<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class PelangganController extends Controller
{
    // Menampilkan semua pelanggan
    public function index()
    {
        return response()->json([
            'message' => 'Data pelanggan berhasil diambil',
            'data' => Pelanggan::orderBy('id', 'desc')->get(),
        ]);
    }

    // Menambahkan pelanggan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'no_whatsapp' => 'required|string|max:20|unique:pelanggan,no_whatsapp',
            'instansi' => 'nullable|string|max:200',
            'sumber_informasi' => [
                'nullable',
                Rule::in([
                    'REKOMENDASI_TEMAN',
                    'INSTAGRAM',
                    'TIKTOK',
                    'IKLAN',
                    'FACEBOOK',
                    'LAINNYA',
                ]),
            ],
        ]);

        $pelanggan = Pelanggan::create($validated);

        return response()->json([
            'message' => 'Data pelanggan berhasil ditambahkan',
            'data' => $pelanggan,
        ], 201);
    }

    // Menampilkan satu pelanggan
    public function show(Pelanggan $pelanggan)
    {
        return response()->json([
            'message' => 'Detail pelanggan berhasil diambil',
            'data' => $pelanggan,
        ]);
    }

    // Mengubah data pelanggan
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:150',
            'no_whatsapp' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('pelanggan', 'no_whatsapp')
                    ->ignore($pelanggan->id),
            ],
            'instansi' => 'sometimes|nullable|string|max:200',
            'sumber_informasi' => [
                'sometimes',
                'nullable',
                Rule::in([
                    'REKOMENDASI_TEMAN',
                    'INSTAGRAM',
                    'TIKTOK',
                    'IKLAN',
                    'FACEBOOK',
                    'LAINNYA',
                ]),
            ],
        ]);

        $pelanggan->update($validated);

        return response()->json([
            'message' => 'Data pelanggan berhasil diperbarui',
            'data' => $pelanggan->fresh(),
        ]);
    }

    // Menghapus pelanggan
    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();

            return response()->json([
                'message' => 'Data pelanggan berhasil dihapus',
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Pelanggan tidak dapat dihapus karena masih memiliki data terkait.',
            ], 409);
        }
    }
}
