// Dashboard CS — terhubung ke database lewat GET /api/dashboard/cs
import { api, esc, rupiah, tanggal, waLink, badge, GAYA_ALUR, toast } from './api.js';

document.addEventListener('DOMContentLoaded', () => {
    // ----- menu samping (mobile) ------------------------------------------------
    const sidebar = document.getElementById('cs-sidebar');
    const toggle = document.getElementById('cs-menu-toggle');
    const backdrop = document.getElementById('cs-backdrop');
    const closeMenu = () => {
        sidebar?.classList.remove('is-open');
        if (backdrop) backdrop.hidden = true;
        toggle?.setAttribute('aria-expanded', 'false');
    };
    toggle?.addEventListener('click', () => {
        const open = sidebar?.classList.toggle('is-open') ?? false;
        if (backdrop) backdrop.hidden = !open;
        toggle.setAttribute('aria-expanded', String(open));
    });
    backdrop?.addEventListener('click', closeMenu);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });
    document.querySelectorAll('.cs-sidebar a[href="#"]').forEach((l) => l.addEventListener('click', (e) => e.preventDefault()));

    // ----- hanya jalan di halaman dashboard (ada tabel #csDashRows) --------------
   // ----- SIDEBAR COLLAPSE DESKTOP -----
const sidebarToggle = document.getElementById('cs-sidebar-toggle');

sidebarToggle?.addEventListener('click', () => {
    if (window.innerWidth <= 900) return;

    document.body.classList.toggle('cs-sidebar-collapsed');

    const isCollapsed = document.body.classList.contains('cs-sidebar-collapsed');

    sidebarToggle.title = isCollapsed ? 'Buka sidebar' : 'Tutup sidebar';
    sidebarToggle.setAttribute(
        'aria-label',
        isCollapsed ? 'Buka sidebar' : 'Tutup sidebar'
    );
});

