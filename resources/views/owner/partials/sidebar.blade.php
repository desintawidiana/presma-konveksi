<aside id="owner-sidebar" class="owner-sidebar">
 <div class="owner-sidebar-top">
  <div class="owner-brand"><a href="{{ route('dashboard.owner') }}" class="owner-brand-link"><img src="{{ asset('images/Logo.png') }}" alt="Presma Logo" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'"><span class="owner-logo-fallback"><span class="material-symbols-outlined">storefront</span></span><span class="owner-brand-text"><b>PRESMA KONVEKSI</b><small>OWNER WORKSPACE</small></span></a><button type="button" id="owner-sidebar-toggle" aria-label="Buka atau tutup sidebar" title="Buka atau tutup sidebar"><span class="material-symbols-outlined" id="owner-sidebar-arrow">chevron_left</span></button></div>
  <div class="owner-nav-label">MENU OPERASIONAL</div>
  <nav class="owner-nav">
   <a href="{{ route('dashboard.owner') }}" class="{{ request()->routeIs('dashboard.owner') ? 'active' : '' }}"><span class="material-symbols-outlined">grid_view</span><span>Dashboard</span></a>
   <a href="{{ route('owner.order') }}" class="{{ request()->routeIs('owner.order') ? 'active' : '' }}"><span class="material-symbols-outlined">shopping_bag</span><span>Order Management</span></a>
   <a href="{{ route('owner.produksi') }}" class="{{ request()->routeIs('owner.produksi') ? 'active' : '' }}"><span class="material-symbols-outlined">precision_manufacturing</span><span>Monitoring Produksi</span></a>
   <a href="{{ route('owner.tracking') }}" class="{{ request()->routeIs('owner.tracking') ? 'active' : '' }}"><span class="material-symbols-outlined">route</span><span>Tracking Pesanan</span></a>
   <a href="{{ route('owner.inventaris') }}" class="{{ request()->routeIs('owner.inventaris') ? 'active' : '' }}"><span class="material-symbols-outlined">inventory_2</span><span>Inventaris & Aset</span></a>
   <a href="{{ route('owner.keuangan') }}" class="{{ request()->routeIs('owner.keuangan') ? 'active' : '' }}"><span class="material-symbols-outlined">payments</span><span>Keuangan</span></a>
   <a href="{{ route('owner.laporan') }}" class="{{ request()->routeIs('owner.laporan') ? 'active' : '' }}"><span class="material-symbols-outlined">analytics</span><span>Laporan & Analitik</span></a>
  </nav>
  <div class="owner-nav-label owner-admin-label">ADMINISTRASI</div>
  <nav class="owner-nav"><a href="{{ route('owner.karyawan') }}" class="{{ request()->routeIs('owner.karyawan') ? 'active' : '' }}"><span class="material-symbols-outlined">groups</span><span>Manajemen Karyawan</span></a></nav>
 </div>
</aside>
