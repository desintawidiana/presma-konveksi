<header
    class="fixed top-0 left-64 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.04)] z-40 flex items-center justify-between px-space-lg cs-header">

    <button aria-expanded="false" aria-label="Buka navigasi Customer Service" class="cs-menu-toggle" id="cs-menu-toggle"
        type="button">
        <span class="material-symbols-outlined">menu</span>
    </button>

    <!-- Breadcrumb: nama modul dan halaman aktif -->
    @php
        $csCurrentPage = match (true) {
            request()->routeIs('cs.preview') => 'Dashboard',
            request()->routeIs('cs.customer.preview') => 'Customer',
            request()->routeIs('cs.order.preview') => 'Order',
            request()->routeIs('cs.work-order.preview') => 'Work Order',
            request()->routeIs('cs.invoice-pembayaran.preview') => 'Invoice & Pembayaran',
            request()->routeIs('cs.tracking.preview') => 'Tracking Order',
            request()->routeIs('cs.public-order.preview') => 'Buat Order Baru',
            request()->routeIs('cs.invoice-create.preview') => 'Buat Invoice',
            request()->routeIs('cs.pembayaran-create.preview') => 'Input Pembayaran',
            request()->routeIs('cs.*') && request()->is('*notification*') => 'Notifikasi',
            request()->routeIs('cs.*') && request()->is('*profile*') => 'Profil Saya',
            default => trim($__env->yieldContent('title')) ?: 'Customer Service',
        };
    @endphp
    <nav aria-label="Breadcrumb" class="flex min-w-0 items-center gap-2 text-[12px] sm:text-[13px]">
        <a href="{{ route('cs.preview') }}" class="whitespace-nowrap text-secondary transition-colors hover:text-[#830909]">Customer Service</a>
        <span class="material-symbols-outlined text-[15px] text-[#A39A9A]" aria-hidden="true">chevron_right</span>
        <span class="truncate font-semibold text-on-surface" aria-current="page">{{ $csCurrentPage }}</span>
    </nav>

    <!-- Header Actions -->
    <div class="flex items-center gap-4 shrink-0">

        <!-- NOTIFIKASI -->
        <div class="relative">
            <button type="button" onclick="toggleCsMenu('cs-notification-menu')"
                class="relative flex items-center justify-center w-9 h-9 rounded-lg hover:bg-surface-container-high text-secondary hover:text-on-surface transition-colors">

                <span class="material-symbols-outlined text-[20px]">
                    notifications
                </span>

                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-primary-container"></span>
            </button>

            <!-- Dropdown Notifikasi -->
            <div id="cs-notification-menu"
                class="cs-header-dropdown hidden absolute right-0 top-12 w-80 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">

                <div class="flex justify-between items-center px-4 py-3 border-b">
                    <strong class="text-sm text-gray-800">Notifikasi</strong>
                    <span class="text-xs text-primary font-semibold">3 Baru</span>
                </div>

                <div class="max-h-80 overflow-y-auto">

                    <div class="flex gap-3 p-4 border-b bg-purple-50/50">
                        <span class="material-symbols-outlined text-primary">shopping_bag</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Pesanan Baru</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Ada pesanan baru yang perlu diperiksa.
                            </p>
                            <span class="text-[11px] text-gray-400">5 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="flex gap-3 p-4 border-b bg-purple-50/50">
                        <span class="material-symbols-outlined text-primary">payments</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Pembayaran Dikonfirmasi</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Pelanggan telah melakukan pembayaran.
                            </p>
                            <span class="text-[11px] text-gray-400">20 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="flex gap-3 p-4 bg-purple-50/50">
                        <span class="material-symbols-outlined text-primary">precision_manufacturing</span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Update Produksi</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Terdapat perubahan tahapan pengerjaan.
                            </p>
                            <span class="text-[11px] text-gray-400">1 jam yang lalu</span>
                        </div>
                    </div>

                </div>

                <a href="{{ url('/cs/notifikasi') }}"
                    class="block text-center text-xs font-semibold text-primary py-3 hover:bg-gray-50">
                    Lihat semua notifikasi
                </a>
            </div>
        </div>

        <!-- PROFIL CS -->
        <div class="relative">

            <button type="button" onclick="toggleCsMenu('cs-profile-menu')"
                class="flex items-center gap-2.5 pl-1.5 pr-2.5 py-1 rounded-full hover:bg-surface-container-high transition-colors cursor-pointer select-none">

                <div
                    class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold text-label-sm flex items-center justify-center shrink-0 tracking-wider shadow-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'RH', 0, 2)) }}
                </div>

                <div class="flex flex-col text-left leading-tight">
                    <span class="font-title-sm text-title-sm text-on-surface font-semibold">
                        {{ auth()->user()->name ?? 'Rina Handayani' }}
                    </span>
                    <span class="font-label-sm text-label-sm text-secondary">
                        Senior CS Presma
                    </span>
                </div>

                <span class="material-symbols-outlined text-secondary text-[18px] ml-0.5">
                    arrow_drop_down
                </span>
            </button>

            <!-- Dropdown Profil -->
            <div id="cs-profile-menu"
                class="cs-header-dropdown hidden absolute right-0 top-12 w-56 bg-white rounded-xl shadow-xl border border-gray-100 p-2">

                <a href="{{ url('/cs/profil') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-700 hover:bg-gray-50">
                    <span class="material-symbols-outlined text-lg">person</span>
                    Profil Saya
                </a>

                <div class="border-t my-2"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-red-500 hover:bg-red-50">
                        <span class="material-symbols-outlined text-lg">logout</span>
                        Keluar
                    </button>
                </form>

            </div>
        </div>

    </div>
</header>
