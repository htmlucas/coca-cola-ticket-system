<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $search = (string) $request->query('search', '');

        return Inertia::render('admin/users/Index', [
            'users' => User::query()
                ->with(['city.state'])
                ->withCount('tickets')
                ->when($search !== '', function ($query) use ($search): void {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('cpf', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(15)
                ->withQueryString()
                ->through(fn (User $user): array => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'cpf' => $user->cpf,
                    'is_admin' => $user->isAdmin(),
                    'tickets_count' => $user->tickets_count,
                    'city' => $user->city ? [
                        'name' => $user->city->name,
                        'state' => $user->city->state->abbreviation,
                    ] : null,
                    'created_at' => $user->created_at?->format('d/m/Y H:i'),
                ]),
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function resendEmail(User $user): RedirectResponse
    {
        Password::sendResetLink(['email' => $user->email]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'E-mail reenviado ao participante.',
        ]);

        return back();
    }
}
