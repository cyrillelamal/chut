<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read int|null $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property Collection|Participation[] $participations
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Find whether this user is blocked by at least one of the provided users.
     * @param User|int ...$others Users or their ids.
     */
    public function isBannedByAny(User|int ...$others): bool
    {
        collect($others)->map(
            fn(User|int $user) => $user instanceof User ? $user->id : $user
        ); // TODO: Check if this user is in ban lists.

        return false;
    }

    /**
     * Find whether this user is not blocked by any of the other users.
     * @param User|int ...$others Users or their ids.
     */
    public function isNotBannedByAny(User|int ...$others): bool
    {
        return !$this->isBannedByAny(...$others);
    }

    /**
     * Find whether this user participates in the provided conversation.
     */
    public function isParticipantOf(Conversation $conversation): bool
    {
        return $this->participations()
            ->where('conversation_id', $conversation->id)
            ->exists();
    }

    /**
     * Get or create the private conversation between this user ant the provided one.
     * @param User $other The interlocutor.
     * @return Conversation The private conversation with the provided interlocutor.
     * There can only be one conversation.
     */
    public function getPrivateConversationWith(User $other): Conversation
    {
        $participation = fn(User $user) => fn(Builder $query) => $query
            ->select('conversation_id')
            ->from('participations')
            ->where('user_id', $user->id);

        /** @var Conversation|null $conversation */
        $conversation = Conversation::query()
            ->whereIn('id', $participation($this))
            ->whereIn('id', $participation($other))
            ->where('private', true)->first();

        return $conversation ?? Conversation::between($this, $other);
    }

    /**
     * Inscribe this user in the provided conversation.
     * @param Conversation $conversation
     * @param array $attributes Initial participation attributes.
     * @return Participation Not persisted participation representation.
     */
    public function participateIn(Conversation $conversation, array $attributes = []): Participation
    {
        $participation = new Participation($attributes);
        $participation->conversation()->associate($conversation);
        $participation->user()->associate($this);
        return $participation;
    }
}
