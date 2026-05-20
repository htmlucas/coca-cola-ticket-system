<?php

namespace Tests\Feature\Routing;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_routes_are_accessible_to_guests(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('campaign.show'))->assertOk();
        $this->get(route('register'))->assertOk();
    }

    public function test_app_routes_require_authentication(): void
    {
        $this->get(route('app.dashboard'))->assertRedirect(route('login'));
        $this->get(route('app.tickets.index'))->assertRedirect(route('login'));
        $this->get(route('app.tickets.create'))->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_access_app_routes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('app.dashboard'))->assertOk();
        $this->actingAs($user)->get(route('app.tickets.index'))->assertOk();
        $this->actingAs($user)->get(route('app.tickets.create'))->assertOk();
    }

    public function test_admin_routes_require_admin_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_admin_users_can_access_admin_routes(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.tickets.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.cities.index'))->assertOk();
    }

    public function test_guests_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }
}
