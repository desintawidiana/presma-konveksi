<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Pemakaian di route:  ->middleware('peran:CS,OWNER')
 *
 * Kolom pengguna.peran bertipe SET('OWNER','CS','PRODUKSI'), jadi nilainya
 * bisa berupa "CS,PRODUKSI". Karena itu dipecah dulu sebelum dicocokkan.
 */
class PeranMiddleware
{
    public function handle(Request $request, Closure $next, string ...$peranDiizinkan)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Belum login.'], 401);
        }

        $peranUser = array_map('trim', explode(',', (string) $user->peran));

        if (!array_intersect($peranUser, $peranDiizinkan)) {
            return response()->json([
                'message' => 'Kamu tidak memiliki akses ke fitur ini.',
            ], 403);
        }

        return $next($request);
    }
}
