<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function create(?User $user): bool
    {
        // More complex validation is performed while creation and not before.
        return !is_null($user);
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

    /**
     * @param User|null $user
     * @param User[]|int[] $invitee Invited users or their ids.
     * @return bool
     */
    public static function initiate(?User $user, ?array $invitee = []): bool
    {
        return $user?->isNotBannedByAny(...$invitee ?? []) ?? false;
    }
}
