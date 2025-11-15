<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <style>
        /* Regras básicas para PDF */
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        .header { text-align: center; margin-bottom: 10px; }
        .small { font-size: 11px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; font-size: 11px; }
        th { background: #f2f2f2; }
        .right { text-align: right; }
        .badge-entry { color: #fff; background: #16a34a; padding: 2px 6px; border-radius: 4px; }
        .badge-exit { color: #fff; background: #dc2626; padding: 2px 6px; border-radius: 4px; }
        .footer { margin-top: 10px; font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Relatório de Movimentações de Estoque</h2>
        <div class="small">
            Gerado em: {{ $generatedAt->format('d/m/Y H:i') }}
            @if(!empty($filters['from']) || !empty($filters['to']))
                — Período:
                {{ $filters['from'] ? \Carbon\Carbon::parse($filters['from'])->format('d/m/Y') : '...' }}
                até
                {{ $filters['to'] ? \Carbon\Carbon::parse($filters['to'])->format('d/m/Y') : '...' }}
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data / Hora</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Stock Antes</th>
                <th>Stock Depois</th>
                <th>Usuário</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ optional($m->product)->name ?? '—' }}</td>
                    <td>
                        @if($m->type === 'entrada')
                            <span class="badge-entry">Entrada</span>
                        @else
                            <span class="badge-exit">Saída</span>
                        @endif
                    </td>
                    <td class="right">{{ number_format($m->quantity, 0, ',', '.') }}</td>
                    <td class="right">{{ number_format($m->previous_stock ?? 0, 0, ',', '.') }}</td>
                    <td class="right">{{ number_format($m->final_stock ?? 0, 0, ',', '.') }}</td>
                    <td>{{ optional($m->user)->name ?? '-' }}</td>
                    <td>{{ $m->description ?? ($m->descricao ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="right">Nenhuma movimentação encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Totais:</strong>
        Entradas: {{ number_format($totalEntries, 0, ',', '.') }} —
        Saídas: {{ number_format($totalExits, 0, ',', '.') }}
    </div>
</body>
</html>
