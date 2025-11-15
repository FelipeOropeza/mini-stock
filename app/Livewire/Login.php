<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Title('Login')]

    public string $email;
    public string $password;

    public function login()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            $this->reset(['email', 'password']);
            return redirect()->route('painel');
        } else {
            dd('Credenciais inválidas.');
        }
    }

    public function render()
    {
        return <<<'HTML'
        <div class="max-w-md mx-auto mt-10">
            <form class="space-y-4" wire:submit="login">
                <div class="mb-4">
                    <label class="block mb-1" for="email">Email:</label>
                    <input class="w-full border border-gray-300 rounded px-3 py-2" type="email" id="email" wire:model="email" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1" for="password">Password:</label>
                    <input class="w-full border border-gray-300 rounded px-3 py-2" type="password" id="password" wire:model="password" required>
                </div>
                <a class="text-blue-500 hover:underline" href="{{ route('cadastro') }}">Cadastro</a>
                <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Login</button>

            </form>
        </div>
        HTML;
    }
}
