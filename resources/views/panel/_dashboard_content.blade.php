<div data-panel="copiservi">
    <div class="mt-0 flex flex-col items-center gap-6">
        <div class="max-w-3xl w-full text-white">
            <div class="text-2xl font-bold">Dashboard</div>
            <div class="text-xs text-white/80">
                {{ $admin ? "Usuario: {$admin->usuario}" : 'Panel' }}
            </div>
        </div>
    <div class="copi-card p-6 max-w-3xl w-full">
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
                    class="copi-bono-btn rounded-lg px-4 py-2 font-semibold"
                    data-bono="{{ $bono }}"
                >
                    CARGAR BONO {{ $bono }}
                </button>
            @endforeach
        </div>
    </div>
    </div>
</div>

