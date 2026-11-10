<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Support\NomorWhatsapp;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    private const SUMBER = [
        'REKOMENDASI_TEMAN', 'INSTAGRAM', 'TIKTOK', 'IKLAN', 'FACEBOOK', 'LAINNYA',
    ];

    public function index()
    {
        return response()->json([
            'message' => 'Data pelanggan berhasil diambil',
            'data' => Pelanggan::orderBy('id', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->normalkanNomor($request);

        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'no_whatsapp' => [
                'required', 'string', 'max:20',
                'regex:' . NomorWhatsapp::POLA,
                Rule::unique('pelanggan', 'no_whatsapp'),
            ],
            'instansi' => 'nullable|string|max:200',
            'sumber_informasi' => ['nullable', Rule::in(self::SUMBER)],
        ], $this->pesanValidasi());

        $pelanggan = Pelanggan::create($validated)->refresh();

        return response()->json([
            'message' => 'Data pelanggan berhasil ditambahkan',
            'data' => $pelanggan,
        ], 201);
    }

    public function show(Pelanggan $pelanggan)
    {
        return response()->json([
            'message' => 'Detail pelanggan berhasil diambil',
            'data' => $pelanggan,
        ]);
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $this->normalkanNomor($request);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:150',
            'no_whatsapp' => [
                'sometimes', 'required', 'string', 'max:20',
                'regex:' . NomorWhatsapp::POLA,
                Rule::unique('pelanggan', 'no_whatsapp')->ignore($pelanggan->id),
            ],
            'instansi' => 'sometimes|nullable|string|max:200',
            'sumber_informasi' => ['sometimes', 'nullable', Rule::in(self::SUMBER)],
        ], $this->pesanValidasi());

        $pelanggan->update($validated);

        return response()->json([
            'message' => 'Data pelanggan berhasil diperbarui',
            'data' => $pelanggan->fresh(),
        ]);
    }

    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();

            return response()->json([
                'message' => 'Data pelanggan berhasil dihapus',
            ]);
        } catch (QueryException $e) {
            // Foreign key: pelanggan masih punya pesanan.
            return response()->json([
                'message' => 'Pelanggan tidak dapat dihapus karena masih memiliki data terkait.',
            ], 409);
        }
    }

    /** 0857... / +62 857... -> 62857..., sebelum divalidasi. */
    private function normalkanNomor(Request $request): void
    {
        if ($request->has('no_whatsapp')) {
            $request->merge([
                'no_whatsapp' => NomorWhatsapp::normalisasi($request->input('no_whatsapp')),
            ]);
        }
    }

    private function pesanValidasi(): array
    {
        return [
            'no_whatsapp.regex' => 'Nomor WhatsApp tidak valid (contoh: 085732240729).',
            'no_whatsapp.unique' => 'Nomor WhatsApp sudah terdaftar pada pelanggan lain.',
        ];
    }
}
