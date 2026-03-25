@php($title = 'Dashboard')

@include('panel._layout', [
    'title' => $title,
    'slot' => new \Illuminate\Support\HtmlString(view()->make('panel._dashboard_content', compact('admin', 'bonos'))->render()),
])

