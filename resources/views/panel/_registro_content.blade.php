<div class="text-white">
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="text-2xl font-bold">Registro</div>
            <div class="text-xs text-white/80">Movimientos (tabla <code>registro</code>).</div>
        </div>

        <div class="flex flex-wrap items-center gap-2 justify-end">
            <form id="registroFilters" method="GET" action="{{ route('panel.registro') }}" class="flex flex-wrap items-center gap-2 justify-end">
                <input
                    name="q"
                    value="{{ $q }}"
                    placeholder="Buscar"
                    class="w-72 max-w-full rounded-lg border border-white/70 bg-white/10 px-3 py-2 text-white placeholder:text-white/70 focus:outline-none focus:ring-4 focus:ring-white/10"
                >

                <select name="accion" class="copi-select w-52 max-w-full rounded-lg border border-white/70 bg-white/10 px-3 py-2 focus:outline-none focus:ring-4 focus:ring-white/10">
                    <option value="" style="color:#000; background:#fff;">Todas las acciones</option>
                    @foreach ($acciones as $a)
                        <option value="{{ $a }}" @selected($accion === $a) style="color:#000; background:#fff;">{{ $a }}</option>
                    @endforeach
                </select>
            </form>

            <a
                href="{{ route('panel.registro') }}"
                class="copi-btn rounded-lg border border-white/70 bg-white/10 px-4 py-2 text-white font-semibold hover:bg-blue-700 transition-colors"
            >
                Borrar filtros
            </a>

            <form id="bulkDeleteRegistroFormTop" method="POST" action="{{ route('panel.registro.borrar') }}">
                @csrf
                <button
                    id="bulkDeleteRegistroBtnTop"
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
    <form id="bulkDeleteRegistroForm" method="POST" action="{{ route('panel.registro.borrar') }}">
        @csrf
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-600">
                    @php
                        $base = request()->except('page');
                        $link = fn ($s) => route('panel.registro', array_merge($base, [
                            'sort' => $s,
                            'dir' => ($sort === $s && $dir === 'desc') ? 'asc' : 'desc',
                        ]));
                        $arrow = fn ($s) => $sort === $s ? ($dir === 'desc' ? ' ↓' : ' ↑') : '';
                    @endphp

                    <th class="py-2 pr-4 w-10">
                        <input id="selectAllRegistro" type="checkbox" class="h-4 w-4">
                    </th>
                    <th class="py-2 pr-4">
                        <a class="underline underline-offset-4" href="{{ $link('fecha') }}">Fecha{!! $arrow('fecha') !!}</a>
                    </th>
                    <th class="py-2 pr-4">
                        <a class="underline underline-offset-4" href="{{ $link('cliente') }}">Cliente{!! $arrow('cliente') !!}</a>
                    </th>
                    <th class="py-2 pr-4">
                        <a class="underline underline-offset-4" href="{{ $link('accion') }}">Acción{!! $arrow('accion') !!}</a>
                    </th>
                    <th class="py-2 pr-4">Notas</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach ($items as $it)
                    <tr class="border-t border-gray-200 hover:bg-gray-50 cursor-pointer" data-row-select-registro>
                        <td class="py-2 pr-4">
                            <input type="checkbox" class="rowCheckboxRegistro h-4 w-4" name="ids[]" value="{{ $it->id }}">
                        </td>
                        <td class="py-2 pr-4 whitespace-nowrap">{{ optional($it->fecha)->format('Y-m-d H:i') }}</td>
                        <td class="py-2 pr-4 font-semibold whitespace-nowrap">{{ $it->usuario }}</td>
                        <td class="py-2 pr-4 whitespace-nowrap">{{ $it->accion }}</td>
                        <td class="py-2 pr-4 min-w-[22rem]">{{ $it->notas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filters = document.getElementById('registroFilters');
        const qInput = filters?.querySelector('input[name="q"]');
        const accionSelect = filters?.querySelector('select[name="accion"]');

        accionSelect?.addEventListener('change', () => filters.submit());
        qInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                filters.submit();
            }
        });

        const selectAll = document.getElementById('selectAllRegistro');
        const checkboxes = Array.from(document.querySelectorAll('.rowCheckboxRegistro'));
        const bulkBtn = document.getElementById('bulkDeleteRegistroBtnTop');
        const bulkFormTop = document.getElementById('bulkDeleteRegistroFormTop');

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

        document.querySelectorAll('[data-row-select-registro]').forEach((row) => {
            row.addEventListener('click', (e) => {
                if (e.target && e.target.tagName === 'INPUT') return;
                const cb = row.querySelector('.rowCheckboxRegistro');
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

