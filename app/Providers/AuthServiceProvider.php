<?php

namespace App\Providers;

use App\Models\Participation;
use App\Policies\ParticipationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Participation::class => ParticipationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
