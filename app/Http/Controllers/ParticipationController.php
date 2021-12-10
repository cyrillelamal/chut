<?php

namespace App\Http\Controllers;

use App\Http\Resources\ParticipationResource;
use App\Models\Participation;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

class ParticipationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Participation::class);
    }

    /**
     * @OA\Get(
     *     path="/api/participations",
     *     description="Get latest user's participations",
     *     @OA\Response(
     *         response="200",
     *         description="Ok",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ParticipationResource")),
     *     ),
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $participations = Participation::query()
            ->where('user_id', auth()->id())
            ->with('last_available_message')
            ->orderByDesc('participations.updated_at')
            ->paginate();

        return ParticipationResource::collection($participations);
    }
}
