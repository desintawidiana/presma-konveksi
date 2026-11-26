<header class="owner-header">
 @php
  $ownerPage = match(true) {
   request()->routeIs('dashboard.owner') => 'Dashboard',
   request()->routeIs('owner.order') => 'Order Management',
   request()->routeIs('owner.produksi') => 'Monitoring Produksi',
   request()->routeIs('owner.tracking') => 'Tracking Pesanan',
   request()->routeIs('owner.inventaris') => 'Inventaris & Aset',
   request()->routeIs('owner.keuangan') => 'Keuangan',
   request()->routeIs('owner.laporan') => 'Laporan & Analitik',
   request()->routeIs('owner.karyawan') => 'Manajemen Karyawan',
   request()->routeIs('owner.notifikasi') => 'Notifikasi',
   request()->routeIs('owner.profil') => 'Profil Saya',
   default => 'Owner Workspace'
  };
  $ownerName = auth()->user()->nama ?? 'Owner Presma';
  $ownerUser = auth()->user()->username ?? '-';
 @endphp
 <button class="owner-mobile-menu" id="owner-mobile-menu" type="button" aria-label="Buka navigasi"><span class="material-symbols-outlined">menu</span></button>
 <nav class="owner-breadcrumb"><span>Owner</span><span class="material-symbols-outlined">chevron_right</span><b>{{ $ownerPage }}</b></nav>
 <div class="owner-header-actions">
  <div class="owner-dropdown-wrap"><button type="button" class="owner-icon-button" id="owner-notif-toggle" aria-label="Notifikasi"><span class="material-symbols-outlined">notifications</span></button><div class="owner-dropdown hidden" id="owner-notif-menu"><div class="owner-dropdown-heading"><b>Notifikasi Owner</b></div><a href="{{ route('owner.notifikasi') }}" class="owner-dropdown-footer">Lihat Semua Notifikasi</a></div></div>
  <span class="owner-header-divider"></span>
  <div class="owner-dropdown-wrap"><button type="button" class="owner-profile-toggle" id="owner-profile-toggle"><span class="owner-avatar">{{ strtoupper(substr($ownerName,0,2)) }}</span><span class="owner-profile-copy"><b>{{ $ownerName }}</b><small>Owner</small></span><span class="material-symbols-outlined">arrow_drop_down</span></button><div class="owner-dropdown owner-profile-dropdown hidden" id="owner-profile-menu"><div class="owner-dropdown-user"><b>{{ $ownerName }}</b><small>{{ $ownerUser }}</small></div><a href="{{ route('owner.profil') }}"><span class="material-symbols-outlined">account_circle</span>Profil Saya</a><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit"><span class="material-symbols-outlined">logout</span>Keluar Akun</button></form></div></div>
 </div>
</header>