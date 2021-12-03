<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function create(): bool
    {
        return Auth::check();
    }

    public function read(?User $user, Conversation $conversation): bool
    {
        return $user?->isParticipantOf($conversation) ?? false;
    }

    public function update(?User $user, Conversation $conversation): bool
    {
        return $user?->isParticipantOf($conversation) ?? false;
    }

    public static function post(?User $user, Conversation $conversation): bool
    {
        return $user?->isParticipantOf($conversation) ?? false;
    }
}
