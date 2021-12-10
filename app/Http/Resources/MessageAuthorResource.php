<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use LogicException;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string", description="User's name"),
 * )
 */
class MessageAuthorResource extends JsonResource
{
    /**
     * @param Request $request
     */
    public function toArray($request): array
    {
        $resource = $this->resource;

        if ($resource instanceof User) {
            $user = $resource;

            return [
                'id' => $user->id,
                'name' => $user->name,
            ];
        }

        Log::error('Invalid resource instance', ['resource' => $resource]);
        throw new LogicException('Invalid resource instance');
    }
}
