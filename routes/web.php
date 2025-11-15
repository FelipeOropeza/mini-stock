<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/painel', \App\Livewire\Painel::class)->name('painel');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/cadastro', \App\Livewire\Cadastro::class)->name('cadastro');
