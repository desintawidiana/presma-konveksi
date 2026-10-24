@extends('layout.cs')
@section('title', 'Detail Order | Presma Operations')
@section('content')
    <main class="cs-order-detail-page w-full min-w-0 px-5 lg:px-8 pt-20 pb-12">

        <div class="cs-review-toolbar">
            <a href="{{ route('cs.order.preview') }}" class="cs-back-link"><span
                    class="material-symbols-outlined">arrow_back</span> Kembali ke Daftar Order</a>
            <div class="cs-review-toolbar-right">
                <button type="button" id="csOpenEdit" class="cs-review-btn cs-review-neutral"><span
                        class="material-symbols-outlined">edit</span> Edit Pesanan</button>
                <button type="button" id="csOpenRevision" class="cs-review-btn cs-review-warning"><span
                        class="material-symbols-outlined">chat</span> Kembalikan / Hubungi Customer</button>
                <button type="button" id="csOpenVerify" class="cs-review-btn cs-review-primary"><span
                        class="material-symbols-outlined">verified</span> Verifikasi &amp; Fiksasi Pesanan</button>
                <button type="button" id="csNextAction" class="cs-review-btn cs-review-primary hidden"><span
                        class="material-symbols-outlined">arrow_forward</span><span id="csNextActionText">Tahap
                        Berikutnya</span></button>
            </div>
        </div>
        <p id="csWorkflowStatus" class="cs-review-status" role="status">Status: Belum diverifikasi. Tindakan di halaman ini
            merupakan simulasi frontend.</p>
        <section id="csDynamicOrder" class="hidden cs-detail-generic" aria-label="Ringkasan order terpilih">
            <div class="cs-detail-generic-head">
                <div>
                    <p class="cs-detail-eyebrow">DETAIL PESANAN PELANGGAN</p>
                    <h1 id="genericCode">Detail Pesanan</h1>
                    <p id="genericCustomer">Nama pelanggan</p>
                </div>
                <span id="genericStage" class="cs-detail-stage">Status pesanan</span>
            </div>
            <div class="cs-detail-info-grid">
                <article><small>Nama produk</small><strong id="genericProduct">-</strong></article>
                <article><small>Instansi</small><strong id="genericOrg">-</strong></article>
                <article><small>Tanggal masuk</small><strong id="genericDate">-</strong></article>
                <article><small>Target deadline</small><strong id="genericDeadline">Belum ditentukan</strong></article>
                <article><small>Penanggung jawab</small><strong id="genericOwner">-</strong></article>
                <article><small>Status pembayaran</small><strong id="genericPayment">-</strong></article>
                <article><small>Nilai order</small><strong id="genericAmount">-</strong></article>
            </div>
            <section class="cs-detail-generic-card">
                <h2>Hasil Form Pesanan Pelanggan</h2>
                <p id="genericNote">Rincian form (ukuran, kain, bordir, dan lampiran) belum tersedia untuk contoh order ini.
                    Data yang ada pada tabel tetap ditampilkan di atas.</p>
            </section>
        </section>
        <div id="csExampleOrder" class="space-y-5">
            <section class="bg-white rounded-xl px-5 py-5 border border-[#e1e3e3] shadow-sm">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <span class="rounded-full bg-amber-50 text-amber-900 text-xs font-semibold px-3 py-1">Menunggu
                        Verifikasi CS</span>
                    <span class="text-xs text-[#635d5e]">24 Okt 2024 • ORD-2024-0330</span>
                </div>
                <h1 class="text-2xl font-bold text-[#191c1c]">Detail Pesanan Pelanggan</h1>
                <p class="cs-order-deadline"><span class="material-symbols-outlined">event</span> Target Deadline: <strong
                        id="csDetailDeadline">Belum ditentukan</strong></p>
                <p class="text-sm mt-2 text-[#59413e]">Farhan Saputra • BEM Fakultas Teknik UGM • Korsa PDH Nagata Drill,
                    350 pcs</p>
            </section>
            <section class="bg-white rounded-xl p-5 lg:p-6 border border-[#e1e3e3] shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-[#e1e3e3]">
                    <div class="w-10 h-10 rounded-lg bg-[#830909] text-white flex justify-center items-center">
                        <span class="material-symbols-outlined">assignment</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-[#191c1c]">Hasil Form Pesanan Pelanggan</h2>
                        <p class="text-xs text-[#635d5e]">Rincian data contoh dari desain Stitch</p>
                    </div>
                </div>
                <!-- 5 Card Rinci Form Pelanggan -->
                <div class="space-y-4">
                    <!-- 1. Identitas & Kontak -->
                    <div class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
                        <div
                            class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[19px]">person</span>
                                <span class="text-xs font-bold text-on-surface uppercase tracking-wide">1. Identitas &amp;
                                    Kontak Pemesan</span>
                            </div>
                            <button type="button" class="cs-section-edit" data-cs-edit-section="identity"><span
                                    class="material-symbols-outlined">edit</span> Edit</button>
                            <span
                                class="text-[11px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Terverifikasi</span>
                        </div>
                        <div class="cs-form-changes hidden" data-cs-changes="identity" aria-live="polite"></div>
                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs">
                            <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container">
                                <span class="text-on-surface-variant block text-[11px]">Nama Lengkap Pemesan:</span>
                                <strong class="text-on-surface text-sm block mt-0.5">Farhan Saputra</strong>
                            </div>
                            <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container">
                                <span class="text-on-surface-variant block text-[11px]">No. WhatsApp / HP:</span>
                                <strong class="text-primary font-mono text-sm block mt-0.5">0812-2891-7890</strong>
                            </div>
                            <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container">
                                <span class="text-on-surface-variant block text-[11px]">Instansi / Kampus / Sekolah:</span>
                                <strong class="text-on-surface text-xs block mt-0.5">BEM Fakultas Teknik Universitas Gadjah
                                    Mada (UGM)</strong>
                            </div>
                            <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container">
                                <span class="text-on-surface-variant block text-[11px]">Sumber Informasi Tau Presma:</span>
                                <span class="text-on-surface font-semibold text-xs block mt-0.5">Instagram
                                    (@presmakonveksi)</span>
                            </div>
                        </div>
                    </div>
                    <!-- 2. Spesifikasi Produk, Kain & Warna -->
                    <div class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
                        <div
                            class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[19px]">checkroom</span>
                                <span class="text-xs font-bold text-on-surface uppercase tracking-wide">2. Spesifikasi
                                    Produk, Kain &amp; Warna</span>
                            </div>
                            <button type="button" class="cs-section-edit" data-cs-edit-section="specification"><span
                                    class="material-symbols-outlined">edit</span> Edit</button>
                            <span class="text-[11px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Garment
                                Grade A</span>
                        </div>
                        <div class="cs-form-changes hidden" data-cs-changes="specification" aria-live="polite"></div>
                        <div class="p-4 text-xs flex flex-col gap-3.5">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container"><span
                                        class="text-on-surface-variant block text-[11px]">Jenis Produk:</span><strong
                                        class="text-on-surface text-xs block mt-0.5">Korsa / PDH / PDL Lapangan</strong>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container"><span
                                        class="text-on-surface-variant block text-[11px]">Bahan Baku Kain:</span><strong
                                        class="text-on-surface text-xs block mt-0.5">Nagata Drill Grade A Original</strong>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container"><span
                                        class="text-on-surface-variant block text-[11px]">Warna Produk:</span><strong
                                        class="text-on-surface text-xs block mt-0.5">Khaki Sand kombinasi Navy Tua (Kerah
                                        &amp; Manset)</strong></div>
                            </div>
                            <div
                                class="p-3 bg-surface-container-low rounded-lg border border-surface-container flex flex-col gap-2">
                                <span
                                    class="text-on-surface-variant text-[11px] font-semibold uppercase tracking-wider">Fitur
                                    Model &amp; Cuttingan:</span>
                                <div class="flex flex-wrap gap-2"><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">Lengan
                                        Panjang</span><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">Regular
                                        Fit Standard</span><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">Manset
                                        Kancing 2</span><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">Placket
                                        Tertutup Kancing Dalam</span><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">Roll-up
                                        Strap Kancing Siku</span><span
                                        class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface text-xs font-semibold ring-1 ring-outline-variant/30">2
                                        Saku Dada Tutup Lipat Runcing 45° + Slot Pulpen</span></div>
                            </div>
                        </div>
                    </div>
                    <!-- 3. Detail Bordir Komputer & Merchandise Bundling -->
                    <div class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
                        <div
                            class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[19px]">stylus_note</span>
                                <span class="text-xs font-bold text-on-surface uppercase tracking-wide">3. Detail Bordir
                                    Komputer &amp; Merchandise Bundling</span>
                            </div>
                            <button type="button" class="cs-section-edit" data-cs-edit-section="embroidery"><span
                                    class="material-symbols-outlined">edit</span> Edit</button>
                            <span
                                class="text-[11px] bg-tertiary-fixed text-on-tertiary-fixed-variant px-2 py-0.5 rounded font-bold">4
                                Titik Bordir HD</span>
                        </div>
                        <div class="cs-form-changes hidden" data-cs-changes="embroidery" aria-live="polite"></div>
                        <div class="p-4 text-xs flex flex-col gap-3.5">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div
                                    class="p-3.5 bg-surface-container-low rounded-lg border border-surface-container flex flex-col gap-2">
                                    <div class="flex items-center gap-1.5 text-primary font-bold text-xs"><span
                                            class="material-symbols-outlined text-[17px]">format_list_bulleted</span><span
                                            class="">1. Catatan Posisi Bordir</span></div>
                                    <ul class="space-y-1.5 text-xs text-on-surface">
                                        <li class="leading-relaxed"><strong class="text-primary">Dada Kiri:</strong> Logo
                                            BEM FT UGM (benang timbul padat)</li>
                                        <li class="leading-relaxed"><strong class="text-primary">Dada Kanan:</strong> Nama
                                            Personil (Font Sans Serif Tegak)</li>
                                        <li class="leading-relaxed"><strong class="text-primary">Punggung:</strong>
                                            Tulisan melengkung "TEKNIK UGM"</li>
                                        <li class="leading-relaxed"><strong class="text-primary">Lengan:</strong> Bendera
                                            Merah Putih (7 × 4 cm)</li>
                                    </ul>
                                </div>
                                <div
                                    class="p-3.5 bg-surface-container-low rounded-lg border border-surface-container flex flex-col gap-2">
                                    <div class="flex items-center gap-1.5 text-tertiary font-bold text-xs"><span
                                            class="material-symbols-outlined text-[17px]">card_membership</span><span
                                            class="">2. Catatan Merchandise Bundling</span></div>
                                    <p class="text-xs text-on-surface leading-relaxed">Paket Lanyard Full Print 2 cm double
                                        side + ID Card PVC cetak 2 sisi (sesuai kuantitas 350 pcs / set lengkap kait besi
                                        putar).</p>
                                </div>
                                <div
                                    class="p-3.5 bg-surface-container-low rounded-lg border border-surface-container flex flex-col gap-2">
                                    <div class="flex items-center gap-1.5 text-amber-800 font-bold text-xs"><span
                                            class="material-symbols-outlined text-[17px]">edit_note</span><span
                                            class="">3. Catatan Khusus Pelanggan</span></div>
                                    <p class="text-xs text-on-surface-variant italic leading-relaxed">"Benang bordir senada
                                        kain Sand Nagata, font punggung sesuai pedoman kampus FT UGM. Jahit rantai ganda
                                        kuat. Deadline wajib sampai 05 November."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 4. Distribusi Ukuran -->
                    <div class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
                        <div
                            class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                            <div class="flex items-center gap-2"><span
                                    class="material-symbols-outlined text-primary text-[19px]">straighten</span><span
                                    class="text-xs font-bold text-on-surface uppercase tracking-wide">4. Distribusi
                                    Ukuran</span></div>
                            <div class="flex items-center gap-2"><button type="button" class="cs-section-edit"
                                    data-cs-edit-section="sizes"><span class="material-symbols-outlined">edit</span>
                                    Edit</button>
                                <span
                                    class="text-[11px] bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded font-bold">Total:
                                    350 Pcs</span>
                            </div>
                        </div>
                        <div class="cs-form-changes hidden" data-cs-changes="sizes" aria-live="polite"></div>
                        <div class="p-4 text-xs flex flex-col gap-3">
                            <div class="cs-size-toolbar"><button type="button" id="csOpenSizes"
                                    class="cs-review-btn cs-review-neutral"><span
                                        class="material-symbols-outlined">table_view</span> Lihat Detail Ukuran
                                    (Excel)</button><span>Rekap ukuran contoh, belum ada daftar nama per orang.</span></div>
                            <div class="grid grid-cols-2 sm:grid-cols-6 gap-2 text-center">
                                <div class="p-2.5 bg-surface-container-low rounded-lg border border-surface-container">
                                    <span class="text-[11px] text-on-surface-variant block font-bold">S</span>
                                    <span class="text-lg font-extrabold text-on-surface font-mono">45</span>
                                    <span class="text-[10px] text-on-surface-variant block">Standar</span>
                                </div>
                                <div class="p-2.5 bg-surface-container-low rounded-lg border border-surface-container">
                                    <span class="text-[11px] text-on-surface-variant block font-bold">M</span>
                                    <span class="text-lg font-extrabold text-on-surface font-mono">120</span>
                                    <span class="text-[10px] text-on-surface-variant block">Standar</span>
                                </div>
                                <div class="p-2.5 bg-surface-container-low rounded-lg border border-surface-container">
                                    <span class="text-[11px] text-on-surface-variant block font-bold">L</span>
                                    <span class="text-lg font-extrabold text-on-surface font-mono">110</span>
                                    <span class="text-[10px] text-on-surface-variant block">Standar</span>
                                </div>
                                <div class="p-2.5 bg-surface-container-low rounded-lg border border-surface-container">
                                    <span class="text-[11px] text-on-surface-variant block font-bold">XL</span>
                                    <span class="text-lg font-extrabold text-on-surface font-mono">50</span>
                                    <span class="text-[10px] text-on-surface-variant block">Standar</span>
                                </div>
                                <div class="p-2.5 bg-amber-50 rounded-lg border border-amber-200">
                                    <span class="text-[11px] text-amber-800 block font-bold">2XL</span>
                                    <span class="text-lg font-extrabold text-amber-900 font-mono">15</span>
                                    <span class="text-[10px] text-amber-700 block">+Rp 10k (Jumbo)</span>
                                </div>
                                <div class="p-2.5 bg-amber-50 rounded-lg border border-amber-200">
                                    <span class="text-[11px] text-amber-800 block font-bold">3XL</span>
                                    <span class="text-lg font-extrabold text-amber-900 font-mono">10</span>
                                    <span class="text-[10px] text-amber-700 block">+Rp 10k (Jumbo)</span>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-between text-xs pt-2.5 border-t border-surface-container text-on-surface-variant">
                                <span class="">Standar (S - XL): <strong class="text-on-surface font-mono">325
                                        pcs</strong></span>
                                <span class="">Jumbo (2XL - 3XL): <strong class="text-amber-800 font-mono">25
                                        pcs</strong></span>
                                <span class="">Total Akumulasi: <strong
                                        class="text-primary font-mono font-bold text-sm">350 pcs</strong></span>
                            </div>
                        </div>
                    </div>
                    <!-- 5. Lampiran Berkas Desain Pelanggan -->
                    <div class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
                        <div
                            class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[19px]">folder_zip</span>
                                <span class="text-xs font-bold text-on-surface uppercase tracking-wide">5. Berkas Desain
                                    &amp; Lampiran Pelanggan</span>
                            </div>
                            <button type="button" class="cs-section-edit" data-cs-edit-section="attachments"><span
                                    class="material-symbols-outlined">edit</span> Edit</button>
                            <span
                                class="text-[11px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-bold">Lampiran
                                Terverifikasi</span>
                        </div>
                        <div class="cs-form-changes hidden" data-cs-changes="attachments" aria-live="polite"></div>
                        <div class="p-4 text-xs flex flex-col gap-3.5">
                            <div
                                class="p-3.5 rounded-lg bg-surface-container-low border border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-amber-100 text-amber-900 flex items-center justify-center shrink-0 border border-amber-300">
                                        <span class="material-symbols-outlined text-[24px]">folder_zip</span>
                                    </div>
                                    <div class="min-w-0 flex flex-col gap-0.5">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span
                                                class="font-bold text-on-surface text-xs truncate">Paket-Desain-BEM-FT-UGM.zip</span>
                                            <span
                                                class="text-[10px] bg-primary-fixed text-on-primary-fixed font-semibold px-2 py-0.2 rounded">Paket
                                                File Tunggal (.ZIP)</span>
                                        </div>
                                        <span class="text-[11px] text-on-surface-variant font-mono">38.4 MB • Berisi:
                                            Mockup Vector, Logo Master AI &amp; CDR, Font Guideline</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-detail-action="preview"
                                        class="cs-detail-action-button"><span
                                            class="material-symbols-outlined text-[17px]">visibility</span>
                                        Pratinjau</button>
                                    <button type="button" data-detail-action="zip"
                                        class="cs-detail-action-button cs-detail-accent"><span
                                            class="material-symbols-outlined text-[17px]">download</span> Unduh Berkas
                                        (.ZIP)</button>
                                </div>
                            </div>
                            <div
                                class="p-3.5 rounded-lg bg-surface-container-low border border-surface-container flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-start gap-3 min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant flex items-center justify-center shrink-0 border border-tertiary-fixed-dim">
                                        <span class="material-symbols-outlined text-[24px]">cloud_done</span>
                                    </div>
                                    <div class="min-w-0 flex flex-col gap-0.5">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-bold text-on-surface text-xs truncate">Tautan Cloud Storage /
                                                Drive Pelanggan</span>
                                            <span
                                                class="text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-200 font-semibold px-2 py-0.2 rounded flex items-center gap-1"><span
                                                    class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Akses
                                                Terbuka</span>
                                        </div>
                                        <span
                                            class="text-[11px] text-tertiary font-mono truncate">drive.google.com/drive/folders/1aBcDeFgHiJkLmNoP...
                                            (Folder BEM FT UGM)</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-detail-action="copy"
                                        class="cs-detail-action-button"><span
                                            class="material-symbols-outlined text-[17px]">content_copy</span> Salin
                                        Tautan</button>
                                    <button type="button" data-detail-action="drive"
                                        class="cs-detail-action-button cs-detail-link"><span
                                            class="material-symbols-outlined text-[17px]">open_in_new</span> Buka Link
                                        Drive / Folder</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cs-detail-footer-actions">
                    <span class="cs-detail-verified"><span
                            class="material-symbols-outlined text-[18px]">check_circle</span> Semua data contoh formulir
                        telah ditampilkan</span>
                    <div class="cs-detail-footer-buttons">
                        <button type="button" data-detail-action="print" class="cs-detail-action-button"><span
                                class="material-symbols-outlined text-[17px]">download</span> Download Form Lengkap untuk
                            Desainer (.PDF)</button>

                    </div>
                </div>
            </section>
        </div>
        <div id="csDetailPreviewModal" class="cs-detail-preview-overlay hidden" role="dialog" aria-modal="true"
            aria-label="Pratinjau lampiran desain">
            <div class="cs-detail-preview-box">
                <div class="cs-detail-preview-head"><strong>Pratinjau Lampiran Desain</strong><button type="button"
                        data-detail-action="close-preview" aria-label="Tutup pratinjau">✕</button></div>
                <div class="cs-detail-preview-content"><span
                        class="material-symbols-outlined text-[48px]">folder_zip</span><strong>Paket-Desain-BEM-FT-UGM.zip</strong>
                    <p>Contoh berkas ZIP dari desain Stitch. Pratinjau isi file asli belum tersedia karena file belum
                        diunggah ke proyek.</p>
                </div>
            </div>
        </div>

        <div id="csEditOrderModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csEditTitle">
            <div class="cs-workflow-dialog">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csEditTitle">Edit Data Pesanan</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <form id="csEditOrderForm" class="cs-workflow-form">
                    <p class="cs-edit-context" id="csEditContext">Perbarui informasi sesuai hasil konfirmasi pelanggan.
                    </p>
                    <div class="cs-edit-fields">
                        <label>Nama Pemesan <input name="customer" required maxlength="120"></label>
                        <label>Nomor WhatsApp <input name="phone" type="tel" placeholder="08..."
                                maxlength="25"></label>
                        <label>Instansi / Organisasi <input name="organization" maxlength="160"></label>
                        <label>Jenis Produk <input name="product" required maxlength="160"></label>
                        <label>Bahan Kain <input name="fabric" maxlength="160"></label>
                        <label>Warna Produk <input name="color" maxlength="160"></label>
                        <label>Target Deadline <input name="deadline" type="date"></label>
                        <label>Kategori Produk <select name="category">
                                <option value="korsa">Korsa / PDH / PDL</option>
                                <option value="jaket">Jaket / Rompi</option>
                                <option value="kaos">Kaos / Polo</option>
                                <option value="other">Lainnya</option>
                            </select></label>
                        <label>Penanggung Jawab CS <input name="owner" maxlength="120"
                                placeholder="Nama PIC internal"></label>
                        <label>Asal Informasi <input name="source" maxlength="150"
                                placeholder="Instagram / Website / Referral"></label>
                        <label>Model / Cutting <input name="cutting" maxlength="240"
                                placeholder="Regular fit, lengan panjang, detail saku..."></label>
                        <label>Detail Bordir / Sablon
                            <textarea name="embroidery" rows="2" placeholder="Posisi, warna benang, nama bordir, logo..."></textarea>
                        </label>
                        <label>Merchandise Tambahan <input name="merchandise" maxlength="240"
                                placeholder="Lanyard, ID card, dll."></label>
                        <label>Alamat Pengiriman
                            <textarea name="address" rows="2" placeholder="Alamat penerima dan kota"></textarea>
                        </label>
                        <label>Link Berkas Desain (URL) <input name="designUrl" type="url"
                                placeholder="https://..."></label>
                        <label>Link Excel Nama & Ukuran (URL) <input name="sizeFileUrl" type="url"
                                placeholder="https://..."></label>
                        <label>Kuantitas (pcs) <input name="quantity" type="number" min="1" required></label>
                    </div>
                    <fieldset id="csEditSizesGroup" class="cs-edit-sizes">
                        <legend>Distribusi Ukuran (Order Contoh Farhan)</legend>
                        <div class="cs-edit-size-grid">
                            <label>S <input name="sizeS" type="number" min="0"></label><label>M <input
                                    name="sizeM" type="number" min="0"></label><label>L <input name="sizeL"
                                    type="number" min="0"></label>
                            <label>XL <input name="sizeXL" type="number" min="0"></label><label>2XL <input
                                    name="size2XL" type="number" min="0"></label><label>3XL <input
                                    name="size3XL" type="number" min="0"></label>
                        </div><small id="csEditSizeTotal"></small>
                    </fieldset>
                    <label>Catatan Revisi CS
                        <textarea name="notes" rows="3" placeholder="Jelaskan perubahan berdasarkan konfirmasi pelanggan"></textarea>
                    </label>
                    <p class="cs-edit-hint">Perubahan disimpan dalam browser pada sesi pratinjau. Tidak mengubah database
                        maupun harga invoice.</p>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-primary">Simpan Perubahan</button></div>
                </form>
            </div>
        </div>
        <div id="csRevisionModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csRevisionTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csRevisionTitle">Kembalikan Pesanan untuk Revisi</h2><button type="button"
                        data-workflow-close aria-label="Tutup">✕</button>
                </div>
                <form id="csRevisionForm" class="cs-workflow-form">
                    <p>Catat kesalahan atau data yang perlu dikonfirmasi ke pelanggan. Status akan berubah menjadi
                        <strong>Perlu Revisi Pelanggan</strong>.</p>
                    <label>Catatan Permintaan Revisi
                        <textarea name="reason" rows="4" required minlength="5"
                            placeholder="Contoh: Mohon konfirmasi ulang jumlah size XL dan file logo bordir..."></textarea>
                    </label>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-warning">Tandai Perlu Revisi</button></div>
                    <button type="button" id="csCopyRevision" class="cs-review-btn cs-review-neutral">Salin Draft Pesan
                        WhatsApp</button>
                </form>
            </div>
        </div>
        <div id="csVerifyModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csVerifyTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csVerifyTitle">Konfirmasi Fiksasi Pesanan</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <div class="cs-workflow-form">
                    <p>Pastikan data pelanggan, produk, ukuran, dan lampiran sudah benar. Aksi ini <strong>hanya memperbarui
                            status pratinjau</strong>, tidak menerbitkan invoice atau work order.</p>
                    <label class="cs-confirm-check"><input id="csVerifyCheck" type="checkbox"> Saya telah memeriksa dan
                        mengonfirmasi data pesanan.</label>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="button"
                            id="csConfirmVerify" class="cs-review-btn cs-review-primary" disabled>Fiksasi Pesanan</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="csStageModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csStageTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csStageTitle">Lanjutkan Tahap Pesanan</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <form id="csStageForm" class="cs-workflow-form">
                    <p id="csStageDescription">Konfirmasi tahap berikutnya untuk pratinjau.</p>
                    <div id="csPaymentSection" class="cs-stage-options hidden">
                        <label>Metode kelanjutan
                            <select name="paymentChoice" id="csPaymentChoice">
                                <option value="dp">DP telah diterima dan diverifikasi</option>
                                <option value="without_dp">Tanpa DP, berdasarkan persetujuan khusus / Surat PO</option>
                            </select>
                        </label>
                        <label id="csDpReferenceLabel">Nominal DP Diterima (Rp) <input name="dpAmount" type="number"
                                min="1" placeholder="Contoh: 10000000"></label>
                        <label id="csPoReasonLabel" class="hidden">Alasan pengecualian DP / Nomor PO
                            <textarea name="poReason" rows="3" placeholder="Contoh: PO-015/2026, disetujui Owner pada tanggal..."></textarea>
                        </label>
                    </div>
                    <div id="csWoSection" class="hidden cs-stage-options">
                        <label>Nomor Work Order <input name="woNumber" placeholder="WO-2026-0001" maxlength="70"></label>
                        <label>Penanggung Jawab Produksi <input name="designer" maxlength="100"
                                placeholder="Nama desainer/PIC produksi"></label>
                    </div>
                    <div id="csTrackingSection" class="hidden cs-stage-options">
                        <label>Progres Produksi <select name="trackingProgress">
                                <option value="Persiapan Bahan">Persiapan Bahan</option>
                                <option value="Cutting / Pola">Cutting / Pola</option>
                                <option value="Bordir / Sablon">Bordir / Sablon</option>
                                <option value="Proses Jahit">Proses Jahit</option>
                                <option value="Finishing / QC">Finishing / QC</option>
                                <option value="Siap Kirim (QC Selesai)">Siap Kirim (QC Selesai)</option>
                            </select></label>
                        <label>Catatan Progres
                            <textarea name="trackingNote" rows="2" placeholder="Update dari tim produksi"></textarea>
                        </label>
                    </div>
                    <div id="csSettlementSection" class="hidden cs-stage-options">
                        <p><strong>Pelunasan Akhir</strong> — Pesanan dengan pengecualian DP wajib membayar penuh. Untuk
                            order dengan DP, validasi sisa tagihan.</p>
                        <label>Nominal Pelunasan Diterima (Rp) <input name="settlementAmount" type="number"
                                min="1" placeholder="Nominal yang benar-benar diterima"></label>
                        <label>Referensi / Bukti Pembayaran <input name="settlementReference" maxlength="120"
                                placeholder="Nomor transfer atau bukti pembayaran"></label>
                    </div>
                    <div id="csReadySection" class="hidden cs-stage-options">
                        <label>Metode Penyerahan <select name="deliveryMethod">
                                <option value="">Pilih metode</option>
                                <option value="Ekspedisi">Ekspedisi</option>
                                <option value="Diambil Pelanggan">Diambil pelanggan</option>
                                <option value="Kurir Internal">Kurir internal</option>
                            </select></label>
                        <label>Resi / Keterangan Penyerahan
                            <textarea name="deliveryNote" rows="2" placeholder="Rencana pengiriman, resi, atau lokasi pengambilan"></textarea>
                        </label>
                    </div>
                    <div id="csHandoverSection" class="hidden cs-stage-options">
                        <label>Bukti Barang Telah Diserahkan <input name="handoverReference"
                                placeholder="Resi diterima / tanda terima / berita acara"></label>
                    </div>
                    <label id="csStageConfirmation"><input type="checkbox" name="confirmed" required> Saya sudah
                        memeriksa bukti dan menyetujui perubahan status pada pratinjau.</label>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Batal</button><button type="submit"
                            class="cs-review-btn cs-review-primary" id="csStageSubmit">Konfirmasi</button></div>
                </form>
            </div>
        </div>
        <div id="csSizesModal" class="cs-workflow-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csSizesTitle">
            <div class="cs-workflow-dialog cs-workflow-small">
                <div class="cs-workflow-dialog-head">
                    <h2 id="csSizesTitle">Detail Distribusi Ukuran</h2><button type="button" data-workflow-close
                        aria-label="Tutup">✕</button>
                </div>
                <div class="cs-workflow-form">
                    <p>Rekap kuantitas setiap ukuran untuk order ini. Data individu pemesan belum tersedia.</p>
                    <table class="cs-size-table">
                        <thead>
                            <tr>
                                <th>Ukuran</th>
                                <th>Jumlah (pcs)</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody id="csSizeRows"></tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th id="csSizeGrand">0</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="cs-workflow-actions"><button type="button" data-workflow-close
                            class="cs-review-btn cs-review-neutral">Tutup</button><a
                            href="{{ asset('samples/ukuran-ORD-2024-0330.xlsx') }}" download="ukuran-ORD-2024-0330.xlsx"
                            class="cs-review-btn cs-review-neutral">Contoh Excel (.XLSX)</a><button type="button"
                            id="csDownloadSizes" class="cs-review-btn cs-review-primary"><span
                                class="material-symbols-outlined">download</span> Ekspor Ukuran Terkini (.CSV)</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="csDetailNotice" class="cs-detail-notice hidden" role="status" aria-live="polite"></div>
    </main>
@endsection
