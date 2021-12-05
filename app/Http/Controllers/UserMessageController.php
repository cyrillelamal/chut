<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class UserMessageController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/users/{id}/messages",
     *     description="Create private message",
     *     @OA\Parameter(name="id", in="path", @OA\Schema(type="integer"), required=true, description="User id"),
     *     @OA\Response(
     *         response="201",
     *         description="Created message",
     *         @OA\JsonContent(ref="#/components/schemas/MessageResource"),
     *     )
     * )
     */
    public function store(StoreUserMessageRequest $request, User $receiver): MessageResource
    {
        $message = DB::transaction(function () use ($request, $receiver) {
            $conversation = $request->user()->getPrivateConversationWith($receiver);

            $message = new Message($request->validated());
            $message->author()->associate($request->user());
            $message->conversation()->associate($conversation);
            $message->save();

            return $message;
        });

        return new MessageResource($message);
    }
}
