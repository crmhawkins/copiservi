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
                <aside class="w-72 shrink-0 bg-white/10 text-white border-r border-white/10">
                    <div class="px-5 py-5 flex items-center gap-3">
                        <img src="/legacy/panel/logo.jpg" alt="Copiservi" class="h-10 w-auto rounded" onerror="this.style.display='none'">
                        <div>
                            <div class="font-bold leading-tight">COPISERVI</div>
                            <div class="text-xs text-white/80">Panel</div>
                        </div>
                    </div>

                    <nav class="px-3 pb-6 text-sm">
                        <a href="{{ route('panel.dashboard') }}"
                           class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('panel.dashboard') ? 'bg-white/10' : '' }}">
                            Dashboard
                        </a>

                        <button
                            type="button"
                            class="mt-2 w-full flex items-center justify-between rounded-lg px-3 py-2 hover:bg-white/10"
                            data-panel-menu-toggle="gestion"
                            aria-expanded="true"
                        >
                            <span>Gestión</span>
                            <span class="text-white/70" data-panel-menu-icon="gestion">▾</span>
                        </button>
                        <div class="pl-3" data-panel-menu="gestion">
                            <a href="{{ route('panel.clientes') }}"
                               class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('panel.clientes') ? 'bg-white/10' : '' }}">
                                Clientes
                            </a>
                            <a href="{{ route('panel.registro') }}"
                               class="block rounded-lg px-3 py-2 hover:bg-white/10 {{ request()->routeIs('panel.registro') ? 'bg-white/10' : '' }}">
                                Registro
                            </a>
                        </div>

                        <div class="mt-4 border-t border-white/10 pt-4">
                            <form method="POST" action="{{ route('panel.logout') }}">
                                @csrf
                                <button class="w-full text-left rounded-lg px-3 py-2 hover:bg-white/10" type="submit">
                                    Salir
                                </button>
                            </form>
                            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10 text-white/90">
                                Volver a la web
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-panel-menu-toggle]').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const key = btn.getAttribute('data-panel-menu-toggle');
                        const menu = document.querySelector(`[data-panel-menu="${key}"]`);
                        const icon = document.querySelector(`[data-panel-menu-icon="${key}"]`);
                        if (!menu) return;

                        const isHidden = menu.classList.toggle('hidden');
                        btn.setAttribute('aria-expanded', isHidden ? 'false' : 'true');
                        if (icon) icon.textContent = isHidden ? '▸' : '▾';
                    });
                });
            });
        </script>
    </body>
</html>

