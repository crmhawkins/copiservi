<div class="text-white">
    <div class="text-2xl font-bold">Registro</div>
    <div class="text-xs text-white/80">Últimos movimientos (limitado a 200).</div>
</div>

<div class="mt-6 copi-card p-6 overflow-x-auto">
    <table class="w-full text-sm">
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

