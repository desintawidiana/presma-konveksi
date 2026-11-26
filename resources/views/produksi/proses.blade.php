@extends('layout.produksi')
@section('title', 'Proses Produksi | Presma Operations')
@section('content')
<main class="produksi-main" data-produksi-detail>
    <a href="{{ route('produksi.order') }}" class="produksi-btn-light mb-4 inline-flex"><span class="material-symbols-outlined">arrow_back</span> Kembali ke List Order</a>
    <section class="produksi-order-hero" id="detail-hero"><div><div class="produksi-loading">Memuat detail Work Order...</div></div></section>
    <div class="produksi-detail-grid">
        <section class="produksi-panel produksi-work-card">
            <div class="produksi-work-head"><span class="produksi-step-label">TAHAP AKTIF</span><h2 id="detail-stage">Tahap Produksi</h2><p>Checklist dan pencatatan progres pengerjaan.</p></div>
            <div class="produksi-work-body">
                <div class="produksi-info-grid">
                    <div><small>PEKERJA PENANGGUNG JAWAB</small><strong id="detail-worker-display">Belum ditugaskan</strong><span>Nama operator sesuai tahapan pengerjaan</span></div>
                    <div><small>NOMOR PESANAN</small><strong id="detail-order-number">—</strong><span id="detail-date">Deadline</span><a id="detail-wo-link" class="produksi-wo-preview-link" href="#" target="_blank" rel="noopener">Lihat Work Order <span class="material-symbols-outlined">open_in_new</span></a></div>
                </div>
                <label class="produksi-field-label" for="detail-stage-select">Tahap yang dikerjakan</label>
                <select id="detail-stage-select" class="w-full rounded-lg border border-[#dfe4e4] bg-white p-3 text-sm mb-3"></select>
                <label class="produksi-field-label" for="detail-worker">Nama penanggung jawab / pekerja</label>
                <input id="detail-worker" type="text" class="w-full rounded-lg border border-[#dfe4e4] bg-white p-3 text-sm mb-3" placeholder="Tuliskan nama pekerja yang bertanggung jawab">
                <label class="produksi-field-label" for="detail-note">Catatan Pengerjaan (Opsional)</label>
                <textarea id="detail-note" rows="4" maxlength="1000" placeholder="Tuliskan catatan operator, kendala mesin, bahan, atau penyesuaian pengerjaan..."></textarea>
                <div class="produksi-note">Pilih tahap dan tuliskan nama pekerja yang bertanggung jawab. Demo ini menyimpan perubahan pada browser; saat integrasi database, data diarahkan ke tabel tahapan/progres Work Order.</div>
                <div class="produksi-work-actions"><button type="button" class="produksi-btn-primary" id="detail-next">Selesaikan Tahap</button></div>
                <div id="detail-qc" class="mt-5 rounded-xl border border-[#eadada] bg-[#fffafa] p-4" hidden>
                    <h3 class="font-bold text-sm text-[#830909] mb-3">Pemeriksaan Quality Control</h3>
                    <label class="produksi-field-label" for="detail-qc-result">Hasil pemeriksaan</label>
                    <select id="detail-qc-result" class="w-full rounded-lg border border-[#dfe4e4] bg-white p-3 text-sm mb-3">
                        <option value="LOLOS">LOLOS — lanjut ke Packing</option>
                        <option value="REVISI">REVISI — kembalikan ke tahap sebelumnya</option>
                    </select>
                    <label class="produksi-field-label" for="detail-qc-back">Kembalikan ke tahap (jika revisi)</label>
                    <select id="detail-qc-back" class="w-full rounded-lg border border-[#dfe4e4] bg-white p-3 text-sm mb-3">
                        <option value="Finishing">Finishing</option>
                        <option value="Jahit/Bordir/Sablon">Jahit/Bordir/Sablon</option>
                        <option value="Cutting">Cutting</option>
                    </select>
                    <label class="produksi-field-label" for="detail-qc-note">Catatan QC</label>
                    <textarea id="detail-qc-note" rows="3" placeholder="Catat hasil pemeriksaan atau bagian yang perlu diperbaiki..."></textarea>
                    <button type="button" class="produksi-btn-primary mt-3 w-full" id="detail-qc-submit">Simpan Hasil QC</button>
                </div>
                <div class="produksi-feedback" id="detail-feedback" role="status"></div>
            </div>
        </section>
        <aside class="produksi-panel produksi-timeline-panel">
            <div class="produksi-panel-heading"><div><h2>Timeline Produksi</h2><p>Urutan tahap sesuai master database</p></div><span id="timeline-count">—</span></div>
            <ol id="detail-timeline" class="produksi-timeline"><li class="produksi-loading">Memuat tahapan...</li></ol>
        </aside>
    </div>
    <section class="produksi-panel mt-5">
        <div class="produksi-panel-heading"><div><h2>Rincian Work Order</h2><p>Informasi pesanan yang diteruskan oleh Customer Service.</p></div></div>
        <div id="detail-spec" class="produksi-spec-grid"><div class="produksi-loading">Memuat spesifikasi...</div></div>
    </section>
</main>
@endsection
