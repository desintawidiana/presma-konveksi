<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Laporan Owner = view yang sudah dibuat di database. Daftar putih
     * (nama URL => nama view) supaya nama tabel tidak bisa diisi sembarangan.
     */
    private const VIEW = [
        'ringkasan-keuangan' => 'v_ringkasan_keuangan',
        'laporan-bulanan' => 'v_laporan_bulanan',
        'arus-kas-bulanan' => 'v_arus_kas_bulanan',
        'laporan-pemasukan' => 'v_laporan_pemasukan',
        'transaksi-keuangan' => 'v_transaksi_keuangan',
        'transaksi-pembayaran' => 'v_transaksi_pembayaran',
        'pengeluaran' => 'v_pengeluaran',
        'stok-bahan' => 'v_stok_bahan',
        'kekurangan-bahan' => 'v_kekurangan_bahan',
        'pembelian' => 'v_pembelian',
    ];

    public function tampil(Request $request, string $nama)
    {
        if (!isset(self::VIEW[$nama])) {
            return response()->json(['message' => 'Laporan tidak ditemukan.'], 404);
        }

        $limit = min(max((int) $request->query('limit', 500), 1), 2000);

        return response()->json([
            'message' => 'Laporan berhasil diambil',
            'data' => DB::table(self::VIEW[$nama])->limit($limit)->get(),
        ]);
    }

    /** Notifikasi sesuai peran pengguna yang sedang login (view v_notifikasi). */
    public function notifikasi()
    {
        $peran = array_map('trim', explode(',', (string) Auth::user()->peran));

        return response()->json([
            'message' => 'Notifikasi berhasil diambil',
            'data' => DB::table('v_notifikasi')->whereIn('untuk_peran', $peran)->get(),
        ]);
    }
}
