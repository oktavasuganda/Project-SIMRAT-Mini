<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InboxController;

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['title' => 'Dashboard']);
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('inboxes', InboxController::class);
});

require __DIR__ . '/auth.php';
