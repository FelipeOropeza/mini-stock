<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home')]
class MovementForm extends Component
{
    public $product;
    public $type = 'entrada';
    public $quantity;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function save()
    {
        $this->validate([
            'type'     => 'required|in:entrada,saida',
            'quantity' => 'required|integer|min:1',
        ]);

        $previous = $this->product->stock;
        $final = $this->type === 'entrada'
            ? $previous + $this->quantity
            : $previous - $this->quantity;

        if ($final < 0) {
            return $this->addError('quantity', 'Não há estoque suficiente.');
        }

        // Registrar movimento
        StockMovement::create([
            'product_id'     => $this->product->id,
            'user_id'        => Auth::id(),
            'type'           => $this->type,
            'quantity'       => $this->quantity,
            'previous_stock' => $previous,
            'final_stock'    => $final,
        ]);

        // Atualizar o produto
        $this->product->update(['stock' => $final]);

        session()->flash('success', 'Movimentação registrada com sucesso!');
        return redirect()->route('products');
    }

    public function render()
    {
        return view('livewire.movement-form');
    }
}
