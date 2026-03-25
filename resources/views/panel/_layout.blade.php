<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Panel' }} - COPISERVI</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="min-h-screen">
            <div class="flex min-h-screen">
                <aside class="w-56 md:w-60 shrink-0 bg-white/10 text-white border-r border-white/10">
                    <div class="px-3 py-4">
                        <img
                            src="/legacy/panel/logo.jpg"
                            alt="Copiservi"
                            class="w-full h-10 object-contain"
                            onerror="this.style.display='none'"
                        >
                    </div>

                    <nav class="px-2 pb-6 text-sm">
                        <a href="{{ route('panel.dashboard') }}"
                           class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('panel.dashboard') ? 'bg-white/10' : '' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('panel.clientes') }}"
                           class="mt-2 block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('panel.clientes') ? 'bg-white/10' : '' }}">
                            Clientes
                        </a>

                        {{-- Registro oculto en menú (no eliminado) --}}

                        <div class="mt-4 border-t border-white/10 pt-4">
                            <form method="POST" action="{{ route('panel.logout') }}">
                                @csrf
                                <button class="w-full text-left rounded-lg px-3 py-2 hover:bg-white/10" type="submit">
                                    Salir
                                </button>
                            </form>
                            <a href="https://copiservi.com/" target="_blank" rel="noopener noreferrer" class="block rounded-lg px-3 py-2 hover:bg-white/10 text-white/90">
                                Ir a la web
                            </a>
                        </div>
                    </nav>
                </aside>

                <main class="flex-1 px-4 py-6 md:px-8 md:py-8">
                    <div class="mx-auto max-w-6xl">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        {{-- sin menú desplegable --}}
    </body>
</html>

