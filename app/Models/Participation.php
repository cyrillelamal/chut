<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property-read int|null $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $visible_title
 * @property Conversation|null $conversation
 * @property User|null $user
 * @property Collection|Message[] $messages
 * @property Message|null $last_available_message
 * @property int|null $conversation_id
 */
class Participation extends Model
{
    use HasFactory;

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'author_id');
    }

    public function last_available_message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'last_available_message_id');
    }
}
