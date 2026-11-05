<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Formulir Pemesanan Seragam &amp; Garment - Presma Konveksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#830909",
                        "primary-hover": "#A10B0B",
                        "primary-tint": "#F7E7E7",
                        "primary-dark": "#5c0002",
                        secondary: "#635D5E",
                        "on-surface": "#231F20",
                        "on-surface-variant": "#59413E",
                        surface: "#F8F9F9",
                        "surface-container-lowest": "#FFFFFF",
                        "surface-container-low": "#F1F2F2",
                        "surface-container": "#EDEEEE",
                        "surface-container-high": "#E7E8E8",
                        "surface-container-highest": "#E1E3E3",
                        outline: "#8D706C",
                        "outline-variant": "#D9DADB",
                        error: "#BA1A1A",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-surface font-sans text-on-surface antialiased min-h-screen flex flex-col">
    <!-- Desktop Top Header Bar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-outline-variant/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo & Identity -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-white border border-primary/15 flex items-center justify-center shadow-sm shrink-0"
                    aria-label="Presma Konveksi">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Presma" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                    <svg style="display:none" width="32" height="32" viewBox="0 0 32 32" aria-hidden="true">
                        <g fill="none" stroke="#830909" stroke-width="3" stroke-linecap="round">
                            <path d="M16 3 21 11 29 16 21 21 16 29 11 21 3 16 11 11Z" />
                            <path d="M16 9v14M9 16h14" />
                        </g>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 flex-wrap">
                        <strong class="text-sm md:text-base font-extrabold tracking-tight text-primary">PRESMA
                            KONVEKSI</strong>
                        <span
                            class="px-2 py-0.5 text-xs font-semibold rounded-full bg-primary-tint text-primary">Official
                            Order</span>
                    </div>
                    <span class="text-xs text-secondary">Garment, Korsa, PDH, Jaket &amp; Konveksi Profesional</span>
                </div>
            </div>
            <!-- Navigation & Hotline Info -->
            <div class="flex items-center gap-6">
                <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-secondary"><a
                        href="{{ url('/preview-order/check') }}" class="hover:text-primary font-semibold">Cek
                        Pesanan</a>



                </nav>
                <div class="h-6 w-px bg-outline-variant hidden md:block"></div>
                <a class="flex items-center gap-2.5 px-4 py-2 rounded-xl bg-green-50 text-green-800 border border-green-200/80 hover:bg-green-100 hover:border-green-300 transition shadow-sm group"
                    href="https://wa.me/6285177154445" target="_blank">
                    <span
                        class="material-symbols-outlined text-green-700 text-xl group-hover:scale-110 transition-transform">support_agent</span>
                    <div class="flex flex-col text-left">
                        <span
                            class="text-[10px] font-semibold uppercase tracking-wider text-green-700 leading-none">Hotline
                            CS Presma</span>
                        <span class="text-xs font-bold text-green-950 font-mono tracking-tight">+62 851-7715-4445</span>
                    </div>
                </a>
            </div>
        </div>
    </header>
    <!-- Breadcrumbs & Page Intro Banner -->
    <div class="bg-gradient-to-b from-white to-surface border-b border-outline-variant/40 py-6">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center gap-2 text-xs font-medium text-secondary mb-2">





            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Formulir Spesifikasi &amp; Pemesanan
                        Produksi</h1>
                    <p class="text-sm text-secondary mt-1">Lengkapi rincian pesanan Anda. Tim teknis &amp; CS Presma
                        Konveksi akan memeriksa formulir dan menghubungi Anda untuk konfirmasi pesanan.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Layout (Desktop 2 Columns: Wide Form + Sticky Summary Sidebar) -->
    <main class="max-w-7xl mx-auto px-6 py-8 flex-1 w-full">
        <form class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start" id="publicOrderForm" novalidate
            onsubmit="event.preventDefault(); submitOrder();">
            <!-- LEFT COLUMN: Comprehensive Interactive Form (8 Columns) -->
            <div class="lg:col-span-8 space-y-8"><!-- STEPPER WIZARD PROGRESS BAR -->
                <div
                    class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/60 mb-6">
                    <div class="flex items-center justify-between relative">
                        <div class="absolute top-1/2 left-8 right-8 -translate-y-1/2 h-1 bg-outline-variant/40 -z-0"
                            id="stepProgressBar">
                            <div class="h-full bg-primary transition-all duration-300" id="stepProgressFill"
                                style="width: 100%;"></div>
                        </div>
                        <!-- Step Indicator 1 -->
                        <button class="relative z-10 flex flex-col items-center gap-1.5 focus:outline-none group"
                            id="stepIndicatorBtn-1" type="button" disabled aria-disabled="true"
                            title="Gunakan tombol Lanjut atau Kembali">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-green-600 text-white"
                                id="stepCircle-1"><span class="material-symbols-outlined text-lg">check</span></div>
                            <div class="text-center">
                                <span class="block text-xs font-semibold text-on-surface leading-tight"
                                    id="stepTitle-1">Identitas &amp; Produk</span>
                                <span class="text-[10px] text-secondary hidden sm:block">Data dasar pemesan</span>
                            </div>
                        </button>
                        <!-- Step Indicator 2 -->
                        <button class="relative z-10 flex flex-col items-center gap-1.5 focus:outline-none group"
                            id="stepIndicatorBtn-2" type="button" disabled aria-disabled="true"
                            title="Gunakan tombol Lanjut atau Kembali">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-green-600 text-white"
                                id="stepCircle-2"><span class="material-symbols-outlined text-lg">check</span></div>
                            <div class="text-center">
                                <span class="block text-xs font-semibold text-on-surface leading-tight"
                                    id="stepTitle-2">Spesifikasi &amp; Desain</span>
                                <span class="text-[10px] text-secondary hidden sm:block">Bahan, saku &amp; mockup</span>
                            </div>
                        </button>
                        <!-- Step Indicator 3 -->
                        <button class="relative z-10 flex flex-col items-center gap-1.5 focus:outline-none group"
                            id="stepIndicatorBtn-3" type="button" disabled aria-disabled="true"
                            title="Gunakan tombol Lanjut atau Kembali">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-primary text-white ring-4 ring-primary-tint/60"
                                id="stepCircle-3">3</div>
                            <div class="text-center">
                                <span class="block text-xs font-bold text-primary leading-tight" id="stepTitle-3">Ukuran
                                    &amp; Selesai</span>
                                <span class="text-[10px] text-secondary hidden sm:block">List nama, addons &amp;
                                    deadline</span>
                            </div>
                        </button>
                    </div>
                </div>
                <!-- STEP 1 CONTAINER: IDENTITAS & PRODUK -->
                <div class="space-y-8 transition-all block" id="stepPanel-1">
                    <!-- SECTION 1: DATA IDENTITAS PEMESAN -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                1
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Data Identitas Pemesan</h2>
                                <p class="text-xs text-secondary">Data kontak penanggung jawab pesanan untuk koordinasi
                                    nota &amp; approval mockup</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- NAMA -->
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="customerName">
                                    NAMA LENGKAP <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">person</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition"
                                        id="customerName" oninput="updateLiveSummary()"
                                        placeholder="Desti" required="" type="text">
                                </div>
                            </div>
                            <!-- NOMOR HP/WHATSAPP -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="whatsappNumber">
                                    NOMOR HP / WHATSAPP <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <div
                                        class="absolute left-3 flex items-center gap-1 text-secondary text-xs font-semibold border-r border-outline-variant pr-2">
                                        <span class="material-symbols-outlined text-base">chat</span>
                                        <span class="">+62</span>
                                    </div>
                                    <input
                                        class="w-full h-11 pl-20 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm font-mono transition"
                                        id="whatsappNumber" oninput="updateLiveSummary()" placeholder="812-3456-4"
                                        required="" type="tel">
                                </div>
                                <span class="text-[11px] text-secondary">Pastikan nomor aktif WhatsApp untuk konfirmasi
                                    nota penawaran.</span>
                            </div>
                            <!-- INSTANSI/KAMPUS/SEKOLAH -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="institutionName">
                                    INSTANSI / KAMPUS / SEKOLAH <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">school</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition"
                                        id="institutionName" oninput="updateLiveSummary()"
                                        placeholder="Contoh: BEM FT UGM / PT Mandiri / SMA 1..." required=""
                                        type="text">
                                </div>
                                <span class="text-[11px] text-secondary">Nama organisasi, fakultas, perhimpunan, atau
                                    perusahaan.</span>
                            </div>
                            <!-- TAU PRESMA DARI MANA? -->
                            <div class="flex flex-col gap-1.5 md:col-span-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="sourceChannel">
                                    TAU PRESMA DARI MANA? <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">explore</span>
                                    <select
                                        class="w-full h-11 pl-11 pr-10 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition appearance-none cursor-pointer"
                                        id="sourceChannel" required="">
                                        <option value="">-- Pilih Sumber Informasi --</option>
                                        <option value="INSTAGRAM">Instagram (@presmakonveksi)</option>
                                        <option value="TIKTOK">TikTok</option>
                                        <option value="REKOMENDASI_TEMAN">Rekomendasi Teman / Alumni</option>
                                        <option value="LAINNYA">Google Search / Website</option>
                                        <option value="LAINNYA">Event / Bazar Kampus</option>
                                        <option value="LAINNYA">Lainnya</option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-3.5 text-secondary pointer-events-none text-xl">expand_more</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 2: JENIS PRODUK & MODEL/CUTTINGAN -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                2
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Jenis Produk &amp; Model Cuttingan</h2>
                                <p class="text-xs text-secondary">Pilih kategori garmen utama dan bentuk pola jahit
                                    yang diinginkan</p>
                            </div>
                        </div>
                        <!-- JENIS PRODUK -->
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface">
                                    JENIS PRODUK <span class="text-error">*</span>
                                </label>
                                <span class="text-xs text-secondary">Pilih salah satu produk utama</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2.5" id="productGrid">
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input checked="" class="hidden" name="jenisProduk"
                                        onchange="updateLiveSummary()" type="radio" value="Korsa/PDH/PDL">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">military_tech</span>
                                    <span class="text-xs font-semibold leading-tight">Korsa / PDH / PDL</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Korsa hybrid 2 in 1">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">shuffle</span>
                                    <span class="text-xs font-semibold leading-tight">Korsa hybrid 2 in 1</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Rompi/Vest">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">shield</span>
                                    <span class="text-xs font-semibold leading-tight">Rompi / Vest</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Workshirt">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">engineering</span>
                                    <span class="text-xs font-semibold leading-tight">Workshirt</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Jaket/Hoodie/Sweater">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">sports_baseball</span>
                                    <span class="text-xs font-semibold leading-tight">Jaket/Hoodie</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Kaos">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">checkroom</span>
                                    <span class="text-xs font-semibold leading-tight">Kaos</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Polo">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">styler</span>
                                    <span class="text-xs font-semibold leading-tight">Polo Shirt</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Jersey">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">sports_soccer</span>
                                    <span class="text-xs font-semibold leading-tight">Jersey</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Jas/Almamater">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">badge</span>
                                    <span class="text-xs font-semibold leading-tight">Jas / Almamater</span>
                                </label>
                                <label
                                    class="cursor-pointer border border-outline-variant/80 rounded-xl p-3 flex flex-col items-center justify-center gap-2 text-center hover:bg-surface-container-low transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/30 has-[:checked]:text-primary group">
                                    <input class="hidden" name="jenisProduk" onchange="updateLiveSummary()"
                                        type="radio" value="Scrub/Baju OK">
                                    <span
                                        class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">medical_services</span>
                                    <span class="text-xs font-semibold leading-tight">Scrub / Baju OK</span>
                                </label>
                            </div>
                        </div>
                        <!-- MODEL / CUTTINGAN -->
                        <div class="space-y-2 pt-2 border-t border-outline-variant/50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface">
                                        MODEL / CUTTINGAN <span class="text-error">*</span>
                                    </label>
                                    <span
                                        class="px-2 py-0.5 rounded text-[11px] font-semibold bg-primary-tint text-primary">Dapat
                                        dipilih lebih dari satu</span>
                                </div>
                                <span class="text-xs text-secondary">Contoh: Lengan Panjang &amp; Tunik</span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input checked=""
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Lengan Pendek">
                                    <span class="text-xs font-medium text-on-surface">Lengan Pendek</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Lengan Panjang">
                                    <span class="text-xs font-medium text-on-surface">Lengan Panjang</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Regular Fit">
                                    <span class="text-xs font-medium text-on-surface">Regular Fit</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Slim Fit">
                                    <span class="text-xs font-medium text-on-surface">Slim Fit</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Boxy">
                                    <span class="text-xs font-medium text-on-surface">Boxy</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Oversize">
                                    <span class="text-xs font-medium text-on-surface">Oversize</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Tunik">
                                    <span class="text-xs font-medium text-on-surface">Tunik</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Crop Top">
                                    <span class="text-xs font-medium text-on-surface">Crop Top</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="modelCutting" onchange="updateLiveSummary()" type="checkbox"
                                        value="Custom (Diskusikan Dengan CS)">
                                    <span class="text-xs font-medium text-on-surface">Custom (Diskusikan CS)</span>
                                </label>
                            </div>
                            <div class="pt-2 mt-2 border-t border-outline-variant/40"><label for="customModelCutting"
                                    class="flex items-center gap-2 mb-1.5 cursor-pointer"><span
                                        class="material-symbols-outlined text-primary text-base">edit_note</span><span
                                        class="text-xs font-bold text-on-surface">Model / Cuttingan Lainnya:</span><span
                                        class="text-[11px] text-secondary font-normal">(Opsional)</span></label>
                                <div class="relative flex items-center"><input id="customModelCutting" type="text"
                                        placeholder="Contoh: Kombinasi lengan raglan, potongan lengkung bawah (curved hem), belahan samping tinggi..."
                                        class="w-full h-11 px-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-xs text-on-surface transition"
                                        oninput="updateLiveSummary()"></div><span
                                    class="text-[10px] text-secondary mt-1 block">Ketik preferensi pola khusus di sini
                                    jika opsi checklist di atas belum mencakup kebutuhan pola seragam Anda.</span>
                            </div>
                        </div>
                    </section>
                    <!-- Step 1 Nav Buttons -->
                    <div class="flex items-center justify-end pt-2">
                        <button
                            class="w-full sm:w-auto px-6 h-12 rounded-xl bg-primary hover:bg-primary-hover active:scale-[0.99] text-white font-bold text-sm flex items-center justify-center gap-2 shadow-md shadow-primary/20 transition-all cursor-pointer"
                            onclick="goToStep(2)" type="button">
                            <span class="">Lanjut: Spesifikasi &amp; Desain</span>
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </div>
                </div>
                <!-- STEP 2 CONTAINER: SPESIFIKASI & DESAIN -->
                <div class="space-y-8 transition-all hidden" id="stepPanel-2">
                    <!-- SECTION 3: BAHAN & WARNA -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                3
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Bahan &amp; Warna Pilihan</h2>
                                <p class="text-xs text-secondary">Spesifikasi material kain dan kombinasi visual warna
                                    seragam</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- BAHAN -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="fabricChoice">
                                    BAHAN YANG DIGUNAKAN <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">texture</span>
                                    <select
                                        class="w-full h-11 pl-11 pr-10 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition appearance-none cursor-pointer"
                                        id="fabricChoice" onchange="updateLiveSummary()" required="">
                                        <option value="">-- Pilih Jenis Bahan Rekomendasi --</option>
                                        <option value="Nagata Drill (Halus, Adem &amp; Kokoh)">Nagata Drill (Halus,
                                            Adem &amp; Kokoh untuk PDL/Korsa)</option>
                                        <option value="American Drill (Standar Seragam Kerja)">American Drill (Standar
                                            Seragam Kerja Ekonomis)</option>
                                        <option value="Hisofy Drill (Sangat Lembut &amp; Jatuh)">Hisofy Drill (Sangat
                                            Lembut &amp; Jatuh)</option>
                                        <option value="Cotton Combed 24s/30s (Kaos Halus)">Cotton Combed 24s / 30s
                                            (Kaos Halus 100% Katun)</option>
                                        <option value="Lacoste CVC Pique (Polo Shirt)">Lacoste CVC Pique (Polo Shirt
                                            Sejuk &amp; Elegan)</option>
                                        <option value="Cotton Fleece 280-330gsm (Jaket/Hoodie)">Cotton Fleece
                                            280-330gsm (Jaket / Hoodie Tebal)</option>
                                        <option value="Taslan Waterproof (Outdoor / Windbreaker)">Taslan Waterproof
                                            (Outdoor / Windbreaker Tahan Air)</option>
                                        <option value="Ripstop Tornado (Tactical Anti Sobek)">Ripstop Tornado (Tactical
                                            Anti Sobek)</option>
                                        <option value="Dryfit Milano / Benzema (Jersey Olahraga)">Dryfit Milano /
                                            Benzema (Jersey Olahraga)</option>
                                        <option value="Lainnya / Rekomendasi CS">Lainnya / Minta Rekomendasi CS Presma
                                        </option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-3.5 text-secondary pointer-events-none text-xl">expand_more</span>
                                </div>
                                
                            </div>
                            <!-- WARNA -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="colorChoice">
                                    WARNA YANG DIGUNAKAN <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">palette</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition"
                                        id="colorChoice" oninput="updateLiveSummary()"
                                        placeholder="Contoh: Navy Blue variasi Putih &amp; list Merah..."
                                        required="" type="text">
                                </div>
                                <span class="text-[11px] text-secondary">Sebutkan warna badan utama serta aksen warna
                                    saku/kerah jika berkombinasi.</span>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 4: SPESIFIKASI DETAIL -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                4
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Spesifikasi Detail Produksi</h2>
                                <p class="text-xs text-secondary">Rincian model saku, peletakan bordir / sablon, dan
                                    fitur variasi khusus</p>
                            </div>
                        </div>
                        <div class="space-y-5">
                            <!-- MODEL SAKU -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                        for="pocketModel">
                                        MODEL SAKU
                                    </label>
                                    <span class="text-[11px] text-secondary">Saku bobok / tempel / resleting</span>
                                </div>
                                <div class="relative">
                                    <textarea
                                        class="w-full p-3.5 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition resize-none"
                                        id="pocketModel"
                                        placeholder="Contoh: 4 saku, 2 atas dan 2 bawah menggunakan saku tempel/gembung dengan tutup kancing..."
                                        required="" rows="2"></textarea>
                                </div>

                            </div>
                            <!-- KETERANGAN BORDIR/SABLON -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                        for="embroideryDetails">
                                        KETERANGAN BORDIR / SABLON <span class="text-error">*</span>
                                    </label>
                                    <span class="text-[11px] text-secondary">Bordir komputer presisi / DTF
                                        premium</span>
                                </div>
                                <div class="relative">
                                    <textarea
                                        class="w-full p-3.5 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition resize-none"
                                        id="embroideryDetails"
                                        placeholder="Contoh: Bordir logo dada kiri, nama di kanan menggunakan bordir reguler, logo bendera di lengan kanan, tulisan punggung bordir besar..."
                                        required="" rows="2"></textarea>
                                </div>

                            </div>
                            <!-- VARIASI LAIN -->
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                        for="otherVariations">
                                        VARIASI LAIN
                                    </label>
                                    <span class="text-[11px] text-secondary">Opsional / Tambahan fitur jahit</span>
                                </div>
                                <div class="relative">
                                    <textarea
                                        class="w-full p-3.5 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition resize-none"
                                        id="otherVariations"
                                        placeholder="Contoh: Menggunakan furing jaring bagian dalam, resleting seamless waterproof, scotchlite reflective di dada dan punggung, ventilasi udara punggung..."
                                        rows="2"></textarea>
                                </div>

                            </div>
                        </div>
                    </section>
                    <!-- SECTION 5: STATUS DESAIN & FILE -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                5
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Status Desain &amp; Pengiriman File</h2>
                                <p class="text-xs text-secondary">Kesiapan artwork mockup, materi logo, dan metode
                                    penyerahan file desain</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- STATUS DESAINMU -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="statusDesain">
                                    STATUS DESAINMU <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">draw</span>
                                    <select
                                        class="w-full h-11 pl-11 pr-10 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition appearance-none cursor-pointer"
                                        id="statusDesain" required="">
                                        <option value="">-- Pilih Kesiapan Desain --</option>
                                        <option value="Sudah Ada Mockup / Desain Siap Cetak (CDR, AI, PDF)">Sudah Ada
                                            Mockup / Desain Siap Cetak (CDR, AI, PDF)</option>
                                        <option value="Desain Masih Sketsa / Gambar Kasar / Foto Referensi">Desain
                                            Masih Sketsa / Gambar Kasar / Foto Referensi</option>
                                        <option value="Belum Ada Desain Sama Sekali (Minta Dibuatkan CS Presma)">Belum
                                            Ada Desain Sama Sekali (Minta Dibuatkan CS Presma)</option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-3.5 text-secondary pointer-events-none text-xl">expand_more</span>
                                </div>
                                <span class="text-[11px] text-secondary">Jika belum ada desain, desainer Presma akan
                                    membuatkan mockup digital 2D secara gratis.</span>
                            </div>
                            <!-- METODE PENGIRIMAN -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="fileDeliveryMethod">
                                    METODE FILE DESAIN
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">cloud_upload</span>
                                    <select
                                        class="w-full h-11 pl-11 pr-10 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition appearance-none cursor-pointer"
                                        id="fileDeliveryMethod" onchange="toggleFileDeliveryField(this.value)"
                                        required="">
                                        <option value="upload">Upload File Mockup / Logo Langsung</option>
                                        <option value="link">Lampirkan Link Google Drive / Dropbox</option>
                                        <option value="whatsapp">Kirim File Menyusul via WhatsApp CS</option>
                                    </select>
                                    <span
                                        class="material-symbols-outlined absolute right-3.5 text-secondary pointer-events-none text-xl">expand_more</span>
                                </div>
                                <span class="text-[11px] text-secondary">Pilih metode yang paling nyaman bagi Anda
                                    untuk melampirkan berkas.</span>
                            </div>
                        </div>
                        <!-- Dynamic Container -->
                        <div class="mt-4 pt-4 border-t border-outline-variant/40">
                            <!-- Mode 1: Direct File Upload -->
                            <div class="block" id="fileUploadContainer">
                                <label class="text-xs font-semibold text-on-surface-variant block mb-2">Upload Berkas
                                    Desain / Sketsa (Maks 100MB per file - Format CDR, AI, PDF, PNG, JPG, ZIP)</label>
                                <div class="border-2 border-dashed border-outline-variant rounded-xl p-5 text-center bg-surface/50 hover:bg-surface hover:border-primary/50 transition cursor-pointer flex flex-col items-center justify-center gap-2"
                                    onclick="document.getElementById('mockupFiles').click()">
                                    <input accept=".png,.jpg,.jpeg,.pdf,.cdr,.ai,.psd,.zip,.rar" class="hidden"
                                        id="mockupFiles" multiple="" onchange="handleMultipleFiles(this)"
                                        type="file">
                                    <div
                                        class="w-10 h-10 rounded-full bg-primary-tint/60 text-primary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-2xl">folder_zip</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-primary hover:underline">Klik di sini untuk
                                            memilih file</span>
                                        <span class="text-xs text-secondary"> atau tarik file ke dalam kotak ini</span>
                                    </div>
                                    <div class="hidden mt-1 px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full"
                                        id="fileCountBadge">
                                        <span id="fileCountText" class="">0 file terpilih</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Mode 2: Link -->
                            <div class="hidden" id="fileLinkContainer">
                                <label class="text-xs font-semibold text-on-surface-variant block mb-1.5"
                                    for="cloudDriveUrl">Tautan Google Drive / Dropbox / OneDrive</label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">link</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition"
                                        id="cloudDriveUrl" placeholder="https://drive.google.com/drive/folders/..."
                                        type="url">
                                </div>
                                <span class="text-[11px] text-secondary mt-1 block">Pastikan pengaturan hak akses link
                                    Google Drive terbuka: "Anyone with the link can view".</span>
                            </div>
                            <!-- Mode 3: WhatsApp -->
                            <div class="hidden p-4 rounded-xl bg-green-50 border border-green-200 text-green-900 flex items-start gap-3"
                                id="fileWaContainer">
                                <span class="material-symbols-outlined text-green-700 text-2xl">send_to_mobile</span>
                                <div class="text-xs leading-relaxed">
                                    <strong>Pengiriman via WhatsApp:</strong> Anda dapat langsung mengirimkan dokumen
                                    logo/mockup format HD/dokumen ke WhatsApp CS kami setelah formulir ini dikirimkan.
                                    Tim kami akan segera merespons Anda.
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 Nav Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                        <button
                            class="w-full sm:w-auto px-5 h-12 rounded-xl border border-outline-variant bg-surface hover:bg-white text-secondary hover:text-on-surface font-semibold text-sm flex items-center justify-center gap-2 transition cursor-pointer"
                            onclick="goToStep(1)" type="button">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            <span class="">Kembali ke Data Pemesan</span>
                        </button>
                        <button
                            class="w-full sm:w-auto px-6 h-12 rounded-xl bg-primary hover:bg-primary-hover active:scale-[0.99] text-white font-bold text-sm flex items-center justify-center gap-2 shadow-md shadow-primary/20 transition-all cursor-pointer"
                            onclick="goToStep(3)" type="button">
                            <span class="">Lanjut: Ukuran &amp; Deadline</span>
                            <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </div>
                </div>
                <!-- STEP 3 CONTAINER: LIST UKURAN, TAMBAHAN & DEADLINE -->
                <div class="space-y-8 transition-all hidden" id="stepPanel-3">
                    <!-- SECTION 6: LIST & JUMLAH UKURAN -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60"
                        id="sectionListUkuran">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                6</div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Jumlah Ukuran Pesanan</h2>
                                <p class="text-xs text-secondary">Masukkan jumlah pakaian untuk setiap ukuran. Jika ada
                                    daftar nama atau ukuran khusus, tuliskan pada kolom catatan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
                            <div class="md:col-span-4 bg-surface rounded-xl p-4 border border-outline-variant/60">
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                        for="totalQty">TOTAL PCS PESANAN <span class="text-error">*</span></label>
                                </div>
                                <div class="relative flex items-center mt-1">
                                    <span
                                        class="material-symbols-outlined absolute left-3 text-secondary text-xl">inventory_2</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-12 rounded-xl bg-white border border-outline-variant text-base font-mono font-bold text-primary"
                                        id="totalQty" min="12" readonly required type="number"
                                        value="0">
                                    <span class="absolute right-3.5 text-xs text-secondary font-semibold">Pcs</span>
                                </div>
                                <p class="text-[11px] text-secondary mt-1.5">Jumlah dihitung otomatis dari seluruh
                                    ukuran.</p>
                            </div>
                            <div class="md:col-span-8 bg-surface rounded-xl p-4 border border-outline-variant/60">
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="text-xs font-bold uppercase tracking-wider text-on-surface">Rekapitulasi
                                        Kuantiti Per Ukuran</span>
                                    <span class="text-[11px] text-secondary">Otomatis</span>
                                </div>
                                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2"
                                    id="sizeQuantityInputs">
                                    <label class="text-xs font-semibold text-on-surface">XS<input type="number"
                                            min="0" value="0" id="qty-XS" data-size="XS"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">S<input type="number"
                                            min="0" value="0" id="qty-S" data-size="S"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">M<input type="number"
                                            min="0" value="0" id="qty-M" data-size="M"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">L<input type="number"
                                            min="0" value="0" id="qty-L" data-size="L"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">XL<input type="number"
                                            min="0" value="0" id="qty-XL" data-size="XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">2XL<input type="number"
                                            min="0" value="0" id="qty-2XL" data-size="2XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">3XL<input type="number"
                                            min="0" value="0" id="qty-3XL" data-size="3XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">4XL<input type="number"
                                            min="0" value="0" id="qty-4XL" data-size="4XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">5XL<input type="number"
                                            min="0" value="0" id="qty-5XL" data-size="5XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-on-surface">6XL<input type="number"
                                            min="0" value="0" id="qty-6XL" data-size="6XL"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-outline-variant font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                    <label class="text-xs font-semibold text-primary">Custom / Khusus<input
                                            type="number" min="0" value="0" id="qty-TANPA_UKURAN"
                                            data-size="TANPA_UKURAN"
                                            class="size-quantity mt-1 w-full h-10 px-3 rounded-lg bg-white border border-primary/40 font-mono"
                                            oninput="recalcSizeQuantities()"></label>
                                </div>
                                <p class="text-[11px] text-secondary mt-3">Isi 0 jika ukuran tersebut tidak dipesan.
                                    Untuk ukuran custom, jelaskan detailnya di kolom catatan.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="memberSizeNotes" class="block text-xs font-bold text-on-surface">Daftar
                                    Nama & Ukuran (Opsional)</label>
                                <textarea id="memberSizeNotes" rows="5"
                                    class="w-full p-3 rounded-xl bg-surface border border-outline-variant text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder="Contoh:
