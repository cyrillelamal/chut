<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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
