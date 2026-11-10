<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    /** Data Work Order lengkap untuk dicetak (view v_work_order). */
    public function show(Pesanan $pesanan)
    {
        $wo = WorkOrder::where('pesanan_id', $pesanan->id)->first();

        if (!$wo) {
            return response()->json(['message' => 'Work Order belum dibuat untuk order ini.'], 404);
        }

        return response()->json([
            'message' => 'Work Order berhasil diambil',
            'data' => $this->detail($wo),
        ]);
    }

    /** Buat WO. Trigger DB mensyaratkan invoice sudah ada dan DP sudah tercatat. */
    public function store(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'catatan_produksi' => ['nullable', 'string'],
        ]);

        if (WorkOrder::where('pesanan_id', $pesanan->id)->exists()) {
            return response()->json(['message' => 'Work Order untuk order ini sudah dibuat.'], 409);
        }

        $wo = WorkOrder::create([
            'pesanan_id' => $pesanan->id,
            'catatan_produksi' => $validated['catatan_produksi'] ?? null,
            'dibuat_oleh' => Auth::id(),
        ])->refresh();

        return response()->json([
            'message' => 'Work Order berhasil dibuat',
            'data' => $this->detail($wo),
        ], 201);
    }

    /**
     * Teruskan WO ke Tim Produksi (DIBUAT -> DITERUSKAN). Setelah ini baru
     * tahap produksi boleh diubah (aturan di trigger pesanan_sebelum_update).
     */
    public function teruskan(WorkOrder $workOrder)
    {
        if ($workOrder->status_wo === 'DITERUSKAN') {
            return response()->json(['message' => 'Work Order sudah diteruskan.'], 409);
        }

        $workOrder->update(['status_wo' => 'DITERUSKAN']);

        return response()->json([
            'message' => 'Work Order diteruskan ke Tim Produksi',
            'data' => $this->detail($workOrder->fresh()),
        ]);
    }

    private function detail(WorkOrder $wo)
    {
        return DB::table('v_work_order')->where('nomor_wo', $wo->nomor_wo)->first()
            ?? $wo;
    }
}
