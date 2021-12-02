<?php

namespace App\Http\Resources;

use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use LogicException;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="private", type="boolean", description="Indicates wheter this conversation is a private dialogue"),
 *     @OA\Property(property="participations", type="array", @OA\Items(ref="#/components/schemas/ParticipationResource")),
 * )
 */
class ConversationResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        $resource = $this->resource;

        if ($resource instanceof Conversation) {
            $conversation = clone $resource;

            $data = [
                'id' => $conversation->id,
                'title' => $conversation->title ?? '',
                'created_at' => $conversation->created_at,
                'updated_at' => $conversation->updated_at,
                'private' => $conversation->private,
            ];

            if ($conversation->relationLoaded('participations')) {
                $data['participations'] = ParticipationResource::collection($conversation->participations);
            }

            return $data;
        }

        Log::error('Invalid resource instance', ['resource' => $resource]);
        throw new LogicException('Invalid resource instance');
    }

    /**
     * {@inheritDoc}
     */
    public function toResponse($request): JsonResponse
    {
        return parent::toResponse($request)->setStatusCode(201);
    }
}
