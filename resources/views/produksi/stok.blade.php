@extends('layout.produksi')
@section('title','Stok Bahan | Presma Operations')
@section('breadcrumb','Stok Bahan')
@section('content')
<main class="produksi-main" data-stock-page>
    <div class="produksi-page-heading"><div><h1>Stok Bahan</h1><p>Pantau ketersediaan bahan dan catat pemakaian sesuai kebutuhan Work Order.</p></div></div>
    <div class="produksi-metrics">
        <article class="produksi-metric"><div>Total Jenis Bahan <span class="material-symbols-outlined">inventory_2</span></div><strong id="stock-total">8</strong><p>Bahan aktif di gudang</p></article>
        <article class="produksi-metric"><div>Stok Aman <span class="material-symbols-outlined">verified</span></div><strong id="stock-safe">4</strong><p>Di atas batas minimum</p></article>
        <article class="produksi-metric"><div>Perlu Restock <span class="material-symbols-outlined">warning</span></div><strong id="stock-low">3</strong><p>Sudah mencapai batas minimum</p></article>
        <article class="produksi-metric"><div>Stok Habis <span class="material-symbols-outlined">error</span></div><strong id="stock-empty">1</strong><p>Perlu pembelian segera</p></article>
    </div>
    <div class="produksi-note stock-info-note">Catat pemakaian saat bahan dikeluarkan untuk produksi. Status stok dan rekomendasi pembelian akan diperbarui otomatis.</div>

    <section class="produksi-panel stock-actions-panel">
        <div class="produksi-panel-heading"><div><h2>Kelola Persediaan</h2><p>Pilih tindakan sesuai aktivitas gudang dan kebutuhan produksi.</p></div></div>
        <div class="stock-action-buttons">
            <button type="button" class="produksi-btn-primary" data-open-stock-modal="usage-modal"><span class="material-symbols-outlined">remove_circle</span>Catat Pemakaian Bahan</button>
            <button type="button" class="produksi-btn-light" data-open-stock-modal="adjust-modal"><span class="material-symbols-outlined">fact_check</span>Penyesuaian Stok / Stok Opname</button>
        </div>
    </section>
    <div class="stock-modal" id="usage-modal" aria-hidden="true">
        <div class="stock-modal-backdrop" data-close-stock-modal></div>
        <section class="stock-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="usage-modal-title">
            <button type="button" class="stock-modal-close" data-close-stock-modal aria-label="Tutup"><span class="material-symbols-outlined">close</span></button>
            <div class="produksi-panel-heading"><div><h2 id="usage-modal-title">Catat Pemakaian Bahan</h2><p>Isi saat bahan dikeluarkan untuk Work Order.</p></div></div>
            <form id="material-usage-form" class="produksi-form">
                <div class="produksi-form-grid">
                    <label>Nomor Pesanan / Work Order<input name="order" required placeholder="Contoh: ORD-2026-0342 / WO-2026-0342"></label>
                    <label>Tahap Produksi<select name="stage" required><option value="">Pilih tahap</option><option>Persiapan Bahan</option><option>Cutting</option><option>Jahit/Bordir/Sablon</option><option>Finishing</option><option>QC</option><option>Packing</option></select></label>
                    <label class="full">Nama bahan<select name="material" id="usage-material" required><option value="">Pilih bahan dari persediaan</option></select></label>
                    <label>Jumlah dipakai<input name="qty" type="number" min="0.01" step="0.01" required placeholder="Contoh: 35"></label>
                    <label>Satuan <input id="usage-unit" value="Otomatis mengikuti bahan" readonly></label>
                    <label class="full">Keterangan<input name="note" placeholder="Contoh: kebutuhan cutting 350 pcs"></label>
                </div>
                <div class="produksi-form-actions"><span class="text-xs text-[#766d6d]">Stok tidak boleh menjadi minus.</span><button class="produksi-btn-primary" type="submit"><span class="material-symbols-outlined">remove_circle</span>Simpan Pemakaian</button></div>
                <p id="usage-feedback" class="text-xs mt-3" aria-live="polite"></p>
            </form>
        </section>
    </div>
    <div class="stock-modal" id="adjust-modal" aria-hidden="true">
        <div class="stock-modal-backdrop" data-close-stock-modal></div>
        <section class="stock-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="adjust-modal-title">
            <button type="button" class="stock-modal-close" data-close-stock-modal aria-label="Tutup"><span class="material-symbols-outlined">close</span></button>
            <div class="produksi-panel-heading"><div><h2 id="adjust-modal-title">Penyesuaian Stok / Stok Opname</h2><p>Isi jika jumlah fisik berbeda dari catatan sistem.</p></div></div>
            <form id="stock-adjust-form" class="produksi-form">
                <div class="produksi-form-grid">
                    <label class="full">Nama bahan<select name="material" id="adjust-material" required><option value="">Pilih bahan</option></select></label>
                    <label>Jumlah stok fisik<input name="qty" type="number" min="0" step="0.01" required placeholder="Jumlah aktual"></label>
                    <label class="full">Alasan penyesuaian<input name="reason" required placeholder="Contoh: hasil hitung ulang gudang"></label>
                </div>
                <div class="produksi-form-actions"><span class="text-xs text-[#766d6d]">Mengganti jumlah sistem dengan jumlah fisik.</span><button class="produksi-btn-light" type="submit">Simpan Stok Opname</button></div>
                <p id="adjust-feedback" class="text-xs mt-3" aria-live="polite"></p>
            </form>
        </section>
    </div>
    <section class="produksi-panel mt-5">
        <div class="produksi-panel-heading"><div><h2>Persediaan Bahan Baku</h2><p>Stok akan berubah setelah pemakaian atau stok opname dicatat</p></div><span class="produksi-chip">Data demo tersimpan di browser</span></div>
        <div class="stock-table-tools">
            <label class="stock-search-clean"><span class="material-symbols-outlined">search</span><input id="stock-search" placeholder="Cari nama/kode bahan..." aria-label="Cari nama atau kode bahan"></label>
            <div class="produksi-filter" id="stock-filters"><button class="active" data-filter="all">Semua</button><button data-filter="low">Menipis</button><button data-filter="empty">Habis</button><button data-filter="safe">Aman</button></div>
        </div>
        <div class="produksi-table-wrap"><table class="produksi-table"><thead><tr><th>Kode / Nama Bahan</th><th>Kategori</th><th>Stok Tersedia</th><th>Minimum</th><th>Satuan</th><th>Lokasi</th><th>Prioritas Pembelian</th><th>Status</th></tr></thead><tbody id="stock-rows"></tbody></table></div>
        <div class="produksi-panel-footer"><span id="stock-count">Menampilkan 8 bahan</span><span>Bahan berstatus Tidak prioritas tidak memicu rekomendasi pembelian.</span></div>
    </section>
    <section class="produksi-panel mt-5">
        <div class="produksi-panel-heading"><div><h2>Riwayat Pemakaian & Penyesuaian</h2><p>Aktivitas stok keluar dan stok opname</p></div></div>
        <div class="produksi-table-wrap"><table class="produksi-table"><thead><tr><th>Waktu</th><th>Aktivitas</th><th>Bahan</th><th>Jumlah</th><th>Pesanan / WO</th><th>Catatan</th></tr></thead><tbody id="stock-history"><tr><td colspan="6" class="produksi-empty">Belum ada aktivitas pada sesi demo ini.</td></tr></tbody></table></div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded',()=>{
 const KEY='presma_produksi_stock_v1', LOG='presma_produksi_stock_log_v1';
 const seed=[['BHN-001','Kain Drill American','Kain',125,40,'meter','Rak A1',true],['BHN-002','Kain Furing Hero Hitam','Kain',0,20,'meter','Rak A2',false],['BHN-003','Kain Taslan','Kain',18,25,'meter','Rak A1',true],['BHN-004','Benang Jahit Hitam','Aksesori',42,15,'cone','Rak B1',true],['BHN-005','Resleting YKK 60 cm','Aksesori',12,30,'pcs','Rak B2',true],['BHN-006','Kancing Kemeja','Aksesori',240,100,'pcs','Rak B3',true],['BHN-007','Label Woven Presma','Label',75,30,'pcs','Rak C1',false],['BHN-008','Plastik Packing','Packing',380,100,'pcs','Rak C2',false]];
 let stock=JSON.parse(localStorage.getItem(KEY)||'null')||seed.map(x=>({code:x[0],name:x[1],category:x[2],qty:x[3],min:x[4],unit:x[5],location:x[6],important:x[7]}));
 stock.forEach(x=>{if(typeof x.important==='undefined')x.important=['BHN-001','BHN-003','BHN-004','BHN-005','BHN-006'].includes(x.code);});
 let logs=JSON.parse(localStorage.getItem(LOG)||'[]');
 const save=()=>{localStorage.setItem(KEY,JSON.stringify(stock));localStorage.setItem(LOG,JSON.stringify(logs));const urgent=stock.filter(x=>x.important&&(x.qty<=0||x.qty<=x.min));localStorage.setItem('presma_produksi_stock_alerts_v1',JSON.stringify(urgent.map(x=>({code:x.code,name:x.name,qty:x.qty,min:x.min,unit:x.unit,status:x.qty<=0?'Habis':'Menipis'}))));};
 const esc=v=>String(v??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
 const status=x=>x.qty<=0?'empty':x.qty<=x.min?'low':'safe'; const needsBuy=x=>x.important && status(x)!=='safe';
 const fmt=n=>Number(n).toLocaleString('id-ID',{maximumFractionDigits:2});
 const refreshSelects=()=>{['usage-material','adjust-material'].forEach(id=>{const el=document.getElementById(id),old=el.value;el.innerHTML='<option value="">Pilih bahan</option>'+stock.map(x=>`<option value="${esc(x.code)}">${esc(x.name)} · stok ${fmt(x.qty)} ${esc(x.unit)}</option>`).join('');el.value=old;});};
 const render=()=>{const q=document.getElementById('stock-search').value.toLowerCase(),f=document.querySelector('#stock-filters button.active')?.dataset.filter||'all';const rows=stock.filter(x=>{const state=status(x);const matchFilter=f==='all'||(f==='low'&&needsBuy(x)&&state==='low')||(f==='empty'&&needsBuy(x)&&state==='empty')||(f==='safe'&&(!needsBuy(x)||state==='safe'));return matchFilter&&`${x.code} ${x.name} ${x.category}`.toLowerCase().includes(q);});document.getElementById('stock-rows').innerHTML=rows.map(x=>`<tr><td><b>${esc(x.name)}</b><span class="subtext">${esc(x.code)}</span></td><td>${esc(x.category)}</td><td class="qty">${fmt(x.qty)}</td><td>${fmt(x.min)}</td><td>${esc(x.unit)}</td><td>${esc(x.location)}</td><td><span class="produksi-status ${x.important?'red':'neutral'}">${x.important?'Penting':'Tidak prioritas'}</span></td><td><span class="produksi-status ${status(x)==='empty'?'red':status(x)==='safe'?'blue':''}">${status(x)==='empty'?'Habis':status(x)==='low'?'Menipis':'Aman'}</span></td></tr>`).join('')||'<tr><td colspan="8" class="produksi-empty">Bahan tidak ditemukan.</td></tr>';
 document.getElementById('stock-total').textContent=stock.length;document.getElementById('stock-safe').textContent=stock.filter(x=>!needsBuy(x)||status(x)==='safe').length;document.getElementById('stock-low').textContent=stock.filter(x=>needsBuy(x)&&status(x)==='low').length;document.getElementById('stock-empty').textContent=stock.filter(x=>needsBuy(x)&&status(x)==='empty').length;document.getElementById('stock-count').textContent=`Menampilkan ${rows.length} dari ${stock.length} bahan`;
 document.getElementById('stock-history').innerHTML=logs.length?logs.slice().reverse().map(x=>`<tr><td>${esc(x.time)}</td><td><span class="produksi-status ${x.type==='Pemakaian'?'red':'blue'}">${esc(x.type)}</span></td><td><b>${esc(x.material)}</b></td><td>${esc(x.qty)}</td><td>${esc(x.order||'-')}</td><td>${esc(x.note||'-')}</td></tr>`).join(''):'<tr><td colspan="6" class="produksi-empty">Belum ada aktivitas pada sesi demo ini.</td></tr>';
 refreshSelects();};
 document.getElementById('usage-material').addEventListener('change',e=>{const x=stock.find(x=>x.code===e.target.value);document.getElementById('usage-unit').value=x?x.unit:'Otomatis mengikuti bahan';});
 document.getElementById('material-usage-form').addEventListener('submit',e=>{e.preventDefault();const d=Object.fromEntries(new FormData(e.currentTarget)),x=stock.find(x=>x.code===d.material),qty=Number(d.qty);const msg=document.getElementById('usage-feedback');if(!x){msg.textContent='Pilih bahan yang akan digunakan.';return;}if(qty<=0||qty>x.qty){msg.textContent=`Jumlah tidak valid. Stok tersedia hanya ${fmt(x.qty)} ${x.unit}.`;msg.style.color='#b42318';return;}x.qty=Number((x.qty-qty).toFixed(2));logs.push({time:new Date().toLocaleString('id-ID'),type:'Pemakaian',material:x.name,qty:`-${fmt(qty)} ${x.unit}`,order:d.order,note:`${d.stage}${d.note?' · '+d.note:''}`});save();render();msg.textContent=`Pemakaian tersimpan. Sisa ${x.name}: ${fmt(x.qty)} ${x.unit} (${status(x)==='empty'?'Habis':status(x)==='low'?'Menipis':'Aman'}).`;msg.style.color='#27633b';e.currentTarget.reset();document.getElementById('usage-unit').value='Otomatis mengikuti bahan';});
 document.getElementById('stock-adjust-form').addEventListener('submit',e=>{e.preventDefault();const d=Object.fromEntries(new FormData(e.currentTarget)),x=stock.find(x=>x.code===d.material),qty=Number(d.qty),msg=document.getElementById('adjust-feedback');if(!x||qty<0){msg.textContent='Periksa bahan dan jumlah stok fisik.';return;}const delta=qty-x.qty;x.qty=qty;logs.push({time:new Date().toLocaleString('id-ID'),type:'Stok Opname',material:x.name,qty:`${delta>=0?'+':''}${fmt(delta)} ${x.unit} (fisik: ${fmt(qty)})`,order:'-',note:d.reason});save();render();msg.textContent=`Stok ${x.name} diperbarui menjadi ${fmt(qty)} ${x.unit}.`;msg.style.color='#27633b';e.currentTarget.reset();});
 document.getElementById('stock-search').addEventListener('input',render);document.getElementById('stock-filters').addEventListener('click',e=>{const b=e.target.closest('button[data-filter]');if(!b)return;document.querySelectorAll('#stock-filters button').forEach(x=>x.classList.toggle('active',x===b));render();});
 document.querySelectorAll('[data-open-stock-modal]').forEach(btn=>btn.addEventListener('click',()=>{const modal=document.getElementById(btn.dataset.openStockModal);modal?.classList.add('is-open');modal?.setAttribute('aria-hidden','false');document.body.classList.add('stock-modal-open');}));
 document.querySelectorAll('[data-close-stock-modal]').forEach(btn=>btn.addEventListener('click',()=>{const modal=btn.closest('.stock-modal');modal?.classList.remove('is-open');modal?.setAttribute('aria-hidden','true');document.body.classList.remove('stock-modal-open');}));
 document.addEventListener('keydown',e=>{if(e.key==='Escape'){document.querySelectorAll('.stock-modal.is-open').forEach(m=>{m.classList.remove('is-open');m.setAttribute('aria-hidden','true');});document.body.classList.remove('stock-modal-open');}});
 save();render();
});
</script>
@endsection
