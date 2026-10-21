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
    document.querySelectorAll('[data-cs-filter]').forEach(button => {
        button.addEventListener('click', () => {
            filter = button.dataset.csFilter;
            document.querySelectorAll('[data-cs-filter]').forEach(b => b.setAttribute('aria-pressed', String(b === button)));
            render();
        });
    });
    // Navigasi href="#" adalah placeholder sampai modul tujuan dibuat.
    document.querySelectorAll('.cs-sidebar a[href="#"]').forEach(link => link.addEventListener('click', e => e.preventDefault()));
});
