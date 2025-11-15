<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf; // facade; garante que o pacote esteja instalado

class ReportController extends Controller
{
    // optional: página com o formulário de filtros
    public function form()
    {
        $products = Product::orderBy('name')->get();
        return view('reports.movements-form', compact('products'));
    }

    // gera e retorna o PDF
    public function exportPdf(Request $request)
    {
        $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'type'       => 'nullable|in:entrada,saida',
            'from'       => 'nullable|date',
            'to'         => 'nullable|date',
        ]);

        $query = StockMovement::with('product', 'user')->orderBy('created_at', 'desc');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $movements = $query->get();

        // some aggregates (totals)
        $totalEntries = $movements->where('type', 'entrada')->sum('quantity');
        $totalExits   = $movements->where('type', 'saida')->sum('quantity');

        $data = [
            'movements'    => $movements,
            'totalEntries' => $totalEntries,
            'totalExits'   => $totalExits,
            'filters'      => $request->only(['product_id','type','from','to']),
            'generatedAt'  => now(),
        ];

        // load blade view and generate pdf
        $pdf = Pdf::loadView('reports.movements-pdf', $data)
                  ->setPaper('a4', 'portrait'); // trocar para 'landscape' se quiser mais colunas

        $fileName = 'relatorio_movimentacoes_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($fileName);
    }
}
