
<!-- Sidebar Owner: sumber Stitch, navigasi lain belum aktif. -->
<aside
    class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest z-50 flex flex-col justify-between shadow-[0_1px_8px_rgba(0,0,0,0.04)]"
>
    <div class="flex flex-col">
        <!-- Logo dan identitas aplikasi -->
        <div
            class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-lowest"
        >
            <a
                aria-disabled="true"
                class="flex items-center gap-3 py-2 px-1 owner-disabled-link"
                href="#"
                title="Modul ini belum dibuat"
            >
                <img
                    alt="Presma Konveksi Logo"
                    class="h-9 w-auto object-contain"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhubmvGlbAWYEg9hQEUE4Q453r8d9Fu9HqwNyoilqcenwKHHDfv6zvn6yQWOBfU9cZ4wrLHzDrdpIYV_J6vU3BoS2mzC5NDQt1nsqbunMZSqP7kZAYQrlBn2uBJTEI9rTwdDW_GdOGQZ6u2zPulHjmfxPx-iWAhhZJQRFzKUw4h84142hEJuhz8MOzJ7sWXLlhiABlpeFl5tsIZY6YClQgPJ-DvqeDBclQZHVexixvU1e74CPzniVqdXcahTgeSoXMDaZRrNFO4Mwqi7U"
                />

                <div class="flex flex-col">
                    <span
                        class="font-title-sm font-bold text-[#830909] leading-tight tracking-tight"
                    >
                        PRESMA
                    </span>

                    <span
                        class="font-label-sm text-[10px] text-on-surface-variant tracking-wider leading-none font-medium"
                    >
                        Owner Portal
                    </span>
                </div>
            </a>
        </div>

        <!-- Garis pemisah -->
        <div class="px-space-md py-space-xs">
            <div class="h-px w-full bg-surface-container"></div>
        </div>

        <!-- Menu operasional -->
        <div class="px-space-md pt-space-sm pb-space-xs">
            <span
                class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold"
            >
                MENU OPERASIONAL
            </span>
        </div>

        <nav
            class="flex flex-col px-space-sm gap-space-xs"
            data-active-classes="bg-primary-container text-on-primary font-title-sm rounded-lg shadow-sm"
        >
            <!-- Dashboard -->
            <a
                aria-current="page"
                class="flex items-center gap-space-sm px-space-md py-2.5 transition-all bg-[#F7E7E7] text-[#830909] font-title-sm font-semibold rounded-lg shadow-sm"
                data-path="dashboard"
                href="{{ route('dashboard') }}"
            >
                <span
                    class="material-symbols-outlined text-lg leading-none text-[#830909]"
                >
                    grid_view
                </span>
                <span>Dashboard</span>
            </a>

            <!-- Order -->
            <a
                aria-disabled="true"
                class="flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="order"
                href="#"
                title="Modul ini belum dibuat"
            >
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-lg leading-none">
                        shopping_bag
                    </span>
                    <span>Order</span>
                </div>

                <span
                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded-full bg-secondary-container text-on-secondary-container"
                >
                    18
                </span>
            </a>

            <!-- Produksi -->
            <a
                aria-disabled="true"
                class="flex items-center justify-between px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="produksi"
                href="#"
                title="Modul ini belum dibuat"
            >
                <div class="flex items-center gap-space-sm">
                    <span class="material-symbols-outlined text-lg leading-none">
                        content_cut
                    </span>
                    <span>Produksi</span>
                </div>

                <span
                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded-full bg-[#F7E7E7] text-[#830909] font-bold"
                >
                    Aktif
                </span>
            </a>

            <!-- Inventaris -->
            <a
                aria-disabled="true"
                class="flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="inventaris"
                href="#"
                title="Modul ini belum dibuat"
            >
                <span class="material-symbols-outlined text-lg leading-none">
                    inventory_2
                </span>
                <span>Inventaris</span>
            </a>

            <!-- Keuangan -->
            <a
                aria-disabled="true"
                class="flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="keuangan"
                href="#"
                title="Modul ini belum dibuat"
            >
                <span class="material-symbols-outlined text-lg leading-none">
                    payments
                </span>
                <span>Keuangan</span>
            </a>

            <!-- Laporan -->
            <a
                aria-disabled="true"
                class="flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="laporan"
                href="#"
                title="Modul ini belum dibuat"
            >
                <span class="material-symbols-outlined text-lg leading-none">
                    bar_chart
                </span>
                <span>Laporan</span>
            </a>
        </nav>

        <!-- Menu administrasi -->
        <div class="px-space-md pt-space-md pb-space-xs">
            <span
                class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider font-semibold"
            >
                ADMINISTRASI
            </span>
        </div>

        <nav
            class="flex flex-col px-space-sm gap-space-xs"
            data-active-classes="bg-primary-container text-on-primary font-title-sm rounded-lg shadow-sm"
        >
            <!-- Manajemen karyawan -->
            <a
                aria-disabled="true"
                class="flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="karyawan"
                href="#"
                title="Modul ini belum dibuat"
            >
                <span class="material-symbols-outlined text-lg leading-none">
                    badge
                </span>
                <span>Manajemen Karyawan</span>
            </a>

            <!-- Pengaturan akun -->
            <a
                aria-disabled="true"
                class="flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all font-body-md text-body-md owner-disabled-link"
                data-path="akun"
                href="#"
                title="Modul ini belum dibuat"
            >
                <span class="material-symbols-outlined text-lg leading-none">
                    manage_accounts
                </span>
                <span>Pengaturan Akun</span>
            </a>
        </nav>
    </div>

    <!-- Tombol logout --> 
    <div class="p-space-sm border-t border-[#D9DADB]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button
                class="w-full flex items-center gap-space-sm px-space-md py-2.5 rounded-lg text-on-surface-variant hover:bg-[#F7E7E7] hover:text-[#830909] transition-all font-body-md text-body-md text-left group"
                title="Keluar dari akun"
                type="submit">
                <span class="material-symbols-outlined text-lg leading-none group-hover:text-[#830909]">logout</span>
                <span class="font-medium">Keluar Akun</span>
            </button>
        </form>
    </div>
    </aside>
