<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientesController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $accion = trim((string) $request->query('accion', ''));

        $sort = (string) $request->query('sort', 'fecha');
        $dir = strtolower((string) $request->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        $sortable = [
            'cliente' => 'usuario',
            'accion' => 'accion',
            'fecha' => 'fecha',
        ];
        $orderBy = $sortable[$sort] ?? 'fecha';

        $acciones = Registro::query()
            ->select('accion')
            ->distinct()
            ->orderBy('accion')
            ->pluck('accion')
            ->values();

        $movimientos = Registro::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('usuario', 'like', '%'.$q.'%');
            })
            ->when($accion !== '', function ($query) use ($accion) {
                $query->where('accion', $accion);
            })
            ->orderBy($orderBy, $dir)
            ->paginate(100)
            ->withQueryString();

        return view('panel.clientes', [
            'q' => $q,
            'accion' => $accion,
            'acciones' => $acciones,
            'sort' => $sort,
            'dir' => $dir,
            'movimientos' => $movimientos,
        ]);
    }

    public function destroySelected(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $ids = array_values(array_unique(array_map('intval', $data['ids'])));

        Registro::query()->whereIn('id', $ids)->delete();

        return back()->with('status', 'Seleccionados borrados');
    }
}

