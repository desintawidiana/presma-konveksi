@extends('layout.owner')

@section('title', 'Laporan & Analitik | Owner')

@section('content')
<style>
.analytics {
    max-width: 1600px;
    margin: 0 auto;
    padding: 88px 24px 32px;
    box-sizing: border-box;
    font-family: inherit;
    font-size: 13px;
    color: #302b2b;
}

.analytics [hidden] {
    display: none !important;
}

.analytics h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 12px;
}

.analytics h2 {
    font-size: 18px;
    font-weight: 600;
    margin: 0 0 10px;
}

.analytics h3 {
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 12px;
}

.analytics .toolbar {
    display: flex;
    gap: 8px;
    align-items: center;
    flex-wrap: wrap;
    margin: 12px 0;
}

.analytics .main-tabs {
    border-bottom: 1px solid #e3dddd;
    padding-bottom: 10px;
    margin-top: 0;
}

.analytics button,
.analytics select,
.analytics input {
    font: inherit;
    font-size: 13px;
    border: 1px solid #ddd5d5;
    border-radius: 7px;
    padding: 8px 12px;
    background: #fff;
    color: #443737;
    box-sizing: border-box;
}

.analytics button {
    color: #870e12;
    font-weight: 600;
    cursor: pointer;
}

.analytics button:hover,
.analytics .main-tabs button.active {
    background: #870e12;
    color: #fff;
}

.analytics .metrics {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin: 16px 0;
}

.analytics .panel,
.analytics .metric {
    background: #fff;
    border: 1px solid #dedada;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 6px #3b151508;
    box-sizing: border-box;
    min-width: 0;
}

.analytics .metric {
    border-top: 3px solid #8b1013;
}

.analytics .metric strong {
    display: block;
    font-size: 22px;
    line-height: 1.25;
    margin: 8px 0;
    color: #282323;
    overflow-wrap: anywhere;
}

.analytics .muted {
    color: #776d6d;
    font-size: 12px;
}

.analytics .charts {
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    gap: 12px;
}

.analytics .panel {
    margin-top: 12px;
}

.analytics .track {
    height: 6px;
    background: #f3e5e5;
    border-radius: 8px;
    overflow: hidden;
}

.analytics .bar {
    height: 100%;
    background: #870e12;
    border-radius: 8px;
}

.analytics .pcs-chart {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    height: 180px;
    border-bottom: 1px solid #e4dada;
    padding: 8px 6px 0;
}

.analytics .pcs-col {
    flex: 1;
    min-width: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    color: #665858;
}

.analytics .pcs-col i {
    display: block;
    width: 65%;
    background: #870e12;
    border-radius: 5px 5px 0 0;
    min-height: 4px;
}

.analytics .pcs-col b {
    color: #870e12;
}

.analytics .pcs-col small {
    padding-bottom: 6px;
}

/* Tabel Laporan Kegiatan */
#activityReport {
    width: 100%;
    min-width: 0;
}

#activityReport .report-table-scroll {
    display: block;
    width: 100%;
    max-width: 100%;
    overflow-x: auto;
    margin-top: 12px;
    -webkit-overflow-scrolling: touch;
}

#activityReport table {
    width: 100%;
    min-width: 1200px;
    border-collapse: collapse;
    table-layout: auto;
    font-size: 13px;
}

#activityReport th,
#activityReport td {
    padding: 12px 16px;
    text-align: left;
    vertical-align: middle;
    border-bottom: 1px solid #eee6e6;
}

#activityReport th {
    background: #f8f5f5;
    color: #694e4e;
    font-weight: 600;
    white-space: nowrap;
}

#activityReport th:nth-child(1),
#activityReport td:nth-child(1),
#activityReport th:nth-child(6),
#activityReport td:nth-child(6),
#activityReport th:nth-child(7),
#activityReport td:nth-child(7),
#activityReport th:nth-child(8),
#activityReport td:nth-child(8) {
    white-space: nowrap;
}

#activityReport th:nth-child(5),
#activityReport td:nth-child(5) {
    min-width: 180px;
}

