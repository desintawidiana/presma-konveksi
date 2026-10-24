// Frontend-only CS Order preview. No database or API writes.
const startCSOrder = () => {
    const page = document.querySelector('.cs-order-page');
    if (!page) return;
    const table = page.querySelector('#csOrderTable');
    const search = page.querySelector('#csOrderSearch');
    const payment = page.querySelector('[data-cs-filter="payment"]');
    const category = page.querySelector('[data-cs-filter="category"]');
    const createModal = page.querySelector('#csOrderCreateModal');
    const detailModal = page.querySelector('#csOrderDetailModal');
    const createForm = page.querySelector('#csOrderCreateForm');
    let activeTab = 'all';
    const toast = (message) => {
        page.querySelector('.cs-order-toast')?.remove();
        const node = document.createElement('div');
        node.className = 'cs-order-toast';
        node.textContent = message;
        page.appendChild(node);
        window.setTimeout(() => node.remove(), 2800);
    };
    const rows = () => Array.from(table?.querySelectorAll('tbody tr[data-order-row]') || []);
    // Sinkronisasi perubahan dari halaman Detail Order saat kembali ke tabel.
    const escText = value => String(value ?? '');
    const reloadEdits = () => rows().forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length < 9) return;
        const code = cells[0].textContent.trim();
        let d = null;
        try { d = JSON.parse(sessionStorage.getItem('presma.cs.order.' + code) || 'null'); } catch (_) { }
        if (!d || !d.lastEditedAt && !d.verifiedAt && !d.revisionReason) return;
        const cs = cells[2].querySelectorAll('span');
        if (cs[0] && d.customer) cs[0].textContent = escText(d.customer);
        if (cs[1] && d.organization) cs[1].textContent = escText(d.organization);
        if (d.product) { const first = cells[3].querySelector('span'); if (first) first.textContent = escText(d.product); else cells[3].textContent = escText(d.product); }
        if (d.status) {
            const pill = cells[5].querySelector('span');
            if (pill) { pill.textContent = escText(d.status); pill.classList.remove('bg-amber-100', 'text-amber-900', 'bg-emerald-100', 'text-emerald-900'); pill.classList.add(d.status.includes('Terverifikasi') ? 'bg-emerald-100' : 'bg-amber-100', d.status.includes('Terverifikasi') ? 'text-emerald-900' : 'text-amber-900'); }
            row.dataset.stage = d.stage || 'verification';
        }
    });
    reloadEdits();
    const workflowStage = d => d.workflowStage || (d.verifiedAt ? 'payment' : d.stage === 'ready' ? 'ready' : d.stage === 'production' ? 'tracking' : 'verification');
    const actionByStage = { verification: 'Verifikasi', payment: 'Pembayaran', wo: 'Upload WO', tracking: 'Tracking', settlement: 'Pelunasan', ready: 'Siap Kirim', handover: 'Selesai', completed: 'Selesai' };
    const syncRowActions = row => {
        const cells = row.querySelectorAll('td'); if (cells.length < 9) return;
        const code = cells[0].textContent.trim(); let d = {};
        try { d = JSON.parse(sessionStorage.getItem('presma.cs.order.' + code) || '{}') || {}; } catch (e) { }
        const stage = workflowStage({ ...{ stage: row.dataset.stage }, ...d });
        // Render status pembayaran sebagai badge, tanpa menampilkan kode ikon mentah.
        const rawPayment = d.payment || cells[6].dataset.paymentLabel || cells[6].textContent;
        const paymentLabel = String(rawPayment || 'Belum Bayar')
            .replace(/check_circle|verified|pending|\u2713|\u2714|\u2717/gi, '')
            .replace(/\s+/g, ' ').trim() || 'Belum Bayar';
        cells[6].dataset.paymentLabel = paymentLabel;
        const paymentKind = /tanpa\s*dp/i.test(paymentLabel) ? 'exception'
            : /lunas|100\s*%/i.test(paymentLabel) ? 'paid'
                : /dp|masuk|diterima/i.test(paymentLabel) ? 'dp' : 'unpaid';
        const paymentStyles = {
            paid: 'background:#d1fae5;color:#065f46',
            dp: 'background:#d1fae5;color:#065f46',
            exception: 'background:#dbeafe;color:#1e40af',
            unpaid: 'background:#fef3c7;color:#92400e'
        };
        const paymentPill = document.createElement('span');
        paymentPill.className = 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold';
        paymentPill.style.cssText = paymentStyles[paymentKind] + ';white-space:nowrap;';
        const paymentIcon = document.createElement('span');
        paymentIcon.textContent = paymentKind === 'unpaid' ? '!' : '\u2713';
        paymentIcon.setAttribute('aria-hidden', 'true');
        const paymentName = document.createElement('span');
        paymentName.textContent = paymentLabel;
        paymentPill.append(paymentIcon, paymentName);
        cells[6].replaceChildren(paymentPill);
        row.dataset.payment = paymentKind === 'paid' ? 'lunas' : paymentKind === 'dp' ? 'dp' : 'belum';
        if (d.owner) { const p = cells[4].querySelector('.font-semibold'); if (p) p.textContent = d.owner; else cells[4].textContent = d.owner; }
        row.dataset.stage = stage === 'verification' ? 'verification' : stage === 'payment' || stage === 'wo' ? 'verification' : stage === 'tracking' || stage === 'settlement' ? 'production' : stage === 'ready' || stage === 'handover' || stage === 'completed' ? 'ready' : 'verification';
        const bClass = 'inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg border border-[#D9DADB] font-semibold text-[12px] whitespace-nowrap hover:bg-[#f3f4f4]';
        const actionClass = bClass + ' bg-[#830909] text-white border-[#830909] hover:bg-[#6b0707]';
        cells[8].innerHTML = `<div class="flex items-center justify-center gap-1.5 flex-wrap"><button type="button" class="${bClass}" data-cs-action="detail">Detail</button><button type="button" class="${actionClass}" data-cs-action="next" ${stage === 'completed' ? 'disabled' : ''}>${actionByStage[stage] || 'Verifikasi'}</button></div>`;
    };
    rows().forEach(syncRowActions);
    // Deadline di tanggal order, tanpa menambah kolom yang merusak pemetaan indeks tabel.
    const deadlineLabel = value => {
        if (!value) return 'Belum ditentukan';
        const parsed = /^\d{4}-\d{2}-\d{2}$/.test(value) ? new Date(value + 'T12:00:00') : null;
        return parsed && !Number.isNaN(parsed.getTime()) ? parsed.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : String(value);
    };
    rows().forEach(row => {
        const cells = row.querySelectorAll('td'); if (cells.length < 9) return;
        const code = cells[0].textContent.trim();
        let order = {}; try { order = JSON.parse(sessionStorage.getItem('presma.cs.order.' + code) || '{}') || {}; } catch (e) { }
        // Hanya deadline yang diketahui dari contoh Stitch. Jangan membuat tanggal untuk pesanan lain.
        const deadline = order.deadline || (code === 'ORD-2024-0330' ? '2024-11-05' : '');
        let badge = cells[1].querySelector('.cs-table-deadline');
        if (!badge) { badge = document.createElement('span'); badge.className = 'cs-table-deadline'; cells[1].appendChild(badge); }
        badge.textContent = 'Deadline: ' + deadlineLabel(deadline);
        if (deadline) row.dataset.deadline = deadline;
    });


    const updateFilters = () => {
        const q = (search?.value || '').toLocaleLowerCase('id-ID').trim();
        let count = 0;
        rows().forEach(row => {
            const matches = (!q || row.textContent.toLocaleLowerCase('id-ID').includes(q)) &&
                (!payment || payment.value === 'all' || row.dataset.payment === payment.value) &&
                (!category || category.value === 'all' || row.dataset.category === category.value) &&
                (activeTab === 'all' || row.dataset.stage === activeTab);
            row.hidden = !matches;
            row.style.display = matches ? '' : 'none';
            if (matches) count++;
        });
        const summary = page.querySelector('[data-cs-summary]');
        if (summary) summary.textContent = `Menampilkan ${count} dari ${rows().length} order contoh`;
    };
    page.querySelectorAll('[data-cs-tab]').forEach(button => button.addEventListener('click', () => {
        activeTab = button.dataset.csTab;
        page.querySelectorAll('[data-cs-tab]').forEach(b => b.classList.toggle('cs-tab-active', b === button));
        updateFilters();
    }));
    page.querySelectorAll('[data-cs-tab]').forEach(b => b.classList.toggle('cs-tab-active', b.dataset.csTab === activeTab));
    search?.addEventListener('input', updateFilters);
    payment?.addEventListener('change', updateFilters);
    category?.addEventListener('change', updateFilters);
    const openModal = modal => { if (modal) { modal.classList.remove('hidden'); modal.querySelector('button, input')?.focus(); } };
    const closeModals = () => { createModal?.classList.add('hidden'); detailModal?.classList.add('hidden'); };
    page.querySelectorAll('[data-order-close]').forEach(b => b.addEventListener('click', closeModals));
    [createModal, detailModal].forEach(modal => modal?.addEventListener('click', e => { if (e.target === modal) closeModals(); }));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModals(); });
    const topCreate = Array.from(page.querySelectorAll('button')).find(b => b.textContent.includes('Tambah Order Baru'));
    topCreate?.addEventListener('click', () => openModal(createModal));
    const getData = row => {
        const tds = row?.querySelectorAll('td');
        if (!tds || tds.length < 9) return null;
        return {
            code: tds[0].textContent.trim(), customer: tds[2].querySelector('span')?.textContent.trim() || tds[2].textContent.trim(),
            product: tds[3].textContent.trim(), owner: tds[4].textContent.trim(), status: tds[5].textContent.trim(),
            payment: tds[6].textContent.trim(), amount: tds[7].textContent.trim()
        };
    };
    // Membuka detail berdasarkan baris yang diklik, bukan modal statis.
    const openDetail = (row, action = 'detail') => {
        const d = getData(row);
        if (!d) return;
        const cells = row.querySelectorAll('td');
        const record = {
            ...d,
            organization: cells[2]?.querySelectorAll('span')[1]?.textContent.trim() || '',
            date: cells[1]?.textContent.replace(/\s+/g, ' ').trim() || '',
            stage: row.dataset.stage || '',
            paymentCode: row.dataset.payment || '',
            notes: row.querySelector('small')?.textContent.trim() || ''
        };
        // Jangan menimpa data edit/verifikasi yang tersimpan dari halaman detail.
        try {
            const saved = JSON.parse(sessionStorage.getItem('presma.cs.order.' + record.code) || 'null');
            if (saved && typeof saved === 'object') Object.assign(record, saved);
            sessionStorage.setItem('presma.cs.order.' + record.code, JSON.stringify(record));
        } catch (_) { /* Tetap bisa masuk halaman meski storage browser diblokir. */ }
        const base = page.dataset.detailUrl || '/preview-order/detail';
        window.location.assign(base + '?code=' + encodeURIComponent(record.code) + (action === 'next' ? '&action=next' : ''));
    };
    table?.addEventListener('click', e => {
        const btn = e.target.closest('[data-cs-action], a[href*="preview-order/detail"]');
        const row = e.target.closest('tr[data-order-row]');
        if (!row) return;
        if (!btn) { openDetail(row); return; }
        const action = btn.dataset.csAction || 'detail';
        if (action === 'detail' || action === 'verify' || action === 'next') {
            e.preventDefault();
            openDetail(row, action);
        } else if (action === 'tracking') {
            toast('Tracking produksi akan dihubungkan oleh backend.');
        }
    });
    const esc = text => String(text ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    createForm?.addEventListener('submit', e => {
        e.preventDefault();
        if (!createForm.reportValidity()) return;
        const fd = new FormData(createForm);
        const customer = String(fd.get('customer') || '').trim();
        const org = String(fd.get('organization') || '').trim();
        const product = String(fd.get('product') || '').trim();
        const qty = Number(fd.get('quantity') || 0);
        const unitPrice = Number(fd.get('unitPrice') || 0);
        const deadline = String(fd.get('deadline') || '');
        if (!customer || !product || qty <= 0 || !/^\d{4}-\d{2}-\d{2}$/.test(deadline)) return;
        const code = `DRAFT-${Date.now().toString().slice(-7)}`;
        const amount = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(qty * unitPrice);
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-surface-container-low transition-colors cursor-pointer';
        tr.dataset.orderRow = 'true'; tr.dataset.payment = 'belum'; tr.dataset.stage = 'verification';
        const pl = product.toLowerCase(); tr.dataset.category = pl.includes('korsa') || pl.includes('pdh') ? 'korsa' : pl.includes('jaket') || pl.includes('rompi') ? 'jaket' : pl.includes('polo') || pl.includes('kaos') ? 'kaos' : 'other';
        tr.innerHTML = `<td class="font-semibold text-primary">${esc(code)}</td><td>${esc(new Date().toLocaleDateString('id-ID'))}</td><td><span class="font-semibold">${esc(customer)}</span><span class="block text-secondary">${esc(org)}</span></td><td>${esc(product)} <small class="block">${qty} pcs</small></td><td>Belum ditugaskan</td><td>Menunggu Verifikasi CS <small class="block">Deadline: ${esc(deadline)}</small></td><td>Belum Bayar</td><td class="text-right">${esc(amount)}</td><td class="text-center"><button type="button" data-cs-action="detail" class="bg-[#830909] text-white rounded-lg px-3 py-2">Detail Pesanan</button></td>`;
        table.querySelector('tbody')?.prepend(tr);
        search.value = ''; payment.value = 'all'; category.value = 'all'; activeTab = 'verification';
        page.querySelectorAll('[data-cs-tab]').forEach(b => b.classList.toggle('cs-tab-active', b.dataset.csTab === 'verification'));
        syncRowActions(tr); updateFilters(); closeModals(); createForm.reset(); toast('Order contoh ditambahkan ke antrean (belum tersimpan ke database).');
    });
    // Demo dataset only: pagination buttons are intentionally inactive.
    const pagination = page.querySelector('[data-cs-summary]')?.parentElement;
    pagination?.querySelectorAll('button').forEach(b => {
        b.disabled = true;
        b.title = 'Pagination menunggu integrasi backend';
        b.style.opacity = '.55';
    });
    // Export CSV uses only rows already in the preview, not Excel format.
    const exportBtn = Array.from(page.querySelectorAll('button')).find(b => b.textContent.includes('Export Data'));
    if (exportBtn) {
        exportBtn.querySelector('span:last-child').textContent = 'Export Data (.CSV)'; exportBtn.addEventListener('click', () => {
            const header = ['Kode Order', 'Tanggal', 'Pelanggan', 'Produk', 'PJ', 'Status', 'Pembayaran', 'Total'];
            const csv = [header, ...rows().map(r => { const t = r.querySelectorAll('td'); return [0, 1, 2, 3, 4, 5, 6, 7].map(i => t[i]?.textContent.trim().replace(/\s+/g, ' ') || ''); })].map(cells => cells.map(v => '"' + v.replace(/"/g, '""') + '"').join(',')).join('\r\n');
            const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' }); const url = URL.createObjectURL(blob); const link = document.createElement('a'); link.href = url; link.download = 'presma-cs-order-preview.csv'; link.click(); URL.revokeObjectURL(url);
        });
    }
    updateFilters();
};
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', startCSOrder); else startCSOrder();
