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
}
