<div class="max-w-xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">
        Categoria do Produto: {{ $product->name }}
    </h1>

    <div class="bg-white p-4 rounded shadow space-y-4">

        <div>
            <label class="text-sm font-semibold">Escolher Categoria</label>
            <select wire:model="category_id" class="w-full border p-2 rounded">
                <option value="">Nenhuma</option>

                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold">Criar Nova Categoria</label>
            <input type="text" wire:model="new_category" class="w-full border p-2 rounded"
                placeholder="Ex: Eletrônicos">
        </div>

        <div class="flex gap-2 mt-4">
            <button wire:click="save"
                class="px-4 py-2 bg-green-600 text-white rounded">
                Salvar
            </button>

            <a href="{{ route('products') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded">
                Voltar
            </a>
        </div>

    </div>

</div>
