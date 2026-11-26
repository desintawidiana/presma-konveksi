<header class="produksi-header fixed top-0 left-64 right-0 z-40 flex h-16 items-center justify-between bg-white/95 px-6 shadow-sm">
 @php
  $prodCurrentPage = match (true) {
   request()->routeIs('dashboard.produksi') => 'Dashboard',
   request()->routeIs('produksi.order') => 'List Order',
   request()->routeIs('produksi.proses') => 'Proses Produksi',
   request()->routeIs('produksi.stok') => 'Stok Bahan',
   request()->routeIs('produksi.pembelian') => 'Pembelian Bahan',
   request()->routeIs('cs.tracking*') => 'Tracking',
   request()->routeIs('produksi.notifikasi') => 'Notifikasi',
   request()->routeIs('produksi.profil') => 'Profil Saya',
   default => trim($__env->yieldContent('title')) ?: 'Produksi',
  };
  $prodUserName = auth()->user()->nama ?? auth()->user()->name ?? 'Kepala Produksi';
 @endphp
 <nav aria-label="Breadcrumb" class="flex min-w-0 items-center gap-2 text-[12px] sm:text-[13px]"><span class="whitespace-nowrap text-secondary">Produksi</span><span class="material-symbols-outlined text-[15px] text-[#A39A9A]">chevron_right</span><strong class="truncate font-semibold text-on-surface" aria-current="page">{{ $prodCurrentPage }}</strong></nav>
 <div class="flex shrink-0 items-center gap-4">
  <div class="relative">
   <button type="button" onclick="toggleProduksiMenu('prod-notification-menu')" aria-label="Notifikasi" class="relative flex h-9 w-9 items-center justify-center rounded-lg text-secondary transition-colors hover:bg-surface-container-high"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-[#830909]"></span></button>
   <div id="prod-notification-menu" class="prod-header-dropdown hidden absolute right-0 top-12 w-80 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-xl">
    <div class="flex items-center justify-between border-b px-4 py-3"><strong class="text-sm text-gray-800">Notifikasi Produksi</strong><span class="text-xs font-semibold text-[#830909]">3 Baru</span></div>
    <div class="max-h-80 overflow-y-auto">
     <div class="flex gap-3 border-b bg-red-50/40 p-4"><span class="material-symbols-outlined text-[#830909]">assignment_turned_in</span><div><p class="text-sm font-semibold text-gray-800">Work Order baru</p><p class="mt-1 text-xs text-gray-500">WO-2026-0342 telah disetujui dan siap diproses.</p><span class="text-[11px] text-gray-400">Baru saja</span></div></div>
     <div class="flex gap-3 border-b bg-red-50/40 p-4"><span class="material-symbols-outlined text-[#830909]">warning</span><div><p class="text-sm font-semibold text-gray-800">Stok bahan menipis</p><p class="mt-1 text-xs text-gray-500">Resleting YKK 60 cm tersisa 12 pcs.</p><span class="text-[11px] text-gray-400">15 menit lalu</span></div></div>
     <div class="flex gap-3 bg-red-50/40 p-4"><span class="material-symbols-outlined text-[#830909]">verified</span><div><p class="text-sm font-semibold text-gray-800">Pemeriksaan QC</p><p class="mt-1 text-xs text-gray-500">ORD-2026-0331 menunggu pemeriksaan kualitas.</p><span class="text-[11px] text-gray-400">1 jam lalu</span></div></div>
    </div>
    <a href="{{ route('produksi.notifikasi') }}" class="block border-t px-4 py-3 text-center text-xs font-semibold text-[#830909] hover:bg-red-50">Lihat Semua Notifikasi</a>
   </div>
  </div>
  <span class="h-7 w-px bg-gray-200"></span>
  <div class="relative">
   <button type="button" onclick="toggleProduksiMenu('prod-profile-menu')" class="flex cursor-pointer select-none items-center gap-2.5 rounded-full px-2 py-1.5 transition-colors hover:bg-gray-100">
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#830909] text-xs font-bold tracking-wider text-white">{{ strtoupper(substr($prodUserName,0,2)) }}</span>
    <span class="flex flex-col text-left leading-tight"><b class="text-xs font-semibold text-gray-800">{{ $prodUserName }}</b><small class="text-[10px] text-gray-500">Kepala Produksi</small></span>
    <span class="material-symbols-outlined text-[18px] text-secondary">arrow_drop_down</span>
   </button>
   <div id="prod-profile-menu" class="prod-header-dropdown hidden absolute right-0 top-12 w-56 rounded-xl border border-gray-100 bg-white p-2 shadow-xl">
    <div class="border-b px-3 py-2"><b class="block text-xs text-gray-800">{{ $prodUserName }}</b><small class="mt-1 block text-[10px] text-gray-500">Kepala Produksi Presma</small><small class="mt-1 block text-[10px] text-gray-400">{{ auth()->user()->username ?? '' }}</small></div>
    <a href="{{ route('produksi.profil') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-xs text-gray-700 hover:bg-gray-50"><span class="material-symbols-outlined text-lg">person</span>Profil Saya</a>
    <div class="my-1 border-t"></div><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-xs text-red-600 hover:bg-red-50"><span class="material-symbols-outlined text-lg">logout</span>Keluar Akun</button></form>
   </div>
  </div>
 </div>
</header>
<script>
function toggleProduksiMenu(id){const target=document.getElementById(id);document.querySelectorAll('.prod-header-dropdown').forEach(el=>{if(el!==target)el.classList.add('hidden')});target?.classList.toggle('hidden')}
document.addEventListener('click',e=>{if(!e.target.closest('.produksi-header'))document.querySelectorAll('.prod-header-dropdown').forEach(el=>el.classList.add('hidden'))});
</script>