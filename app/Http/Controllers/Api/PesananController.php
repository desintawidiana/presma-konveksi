<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with([
            'pelanggan',
            'spesifikasi',
            'ukuranPesanan',
        ])->orderByDesc('dibuat_pada')->get();

        return response()->json([
            'message' => 'Data pesanan berhasil diambil',
            'data' => $pesanan,
        ]);
    }

    private function validasiPesanan(Request $request): array
    {
        return $request->validate([
            'pelanggan_id' => [
                'required',
                'integer',
                Rule::exists('pelanggan', 'id'),
            ],

            'jenis_produk' => [
                'required',
                Rule::in([
                    'Korsa',
                    'Vest',
                    'Kaos',
                    'Polo',
                    'Jaket',
                    'Topi',
                    'Celana/Rok',
                    'Scrub',
                    'Makloon',
                    'Ganci',
                    'Lanyard',
                    'ID CARD',
                    'Jersey',
                    'Workshirt',
                    'Lainnya',
                ]),
            ],

            'keterangan' => ['nullable', 'string', 'max:255'],
            'harga_satuan' => ['nullable', 'numeric', 'min:0'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],

            'spesifikasi' => ['required', 'array'],
            'spesifikasi.model_cuttingan' => ['nullable', 'string', 'max:200'],
            'spesifikasi.lengan' => [
                'nullable',
                Rule::in(['PANJANG', 'PENDEK']),
            ],
            'spesifikasi.status_desain' => [
                'required',
                Rule::in(['SUDAH_ADA_FILE', 'DIBUATKAN_TIM']),
            ],
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
            'ukuran.*.ukuran' => [
                'required',
                'distinct',
                Rule::in([
                    'XS',
                    'S',
                    'M',
                    'L',
                    'XL',
                    '2XL',
                    '3XL',
                    '4XL',
                    '5XL',
                    '6XL',
                    'TANPA_UKURAN',
                ]),
            ],
            'ukuran.*.jumlah' => ['required', 'integer', 'min:1'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validasiPesanan($request);

        $pesanan = DB::transaction(function () use ($validated) {
            $pelanggan = Pelanggan::findOrFail(
                $validated['pelanggan_id']
            );

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'jenis_produk' => $validated['jenis_produk'],
                'keterangan' => $validated['keterangan'] ?? null,
                'harga_satuan' => $validated['harga_satuan'] ?? null,
                'deadline' => $validated['deadline'] ?? null,
                'status_order' => 'BARU',
                'dibuat_dari' => 'FORM_CUSTOMER',
            ]);

            $spesifikasi = $validated['spesifikasi'];

            $pesanan->spesifikasi()->create([
                'model_cuttingan' => $spesifikasi['model_cuttingan'] ?? null,
                'lengan' => $spesifikasi['lengan'] ?? null,
                'status_desain' => $spesifikasi['status_desain'],
                'catatan_desain' => $spesifikasi['catatan_desain'] ?? null,
                'bahan' => $spesifikasi['bahan'] ?? null,
                'warna' => $spesifikasi['warna'] ?? null,
                'pakai_lanyard' => $spesifikasi['pakai_lanyard'] ?? false,
                'pakai_id_card' => $spesifikasi['pakai_id_card'] ?? false,
                'model_saku' => $spesifikasi['model_saku'] ?? null,
                'pakai_sablon' => $spesifikasi['pakai_sablon'] ?? false,
                'pakai_bordir' => $spesifikasi['pakai_bordir'] ?? false,
                'ket_bordir_sablon' => $spesifikasi['ket_bordir_sablon'] ?? null,
                'tambahan' => $spesifikasi['tambahan'] ?? null,
                'variasi_lain' => $spesifikasi['variasi_lain'] ?? null,
            ]);

            foreach ($validated['ukuran'] as $item) {
                $pesanan->ukuranPesanan()->create([
                    'ukuran' => $item['ukuran'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            return $pesanan;
        });

        $pesanan->load([
            'pelanggan',
            'spesifikasi',
            'ukuranPesanan',
        ]);

        return response()->json([
            'message' => 'Pesanan berhasil dibuat',
            'data' => $pesanan,
        ], 201);
    }
}
