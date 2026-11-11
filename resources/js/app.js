import './bootstrap';
import './auth/login.js';
import './owner/dashboard.js';

import './cs/dashboard.js';
import './cs/customer.js';
import './cs/order.js';
import './cs/order-detail.js';
import './cs/work-order.js';
import './cs/invoice-pembayaran.js';
import './tracking.js';
import './cs/profile.js';
import './cs/notification.js';

// Dropdown Header CS
window.toggleCsMenu = function (menuId) {
    const selectedMenu = document.getElementById(menuId);

    if (!selectedMenu) return;

    document.querySelectorAll('.cs-header-dropdown').forEach(menu => {
        if (menu !== selectedMenu) {
            menu.classList.add('hidden');
        }
    });

    selectedMenu.classList.toggle('hidden');
};

document.addEventListener('click', function (event) {
    if (
        !event.target.closest('.cs-header-dropdown') &&
        !event.target.closest('.cs-header button')
    ) {
        document.querySelectorAll('.cs-header-dropdown').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});

// ==========================================================
// SHARED PAGINATION — applies to remaining data tables.
// Order, Work Order and Customer have page-specific filter-aware
// pagination and are intentionally excluded here.
// ==========================================================
document.addEventListener('DOMContentLoaded', () => {
    const excluded = '#csOrderTable, #csWorkOrderTable, #customerDirectoryTable, .invoice-item-table, [data-no-pagination="true"]';
    document.querySelectorAll('table').forEach(table => {
        if (table.matches(excluded) || table.closest('.invoice-item-table')) return;
        const tbody = table.tBodies?.[0];
        if (!tbody) return;
        const wrapper = table.closest('.overflow-x-auto, .overflow-auto, .table-responsive, .invoice-table-wrap') || table.parentElement;
        if (!wrapper) return;
        const footer = document.createElement('div');
        footer.className = 'presma-pagination';
        footer.setAttribute('aria-label', 'Navigasi halaman tabel');
        wrapper.insertAdjacentElement('afterend', footer);
        let page = 1, pageSize = 10, rows = [];
        const refreshRows = () => {
            rows = [...tbody.rows].filter(row => !row.matches('[data-pagination-ignore="true"]'));
            page = Math.min(page, Math.max(1, Math.ceil(rows.length / pageSize)));
            render();
        };
        const render = () => {
            const total = rows.length;
            const pages = Math.max(1, Math.ceil(total / pageSize));
            const start = (page - 1) * pageSize;
            const end = Math.min(start + pageSize, total);
            rows.forEach((row, index) => row.classList.toggle('presma-page-hidden', index < start || index >= end));
            footer.innerHTML = `
              <div class="presma-pagination-info">
                <span>${total ? `Menampilkan ${start + 1}–${end} dari ${total} data` : 'Tidak ada data untuk ditampilkan'}</span>
                <label>Tampilkan <select data-page-size aria-label="Jumlah data per halaman">
                  <option value="10" ${pageSize === 10 ? 'selected' : ''}>10</option>
                  <option value="20" ${pageSize === 20 ? 'selected' : ''}>20</option>
                </select></label>
              </div>
              <div class="presma-page-actions">
                <button type="button" data-prev aria-label="Halaman sebelumnya" ${page <= 1 ? 'disabled' : ''}>‹</button>
                <span class="presma-page-current">${page} / ${pages}</span>
                <button type="button" data-next aria-label="Halaman berikutnya" ${page >= pages ? 'disabled' : ''}>›</button>
              </div>`;
            footer.querySelector('[data-page-size]')?.addEventListener('change', e => { pageSize = Number(e.target.value) || 10; page = 1; render(); });
            footer.querySelector('[data-prev]')?.addEventListener('click', () => { if (page > 1) { page--; render(); } });
            footer.querySelector('[data-next]')?.addEventListener('click', () => { if (page < pages) { page++; render(); } });
        };
        refreshRows();
        let scheduled = false;
        const observer = new MutationObserver(() => {
            if (scheduled) return;
            scheduled = true;
            requestAnimationFrame(() => { scheduled = false; refreshRows(); });
        });
        observer.observe(tbody, { childList: true });
    });
});

// Terapkan pola kartu ringkasan compact pada kartu metrik yang sudah ada.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.cs-main .grid > div, .owner-page .grid > div').forEach(card => {
        if (card.querySelector('.text-4xl, .text-3xl, .text-2xl') && !card.querySelector('table')) {
            card.classList.add('presma-metric-card');
        }
    });
});
