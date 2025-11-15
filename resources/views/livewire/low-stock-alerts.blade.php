<div>
    @if($alerts->count() > 0)
        <div class="space-y-3">
            @foreach ($alerts as $notification)
                <div class="bg-red-100 text-red-800 border border-red-300 p-3 rounded flex justify-between items-center">
                    <div>
                        <strong>Atenção!</strong>
                        O produto
                        <strong>{{ $notification->product->name }}</strong>
                        está com estoque baixo.
                        ({{ $notification->current_stock }} itens)
                    </div>

                    <button wire:click="dismiss({{ $notification->id }})"
                            class="bg-red-600 text-white px-3 py-1 rounded">
                        Fechar
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>
