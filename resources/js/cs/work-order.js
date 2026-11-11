document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('wo-overlay');
    const drawer = document.getElementById('wo-drawer');
    const modal = document.getElementById('wo-modal');
    const tbody = document.getElementById('wo-table-body');
    if (!overlay || !drawer || !modal || !tbody) return;

    let activeReviewRow = null;
    const openDrawer = () => { overlay.hidden = false; drawer.classList.add('is-open'); drawer.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; };
    const closeDrawer = () => { drawer.classList.remove('is-open'); drawer.setAttribute('aria-hidden', 'true'); overlay.hidden = true; document.body.style.overflow = ''; };
    const openDetail = () => { modal.hidden = false; document.body.style.overflow = 'hidden'; };
    const closeDetail = () => { modal.hidden = true; document.body.style.overflow = ''; activeReviewRow = null; };
    document.getElementById('wo-open-upload')?.addEventListener('click', openDrawer);
    ['wo-close-upload', 'wo-cancel-upload'].forEach(id => document.getElementById(id)?.addEventListener('click', closeDrawer));
    overlay.addEventListener('click', closeDrawer);
    ['wo-modal-close', 'wo-modal-cancel'].forEach(id => document.getElementById(id)?.addEventListener('click', closeDetail));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeDrawer(); closeDetail(); } });

    const fileRadio = document.querySelectorAll('input[name="wo-source"]');
    const fileZone = document.getElementById('wo-file-zone'), linkZone = document.getElementById('wo-link-zone');
    fileRadio.forEach(r => r.addEventListener('change', () => {
        const useFile = document.querySelector('input[name="wo-source"]:checked')?.value === 'file';
        fileZone.hidden = !useFile; linkZone.hidden = useFile;
        document.getElementById('wo-file').required = useFile;
        document.getElementById('wo-file-url').required = !useFile;
    }));
    const search = document.getElementById('wo-search'), filter = document.getElementById('wo-filter');
    const refreshStats = () => {
        const rows = [...tbody.querySelectorAll('tr[data-status]')];
        document.getElementById('wo-count-total').textContent = rows.length;
        document.getElementById('wo-count-review').textContent = rows.filter(r => r.dataset.status === 'PERLU_DIPERIKSA').length;
        document.getElementById('wo-count-ready').textContent = rows.filter(r => r.dataset.status === 'SIAP_DITERUSKAN').length;
        document.getElementById('wo-count-sent').textContent = rows.filter(r => r.dataset.status === 'DITERUSKAN').length;
    };
    let currentPage = 1; let pageSize = 10;
    document.getElementById('wo-page-size')?.addEventListener('change', e => { pageSize = Number(e.target.value) || 10; currentPage = 1; applyFilters(); });
    const applyFilters = () => {
        const keyword = (search?.value || '').trim().toLowerCase(), selected = filter?.value || '';
        const rows = [...tbody.querySelectorAll('tr[data-status]')];
        const matched = rows.filter(r => (!keyword || (r.dataset.search || '').includes(keyword)) && (!selected || r.dataset.status === selected));
        const pages = Math.max(1, Math.ceil(matched.length / pageSize)); currentPage = Math.min(currentPage, pages);
        rows.forEach(r => r.hidden = true);
        const begin = (currentPage - 1) * pageSize; matched.slice(begin, begin + pageSize).forEach(r => r.hidden = false);
        let empty = tbody.querySelector('.cs-wo-empty-row');
        if (!matched.length) { if (!empty) { empty = document.createElement('tr'); empty.className = 'cs-wo-empty-row'; empty.innerHTML = '<td colspan="9" class="cs-wo-empty">Data Work Order tidak ditemukan.</td>'; tbody.appendChild(empty); } empty.hidden = false; } else if (empty) empty.hidden = true;
        document.getElementById('wo-page-info').textContent = matched.length ? `Menampilkan ${begin + 1}–${Math.min(begin + pageSize, matched.length)} dari ${matched.length} data` : 'Tidak ada data untuk ditampilkan';
        document.getElementById('wo-page-current').textContent = `${currentPage} / ${pages}`;
        document.getElementById('wo-prev-page').disabled = currentPage <= 1; document.getElementById('wo-next-page').disabled = currentPage >= pages;
    };
    search?.addEventListener('input', () => { currentPage = 1; applyFilters(); });
    filter?.addEventListener('change', () => { currentPage = 1; applyFilters(); });
    document.getElementById('wo-prev-page')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; applyFilters(); } });
    document.getElementById('wo-next-page')?.addEventListener('click', () => { currentPage++; applyFilters(); });

    const statusLabel = s => ({ PERLU_DIPERIKSA: '<span class="cs-wo-status cs-wo-status-review">Menunggu Pemeriksaan</span>', SIAP_DITERUSKAN: '<span class="cs-wo-status cs-wo-status-ready">Siap Diteruskan</span>', DITERUSKAN: '<span class="cs-wo-status cs-wo-status-sent"><span class="material-symbols-outlined">check_circle</span> Diteruskan ke Produksi</span>' }[s] || '');
    const esc = v => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));
    const rowData = row => { const c = row.querySelectorAll('td'); return { wo: c[0]?.innerText.trim(), order: c[1]?.innerText.trim(), customer: c[2]?.querySelector('strong')?.innerText.trim(), company: c[2]?.querySelector('small')?.innerText.trim(), product: c[3]?.innerText.trim(), designer: c[4]?.innerText.trim(), status: row.dataset.status, file: c[6]?.innerText.trim(), url: c[6]?.querySelector('a')?.href, note: c[7]?.innerText.trim() }; };
    tbody.addEventListener('click', e => {
        const review = e.target.closest('[data-wo-detail]'), remove = e.target.closest('[data-wo-delete]'), forward = e.target.closest('[data-wo-forward]');
        if (forward) { const row = forward.closest('tr'); if (!row || row.dataset.status !== 'SIAP_DITERUSKAN') return; if (!confirm(`Teruskan ${forward.dataset.woForward} ke tim produksi?`)) return; row.dataset.status = 'DITERUSKAN'; row.querySelectorAll('td')[5].innerHTML = statusLabel('DITERUSKAN'); forward.remove(); refreshStats(); applyFilters(); }
        if (review) {
            activeReviewRow = review.closest('tr'); const d = rowData(activeReviewRow); document.getElementById('wo-modal-content').innerHTML = `
            <div class="cs-wo-detail-content">
            <div class="cs-wo-detail-item"><small>Nomor WO</small><strong>${esc(d.wo)}</strong></div><div class="cs-wo-detail-item"><small>ID Order</small><strong>${esc(d.order)}</strong></div>
            <div class="cs-wo-detail-item"><small>Pemesan</small><strong>${esc(d.customer)}</strong></div><div class="cs-wo-detail-item"><small>Instansi</small><strong>${esc(d.company)}</strong></div>
            <div class="cs-wo-detail-item"><small>Jenis Produk</small><strong>${esc(d.product)}</strong></div><div class="cs-wo-detail-item"><small>Nama Desainer</small><strong>${esc(d.designer)}</strong></div>
            <div class="cs-wo-detail-item"><small>Status WO</small>${statusLabel(d.status)}</div><div class="cs-wo-detail-item"><small>Berkas Work Order</small>${d.url ? `<a href="${esc(d.url)}" target="_blank" rel="noopener">${esc(d.file)} ↗</a>` : `<strong>${esc(d.file)}</strong>`}</div>
            <div class="cs-wo-detail-item" style="grid-column:1/-1"><small>Catatan</small><strong>${esc(d.note || '-')}</strong></div></div>`;
            document.getElementById('wo-modal-approve').hidden = d.status !== 'PERLU_DIPERIKSA'; openDetail();
        }
        if (remove) { if (!confirm(`Hapus data dummy ${remove.dataset.woDelete}?`)) return; remove.closest('tr')?.remove(); refreshStats(); applyFilters(); }
    });
    document.getElementById('wo-modal-approve')?.addEventListener('click', () => {
        if (!activeReviewRow) return; activeReviewRow.dataset.status = 'SIAP_DITERUSKAN'; activeReviewRow.querySelectorAll('td')[5].innerHTML = statusLabel('SIAP_DITERUSKAN');
        const action = activeReviewRow.querySelector('.cs-wo-actions');
        if (action && !action.querySelector('[data-wo-forward]')) { const id = activeReviewRow.querySelector('.cs-wo-number')?.textContent.trim(); const btn = document.createElement('button'); btn.type = 'button'; btn.className = 'cs-wo-forward'; btn.dataset.woForward = id; btn.textContent = 'Teruskan'; action.insertBefore(btn, action.querySelector('[data-wo-delete]')); }
        closeDetail(); refreshStats(); applyFilters();
    });

    document.getElementById('wo-upload-form')?.addEventListener('submit', e => {
        e.preventDefault();
        const selected = document.getElementById('wo-order'), order = selected.value, label = selected.options[selected.selectedIndex]?.text || '';
        const parts = label.split(' — '), customer = parts[1] || 'Pemesan', company = parts[1] || '-';
        const file = document.getElementById('wo-file').files[0], link = document.getElementById('wo-file-url').value.trim(), source = document.querySelector('input[name="wo-source"]:checked')?.value;
        const notes = document.getElementById('wo-notes').value.trim(), designer = document.getElementById('wo-designer').value.trim();
        if (source === 'file' && !file) { alert('Pilih berkas Work Order terlebih dahulu.'); return; }
        if (source === 'link' && !/^https?:\/\//i.test(link)) { alert('Masukkan link dokumen yang valid.'); return; }
        if (file && file.size > 10 * 1024 * 1024) { alert('Ukuran file maksimal 10 MB.'); return; }
        const rows = [...tbody.querySelectorAll('tr[data-status]')], n = rows.length + 1, wo = `WO-2026-${String(n).padStart(3, '0')}`;
        const fileName = source === 'file' ? file.name : 'Buka link berkas';
        const fileCell = source === 'file' ? `<span class="cs-wo-file-link"><span class="material-symbols-outlined">attach_file</span>${esc(fileName)}</span>` : `<a class="cs-wo-file-link" href="${esc(link)}" target="_blank" rel="noopener"><span class="material-symbols-outlined">link</span>Link dokumen <span class="material-symbols-outlined cs-wo-external">open_in_new</span></a>`;
        const tr = document.createElement('tr'); tr.dataset.status = 'PERLU_DIPERIKSA'; tr.dataset.search = `${wo} ${order} ${customer} ${company} ${designer}`.toLowerCase();
        tr.innerHTML = `<td><strong class="cs-wo-number">${wo}</strong></td><td><strong>${esc(order)}</strong></td><td><strong>${esc(customer)}</strong><small>${esc(company)}</small></td><td>-</td><td>${esc(designer || 'Belum diisi')}</td><td>${statusLabel('PERLU_DIPERIKSA')}</td><td>${fileCell}</td><td class="cs-wo-note-cell">${esc(notes || '-')}</td><td><div class="cs-wo-actions"><button type="button" class="cs-wo-review" data-wo-detail="${wo}">Periksa WO</button><button type="button" class="cs-wo-delete" data-wo-delete="${wo}" aria-label="Hapus ${wo}"><span class="material-symbols-outlined">delete</span></button></div></td>`;
        tbody.prepend(tr); e.target.reset(); fileZone.hidden = false; linkZone.hidden = true; closeDrawer(); refreshStats(); currentPage = 1; applyFilters(); alert(`${wo} ditambahkan sebagai data dummy. Data belum tersimpan ke database.`);
    });
    refreshStats(); applyFilters();
});
