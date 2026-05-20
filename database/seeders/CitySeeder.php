<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * @var array<string, array<int, string>>
     */
    private array $cities = [
        'BA' => ['Salvador', 'Feira de Santana'],
        'DF' => ['Brasília'],
        'MG' => ['Belo Horizonte', 'Uberlândia'],
        'PE' => ['Recife'],
        'PR' => ['Curitiba'],
        'RJ' => ['Rio de Janeiro', 'Niterói'],
        'RS' => ['Porto Alegre'],
        'SC' => ['Florianópolis'],
        'SP' => ['São Paulo', 'Campinas', 'Santos'],
    ];

    public function run(): void
    {
        foreach ($this->cities as $abbreviation => $cityNames) {
            $state = State::query()->where('abbreviation', $abbreviation)->firstOrFail();

            foreach ($cityNames as $name) {
                City::query()->updateOrCreate(
                    [
                        'state_id' => $state->id,
                        'name' => $name,
                    ],
                );
            }
        }
    }
}
