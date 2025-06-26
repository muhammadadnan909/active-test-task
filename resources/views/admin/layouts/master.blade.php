{{-- <!-- ✅ Custom layout loaded -->
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ addslashes(session('success')) }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif --}}


<!DOCTYPE html>
<html>
<head>
    <title>My Custom Admin Template</title>
</head>
<body>
    <h1>This is my custom admin layout!</h1>

    @yield('content')
</body>
</html>
