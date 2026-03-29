<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function() {
    Route::resource('students', StudentController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';