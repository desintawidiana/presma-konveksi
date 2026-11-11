(() => {
    const root = document.querySelector('.cs-invoice-page');
    if (!root || root.dataset.initialized === 'true') return;
    root.dataset.initialized = 'true';

    /* =========================================================
       Helper
       ========================================================= */
    const $ = (selector, scope = document) => scope.querySelector(selector);
    const $$ = (selector, scope = document) => [...scope.querySelectorAll(selector)];
    const pad = n => String(n).padStart(2, '0');
    const esc = value => String(value ?? '').replace(/[&<>"']/g, ch => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]));

    const MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const MONTHS_LONG = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    const rupiah = value => `Rp ${Math.round(Number(value) || 0).toLocaleString('id-ID')}`;
    const fmtDate = iso => { if (!iso) return '-'; const [y, m, d] = iso.split('-').map(Number); return `${pad(d)} ${MONTHS[m - 1]} ${y}`; };
    const fmtDateLong = iso => { const [y, m, d] = iso.split('-').map(Number); return `${pad(d)} ${MONTHS_LONG[m - 1]} ${y}`; };
    const todayISO = () => { const d = new Date(); return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`; };
    const nowTime = () => { const d = new Date(); return `${pad(d.getHours())}:${pad(d.getMinutes())}`; };

    const toast = message => {
        const el = $('#invoice-toast');
        if (!el) return;
        el.textContent = message;
        el.classList.add('is-visible');
        window.clearTimeout(toast.timer);
        toast.timer = window.setTimeout(() => el.classList.remove('is-visible'), 3200);
    };

    /* =========================================================
       Data & perhitungan (satu sumber data untuk seluruh halaman)
       ========================================================= */
    let seed = {};
    try { seed = JSON.parse($('#invoice-seed')?.textContent || '{}'); } catch (error) { seed = {}; }

    const state = {
        orders: seed.orders || [],
        invoices: (seed.invoices || []).map(inv => ({ ...inv, items: (inv.items || []).map(item => ({ ...item })) })),
        payments: (seed.payments || []).map((payment, index) => ({ id: index + 1, ...payment })),
        currentCsName: seed.currentCsName || 'Customer Service',
        tab: 'invoices',
        query: '',
        status: ''
    };

    const STATUS = {
        BELUM_HARGA: { label: 'Belum input harga', css: 'status-unpaid' },
        BELUM_BAYAR: { label: 'Belum ada DP', css: 'status-warn' },
        DP: { label: 'DP masuk', css: 'status-dp' },
        LUNAS: { label: 'Lunas', css: 'status-paid' }
    };

    const orderById = id => state.orders.find(order => order.id === id);
    const invoiceByNumber = number => state.invoices.find(inv => inv.number === number);
    const invoiceOfOrder = orderId => state.invoices.find(inv => inv.order_id === orderId) || null;
    const subtotalOf = inv => inv.items.reduce((sum, item) => sum + item.qty * item.price, 0);
    const totalOf = inv => Math.max(0, subtotalOf(inv) - (Number(inv.discount) || 0) + (Number(inv.shipping_fee) || 0));
    const paymentsOf = inv => state.payments.filter(payment => payment.invoice === inv.number);
    const paidOf = inv => paymentsOf(inv).reduce((sum, payment) => sum + payment.amount, 0);
    const balanceOf = inv => Math.max(0, totalOf(inv) - paidOf(inv));
    const statusOf = inv => { const paid = paidOf(inv); return paid >= totalOf(inv) ? 'LUNAS' : paid > 0 ? 'DP' : 'BELUM_BAYAR'; };
    const qtyOf = inv => inv.items.reduce((sum, item) => sum + item.qty, 0);

    const allRows = () => state.orders
        .map(order => {
            const invoice = invoiceOfOrder(order.id);
            return { order, invoice, status: invoice ? statusOf(invoice) : 'BELUM_HARGA' };
        })
        .sort((a, b) => {
            if (!a.invoice !== !b.invoice) return a.invoice ? 1 : -1;
            if (!a.invoice) return a.order.id.localeCompare(b.order.id);
            return b.invoice.date.localeCompare(a.invoice.date) || b.invoice.number.localeCompare(a.invoice.number);
        });

    const matchesQuery = (text) => text.toLowerCase().includes(state.query.trim().toLowerCase());
    const visibleRows = () => allRows().filter(row => {
        const haystack = [row.invoice?.number, row.order.customer, row.order.id, row.order.product, row.order.spec].filter(Boolean).join(' ');
        return matchesQuery(haystack) && (!state.status || row.status === state.status);
    });
    const allPayments = () => [...state.payments].sort((a, b) => `${b.date} ${b.time}`.localeCompare(`${a.date} ${a.time}`) || b.id - a.id);
    const visiblePayments = () => allPayments().filter(payment => {
        const order = orderById(invoiceByNumber(payment.invoice)?.order_id);
        return matchesQuery([payment.invoice, order?.customer, payment.type, payment.method].filter(Boolean).join(' '));
    });

    /* =========================================================
       Render: KPI, tabel tagihan, riwayat pembayaran
       ========================================================= */
    const statusBadge = key => `<span class="invoice-status ${STATUS[key].css}">${STATUS[key].label}</span>`;

    const actionsHtml = row => {
        if (!row.invoice) {
            return `<button type="button" class="invoice-action invoice-action-primary" data-action="cost" data-order="${esc(row.order.id)}">Input Harga</button>`;
        }
        const number = esc(row.invoice.number);
        const base = `<button type="button" class="invoice-action invoice-icon-action" data-action="detail" data-invoice="${number}" title="Lihat detail" aria-label="Lihat detail invoice ${number}"><span class="material-symbols-outlined" aria-hidden="true">visibility</span></button>`
            + `<button type="button" class="invoice-action invoice-icon-action" data-action="edit" data-invoice="${number}" title="Edit harga" aria-label="Edit harga invoice ${number}"><span class="material-symbols-outlined" aria-hidden="true">edit</span></button>`;
        if (row.status === 'LUNAS') return base;
        const label = row.status === 'BELUM_BAYAR' ? 'Catat DP' : 'Catat Pelunasan';
        return `${base}<button type="button" class="invoice-action invoice-action-primary" data-action="pay" data-invoice="${number}">${label}</button>`;
    };

    const rowHtml = row => {
        const { order, invoice, status } = row;
        const product = `<td><strong>${esc(order.product)}</strong><small>${esc(order.qty)} pcs · ${esc(order.spec)}</small></td>`;
        const customer = `<td><strong>${esc(order.customer)}</strong><small>${esc(order.id)}</small></td>`;
        if (!invoice) {
            return `<tr>
                <td><strong class="invoice-number is-muted">Belum dibuat</strong><small>Menunggu rincian harga</small></td>
                ${customer}${product}
                <td class="money is-muted">—</td><td class="money is-muted text-center">—</td><td class="money is-muted text-center">—</td>
                <td class="text-center">${statusBadge(status)}</td>
                <td class="invoice-actions-cell"><div class="invoice-actions">${actionsHtml(row)}</div></td>
            </tr>`;
        }
        const paid = paidOf(invoice);
        const balance = balanceOf(invoice);
        return `<tr>
            <td><strong class="invoice-number">${esc(invoice.number)}</strong><small>${fmtDate(invoice.date)}</small></td>
            ${customer}${product}
            <td class="money">${rupiah(totalOf(invoice))}</td>
            <td class="money text-center ${paid > 0 ? 'money-blue' : 'is-muted'}">${rupiah(paid)}</td>
            <td class="money text-center ${balance > 0 ? 'money-red' : 'money-green'}">${rupiah(balance)}</td>
            <td class="text-center">${statusBadge(status)}</td>
            <td class="invoice-actions-cell"><div class="invoice-actions">${actionsHtml(row)}</div></td>
        </tr>`;
    };

    const renderKpis = () => {
        const rows = allRows();
        $$('[data-kpi]').forEach(el => { el.textContent = rows.filter(row => row.status === el.dataset.kpi).length; });
    };

    const renderInvoices = () => {
        const rows = visibleRows();
        const total = state.orders.length;
        $('#invoice-table-body').innerHTML = rows.map(rowHtml).join('');
        $('#invoice-empty').hidden = rows.length !== 0;
        $('#invoice-count').textContent = `${rows.length} data`;
        $('#invoice-visible-count').textContent = `Menampilkan ${rows.length} dari ${total} pesanan`;
        $('#tab-count-invoices').textContent = total;
    };

    const renderPayments = () => {
        const rows = visiblePayments();
        $('#payment-history-body').innerHTML = rows.map(payment => {
            const inv = invoiceByNumber(payment.invoice);
            const customer = orderById(inv?.order_id)?.customer || '-';
            return `<tr>
                <td><strong>${fmtDate(payment.date)}</strong><small>${esc(payment.time)} WIB</small></td>
                <td><strong class="invoice-number">${esc(payment.invoice)}</strong><small>${esc(customer)}</small></td>
                <td><span class="invoice-type ${payment.type === 'PELUNASAN' ? 'is-full' : ''}">${payment.type === 'PELUNASAN' ? 'Pelunasan' : 'DP'}</span></td>
                <td class="money money-green">${rupiah(payment.amount)}</td>
                <td>${esc(payment.method)}</td>
                <td>${esc(payment.by || 'CS')}</td>
                <td class="text-center">${payment.proofUrl ? `<a class="invoice-proof-link" href="${esc(payment.proofUrl)}" target="_blank" rel="noopener" title="Lihat bukti pembayaran"><span class="material-symbols-outlined" aria-hidden="true">attach_file</span><span>${esc(payment.proofName || 'Lihat bukti')}</span></a>` : '<span class="invoice-proof-empty">—</span>'}</td>
                <td><span class="invoice-status status-paid">Tercatat</span></td>
            </tr>`;
        }).join('');
        $('#payment-empty').hidden = rows.length !== 0;
        $('#payment-count').textContent = `${rows.length} data`;
        $('#tab-count-payments').textContent = state.payments.length;
    };

    const renderAll = () => { renderKpis(); renderInvoices(); renderPayments(); };

    /* =========================================================
       Tab, pencarian, filter
       ========================================================= */
    const search = $('#invoice-search');
    const statusFilter = $('#invoice-status-filter');

    const setTab = tab => {
        state.tab = tab;
        $$('.invoice-tab').forEach(item => {
            const active = item.dataset.tab === tab;
            item.classList.toggle('is-active', active);
            item.setAttribute('aria-selected', active ? 'true' : 'false');
            item.tabIndex = active ? 0 : -1;
        });
        $('#invoice-pane-invoices').hidden = tab !== 'invoices';
        $('#invoice-pane-payments').hidden = tab !== 'payments';
        statusFilter.hidden = tab !== 'invoices';
        search.placeholder = tab === 'invoices' ? 'Cari invoice, order, atau pemesan...' : 'Cari invoice, pemesan, atau metode...';
    };
    $$('.invoice-tab').forEach(tab => tab.addEventListener('click', () => setTab(tab.dataset.tab)));
    search.addEventListener('input', () => { state.query = search.value; renderInvoices(); renderPayments(); });
    statusFilter.addEventListener('change', () => { state.status = statusFilter.value; renderInvoices(); });

    /* =========================================================
       Modal
       ========================================================= */
    let lastFocus = null;
    $$('.invoice-modal').forEach(modal => modal.setAttribute('tabindex', '-1'));
    const isModalOpen = () => $$('.invoice-modal-backdrop').some(modal => !modal.hidden);

    const openModal = id => {
        const backdrop = document.getElementById(id);
        if (!backdrop) return;
        if (!isModalOpen()) lastFocus = document.activeElement;
        $$('.invoice-modal-backdrop').forEach(modal => { modal.hidden = true; });
        backdrop.hidden = false;
        document.body.classList.add('inv-modal-open');
        const target = $('.invoice-modal-body select:not([disabled]), .invoice-modal-body input:not([readonly]):not([disabled])', backdrop) || $('.invoice-modal', backdrop);
        window.setTimeout(() => target.focus({ preventScroll: true }), 30);
    };
    const closeModals = () => {
        $$('.invoice-modal-backdrop').forEach(modal => { modal.hidden = true; });
        document.body.classList.remove('inv-modal-open');
        if (lastFocus && document.contains(lastFocus)) lastFocus.focus({ preventScroll: true });
        lastFocus = null;
    };

    $$('[data-close-modal]').forEach(button => button.addEventListener('click', () => { createOrder.disabled = false; editingInvoiceNumber = null; closeModals(); }));
    $$('.invoice-modal-backdrop').forEach(backdrop => {
        let pressedOnBackdrop = false;
        backdrop.addEventListener('mousedown', event => { pressedOnBackdrop = event.target === backdrop; });
        backdrop.addEventListener('click', event => { if (event.target === backdrop && pressedOnBackdrop) closeModals(); });
    });
    document.addEventListener('keydown', event => {
        if (!isModalOpen()) return;
        if (event.key === 'Escape') { closeModals(); return; }
        if (event.key !== 'Tab') return;
        const modal = $$('.invoice-modal-backdrop').find(item => !item.hidden);
        const focusable = $$('button:not([disabled]), input:not([disabled]):not([readonly]), select:not([disabled]), textarea:not([disabled])', modal).filter(el => el.offsetParent !== null);
        if (!focusable.length) return;
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
    });

    const showError = (el, message, focusEl) => {
        el.textContent = message;
        el.hidden = false;
        if (focusEl) { focusEl.focus(); focusEl.classList?.add('is-invalid'); }
        return false;
    };
    const clearError = (el, scope) => {
        el.hidden = true;
        el.textContent = '';
        $$('.is-invalid', scope).forEach(node => node.classList.remove('is-invalid'));
    };

    /* =========================================================
       Cetak (invoice & rekap) - memakai area cetak terpisah
       ========================================================= */
    const printDocument = html => {
        let area = $('#invoice-print-root');
        if (!area) { area = document.createElement('div'); area.id = 'invoice-print-root'; document.body.appendChild(area); }
        area.innerHTML = html;
        document.body.classList.add('inv-printing');
        const cleanup = () => { document.body.classList.remove('inv-printing'); area.innerHTML = ''; window.removeEventListener('afterprint', cleanup); };
        window.addEventListener('afterprint', cleanup);
        window.print();
    };

    const paperHtml = inv => {
        const order = orderById(inv.order_id) || {};
        const total = totalOf(inv);
        const paid = paidOf(inv);
        const balance = balanceOf(inv);
        const status = statusOf(inv);
        const rows = inv.items.map((item, index) => `<tr>
            <td>${index + 1}</td>
            <td><strong>${esc(item.name)}</strong>${item.variant ? `<small>${esc(item.variant)}</small>` : ''}</td>
            <td class="center">${item.qty}</td>
            <td class="right">${rupiah(item.price)}</td>
            <td class="right">${rupiah(item.qty * item.price)}</td>
        </tr>`).join('');
        return `
            <div class="paper-top">
                <div class="paper-brand-wrap">
                    <img class="paper-logo" src="/images/Logo.png" alt="Logo Presma Konveksi">
                    <div><div class="paper-brand">PRESMA <span>KONVEKSI</span></div>
                    <p>Konveksi &amp; Produksi Pakaian</p>
                    <small>Yogyakarta · presmakonveksi.id</small></div>
                </div>
                <div class="paper-invoice-title">
                    <h1>INVOICE</h1>
                    <strong>${esc(inv.number)}</strong>
                    <small>Tanggal: ${fmtDateLong(inv.date)}</small>
                </div>
            </div>
            <div class="paper-rule"></div>
            <div class="paper-parties">
                <div><small>Ditagihkan kepada</small><strong>${esc(order.customer || '-')}</strong><span>${esc(inv.order_id)}</span></div>
                <div><small>Keterangan</small><strong>${esc(inv.description || `Pesanan ${order.product || ''}`.trim())}</strong><span>${esc(order.product || '')} · ${qtyOf(inv)} pcs</span></div>
            </div>
            <table class="paper-items">
                <thead><tr><th>No</th><th>Deskripsi item</th><th class="center">Qty</th><th class="right">Harga satuan</th><th class="right">Jumlah</th></tr></thead>
                <tbody>${rows}</tbody>
            </table>
            <div class="paper-summary">
                ${status === 'LUNAS' ? '<div class="paper-stamp">LUNAS</div>' : ''}
                <div class="paper-totals">
                    <span>Subtotal</span><strong>${rupiah(subtotalOf(inv))}</strong>
                    ${Number(inv.discount) > 0 ? `<span>Diskon</span><strong>− ${rupiah(inv.discount)}</strong>` : ''}
                    ${Number(inv.shipping_fee) > 0 ? `<span>Biaya ongkir</span><strong>${rupiah(inv.shipping_fee)}</strong>` : ''}
                    <span>Total tagihan</span><strong>${rupiah(total)}</strong>
                    <span>Pembayaran diterima</span><strong>${rupiah(paid)}</strong>
                    <span>Sisa tagihan</span><strong class="paper-balance">${rupiah(balance)}</strong>
                </div>
            </div>
            <div class="paper-bottom">
                <p>Terima kasih telah mempercayakan kebutuhan konveksi Anda kepada Presma Konveksi.</p>
                <div><span>Hormat kami,</span><strong class="paper-digital-stamp">${esc(inv.created_by || state.currentCsName)}</strong><small>Rina Handayani</small><em>Stempel Digital</em></div>
            </div>`;
    };

    const openPreview = number => {
        const inv = invoiceByNumber(number);
        if (!inv) return;
        $('#invoice-preview-title').textContent = inv.number;
        $('#invoice-print-area').innerHTML = paperHtml(inv);
        $('#invoice-preview-modal').dataset.invoice = inv.number;
        openModal('invoice-preview-modal');
    };

    const recapHtml = () => {
        const printed = `Dicetak ${fmtDateLong(todayISO())}, ${nowTime()} WIB`;
        const head = title => `<div class="recap-head"><div><div class="paper-brand">PRESMA <span>KONVEKSI</span></div><p>${title}</p></div><small>${printed}</small></div>`;
        if (state.tab === 'payments') {
            const rows = visiblePayments();
            const sum = rows.reduce((total, payment) => total + payment.amount, 0);
            return `<div class="invoice-paper invoice-recap">${head('Rekap Riwayat Pembayaran')}
                <table class="paper-items"><thead><tr><th>Tanggal</th><th>Invoice</th><th>Pemesan</th><th>Jenis</th><th>Metode</th><th class="right">Nominal</th></tr></thead><tbody>
                ${rows.map(payment => `<tr><td>${fmtDate(payment.date)} ${esc(payment.time)}</td><td>${esc(payment.invoice)}</td><td>${esc(orderById(invoiceByNumber(payment.invoice)?.order_id)?.customer || '-')}</td><td>${payment.type === 'PELUNASAN' ? 'Pelunasan' : 'DP'}</td><td>${esc(payment.method)}</td><td class="right">${rupiah(payment.amount)}</td></tr>`).join('')}
                </tbody><tfoot><tr><td colspan="5">Total pembayaran (${rows.length} catatan)</td><td class="right">${rupiah(sum)}</td></tr></tfoot></table></div>`;
        }
        const rows = visibleRows();
        const invoiced = rows.filter(row => row.invoice);
        const sum = fn => invoiced.reduce((total, row) => total + fn(row.invoice), 0);
        return `<div class="invoice-paper invoice-recap">${head('Rekap Invoice &amp; Tagihan')}
            <table class="paper-items"><thead><tr><th>Invoice</th><th>Pemesan</th><th>Produk</th><th class="right">Total</th><th class="right">Dibayar</th><th class="right">Sisa</th><th>Status</th></tr></thead><tbody>
            ${rows.map(row => `<tr><td>${esc(row.invoice?.number || '—')}</td><td>${esc(row.order.customer)}<small>${esc(row.order.id)}</small></td><td>${esc(row.order.product)}<small>${esc(row.order.qty)} pcs</small></td>
                <td class="right">${row.invoice ? rupiah(totalOf(row.invoice)) : '—'}</td><td class="right">${row.invoice ? rupiah(paidOf(row.invoice)) : '—'}</td><td class="right">${row.invoice ? rupiah(balanceOf(row.invoice)) : '—'}</td><td>${STATUS[row.status].label}</td></tr>`).join('')}
            </tbody><tfoot><tr><td colspan="3">Total (${invoiced.length} invoice)</td><td class="right">${rupiah(sum(totalOf))}</td><td class="right">${rupiah(sum(paidOf))}</td><td class="right">${rupiah(sum(balanceOf))}</td><td></td></tr></tfoot></table></div>`;
    };

    /* =========================================================
       Modal: input harga & buat invoice
       ========================================================= */
    const createForm = $('#create-invoice-form');
    const createError = $('#create-error');
    const itemBody = $('#invoice-item-rows');
    const createOrder = $('#create-order');
    let editingInvoiceNumber = null;

    const itemRowHtml = (item = {}) => `<tr>
        <td data-label="Nama item"><input class="item-name" type="text" placeholder="Nama item" value="${esc(item.name || '')}" maxlength="80" aria-label="Nama item"></td>
        <td data-label="Ukuran / varian"><input class="item-variant" type="text" placeholder="S – L, XL, All Size" value="${esc(item.variant || '')}" maxlength="40" aria-label="Ukuran atau varian"></td>
        <td data-label="Qty" class="col-qty"><input class="item-qty" type="number" min="1" step="1" inputmode="numeric" placeholder="0" value="${item.qty > 0 ? item.qty : ''}" aria-label="Kuantitas"></td>
        <td data-label="Harga satuan (Rp)" class="col-price"><input class="item-price" type="number" min="0" step="1" inputmode="numeric" placeholder="0" value="${item.price > 0 ? item.price : ''}" aria-label="Harga satuan"></td>
        <td data-label="Subtotal" class="item-subtotal col-sub">Rp 0</td>
        <td class="col-del"><button type="button" class="invoice-remove-item" aria-label="Hapus item"><span class="material-symbols-outlined" aria-hidden="true">delete</span></button></td>
    </tr>`;

    const collectItems = () => $$('tr', itemBody).map(tr => ({
        name: $('.item-name', tr).value.trim(),
        variant: $('.item-variant', tr).value.trim(),
        qty: Number($('.item-qty', tr).value),
        price: Number($('.item-price', tr).value)
    }));

    const recalcCreate = () => {
        let total = 0;
        let qty = 0;
        $$('tr', itemBody).forEach(tr => {
            const q = Number($('.item-qty', tr).value) || 0;
            const p = Number($('.item-price', tr).value) || 0;
            total += q * p;
            qty += q;
            $('.item-subtotal', tr).textContent = rupiah(q * p);
        });
        const dpInput = $('#create-dp');
        const dp = Number(dpInput.value) || 0;
        const discount = Number($('#create-discount').value) || 0;
        const finalTotal = Math.max(0, total - discount);
        $('#create-dp-method').disabled = dp <= 0;
        $('#subtotal-preview').textContent = rupiah(total);
        $('#discount-preview').textContent = rupiah(discount);
        $('#total-preview').textContent = rupiah(finalTotal);
        $('#dp-preview').textContent = rupiah(dp);
        $('#balance-preview').textContent = rupiah(Math.max(0, finalTotal - dp));
        const order = orderById(createOrder.value);
        const hint = $('#create-qty-hint');
        if (!order) { hint.textContent = ''; hint.className = 'invoice-qty-hint'; return; }
        hint.textContent = `Qty item ${qty} dari ${order.qty} pcs pesanan`;
        hint.className = `invoice-qty-hint ${qty === order.qty ? 'is-match' : 'is-diff'}`;
    };

    const setItems = items => { itemBody.innerHTML = (items?.length ? items : [{}]).map(itemRowHtml).join(''); recalcCreate(); };

    const fillOrderFields = () => {
        const order = orderById(createOrder.value);
        $('#create-customer').value = order?.customer || '';
        $('#create-product').value = order ? `${order.product} · ${order.qty} pcs` : '';
        $('#create-description').placeholder = order ? `Contoh: Pesanan ${order.product.toLowerCase()} ${order.customer}` : 'Contoh: Pesanan seragam kerja';
        const untouched = collectItems().every(item => !(item.price > 0));
        if (untouched) setItems(order ? [{ name: order.product, variant: '', qty: order.qty }] : []);
        else recalcCreate();
    };

    const openCreate = (orderId = '') => {
        editingInvoiceNumber = null;
        const available = state.orders.filter(order => !invoiceOfOrder(order.id));
        if (!available.length) { toast('Semua pesanan sudah memiliki invoice.'); return; }
        createForm.reset(); createOrder.disabled = false; clearError(createError, createForm);
        createOrder.innerHTML = `<option value="">Pilih pesanan</option>${available.map(order => `<option value="${esc(order.id)}">${esc(order.id)} · ${esc(order.customer)}</option>`).join('')}`;
        createOrder.value = available.some(order => order.id === orderId) ? orderId : (available.length === 1 ? available[0].id : '');
        $('#create-date').value = todayISO(); $('#create-discount').value = '';
        setItems([]); fillOrderFields();
        $('#create-invoice-title').textContent = 'Input Harga & Buat Invoice';
        createForm.querySelector('[type="submit"]').textContent = 'Buat & Pratinjau Invoice';
        $('#create-dp').disabled = false;
        openModal('create-invoice-modal');
    };

    const openEditInvoice = number => {
        const inv = invoiceByNumber(number); if (!inv) return;
        editingInvoiceNumber = number;
        createForm.reset(); clearError(createError, createForm);
        createOrder.innerHTML = `<option value="${esc(inv.order_id)}">${esc(inv.order_id)} · ${esc(orderById(inv.order_id)?.customer || '')}</option>`;
        createOrder.value = inv.order_id; createOrder.disabled = true;
        fillOrderFields();
        $('#create-date').value = inv.date;
        $('#create-description').value = inv.description || '';
        $('#create-discount').value = Number(inv.discount) || '';
        $('#create-dp').value = '';
        $('#create-dp').disabled = true;
        setItems(inv.items);
        $('#create-invoice-title').textContent = `Edit Harga ${inv.number}`;
        createForm.querySelector('[type="submit"]').textContent = 'Simpan Perubahan';
        openModal('create-invoice-modal');
    };

    const nextInvoiceNumber = iso => {
        const year = iso.slice(0, 4);
        const max = state.invoices
            .filter(inv => inv.number.startsWith(`INV-${year}-`))
            .reduce((highest, inv) => Math.max(highest, Number(inv.number.split('-')[2]) || 0), 0);
        return `INV-${year}-${String(max + 1).padStart(3, '0')}`;
    };

    createOrder.addEventListener('change', () => { clearError(createError, createForm); fillOrderFields(); });
    $('#invoice-add-item').addEventListener('click', () => {
        itemBody.insertAdjacentHTML('beforeend', itemRowHtml());
        recalcCreate();
        $$('tr', itemBody).pop().querySelector('.item-name').focus();
    });
    itemBody.addEventListener('input', () => { clearError(createError, createForm); recalcCreate(); });
    itemBody.addEventListener('click', event => {
        const button = event.target.closest('.invoice-remove-item');
        if (!button) return;
        const tr = button.closest('tr');
        if ($$('tr', itemBody).length > 1) tr.remove();
        else setItems([]);
        recalcCreate();
    });
    $('#create-dp').addEventListener('input', () => { clearError(createError, createForm); recalcCreate(); });
    $('#create-discount').addEventListener('input', () => { clearError(createError, createForm); recalcCreate(); });

    createForm.addEventListener('submit', event => {
        event.preventDefault();
        clearError(createError, createForm);
        const order = orderById(createOrder.value);
        const date = $('#create-date').value;
        const items = collectItems();
        const rows = $$('tr', itemBody);
        if (!order) return showError(createError, 'Pilih pesanan terlebih dahulu.', createOrder);
        if (!date) return showError(createError, 'Tanggal invoice wajib diisi.', $('#create-date'));
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            if (!item.name) return showError(createError, `Nama item pada baris ${i + 1} belum diisi.`, $('.item-name', rows[i]));
            if (!Number.isInteger(item.qty) || item.qty < 1) return showError(createError, `Qty pada baris ${i + 1} harus berupa bilangan bulat minimal 1.`, $('.item-qty', rows[i]));
            if (!(item.price > 0)) return showError(createError, `Harga satuan pada baris ${i + 1} harus lebih dari 0.`, $('.item-price', rows[i]));
        }
        const subtotal = items.reduce((sum, item) => sum + item.qty * item.price, 0);
        const discount = Number($('#create-discount').value) || 0;
        if (discount < 0 || discount > subtotal) return showError(createError, 'Diskon tidak boleh melebihi subtotal.', $('#create-discount'));
        const total = subtotal - discount;
        const dp = Number($('#create-dp').value) || 0;
        if (dp < 0) return showError(createError, 'DP tidak boleh bernilai negatif.', $('#create-dp'));
        if (!editingInvoiceNumber && dp > total) return showError(createError, `DP tidak boleh melebihi total tagihan (${rupiah(total)}).`, $('#create-dp'));

        if (editingInvoiceNumber) {
            const invoice = invoiceByNumber(editingInvoiceNumber);
            if (paidOf(invoice) > total) return showError(createError, 'Total baru lebih kecil dari pembayaran yang sudah tercatat. Sesuaikan pembayaran terlebih dahulu.', $('#create-discount'));
            Object.assign(invoice, { date, description: $('#create-description').value.trim(), items, discount, created_by: invoice.created_by || state.currentCsName });
            createOrder.disabled = false; createOrder.value = '';
            renderAll(); closeModals(); openPreview(invoice.number);
            toast(`Perubahan ${invoice.number} berhasil disimpan.`); editingInvoiceNumber = null; return;
        }

        // TODO backend: simpan invoice, detail item, diskon, dan created_by ke database.
        const invoice = {
            number: nextInvoiceNumber(date), order_id: order.id, date,
            description: $('#create-description').value.trim(), items, discount,
            created_by: state.currentCsName
        };
        state.invoices.push(invoice);
        if (dp > 0) {
            state.payments.push({
                id: Math.max(0, ...state.payments.map(payment => payment.id)) + 1,
                invoice: invoice.number, date, time: nowTime(),
                type: dp >= total ? 'PELUNASAN' : 'DP',
                amount: dp, method: $('#create-dp-method').value, by: 'CS', note: ''
            });
        }
        renderAll();
        openPreview(invoice.number);
        toast(`Invoice ${invoice.number} berhasil dibuat.`);
        createOrder.disabled = false; editingInvoiceNumber = null;
    });

    /* =========================================================
       Modal: catat pembayaran
       ========================================================= */
    const paymentForm = $('#payment-form');
    const paymentError = $('#payment-error');
    const paymentInvoice = $('#payment-invoice');
    const paymentType = $('#payment-type');
    const paymentAmount = $('#payment-amount');

    const syncPayment = source => {
        const inv = invoiceByNumber(paymentInvoice.value);
        const total = inv ? totalOf(inv) : 0;
        const paid = inv ? paidOf(inv) : 0;
        const balance = inv ? balanceOf(inv) : 0;
        $('[data-sum="total"]').textContent = rupiah(total);
        $('[data-sum="paid"]').textContent = rupiah(paid);
        $('[data-sum="balance"]').textContent = rupiah(balance);
        if (source === 'invoice') paymentType.value = paid > 0 ? 'PELUNASAN' : 'DP';
        const isFull = paymentType.value === 'PELUNASAN';
        $('#payment-shipping-field').hidden = !isFull;
        if (!isFull) $('#payment-shipping').value = '';
        paymentAmount.readOnly = isFull;
        paymentAmount.max = balance || '';
        if (isFull) paymentAmount.value = balance || '';
        else if (source === 'invoice' || source === 'type') paymentAmount.value = '';
        $('#payment-hint').textContent = !inv ? ''
            : isFull ? `Pelunasan dicatat sebesar sisa tagihan, yaitu ${rupiah(balance)}.`
                : `Nominal DP maksimal ${rupiah(balance)} (sisa tagihan).`;
    };

    const openPayment = number => {
        const open = state.invoices.filter(inv => balanceOf(inv) > 0);
        if (!open.length) { toast('Semua invoice sudah lunas.'); return; }
        paymentForm.reset();
        clearError(paymentError, paymentForm);
        paymentInvoice.innerHTML = `<option value="">Pilih invoice</option>${open.map(inv => `<option value="${esc(inv.number)}">${esc(inv.number)} · ${esc(orderById(inv.order_id)?.customer || '-')}</option>`).join('')}`;
        paymentInvoice.value = open.some(inv => inv.number === number) ? number : '';
        $('#payment-date').value = todayISO();
        syncPayment('invoice');
        openModal('payment-modal');
    };

    paymentInvoice.addEventListener('change', () => { clearError(paymentError, paymentForm); syncPayment('invoice'); });
    paymentType.addEventListener('change', () => { clearError(paymentError, paymentForm); syncPayment('type'); });
    paymentForm.addEventListener('input', () => clearError(paymentError, paymentForm));

    paymentForm.addEventListener('submit', event => {
        event.preventDefault();
        clearError(paymentError, paymentForm);
        const inv = invoiceByNumber(paymentInvoice.value);
        let amount = Number(paymentAmount.value);
        const shippingFee = paymentType.value === 'PELUNASAN' ? (Number($('#payment-shipping').value) || 0) : 0;
        if (!inv) return showError(paymentError, 'Pilih invoice terlebih dahulu.', paymentInvoice);
        if (shippingFee < 0) return showError(paymentError, 'Biaya ongkir tidak boleh negatif.', $('#payment-shipping'));
        const balanceBeforeShipping = balanceOf(inv);
        const balance = balanceBeforeShipping + shippingFee;
        if (paymentType.value === 'PELUNASAN' && paymentAmount.readOnly) { paymentAmount.value = balance; amount = balance; }
        if (!Number.isFinite(Number(paymentAmount.value)) || amount <= 0) return showError(paymentError, 'Nominal pembayaran harus lebih dari 0.', paymentAmount);
        if (amount > balance) return showError(paymentError, `Nominal melebihi sisa tagihan (${rupiah(balance)}).`, paymentAmount);
        if (!$('#payment-date').value) return showError(paymentError, 'Tanggal pembayaran wajib diisi.', $('#payment-date'));
        if (!$('#payment-method').value) return showError(paymentError, 'Pilih metode pembayaran.', $('#payment-method'));

        if (shippingFee > 0) inv.shipping_fee = (Number(inv.shipping_fee) || 0) + shippingFee;
        const proofFile = $('#payment-proof').files?.[0] || null;
        const proof = proofFile?.name || '';
        const proofUrl = proofFile ? URL.createObjectURL(proofFile) : '';
        const note = [$('#payment-note').value.trim(), proof ? `Bukti: ${proof}` : ''].filter(Boolean).join(' · ');
        const type = amount === balance ? 'PELUNASAN' : 'DP';

        // TODO backend: kirim { invoice_id, jenis, jumlah, tanggal_bayar, metode, keterangan, bukti } ke endpoint.
        state.payments.push({
            id: Math.max(0, ...state.payments.map(payment => payment.id)) + 1,
            invoice: inv.number, date: $('#payment-date').value, time: nowTime(),
            type, amount, shipping_fee: shippingFee, method: $('#payment-method').value, by: state.currentCsName, note,
            proof_name: proof, proofName: proof, proofUrl
        });
        renderAll();
        closeModals();
        toast(`${type === 'PELUNASAN' ? 'Pelunasan' : 'DP'} ${rupiah(amount)} untuk ${inv.number} tercatat.${type === 'PELUNASAN' ? ' Invoice lunas.' : ''}`);
    });

    /* =========================================================
       Modal: detail invoice
       ========================================================= */
    const openDetail = number => {
        const inv = invoiceByNumber(number);
        if (!inv) return;
        const order = orderById(inv.order_id) || {};
        const status = statusOf(inv);
        const payments = paymentsOf(inv).sort((a, b) => `${a.date} ${a.time}`.localeCompare(`${b.date} ${b.time}`));
        $('#invoice-detail-title').textContent = inv.number;
        $('#invoice-detail-modal').dataset.invoice = inv.number;
        $('#invoice-detail-content').innerHTML = `
            <div class="invoice-detail-grid">
                <div class="invoice-detail-box"><small>Pemesan</small><strong>${esc(order.customer || '-')}</strong></div>
                <div class="invoice-detail-box"><small>ID order</small><strong>${esc(inv.order_id)}</strong></div>
                <div class="invoice-detail-box"><small>Tanggal invoice</small><strong>${fmtDate(inv.date)}</strong></div>
                <div class="invoice-detail-box"><small>Status</small><strong>${statusBadge(status)}</strong></div>
            </div>
            <h3 class="invoice-detail-heading">Rincian item</h3>
            <div class="invoice-item-table-wrap">
                <table class="invoice-detail-items">
                    <thead><tr><th>Item</th><th>Varian</th><th class="right">Qty</th><th class="right">Harga satuan</th><th class="right">Subtotal</th></tr></thead>
                    <tbody>${inv.items.map(item => `<tr><td>${esc(item.name)}</td><td>${esc(item.variant || '-')}</td><td class="right">${item.qty}</td><td class="right">${rupiah(item.price)}</td><td class="right">${rupiah(item.qty * item.price)}</td></tr>`).join('')}</tbody>
                </table>
            </div>
            <dl class="invoice-totals">
                <div><dt>Subtotal</dt><dd>${rupiah(subtotalOf(inv))}</dd></div>
                ${Number(inv.discount) > 0 ? `<div><dt>Diskon</dt><dd>− ${rupiah(inv.discount)}</dd></div>` : ''}
                ${Number(inv.shipping_fee) > 0 ? `<div><dt>Biaya ongkir</dt><dd>${rupiah(inv.shipping_fee)}</dd></div>` : ''}
                <div><dt>Total tagihan</dt><dd>${rupiah(totalOf(inv))}</dd></div>
                <div><dt>Sudah dibayar</dt><dd>${rupiah(paidOf(inv))}</dd></div>
                <div class="is-balance"><dt>Sisa tagihan</dt><dd>${rupiah(balanceOf(inv))}</dd></div>
            </dl>
            <h3 class="invoice-detail-heading">Pembayaran tercatat</h3>
            ${payments.length ? `<ul class="invoice-detail-payments">${payments.map(payment => `<li>
                <span><strong>${payment.type === 'PELUNASAN' ? 'Pelunasan' : 'DP'}</strong><small>${fmtDate(payment.date)}, ${esc(payment.time)} WIB · ${esc(payment.method)}${payment.note ? ` · ${esc(payment.note)}` : ''}</small></span>
                <b>${rupiah(payment.amount)}</b></li>`).join('')}</ul>` : '<p class="invoice-detail-empty">Belum ada pembayaran yang tercatat.</p>'}`;
        const payButton = $('#invoice-detail-pay');
        payButton.hidden = balanceOf(inv) <= 0;
        payButton.lastChild.textContent = ` ${status === 'BELUM_BAYAR' ? 'Catat DP' : 'Catat Pelunasan'}`;
        openModal('invoice-detail-modal');
    };

    /* =========================================================
       Event tombol
       ========================================================= */
    $('#invoice-table-body').addEventListener('click', event => {
        const button = event.target.closest('button[data-action]');
        if (!button) return;
        const { action, invoice, order } = button.dataset;
        if (action === 'cost') openCreate(order);
        else if (action === 'detail') openDetail(invoice);
        else if (action === 'edit') openEditInvoice(invoice);
        else if (action === 'pay') openPayment(invoice);
    });

    $('#invoice-create').addEventListener('click', () => openCreate());
    $('#invoice-print').addEventListener('click', () => {
        const empty = state.tab === 'payments' ? !visiblePayments().length : !visibleRows().length;
        if (empty) { toast('Tidak ada data untuk dicetak.'); return; }
        printDocument(recapHtml());
    });
    $('#invoice-preview-print').addEventListener('click', () => {
        const inv = invoiceByNumber($('#invoice-preview-modal').dataset.invoice);
        if (inv) printDocument(`<div class="invoice-paper">${paperHtml(inv)}</div>`);
    });
    $('#invoice-detail-print').addEventListener('click', () => openPreview($('#invoice-detail-modal').dataset.invoice));
    $('#invoice-detail-pay').addEventListener('click', () => openPayment($('#invoice-detail-modal').dataset.invoice));

    /* =========================================================
       Inisialisasi
       ========================================================= */
    setTab('invoices');
    renderAll();
})();
