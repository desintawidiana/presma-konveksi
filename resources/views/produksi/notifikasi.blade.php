@extends('layout.produksi')
@section('title','Notifikasi Produksi | Presma Operations')
@section('breadcrumb','Notifikasi')
@section('content')
<main class="produksi-main" data-notification-page>
    <div class="produksi-page-heading"><div><h1>Notifikasi</h1><p>Informasi Work Order, stok bahan, dan aktivitas produksi.</p></div><button type="button" class="produksi-btn-light" id="mark-all-read"><span class="material-symbols-outlined">done_all</span>Tandai Semua Dibaca</button></div>
    <section class="produksi-panel">
        <div class="produksi-panel-heading"><div><h2>Aktivitas Terbaru</h2><p>Notifikasi untuk Kepala Produksi</p></div><span class="produksi-chip" id="notification-unread-count">3 belum dibaca</span></div>
        <div class="produksi-notification-list" id="notification-list">
            <article class="produksi-notification-item unread" data-notification="wo-342"><span class="produksi-notification-icon"><span class="material-symbols-outlined">assignment_turned_in</span></span><div><b>Work Order baru disetujui</b><p>WO-2026-0342 untuk Korsa PDH BEM FT UGM sudah ACC dan dapat diproses.</p><small>Hari ini · 09.15</small></div><button type="button" data-read> Tandai dibaca </button></article>
            <article class="produksi-notification-item unread" data-notification="stock-005"><span class="produksi-notification-icon warning"><span class="material-symbols-outlined">warning</span></span><div><b>Stok bahan menipis</b><p>Resleting YKK 60 cm tersisa 12 pcs, di bawah stok minimum 30 pcs.</p><small>Hari ini · 08.45</small></div><button type="button" data-read>Tandai dibaca</button></article>
            <article class="produksi-notification-item unread" data-notification="qc-331"><span class="produksi-notification-icon"><span class="material-symbols-outlined">verified</span></span><div><b>Pesanan menunggu pemeriksaan QC</b><p>ORD-2026-0331 · Hoodie Custom sudah memasuki tahap QC.</p><small>Kemarin · 16.20</small></div><button type="button" data-read>Tandai dibaca</button></article>
            <article class="produksi-notification-item" data-notification="purchase-003"><span class="produksi-notification-icon success"><span class="material-symbols-outlined">inventory</span></span><div><b>Penerimaan bahan tercatat</b><p>Pembelian Kain Taslan sebanyak 40 meter telah diterima untuk kebutuhan WO-2026-0338.</p><small>17 Nov 2026 · 14.10</small></div><span class="produksi-notification-read">Sudah dibaca</span></article>
        </div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded',()=>{
 const key='presma_produksi_notifications_read_v1',read=new Set(JSON.parse(localStorage.getItem(key)||'[]'));
 const urgent=JSON.parse(localStorage.getItem('presma_produksi_stock_alerts_v1')||'[]');
 const stockItem=document.querySelector('[data-notification="stock-005"]');
 if(stockItem){if(!urgent.length){stockItem.remove();}else{stockItem.querySelector('p').textContent=urgent.map(x=>`${x.name} ${x.status.toLowerCase()} (${x.qty} ${x.unit})`).join('; ')+'.';}}
 const update=()=>{document.querySelectorAll('[data-notification]').forEach(item=>{const done=read.has(item.dataset.notification);item.classList.toggle('unread',!done);const btn=item.querySelector('[data-read]');if(btn){btn.hidden=done;}});const n=document.querySelectorAll('[data-notification].unread').length;document.getElementById('notification-unread-count').textContent=`${n} belum dibaca`;};
 document.querySelectorAll('[data-read]').forEach(btn=>btn.addEventListener('click',()=>{read.add(btn.closest('[data-notification]').dataset.notification);localStorage.setItem(key,JSON.stringify([...read]));update();}));
 document.getElementById('mark-all-read').addEventListener('click',()=>{document.querySelectorAll('[data-notification]').forEach(x=>read.add(x.dataset.notification));localStorage.setItem(key,JSON.stringify([...read]));update();});update();
});
</script>
@endsection
