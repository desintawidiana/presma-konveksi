// Halaman Detail Order CS — terhubung ke database lewat API.
// Alur: Verifikasi -> Invoice+DP -> Work Order -> (Produksi) -> Pelunasan -> Serah Terima
import {
    api, esc, rupiah, tanggal, waLink, toast, normalisasiWa,
    GAYA_ALUR, badge, statusBayar, LABEL_BAYAR, GAYA_BAYAR, SUMBER, UKURAN,
} from './api.js';

const startDetail = () => {
    const page = document.querySelector('.cs-order-detail-page');
    if (!page || !page.querySelector('#csOrderBody')) return;

    const $ = (sel) => page.querySelector(sel);
    const body = $('#csOrderBody');
    const statusLine = $('#csWorkflowStatus');
    const btnEdit = $('#csOpenEdit');
    const btnRevisi = $('#csOpenRevision');
    const btnBatal = $('#csOpenCancel');
    const btnNext = $('#csNextAction');
    const params = new URLSearchParams(window.location.search);
    const id = params.get('id');

    let o = null;          // data order dari API
    let daftarTahap = [];  // tahap produksi berurutan

    // ---------- util tampilan ------------------------------------------------
    const nilai = (x) => (x === null || x === undefined || x === '' ? '<span class="text-secondary font-normal">—</span>' : esc(x));
    const kv = (label, isi, ekstra = '') => `
        <div class="p-3 bg-surface-container-low rounded-lg border border-surface-container">
            <span class="text-on-surface-variant block text-[11px]">${esc(label)}</span>
            <strong class="text-on-surface text-sm block mt-0.5 ${ekstra}">${isi}</strong>
        </div>`;
    const kartu = (ikon, judul, isi, sisi = '') => `
        <section class="border border-surface-container rounded-xl overflow-hidden bg-surface-container-lowest">
            <div class="w-full px-4 py-3 bg-surface-container-low flex items-center justify-between border-b border-surface-container">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[19px]">${ikon}</span>
                    <span class="text-xs font-bold text-on-surface uppercase tracking-wide">${esc(judul)}</span>
                </div>${sisi}
            </div>
            <div class="p-4 text-xs">${isi}</div>
        </section>`;
    const grid = (isi, kolom = 'sm:grid-cols-2 lg:grid-cols-4') =>
        `<div class="grid grid-cols-1 ${kolom} gap-3">${isi}</div>`;
    const ya = (b) => (b ? 'Ya' : 'Tidak');

    // ---------- aturan tombol per posisi alur ---------------------------------
    const AKSI_UTAMA = {
        verification: 'Verifikasi & Fiksasi Pesanan',
        payment: 'Terbitkan Invoice & Catat DP',
        wo: () => (o.work_order ? 'Teruskan WO ke Produksi' : 'Buat Work Order'),
        settlement: 'Catat Pelunasan',
        ready: 'Serah Terima ke Pelanggan',
    };
    const PETUNJUK = {
        verification: 'Periksa data pesanan, lengkapi harga satuan, lalu fiksasi.',
        payment: 'Pesanan terverifikasi. Terbitkan invoice dan catat DP dari pelanggan.',
        wo: 'DP sudah masuk. Buat Work Order dan teruskan ke Tim Produksi.',
        tracking: 'Pesanan sedang dikerjakan Tim Produksi. CS cukup memantau tahapnya di bawah.',
        settlement: 'Barang sudah di tahap Packing. Tagih dan catat pelunasan.',
        ready: 'Sudah lunas. Serahkan barang ke pelanggan, lalu tandai selesai.',
        completed: 'Order selesai. Barang telah diserahkan ke pelanggan.',
        cancelled: 'Order ini dibatalkan.',
    };

    const terkunci = () => Boolean(o?.invoice); // harga & ukuran dikunci trigger setelah invoice

    // ---------- render halaman ----------------------------------------------
    const render = () => {
        const p = o.pelanggan || {};
        const s = o.spesifikasi || {};
        const uk = o.ukuran_pesanan || [];
        const rp = o.ringkasan_pembayaran || {};
        const bayar = statusBayar({ total_pembayaran: rp.total_pembayaran, total_dibayar: rp.total_dibayar, dp: rp.dp });
        const totalPcs = uk.reduce((a, x) => a + Number(x.jumlah || 0), 0);
        const belumDirinci = uk.length > 0 && uk.every((x) => x.ukuran === 'TANPA_UKURAN');
        const idxTahap = daftarTahap.findIndex((t) => t.nama === o.tahap_saat_ini);

        statusLine.textContent = `Status: ${o.alur_label} • Tahap produksi: ${o.tahap_saat_ini}. ${PETUNJUK[o.alur] || ''}`;

        // Kepala + progres tahap produksi
        const chips = daftarTahap.map((t, i) => {
            const gaya = i < idxTahap ? 'background:#d1fae5;color:#065f46'
                : i === idxTahap ? 'background:#830909;color:#fff'
                    : 'background:#f3f4f4;color:#6b7280';
            return `<span class="px-2.5 py-1 rounded-full text-[11px] font-semibold" style="${gaya}">${esc(t.nama)}</span>`;
        }).join('');

        const kepala = `
        <section class="bg-white rounded-xl px-5 py-5 border border-[#e1e3e3] shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-[#635d5e]">Kode Order</p>
                    <h1 class="text-2xl font-bold text-[#191c1c]" id="csDetailCode">${esc(o.kode_order)}</h1>
                    <p class="text-sm text-[#635d5e] mt-1">${esc(p.nama || '—')}${p.instansi ? ' • ' + esc(p.instansi) : ''}</p>
                </div>
                <div class="flex flex-col items-end gap-1.5">
                    ${badge(o.alur_label, GAYA_ALUR[o.alur] || GAYA_ALUR.verification)}
                    ${badge(LABEL_BAYAR[bayar], GAYA_BAYAR[bayar])}
                    <span class="text-xs text-[#635d5e]">Deadline: <strong>${o.deadline ? esc(tanggal(o.deadline)) : 'Belum ditentukan'}</strong></span>
                </div>
            </div>
            <div class="flex flex-wrap gap-1.5 mt-4" aria-label="Progres produksi">${chips}</div>
        </section>`;

        const identitas = kartu('person', 'Identitas & Kontak Pemesan', grid(
            kv('Nama Pemesan', nilai(p.nama))
            + kv('No. WhatsApp', p.no_whatsapp ? `<a class="text-primary font-mono" target="_blank" rel="noopener" href="${esc(waLink(p.no_whatsapp))}">${esc(p.no_whatsapp)}</a>` : nilai(null))
            + kv('Instansi', nilai(p.instansi))
            + kv('Sumber Informasi', nilai(SUMBER[p.sumber_informasi] || p.sumber_informasi))
            + kv('Tanggal Masuk', esc(tanggal(o.dibuat_pada, true)))
            + kv('Dibuat Lewat', o.dibuat_dari === 'FORM_CUSTOMER' ? 'Form Customer' : 'Dibuat CS')
            + kv('Kode Tracking Pelanggan', `<span class="font-mono text-[12px] break-all">${esc(o.kode_tracking)}</span>`)
        ));

        const spesifikasi = kartu('checkroom', 'Spesifikasi Produk', grid(
            kv('Jenis Produk', nilai(o.jenis_produk))
            + kv('Bahan Kain', nilai(s.bahan))
            + kv('Warna', nilai(s.warna))
            + kv('Model / Cutting', nilai(s.model_cuttingan))
            + kv('Lengan', nilai(s.lengan === 'PANJANG' ? 'Panjang' : s.lengan === 'PENDEK' ? 'Pendek' : null))
            + kv('Desain', s.status_desain === 'SUDAH_ADA_FILE' ? 'Pelanggan sudah punya file' : 'Dibuatkan tim Presma')
            + kv('Sablon / Bordir', `${ya(s.pakai_sablon)} / ${ya(s.pakai_bordir)}`)
            + kv('Lanyard / ID Card', `${ya(s.pakai_lanyard)} / ${ya(s.pakai_id_card)}`)
            + kv('Catatan Bordir / Sablon', nilai(s.ket_bordir_sablon))
            + kv('Merchandise Tambahan', nilai(s.tambahan))
            + kv('Keterangan Order', nilai(o.keterangan))
        ));

        const barisUkuran = uk.map((x) => `<tr><td class="py-1.5 px-3">${x.ukuran === 'TANPA_UKURAN' ? 'Tanpa rincian ukuran' : esc(x.ukuran)}</td><td class="py-1.5 px-3 text-right font-semibold">${Number(x.jumlah)}</td></tr>`).join('');
        const ukuran = kartu('straighten', 'Rincian Ukuran', `
            ${belumDirinci ? '<p class="mb-3 px-3 py-2 rounded-lg" style="background:#fef3c7;color:#92400e">Rincian ukuran belum diisi. Lengkapi lewat tombol <strong>Edit Pesanan</strong>.</p>' : ''}
            <table class="w-full max-w-sm text-left"><thead><tr class="text-on-surface-variant"><th class="py-1.5 px-3">Ukuran</th><th class="py-1.5 px-3 text-right">Jumlah (pcs)</th></tr></thead>
            <tbody class="divide-y divide-surface-container">${barisUkuran || '<tr><td colspan="2" class="py-2 px-3 text-secondary">Belum ada data ukuran.</td></tr>'}</tbody>
            <tfoot><tr class="font-bold"><td class="py-2 px-3">Total</td><td class="py-2 px-3 text-right">${totalPcs}</td></tr></tfoot></table>`);

        const barisBayar = (o.pembayaran || []).map((x) => `
            <tr><td class="py-1.5 px-3">${esc(tanggal(x.tanggal_bayar))}</td><td class="py-1.5 px-3">${esc(x.jenis)}</td>
            <td class="py-1.5 px-3">${esc(x.metode || '—')}</td><td class="py-1.5 px-3">${esc(x.keterangan || '—')}</td>
            <td class="py-1.5 px-3 text-right font-semibold">${esc(rupiah(x.jumlah))}</td></tr>`).join('');
        const keuangan = kartu('payments', 'Invoice & Pembayaran', grid(
            kv('Nomor Invoice', o.invoice ? esc(o.invoice.nomor_invoice) : '<span class="text-secondary font-normal">Belum diterbitkan</span>')
            + kv('Harga Satuan', esc(rupiah(o.harga_satuan)))
            + kv('Total Tagihan', esc(rupiah(rp.total_pembayaran)))
            + kv('DP Diterima', esc(rupiah(rp.dp)))
            + kv('Pelunasan Diterima', esc(rupiah(rp.pelunasan)))
            + kv('Kekurangan', esc(rupiah(rp.kekurangan)), Number(rp.kekurangan) > 0 ? 'text-error' : '')
        ) + `
            <table class="w-full text-left mt-4"><thead><tr class="text-on-surface-variant"><th class="py-1.5 px-3">Tanggal</th><th class="py-1.5 px-3">Jenis</th><th class="py-1.5 px-3">Metode</th><th class="py-1.5 px-3">Keterangan</th><th class="py-1.5 px-3 text-right">Jumlah</th></tr></thead>
            <tbody class="divide-y divide-surface-container">${barisBayar || '<tr><td colspan="5" class="py-2 px-3 text-secondary">Belum ada pembayaran tercatat.</td></tr>'}</tbody></table>`);

        const wo = o.work_order;
        const workOrder = kartu('assignment', 'Work Order', wo ? grid(
            kv('Nomor WO', esc(wo.nomor_wo)) + kv('Status', wo.status_wo === 'DITERUSKAN' ? 'Diteruskan ke Produksi' : 'Dibuat (belum diteruskan)')
            + kv('Tanggal WO', esc(tanggal(wo.tanggal_wo))) + kv('Catatan Produksi', nilai(wo.catatan_produksi))
        ) : '<p class="text-secondary">Work Order belum dibuat. WO bisa dibuat setelah invoice terbit dan DP tercatat.</p>');

        const riwayatBaris = (o.riwayat_tahap || []).map((r) => `
            <li class="py-2 flex flex-wrap items-baseline gap-x-3">
                <span class="font-semibold">${esc(r.tahap_baru)}${Number(r.mundur) ? ' <span style="color:#c62b2b">(mundur)</span>' : ''}</span>
                <span class="text-secondary">${esc(tanggal(r.waktu, true))} • ${esc(r.diubah_oleh_nama || 'Sistem')}</span>
                ${r.catatan ? `<span class="basis-full text-on-surface-variant">${esc(r.catatan)}</span>` : ''}
            </li>`).join('');
        const riwayat = kartu('timeline', 'Riwayat Tahap Produksi',
            riwayatBaris ? `<ul class="divide-y divide-surface-container">${riwayatBaris}</ul>` : '<p class="text-secondary">Belum ada perubahan tahap.</p>');

        const lampiran = kartu('attach_file', 'Lampiran Desain',
            '<p class="text-secondary">Upload dan lampiran file desain belum tersedia (modul <code>file_desain</code> belum dibuat di backend).</p>');

        const catatan = o.catatan_internal
            ? kartu('sticky_note_2', 'Catatan Internal', `<p class="whitespace-pre-line">${esc(o.catatan_internal)}</p>`) : '';

        body.innerHTML = kepala + identitas + spesifikasi + ukuran + keuangan + workOrder + riwayat + lampiran + catatan;
        aturTombol();
    };

    const aturTombol = () => {
        const final = o.alur === 'completed' || o.alur === 'cancelled';
        btnEdit.disabled = final;
        btnRevisi.disabled = !o.pelanggan?.no_whatsapp;

        const bisaBatal = o.alur === 'verification' || (o.alur === 'payment' && Number(o.ringkasan_pembayaran?.dp || 0) <= 0);
        btnBatal.classList.toggle('hidden', !bisaBatal);

        const label = typeof AKSI_UTAMA[o.alur] === 'function' ? AKSI_UTAMA[o.alur]() : AKSI_UTAMA[o.alur];
        btnNext.classList.toggle('hidden', !label);
        if (label) $('#csNextActionText').textContent = label;
    };

    // ---------- modal umum ----------------------------------------------------
    const modal = (sel) => $(sel);
    const buka = (sel) => { const m = modal(sel); m.classList.remove('hidden'); m.querySelector('input:not([type=hidden]),select,textarea,button')?.focus(); };
    const tutup = () => page.querySelectorAll('.cs-workflow-overlay').forEach((m) => m.classList.add('hidden'));
    page.querySelectorAll('[data-workflow-close]').forEach((b) => b.addEventListener('click', tutup));
    page.querySelectorAll('.cs-workflow-overlay').forEach((m) => m.addEventListener('click', (e) => { if (e.target === m) tutup(); }));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutup(); });
    const tampilError = (sel, pesan) => { const el = $(sel); el.textContent = pesan || ''; el.classList.toggle('hidden', !pesan); };
    const sibuk = (tombol, aktif, teks) => { tombol.disabled = aktif; if (aktif) { tombol.dataset.t = tombol.textContent; tombol.textContent = teks || 'Memproses…'; } else if (tombol.dataset.t) tombol.textContent = tombol.dataset.t; };

    const muat = async () => {
        const [detail, tahap] = await Promise.all([api('/pesanan/' + id), api('/tahap-produksi')]);
        o = detail.data;
        daftarTahap = tahap.data;
        render();
    };

    // ---------- modal langkah alur -------------------------------------------
    const form = $('#csStageForm');
    const fields = $('#csStageFields');
    let modeAktif = null;

    const fieldBayar = (jenis, default_, maks) => `
        <label>Nominal ${jenis} (Rp) <input name="jumlah" type="number" min="1" max="${maks}" step="1" required value="${default_}"></label>
        <label>Metode <select name="metode"><option value="TRANSFER">Transfer</option><option value="TUNAI">Tunai</option><option value="QRIS">QRIS</option><option value="LAINNYA">Lainnya</option></select></label>
        <label>Tanggal Bayar <input name="tanggal" type="date" value="${new Date().toISOString().slice(0, 10)}"></label>
        <label>Referensi / Keterangan <input name="keterangan" maxlength="255" placeholder="No. transfer, nama pengirim…"></label>`;

    const MODE = {
        verification: () => ({
            judul: 'Verifikasi & Fiksasi Pesanan',
            desc: 'Setelah difiksasi, pesanan berstatus DIKONFIRMASI dan siap ditagihkan.',
            submit: 'Fiksasi Pesanan',
            isi: () => {
                const adaHarga = o.harga_satuan !== null && o.harga_satuan !== '';
                const belumRinci = (o.ukuran_pesanan || []).every((x) => x.ukuran === 'TANPA_UKURAN');
                return `
                <ul class="text-[13px] space-y-1">
                    <li>${adaHarga ? '✅' : '❌'} Harga satuan ${adaHarga ? esc(rupiah(o.harga_satuan)) : 'belum diisi (wajib, lewat Edit Pesanan)'}</li>
                    <li>${belumRinci ? '⚠️ Rincian ukuran belum diisi (disarankan dilengkapi)' : '✅ Rincian ukuran sudah diisi'}</li>
                </ul>
                <label class="cs-confirm-check"><input type="checkbox" name="konfirmasi" required ${adaHarga ? '' : 'disabled'}> Saya sudah memeriksa data pesanan bersama pelanggan.</label>`;
            },
            jalankan: async () => { await api(`/pesanan/${id}/konfirmasi`, { method: 'POST' }); },
            ok: 'Pesanan berhasil diverifikasi.',
        }),
        payment: () => {
            const total = Number(o.ringkasan_pembayaran?.total_pembayaran || 0);
            return {
                judul: 'Invoice & Pembayaran DP',
                desc: o.invoice ? `Invoice ${o.invoice.nomor_invoice} sudah terbit. Catat DP yang diterima.` : 'Invoice akan diterbitkan otomatis, lalu DP dicatat.',
                submit: 'Simpan DP',
                isi: () => fieldBayar('DP', Math.round(total / 2), total),
                jalankan: async (fd) => {
                    if (!o.invoice) await api(`/pesanan/${id}/invoice`, { method: 'POST' });
                    await api(`/pesanan/${id}/pembayaran`, { method: 'POST', body: {
                        jenis: 'DP', jumlah: Number(fd.get('jumlah')), metode: fd.get('metode'),
                        tanggal_bayar: fd.get('tanggal') || null, keterangan: fd.get('keterangan') || null } });
                },
                ok: 'Invoice diterbitkan dan DP tercatat.',
            };
        },
        wo: () => ({
            judul: o.work_order ? 'Teruskan Work Order' : 'Buat Work Order',
            desc: o.work_order ? `WO ${o.work_order.nomor_wo} akan diteruskan ke Tim Produksi.` : 'Nomor WO dibuat otomatis oleh sistem. Setelah dibuat, WO langsung diteruskan ke Tim Produksi.',
            submit: o.work_order ? 'Teruskan ke Produksi' : 'Buat & Teruskan WO',
            isi: () => (o.work_order ? '' : '<label>Catatan untuk Produksi <textarea name="catatan" rows="3" placeholder="Penanggung jawab produksi, catatan khusus, dll."></textarea></label>'),
            jalankan: async (fd) => {
                let woId = o.work_order?.id;
                if (!woId) {
                    await api(`/pesanan/${id}/work-order`, { method: 'POST', body: { catatan_produksi: fd.get('catatan') || null } });
                    woId = (await api('/pesanan/' + id)).data.work_order.id;
                }
                await api(`/work-order/${woId}/teruskan`, { method: 'POST' });
            },
            ok: 'Work Order diteruskan ke Tim Produksi.',
        }),
        settlement: () => {
            const sisa = Number(o.ringkasan_pembayaran?.kekurangan || 0);
            return {
                judul: 'Pelunasan', desc: `Sisa tagihan ${rupiah(sisa)}.`, submit: 'Simpan Pelunasan',
                isi: () => fieldBayar('Pelunasan', sisa, sisa),
                jalankan: async (fd) => { await api(`/pesanan/${id}/pembayaran`, { method: 'POST', body: {
                    jenis: 'PELUNASAN', jumlah: Number(fd.get('jumlah')), metode: fd.get('metode'),
                    tanggal_bayar: fd.get('tanggal') || null, keterangan: fd.get('keterangan') || null } }); },
                ok: 'Pelunasan tercatat.',
            };
        },
        ready: () => ({
            judul: 'Serah Terima ke Pelanggan', desc: 'Tandai barang sudah diserahkan. Order akan berstatus Selesai.', submit: 'Tandai Selesai',
            isi: () => `<label>Metode Penyerahan <select name="metode"><option>Diambil di toko</option><option>Kurir lokal</option><option>Ekspedisi</option></select></label>
                <label>Catatan / No. Resi <input name="catatan" maxlength="200"></label>
                <label class="cs-confirm-check"><input type="checkbox" required> Barang sudah diterima pelanggan.</label>`,
            jalankan: async (fd) => { await api(`/pesanan/${id}/serah-terima`, { method: 'POST', body: {
                catatan: [fd.get('metode'), fd.get('catatan')].filter(Boolean).join(' — ') } }); },
            ok: 'Order selesai.',
        }),
        cancel: () => ({
            judul: 'Batalkan Order', desc: 'Order yang dibatalkan tidak bisa diproses lagi.', submit: 'Batalkan Order',
            isi: () => '<label>Alasan pembatalan <textarea name="alasan" rows="3" required minlength="3" maxlength="200"></textarea></label>',
            jalankan: async (fd) => { await api(`/pesanan/${id}/batal`, { method: 'POST', body: { alasan: fd.get('alasan') } }); },
            ok: 'Order dibatalkan.',
        }),
    };

    let konfigAktif = null;
    const bukaMode = (mode) => {
        if (!MODE[mode]) return;
        modeAktif = mode;
        konfigAktif = MODE[mode]();
        $('#csStageTitle').textContent = konfigAktif.judul;
        $('#csStageDescription').textContent = konfigAktif.desc;
        $('#csStageSubmit').textContent = konfigAktif.submit;
        fields.innerHTML = konfigAktif.isi();
        tampilError('#csStageError', '');
        buka('#csStageModal');
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!form.reportValidity() || !konfigAktif) return;
        const submit = $('#csStageSubmit');
        sibuk(submit, true);
        tampilError('#csStageError', '');
        try {
            await konfigAktif.jalankan(new FormData(form));
            tutup();
            toast(konfigAktif.ok);
            await muat();
        } catch (err) {
            tampilError('#csStageError', err.message);
            await muat().catch(() => {}); // sinkronkan bila sebagian langkah sudah berhasil
        } finally {
            sibuk(submit, false);
        }
    });

    btnNext.addEventListener('click', () => bukaMode(o.alur));
    btnBatal.addEventListener('click', () => bukaMode('cancel'));

    // ---------- modal edit pesanan -------------------------------------------
    const editForm = $('#csEditOrderForm');
    const gridUkuran = $('#csEditSizeGrid');
    gridUkuran.innerHTML = UKURAN.filter((u) => u !== 'TANPA_UKURAN').map((u) =>
        `<label>${u} <input name="size_${u}" type="number" min="0" step="1"></label>`).join('');
    const totalUkuran = () => UKURAN.filter((u) => u !== 'TANPA_UKURAN')
        .reduce((a, u) => a + (Number(editForm.elements['size_' + u].value) || 0), 0);
    const tampilTotalUkuran = () => { $('#csEditSizeTotal').textContent = 'Total: ' + totalUkuran() + ' pcs'; };
    gridUkuran.addEventListener('input', tampilTotalUkuran);

    btnEdit.addEventListener('click', () => {
        const el = editForm.elements;
        const p = o.pelanggan || {};
        const s = o.spesifikasi || {};
        el.customer.value = p.nama || '';
        el.phone.value = p.no_whatsapp || '';
        el.organization.value = p.instansi || '';
        el.source.value = p.sumber_informasi || '';
        el.product.value = o.jenis_produk || '';
        el.fabric.value = s.bahan || '';
        el.color.value = s.warna || '';
        el.deadline.value = o.deadline || '';
        el.unitPrice.value = o.harga_satuan === null || o.harga_satuan === undefined ? '' : Number(o.harga_satuan);
        el.cutting.value = s.model_cuttingan || '';
        el.lengan.value = s.lengan || '';
        el.design.value = s.status_desain || 'DIBUATKAN_TIM';
        el.merchandise.value = s.tambahan || '';
        el.embroidery.value = s.ket_bordir_sablon || '';
        el.notes.value = o.keterangan || '';
        el.sablon.checked = Boolean(s.pakai_sablon);
        el.bordir.checked = Boolean(s.pakai_bordir);
        el.lanyard.checked = Boolean(s.pakai_lanyard);
        el.idcard.checked = Boolean(s.pakai_id_card);

        const peta = Object.fromEntries((o.ukuran_pesanan || []).map((x) => [x.ukuran, x.jumlah]));
        UKURAN.filter((u) => u !== 'TANPA_UKURAN').forEach((u) => { el['size_' + u].value = peta[u] ?? ''; });
        tampilTotalUkuran();

        const kunci = terkunci();
        el.unitPrice.disabled = kunci;
        UKURAN.filter((u) => u !== 'TANPA_UKURAN').forEach((u) => { el['size_' + u].disabled = kunci; });
        $('#csEditLockHint').classList.toggle('hidden', !kunci);
        $('#csEditContext').textContent = 'Kode order ' + o.kode_order;
        tampilError('#csEditError', '');
        buka('#csEditOrderModal');
    });

    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!editForm.reportValidity()) return;
        const el = editForm.elements;
        const submit = $('#csEditSubmit');
        sibuk(submit, true, 'Menyimpan…');
        tampilError('#csEditError', '');

        try {
            const p = o.pelanggan || {};
            const pelangganBaru = {
                nama: el.customer.value.trim(),
                no_whatsapp: normalisasiWa(el.phone.value),
                instansi: el.organization.value.trim() || null,
                sumber_informasi: el.source.value || null,
            };
            const berubah = pelangganBaru.nama !== (p.nama || '')
                || pelangganBaru.no_whatsapp !== (p.no_whatsapp || '')
                || (pelangganBaru.instansi || '') !== (p.instansi || '')
                || (pelangganBaru.sumber_informasi || '') !== (p.sumber_informasi || '');
            if (berubah) await api('/pelanggan/' + o.pelanggan_id, { method: 'PUT', body: pelangganBaru });

            const payload = {
                jenis_produk: el.product.value,
                keterangan: el.notes.value.trim() || null,
                deadline: el.deadline.value || null,
                spesifikasi: {
                    bahan: el.fabric.value.trim() || null,
                    warna: el.color.value.trim() || null,
                    model_cuttingan: el.cutting.value.trim() || null,
                    lengan: el.lengan.value || null,
                    status_desain: el.design.value,
                    tambahan: el.merchandise.value.trim() || null,
                    ket_bordir_sablon: el.embroidery.value.trim() || null,
                    pakai_sablon: el.sablon.checked,
                    pakai_bordir: el.bordir.checked,
                    pakai_lanyard: el.lanyard.checked,
                    pakai_id_card: el.idcard.checked,
                },
            };
            if (!terkunci()) {
                payload.harga_satuan = el.unitPrice.value === '' ? null : Number(el.unitPrice.value);
                const rincian = UKURAN.filter((u) => u !== 'TANPA_UKURAN')
                    .map((u) => ({ ukuran: u, jumlah: Number(el['size_' + u].value) || 0 }))
                    .filter((x) => x.jumlah > 0);
                if (rincian.length) payload.ukuran = rincian; // kosong = ukuran lama dibiarkan
            }

            await api('/pesanan/' + id, { method: 'PUT', body: payload });
            tutup();
            toast('Perubahan pesanan tersimpan.');
            await muat();
        } catch (err) {
            tampilError('#csEditError', err.message);
        } finally {
            sibuk(submit, false);
        }
    });

    // ---------- hubungi customer / revisi ------------------------------------
    const revisiForm = $('#csRevisionForm');
    btnRevisi.addEventListener('click', () => { revisiForm.reset(); tampilError('#csRevisionError', ''); buka('#csRevisionModal'); });
    revisiForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!revisiForm.reportValidity()) return;
        const alasan = revisiForm.elements.reason.value.trim();
        const teks = `Halo ${o.pelanggan?.nama || 'Kak'}, kami dari Presma Konveksi terkait order ${o.kode_order}. ${alasan}`;
        window.open(waLink(o.pelanggan.no_whatsapp, teks), '_blank', 'noopener'); // dibuka sinkron agar tidak diblokir popup blocker
        try {
            const catatan = (o.catatan_internal ? o.catatan_internal + '\n' : '')
                + `[${tanggal(new Date().toISOString().slice(0, 10))}] Hubungi customer: ${alasan}`;
            await api('/pesanan/' + id, { method: 'PUT', body: { catatan_internal: catatan } });
            tutup();
            toast('Catatan tersimpan.');
            await muat();
        } catch (err) {
            tampilError('#csRevisionError', err.message);
        }
    });

    // ---------- mulai --------------------------------------------------------
    if (!id) {
        statusLine.textContent = 'Order tidak dipilih. Buka dari daftar order.';
        return;
    }
    muat().then(() => {
        if (params.get('action') === 'next' && !btnNext.classList.contains('hidden')) btnNext.click();
    }).catch((err) => {
        statusLine.textContent = err.message;
        body.innerHTML = '';
    });
};

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startDetail);
else startDetail();
