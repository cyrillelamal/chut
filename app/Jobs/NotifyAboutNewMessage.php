<?php

namespace App\Jobs;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyAboutNewMessage implements ShouldQueue
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

        MessageSent::dispatch($this->message);

        Log::debug('Job done', ['job' => $this]);
    }
}
