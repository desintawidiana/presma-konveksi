
<aside
    id="cs-sidebar"
    class="cs-sidebar fixed left-0 top-0 z-50 flex h-full w-64 select-none flex-col justify-between bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)]">

    {{-- BAGIAN ATAS SIDEBAR --}}
    <div class="flex flex-col">

        {{-- LOGO DAN HEADER --}}
        <div class="cs-sidebar-header flex h-16 items-center justify-between px-4">

            <div id="cs-sidebar-brand" class="flex min-w-0 items-center gap-3">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhubmvGlbAWYEg9hQEUE4Q453r8d9Fu9HqwNyoilqcenwKHHDfv6zvn6yQWOBfU9cZ4wrLHzDrdpIYV_J6vU3BoS2mzC5NDQt1nsqbunMZSqP7kZAYQrlBn2uBJTEI9rTwdDW_GdOGQZ6u2zPulHjmfxPx-iWAhhZJQRFzKUw4h84142hEJuhz8MOzJ7sWXLlhiABlpeFl5tsIZY6YClQgPJ-DvqeDBclQZHVexixvU1e74CPzniVqdXcahTgeSoXMDaZRrNFO4Mwqi7U"
                    alt="Presma Logo"
                    class="h-9 w-9 shrink-0 rounded object-contain">

                <div class="cs-brand-text flex min-w-0 flex-col leading-tight">
                    <span class="truncate text-sm font-bold uppercase tracking-tight text-on-surface">
                        PRESMA KONVEKSI
                    </span>

                    <span class="text-xs font-semibold uppercase tracking-wider text-secondary">
                        CS WORKSPACE
                    </span>
                </div>
            </div>

            {{-- TOMBOL COLLAPSE --}}
            <button
                type="button"
                id="cs-sidebar-toggle"
                class="cs-sidebar-toggle flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#830909] transition-colors hover:bg-[#F7E7E7]"
                title="Tutup sidebar"
                aria-label="Tutup sidebar">

                <span class="material-symbols-outlined">
                    chevron_left
                </span>
            </button>

        </div>

        {{-- JUDUL MENU --}}
        <div class="cs-section-label px-4 pb-2 pt-5">
            <span class="text-xs font-semibold uppercase tracking-wider text-secondary">
                Menu Operasional
            </span>
        </div>

        {{-- NAVIGASI --}}
        <nav class="cs-sidebar-nav flex flex-col gap-1 px-3"
            aria-label="Menu navigasi CS">

            {{-- DASHBOARD --}}
            <a href="{{ route('cs.preview') }}"
                title="Dashboard"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">grid_view</span>
                <span class="cs-sidebar-label">Dashboard</span>
            </a>

            {{-- CUSTOMER --}}
            <a href="{{ route('cs.customer.preview') }}"
                title="Customer"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.customer.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">people</span>
                <span class="cs-sidebar-label">Customer</span>
            </a>

            {{-- ORDER --}}
            <a href="{{ route('cs.order.preview') }}"
                title="Order"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.order.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">shopping_bag</span>
                <span class="cs-sidebar-label">Order</span>
            </a>

            {{-- WORK ORDER --}}
            <a href="{{ route('cs.work-order.preview') }}"
                title="Work Order"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.work-order.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">assignment</span>
                <span class="cs-sidebar-label">Work Order</span>
            </a>

            {{-- INVOICE DAN PEMBAYARAN --}}
            <a href="{{ route('cs.invoice-pembayaran.preview') }}"
                title="Invoice & Pembayaran"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.invoice-pembayaran.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">payments</span>
                <span class="cs-sidebar-label">Invoice &amp; Pembayaran</span>
            </a>

            {{-- TRACKING --}}
            <a href="{{ route('cs.tracking.preview') }}"
                title="Tracking"
                class="cs-nav-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.tracking.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">

                <span class="material-symbols-outlined">near_me</span>
                <span class="cs-sidebar-label">Tracking</span>
            </a>

        </nav>
    </div>

    {{-- BAGIAN BAWAH SIDEBAR --}}
    <div class="cs-sidebar-footer flex flex-col gap-3 bg-surface-container-low p-4">

        {{-- STATUS WORKSPACE --}}
        <div class="cs-status-box flex items-center justify-between rounded-lg bg-surface-container-lowest px-3 py-2 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">

            <div class="flex items-center gap-2">
                <span class="h-2 w-2 shrink-0 animate-pulse rounded-full bg-primary-container"></span>

                <span class="cs-sidebar-label text-xs font-medium text-secondary">
                    CS Workspace
                </span>
            </div>

            <span class="cs-sidebar-label text-xs font-semibold text-primary-container">
                Aktif
            </span>

        </div>

        {{-- LOGOUT --}}
        <div class="border-t border-[#D9DADB] pt-2">

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    type="submit"
                    class="cs-logout-button flex w-full items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-error transition-colors hover:bg-[#F7E7E7] hover:text-[#830909]">

                    <span class="cs-sidebar-label">Keluar Akun</span>

                    <span class="material-symbols-outlined text-xl">
                        logout
                    </span>

                </button>
            </form>

        </div>
    </div>

