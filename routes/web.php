<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendEmail'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/painel', \App\Livewire\Painel::class)->name('painel');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/cadastro', \App\Livewire\Cadastro::class)->name('cadastro');
