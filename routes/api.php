<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FormOrderController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembayaranController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\ProduksiController;
use App\Http\Controllers\Api\TrackingController;
use App\Http\Controllers\Api\WorkOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Presma Konveksi
|--------------------------------------------------------------------------
| Alur bisnis (sesuai aturan trigger di database):
|   Form order -> Verifikasi (DIKONFIRMASI) -> Invoice -> DP -> Work Order
|   -> Diteruskan ke Produksi -> Tahap produksi -> QC -> Packing -> Selesai
*/

// ===== PUBLIK (tanpa login, dibatasi laju request) ========================
Route::post('/form-order', [FormOrderController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/tracking/{kode}', [TrackingController::class, 'show'])
    ->middleware('throttle:30,1');

// ===== TERLINDUNGI: login sesi (web) + pencatat pengguna untuk trigger ====
// 'web' dipakai agar sesi & CSRF aktif (frontend Blade satu domain dengan API).
Route::middleware(['web', 'auth', 'db.user'])->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/notifikasi', [LaporanController::class, 'notifikasi']);

    // --- Semua peran: referensi tahap produksi ---
    Route::get('/tahap-produksi', [ProduksiController::class, 'tahap']);

    // --- CS & Owner: pelanggan, pesanan, invoice, pembayaran, work order ---
    Route::middleware('peran:CS,OWNER')->group(function () {
        Route::apiResource('pelanggan', PelangganController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy']);

        Route::apiResource('pesanan', PesananController::class)
            ->only(['index', 'show', 'store', 'update']);
        Route::post('/pesanan/{pesanan}/konfirmasi', [PesananController::class, 'konfirmasi']);
        Route::post('/pesanan/{pesanan}/batal', [PesananController::class, 'batal']);
        Route::post('/pesanan/{pesanan}/serah-terima', [PesananController::class, 'serahTerima']);

        Route::get('/dashboard/cs', [DashboardController::class, 'cs']);

        Route::get('/pesanan/{pesanan}/invoice', [InvoiceController::class, 'show']);
        Route::post('/pesanan/{pesanan}/invoice', [InvoiceController::class, 'store']);
        Route::delete('/pesanan/{pesanan}/invoice', [InvoiceController::class, 'destroy']);

        Route::get('/pesanan/{pesanan}/pembayaran', [PembayaranController::class, 'index']);
        Route::post('/pesanan/{pesanan}/pembayaran', [PembayaranController::class, 'store']);

        Route::post('/pesanan/{pesanan}/work-order', [WorkOrderController::class, 'store']);
        Route::post('/work-order/{workOrder}/teruskan', [WorkOrderController::class, 'teruskan']);
    });

    // --- CS, Owner & Produksi: lihat WO dan riwayat tahap ---
    Route::middleware('peran:CS,OWNER,PRODUKSI')->group(function () {
        Route::get('/pesanan/{pesanan}/work-order', [WorkOrderController::class, 'show']);
        Route::get('/pesanan/{pesanan}/riwayat-tahap', [ProduksiController::class, 'riwayatTahap']);
    });

    // --- Produksi & Owner: antrian, ubah tahap, QC ---
    Route::middleware('peran:PRODUKSI,OWNER')->group(function () {
        Route::get('/antrian-produksi', [ProduksiController::class, 'antrian']);
        Route::post('/pesanan/{pesanan}/tahap', [ProduksiController::class, 'ubahTahap']);
        Route::post('/work-order/{workOrder}/qc', [ProduksiController::class, 'catatQc']);
    });

    // --- Owner saja: koreksi/hapus pembayaran & laporan ---
    Route::middleware('peran:OWNER')->group(function () {
        Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update']);
        Route::delete('/pembayaran/{pembayaran}', [PembayaranController::class, 'destroy']);

        Route::get('/laporan/{nama}', [LaporanController::class, 'tampil']);
    });
});
