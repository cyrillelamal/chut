<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;
use function response;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/RegisterRequest")),
     *     @OA\Response(response="201", description="Ok"),
     *     @OA\Response(response="422", description="Unprocessable entity"),
     * )
     */
    public function __invoke(RegisterRequest $request): Response
    {
        User::query()->create($request->validated());

        return response(null, 201);
    }
}
