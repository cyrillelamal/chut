<?php

namespace App\Http\Resources;

use App\Models\Participation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use LogicException;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="visible_title", type="string", description="Conversation title"),
 *     @OA\Property(property="conversation", type="string", format="uri", description="Conversation URI"),
 *     @OA\Property(property="last_available_message", type="object", @OA\Schema(ref="#/components/schemas/MessageResource")),
 * )
 */
class ParticipationResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        $resource = $this->resource;

        if ($resource instanceof Participation) {
            $participation = clone $resource;

            return [
                'id' => $participation->id,
                'created_at' => $participation->created_at,
                'updated_at' => $participation->updated_at->diffForHumans(),
                'visible_title' => $participation->visible_title,
                'conversation_id' => $participation->conversation_id,
                'user_id' => $participation->user_id,
                'last_available_message' => new MessageResource($participation->last_available_message),
            ];
        }

        Log::error('Invalid resource instance', ['resource' => $resource]);
        throw new LogicException('Invalid resource instance');
    }
}
