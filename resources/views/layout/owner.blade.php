<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Owner | Presma Operations')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    @vite(['resources/css/app.css','resources/css/owner/owner.css','resources/css/tracking.css','resources/js/owner/owner.js'])
</head>
<body class="owner-page bg-[#f6f8f8] text-[#191c1c] antialiased">
    @include('owner.partials.sidebar')
    <div class="owner-shell">
        @include('owner.partials.header')
        @yield('content')
    </div>
</body>
</html>
