<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RejectTicketRequest;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Models\City;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TicketController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'status', 'city_id']);

        $tickets = Ticket::query()
            ->with(['user', 'city.state', 'reviewer'])
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('serial_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search): void {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('cpf', 'like', "%{$search}%");
                        });
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['city_id'] ?? null, fn ($query, string $cityId) => $query->where('city_id', $cityId))
            ->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn (Ticket $ticket): array => $this->ticketPayload($ticket));

        return Inertia::render('admin/tickets/Index', [
            'tickets' => $tickets,
            'filters' => [
                'search' => $filters['search'] ?? '',
                'status' => $filters['status'] ?? '',
                'city_id' => $filters['city_id'] ?? '',
            ],
            'statuses' => $this->statuses(),
            'cities' => $this->citiesForFilters(),
        ]);
    }

    public function edit(Ticket $ticket): Response
    {
        $ticket->load(['user', 'city.state', 'reviewer']);

        return Inertia::render('admin/tickets/Edit', [
            'ticket' => $this->ticketPayload($ticket),
            'statuses' => $this->statuses(),
            'cities' => $this->citiesForFilters(),
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        Gate::authorize('update', $ticket);

        $validated = $request->validated();

        if ($request->hasFile('proof_image')) {
            Storage::disk('public')->delete($ticket->proof_image_path);

            $validated['proof_image_path'] = $request->file('proof_image')->store(
                "tickets/proofs/{$ticket->user_id}",
                'public',
            );
        }

        $validated['reviewed_by'] = $validated['status'] === TicketStatus::Pending->value
            ? null
            : $request->user()->id;
        $validated['reviewed_at'] = $validated['status'] === TicketStatus::Pending->value
            ? null
            : now();
        $validated['rejection_reason'] = $validated['status'] === TicketStatus::Rejected->value
            ? $validated['rejection_reason']
            : null;

        unset($validated['proof_image']);

        $ticket->update($validated);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket atualizado.',
        ]);

        return to_route('admin.tickets.index');
    }

    public function approve(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::authorize('update', $ticket);

        $ticket->approve($request->user());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket aprovado.',
        ]);

        return back();
    }

    public function reject(RejectTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        Gate::authorize('update', $ticket);

        $ticket->reject($request->user(), $request->validated('rejection_reason'));

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket rejeitado.',
        ]);

        return back();
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        Gate::authorize('delete', $ticket);

        Storage::disk('public')->delete($ticket->proof_image_path);
        $ticket->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Ticket excluído.',
        ]);

        return to_route('admin.tickets.index');
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function statuses(): array
    {
        return array_map(fn (TicketStatus $status): array => [
            'value' => $status->value,
            'label' => $status->label(),
        ], TicketStatus::cases());
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function citiesForFilters(): array
    {
        return City::query()
            ->with('state')
            ->join('states', 'states.id', '=', 'cities.state_id')
            ->orderBy('states.abbreviation')
            ->orderBy('cities.name')
            ->select('cities.*')
            ->get()
            ->map(fn (City $city): array => [
                'id' => $city->id,
                'name' => $city->name,
                'state' => $city->state->abbreviation,
            ])
            ->all();
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
            'user' => [
                'id' => $ticket->user->id,
                'name' => $ticket->user->name,
                'email' => $ticket->user->email,
                'cpf' => $ticket->user->cpf,
            ],
            'city' => [
                'id' => $ticket->city->id,
                'name' => $ticket->city->name,
                'state' => $ticket->city->state->abbreviation,
            ],
            'reviewer' => $ticket->reviewer ? [
                'id' => $ticket->reviewer->id,
                'name' => $ticket->reviewer->name,
            ] : null,
            'created_at' => $ticket->created_at?->format('d/m/Y H:i'),
            'reviewed_at' => $ticket->reviewed_at?->format('d/m/Y H:i'),
        ];
    }
}
