<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipationSeeder extends Seeder
{
    public function run()
    {
        $this->loadPrivateConversations();
        $this->loadPublicConversations();
    }

    protected function loadPrivateConversations(): void
    {
        User::all()->crossJoin(User::all())->each(function (array $pair) {
            /** @var User $initiator */
            /** @var User $interlocutor */
            [$initiator, $interlocutor] = $pair;

            if ($initiator->is($interlocutor)) return;

            $conversation = Conversation::factory()->create([
                'private' => true,
                'title' => null,
            ]);

            Participation::factory()->create([
                'conversation_id' => $conversation,
                'user_id' => $initiator,
                'visible_title' => $interlocutor->name,
            ]);
            Participation::factory()->create([
                'conversation_id' => $conversation,
                'user_id' => $interlocutor,
                'visible_title' => $initiator->name,
            ]);
        });
    }

    protected function loadPublicConversations(): void
    {
        Conversation::all()->where('private', false)->each(function (Conversation $conversation) {
            User::all()->random(rand(2, 5))->each(function (User $user) use ($conversation) {
                Participation::factory()->create([
                    'conversation_id' => $conversation,
                    'user_id' => $user,
                ]);
            });
        });
    }
}
