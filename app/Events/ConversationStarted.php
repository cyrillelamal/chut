<?php

namespace App\Events;

use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

class ConversationStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Conversation $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * {@inheritDoc}
     */
    public function broadcastOn(): array
    {
        $ids = DB::table('users')
            ->join('participations', 'participations.user_id', '=', 'users.id')
            ->join('conversations', 'conversations.id', '=', 'participations.conversation_id')
            ->where('conversations.id', $this->conversation->id)
            ->pluck('users.id');

        return array_map(
            fn(int $id) => new PrivateChannel("users.$id"),
            $ids->toArray()
        );
    }

    #[Pure] public function broadcastWith(): array
    {
        return [
            'data' => new ConversationResource($this->conversation),
        ];
    }
}
