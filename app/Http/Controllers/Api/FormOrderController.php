<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Services\PesananService;
use App\Support\NomorWhatsapp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Form order PUBLIK untuk customer (tanpa login). Customer tidak punya
 * pelanggan_id, jadi pelanggan dicari lewat nomor WhatsApp; kalau belum ada
 * dibuatkan otomatis. Data pelanggan yang sudah ada TIDAK ditimpa.
 *
 * Respons sengaja minim: hanya kode order & kode tracking.
 */
class FormOrderController extends Controller
{
    public function store(Request $request, PesananService $service)
    {
        $request->merge([
            'no_whatsapp' => NomorWhatsapp::normalisasi($request->input('no_whatsapp')),
        ]);

        $validated = $request->validate(array_merge([
            'nama' => ['required', 'string', 'max:150'],
            'no_whatsapp' => ['required', 'string', 'regex:' . NomorWhatsapp::POLA],
            'instansi' => ['nullable', 'string', 'max:200'],
            'sumber_informasi' => ['nullable', Rule::in([
                'REKOMENDASI_TEMAN', 'INSTAGRAM', 'TIKTOK', 'IKLAN', 'FACEBOOK', 'LAINNYA',
            ])],
        ], PesananService::aturanIsiPesanan()), [
            'no_whatsapp.regex' => 'Nomor WhatsApp tidak valid (contoh: 085732240729).',
        ]);

        // Customer publik tidak boleh menentukan harga.
        unset($validated['harga_satuan']);

        $pelanggan = Pelanggan::firstOrCreate(
            ['no_whatsapp' => $validated['no_whatsapp']],
            [
                'nama' => $validated['nama'],
                'instansi' => $validated['instansi'] ?? null,
                'sumber_informasi' => $validated['sumber_informasi'] ?? null,
            ]
        );

        $pesanan = $service->buat($pelanggan, $validated, 'FORM_CUSTOMER');

        return response()->json([
            'message' => 'Order berhasil dikirim. Simpan kode tracking Anda.',
            'data' => [
                'kode_order' => $pesanan->kode_order,
                'kode_tracking' => $pesanan->kode_tracking,
            ],
        ], 201);
    }
}
