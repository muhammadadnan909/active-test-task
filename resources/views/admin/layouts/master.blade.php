<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    {!! $template->renderMeta($title) !!}
    {!! $template->renderStyles() !!}
</head>
<body>

    {{-- Flash messages --}}
    @include('admin.partials.flash')

    <div class="container-fluid">
        @yield('content')
    </div>

    {!! $template->renderScripts() !!}
</body>
</html>