1. Bagas - L
2. Nanda - M 
3. Rina - Bendahara - XL"></textarea>
                                <p class="text-[11px] text-secondary">Isi jika setiap pakaian memiliki nama bordir atau
                                    ukuran per anggota yang perlu dicatat.</p>
                            </div>
                            <div class="space-y-2">
                                <label for="otherSizeNotes" class="block text-xs font-bold text-on-surface">Catatan
                                    Ukuran / Permintaan Khusus Lainnya</label>
                                <textarea id="otherSizeNotes" rows="5"
                                    class="w-full p-3 rounded-xl bg-surface border border-outline-variant text-sm focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder="Contoh: 2 pcs ukuran L dibuat lebih panjang 5 cm; ukuran custom lingkar dada 110 cm."></textarea>
                                <p class="text-[11px] text-secondary">Tuliskan perbedaan ukuran, detail cutting, atau
                                    instruksi produksi lain jika ada.</p>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 7: TAMBAHAN PRODUK -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                7
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Tambahan (Merchandise &amp; Pelengkap)
                                </h2>
                                <p class="text-xs text-secondary">Pilihan paket bundling aksesoris event, kepanitiaan,
                                    atau perlengkapan seragam</p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Lanyard">
                                    <span class="text-xs font-semibold text-on-surface">Lanyard</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="ID Card">
                                    <span class="text-xs font-semibold text-on-surface">ID Card</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Banner">
                                    <span class="text-xs font-semibold text-on-surface">Banner</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Tumbler">
                                    <span class="text-xs font-semibold text-on-surface">Tumbler</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Topi">
                                    <span class="text-xs font-semibold text-on-surface">Topi</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Totebag">
                                    <span class="text-xs font-semibold text-on-surface">Totebag</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="updateLiveSummary()" type="checkbox"
                                        value="Gantungan Kunci">
                                    <span class="text-xs font-semibold text-on-surface">Gantungan Kunci</span>
                                </label>
                                <label
                                    class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/80 bg-surface hover:bg-white cursor-pointer transition has-[:checked]:border-primary has-[:checked]:bg-primary-tint/20">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        name="tambahan" onchange="handleNoAddons(this)" type="checkbox"
                                        value="Tidak ada tambahan">
                                    <span class="text-xs font-semibold text-on-surface">Tidak ada tambahan</span>
                                </label>
                            </div>
                            <div class="pt-3 border-t border-outline-variant/50">
                                <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                    <input
                                        class="w-4 h-4 rounded text-primary focus:ring-primary border-outline-variant"
                                        id="otherAddonCheckbox" onchange="toggleOtherAddonInput(this)"
                                        type="checkbox">
                                    <span class="text-xs font-bold text-on-surface">Lain-lain (Item merchandise
                                        kustom)</span>
                                </label>
                                <div class="mt-2" id="otherAddonInputWrapper">
                                    <input
                                        class="w-full h-11 px-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm transition"
                                        id="otherAddonDetail" oninput="updateLiveSummary()"
                                        placeholder="Tuliskan tambahan lainnya (Contoh: Jas hujan, Rompi safety, Sticker pack, Bendera pataka)..."
                                        type="text">
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- SECTION 8: TARGET DEADLINE -->
                    <section
                        class="bg-surface-container-lowest rounded-2xl p-6 md:p-8 shadow-sm border border-outline-variant/60">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-outline-variant/60">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                8
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface">Tenggat Waktu Pemakaian (Deadline)</h2>
                                <p class="text-xs text-secondary">Estimasi jadwal penggunaan acara / pengiriman
                                    seragam selesai</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-center">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold uppercase tracking-wider text-on-surface"
                                    for="targetDeadline">
                                    TANGGAL DEADLINE KEBUTUHAN PAKAI <span class="text-error">*</span>
                                </label>
                                <div class="relative flex items-center">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 text-secondary text-xl">calendar_month</span>
                                    <input
                                        class="w-full h-11 pl-11 pr-4 rounded-xl bg-surface border border-outline-variant focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary text-sm font-mono transition"
                                        id="targetDeadline" onchange="updateLiveSummary()" required=""
                                        type="date">
                                </div>
                            </div>
                            <div
                                class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 flex items-start gap-3">
                                <span
                                    class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5">schedule</span>
                                <p class="text-xs text-secondary leading-relaxed">
                                    Standar pengerjaan massal berkisar antara <strong>10 s/d 21 hari kerja</strong>
                                    sejak DP &amp; approval sampel terverifikasi. Butuh kilat? Diskusikan jadwal darurat
                                    dengan CS kami.
                                </p>
                            </div>
                        </div>
                    </section>
                    <!-- INFO BOX & CS -->
                    <section
                        class="rounded-2xl p-6 bg-gradient-to-r from-amber-50/90 via-orange-50/70 to-amber-50/90 border border-amber-200/80 shadow-sm">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-amber-200/80 text-amber-900 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl">campaign</span>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs md:text-sm font-semibold text-amber-950">
                                        ⚠️ Jika detail fitur dikosongkan, maka akan kami buatkan sesuai standar presma
                                        konveksi.
                                    </p>
                                </div>
                            </div>
                            <a class="px-4 py-2.5 rounded-xl bg-amber-900 hover:bg-amber-950 text-white text-xs font-bold flex items-center gap-2 shadow-sm transition shrink-0"
                                href="https://wa.me/6285177154445" target="_blank">
                                <span class="material-symbols-outlined text-base">chat</span>
                                <span class="">Hubungi CS WhatsApp</span>
                            </a>
                        </div>
                    </section>
                    <!-- Step 3 Final Nav Buttons -->
                    <div class="space-y-4 pt-2">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                            <button
                                class="w-full sm:w-auto px-5 h-12 rounded-xl border border-outline-variant bg-surface hover:bg-white text-secondary hover:text-on-surface font-semibold text-sm flex items-center justify-center gap-2 transition cursor-pointer"
                                onclick="goToStep(2)" type="button">
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                                <span class="">Kembali ke Spesifikasi</span>
                            </button>
                            <button
                                class="w-full sm:flex-1 h-14 rounded-2xl bg-primary hover:bg-primary-hover active:scale-[0.99] text-white font-bold text-base flex items-center justify-center gap-3 shadow-lg shadow-primary/20 transition-all cursor-pointer"
                                id="submitBtn" type="submit">
                                <span class="material-symbols-outlined text-2xl">send</span>
                                <span class="">Kirim Formulir Pemesanan</span>
                            </button>
                        </div>
                        <div class="flex items-center justify-center gap-2 text-xs text-secondary">
                            <span class="material-symbols-outlined text-sm text-green-700">lock</span>
                            <span class="">Mode pratinjau: formulir belum dikirim ke server. Kode dan status
                                tersimpan hanya di browser ini.</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- RIGHT COLUMN: Sticky Summary, Guarantee & Order Guidance Sidebar (4 Columns) -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                <!-- Order Live Summary Card -->
                <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/60">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-outline-variant/50">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-xl">receipt_long</span>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-on-surface">Ringkasan Draf</h3>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-800">Menunggu
                            Submit</span>
                    </div>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Pemesan / Instansi:</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[180px]"
                                id="summaryName">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Produk Dipilih:</span>
                            <span class="font-semibold text-primary text-right"
                                id="summaryProduct">Korsa/PDH/PDL</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Cuttingan:</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[170px]"
                                id="summaryCutting">Lengan Pendek</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Estimasi Bahan:</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[170px]"
                                id="summaryFabric">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Warna Utama:</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[170px]"
                                id="summaryColor">-</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Jumlah Pemesanan:</span>
                            <span class="font-mono font-bold text-sm text-primary text-right" id="summaryQty">12
                                pcs</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-outline-variant/30">
                            <span class="text-secondary">Merchandise Tambahan:</span>
                            <span class="font-semibold text-on-surface text-right truncate max-w-[160px]"
                                id="summaryAddons">Tidak ada</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-secondary">Target Pakai:</span>
                            <span class="font-mono font-semibold text-on-surface text-right"
                                id="summaryDeadline">-</span>
                        </div>
                    </div>
                    <div
                        class="mt-5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/50 text-xs text-secondary space-y-1">
                        <div class="flex items-center gap-1.5 font-bold text-on-surface">
                            <span class="material-symbols-outlined text-base text-primary">price_check</span>
                            <span class="">Kalkulasi Biaya Nota Resmi</span>
                        </div>
                        <p class="text-[11px] leading-relaxed">
                            Setelah dikirim, CS Presma akan menghitung total biaya, diskon kuantiti, serta opsi ongkir
                            cargo termurah ke kota Anda.
                        </p>
                    </div>
                </div>
                <!-- JAMINAN PRESMA KONVEKSI -->

                <!-- QUICK CS CONTACT WIDGET -->
                <div
                    class="bg-white rounded-2xl p-5 border border-outline-variant/60 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined">headset_mic</span>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-on-surface block">Butuh Bantuan Konsultasi?</span>
                            <span class="text-[11px] text-secondary font-mono">+62 851-7715-4445</span>
                        </div>
                    </div>
                    <a class="px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-bold flex items-center gap-1 transition"
                        href="https://wa.me/6285177154445" target="_blank">
                        <span class="">Chat CS</span>
                        <span class="material-symbols-outlined text-sm">open_in_new</span>
                    </a>
                </div>
            </aside>
        </form>
    </main>
    <!-- Interactive Desktop Modal Confirmation (Hidden by default) -->
    <div class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
        id="successModal">
        <div
            class="w-full max-w-lg bg-surface-container-lowest rounded-2xl p-6 sm:p-8 flex flex-col items-center text-center shadow-2xl border border-outline-variant/50 relative overflow-hidden transition-all duration-300">
            <div
                class="w-16 h-16 rounded-2xl bg-green-100 text-green-700 flex items-center justify-center shadow-inner mb-4 transition-transform hover:scale-105 duration-300">
                <span class="material-symbols-outlined text-4xl">check_circle</span>
            </div>
            <div class="space-y-2 mb-5">
                <span
                    class="px-3 py-1 rounded-full bg-green-50 border border-green-200 text-green-800 text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm text-green-700">schedule</span> Menunggu Verifikasi
                    CS (1x24 Jam)
                </span>
                <h3 class="text-xl md:text-2xl font-bold text-on-surface">Formulir Berhasil Disimpan (Preview)</h3>
                <p class="text-xs text-secondary leading-relaxed max-w-md mx-auto">
                    Terima kasih telah mempercayakan seragam Anda kepada <strong class="text-on-surface">Presma
                        Konveksi</strong>. Nomor di bawah merupakan kode simulasi frontend. Data hanya tersedia di
                    browser ini hingga backend aktif.
                </p>
            </div>
            <div
                class="w-full bg-surface-container-low rounded-xl p-4 border border-outline-variant/60 text-left text-xs space-y-2.5 mb-5 shadow-sm">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                    <span class="text-secondary font-medium">Nomor Pengajuan:</span>
                    <span class="font-mono font-bold text-primary bg-primary-tint/60 px-2 py-0.5 rounded text-xs"><span
                            id="modalOrderCode">Menyiapkan kode...</span></span>
                </div>
                <div class="flex items-center justify-between gap-3 pb-2 border-b border-outline-variant/40">
                    <span class="text-secondary font-medium shrink-0">Kode Tracking:</span>
                
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="font-mono font-bold text-on-surface bg-white px-2 py-1 rounded border border-outline-variant/60 break-all">
                            <span id="modalTrackingCode">Menyiapkan kode...</span>
                        </span>
                
                        <button
                            type="button"
                            id="copyTrackingCodeBtn"
                            onclick="copyTrackingCode()"
                            class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-primary text-white hover:bg-primary-hover text-[11px] font-bold transition"
                            aria-label="Salin kode tracking">
                            <span class="material-symbols-outlined text-sm">content_copy</span>
                            <span id="copyTrackingCodeLabel"></span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                    <span class="text-secondary font-medium">Estimasi Respon CS:</span>
                    <span class="font-semibold text-green-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-green-700">verified</span> 1×24 Jam kerja
                        via WhatsApp
                    </span>
                </div>
                <div class="flex items-center justify-between pt-0.5">
                    <span class="text-secondary font-medium">Kuantitas &amp; Produk:</span>
                    <span class="font-semibold text-on-surface text-right"><strong class="text-primary font-mono"
                            id="modalQty">- pcs</strong> <span id="modalProduct">-</span></span>
                </div>
            </div>
            <div class="flex flex-col w-full gap-2.5">
                <a class="w-full h-11 rounded-xl bg-primary hover:bg-primary-hover active:scale-[0.99] text-white font-bold text-xs flex items-center justify-center gap-2 shadow-md shadow-primary/20 transition-all cursor-pointer"
                    href="https://wa.me/6285177154445?text=Halo%20Admin%20Presma%2C%20saya%20ingin%20memantau%20tracking%20pesanan%20dengan%20Kode%20Tracking%20STO-2026-ENSL"
                    id="modalWaDirectLink" target="_blank">
                    <span class="material-symbols-outlined text-base">track_changes</span>
                    <span class="">Hubungi CS via WhatsApp</span>
                </a>
                <a id="modalTrackPageLink"
                    class="w-full h-11 rounded-xl bg-white border border-primary/40 hover:bg-primary-tint text-primary font-bold text-xs flex items-center justify-center gap-2 transition"
                    href="{{ url('/preview-order/check') }}">Cek Status Pesanan di Website</a>
                <button type="button" onclick="window.print()"
                    class="w-full h-11 rounded-xl bg-white border border-outline-variant hover:border-primary hover:bg-surface text-on-surface font-semibold text-xs flex items-center justify-center gap-2 transition cursor-pointer shadow-sm">
                    <span class="material-symbols-outlined text-base text-primary">print</span>
                    <span class="">Cetak / Unduh Bukti Formulir (.PDF)</span>
                </button>
                <button type="button" onclick="closeModalAndReset()"
                    class="w-full h-9 rounded-xl text-secondary hover:text-on-surface text-xs font-semibold transition mt-1 cursor-pointer hover:underline">
                    Tutup &amp; Buat Pesanan Lain
                </button>
            </div>
        </div>
    </div>
    <!-- Footer Desktop -->
    <footer class="bg-white border-t border-outline-variant/60 py-6 mt-12 text-xs text-secondary">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="font-bold text-on-surface">Presma Konveksi</span>
                <span class="">•</span>
                <span class="">Spesialis Pembuatan Korsa, PDH, Jaket, Kaos &amp; Merchandise</span>
            </div>
            <div class="">
                Hotline Layanan CS: <a class="font-semibold text-primary hover:underline"
                    href="https://wa.me/6285177154445" target="_blank">+62 851-7715-4445</a>
            </div>
        </div>
    </footer>
    <!-- Page Interactivity Scripts -->
    <script>
        function toggleFileDeliveryField(val) {
            document.getElementById('fileUploadContainer').classList.add('hidden');
            document.getElementById('fileLinkContainer').classList.add('hidden');
            document.getElementById('fileWaContainer').classList.add('hidden');

            if (val === 'upload') {
                document.getElementById('fileUploadContainer').classList.remove('hidden');
            } else if (val === 'link') {
                document.getElementById('fileLinkContainer').classList.remove('hidden');
            } else if (val === 'whatsapp') {
                document.getElementById('fileWaContainer').classList.remove('hidden');
            }
        }

        function handleMultipleFiles(input) {
            const badge = document.getElementById('fileCountBadge');
            const text = document.getElementById('fileCountText');
            if (input.files && input.files.length > 0) {
                badge.classList.remove('hidden');
                text.textContent = input.files.length + ' file terpilih untuk diunggah';
            } else {
                badge.classList.add('hidden');
            }
        }

        function toggleOtherAddonInput(checkbox) {
            const wrapper = document.getElementById('otherAddonInputWrapper');
            if (checkbox.checked) {
                wrapper.classList.remove('hidden');
                document.getElementById('otherAddonDetail').focus();
            } else {
                wrapper.classList.add('hidden');
                document.getElementById('otherAddonDetail').value = '';
            }
            updateLiveSummary();
        }

        function handleNoAddons(noCheckbox) {
            if (noCheckbox.checked) {
                const checkboxes = document.querySelectorAll('input[name="tambahan"]');
                checkboxes.forEach(cb => {
                    if (cb !== noCheckbox) cb.checked = false;
                });
                const otherCb = document.getElementById('otherAddonCheckbox');
                otherCb.checked = false;
                document.getElementById('otherAddonInputWrapper').classList.add('hidden');
                document.getElementById('otherAddonDetail').value = '';
            }
            updateLiveSummary();
        }

        function updateLiveSummary() {
            // Name & Institution
            const name = document.getElementById('customerName').value.trim();
            const inst = document.getElementById('institutionName').value.trim();
            let displayName = name || '-';
            if (inst) displayName += ' (' + inst + ')';
            document.getElementById('summaryName').textContent = displayName;

            // Product
            const selectedProduct = document.querySelector('input[name="jenisProduk"]:checked');
            if (selectedProduct) {
                document.getElementById('summaryProduct').textContent = selectedProduct.value;
            }

            // Cuttingan
            const checkedCuttings = Array.from(document.querySelectorAll('input[name="modelCutting"]:checked')).map(cb => cb
                .value);
            document.getElementById('summaryCutting').textContent = checkedCuttings.length ? checkedCuttings.join(', ') :
                '-';

            // Fabric & Color
            const fabric = document.getElementById('fabricChoice').value;
            document.getElementById('summaryFabric').textContent = fabric ? fabric.split('(')[0] : '-';

            const color = document.getElementById('colorChoice').value.trim();
            document.getElementById('summaryColor').textContent = color || '-';

            // Qty
            const qty = document.getElementById('totalQty').value;
            document.getElementById('summaryQty').textContent = qty ? qty + ' pcs' : '- pcs';

            // Addons
            const addons = Array.from(document.querySelectorAll('input[name="tambahan"]:checked')).map(cb => cb.value);
            const otherCb = document.getElementById('otherAddonCheckbox');
            const otherDetail = document.getElementById('otherAddonDetail').value.trim();
            if (otherCb && otherCb.checked && otherDetail) {
                addons.push(otherDetail);
            }
            document.getElementById('summaryAddons').textContent = addons.length ? addons.join(', ') : 'Tidak ada';

            // Deadline
            const dl = document.getElementById('targetDeadline').value;
            document.getElementById('summaryDeadline').textContent = dl || '-';
        }

        function submitOrder() {
            const name = document.getElementById('customerName').value.trim();
            const wa = document.getElementById('whatsappNumber').value.trim();
            const product = document.querySelector('input[name="jenisProduk"]:checked')?.value || 'Pesanan Konveksi';
            const qty = document.getElementById('totalQty').value || '12';
            const fabric = document.getElementById('fabricChoice').value || 'Pilihan Bahan';

            // Set modal elements
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalProduct').textContent = product;
            document.getElementById('modalQty').textContent = qty + ' pcs';
            document.getElementById('modalWa').textContent = '+62 ' + wa;

            // WhatsApp direct text prefill to +62 851-7715-4445
            const textMsg = encodeURIComponent(
                `Halo Admin Presma Konveksi, saya telah mengisi Formulir Pemesanan Resmi di website:\n\n` +
                `• Nama: ${name}\n` +
                `• Kontak: +62 ${wa}\n` +
                `• Produk: ${product}\n` +
                `• Bahan: ${fabric}\n` +
                `• Kuantiti: ${qty} pcs\n\n` +
                `Mohon dicek dan dihitung estimasi nota penawarannya. Terima kasih!`
            );
            document.getElementById('modalWaDirectLink').href = `https://wa.me/6285177154445?text=${textMsg}`;

            // Show modal
            document.getElementById('successModal').classList.remove('hidden');
        }

        function closeModalAndReset() {
            document.getElementById('successModal').classList.add('hidden');
            document.getElementById('publicOrderForm').reset();
            goToStep(1, true);
            updateLiveSummary();
        }

        // Init summary display
        window.addEventListener('DOMContentLoaded', () => {
            recalcSizeQuantities();
            updateLiveSummary();
            goToStep(1, true);
        });
    </script>
    <script>
        let currentWizardStep = 1;

        // Validasi berdasarkan panel saat ini, termasuk input yang tersembunyi pada step lain.
        function validateWizardStep(step) {
            const panel = document.getElementById('stepPanel-' + step);
            if (!panel) return false;
            // Control native constraint validation explicitly, karena panel lain disembunyikan.
            const required = [...panel.querySelectorAll('input[required], select[required], textarea[required]')];
            for (const el of required) {
                if (el.disabled || el.type === 'hidden') continue;
                if (!el.checkValidity() || (typeof el.value === 'string' && !el.value.trim())) {
                    el.focus();
                    el.reportValidity();
                    if (el.validity.valid) alert('Lengkapi semua kolom wajib terlebih dahulu.');
                    return false;
                }
            }
            if (step === 1 && !panel.querySelector('input[name="jenisProduk"]:checked')) {
                alert('Pilih jenis produk.');
                return false;
            }
            if (step === 1 && !panel.querySelector('input[name="modelCutting"]:checked') && !document.getElementById(
                    'customModelCutting')?.value.trim()) {
                alert('Pilih minimal satu model/cuttingan atau isi model kustom.');
                return false;
            }
            if (step === 3) {
                recalcSizeQuantities();
                const total = Number(document.getElementById('totalQty')?.value || 0);
            }
            return true;
        }

        function goToStep(step, internal = false) {
            if (![1, 2, 3].includes(step)) return;
            if (!internal) {
                // Maju hanya satu step dan sesudah validasi; mundur hanya satu step.
                if (step !== currentWizardStep + 1 && step !== currentWizardStep - 1) return;
                if (step > currentWizardStep && !validateWizardStep(currentWizardStep)) return;
            }

            currentWizardStep = step;

            // Hide all step panels
            for (let i = 1; i <= 3; i++) {
                const panel = document.getElementById('stepPanel-' + i);
                const circle = document.getElementById('stepCircle-' + i);
                const title = document.getElementById('stepTitle-' + i);
                if (panel) {
                    if (i === step) {
                        panel.classList.remove('hidden');
                        panel.classList.add('block');
                    } else {
                        panel.classList.add('hidden');
                        panel.classList.remove('block');
                    }
                }
                if (circle && title) {
                    if (i < step) {
                        circle.className =
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-green-600 text-white';
                        circle.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                        title.className = 'block text-xs font-semibold text-on-surface leading-tight';
                    } else if (i === step) {
                        circle.className =
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-primary text-white ring-4 ring-primary-tint/60';
                        circle.textContent = i;
                        title.className = 'block text-xs font-bold text-primary leading-tight';
                    } else {
                        circle.className =
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-sm transition-all bg-surface-container-high text-secondary border border-outline-variant';
                        circle.textContent = i;
                        title.className = 'block text-xs font-semibold text-secondary leading-tight';
                    }
                }
            }

            // Progress bar fill
            const progressFill = document.getElementById('stepProgressFill');
            if (progressFill) {
                if (step === 1) progressFill.style.width = '0%';
                else if (step === 2) progressFill.style.width = '50%';
                else if (step === 3) progressFill.style.width = '100%';
            }

            // Scroll smoothly to top of form
            const form = document.getElementById('publicOrderForm');
            if (form) {
                form.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        function recalcSizeQuantities() {
            const sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL', 'TANPA_UKURAN'];
            let total = 0;
            sizes.forEach(size => {
                const input = document.getElementById('qty-' + size);
                const count = Math.max(0, parseInt(input?.value || '0', 10) || 0);
                if (input && String(count) !== input.value) input.value = count;
                total += count;
                const label = size === 'TANPA_UKURAN' ? 'Custom' : (size === '2XL' ? 'XXL' : size);
                const oldCount = document.getElementById('count-' + label);
                if (oldCount) oldCount.textContent = count;
            });
            const totalInput = document.getElementById('totalQty');
            if (totalInput) totalInput.value = total;
            updateLiveSummary();
        }

        function switchInputMode(mode) {
            const viewTable = document.getElementById('viewTableMode');
            const viewExcel = document.getElementById('viewExcelMode');
            const btnTable = document.getElementById('btnModeTable');
            const btnExcel = document.getElementById('btnModeExcel');
            if (!viewTable || !viewExcel) return;
            if (mode === 'table') {
                viewTable.classList.remove('hidden');
                viewTable.classList.add('block');
                viewExcel.classList.add('hidden');
                btnTable.className =
                    'px-3 py-1.5 rounded-lg bg-white text-primary shadow-sm flex items-center gap-1.5 transition font-semibold';
                btnExcel.className =
                    'px-3 py-1.5 rounded-lg text-secondary hover:text-on-surface flex items-center gap-1.5 transition font-semibold';
            } else {
                viewExcel.classList.remove('hidden');
                viewExcel.classList.add('block');
                viewTable.classList.add('hidden');
                btnExcel.className =
                    'px-3 py-1.5 rounded-lg bg-white text-primary shadow-sm flex items-center gap-1.5 transition font-semibold';
                btnTable.className =
                    'px-3 py-1.5 rounded-lg text-secondary hover:text-on-surface flex items-center gap-1.5 transition font-semibold';
            }
        }

        function addTableRow() {
            const tbody = document.getElementById('membersTableBody');
            if (!tbody) return;
            const newIndex = tbody.children.length + 1;
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-surface-container-low transition';
            tr.innerHTML = `
      <td class="p-3 text-center font-mono text-secondary font-semibold row-number">${newIndex}</td>
      <td class="p-2.5">
        <input type="text" placeholder="Nama anggota" class="w-full h-9 px-3 rounded-lg bg-surface border border-outline-variant text-xs focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary member-name" oninput="updateLiveSummary()">
      </td>
      <td class="p-2.5">
        <select class="w-full h-9 px-2 rounded-lg bg-surface border border-outline-variant text-xs focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary font-mono font-semibold member-size" onchange="recalcTableStats()">
          <option value="XS">XS</option>
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L" selected>L</option>
          <option value="XL">XL</option>
          <option value="2XL">XXL</option>
          <option value="3XL">3XL</option>
          <option value="TANPA_UKURAN">Custom/Khusus</option>
        </select>
      </td>
      <td class="p-2.5">
        <select class="w-full h-9 px-2 rounded-lg bg-surface border border-outline-variant text-xs focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary member-cut">
          <option value="Lengan Pendek" selected>Lengan Pendek</option>
          <option value="Lengan Panjang (Kancing)">Lengan Panjang (Kancing)</option>
          <option value="Lengan Panjang (Rib Karet)">Lengan Panjang (Rib Karet)</option>
          <option value="Tunik (Wanita)">Tunik (Wanita)</option>
          <option value="Pola Khusus">Pola Khusus</option>
        </select>
      </td>
      <td class="p-2.5">
        <input type="text" placeholder="Catatan variasi..." class="w-full h-9 px-3 rounded-lg bg-surface border border-outline-variant text-xs focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary member-note">
      </td>
      <td class="p-2.5 text-center">
        <button type="button" onclick="deleteTableRow(this)" title="Hapus Baris" class="w-8 h-8 rounded-lg text-secondary hover:text-error hover:bg-red-50 flex items-center justify-center transition">
          <span class="material-symbols-outlined text-lg">delete</span>
        </button>
      </td>
    `;
            tbody.appendChild(tr);
            recalcTableStats();
        }

        function deleteTableRow(btn) {
            const row = btn.closest('tr');
            const tbody = document.getElementById('membersTableBody');
            if (tbody && tbody.children.length > 1) {
                row.remove();
                const rows = tbody.querySelectorAll('tr');
                rows.forEach((r, idx) => {
                    const numCell = r.querySelector('.row-number');
                    if (numCell) numCell.textContent = idx + 1;
                });
                recalcTableStats();
            }
        }

        function recalcTableStats() {
            const rows = document.querySelectorAll('#membersTableBody tr');
            const countSpan = document.getElementById('tableRowCount');
            const totalInput = document.getElementById('totalQty');
            if (countSpan) countSpan.textContent = rows.length;
            if (totalInput) totalInput.value = rows.length;

            const sizeCounts = {
                S: 0,
                M: 0,
                L: 0,
                XL: 0,
                XXL: 0,
                '3XL': 0,
                Custom: 0
            };
            rows.forEach(r => {
                const sizeSelect = r.querySelector('.member-size');
                if (sizeSelect && sizeCounts.hasOwnProperty(sizeSelect.value)) {
                    sizeCounts[sizeSelect.value]++;
                }
            });
            for (const [sz, val] of Object.entries(sizeCounts)) {
                const el = document.getElementById('count-' + sz);
                if (el) el.textContent = val;
            }
            updateLiveSummary();
        }
    </script>










    <script>
        // PREVIEW SAJA: identitas transaksi resmi WAJIB diterbitkan backend secara atomik.
        (function() {
            const excel = document.getElementById('excelFileInput');
            if (excel) excel.addEventListener('change', function() {
                const f = this.files?.[0];
                const badge = document.getElementById('excelSuccessBadge');
                const label = document.getElementById('excelSuccessText');
                if (f && f.size > 10 * 1024 * 1024) {
                    alert('File maksimal 10 MB');
                    this.value = '';
                    return;
                }
                if (label) label.textContent = f ? 'Berkas dipilih: ' + f.name + ' (belum diunggah ke server)' :
                    '';
                if (badge) badge.classList.toggle('hidden', !f);
            });
            window.handleExcelUpload = function(input) {
                const f = input.files?.[0];
                const badge = document.getElementById('excelSuccessBadge');
                const label = document.getElementById('excelSuccessText');
                if (f && f.size > 10 * 1024 * 1024) {
                    alert('Ukuran maksimal 10 MB');
                    input.value = '';
                    return;
                }
                if (label) label.textContent = f ? 'Berkas dipilih: ' + f.name + ' (belum diunggah ke server)' : '';
                if (badge) badge.classList.toggle('hidden', !f);
            };
            const safe = v => String(v || '').trim();
            const get = id => safe(document.getElementById(id)?.value);
            const token = (length = 10) => {
                const b = new Uint8Array(length);
                crypto.getRandomValues(b);
                return Array.from(b, x => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' [x % 32]).join('');
            };
            window.submitOrder = function() {
                const form = document.getElementById('publicOrderForm');
                for (let step = 1; step <= 3; step++) {
                    goToStep(step, true);
                    if (!validateWizardStep(step)) return;
                }
                recalcSizeQuantities();
                const quantity = Number(get('totalQty'));
                const now = new Date();
                const year = now.getFullYear();
                const code = `DEMO-ORD-${year}-${token(8)}`;
                const track = `DEMO-TRK-${token(12)}`;
                const product = document.querySelector('input[name="jenisProduk"]:checked')?.value || '-';
                const record = {
                    code,
                    tracking: track,
                    status: 'Menunggu Verifikasi CS',
                    name: get('customerName'),
                    product,
                    qty: quantity,
                    deadline: get('targetDeadline'),
                    createdAt: now.toISOString()
                };
                try {
                    const all = JSON.parse(localStorage.getItem('presma_public_preview_orders') || '[]');
                    all.push(record);
                    localStorage.setItem('presma_public_preview_orders', JSON.stringify(all));
                } catch (err) {
                    alert('Penyimpanan browser tidak tersedia. Kode tidak dapat dibuat untuk dicek kembali.');
                    return;
                }
                document.getElementById('modalOrderCode').textContent = code;
                document.getElementById('modalTrackingCode').textContent = track;
                document.getElementById('modalQty').textContent = quantity + ' pcs';
                document.getElementById('modalProduct').textContent = product;
                document.getElementById('modalTrackPageLink').href = "{{ url('/preview-order/check') }}?tracking=" +
                    encodeURIComponent(track);
                const msg =
                    `Halo CS Presma, saya telah mengisi formulir preview. Kode pengajuan: ${code}, kode tracking: ${track}, produk: ${product}, jumlah: ${quantity} pcs. Mohon konfirmasi pencatatan pesanan resmi.`;
                document.getElementById('modalWaDirectLink').href = 'https://wa.me/6285177154445?text=' +
                    encodeURIComponent(msg);
                document.getElementById('successModal').classList.remove('hidden');
            };
        })();
    </script>
</body>

</html>
