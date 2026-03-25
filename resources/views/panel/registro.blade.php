@php($title = 'Registro')

@include('panel._layout', [
    'title' => $title,
    'slot' => new \Illuminate\Support\HtmlString(view()->make('panel._registro_content', compact('items', 'q', 'accion', 'acciones', 'sort', 'dir'))->render()),
])

