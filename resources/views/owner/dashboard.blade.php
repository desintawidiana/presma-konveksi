@extends('layout.owner')
@section('title','Dashboard Owner | Presma Operations')
@section('content')
<main class="owner-main">
 <div class="owner-page-heading"><div><h1>Dashboard</h1><p>Ringkasan menyeluruh operasional Presma Konveksi.</p></div><div class="owner-actions"><span class="owner-badge">Periode: November 2026</span><a class="owner-btn-light" href="{{ route('owner.laporan') }}"><span class="material-symbols-outlined">download</span>Lihat Laporan</a></div></div>
 <section class="owner-grid owner-metrics">
  <article class="owner-card owner-metric"><div class="owner-metric-top">Order Aktif <span class="owner-metric-icon"><span class="material-symbols-outlined">shopping_bag</span></span></div><strong>64</strong><small>Pesanan berjalan seluruh tim</small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Dalam Produksi <span class="owner-metric-icon"><span class="material-symbols-outlined">precision_manufacturing</span></span></div><strong>24</strong><small>3 pesanan mendekati deadline</small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Pendapatan Bulan Ini <span class="owner-metric-icon"><span class="material-symbols-outlined">payments</span></span></div><strong>Rp 186,4 jt</strong><small>88,7% dari target Rp 210 jt</small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Stok Perlu Perhatian <span class="owner-metric-icon"><span class="material-symbols-outlined">inventory_2</span></span></div><strong>7</strong><small>5 bahan penting menipis, 2 habis</small></article>
 </section>
 <div class="owner-content-grid">
  <div class="owner-grid">
   <section class="owner-card owner-panel">
    <div class="owner-panel-heading"><div><h2>Ringkasan Operasional</h2><p>Distribusi pekerjaan dan status tim saat ini</p></div><a class="owner-panel-link" href="{{ route('owner.produksi') }}">Detail produksi →</a></div>
    <div class="owner-grid" style="grid-template-columns:repeat(4,minmax(0,1fr));gap:9px">
     <div class="owner-card owner-metric"><small>Pesanan Baru</small><strong>12</strong><span class="owner-badge orange">Perlu verifikasi</span></div>
     <div class="owner-card owner-metric"><small>Dalam Produksi</small><strong>24</strong><span class="owner-badge blue">Berjalan</span></div>
     <div class="owner-card owner-metric"><small>Menunggu QC</small><strong>5</strong><span class="owner-badge orange">Perlu diperiksa</span></div>
     <div class="owner-card owner-metric"><small>Selesai</small><strong>23</strong><span class="owner-badge green">Siap / terkirim</span></div>
    </div>
   </section>
   <section class="owner-card">
    <div class="owner-panel owner-panel-heading"><div><h2>Order Terbaru & Perlu Perhatian</h2><p>Monitoring pesanan aktif dari Customer Service dan Produksi</p></div><a href="{{ route('owner.order') }}" class="owner-panel-link">Semua order →</a></div>
    <div class="owner-table-wrap"><table class="owner-table"><thead><tr><th>No. Pesanan</th><th>Customer / Produk</th><th>Deadline</th><th>Status</th><th>PIC Produksi</th></tr></thead><tbody>
     <tr><td class="owner-code">ORD-2026-0342</td><td><strong>BEM FT UGM</strong><span class="owner-subtext">Korsa PDH Nagata Drill · 350 pcs</span></td><td>28 Nov 2026</td><td><span class="owner-badge blue">Jahit</span></td><td>Dimas Saputra</td></tr>
     <tr><td class="owner-code">ORD-2026-0338</td><td><strong>HIMASISKO Undip</strong><span class="owner-subtext">Jaket Bomber · 150 pcs</span></td><td>25 Nov 2026</td><td><span class="owner-badge blue">Cutting</span></td><td>Bambang Prakoso</td></tr>
     <tr><td class="owner-code">ORD-2026-0335</td><td><strong>KOMA AMIKOM</strong><span class="owner-subtext">Kaos Komunitas · 200 pcs</span></td><td>22 Nov 2026</td><td><span class="owner-badge orange">Finishing</span></td><td>Yuni Kartika</td></tr>
     <tr><td class="owner-code">ORD-2026-0331</td><td><strong>BEM FISIP UPN</strong><span class="owner-subtext">Hoodie Custom · 120 pcs</span></td><td>21 Nov 2026</td><td><span class="owner-badge orange">Menunggu QC</span></td><td>Rudi Hartono</td></tr>
    </tbody></table></div>
   </section>
  </div>
  <div class="owner-grid">
   <section class="owner-card owner-panel"><div class="owner-panel-heading"><div><h2>Ringkasan Keuangan</h2><p>November 2026</p></div><a href="{{ route('owner.keuangan') }}" class="owner-panel-link">Detail →</a></div>
    <div class="owner-stat-list">
     <div class="owner-stat-row"><div><span>Total Pemasukan</span><b>Rp 186.400.000</b></div><div class="owner-progress"><span style="width:88.7%"></span></div></div>
     <div class="owner-stat-row"><div><span>Pengeluaran</span><b>Rp 104.300.000</b></div><div class="owner-progress"><span style="width:56%"></span></div></div>
     <div class="owner-stat-row"><div><span>Piutang Berjalan</span><b>Rp 32.500.000</b></div><div class="owner-progress"><span style="width:35%"></span></div></div>
    </div><div class="owner-note" style="margin-top:14px;font-size:10px;color:#706767">Saldo bersih operasional: <b style="color:#247342">Rp 82.100.000</b></div>
   </section>
   <section class="owner-card owner-panel"><div class="owner-panel-heading"><div><h2>Perlu Perhatian</h2><p>Hal yang memerlukan tindak lanjut Owner</p></div></div>
    <div class="owner-alert-item"><span class="material-symbols-outlined">inventory</span><div><b>Permintaan pembelian bahan</b><p>2 pengajuan bahan menunggu persetujuan.</p></div></div>
    <div class="owner-alert-item"><span class="material-symbols-outlined">event_busy</span><div><b>Deadline mendekat</b><p>3 pesanan perlu dipantau penyelesaiannya.</p></div></div>
    <div class="owner-alert-item"><span class="material-symbols-outlined">receipt_long</span><div><b>Invoice belum lunas</b><p>8 invoice masih memiliki sisa pembayaran.</p></div></div>
   </section>
  </div>
 </div>
</main>
@endsection