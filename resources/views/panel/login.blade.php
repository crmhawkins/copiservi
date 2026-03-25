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
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="w-full max-w-lg copi-card p-8 md:p-10">
                <div class="flex items-center justify-center">
                    <img src="/legacy/panel/logo.jpg" alt="Copiservi" class="h-20 w-auto" onerror="this.style.display='none'">
                </div>

                <h1 class="copi-title text-center text-3xl font-bold mt-5">Acceso al panel</h1>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Introduce tus credenciales para acceder a la gestión.
                </p>

                @if ($errors->any())
                    <div class="mt-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('panel.login.post') }}" class="mt-8 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Usuario</label>
                        <input
                            name="usuario"
                            value="{{ old('usuario') }}"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 text-lg shadow-sm focus:outline-none focus:ring-4 focus:ring-[color:var(--color-copiservi-muted-light)]"
                            autocomplete="username"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 text-lg shadow-sm focus:outline-none focus:ring-4 focus:ring-[color:var(--color-copiservi-muted-light)]"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button
                        class="w-full rounded-xl bg-[color:var(--color-copiservi-blue)] px-5 py-3 text-white font-bold text-lg shadow-md hover:brightness-110 active:brightness-95 transition"
                    >
                        Acceder
                    </button>
                </form>

                <div class="mt-4 text-center text-xs text-gray-500">
                    <a class="underline underline-offset-4" href="https://copiservi.com/" target="_blank" rel="noopener noreferrer">Ir a la web</a>
                </div>
            </div>
        </div>
    </body>
</html>

