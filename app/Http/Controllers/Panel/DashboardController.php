<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(Request $request): View
    {
        $admin = Admin::find($request->session()->get('panel_admin_id'));

        return view('panel.dashboard', [
            'admin' => $admin,
            'bonos' => config('copiservi.bonos'),
        ]);
    }
}

