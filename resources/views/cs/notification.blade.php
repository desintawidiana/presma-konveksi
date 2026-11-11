@extends('layout.cs')

@section('title', 'Notifications | Presma Konveksi')

@section('content')

<div class="cs-notification-page">

        <div class="notification-page-heading">
            <div>
                <h1>Notifikasi</h1>
                <p>Pantau informasi terbaru dan aktivitas pesanan.</p>
            </div>

            <button type="button" class="btn-mark-all">
                Tandai semua sudah dilihat
            </button>
        </div>

        <!-- Ringkasan -->
        <div class="notification-summary">
            <div class="notification-summary-card">
                <span class="material-symbols-outlined">notifications</span>
                <div>
                    <p>Total Notifikasi</p>
                    <h3>12</h3>
                </div>
            </div>

            <div class="notification-summary-card">
                <span class="material-symbols-outlined">mark_email_unread</span>
                <div>
                    <p>Notifikasi Baru</p>
                    <h3>3</h3>
                </div>
            </div>

            <div class="notification-summary-card">
                <span class="material-symbols-outlined">check_circle</span>
                <div>
                    <p>Sudah Dilihat</p>
                    <h3>9</h3>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="notification-filter">
            <div class="notification-filter-tabs">
                <button class="active" type="button">Semua</button>
                <button type="button">Baru</button>
                <button type="button">Sudah Dilihat</button>
            </div>

            <select aria-label="Filter jenis notifikasi">
                <option value="semua">Semua Kategori</option>
                <option value="pesanan">Pesanan</option>
                <option value="pembayaran">Pembayaran</option>
                <option value="produksi">Produksi</option>
                <option value="pengiriman">Pengiriman</option>
            </select>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="notification-list-page">

            <div class="notification-date-heading">Hari Ini</div>

            <div class="notification-card unread" data-category="pesanan">
                <div class="notification-card-icon order">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </div>

                <div class="notification-card-content" >
                    <div class="notification-card-title">
                        <h3>Pesanan Baru Masuk</h3>
                        <span class="new-label">Baru</span>
                    </div>

                    <p>
                        Terdapat pesanan baru yang perlu diperiksa
                        dan ditindaklanjuti oleh Customer Service.
                    </p>

                    <div class="notification-meta">
                        <span>Nomor Pesanan: #ORD-2026-001</span>
                        <span>•</span>
                        <span>5 menit yang lalu</span>
                    </div>
                </div>

                <a href="{{ route('cs.order.preview') }}" class="notification-action">Lihat Pesanan</a>
            </div>

            <div class="notification-card unread" data-category="pembayaran">
                <div class="notification-card-icon payment">
                    <span class="material-symbols-outlined">payments</span>
                </div>

                <div class="notification-card-content" >
                    <div class="notification-card-title">
                        <h3>Pembayaran Dikonfirmasi</h3>
                        <span class="new-label">Baru</span>
                    </div>

                    <p>
                        Pembayaran pelanggan telah dikonfirmasi.
                        Silakan periksa detail transaksi.
                    </p>

                    <div class="notification-meta">
                        <span>Nomor Pesanan: #ORD-2026-002</span>
                        <span>•</span>
                        <span>20 menit yang lalu</span>
                    </div>
                </div>

                <a href="{{ route('cs.order.preview') }}" class="notification-action">Lihat Pesanan</a>
            </div>

            <div class="notification-card unread" data-category="produksi">
                <div class="notification-card-icon production">
                    <span class="material-symbols-outlined">precision_manufacturing</span>
                </div>

                <div class="notification-card-content">
                    <div class="notification-card-title">
                        <h3>Perubahan Status Produksi</h3>
                        <span class="new-label">Baru</span>
                    </div>

                    <p>
                        Pesanan telah mengalami perubahan tahapan
                        pengerjaan produksi.
                    </p>

                    <div class="notification-meta">
                        <span>Nomor Pesanan: #ORD-2026-003</span>
                        <span>•</span>
                        <span>1 jam yang lalu</span>
                    </div>
                </div>

                <a href="{{ route('cs.order.preview') }}" class="notification-action">Lihat Pesanan</a>
            </div>

            <div class="notification-date-heading">Sebelumnya</div>

            <div class="notification-card">
                <div class="notification-card-icon delivery">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>

                <div class="notification-card-content">
                    <div class="notification-card-title">
                        <h3>Pesanan Siap Dikirim</h3>
                    </div>

                    <p>
                        Pesanan telah selesai diproses dan siap
                        untuk tahap pengiriman.
                    </p>

                    <div class="notification-meta">
                        <span>Nomor Pesanan: #ORD-2026-004</span>
                        <span>•</span>
                        <span>Kemarin</span>
                    </div>
                </div>

                <a href="{{ route('cs.order.preview') }}" class="notification-action">Lihat Pesanan</a>
            </div>

        </div>
    </div>
@endsection
