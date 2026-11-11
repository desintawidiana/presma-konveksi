<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan | Presma Konveksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#830909',
                        'primary-hover': '#A10B0B',
                        'primary-tint': '#F7E7E7',
                        secondary: '#635D5E',
                        'on-surface': '#231F20',
                        surface: '#F8F9F9',
                        'surface-container-lowest': '#FFFFFF',
                        'surface-container-low': '#F1F2F2',
                        'surface-container': '#EDEEEE',
                        'surface-container-high': '#E7E8E8',
                        outline: '#8D706C',
                        'outline-variant': '#D9DADB',
                        success: '#16804B',
                        warning: '#B86B00',
                        danger: '#C62B2B'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        };
    </script>
    <style>
        html {
            scroll-behavior: smooth
        }

        body {
            margin: 0
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24
        }

        .track-step {
            position: relative
        }

        .track-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 19px;
            left: calc(50% + 25px);
            right: calc(-50% + 25px);
            height: 3px;
            background: #e1e3e3
        }

        .track-step.done:not(:last-child)::after {
            background: #16804b
        }

        @media(max-width:640px) {
            .track-step:not(:last-child)::after {
                left: calc(50% + 18px);
                right: calc(-50% + 18px);
                top: 15px
            }

            .track-step .step-icon {
                width: 32px;
                height: 32px
            }

            .track-step .step-icon .material-symbols-outlined {
                font-size: 17px
            }
        }
    </style>
</head>

