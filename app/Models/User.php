<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
     * Check if this user participates in the provided conversation.
     */
    public function isParticipantOf(Conversation $conversation): bool
    {
        return $this->participations()
            ->where('conversation_id', $conversation->id)
            ->exists();
    }
}
