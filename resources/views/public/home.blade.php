<x-layouts.copiservi title="COPISERVI">
    <div class="copi-card overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 md:p-10">
                <h1 class="copi-title text-3xl md:text-4xl font-bold">Bienvenido</h1>
                <p class="copi-text mt-4 text-base leading-relaxed">
                    Bienvenido a la Web de Copiservi, donde podrá encontrar todos los servicios para cubrir sus necesidades
                    de fotocopiado, ploteado, impresión y encuadernación de todo tipo de documentos, en cualquier tamaño
                    de papel.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('servicios') }}" class="rounded-lg bg-[color:var(--color-copiservi-blue)] px-4 py-2 text-white font-semibold">
                        Ver servicios
                    </a>
                    <a href="{{ route('contactar') }}" class="rounded-lg bg-[color:var(--color-copiservi-muted)] px-4 py-2 text-white font-semibold">
                        Contactar
                    </a>
                </div>
            </div>

            <div class="bg-white/5 p-6 md:p-10">
                <img src="/legacy/Images/SELLO.GIF" alt="Sello" class="mx-auto h-32 w-auto" onerror="this.style.display='none'">
                <div class="mt-6 text-white/90 text-sm">
                    <div class="font-semibold">Servicios destacados</div>
                    <ul class="mt-2 list-disc pl-5 space-y-1">
                        <li>Fotocopias color y B/N digital</li>
                        <li>Copias de planos digitales</li>
                        <li>Ploteado de planos</li>
                        <li>Encuadernaciones y plastificaciones</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.copiservi>

