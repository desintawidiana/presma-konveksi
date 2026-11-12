@extends('layout.cs')

@section('title', 'Work Order | Presma Operations')

@section('content')
    <main class="cs-wo-page w-full pt-16 px-space-xl py-space-lg bg-surface">
        <div class="cs-wo-stack">
            <section class="cs-wo-heading">
                <div>
                    <h1>Work Order Management</h1>
                    <p>Kelola berkas Work Order dari desainer, periksa kelengkapan, lalu teruskan ke tim produksi.</p>
                </div>
                <button type="button" class="cs-wo-primary cs-wo-header-btn" id="wo-open-upload">
                    <span class="material-symbols-outlined">add_circle</span> Tambah Work Order
                </button>
            </section>

            <section class="cs-wo-kpis">
                <article class="cs-wo-kpi">
                    <div class="cs-wo-kpi-top"><span>TOTAL WORK ORDER</span><span class="cs-wo-kpi-icon"><span
                                class="material-symbols-outlined">assignment</span></span></div>
                    <strong class="cs-wo-kpi-number" id="wo-count-total">7</strong>
                    <div class="cs-wo-kpi-foot"><span>Seluruh data WO</span><span class="cs-wo-chip cs-wo-chip-neutral">Data
                            contoh</span></div>
                </article>
                <article class="cs-wo-kpi">
                    <div class="cs-wo-kpi-top"><span>PERLU DIPERIKSA</span><span
                            class="cs-wo-kpi-icon cs-wo-icon-yellow"><span
                                class="material-symbols-outlined">pending_actions</span></span></div>
                    <strong class="cs-wo-kpi-number" id="wo-count-review">2</strong>
                    <div class="cs-wo-kpi-foot"><span>WO menunggu pemeriksaan CS</span><span
                            class="cs-wo-chip cs-wo-chip-yellow">Perlu tindakan</span></div>
                </article>
                <article class="cs-wo-kpi">
                    <div class="cs-wo-kpi-top"><span>SIAP DITERUSKAN</span><span
                            class="cs-wo-kpi-icon cs-wo-icon-blue"><span
                                class="material-symbols-outlined">task_alt</span></span></div>
                    <strong class="cs-wo-kpi-number" id="wo-count-ready">1</strong>
                    <div class="cs-wo-kpi-foot"><span>Menunggu diteruskan ke produksi</span><span
                            class="cs-wo-chip cs-wo-chip-blue">Siap</span></div>
                </article>
                <article class="cs-wo-kpi">
                    <div class="cs-wo-kpi-top"><span>DITERUSKAN KE PRODUKSI</span><span
                            class="cs-wo-kpi-icon cs-wo-icon-green"><span
                                class="material-symbols-outlined">local_shipping</span></span></div>
                    <strong class="cs-wo-kpi-number" id="wo-count-sent">4</strong>
                    <div class="cs-wo-kpi-foot"><span>WO telah diteruskan</span><span
                            class="cs-wo-chip cs-wo-chip-green">Terkirim</span></div>
                </article>
            </section>

            <section class="cs-wo-panel">
                <div class="cs-wo-toolbar">
                    <label class="cs-wo-search"><span class="material-symbols-outlined">search</span><input id="wo-search"
                            type="search" placeholder="Cari nomor WO, ID order, pemesan, instansi, desainer..."></label>
                    <div class="cs-wo-filter">
                        <label for="wo-filter">STATUS:</label>
                        <select id="wo-filter">
                            <option value="">Semua Status</option>
                            <option value="PERLU_DIPERIKSA">Perlu Diperiksa</option>
                            <option value="SIAP_DITERUSKAN">Siap Diteruskan</option>
                            <option value="DITERUSKAN">Diteruskan ke Produksi</option>
                        </select>
                    </div>
                </div>
                <div class="cs-wo-table-wrap">
                    <table class="cs-wo-table" id="csWorkOrderTable">
                        <thead>
                            <tr>
                                <th>NOMOR WO</th>
                                <th>ID ORDER</th>
                                <th>PEMESAN &amp; INSTANSI</th>
                                <th>JENIS PRODUK</th>
                                <th>DESAINER</th>
                                <th>STATUS WO</th>
                                <th>BERKAS WORK ORDER</th>
                                <th>CATATAN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="wo-table-body">
                            <tr data-status="PERLU_DIPERIKSA"
                                data-search="wo-2026-001 po-2026-018 farhan saputra pt maju jaya korsa abiyu">
                                <td><strong class="cs-wo-number">WO-2026-001</strong></td>
                                <td><strong>PO-2026-018</strong></td>
                                <td><strong>Farhan Saputra</strong><small>PT Maju Jaya</small></td>
                                <td>Korsa PDH</td>
                                <td>Abiyu</td>
                                <td><span class="cs-wo-status cs-wo-status-review">Menunggu Pemeriksaan</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">WO-001.pdf <small>(belum tersedia)</small></span></td>
                                <td class="cs-wo-note-cell">Cek ulang ukuran dan posisi bordir.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-001">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-001" aria-label="Hapus WO-2026-001"
                                            title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="PERLU_DIPERIKSA"
                                data-search="wo-2026-002 po-2026-021 rizky aditya komunitas ruang karya kaos rina">
                                <td><strong class="cs-wo-number">WO-2026-002</strong></td>
                                <td><strong>PO-2026-021</strong></td>
                                <td><strong>Rizky Aditya</strong><small>Komunitas Ruang Karya</small></td>
                                <td>Kaos Komunitas</td>
                                <td>Rina</td>
                                <td><span class="cs-wo-status cs-wo-status-review">Menunggu Pemeriksaan</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">WO-002.pdf <small>(belum tersedia)</small></span></td>
                                <td class="cs-wo-note-cell">Mohon pastikan warna sesuai sampel.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-002">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-002" aria-label="Hapus WO-2026-002"
                                            title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-status="SIAP_DITERUSKAN"
                                data-search="wo-2026-003 po-2026-023 nadia rahmawati cv karya utama rompi bordir dinda">
                                <td><strong class="cs-wo-number">WO-2026-003</strong></td>
                                <td><strong>PO-2026-023</strong></td>
                                <td><strong>Nadia Rahmawati</strong><small>CV Karya Utama</small></td>
                                <td>Rompi Bordir</td>
                                <td>Dinda</td>
                                <td><span class="cs-wo-status cs-wo-status-ready">Siap Diteruskan</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">Link Google Drive <small>(belum tersedia)</small></span>
                                </td>
                                <td class="cs-wo-note-cell">Desain sudah disetujui pemesan.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-003">Periksa WO</button><button type="button"
                                            class="cs-wo-forward" data-wo-forward="WO-2026-003">Teruskan</button><button
                                            type="button" class="cs-wo-delete" data-wo-delete="WO-2026-003"
                                            aria-label="Hapus WO-2026-003" title="Hapus"><span
                                                class="material-symbols-outlined">delete</span></button></div>
                                </td>
                            </tr>
                            <tr data-status="DITERUSKAN"
                                data-search="wo-2026-004 po-2026-025 himpunan mahasiswa informatika jaket dimas">
                                <td><strong class="cs-wo-number">WO-2026-004</strong></td>
                                <td><strong>PO-2026-025</strong></td>
                                <td><strong>Himpunan Mahasiswa Informatika</strong><small>Universitas AMIKOM</small></td>
                                <td>Jaket Himpunan</td>
                                <td>Dimas</td>
                                <td><span class="cs-wo-status cs-wo-status-sent"><span
                                            class="material-symbols-outlined">check_circle</span> Diteruskan ke
                                        Produksi</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">WO-004.pdf <small>(belum tersedia)</small></span></td>
                                <td class="cs-wo-note-cell">Bahan utama sudah dikonfirmasi.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-004">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-004"
                                            aria-label="Hapus WO-2026-004" title="Hapus"><span
                                                class="material-symbols-outlined">delete</span></button></div>
                                </td>
                            </tr>
                            <tr data-status="DITERUSKAN" data-search="wo-2026-005 po-2026-027 pt sinar abadi polo rina">
                                <td><strong class="cs-wo-number">WO-2026-005</strong></td>
                                <td><strong>PO-2026-027</strong></td>
                                <td><strong>PT Sinar Abadi</strong><small>PT Sinar Abadi</small></td>
                                <td>Polo Kantor</td>
                                <td>Rina</td>
                                <td><span class="cs-wo-status cs-wo-status-sent"><span
                                            class="material-symbols-outlined">check_circle</span> Diteruskan ke
                                        Produksi</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">WO-005.pdf <small>(belum tersedia)</small></span></td>
                                <td class="cs-wo-note-cell">Jahitan menggunakan benang warna senada.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-005">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-005"
                                            aria-label="Hapus WO-2026-005" title="Hapus"><span
                                                class="material-symbols-outlined">delete</span></button></div>
                                </td>
                            </tr>
                            <tr data-status="DITERUSKAN"
                                data-search="wo-2026-006 po-2026-029 pt sentosa seragam kerja abiyu">
                                <td><strong class="cs-wo-number">WO-2026-006</strong></td>
                                <td><strong>PO-2026-029</strong></td>
                                <td><strong>PT Sentosa</strong><small>PT Sentosa</small></td>
                                <td>Seragam Kerja</td>
                                <td>Abiyu</td>
                                <td><span class="cs-wo-status cs-wo-status-sent"><span
                                            class="material-symbols-outlined">check_circle</span> Diteruskan ke
                                        Produksi</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">Link Google Drive <small>(belum tersedia)</small></span>
                                </td>
                                <td class="cs-wo-note-cell">Produksi mengikuti ukuran pada lampiran.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-006">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-006"
                                            aria-label="Hapus WO-2026-006" title="Hapus"><span
                                                class="material-symbols-outlined">delete</span></button></div>
                                </td>
                            </tr>
                            <tr data-status="DITERUSKAN"
                                data-search="wo-2026-007 po-2026-031 festival kampus kaos event dinda">
                                <td><strong class="cs-wo-number">WO-2026-007</strong></td>
                                <td><strong>PO-2026-031</strong></td>
                                <td><strong>Panitia Festival Kampus</strong><small>Universitas Nusantara</small></td>
                                <td>Kaos Event</td>
                                <td>Dinda</td>
                                <td><span class="cs-wo-status cs-wo-status-sent"><span
                                            class="material-symbols-outlined">check_circle</span> Diteruskan ke
                                        Produksi</span></td>
                                <td><span class="cs-wo-file-link is-unavailable" aria-disabled="true" title="Dokumen belum tersedia">WO-007.pdf <small>(belum tersedia)</small></span></td>
                                <td class="cs-wo-note-cell">Cetak bagian depan dan belakang.</td>
                                <td>
                                    <div class="cs-wo-actions"><button type="button" class="cs-wo-review"
                                            data-wo-detail="WO-2026-007">Periksa WO</button><button type="button"
                                            class="cs-wo-delete" data-wo-delete="WO-2026-007"
                                            aria-label="Hapus WO-2026-007" title="Hapus"><span
                                                class="material-symbols-outlined">delete</span></button></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="cs-wo-pagination" id="wo-pagination">
                    <div class="flex items-center gap-3">
                        <span class="cs-wo-page-info" id="wo-page-info">Menampilkan 1–10 dari 7 data</span>
                        <label class="flex items-center gap-2 text-xs text-secondary">
                            Tampilkan
                            <select id="wo-page-size" class="rounded-lg border border-[#D9DADB] px-2 py-1 text-xs">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                            </select>
                        </label>
                    </div>
                    <div class="cs-wo-page-controls">
                        <button type="button" id="wo-prev-page" aria-label="Halaman sebelumnya">‹</button>
                        <span id="wo-page-current">1</span>
                        <button type="button" id="wo-next-page" aria-label="Halaman berikutnya">›</button>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <div class="wo-overlay" id="wo-overlay" hidden></div>
    <aside class="wo-drawer" id="wo-drawer" aria-hidden="true">
        <div class="wo-drawer-head">
            <div><span class="wo-eyebrow">DOKUMEN PRODUKSI</span>
                <h2>Upload Berkas WO</h2>
            </div>
            <button type="button" class="wo-icon-btn" id="wo-close-upload" aria-label="Tutup"><span
                    class="material-symbols-outlined">close</span></button>
        </div>
        <form id="wo-upload-form">
            <div class="wo-field">
                <label for="wo-order">Pesanan terkait</label>
                <select id="wo-order" required>
                    <option value="">Pilih pesanan</option>
                    <option value="PO-2026-018">PO-2026-018 — PT Maju Jaya</option>
                    <option value="PO-2026-021">PO-2026-021 — Komunitas Ruang Karya</option>
                    <option value="PO-2026-023">PO-2026-023 — CV Karya Utama</option>
                </select>
                <small>Daftar pesanan akan diisi dari database setelah endpoint backend tersedia.</small>
            </div>
            <div class="wo-field">
                <label for="wo-designer">Nama desainer</label>
                <input id="wo-designer" name="desainer" type="text" placeholder="Masukkan nama desainer"
                    autocomplete="off">
                <small>Masukkan nama desainer yang menangani Work Order.</small>
            </div>
            <div class="wo-field">
                <label>Berkas Work Order</label>
                <div class="wo-file-options">
                    <label class="wo-choice"><input type="radio" name="wo-source" value="file" checked> Upload
                        file</label>
                    <label class="wo-choice"><input type="radio" name="wo-source" value="link"> Cantumkan
                        link</label>
                </div>
                <label class="wo-dropzone" id="wo-file-zone" for="wo-file">
                    <span class="material-symbols-outlined">upload_file</span>
                    <strong>Pilih berkas WO</strong>
                    <span>Format PDF, JPG, atau PNG (maks. 10 MB)</span>
                    <input id="wo-file" type="file" accept=".pdf,.jpg,.jpeg,.png">
                </label>
                <div id="wo-link-zone" hidden>
                    <input id="wo-file-url" type="url" placeholder="https://drive.google.com/...">
                    <small>Masukkan tautan Google Drive atau URL dokumen yang dapat diakses.</small>
                </div>
            </div>
            <div class="wo-field">
                <label for="wo-notes">Catatan</label>
                <textarea id="wo-notes" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
            </div>
            <div class="wo-alert"><span class="material-symbols-outlined">info</span><span>File atau link dapat dipilih
                    sebagai jenis berkas. Penyimpanan permanen tetap memerlukan endpoint backend.</span></div>
            <div class="wo-drawer-actions">
                <button type="button" class="wo-btn wo-btn-light" id="wo-cancel-upload">Tutup</button>
                <button type="submit" class="wo-btn wo-btn-primary">Simpan WO</button>
            </div>
        </form>
    </aside>

    <div class="wo-modal-backdrop" id="wo-modal" hidden>
        <section class="wo-modal-card" role="dialog" aria-modal="true" aria-labelledby="wo-modal-title">
            <div class="wo-drawer-head">
                <div><span class="wo-eyebrow">DETAIL WORK ORDER</span>
                    <h2 id="wo-modal-title">Periksa WO</h2>
                </div>
                <button type="button" class="wo-icon-btn" id="wo-modal-close" aria-label="Tutup"><span
                        class="material-symbols-outlined">close</span></button>
            </div>
            <div id="wo-modal-content"></div>
            <div class="wo-modal-actions">
                <button type="button" class="wo-btn wo-btn-light" id="wo-modal-cancel">Tutup</button>
                <button type="button" class="wo-btn wo-btn-primary" id="wo-modal-approve">Tandai Siap
                    Diteruskan</button>
            </div>
        </section>
    </div>
@endsection
