<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\ReportController;



Route::get('/forgot-password', [PasswordResetController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendEmail'])->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'updatePassword'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/painel', \App\Livewire\Painel::class)->name('painel');
    Route::get('/products', \App\Livewire\Products::class)->name('products');
    Route::get('/products/{product}/category', \App\Livewire\ProductCategory::class)->name('category');
    Route::get('/estoque/movimentar/{product}', \App\Livewire\MovementForm::class)->name('movement');
    Route::get('/reports/movements', [ReportController::class, 'form'])->name('reports.movements.form');
    Route::get('/reports/movements/pdf', [ReportController::class, 'exportPdf'])->name('reports.movements.pdf');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', \App\Livewire\Login::class)->name('login');
Route::get('/cadastro', \App\Livewire\Cadastro::class)->name('cadastro');
