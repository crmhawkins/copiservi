<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(Request $request): View
    {
        return view('panel.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'usuario' => ['required', 'string', 'max:240'],
            'password' => ['required', 'string', 'max:240'],
        ]);

        $admin = Admin::query()->where('usuario', $data['usuario'])->first();
        if (! $admin || ! $admin->checkPassword($data['password'])) {
            return back()->withErrors(['usuario' => 'Usuario o contraseña incorrectos'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('panel_admin_id', $admin->id);
        $request->session()->put('panel_admin_nivel', $admin->nivel);

        return redirect()->route('panel.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['panel_admin_id', 'panel_admin_nivel']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('panel.login');
    }
}

