<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\UserSearch\Exception\CannotIndexUserException;
use App\Services\UserSearch\UserSearchInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class IndexUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(
        UserSearchInterface $userSearch,
    )
    {
        Log::debug('Job started', ['job' => $this]);

        try {
            $userSearch->index($this->user);
        } catch (CannotIndexUserException $e) {
            Log::error('Indexation failed', ['model' => $this->user, 'exception' => $e]);
        }

        Log::debug('Job done', ['job' => $this]);
    }
}
