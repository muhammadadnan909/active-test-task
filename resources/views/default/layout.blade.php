<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ AdminSection::getTitle() }}</title>

    <!-- Include default admin head -->
    @include('sleepingowl.default._partials.head')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="skin-blue sidebar-mini">

<div class="wrapper">

    @include('sleepingowl.default._partials.header')
    @include('sleepingowl.default._partials.sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ AdminSection::getTitle() }} <small>{{ AdminSection::getDescription() }}</small></h1>
            {!! AdminSection::breadcrumb()->render() !!}
        </section>

        <section class="content">
            {!! $content !!}
        </section>
    </div>

    @include('sleepingowl.default._partials.footer')

</div>

<!-- Scripts -->
@include('sleepingowl.default._partials.scripts')

<!-- ✅ SweetAlert for success messages -->
@if (session('success'))
<script>
    $(function () {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });

    $(document).on('pjax:end', function () {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

</body>
</html>
