<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $registros = Registro::query()->whereIn('id', $ids)->get();
        $ajustes = [];

        foreach ($registros as $registro) {
            $reversion = -1 * $this->movementDelta((string) $registro->accion, (string) $registro->notas);
            if ($reversion !== 0) {
                $usuario = (string) $registro->usuario;
                $ajustes[$usuario] = ($ajustes[$usuario] ?? 0) + $reversion;
            }
        }

        DB::transaction(function () use ($ids, $ajustes): void {
            foreach ($ajustes as $usuario => $ajuste) {
                Usuario::query()
                    ->where('usuario', $usuario)
                    ->update([
                        'copias' => DB::raw('copias + ('.((int) $ajuste).')'),
                    ]);
            }

            Registro::query()->whereIn('id', $ids)->delete();
        });

        return back()->with('status', 'Seleccionados borrados');
    }

    private function movementDelta(string $accion, string $notas): int
    {
        preg_match('/-?\d+/', $notas, $m);
        $n = isset($m[0]) ? (int) $m[0] : 0;
        $a = mb_strtolower($accion);
        $t = mb_strtolower($notas);

        if (str_contains($a, 'carga') || str_contains($t, 'carga bono')) {
            return $n; // se sumó al saldo
        }

        if ($a === 'copias' || str_contains($a, 'copias')) {
            return -1 * $n; // se restó del saldo
        }

        if (str_contains($a, 'bonos')) {
            if (str_contains($t, 'suma')) {
                return $n;
            }
            if (str_contains($t, 'resta')) {
                return -1 * $n;
            }
        }

        return 0;
    }
}

