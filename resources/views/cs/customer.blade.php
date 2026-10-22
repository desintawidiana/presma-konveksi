@extends('layout.cs')

@section('title', 'Customer | Presma Operations')

@section('content')
    <main class="w-full pt-20 px-space-xl py-space-lg flex-1 bg-surface cs-customer-page">
        <div class="flex flex-col w-full gap-space-lg">
            <!-- Header Workspace -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                <div class="flex flex-col">
                    <div class="flex items-center gap-space-xs text-on-surface-variant font-body-sm text-body-sm mb-1">
                    </div>
                    <div class="flex items-center gap-3">
                        <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight">Direktori
                            &amp; Profil Pelanggan</h1>
                    </div>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Database kontak pemesan, instansi,
                        dan riwayat pesanan garmen konveksi (non-login account model).</p>
                </div>
                <div class="flex items-center gap-space-sm self-start md:self-auto">
                    <button
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-surface-container-lowest text-on-surface font-title-sm text-title-sm shadow-sm hover:bg-surface-container transition-colors"
                        id="customerExport">
                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant">download</span>
                        <span class="">Export Kontak (CSV)</span>
                    </button>
                    <button
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#830909] text-white font-title-sm text-title-sm font-medium shadow-sm hover:bg-[#6b0707] transition-all cursor-pointer"
                        id="customerOpenModal" type="button"><span
                            class="material-symbols-outlined text-[18px]">person_add</span><span class="">Entri Kontak
                            Baru</span></button>
                </div>
            </div>
            <!-- KPI Summary Banner -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-space-md">
                <!-- KPI 1 -->
                <div
                    class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between relative overflow-hidden w-full">
                    <div class="flex items-center justify-between">
                        <span
                            class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Total
                            Pelanggan</span>
                        <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">contacts</span>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="flex items-baseline gap-2">
                            <span class="font-display-lg text-display-lg font-bold text-on-surface">142</span>
                            <span class="font-label-md text-label-md text-on-surface-variant font-medium">Kontak
                                Terverifikasi</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                    </div>
                </div>
                <!-- KPI 2 -->
                <div
                    class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between relative overflow-hidden w-full">
                    <div class="flex items-center justify-between">
                        <span
                            class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Pelanggan
                            Aktif Berjalan</span>
                        <div
                            class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined text-[18px]">factory</span>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="flex items-baseline gap-2">
                            <span class="font-display-lg text-display-lg font-bold text-on-surface">28</span>
                            <span class="font-label-md text-label-md text-on-surface-variant font-medium">Instansi
                                SPK<br /></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                    </div>
                </div>
                <!-- KPI 3 -->
                <div
                    class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between relative overflow-hidden w-full">
                    <div class="flex items-center justify-between">
                        <span
                            class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Repeat
                            Order</span>
                        <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[18px]">sync_alt</span>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="flex items-baseline gap-2">
                            <span class="font-display-lg text-display-lg font-bold text-on-surface">64%</span>
                            <span
                                class="font-label-md text-label-md text-emerald-700 font-semibold inline-flex items-center gap-0.5">
                                <span class="material-symbols-outlined text-[14px]">arrow_upward</span>+4.2%
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                    </div>
                </div>
                <!-- KPI 4 -->
                <div
                    class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col justify-between relative overflow-hidden w-full">
                    <div class="flex items-center justify-between">
                        <span
                            class="font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant font-semibold">Rata-rata
                            Volume</span>
                        <div
                            class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-primary-container">
                            <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="flex items-baseline gap-2">
                            <span class="font-display-lg text-display-lg font-bold text-on-surface">185</span>
                            <span class="font-label-md text-label-md text-on-surface-variant font-medium">Pcs / Batch</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                    </div>
                </div>
            </div>
            <!-- Main 2-Column Split: Customer Table & Detail Inspector -->
            <div class="gap-space-lg items-start w-full">
                <!-- Left Column: Customer Directory Table (7 Cols) -->
                <div class="flex flex-col gap-space-md w-full">
                    <div
                        class="bg-surface-container-lowest rounded-xl border border-surface-variant/80 shadow-xs overflow-hidden flex flex-col">
                        <!-- Filter and Search Header -->
                        <div class="p-4 bg-surface-container-lowest border-b border-surface-variant/60 flex flex-col gap-3">
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2.5">
                                <!-- Search bar -->
                                <div class="relative flex-1">
                                    <span
                                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[18px]">search</span>
                                    <input aria-label="Cari pelanggan"
                                        class="w-full h-9 pl-9 pr-3 rounded-lg bg-surface-container-low text-on-surface placeholder:text-on-surface-variant/70 font-body-sm text-[13px] border border-transparent focus:border-outline-variant focus:bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-primary-container/20 transition-all"
                                        id="customerSearch" placeholder="Cari nama kontak, instansi, atau WhatsApp..."
                                        type="text" value="" />
                                </div>
                                <!-- Quick Category Pill / Dropdown -->
                                <div class="flex items-center gap-2 shrink-0">
                                    <select
                                        class="h-9 px-3 rounded-lg bg-surface-container-low font-body-sm text-[12px] font-medium text-on-surface border border-transparent focus:border-outline-variant focus:outline-none cursor-pointer"
                                        id="customerCategory">
                                        <option selected="">Semua Kategori</option>
                                        <option>Kampus &amp; Organisasi</option>
                                        <option>Korporat &amp; Industri</option>
                                        <option>Komunitas Kreatif</option>
                                    </select>
                                    <button
                                        class="h-9 px-2.5 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-on-surface hover:bg-surface-container flex items-center gap-1 font-body-sm text-[12px] font-medium border border-transparent transition-colors"
                                        id="customerSort" title="Urutkan Data">
                                        <span class="material-symbols-outlined text-[17px]">swap_vert</span>
                                        <span class="hidden sm:inline">Sort</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Secondary Filters Row -->
                            <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                <span
                                    class="font-label-sm text-[11px] text-on-surface-variant uppercase font-semibold mr-1">Filter
                                    Cepat:</span>
                                <button
                                    class="px-2.5 py-1 rounded-full bg-primary-container text-white font-label-sm text-[11px] font-semibold transition-all shadow-xs"
                                    data-filter="all">
                                    Semua (142)
                                </button>
                                <button
                                    class="px-2.5 py-1 rounded-full bg-surface-container-low text-on-surface-variant hover:text-on-surface hover:bg-surface-container font-label-sm text-[11px] font-medium transition-all"
                                    data-filter="repeat">
                                    Repeat Order &gt; 1x (91)
                                </button>
                                <button
                                    class="px-2.5 py-1 rounded-full bg-surface-container-low text-on-surface-variant hover:text-on-surface hover:bg-surface-container font-label-sm text-[11px] font-medium transition-all"
                                    data-filter="active">
                                    Ada SPK Aktif (28)
                                </button>
                                <button
                                    class="px-2.5 py-1 rounded-full bg-surface-container-low text-on-surface-variant hover:text-on-surface hover:bg-surface-container font-label-sm text-[11px] font-medium transition-all"
                                    data-filter="diy">
                                    D.I. Yogyakarta (64)
                                </button>
                            </div>
                        </div>
                        <!-- Directory Table -->
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse" id="customerDirectoryTable">
                                <thead>
                                    <tr
                                        class="bg-surface-container-low text-on-surface-variant font-label-sm text-[11px] uppercase tracking-wider border-b border-surface-variant/60">
                                        <th class="py-3 px-4 font-semibold w-24">ID Pelanggan</th>
                                        <th class="py-3 px-4 font-semibold">Nama Pelanggan &amp; Instansi</th>
                                        <th class="py-3 px-4 font-semibold">Kontak WhatsApp</th>
                                        <th class="py-3 px-4 font-semibold">Kota</th>
                                        <th class="py-3 px-4 font-semibold">Total Order</th>
                                        <th class="py-3 px-4 font-semibold">Order Terakhir</th>
                                        <th class="py-3 px-4 text-right font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-surface-container">
                                    <!-- Row 1: Farhan Saputra (Selected) -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row hover:bg-primary-fixed/40 transition-colors cursor-pointer group bg-primary-fixed/30"
                                        data-index="0" role="button" tabindex="0">
                                        <td class="py-3.5 px-4 font-mono text-[12px] font-semibold text-primary"><span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0142</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-primary-container text-white font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0 shadow-xs">
                                                    FS
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] font-bold truncate text-primary">Farhan
                                                            Saputra</span>
                                                        <span
                                                            class="status-pill inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">BEM
                                                        FEB Universitas Indonesia</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 hover:bg-emerald-100 transition-colors font-mono font-medium text-[12px]"
                                                href="https://wa.me/6281244918821" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0812-4491-8821</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Kota Depok
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container-high font-label-sm text-[11px] font-bold text-on-surface">3x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-semibold text-primary font-mono">ORD-2024-0330</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">24 Okt
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary-container text-white font-title-sm text-[12px] font-bold shadow-xs hover:bg-primary transition-all cursor-pointer"
                                                data-open-customer="0" type="button"><span
                                                    class="material-symbols-outlined text-[15px]">visibility</span><span
                                                    class="">Lihat Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="0"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Row 2: Rizky Ananda -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row transition-colors cursor-pointer group hover:bg-surface-container"
                                        data-index="1" role="button" tabindex="0">
                                        <td
                                            class="py-3.5 px-4 font-mono text-[12px] font-semibold text-on-surface-variant">
                                            <span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0141</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0">
                                                    RA
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] font-semibold truncate text-on-surface">Rizky
                                                            Ananda</span>
                                                        <span
                                                            class="status-pill inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium hidden">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">Himpunan
                                                        Mahasiswa Mesin UGM</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-mono text-[12px]"
                                                href="https://wa.me/6287739128841" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0877-3912-8841</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Sleman,
                                            DIY</td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-[11px] font-semibold text-on-surface-variant">2x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-medium text-on-surface font-mono">ORD-2024-0288</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">08 Okt
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-secondary-fixed hover:text-primary-container border border-surface-variant font-title-sm text-[12px] font-semibold transition-all cursor-pointer"
                                                data-open-customer="1" type="button"><span
                                                    class="material-symbols-outlined text-[15px] text-on-surface-variant">person_search</span><span
                                                    class="">Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="1"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Row 3: Budi Santoso -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row transition-colors cursor-pointer group hover:bg-surface-container"
                                        data-index="2" role="button" tabindex="0">
                                        <td
                                            class="py-3.5 px-4 font-mono text-[12px] font-semibold text-on-surface-variant">
                                            <span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0128</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0">
                                                    BS
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] font-semibold truncate text-on-surface">Budi
                                                            Santoso</span>
                                                        <span
                                                            class="status-pill inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium hidden">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">PT
                                                        Sinar Maju Perkasa</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-mono text-[12px]"
                                                href="https://wa.me/6281399812401" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0813-9981-2401</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Semarang
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-[11px] font-semibold text-on-surface-variant">5x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-medium text-on-surface font-mono">ORD-2024-0250</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">29 Sep
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-secondary-fixed hover:text-primary-container border border-surface-variant font-title-sm text-[12px] font-semibold transition-all cursor-pointer"
                                                data-open-customer="2" type="button"><span
                                                    class="material-symbols-outlined text-[15px] text-on-surface-variant">person_search</span><span
                                                    class="">Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="2"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Row 4: Lutfi Hakim -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row hover:bg-surface-container transition-colors cursor-pointer group"
                                        data-index="3" role="button" tabindex="0">
                                        <td
                                            class="py-3.5 px-4 font-mono text-[12px] font-semibold text-on-surface-variant">
                                            <span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0115</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0">
                                                    LH
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] text-on-surface font-semibold truncate">Lutfi
                                                            Hakim</span>
                                                        <span
                                                            class="status-pill hidden inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">DEMA
                                                        UIN Sunan Kalijaga</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-mono text-[12px]"
                                                href="https://wa.me/6285811094321" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0858-1109-4321</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Yogyakarta
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-[11px] font-semibold text-on-surface-variant">1x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-medium text-on-surface font-mono">ORD-2024-0312</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">19 Okt
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-secondary-fixed hover:text-primary-container border border-surface-variant font-title-sm text-[12px] font-semibold transition-all cursor-pointer"
                                                data-open-customer="3" type="button"><span
                                                    class="material-symbols-outlined text-[15px] text-on-surface-variant">person_search</span><span
                                                    class="">Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="3"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Row 5: Nadia Pratiwi -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row hover:bg-surface-container transition-colors cursor-pointer group"
                                        data-index="4" role="button" tabindex="0">
                                        <td
                                            class="py-3.5 px-4 font-mono text-[12px] font-semibold text-on-surface-variant">
                                            <span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0098</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0">
                                                    NP
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] text-on-surface font-semibold truncate">Nadia
                                                            Pratiwi</span>
                                                        <span
                                                            class="status-pill hidden inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">Komunitas
                                                        Sinema Jogja</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-mono text-[12px]"
                                                href="https://wa.me/6281903445892" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0819-0344-5892</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Bantul,
                                            DIY</td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-[11px] font-semibold text-on-surface-variant">2x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-medium text-on-surface font-mono">ORD-2024-0199</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">14 Agu
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-secondary-fixed hover:text-primary-container border border-surface-variant font-title-sm text-[12px] font-semibold transition-all cursor-pointer"
                                                data-open-customer="4" type="button"><span
                                                    class="material-symbols-outlined text-[15px] text-on-surface-variant">person_search</span><span
                                                    class="">Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="4"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                    <!-- Row 6: Tika Rahayu -->
                                    <tr aria-label="Lihat detail pelanggan"
                                        class="customer-row hover:bg-surface-container transition-colors cursor-pointer group"
                                        data-index="5" role="button" tabindex="0">
                                        <td
                                            class="py-3.5 px-4 font-mono text-[12px] font-semibold text-on-surface-variant">
                                            <span
                                                class="font-mono font-medium text-[12px] text-on-surface-variant">CUST-0084</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-9 h-9 rounded-lg bg-surface-container-high text-on-surface-variant font-title-sm text-[13px] font-bold flex items-center justify-center shrink-0">
                                                    TR
                                                </div>
                                                <div class="flex flex-col min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span
                                                            class="font-title-sm text-[13px] text-on-surface font-semibold truncate">Tika
                                                            Rahayu</span>
                                                        <span
                                                            class="status-pill hidden inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-primary text-white font-medium">Terpilih</span>
                                                    </div>
                                                    <span
                                                        class="font-body-sm text-[12px] text-on-surface-variant truncate">Himpunan
                                                        Biologi UNISA</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 font-data-tabular text-[12px]">
                                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-surface-container text-on-surface hover:bg-surface-container-high transition-colors font-mono text-[12px]"
                                                href="https://wa.me/6282245671190" rel="noopener noreferrer"
                                                target="_blank" title="Kirim Pesan WhatsApp">
                                                <span
                                                    class="material-symbols-outlined text-[14px] text-emerald-700">chat</span>
                                                <span class="">0822-4567-1190</span>
                                            </a>
                                        </td>
                                        <td class="py-3.5 px-4 font-body-sm text-[12px] text-on-surface-variant">Sleman,
                                            DIY</td>
                                        <td class="py-3.5 px-4">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full bg-surface-container font-label-sm text-[11px] font-semibold text-on-surface-variant">1x
                                                Order</span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-label-sm text-[11px] font-medium text-on-surface font-mono">ORD-2024-0322</span>
                                                <span class="font-body-sm text-[11px] text-on-surface-variant">21 Okt
                                                    2024</span>
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <button
                                                class="action-btn inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container-lowest text-on-surface hover:bg-secondary-fixed hover:text-primary-container border border-surface-variant font-title-sm text-[12px] font-semibold transition-all cursor-pointer"
                                                data-open-customer="5" type="button"><span
                                                    class="material-symbols-outlined text-[15px] text-on-surface-variant">person_search</span><span
                                                    class="">Detail</span></button> <button
                                                class="cs-customer-edit-row" type="button" data-edit-customer="5"><span
                                                    class="material-symbols-outlined text-[15px]">edit</span> Edit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Table Footer / Pagination -->
                        <div
                            class="p-3.5 bg-surface-container-low border-t border-surface-variant/60 text-on-surface-variant text-[12px]">
                            Menampilkan 6 kontak contoh. Pencarian dan filter bekerja pada data pratinjau.</div>
                    </div>
                </div>
                <!-- Right Column: Customer Profile & Order History Detail Card (5 Cols) -->
                <div aria-labelledby="customerDrawerTitle" aria-modal="true" class="cs-customer-overlay hidden"
                    id="customer-detail-drawer" role="dialog">
                    <div class="cs-customer-drawer bg-surface-container-lowest">
                        <div class="cs-customer-drawer-top bg-surface-container-low">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-primary-container text-white font-bold flex items-center justify-center"
                                    id="detailInitials">FS</div>
                                <div class="min-w-0">
                                    <h2 class="text-[16px] font-bold text-on-surface" id="customerDrawerTitle">Profil
                                        Pelanggan</h2>
                                    <p class="text-[12px] text-on-surface-variant truncate" id="detailOrganization"></p>
                                </div>
                            </div>
                            <button aria-label="Tutup detail pelanggan" class="p-2 rounded-lg hover:bg-surface-container"
                                data-close-drawer="" type="button"><span
                                    class="material-symbols-outlined">close</span></button>
                        </div>
                        <div class="cs-customer-drawer-body">
                            <span
                                class="inline-flex w-fit rounded-full px-3 py-1 bg-[#F7E7E7] text-[#830909] text-[11px] font-semibold"
                                id="detailBadge"></span>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="cs-customer-detail-card"><span>Jumlah Order</span><strong
                                        id="detailCount"></strong></div>
                                <div class="cs-customer-detail-card"><span>Nilai Transaksi</span><strong
                                        id="detailValue"></strong></div>
                            </div>
                            <div class="cs-customer-detail-card">
                                <h3 class="font-semibold mb-3">Informasi Kontak &amp; Pengiriman</h3>
                                <div class="cs-customer-detail-line"><span>Nomor WhatsApp</span><strong
                                        id="detailPhone"></strong></div>
                                <div class="cs-customer-detail-line"><span>Email</span><strong id="detailEmail"></strong>
                                </div>
                                <div class="cs-customer-detail-line"><span>Alamat</span><strong
                                        id="detailAddress"></strong></div><a class="cs-customer-wa-link" href="#"
                                    id="detailWa" rel="noopener noreferrer" target="_blank"><span
                                        class="material-symbols-outlined text-[16px]">chat</span> Hubungi via WhatsApp</a>
                            </div>
                            <section class="cs-customer-detail-card">
                                <h3 class="font-semibold mb-3">Riwayat Pesanan</h3>
                                <div class="flex flex-col gap-2" id="detailOrders"></div>
                            </section>
                            <section class="cs-customer-detail-card">
                                <h3 class="font-semibold mb-2">Catatan CS</h3>
                                <p class="text-[12px] text-on-surface-variant leading-relaxed" id="detailNote"></p>
                            </section>
                        </div>
                        <div class="cs-customer-drawer-bottom bg-surface-container-low"><button id="customerEditInDrawer"
                                type="button" class="cs-customer-edit-primary"><span
                                    class="material-symbols-outlined text-[17px]">edit</span> Edit Kontak</button><button
                                class="px-4 py-2 rounded-lg border border-[#D9DADB] bg-white font-semibold"
                                data-close-drawer="" type="button">Tutup</button></div>
                    </div>
                </div>
                <div id="modal-entri-kontak" class="cs-customer-edit-overlay hidden" role="dialog" aria-modal="true"
                    aria-labelledby="modal-entri-kontak-title">
                    <div class="cs-customer-edit-panel">
                        <div class="cs-customer-edit-top">
                            <div>
                                <h2 id="modal-entri-kontak-title">Tambah / Entri Kontak Baru</h2>
                                <p>Data pratinjau. Perubahan belum tersimpan ke database.</p>
                            </div>
                            <button type="button" data-close-modal="true" aria-label="Tutup"><span
                                    class="material-symbols-outlined">close</span></button>
                        </div>
                        <form id="customerCreateForm" class="cs-customer-edit-form">
                            <div class="cs-customer-edit-cols"><label for="customerCreateForm-name">Nama Lengkap Pelanggan
                                    *<input type="text" name="name" id="customerCreateForm-name" required
                                        maxlength="150" placeholder="Nama Lengkap Pelanggan" /></label><label
                                    for="customerCreateForm-phone">Nomor WhatsApp / HP *<input type="tel"
                                        name="phone" id="customerCreateForm-phone" required maxlength="150"
                                        placeholder="Nomor WhatsApp / HP" /></label></div>
                            <div class="cs-customer-edit-cols"><label for="customerCreateForm-category">Kategori
                                    Pelanggan<select name="category" id="customerCreateForm-category">
                                        <option value="Kampus & Organisasi">Kampus & Organisasi</option>
                                        <option value="Korporat & Industri">Korporat & Industri</option>
                                        <option value="Komunitas Kreatif">Komunitas Kreatif</option>
                                        <option value="Sekolah / OSIS">Sekolah / OSIS</option>
                                        <option value="Lainnya / Personal">Lainnya / Personal</option>
                                    </select></label><label for="customerCreateForm-org">Nama Instansi / Perusahaan /
                                    Kampus<input type="text" name="org" id="customerCreateForm-org"
                                        maxlength="150" placeholder="Nama Instansi / Perusahaan / Kampus" /></label></div>
                            <div class="cs-customer-edit-cols"><label for="customerCreateForm-city">Kota / Domisili<input
                                        type="text" name="city" id="customerCreateForm-city" maxlength="150"
                                        placeholder="Kota / Domisili" /></label><label
                                    for="customerCreateForm-email">Email Pelanggan<input type="email" name="email"
                                        id="customerCreateForm-email" maxlength="150"
                                        placeholder="Email Pelanggan" /></label></div>
                            <label for="customerCreateForm-role">Posisi / Jabatan PIC<input type="text" name="role"
                                    id="customerCreateForm-role" maxlength="150"
                                    placeholder="Posisi / Jabatan PIC" /></label><label
                                for="customerCreateForm-address">Alamat Lengkap & Pengiriman
                                <textarea name="address" id="customerCreateForm-address" rows="3" maxlength="1000"></textarea>
                            </label><label for="customerCreateForm-note">Catatan Tambahan PIC / Preferensi Order
                                <textarea name="note" id="customerCreateForm-note" rows="3" maxlength="1000"></textarea>
                            </label>
                            <p class="cs-customer-form-note">ID pelanggan dikelola otomatis. Jumlah dan riwayat order tidak
                                bisa diubah melalui formulir kontak.</p>
                            <div class="cs-customer-edit-actions">
                                <button type="button" data-close-modal="true"
                                    class="cs-customer-edit-cancel">Batal</button>
                                <button type="submit" class="cs-customer-edit-primary"><span
                                        class="material-symbols-outlined text-[17px]">save</span> Tambah Kontak</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="customer-edit-modal" class="cs-customer-edit-overlay hidden" role="dialog" aria-modal="true"
                    aria-labelledby="customer-edit-modal-title">
                    <div class="cs-customer-edit-panel">
                        <div class="cs-customer-edit-top">
                            <div>
                                <h2 id="customer-edit-modal-title">Edit Data Pelanggan</h2>
                                <p>Data pratinjau. Perubahan belum tersimpan ke database.</p>
                            </div>
                            <button type="button" data-close-edit aria-label="Tutup"><span
                                    class="material-symbols-outlined">close</span></button>
                        </div>
                        <form id="customerEditForm" class="cs-customer-edit-form">
                            <div class="cs-customer-edit-cols"><label for="customerEditForm-name">Nama Lengkap Pelanggan
                                    *<input type="text" name="name" id="customerEditForm-name" required
                                        maxlength="150" placeholder="Nama Lengkap Pelanggan" /></label><label
                                    for="customerEditForm-phone">Nomor WhatsApp / HP *<input type="tel"
                                        name="phone" id="customerEditForm-phone" required maxlength="150"
                                        placeholder="Nomor WhatsApp / HP" /></label></div>
                            <div class="cs-customer-edit-cols"><label for="customerEditForm-category">Kategori
                                    Pelanggan<select name="category" id="customerEditForm-category">
                                        <option value="Kampus & Organisasi">Kampus & Organisasi</option>
                                        <option value="Korporat & Industri">Korporat & Industri</option>
                                        <option value="Komunitas Kreatif">Komunitas Kreatif</option>
                                        <option value="Sekolah / OSIS">Sekolah / OSIS</option>
                                        <option value="Lainnya / Personal">Lainnya / Personal</option>
                                    </select></label><label for="customerEditForm-org">Nama Instansi / Perusahaan /
                                    Kampus<input type="text" name="org" id="customerEditForm-org" maxlength="150"
                                        placeholder="Nama Instansi / Perusahaan / Kampus" /></label></div>
                            <div class="cs-customer-edit-cols"><label for="customerEditForm-city">Kota / Domisili<input
                                        type="text" name="city" id="customerEditForm-city" maxlength="150"
                                        placeholder="Kota / Domisili" /></label><label for="customerEditForm-email">Email
                                    Pelanggan<input type="email" name="email" id="customerEditForm-email"
                                        maxlength="150" placeholder="Email Pelanggan" /></label></div>
                            <label for="customerEditForm-role">Posisi / Jabatan PIC<input type="text" name="role"
                                    id="customerEditForm-role" maxlength="150"
                                    placeholder="Posisi / Jabatan PIC" /></label><label
                                for="customerEditForm-address">Alamat Lengkap & Pengiriman
                                <textarea name="address" id="customerEditForm-address" rows="3" maxlength="1000"></textarea>
                            </label><label for="customerEditForm-note">Catatan Tambahan PIC / Preferensi Order
                                <textarea name="note" id="customerEditForm-note" rows="3" maxlength="1000"></textarea>
                            </label>
                            <p class="cs-customer-form-note">ID pelanggan dikelola otomatis. Jumlah dan riwayat order tidak
                                bisa diubah melalui formulir kontak.</p>
                            <div class="cs-customer-edit-actions">
                                <button type="button" data-close-edit class="cs-customer-edit-cancel">Batal</button>
                                <button type="submit" class="cs-customer-edit-primary"><span
                                        class="material-symbols-outlined text-[17px]">save</span> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
@endsection
