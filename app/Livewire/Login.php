<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Login extends Component
{
     #[Title('Login')]
    public function render()
    {
        return <<<'HTML'
        <div>
            <h1 class="text-2xl font-bold">Login Page</h1>
        </div>
        HTML;
    }
}
