<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class LogoutController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     description="Invalidate current user's session",
     *     @OA\Response(response="201", description="OK")
     * )
     */
    public function __invoke(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response(null, 201);
    }
}
