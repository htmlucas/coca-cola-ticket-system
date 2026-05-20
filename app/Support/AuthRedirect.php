<?php

namespace App\Support;

use App\Models\User;

class AuthRedirect
{
    public static function homeFor(?User $user): string
    {
        if ($user?->isAdmin()) {
            return route('admin.dashboard', absolute: false);
        }

        return route('app.dashboard', absolute: false);
    }
}
