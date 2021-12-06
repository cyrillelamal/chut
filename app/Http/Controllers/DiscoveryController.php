<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

class DiscoveryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/discovery",
     *     @OA\Response(
     *         response="200",
     *         description="Channels the user can subscribe to",
     *         @OA\JsonContent(type="array", @OA\Items(type="string", description="Channel")),
     *     ),
     * )
     */
    public function __invoke(): array
    {
        return [
            'data' => [
                'users.' . auth()->id(),
            ],
        ];
    }
}
