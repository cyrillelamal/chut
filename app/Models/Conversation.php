<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

/**
 * @property-read int|null $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $title
 * @property boolean $private
 * @property Collection|Participation[] $participations
 */
class Conversation extends Model
{
    use HasFactory;

    protected $attributes = [
        'title' => '',
        'private' => true,
    ];

    protected $casts = [
        'private' => 'bool',
    ];

    protected $fillable = [
        'title',
        'private',
    ];

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Create a new private conversation.
     * Private conversation has exactly two users, and it is unique.
     */
    public static function between(User $initiator, User $interlocutor): static
    {
        return DB::transaction(function () use ($initiator, $interlocutor) {
            $conversation = new self(['private' => true]);
            $conversation->save();

            $initiator->participateIn($conversation)->save();
            $interlocutor->participateIn($conversation)->save();

            return $conversation;
        });
    }

    /**
     * Create a new public conversation.
     * Public conversation has at least one user.
     *
     * @param iterable $users participants
     * @param array $attributes model attributes
     */
    public static function among(iterable $users, array $attributes = []): static
    {
        return DB::transaction(function () use ($users, $attributes) {
            if (empty([...$users])) {
                abort(422);
            }

            $conversation = new self($attributes);
            $conversation->private = false;
            $conversation->save();

            collect($users)->each(function (User $user) use ($conversation) {
                $user->participateIn($conversation)->save();
            });

            return $conversation;
        });
    }

    protected static function booted()
    {
        static::creating(function (Conversation $conversation) {
            $conversation->private = $conversation->private && $conversation->canBePrivate();

            $conversation->title = $conversation->canHaveTitle()
                ? Str::substr($conversation->getTitle(), 0, 255)
                : null;
        });
    }

    /**
     * Check if this conversation can be private.
     * This method represents the possibility and not the actual state.
     */
    #[Pure] public function canBePrivate(): bool
    {
        return $this->participations->count() <= 2;
    }

    /**
     * Check if this conversation may have a custom title.
     */
    #[Pure] public function canHaveTitle(): bool
    {
        return !$this->private;
    }

    /**
     * Get the title provided by the user or generate a new one dynamically.
     */
    public function getTitle(): string
    {
        return $this->title ?? $this->participations
                ->map(fn(Participation $participation) => $participation->user)
                ->map(fn(User $user) => $user->name)
                ->join(', ');
    }
}
