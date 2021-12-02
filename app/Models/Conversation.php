<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
            $conversation->private = $conversation->private && $conversation->participations->count() <= 2;

            $conversation->title = $conversation->private ? null : Str::substr(
                $conversation->title ?? $conversation->participations
                    ->map(fn(Participation $participation) => $participation->user)
                    ->map(fn(User $user) => $user->name)
                    ->join(', '),
                0,
                255
            );
        });
    }
}
