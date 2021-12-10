<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Channel[]
     */
    public function broadcastOn(): array
    {
        $ids = DB::table('users')
            ->join('participations', 'participations.user_id', '=', 'users.id')
            ->join('conversations', 'conversations.id', '=', 'participations.conversation_id')
            ->where('conversations.id', $this->message->conversation_id)
            ->where('participations.user_id', '<>', $this->message->author_id)
            ->pluck('users.id');

        return array_map(
            fn(int $id) => new PrivateChannel("users.$id"),
            $ids->toArray()
        );
    }

    #[Pure] public function broadcastWith(): array
    {
        return [
            'data' => new MessageResource($this->message),
        ];
    }
}
