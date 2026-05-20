<?php

namespace Tests\Feature\Auth;

use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function test_new_users_can_register(): void
    {
        $city = City::factory()->create();

        $response = $this->post(route('register.store'), [
            'name' => 'Novo Participante',
            'email' => 'novo@cocacola.com',
            'cpf' => '111.444.777-35',
            'city_id' => $city->id,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('app.dashboard'));

        $user = User::query()->where('email', 'novo@cocacola.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('11144477735', $user->cpf);
        $this->assertSame($city->id, $user->city_id);
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($user->teams()->exists());
    }

    public function test_registration_requires_valid_data(): void
    {
        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => '',
            'email' => 'invalid-email',
            'cpf' => '00000000000',
            'city_id' => '',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['name', 'email', 'cpf', 'city_id', 'password']);
        $this->assertGuest();
    }

    public function test_authenticated_users_are_redirected_from_registration(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect(route('app.dashboard'));
    }
}
