<?php

namespace App\Jobs;

use App\Events\ConversationStarted;
use App\Models\Conversation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyAboutNewConversation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Conversation $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function handle()
    {
        Log::debug('Job started', ['job' => $this]);

        ConversationStarted::dispatch($this->conversation);

        Log::debug('Job done', ['job' => $this]);
    }
}
