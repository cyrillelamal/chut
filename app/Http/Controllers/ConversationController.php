<?php

namespace App\Http\Controllers;

use App\Dtos\StartConversationDto;
use App\Http\Requests\StoreConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\UseCases\Conversation\StartConversation;
use Illuminate\Http\Request;
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
        $dto->users[] = auth()->id();
        $dto->private = false;

        $conversation = ($this->startConversation)($dto);

        return new ConversationResource($conversation);
    }

    public function show(Conversation $conversation)
    {
        //
    }

    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    public function destroy(Conversation $conversation)
    {
        //
    }
}