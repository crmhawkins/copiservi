<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Panel - COPISERVI</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="min-h-screen px-4 py-8" data-panel="copiservi">
            <div class="mx-auto max-w-3xl">
                <div class="flex items-center justify-between gap-4">
                    <div class="text-white">
                        <div class="text-lg font-bold">COPISERVI</div>
                        <div class="text-xs text-white/80">
                            {{ $admin ? "Admin: {$admin->usuario}" : 'Panel' }}
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-sm">
                        <a href="{{ route('panel.registro') }}" class="underline underline-offset-4 text-white">Registro</a>
                        <form method="POST" action="{{ route('panel.logout') }}">
                            @csrf
                            <button class="underline underline-offset-4 text-white" type="submit">Salir</button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 copi-card p-6">
                    <div class="flex items-center justify-center">
                        <img src="/legacy/panel/logo.jpg" alt="Copiservi" class="h-14 w-auto" onerror="this.style.display='none'">
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-700">Usuario</label>
                        <input id="usuario" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-3 text-3xl font-bold text-center" inputmode="numeric" autocomplete="off">
                    </div>

                    <div class="mt-4">
                        <div id="comprobar_copias"></div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-semibold text-gray-700">Copias a realizar</label>
                        <input id="copias" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-3 text-3xl font-bold text-center" inputmode="numeric" autocomplete="off">
                        <div class="mt-2 text-xs text-gray-500">Al cambiar el valor, se descuenta del saldo.</div>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        @foreach ($bonos as $bono)
                            <button
                                type="button"
                                class="rounded-lg bg-[color:var(--color-copiservi-muted)] px-4 py-2 text-white font-semibold"
                                data-bono="{{ $bono }}"
                            >
                                CARGAR BONO {{ $bono }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

