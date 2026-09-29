<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use App\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class CopiasController extends Controller
{
    public function comprobar(Request $request): Response
    {
        $data = $request->validate([
            'usuario' => ['required', 'string', 'max:240'],
        ]);

        $usuario = Usuario::query()->where('usuario', $data['usuario'])->first();
        if (! $usuario) {
            return response($this->renderNoExisteHtml(), 200);
        }

        return response($this->renderSaldoHtml($usuario->copias).'<input type="hidden" name="existe" value="1" id="existe">', 200);
    }

    public function crear(Request $request): Response
    {
        $data = $request->validate([
            'usuario' => ['required', 'string', 'max:240'],
        ]);

        $numero = trim($data['usuario']);

        if (Usuario::query()->where('usuario', $numero)->exists()) {
            return response('<div class="text-sm text-white/90">Ese número operativo ya existe, no se puede duplicar.</div>', 200);
        }

        try {
            $usuario = Usuario::create([
                'usuario' => $numero,
                'copias' => 0,
                'ingreso' => Carbon::now()->toDateString(),
            ]);
        } catch (QueryException $e) {
            return response('<div class="text-sm text-white/90">Ese número operativo ya existe, no se puede duplicar.</div>', 200);
        }

        Registro::create([
            'admin_id' => $request->session()->get('panel_admin_id'),
            'usuario' => $usuario->usuario,
            'accion' => 'Alta',
            'notas' => 'Nuevo número operativo dado de alta',
            'fecha' => Carbon::now(),
        ]);

        return response($this->renderSaldoHtml($usuario->copias).'<input type="hidden" name="existe" value="1" id="existe">', 200);
    }

    public function hacerCopias(Request $request): Response
    {
        $data = $request->validate([
            'usuario' => ['required', 'string', 'max:240'],
            'copias' => ['required', 'integer', 'min:0'],
        ]);

        $usuario = Usuario::query()->where('usuario', $data['usuario'])->first();
        if (! $usuario) {
            return response('El usuario elegido no existe', 200);
        }

        $usuario->copias = $usuario->copias - (int) $data['copias'];
        $usuario->save();

        Registro::create([
            'admin_id' => $request->session()->get('panel_admin_id'),
            'usuario' => $usuario->usuario,
            'accion' => 'Copias',
            'notas' => 'Realiza '.$data['copias'].' copias',
            'fecha' => Carbon::now(),
        ]);

        return response($this->renderSaldoHtml($usuario->copias).'<input type="hidden" name="existe" value="1" id="existe">', 200);
    }

    public function cargarBono(Request $request): Response
    {
        $data = $request->validate([
            'usuario' => ['required', 'string', 'max:240'],
            'copias' => ['required', 'integer', 'min:1'],
        ]);

        $usuario = Usuario::query()->where('usuario', $data['usuario'])->first();
        if (! $usuario) {
            return response('El usuario elegido no existe', 200);
        }

        $usuario->copias = $usuario->copias + (int) $data['copias'];
        $usuario->save();

        Registro::create([
            'admin_id' => $request->session()->get('panel_admin_id'),
            'usuario' => $usuario->usuario,
            'accion' => 'Carga de Bono',
            'notas' => 'Carga bono de '.$data['copias'].' copias',
            'fecha' => Carbon::now(),
        ]);

        return response($this->renderSaldoHtml($usuario->copias).'<input type="hidden" name="existe" value="1" id="existe">', 200);
    }

    private function renderNoExisteHtml(): string
    {
        return '<div class="text-sm text-white/90">El usuario elegido no existe.</div>'
            .'<button type="button" id="crear-usuario-btn" class="copi-btn mt-2 rounded-lg border border-white/70 bg-white/10 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition-colors">'
            .'Dar de alta como nuevo número operativo</button>';
    }

    private function renderSaldoHtml(int $copias): string
    {
        if ($copias > 5) {
            return '<div id="green"><span class="middle">'.$copias.' disponibles</span></div>';
        }
        if ($copias > 0) {
            return '<div id="orange"><span class="middle">'.$copias.' disponibles</span></div>';
        }

        return '<div id="red"><span class="middle">'.$copias.' disponibles</span></div>';
    }
}

