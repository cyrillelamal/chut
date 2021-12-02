<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ParticipationPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return Auth::check();
    }
}
