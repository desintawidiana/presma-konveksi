@extends('layout.cs')

@section('title', 'Order Tracking | Presma Konveksi')

@section('content')
    @php
        // DATA CONTOH: ganti dengan data dari controller/database saat backend dihubungkan.
        $stages = [
            [
                'id' => 1,
                'name' => 'Intake & Form CS',
                'team' => 'CUSTOMER SERVICE',
                'desc' => 'Penerimaan dan verifikasi data pesanan',
            ],
            [
                'id' => 2,
                'name' => 'Pembuatan WO & Desain',
                'team' => 'CS / DESAINER',
                'desc' => 'Pembuatan dan persetujuan Work Order',
            ],
            [
                'id' => 3,
                'name' => 'Cutting & Potong',
                'team' => 'TIM PRODUKSI',
                'desc' => 'Persiapan dan pemotongan bahan',
            ],
            ['id' => 4, 'name' => 'Bordir & Sablon', 'team' => 'TIM PRODUKSI', 'desc' => 'Pengerjaan detail desain'],
            ['id' => 5, 'name' => 'Jahit & Perakitan', 'team' => 'TIM PRODUKSI', 'desc' => 'Proses perakitan produk'],
            [
                'id' => 6,
                'name' => 'QC & Finishing',
                'team' => 'TIM PRODUKSI',
                'desc' => 'Pemeriksaan kualitas dan penyelesaian',
            ],
            [
                'id' => 7,
                'name' => 'Pelunasan & Kasir',
                'team' => 'CS / KEUANGAN',
                'desc' => 'Konfirmasi pelunasan pesanan',
            ],
            [
                'id' => 8,
                'name' => 'Siap Ambil / Kirim',
                'team' => 'CS / OWNER',
                'desc' => 'Penyerahan pesanan kepada pelanggan',
            ],
        ];
        $orders = [
            [
                'code' => 'ORD-2026-041',
                'client' => 'SMAN 3 Yogyakarta',
                'product' => 'Jaket Taslan Balon',
                'qty' => '110 pcs',
                'stage' => 1,
                'status' => 'Menunggu verifikasi form ukuran',
                'confirmed' => 'Rina (CS 1) · @rina.cs1',
                'date' => '12 November 2026',
                'wo' => null,
                'notes' => [
                    [
                        'by' => 'Rina (CS 1)',
                        'date' => '7 November 2026, 10.15',
                        'text' => 'Menunggu pelanggan melengkapi form ukuran.',
                    ],
                ],
            ],
            [
                'code' => 'ORD-2026-040',
                'client' => 'BEM Geografi UGM',
                'product' => 'Korsa PDH Drill',
                'qty' => '160 pcs',
                'stage' => 2,
                'status' => 'Menunggu ACC Work Order',
                'confirmed' => 'Owner · @owner.presma',
                'date' => '14 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-040', 'url' => '#'],
                'notes' => [
                    [
                        'by' => 'Fika (CS 2)',
                        'date' => '7 November 2026, 11.20',
                        'text' => 'Desain sudah dikirim untuk diperiksa pelanggan.',
                    ],
                ],
            ],
            [
                'code' => 'ORD-2026-039',
                'client' => 'DEMA UIN Sunan Kalijaga',
                'product' => 'Korsa PDH Tropical',
                'qty' => '150 pcs',
                'stage' => 3,
                'status' => 'Pemotongan pola badan dan lengan',
                'confirmed' => 'Fika (CS 2) · @fika.cs2',
                'date' => '15 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-039', 'url' => '#'],
                'notes' => [
                    [
                        'by' => 'Tim Produksi',
                        'date' => '7 November 2026, 13.05',
                        'text' => 'Bahan utama sudah diterima dan proses cutting dimulai.',
                    ],
                ],
            ],
            [
                'code' => 'ORD-2026-038',
                'client' => 'HMJ Manajemen UNS',
                'product' => 'Polo Katun CVC',
                'qty' => '85 pcs',
                'stage' => 4,
                'status' => 'Proses bordir emblem dada kiri',
                'confirmed' => 'Rina (CS 1) · @rina.cs1',
                'date' => '16 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-038', 'url' => '#'],
                'notes' => [],
            ],
            [
                'code' => 'ORD-2026-037',
                'client' => 'BEM Fakultas Teknik UGM',
                'product' => 'Korsa PDH Nagata Navy',
                'qty' => '350 pcs',
                'stage' => 5,
                'status' => 'Assembly jahit badan dan pemasangan kerah',
                'confirmed' => 'Owner · @owner.presma',
                'date' => '18 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-037', 'url' => '#'],
                'notes' => [
                    [
                        'by' => 'Tim Produksi',
                        'date' => '7 November 2026, 14.30',
                        'text' =>
                            'Proses jahit berjalan. Ada penyesuaian urutan pengerjaan karena bordir selesai lebih dahulu.',
                    ],
                    [
                        'by' => 'Rina (CS 1)',
                        'date' => '7 November 2026, 15.00',
                        'text' => 'Pelanggan meminta konfirmasi jadwal sebelum pengiriman.',
                    ],
                ],
            ],
            [
                'code' => 'ORD-2026-035',
                'client' => 'Komunitas Motor CB',
                'product' => 'Jaket Parasut Windbreaker',
                'qty' => '60 pcs',
                'stage' => 7,
                'status' => 'Barang selesai, menunggu pelunasan',
                'confirmed' => 'Rina (CS 1) · @rina.cs1',
                'date' => '9 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-035', 'url' => '#'],
                'notes' => [
                    [
                        'by' => 'Owner',
                        'date' => '7 November 2026, 09.10',
                        'text' => 'Mohon konfirmasi pelunasan sebelum barang diserahkan.',
                    ],
                ],
            ],
            [
                'code' => 'ORD-2026-034',
                'client' => 'Alumni Farmasi UII',
                'product' => 'Kaos Combed 30s',
                'qty' => '140 pcs',
                'stage' => 8,
                'status' => 'Lunas dan siap dikirim',
                'confirmed' => 'Fika (CS 2) · @fika.cs2',
                'date' => '7 November 2026',
                'wo' => ['label' => 'Lihat Work Order ORD-2026-034', 'url' => '#'],
                'notes' => [],
            ],
        ];
    @endphp
