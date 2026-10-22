const presmaCustomers = [
    {
        id: 0,
        initials: 'FS',
        name: 'Farhan Saputra',
        badge: 'VIP Pelanggan',
        badgeClass: 'bg-emerald-50 text-emerald-800',
        org: 'BEM FEB Universitas Indonesia',
        role: 'Koordinator Divisi Pengadaan & Logistik',
        phone: '+62 812-4491-8821',
        waUrl: 'https://wa.me/6281244918821',
        email: 'farhan.saputra@ui.ac.id',
        address: 'Gedung Student Center FEB UI, Kampus UI Depok, Jl. Prof. Dr. Sumitro Djojohadikusumo, Pondok Cina, Beji, Kota Depok, Jawa Barat 16424',
        totalOrders: '3 Batch',
        totalValue: 'Rp 48.200.000',
        discipline: 'Disiplin DP',
        activeSpkCount: '3 SPK',
        lastUpdate: 'Update 10m lalu',
        orders: [
            {
                code: 'ORD-2024-0330',
                status: 'Dikonfirmasi',
                statusClass: 'bg-emerald-50 text-emerald-800',
                title: 'Korsa PDH Drill Nagata (350 pcs)',
                targetDate: 'Target: 10 Nov 2024',
                currentStage: 'Antrean Potong Pola',
                stepper: [2, 1, 0, 0, 0],
                financial: 'DP 50% (Rp 14.875.000)',
                date: '24 Okt 2024'
            },
            {
                code: 'ORD-2024-0120',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'Kaos Polo Lacoste Pique CVC (120 pcs)',
                financial: 'Lunas 100% (Rp 10.200.000)',
                invoice: 'INV-2024-0142',
                date: '14 Mei 2024'
            },
            {
                code: 'ORD-2023-0890',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'Jaket Bomber Taslan + Furing Quilting (80 pcs)',
                financial: 'Lunas 100% (Rp 13.500.000)',
                invoice: 'INV-2023-0899',
                date: '12 Des 2023'
            }
        ],
        note: 'Klien rutin repeat order tiap pelantikan pengurus dan kepanitiaan FEB UI. Lebih menyukai komunikasi terstruktur via WhatsApp group dan meminta update foto sampling bordir emblem sebelum eksekusi massal.'
    },
    {
        id: 1,
        initials: 'RA',
        name: 'Rizky Ananda',
        badge: 'Repeat Order 2x',
        badgeClass: 'bg-surface-container-high text-on-surface font-semibold',
        org: 'Himpunan Mahasiswa Mesin UGM',
        role: 'Ketua Divisi Logistik & Inventaris',
        phone: '+62 877-3912-8841',
        waUrl: 'https://wa.me/6287739128841',
        email: 'rizky.ananda.mesin@ugm.ac.id',
        address: 'Kantor HMM FT UGM, Jl. Grafika No. 2, Kampus UGM, Sinduadi, Mlati, Sleman, D.I. Yogyakarta 55281',
        totalOrders: '2 Batch',
        totalValue: 'Rp 27.500.000',
        discipline: 'Tertib Termin',
        activeSpkCount: '2 SPK',
        lastUpdate: 'Update 2 jam lalu',
        orders: [
            {
                code: 'ORD-2024-0288',
                status: 'Sedang Bordir',
                statusClass: 'bg-emerald-50 text-emerald-800',
                title: 'Kemeja PDL Ripstop Drill Bordir Punggung (180 pcs)',
                targetDate: 'Target: 28 Nov 2024',
                currentStage: 'Proses Bordir Komputer',
                stepper: [2, 2, 1, 0, 0],
                financial: 'DP 50% (Rp 9.200.000)',
                date: '08 Okt 2024'
            },
            {
                code: 'ORD-2024-0095',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'Jaket Parka Outdoor Canvas Marsoto (110 pcs)',
                financial: 'Lunas 100% (Rp 18.300.000)',
                invoice: 'INV-2024-0105',
                date: '18 Apr 2024'
            }
        ],
        note: 'Sangat teliti pada kerapatan stik bordir komputer logo fakultas. Pengiriman langsung ke Sekretariat Mahasiswa Teknik UGM.'
    },
    {
        id: 2,
        initials: 'BS',
        name: 'Budi Santoso',
        badge: 'Korporat Prioritas',
        badgeClass: 'bg-primary-fixed text-primary-container font-bold',
        org: 'PT Sinar Maju Perkasa',
        role: 'General Affairs & Procurement Manager',
        phone: '+62 813-9981-2401',
        waUrl: 'https://wa.me/6281399812401',
        email: 'budi.santoso@sinarmaju.co.id',
        address: 'Kawasan Industri Candi Blok C-12, Ngaliyan, Kota Semarang, Jawa Tengah 50181',
        totalOrders: '5 Batch',
        totalValue: 'Rp 112.400.000',
        discipline: 'PO Resmi / TOP 30',
        activeSpkCount: '5 SPK',
        lastUpdate: 'Update 1 hari lalu',
        orders: [
            {
                code: 'ORD-2024-0250',
                status: 'Quality Control',
                statusClass: 'bg-emerald-50 text-emerald-800',
                title: 'Wearpack Safety Tambang + Scotchlite 3M (500 pcs)',
                targetDate: 'Target: 15 Nov 2024',
                currentStage: 'Finishing & Steam Press',
                stepper: [2, 2, 2, 2, 1],
                financial: 'Termin 70% (Rp 58.000.000)',
                date: '29 Sep 2024'
            },
            {
                code: 'ORD-2024-0145',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'Kemeja Seragam Pabrik Taipan Tropical (320 pcs)',
                financial: 'Lunas 100% (Rp 32.400.000)',
                invoice: 'INV-2024-0188',
                date: '15 Jun 2024'
            }
        ],
        note: 'Memerlukan dokumen penagihan lengkap (Faktur Pajak, Surat Jalan rangkap 3, BAST bertandatangan). Selalu menyertakan sampel approval fisik sebelum potong bahan.'
    },
    {
        id: 3,
        initials: 'LH',
        name: 'Lutfi Hakim',
        badge: 'Pelanggan Baru',
        badgeClass: 'bg-surface-container-high text-on-surface-variant font-medium',
        org: 'DEMA UIN Sunan Kalijaga',
        role: 'Menteri Koordinator Minat & Bakat',
        phone: '+62 858-1109-4321',
        waUrl: 'https://wa.me/6285811094321',
        email: 'lutfi.hakim99@uin-suka.ac.id',
        address: 'Gedung Student Center Lt. 2 DEMA UIN Suka, Jl. Marsda Adisucipto No. 1, Caturtunggal, Depok, Sleman 55281',
        totalOrders: '1 Batch',
        totalValue: 'Rp 14.800.000',
        discipline: 'DP Masuk OK',
        activeSpkCount: '1 SPK',
        lastUpdate: 'Update 4 jam lalu',
        orders: [
            {
                code: 'ORD-2024-0312',
                status: 'Cutting Kain',
                statusClass: 'bg-emerald-50 text-emerald-800',
                title: 'Rompi Lapangan Drill Double Mesh + Sablon Reflektif (140 pcs)',
                targetDate: 'Target: 22 Nov 2024',
                currentStage: 'Potong Pola Presisi',
                stepper: [2, 1, 0, 0, 0],
                financial: 'DP 50% (Rp 7.400.000)',
                date: '19 Okt 2024'
            }
        ],
        note: 'Order perdana untuk seragam kegiatan Festival Budaya Kampus. Membutuhkan estimasi timeline yang ketat karena event berlangsung akhir bulan.'
    },
    {
        id: 4,
        initials: 'NP',
        name: 'Nadia Pratiwi',
        badge: 'Komunitas Kreatif',
        badgeClass: 'bg-surface-container-high text-on-surface font-semibold',
        org: 'Komunitas Sinema Jogja',
        role: 'Head of Merchandising & Festival Production',
        phone: '+62 819-0344-5892',
        waUrl: 'https://wa.me/6281903445892',
        email: 'nadia.cinema.jogja@gmail.com',
        address: 'Rumah Kreatif Sinema Jogja, Jl. Bantul Km 6.5, Kasihan, Bantul, D.I. Yogyakarta 55188',
        totalOrders: '2 Batch',
        totalValue: 'Rp 19.350.000',
        discipline: 'Disiplin Lunas',
        activeSpkCount: '2 SPK',
        lastUpdate: 'Update 3 hari lalu',
        orders: [
            {
                code: 'ORD-2024-0199',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'T-Shirt Heavyweight Cotton 16s Sablon Plastisol (250 pcs)',
                financial: 'Lunas 100% (Rp 11.250.000)',
                invoice: 'INV-2024-0220',
                date: '14 Agu 2024'
            },
            {
                code: 'ORD-2024-0081',
                status: 'Selesai & Diterima',
                statusClass: 'bg-surface-container text-on-surface-variant',
                title: 'Tote Bag Kanvas Lukis Premium + Zipper YKK (150 pcs)',
                financial: 'Lunas 100% (Rp 8.100.000)',
                invoice: 'INV-2024-0091',
                date: '02 Mar 2024'
            }
        ],
        note: 'Fokus pada ketebalan gramasi kain dan kualitas tinta plastisol sablon. Suka packing per piece plastik opp dengan hangtag khusus festival.'
    },
    {
        id: 5,
        initials: 'TR',
        name: 'Tika Rahayu',
        badge: 'Pelanggan Kampus',
        badgeClass: 'bg-surface-container-high text-on-surface-variant font-medium',
        org: 'Himpunan Biologi UNISA',
        role: 'Sekretaris Panitia Makrab Biologi',
        phone: '+62 822-4567-1190',
        waUrl: 'https://wa.me/6282245671190',
        email: 'tika.rahayu.bio@unisa.ac.id',
        address: 'Kampus Terpadu UNISA Yogyakarta, Jl. Siliwangi (Ringroad Barat) No. 63, Mlangi, Sleman 55292',
        totalOrders: '1 Batch',
        totalValue: 'Rp 8.750.000',
        discipline: 'DP 50% Lunas',
        activeSpkCount: '1 SPK',
        lastUpdate: 'Update 5 hari lalu',
        orders: [
            {
                code: 'ORD-2024-0322',
                status: 'Antrean Jahit',
                statusClass: 'bg-emerald-50 text-emerald-800',
                title: 'Hoodie Cotton Fleece 280gsm Bordir Dada Kiri (75 pcs)',
                targetDate: 'Target: 18 Nov 2024',
                currentStage: 'Perakitan & Jahit Obras',
                stepper: [2, 2, 1, 0, 0],
                financial: 'DP 50% (Rp 4.375.000)',
                date: '21 Okt 2024'
            }
        ],
        note: 'Pesanan jaket angkatan makrab 2024. Telah menyetujui color swatch sage green fleece dan benang bordir putih gading.'
    }
];

