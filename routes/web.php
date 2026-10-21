
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



// DASHBOARD
// Dipertahankan sesuai route proyek awal.
Route::view('/dashboard', 'dashboard.index')
    ->name('dashboard');

    
/*
|--------------------------------------------------------------------------
| Preview Dashboard Owner
|--------------------------------------------------------------------------
| Khusus pengembangan frontend.
| Tidak memerlukan koneksi database.
*/

if (app()->environment('local')) {

    Route::view(
        '/owner',
        'owner.dashboard'
    )->name('owner.preview');

}

/*
|--------------------------------------------------------------------------
| Preview Dashboard Customer Service
|--------------------------------------------------------------------------
| Hanya untuk pengembangan frontend lokal.
*/

if (app()->environment('local')) {

    Route::view(
        '/preview-cs',
        'cs.dashboard'
    )->name('cs.preview');

}
