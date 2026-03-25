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
            <div class="w-full max-w-md copi-card p-6">
                <div class="flex items-center justify-center">
                    <img src="/legacy/panel/logo.jpg" alt="Copiservi" class="h-16 w-auto" onerror="this.style.display='none'">
                </div>

                <h1 class="copi-title text-center text-2xl font-bold mt-4">Acceso al panel</h1>

                @if ($errors->any())
                    <div class="mt-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('panel.login.post') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Usuario</label>
                        <input name="usuario" value="{{ old('usuario') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" autocomplete="username" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Contraseña</label>
                        <input type="password" name="password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2" autocomplete="current-password" required>
                    </div>

                    <button class="w-full rounded-lg bg-[color:var(--color-copiservi-blue)] px-4 py-2 text-white font-semibold">
                        Entrar
                    </button>
                </form>

                <div class="mt-4 text-center text-xs text-gray-500">
                    <a class="underline underline-offset-4" href="{{ route('home') }}">Volver a la web</a>
                </div>
            </div>
        </div>
    </body>
</html>

