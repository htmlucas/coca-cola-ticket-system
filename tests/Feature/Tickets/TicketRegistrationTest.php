<?php

namespace Tests\Feature\Tickets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TicketRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_register_ticket_with_proof_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('app.tickets.store'), [
            'serial_number' => ' cc-1234-abcd ',
            'proof_image' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response->assertRedirect(route('app.tickets.index'));

        $ticket = Ticket::query()->first();

        $this->assertNotNull($ticket);
        $this->assertSame($user->id, $ticket->user_id);
        $this->assertSame($user->city_id, $ticket->city_id);
        $this->assertSame('CC-1234-ABCD', $ticket->serial_number);
        $this->assertSame(TicketStatus::Pending, $ticket->status);

        Storage::disk('public')->assertExists($ticket->proof_image_path);
    }

    public function test_ticket_serial_number_must_be_unique(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        Ticket::factory()->for($user)->create([
            'city_id' => $user->city_id,
            'serial_number' => 'CC-1234-ABCD',
        ]);

        $response = $this->actingAs($user)->from(route('app.tickets.create'))->post(route('app.tickets.store'), [
            'serial_number' => 'cc-1234-abcd',
            'proof_image' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response
            ->assertRedirect(route('app.tickets.create'))
            ->assertSessionHasErrors('serial_number');
    }

    public function test_proof_image_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from(route('app.tickets.create'))->post(route('app.tickets.store'), [
            'serial_number' => 'CC-1234-ABCD',
        ]);

        $response
            ->assertRedirect(route('app.tickets.create'))
            ->assertSessionHasErrors('proof_image');
    }

    public function test_user_without_city_cannot_register_ticket(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['city_id' => null]);

        $response = $this->actingAs($user)->from(route('app.tickets.create'))->post(route('app.tickets.store'), [
            'serial_number' => 'CC-1234-ABCD',
            'proof_image' => UploadedFile::fake()->image('proof.jpg'),
        ]);

        $response
            ->assertRedirect(route('app.tickets.create'))
            ->assertSessionHasErrors('city_id');
    }
}
