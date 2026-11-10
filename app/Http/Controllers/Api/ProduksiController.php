<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Qc;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProduksiController extends Controller
{
    /** Daftar tahap berurutan (untuk dropdown / progress bar). */
    public function tahap()
    {
        return response()->json([
            'message' => 'Data tahap produksi berhasil diambil',
            'data' => DB::table('tahap_produksi')->orderBy('urutan')->get(),
        ]);
    }

    /** Antrian kerja produksi (WO yang sudah diteruskan). */
    public function antrian()
    {
        return response()->json([
            'message' => 'Antrian produksi berhasil diambil',
            'data' => DB::table('v_antrian_produksi')->orderBy('deadline')->get(),
        ]);
    }

    public function riwayatTahap(Pesanan $pesanan)
    {
        return response()->json([
            'message' => 'Riwayat tahap berhasil diambil',
            'data' => DB::table('riwayat_tahap as r')
                ->leftJoin('pengguna as p', 'p.id', '=', 'r.diubah_oleh')
                ->where('r.pesanan_id', $pesanan->id)
                ->orderBy('r.id')
                ->get(['r.*', 'p.nama as diubah_oleh_nama']),
        ]);
    }

    /**
     * Ubah tahap lewat stored procedure ubah_tahap_produksi (mencatat siapa &
     * catatannya). Aturan di DB: WO harus sudah DITERUSKAN, order tidak BATAL,
     * dan Packing/Selesai hanya setelah QC terakhir LOLOS.
     */
    public function ubahTahap(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'tahap' => ['required', Rule::exists('tahap_produksi', 'nama')],
            'catatan' => ['nullable', 'string'],
        ]);

        DB::statement('CALL ubah_tahap_produksi(?, ?, ?, ?)', [
            $pesanan->id,
            $validated['tahap'],
            $validated['catatan'] ?? null,
            Auth::id(),
        ]);

        return response()->json([
            'message' => 'Tahap produksi berhasil diubah',
            'data' => $pesanan->fresh(),
        ]);
    }

    /**
     * Catat hasil QC. Trigger qc_setelah_insert otomatis memindahkan tahap:
     * LOLOS -> Packing, REVISI -> tahap yang dipilih (harus sebelum QC).
     * Hanya bisa saat order berada di tahap QC.
     */
    public function catatQc(Request $request, WorkOrder $workOrder)
    {
        $validated = $request->validate([
            'hasil' => ['required', Rule::in(['LOLOS', 'REVISI'])],
            'catatan' => ['nullable', 'string'],
            'kembali_ke_tahap' => [
                'required_if:hasil,REVISI', 'nullable',
                Rule::exists('tahap_produksi', 'nama'),
            ],
        ]);

        if ($validated['hasil'] === 'LOLOS') {
            $validated['kembali_ke_tahap'] = null;
        }

        $qc = Qc::create($validated + [
            'work_order_id' => $workOrder->id,
            'dicatat_oleh' => Auth::id(),
        ])->refresh();

        return response()->json([
            'message' => 'Hasil QC berhasil dicatat',
            'data' => $qc,
            'tahap_saat_ini' => Pesanan::find($workOrder->pesanan_id)->tahap_saat_ini,
        ], 201);
    }
}
