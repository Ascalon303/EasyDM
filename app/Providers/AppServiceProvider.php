<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    Gate::define('admin', fn($user) => $user->isAdmin());

    // Gate generik untuk Campaign, Encounter, dll (pakai user_id)
    Gate::define('view',   fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());
    Gate::define('update', fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());
    Gate::define('delete', fn($user, $model) => $user->id === $model->user_id || $user->isAdmin());

    // Policy khusus CreatorContent (pakai creator_id) — ini override Gate di atas
    Gate::policy(CreatorContent::class, CreatorContentPolicy::class);
    }
}
