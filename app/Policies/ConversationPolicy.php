<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Conversation $conversation)
    {
        //
    }

    public function create(): bool
    {
        return Auth::check();
    }

    public function update(User $user, Conversation $conversation)
    {
        //
    }

    public function delete(User $user, Conversation $conversation)
    {
        //
    }
}
