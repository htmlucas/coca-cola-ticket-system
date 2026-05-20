<?php

namespace Tests\Feature\Tickets;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTicketManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_tickets(): void
    {
        $admin = User::factory()->admin()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.tickets.index'));

        $response
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('admin/tickets/Index')
                ->has('tickets.data', 1)
                ->where('tickets.data.0.id', $ticket->id));
    }

    public function test_admin_can_approve_and_reject_tickets(): void
    {
        $admin = User::factory()->admin()->create();
        $ticket = Ticket::factory()->create();

        $this->actingAs($admin)->patch(route('admin.tickets.approve', $ticket))->assertRedirect();

        $this->assertSame(TicketStatus::Approved, $ticket->fresh()->status);

        $this->actingAs($admin)->patch(route('admin.tickets.reject', $ticket), [
            'rejection_reason' => 'Imagem sem visibilidade.',
        ])->assertRedirect();

        $ticket->refresh();

        $this->assertSame(TicketStatus::Rejected, $ticket->status);
        $this->assertSame('Imagem sem visibilidade.', $ticket->rejection_reason);
    }

    public function test_admin_can_update_ticket_and_replace_proof_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $ticket = Ticket::factory()->create([
            'proof_image_path' => 'tickets/proofs/old.jpg',
        ]);

        Storage::disk('public')->put('tickets/proofs/old.jpg', 'old');

        $response = $this->actingAs($admin)->post(route('admin.tickets.update', $ticket), [
            '_method' => 'PATCH',
            'serial_number' => 'new-serial',
            'city_id' => $ticket->city_id,
            'status' => TicketStatus::Approved->value,
            'proof_image' => UploadedFile::fake()->image('new.jpg'),
        ]);

        $response->assertRedirect(route('admin.tickets.index'));

        $ticket->refresh();

        $this->assertSame('NEW-SERIAL', $ticket->serial_number);
        $this->assertSame(TicketStatus::Approved, $ticket->status);
        Storage::disk('public')->assertMissing('tickets/proofs/old.jpg');
        Storage::disk('public')->assertExists($ticket->proof_image_path);
    }

    public function test_non_admin_cannot_manage_admin_tickets(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $this->actingAs($user)
            ->patch(route('admin.tickets.approve', $ticket))
            ->assertForbidden();
    }
}
