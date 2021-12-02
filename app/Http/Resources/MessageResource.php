<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="body", type="string", description="Message content"),
 * )
 */
class MessageResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
