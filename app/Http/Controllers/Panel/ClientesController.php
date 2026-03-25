<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientesController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $movimientos = Registro::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('usuario', 'like', '%'.$q.'%');
            })
            ->orderByDesc('fecha')
            ->paginate(100)
            ->withQueryString();

        return view('panel.clientes', [
            'q' => $q,
            'movimientos' => $movimientos,
        ]);
    }
}

