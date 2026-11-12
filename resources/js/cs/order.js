// Halaman Order CS — terhubung ke database lewat API (/api/pesanan).
import {
    api, esc, rupiah, tanggal, normalisasiWa, toast,
    GAYA_ALUR, badge, statusBayar, LABEL_BAYAR, GAYA_BAYAR,
} from './api.js';

const startCSOrder = () => {
    const page = document.querySelector('.cs-order-page');
    if (!page || !page.querySelector('#csOrderTable')) return;

    const tbody = page.querySelector('#csOrderTable tbody');
    const search = page.querySelector('#csOrderSearch');
    const filterBayar = page.querySelector('[data-cs-filter="payment"]');
    const filterKategori = page.querySelector('[data-cs-filter="category"]');
    const createModal = page.querySelector('#csOrderCreateModal');
    const createForm = page.querySelector('#csOrderCreateForm');
    const summary = page.querySelector('[data-cs-summary]');
    const detailUrl = page.dataset.detailUrl || '/cs/order/detail';

    let semuaOrder = [];
    let tabAktif = 'all';
    let orderPage = 1;
    let orderPageSize = 10;
    let orderFooter = null;

    // ----- pemetaan alur kerja -> tab, kategori, tombol aksi -------------------
    const TAB_ALUR = {
        verification: 'verification', payment: 'verification', wo: 'verification',
        tracking: 'production', settlement: 'production',
        ready: 'ready', completed: 'ready',
    };
    const AKSI = {
        verification: 'Verifikasi', payment: 'Pembayaran', wo: 'Work Order',
        tracking: 'Pantau', settlement: 'Pelunasan', ready: 'Serah Terima',
    };
    const kategori = (jenis) => {
        const j = String(jenis || '').toLowerCase();
        if (j.includes('korsa')) return 'korsa';
        if (j.includes('jaket') || j.includes('vest')) return 'jaket';
        if (j.includes('kaos') || j.includes('polo')) return 'kaos';
        return 'other';
    };
    const SUMBER_ORDER = { FORM_CUSTOMER: 'Form Customer', CS: 'Dibuat CS' };

    const linkDetail = (id, aksi) =>
        detailUrl + '?id=' + encodeURIComponent(id) + (aksi ? '&action=next' : '');

    // ----- render tabel --------------------------------------------------------
    const barisPesan = (teks, kelas = 'text-secondary') =>
        `<tr><td colspan="9" class="py-10 px-4 text-center ${kelas}">${teks}</td></tr>`;

    const barisHtml = (o) => {
        const bayar = statusBayar(o);
        const aksi = AKSI[o.alur];
        const btn = 'inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg border border-[#D9DADB] font-semibold text-[12px] whitespace-nowrap hover:bg-[#f3f4f4]';
        const btnUtama = btn + ' bg-[#830909] text-white border-[#830909] hover:bg-[#6b0707]';
        return `
        <tr class="hover:bg-surface-container-low transition-colors cursor-pointer" data-order-row="true" data-id="${esc(o.no)}">
            <td class="py-3.5 px-4 font-semibold text-primary">${esc(o.kode_order)}</td>
            <td class="py-3.5 px-4">${esc(tanggal(o.dibuat_pada))}
                <span class="block text-[11px] text-secondary">Deadline: ${o.deadline ? esc(tanggal(o.deadline)) : 'Belum ditentukan'}</span></td>
            <td class="py-3.5 px-4"><span class="font-semibold">${esc(o.customer)}</span>
                <span class="block text-secondary text-[12px]">${esc(o.instansi || '—')}</span></td>
            <td class="py-3.5 px-4">${esc(o.jenis_order)}
                <small class="block text-secondary">${Number(o.jumlah) || 0} pcs</small></td>
            <td class="py-3.5 px-4">${esc(SUMBER_ORDER[o.dibuat_dari] || o.dibuat_dari)}</td>
            <td class="py-3.5 px-4">${badge(o.alur_label, GAYA_ALUR[o.alur] || GAYA_ALUR.verification)}
                <small class="block text-secondary mt-1">Tahap: ${esc(o.tahap_saat_ini)}</small></td>
            <td class="py-3.5 px-4">${badge(LABEL_BAYAR[bayar], GAYA_BAYAR[bayar])}</td>
            <td class="py-3.5 px-4 text-right font-semibold">${esc(rupiah(o.total_pembayaran))}</td>
            <td class="py-3.5 px-4 text-center"><div class="flex items-center justify-center gap-1.5 flex-wrap">
                <a href="${linkDetail(o.no)}" class="${btn}" data-cs-action="detail">Detail</a>
                ${aksi ? `<a href="${linkDetail(o.no, true)}" class="${btnUtama}" data-cs-action="next">${esc(aksi)}</a>` : ''}
            </div></td>
        </tr>`;
    };

    const terfilter = () => {
        const q = (search?.value || '').toLocaleLowerCase('id-ID').trim();
        return semuaOrder.filter((o) => {
            const teks = [o.kode_order, o.customer, o.instansi, o.jenis_order, o.no_whatsapp]
                .join(' ').toLocaleLowerCase('id-ID');
            return (!q || teks.includes(q))
                && (!filterBayar || filterBayar.value === 'all' || statusBayar(o) === filterBayar.value)
                && (!filterKategori || filterKategori.value === 'all' || kategori(o.jenis_order) === filterKategori.value)
                && (tabAktif === 'all' || TAB_ALUR[o.alur] === tabAktif);
        });
    };

    // Kartu ringkasan di atas tabel (dihitung dari data database).
    const isiKpi = () => {
        const kpi = page.querySelectorAll('.cs-order-kpi-number');
        const n = (alur) => semuaOrder.filter((o) => alur.includes(o.alur)).length;
        const hariIni = new Date().toISOString().slice(0, 10);
        const nilai = [
            semuaOrder.filter((o) => o.alur !== 'cancelled').length,
            n(['verification']),
            n(['tracking', 'settlement']),
            n(['ready']),
        ];
        kpi.forEach((el, i) => { el.textContent = nilai[i] ?? 0; });
        const baru = semuaOrder.filter((o) => String(o.dibuat_pada || '').startsWith(hariIni)).length;
        if (kpi[0]?.nextElementSibling) kpi[0].nextElementSibling.textContent = '+' + baru + ' hari ini';
        const periode = kpi[0]?.closest('div.bg-surface-container-lowest')?.querySelector('.border-t span:last-child');
        if (periode) periode.textContent = 'Periode ' + new Date().toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
    };

    const render = () => {
        isiKpi();
        const tampil = terfilter();
        const pages = Math.max(1, Math.ceil(tampil.length / orderPageSize));
        orderPage = Math.min(orderPage, pages);
        const start = (orderPage - 1) * orderPageSize;
        const end = Math.min(start + orderPageSize, tampil.length);
        const pageData = tampil.slice(start, end);
        tbody.innerHTML = pageData.length
            ? pageData.map(barisHtml).join('')
            : barisPesan(semuaOrder.length ? 'Tidak ada order yang cocok dengan filter.' : 'Belum ada order. Klik “Tambah Order Baru”.');
        if (summary) summary.textContent = `Menampilkan ${tampil.length ? start + 1 : 0}–${end} dari ${tampil.length} data`;
        if (orderFooter) {
            orderFooter.innerHTML = `<div class="presma-pagination-info"><span>${tampil.length ? `Menampilkan ${start + 1}–${end} dari ${tampil.length} data` : 'Tidak ada data untuk ditampilkan'}</span><label>Tampilkan <select data-order-page-size><option value="10" ${orderPageSize === 10 ? 'selected' : ''}>10</option><option value="20" ${orderPageSize === 20 ? 'selected' : ''}>20</option></select></label></div><div class="presma-page-actions"><button type="button" data-order-prev ${orderPage <= 1 ? 'disabled' : ''}>‹</button><span class="presma-page-current">${orderPage} / ${pages}</span><button type="button" data-order-next ${orderPage >= pages ? 'disabled' : ''}>›</button></div>`;
            orderFooter.querySelector('[data-order-page-size]')?.addEventListener('change', e => { orderPageSize = Number(e.target.value) || 10; orderPage = 1; render(); });
            orderFooter.querySelector('[data-order-prev]')?.addEventListener('click', () => { if (orderPage > 1) { orderPage--; render(); } });
            orderFooter.querySelector('[data-order-next]')?.addEventListener('click', () => { if (orderPage < pages) { orderPage++; render(); } });
        }
    };

    const muatData = async () => {
        tbody.innerHTML = barisPesan('Memuat data order…');
        try {
            semuaOrder = (await api('/pesanan')).data;
            render();
        } catch (e) {
            tbody.innerHTML = barisPesan(`${esc(e.message)} <button type="button" id="csOrderRetry" class="underline font-semibold">Coba lagi</button>`, 'text-error');
            tbody.querySelector('#csOrderRetry')?.addEventListener('click', muatData);
        }
    };

    // ----- tab, pencarian, filter ---------------------------------------------
    page.querySelectorAll('[data-cs-tab]').forEach((b) => b.addEventListener('click', () => {
        tabAktif = b.dataset.csTab;
        orderPage = 1;
        page.querySelectorAll('[data-cs-tab]').forEach((x) => x.classList.toggle('cs-tab-active', x === b));
        orderPage = 1;
        render();
    }));
    page.querySelectorAll('[data-cs-tab]').forEach((b) => b.classList.toggle('cs-tab-active', b.dataset.csTab === tabAktif));
    search?.addEventListener('input', () => { orderPage = 1; render(); });
    filterBayar?.addEventListener('change', () => { orderPage = 1; render(); });
    filterKategori?.addEventListener('change', () => { orderPage = 1; render(); });

    // Klik baris = buka detail (tombol/tautan di dalam baris punya tujuannya sendiri).
    tbody.addEventListener('click', (e) => {
        if (e.target.closest('a')) return;
        const row = e.target.closest('tr[data-order-row]');
        if (row) window.location.assign(linkDetail(row.dataset.id));
    });

    // Footer pagination disisipkan tepat setelah pembungkus tabel.
    const tableWrapper = page.querySelector('#csOrderTable')?.closest('.overflow-x-auto');
    if (tableWrapper) {
        const legacyFooter = tableWrapper.nextElementSibling;
        legacyFooter?.querySelectorAll('button').forEach(button => button.hidden = true);
        orderFooter = document.createElement('div');
        orderFooter.className = 'presma-pagination';
        orderFooter.setAttribute('aria-label', 'Navigasi halaman order');
        tableWrapper.insertAdjacentElement('afterend', orderFooter);
    }

    // ----- modal tambah order -------------------------------------------------
    const bukaModal = () => { createModal?.classList.remove('hidden'); createModal?.querySelector('input,select')?.focus(); };
    const tutupModal = () => createModal?.classList.add('hidden');
    Array.from(page.querySelectorAll('button')).find((b) => b.textContent.includes('Tambah Order Baru'))
        ?.addEventListener('click', bukaModal);
    page.querySelectorAll('[data-order-close]').forEach((b) => b.addEventListener('click', tutupModal));
    createModal?.addEventListener('click', (e) => { if (e.target === createModal) tutupModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') tutupModal(); });

    createForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!createForm.reportValidity()) return;

        const fd = new FormData(createForm);
        const submit = createForm.querySelector('[type="submit"]');
        const teksAwal = submit?.textContent;
        const nomor = normalisasiWa(fd.get('phone'));
        const jumlah = Number(fd.get('quantity')) || 0;
        const harga = fd.get('unitPrice');

        if (submit) { submit.disabled = true; submit.textContent = 'Menyimpan…'; }

        try {
            // 1) cari pelanggan berdasarkan nomor WhatsApp; kalau belum ada, buat baru
            const daftar = (await api('/pelanggan')).data;
            let pelanggan = daftar.find((p) => p.no_whatsapp === nomor);
            if (!pelanggan) {
                pelanggan = (await api('/pelanggan', {
                    method: 'POST',
                    body: {
                        nama: String(fd.get('customer')).trim(),
                        no_whatsapp: nomor,
                        instansi: String(fd.get('organization') || '').trim() || null,
                        sumber_informasi: fd.get('source') || null,
                    },
                })).data;
            }

            // 2) buat pesanan. Rincian ukuran dilengkapi nanti lewat "Edit Pesanan".
            const hasil = await api('/pesanan', {
                method: 'POST',
                body: {
                    pelanggan_id: pelanggan.id,
                    jenis_produk: fd.get('product'),
                    keterangan: String(fd.get('notes') || '').trim() || null,
                    harga_satuan: harga === '' || harga === null ? null : Number(harga),
                    deadline: fd.get('deadline') || null,
                    spesifikasi: { status_desain: fd.get('design') || 'DIBUATKAN_TIM' },
                    ukuran: [{ ukuran: 'TANPA_UKURAN', jumlah }],
                },
            });

            createForm.reset();
            tutupModal();
            toast('Order ' + hasil.data.kode_order + ' berhasil dibuat.');
            await muatData();
        } catch (err) {
            toast(err.message, false);
        } finally {
            if (submit) { submit.disabled = false; submit.textContent = teksAwal; }
        }
    });

    // ----- export CSV (sesuai filter yang sedang tampil) ----------------------
    const aman = (v) => {
        let s = String(v ?? '').replace(/\s+/g, ' ').trim();
        if (/^[=+\-@]/.test(s)) s = "'" + s; // cegah formula injection di Excel
        return '"' + s.replace(/"/g, '""') + '"';
    };
    Array.from(page.querySelectorAll('button')).find((b) => b.textContent.includes('Export Data'))
        ?.addEventListener('click', () => {
            const kepala = ['Kode Order', 'Tanggal Masuk', 'Pelanggan', 'Instansi', 'WhatsApp', 'Produk', 'Jumlah',
                'Deadline', 'Status Alur', 'Tahap Produksi', 'Status Pembayaran', 'Total', 'Dibayar', 'Kekurangan'];
            const baris = terfilter().map((o) => [
                o.kode_order, tanggal(o.dibuat_pada), o.customer, o.instansi, o.no_whatsapp, o.jenis_order, o.jumlah,
                o.deadline || '', o.alur_label, o.tahap_saat_ini, LABEL_BAYAR[statusBayar(o)],
                o.total_pembayaran ?? '', o.total_dibayar ?? '', o.kekurangan ?? '',
            ]);
            const csv = [kepala, ...baris].map((r) => r.map(aman).join(',')).join('\r\n');
            const url = URL.createObjectURL(new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' }));
            const a = document.createElement('a');
            a.href = url;
            a.download = 'presma-order-' + new Date().toISOString().slice(0, 10) + '.csv';
            a.click();
            URL.revokeObjectURL(url);
        });

    muatData();
    if (new URLSearchParams(window.location.search).get('new') === '1') bukaModal();
};

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startCSOrder);
else startCSOrder();
