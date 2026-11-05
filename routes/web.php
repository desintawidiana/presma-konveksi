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

// PREVIEW DASHBOARD OWNER
if (app()->environment('local')) {
    Route::view('/owner', 'owner.dashboard')
        ->name('owner.preview');
}

// PREVIEW DASHBOARD CS
if (app()->environment('local')) {
    Route::view('/cs', 'cs.dashboard')
        ->name('cs.preview');
}

// PREVIEW DETAIL PESANAN
if (app()->environment('local')) {
    Route::view('/preview-order/detail', 'cs.order-detail')
        ->name('cs.order.detail.preview');
}
