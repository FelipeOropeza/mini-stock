<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', \App\Livewire\Login::class)->name('login');
