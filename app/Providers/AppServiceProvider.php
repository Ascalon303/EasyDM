<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Admin gate
        Gate::define('admin', fn($user) => $user->isAdmin());

        // Campaign policy: owner only
        Gate::define('view',   fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());
        Gate::define('update', fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());
        Gate::define('delete', fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());
    }
}
