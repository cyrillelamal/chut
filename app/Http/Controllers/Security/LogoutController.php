<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use function response;

class LogoutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     description="Invalidate current user's session",
     *     @OA\Response(response="200", description="User logged out"),
     * )
     */
    public function __invoke(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response(null, 200);
    }
}
