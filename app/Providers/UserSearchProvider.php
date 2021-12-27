<?php

namespace App\Providers;

use App\Services\UserSearch\TypesenseUserSearch;
use App\Services\UserSearch\UserSearchInterface;
use Illuminate\Support\ServiceProvider;

class UserSearchProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(UserSearchInterface::class, function () {
            return $this->app->get(TypesenseUserSearch::class);
        });
    }
}
