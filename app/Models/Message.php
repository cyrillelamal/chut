<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @property-read int|null $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $body
 * @property Participation|null $author
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="body", type="string", description="Message content"),
 * )
 */
class Message extends Model
{
    use HasFactory;

    protected $attributes = [
        'body' => '',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Participation::class, 'author_id');
    }
}
