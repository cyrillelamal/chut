<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }
}
