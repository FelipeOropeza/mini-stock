<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home')]
class ProductCategory extends Component
{
    public $product;
    public $category_id = '';
    public $new_category = '';

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->category_id = $product->category_id;
    }

    public function save()
    {
        // Se o user escreveu uma nova categoria → cria
        if (!empty($this->new_category)) {
            $category = Category::create([
                'name' => $this->new_category,
            ]);

            $this->category_id = $category->id;
        }

        // Atualiza produto
        $this->product->update([
            'category_id' => $this->category_id ?: null,
        ]);

        return redirect()->route('products')->with('success', 'Categoria atualizada!');
    }

    public function render()
    {
        return view('livewire.product-category', [
            'categories' => Category::all()
        ]);
    }
}
