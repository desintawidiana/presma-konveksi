<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();

        return response()->json([
            'message' => 'Data pelanggan berhasil diambil',
            'data' => $pelanggan,
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'no_whatsapp' => 'required|string|max:20|unique:pelanggan,no_whatsapp',
            'instansi' => 'nullable|string|max:200',
            'sumber_informasi' => 'nullable|in:REKOMENDASI_TEMAN,INSTAGRAM,TIKTOK,IKLAN,FACEBOOK,LAINNYA',
        ]);

        $pelanggan = Pelanggan::create($validated);

        return response()->json([
            'message' => 'Data pelanggan berhasil ditambahkan',
            'data' => $pelanggan,
        ], 201);
    }
}