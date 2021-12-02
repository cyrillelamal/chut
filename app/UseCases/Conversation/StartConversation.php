<?php

namespace App\UseCases\Conversation;

use App\Dtos\StartConversationDto;
use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StartConversation
{
    /**
     * Create a new conversation.
     *
     * @param StartConversationDto $dto
     * @return Conversation
     */
    public function __invoke(StartConversationDto $dto): Conversation
    {
        $conversation = new Conversation($dto->only('title', 'private')->toArray());

        DB::transaction(function () use ($conversation, $dto) {
            $participations = User::query()
                ->whereIn('id', $dto->users)
                ->get()
                ->map(function (User $user) use ($conversation) {
                    $participation = new Participation();
                    $participation->user()->associate($user);
                    $participation->conversation()->associate($conversation);
                    return $participation;
                });

            $conversation->setRelation('participations', $participations);

            if ($conversation->participations->isEmpty()) {
                abort(422);
            }

            $conversation->save();
            $conversation->participations()->saveMany($participations);
        });

        return $conversation;
    }
}
