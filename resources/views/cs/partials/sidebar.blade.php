<aside
    class="fixed left-0 top-0 h-full w-64 bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-50 flex flex-col justify-between select-none cs-sidebar"
    id="cs-sidebar">
    <div class="flex flex-col">
        <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest">
            <div class="flex items-center gap-3 w-full"><img alt="Presma Logo"
                    class="w-9 h-9 object-contain rounded shrink-0"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhubmvGlbAWYEg9hQEUE4Q453r8d9Fu9HqwNyoilqcenwKHHDfv6zvn6yQWOBfU9cZ4wrLHzDrdpIYV_J6vU3BoS2mzC5NDQt1nsqbunMZSqP7kZAYQrlBn2uBJTEI9rTwdDW_GdOGQZ6u2zPulHjmfxPx-iWAhhZJQRFzKUw4h84142hEJuhz8MOzJ7sWXLlhiABlpeFl5tsIZY6YClQgPJ-DvqeDBclQZHVexixvU1e74CPzniVqdXcahTgeSoXMDaZRrNFO4Mwqi7U" />
                <div class="flex flex-col min-w-0 leading-tight"><span
                        class="font-title-sm text-title-sm text-on-surface tracking-tight uppercase truncate font-bold">PRESMA
                        KONVEKSI</span><span
                        class="font-label-sm text-label-sm text-secondary uppercase font-semibold tracking-wider">CS
                        WORKSPACE</span></div>
            </div>
        </div>
        <div class="px-space-md pt-space-md pb-space-xs"><span
                class="font-label-sm text-label-sm text-secondary uppercase tracking-wider font-semibold">Menu
                Operasional</span></div>
        <nav class="flex flex-col gap-1 px-space-sm"
            data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm"><a aria-current="page"
                class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors bg-[#F7E7E7] text-[#830909] font-semibold"
                data-path="cs-dashboard" href="{{ route('cs.preview') }}"><span
                    class="material-symbols-outlined text-[20px] text-[#830909]">grid_view</span><span
                    class="">Dashboard</span></a><a
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                data-path="customer-management" href="#"><span
                    class="material-symbols-outlined text-[20px]">people</span><span
                    class="">Customer</span></a><a
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                data-path="order-management" href="#"><span
                    class="material-symbols-outlined text-[20px]">shopping_bag</span><span
                    class="">Order</span></a><a
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                data-path="work-order" href="#"><span
                    class="material-symbols-outlined text-[20px]">assignment</span><span class="">Work
                    Order</span></a><a
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                data-path="invoice-and-pembayaran" href="#"><span
                    class="material-symbols-outlined text-[20px]">payments</span><span class="">Invoice &amp;
                    Pembayaran</span></a><a
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors"
                data-path="order-tracking" href="#"><span
                    class="material-symbols-outlined text-[20px]">near_me</span><span class="">Tracking</span></a>
        </nav>
    </div>
    <div class="p-space-md flex flex-col gap-3 bg-surface-container-low">
        <div
            class="flex items-center justify-between px-3 py-2 rounded-lg bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="flex items-center gap-2"><span
                    class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></span><span
                    class="font-label-sm text-label-sm text-secondary font-medium">Pratinjau CS</span></div><span
                class="font-label-sm text-label-sm text-primary-container font-semibold">Aktif</span>
        </div>
        <div class="pt-2 border-t border-[#D9DADB]"><button
                class="flex items-center justify-between w-full px-3 py-2 rounded-lg font-label-md text-label-md text-error hover:bg-[#F7E7E7] hover:text-[#830909] transition-colors cs-disabled-action"
                disabled="disabled" title="Logout dihubungkan oleh backend" type="button"><span
                    class="font-medium">Keluar Akun</span><span
                    class="material-symbols-outlined text-[18px]">logout</span></button></div>
    </div>
</aside>
<aside
    class="cs-sidebar fixed left-0 top-0 z-50 flex h-full w-64 select-none flex-col justify-between bg-surface-container-lowest shadow-[0_1px_8px_rgba(0,0,0,0.04)]"
    id="cs-sidebar">
    <div class="flex flex-col">
        {{-- Logo dan nama aplikasi --}}
        <div class="flex h-16 items-center gap-space-sm bg-surface-container-lowest px-space-md">
            <div class="flex w-full items-center gap-3">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhubmvGlbAWYEg9hQEUE4Q453r8d9Fu9HqwNyoilqcenwKHHDfv6zvn6yQWOBfU9cZ4wrLHzDrdpIYV_J6vU3BoS2mzC5NDQt1nsqbunMZSqP7kZAYQrlBn2uBJTEI9rTwdDW_GdOGQZ6u2zPulHjmfxPx-iWAhhZJQRFzKUw4h84142hEJuhz8MOzJ7sWXLlhiABlpeFl5tsIZY6YClQgPJ-DvqeDBclQZHVexixvU1e74CPzniVqdXcahTgeSoXMDaZRrNFO4Mwqi7U"
                    alt="Presma Logo" class="h-9 w-9 shrink-0 rounded object-contain">

                <div class="flex min-w-0 flex-col leading-tight">
                    <span class="truncate text-title-sm font-bold uppercase tracking-tight text-on-surface">
                        PRESMA KONVEKSI
                    </span>
                    <span class="text-label-sm font-semibold uppercase tracking-wider text-secondary">
                        CS WORKSPACE
                    </span>
                </div>
            </div>
        </div>

        {{-- Judul menu --}}
        <div class="px-space-md pb-space-xs pt-space-md">
            <span class="text-label-sm font-semibold uppercase tracking-wider text-secondary">
                Menu Operasional
            </span>
        </div>

        {{-- Navigasi --}}
        <nav class="flex flex-col gap-1 px-space-sm"
            data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">

            <a href="{{ route('cs.preview') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
                data-path="cs-dashboard">
                <span class="material-symbols-outlined text-[20px]">grid_view</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('cs.customer.preview') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2 transition-colors
                {{ request()->routeIs('cs.customer.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-label-md text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
                data-path="customer-management">
                <span class="material-symbols-outlined text-[20px]">people</span>
                <span>Customer</span>
            </a>

            <a href="{{ route('cs.order.preview') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md transition-colors
                {{ request()->routeIs('cs.order.preview')
                    ? 'bg-[#F7E7E7] text-[#830909] font-semibold'
                    : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}"
                data-path="order-management">
                <span class="material-symbols-outlined text-[20px]">
                    shopping_bag
                </span>
                <span>Order</span>
            </a>


            <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="work-order">
                <span class="material-symbols-outlined text-[20px]">assignment</span>
                <span>Work Order</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="invoice-and-pembayaran">
                <span class="material-symbols-outlined text-[20px]">payments</span>
                <span>Invoice &amp; Pembayaran</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-label-md text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface"
                data-path="order-tracking">
                <span class="material-symbols-outlined text-[20px]">near_me</span>
                <span>Tracking</span>
            </a>
        </nav>
    </div>

    {{-- Status dan logout --}}
    <div class="flex flex-col gap-3 bg-surface-container-low p-space-md">
        <div
            class="flex items-center justify-between rounded-lg bg-surface-container-lowest px-3 py-2 shadow-[0_1px_8px_rgba(0,0,0,0.04)]">
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 animate-pulse rounded-full bg-primary-container"></span>
                <span class="text-label-sm font-medium text-secondary">
                    CS Workspace
                </span>
            </div>

            <span class="text-label-sm font-semibold text-primary-container">
                Aktif
            </span>
        </div>

        <div class="border-t border-[#D9DADB] pt-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-label-md text-error transition-colors hover:bg-[#F7E7E7] hover:text-[#830909]">
                    <span class="font-medium">Keluar Akun</span>
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
