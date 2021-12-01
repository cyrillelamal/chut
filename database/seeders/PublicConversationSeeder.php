<?php

namespace Database\Seeders;

use App\Models\Conversation;
use Illuminate\Database\Seeder;

class PublicConversationSeeder extends Seeder
{
    public function run()
    {
        Conversation::factory()->count(30)->create([
            'private' => false,
        ]);
    }
}
