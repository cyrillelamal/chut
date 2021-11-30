<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\NewAccessToken;
use LogicException;

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

        Log::error('Unexpected resource instance', ['resource' => $token]);
        throw new LogicException('Unexpected resource instance');
    }
}
