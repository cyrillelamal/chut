<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateParticipations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        Log::debug('Job started', ['job' => $this]);

        DB::table('participations')
            ->where('conversation_id', $this->message->conversation_id)
            ->update([
                'last_available_message_id' => $this->message->id
            ]);

        Log::debug('Job done', ['job' => $this]);
    }
}
