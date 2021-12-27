<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserSearch\Exception\CannotSearchForUsersException;
use App\Services\UserSearch\SearchParameters;
use App\Services\UserSearch\UserSearchInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    private UserSearchInterface $userSearch;

    public function __construct(
        UserSearchInterface $userSearch,
    )
    {
        $this->userSearch = $userSearch;
    }

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
     *         description="List of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserResource")),
     *     )
     * )
     * @throws CannotSearchForUsersException
     */
    public function find(FindUserRequest $request): AnonymousResourceCollection
    {
        $result = $this->userSearch->search($request->q, new SearchParameters(
            ['name', 'email'],
            ['name', 'email'],
            ['email:!=' . $request->user()->email],
            (int)$request->get('page', 1)
        ));

        return UserResource::collection($result->toPaginator());
    }
}
