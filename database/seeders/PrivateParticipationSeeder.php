<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrivateParticipationSeeder extends Seeder
{
    public function run()
    {
        User::all()
            ->crossJoin(User::all())
            ->unique(function (array $pair) {
                usort($pair, fn(User $a, User $b) => $a->id <=> $b->id);
                return "{$pair[0]->id}:{$pair[1]->id}";
            })->each(function (array $pair) {
                /** @var User $john */
                /** @var User $kathy */
                [$john, $kathy] = $pair;

                if ($john->is($kathy)) return;

                /** @var Conversation $conversation */
                $conversation = Conversation::factory()->create(['private' => true]);

                Participation::factory()->create([
                    'conversation_id' => $conversation,
                    'user_id' => $john,
                    'visible_title' => $kathy->name,
                ]);
                Participation::factory()->create([
                    'conversation_id' => $conversation,
                    'user_id' => $kathy,
                    'visible_title' => $john->name,
                ]);

                $conversation->participations()->each(function (Participation $participation) {
                    $participation->visible_title = $participation->getTitle();
                    $participation->save();
                });
            });
    }
}
