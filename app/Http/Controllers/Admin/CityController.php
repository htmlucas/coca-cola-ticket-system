<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/cities/Index', [
            'states' => State::query()
                ->withCount('cities')
                ->with(['cities' => fn ($query) => $query->withCount(['users', 'tickets'])->orderBy('name')])
                ->orderBy('name')
                ->get()
                ->map(fn (State $state): array => [
                    'id' => $state->id,
                    'name' => $state->name,
                    'abbreviation' => $state->abbreviation,
                    'cities_count' => $state->cities_count,
                    'cities' => $state->cities->map(fn ($city): array => [
                        'id' => $city->id,
                        'name' => $city->name,
                        'users_count' => $city->users_count,
                        'tickets_count' => $city->tickets_count,
                    ])->all(),
                ]),
        ]);
    }
}
