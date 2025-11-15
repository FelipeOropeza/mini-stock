<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.home')]
class Products extends Component
{
    public $products;
    public $categories;

    public $product_id;
    public $name;
    public $description;
    public $category_id = null;
    public $stock = 0;
    public $min_stock = 0;

    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'stock' => 'required|integer|min:0',
        'min_stock' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->products = Product::with('category')->orderBy('id', 'DESC')->get();
        $this->categories = Category::orderBy('name')->get();
    }

    public function resetFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->description = '';
        $this->category_id = null;
        $this->stock = 0;
        $this->min_stock = 0;
        $this->isEditing = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            Product::where('id', $this->product_id)->update([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id ?? null,
                'stock' => $this->stock,
                'min_stock' => $this->min_stock,
            ]);
        } else {
            Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id ?? null,
                'stock' => $this->stock,
                'min_stock' => $this->min_stock,
            ]);
        }

        $this->resetFields();
        $this->loadData();
    }

    public function associateCategory($productId)
    {
        return redirect()->route('category', $productId);
    }

    public function goToMovement($productId)
    {
        return redirect()->route('movement', $productId);
    }



    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->category_id = $product->category_id ?? null;
        $this->stock = $product->stock;
        $this->min_stock = $product->min_stock;

        $this->isEditing = true;
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.products');
    }
}
