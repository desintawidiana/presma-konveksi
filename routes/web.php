<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Presma Operations
|--------------------------------------------------------------------------
*/

// HALAMAN UTAMA
// Saat membuka http://127.0.0.1:8000
// langsung menampilkan Login.
Route::view('/', 'auth.login')
    ->name('home');


// HALAMAN LOGIN
// Saat membuka http://127.0.0.1:8000/login
// menampilkan Login yang sama.
Route::view('/login', 'auth.login')
    ->name('login');


// PREVIEW LOGIN
// Hanya tersedia pada environment local.
if (app()->environment('local')) {

    Route::view('/preview-login', 'auth.login')
        ->name('preview.login');

}


// DASHBOARD
// Dipertahankan sesuai route proyek awal.
Route::view('/dashboard', 'dashboard.index')
    ->name('dashboard');