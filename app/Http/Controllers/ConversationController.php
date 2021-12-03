<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\StartConversationDto;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Requests\UpdateConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\UseCases\Conversation\StartConversation;
use OpenApi\Annotations as OA;
use Throwable;

class ConversationController extends Controller
{
    private StartConversation $startConversation;

    public function __construct(
        StartConversation $startConversation,
    )
    {
        $this->authorizeResource(Conversation::class);

        $this->startConversation = $startConversation;
    }

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
     * @throws Throwable -> 500
     */
    public function store(StoreConversationRequest $request): ConversationResource
    {
        $dto = new StartConversationDto($request->validated());
        $dto->user_ids[] = auth()->id();
        $dto->private = false;

        $conversation = ($this->startConversation)($dto);

        return new ConversationResource($conversation);
    }

    /**
     * @OA\Patch(
     *     path="/api/conversations/{id}",
     *     description="Update conversation",
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
