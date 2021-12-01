<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\NewAccessTokenResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/LoginRequest")),
     *     @OA\Response(response="201", @OA\JsonContent(ref="#/components/schemas/NewAccessTokenResource"), description="OK"),
     *     @OA\Response(response="422", description="Unprocessable entity"),
     * )
     */
    public function __invoke(LoginRequest $request): NewAccessTokenResource
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::guard('web')->login($user, true);

            $token = $user->createToken($request->device_name);

            return new NewAccessTokenResource($token);
        }

        throw new HttpException(401, trans('auth.failed'));
    }
}
