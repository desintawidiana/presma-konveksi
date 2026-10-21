<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Owner | Presma Operations')</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Mengikuti konfigurasi Tailwind desain Stitch untuk tahap preview. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:"class",theme:{extend:{"colors":{"tertiary-fixed":"#d4e3ff","tertiary-fixed-dim":"#a5c8ff","primary-fixed":"#ffdad5","surface-bright":"#f8f9f9","on-primary-fixed":"#410001","surface-container-high":"#e7e8e8","surface-tint":"#b02e25","inverse-surface":"#2e3131","primary":"#5c0002","on-surface-variant":"#59413e","primary-container":"#830909","surface-variant":"#e1e3e3","surface-container-lowest":"#ffffff","background":"#f8f9f9","on-primary-container":"#ff8a7b","on-background":"#191c1c","on-tertiary-fixed":"#001c3a","on-surface":"#191c1c","inverse-primary":"#ffb4aa","surface-container-highest":"#e1e3e3","inverse-on-surface":"#f0f1f1","error-container":"#ffdad6","outline-variant":"#e1bfba","tertiary":"#002a52","on-error-container":"#93000a","surface-dim":"#d9dada","primary-fixed-dim":"#ffb4aa","secondary":"#635d5e","on-tertiary":"#ffffff","on-tertiary-fixed-variant":"#004785","tertiary-container":"#004078","error":"#ba1a1a","on-primary":"#ffffff","on-secondary":"#ffffff","on-secondary-fixed-variant":"#4b4546","secondary-container":"#e9e0e1","on-primary-fixed-variant":"#8e1310","outline":"#8d706c","surface":"#f8f9f9","on-error":"#ffffff","on-secondary-fixed":"#1e1b1c","on-secondary-container":"#696364","on-tertiary-container":"#78adf7","secondary-fixed-dim":"#cdc4c5","surface-container":"#edeeee","secondary-fixed":"#e9e0e1","surface-container-low":"#f3f4f4"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"margin":"1.5rem","margin-mobile":"1rem","space-xl":"2rem","gutter":"1rem","space-sm":"0.5rem","space-md":"1rem","space-xs":"0.25rem","space-lg":"1.5rem","gutter-compact":"0.5rem"},"fontFamily":{"body-lg":["Inter"],"headline-sm":["Inter"],"label-md":["Inter"],"display-lg":["Inter"],"data-tabular":["Inter"],"title-md":["Inter"],"headline-lg":["Inter"],"body-sm":["Inter"],"body-md":["Inter"],"title-sm":["Inter"],"label-sm":["Inter"]},"fontSize":{"body-lg":["16px",{"lineHeight":"24px","fontWeight":"400"}],"headline-sm":["20px",{"lineHeight":"28px","letterSpacing":"-0.01em","fontWeight":"600"}],"label-md":["13px",{"lineHeight":"18px","fontWeight":"500"}],"display-lg":["32px",{"lineHeight":"40px","letterSpacing":"-0.02em","fontWeight":"700"}],"data-tabular":["13px",{"lineHeight":"18px","letterSpacing":"0.01em","fontWeight":"500"}],"title-md":["16px",{"lineHeight":"24px","letterSpacing":"-0.005em","fontWeight":"600"}],"headline-lg":["24px",{"lineHeight":"32px","letterSpacing":"-0.015em","fontWeight":"600"}],"body-sm":["12px",{"lineHeight":"16px","fontWeight":"400"}],"body-md":["14px",{"lineHeight":"20px","fontWeight":"400"}],"title-sm":["14px",{"lineHeight":"20px","fontWeight":"600"}],"label-sm":["11px",{"lineHeight":"14px","letterSpacing":"0.04em","fontWeight":"600"}]}}}}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="owner-page bg-surface font-body-md text-body-md text-on-surface antialiased">
    @include('owner.partials.sidebar')
    <div class="owner-shell pl-64 flex flex-col min-h-screen">
        @include('owner.partials.header')
        <main class="flex-1 pt-16 bg-surface px-space-lg py-space-lg w-full">
            @yield('content')
        </main>
    </div>
</body>
</html>
