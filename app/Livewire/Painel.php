<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class Painel extends Component
{
    public string $user;

    public function mount()
    {
        $this->user = Auth::user()->name;
    }

    public function render()
    {
        return view('livewire.painel');
    }
}
