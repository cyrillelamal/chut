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
 *     @OA\Property(property="last_available_message", type="object", @OA\Schema(ref="#/components/schemas/Message")),
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
            $participation = parent::toArray($request);

            $participation['conversation'] = route('conversations.show', ['conversation' => $resource->conversation_id]);

            return $participation;
        }

        Log::error('Unexpected resource instance', ['resource' => $resource]);
        throw new LogicException('Unexpected resource instance');
    }
}
