<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\User;
use OpenApi\Annotations as OA;

class ConversationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/conversations",
     *     description="Create public conversation",
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/StoreConversationRequest")),
     *     @OA\Response(
     *         response="201",
     *         description="Conversation created",
     *         @OA\JsonContent(ref="#/components/schemas/ConversationResource"),
     *     ),
     *     @OA\Response(response="422", description="Unprocessable entity"),
     * )
     */
    public function store(StoreConversationRequest $request): ConversationResource
    {
        $conversation = Conversation::among(
            User::query()->whereIn('id', [...$request->users, $request->user()->id])->get(),
            ['title' => $request->title]
        );

        return new ConversationResource($conversation);
    }

    /**
     * @OA\Patch(
     *     path="/api/conversations/{id}",
     *     description="Update public conversation",
     *     @OA\Parameter(name="id", in="path", description="Conversation id", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/UpdateConversationRequest")),
     *     @OA\Response(
     *         response="200",
     *         description="Conversation updated",
     *         @OA\JsonContent(ref="#/components/schemas/ConversationResource"),
     * )
     * )
     */
    public function update(UpdateConversationRequest $request, Conversation $conversation): ConversationResource
    {
        $conversation->update($request->validated());

        return new ConversationResource($conversation);
    }
}
