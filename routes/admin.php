<?php

use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users/{user}/resend-email', [UserController::class, 'resendEmail'])->name('users.resend-email');

        Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::patch('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::patch('tickets/{ticket}/approve', [TicketController::class, 'approve'])->name('tickets.approve');
        Route::patch('tickets/{ticket}/reject', [TicketController::class, 'reject'])->name('tickets.reject');
        Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        Route::get('cities', [CityController::class, 'index'])->name('cities.index');
    });
