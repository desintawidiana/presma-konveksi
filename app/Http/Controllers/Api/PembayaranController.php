<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
    public function index(Pesanan $pesanan)
    {
        return response()->json([
            'message' => 'Data pembayaran berhasil diambil',
            'data' => [
                'ringkasan' => DB::table('v_pembayaran_order')
                    ->where('pesanan_id', $pesanan->id)->first(),
                'pembayaran' => Pembayaran::where('pesanan_id', $pesanan->id)
                    ->orderBy('id')->get(),
            ],
        ]);
    }

    /**
     * Catat DP / pelunasan. Trigger DB menolak bila invoice belum ada, order
     * BATAL, atau total pembayaran melebihi tagihan.
     */
    public function store(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate($this->aturan());

        $pembayaran = Pembayaran::create($validated + [
            'pesanan_id' => $pesanan->id,
            'dicatat_oleh' => Auth::id(),
        ])->refresh();

        return response()->json([
            'message' => 'Pembayaran berhasil dicatat',
            'data' => $pembayaran,
            'ringkasan' => DB::table('v_pembayaran_order')
                ->where('pesanan_id', $pesanan->id)->first(),
        ], 201);
    }

    /** Koreksi pembayaran (perubahan dicatat trigger ke riwayat_perubahan). */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate($this->aturan(sometimes: true));

        $pembayaran->update($validated);

        return response()->json([
            'message' => 'Pembayaran berhasil dikoreksi',
            'data' => $pembayaran->fresh(),
        ]);
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return response()->json(['message' => 'Pembayaran berhasil dihapus']);
    }

    private function aturan(bool $sometimes = false): array
    {
        $wajib = $sometimes ? ['sometimes', 'required'] : ['required'];

        return [
            'jenis' => array_merge($wajib, [Rule::in(['DP', 'PELUNASAN'])]),
            'jumlah' => array_merge($wajib, ['numeric', 'gt:0']),
            'tanggal_bayar' => ['nullable', 'date'],
            'metode' => array_merge($sometimes ? ['sometimes'] : ['nullable'], [Rule::in(['TRANSFER', 'TUNAI', 'QRIS', 'LAINNYA'])]),
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];
    }
}
