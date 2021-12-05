<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
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
     *     @OA\Parameter(name="id", in="path", description="Conversation id", required=true, @OA\Schema(type="integer")),
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
            ->with('author')
            ->where('conversation_id', $conversation->id)
            ->orderByDesc('messages.created_at')
            ->paginate();

        return MessageResource::collection($messages);
    }

    /**
     * @OA\Post(
     *     path="/api/conversations{id}/messages",
     *     description="Create message",
     *     @OA\Parameter(name="id", in="path", @OA\Schema(type="integer"), required=true, description="Conversation id"),
     *     @OA\Response(
     *         response="201",
     *         description="Created message",
     *         @OA\JsonContent(ref="#/components/schemas/MessageResource"),
     *     )
     * )
     */
    public function store(StoreMessageRequest $request, Conversation $conversation): MessageResource
    {
        /** @var Message $message */
        $message = Message::factory()->make($request->validated());

        $message->author()->associate($request->user());
        $message->conversation()->associate($conversation);

        $message->save();

        return new MessageResource($message);
    }
}
