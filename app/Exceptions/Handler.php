<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Trigger/procedure di database memakai SIGNAL SQLSTATE '45000'
        // untuk menolak aturan bisnis (mis. "Pembayaran melebihi total
        // tagihan"). Ubah menjadi respons 422 berisi pesan aslinya agar
        // frontend bisa langsung menampilkannya.
        $this->renderable(function (QueryException $e, Request $request) {
            if (($e->errorInfo[0] ?? null) === '45000' && $request->expectsJson()) {
                return response()->json([
                    'message' => $e->errorInfo[2] ?? 'Aturan bisnis database menolak perubahan ini.',
                ], 422);
            }
        });
    }
}
