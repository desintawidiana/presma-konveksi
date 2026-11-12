@extends('layout.cs')

@section('title', 'Dashboard | Presma Operations')

@section('content')
    <main class="relative pt-12 min-h-screen bg-surface cs-main" data-order-url="{{ route('cs.order') }}">
        <div class="flex flex-col w-full">
            <div class="px-space-lg py-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">
                <!-- 1. HEADER RINGKAS & ACTIONS -->
                <div class="flex flex-col gap-4 pb-2">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-1.5 font-label-md text-label-md text-secondary"><span
                                    class="hover:text-on-surface transition-colors cursor-pointer">
                                    <h1 class="font-headline-lg text-headline-lg text-on-surface font-bold tracking-tight"
                                        style="font-size:24px;line-height:32px;color:#191c1c">Dashboard Customer Service</h1>
                                    <p class="text-secondary mt-2 text-sm">Pusat kendali harian CS: penanganan pesanan,
                                        verifikasi berkas, monitoring pembayaran pelanggan, dan penerbitan Work Order.</p>
                                </span></div>
                            <div class="flex flex-wrap items-center gap-2"></div>
                        </div>
                        <div class="flex items-center gap-3 shrink-0 self-start sm:self-center"><button aria-disabled="true"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-lg bg-surface-container-lowest hover:bg-surface-container text-on-surface font-title-sm text-title-sm font-medium border border-[#D9DADB] transition-colors shadow-sm"
                                disabled="disabled" title="Fitur ini akan dihubungkan setelah modul backend siap"
                                type="button"><span
                                    class="material-symbols-outlined text-[18px] text-emerald-700">download</span><span
                                    class="">Export Laporan (XLSX)<br /></span></button><a href="{{ route('cs.public-order.preview') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 h-[44px] rounded-lg bg-[#830909] hover:bg-[#A10B0B] text-white font-title-sm text-title-sm font-semibold transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[18px]">add</span>
                                <span>Buat Order Baru</span>
                            </a></div>
                    </div>
                    <div></div>
                </div>
                <!-- 2. 4 KARTU METRIK KPI UTAMA (PRESMA UI KIT CARD) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md cs-dashboard-kpi-grid">
                    <!-- Card 1: Pesanan Baru -->
                    <div
                        class="p-4 rounded-xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col justify-between hover:bg-surface-container-low/50 transition-colors gap-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[14px] font-medium text-secondary">Pesanan Baru</span>
                            <span
                                class="w-9 h-9 rounded-lg bg-[#FEF3E6] flex items-center justify-center text-[#B86B00] shrink-0">
                                <span class="material-symbols-outlined text-[20px]">inbox</span>
                            </span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-extrabold text-on-surface tracking-tight leading-none">6</span>
                                <span class="font-title-sm text-secondary font-medium">Order</span>
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#FEF3E6] text-[#B86B00] font-label-sm font-semibold w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#B86B00]"></span><span
                                    class="font-medium text-[11px] leading-tight">Butuh verifikasi awal CS</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: Dalam Produksi -->
                    <div
                        class="p-4 rounded-xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col justify-between hover:bg-surface-container-low/50 transition-colors gap-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[14px] font-medium text-secondary">Dalam Produksi</span>
                            <span
                                class="w-9 h-9 rounded-lg bg-[#EBF2FA] flex items-center justify-center text-[#2563A8] shrink-0">
                                <span class="material-symbols-outlined text-[20px]">precision_manufacturing</span>
                            </span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-extrabold text-on-surface tracking-tight leading-none">18</span>
                                <span class="font-title-sm text-secondary font-medium">SPK</span>
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#EBF2FA] text-[#2563A8] font-label-sm font-semibold w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#2563A8]"></span><span
                                    class="font-medium text-[11px] leading-tight">Terbit WO lantai jahit</span>

                            </div>
                        </div>
                    </div>
                    <!-- Card 3: Menunggu DP / Pelunasan -->
                    <div
                        class="p-4 rounded-xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col justify-between hover:bg-surface-container-low/50 transition-colors gap-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[13px] font-medium text-secondary">Menunggu DP / Pelunasan</span>
                            <span
                                class="w-9 h-9 rounded-lg bg-[#FDE8E8] flex items-center justify-center text-[#830909] shrink-0">
                                <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                            </span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-extrabold text-on-surface tracking-tight leading-none">8</span>
                                <span class="font-title-sm text-secondary font-medium">Invoice</span>
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#FDE8E8] text-[#C62B2B] font-label-sm font-semibold w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#C62B2B]"></span><span
                                    class="font-medium text-[11px] leading-tight">Perlu follow-up penagihan</span>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4: Selesai & Siap Kirim -->
                    <div
                        class="p-4 rounded-xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col justify-between hover:bg-surface-container-low/50 transition-colors gap-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[14px] font-medium text-secondary">Selesai &amp; Siap Kirim</span>
                            <span
                                class="w-9 h-9 rounded-lg bg-[#E8F5EE] flex items-center justify-center text-[#16804B] shrink-0">
                                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                            </span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl font-extrabold text-on-surface tracking-tight leading-none">5</span>
                                <span class="font-title-sm text-secondary font-medium">Pesanan</span>
                            </div>
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#E8F5EE] text-[#16804B] font-label-sm font-semibold w-fit">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16804B]"></span><span
                                    class="font-medium text-[11px] leading-tight">QC tuntas &amp; siap packing</span>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3. RINGKASAN STATUS KEUANGAN & PEMBAYARAN -->
                <div
                    class="p-space-md rounded-2xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col gap-4">
                    <div
                        class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#D9DADB]">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-9 h-9 rounded-lg bg-[#FDE8E8] text-primary-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                            </div>
                            <div>
                                <h2 class="font-title-sm text-on-surface font-bold leading-tight">Ringkasan Status Tagihan
                                    &amp; Pembayaran Pelanggan</h2>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container font-label-sm text-secondary font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16804B]"></span>Finansial Realtime</span>
                            <a href="{{ route('cs.invoice-pembayaran.preview') }}"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-[#D9DADB] bg-white px-3 h-[40px] text-[13px] font-semibold text-on-surface shadow-sm transition-colors hover:bg-[#F7E7E7] hover:text-[#830909]">
                                <span class="material-symbols-outlined text-[17px]">receipt</span>
                                <span>Rekap Tagihan</span>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div
                            class="p-3.5 rounded-xl bg-surface-container-low border border-[#D9DADB] flex flex-col justify-between gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-medium text-secondary">Total Nilai Pesanan</span>
                                <span class="material-symbols-outlined text-secondary text-[18px]">payments</span>
                            </div>
                            <div>
                                <div class="font-headline-sm font-bold text-on-surface font-data-tabular">Rp 60.787.500
                                </div>
                                <div class="text-[11px] text-secondary mt-0.5">Akumulasi 6 order aktif berjalan</div>
                            </div>
                        </div>
                        <div
                            class="p-3.5 rounded-xl bg-[#E8F5EE]/50 border border-[#16804B]/20 flex flex-col justify-between gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-medium text-[#16804B]">DP Terverifikasi</span>
                                <span class="material-symbols-outlined text-[#16804B] text-[18px]">verified</span>
                            </div>
                            <div>
                                <div class="font-headline-sm font-bold text-[#16804B] font-data-tabular">Rp 29.587.500
                                </div>
                                <div class="text-[11px] text-secondary mt-0.5">3 pesanan lolos verifikasi DP produksi</div>
                            </div>
                        </div>
                        <div
                            class="p-3.5 rounded-xl bg-[#FEF3E6]/60 border border-[#B86B00]/20 flex flex-col justify-between gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-medium text-[#B86B00]">Menunggu Pelunasan</span>
                                <span class="material-symbols-outlined text-[#B86B00] text-[18px]">pending_actions</span>
                            </div>
                            <div>
                                <div class="font-headline-sm font-bold text-[#B86B00] font-data-tabular">Rp 15.000.000
                                </div>
                                <div class="text-[11px] text-secondary mt-0.5">Siap kirim &amp; jadwal tagih pelunasan
                                </div>
                            </div>
                        </div>
                        <div
                            class="p-3.5 rounded-xl bg-[#FDE8E8]/60 border border-error/20 flex flex-col justify-between gap-2">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-medium text-[#C62B2B]">Belum Bayar DP</span>
                                <span class="material-symbols-outlined text-error text-[18px]">error_outline</span>
                            </div>
                            <div>
                                <div class="font-headline-sm font-bold text-error font-data-tabular">Rp 16.200.000</div>
                                <div class="text-[11px] text-[#C62B2B] font-medium mt-0.5">1 order butuh follow-up transfer
                                    CS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 4. TABEL DAFTAR PESANAN PERLU TINDAKAN CS -->
                <div
                    class="rounded-2xl bg-surface-container-lowest shadow-sm border border-[#D9DADB] flex flex-col overflow-hidden">
                    <!-- Toolbar Filter & Search -->
                    <div
                        class="p-space-md flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#D9DADB]">
                        <div class="flex items-center gap-2 overflow-x-auto">
                            <button
                                class="cs-queue-filter is-active px-3.5 h-[40px] rounded-lg bg-[#830909] text-on-primary transition-colors shadow-sm font-label-md font-semibold shrink-0 flex items-center gap-2"
                                data-cs-filter="all" type="button">
                                <span class="material-symbols-outlined text-[18px]">tune</span>
                                <span class="">Semua Antrean (6)</span>
                            </button>
                            <button
                                class="cs-queue-filter px-3.5 h-[40px] rounded-lg bg-surface-container-lowest border border-[#D9DADB] text-on-surface hover:bg-surface-container-low font-label-md font-medium transition-colors shrink-0"
                                data-cs-filter="verify" type="button">
                                Perlu Verifikasi (4)
                            </button>
                            <button
                                class="cs-queue-filter inline-flex items-center gap-1.5 px-3.5 h-[40px] rounded-lg bg-surface-container-lowest border border-[#D9DADB] text-on-surface hover:bg-surface-container-low font-label-md font-medium transition-colors shrink-0"
                                data-cs-filter="urgent" type="button">
                                <span class="w-2 h-2 rounded-full bg-error animate-pulse"></span>
                                Mendesak (2)
                            </button>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <div class="relative min-w-[260px] sm:w-72">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-3 text-secondary text-[18px]">search</span>
                                <input aria-label="Cari kode order atau customer"
                                    class="w-full h-[44px] pl-9 pr-3 rounded-lg bg-surface-container-lowest border border-[#D9DADB] font-body-sm text-on-surface placeholder:text-secondary focus:outline-none focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary-container/20 transition-all"
                                    id="cs-order-search" placeholder="Cari kode order / customer..." type="text" />
                            </div>
                            <button aria-disabled="true"
                                class="h-[44px] px-3.5 rounded-lg bg-surface-container-lowest border border-[#D9DADB] hover:bg-surface-container-low text-secondary hover:text-on-surface flex items-center gap-1.5 font-label-md font-medium transition-colors shrink-0 shadow-sm cs-disabled-action"
                                disabled="disabled" title="Fitur ini akan dihubungkan setelah modul backend siap"
                                type="button">
                                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                                <span class="">Filter</span>
                            </button>
                        </div>
                    </div>
                    <!-- Table Section -->
                    <div class="overflow-x-auto">
                        <table class="cs-order-table w-full text-left border-collapse">
                            <thead>

                                <tr
                                    class="bg-surface-container-low text-[13px] text-secondary uppercase tracking-wide border-b border-[#D9DADB]">
                                    <th class="py-2 px-3 font-semibold">Kode Order</th>
                                    <th class="py-2 px-3 font-semibold">Customer &amp; Instansi</th>
                                    <th class="py-2 px-3 font-semibold">Produk &amp; Qty</th>
                                    <th class="py-2 px-3 font-semibold">Deadline</th>
                                    <th class="py-2 px-3 font-semibold">Status Verifikasi</th>
                                    <th class="py-2 px-3 font-semibold text-center">Aksi Cepat</th>
                                </tr>

                            </thead>
                            <tbody id="csDashRows" class="divide-y divide-[#D9DADB] font-body-sm text-on-surface"></tbody>
                        </table>
                    </div>
                    <!-- Table Footer -->
                    <div
                        class="p-3 px-4 flex items-center justify-between bg-surface-container-low border-t border-[#D9DADB] text-secondary font-label-md">
                        <span class="" id="csDashFooter">Memuat data…</span>
                        <a class="text-primary-container font-semibold hover:underline flex items-center gap-1 text-[13px]"
                            href="{{ route('cs.order') }}" id="csDashAll">
                            <span class="">Buka Seluruh Antrean</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
