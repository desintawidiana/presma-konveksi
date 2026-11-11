document.addEventListener('DOMContentLoaded', () => {
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
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });

    // Pencarian dan filter hanya memproses baris contoh yang sedang ditampilkan.
    const search = document.getElementById('cs-order-search');
    const rows = [...document.querySelectorAll('[data-cs-row]')];
    let filter = 'all';
    const filterButtons = [...document.querySelectorAll('[data-cs-filter]')];
    filterButtons.forEach(button => button.setAttribute('aria-pressed', String(button.dataset.csFilter === filter)));
    const render = () => {
        const query = (search?.value ?? '').trim().toLocaleLowerCase('id');
        for (const row of rows) {
            const text = row.textContent.toLocaleLowerCase('id');
            const urgent = text.includes('data belum lengkap');
            const verify = urgent || text.includes('belum diverifikasi') || text.includes('menunggu cek');
            row.hidden = !(text.includes(query) && (filter === 'all' || (filter === 'urgent' && urgent) || (filter === 'verify' && verify)));
            row.style.display = row.hidden ? 'none' : '';
        }
    };
    search?.addEventListener('input', render);
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filter = button.dataset.csFilter;
            filterButtons.forEach(b => {
                const active = b === button;
                b.setAttribute('aria-pressed', String(active));
                b.classList.toggle('is-active', active);
            });
            render();
        });
    });
    // Navigasi href="#" adalah placeholder sampai modul tujuan dibuat.
    document.querySelectorAll('.cs-sidebar a[href="#"]').forEach(link => link.addEventListener('click', e => e.preventDefault()));
});
