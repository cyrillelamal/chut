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
            $participations = Participation::query()->where('conversation_id', $conversation->id)->get();

            for ($i = 0; $i < rand(1, 30); $i++) {
                /** @var Participation $author */
                $author = $participations->random();

                /** @var Message $message */
                $message = Message::factory()->create([
                    'author_id' => $author,
                ]);

                $author->conversation->participations()->update([
                    'last_available_message_id' => $message->id,
                ]);
            }
        });
    }
}
