<x-layouts.copiservi title="Contactar - COPISERVI">
    <div class="copi-card p-6 md:p-10">
        <h1 class="copi-title text-3xl font-bold">Contactar</h1>

        <div class="copi-text mt-4 text-base leading-relaxed">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="font-semibold">Dirección</div>
                    <div>Villa Romana, Local 2</div>
                    <div>Algeciras, Cádiz</div>
                </div>
                <div>
                    <div class="font-semibold">Teléfono / Email</div>
                    <div>Teléfono: 956 634 876</div>
                    <div>Fax: 956 634 876</div>
                    <div>
                        <a class="underline underline-offset-4" href="mailto:copiservisl@telefonica.net">copiservisl@telefonica.net</a>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('home') }}" class="rounded-lg bg-[color:var(--color-copiservi-blue)] px-4 py-2 text-white font-semibold">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</x-layouts.copiservi>

