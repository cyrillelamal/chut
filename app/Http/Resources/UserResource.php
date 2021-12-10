<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="name", type="string", description="User's name"),
 * )
 */
class UserResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
