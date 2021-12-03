<?php

namespace App\Providers;

use App\Models\Conversation;
use App\Models\Participation;
use App\Policies\ConversationPolicy;
use App\Policies\ParticipationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Participation::class => ParticipationPolicy::class,
        Conversation::class => ConversationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('post-to', [ConversationPolicy::class, 'post']);
    }
}
