
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login | Presma Operations')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
        rel="stylesheet">

    @vite([
        'resources/css/auth/login.css',
        'resources/js/auth/login.js'
    ])

    @stack('styles')
</head>
<body class="bg-surface font-body-md text-body-md text-on-surface antialiased min-h-screen flex items-center justify-center p-space-md">
    <main class="w-full flex justify-center items-center">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