<body class="bg-surface font-sans text-on-surface antialiased min-h-screen flex flex-col">
    <!-- Header disamakan dengan Formulir Pemesanan Pelanggan -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-outline-variant/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-4">
            <a href="{{ url('/preview-order/new') }}" class="flex items-center gap-4 min-w-0 no-underline">
                <div class="w-12 h-12 rounded-xl bg-white border border-primary/15 flex items-center justify-center shadow-sm shrink-0"
                    aria-label="Presma Konveksi">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo Presma" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <svg style="display:none" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                        <g fill="none" stroke="#830909" stroke-width="3" stroke-linecap="round">
                            <path d="M16 3 21 11 29 16 21 21 16 29 11 21 3 16 11 11Z" />
                            <path d="M16 9v14M9 16h14" />
                        </g>
                    </svg>
                </div>
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-2 flex-wrap"><strong
                            class="text-sm md:text-base font-extrabold tracking-tight text-primary">PRESMA
                            KONVEKSI</strong><span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full bg-primary-tint text-primary">Official
                            Order</span></div>
                    <span class="text-xs text-secondary truncate">Garment, Korsa, PDH, Jaket &amp; Konveksi
                        Profesional</span>
                </div>
            </a>
            <a href="{{ url('/preview-order/new') }}"
                class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-semibold transition-colors"><span
                    class="material-symbols-outlined text-lg">add_circle</span>Buat Pesanan</a>
        </div>
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 py-8 md:py-10">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ url('/preview-order/new') }}"
                class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-secondary hover:text-primary hover:bg-surface-container transition-colors"><span
                    class="material-symbols-outlined text-lg">arrow_back</span>Kembali ke Formulir Pemesanan</a>
            <span
                class="inline-flex items-center gap-2 rounded-full bg-white border border-outline-variant px-3 py-1.5 text-xs font-semibold text-secondary"><span
                    class="w-2 h-2 rounded-full bg-warning"></span>Pelacakan Pesanan</span>
        </div>

        <section class="bg-white rounded-2xl border border-outline-variant/70 shadow-sm p-5 sm:p-8 mb-6">
            <div class="flex items-start gap-3 mb-5">
                <div
                    class="w-11 h-11 rounded-xl bg-primary-tint text-primary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-2xl">local_shipping</span></div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-primary mb-1">Presma Konveksi</p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Lacak Pesanan Kamu</h1>
                    <p class="mt-2 text-sm text-secondary leading-relaxed">Masukkan kode order atau kode tracking yang
                        muncul setelah formulir dikirim. Tidak perlu login.</p>
                </div>
            </div>
            <form id="trackingForm" class="flex flex-col sm:flex-row gap-3" novalidate>
                <label for="trackingCode" class="sr-only">Kode order atau tracking</label><input id="trackingCode"
                    name="trackingCode" autocomplete="off"
                    class="flex-1 min-w-0 rounded-xl border-outline-variant bg-surface px-4 py-3 text-sm uppercase focus:border-primary focus:ring-primary"
                    placeholder="Contoh: DEMO-TRK-... atau kode order" required>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary hover:bg-primary-hover px-5 py-3 text-sm font-bold text-white transition-colors"><span
                        class="material-symbols-outlined text-lg">search</span>Cek Pesanan</button>
            </form>
            <p id="searchMessage" class="hidden mt-3 text-sm" role="status" aria-live="polite"></p>
        </section>

        <section id="trackingResult" class="hidden space-y-6" aria-live="polite">
            <div class="bg-white rounded-2xl border border-outline-variant/70 shadow-sm p-5 sm:p-7">
                <div
                    class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-5 border-b border-surface-container">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-secondary mb-2"><span
                                class="material-symbols-outlined align-middle text-base text-primary">receipt_long</span>
                            Ringkasan Pelacakan</p>
                        <h2 class="text-xl sm:text-2xl font-extrabold">Order <span id="orderCode"
                                class="text-primary break-all"></span></h2>
                        <p class="text-sm text-secondary mt-2">Kode tracking: <span id="trackingCodeLabel"
                                class="font-semibold text-on-surface break-all"></span></p>
                    </div>
                    <span id="statusBadge"
                        class="self-start rounded-full bg-primary-tint px-3 py-2 text-xs font-bold text-primary">Menunggu
                        Verifikasi CS</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 py-5">
                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs text-secondary mb-1">Nama Pemesan</p>
                        <p id="customerName" class="font-bold break-words">-</p>
                    </div>
                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs text-secondary mb-1">Produk</p>
                        <p id="productName" class="font-bold break-words">-</p>
                    </div>
                    <div class="rounded-xl bg-surface-container-low p-4">
                        <p class="text-xs text-secondary mb-1">Jumlah Pesanan</p>
                        <p class="font-bold"><span id="quantity">-</span> pcs</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3"><span
                            class="material-symbols-outlined text-primary">calendar_month</span>
                        <div>
                            <p class="text-xs text-secondary">Tanggal Pengajuan</p>
                            <p id="createdDate" class="text-sm font-semibold">-</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3"><span
                            class="material-symbols-outlined text-primary">event</span>
                        <div>
                            <p class="text-xs text-secondary">Deadline yang Diajukan</p>
                            <p id="deadline" class="text-sm font-semibold">Belum diisi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-outline-variant/70 shadow-sm p-5 sm:p-7">
                <h2 class="text-lg font-extrabold mb-6">Perjalanan Pesanan</h2>
                <div id="timeline" class="grid grid-cols-2 md:grid-cols-4 gap-5"></div>
                <div
                    class="mt-6 flex items-start gap-3 rounded-xl border border-outline-variant bg-surface-container-low p-4">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <div>
                        <p class="text-sm font-bold">Informasi status</p>
                        <p id="statusDescription" class="mt-1 text-sm text-secondary leading-relaxed"></p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3"><a id="whatsappLink" target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#16804B] hover:bg-[#126b3e] px-4 py-3 text-sm font-bold text-white"><span
                        class="material-symbols-outlined">chat</span>Tanya CS via WhatsApp</a><button
                    id="searchAnother" type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-outline-variant bg-white hover:bg-surface-container px-4 py-3 text-sm font-bold text-on-surface"><span
                        class="material-symbols-outlined">search</span>Lacak Pesanan Lain</button></div>
        </section>

        <section class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-4 flex items-start gap-3"><span
                class="material-symbols-outlined text-amber-700">info</span>
            <p class="text-xs sm:text-sm text-amber-900 leading-relaxed"><strong>Catatan pratinjau:</strong> halaman
                ini membaca data formulir dari penyimpanan browser yang sama. Status belum tersambung ke database atau
                update produksi dari tim CS. Untuk status resmi, konfirmasi melalui WhatsApp Presma.</p>
        </section>
    </main>

    <footer class="bg-white border-t border-outline-variant/60 py-6 mt-4 text-xs text-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2"><span class="font-bold text-on-surface">Presma
                    Konveksi</span><span>•</span><span>Spesialis Pembuatan Korsa, PDH, Jaket, Kaos &amp;
                    Merchandise</span></div>
            <div>Hotline Layanan CS: <a class="font-semibold text-primary hover:underline"
                    href="https://wa.me/6285177154445" target="_blank" rel="noopener noreferrer">+62
                    851-7715-4445</a></div>
        </div>
    </footer>

    <script>
        (function() {
            const form = document.getElementById('trackingForm'),
                input = document.getElementById('trackingCode'),
                result = document.getElementById('trackingResult'),
                message = document.getElementById('searchMessage');
            const stages = [{
                    title: 'Pesanan Masuk',
                    sub: 'Formulir diterima',
                    icon: 'assignment_turned_in'
                },
                {
                    title: 'Verifikasi & Fiksasi',
                    sub: 'Pemeriksaan CS',
                    icon: 'fact_check'
                },
                {
                    title: 'Produksi',
                    sub: 'Pengerjaan pesanan',
                    icon: 'precision_manufacturing'
                },
                {
                    title: 'Siap Kirim',
                    sub: 'QC dan penyerahan',
                    icon: 'local_shipping'
                }
            ];

            function readOrders() {
                try {
                    return JSON.parse(localStorage.getItem('presma_public_preview_orders') || '[]')
                } catch (e) {
                    return []
                }
            }

            function esc(value) {
                return String(value ?? '-').replace(/[&<>"']/g, c => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [c]))
            }

            function showMessage(text, ok) {
                message.textContent = text;
                message.classList.remove('hidden', 'text-red-700', 'text-emerald-700');
                message.classList.add(ok ? 'text-emerald-700' : 'text-red-700')
            }

            function stageIndex(status) {
                const s = String(status || '').toLowerCase();
                if (s.includes('selesai') || s.includes('diterima')) return 3;
                if (s.includes('siap kirim') || s.includes('siap diambil')) return 3;
                if (s.includes('produksi') || s.includes('bordir') || s.includes('jahit') || s.includes('diproses'))
                    return 2;
                if (s.includes('verifikasi') || s.includes('fiksasi')) return 1;
                return 0
            }

            function render(order) {
                result.classList.remove('hidden');
                document.getElementById('orderCode').textContent = order.code || '-';
                document.getElementById('trackingCodeLabel').textContent = order.tracking || '-';
                document.getElementById('customerName').textContent = order.name || '-';
                document.getElementById('productName').textContent = order.product || '-';
                document.getElementById('quantity').textContent = order.qty ?? '-';
                const created = order.createdAt ? new Date(order.createdAt) : null;
                document.getElementById('createdDate').textContent = created && !isNaN(created) ? created
                    .toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    }) : 'Belum tersedia';
                document.getElementById('deadline').textContent = order.deadline || 'Belum diisi';
                const status = order.status || 'Menunggu Verifikasi CS';
                document.getElementById('statusBadge').textContent = status;
                const idx = stageIndex(status);
                document.getElementById('timeline').innerHTML = stages.map((s, i) => {
                    const done = i < idx,
                        active = i === idx;
                    const cls = done ? 'bg-emerald-600 text-white' : active ?
                        'bg-primary text-white ring-4 ring-primary-tint' :
                        'bg-surface-container-high text-secondary';
                    return `<div class="track-step ${done?'done':''} flex flex-col items-center text-center"><div class="step-icon relative z-10 w-10 h-10 rounded-full flex items-center justify-center mb-3 ${cls}"><span class="material-symbols-outlined">${done?'check':s.icon}</span></div><p class="text-sm font-bold ${done?'text-emerald-700':active?'text-primary':'text-secondary'}">${i+1}. ${s.title}</p><p class="text-xs text-secondary mt-1">${s.sub}</p>${active?'<span class="mt-2 rounded-full bg-primary-tint text-primary px-2 py-1 text-[10px] font-bold">Tahap sekarang</span>':done?'<span class="mt-2 rounded-full bg-emerald-50 text-emerald-700 px-2 py-1 text-[10px] font-bold">Selesai</span>':''}</div>`
                }).join('');
                document.getElementById('statusDescription').textContent = 'Status yang tercatat pada pengajuan ini: ' +
                    status +
                    '. Untuk konfirmasi status produksi terbaru, hubungi Customer Service Presma dengan menyertakan kode order.';
                const waText =
                    `Halo CS Presma Konveksi, saya ingin menanyakan status pesanan ${order.code||''} dengan kode tracking ${order.tracking||''}.`;
                document.getElementById('whatsappLink').href = 'https://wa.me/6285177154445?text=' + encodeURIComponent(
                    waText);
                result.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const key = input.value.trim().toUpperCase();
                if (!key) {
                    showMessage('Masukkan kode order atau kode tracking terlebih dahulu.', false);
                    return
                }
                const order = readOrders().find(x => String(x.tracking || '').toUpperCase() === key || String(x
                    .code || '').toUpperCase() === key);
                if (!order) {
                    result.classList.add('hidden');
                    showMessage(
                        'Kode tidak ditemukan pada browser ini. Pastikan kode benar dan gunakan browser/perangkat yang sama saat mengirim formulir.',
                        false);
                    return
                }
                message.classList.add('hidden');
                showMessage('Pesanan ditemukan.', true);
                render(order)
            });
            document.getElementById('searchAnother').addEventListener('click', () => {
                input.value = '';
                result.classList.add('hidden');
                message.classList.add('hidden');
                input.focus();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                })
            });
            const params = new URLSearchParams(window.location.search);
            const initial = params.get('tracking') || params.get('code') || '';
            if (initial) {
                input.value = initial;
                form.requestSubmit()
            }
        })();
    </script>
</body>

</html>
