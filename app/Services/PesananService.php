<?php

namespace App\Services;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Logika pembuatan pesanan dipakai dua pintu masuk:
 *  - CS lewat dashboard      (POST /api/pesanan)    -> dibuat_dari = CS
 *  - Customer lewat form web (POST /api/form-order) -> dibuat_dari = FORM_CUSTOMER
 */
class PesananService
{
    public const JENIS_PRODUK = [
        'Korsa', 'Vest', 'Kaos', 'Polo', 'Jaket', 'Topi', 'Celana/Rok',
        'Scrub', 'Makloon', 'Ganci', 'Lanyard', 'ID CARD', 'Jersey',
        'Workshirt', 'Lainnya',
    ];

    public const UKURAN = [
        'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL', '6XL',
        'TANPA_UKURAN',
    ];

    /** Aturan validasi untuk isi pesanan (tanpa data pelanggan). */
    public static function aturanIsiPesanan(): array
    {
        return [
            'jenis_produk' => ['required', Rule::in(self::JENIS_PRODUK)],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'harga_satuan' => ['nullable', 'numeric', 'min:0'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],

            'spesifikasi' => ['required', 'array'],
            'spesifikasi.model_cuttingan' => ['nullable', 'string', 'max:200'],
            'spesifikasi.lengan' => ['nullable', Rule::in(['PANJANG', 'PENDEK'])],
            'spesifikasi.status_desain' => ['required', Rule::in(['SUDAH_ADA_FILE', 'DIBUATKAN_TIM'])],
            'spesifikasi.catatan_desain' => ['nullable', 'string'],
            'spesifikasi.bahan' => ['nullable', 'string', 'max:150'],
            'spesifikasi.warna' => ['nullable', 'string', 'max:100'],
            'spesifikasi.pakai_lanyard' => ['sometimes', 'boolean'],
            'spesifikasi.pakai_id_card' => ['sometimes', 'boolean'],
            'spesifikasi.model_saku' => ['nullable', 'string'],
            'spesifikasi.pakai_sablon' => ['sometimes', 'boolean'],
            'spesifikasi.pakai_bordir' => ['sometimes', 'boolean'],
            'spesifikasi.ket_bordir_sablon' => ['nullable', 'string'],
            'spesifikasi.tambahan' => ['nullable', 'string'],
            'spesifikasi.variasi_lain' => ['nullable', 'string'],

            'ukuran' => ['required', 'array', 'min:1'],
            'ukuran.*.ukuran' => ['required', 'distinct', Rule::in(self::UKURAN)],
            'ukuran.*.jumlah' => ['required', 'integer', 'min:1'],
        ];
    }

    public function buat(Pelanggan $pelanggan, array $v, string $dibuatDari): Pesanan
    {
        $pesanan = DB::transaction(function () use ($pelanggan, $v, $dibuatDari) {
            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'jenis_produk' => $v['jenis_produk'],
                'keterangan' => $v['keterangan'] ?? null,
                'harga_satuan' => $v['harga_satuan'] ?? null,
                'deadline' => $v['deadline'] ?? null,
                'status_order' => 'BARU',
                'dibuat_dari' => $dibuatDari,
            ]);

            $s = $v['spesifikasi'];

            $pesanan->spesifikasi()->create([
                'model_cuttingan' => $s['model_cuttingan'] ?? null,
                'lengan' => $s['lengan'] ?? null,
                'status_desain' => $s['status_desain'],
                'catatan_desain' => $s['catatan_desain'] ?? null,
                'bahan' => $s['bahan'] ?? null,
                'warna' => $s['warna'] ?? null,
                'pakai_lanyard' => $s['pakai_lanyard'] ?? false,
                'pakai_id_card' => $s['pakai_id_card'] ?? false,
                'model_saku' => $s['model_saku'] ?? null,
                'pakai_sablon' => $s['pakai_sablon'] ?? false,
                'pakai_bordir' => $s['pakai_bordir'] ?? false,
                'ket_bordir_sablon' => $s['ket_bordir_sablon'] ?? null,
                'tambahan' => $s['tambahan'] ?? null,
                'variasi_lain' => $s['variasi_lain'] ?? null,
            ]);

            foreach ($v['ukuran'] as $item) {
                $pesanan->ukuranPesanan()->create([
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            return $pesanan;
        });

        // hp_4_digit, instansi & tahap_saat_ini diisi trigger/default DB,
        // jadi baca ulang supaya ikut muncul di respons (termasuk kode_order).
        return $pesanan->refresh()->load(['pelanggan', 'spesifikasi', 'ukuranPesanan']);
    }
}
