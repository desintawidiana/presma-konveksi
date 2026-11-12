```blade
<aside
    class="cs-sidebar fixed left-0 top-0 z-50 flex h-full w-64 select-none flex-col justify-between bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)]"
    id="cs-sidebar"
>
    <div class="flex flex-col">
        {{-- Logo dan nama aplikasi --}}
        <div class="flex h-16 items-center gap-space-sm bg-surface-container-lowest px-space-md">
            <div class="flex w-full items-center gap-3">
                <img
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI7NzLLvbSZK-R70072_RFmOBCKj09oADam5Dq4uAMA0OfCPsFCYuLj9GPsA4sxxj36JA5X5Y7BVwOJl4HPuJ8V0xhXCsTAiYhjsz0WxYotg5ILTSBJE5UNLt3G44NtGkbK1HatrjXAxThAwCchCNihTTWGxFBeIDzOA1rgRK6FvRO3wv5eOivrtsOx1NKtBTziuGE6KVM7PJ17Rn8RPt-20SCK9M7WbctTZaZZX1hL9FMvgJbM8JwWPFT2UZlvOmf6k4"
                    alt="Presma Logo"
                    class="h-9 w-9 shrink-0 rounded object-contain"
                >

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

        {{-- Navigasi --}}
        <nav
            class="flex flex-col gap-1 px-space-sm"
            data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm"
        >
            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard.cs') }}"
                @if (request()->routeIs('dashboard.cs'))
                    aria-current="page"
                @endif
                class="flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                    {{ request()->routeIs('dashboard.cs')
                        ? 'bg-[#F7E7E7] font-semibold text-[#830909]'
                        : 'text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
                data-path="cs-dashboard"
            >
                <span class="material-symbols-outlined text-[20px]">grid_view</span>
                <span>Dashboard</span>
            </a>

            {{-- Customer --}}
            <a
                href="{{ route('cs.customer') }}"
                @if (request()->routeIs('cs.customer'))
                    aria-current="page"
                @endif
                class="flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                    {{ request()->routeIs('cs.customer')
                        ? 'bg-[#F7E7E7] font-semibold text-[#830909]'
                        : 'text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
                data-path="customer-management"
            >
                <span class="material-symbols-outlined text-[20px]">people</span>
                <span>Customer</span>
            </a>

            {{-- Order --}}
            <a
            href="{{ route('cs.order') }}"
            @if (request()->routeIs('cs.order', 'cs.order.detail'))
                aria-current="page"
            @endif
            class="flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.order', 'cs.order.detail')
                    ? 'bg-[#F7E7E7] font-semibold text-[#830909]'
                    : 'text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
            data-path="order-management"
        >
                <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                <span>Order</span>
            </a>

            {{-- Work Order --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="work-order"
            >
                <span class="material-symbols-outlined text-[20px]">assignment</span>
                <span>Work Order</span>
            </a>

            {{-- Invoice dan Pembayaran --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="invoice-and-pembayaran"
            >
                <span class="material-symbols-outlined text-[20px]">payments</span>
                <span>Invoice &amp; Pembayaran</span>
            </a>

            {{-- Tracking --}}
            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="order-tracking"
            >
                <span class="material-symbols-outlined text-[20px]">near_me</span>
                <span>Tracking</span>
            </a>

        </nav>
    </div>

    {{-- Status dan logout --}}
    <div class="flex flex-col gap-3 bg-surface-container-low p-space-md">
        <div class="flex items-center justify-between rounded-lg bg-surface-container-lowest px-3 py-2 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
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
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-label-md text-error transition-colors hover:bg-[#F7E7E7] hover:text-[#830909]"
                >
                    <span class="font-medium">Keluar Akun</span>
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>

        </div>
    </div>

</aside>
```