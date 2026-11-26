document.addEventListener('DOMContentLoaded',()=>{
 const sidebar=document.getElementById('owner-sidebar'),toggle=document.getElementById('owner-sidebar-toggle'),shell=document.querySelector('.owner-shell'),header=document.querySelector('.owner-header');
 const key='presma-owner-sidebar-collapsed';
 const setCollapsed=v=>{sidebar?.classList.toggle('is-collapsed',v);shell?.classList.toggle('sidebar-collapsed',v);header?.classList.toggle('sidebar-collapsed',v);const a=document.getElementById('owner-sidebar-arrow');if(a)a.textContent=v?'chevron_right':'chevron_left';};
 let collapsed=window.matchMedia('(max-width:760px)').matches||localStorage.getItem(key)==='1';setCollapsed(collapsed);
 toggle?.addEventListener('click',()=>{collapsed=!sidebar.classList.contains('is-collapsed');if(!window.matchMedia('(max-width:760px)').matches)localStorage.setItem(key,collapsed?'1':'0');setCollapsed(collapsed);});
 document.getElementById('owner-mobile-menu')?.addEventListener('click',()=>{sidebar?.classList.toggle('mobile-open');});
 const dropdowns=[['owner-notif-toggle','owner-notif-menu'],['owner-profile-toggle','owner-profile-menu']];
 dropdowns.forEach(([bid,mid])=>{const b=document.getElementById(bid),m=document.getElementById(mid);b?.addEventListener('click',e=>{e.stopPropagation();document.querySelectorAll('.owner-dropdown').forEach(x=>{if(x!==m)x.classList.add('hidden')});m?.classList.toggle('hidden');});});
 document.addEventListener('click',e=>{if(!e.target.closest('.owner-dropdown-wrap'))document.querySelectorAll('.owner-dropdown').forEach(x=>x.classList.add('hidden'));});
 // Shared table search and status filters
 const table=document.getElementById('owner-data-table'),search=document.getElementById('owner-search');
 let activeFilter='all';
 const applyFilters=()=>{if(!table)return;let count=0;const q=(search?.value||'').toLocaleLowerCase('id-ID');[...table.tBodies[0].rows].forEach(row=>{const state=(row.dataset.state||'').split(/\s+/);const okState=activeFilter==='all'||state.includes(activeFilter);const okText=row.innerText.toLocaleLowerCase('id-ID').includes(q);row.hidden=!(okState&&okText);if(!row.hidden)count++;});const c=document.getElementById('owner-table-count');if(c)c.textContent=`Menampilkan ${count} data sesuai pencarian/filter`;};
 search?.addEventListener('input',applyFilters);
 document.querySelectorAll('[data-filters] .owner-filter').forEach(btn=>btn.addEventListener('click',()=>{btn.parentElement.querySelectorAll('.owner-filter').forEach(x=>x.classList.remove('active'));btn.classList.add('active');activeFilter=btn.dataset.filter;applyFilters();}));
 // Detail modal
 const detailModal=document.getElementById('owner-detail-modal');
 document.querySelectorAll('.owner-detail').forEach(btn=>btn.addEventListener('click',()=>{const row=btn.closest('tr');const target=document.getElementById('owner-detail-content');if(target)target.innerHTML='<b>'+row.cells[0].innerText+'</b><br><br>'+row.innerText.replace(/\n/g,' · ');detailModal?.classList.add('open');}));
 document.querySelectorAll('[data-open-modal]').forEach(btn=>btn.addEventListener('click',()=>document.getElementById(btn.dataset.openModal)?.classList.add('open')));
 document.querySelectorAll('[data-close-modal]').forEach(btn=>btn.addEventListener('click',()=>btn.closest('.owner-modal')?.classList.remove('open')));
 document.addEventListener('keydown',e=>{if(e.key==='Escape')document.querySelectorAll('.owner-modal.open').forEach(x=>x.classList.remove('open'));});
 document.querySelectorAll('[data-demo-form]').forEach(form=>form.addEventListener('submit',e=>{e.preventDefault();alert('Data berhasil dicatat untuk simulasi tampilan. Data belum disimpan ke database.');form.closest('.owner-modal')?.classList.remove('open');form.reset();}));
 document.querySelectorAll('.owner-approve,.owner-reject').forEach(btn=>btn.addEventListener('click',()=>{const row=btn.closest('tr'),status=row.querySelector('[data-purchase-status]');const approved=btn.classList.contains('owner-approve');status.textContent=approved?'Disetujui':'Ditolak';status.className='owner-badge '+(approved?'green':'red');row.querySelectorAll('button').forEach(b=>b.disabled=true);row.querySelector('td:last-child').textContent=approved?'Disetujui Owner':'Ditolak Owner';}));
 // Settings demo
 document.querySelector('[data-settings-form]')?.addEventListener('submit',e=>{e.preventDefault();localStorage.setItem('presma-owner-settings-demo',JSON.stringify(Object.fromEntries(new FormData(e.currentTarget))));document.getElementById('owner-settings-feedback').textContent='Pengaturan demo berhasil disimpan di browser.';});
 // Notifications read state
 const notifKey='presma-owner-notif-read',read=new Set(JSON.parse(localStorage.getItem(notifKey)||'[]'));
 const renderNotifs=()=>{document.querySelectorAll('[data-notif]').forEach(n=>{const done=read.has(n.dataset.notif);n.classList.toggle('unread',!done);const b=n.querySelector('[data-read]');if(b)b.hidden=done;});const c=document.getElementById('owner-unread-count');if(c)c.textContent=`${document.querySelectorAll('[data-notif].unread').length} belum dibaca`;};
 document.querySelectorAll('[data-read]').forEach(b=>b.addEventListener('click',()=>{read.add(b.closest('[data-notif]').dataset.notif);localStorage.setItem(notifKey,JSON.stringify([...read]));renderNotifs();}));
 document.getElementById('owner-mark-all-read')?.addEventListener('click',()=>{document.querySelectorAll('[data-notif]').forEach(n=>read.add(n.dataset.notif));localStorage.setItem(notifKey,JSON.stringify([...read]));renderNotifs();});renderNotifs();
 // Export reports as a compact CSV
 document.getElementById('owner-report-export')?.addEventListener('click',()=>{const rows=[['Laporan','Nilai'],['Total Produksi','28 SPK'],['Omzet','Rp 184.500.000'],['Efisiensi Produksi','96,4%'],['Ketepatan Deadline','88,5%'],['Pemasukan','Rp 186.400.000'],['Pengeluaran','Rp 104.300.000']];const csv=rows.map(r=>r.map(x=>'"'+x+'"').join(',')).join('\r\n');const blob=new Blob(['\ufeff'+csv],{type:'text/csv;charset=utf-8'});const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='laporan-owner-presma-demo.csv';a.click();URL.revokeObjectURL(a.href);});
});

 // Show/hide password fields on the settings page
 document.querySelectorAll('[data-toggle-password]').forEach(button=>{
   button.addEventListener('click',()=>{
     const input=document.getElementById(button.dataset.togglePassword);
     if(!input)return;
     const visible=input.type==='password';
     input.type=visible?'text':'password';
     const icon=button.querySelector('.material-symbols-outlined');
     if(icon)icon.textContent=visible?'visibility_off':'visibility';
     button.setAttribute('aria-label',visible?'Sembunyikan password':'Tampilkan password');
   });
 });

// Demo-only employee actions: explicit feedback, no database mutation.
document.addEventListener('DOMContentLoaded',()=>{
 document.querySelector('[data-employee-demo-form]')?.addEventListener('submit',e=>{e.preventDefault();const d=new FormData(e.currentTarget);if(d.get('password')!==d.get('password_confirmation')){alert('Konfirmasi password tidak sama.');return;}alert('Validasi form berhasil. Akun belum dibuat karena backend belum diintegrasikan.');e.currentTarget.reset();});
 document.querySelectorAll('[data-demo-employee-action]').forEach(b=>b.addEventListener('click',()=>alert('Aksi ini merupakan pratinjau. Status dan akun belum diubah di database.')));
 document.querySelectorAll('[data-toggle-password]').forEach(button=>button.addEventListener('click',()=>{const input=document.getElementById(button.dataset.togglePassword);if(input)input.type=input.type==='password'?'text':'password';}));
});
