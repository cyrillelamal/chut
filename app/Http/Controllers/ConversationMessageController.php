<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

class ConversationMessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/conversations{id}/messages",
     *     description="List conversation messages",
     *     @OA\Parameter(name="id", in="path", @OA\Schema(type="integer"), required=true, description="Conversation id"),
     *     @OA\Response(
     *         response="200",
     *         description="Paginated conversation messages",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MessageResource")),
     *     ),
     * )
     */
    public function index(Conversation $conversation): AnonymousResourceCollection
    {
        Gate::authorize('read', $conversation);

        $messages = Message::query()
            ->with(['author'])
            ->where('conversation_id', $conversation->id)
            ->orderByDesc('messages.created_at')
            ->paginate();

        return MessageResource::collection($messages);
    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
