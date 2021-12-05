<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Database\Seeder;

class PublicParticipationSeeder extends Seeder
{
    public function run()
    {
        Conversation::factory()
            ->count(11)
            ->create(['private' => false])
            ->each(function (Conversation $conversation) {
                User::all()->random(rand(2, 5))->each(function (User $user) use ($conversation) {
                    Participation::factory()->create([
                        'conversation_id' => $conversation,
                        'user_id' => $user,
                        'visible_title' => $conversation->title,
                    ]);
                });
            });
    }
}
