<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\User;
use Database\Seeders\Concerns\ProvisionsUserTeam;
use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    use ProvisionsUserTeam;

    public function run(): void
    {
        $city = City::query()->where('name', 'Rio de Janeiro')->firstOrFail();

        $user = User::query()->updateOrCreate(
            ['email' => 'user@cocacola.com'],
            [
                'name' => 'Usuário Teste',
                'cpf' => '39053344705',
                'city_id' => $city->id,
                'password' => 'password',
                'is_admin' => false,
                'email_verified_at' => now(),
            ],
        );

        $this->provisionTeamFor($user);
    }
}
