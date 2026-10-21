@extends('layout.owner')
@section('title', 'Dashboard Owner | Presma Operations')
@section('content')

    <div class="owner-dashboard-page flex flex-col w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-space-md mb-space-xl">
            <div>
                <div
                    class="flex items-center gap-space-xs font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-6">
                  
                    <span class="w-1 h-1 rounded-full bg-surface-tint"></span>
                </div>
                <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight leading-none">Dashboard</h1>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1.5">Ringkasan menyeluruh operasional Presma
                    Konveksi hari ini.</p>
            </div>
            <div class="flex flex-wrap items-center gap-space-sm">
                <div
                    class="flex items-center gap-space-xs bg-surface-container-lowest px-space-md h-[44px] rounded-lg shadow-sm text-on-surface border border-[#D9DADB]">
                    <span class="material-symbols-outlined text-lg text-on-surface-variant">calendar_today</span><span
                        class="font-label-md text-label-md font-semibold">Bulan Ini - Sept 2026</span><span
                        class="material-symbols-outlined text-base text-on-surface-variant">expand_more</span></div>
                <button
                    class="h-[44px] px-space-md bg-surface-container-lowest border border-[#D9DADB] text-on-surface rounded-lg shadow-sm font-label-md text-label-md font-semibold hover:bg-surface-container transition-colors flex items-center gap-space-xs"
                    id="ownerExportCsv" title="Unduh data contoh tabel sebagai CSV" type="button"><span
                        class="material-symbols-outlined text-lg text-on-surface-variant">file_download</span><span
                        class="">Export Laporan</span></button>
                <button
                    class="h-[44px] px-space-md bg-[#830909] hover:bg-primary text-on-primary rounded-lg shadow-sm font-label-md text-label-md font-semibold transition-colors flex items-center gap-space-xs owner-disabled-button"
                    disabled="disabled" title="Fitur akan diaktifkan setelah modul terkait tersedia" type="button"><span
                        class="material-symbols-outlined text-lg leading-none">add</span><span class="">+ Order
                        Baru</span></button>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-xl">
            <div
                class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-primary-fixed/30 to-transparent rounded-bl-full pointer-events-none">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Order Aktif</span>
                        <span
                            class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-semibold">+8
                            bulan ini</span>
                    </div>
                    <div class="font-display-lg text-display-lg text-on-surface font-data-tabular mt-2 tracking-tight">64
                        <span class="font-headline-sm text-headline-sm text-on-surface-variant font-normal">Pesanan</span>
                    </div>
                </div>
                <div class="mt-space-md pt-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="">Total SPK berjalan seluruh tim</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-[#FEF3E6] to-transparent rounded-bl-full pointer-events-none">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Dalam Produksi</span>
                        <span
                            class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#FEF3E6] text-[#B86B00] font-bold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#B86B00]"></span>+3 perlu perhatian
                        </span>
                    </div>
                    <div class="font-display-lg text-display-lg text-on-surface font-data-tabular mt-2 tracking-tight">24
                        <span class="font-headline-sm text-headline-sm text-on-surface-variant font-normal">Batch</span>
                    </div>
                </div>
                <div class="mt-space-md pt-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="">Tahap potong, jahit, &amp; QC</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-secondary-container/40 to-transparent rounded-bl-full pointer-events-none">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Omzet Bulan Ini</span>
                        <span
                            class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#E8F5EE] text-[#16804B] font-bold flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-xs">trending_up</span>+12,8% dari Desember
                        </span>
                    </div>
                    <div class="font-display-lg text-display-lg text-on-surface font-data-tabular mt-2 tracking-tight">Rp
                        186,4 Jt</div>
                </div>
                <div
                    class="mt-space-md pt-space-xs text-on-surface-variant font-body-sm text-body-sm flex items-center justify-between">
                    <span class="">Target Rp 210 Jt</span>
                    <span class="font-semibold text-on-surface">88,7% tercapai</span>
                </div>
            </div>
            <div
                class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between relative overflow-hidden group">
                <div
                    class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-bl from-error-container/40 to-transparent rounded-bl-full pointer-events-none">
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-label-md text-label-md text-on-surface-variant font-medium">Stok Menipis</span>
                        <span
                            class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#FDE8E8] text-[#C62B2B] font-bold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>2 bahan habis
                        </span>
                    </div>
                    <div class="font-display-lg text-display-lg text-error font-data-tabular mt-2 tracking-tight">7 <span
                            class="font-headline-sm text-headline-sm text-on-surface-variant font-normal">Bahan</span></div>
                </div>
                <div class="mt-space-md pt-space-xs text-on-surface-variant font-body-sm text-body-sm">
                    <span class="">Di bawah batas minimum aman</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
            <div class="xl:col-span-8 flex flex-col gap-space-lg">
                <div class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col gap-space-md">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-xs">
                        <div>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface">Ringkasan Operasional</h2>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Live Flow — Aliran status
                                SPK dari CS hingga kirim</p>
                        </div>
                        <span
                            class="font-label-sm text-label-sm px-2.5 py-1 bg-surface-container-low text-on-surface-variant rounded-full font-semibold self-start sm:self-auto">Total
                            63 SPK Aktif</span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-space-sm">
                        <div
                            class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between border border-transparent hover:border-outline-variant transition-colors">
                            <span class="font-body-sm text-body-sm text-on-surface-variant font-medium">1. Order Baru</span>
                            <div class="flex items-baseline justify-between mt-2">
                                <span class="font-display-lg text-display-lg text-on-surface font-data-tabular">12</span>
                                <span
                                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-surface-container-highest text-on-surface-variant font-semibold">SPK
                                    CS</span>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between border border-transparent hover:border-outline-variant transition-colors">
                            <span class="font-body-sm text-body-sm text-on-surface-variant font-medium">2. WO Masuk</span>
                            <div class="flex items-baseline justify-between mt-2">
                                <span class="font-display-lg text-display-lg text-[#2563A8] font-data-tabular">18</span>
                                <span
                                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-[#EBF2FA] text-[#2563A8] font-semibold">Antrean
                                    WO</span>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between border border-transparent hover:border-outline-variant transition-colors">
                            <span class="font-body-sm text-body-sm text-on-surface-variant font-medium">3. Dalam
                                Produksi</span>
                            <div class="flex items-baseline justify-between mt-2">
                                <span
                                    class="font-display-lg text-display-lg text-primary-container font-data-tabular">24</span>
                                <span
                                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-primary-fixed text-on-primary-fixed font-bold">Potong/Jahit</span>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-low p-space-md rounded-xl flex flex-col justify-between border border-transparent hover:border-outline-variant transition-colors">
                            <span class="font-body-sm text-body-sm text-on-surface-variant font-medium">4. Menunggu
                                Pelunasan</span>
                            <div class="flex items-baseline justify-between mt-2">
                                <span class="font-display-lg text-display-lg text-[#16804B] font-data-tabular">9</span>
                                <span
                                    class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-[#E8F5EE] text-[#16804B] font-semibold">QC
                                    &amp; Siap</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm mb-space-md">
                            <div>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface">Order Terbaru &amp; Perlu
                                    Perhatian</h2>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Sinkronisasi pesanan
                                    aktif dengan CS dan Produksi</p>
                            </div>
                            <span
                                class="font-label-sm text-label-sm px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed font-bold self-start sm:self-auto">5
                                Perlu Pantauan</span>
                        </div>
                        <div class="overflow-x-auto -mx-space-lg px-space-lg">
                            <table class="w-full text-left min-w-[620px]" id="ownerOrdersTable">
                                <thead>
                                    <tr
                                        class="bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase">
                                        <th class="py-2.5 px-3 rounded-l-lg">Order ID</th>
                                        <th class="py-2.5 px-3">Customer</th>
                                        <th class="py-2.5 px-3">Produk</th>
                                        <th class="py-2.5 px-3">PJ CS</th>
                                        <th class="py-2.5 px-3">Status</th>
                                        <th class="py-2.5 px-3">Deadline</th>
                                        <th class="py-2.5 px-3 text-right">Nilai Total</th>
                                        <th class="py-2.5 px-3 text-center rounded-r-lg">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="font-body-md text-body-md divide-y divide-transparent">
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3 px-3 font-data-tabular font-bold text-primary">ORD-0330</td>
                                        <td class="py-3 px-3">
                                            <div class="font-title-sm text-title-sm text-on-surface leading-snug">BEM FT
                                                UGM</div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Kemenko
                                                Advokasi</span>
                                        </td>
                                        <td class="py-3 px-3 font-body-sm text-body-sm">
                                            <div class="text-on-surface font-medium">Korsa PDH Kampus</div>
                                            <span class="text-on-surface-variant">65 pcs • Drill Nagata</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-space-xs">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-sm text-label-sm font-semibold shrink-0">
                                                    RH</div>
                                                <div class="flex flex-col"><span
                                                        class="font-title-sm text-title-sm text-on-surface leading-tight font-medium">Rina
                                                        Handayani</span><span
                                                        class="font-body-sm text-[11px] text-on-surface-variant leading-tight">Senior
                                                        CS</span></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-bold">Produksi</span>
                                        </td>
                                        <td class="py-3 px-3 font-data-tabular text-error font-semibold">18 Okt (H-1)</td>
                                        <td class="py-3 px-3 font-data-tabular text-right text-on-surface font-semibold">Rp
                                            9.750.000</td>
                                        <td class="py-3 px-3 text-center">
                                            <button
                                                class="px-2.5 py-1 bg-surface-container hover:bg-surface-container-high rounded text-on-surface font-label-sm text-label-sm font-semibold transition-colors owner-disabled-button"
                                                disabled="disabled"
                                                title="Fitur akan diaktifkan setelah modul terkait tersedia"
                                                type="button">Detail</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3 px-3 font-data-tabular font-bold text-primary">ORD-0329</td>
                                        <td class="py-3 px-3">
                                            <div class="font-title-sm text-title-sm text-on-surface leading-snug">Komunitas
                                                Sinema Jogja</div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Divisi
                                                Dokumentasi</span>
                                        </td>
                                        <td class="py-3 px-3 font-body-sm text-body-sm">
                                            <div class="text-on-surface font-medium">Varsity Jacket</div>
                                            <span class="text-on-surface-variant">40 pcs • Fleece + Kulit</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-space-xs">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-sm text-label-sm font-semibold shrink-0">
                                                    DA</div>
                                                <div class="flex flex-col"><span
                                                        class="font-title-sm text-title-sm text-on-surface leading-tight font-medium">Dimas
                                                        Aditya</span><span
                                                        class="font-body-sm text-[11px] text-on-surface-variant leading-tight">CS
                                                        Team</span></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#FEF3E6] text-[#B86B00] font-bold">QC</span>
                                        </td>
                                        <td class="py-3 px-3 font-data-tabular text-error font-semibold">20 Okt (H-3)</td>
                                        <td class="py-3 px-3 font-data-tabular text-right text-on-surface font-semibold">Rp
                                            11.200.000</td>
                                        <td class="py-3 px-3 text-center">
                                            <button
                                                class="px-2.5 py-1 bg-surface-container hover:bg-surface-container-high rounded text-on-surface font-label-sm text-label-sm font-semibold transition-colors owner-disabled-button"
                                                disabled="disabled"
                                                title="Fitur akan diaktifkan setelah modul terkait tersedia"
                                                type="button">Detail</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3 px-3 font-data-tabular font-bold text-primary">ORD-0328</td>
                                        <td class="py-3 px-3">
                                            <div class="font-title-sm text-title-sm text-on-surface leading-snug">PT Sinar
                                                Maju Perkasa</div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Divisi
                                                Operasional Lapangan</span>
                                        </td>
                                        <td class="py-3 px-3 font-body-sm text-body-sm">
                                            <div class="text-on-surface font-medium">Wearpack Safety Korsa</div>
                                            <span class="text-on-surface-variant">150 pcs • Reflektor 3M</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-space-xs">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-sm text-label-sm font-semibold shrink-0">
                                                    SN</div>
                                                <div class="flex flex-col"><span
                                                        class="font-title-sm text-title-sm text-on-surface leading-tight font-medium">Siti
                                                        Nurhaliza</span><span
                                                        class="font-body-sm text-[11px] text-on-surface-variant leading-tight">CS
                                                        Corporate</span></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#EBF2FA] text-[#2563A8] font-bold">Diproses</span>
                                        </td>
                                        <td class="py-3 px-3 font-data-tabular text-on-surface">24 Okt</td>
                                        <td class="py-3 px-3 font-data-tabular text-right text-on-surface font-semibold">Rp
                                            24.500.000</td>
                                        <td class="py-3 px-3 text-center">
                                            <button
                                                class="px-2.5 py-1 bg-surface-container hover:bg-surface-container-high rounded text-on-surface font-label-sm text-label-sm font-semibold transition-colors owner-disabled-button"
                                                disabled="disabled"
                                                title="Fitur akan diaktifkan setelah modul terkait tersedia"
                                                type="button">Detail</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3 px-3 font-data-tabular font-bold text-primary">ORD-0327</td>
                                        <td class="py-3 px-3">
                                            <div class="font-title-sm text-title-sm text-on-surface leading-snug">Himpunan
                                                Biologi UNISA</div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Panitia Studi
                                                Lapangan</span>
                                        </td>
                                        <td class="py-3 px-3 font-body-sm text-body-sm">
                                            <div class="text-on-surface font-medium">Rompi / Vest Lapangan</div>
                                            <span class="text-on-surface-variant">55 pcs • Ripstop Premium</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-space-xs">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-sm text-label-sm font-semibold shrink-0">
                                                    RH</div>
                                                <div class="flex flex-col"><span
                                                        class="font-title-sm text-title-sm text-on-surface leading-tight font-medium">Rina
                                                        Handayani</span><span
                                                        class="font-body-sm text-[11px] text-on-surface-variant leading-tight">Senior
                                                        CS</span></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed font-bold">Produksi</span>
                                        </td>
                                        <td class="py-3 px-3 font-data-tabular text-on-surface">27 Okt</td>
                                        <td class="py-3 px-3 font-data-tabular text-right text-on-surface font-semibold">Rp
                                            7.425.000</td>
                                        <td class="py-3 px-3 text-center">
                                            <button
                                                class="px-2.5 py-1 bg-surface-container hover:bg-surface-container-high rounded text-on-surface font-label-sm text-label-sm font-semibold transition-colors owner-disabled-button"
                                                disabled="disabled"
                                                title="Fitur akan diaktifkan setelah modul terkait tersedia"
                                                type="button">Detail</button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-surface-container-low transition-colors">
                                        <td class="py-3 px-3 font-data-tabular font-bold text-primary">ORD-0325</td>
                                        <td class="py-3 px-3">
                                            <div class="font-title-sm text-title-sm text-on-surface leading-snug">Himatek
                                                ITS</div>
                                            <span class="font-body-sm text-body-sm text-on-surface-variant">Biro
                                                Ekraf</span>
                                        </td>
                                        <td class="py-3 px-3 font-body-sm text-body-sm">
                                            <div class="text-on-surface font-medium">Polo Shirt Bordir</div>
                                            <span class="text-on-surface-variant">90 pcs • Lacoste CVC 24s</span>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="flex items-center gap-space-xs">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-label-sm text-label-sm font-semibold shrink-0">
                                                    DA</div>
                                                <div class="flex flex-col"><span
                                                        class="font-title-sm text-title-sm text-on-surface leading-tight font-medium">Dimas
                                                        Aditya</span><span
                                                        class="font-body-sm text-[11px] text-on-surface-variant leading-tight">CS
                                                        Team</span></div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container font-semibold">Baru</span>
                                        </td>
                                        <td class="py-3 px-3 font-data-tabular text-on-surface">30 Okt</td>
                                        <td class="py-3 px-3 font-data-tabular text-right text-on-surface font-semibold">Rp
                                            8.100.000</td>
                                        <td class="py-3 px-3 text-center">
                                            <button
                                                class="px-2.5 py-1 bg-surface-container hover:bg-surface-container-high rounded text-on-surface font-label-sm text-label-sm font-semibold transition-colors owner-disabled-button"
                                                disabled="disabled"
                                                title="Fitur akan diaktifkan setelah modul terkait tersedia"
                                                type="button">Detail</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pt-space-md mt-space-md flex items-center justify-between border-t border-[#D9DADB]">
                        <span class="font-body-sm text-body-sm text-on-surface-variant">Menampilkan 5 dari 64 order
                            aktif</span>
                        <button
                            class="font-label-md text-label-md text-primary font-bold hover:underline flex items-center gap-1 owner-disabled-button"
                            disabled="disabled" title="Fitur akan diaktifkan setelah modul terkait tersedia"
                            type="button">
                            Lihat Semua Order <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="xl:col-span-4 flex flex-col gap-space-lg">
                <div class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-space-xs">
                                <span
                                    class="material-symbols-outlined text-primary-container">account_balance_wallet</span>
                                <h3 class="font-title-md text-title-md text-on-surface font-semibold">Keuangan Bulan Ini
                                </h3>
                            </div>
                            <span
                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#E8F5EE] text-[#16804B] font-bold">Surplus</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">Monitoring tanpa mengubah
                            transaksi tim</p>
                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between py-1.5 border-b border-surface-container">
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Pendapatan Diterima</span>
                                <span class="font-data-tabular font-semibold text-on-surface">Rp 142.850.000</span>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-surface-container">
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Piutang Berjalan</span>
                                <span class="font-data-tabular font-semibold text-[#B86B00]">Rp 43.550.000</span>
                            </div>
                            <div class="flex items-center justify-between py-1.5 border-b border-surface-container">
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Pembelian Bahan</span>
                                <span class="font-data-tabular font-semibold text-error">Rp 38.420.000</span>
                            </div>
                            <div class="p-space-md bg-primary-fixed/30 rounded-xl mt-space-sm">
                                <div class="flex justify-between items-center mb-1">
                                    <span
                                        class="font-body-sm text-body-sm text-on-primary-fixed font-semibold flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full bg-primary-container"></span> Arus Bersih
                                    </span>
                                    <span class="font-label-sm text-label-sm text-primary font-bold">Surplus
                                        Operasional</span>
                                </div>
                                <div class="font-headline-sm text-headline-sm text-primary font-data-tabular font-bold">Rp
                                    104.430.000</div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-space-md mt-space-md">
                        <button
                            class="w-full h-[44px] px-3 bg-surface-container hover:bg-surface-container-high text-on-surface rounded-lg font-label-md text-label-md font-semibold transition-colors flex items-center justify-center gap-space-xs border border-[#D9DADB] owner-disabled-button"
                            disabled="disabled" title="Fitur akan diaktifkan setelah modul terkait tersedia"
                            type="button">
                            <span class="material-symbols-outlined text-base">receipt_long</span>
                            <span class="">Lihat Buku Kas</span>
                        </button>
                    </div>
                </div>
                <div class="bg-surface-container-lowest p-space-lg rounded-[16px] shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <div class="flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-[#C62B2B]">warning</span>
                                <h3 class="font-title-md text-title-md text-on-surface font-semibold">Peringatan Restock
                                </h3>
                            </div>
                            <span
                                class="font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-[#FDE8E8] text-[#C62B2B] font-bold">2
                                Kritis / Habis</span>
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mb-space-md">7 bahan menipis, 2 kritis
                            untuk batch produksi aktif</p>
                        <div class="space-y-space-sm">
                            <div class="p-space-sm bg-[#FDE8E8]/40 border border-[#FDE8E8] rounded-lg">
                                <div class="flex justify-between items-center text-on-surface font-title-sm text-title-sm">
                                    <span class="font-medium">Kain Furing Hero Hitam</span>
                                    <span class="font-data-tabular text-error font-bold">0 Meter (Habis)</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                                    <div class="bg-error h-full" style="width: 0%"></div>
                                </div>
                                <span class="font-label-sm text-label-sm text-on-surface-variant mt-1 block">Roll 01 • Min.
                                    Safe: 15 Meter</span>
                            </div>
                            <div class="p-space-sm bg-surface-container-low rounded-lg">
                                <div class="flex justify-between items-center text-on-surface font-title-sm text-title-sm">
                                    <span class="font-medium">Resleting YKK Jaket 60cm</span>
                                    <span class="font-data-tabular text-error font-bold">12 pcs (Menipis)</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                                    <div class="bg-error h-full" style="width: 30%"></div>
                                </div>
                                <span class="font-label-sm text-label-sm text-on-surface-variant mt-1 block">Besi Hitam •
                                    Min. Safe: 40 pcs</span>
                            </div>
                            <div class="p-space-sm bg-surface-container-low rounded-lg">
                                <div class="flex justify-between items-center text-on-surface font-title-sm text-title-sm">
                                    <span class="font-medium">Benang Jahit Navy</span>
                                    <span class="font-data-tabular text-[#B86B00] font-bold">12 cones (Menipis)</span>
                                </div>
                                <div class="w-full bg-surface-container-high h-1.5 rounded-full mt-2 overflow-hidden">
                                    <div class="bg-[#B86B00] h-full" style="width: 48%"></div>
                                </div>
                                <span class="font-label-sm text-label-sm text-on-surface-variant mt-1 block">Astra 40/2 •
                                    Min. Safe: 25 cones</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-space-md mt-space-md">
                        <button
                            class="w-full h-[44px] px-3 bg-[#830909] hover:bg-primary text-on-primary rounded-lg font-label-md text-label-md font-semibold transition-colors flex items-center justify-center gap-space-xs shadow-sm owner-disabled-button"
                            disabled="disabled" title="Fitur akan diaktifkan setelah modul terkait tersedia"
                            type="button">
                            <span class="material-symbols-outlined text-base">shopping_cart_checkout</span>
                            <span class="">Pesan Bahan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
