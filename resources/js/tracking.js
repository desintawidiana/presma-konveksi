(() => {
    const board = document.getElementById('trackingBoard');
    if (!board || board.dataset.initialized === '1') return;
    board.dataset.initialized = '1';

    const search = document.getElementById('trackingSearch');
    const filter = document.getElementById('trackingFilter');
    const modal = document.getElementById('trackingDetailModal');
    const noResults = document.getElementById('trackingNoResults');
    const stageNames = {
        1: 'Intake & Form CS', 2: 'Pembuatan WO & Desain', 3: 'Cutting & Potong',
        4: 'Bordir & Sablon', 5: 'Jahit & Perakitan', 6: 'QC & Finishing',
        7: 'Pelunasan & Kasir', 8: 'Siap Ambil / Kirim'
    };

    const safe = (value) => String(value ?? '-').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
    }[char]));

    function applyFilters() {
        const keyword = (search?.value || '').trim().toLocaleLowerCase('id');
        const selectedStage = filter?.value || 'all';
        let visibleCards = 0;
        board.querySelectorAll('.tracking-column').forEach((column) => {
            const stageMatches = selectedStage === 'all' || column.dataset.stage === selectedStage;
            let columnVisible = 0;
            column.querySelectorAll('.tracking-order-card').forEach((card) => {
                const data = JSON.parse(card.dataset.order || '{}');
                const text = [data.code, data.client, data.product, data.confirmed, data.status].join(' ').toLocaleLowerCase('id');
                const show = stageMatches && (!keyword || text.includes(keyword));
                card.hidden = !show;
                if (show) { columnVisible++; visibleCards++; }
            });
            column.hidden = !stageMatches;
            const count = column.querySelector('.tracking-count');
            if (count) count.textContent = `${columnVisible} order`;
        });
        if (noResults) noResults.hidden = visibleCards > 0;
    }

    function openDetails(order) {
        document.getElementById('detailCode').textContent = order.code || '-';
        document.getElementById('detailClient').textContent = order.client || '-';
        document.getElementById('detailProduct').textContent = order.product || '-';
        document.getElementById('detailQty').textContent = order.qty || '-';
        document.getElementById('detailStage').textContent = stageNames[order.stage] || '-';
        document.getElementById('detailStatus').textContent = order.status || '-';
        document.getElementById('detailDate').textContent = order.date || '-';
        document.getElementById('detailConfirmed').textContent = order.confirmed || 'Belum tercatat';

        const wo = document.getElementById('detailWo');
        if (order.wo?.url && order.wo.url !== '#') {
            wo.innerHTML = `<a href="${safe(order.wo.url)}" target="_blank" rel="noopener"><span class="material-symbols-outlined">attach_file</span>${safe(order.wo.label || 'Buka file WO')}</a>`;
        } else if (order.wo?.url === '#') {
            wo.textContent = 'Contoh tautan WO. Ganti dengan URL file WO yang tersimpan di aplikasi.';
        } else {
            wo.textContent = 'Belum ada file/link WO.';
        }

        const notes = document.getElementById('detailNotes');
        if (Array.isArray(order.notes) && order.notes.length) {
            notes.innerHTML = order.notes.map((note) => `
                <article class="tracking-note-item">
                    <div class="tracking-note-meta"><strong>${safe(note.by)}</strong><span>${safe(note.date)}</span></div>
                    <div class="tracking-note-text">${safe(note.text)}</div>
                </article>`).join('');
        } else {
            notes.innerHTML = '<p class="tracking-no-note">Belum ada catatan untuk pesanan ini.</p>';
        }
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('tracking-modal-open');
    }

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('tracking-modal-open');
    }

    board.addEventListener('click', (event) => {
        const card = event.target.closest('.tracking-order-card');
        if (!card) return;
        try { openDetails(JSON.parse(card.dataset.order || '{}')); }
        catch (error) { console.error('Data detail tracking tidak valid.', error); }
    });
    modal?.addEventListener('click', (event) => {
        if (event.target.closest('[data-close-tracking]')) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal?.getAttribute('aria-hidden') === 'false') closeModal();
    });
    search?.addEventListener('input', applyFilters);
    filter?.addEventListener('change', applyFilters);
    applyFilters();
})();
