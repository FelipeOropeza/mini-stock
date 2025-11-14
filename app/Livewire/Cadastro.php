<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\User;

class Cadastro extends Component
{
    #[Title('Cadastro')]

    public string $name;
    public string $email;
    public string $password;

    public function cadastro()
    {
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $this->reset(['name', 'email', 'password']);
    }
    public function render()
    {
        return <<<'HTML'
        <div class="max-w-md mx-auto mt-10">
            <form class="space-y-4" wire:submit="cadastro">
                <div class="mb-4">
                    <label class="block mb-1" for="name">Name:</label>
                    <input class="w-full border border-gray-300 rounded px-3 py-2" type="text" id="name" wire:model="name" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1" for="email">Email:</label>
                    <input class="w-full border border-gray-300 rounded px-3 py-2" type="email" id="email" wire:model="email" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1" for="password">Password:</label>
                    <input class="w-full border border-gray-300 rounded px-3 py-2" type="password" id="password" wire:model="password" required>
                </div>
                <a class="text-blue-500 hover:underline" href="{{ route('login') }}">Login</a>
                <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit">Cadastro</button>
            </form>
        </div>
        HTML;
    }
}