</aside>


{{-- CSS SIDEBAR --}}
<style>
    /* SIDEBAR UTAMA */
    .cs-sidebar {
        width: 256px;
        transition: width .25s ease;
        overflow-x: hidden;
    }

    /* HEADER */
    .cs-sidebar-header {
        position: relative;
        flex-shrink: 0;
    }

    .cs-brand-text {
        transition: opacity .2s ease;
    }

    .cs-sidebar-toggle {
        cursor: pointer;
        flex-shrink: 0;
    }

    /* UKURAN FONT KONSISTEN */
    .cs-sidebar-label {
        font-size: 14px;
        line-height: 20px;
        white-space: nowrap;
    }

    .cs-nav-link {
        min-height: 40px;
        font-size: 14px;
        line-height: 20px;
        font-weight: 500;
    }

    .cs-nav-link .material-symbols-outlined {
        font-size: 20px;
        line-height: 1;
        flex-shrink: 0;
    }

    .cs-section-label {
        font-size: 11px;
        line-height: 16px;
    }

    /* TRANSISI */
    .cs-sidebar-label,
    .cs-section-label,
    .cs-brand-text {
        transition: opacity .2s ease;
    }

    /* SIDEBAR COLLAPSE */
    .cs-sidebar.collapsed {
        width: 76px;
    }

    .cs-sidebar.collapsed .cs-brand-text,
    .cs-sidebar.collapsed .cs-sidebar-label,
    .cs-sidebar.collapsed .cs-section-label {
        display: none;
    }

    .cs-sidebar.collapsed .cs-sidebar-header {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .cs-sidebar.collapsed #cs-sidebar-brand {
        justify-content: center;
    }

    .cs-sidebar.collapsed #cs-sidebar-toggle {
        position: absolute;
        top: 72px;
        right: 8px;
        z-index: 2;
        width: 24px;
        height: 24px;
        background: #F7E7E7;
    }

    .cs-sidebar.collapsed #cs-sidebar-toggle span {
        transform: rotate(180deg);
    }

    .cs-sidebar.collapsed .cs-sidebar-nav {
        padding-left: 10px;
        padding-right: 10px;
    }

    .cs-sidebar.collapsed .cs-nav-link {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .cs-sidebar.collapsed .cs-sidebar-footer {
        padding-left: 8px;
        padding-right: 8px;
    }

    .cs-sidebar.collapsed .cs-status-box {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    .cs-sidebar.collapsed .cs-logout-button {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
    }

    /* TOOLTIP MENU SAAT COLLAPSE */
    .cs-sidebar.collapsed .cs-nav-link {
        position: relative;
    }

    .cs-sidebar.collapsed .cs-nav-link:hover::after {
        content: attr(title);
        position: absolute;
        left: 60px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 100;
        padding: 7px 10px;
        border-radius: 6px;
        background: #292929;
        color: white;
        font-size: 12px;
        white-space: nowrap;
        pointer-events: none;
    }

    /* SHELL DAN HEADER UTAMA */
    .cs-shell {
        margin-left: 256px;
        min-width: 0;
        transition: margin-left .25s ease;
    }

    body.sidebar-collapsed .cs-shell {
        margin-left: 76px;
    }

    .cs-header {
        left: 256px;
        transition: left .25s ease;
    }

    body.sidebar-collapsed .cs-header {
        left: 76px;
    }

    /* RESPONSIVE MOBILE */
    @media (max-width: 768px) {
        .cs-sidebar {
            transform: translateX(-100%);
            transition: transform .25s ease;
        }

        .cs-sidebar.mobile-open {
            transform: translateX(0);
            width: 256px;
        }

        .cs-shell,
        body.sidebar-collapsed .cs-shell {
            margin-left: 0;
        }

        .cs-header,
        body.sidebar-collapsed .cs-header {
            left: 0;
        }
    }
</style>


{{-- JAVASCRIPT SIDEBAR --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('cs-sidebar');
    const toggleButton = document.getElementById('cs-sidebar-toggle');

    if (!sidebar || !toggleButton) return;

    toggleButton.addEventListener('click', function () {

        const isCollapsed = sidebar.classList.toggle('collapsed');

        document.body.classList.toggle(
            'sidebar-collapsed',
            isCollapsed
        );

        toggleButton.title = isCollapsed
            ? 'Buka sidebar'
            : 'Tutup sidebar';

        toggleButton.setAttribute(
            'aria-label',
            isCollapsed ? 'Buka sidebar' : 'Tutup sidebar'
        );

    });

});
</script>
