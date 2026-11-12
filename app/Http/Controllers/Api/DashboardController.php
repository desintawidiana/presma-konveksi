<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\AlurOrder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /** Data dashboard CS: kartu ringkasan, ringkasan tagihan, dan daftar tindakan. */
    public function cs()
    {
        $rows = PesananController::queryOrder()
            ->where('o.status_order', '!=', 'BATAL')
            ->get()
            ->map(function ($r) {
                $r->alur = AlurOrder::tahap($r);

                return $r;
            });

        $hitung = fn (array $alur) => $rows->whereIn('alur', $alur)->count();
        $aktif = $rows->where('alur', '!=', 'completed');
        $adaDp = $rows->filter(fn ($r) => (float) $r->dp > 0);
        $tagihanBerjalan = $rows->filter(fn ($r) => $r->nomor_invoice && (float) $r->kekurangan > 0);
        $belumDp = $rows->filter(fn ($r) => $r->nomor_invoice && (float) $r->dp <= 0);
        $menungguPelunasan = $adaDp->filter(fn ($r) => (float) $r->kekurangan > 0);

        $hariIni = Carbon::today();

        $butuhTindakan = $rows->whereIn('alur', ['verification', 'payment', 'wo']);

        $perluTindakan = $butuhTindakan
            ->sortBy(fn ($r) => $r->deadline ?: '9999-12-31')
            ->take(10)
            ->map(function ($r) use ($hariIni) {
                $selisih = $r->deadline ? $hariIni->diffInDays(Carbon::parse($r->deadline), false) : null;
                $lengkap = $r->harga_satuan !== null && (int) $r->jumlah > 0;

                return [
                    'id' => $r->no,
                    'kode_order' => $r->kode_order,
                    'customer' => $r->customer,
                    'instansi' => $r->instansi,
                    'no_whatsapp' => $r->no_whatsapp,
                    'jenis_order' => $r->jenis_order,
                    'jumlah' => (int) $r->jumlah,
                    'deadline' => $r->deadline,
                    'sisa_hari' => $selisih,
                    'data_lengkap' => $lengkap,
                    'urgent' => !$lengkap || ($selisih !== null && $selisih <= 3),
                    'alur' => $r->alur,
                    'alur_label' => AlurOrder::LABEL[$r->alur],
                ];
            })
            ->values();

        return response()->json([
            'message' => 'Data dashboard CS berhasil diambil',
            'data' => [
                'kartu' => [
                    'perlu_verifikasi' => $hitung(['verification']),
                    'dalam_produksi' => $hitung(['tracking', 'settlement']),
                    'menunggu_pembayaran' => $tagihanBerjalan->count(),
                    'selesai_siap_kirim' => $hitung(['ready', 'completed']),
                ],
                'keuangan' => [
                    'total_nilai' => (float) $aktif->sum('total_pembayaran'),
                    'jumlah_order_aktif' => $aktif->count(),
                    'dp_terverifikasi' => (float) $adaDp->sum('dp'),
                    'jumlah_dp' => $adaDp->count(),
                    'menunggu_pelunasan' => (float) $menungguPelunasan->sum('kekurangan'),
                    'jumlah_pelunasan' => $menungguPelunasan->count(),
                    'belum_bayar_dp' => (float) $belumDp->sum('total_pembayaran'),
                    'jumlah_belum_dp' => $belumDp->count(),
                ],
                'jumlah_perlu_tindakan' => $butuhTindakan->count(),
                'perlu_tindakan' => $perluTindakan,
            ],
        ]);
    }
}
