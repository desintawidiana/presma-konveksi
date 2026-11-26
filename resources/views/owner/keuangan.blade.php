@extends('layout.owner')
@section('title','Keuangan & Arus Kas | Owner')
@section('content')
<main class="owner-main" data-owner-table-page>
 <div class="owner-page-heading"><div><h1>Keuangan & Arus Kas</h1><p>Ringkasan pemasukan, pengeluaran, piutang, dan transaksi usaha.</p></div><div class="owner-actions"><button class="owner-btn" data-open-modal="finance-modal"><span class="material-symbols-outlined">add</span>Catat Transaksi</button></div></div>
 <section class="owner-grid owner-metrics">
  <article class="owner-card owner-metric"><div class="owner-metric-top">Total Pemasukan</div><strong>Rp 186,4 jt</strong><small>November 2026</small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Total Pengeluaran</div><strong>Rp 104,3 jt</strong><small>November 2026</small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Saldo Bersih</div><strong>Rp 82,1 jt</strong><small><span class="owner-badge green">Positif</span></small></article>
  <article class="owner-card owner-metric"><div class="owner-metric-top">Piutang Berjalan</div><strong>Rp 32,5 jt</strong><small>8 invoice belum lunas</small></article>
 </section>
 <section class="owner-card owner-panel finance-panel">
  <div class="owner-panel-heading"><div><h2>Arus Kas Bulanan</h2><p>Perbandingan pemasukan dan pengeluaran · data demo</p></div><span class="owner-badge" id="finance-caption"></span></div>
  <div class="finance-controls"><label for="finance-period">Periode akhir</label><input id="finance-period" type="month" value="2026-11"><select id="finance-range" aria-label="Rentang periode"><option value="3">3 bulan</option><option value="6" selected>6 bulan</option><option value="12">12 bulan</option></select></div>
  
