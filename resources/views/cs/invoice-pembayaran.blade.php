@extends('layout.cs')
@section('title', 'Invoice & Pembayaran | Presma Operations')

{{--
    Data awal halaman. Saat backend siap, kirim variabel $orders, $invoices, dan $payments
    dari controller dengan struktur yang sama; seluruh tampilan akan mengikuti data tersebut.
--}}
@php
    $orders = $orders ?? [
        [
            'id' => 'ORD-2026-029',
            'customer' => 'CV Karya Utama',
            'product' => 'Rompi Bordir',
            'qty' => 80,
            'spec' => 'Bordir',
        ],
        [
            'id' => 'ORD-2026-018',
            'customer' => 'BEM FT UGM',
            'product' => 'Korsa PDH',
            'qty' => 350,
            'spec' => 'Bordir',
        ],
        [
            'id' => 'ORD-2026-021',
            'customer' => 'Komunitas Sinema',
            'product' => 'Jaket Varsity',
            'qty' => 120,
            'spec' => 'Fleece',
        ],
        [
            'id' => 'ORD-2026-023',
            'customer' => 'PT Sinar Maju',
            'product' => 'Polo Shirt',
            'qty' => 200,
            'spec' => 'Bordir',
        ],
        [
            'id' => 'ORD-2026-025',
            'customer' => 'Himatek ITS',
            'product' => 'Rompi Lapangan',
            'qty' => 45,
            'spec' => 'Drill',
        ],
        [
            'id' => 'ORD-2026-027',
            'customer' => 'UKM Olahraga',
            'product' => 'Jersey',
            'qty' => 70,
            'spec' => 'Printing',
        ],
    ];

    $invoices = $invoices ?? [
        [
            'number' => 'INV-2026-001',
            'order_id' => 'ORD-2026-018',
            'date' => '2026-11-06',
            'description' => 'Pesanan korsa PDH BEM FT UGM',
            'items' => [
                ['name' => 'Korsa PDH', 'variant' => 'S – L', 'qty' => 200, 'price' => 135000],
                ['name' => 'Korsa PDH', 'variant' => 'XL – XXL', 'qty' => 150, 'price' => 154500],
            ],
        ],
        [
            'number' => 'INV-2026-002',
            'order_id' => 'ORD-2026-021',
            'date' => '2026-11-05',
            'description' => 'Pesanan jaket varsity fleece',
            'items' => [
                ['name' => 'Jaket Varsity Fleece', 'variant' => 'S – L', 'qty' => 80, 'price' => 170000],
                ['name' => 'Jaket Varsity Fleece', 'variant' => 'XL – XXL', 'qty' => 40, 'price' => 185000],
            ],
        ],
        [
            'number' => 'INV-2026-003',
            'order_id' => 'ORD-2026-023',
            'date' => '2026-11-04',
            'description' => 'Pesanan polo shirt bordir',
            'items' => [
                ['name' => 'Polo Shirt Bordir', 'variant' => 'S – L', 'qty' => 120, 'price' => 90000],
                ['name' => 'Polo Shirt Bordir', 'variant' => 'XL – XXL', 'qty' => 80, 'price' => 102500],
            ],
        ],
        [
            'number' => 'INV-2026-004',
            'order_id' => 'ORD-2026-025',
            'date' => '2026-11-03',
            'description' => 'Pesanan rompi lapangan',
            'items' => [['name' => 'Rompi Lapangan Drill', 'variant' => 'All Size', 'qty' => 45, 'price' => 135000]],
        ],
        [
            'number' => 'INV-2026-005',
            'order_id' => 'ORD-2026-027',
            'date' => '2026-11-02',
            'description' => 'Pesanan jersey printing',
            'items' => [
                ['name' => 'Jersey Printing', 'variant' => 'S – L', 'qty' => 50, 'price' => 90000],
                ['name' => 'Jersey Printing', 'variant' => 'XL – XXL', 'qty' => 20, 'price' => 95000],
            ],
        ],
    ];

    $payments = $payments ?? [
        [
            'invoice' => 'INV-2026-001',
            'date' => '2026-11-06',
            'time' => '14:15',
            'type' => 'DP',
            'amount' => 25087500,
            'method' => 'Transfer Bank',
            'by' => 'CS',
            'note' => '',
        ],
        [
            'invoice' => 'INV-2026-002',
            'date' => '2026-11-05',
            'time' => '16:40',
            'type' => 'DP',
            'amount' => 10500000,
            'method' => 'Transfer Bank',
            'by' => 'CS',
            'note' => '',
        ],
        [
            'invoice' => 'INV-2026-003',
            'date' => '2026-11-04',
            'time' => '11:20',
            'type' => 'PELUNASAN',
            'amount' => 19000000,
            'method' => 'Transfer Bank',
            'by' => 'CS',
            'note' => '',
        ],
        [
            'invoice' => 'INV-2026-005',
            'date' => '2026-11-02',
            'time' => '09:12',
            'type' => 'DP',
            'amount' => 3200000,
            'method' => 'QRIS',
            'by' => 'CS',
            'note' => '',
        ],
    ];

    $invoiceSeed = [
        'orders' => $orders,
        'invoices' => $invoices,
        'payments' => $payments,
        'currentCsName' => auth()->user()->name ?? 'Customer Service',
    ];
