<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Halaman tracking PUBLIK untuk customer. Akses hanya lewat kode_tracking
 * acak 32 karakter, dan hanya kolom aman dari view v_tracking yang tampil
 * (tanpa harga, no. WhatsApp, atau catatan internal).
 */
class TrackingController extends Controller
{
    public function show(string $kode)
    {
        if (!preg_match('/^[A-Za-z0-9]{32}$/', $kode)) {
            return $this->tidakDitemukan();
        }

        // kode_tracking bertipe ascii_bin (huruf besar/kecil dibedakan).
        $order = DB::table('v_tracking')->where('kode_tracking', $kode)->first();

        if (!$order) {
            return $this->tidakDitemukan();
        }

        return response()->json([
            'message' => 'Data tracking berhasil diambil',
            'data' => [
                'order' => $order,
                'ukuran' => DB::table('v_tracking_ukuran')
                    ->where('kode_tracking', $kode)->get(['ukuran', 'jumlah']),
                'riwayat' => DB::table('v_tracking_riwayat')
                    ->where('kode_tracking', $kode)->orderBy('waktu')->get(['tahap_baru', 'waktu']),
            ],
        ]);
    }

    private function tidakDitemukan()
    {
        return response()->json(['message' => 'Kode tracking tidak ditemukan.'], 404);
    }
}
