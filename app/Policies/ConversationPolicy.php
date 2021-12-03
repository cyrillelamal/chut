<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\Participation;
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

    public function update(?User $user, Conversation $conversation): bool
    {
        if (null === $user) {
            return false;
        }

        if ($conversation->relationLoaded('participations')) {
            return $conversation->participations->contains(
                fn(Participation $participation) => $participation->user_id === $user->id
            );
        }

        return Participation::query()
            ->where('user_id', $user->id)
            ->where('conversation_id', $conversation->id)
            ->exists();
    }
}
