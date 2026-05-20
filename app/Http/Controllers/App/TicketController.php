<?php

namespace App\Http\Controllers\App;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\App\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(): Response
    {
        $user = request()->user();

        return Inertia::render('app/tickets/Index', [
            'totalTickets' => $user->tickets()->count(),
            'statusCounts' => TicketStatus::casesAsStatusCounts(
                $user->tickets()
                    ->selectRaw('status, count(*) as total')
                    ->groupBy('status')
                    ->pluck('total', 'status')
                    ->all(),
            ),
            'tickets' => $user->tickets()
                ->with(['city.state'])
                ->latest()
                ->paginate(10)
                ->through(fn (Ticket $ticket): array => $this->ticketPayload($ticket)),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('app/tickets/Create', [
            'city' => request()->user()->city?->load('state'),
        ]);
    }

    public function store(StoreTicketRequest $request): RedirectResponse
    {
        $user = $request->user();

        $path = $request->file('proof_image')->store(
            "tickets/proofs/{$user->id}",
            'public',
        );

        $user->tickets()->create([
            'city_id' => $user->city_id,
            'serial_number' => $request->validated('serial_number'),
            'proof_image_path' => $path,
            'status' => TicketStatus::Pending,
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket registrado para análise.',
        ]);

        return to_route('app.tickets.index');
    }

    /**
     * @return array<string, mixed>
     */
    private function ticketPayload(Ticket $ticket): array
    {
        return [
            'id' => $ticket->id,
            'serial_number' => $ticket->serial_number,
            'status' => $ticket->status->value,
            'status_label' => $ticket->status->label(),
            'rejection_reason' => $ticket->rejection_reason,
            'proof_image_url' => Storage::disk('public')->url($ticket->proof_image_path),
            'city' => [
                'name' => $ticket->city->name,
                'state' => $ticket->city->state->abbreviation,
            ],
            'created_at' => $ticket->created_at?->format('d/m/Y H:i'),
        ];
    }
}