// ----- hanya jalan di halaman dashboard -----
const rowsEl = document.getElementById('csDashRows');
if (!rowsEl) return;

    const main = document.querySelector('main[data-order-url]');
    const orderUrl = main?.dataset.orderUrl || '/cs/order';
    const detailUrl = orderUrl + '/detail';
    const search = document.getElementById('cs-order-search');
    const footer = document.getElementById('csDashFooter');
    let daftar = [];
    let filter = 'all';

    // Tombol "Buat Order Baru" -> halaman Order (modal tambah order terbuka otomatis)
    const btnBuat = Array.from(document.querySelectorAll('button')).find((b) => b.textContent.includes('Buat Order Baru'));
    if (btnBuat) {
        btnBuat.disabled = false;
        btnBuat.removeAttribute('aria-disabled');
        btnBuat.classList.remove('cs-disabled-action');
        btnBuat.removeAttribute('title');
        btnBuat.addEventListener('click', () => window.location.assign(orderUrl + '?new=1'));
    }

    // ----- isi kartu & keuangan -------------------------------------------------
    const isiAngka = (d) => {
        const angka = document.querySelectorAll('span.text-4xl.font-extrabold');
        [d.kartu.perlu_verifikasi, d.kartu.dalam_produksi, d.kartu.menunggu_pembayaran, d.kartu.selesai_siap_kirim]
            .forEach((v, i) => { if (angka[i]) angka[i].textContent = v; });

        const uang = document.querySelectorAll('.font-headline-sm.font-data-tabular');
        const k = d.keuangan;
        const isi = [
            [k.total_nilai, `Akumulasi ${k.jumlah_order_aktif} order aktif berjalan`],
            [k.dp_terverifikasi, `${k.jumlah_dp} pesanan sudah membayar DP`],
            [k.menunggu_pelunasan, `${k.jumlah_pelunasan} order menunggu pelunasan`],
            [k.belum_bayar_dp, `${k.jumlah_belum_dp} order sudah berinvoice, belum bayar DP`],
        ];
        isi.forEach(([nilai, ket], i) => {
            if (!uang[i]) return;
            uang[i].textContent = rupiah(nilai);
            const keterangan = uang[i].nextElementSibling;
            if (keterangan) keterangan.textContent = ket;
        });
    };

    // ----- tabel tindakan -------------------------------------------------------
    const labelDeadline = (r) => {
        if (!r.deadline) return ['Belum ditentukan', 'background:#f3f4f4;color:#6b7280'];
        const h = r.sisa_hari;
        const teks = tanggal(r.deadline) + (h === null ? '' : h < 0 ? ` (lewat ${-h} hari)` : ` (H-${h})`);
        return [teks, r.urgent ? 'background:#fde8e8;color:#c62b2b' : 'background:#f3f4f4;color:#374151'];
    };

    const barisHtml = (r) => {
        const [dl, gayaDl] = labelDeadline(r);
        const btn = 'inline-flex items-center gap-1.5 px-3.5 h-[44px] rounded-lg font-label-md font-semibold transition-colors shadow-sm';
        return `
        <tr class="hover:bg-surface-container-low transition-colors ${r.urgent ? 'bg-error-container/10' : ''}" data-cs-row="true">
            <td class="py-3.5 px-4 font-data-tabular"><span class="font-bold text-primary-container font-label-md">${esc(r.kode_order)}</span></td>
            <td class="py-3.5 px-4"><div class="font-semibold text-on-surface">${esc(r.customer)}</div>
                <div class="text-secondary text-[11px]">${esc(r.instansi || r.no_whatsapp || '—')}</div></td>
            <td class="py-3.5 px-4"><div class="font-medium text-on-surface">${esc(r.jenis_order)}</div>
                <div class="text-secondary text-[11px] font-semibold">${r.jumlah} pcs</div></td>
            <td class="py-3.5 px-4"><span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm font-semibold" style="${gayaDl}">${esc(dl)}</span></td>
            <td class="py-3.5 px-4">${badge(r.data_lengkap ? r.alur_label : r.alur_label + ' • data belum lengkap', r.data_lengkap ? (GAYA_ALUR[r.alur] || '') : GAYA_ALUR.payment)}</td>
            <td class="py-3.5 px-4 text-center"><div class="flex items-center justify-center gap-2">
                ${r.no_whatsapp ? `<a target="_blank" rel="noopener" href="${esc(waLink(r.no_whatsapp))}" class="${btn} bg-[#16804B] text-on-primary hover:bg-[#12663b]"><span class="material-symbols-outlined text-[16px]">chat</span>Chat WA</a>` : ''}
                <a href="${esc(detailUrl)}?id=${encodeURIComponent(r.id)}" class="${btn} bg-surface-container-lowest border border-[#D9DADB] text-on-surface hover:bg-surface-container-low">Detail</a>
            </div></td>
        </tr>`;
    };

    const terfilter = () => {
        const q = (search?.value || '').toLocaleLowerCase('id-ID').trim();
        return daftar.filter((r) => {
            const teks = [r.kode_order, r.customer, r.instansi, r.jenis_order].join(' ').toLocaleLowerCase('id-ID');
            return (!q || teks.includes(q))
                && (filter === 'all' || (filter === 'urgent' && r.urgent) || (filter === 'verify' && r.alur === 'verification'));
        });
    };

    const render = () => {
        const tampil = terfilter();
        rowsEl.innerHTML = tampil.length ? tampil.map(barisHtml).join('')
            : '<tr><td colspan="6" class="py-10 px-4 text-center text-secondary">Tidak ada pesanan yang perlu tindakan CS. 🎉</td></tr>';
    };

    const setLabel = (btn, teks) => {
        const target = Array.from(btn.childNodes).reverse()
            .find((n) => (n.nodeType === 3 && n.textContent.trim()) || (n.nodeType === 1 && n.tagName === 'SPAN' && !n.children.length && n.textContent.trim()));
        if (target) target.textContent = teks;
    };

    document.querySelectorAll('[data-cs-filter]').forEach((button) => {
        button.addEventListener('click', () => {
            filter = button.dataset.csFilter;
            document.querySelectorAll('[data-cs-filter]').forEach((b) => b.setAttribute('aria-pressed', String(b === button)));
            render();
        });
    });
    search?.addEventListener('input', render);

    api('/dashboard/cs').then(({ data }) => {
        daftar = data.perlu_tindakan;
        isiAngka(data);
        const cnt = {
            all: daftar.length,
            verify: daftar.filter((r) => r.alur === 'verification').length,
            urgent: daftar.filter((r) => r.urgent).length,
        };
        setLabel(document.querySelector('[data-cs-filter="all"]'), `Semua Antrean (${cnt.all})`);
        setLabel(document.querySelector('[data-cs-filter="verify"]'), `Perlu Verifikasi (${cnt.verify})`);
        setLabel(document.querySelector('[data-cs-filter="urgent"]'), `Mendesak (${cnt.urgent})`);
        if (footer) footer.textContent = `Menampilkan ${daftar.length} dari ${data.jumlah_perlu_tindakan} pesanan yang perlu tindakan`;
        render();
    }).catch((e) => {
        rowsEl.innerHTML = `<tr><td colspan="6" class="py-10 px-4 text-center text-error">${esc(e.message)}</td></tr>`;
        if (footer) footer.textContent = 'Gagal memuat data';
        toast(e.message, false);
    });
});
