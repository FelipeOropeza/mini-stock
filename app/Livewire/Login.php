<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Title('Login')]

    public string $email = '';
    public string $password = '';
    public ?string $errorMessage = null;
    public array $errors = [];

    public function login()
    {
        $this->errors = [];
        $this->errorMessage = null;

        if (empty($this->email)) {
            $this->errors['email'] = 'Email é obrigatório.';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email inválido.';
        }

        if (empty($this->password)) {
            $this->errors['password'] = 'Senha é obrigatória.';
        } elseif (strlen($this->password) < 6) {
            $this->errors['password'] = 'Senha deve ter no mínimo 6 caracteres.';
        }

        if (!empty($this->errors)) {
            return;
        }

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            $this->reset(['email', 'password', 'errors']);
            return redirect()->route('painel');
        } else {
            $this->errorMessage = 'Email ou senha incorretos.';
        }
    }

    public function render()
    {
        return <<<'HTML'
    <div class="max-w-md mx-auto mt-10" x-data="{ showGeneralError: true, showEmailError: true, showPasswordError: true }">
        <form class="space-y-4" wire:submit="login">
            @if ($errorMessage)
                <div
                    class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded transition-all duration-300"
                    x-show="showGeneralError"
                    x-init="setTimeout(() => showGeneralError = false, 3000)"
                >
                    <p class="font-semibold">Erro de autenticação</p>
                    <p>{{ $errorMessage }}</p>
                </div>
            @endif

            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="email">Email:</label>
                <input
                    class="w-full border rounded px-3 py-2 transition-all duration-300"
                    :class="showEmailError && {{ isset($errors['email']) ? 'true' : 'false' }} ? 'border-red-500 bg-red-50' : 'border-gray-300'"
                    type="email"
                    id="email"
                    wire:model="email"
                    placeholder="seu@email.com"
                >
                @if (isset($errors['email']))
                    <p
                        x-show="showEmailError"
                        x-init="setTimeout(() => showEmailError = false, 3000)"
                        class="text-red-500 text-sm mt-1 transition-all duration-300"
                    >
                        {{ $errors['email'] }}
                    </p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold" for="password">Senha:</label>
                <input
                    class="w-full border rounded px-3 py-2 transition-all duration-300"
                    :class="showPasswordError && {{ isset($errors['password']) ? 'true' : 'false' }} ? 'border-red-500 bg-red-50' : 'border-gray-300'"
                    type="password"
                    id="password"
                    wire:model="password"
                    placeholder="Digite sua senha"
                >
                @if (isset($errors['password']))
                    <p
                        x-show="showPasswordError"
                        x-init="setTimeout(() => showPasswordError = false, 3000)"
                        class="text-red-500 text-sm mt-1 transition-all duration-300"
                    >
                        {{ $errors['password'] }}
                    </p>
                @endif
            </div>

            <div class="flex gap-2">
                <button
                    class="flex-1 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
                    type="submit"
                >
                    Entrar
                </button>
            </div>

            <div class="text-center mt-2">
                <a class="text-blue-500 hover:underline text-sm" href="{{ route('password.request') }}">
                    Esqueci a senha?
                </a>
            </div>

            <div class="text-center mt-4">
                <p class="text-gray-600">Não tem conta?
                    <a class="text-blue-500 hover:underline" href="{{ route('cadastro') }}">Criar conta</a>
                </p>
            </div>
        </form>
    </div>
    HTML;
    }
}