<div class="tracking-page">
        <section class="tracking-hero">
            <div class="tracking-hero-copy">
                <h1>Tracking Order</h1>
                <p>Pantau posisi pesanan dari konfirmasi awal hingga siap diambil atau dikirim.</p>
            </div>
            <div class="tracking-summary">
                <div><span
                        class="material-symbols-outlined">receipt_long</span><strong>{{ count($orders) }}</strong><small>Total
                        order contoh</small></div>
                <div><span
                        class="material-symbols-outlined">precision_manufacturing</span><strong>{{ collect($orders)->whereBetween('stage', [3, 6])->count() }}</strong><small>Dalam
                        produksi</small></div>
                <div><span
                        class="material-symbols-outlined">payments</span><strong>{{ collect($orders)->where('stage', 7)->count() }}</strong><small>Menunggu
                        pelunasan</small></div>
                <div><span
                        class="material-symbols-outlined">local_shipping</span><strong>{{ collect($orders)->where('stage', 8)->count() }}</strong><small>Siap
                        diserahkan</small></div>
            </div>
            <div class="tracking-tools">
                <label class="tracking-search"><span class="material-symbols-outlined">search</span><input
                        id="trackingSearch" type="search"
                        placeholder="Cari nomor order, pemesan, produk, atau akun CS..."></label>
                <select id="trackingFilter" aria-label="Filter tahapan">
                    <option value="all">Semua Tahapan</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage['id'] }}">{{ $stage['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </section>

        <section class="tracking-board-wrap">
            <div class="tracking-board-heading">
                <div>
                    <h2>Alur Pesanan</h2>
                    <p>Setiap stasiun dapat berisi beberapa order atau kosong.</p>
                </div><span class="tracking-scroll-hint"><span class="material-symbols-outlined">swipe</span> Geser
                    menyamping</span>
            </div>
            <div class="tracking-board" id="trackingBoard">
                @foreach ($stages as $stage)
                    <section class="tracking-column" data-stage="{{ $stage['id'] }}">
                        <header class="tracking-column-head">
                            <div class="tracking-stage-number">STASIUN {{ $stage['id'] }}</div>
                            <div class="tracking-team">{{ $stage['team'] }}</div>
                            <h3>{{ $stage['name'] }}</h3>
                            <p>{{ $stage['desc'] }}</p>
                            <span class="tracking-count">{{ collect($orders)->where('stage', $stage['id'])->count() }}
                                order</span>
                        </header>
                        <div class="tracking-card-list">
                            @forelse(collect($orders)->where('stage',$stage['id']) as $order)
                                <button type="button" class="tracking-order-card"
                                    data-order='@json($order)'>
                                    <span class="tracking-order-code">{{ $order['code'] }}</span>
                                    <strong class="tracking-client">{{ $order['client'] }}</strong>
                                    <span class="tracking-product">{{ $order['qty'] }} · {{ $order['product'] }}</span>
                                    <span class="tracking-order-status">{{ $order['status'] }}</span>
                                    <span class="tracking-confirmed"><small>Dikonfirmasi
                                            oleh</small><b>{{ $order['confirmed'] }}</b></span>
                                    <span class="tracking-card-open">Lihat detail <span
                                            class="material-symbols-outlined">arrow_forward</span></span>
                                </button>
                            @empty
                                <div class="tracking-column-empty"><span
                                        class="material-symbols-outlined">inbox</span><strong>Belum ada
                                        order</strong><small>Order akan muncul di sini saat memasuki tahap ini.</small>
                                </div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </div>
            <div class="tracking-no-results" id="trackingNoResults" hidden>Tidak ada order yang sesuai dengan pencarian atau
                filter.</div>
        </section>
    </div>

    <div class="tracking-modal" id="trackingDetailModal" aria-hidden="true">
        <div class="tracking-modal-backdrop" data-close-tracking></div>
        <section class="tracking-modal-panel" role="dialog" aria-modal="true" aria-labelledby="trackingModalTitle">
            <header class="tracking-modal-header">
                <div><small>INFORMASI PESANAN</small>
                    <h2 id="trackingModalTitle">Detail Tracking</h2>
                </div><button type="button" data-close-tracking aria-label="Tutup"><span
                        class="material-symbols-outlined">close</span></button>
            </header>
            <div class="tracking-modal-body">
                <div class="tracking-detail-code" id="detailCode">-</div>
                <div class="tracking-detail-grid">
                    <div><small>Nama Pemesan</small><strong id="detailClient">-</strong></div>
                    <div><small>Produk</small><strong id="detailProduct">-</strong></div>
                    <div><small>Jumlah</small><strong id="detailQty">-</strong></div>
                    <div><small>Tahapan Saat Ini</small><strong id="detailStage">-</strong></div>
                    <div><small>Status</small><strong id="detailStatus">-</strong></div>
                    <div><small>Target Selesai</small><strong id="detailDate">-</strong></div>
                    <div class="tracking-detail-wide"><small>Dikonfirmasi oleh</small><strong
                            id="detailConfirmed">-</strong></div>
                </div>
                <section class="tracking-detail-section">
                    <h3><span class="material-symbols-outlined">description</span> Work Order (WO)</h3>
                    <div id="detailWo" class="tracking-attachment">Belum ada file/link WO.</div>
                </section>
                <section class="tracking-detail-section">
                    <h3><span class="material-symbols-outlined">forum</span> Catatan Pesanan</h3>
                    <div id="detailNotes" class="tracking-notes">
                        <p class="tracking-no-note">Belum ada catatan untuk pesanan ini.</p>
                    </div>
                </section>
            </div>
            <footer class="tracking-modal-footer"><button type="button" data-close-tracking>Tutup</button></footer>
        </section>
    </div>
@endsection
