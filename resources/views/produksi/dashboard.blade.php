@extends('layout.produksi')
@section('title', 'Dashboard Produksi | Presma Operations')
@section('content')
<main class="produksi-main" data-produksi-dashboard>
    <div class="produksi-page-heading">
        <div><div class="flex items-center gap-2 flex-wrap"><h1>Dashboard Produksi</h1></div>
            <p>Ringkasan alur kerja konveksi dan prioritas lantai pabrik hari ini.</p></div>
        <a class="produksi-btn-primary" href="{{ route('produksi.order') }}">Lihat Antrean Produksi</a>
    </div>

    <div class="produksi-alert" id="produksi-alert" hidden>
        <span class="material-symbols-outlined">warning</span><div><strong>Perhatian Bahan Baku:</strong> <span id="produksi-alert-text">Memeriksa ketersediaan bahan...</span></div>
        <a href="{{ route('produksi.stok') }}">Cek Stok <span class="material-symbols-outlined">arrow_forward</span></a>
    </div>

    <section class="produksi-metrics" aria-label="Ringkasan produksi">
        <article class="produksi-metric"><div>Pesanan Masuk (ACC WO)<span class="material-symbols-outlined">assignment_turned_in</span></div><strong id="metric-incoming">— <small>Pesanan</small></strong><p>Siap diproses produksi</p></article>
        <article class="produksi-metric"><div>Sedang Dikerjakan<span class="material-symbols-outlined">precision_manufacturing</span></div><strong id="metric-working">— <small>Pesanan</small></strong><p>Pesanan dalam proses produksi</p></article>
        <article class="produksi-metric"><div>Pemeriksaan QC<span class="material-symbols-outlined">verified</span></div><strong id="metric-qc">— <small>Pesanan</small></strong><p>Menunggu pemeriksaan kualitas</p></article>
        <article class="produksi-metric"><div>Siap Packing / Kirim<span class="material-symbols-outlined">inventory_2</span></div><strong id="metric-packing">— <small>Pesanan</small></strong><p>Lolos QC dan siap dikemas</p></article>
    </section>

    <section class="produksi-panel">
        <div class="produksi-panel-heading"><div><h2>Antrean Pekerjaan Hari Ini</h2><p>Prioritas operasional berdasarkan tenggat waktu pengiriman</p></div><a href="{{ route('produksi.order') }}">Lihat Semua Order <span class="material-symbols-outlined">chevron_right</span></a></div>
        <div class="produksi-table-wrap">
            <table class="produksi-table">
                <thead><tr><th>Nomor Pesanan</th><th>Work Order</th><th>Produk & Pemesan</th><th>PJ Customer Service</th><th>Jumlah</th><th>Batas Waktu</th><th>Tahap Saat Ini</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody id="dashboard-antrian"><tr><td colspan="9" class="produksi-empty">Memuat antrean produksi...</td></tr></tbody>
            </table>
        </div>
        <div class="produksi-panel-footer"><span id="dashboard-count">Memuat data antrean...</span><a href="{{ route('produksi.order') }}">Buka daftar order →</a></div>
    </section>
</main>
@endsection
