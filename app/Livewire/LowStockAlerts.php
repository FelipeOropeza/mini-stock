<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LowStockNotification;

class LowStockAlerts extends Component
{
    public $alerts;

    public function mount()
    {
        $this->loadAlerts();
    }

    public function loadAlerts()
    {
        $this->alerts = LowStockNotification::with('product')
            ->where('sent', false)
            ->latest()
            ->get();
    }

    public function dismiss($id)
    {
        LowStockNotification::where('id', $id)->update(['sent' => true]);
        $this->loadAlerts();
    }

    public function render()
    {
        return view('livewire.low-stock-alerts');
    }
}
