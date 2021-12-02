<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     description="Search for users",
     *     @OA\Parameter(
     *         in="query",
     *         name="q",
     *         @OA\Schema(ref="#/components/schemas/FindUserRequest"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserResource")),
     *         description="Ok",
     *     )
     * )
     */
    public function find(FindUserRequest $request): AnonymousResourceCollection
    {
        $users = User::query()
            ->where('name', 'LIKE', "%$request->q%")
            ->orWhere('email', 'LIKE', "%$request->q%")
            ->where('id', '<>', auth()->id())
            ->paginate();

        return UserResource::collection($users);
    }
}
