@extends('layout.cs')
@section('title', 'Order Management | Presma Operations')
@section('content')
    <main class="cs-order-page w-full pt-16 px-space-xl py-space-lg flex-1 bg-surface">
        <div class="flex flex-col w-full gap-space-lg">
            <!-- Top Banner / Operational Context Bar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-space-md pb-space-xs">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 flex-wrap"></div>
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-bold">Order Management
                        &amp; Verifikasi</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-3xl leading-relaxed">Verifikasi pesanan
                        masuk dari formulir web pelanggan, lengkapi rincian spesifikasi, input kalkulasi harga satuan, dan
                        delegasikan data pola ke divisi desainer.</p>
                </div>
                <div class="flex items-center gap-space-sm self-start md:self-auto"><button
                        class="cs-order-header-btn inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-lg bg-surface-container-lowest hover:bg-surface-container text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors shadow-sm"><span
                            class="material-symbols-outlined text-[18px] text-emerald-700">file_download</span><span
                            class="">Export Data (.CSV)</span></button><button
                        class="cs-order-header-btn inline-flex items-center gap-2 px-4 h-[44px] rounded-lg bg-[#830909] hover:bg-[#A10B0B] text-on-primary font-title-sm text-title-sm font-semibold transition-all shadow-sm"><span
                            class="material-symbols-outlined text-[18px]">add_circle</span><span class="">Tambah Order
                            Baru</span></button></div>
            </div>
            <!-- Operational Stat Cards / Queue Pulse -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
                <div
                    class="bg-surface-container-lowest p-4 rounded-2xl border border-[#D9DADB] flex flex-col justify-between shadow-sm h-full">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between"><span
                                class="font-label-sm text-label-sm font-semibold uppercase tracking-wider text-on-surface-variant">Total
                                Order Masuk</span><span
                                class="p-1.5 rounded-lg bg-surface-container text-on-surface-variant flex items-center justify-center"><span
                                    class="material-symbols-outlined text-[18px]">inbox</span></span></div>
                        <div class="flex items-baseline justify-between gap-2 mt-1"><span
                                class="cs-order-kpi-number text-[28px] font-bold text-on-surface tracking-tight leading-none">28</span><span
                                class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold">+6
                                hari ini</span></div>
                    </div>
                    <div
                        class="border-t border-surface-variant pt-2.5 mt-3 flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[15px] text-primary">calendar_today</span><span
                            class="">Periode aktif Oktober 2024</span></div>
                </div>
                <div
                    class="bg-surface-container-lowest p-4 rounded-2xl border border-[#D9DADB] flex flex-col justify-between shadow-sm h-full">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between"><span
                                class="font-label-sm text-label-sm font-semibold uppercase tracking-wider text-on-surface-variant">Perlu
                                Verifikasi CS</span><span
                                class="p-1.5 rounded-lg bg-amber-50 text-amber-800 flex items-center justify-center"><span
                                    class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span></span></div>
                        <div class="flex items-baseline justify-between gap-2 mt-1"><span
                                class="cs-order-kpi-number text-[28px] font-bold text-on-surface tracking-tight leading-none">6</span><span
                                class="px-2 py-0.5 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold flex items-center gap-1"><span
                                    class="material-symbols-outlined text-[13px]">warning</span>Langkah Intake</span></div>
                    </div>
                    <div
                        class="border-t border-surface-variant pt-2.5 mt-3 flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[15px] text-amber-800">schedule</span><span
                            class="">Fiksasi spesifikasi &amp; harga satuan</span></div>
                </div>
                <div
                    class="bg-surface-container-lowest p-4 rounded-2xl border border-[#D9DADB] flex flex-col justify-between shadow-sm h-full">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between"><span
                                class="font-label-sm text-label-sm font-semibold uppercase tracking-wider text-on-surface-variant">Dalam
                                Pengerjaan</span><span
                                class="p-1.5 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant flex items-center justify-center"><span
                                    class="material-symbols-outlined text-[18px]">precision_manufacturing</span></span>
                        </div>
                        <div class="flex items-baseline justify-between gap-2 mt-1"><span
                                class="cs-order-kpi-number text-[28px] font-bold text-on-surface tracking-tight leading-none">18</span><span
                                class="px-2 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm font-semibold">SPK
                                Aktif</span></div>
                    </div>
                    <div
                        class="border-t border-surface-variant pt-2.5 mt-3 flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[15px] text-tertiary">layers</span><span
                            class="truncate">Jahit, Bordir Komputer, Finishing</span></div>
                </div>
                <div
                    class="bg-surface-container-lowest p-4 rounded-2xl border border-[#D9DADB] flex flex-col justify-between shadow-sm h-full">
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-between"><span
                                class="font-label-sm text-label-sm font-semibold uppercase tracking-wider text-on-surface-variant">Siap
                                Diambil / Kirim</span><span
                                class="p-1.5 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center"><span
                                    class="material-symbols-outlined text-[18px]">local_shipping</span></span></div>
                        <div class="flex items-baseline justify-between gap-2 mt-1"><span
                                class="cs-order-kpi-number text-[28px] font-bold text-emerald-700 tracking-tight leading-none">4</span><span
                                class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold">Pelunasan
                                100%</span></div>
                    </div>
                    <div
                        class="border-t border-surface-variant pt-2.5 mt-3 flex items-center gap-1.5 text-on-surface-variant font-body-sm text-body-sm">
                        <span class="material-symbols-outlined text-[15px] text-emerald-700">check_circle</span><span
                            class="">Quality Check lolos &amp; siap ekspedisi</span></div>
                </div>
            </div>
            <!-- Main Workflow Workspace Container -->
            <div
                class="bg-surface-container-lowest rounded-2xl border border-[#D9DADB] shadow-sm flex flex-col overflow-hidden">
                <div
                    class="p-4 border-b border-[#D9DADB] flex flex-col md:flex-row md:items-center justify-between gap-3 bg-surface-container-lowest">
                    <div class="flex items-center gap-2 flex-1 max-w-lg">
                        <div class="relative w-full"><span
                                class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-on-surface-variant">search</span><input
                                class="w-full h-10 pl-9 pr-3 rounded-lg bg-surface-container-low border border-[#D9DADB] text-body-sm text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:ring-2 focus:ring-primary-container/20"
                                placeholder="Cari No. Order, nama pemesan, instansi, produk..." type="text" /></div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="flex items-center gap-1.5"><label
                                class="font-label-sm text-label-sm text-on-surface-variant font-semibold uppercase">Pembayaran:</label><select
                                data-cs-filter="payment"
                                class="h-9 px-2.5 rounded-lg bg-surface-container-low border border-[#D9DADB] text-body-sm text-on-surface focus:outline-none">
                                <option value="all">Semua Status</option>
                                <option value="dp">DP 50% Masuk</option>
                                <option value="lunas">Lunas 100%</option>
                                <option value="belum">Belum Bayar</option>
                            </select></div>
                        <div class="flex items-center gap-1.5"><label
                                class="font-label-sm text-label-sm text-on-surface-variant font-semibold uppercase">Kategori:</label><select
                                data-cs-filter="category"
                                class="h-9 px-2.5 rounded-lg bg-surface-container-low border border-[#D9DADB] text-body-sm text-on-surface focus:outline-none">
                                <option value="all">Semua Kategori</option>
                                <option value="korsa">Korsa / PDH</option>
                                <option value="jaket">Jaket &amp; Rompi</option>
                                <option value="kaos">Kaos &amp; Polo</option>
                            </select></div>
                    </div>
                </div>
                <div
                    class="flex items-center gap-1 px-4 pt-2 bg-surface-container-low border-b border-[#D9DADB] overflow-x-auto">
                    <button type="button" data-cs-tab="all" class="cs-order-tab"><span class="">Semua
                            Order</span><span
                            class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface font-mono text-label-sm font-semibold">28</span></button><button
                        type="button" data-cs-tab="verification" class="cs-order-tab"><span class="">Perlu
                            Verifikasi</span><span
                            class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 font-mono text-label-sm font-semibold">6</span></button><button
                        type="button" data-cs-tab="production" class="cs-order-tab"><span class="">Produksi
                            Berjalan</span><span
                            class="px-2 py-0.5 rounded-full bg-surface-container text-on-surface-variant font-mono text-label-sm font-semibold">18</span></button><button
                        type="button" data-cs-tab="ready" class="cs-order-tab"><span class="">Siap
                            Kirim</span><span
                            class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-900 font-mono text-label-sm font-semibold">4</span></button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1250px] text-left border-collapse text-body-sm" id="csOrderTable">
                        <thead
                            class="bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider border-b border-[#D9DADB]">
                            <tr>
                                <th class="py-3.5 px-4 font-semibold w-36">Kode Order</th>
                                <th class="py-3.5 px-4 font-semibold w-36">Tanggal Masuk</th>
                                <th class="py-3.5 px-4 font-semibold w-64">Pelanggan &amp; Instansi</th>
                                <th class="py-3.5 px-4 font-semibold w-64">Jenis Produk</th>
                                <th class="py-3.5 px-4 font-semibold w-56">Penanggung Jawab</th>
                                <th class="py-3.5 px-4 font-semibold w-56">Status Order &amp; Produksi</th>
                                <th class="py-3.5 px-4 font-semibold w-40">Status Pembayaran</th>
                                <th class="py-3.5 px-4 font-semibold text-right w-44">Total Nilai Order</th>
                                <th class="py-3.5 px-4 font-semibold text-center w-56">Tindakan / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D9DADB] bg-surface-container-lowest">
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="korsa" data-order-row="true" data-payment="dp" data-stage="verification">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0330</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">24
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">09:15
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Farhan Saputra</span><span
                                            class="text-on-surface-variant font-body-sm">BEM FT UGM (Yogyakarta)</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Korsa PDH
                                            Nagata Drill</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-[#830909] text-on-primary font-bold text-label-sm flex items-center justify-center shrink-0 ring-1 ring-outline-variant/40">
                                            AB</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Abiyyu</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-[#830909]/10 text-primary w-max mt-0.5">Owner</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 font-label-sm text-label-sm font-semibold w-max"><span
                                                class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>Menunggu
                                            Verifikasi CS</span><span
                                            class="font-label-sm text-label-sm text-error font-medium">Deadline H-3 (02
                                            Nov)</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold"><span
                                            class="material-symbols-outlined text-[13px]">check_circle</span>DP 50%
                                        Masuk</span></td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        50.175.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-[#830909] hover:bg-[#A10B0B] text-on-primary font-title-sm text-title-sm font-medium shadow-sm transition-colors"
                                            data-cs-action="verify"><span
                                                class="material-symbols-outlined text-[16px]">verified</span>Verifikasi</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button></div>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="kaos" data-order-row="true" data-payment="dp" data-stage="production">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0329</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">24
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">08:30
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Rizky Aditya</span><span
                                            class="text-on-surface-variant font-body-sm">HMM UGM Divisi Kaderisasi</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Kaos Polo
                                            Lacoste CVC</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary-container text-on-primary font-bold text-label-sm flex items-center justify-center shrink-0">
                                            RH</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Rina
                                                Handayani</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant w-max mt-0.5">Senior
                                                CS</span></div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-tertiary-fixed text-on-tertiary-fixed-variant font-label-sm text-label-sm font-semibold w-max"><span
                                                class="material-symbols-outlined text-[13px]">assignment_turned_in</span>Siap
                                            Terbitkan WO</span><span
                                            class="font-label-sm text-label-sm text-on-surface-variant font-medium">Pola
                                            disetujui pemesan</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold"><span
                                            class="material-symbols-outlined text-[13px]">check_circle</span>DP 50%
                                        Masuk</span></td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        20.900.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="tracking"><span
                                                class="material-symbols-outlined text-[16px]">near_me</span>Tracking</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="jaket" data-order-row="true" data-payment="dp" data-stage="production">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0328</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">23
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">16:45
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Nadia Rahmawati</span><span
                                            class="text-on-surface-variant font-body-sm">PT Citra Prima Nusantara</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Jaket Parka
                                            Taslan WP</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-secondary-fixed text-on-secondary-fixed font-bold text-label-sm flex items-center justify-center shrink-0">
                                            DA</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Dimas
                                                Aditya</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant w-max mt-0.5">CS
                                                2</span></div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface font-label-sm text-label-sm font-semibold w-max"><span
                                                class="material-symbols-outlined text-[13px]">tune</span>Jahit &amp;
                                            Bordir</span><span
                                            class="font-label-sm text-label-sm text-on-surface-variant font-medium">Proses
                                            Jahit 65%</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold"><span
                                            class="material-symbols-outlined text-[13px]">check_circle</span>DP 50%
                                        Masuk</span></td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        36.750.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="tracking"><span
                                                class="material-symbols-outlined text-[16px]">near_me</span>Tracking</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="jaket" data-order-row="true" data-payment="lunas" data-stage="ready">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0327</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">23
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">14:10
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Dewi Kartika</span><span
                                            class="text-on-surface-variant font-body-sm">Komunitas Relawan Muda
                                            Sleman</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Rompi Vest
                                            Lapangan Drill</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-surface-variant text-on-surface font-bold text-label-sm flex items-center justify-center shrink-0">
                                            SN</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Siti
                                                Nurhaliza</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant w-max mt-0.5">CS
                                                1</span></div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold w-max"><span
                                                class="material-symbols-outlined text-[13px]">inventory</span>Selesai
                                            Packing</span><span
                                            class="font-label-sm text-label-sm text-emerald-700 font-medium">Siap kirim
                                            ekspedisi</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-bold"><span
                                            class="material-symbols-outlined text-[13px]">verified</span>Lunas 100%</span>
                                </td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        15.600.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-emerald-700 hover:text-emerald-800 font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="tracking"><span
                                                class="material-symbols-outlined text-[16px]">local_shipping</span>Tracking</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="korsa" data-order-row="true" data-payment="belum"
                                data-stage="verification">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0326</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">22
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">11:20
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Ahmad Fauzan</span><span
                                            class="text-on-surface-variant font-body-sm">SMK Negeri 2 Depok Sleman</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Korsa Praktik
                                            Siswa Otomotif</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-[#830909] text-on-primary font-bold text-label-sm flex items-center justify-center shrink-0 ring-1 ring-outline-variant/40">
                                            AB</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Abiyyu</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-[#830909]/10 text-primary w-max mt-0.5">Owner</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 font-label-sm text-label-sm font-semibold w-max"><span
                                                class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>Menunggu
                                            Verifikasi CS</span><span
                                            class="font-label-sm text-label-sm text-on-surface-variant font-medium">Cek
                                            file logo saku</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm font-semibold"><span
                                            class="material-symbols-outlined text-[13px]">pending</span>Belum Bayar</span>
                                </td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        28.000.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-[#830909] hover:bg-[#A10B0B] text-on-primary font-title-sm text-title-sm font-medium shadow-sm transition-colors"
                                            data-cs-action="verify"><span
                                                class="material-symbols-outlined text-[16px]">verified</span>Verifikasi</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button></div>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container-low transition-colors cursor-pointer"
                                data-category="jaket" data-order-row="true" data-payment="dp" data-stage="production">
                                <td class="py-3.5 px-4"><span
                                        class="font-title-sm text-title-sm font-bold text-primary font-mono">ORD-2024-0325</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-medium text-on-surface text-body-sm">22
                                            Okt 2024</span><span class="text-[11px] text-on-surface-variant">09:05
                                            WIB</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span
                                            class="font-semibold text-on-surface text-[15px]">Hendra Gunawan</span><span
                                            class="text-on-surface-variant font-body-sm">Alumni Arsitektur Undip</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col"><span class="font-semibold text-on-surface">Jaket Coach
                                            Taslan Milky</span></div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="w-8 h-8 rounded-full bg-secondary-fixed text-on-secondary-fixed font-bold text-label-sm flex items-center justify-center shrink-0">
                                            DA</div>
                                        <div class="flex flex-col"><span
                                                class="font-semibold text-on-surface leading-tight text-body-sm">Dimas
                                                Aditya</span><span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant w-max mt-0.5">CS
                                                2</span></div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex flex-col gap-1"><span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface font-label-sm text-label-sm font-semibold w-max"><span
                                                class="material-symbols-outlined text-[13px]">precision_manufacturing</span>Jahit
                                            &amp; Bordir</span><span
                                            class="font-label-sm text-label-sm text-on-surface-variant font-medium">Proses
                                            Finishing</span></div>
                                </td>
                                <td class="py-3.5 px-4"><span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-900 font-label-sm text-label-sm font-semibold"><span
                                            class="material-symbols-outlined text-[13px]">check_circle</span>DP 50%
                                        Masuk</span></td>
                                <td class="py-3.5 px-4 text-right"><span
                                        class="font-title-sm text-title-sm font-bold text-on-surface font-mono text-[15px]">Rp
                                        14.875.000</span></td>
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex items-center justify-center gap-2"><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="detail"><span
                                                class="material-symbols-outlined text-[16px]">visibility</span>Detail
                                            Pesanan</button><button
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-primary font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors"
                                            data-cs-action="tracking"><span
                                                class="material-symbols-outlined text-[16px]">near_me</span>Tracking</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="p-4 border-t border-[#D9DADB] flex flex-col sm:flex-row items-center justify-between gap-3 bg-surface-container-lowest">
                    <span data-cs-summary class="font-body-sm text-body-sm text-on-surface-variant">Menampilkan 0 dari 6
                        order contoh</span>
                    <div class="flex items-center gap-1.5"><button
                            class="px-3 py-1.5 rounded-lg bg-surface-container text-on-surface-variant font-title-sm text-title-sm disabled:opacity-50 cursor-not-allowed"
                            disabled="">Sebelumnya</button><button
                            class="w-8 h-8 rounded-lg bg-[#830909] text-on-primary font-title-sm text-title-sm font-bold shadow-sm">1</button><button
                            class="w-8 h-8 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm transition-colors">2</button><button
                            class="w-8 h-8 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm transition-colors">3</button><button
                            class="px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm transition-colors">Berikutnya</button>
                    </div>
                </div>
            </div>
            <!-- Operational Flow Reference Card (CS Quick Guide) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md">
            </div>
            <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden"
                id="modal-input-order">
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg max-w-lg w-full p-space-md overflow-hidden flex flex-col gap-space-md">
                    <div class="flex items-center justify-between border-b border-surface-container-high pb-2">
                        <h3 class="font-title-sm text-title-sm font-bold text-on-surface flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-[20px]">add_circle</span> Input Order
                            Khusus / Manual</h3><button
                            class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant"
                            id="close-modal-input"><span
                                class="material-symbols-outlined text-[20px]">close</span></button>
                    </div>
                    <form class="flex flex-col gap-space-sm" id="form-input-order">
                        <div class="flex flex-col gap-1"><label
                                class="font-label-sm text-label-sm font-semibold text-on-surface-variant uppercase">Nama
                                Pemesan / Instansi</label><input
                                class="h-9 px-3 rounded-lg bg-surface-container-low text-on-surface text-body-sm focus:outline-none focus:ring-2 focus:ring-primary-container/20"
                                placeholder="Misal: Panitia Dies Natalis FT UI" required="" type="text" /></div>
                        <div class="grid grid-cols-2 gap-space-sm">
                            <div class="flex flex-col gap-1"><label
                                    class="font-label-sm text-label-sm font-semibold text-on-surface-variant uppercase">Jenis
                                    Produk</label><input
                                    class="h-9 px-3 rounded-lg bg-surface-container-low text-on-surface text-body-sm focus:outline-none"
                                    placeholder="Korsa / Jaket / Polo" required="" type="text" /></div>
                            <div class="flex flex-col gap-1"><label
                                    class="font-label-sm text-label-sm font-semibold text-on-surface-variant uppercase">Kuantitas
                                    (pcs)</label><input
                                    class="h-9 px-3 rounded-lg bg-surface-container-low text-on-surface text-body-sm focus:outline-none"
                                    placeholder="Contoh: 100" required="" type="number" /></div>
                        </div>
                        <div class="flex flex-col gap-1"><label
                                class="font-label-sm text-label-sm font-semibold text-on-surface-variant uppercase">Target
                                Deadline</label><input
                                class="h-9 px-3 rounded-lg bg-surface-container-low text-on-surface text-body-sm focus:outline-none"
                                required="" type="date" /></div>
                        <div class="flex items-center justify-end gap-2 pt-2 border-t border-surface-container-high">
                            <button
                                class="px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm font-medium"
                                id="btn-cancel-input" type="button">Batal</button><button
                                class="px-4 py-1.5 rounded-lg bg-primary-container text-on-primary hover:bg-primary font-title-sm text-title-sm font-semibold shadow-sm"
                                type="submit">Simpan Antrean</button></div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 hidden"
                id="modal-detail-order">
                <div
                    class="bg-surface-container-lowest rounded-xl shadow-lg max-w-lg w-full p-space-md flex flex-col gap-space-md">
                    <div class="flex items-center justify-between border-b border-surface-container-high pb-2">
                        <div class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-[20px]">receipt_long</span>
                            <h3 class="font-title-sm text-title-sm font-bold text-on-surface" id="modal-detail-title">
                                Detail Verifikasi Pesanan</h3>
                        </div><button class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant"
                            id="close-modal-detail"><span
                                class="material-symbols-outlined text-[20px]">close</span></button>
                    </div>
                    <div class="flex flex-col gap-space-sm bg-surface-container-low p-space-sm rounded-lg text-body-sm">
                        <div class="flex justify-between items-center"><span
                                class="text-on-surface-variant font-label-sm">Kode Order:</span><span
                                class="font-title-sm font-bold text-primary" id="detail-kode">ORD-2024-0325</span></div>
                        <div class="flex justify-between items-center"><span
                                class="text-on-surface-variant font-label-sm">Customer:</span><span
                                class="font-semibold text-on-surface" id="detail-customer">Pelanggan</span></div>
                        <div class="flex justify-between items-center"><span
                                class="text-on-surface-variant font-label-sm">Produk:</span><span class="text-on-surface"
                                id="detail-produk">Hendra Gunawan</span></div>
                        <div class="flex justify-between items-center"><span
                                class="text-on-surface-variant font-label-sm">Target Deadline:</span><span
                                class="font-semibold text-error" id="detail-deadline">Jaket Coach Taslan MilkySablon
                                Raster Depan Belakang</span></div>
                        <div class="flex justify-between items-center"><span
                                class="text-on-surface-variant font-label-sm">Status Saat Ini:</span><span
                                class="px-2 py-0.5 rounded-full text-label-sm font-semibold bg-amber-100 text-amber-900"
                                id="detail-status">DADimas AdityaCS 2</span></div>
                    </div>
                    <div class="flex items-center justify-between gap-2 pt-2 border-t border-surface-container-high">
                        <button
                            class="px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm flex items-center gap-1"
                            id="btn-request-info" type="button"><span
                                class="material-symbols-outlined text-[16px]">chat</span> Minta Kelengkapan Data</button>
                        <div class="flex gap-2"><button
                                class="px-3 py-1.5 rounded-lg bg-surface-container hover:bg-surface-container-high text-on-surface font-title-sm text-title-sm"
                                id="btn-close-detail" type="button">Tutup</button><button
                                class="px-4 py-1.5 rounded-lg bg-primary-container text-on-primary hover:bg-primary font-title-sm text-title-sm font-semibold"
                                id="btn-approve-designer" type="button">Verifikasi &amp; Teruskan</button></div>
                    </div>
                </div>
            </div>
            <div class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none" id="toast-container"></div>
        </div>
        <script>
            // Simple interactive dropdown / trigger simulation for CS quick action dots
            document.querySelectorAll('button[title="Opsi Cepat"], button[title="Reset Filter"]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    console.log('Action menu triggered for operational item');
                });
            });
        </script>

        <!-- Modal input order, frontend preview only -->
        <div id="csOrderCreateModal" class="cs-order-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csOrderCreateTitle">
            <div class="cs-order-modal" role="document">
                <div class="cs-order-modal-header">
                    <h2 id="csOrderCreateTitle" class="font-bold text-[17px]">Tambah Order Baru</h2><button
                        type="button" data-order-close aria-label="Tutup">✕</button>
                </div>
                <form id="csOrderCreateForm" class="cs-order-form">
                    <label>Nama Pemesan <input name="customer" required maxlength="120"
                            placeholder="Nama pelanggan" /></label>
                    <label>Instansi <input name="organization" maxlength="120" placeholder="Nama instansi" /></label>
                    <div class="cs-order-form-grid"><label>Jenis Produk <input name="product" required maxlength="120"
                                placeholder="Contoh: Korsa PDH" /></label><label>Qty (pcs) <input name="quantity" required
                                type="number" min="1" placeholder="100" /></label></div>
                    <div class="cs-order-form-grid"><label>Target Deadline <input name="deadline" required
                                type="date" /></label><label>Harga Satuan (Rp) <input name="unitPrice" type="number"
                                min="0" step="1000" placeholder="120000" /></label></div>
                    <label>Spesifikasi / Catatan
                        <textarea name="notes" rows="2" placeholder="Warna, bahan, ukuran, bordir..."></textarea>
                    </label>
                    <p class="cs-order-note">Data hanya ditambahkan ke tampilan saat ini, belum disimpan ke database.</p>
                    <div class="cs-order-actions"><button type="button" data-order-close
                            class="cs-order-btn-light">Batal</button><button type="submit"
                            class="cs-order-btn-primary">Tambah ke Antrean</button></div>
                </form>
            </div>
        </div>

        <!-- Detail order preview -->
        <div id="csOrderDetailModal" class="cs-order-overlay hidden" role="dialog" aria-modal="true"
            aria-labelledby="csOrderDetailTitle">
            <div class="cs-order-modal" role="document">
                <div class="cs-order-modal-header">
                    <h2 id="csOrderDetailTitle" class="font-bold text-[17px]">Detail Pesanan</h2><button type="button"
                        data-order-close aria-label="Tutup">✕</button>
                </div>
                <div class="cs-order-detail-grid">
                    <div><small>Kode Order</small><strong id="csDetailCode"></strong></div>
                    <div><small>Pelanggan</small><strong id="csDetailCustomer"></strong></div>
                    <div><small>Produk</small><strong id="csDetailProduct"></strong></div>
                    <div><small>Penanggung Jawab</small><strong id="csDetailOwner"></strong></div>
                    <div><small>Status Pesanan</small><strong id="csDetailStatus"></strong></div>
                    <div><small>Status Pembayaran</small><strong id="csDetailPayment"></strong></div>
                    <div><small>Total Nilai</small><strong id="csDetailAmount"></strong></div>
                </div>
                <p class="cs-order-note">Verifikasi, penerbitan WO, pembayaran, dan tracking sungguhan akan terhubung lewat
                    backend.</p>
                <div class="cs-order-actions"><button type="button" data-order-close
                        class="cs-order-btn-light">Tutup</button></div>
            </div>
        </div>
    </main>
@endsection
