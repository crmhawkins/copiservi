<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Registro - COPISERVI</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="min-h-screen px-4 py-8">
            <div class="mx-auto max-w-5xl">
                <div class="flex items-center justify-between gap-4 text-white">
                    <a href="{{ route('panel.dashboard') }}" class="underline underline-offset-4">← Volver</a>
                    <form method="POST" action="{{ route('panel.logout') }}">
                        @csrf
                        <button class="underline underline-offset-4" type="submit">Salir</button>
                    </form>
                </div>

                <div class="mt-6 copi-card p-6 overflow-x-auto">
                    <h1 class="copi-title text-2xl font-bold">Registro</h1>
                    <table class="mt-4 w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-600">
                                <th class="py-2 pr-4">Fecha</th>
                                <th class="py-2 pr-4">Usuario</th>
                                <th class="py-2 pr-4">Acción</th>
                                <th class="py-2 pr-4">Notas</th>
                                <th class="py-2 pr-4">Admin</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @foreach ($items as $it)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4 whitespace-nowrap">{{ optional($it->fecha)->format('Y-m-d H:i') }}</td>
                                    <td class="py-2 pr-4">{{ $it->usuario }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">{{ $it->accion }}</td>
                                    <td class="py-2 pr-4">{{ $it->notas }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">{{ $it->admin_id ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

