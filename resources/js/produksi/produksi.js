(() => {
  const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
  const stages = ['Order Diterima','Persiapan/Pembelian Bahan','Cutting','Jahit/Bordir/Sablon','Finishing','QC','Packing','Selesai'];
  const esc = v => String(v ?? '-').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const api = async (url, options={}) => {
    const res = await fetch(url, { credentials:'same-origin', headers:{'Accept':'application/json','Content-Type':'application/json','X-CSRF-TOKEN':csrf,...(options.headers||{})}, ...options });
    const body = await res.json().catch(()=>({message:'Respons server tidak valid'}));
    if (!res.ok) throw new Error(body.message || `HTTP ${res.status}`);
    return body;
  };
  const date = v => v ? new Date(`${v}T00:00:00`).toLocaleDateString('id-ID',{day:'2-digit',month:'short',year:'numeric'}) : 'Belum ditentukan';
  const stageIndex = name => Math.max(0, stages.indexOf(name));
  const status = name => name === 'QC' ? 'Menunggu QC' : name === 'Packing' ? 'Siap Packing' : name === 'Selesai' ? 'Selesai' : 'Sedang Dikerjakan';
  const getQueue = async () => (await api('/api/antrian-produksi')).data || [];
  const row = o => {
    const id = o.pesanan_id;
    const st = o.tahap_saat_ini || 'Order Diterima';
    return `<tr><td><b class="order-code">${esc(o.kode_order)}</b></td><td><b>WO-${esc(id)}</b></td><td><b>${esc(o.produk)}</b><span class="subtext">${esc(o.customer)}</span></td><td>—</td><td>${Number(o.jumlah||0).toLocaleString('id-ID')} pcs</td><td>${date(o.deadline)}</td><td>${esc(st)}<span class="subtext">${esc(o.bahan||'')}</span></td><td><span class="produksi-status ${st==='QC'?'red':st==='Packing'||st==='Selesai'?'blue':''}">${status(st)}</span></td><td><a class="produksi-row-action" href="/produksi/proses?id=${encodeURIComponent(id)}&wo_id=${encodeURIComponent(o.work_order_id)}">Kelola</a></td></tr>`;
  };
  const showError = (target, message, colspan=9) => { if(target) target.innerHTML=`<tr><td colspan="${colspan}" class="produksi-empty">${esc(message)}</td></tr>`; };

  // Dashboard: data antrean berasal dari v_antrian_produksi.
  const dash = document.querySelector('[data-produksi-dashboard]');
  if (dash) (async()=>{
    const rows = document.getElementById('dashboard-antrian');
    try {
      const data = await getQueue();
      const active = data.filter(x=>x.tahap_saat_ini!=='Selesai');
      document.getElementById('metric-incoming').innerHTML=`${data.length}<small> Pesanan</small>`;
      document.getElementById('metric-working').innerHTML=`${data.filter(x=>!['Order Diterima','Persiapan/Pembelian Bahan','QC','Packing','Selesai'].includes(x.tahap_saat_ini)).length}<small> Pesanan</small>`;
      document.getElementById('metric-qc').innerHTML=`${data.filter(x=>x.tahap_saat_ini==='QC').length}<small> Pesanan</small>`;
      document.getElementById('metric-packing').innerHTML=`${data.filter(x=>x.tahap_saat_ini==='Packing').length}<small> Pesanan</small>`;
      rows.innerHTML=active.slice(0,6).map(row).join('') || '<tr><td colspan="9" class="produksi-empty">Belum ada Work Order yang diteruskan ke Produksi.</td></tr>';
      document.getElementById('dashboard-count').textContent=`${active.length} Work Order aktif dari database`;
      const alertBox=document.getElementById('produksi-alert');
      if(alertBox){
        try { const stock=(await api('/produksi/data/stok')).data||[]; const low=stock.filter(x=>Number(x.menipis)===1);
          alertBox.hidden=!low.length;
          document.getElementById('produksi-alert-text').textContent=low.length?`Stok perlu diperhatikan: ${low.map(x=>`${x.nama} (${x.stok_tersedia} ${x.satuan})`).join(', ')}.`:'';
        } catch { alertBox.hidden=true; }
      }
    } catch(e) { showError(rows,`Gagal memuat antrean: ${e.message}`); }
  })();

  // List Order: seluruh baris berasal dari endpoint antrian produksi yang sama.
  const list=document.querySelector('[data-produksi-order]');
  if(list) (async()=>{
    const tbody=document.getElementById('produksi-order-rows');
    let data=[];
    const search=document.getElementById('order-search');
    let filter='all';
    const render=()=>{
      const q=(search?.value||'').toLocaleLowerCase('id-ID');
      const filtered=data.filter(o=>{
        const hay=[o.kode_order,o.nomor_wo,o.produk,o.customer,o.tahap_saat_ini,o.bahan].join(' ').toLocaleLowerCase('id-ID');
        const s=o.tahap_saat_ini;
        return hay.includes(q) && (filter==='all'||filter==='ready'&&s==='Persiapan/Pembelian Bahan'||filter==='working'&&['Cutting','Jahit/Bordir/Sablon','Finishing'].includes(s)||filter==='qc'&&s==='QC'||filter==='done'&&s==='Selesai');
      });
      tbody.innerHTML=filtered.map(row).join('')||'<tr><td colspan="9" class="produksi-empty">Tidak ada Work Order sesuai filter.</td></tr>';
      document.getElementById('order-total').innerHTML=`${data.length}<small> Order</small>`;
      document.getElementById('order-working').innerHTML=`${data.filter(x=>['Cutting','Jahit/Bordir/Sablon','Finishing'].includes(x.tahap_saat_ini)).length}<small> Order</small>`;
      document.getElementById('order-revision').innerHTML=`${data.filter(x=>x.tahap_saat_ini==='QC').length}<small> Order</small>`;
      document.getElementById('order-ready').innerHTML=`${data.filter(x=>['Packing','Selesai'].includes(x.tahap_saat_ini)).length}<small> Order</small>`;
      document.getElementById('order-qty').textContent=`Total Qty: ${data.reduce((a,x)=>a+Number(x.jumlah||0),0).toLocaleString('id-ID')} pcs`;
      document.getElementById('order-pagination-info').textContent=`Menampilkan ${filtered.length} dari ${data.length} Work Order database`;
    };
    const load=async()=>{tbody.innerHTML='<tr><td colspan="9" class="produksi-empty">Memuat antrean database...</td></tr>';try{data=await getQueue();render();}catch(e){showError(tbody,e.message);}};
    search?.addEventListener('input',render);
    document.getElementById('order-filters')?.addEventListener('click',e=>{const b=e.target.closest('[data-filter]');if(!b)return;filter=b.dataset.filter;document.querySelectorAll('#order-filters button').forEach(x=>x.classList.toggle('active',x===b));render();});
    document.getElementById('produksi-refresh')?.addEventListener('click',load);
    await load();
  })();

  // Detail WO: membaca detail dan riwayat dari API, lalu menyimpan tahap/QC ke backend.
  const detail=document.querySelector('[data-produksi-detail]');
  if(detail) (async()=>{
    const id=new URLSearchParams(location.search).get('id');
    const feedback=document.getElementById('detail-feedback');
    const setmsg=t=>{if(feedback)feedback.textContent=t;};
    if(!id){setmsg('ID pesanan tidak ditemukan pada URL.');return;}
    let wo=null, currentStage='Order Diterima', stageOptions=[];
    try {
      const [detailRes, stageRes, historyRes] = await Promise.all([
        api(`/api/pesanan/${encodeURIComponent(id)}/work-order`),
        api('/api/tahap-produksi'),
        api(`/api/pesanan/${encodeURIComponent(id)}/riwayat-tahap`)
      ]);
      wo=detailRes.data; stageOptions=stageRes.data||[]; currentStage=wo.tahap_saat_ini||'Order Diterima';
      const history=historyRes.data||[];
      document.getElementById('detail-hero').innerHTML=`<div><h1>${esc(wo.kode_order||`Order #${id}`)} · ${esc(wo.jenis_produk)}</h1><p>${esc(wo.nomor_wo)} • ${esc(wo.customer)} • ${Number(wo.jumlah||0).toLocaleString('id-ID')} pcs • Deadline ${date(wo.deadline)}</p><span class="produksi-status">${esc(status(currentStage))}</span></div>`;
      document.getElementById('detail-order-number').textContent=wo.kode_order||id;
      document.getElementById('detail-date').textContent=`Deadline: ${date(wo.deadline)}`;
      document.getElementById('detail-wo-link').href='#';
      document.getElementById('detail-stage').textContent=currentStage;
      const select=document.getElementById('detail-stage-select');
      select.innerHTML=stageOptions.map(s=>`<option value="${esc(s.nama)}" ${s.nama===currentStage?'selected':''}>${esc(s.nama)}</option>`).join('');
      document.getElementById('detail-worker-display').textContent='Penanggung jawab tidak disimpan pada skema database saat ini';
      document.getElementById('detail-worker').closest('label')?.classList.add('hidden');
      document.getElementById('detail-worker').classList.add('hidden');
      document.getElementById('detail-note').value=wo.catatan_produksi||'';
      document.querySelector('.produksi-note').textContent='Perubahan tahap dan catatan disimpan ke database melalui API. Tahap Packing/Selesai mengikuti validasi QC pada database.';
      document.getElementById('detail-timeline').innerHTML=stageOptions.map((s,i)=>{const idx=stageOptions.findIndex(x=>x.nama===currentStage);return `<li class="${i<idx?'done':i===idx?'current':''}"><span class="timeline-number">${i<idx?'✓':i+1}</span><div><strong>${esc(s.nama)}</strong><small>${i<idx?'Selesai':i===idx?'Tahap saat ini':'Menunggu'}</small></div><em>${i<idx?'Selesai':i===idx?'Aktif':'Menunggu'}</em></li>`;}).join('');
      document.getElementById('timeline-count').textContent=`Tahap ${stageOptions.findIndex(x=>x.nama===currentStage)+1} dari ${stageOptions.length}`;
      document.getElementById('detail-qc').hidden=currentStage!=='QC';
      document.getElementById('detail-next').hidden=currentStage==='QC'||currentStage==='Selesai';
      document.getElementById('detail-next').textContent='Simpan Tahap Produksi';
      document.getElementById('detail-spec').innerHTML=[['Produk',wo.jenis_produk],['Pemesan',wo.customer],['Jumlah',`${wo.jumlah} pcs`],['Bahan',wo.bahan],['Warna',wo.warna],['Deadline',date(wo.deadline)],['Work Order',wo.nomor_wo],['Riwayat Tahap',`${history.length} catatan`]].map(x=>`<div class="produksi-spec-item"><small>${esc(x[0])}</small><strong>${esc(x[1])}</strong></div>`).join('');
      document.getElementById('detail-next').addEventListener('click',async()=>{
        try { const next=select.value; await api(`/api/pesanan/${encodeURIComponent(id)}/tahap`,{method:'POST',body:JSON.stringify({tahap:next,catatan:document.getElementById('detail-note').value})}); setmsg('Tahap produksi berhasil disimpan ke database.'); location.reload(); }
        catch(e){setmsg(e.message);}
      });
      document.getElementById('detail-qc-submit').addEventListener('click',async()=>{
        try { const result=document.getElementById('detail-qc-result').value; const payload={hasil:result,catatan:document.getElementById('detail-qc-note').value,kembali_ke_tahap:result==='REVISI'?document.getElementById('detail-qc-back').value:null}; await api(`/api/work-order/${encodeURIComponent(new URLSearchParams(location.search).get('wo_id')||id)}/qc`,{method:'POST',body:JSON.stringify(payload)}); setmsg('Hasil QC berhasil dicatat.'); location.reload(); }
        catch(e){setmsg(e.message);}
      });
    } catch(e) { document.getElementById('detail-hero').innerHTML=`<div class="produksi-loading">${esc(e.message)}</div>`; setmsg(e.message); }
  })();
})();
