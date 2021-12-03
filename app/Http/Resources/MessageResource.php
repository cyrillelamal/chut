<?php

namespace App\Http\Resources;

use App\Models\Message;
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
 *     @OA\Property(property="body", type="string", description="Message content"),
 *     @OA\Property(property="author", type="object", @OA\Schema(ref="#/components/schemas/MessageAuthorResource")),
 * )
 */
class MessageResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        $resource = $this->resource;

        if ($resource instanceof Message) {
            $message = clone $resource;

            $data = [
                'id' => $message->id,
                'created_at' => $message->created_at,
                'body' => $message->body,
            ];

            if ($message->relationLoaded('author')) {
                $data['author'] = new MessageAuthorResource($message->author);
            }

            return $data;
        }

        Log::error('Invalid resource instance', ['resource' => $resource]);
        throw new LogicException('Invalid resource instance');
    }
}
