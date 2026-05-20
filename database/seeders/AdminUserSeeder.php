<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Database\Seeders\Concerns\ProvisionsUserTeam;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    use ProvisionsUserTeam;

    public function run(): void
    {
        $city = City::query()->where('name', 'São Paulo')->firstOrFail();

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@cocacola.com'],
            [
                'name' => 'Administrador',
                'cpf' => '52998224725',
                'city_id' => $city->id,
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );

        $this->provisionTeamFor($admin);
    }
}
