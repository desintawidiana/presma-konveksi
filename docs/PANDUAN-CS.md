# Panduan: Panel CS terhubung ke database

## Halaman yang sudah terhubung
| Halaman | Sumber data |
|---|---|
| Dashboard CS (`/dashboard/cs`) | `GET /api/dashboard/cs` (kartu, ringkasan tagihan, antrean tindakan) |
| Customer (`/cs/customer`) | `/api/pelanggan` (sudah ada sebelumnya, diverifikasi) |
| Order (`/cs/order`) | `GET /api/pesanan` (view `v_order`), tambah order: `POST /api/pesanan` |
| Detail Order (`/cs/order/detail?id=ID`) | `GET /api/pesanan/{id}` + aksi alur |

## Alur order (dihitung dari database oleh `App\Support\AlurOrder`)
1. verification  : order BARU -> CS fiksasi (konfirmasi)  [harga satuan wajib terisi]
2. payment       : DIKONFIRMASI -> terbitkan invoice + catat DP
3. wo            : DP masuk -> buat Work Order -> teruskan ke produksi
4. tracking      : produksi berjalan (CS hanya memantau; tahap diubah role PRODUKSI)
5. settlement    : di tahap Packing, menunggu pelunasan
6. ready         : lunas -> serah terima (POST /api/pesanan/{id}/serah-terima)
7. completed     : tahap Selesai.  Batal hanya bisa sebelum DP masuk.

## Aturan database yang memengaruhi tampilan
- Work Order WAJIB menunggu DP tercatat. Opsi "tanpa DP / PO" dari desain lama dihapus karena ditolak trigger.
- Harga & rincian ukuran dikunci setelah invoice terbit (form edit menonaktifkannya).
- Packing/Selesai hanya setelah QC lolos (dikerjakan role PRODUKSI).
- Nomor WO & nomor invoice dibuat otomatis oleh database.

## Field di desain lama yang belum ada di database (sengaja tidak ditampilkan)
Alamat penerima, link berkas desain, link Excel ukuran, penanggung jawab CS, kategori produk manual,
lampiran file. Lampiran menunggu modul `file_desain`.

## Perubahan penting terhadap branch frontend
- Tombol "Tambah Order Baru" di halaman Order sekarang membuka form yang menyimpan ke database
  (sebelumnya tautan ke form pelanggan mode preview).
- Kolom "Penanggung Jawab" menjadi "Sumber Order" (Form Customer / Dibuat CS).
- Route `cs.order.preview` (preview lokal) dipertahankan; route sungguhan bernama `cs.order` dan `cs.order.detail`.
- Pagination bawaan desain disembunyikan (semua order tampil sekaligus).

## Belum dikerjakan
Panel Owner, form order publik pelanggan (`public-order`, `public-order-check` -> `/api/form-order`, `/api/tracking/{kode}`),
modul file_desain, menu sidebar Work Order / Invoice & Pembayaran / Tracking (masih `#`).

## Catatan
- API dibatasi 60 request/menit per pengguna (bawaan Laravel). Cukup untuk pemakaian normal.
- Jalankan `npm run dev` (atau `npm.cmd run dev`) agar JS/CSS termuat.
