<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    {!! $template->renderMeta($title) !!}

    @if(null !== ($favicon = config('sleeping_owl.favicon')))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Optional: auto-dismiss flash messages after 3 seconds --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                });
            }, 3000);
        });
    </script>

    {{-- Main content --}}
    <div class="container-fluid">
        @yield('content')
    </div>

</body>
</html>
