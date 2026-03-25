<div class="text-white">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="text-2xl font-bold">Clientes</div>
            <div class="text-xs text-white/80">Movimientos por cliente (tabla <code>registro</code>).</div>
        </div>

        <div class="flex flex-wrap items-center gap-2 justify-end">
        <form id="clientesFilters" method="GET" action="{{ route('panel.clientes') }}" class="flex flex-wrap items-center gap-2 justify-end">
            <input
                name="q"
                value="{{ $q }}"
                placeholder="Buscar por cliente"
                class="w-72 max-w-full rounded-lg border border-white/70 bg-white/10 px-3 py-2 text-white placeholder:text-white/70 focus:outline-none focus:ring-4 focus:ring-white/10"
            >

            <select name="accion" class="copi-select w-52 max-w-full rounded-lg border border-white/70 bg-white/10 px-3 py-2 focus:outline-none focus:ring-4 focus:ring-white/10">
                <option value="" style="color:#000; background:#fff;">Todas las acciones</option>
                @foreach ($acciones as $a)
                    <option value="{{ $a }}" @selected($accion === $a) style="color:#000; background:#fff;">{{ $a }}</option>
                @endforeach
            </select>

            <a
                href="{{ route('panel.clientes') }}"
                class="copi-btn rounded-lg border border-white/70 bg-white/10 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition-colors"
            >
                Borrar filtros
            </a>
        </form>

        <form id="bulkDeleteFormTop" method="POST" action="{{ route('panel.clientes.borrar') }}">
            @csrf
            <button
                id="bulkDeleteBtnTop"
                class="copi-btn rounded-lg border border-white/70 bg-white/10 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                type="submit"
                disabled
            >
                Borrar seleccionados (0)
            </button>
        </form>
        </div>
    </div>
</div>

<div class="mt-6 copi-card p-6 overflow-x-auto">
    <form id="bulkDeleteForm" method="POST" action="{{ route('panel.clientes.borrar') }}">
    @csrf
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-600">
                @php
                    $base = request()->except('page');
                    $link = fn ($s) => route('panel.clientes', array_merge($base, [
                        'sort' => $s,
                        'dir' => ($sort === $s && $dir === 'desc') ? 'asc' : 'desc',
                    ]));
                    $arrow = fn ($s) => $sort === $s ? ($dir === 'desc' ? ' ↓' : ' ↑') : '';
                @endphp

                <th class="py-2 pr-4 w-10">
                    <input id="selectAll" type="checkbox" class="h-4 w-4">
                </th>
                <th class="py-2 pr-4">
                    <a class="underline underline-offset-4" href="{{ $link('cliente') }}">Cliente{!! $arrow('cliente') !!}</a>
                </th>
                <th class="py-2 pr-4">
                    <a class="underline underline-offset-4" href="{{ $link('accion') }}">Acción{!! $arrow('accion') !!}</a>
                </th>
                <th class="py-2 pr-4">Notas</th>
                <th class="py-2 pr-4">
                    <a class="underline underline-offset-4" href="{{ $link('fecha') }}">Fecha{!! $arrow('fecha') !!}</a>
                </th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach ($movimientos as $m)
                <tr class="border-t border-gray-200 hover:bg-gray-50 cursor-pointer" data-row-select>
                    <td class="py-2 pr-4">
                        <input type="checkbox" class="rowCheckbox h-4 w-4" name="ids[]" value="{{ $m->id }}">
                    </td>
                    <td class="py-2 pr-4 font-semibold whitespace-nowrap">{{ $m->usuario }}</td>
                    <td class="py-2 pr-4 whitespace-nowrap">{{ $m->accion }}</td>
                    <td class="py-2 pr-4 min-w-[22rem]">{{ $m->notas }}</td>
                    <td class="py-2 pr-4 whitespace-nowrap">{{ optional($m->fecha)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </form>

    <div class="mt-4">
        {{ $movimientos->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filters = document.getElementById('clientesFilters');
        const qInput = filters?.querySelector('input[name="q"]');
        const accionSelect = filters?.querySelector('select[name="accion"]');
        accionSelect?.addEventListener('change', () => filters.submit());
        qInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                filters.submit();
            }
        });

        const selectAll = document.getElementById('selectAll');
        const checkboxes = Array.from(document.querySelectorAll('.rowCheckbox'));
        const bulkBtn = document.getElementById('bulkDeleteBtnTop');
        const bulkFormTop = document.getElementById('bulkDeleteFormTop');

        function syncTopFormIds() {
            bulkFormTop.querySelectorAll('input[name="ids[]"]').forEach((n) => n.remove());
            checkboxes.filter((c) => c.checked).forEach((c) => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'ids[]';
                inp.value = c.value;
                bulkFormTop.appendChild(inp);
            });
        }

        function refreshBulkState() {
            const selectedCount = checkboxes.filter((c) => c.checked).length;
            bulkBtn.disabled = selectedCount === 0;
            bulkBtn.textContent = `Borrar seleccionados (${selectedCount})`;
            if (selectAll) selectAll.checked = selectedCount > 0 && selectedCount === checkboxes.length;
            syncTopFormIds();
        }

        selectAll?.addEventListener('change', () => {
            const on = selectAll.checked;
            checkboxes.forEach((c) => (c.checked = on));
            refreshBulkState();
        });

        checkboxes.forEach((cb) => cb.addEventListener('change', refreshBulkState));

        document.querySelectorAll('[data-row-select]').forEach((row) => {
            row.addEventListener('click', (e) => {
                if (e.target && e.target.tagName === 'INPUT') return;
                const cb = row.querySelector('.rowCheckbox');
                if (!cb) return;
                cb.checked = !cb.checked;
                refreshBulkState();
            });
        });

        bulkFormTop?.addEventListener('submit', (e) => {
            if (bulkBtn.disabled) return;
            if (!confirm('¿Borrar los seleccionados?')) e.preventDefault();
        });

        refreshBulkState();
    });
</script>

