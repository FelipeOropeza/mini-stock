<x-layouts.home>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-xl font-bold mb-4">Gerar Relatório de Movimentações</h1>

        <form action="{{ route('reports.movements.pdf') }}" method="GET" target="_blank" class="grid gap-4">
            <div>
                <label>Produto</label>
                <select name="product_id" class="w-full border p-2">
                    <option value="">Todos</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Tipo</label>
                <select name="type" class="w-full border p-2">
                    <option value="">Todos</option>
                    <option value="entrada">Entradas</option>
                    <option value="saida">Saídas</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>De (data)</label>
                    <input type="date" name="from" class="w-full border p-2">
                </div>
                <div>
                    <label>Até (data)</label>
                    <input type="date" name="to" class="w-full border p-2">
                </div>
            </div>

            <div class="flex gap-2 mt-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Gerar PDF</button>
                <a href="{{ route('products') }}" class="px-4 py-2 bg-gray-200 rounded">Voltar</a>
            </div>
        </form>
    </div>
</x-layouts.home>
