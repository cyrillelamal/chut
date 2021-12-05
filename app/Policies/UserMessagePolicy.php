<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use JetBrains\PhpStorm\Pure;

class UserMessagePolicy
{
    use HandlesAuthorization;

    public static function send(?User $sender, User $receiver): bool
    {
        return $sender?->isNotBannedByAny($receiver) ?? false;
    }
}
