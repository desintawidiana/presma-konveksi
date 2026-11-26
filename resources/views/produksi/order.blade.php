@extends('layout.produksi')
@section('title', 'List Order Produksi | Presma Operations')
@section('content')
<main class="produksi-main" data-produksi-order>
    <div class="produksi-page-heading">
        <div><h1>List Antrean Order Produksi</h1><p>Monitoring pengerjaan pesanan aktif lantai pabrik, progres pengerjaan, dan validasi WO.</p></div>
        <button class="produksi-btn-light" type="button" id="produksi-refresh"><span class="material-symbols-outlined">sync</span> Refresh Data</button>
    </div>
    <section class="produksi-metrics produksi-metrics-compact">
        <article class="produksi-metric"><div>Total Antrean<span class="material-symbols-outlined">format_list_bulleted</span></div><strong id="order-total">— <small>Order</small></strong></article>
        <article class="produksi-metric"><div>Sedang Dikerjakan<span class="material-symbols-outlined">precision_manufacturing</span></div><strong id="order-working">— <small>Batch</small></strong></article>
        <article class="produksi-metric"><div>Perlu Revisi QC<span class="material-symbols-outlined">warning</span></div><strong id="order-revision">— <small>Order</small></strong></article>
        <article class="produksi-metric"><div>Siap Diambil/Kirim<span class="material-symbols-outlined">local_shipping</span></div><strong id="order-ready">— <small>Order</small></strong></article>
    </section>
    <section class="produksi-toolbar">
        <label class="produksi-search"><span class="material-symbols-outlined">search</span><input id="order-search" type="search" placeholder="Cari WO, kode order, produk, atau pemesan..."></label>
        <div class="produksi-filter" id="order-filters">
            <button class="active" data-filter="all">Semua</button>
            <button data-filter="ready">Siap Dikerjakan</button>
            <button data-filter="working">Sedang Dikerjakan</button>
            <button data-filter="qc">Menunggu QC</button>
            <button data-filter="done">Selesai</button>
        </div>
    </section>
    <section class="produksi-panel no-pad">
        <div class="produksi-table-caption"><strong>Data Work Order & Antrean Produksi</strong><span>Terhubung dengan data pesanan CS melalui database Presma</span><strong id="order-qty">Total Qty: —</strong></div>
        <div class="produksi-table-wrap">
            <table class="produksi-table">
                <thead><tr><th>Nomor Pesanan</th><th>Work Order</th><th>Produk & Pemesan</th><th>PJ Customer Service</th><th>Jumlah</th><th>Batas Waktu</th><th>Tahap Produksi</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody id="produksi-order-rows"><tr><td colspan="9" class="produksi-empty">Memuat data antrean...</td></tr></tbody>
            </table>
        </div>
        <div class="produksi-panel-footer"><span id="order-pagination-info">—</span><div class="produksi-pagination"><button id="order-prev" disabled>‹</button><span id="order-page">1</span><button id="order-next" disabled>›</button></div></div>
    </section>
</main>
@endsection
