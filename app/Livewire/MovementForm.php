<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Log;
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
            'type' => 'required|in:entrada,saida',
            'quantity' => 'required|integer|min:1',
        ]);

        $previous = $this->product->stock;
        $final = $this->type === 'entrada'
            ? $previous + $this->quantity
            : $previous - $this->quantity;

        if ($final < 0) {
            return $this->addError('quantity', 'Não há estoque suficiente.');
        }

        // Registrar movimento na tabela stock_movements
        StockMovement::create([
            'product_id' => $this->product->id,
            'user_id' => Auth::id(),
            'type' => $this->type,
            'quantity' => $this->quantity,
            'previous_stock' => $previous,
            'final_stock' => $final,
        ]);

        // Atualizar o produto
        $this->product->update(['stock' => $final]);

        if ($final <= $this->product->min_stock) {
            \App\Models\LowStockNotification::create([
                'product_id' => $this->product->id,
                'current_stock' => $final,
                'sent' => false,
            ]);
        }

        /**
         * 🔥 Registrar LOG (isso era o que eu tinha feito antes)
         */
        Log::create([
            'user_id' => Auth::id(),
            'action' => "Movimentação de estoque: {$this->type}",
            'details' =>
                "Produto: {$this->product->name}\n" .
                "Quantidade: {$this->quantity}\n" .
                "Stock anterior: {$previous}\n" .
                "Stock atual: {$final}"
        ]);


        session()->flash('success', 'Movimentação registrada com sucesso!');
        return redirect()->route('products');
    }

    public function render()
    {
        return view('livewire.movement-form');
    }
}
