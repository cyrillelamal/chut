<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\NewAccessToken;
use LogicException;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="token", type="string", description="This token is used to made authenticated API requests"),
 * )
 */
class NewAccessTokenResource extends JsonResource
{
    /**
     * {@inheritDoc}
     */
    public function toArray($request): array
    {
        $token = $this->resource;

        if ($token instanceof NewAccessToken) {
            return [
                'token' => $token->plainTextToken,
            ];
        }

        Log::error('Invalid resource instance', ['resource' => $token]);
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
