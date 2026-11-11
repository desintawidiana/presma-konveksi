@extends('layout.cs')
@section('title', 'Detail Order | Presma Operations')
@section('content')
    <main class="cs-order-detail-page w-full min-w-0 px-5 lg:px-8 pt-20 pb-12">

        {{-- Halaman ini terhubung ke database: data dimuat oleh resources/js/cs/order-detail.js
             dari GET /api/pesanan/{id}. Alamat: /cs/order/detail?id=<id pesanan> --}}
        <div class="cs-review-toolbar">
            <a href="{{ route('cs.order') }}" class="cs-back-link"><span
                    class="material-symbols-outlined">arrow_back</span> Kembali ke Daftar Order</a>
            <div class="cs-review-toolbar-right">
                <button type="button" id="csOpenEdit" class="cs-review-btn cs-review-neutral" disabled><span
                        class="material-symbols-outlined">edit</span> Edit Pesanan</button>
                <button type="button" id="csOpenRevision" class="cs-review-btn cs-review-warning" disabled><span
                        class="material-symbols-outlined">chat</span> Hubungi Customer</button>
                <button type="button" id="csOpenCancel" class="cs-review-btn cs-review-neutral hidden"><span
                        class="material-symbols-outlined">cancel</span> Batalkan Order</button>
                <button type="button" id="csNextAction" class="cs-review-btn cs-review-primary hidden"><span
                        class="material-symbols-outlined">arrow_forward</span><span id="csNextActionText">Tahap
                        Berikutnya</span></button>
            </div>
        </div>
        <p id="csWorkflowStatus" class="cs-review-status" role="status">Memuat data order…</p>

        <div id="csOrderBody" class="space-y-5"></div>

        {{-- ========== MODAL: EDIT PESANAN ========== --}}
        <div id="csEditOrderModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csEditTitle">
            <div class="cs-workflow-dialog">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csEditTitle">Edit Data Pesanan</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <form id="csEditOrderForm" class="cs-workflow-form">
                    <p class="cs-edit-context" id="csEditContext">Perbarui informasi sesuai konfirmasi pelanggan.</p>
                    <div class="cs-edit-fields">
                        <label>Nama Pemesan <input name="customer" required maxlength="150"></label>
                        <label>Nomor WhatsApp <input name="phone" type="tel" required maxlength="20"></label>
                        <label>Instansi / Organisasi <input name="organization" maxlength="200"></label>
                        <label>Sumber Informasi
                            <select name="source">
                                <option value="">— belum diisi —</option>
                                <option value="INSTAGRAM">Instagram</option>
                                <option value="TIKTOK">TikTok</option>
                                <option value="FACEBOOK">Facebook</option>
                                <option value="IKLAN">Iklan</option>
                                <option value="REKOMENDASI_TEMAN">Rekomendasi Teman</option>
                                <option value="LAINNYA">Lainnya</option>
                            </select></label>
                        <label>Jenis Produk
                            <select name="product" required>
                                @foreach (['Korsa','Vest','Kaos','Polo','Jaket','Topi','Celana/Rok','Scrub','Makloon','Ganci','Lanyard','ID CARD','Jersey','Workshirt','Lainnya'] as $jenis)
                                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                                @endforeach
                            </select></label>
                        <label>Bahan Kain <input name="fabric" maxlength="150"></label>
                        <label>Warna Produk <input name="color" maxlength="100"></label>
                        <label>Target Deadline <input name="deadline" type="date"></label>
                        <label>Harga Satuan (Rp) <input name="unitPrice" type="number" min="0" step="500"></label>
                        <label>Model / Cutting <input name="cutting" maxlength="200"></label>
                        <label>Lengan
                            <select name="lengan">
                                <option value="">— tidak ada —</option>
                                <option value="PENDEK">Pendek</option>
                                <option value="PANJANG">Panjang</option>
                            </select></label>
                        <label>Desain
                            <select name="design">
                                <option value="DIBUATKAN_TIM">Dibuatkan tim Presma</option>
                                <option value="SUDAH_ADA_FILE">Pelanggan sudah punya file desain</option>
                            </select></label>
                        <label>Merchandise Tambahan <input name="merchandise"></label>
                        <label>Catatan Bordir / Sablon
                            <textarea name="embroidery" rows="2"
                                placeholder="Posisi, warna benang, nama bordir, logo..."></textarea></label>
                        <label>Keterangan Order <textarea name="notes" rows="2" maxlength="255"></textarea></label>
                        <fieldset class="cs-edit-flags">
                            <legend>Perlengkapan</legend>
                            <label><input type="checkbox" name="sablon"> Sablon</label>
                            <label><input type="checkbox" name="bordir"> Bordir</label>
                            <label><input type="checkbox" name="lanyard"> Lanyard</label>
                            <label><input type="checkbox" name="idcard"> ID Card</label>
                        </fieldset>
                        <fieldset id="csEditSizesGroup" class="cs-edit-sizes">
                            <legend>Rincian Ukuran (pcs)</legend>
                            <div class="cs-edit-size-grid" id="csEditSizeGrid"></div>
                            <small id="csEditSizeTotal"></small>
                        </fieldset>
                    </div>
                    <p class="cs-edit-hint hidden" id="csEditLockHint">Harga dan rincian ukuran dikunci karena invoice
                        sudah diterbitkan.</p>
                    <p class="text-error text-[13px] font-semibold hidden" id="csEditError" role="alert"></p>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-primary" id="csEditSubmit">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>

        {{-- ========== MODAL: HUBUNGI CUSTOMER / REVISI ========== --}}
        <div id="csRevisionModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csRevisionTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csRevisionTitle">Hubungi Customer</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <form id="csRevisionForm" class="cs-workflow-form">
                    <p>Tulis hal yang perlu dilengkapi atau direvisi pelanggan. Pesan dibuka di WhatsApp, dan
                        catatannya disimpan pada order.</p>
                    <label>Isi pesan / alasan revisi
                        <textarea name="reason" rows="4" required minlength="5"
                            placeholder="Contoh: Mohon lengkapi rincian ukuran dan kirim file logo."></textarea></label>
                    <p class="text-error text-[13px] font-semibold hidden" id="csRevisionError" role="alert"></p>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-primary">Simpan Catatan &amp; Buka WhatsApp</button></div>
                </form>
            </div>
        </div>

        {{-- ========== MODAL: LANGKAH ALUR (verifikasi, pembayaran, WO, pelunasan, serah terima, batal) ========== --}}
        <div id="csStageModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csStageTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csStageTitle">Lanjutkan Tahap Pesanan</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <form id="csStageForm" class="cs-workflow-form">
                    <p id="csStageDescription"></p>
                    <div id="csStageFields" class="cs-stage-options"></div>
                    <p class="text-error text-[13px] font-semibold hidden" id="csStageError" role="alert"></p>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-primary" id="csStageSubmit">Konfirmasi</button></div>
                </form>
            </div>
        </div>

        <div id="csDetailNotice" class="cs-detail-notice hidden" role="status" aria-live="polite"></div>
    </main>
@endsection