// Frontend preview: perubahan hanya hidup di memori tab ini. Backend tidak disentuh.
document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('.cs-customer-page');
    if (!page) return;
    const table = document.getElementById('customerDirectoryTable');
    const tbody = table.querySelector('tbody');
    const drawer = document.getElementById('customer-detail-drawer');
    const addModal = document.getElementById('modal-entri-kontak');
    const editModal = document.getElementById('customer-edit-modal');
    const editForm = document.getElementById('customerEditForm');
    const createForm = document.getElementById('customerCreateForm');
    const search = document.getElementById('customerSearch');
    const category = document.getElementById('customerCategory');
    let activeFilter = 'all', ascending = true, activeId = null, editingId = null;
    let lastFocus = null;
    const escapeHTML = v => String(v ?? '').replace(/[&<>"']/g, ch => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch]));
    const byId = id => presmaCustomers.find(c => c.id === Number(id));
    const text = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val || '—'; };
    const waHref = phone => 'https://wa.me/' + String(phone || '').replace(/\D/g, '').replace(/^0/, '62');
    const lockBody = () => document.body.classList.toggle('cs-modal-open', !drawer.classList.contains('hidden') || !editModal.classList.contains('hidden') || !addModal.classList.contains('hidden'));
    const show = el => { el.classList.remove('hidden'); lockBody(); };
    const hide = el => { el.classList.add('hidden'); lockBody(); };
    const cityFromAddress = a => /Semarang/i.test(a) ? 'Semarang' : /Bantul/i.test(a) ? 'Bantul, DIY' : /Sleman/i.test(a) ? 'Sleman, DIY' : /Depok|Jawa Barat/i.test(a) ? 'Kota Depok' : 'Yogyakarta';
    const categoryFor = c => c.category || (/^PT\b|industri|perusahaan/i.test(c.org) ? 'Korporat & Industri' : /komunitas/i.test(c.org) ? 'Komunitas Kreatif' : 'Kampus & Organisasi');
    presmaCustomers.forEach(c => { c.code = c.code || ('CUST-' + String(142 - c.id).padStart(4, '0')); c.city = c.city || cityFromAddress(c.address); c.category = categoryFor(c); });

    function updateRow(c) {
        const row = tbody.querySelector(`[data-index="${c.id}"]`); if (!row) return;
        const cells = row.querySelectorAll('td');
        cells[0].textContent = c.code;
        cells[1].innerHTML = `<div class="flex items-center gap-3"><div class="cs-customer-avatar">${escapeHTML(c.initials)}</div><div class="min-w-0"><div class="cs-customer-name">${escapeHTML(c.name)} <span class="cs-customer-selected-tag ${activeId === c.id ? '' : 'hidden'}">Terpilih</span></div><div class="cs-customer-org">${escapeHTML(c.org)}</div></div></div>`;
        cells[2].innerHTML = `<a class="cs-customer-phone-link" href="${waHref(c.phone)}" target="_blank" rel="noopener noreferrer"><span class="material-symbols-outlined text-[15px]">chat</span>${escapeHTML(c.phone)}</a>`;
        cells[3].textContent = c.city;
        cells[4].innerHTML = `<span class="cs-customer-count">${escapeHTML(c.totalOrders)}</span>`;
        const last = c.orders[0];
        cells[5].innerHTML = last ? `<div class="font-semibold text-[#830909]">${escapeHTML(last.code)}</div><small class="text-on-surface-variant">${escapeHTML(last.date)}</small>` : '<span class="text-on-surface-variant">Belum ada order</span>';
        cells[6].innerHTML = `<div class="cs-customer-actions"><button type="button" data-open-customer="${c.id}" class="cs-customer-detail-action"><span class="material-symbols-outlined text-[15px]">visibility</span> Detail</button><button type="button" data-edit-customer="${c.id}" class="cs-customer-edit-row"><span class="material-symbols-outlined text-[15px]">edit</span> Edit</button></div>`;
        row.classList.toggle('cs-customer-row-selected', activeId === c.id);
        row.setAttribute('aria-selected', String(activeId === c.id));
    }
    function redraw() { presmaCustomers.forEach(updateRow); filterRows(); }
    function filterRows() {
        const q = (search?.value || '').trim().toLowerCase(); let shown = 0;
        tbody.querySelectorAll('.customer-row').forEach(row => {
            const c = byId(row.dataset.index); if (!c) return;
            const matchText = [c.code, c.name, c.org, c.phone, c.city, c.email].join(' ').toLowerCase().includes(q);
            const matchCategory = !category || category.value === 'Semua Kategori' || category.value === categoryFor(c);
            const matchQuick = activeFilter === 'all' || (activeFilter === 'repeat' && parseInt(c.totalOrders, 10) > 1) || (activeFilter === 'active' && c.orders.some(o => !o.status.includes('Selesai'))) || (activeFilter === 'diy' && /Yogyakarta|Sleman|Bantul/i.test(c.city));
            row.hidden = !(matchText && matchCategory && matchQuick); if (!row.hidden) shown++;
        });
        let summary = document.getElementById('customerVisibleSummary');
        if (!summary) { summary = document.createElement('p'); summary.id = 'customerVisibleSummary'; summary.className = 'cs-customer-visible-summary'; table.parentElement.after(summary); }
        summary.textContent = shown ? `Menampilkan ${shown} pelanggan dari ${presmaCustomers.length} data pratinjau.` : 'Tidak ada pelanggan yang sesuai filter.';
    }
    function populateDetail(c) {
        text('detailInitials', c.initials); text('customerDrawerTitle', c.name);
        text('detailOrganization', `${c.org} • ${c.role}`); text('detailBadge', c.badge);
        text('detailCount', c.totalOrders); text('detailValue', c.totalValue);
        text('detailPhone', c.phone); text('detailEmail', c.email);
        text('detailAddress', c.address); text('detailNote', c.note);
        const wa = document.getElementById('detailWa'); wa.href = waHref(c.phone);
        const orders = document.getElementById('detailOrders');
        orders.innerHTML = c.orders.length ? c.orders.map(o => `<div class="cs-customer-order-item"><div class="flex flex-wrap items-center gap-2"><strong>${escapeHTML(o.code)}</strong><span class="cs-customer-order-badge">${escapeHTML(o.status)}</span></div><p>${escapeHTML(o.title)}</p><small>${escapeHTML(o.financial)} • ${escapeHTML(o.date)}</small></div>`).join('') : '<p>Belum ada riwayat pesanan.</p>';
    }
    function openDetail(id) {
        const c = byId(id); if (!c) return;
        activeId = c.id; lastFocus = document.activeElement;
        populateDetail(c); redraw(); show(drawer); drawer.querySelector('[data-close-drawer]')?.focus();
    }
    function openEdit(id) {
        const c = byId(id); if (!c) return;
        editingId = c.id; activeId = c.id; lastFocus = document.activeElement;
        const fields = ['name', 'phone', 'category', 'org', 'city', 'email', 'role', 'address', 'note'];
        fields.forEach(k => { editForm.elements[k].value = c[k] || ''; });
        redraw(); show(editModal); editForm.elements.name.focus();
    }
    function closeDetail() { hide(drawer); lastFocus?.focus?.(); }
    function closeEdit() { hide(editModal); lastFocus?.focus?.(); }
    tbody.addEventListener('click', e => {
        if (e.target.closest('a')) return;
        const edit = e.target.closest('[data-edit-customer]'); if (edit) { openEdit(edit.dataset.editCustomer); return; }
        const detail = e.target.closest('[data-open-customer]'); if (detail) { openDetail(detail.dataset.openCustomer); return; }
        const row = e.target.closest('.customer-row'); if (row) openDetail(row.dataset.index);
    });
    tbody.addEventListener('keydown', e => { const row = e.target.closest('.customer-row'); if (e.target === row && (e.key === 'Enter' || e.key === ' ')) { e.preventDefault(); openDetail(row.dataset.index); } });
    document.getElementById('customerEditInDrawer')?.addEventListener('click', () => { hide(drawer); openEdit(activeId); });
    editForm.addEventListener('submit', e => {
        e.preventDefault(); const c = byId(editingId); if (!c) return;
        for (const key of ['name', 'phone', 'category', 'org', 'city', 'email', 'role', 'address', 'note']) c[key] = editForm.elements[key].value.trim();
        c.initials = c.name.split(/\s+/).slice(0, 2).map(x => x[0] || '').join('').toUpperCase();
        c.waUrl = waHref(c.phone);
        hide(editModal); populateDetail(c); redraw(); show(drawer);
    });
    editModal.querySelectorAll('[data-close-edit]').forEach(btn => btn.addEventListener('click', closeEdit));
    editModal.addEventListener('click', e => { if (e.target === editModal) closeEdit(); });
    drawer.querySelectorAll('[data-close-drawer]').forEach(btn => btn.addEventListener('click', closeDetail));
    drawer.addEventListener('click', e => { if (e.target === drawer) closeDetail(); });
    document.getElementById('customerOpenModal')?.addEventListener('click', () => { lastFocus = document.activeElement; createForm.reset(); show(addModal); createForm.elements.name.focus(); });
    addModal.querySelectorAll('[data-close-modal]').forEach(btn => btn.addEventListener('click', () => hide(addModal)));
    addModal.addEventListener('click', e => { if (e.target === addModal) hide(addModal); });
    document.addEventListener('keydown', e => { if (e.key !== 'Escape') return; if (!editModal.classList.contains('hidden')) closeEdit(); else if (!addModal.classList.contains('hidden')) hide(addModal); else if (!drawer.classList.contains('hidden')) closeDetail(); });
    createForm.addEventListener('submit', e => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(createForm).entries());
        const id = Math.max(-1, ...presmaCustomers.map(c => c.id)) + 1;
        const codes = presmaCustomers.map(c => Number((c.code || '').replace(/\D/g, ''))).filter(Number.isFinite);
        const code = 'CUST-' + String(Math.max(142, ...codes) + 1).padStart(4, '0');
        const c = {
            id, code, ...data, initials: data.name.trim().split(/\s+/).slice(0, 2).map(w => w[0] || '').join('').toUpperCase(),
            badge: 'Pelanggan Baru', totalOrders: '0x Order', totalValue: 'Rp 0', orders: [], waUrl: waHref(data.phone)
        };
        presmaCustomers.push(c);
        const row = document.createElement('tr'); row.className = 'customer-row hover:bg-surface-container transition-colors cursor-pointer';
        row.dataset.index = String(id); row.setAttribute('tabindex', '0'); row.setAttribute('role', 'button');
        row.innerHTML = '<td></td>'.repeat(7); tbody.prepend(row);
        activeFilter = 'all'; search.value = ''; category.value = 'Semua Kategori';
        page.querySelectorAll('[data-filter]').forEach(b => { b.classList.toggle('cs-customer-filter-active', b.dataset.filter === 'all'); b.setAttribute('aria-pressed', String(b.dataset.filter === 'all')); });
        hide(addModal); activeId = id; redraw(); openDetail(id);
    });
    search?.addEventListener('input', filterRows); category?.addEventListener('change', filterRows);
    page.querySelectorAll('[data-filter]').forEach(btn => btn.addEventListener('click', () => { activeFilter = btn.dataset.filter; page.querySelectorAll('[data-filter]').forEach(b => { b.classList.toggle('cs-customer-filter-active', b === btn); b.setAttribute('aria-pressed', String(b === btn)); }); filterRows(); }));
    document.getElementById('customerSort')?.addEventListener('click', () => { ascending = !ascending; presmaCustomers.slice().sort((a, b) => ascending ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name)).forEach(c => { const r = tbody.querySelector(`[data-index="${c.id}"]`); if (r) tbody.appendChild(r); }); filterRows(); });
    document.getElementById('customerExport')?.addEventListener('click', () => {
        const out = [['ID', 'Nama', 'Instansi', 'WhatsApp', 'Kota', 'Total Order']];
        tbody.querySelectorAll('.customer-row:not([hidden])').forEach(r => { const c = byId(r.dataset.index); out.push([c.code, c.name, c.org, c.phone, c.city, c.totalOrders]); });
        const csv = '\uFEFF' + out.map(line => line.map(v => '"' + String(v).replaceAll('"', '""') + '"').join(',')).join('\r\n');
        const u = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' })); const a = document.createElement('a'); a.href = u; a.download = 'presma-customer-preview.csv'; a.click(); setTimeout(() => URL.revokeObjectURL(u), 1000);
    });
    redraw();
});
