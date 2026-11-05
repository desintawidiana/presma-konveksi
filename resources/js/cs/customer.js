
let presmaCustomers = [];

document.addEventListener('DOMContentLoaded', () => {
    const page = document.querySelector('.cs-customer-page');
    if (!page) return;

    const API_URL = '/api/pelanggan';

    const table = document.getElementById('customerDirectoryTable');
    const tbody = table?.querySelector('tbody');
    const drawer = document.getElementById('customer-detail-drawer');
    const addModal = document.getElementById('modal-entri-kontak');
    const editModal = document.getElementById('customer-edit-modal');
    const editForm = document.getElementById('customerEditForm');
    const createForm = document.getElementById('customerCreateForm');
    const search = document.getElementById('customerSearch');
    const category = document.getElementById('customerCategory');
    const openModalButton = document.getElementById('customerOpenModal');

    if (
        !table ||
        !tbody ||
        !drawer ||
        !addModal ||
        !editModal ||
        !editForm ||
        !createForm
    ) {
        console.error('Elemen halaman Customer belum lengkap.');
        return;
    }

    let activeFilter = 'all';
    let ascending = false;
    let activeId = null;
    let editingId = null;
    let lastFocus = null;
    let loading = false;

    const validSources = [
        'REKOMENDASI_TEMAN',
        'INSTAGRAM',
        'TIKTOK',
        'IKLAN',
        'FACEBOOK',
        'LAINNYA',
    ];

    const escapeHTML = value =>
        String(value ?? '').replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
        })[char]);

    const byId = id =>
        presmaCustomers.find(
            customer => customer.id === Number(id)
        );

    const text = (id, value) => {
        const element = document.getElementById(id);

        if (element) {
            element.textContent = value || '—';
        }
    };

    const initials = name =>
        String(name || '?')
            .trim()
            .split(/\s+/)
            .slice(0, 2)
            .map(word => word[0] || '')
            .join('')
            .toUpperCase();

    const waHref = phone => {
        let number = String(phone || '').replace(/\D/g, '');

        if (number.startsWith('0')) {
            number = '62' + number.slice(1);
        } else if (number.startsWith('8')) {
            number = '62' + number;
        }

        return number ? `https://wa.me/${number}` : '#';
    };

    const sourceLabel = source => ({
        REKOMENDASI_TEMAN: 'Rekomendasi Teman',
        INSTAGRAM: 'Instagram',
        TIKTOK: 'TikTok',
        IKLAN: 'Iklan',
        FACEBOOK: 'Facebook',
        LAINNYA: 'Lainnya',
    })[source] || 'Belum diketahui';

    const formatDate = value => {
        if (!value) return '—';

        const date = new Date(
            String(value).replace(' ', 'T')
        );

        if (Number.isNaN(date.getTime())) {
            return String(value);
        }

        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    const categoryFor = customer => {
        const org = customer.org || '';

        if (/^(PT|CV)\b|industri|perusahaan/i.test(org)) {
            return 'Korporat & Industri';
        }

        if (/komunitas/i.test(org)) {
            return 'Komunitas Kreatif';
        }

        return 'Kampus & Organisasi';
    };

    function mapCustomer(p) {
        if (!p) {
            throw new Error(
                'Data pelanggan dari API tidak ditemukan.'
            );
        }

        return {
            id: Number(p.id),
            code: `CUST-${String(p.id).padStart(4, '0')}`,
            name: p.nama || '',
            initials: initials(p.nama),
            phone: p.no_whatsapp || '',
            org: p.instansi || '',
            sumberInformasi: p.sumber_informasi || '',
            category: categoryFor({
                org: p.instansi || '',
            }),
            createdAt: p.dibuat_pada || '',
            city: '',
            email: '',
            role: '',
            address: '',
            note: '',
            orders: [],
        };
    }

    async function apiRequest(url, options = {}) {
        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                ...(options.body
                    ? { 'Content-Type': 'application/json' }
                    : {}),
                ...options.headers,
            },
        });

        const result = await response.json().catch(() => ({}));

        if (!response.ok) {
            const validationErrors = result.errors
                ? Object.values(result.errors)
                    .flat()
                    .join('\n')
                : '';

            throw new Error(
                validationErrors ||
                result.message ||
                `Permintaan gagal (${response.status}).`
            );
        }

        return result;
    }

    function showError(error) {
        console.error(error);

        alert(
            error.message ||
            'Terjadi kesalahan. Silakan coba lagi.'
        );
    }

    // Mengunci scroll halaman selama modal atau drawer terbuka.
    function lockBody() {
        const anyOpen = [
            drawer,
            addModal,
            editModal,
        ].some(element =>
            !element.classList.contains('hidden')
        );

        document.body.classList.toggle(
            'cs-modal-open',
            anyOpen
        );
    }

    function show(element) {
        if (!element) return;

        element.classList.remove('hidden');
        lockBody();
    }

    function hide(element) {
        if (!element) return;

        element.classList.add('hidden');
        lockBody();
    }

    function restoreFocus() {
        if (lastFocus && document.contains(lastFocus)) {
            lastFocus.focus();
        }

        lastFocus = null;
    }

    function updateSummary() {
        const total = presmaCustomers.length;

        const totalElement = page.querySelector(
            '.grid.grid-cols-1.sm\\:grid-cols-2.xl\\:grid-cols-4 ' +
            '> div:first-child .font-display-lg'
        );

        if (totalElement) {
            totalElement.textContent = total;
        }

        const allFilter = page.querySelector(
            '[data-filter="all"]'
        );

        if (allFilter) {
            allFilter.textContent = `Semua (${total})`;
        }

        const summary = document.getElementById(
            'customerVisibleSummary'
        );

        if (summary) {
            const visible = [
                ...tbody.querySelectorAll('.customer-row'),
            ].filter(row => !row.hidden).length;

            summary.textContent =
                `Menampilkan ${visible} dari ${total} pelanggan.`;
        }

        const footer = table.closest('.overflow-hidden')
            ?.querySelector(':scope > div:last-child');

        if (footer) {
            footer.textContent =
                `Total ${total} pelanggan dari database. ` +
                'Informasi kota dan riwayat order belum tersedia.';
        }
    }

    function renderRow(customer) {
        let row = tbody.querySelector(
            `[data-index="${customer.id}"]`
        );

        if (!row) {
            row = document.createElement('tr');

            row.className =
                'customer-row hover:bg-surface-container ' +
                'transition-colors cursor-pointer';

            row.dataset.index = String(customer.id);
            row.tabIndex = 0;
            row.setAttribute('role', 'button');
            row.setAttribute(
                'aria-label',
                `Lihat detail pelanggan ${customer.name}`
            );

            row.innerHTML = '<td></td>'.repeat(7);
            tbody.appendChild(row);
        }

        const cells = row.querySelectorAll('td');

        cells[0].className =
            'py-3.5 px-4 font-mono text-xs text-on-surface-variant';

        cells[0].textContent = customer.code;

        cells[1].className = 'py-3.5 px-4';

        cells[1].innerHTML = `
            <div class="flex items-center gap-3">
                <div class="cs-customer-avatar">
                    ${escapeHTML(customer.initials)}
                </div>
                <div class="min-w-0">
                    <div class="cs-customer-name">
                        ${escapeHTML(customer.name)}
                        <span class="cs-customer-selected-tag ${
                            activeId === customer.id ? '' : 'hidden'
                        }">Terpilih</span>
                    </div>
                    <div class="cs-customer-org">
                        ${escapeHTML(
                            customer.org || 'Belum ada instansi'
                        )}
                    </div>
                </div>
            </div>`;

        cells[2].className = 'py-3.5 px-4 text-xs';

        cells[2].innerHTML = `
            <a class="cs-customer-phone-link"
               href="${escapeHTML(waHref(customer.phone))}"
               target="_blank"
               rel="noopener noreferrer">
                <span class="material-symbols-outlined text-[15px]">
                    chat
                </span>
                ${escapeHTML(customer.phone || '—')}
            </a>`;

        cells[3].className =
            'py-3.5 px-4 text-xs text-on-surface-variant';

        cells[3].textContent = '—';

        cells[4].className =
            'py-3.5 px-4 text-xs text-on-surface-variant';

        cells[4].textContent = 'Belum tersedia';

        cells[5].className =
            'py-3.5 px-4 text-xs text-on-surface-variant';

        cells[5].textContent = formatDate(customer.createdAt);

        cells[6].className = 'py-3.5 px-4 text-right';

        cells[6].innerHTML = `
            <div class="cs-customer-actions">
                <button type="button"
                    data-open-customer="${customer.id}"
                    class="cs-customer-detail-action">
                    <span class="material-symbols-outlined text-[15px]">
                        visibility
                    </span>
                    Detail
                </button>

                <button type="button"
                    data-edit-customer="${customer.id}"
                    class="cs-customer-edit-row">
                    <span class="material-symbols-outlined text-[15px]">
                        edit
                    </span>
                    Edit
                </button>

                <button type="button"
                    data-delete-customer="${customer.id}"
                    class="cs-customer-edit-row">
                    Hapus
                </button>
            </div>`;

        row.classList.toggle(
            'cs-customer-row-selected',
            activeId === customer.id
        );

        row.setAttribute(
            'aria-selected',
            String(activeId === customer.id)
        );
    }

    function filterRows() {
        const query = (search?.value || '')
            .trim()
            .toLowerCase();

        const selectedCategory =
            category?.value || 'Semua Kategori';

        let shown = 0;

        tbody.querySelectorAll('.customer-row').forEach(row => {
            const customer = byId(row.dataset.index);

            if (!customer) return;

            const searchable = [
                customer.code,
                customer.name,
                customer.org,
                customer.phone,
                customer.sumberInformasi,
                sourceLabel(customer.sumberInformasi),
            ].join(' ').toLowerCase();

            const matchText = searchable.includes(query);

            const matchCategory =
                selectedCategory === 'Semua Kategori' ||
                selectedCategory === categoryFor(customer);

            // Data order dan domisili belum tersedia dari API.
            const matchQuick = activeFilter === 'all';

            row.hidden = !(
                matchText &&
                matchCategory &&
                matchQuick
            );

            if (!row.hidden) shown++;
        });

        let summary = document.getElementById(
            'customerVisibleSummary'
        );

        if (!summary) {
            summary = document.createElement('p');
            summary.id = 'customerVisibleSummary';
            summary.className = 'cs-customer-visible-summary';

            table.parentElement.after(summary);
        }

        summary.textContent = shown
            ? `Menampilkan ${shown} dari ${presmaCustomers.length} pelanggan.`
            : 'Tidak ada pelanggan yang sesuai dengan pencarian atau filter.';

        updateSummary();
    }

    function redraw() {
        presmaCustomers.forEach(renderRow);

        tbody.querySelectorAll('.customer-row').forEach(row => {
            if (!byId(row.dataset.index)) {
                row.remove();
            }
        });

        const sorted = [...presmaCustomers].sort((a, b) =>
            ascending
                ? a.id - b.id
                : b.id - a.id
        );

        sorted.forEach(customer => {
            const row = tbody.querySelector(
                `[data-index="${customer.id}"]`
            );

            if (row) {
                tbody.appendChild(row);
            }
        });

        filterRows();
    }

    async function loadCustomers() {
        if (loading) return;

        loading = true;

        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-4 py-8 text-center">
                    Memuat data pelanggan...
                </td>
            </tr>`;

        try {
            const result = await apiRequest(API_URL);

            if (!Array.isArray(result.data)) {
                throw new Error(
                    'Format data pelanggan dari API tidak sesuai.'
                );
            }

            presmaCustomers = result.data.map(mapCustomer);

            tbody.innerHTML = '';

            if (activeId && !byId(activeId)) {
                activeId = null;
            }

            redraw();
        } catch (error) {
            console.error('Gagal memuat pelanggan:', error);

            tbody.innerHTML = `
                <tr>
                    <td colspan="7"
                        class="px-4 py-8 text-center text-red-700">
                        Gagal memuat data pelanggan.
                        Silakan muat ulang halaman.
                    </td>
                </tr>`;

            alert(
                'Data pelanggan gagal dimuat. ' +
                'Periksa server Laravel dan endpoint /api/pelanggan.'
            );
        } finally {
            loading = false;
        }
    }

    function populateDetail(customer) {
        text('detailInitials', customer.initials);
        text('customerDrawerTitle', customer.name);
        text('detailOrganization', customer.org);
        text(
            'detailBadge',
            sourceLabel(customer.sumberInformasi)
        );
        text('detailCount', 'Belum tersedia');
        text('detailValue', 'Belum tersedia');
        text('detailPhone', customer.phone);
        text('detailEmail', 'Belum tersedia');
        text('detailAddress', 'Belum tersedia');

        text(
            'detailNote',
            `Terdaftar pada ${formatDate(customer.createdAt)}. ` +
            'Riwayat order belum tersedia pada API pelanggan.'
        );

        const wa = document.getElementById('detailWa');

        if (wa) {
            wa.href = waHref(customer.phone);
        }

        const orders = document.getElementById('detailOrders');

        if (orders) {
            orders.innerHTML = `
                <p class="text-xs text-on-surface-variant">
                    Belum ada data riwayat pesanan yang terhubung.
                </p>`;
        }
    }

    function openDetail(id) {
        const customer = byId(id);
        if (!customer) return;

        activeId = customer.id;
        lastFocus = document.activeElement;

        populateDetail(customer);
        redraw();
        show(drawer);
    }

    function sourceFromForm(form, previousSource = '') {
        const value = form.elements.category?.value || '';

        if (validSources.includes(value)) {
            return value;
        }

        return validSources.includes(previousSource)
            ? previousSource
            : null;
    }

    function payloadFromForm(form, previousSource = '') {
        const value = key =>
            form.elements[key]?.value?.trim() || '';

        return {
            nama: value('name'),
            no_whatsapp: value('phone'),
            instansi: value('org') || null,
            sumber_informasi: sourceFromForm(
                form,
                previousSource
            ),
        };
    }

    function openCreate() {
        lastFocus = document.activeElement;

        createForm.reset();
        show(addModal);

        requestAnimationFrame(() => {
            createForm.elements.name?.focus();
        });
    }

    function openEdit(id) {
        const customer = byId(id);
        if (!customer) return;

        editingId = customer.id;
        activeId = customer.id;
        lastFocus = document.activeElement;

        const values = {
            name: customer.name,
            phone: customer.phone,
            org: customer.org,
            city: customer.city,
            email: customer.email,
            role: customer.role,
            address: customer.address,
            note: customer.note,
        };

        Object.entries(values).forEach(([key, value]) => {
            const field = editForm.elements[key];

            if (field) {
                field.value = value || '';
            }
        });

        const sourceSelect = editForm.elements.category;

        if (sourceSelect) {
            sourceSelect.value = validSources.includes(
                customer.sumberInformasi
            )
                ? customer.sumberInformasi
                : '';
        }

        redraw();
        show(editModal);

        requestAnimationFrame(() => {
            editForm.elements.name?.focus();
        });
    }

    function closeDetail() {
        hide(drawer);
        restoreFocus();
    }

    function closeEdit() {
        hide(editModal);
        editingId = null;
        restoreFocus();
    }

    // Klik detail, edit, atau hapus.
    tbody.addEventListener('click', async event => {
        if (!(event.target instanceof Element)) return;

        // Jangan membuka detail ketika tautan WhatsApp diklik.
        if (event.target.closest('a')) return;

        const editButton = event.target.closest(
            '[data-edit-customer]'
        );

        if (editButton) {
            openEdit(editButton.dataset.editCustomer);
            return;
        }

        const detailButton = event.target.closest(
            '[data-open-customer]'
        );

        if (detailButton) {
            openDetail(detailButton.dataset.openCustomer);
            return;
        }

        const deleteButton = event.target.closest(
            '[data-delete-customer]'
        );

        if (deleteButton) {
            const customer = byId(
                deleteButton.dataset.deleteCustomer
            );

            if (!customer) return;

            const confirmed = confirm(
                `Yakin ingin menghapus pelanggan "${customer.name}"?`
            );

            if (!confirmed) return;

            deleteButton.disabled = true;

            try {
                await apiRequest(
                    `${API_URL}/${customer.id}`,
                    { method: 'DELETE' }
                );

                presmaCustomers = presmaCustomers.filter(
                    item => item.id !== customer.id
                );

                if (activeId === customer.id) {
                    activeId = null;
                    hide(drawer);
                }

                redraw();

                alert('Pelanggan berhasil dihapus.');
            } catch (error) {
                showError(error);
            } finally {
                deleteButton.disabled = false;
            }

            return;
        }

        const row = event.target.closest('.customer-row');

        if (row) {
            openDetail(row.dataset.index);
        }
    });

    tbody.addEventListener('keydown', event => {
        const row = event.target.closest('.customer-row');

        if (
            event.target === row &&
            (event.key === 'Enter' || event.key === ' ')
        ) {
            event.preventDefault();
            openDetail(row.dataset.index);
        }
    });

    // Tambah pelanggan ke database.
    createForm.addEventListener('submit', async event => {
        event.preventDefault();

        const submitButton = createForm.querySelector(
            'button[type="submit"]'
        );

        if (submitButton?.disabled) return;

        if (submitButton) {
            submitButton.disabled = true;
        }

        try {
            const payload = payloadFromForm(createForm);

            const result = await apiRequest(API_URL, {
                method: 'POST',
                body: JSON.stringify(payload),
            });

            if (!result.data) {
                throw new Error(
                    'Data pelanggan baru tidak ditemukan pada respons API.'
                );
            }

            const customer = mapCustomer(result.data);

            presmaCustomers.unshift(customer);

            hide(addModal);
            createForm.reset();

            activeFilter = 'all';

            if (search) search.value = '';
            if (category) category.value = 'Semua Kategori';

            redraw();

            // Buka drawer detail setelah pelanggan berhasil dibuat.
            openDetail(customer.id);

            alert(
                'Pelanggan berhasil ditambahkan ke database.'
            );
        } catch (error) {
            showError(error);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });

    // Edit pelanggan di database.
    editForm.addEventListener('submit', async event => {
        event.preventDefault();

        const customer = byId(editingId);
        if (!customer) return;

        const submitButton = editForm.querySelector(
            'button[type="submit"]'
        );

        if (submitButton?.disabled) return;

        if (submitButton) {
            submitButton.disabled = true;
        }

        try {
            const payload = payloadFromForm(
                editForm,
                customer.sumberInformasi
            );

            const result = await apiRequest(
                `${API_URL}/${customer.id}`,
                {
                    method: 'PUT',
                    body: JSON.stringify(payload),
                }
            );

            if (!result.data) {
                throw new Error(
                    'Data pelanggan yang diperbarui tidak ditemukan pada respons API.'
                );
            }

            const updated = mapCustomer(result.data);

            presmaCustomers = presmaCustomers.map(item =>
                item.id === customer.id ? updated : item
            );

            activeId = updated.id;
            editingId = null;

            hide(editModal);
            redraw();

            populateDetail(updated);
            show(drawer);

            alert('Data pelanggan berhasil diperbarui.');
        } catch (error) {
            showError(error);
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
            }
        }
    });

    // Tombol buka modal tambah.
    openModalButton?.addEventListener(
        'click',
        openCreate
    );

    // Tombol edit dari drawer detail.
    document.getElementById('customerEditInDrawer')
        ?.addEventListener('click', () => {
            if (activeId !== null) {
                const id = activeId;

                hide(drawer);
                openEdit(id);
            }
        });

    // Tombol tutup modal tambah.
    addModal.querySelectorAll('[data-close-modal]')
        .forEach(button => {
            button.addEventListener('click', () => {
                hide(addModal);
                createForm.reset();
                restoreFocus();
            });
        });

    // Tombol tutup modal edit.
    editModal.querySelectorAll('[data-close-edit]')
        .forEach(button => {
            button.addEventListener('click', closeEdit);
        });

    // Tombol tutup drawer.
    drawer.querySelectorAll('[data-close-drawer]')
        .forEach(button => {
            button.addEventListener('click', closeDetail);
        });

    // Tutup jika pengguna mengeklik latar belakang overlay.
    [addModal, editModal, drawer].forEach(element => {
        element.addEventListener('click', event => {
            if (event.target !== element) return;

            if (element === addModal) {
                hide(addModal);
                createForm.reset();
                restoreFocus();
            } else if (element === editModal) {
                closeEdit();
            } else if (element === drawer) {
                closeDetail();
            }
        });
    });

    // Tutup komponen paling atas menggunakan Escape.
    document.addEventListener('keydown', event => {
        if (event.key !== 'Escape') return;

        if (!editModal.classList.contains('hidden')) {
            closeEdit();
        } else if (!addModal.classList.contains('hidden')) {
            hide(addModal);
            createForm.reset();
            restoreFocus();
        } else if (!drawer.classList.contains('hidden')) {
            closeDetail();
        }
    });

    // Pencarian dan kategori instansi.
    search?.addEventListener('input', filterRows);
    category?.addEventListener('change', filterRows);

    // Filter yang membutuhkan data order atau domisili
    // belum tersedia pada endpoint pelanggan saat ini.
    page.querySelectorAll('[data-filter]').forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;

            if (filter !== 'all') {
                alert(
                    'Filter ini belum bisa dihitung karena data pesanan ' +
                    'dan domisili belum tersedia pada API.'
                );
                return;
            }

            activeFilter = 'all';
            redraw();
        });
    });

    // Urutkan berdasarkan ID pelanggan.
    document.getElementById('customerSort')
        ?.addEventListener('click', () => {
            ascending = !ascending;
            redraw();
        });

    // Ekspor pelanggan yang sedang terlihat ke CSV.
    document.getElementById('customerExport')
        ?.addEventListener('click', () => {
            const rows = [[
                'ID Pelanggan',
                'Nama',
                'Nomor WhatsApp',
                'Instansi',
                'Sumber Informasi',
                'Tanggal Terdaftar',
            ]];

            tbody.querySelectorAll(
                '.customer-row:not([hidden])'
            ).forEach(row => {
                const customer = byId(row.dataset.index);

                if (!customer) return;

                rows.push([
                    customer.code,
                    customer.name,
                    customer.phone,
                    customer.org,
                    sourceLabel(customer.sumberInformasi),
                    formatDate(customer.createdAt),
                ]);
            });

            const csv = '\uFEFF' + rows.map(row =>
                row.map(value =>
                    `"${String(value ?? '').replace(/"/g, '""')}"`
                ).join(',')
            ).join('\r\n');

            const url = URL.createObjectURL(
                new Blob([csv], {
                    type: 'text/csv;charset=utf-8;',
                })
            );

            const link = document.createElement('a');

            link.href = url;
            link.download = 'data-pelanggan-presma.csv';

            document.body.appendChild(link);
            link.click();
            link.remove();

            setTimeout(() => {
                URL.revokeObjectURL(url);
            }, 1000);
        });

    // Pastikan kondisi awal overlay konsisten.
    // Elemen yang memang harus tertutup harus memiliki class hidden.
    lockBody();

    loadCustomers();
});
