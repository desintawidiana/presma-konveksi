<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /** Lihat invoice (view v_invoice: total, DP, sisa tagihan, status bayar). */
    public function show(Pesanan $pesanan)
    {
        $invoice = $this->ambilInvoice($pesanan);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice belum dibuat untuk order ini.'], 404);
        }

        return response()->json([
            'message' => 'Invoice berhasil diambil',
            'data' => $invoice,
        ]);
    }

    /**
     * Terbitkan invoice. Aturan ditegakkan trigger database:
     * order harus DIKONFIRMASI, harga satuan & rincian ukuran harus terisi.
     * nomor_invoice & deskripsi_produk dibuat otomatis oleh trigger.
     */
    public function store(Pesanan $pesanan)
    {
        if (Invoice::where('pesanan_id', $pesanan->id)->exists()) {
            return response()->json(['message' => 'Invoice untuk order ini sudah dibuat.'], 409);
        }

        Invoice::create([
            'pesanan_id' => $pesanan->id,
            'dibuat_oleh' => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Invoice berhasil dibuat',
            'data' => $this->ambilInvoice($pesanan),
        ], 201);
    }

    /** Batalkan invoice (ditolak DB bila sudah ada pembayaran / Work Order). */
    public function destroy(Pesanan $pesanan)
    {
        $invoice = Invoice::where('pesanan_id', $pesanan->id)->first();

        if (!$invoice) {
            return response()->json(['message' => 'Invoice belum dibuat untuk order ini.'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice berhasil dibatalkan']);
    }

    private function ambilInvoice(Pesanan $pesanan)
    {
        // nomor_invoice = kode order ("<id>_<4 digit HP>")
        return DB::table('v_invoice')
            ->where('nomor_invoice', $pesanan->fresh()->kode_order)
            ->first();
    }
}
