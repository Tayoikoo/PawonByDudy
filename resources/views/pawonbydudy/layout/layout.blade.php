<!DOCTYPE html>
<html lang="en">
<head>    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>PawonByDudy</title>
    <!-- resources -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icons/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">    
</head>
<body class="d-flex flex-column min-vh-100" style="background-color:rgb(255, 255, 255);">
    <!-- Navbar -->
    @include('pawonbydudy.layout.navbar')
    <span class="d-inline-block d-md-block mt-5"></span>
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    <span class="d-inline-block d-md-block mt-5"></span>
    <!-- footer -->
    @include('pawonbydudy.layout.footer')
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sweetalert/jquery-3.6.0.min.js') }}"></script>
    
    <!-- sweetalert -->
    <script src="{{ asset('sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- sweetalert End -->
    @if (session('error'))
        <script>
        Swal.fire({
            icon: 'warning',
            title: 'Error!',
            text: "{{ session('error') }}"
        });
        </script>
    @endif
    
    @if (session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}"
        });
        </script>
    @endif    

    <script>
        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function isNumeric(value) {
            return /^-?\d+$/.test(value);
        }           
    </script>
</body>
</html>
