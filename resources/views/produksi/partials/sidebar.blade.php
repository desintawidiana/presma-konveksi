<aside id="produksi-sidebar"
    class="produksi-sidebar fixed left-0 top-0 z-50 flex h-full w-64 flex-col justify-between bg-white">
    <div class="produksi-sidebar-top">
        <div class="cs-sidebar-header flex h-16 items-center justify-between px-4">
            <div class="flex min-w-0 items-center gap-1"><span class="produksi-logo-wrap"><img
                        src="{{ asset('images/Logo.png') }}" alt="Presma Logo" class="produksi-logo"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='grid'"><span
                        class="produksi-logo-fallback" style="display:none"><span
                            class="material-symbols-outlined">storefront</span></span></span>
                <div class="flex min-w-0 flex-col leading-tight"><span
                        class="truncate text-sm font-bold uppercase tracking-tight text-on-surface">PRESMA
                        KONVEKSI</span><span class="text-[9px] font-semibold uppercase tracking-wide text-secondary">
                        PRODUCTION WORKSPACE
                    </span></div>
            </div>
            <button type="button" id="produksi-sidebar-toggle"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg text-[#830909] hover:bg-[#F7E7E7]"
                aria-label="Tutup sidebar"><span class="material-symbols-outlined"
                    id="produksi-sidebar-arrow">chevron_left</span></button>
        </div>
        <div class="produksi-nav-label">MENU OPERASIONAL</div>
        <nav class="produksi-nav">
            <a href="{{ route('dashboard.produksi') }}"
                class="{{ request()->routeIs('dashboard.produksi') ? 'active' : '' }}"><span
                    class="material-symbols-outlined">grid_view</span><span>Dashboard</span></a>
            <a href="{{ route('produksi.order') }}"
                class="{{ request()->routeIs('produksi.order') ? 'active' : '' }}"><span
                    class="material-symbols-outlined">shopping_bag</span><span>List Order</span></a>
            <a href="{{ route('produksi.proses') }}"
                class="{{ request()->routeIs('produksi.proses') ? 'active' : '' }}"><span
                    class="material-symbols-outlined">precision_manufacturing</span><span>Proses Produksi</span></a>
            <a href="{{ route('produksi.stok') }}"
                class="{{ request()->routeIs('produksi.stok') ? 'active' : '' }}"><span
                    class="material-symbols-outlined">layers</span><span>Stok Bahan</span></a>
            <a href="{{ route('produksi.pembelian') }}"
                class="{{ request()->routeIs('produksi.pembelian') ? 'active' : '' }}"><span
                    class="material-symbols-outlined">shopping_cart</span><span>Pembelian Bahan</span></a>
            {{-- TRACKING --}}
            <a href="{{ route('cs.tracking') }}" @if (request()->routeIs('cs.tracking*')) aria-current="page" @endif
                class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm transition-colors {{ request()->routeIs('cs.tracking*') ? 'bg-[#F7E7E7] font-semibold text-[#830909]' : 'text-[#59413E] hover:bg-[#F7E7E7] hover:text-[#830909]' }}"><span
                    class="material-symbols-outlined text-[20px]">near_me</span><span>Tracking</span></a>
        </nav>
    </div>
</aside>