<style>
.finance-panel{font-family:inherit}.finance-controls,.finance-legend{display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:14px 0}
.finance-controls label {
    font-size: 11px;
}
.finance-controls input,
.finance-controls select {
    font: inherit;
    font-size: 12px;
    padding: 6px 10px;
    border: 1px solid #d9dfe3;
    border-radius: 8px;
    background: white;
    justify-content: flex-end;
}
.finance-legend{font-size:12px}.finance-dot{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:6px}
.finance-chart-scroll{overflow-x:auto}.finance-svg{display:block;width:100%;min-width:640px;height:auto;font:inherit;font-size:12px}
</style>
<div class="finance-chart-scroll"><svg id="finance-chart" class="finance-svg" role="img" aria-label="Grafik garis arus kas bulanan" viewBox="0 0 960 330"></svg></div>
<div class="finance-legend"><span><i class="finance-dot" style="background:#247342"></i>Pemasukan (+)</span><span><i class="finance-dot" style="background:#a31b1b"></i>Pengeluaran (−)</span></div>
<script>
(()=>{
const income=[112,128,119,151,143,186.4,162,175,168,191,184,205],expense=[68,74,72,88,81,104.3,96,102,99,110,106,118];
const p=document.getElementById('finance-period'),r=document.getElementById('finance-range'),svg=document.getElementById('finance-chart');
const fmt=v=>new Intl.NumberFormat('id-ID',{maximumFractionDigits:1}).format(v);
function draw(){
if(!p.value)return;
let n=+r.value,d=new Date(p.value+'-01T12:00:00'),months=[];
for(let i=n-1;i>=0;i--){let m=new Date(d.getFullYear(),d.getMonth()-i,1),k=m.getMonth();months.push({m,a:income[k],b:expense[k]})}
let max=Math.max(...months.map(v=>v.a))*1.2;
let x=i=>65+i*860/Math.max(1,n-1),y=v=>270-v/max*220;
let h='';
for(let j=0;j<=4;j++){let v=max*j/4,yy=y(v);h+=`<line x1="65" x2="925" y1="${yy}" y2="${yy}" stroke="#e5e7eb"/><text x="55" y="${yy+4}" text-anchor="end" fill="#777">${fmt(v)}</text>`}
months.forEach((v,i)=>{h+=`<text x="${x(i)}" y="295" text-anchor="middle" fill="#666">${v.m.toLocaleDateString('id-ID',{month:'short',year:'2-digit'})}</text>`});
[['a','#247342','+'],['b','#a31b1b','−']].forEach(([key,color,sign])=>{
h+=`<polyline fill="none" stroke="${color}" stroke-width="3" stroke-linejoin="round" points="${months.map((v,i)=>x(i)+','+y(v[key])).join(' ')}"/>`;
months.forEach((v,i)=>{let xx=x(i),yy=y(v[key]);h+=`<circle cx="${xx}" cy="${yy}" r="4.5" fill="${color}" stroke="white" stroke-width="2"><title>${sign} Rp ${fmt(v[key])} juta</title></circle><text x="${xx}" y="${yy-10}" text-anchor="middle" fill="${color}" font-weight="600" font-size="11">${sign}${fmt(v[key])}</text>`})
});
svg.innerHTML=h;
document.getElementById('finance-caption').textContent=months[0].m.toLocaleDateString('id-ID',{month:'short',year:'numeric'})+' – '+d.toLocaleDateString('id-ID',{month:'short',year:'numeric'})+' · Rp juta';
}
p.onchange=draw;r.onchange=draw;draw();
})();
</script>
 </section>
 
 <section class="owner-card"><div class="owner-toolbar"><label class="owner-search"><span class="material-symbols-outlined">search</span><input id="owner-search" placeholder="Cari transaksi, invoice, atau customer..."></label><div class="owner-filters" data-filters><button class="owner-filter active" data-filter="all">Semua</button><button class="owner-filter" data-filter="masuk">Pemasukan</button><button class="owner-filter" data-filter="keluar">Pengeluaran</button><button class="owner-filter" data-filter="piutang">Piutang</button></div></div>
 <div class="owner-table-wrap"><table class="owner-table" id="owner-data-table"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Referensi</th><th>Kategori</th><th>Metode</th><th>Jumlah</th><th>Status</th></tr></thead><tbody>
 <tr data-state="masuk"><td>24 Nov 2026</td><td><strong>DP Korsa PDH BEM FT UGM</strong></td><td>INV-2026-0342</td><td>Pembayaran Order</td><td>Transfer</td><td style="color:#247342;font-weight:700">+ Rp 12.500.000</td><td><span class="owner-badge green">Terverifikasi</span></td></tr>
 <tr data-state="keluar"><td>23 Nov 2026</td><td><strong>Pembelian kain drill</strong></td><td>PB-2026-008</td><td>Bahan Baku</td><td>Transfer</td><td style="color:#a31b1b;font-weight:700">− Rp 4.250.000</td><td><span class="owner-badge green">Disetujui</span></td></tr>
 <tr data-state="piutang"><td>22 Nov 2026</td><td><strong>Pelunasan Kaos Komunitas</strong></td><td>INV-2026-0335</td><td>Piutang</td><td>—</td><td>Rp 8.000.000</td><td><span class="owner-badge orange">Menunggu</span></td></tr>
 <tr data-state="keluar"><td>20 Nov 2026</td><td><strong>Biaya operasional workshop</strong></td><td>OPS-2026-011</td><td>Operasional</td><td>Cash</td><td style="color:#a31b1b;font-weight:700">− Rp 1.200.000</td><td><span class="owner-badge green">Tercatat</span></td></tr>
 </tbody></table></div><div class="owner-table-footer"><span>Riwayat transaksi contoh</span><span>Data demo belum masuk pembukuan SQL</span></div></section>
 
 <div class="owner-modal" id="finance-modal"><div class="owner-modal-backdrop" data-close-modal></div><section class="owner-modal-content"><button class="owner-modal-close" data-close-modal><span class="material-symbols-outlined">close</span></button><h2 style="font-size:16px;font-weight:700">Catat Transaksi (Demo)</h2><form class="owner-form-grid" data-demo-form><div class="owner-field"><label>Jenis Transaksi</label><select><option>Pemasukan</option><option>Pengeluaran</option></select></div><div class="owner-field"><label>Tanggal</label><input type="date" value="2026-11-24"></div><div class="owner-field full"><label>Keterangan</label><input required placeholder="Keterangan transaksi"></div><div class="owner-field"><label>Kategori</label><input placeholder="Operasional / Bahan / Order"></div><div class="owner-field"><label>Jumlah (Rp)</label><input type="number" min="1" required></div><div class="owner-modal-actions full"><button type="button" class="owner-btn-light" data-close-modal>Batal</button><button class="owner-btn">Simpan Demo</button></div></form></section></div>
</main>
@endsection