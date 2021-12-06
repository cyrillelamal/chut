<?php

namespace App\Models;

use App\Jobs\NotifyAboutNewMessage;
use App\Jobs\UpdateParticipations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

/**
 * @property-read int|null $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $body
 * @property User|null $author
 * @property Conversation|null $conversation
 * @property int|null $author_id
 * @property int|null $conversation_id
 */
class Message extends Model
{
    use HasFactory;

    protected $attributes = [
        'body' => '',
    ];

    protected $fillable = [
        'body',
        'author_id',
        'conversation_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    protected static function booted()
    {
        static::saved(function (Message $message) {
            Log::debug('Dispatching job', ['job' => UpdateParticipations::class, 'arguments' => [$message]]);
            UpdateParticipations::dispatch($message);
        });

        static::created(function (Message $message) {
            Log::debug('Dispatching job', ['job' => NotifyAboutNewMessage::class, 'arguments' => [$message]]);
            NotifyAboutNewMessage::dispatch($message);
        });
    }
}
