<div class="text-white">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="text-2xl font-bold">Clientes</div>
            <div class="text-xs text-white/80">Movimientos por cliente (tabla <code>registro</code>).</div>
        </div>

        <form method="GET" action="{{ route('panel.clientes') }}" class="flex items-center gap-2">
            <input
                name="q"
                value="{{ $q }}"
                placeholder="Buscar por código (ej: 00043)"
                class="w-72 max-w-full rounded-lg border border-gray-300 px-3 py-2 text-black"
            >
            <button class="rounded-lg bg-[color:var(--color-copiservi-blue)] px-4 py-2 text-white font-semibold">
                Buscar
            </button>
        </form>
    </div>
</div>

<div class="mt-6 copi-card p-6 overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-600">
                <th class="py-2 pr-4">Cliente</th>
                <th class="py-2 pr-4">Acción</th>
                <th class="py-2 pr-4">Notas</th>
                <th class="py-2 pr-4">Fecha</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($movimientos as $m)
                <tr class="border-t border-gray-200">
                    <td class="py-2 pr-4 font-semibold whitespace-nowrap">{{ $m->usuario }}</td>
                    <td class="py-2 pr-4 whitespace-nowrap">{{ $m->accion }}</td>
                    <td class="py-2 pr-4 min-w-[22rem]">{{ $m->notas }}</td>
                    <td class="py-2 pr-4 whitespace-nowrap">{{ optional($m->fecha)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $movimientos->links() }}
    </div>
</div>

