@extends('layout.cs')
@section('title', 'Input Pembayaran | Presma Operations')
@section('content')
<main class="ip-page ip-form-page">
    <div class="ip-breadcrumb"><a href="{{ route('cs.invoice-pembayaran.preview') }}">Invoice &amp; Pembayaran</a><span>›</span> Input Pembayaran</div>
    <div class="ip-heading">
        <div><h1>Input Pembayaran</h1><p>Catat pembayaran DP atau pelunasan yang diterima dari pelanggan.</p></div>
        <a class="ip-btn ip-btn-outline" href="{{ route('cs.invoice-pembayaran.preview') }}">← Kembali</a>
    </div>
    <form class="ip-form-card" id="paymentForm">
        <div class="ip-section-title"><span>01</span><div><h2>Informasi Invoice</h2><p>Pilih invoice yang menjadi dasar pembayaran.</p></div></div>
        <div class="ip-grid">
            <label class="ip-field ip-span-2">Nomor Invoice <em>*</em>
                <select id="paymentInvoice" required><option value="">Pilih nomor invoice</option><option value="INV/PRS/2026/001" data-order="ORD-2026-0330" data-customer="Farhan Saputra" data-total="5500000" data-paid="2750000">INV/PRS/2026/001 — Farhan Saputra</option><option value="INV/PRS/2026/002" data-order="ORD-2026-0329" data-customer="Rizky Aditya" data-total="3250000" data-paid="0">INV/PRS/2026/002 — Rizky Aditya</option><option value="INV/PRS/2026/003" data-order="ORD-2026-0328" data-customer="Nadia Rahmawati" data-total="2750000" data-paid="2750000">INV/PRS/2026/003 — Nadia Rahmawati</option></select>
            </label>
            <label class="ip-field">Kode Order <input id="paymentOrder" readonly placeholder="Otomatis dari invoice"></label>
            <label class="ip-field">Nama Pemesan <input id="paymentCustomer" readonly placeholder="Otomatis dari invoice"></label>
        </div>
        <div class="ip-section-title ip-section-gap"><span>02</span><div><h2>Rincian Pembayaran</h2><p>Jenis pembayaran pada sistem terdiri dari DP dan pelunasan.</p></div></div>
        <div class="ip-grid">
            <label class="ip-field">Jenis Pembayaran <em>*</em><select id="paymentType" required><option value="">Pilih jenis pembayaran</option><option value="DP">DP</option><option value="PELUNASAN">Pelunasan</option></select></label>
            <label class="ip-field">Tanggal Pembayaran <em>*</em><input type="date" id="paymentDate" value="2026-11-06" required></label>
            <label class="ip-field">Nominal Pembayaran (Rp) <em>*</em><input type="number" id="paymentAmount" min="1" placeholder="Masukkan nominal" required></label>
            <label class="ip-field">Metode Pembayaran <em>*</em><select id="paymentMethod" required><option value="">Pilih metode</option><option>Transfer Bank</option><option>Tunai</option><option>QRIS</option></select></label>
            <label class="ip-field ip-span-2">Keterangan <textarea id="paymentNote" rows="3" placeholder="Catatan tambahan (opsional)"></textarea></label>
        </div>
        <div class="ip-payment-summary"><div><span>Total Invoice</span><b id="paymentTotal">Rp 0</b></div><div><span>Sudah Dibayar</span><b id="paymentPaid">Rp 0</b></div><div><span>Sisa Tagihan</span><b id="paymentRemaining">Rp 0</b></div></div>
        <div class="ip-form-footer"><a class="ip-btn ip-btn-outline" href="{{ route('cs.invoice-pembayaran.preview') }}">Batal</a><button class="ip-btn ip-btn-primary" type="submit">Simpan Pembayaran</button></div>
        <p class="ip-demo-note" id="paymentNotice">Mode tampilan frontend: data contoh belum disimpan ke database.</p>
    </form>
</main>
@endsection
