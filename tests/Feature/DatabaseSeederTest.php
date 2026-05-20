<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_default_users(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', [
            'email' => 'admin@cocacola.com',
            'is_admin' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@cocacola.com',
            'is_admin' => false,
        ]);

        $this->assertGreaterThanOrEqual(22, User::query()->count());
    }
}
