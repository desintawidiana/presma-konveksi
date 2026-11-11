<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Trigger & stored procedure di database memakai variabel sesi MySQL
 * @id_pengguna untuk mencatat "siapa yang mengubah" (tabel riwayat_perubahan
 * dan riwayat_tahap). Tanpa ini kolom diubah_oleh akan selalu NULL.
 *
 * Variabel sesi MySQL hidup per-koneksi, jadi harus diset di setiap request.
 */
class SetDbUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            DB::statement('SET @id_pengguna = ?', [Auth::id()]);
        }

        return $next($request);
    }
}