@endphp

@section('content')
    <main class="cs-invoice-page cs-wo-page">
        <div class="cs-invoice-stack cs-wo-stack">

            {{-- Judul halaman --}}
            <section class="invoice-heading">
                <div>
                    <span class="invoice-crumb">Customer Service / Invoice &amp; Pembayaran</span>
                    <h1>Invoice &amp; Payments</h1>
                    <p>Input harga per item, terbitkan invoice, lalu pantau DP dan pelunasan setiap pesanan.</p>
                </div>
                <div class="invoice-heading-actions">
                    <button type="button" class="invoice-btn invoice-btn-light" id="invoice-print">
                        <span class="material-symbols-outlined" aria-hidden="true">print</span> Cetak Rekap
                    </button>
                    <button type="button" class="invoice-btn invoice-btn-primary" id="invoice-create">
                        <span class="material-symbols-outlined" aria-hidden="true">add</span> Buat Invoice
                    </button>
                </div>
            </section>

            <div class="invoice-info-note">
                <span class="material-symbols-outlined" aria-hidden="true">info</span>
                <p><strong>Alur kerja:</strong> input harga item → buat dan cetak invoice → catat DP atau pelunasan setelah
                    bukti transfer diterima. Pastikan nominal dan pesanan sudah sesuai sebelum menyimpan.</p>
            </div>

            {{-- Ringkasan status --}}
            <section class="invoice-kpis" aria-label="Ringkasan status tagihan">
                <article class="invoice-kpi">
                    <div class="invoice-kpi-top"><span>Belum input harga</span><span class="invoice-kpi-icon is-red"><span
                                class="material-symbols-outlined" aria-hidden="true">edit_note</span></span></div>
                    <strong data-kpi="BELUM_HARGA">0</strong>
                    <small>Pesanan belum memiliki rincian harga</small>
                </article>
                <article class="invoice-kpi">
                    <div class="invoice-kpi-top"><span>Belum ada DP</span><span class="invoice-kpi-icon is-yellow"><span
                                class="material-symbols-outlined" aria-hidden="true">pending_actions</span></span></div>
                    <strong data-kpi="BELUM_BAYAR">0</strong>
                    <small>Invoice terbit, pembayaran belum masuk</small>
                </article>
                <article class="invoice-kpi">
                    <div class="invoice-kpi-top"><span>DP masuk</span><span class="invoice-kpi-icon is-blue"><span
                                class="material-symbols-outlined" aria-hidden="true">account_balance_wallet</span></span>
                    </div>
                    <strong data-kpi="DP">0</strong>
                    <small>Masih memiliki sisa tagihan</small>
                </article>
                <article class="invoice-kpi">
                    <div class="invoice-kpi-top"><span>Lunas</span><span class="invoice-kpi-icon is-green"><span
                                class="material-symbols-outlined" aria-hidden="true">verified</span></span></div>
                    <strong data-kpi="LUNAS">0</strong>
                    <small>Seluruh tagihan telah dibayar</small>
                </article>
            </section>

            {{-- Tab, pencarian, filter --}}
            <section class="invoice-toolbar">
                <div class="invoice-tabs" role="tablist" aria-label="Data invoice dan pembayaran">
                    <button type="button" class="invoice-tab is-active" data-tab="invoices" role="tab"
                        aria-selected="true" aria-controls="invoice-pane-invoices">Daftar Tagihan <span
                            class="invoice-tab-count" id="tab-count-invoices">0</span></button>
                    <button type="button" class="invoice-tab" data-tab="payments" role="tab" aria-selected="false"
                        aria-controls="invoice-pane-payments">Riwayat Pembayaran <span class="invoice-tab-count"
                            id="tab-count-payments">0</span></button>
                </div>
                <div class="invoice-tools">
                    <label class="invoice-search">
                        <span class="material-symbols-outlined" aria-hidden="true">search</span>
                        <input id="invoice-search" type="search" placeholder="Cari invoice, order, atau pemesan..."
                            aria-label="Cari data">
                    </label>
                    <select id="invoice-status-filter" class="invoice-select" aria-label="Filter status">
                        <option value="">Semua status</option>
                        <option value="BELUM_HARGA">Belum input harga</option>
                        <option value="BELUM_BAYAR">Belum ada DP</option>
                        <option value="DP">DP masuk</option>
                        <option value="LUNAS">Lunas</option>
                    </select>
                </div>
            </section>

            {{-- Daftar tagihan --}}
            <section class="invoice-panel" id="invoice-pane-invoices" role="tabpanel">
                <div class="invoice-panel-head">
                    <div><strong>Daftar Tagihan Pesanan</strong><span>Invoice dan ringkasan pembayaran per pesanan</span>
                    </div>
                    <span class="invoice-count" id="invoice-count">0 data</span>
                </div>
                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Nomor Invoice</th>
                                <th>Pemesan / ID Order</th>
                                <th>Produk</th>
                                <th class="text-right">Total Tagihan</th>
                                <th class="text-center">Dibayar</th>
                                <th class="text-center">Sisa Tagihan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-table-body"></tbody>
                    </table>
                    <div class="invoice-empty" id="invoice-empty" hidden>
                        <span class="material-symbols-outlined" aria-hidden="true">search_off</span>
                        <strong>Tidak ada data yang sesuai</strong>
                        <span>Ubah kata kunci atau filter status untuk melihat data lain.</span>
                    </div>
                </div>
                <div class="invoice-table-footer"><span id="invoice-visible-count"></span><span>Data pada halaman ini masih
                        berupa demo dan belum tersimpan ke database.</span></div>
            </section>

            {{-- Riwayat pembayaran --}}
            <section class="invoice-panel" id="invoice-pane-payments" role="tabpanel" hidden>
                <div class="invoice-panel-head">
                    <div><strong>Riwayat Pembayaran</strong><span>Catatan DP dan pelunasan yang telah dimasukkan CS</span>
                    </div>
                    <span class="invoice-count" id="payment-count">0 data</span>
                </div>
                <div class="invoice-table-wrap">
                    <table class="invoice-table payment-history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Invoice / Pemesan</th>
                                <th>Jenis</th>
                                <th class="text-right">Nominal</th>
                                <th>Metode</th>
                                <th>Dicatat Oleh</th>
                                <th class="text-center">Bukti Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="payment-history-body"></tbody>
                    </table>
                    <div class="invoice-empty" id="payment-empty" hidden>
                        <span class="material-symbols-outlined" aria-hidden="true">search_off</span>
                        <strong>Tidak ada pembayaran yang sesuai</strong>
                        <span>Ubah kata kunci pencarian untuk melihat data lain.</span>
                    </div>
                </div>
            </section>

            <section class="invoice-guidelines">
                <article>
                    <div class="guideline-title"><span class="material-symbols-outlined"
                            aria-hidden="true">rule</span><strong>Ketentuan pencatatan DP</strong></div>
                    <p>Catat DP setelah bukti pembayaran diterima dan nominalnya sesuai. Status pembayaran tidak boleh
                        diubah hanya berdasarkan konfirmasi lisan.</p>
                </article>
                <article>
                    <div class="guideline-title"><span class="material-symbols-outlined"
                            aria-hidden="true">receipt_long</span><strong>Ketentuan pelunasan</strong></div>
                    <p>Pelunasan dicatat sebesar sisa tagihan. Total pembayaran tidak boleh melebihi nilai invoice, dan
                        invoice berstatus lunas setelah pelunasan tercatat.</p>
                </article>
            </section>
        </div>
    </main>

    {{-- Data awal untuk JavaScript --}}
    <script type="application/json" id="invoice-seed">@json($invoiceSeed)</script>

    {{-- Modal: input harga & buat invoice --}}
    <div class="invoice-modal-backdrop" id="create-invoice-modal" hidden>
        <section class="invoice-modal invoice-editor-modal" role="dialog" aria-modal="true"
            aria-labelledby="create-invoice-title">
            <header>
                <div><span class="invoice-modal-eyebrow">Rincian harga pesanan</span>
                    <h2 id="create-invoice-title">Input Harga &amp; Buat Invoice</h2>
                </div>
                <button type="button" class="invoice-modal-close" data-close-modal aria-label="Tutup"><span
                        class="material-symbols-outlined" aria-hidden="true">close</span></button>
            </header>
            <form id="create-invoice-form" class="invoice-modal-form" novalidate>
                <div class="invoice-modal-body">
                    <div class="invoice-form-grid">
                        <label class="invoice-form-field invoice-form-full"><span>Pesanan / ID Order</span>
                            <select id="create-order" required></select>
                        </label>
                        <label class="invoice-form-field"><span>Nama pemesan</span><input id="create-customer"
                                type="text" readonly tabindex="-1"></label>
                        <label class="invoice-form-field"><span>Produk</span><input id="create-product" type="text"
                                readonly tabindex="-1"></label>
                        <label class="invoice-form-field"><span>Tanggal invoice</span><input id="create-date"
                                type="date" required></label>
                        <label class="invoice-form-field"><span>Keterangan</span><input id="create-description"
                                type="text" placeholder="Contoh: Pesanan seragam kerja" maxlength="120"></label>
                    </div>

                    <div class="invoice-cost-breakdown">
                        <div class="invoice-cost-heading">
                            <div><strong>Rincian item &amp; harga</strong><small>Tambah baris untuk setiap jenis item atau
                                    ukuran yang harganya berbeda.</small></div>
                            <span class="invoice-qty-hint" id="create-qty-hint" aria-live="polite"></span>
                        </div>
                        <div class="invoice-item-table-wrap">
                            <table class="invoice-item-table">
                                <thead>
                                    <tr>
                                        <th>Nama item</th>
                                        <th>Ukuran / varian</th>
                                        <th class="col-qty">Qty</th>
                                        <th class="col-price">Harga satuan (Rp)</th>
                                        <th class="col-sub text-right">Subtotal</th>
                                        <th class="col-del"><span class="sr-only">Hapus</span></th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-item-rows"></tbody>
                            </table>
                        </div>
                        <button type="button" class="invoice-add-item" id="invoice-add-item"><span
                                class="material-symbols-outlined" aria-hidden="true">add</span> Tambah item</button>
                    </div>

                    <div class="invoice-form-grid">
                        <label class="invoice-form-field"><span>Diskon (opsional)</span><input id="create-discount"
                                type="number" min="0" step="1" inputmode="numeric"
                                placeholder="0"></label>
                        <label class="invoice-form-field"><span>DP diterima (opsional)</span><input id="create-dp"
                                type="number" min="0" step="1" inputmode="numeric"
                                placeholder="0"></label>
                        <label class="invoice-form-field"><span>Metode DP</span>
                            <select id="create-dp-method" disabled>
                                <option>Transfer Bank</option>
                                <option>QRIS</option>
                                <option>Tunai</option>
                            </select>
                        </label>
                    </div>

                    <dl class="invoice-totals" aria-live="polite">
                        <div>
                            <dt>Subtotal</dt>
                            <dd id="subtotal-preview">Rp 0</dd>
                        </div>
                        <div>
                            <dt>Diskon</dt>
                            <dd id="discount-preview">Rp 0</dd>
                        </div>
                        <div>
                            <dt>Total tagihan</dt>
                            <dd id="total-preview">Rp 0</dd>
                        </div>
                        <div>
                            <dt>DP</dt>
                            <dd id="dp-preview">Rp 0</dd>
                        </div>
                        <div class="is-balance">
                            <dt>Sisa tagihan</dt>
                            <dd id="balance-preview">Rp 0</dd>
                        </div>
                    </dl>

                    <p class="invoice-form-error" id="create-error" role="alert" hidden></p>
                </div>
                <footer>
                    <button type="button" class="invoice-btn invoice-btn-light" data-close-modal>Batal</button>
                    <button type="submit" class="invoice-btn invoice-btn-primary">Buat &amp; Pratinjau Invoice</button>
                </footer>
            </form>
        </section>
    </div>

    {{-- Modal: catat pembayaran --}}
    <div class="invoice-modal-backdrop" id="payment-modal" hidden>
        <section class="invoice-modal" role="dialog" aria-modal="true" aria-labelledby="payment-modal-title">
            <header>
                <div><span class="invoice-modal-eyebrow">Pembayaran pesanan</span>
                    <h2 id="payment-modal-title">Catat Pembayaran</h2>
                </div>
                <button type="button" class="invoice-modal-close" data-close-modal aria-label="Tutup"><span
                        class="material-symbols-outlined" aria-hidden="true">close</span></button>
            </header>
            <form id="payment-form" class="invoice-modal-form" novalidate>
                <div class="invoice-modal-body">
                    <div class="invoice-form-grid">
                        <label class="invoice-form-field invoice-form-full"><span>Invoice / pemesan</span><select
                                id="payment-invoice" required></select></label>
                    </div>
                    <dl class="invoice-totals" id="payment-summary" aria-live="polite">
                        <div>
                            <dt>Total tagihan</dt>
                            <dd data-sum="total">Rp 0</dd>
                        </div>
                        <div>
                            <dt>Sudah dibayar</dt>
                            <dd data-sum="paid">Rp 0</dd>
                        </div>
                        <div class="is-balance">
                            <dt>Sisa tagihan</dt>
                            <dd data-sum="balance">Rp 0</dd>
                        </div>
                    </dl>
                    <div class="invoice-form-grid">
                        <label class="invoice-form-field"><span>Jenis pembayaran</span>
                            <select id="payment-type" required>
                                <option value="DP">DP</option>
                                <option value="PELUNASAN">Pelunasan</option>
                            </select>
                        </label>
                        <label class="invoice-form-field"><span>Nominal (Rp)</span><input id="payment-amount"
                                type="number" min="1" step="1" inputmode="numeric"
                                placeholder="Masukkan nominal" required><small class="invoice-field-hint"
                                id="payment-hint"></small></label>
                        <label class="invoice-form-field" id="payment-shipping-field" hidden><span>Biaya ongkir
                                (opsional)</span><input id="payment-shipping" type="number" min="0"
                                step="1" inputmode="numeric" placeholder="0"><small
                                class="invoice-field-hint">Ditambahkan ke total tagihan saat pelunasan.</small></label>
                        <label class="invoice-form-field"><span>Tanggal pembayaran</span><input id="payment-date"
                                type="date" required></label>
                        <label class="invoice-form-field"><span>Metode pembayaran</span>
                            <select id="payment-method" required>
                                <option value="">Pilih metode</option>
                                <option>Transfer Bank</option>
                                <option>QRIS</option>
                                <option>Tunai</option>
                            </select>
                        </label>
                        <label class="invoice-form-field invoice-form-full"><span>Bukti pembayaran (opsional)</span><input
                                id="payment-proof" type="file" accept=".jpg,.jpeg,.png,.pdf"></label>
                        <label class="invoice-form-field invoice-form-full"><span>Keterangan</span>
                            <textarea id="payment-note" rows="2" placeholder="Catatan verifikasi jika diperlukan" maxlength="200"></textarea>
                        </label>
                    </div>
                    <p class="invoice-form-error" id="payment-error" role="alert" hidden></p>
                </div>
                <footer>
                    <button type="button" class="invoice-btn invoice-btn-light" data-close-modal>Batal</button>
                    <button type="submit" class="invoice-btn invoice-btn-primary">Simpan Pembayaran</button>
                </footer>
            </form>
        </section>
    </div>

    {{-- Modal: detail invoice --}}
    <div class="invoice-modal-backdrop" id="invoice-detail-modal" hidden>
        <section class="invoice-modal invoice-detail-modal" role="dialog" aria-modal="true"
            aria-labelledby="invoice-detail-title">
            <header>
                <div><span class="invoice-modal-eyebrow">Rincian tagihan</span>
                    <h2 id="invoice-detail-title">Detail Invoice</h2>
                </div>
                <button type="button" class="invoice-modal-close" data-close-modal aria-label="Tutup"><span
                        class="material-symbols-outlined" aria-hidden="true">close</span></button>
            </header>
            <div class="invoice-modal-body" id="invoice-detail-content"></div>
            <footer>
                <button type="button" class="invoice-btn invoice-btn-light" data-close-modal>Tutup</button>
                <button type="button" class="invoice-btn invoice-btn-light" id="invoice-detail-pay"><span
                        class="material-symbols-outlined" aria-hidden="true">payments</span> Catat Pembayaran</button>
                <button type="button" class="invoice-btn invoice-btn-primary" id="invoice-detail-print"><span
                        class="material-symbols-outlined" aria-hidden="true">print</span> Cetak Invoice</button>
            </footer>
        </section>
    </div>

    {{-- Modal: pratinjau & cetak invoice --}}
    <div class="invoice-modal-backdrop" id="invoice-preview-modal" hidden>
        <section class="invoice-modal invoice-preview-shell" role="dialog" aria-modal="true"
            aria-labelledby="invoice-preview-title">
            <header>
                <div><span class="invoice-modal-eyebrow">Pratinjau dokumen</span>
                    <h2 id="invoice-preview-title">Invoice</h2>
                </div>
                <button type="button" class="invoice-modal-close" data-close-modal aria-label="Tutup"><span
                        class="material-symbols-outlined" aria-hidden="true">close</span></button>
            </header>
            <div class="invoice-modal-body invoice-preview-body">
                <div id="invoice-print-area" class="invoice-paper"></div>
            </div>
            <footer>
                <button type="button" class="invoice-btn invoice-btn-light" data-close-modal>Tutup</button>
                <button type="button" class="invoice-btn invoice-btn-primary" id="invoice-preview-print"><span
                        class="material-symbols-outlined" aria-hidden="true">print</span> Cetak Invoice</button>
            </footer>
        </section>
    </div>

    <div class="invoice-toast" id="invoice-toast" role="status" aria-live="polite"></div>
@endsection
