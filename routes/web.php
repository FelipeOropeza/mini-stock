<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/cadastro', \App\Livewire\Cadastro::class)->name('cadastro');
