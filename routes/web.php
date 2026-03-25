<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'public.home')->name('home');
Route::view('/servicios', 'public.servicios')->name('servicios');
Route::view('/perfil', 'public.perfil')->name('perfil');
Route::view('/contactar', 'public.contactar')->name('contactar');

Route::prefix('panel')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Panel\AuthController::class, 'showLogin'])->name('panel.login');
    Route::post('/login', [\App\Http\Controllers\Panel\AuthController::class, 'login'])->name('panel.login.post');
    Route::post('/logout', [\App\Http\Controllers\Panel\AuthController::class, 'logout'])->name('panel.logout');

    Route::middleware([\App\Http\Middleware\PanelAuthenticate::class])->group(function () {
        Route::get('/', [\App\Http\Controllers\Panel\DashboardController::class, 'show'])->name('panel.dashboard');
        Route::post('/comprobar', [\App\Http\Controllers\Panel\CopiasController::class, 'comprobar'])->name('panel.comprobar');
        Route::post('/copias', [\App\Http\Controllers\Panel\CopiasController::class, 'hacerCopias'])->name('panel.copias');
        Route::post('/bono', [\App\Http\Controllers\Panel\CopiasController::class, 'cargarBono'])->name('panel.bono');
        Route::get('/registro', [\App\Http\Controllers\Panel\RegistroController::class, 'index'])->name('panel.registro');
    });
});
