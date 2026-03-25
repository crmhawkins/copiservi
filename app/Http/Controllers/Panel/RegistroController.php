<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistroController extends Controller
{
    public function index(Request $request): View
    {
        $items = Registro::query()
            ->orderByDesc('fecha')
            ->limit(200)
            ->get();

        return view('panel.registro', [
            'items' => $items,
        ]);
    }
}

