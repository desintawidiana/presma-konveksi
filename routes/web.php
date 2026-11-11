<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// HALAMAN LOGIN
Route::view('/login', 'auth.login')
    ->name('login');

// PROSES LOGIN
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// PENGALIHAN DASHBOARD BERDASARKAN PERAN
Route::get('/dashboard', function () {
    $peran = Auth::user()->peran;

    if ($peran === 'OWNER') {
        return redirect()->route('dashboard.owner');
    }

    if ($peran === 'CS') {
        return redirect()->route('dashboard.cs');
    }

    abort(403, 'Kamu tidak memiliki akses ke halaman ini.');
})->middleware('auth')->name('dashboard');

// DASHBOARD OWNER
Route::get('/dashboard/owner', function () {
    if (Auth::user()->peran !== 'OWNER') {
        abort(403, 'Kamu tidak memiliki akses ke dashboard Owner.');
    }

    return view('owner.dashboard');
})->middleware('auth')->name('dashboard.owner');

// DASHBOARD CS
Route::get('/dashboard/cs', function () {
    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Kamu tidak memiliki akses ke dashboard CS.');
    }

    return view('cs.dashboard');
})->middleware('auth')->name('dashboard.cs');

// HALAMAN CUSTOMER CS
Route::get('/cs/customer', function () {
    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Kamu tidak memiliki akses ke halaman Customer.');
    }

    return view('cs.customer');
})->middleware('auth')->name('cs.customer');

// HALAMAN ORDER CS (daftar order, terhubung ke database lewat /api/pesanan)
Route::get('/cs/order', function () {
    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Kamu tidak memiliki akses ke halaman Order.');
    }

    return view('cs.order');
})->middleware('auth')->name('cs.order');

// HALAMAN DETAIL ORDER CS  (dibuka dengan /cs/order/detail?id=<id pesanan>)
Route::get('/cs/order/detail', function () {
    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Kamu tidak memiliki akses ke halaman Detail Order.');
    }

    return view('cs.order-detail');
})->middleware('auth')->name('cs.order.detail');

/*
|--------------------------------------------------------------------------
| PREVIEW FRONTEND (dari branch frontend)
|--------------------------------------------------------------------------
| Hanya untuk lingkungan local; tidak memakai login. Halaman yang sudah
| terhubung database akan mengarahkan ke /login bila dibuka lewat preview.
*/

if (app()->environment('local')) {

    // Preview Owner
    Route::view('/owner', 'owner.dashboard')
        ->name('owner.preview');

    // Preview Customer Service
    Route::view('/preview-cs', 'cs.dashboard')
        ->name('cs.preview');

    // Alias preview CS dari backend
    Route::view('/cs', 'cs.dashboard');

    Route::view('/preview-customer', 'cs.customer')
        ->name('cs.customer.preview');

    Route::view('/preview-order', 'cs.order')
        ->name('cs.order.preview');
}

Route::view('/preview-order/detail', 'cs.order-detail')
    ->name('cs.order.detail.preview');

require __DIR__.'/presma-public-order-preview.php';
