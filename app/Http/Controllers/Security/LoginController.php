<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\NewAccessTokenResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use function trans;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): NewAccessTokenResource
    {
        /** @var User|null $user */
        $user = User::query()->where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken($request->device_name);

            return new NewAccessTokenResource($token);
        }

        throw new HttpException(401, trans('auth.failed'));
    }
}
