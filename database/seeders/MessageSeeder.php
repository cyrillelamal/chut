<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Participation;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run()
    {
        Conversation::all()->each(function (Conversation $conversation) {
            $participations = $conversation->participations()->get();

            for ($i = 0; $i < rand(2, 40); $i++) {
                /** @var Participation $author */
                $author = $participations->random();

                /** @var Message $message */
                $message = Message::factory()->create([
                    'author_id' => $author->user_id,
                    'conversation_id' => $author->conversation_id,
                ]);

                $conversation->participations()->update([
                    'last_available_message_id' => $message->id,
                ]);
            }
        });
    }
}
