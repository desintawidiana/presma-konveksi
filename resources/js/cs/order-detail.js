// PRESMA CS detail: workflow simulasi saja; tidak ada penulisan database/API.
const initCsOrderDetailV4 = () => {
    const page = document.querySelector('.cs-order-detail-page');
    if (!page) return;
    const params = new URLSearchParams(window.location.search);
    const code = params.get('code') || 'ORD-2024-0330';
    const isExample = code === 'ORD-2024-0330';
    const key = 'presma.cs.order.' + code;
    const defaultSizes = { S: 45, M: 120, L: 110, XL: 50, '2XL': 15, '3XL': 10 };
    const base = isExample ? {
        code, customer: 'Farhan Saputra', phone: '0812-2891-7890', organization: 'BEM Fakultas Teknik UGM', product: 'Korsa PDH Nagata Drill',
        fabric: 'Nagata Drill Grade A Original', color: 'Khaki Sand kombinasi Navy Tua', quantity: 350,
        date: '24 Okt 2024', owner: 'Abiyyu', status: 'Menunggu Verifikasi CS', payment: 'DP 50% Masuk', amount: 'Rp 50.175.000',
        stage: 'verification', paymentCode: 'dp', notes: '', sizes: defaultSizes, deadline: '2024-11-05'
    } : { code, customer: '', phone: '', organization: '', product: '', fabric: '', color: '', quantity: 0, date: '', owner: '', status: 'Menunggu Verifikasi CS', payment: '', amount: '', stage: 'verification', notes: '', deadline: '', sizes: null };
    let record = { ...base };
    try { const stored = JSON.parse(sessionStorage.getItem(key) || 'null'); if (stored && typeof stored === 'object') record = { ...base, ...stored }; } catch (e) { }
    if (!record.code) record.code = code;
    if (!record.workflowStage) { record.workflowStage = record.verifiedAt ? 'payment' : record.stage === 'ready' ? 'ready' : record.stage === 'production' ? 'tracking' : 'verification'; }
    const el = id => page.querySelector('#' + id);
    const setText = (id, value) => { if (el(id)) el(id).textContent = String(value ?? '-'); };
    const notify = (message) => { const n = el('csDetailNotice'); if (!n) return; n.textContent = message; n.classList.remove('hidden'); };
    const persist = () => { try { sessionStorage.setItem(key, JSON.stringify(record)); } catch (e) { notify('Penyimpanan browser diblokir. Perubahan hanya berlaku selama halaman ini terbuka.'); } };
    const number = (val) => Math.max(0, Number(val) || 0);
    const sanitize = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const qtyTotal = sizes => sizes ? Object.values(sizes).reduce((n, v) => n + number(v), 0) : 0;
    const resolveStage = () => {
        if (record.status === 'Perlu Revisi Pelanggan' || record.status === 'Perlu Verifikasi Ulang CS') return 'verification';
        return record.workflowStage || (record.verifiedAt ? 'payment' : (record.stage === 'ready' ? 'ready' : record.stage === 'production' ? 'tracking' : 'verification'));
    };
    const actionLabel = () => ({ verification: 'Verifikasi', payment: 'Pembayaran / Tanpa DP', wo: 'Upload WO', tracking: 'Tracking Produksi', settlement: 'Pembayaran / Pelunasan', ready: 'Siap Kirim', handover: 'Selesai', completed: 'Selesai' })[resolveStage()] || 'Verifikasi';
    const updateActions = () => {
        const stage = resolveStage();
        el('csOpenVerify')?.classList.toggle('hidden', stage !== 'verification');
        el('csNextAction')?.classList.toggle('hidden', stage === 'verification' || stage === 'completed');
        setText('csNextActionText', actionLabel());
    };
    const humanDeadline = raw => {
        if (!raw) return 'Belum ditentukan';
        const date = /^\d{4}-\d{2}-\d{2}$/.test(raw) ? new Date(raw + 'T12:00:00') : null;
        return date && !Number.isNaN(date.getTime()) ? date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : String(raw);
    };
    const editedLabels = {
        identity: { customer: 'Nama pemesan', phone: 'No. WhatsApp', organization: 'Instansi', source: 'Sumber informasi' },
        specification: { product: 'Jenis produk', fabric: 'Bahan kain', color: 'Warna produk', cutting: 'Model / cutting', category: 'Kategori', quantity: 'Kuantitas', deadline: 'Target deadline' },
        embroidery: { embroidery: 'Detail bordir / sablon', merchandise: 'Merchandise', notes: 'Catatan pelanggan / CS' },
        sizes: { quantity: 'Total kuantitas', sizeFileUrl: 'Excel nama & ukuran' },
        attachments: { designUrl: 'Tautan berkas desain', address: 'Alamat pengiriman' }
    };
    const renderChanges = () => {
        Object.entries(editedLabels).forEach(([section, labels]) => {
            const box = page.querySelector(`[data-cs-changes="${section}"]`);
            if (!box) return;
            const changed = (record.editedFields || []).filter(k => Object.prototype.hasOwnProperty.call(labels, k));
            if (section === 'sizes' && (record.editedFields || []).some(k => k === 'sizes')) changed.push('sizes');
            box.classList.toggle('hidden', !changed.length);
            box.replaceChildren();
            if (!changed.length) return;
            const head = document.createElement('strong'); head.textContent = 'Data terbaru setelah perubahan CS'; box.append(head);
            changed.forEach(k => {
                const item = document.createElement('div');
                const lbl = document.createElement('span'); lbl.textContent = (labels[k] || 'Distribusi ukuran') + ': ';
                const val = document.createElement('b'); val.textContent = k === 'sizes' ? sizeKeys.map(size => `${size} ${number(record.sizes?.[size])}`).join(' • ') : k === 'deadline' ? humanDeadline(record[k]) : String(record[k] || 'Belum diisi');
                item.append(lbl, val); box.append(item);
            });
        });
    };
    const updateStatus = () => {
        const status = record.status || 'Belum diverifikasi';
        setText('csWorkflowStatus', 'Status: ' + status + '. ' + (record.revisionReason ? 'Catatan: ' + record.revisionReason + '. ' : '') + 'Mode pratinjau frontend, belum tersimpan ke backend.');
    };
    const render = () => {
        if (isExample) {
            el('csExampleOrder')?.classList.remove('hidden'); el('csDynamicOrder')?.classList.add('hidden');
            const top = el('csExampleOrder')?.querySelector('section:first-child');
            if (top) { const pill = top.querySelector('span.rounded-full'); if (pill) pill.textContent = record.status; const summary = top.querySelector('p'); if (summary) summary.textContent = `${record.customer} • ${record.organization} • ${record.product}, ${record.quantity} pcs`; }
            const form = el('csExampleOrder')?.querySelector('section:nth-child(2)');
            if (form) {
                const headings = ['Nama Lengkap Pemesan:', 'No. WhatsApp / HP:', 'Instansi / Kampus / Sekolah:', 'Jenis Produk:', 'Bahan Baku Kain:', 'Warna Produk:'];
                const values = [record.customer, record.phone, record.organization, record.product, record.fabric, record.color];
                headings.forEach((heading, i) => {
                    const node = Array.from(form.querySelectorAll('span')).find(s => s.textContent.trim() === heading);
                    const value = node?.parentElement?.querySelector('strong'); if (value) value.textContent = values[i] || 'Belum ada data';
                });
                if (record.sizes) {
                    const block = Array.from(form.querySelectorAll('div')).find(d => d.querySelector(':scope > span')?.textContent?.trim() === 'S' && d.querySelector('span.text-lg'));
                    const sizeGrid = block?.parentElement;
                    if (sizeGrid) {
                        ['S', 'M', 'L', 'XL', '2XL', '3XL'].forEach((size, i) => {
                            const box = sizeGrid.children[i]; const numberEl = box?.querySelector('.text-lg'); if (numberEl) numberEl.textContent = String(number(record.sizes[size]));
                        });
                    }
                    const totalBadge = Array.from(form.querySelectorAll('span')).find(s => s.textContent.trim().startsWith('Total:') && s.textContent.includes('Pcs'));
                    if (totalBadge) totalBadge.textContent = `Total: ${qtyTotal(record.sizes)} Pcs`;
                }
            }
        } else {
            el('csExampleOrder')?.classList.add('hidden'); el('csDynamicOrder')?.classList.remove('hidden');
            [['genericCode', code], ['genericCustomer', record.customer || 'Data pelanggan belum tersedia'], ['genericProduct', record.product], ['genericOrg', record.organization], ['genericDate', record.date], ['genericOwner', record.owner], ['genericStage', record.status], ['genericPayment', record.payment], ['genericAmount', record.amount]].forEach(([id, v]) => setText(id, v));
            setText('genericNote', record.notes || 'Rincian ukuran, kain, bordir dan lampiran belum tersedia untuk pesanan ini. CS dapat melengkapi data melalui tombol Edit Pesanan.');
        }
        if (!isExample) el('csOpenSizes')?.classList.add('hidden');
        el('csOpenEdit')?.classList.toggle('hidden', isExample);
        setText('csDetailDeadline', humanDeadline(record.deadline));
        setText('genericDeadline', humanDeadline(record.deadline));
        renderChanges();
        [['csExtraSource', 'source'], ['csExtraCutting', 'cutting'], ['csExtraEmbroidery', 'embroidery'], ['csExtraMerchandise', 'merchandise'], ['csExtraAddress', 'address'], ['csExtraDeadline', 'deadline'], ['csExtraWo', 'woNumber'], ['csExtraTracking', 'trackingProgress'], ['csExtraNotes', 'notes']].forEach(([id, k]) => setText(id, record[k] || 'Belum diisi'));
        [['Design', 'designUrl'], ['Size', 'sizeFileUrl']].forEach(([suffix, k]) => {
            const link = el('csExtra' + suffix + 'Link'); const missing = el('csExtraNo' + suffix);
            const value = String(record[k] || '').trim();
            const valid = /^https:\/\//i.test(value);
            if (link) { link.hidden = !valid; if (valid) link.href = value; else link.removeAttribute('href'); }
            if (missing) missing.hidden = valid;
        });
        updateActions(); updateStatus(); document.title = 'Detail ' + code + ' | Presma Operations';
    };
    const modals = ['csStageModal', 'csEditOrderModal', 'csRevisionModal', 'csVerifyModal', 'csSizesModal', 'csDetailPreviewModal'];
    const open = id => { el(id)?.classList.remove('hidden'); document.body.style.overflow = 'hidden'; };
    const close = () => { modals.forEach(id => el(id)?.classList.add('hidden')); document.body.style.overflow = ''; };
    modals.forEach(id => el(id)?.addEventListener('click', e => { if (e.target === el(id)) close(); }));
    page.querySelectorAll('[data-workflow-close]').forEach(b => b.addEventListener('click', close));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
    const editForm = el('csEditOrderForm');
    const sizeKeys = ['S', 'M', 'L', 'XL', '2XL', '3XL'];
    const sizeName = (s) => 'size' + s;
    const updateEditSum = () => {
        if (!editForm || !record.sizes) return;
        const sum = sizeKeys.reduce((n, k) => n + number(editForm.elements[sizeName(k)].value), 0);
        setText('csEditSizeTotal', `Total rincian ukuran: ${sum} pcs | Kuantitas order: ${editForm.elements.quantity.value || 0} pcs`);
    };
    const editGroups = {
        identity: ['customer', 'phone', 'organization', 'source'],
        specification: ['product', 'fabric', 'color', 'cutting', 'category', 'quantity', 'deadline'],
        embroidery: ['embroidery', 'merchandise', 'notes'],
        sizes: ['quantity', 'sizeFileUrl'],
        attachments: ['designUrl', 'address'],
        all: ['customer', 'phone', 'organization', 'product', 'fabric', 'color', 'deadline', 'quantity', 'notes', 'category', 'owner', 'source', 'cutting', 'embroidery', 'merchandise', 'address', 'designUrl', 'sizeFileUrl']
    };
    const sectionTitles = { identity: '1. Identitas & Kontak Pemesan', specification: '2. Spesifikasi Produk, Kain & Warna', embroidery: '3. Bordir, Merchandise & Catatan', sizes: '4. Distribusi Ukuran', attachments: '5. Berkas Desain & Lampiran', all: 'Edit Pesanan' };
    let activeEditSection = 'all';
    const openSectionEdit = section => {
        activeEditSection = editGroups[section] ? section : 'all';
        const allowed = new Set(editGroups[activeEditSection]);
        const selected = editForm.querySelectorAll('.cs-edit-fields label');
        selected.forEach(label => {
            const input = label.querySelector('input,textarea,select');
            const visible = allowed.has(input?.name);
            label.hidden = !visible;
            if (input) { input.disabled = !visible; input.required = visible && (input.name === 'customer' || input.name === 'product' || input.name === 'quantity'); }
        });
        const noteLabel = editForm.elements.notes?.closest('label');
        if (noteLabel && !noteLabel.closest('.cs-edit-fields')) {
            noteLabel.hidden = !allowed.has('notes');
            editForm.elements.notes.disabled = !allowed.has('notes');
        }
        const sizesGroup = el('csEditSizesGroup');
        sizesGroup.hidden = activeEditSection !== 'sizes' || !record.sizes;
        sizesGroup.querySelectorAll('input').forEach(input => input.disabled = sizesGroup.hidden);
        editGroups.all.forEach(k => { if (editForm.elements[k]) editForm.elements[k].value = record[k] ?? ''; });
        if (record.sizes) sizeKeys.forEach(k => { editForm.elements[sizeName(k)].value = number(record.sizes[k]); });
        setText('csEditTitle', 'Edit ' + sectionTitles[activeEditSection]);
        setText('csEditContext', 'Perubahan di bagian ini akan memperbarui hasil form pelanggan. Setelah disimpan, order yang sudah difiksasi memerlukan verifikasi ulang.');
        updateEditSum(); open('csEditOrderModal');
    };
    el('csOpenEdit')?.addEventListener('click', () => openSectionEdit('all'));
    page.querySelectorAll('[data-cs-edit-section]').forEach(button => button.addEventListener('click', () => openSectionEdit(button.dataset.csEditSection)));
    editForm?.addEventListener('input', updateEditSum);
    editForm?.addEventListener('submit', e => {
        e.preventDefault(); if (!editForm.reportValidity()) return;
        const update = {};
        editGroups[activeEditSection].forEach(k => {
            if (!editForm.elements[k]) return;
            update[k] = k === 'quantity' ? number(editForm.elements[k].value) : editForm.elements[k].value.trim();
        });
        if ('quantity' in update && (!Number.isInteger(update.quantity) || update.quantity < 1)) return notify('Jumlah pesanan harus bilangan bulat minimal 1 pcs.');
        if (activeEditSection === 'sizes' && record.sizes) {
            const sizes = Object.fromEntries(sizeKeys.map(k => [k, number(editForm.elements[sizeName(k)].value)]));
            if (sizeKeys.some(k => !Number.isInteger(sizes[k]))) return notify('Jumlah setiap ukuran harus bilangan bulat.');
            if (qtyTotal(sizes) !== (update.quantity ?? record.quantity)) return notify('Jumlah seluruh ukuran harus sesuai kuantitas pesanan.');
            update.sizes = sizes;
        }
        if (activeEditSection === 'specification' && record.sizes && 'quantity' in update && update.quantity !== qtyTotal(record.sizes)) return notify('Jumlah pesanan harus sama dengan rekap ukuran. Untuk mengubah kuantitas, perbarui melalui Edit Distribusi Ukuran.');
        const changed = Object.keys(update).filter(k => JSON.stringify(update[k]) !== JSON.stringify(record[k]));
        if (!changed.length) { close(); return notify('Tidak ada perubahan data.'); }
        Object.assign(record, update);
        record.editedFields = [...new Set([...(record.editedFields || []), ...changed])];
        record.lastEditedAt = new Date().toISOString();
        if (record.verifiedAt) { record.status = 'Perlu Verifikasi Ulang CS'; record.workflowStage = 'verification'; record.verifiedAt = null; record.paymentApprovedAt = null; record.woIssuedAt = null; }
        persist(); close(); render(); notify('Perubahan bagian ' + sectionTitles[activeEditSection] + ' disimpan di sesi browser. Belum masuk database.');
    });
    const revisionForm = el('csRevisionForm');
    const revisionMessage = () => `Halo Kak ${record.customer || 'Pelanggan'}, terkait pesanan ${code}, mohon bantu konfirmasi: ${revisionForm.elements.reason.value.trim()}. Terima kasih, CS Presma Konveksi.`;
    el('csOpenRevision')?.addEventListener('click', () => { revisionForm.elements.reason.value = record.revisionReason || ''; open('csRevisionModal'); });
    revisionForm?.addEventListener('submit', e => { e.preventDefault(); if (!revisionForm.reportValidity()) return; record.revisionReason = revisionForm.elements.reason.value.trim(); record.status = 'Perlu Revisi Pelanggan'; record.stage = 'verification'; record.workflowStage = 'verification'; record.verifiedAt = null; persist(); close(); render(); notify('Pesanan ditandai perlu revisi. Hubungi pelanggan menggunakan draft pesan, tidak ada pesan dikirim otomatis.'); });
    el('csCopyRevision')?.addEventListener('click', async () => {
        const message = revisionMessage(); if (!revisionForm.elements.reason.value.trim()) return notify('Isi catatan revisi sebelum menyalin pesan.');
        try { await navigator.clipboard.writeText(message); notify('Draft pesan disalin. Tempel ke WhatsApp pelanggan setelah nomor dikonfirmasi.'); }
        catch (e) { notify('Browser tidak mengizinkan penyalinan otomatis. Salin catatan secara manual.'); }
    });
    el('csOpenVerify')?.addEventListener('click', () => { el('csVerifyCheck').checked = false; el('csConfirmVerify').disabled = true; open('csVerifyModal'); });
    el('csVerifyCheck')?.addEventListener('change', e => el('csConfirmVerify').disabled = !e.target.checked);
    el('csConfirmVerify')?.addEventListener('click', () => {
        if (!el('csVerifyCheck').checked) return;
        record.status = 'Terverifikasi / Fiksasi CS'; record.stage = 'verification'; record.workflowStage = 'payment'; record.revisionReason = ''; record.verifiedAt = new Date().toISOString(); persist(); close(); render(); notify('Pesanan difiksasi dalam pratinjau. Tahap berikutnya: Pembayaran / pengecualian DP.');
    });
    const stageForm = el('csStageForm');
    const stageTitle = el('csStageTitle');
    const paymentChoice = el('csPaymentChoice');
    const paymentOptions = () => {
        const without = paymentChoice?.value === 'without_dp';
        el('csPoReasonLabel')?.classList.toggle('hidden', !without);
        el('csDpReferenceLabel')?.classList.toggle('hidden', without);
        if (stageForm) { stageForm.elements.poReason.required = without; stageForm.elements.dpAmount.required = !without; }
    };
    paymentChoice?.addEventListener('change', paymentOptions);
    el('csNextAction')?.addEventListener('click', () => {
        const stage = resolveStage();
        if (stage === 'completed') return;
        if (stage === 'tracking') {
            stageTitle.textContent = 'Update Tracking Produksi';
        } else stageTitle.textContent = actionLabel();
        stageForm.reset();
        el('csPaymentSection')?.classList.toggle('hidden', stage !== 'payment');
        el('csWoSection')?.classList.toggle('hidden', stage !== 'wo');
        el('csTrackingSection')?.classList.toggle('hidden', stage !== 'tracking');
        el('csSettlementSection')?.classList.toggle('hidden', stage !== 'settlement');
        el('csReadySection')?.classList.toggle('hidden', stage !== 'ready');
        el('csHandoverSection')?.classList.toggle('hidden', stage !== 'handover');
        if (stage === 'payment') paymentOptions();
        el('csStageDescription').textContent = { payment: 'Validasi DP atau catat persetujuan pengecualian DP sebelum membuat WO.', wo: 'Catat nomor WO dan PIC produksi sebelum mengalihkan order ke tracking.', tracking: 'Catat progres produksi. Hanya QC selesai yang mengalihkan ke tahap pelunasan.', settlement: 'Validasi sisa tagihan, atau pembayaran penuh untuk pesanan tanpa DP, sebelum siap kirim.', ready: 'Konfirmasi pesanan siap kirim dengan ekspedisi atau metode pengambilan.', handover: 'Konfirmasi barang telah diserahkan/diterima agar order dapat ditutup.', completed: 'Order telah selesai.' }[stage] || 'Konfirmasi tahap berikutnya.';
        el('csStageSubmit').textContent = stage === 'tracking' ? 'Simpan Update Tracking' : stage === 'ready' ? 'Konfirmasi Siap Kirim' : stage === 'handover' ? 'Tandai Selesai' : 'Konfirmasi Tahap';
        open('csStageModal');
    });
    stageForm?.addEventListener('submit', e => {
        e.preventDefault(); const stage = resolveStage();
        if (stage === 'payment') {
            if (paymentChoice.value === 'without_dp') {
                const reason = stageForm.elements.poReason.value.trim();
                if (reason.length < 8) return notify('Isi nomor PO/alasan dan persetujuan khusus minimal 8 karakter.');
                record.dpExceptionReason = reason; record.dpAmount = 0; record.payment = 'Tanpa DP (Persetujuan Khusus)'; record.paymentCode = 'without_dp';
            } else {
                const amount = Number(stageForm.elements.dpAmount.value);
                if (!Number.isFinite(amount) || amount <= 0) return notify('Masukkan nominal DP yang telah diverifikasi.');
                record.dpAmount = amount; record.payment = 'DP Diterima'; record.paymentCode = 'dp'; record.dpExceptionReason = '';
            }
            record.paymentApprovedAt = new Date().toISOString(); record.workflowStage = 'wo'; record.status = 'Menunggu Upload WO'; record.stage = 'verification';
        } else if (stage === 'wo') {
            const wo = stageForm.elements.woNumber.value.trim(); const des = stageForm.elements.designer.value.trim();
            if (!wo || !des) return notify('Nomor WO dan PIC produksi wajib diisi.');
            record.woNumber = wo; record.designer = des; record.woIssuedAt = new Date().toISOString(); record.workflowStage = 'tracking'; record.stage = 'production'; record.status = 'Produksi Berjalan';
        } else if (stage === 'tracking') {
            record.trackingProgress = stageForm.elements.trackingProgress.value; record.trackingNote = stageForm.elements.trackingNote.value.trim();
            record.status = 'Produksi: ' + record.trackingProgress;
            if (record.trackingProgress === 'Siap Kirim (QC Selesai)') {
                record.workflowStage = 'settlement'; record.stage = 'production'; record.status = 'QC Selesai - Menunggu Pelunasan';
            }
        } else if (stage === 'settlement') {
            const value = Number(stageForm.elements.settlementAmount.value);
            const reference = stageForm.elements.settlementReference.value.trim();
            if (!Number.isFinite(value) || value <= 0) return notify('Masukkan nominal pembayaran akhir lebih dari Rp0.');
            if (reference.length < 3) return notify('Isi nomor referensi atau bukti pembayaran akhir.');
            // Jika nominal kontrak numerik tersedia, jangan izinkan pelunasan lebih kecil dari sisa tagihan.
            const total = Number(record.totalAmount || 0);
            const remainder = total > 0 ? Math.max(0, total - number(record.dpAmount)) : null;
            if (remainder !== null && value < remainder) return notify('Pembayaran akhir kurang dari sisa tagihan Rp' + remainder.toLocaleString('id-ID') + '.');
            record.settlementAmount = value; record.settlementReference = reference;
            record.settledAt = new Date().toISOString(); record.payment = 'Lunas'; record.paymentCode = 'paid';
            record.workflowStage = 'ready'; record.stage = 'ready'; record.status = 'Lunas - Menunggu Siap Kirim';
        } else if (stage === 'ready') {
            const method = stageForm.elements.deliveryMethod.value;
            const note = stageForm.elements.deliveryNote.value.trim();
            if (!method || note.length < 3) return notify('Pilih metode pengiriman dan isi referensi/keterangan pengiriman.');
            record.deliveryMethod = method; record.deliveryNote = note;
            record.readyAt = new Date().toISOString(); record.workflowStage = 'handover'; record.stage = 'ready'; record.status = 'Siap Kirim';
        } else if (stage === 'handover') {
            const ref = stageForm.elements.handoverReference.value.trim();
            if (ref.length < 3) return notify('Isi bukti/resi penyerahan barang sebelum menutup order.');
            record.handoverReference = ref; record.completedAt = new Date().toISOString();
            record.workflowStage = 'completed'; record.status = 'Selesai & Diserahkan'; record.stage = 'ready';
        }
        record.lastWorkflowAt = new Date().toISOString(); persist(); close(); render(); notify('Status ' + code + ' diperbarui di sesi pratinjau. Belum dikirim ke backend.');
    });
    const renderSizes = () => {
        const body = el('csSizeRows'); if (!body || !record.sizes) return;
        body.innerHTML = sizeKeys.map(k => `<tr><td>${sanitize(k)}</td><td>${number(record.sizes[k])}</td><td>${['2XL', '3XL'].includes(k) ? 'Jumbo' : 'Standar'}</td></tr>`).join('');
        setText('csSizeGrand', qtyTotal(record.sizes));
    };
    el('csOpenSizes')?.addEventListener('click', () => { if (!record.sizes) return notify('Distribusi ukuran order ini belum tersedia.'); renderSizes(); open('csSizesModal'); });
    el('csDownloadSizes')?.addEventListener('click', () => {
        if (!record.sizes) return;
        const lines = [['Kode Order', code], ['Pelanggan', record.customer], ['Produk', record.product], [], ['Ukuran', 'Jumlah (pcs)', 'Kategori'], ...sizeKeys.map(k => [k, String(number(record.sizes[k])), ['2XL', '3XL'].includes(k) ? 'Jumbo' : 'Standar']), ['TOTAL', String(qtyTotal(record.sizes)), '']];
        const csv = lines.map(row => row.map(v => '"' + String(v ?? '').replace(/"/g, '""') + '"').join(';')).join('\r\n');
        const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' }); const url = URL.createObjectURL(blob); const a = document.createElement('a'); a.href = url; a.download = 'detail-ukuran-' + code + '.csv'; document.body.appendChild(a); a.click(); a.remove(); setTimeout(() => URL.revokeObjectURL(url), 1000);
    });

    // Cetak hanya brief lengkap desainer, bukan dashboard/sidebar/modal CS.
    // Browser menyediakan pilihan "Save as PDF"; tidak diperlukan akun desainer.
    const printDesignerBrief = () => {
        const safe = sanitize;
        const validUrl = (value) => {
            try { const u = new URL(String(value || '')); return ['https:', 'http:'].includes(u.protocol) && !/1aBcDeFgHiJkLmNoP|contoh|example/i.test(u.href) ? u.href : null; }
            catch { return null; }
        };
        const detailSections = [
            ['1. Identitas & Kontak Pemesan', 'identity'],
            ['2. Spesifikasi Produk, Kain & Warna', 'specification'],
            ['3. Detail Bordir & Merchandise', 'embroidery'],
            ['4. Distribusi Ukuran', 'sizes'],
            ['5. Berkas Desain & Lampiran', 'attachments']
        ];
        const groups = {
            identity: [['customer', 'Nama pemesan'], ['phone', 'Nomor WhatsApp'], ['organization', 'Instansi'], ['source', 'Sumber informasi']],
            specification: [['product', 'Produk'], ['category', 'Kategori'], ['fabric', 'Bahan'], ['color', 'Warna'], ['cutting', 'Model / cutting'], ['quantity', 'Kuantitas'], ['deadline', 'Deadline']],
            embroidery: [['embroidery', 'Bordir / sablon'], ['merchandise', 'Merchandise'], ['notes', 'Catatan khusus']],
            sizes: [['sizeFileUrl', 'Excel nama dan ukuran']],
            attachments: [['designUrl', 'Link desain'], ['address', 'Alamat pengiriman']]
        };
        const edited = new Set(record.editedFields || []);
        const valueHtml = (key) => {
            const val = record[key]; if (val === null || val === undefined || String(val).trim() === '') return '';
            if (key === 'deadline') return safe(humanDeadline(val));
            const url = validUrl(val);
            if (url && (key === 'designUrl' || key === 'sizeFileUrl')) return `<a href="${safe(url)}" target="_blank" rel="noopener">${safe(url)}</a>`;
            return safe(val);
        };
        const rowsFor = group => (groups[group] || []).filter(([key]) => valueHtml(key) && (edited.has(key) || (groups[group] || []).some(([k]) => edited.has(k)))).map(([key, label]) => `<tr><th>${safe(label)}</th><td>${valueHtml(key)}</td></tr>`).join('');
        const sectionCards = Array.from(page.querySelectorAll('#csExampleOrder .cs-form-changes'));
        const cardFor = (group) => {
            const changes = page.querySelector(`[data-cs-changes="${group}"]`);
            const card = changes?.parentElement;
            if (!card) return '';
            const clone = card.cloneNode(true);
            clone.querySelectorAll('button,.cs-form-changes,.material-symbols-outlined,.cs-size-toolbar,.cs-section-edit,[data-detail-action]').forEach(node => node.remove());
            // Teks lama pada kartu yang memang sudah diedit tidak boleh dianggap data terbaru.
            // Detail contoh tetap dilampirkan untuk field yang belum diubah.
            const labels = { identity: ['customer', 'phone', 'organization', 'source'], specification: ['product', 'fabric', 'color', 'quantity', 'cutting', 'category', 'deadline'], embroidery: ['embroidery', 'merchandise', 'notes'], sizes: ['sizes', 'quantity'], attachments: ['designUrl', 'sizeFileUrl', 'address'] };
            if ((labels[group] || []).some(key => edited.has(key))) return '';
            if (group === 'attachments') return '';// Hanya tautan asli boleh masuk PDF, bukan link contoh Stitch
            const content = clone.innerHTML;
            return `<div class="original">${content}</div>`;
        };
        const sizeRows = record.sizes ? Object.entries(record.sizes).map(([k, v]) => `<tr><td>${safe(k)}</td><td>${number(v)} pcs</td></tr>`).join('') : '';
        const links = [['File desain pelanggan', 'designUrl'], ['Excel nama dan ukuran', 'sizeFileUrl']]
            .filter(([, key]) => validUrl(record[key]))
            .map(([label, key]) => `<p><strong>${safe(label)}:</strong> <a href="${safe(validUrl(record[key]))}">${safe(record[key])}</a></p>`).join('');
        const blocks = detailSections.map(([title, group]) => {
            const changed = rowsFor(group);
            let body = changed ? `<table class="fields"><tbody>${changed}</tbody></table>` : '';
            if (group === 'sizes' && sizeRows) body += `<table class="sizes"><thead><tr><th>Ukuran</th><th>Jumlah</th></tr></thead><tbody>${sizeRows}<tr><th>Total</th><th>${qtyTotal(record.sizes)} pcs</th></tr></tbody></table>`;
            body += cardFor(group);
            if (group === 'attachments') body += links || '<p class="muted">Berkas asli belum ditautkan. Minta CS mengunggah atau memasukkan URL berkas yang valid.</p>';
            if (!body) body = '<p class="muted">Rincian bagian ini belum tersedia.</p>';
            return `<section class="section"><h2>${safe(title)}</h2>${body}</section>`;
        }).join('');
        const html = `<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Form Desainer - ${safe(code)}</title>
  <style>
  @page{size:A4;margin:15mm 14mm}*{box-sizing:border-box}body{font-family:Arial,Helvetica,sans-serif;color:#252525;margin:0;font-size:11px;line-height:1.45}
  header{border-bottom:3px solid #830909;padding-bottom:12px;margin-bottom:15px}header .brand{color:#830909;font-size:12px;font-weight:800;letter-spacing:.06em}h1{font-size:21px;margin:8px 0 5px}h2{font-size:13px;background:#f6eeee;border-left:3px solid #830909;padding:8px 10px;margin:0 0 10px}.meta{display:grid;grid-template-columns:1fr 1fr;gap:5px 16px;margin-top:8px}.meta div{padding:5px 0}.meta small{color:#555}.section{margin:12px 0 18px;break-inside:avoid-page}.fields,.sizes{width:100%;border-collapse:collapse;margin:8px 0}.fields th,.fields td,.sizes th,.sizes td{border:1px solid #ddd;padding:6px 8px;text-align:left;vertical-align:top}.fields th{width:30%;background:#fafafa}.original{background:#fff;margin-top:6px}.original .grid{display:block}.original .grid>div,.original .flex>div{margin:3px 0}.original .bg-surface-container-low{background:#fafafa;padding:6px;border:1px solid #e8e8e8;border-radius:4px}.original .font-bold{font-weight:bold}.original span,.original strong{word-break:break-word}.original ul{padding-left:18px}.original [class*="rounded-full"],.original [class*="bg-emerald"],.original [class*="bg-primary-fixed"]{display:none}.original .flex{display:block}.original p{margin:5px 0}.muted{color:#666}a{color:#830909;text-decoration:underline;overflow-wrap:anywhere}footer{border-top:1px solid #ddd;padding-top:7px;margin-top:18px;color:#666;font-size:10px}button{display:none}
  </style></head><body>
  <header><div class="brand">PRESMA KONVEKSI • FORM UNTUK DESAINER</div><h1>Detail Form Pesanan Pelanggan</h1><div class="meta"><div><small>Kode order</small><br><strong>${safe(code)}</strong></div><div><small>Deadline</small><br><strong>${safe(humanDeadline(record.deadline))}</strong></div><div><small>Nama pelanggan</small><br><strong>${safe(record.customer || 'Tidak tersedia')}</strong></div><div><small>Produk & jumlah</small><br><strong>${safe(record.product || 'Tidak tersedia')} • ${number(record.quantity)} pcs</strong></div><div><small>Instansi</small><br>${safe(record.organization || '-')}</div><div><small>Status CS</small><br>${safe(record.status || '-')}</div></div></header>
  ${blocks}
  <footer>Dokumen disusun dari hasil form pesanan yang tersedia di browser CS. Tautan file aktif hanya jika URL asli sudah dimasukkan. Periksa kembali isi dan lampiran sebelum dibagikan ke desainer.</footer>
  <script>window.addEventListener('load',()=>setTimeout(()=>window.print(),350));<\/script>
  </body></html>`;
        const win = window.open('', '_blank');
        if (!win) { notify('Browser memblokir tab PDF. Izinkan pop-up untuk halaman ini, lalu klik lagi.'); return; }
        win.document.open(); win.document.write(html); win.document.close();
    };

    const preview = el('csDetailPreviewModal');
    page.addEventListener('click', e => {
        const b = e.target.closest('[data-detail-action]'); if (!b) return;
        switch (b.dataset.detailAction) {
            case 'preview': open('csDetailPreviewModal'); break;
            case 'close-preview': close(); break;
            case 'zip': notify('Berkas ZIP asli belum tersedia di proyek.'); break;
            case 'copy': notify('URL Drive masih contoh Stitch, tidak ada tautan asli yang disalin.'); break;
            case 'drive': notify('Link Drive masih contoh, belum dapat dibuka.'); break;
            case 'print': printDesignerBrief(); break;
        }
    });
    render();
    const requestedAction = params.get('action');
    if (requestedAction === 'edit') openSectionEdit(isExample ? 'identity' : 'all');
    if (requestedAction === 'next') {
        if (resolveStage() === 'verification') el('csOpenVerify')?.click();
        else el('csNextAction')?.click();
    }
};
if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initCsOrderDetailV4, { once: true }); else initCsOrderDetailV4();
