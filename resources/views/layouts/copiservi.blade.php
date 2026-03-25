<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('copiservi.branding.name') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="copi-shell">
            <div class="mx-auto max-w-5xl px-4 py-8">
                <div class="flex items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="/legacy/logo.GIF" alt="Copiservi" class="h-12 w-auto" onerror="this.style.display='none'">
                        <span class="text-white font-semibold tracking-wide">{{ config('copiservi.branding.name') }}</span>
                    </a>

                    <nav class="flex items-center gap-3 text-sm">
                        <a href="{{ route('home') }}" class="underline underline-offset-4">Inicio</a>
                        <a href="{{ route('perfil') }}" class="underline underline-offset-4">Perfil</a>
                        <a href="{{ route('servicios') }}" class="underline underline-offset-4">Servicios</a>
                        <a href="{{ route('contactar') }}" class="underline underline-offset-4">Contactar</a>
                        <a href="{{ route('panel.login') }}" class="underline underline-offset-4">Panel</a>
                    </nav>
                </div>

                <div class="mt-8">
                    {{ $slot }}
                </div>

                <footer class="mt-10 text-xs text-white/80">
                    <div>© {{ date('Y') }} {{ config('copiservi.branding.name') }}</div>
                </footer>
            </div>
        </div>
    </body>
</html>

