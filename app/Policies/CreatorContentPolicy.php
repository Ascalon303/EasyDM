<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CreatorContent;

class CreatorContentPolicy
{
    public function update(User $user, CreatorContent $content): bool
    {
        return $user->id === $content->creator_id || $user->isAdmin();
    }

    public function delete(User $user, CreatorContent $content): bool
    {
        return $user->id === $content->creator_id || $user->isAdmin();
    }
}