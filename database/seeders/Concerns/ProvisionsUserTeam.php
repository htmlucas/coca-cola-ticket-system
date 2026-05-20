<?php

namespace Database\Seeders\Concerns;

use App\Actions\Teams\CreateTeam;
use App\Models\User;

trait ProvisionsUserTeam
{
    protected function provisionTeamFor(User $user): void
    {
        if ($user->teams()->exists()) {
            return;
        }

        app(CreateTeam::class)->handle($user, "{$user->name}'s Team", isPersonal: true);
    }
}
