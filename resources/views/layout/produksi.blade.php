<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Produksi | Presma Operations')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: {
                    primary: '#830909', 'primary-container': '#830909',
                    background: '#f6f8f8', surface: '#f6f8f8',
                    'surface-container-lowest': '#ffffff',
                    'surface-container-low': '#f1f3f3',
                    'surface-container': '#ecefef',
                    'on-surface': '#191c1c', secondary: '#625b5b',
                    outline: '#d9dddd', error: '#ba1a1a'
                },
                fontFamily: { sans: ['Inter', 'sans-serif'] }
            }}
        };
    </script>
    @vite([
        'resources/css/app.css',
        'resources/css/produksi/produksi.css',
        'resources/js/app.js',
        'resources/js/produksi/produksi.js'
    ])
</head>
<body class="bg-[#f6f8f8] text-[#191c1c] antialiased">
    @include('produksi.partials.sidebar')
    <div class="produksi-shell">
        @include('produksi.partials.header')
        @yield('content')
    </div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('produksi-sidebar');
    const toggle = document.getElementById('produksi-sidebar-toggle');
    const shell = document.querySelector('.produksi-shell');
    const header = document.querySelector('.produksi-header');
    const key = 'presma-produksi-sidebar-collapsed';
    const mobile = window.matchMedia('(max-width: 760px)');

    const apply = (collapsed) => {
        sidebar?.classList.toggle('is-collapsed', collapsed);
        shell?.classList.toggle('sidebar-is-collapsed', collapsed);
        if (sidebar) sidebar.style.width = collapsed ? '76px' : '260px';
        if (shell) {
            shell.style.marginLeft = collapsed ? '76px' : '260px';
            shell.style.width = collapsed ? 'calc(100% - 76px)' : 'calc(100% - 260px)';
        }
        if (header) header.style.left = collapsed ? '76px' : '260px';
        const arrow = document.getElementById('produksi-sidebar-arrow');
        if (arrow) arrow.textContent = collapsed ? 'chevron_right' : 'chevron_left';
        toggle?.setAttribute('aria-label', collapsed ? 'Buka sidebar' : 'Tutup sidebar');
    };

    let collapsed = mobile.matches || localStorage.getItem(key) === '1';
    apply(collapsed);

    toggle?.addEventListener('click', () => {
        collapsed = !sidebar?.classList.contains('is-collapsed');
        if (!mobile.matches) localStorage.setItem(key, collapsed ? '1' : '0');
        apply(collapsed);
    });

    mobile.addEventListener?.('change', (event) => {
        collapsed = event.matches || localStorage.getItem(key) === '1';
        apply(collapsed);
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.produksi-header')) {
            document.querySelectorAll('.prod-header-dropdown').forEach(menu => menu.classList.add('hidden'));
        }
    });
});
</script>
</body>
</html>
