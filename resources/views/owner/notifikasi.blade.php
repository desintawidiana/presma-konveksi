@extends('layout.owner')
@section('title','Notifikasi | Owner')
@section('content')
<main class="owner-main">
 <div class="owner-page-heading"><div><h1>Notifikasi</h1><p>Informasi penting terkait pesanan, produksi, pembelian bahan, dan keuangan.</p></div><button class="owner-btn-light" id="owner-mark-all-read"><span class="material-symbols-outlined">done_all</span>Tandai Semua Dibaca</button></div>
 <section class="owner-card"><div class="owner-panel-heading" style="padding:16px 17px 0"><div><h2>Aktivitas Terbaru</h2><p>Notifikasi untuk Owner</p></div><span class="owner-badge red" id="owner-unread-count">3 belum dibaca</span></div>
  <div id="owner-notification-list">
   <article class="owner-notification unread" data-notif="order"><span class="material-symbols-outlined">shopping_bag</span><div><b>Pesanan baru masuk</b><p>ORD-2026-0345 dari UKM Musik menunggu verifikasi Customer Service.</p><small>Hari ini · 10.15</small></div><button data-read> Tandai dibaca </button></article>
   <article class="owner-notification unread" data-notif="purchase"><span class="material-symbols-outlined">inventory_2</span><div><b>Pengajuan pembelian bahan</b><p>Pengajuan pembelian Kain Taslan dan Resleting YKK menunggu persetujuan Owner.</p><small>Hari ini · 09.30</small></div><button data-read>Tandai dibaca</button></article>
   <article class="owner-notification unread" data-notif="deadline"><span class="material-symbols-outlined">event_busy</span><div><b>Deadline pesanan mendekat</b><p>ORD-2026-0331 dijadwalkan selesai pada 21 November 2026 dan menunggu QC.</p><small>Kemarin · 16.20</small></div><button data-read>Tandai dibaca</button></article>
   <article class="owner-notification" data-notif="payment"><span class="material-symbols-outlined">payments</span><div><b>Pembayaran diterima</b><p>DP pesanan ORD-2026-0342 berhasil diverifikasi oleh CS.</p><small>23 Nov 2026 · 14.10</small></div><span class="owner-badge">Dibaca</span></article>
  </div>
 </section>
</main>
@endsection