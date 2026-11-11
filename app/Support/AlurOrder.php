<?php

namespace App\Support;

/**
 * Menentukan "posisi alur kerja CS" sebuah order dari data di database
 * (bukan dari sessionStorage). Satu sumber kebenaran untuk dashboard,
 * daftar order, dan halaman detail.
 *
 *  verification : order BARU, menunggu verifikasi/fiksasi CS
 *  payment      : sudah DIKONFIRMASI, menunggu invoice + DP
 *  wo           : DP masuk, menunggu Work Order dibuat / diteruskan
 *  tracking     : produksi berjalan (CS hanya memantau)
 *  settlement   : barang di Packing, menunggu pelunasan
 *  ready        : Packing & lunas, siap diserahterimakan
 *  completed    : tahap Selesai
 *  cancelled    : BATAL
 */
class AlurOrder
{
    public const LABEL = [
        'verification' => 'Menunggu Verifikasi CS',
        'payment'      => 'Menunggu Pembayaran DP',
        'wo'           => 'Menunggu Work Order',
        'tracking'     => 'Dalam Produksi',
        'settlement'   => 'Menunggu Pelunasan',
        'ready'        => 'Siap Serah Terima',
        'completed'    => 'Selesai',
        'cancelled'    => 'Dibatalkan',
    ];

    /** @param object|array $order baris v_order + kolom status_wo (join work_order) */
    public static function tahap($order): string
    {
        $o = (object) $order;

        if (($o->status_order ?? '') === 'BATAL') {
            return 'cancelled';
        }
        if (($o->status_order ?? '') === 'BARU') {
            return 'verification';
        }
        if (($o->tahap_saat_ini ?? '') === 'Selesai') {
            return 'completed';
        }
        if (empty($o->nomor_invoice) || (float) ($o->dp ?? 0) <= 0) {
            return 'payment';
        }
        if (($o->status_wo ?? null) !== 'DITERUSKAN') {
            return 'wo';
        }
        if (($o->tahap_saat_ini ?? '') === 'Packing') {
            return (float) ($o->kekurangan ?? 0) > 0 ? 'settlement' : 'ready';
        }

        return 'tracking';
    }
}
