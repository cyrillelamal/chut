<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int|null $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $body
 * @property User|null $author
 * @property Conversation|null $conversation
 */
class Message extends Model
{
    use HasFactory;

    protected $attributes = [
        'body' => '',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
