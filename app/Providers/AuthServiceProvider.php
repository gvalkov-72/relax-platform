<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        Gate::define('manage users', fn($user) => $user->can('manage users'));
        Gate::define('manage roles', fn($user) => $user->can('manage roles'));
        Gate::define('manage permissions', fn($user) => $user->can('manage permissions'));
        Gate::define('manage pages', fn($user) => $user->can('manage pages'));
        Gate::define('manage sections', fn($user) => $user->can('manage sections'));
        Gate::define('manage languages', fn($user) => $user->can('manage languages'));
        Gate::define('manage meditations', fn($user) => $user->can('manage meditations'));
        Gate::define('manage audio', fn($user) => $user->can('manage audio'));
        Gate::define('manage brainwaves', fn($user) => $user->can('manage brainwaves'));
        Gate::define('manage contents', fn($user) => $user->can('manage contents'));
        Gate::define('manage tags', fn($user) => $user->can('manage tags'));
        Gate::define('manage ai', fn($user) => $user->can('manage ai'));
    }
}