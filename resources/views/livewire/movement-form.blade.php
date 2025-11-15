<div class="max-w-lg mx-auto bg-white p-6 shadow rounded">

    <h1 class="text-xl font-bold mb-4">
        Movimentar Estoque — {{ $product->name }}
    </h1>

    @if (session('success'))
        <div class="p-2 bg-green-500 text-white rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">

        <div>
            <label class="text-sm">Tipo de Movimentação</label>
            <select wire:model="type" class="w-full border rounded p-2">
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
            </select>
        </div>

        <div>
            <label class="text-sm">Quantidade</label>
            <input type="number" wire:model="quantity" class="w-full border rounded p-2">
            @error('quantity')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">
            Registrar
        </button>

        <a href="{{ route('products') }}" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">
            Voltar
        </a>

    </form>

</div>
