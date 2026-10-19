
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Login | Presma Operations')
    </title>

    <!-- Google Fonts -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet">

    <!-- CSS Login -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/login.css') }}">

    @stack('styles')
</head>

<body>

    <main>
        @yield('content')
    </main>

    <!-- JavaScript Login -->
    <script src="{{ asset('assets/js/login.js') }}"></script>

    @stack('scripts')
</body>
</html>
