<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PesananController;

// API Pelanggan: index, store, show, update, destroy
Route::apiResource('pelanggan', PelangganController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

// API Pesanan
Route::get('/pesanan', [PesananController::class, 'index']);
Route::post('/pesanan', [PesananController::class, 'store']);

// API User
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
