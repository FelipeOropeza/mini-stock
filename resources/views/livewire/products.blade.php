<div class="p-6 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">
        Gestão de Produtos
    </h1>

    {{-- FORM --}}
    <div class="bg-white p-4 rounded shadow mb-6">

        <h2 class="text-xl font-semibold mb-3">
            {{ $isEditing ? 'Editar Produto' : 'Novo Produto' }}
        </h2>

        <form wire:submit.prevent="save" class="grid grid-cols-1 gap-4">

            <div>
                <label class="text-sm">Nome</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="text-sm">Descrição</label>
                <textarea wire:model="description" class="w-full border rounded p-2"></textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm">Estoque Inicial</label>
                    <input type="number" wire:model="stock" class="w-full border rounded p-2">
                    @error('stock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="text-sm">Nível Mínimo</label>
                    <input type="number" wire:model="min_stock" class="w-full border rounded p-2">
                    @error('min_stock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <button class="px-4 py-2 bg-blue-600 text-white rounded">
                    {{ $isEditing ? 'Atualizar' : 'Cadastrar' }}
                </button>

                @if ($isEditing)
                    <button type="button" wire:click="resetFields"
                        class="px-4 py-2 bg-gray-500 text-white rounded ml-2">
                        Cancelar
                    </button>
                @endif
            </div>

        </form>
    </div>

    {{-- LISTA --}}
    <div class="bg-white p-4 rounded shadow">

        <h2 class="text-xl font-semibold mb-3">Produtos Cadastrados</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">Nome</th>
                    <th>Categoria</th>
                    <th>Estoque</th>
                    <th>Mínimo</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b">
                        <td class="py-2">{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Sem Categoria' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->min_stock }}</td>
                        <td class="space-x-2">
                            <button wire:click="associateCategory({{ $product->id }})"
                                class="px-3 py-1 bg-purple-600 text-white rounded">
                                Categoria
                            </button>

                            <button wire:click="goToMovement({{ $product->id }})"
                                class="px-3 py-1 bg-blue-600 text-white rounded">
                                Movimentar
                            </button>


                            <button wire:click="edit({{ $product->id }})"
                                class="px-3 py-1 bg-yellow-500 text-white rounded">
                                Editar
                            </button>

                            <button wire:click="delete({{ $product->id }})"
                                onclick="return confirm('Excluir este produto?')"
                                class="px-3 py-1 bg-red-600 text-white rounded">
                                Excluir
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>