#activityReport tbody tr:hover {
    background: #fcf8f8;
}

@media (max-width: 900px) {
    .analytics .metrics {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .analytics .charts {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 520px) {
    .analytics {
        padding: 80px 12px 20px;
    }

    .analytics .metrics {
        grid-template-columns: 1fr;
    }
}
</style>

<main class="analytics">

    <div class="toolbar main-tabs">
        <button id="tabOverview" onclick="switchView(false)">
            Dashboard Analitik
        </button>
        <button id="tabActivity" onclick="switchView(true)">
            Laporan Kegiatan
        </button>
    </div>

    <div id="overview">
        <h1>Laporan & Analitik</h1>

        <div class="toolbar">
            <label for="month">Periode</label>
            <input type="month" id="month" value="2026-11">
            <button id="save">Unduh CSV</button>
        </div>

        <div class="metrics" id="metrics"></div>

        <div class="charts">
            <section class="panel">
                <h3>Penjualan per CS</h3>
                <div id="bars"></div>
            </section>

            <section class="panel">
                <h3>Ringkasan operasional</h3>
                <div id="activity"></div>
            </section>
        </div>

        <section class="panel">
            <h3>Perbandingan Penjualan Bulanan (PCS)</h3>
            <div id="pcsChart" class="pcs-chart"></div>
        </section>
    </div>

    <section id="activityReport" class="panel" hidden>
        <h2>Laporan Seluruh Kegiatan</h2>
        <p class="muted">Rekap lintas operasional · Data demo</p>

        <div class="toolbar">
            <input type="month" id="activityMonth" value="2026-11">

            <select id="activityType">
                <option value="all">Semua kegiatan</option>
                <option value="Penjualan">Penjualan</option>
                <option value="Pembelian">Pembelian</option>
                <option value="Stok">Stok</option>
                <option value="Produksi">Produksi</option>
                <option value="Keuangan">Keuangan</option>
            </select>

            <button id="downloadActivity">Unduh Laporan CSV</button>
        </div>

        <div class="report-table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Petugas</th>
                        <th>Asal / Mitra</th>
                        <th>Nama kegiatan / barang</th>
                        <th>Jumlah</th>
                        <th>Nilai</th>
                        <th>Arus kas</th>
                    </tr>
                </thead>
                <tbody id="activityRows"></tbody>
            </table>
        </div>
    </section>

</main>

<script>
const data = [
    ['Penjualan', 'CS 1', 'BEM FT UGM', 'Korsa PDH', 18, 18500000, 'Pemasukan'],
    ['Penjualan', 'CS 2', 'CV Karya Utama', 'Rompi Bordir', 14, 14200000, 'Pemasukan'],
    ['Pembelian', 'Runner Produksi', 'Supplier Bahan', 'Kain Drill', 8, 7600000, 'Pengeluaran'],
    ['Stok', 'Admin CS', 'Gudang', 'Kain Drill', 24, 0, 'Nonkeuangan'],
    ['Produksi', 'Tim Produksi', 'BEM FT UGM', 'Korsa PDH', 26, 0, 'Nonkeuangan'],
    ['Keuangan', 'Owner', 'Kas Operasional', 'Pemasukan penjualan', 32, 32700000, 'Pemasukan'],
    ['Keuangan', 'Owner', 'Kas Operasional', 'Pengeluaran pembelian bahan', 8, 7600000, 'Pengeluaran']
];

const pcs = [420, 510, 465, 580, 620, 680];
const money = n => 'Rp ' + n.toLocaleString('id-ID');

function switchView(showActivity) {
    document.getElementById('overview').hidden = showActivity;
    document.getElementById('activityReport').hidden = !showActivity;

    document.getElementById('tabOverview').classList.toggle('active', !showActivity);
    document.getElementById('tabActivity').classList.toggle('active', showActivity);
}

function render() {
    const m = document.getElementById('month').value;
    if (!m) return;

    const d = new Date(m + '-01T12:00:00');

    const months = pcs.map((v, i) => {
        const x = new Date(d.getFullYear(), d.getMonth() - 5 + i, 1);
        return [
            x.toLocaleDateString('id-ID', { month: 'short', year: '2-digit' }),
            v
        ];
    });

    document.getElementById('pcsChart').innerHTML = months.map(([label, v]) => `
        <div class="pcs-col">
            <b>${v} pcs</b>
            <i style="height:${v / 680 * 145}px"></i>
            <small>${label}</small>
        </div>
    `).join('');

    const total = data
        .filter(r => r[0] === 'Penjualan')
        .reduce((a, r) => a + r[5], 0);

    document.getElementById('metrics').innerHTML = [
        ['Penjualan', money(total)],
        ['Pesanan', '32'],
        ['Pembelian', money(7600000)],
        ['Produksi selesai', '26']
    ].map(r => `
        <div class="metric">
            <span class="muted">${r[0]}</span>
            <strong>${r[1]}</strong>
            <span class="muted">Periode terpilih</span>
        </div>
    `).join('');

    document.getElementById('bars').innerHTML = data
        .filter(r => r[0] === 'Penjualan')
        .map(r => `
            <div style="display:flex;justify-content:space-between;margin:16px 0 8px">
                <b>${r[1]}</b>
                <strong>${money(r[5])}</strong>
            </div>
            <div class="track">
                <div class="bar" style="width:${r[5] / 185000}%"></div>
            </div>
        `).join('');

    document.getElementById('activity').innerHTML = [
        ['Pembelian', 8],
        ['Stok bahan', 24],
        ['Produksi selesai', 26]
    ].map(r => `
        <div style="display:flex;justify-content:space-between;align-items:center;
                    padding:12px 0;border-bottom:1px solid #eee6e6">
            <span>${r[0]}</span>
            <strong style="background:#f8e9e9;color:#870e12;
                           border-radius:20px;padding:5px 12px">${r[1]}</strong>
        </div>
    `).join('');
}

function activity() {
    const type = document.getElementById('activityType').value;
    const month = document.getElementById('activityMonth').value;

    return data
        .map((r, i) => [
            month + '-' + String(i + 1).padStart(2, '0'),
            ...r
        ])
        .filter(r => type === 'all' || r[1] === type);
}

function renderActivity() {
    document.getElementById('activityRows').innerHTML = activity()
        .map(r => `
            <tr>
                ${r.map((v, i) => {
                    if (i === 6) {
                        const sign = r[7] === 'Pemasukan'
                            ? '+ '
                            : r[7] === 'Pengeluaran' ? '− ' : '';

                        return `<td>${sign}${money(v)}</td>`;
                    }

                    return `<td>${v}</td>`;
                }).join('')}
            </tr>
        `).join('');
}

function downloadCSV(filename, csv) {
    const blob = new Blob(['\ufeff' + csv], {
        type: 'text/csv;charset=utf-8'
    });

    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}

document.getElementById('activityType').onchange = renderActivity;
document.getElementById('activityMonth').onchange = renderActivity;

document.getElementById('downloadActivity').onclick = () => {
    const rows = activity().map(r =>
        r.map((v, i) => i === 6 && r[7] === 'Pengeluaran' ? -v : v)
            .map(v => '"' + String(v).replaceAll('"', '""') + '"')
            .join(',')
    );

    const csv = 'Tanggal,Kegiatan,Petugas,Asal/Mitra,Nama kegiatan/barang,Jumlah,Nilai,Arus kas\n'
        + rows.join('\n');

    downloadCSV('laporan-kegiatan.csv', csv);
};

document.getElementById('month').onchange = render;

document.getElementById('save').onclick = () => {
    const d = new Date(document.getElementById('month').value + '-01T12:00:00');

    const csv = 'Periode,PCS\n' + pcs.map((v, i) => {
        const x = new Date(d.getFullYear(), d.getMonth() - 5 + i, 1);
        const period = x.getFullYear() + '-' + String(x.getMonth() + 1).padStart(2, '0');
        return period + ',' + v;
    }).join('\n');

    downloadCSV('laporan-demo.csv', csv);
};

switchView(false);
render();
renderActivity();
</script>
@endsection