@php($title = 'Clientes')

@include('panel._layout', [
    'title' => $title,
    'slot' => new \Illuminate\Support\HtmlString(view()->make('panel._clientes_content', compact('q', 'accion', 'acciones', 'sort', 'dir', 'movimientos'))->render()),
])

