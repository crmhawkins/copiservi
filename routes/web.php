<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session()->has('panel_admin_id')) {
        return redirect()->route('panel.dashboard');
    }

    return redirect()->route('panel.login');
})->name('home');

Route::prefix('panel')->group(function () {
    // Compatibilidad URLs antiguas (/panel/login.php, /panel/index.php, etc.)
    Route::redirect('/login.php', '/panel/login', 302);
    Route::redirect('/index.php', '/panel', 302);

    Route::get('/login', [\App\Http\Controllers\Panel\AuthController::class, 'showLogin'])->name('panel.login');
    Route::post('/login', [\App\Http\Controllers\Panel\AuthController::class, 'login'])->name('panel.login.post');
    Route::post('/logout', [\App\Http\Controllers\Panel\AuthController::class, 'logout'])->name('panel.logout');

    Route::middleware([\App\Http\Middleware\PanelAuthenticate::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\Panel\DashboardController::class, 'show'])->name('panel.dashboard');
        Route::post('/comprobar', [\App\Http\Controllers\Panel\CopiasController::class, 'comprobar'])->name('panel.comprobar');
        Route::post('/copias', [\App\Http\Controllers\Panel\CopiasController::class, 'hacerCopias'])->name('panel.copias');
        Route::post('/bono', [\App\Http\Controllers\Panel\CopiasController::class, 'cargarBono'])->name('panel.bono');
        Route::get('/registro', [\App\Http\Controllers\Panel\RegistroController::class, 'index'])->name('panel.registro');
        Route::post('/registro/borrar', [\App\Http\Controllers\Panel\RegistroController::class, 'destroySelected'])->name('panel.registro.borrar');
        Route::get('/clientes', [\App\Http\Controllers\Panel\ClientesController::class, 'index'])->name('panel.clientes');
        Route::post('/clientes/borrar', [\App\Http\Controllers\Panel\ClientesController::class, 'destroySelected'])->name('panel.clientes.borrar');
    });
});
