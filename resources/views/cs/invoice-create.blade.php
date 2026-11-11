@extends('layout.cs')
@section('title', 'Buat Invoice | Presma Operations')
@section('content')
    <main class="ip-page ip-form-page">
        <div class="ip-breadcrumb"><a href="{{ route('cs.invoice-pembayaran.preview') }}">Invoice &amp;
                Pembayaran</a><span>›</span> Buat Invoice</div>
        <div class="ip-heading">
            <div>
                <h1>Pembuatan Invoice</h1>
                <p>Buat tagihan berdasarkan pesanan yang telah disepakati dengan pelanggan.</p>
            </div>
            <a class="ip-btn ip-btn-outline" href="{{ route('cs.invoice-pembayaran.preview') }}">← Kembali</a>
        </div>

        <form class="ip-form-card" id="invoiceForm">
            <div class="ip-section-title"><span>01</span>
                <div>
                    <h2>Informasi Pesanan</h2>
                    <p>Pilih pesanan yang akan dibuatkan invoice.</p>
                </div>
            </div>
            <div class="ip-grid">
                <label class="ip-field ip-span-2">Pilih Kode Order <em>*</em>
                    <select id="orderSelect" required>
                        <option value="">Pilih kode order</option>
                        <option value="ORD-2026-0330" data-name="Farhan Saputra" data-instansi="BEM FT UGM"
                            data-product="Korsa PDH Nagata Drill" data-qty="50" data-price="110000">ORD-2026-0330 — Farhan
                            Saputra</option>
                        <option value="ORD-2026-0329" data-name="Rizky Aditya" data-instansi="HMM UGM"
                            data-product="Kaos Polo Lacoste CVC" data-qty="25" data-price="130000">ORD-2026-0329 — Rizky
                            Aditya</option>
                        <option value="ORD-2026-0328" data-name="Nadia Rahmawati" data-instansi="PT Citra Prima Nusantara"
                            data-product="Jaket Parka Taslan WP" data-qty="20" data-price="137500">ORD-2026-0328 — Nadia
                            Rahmawati</option>
                    </select>
                </label>
                <label class="ip-field">Nama Pemesan <input id="customerName" readonly
                        placeholder="Terisi setelah order dipilih"></label>
                <label class="ip-field">Instansi <input id="customerOrg" readonly
                        placeholder="Terisi setelah order dipilih"></label>
                <label class="ip-field ip-span-2">Deskripsi Produk
                    <textarea id="productDesc" rows="2" placeholder="Deskripsi produk / spesifikasi pesanan"></textarea>
                </label>
                <label class="ip-field">Jumlah Pesanan <input id="quantity" type="number" min="1" readonly></label>
                <label class="ip-field">Harga Satuan (Rp) <input id="unitPrice" type="number" min="0"
                        readonly></label>
            </div>
            <div class="ip-section-title ip-section-gap"><span>02</span>
                <div>
                    <h2>Rincian Tagihan</h2>
                    <p>Periksa nilai tagihan sebelum invoice diterbitkan.</p>
                </div>
            </div>
            <div class="ip-grid">
                <label class="ip-field">Nomor Invoice <input id="invoiceNumber" value="INV/PRS/2026/004" required></label>
                <label class="ip-field">Tanggal Invoice <input type="date" id="invoiceDate" value="2026-11-06"
                        required></label>
                <label class="ip-field">Diskon (Rp) <input type="number" id="discount" min="0"
                        value="0"></label>
                <label class="ip-field">Biaya Tambahan (Rp) <input type="number" id="extraCost" min="0"
                        value="0"></label>
            </div>
            <div class="ip-total-box"><span>Total Tagihan</span><strong id="grandTotal">Rp 0</strong><small>Jumlah × harga
                    satuan − diskon + biaya tambahan</small></div>
            <div class="ip-form-footer"><a class="ip-btn ip-btn-outline"
                    href="{{ route('cs.invoice-pembayaran.preview') }}">Batal</a><button class="ip-btn ip-btn-primary"
                    type="submit">Simpan Invoice</button></div>
            <p class="ip-demo-note" id="invoiceNotice">Mode tampilan frontend: data contoh belum disimpan ke database.</p>
        </form>
    </main>
@endsection
