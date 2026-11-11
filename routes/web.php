
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Halaman Login
Route::view('/login', 'auth.login')
    ->name('login');

// Proses Login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD BERDASARKAN PERAN
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| DASHBOARD OWNER
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/owner', function () {

    if (Auth::user()->peran !== 'OWNER') {
        abort(403, 'Akses hanya untuk Owner.');
    }

    return view('owner.dashboard');

})->middleware('auth')->name('dashboard.owner');

/*
|--------------------------------------------------------------------------
| DASHBOARD CUSTOMER SERVICE
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/cs', function () {

    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Akses hanya untuk Customer Service.');
    }

    return view('cs.dashboard');

})->middleware('auth')->name('dashboard.cs');

/*
|--------------------------------------------------------------------------
| PREVIEW FRONTEND
|--------------------------------------------------------------------------
| Hanya tersedia di lingkungan local.
| Tidak membutuhkan login/database.
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

}


if (app()->environment('local')) {
    Route::view('/preview-customer', 'cs.customer')
        ->name('cs.customer.preview');
}


if (app()->environment('local')) {
    Route::view('/preview-order', 'cs.order')
        ->name('cs.order.preview');
}

Route::view('/preview-order/detail', 'cs.order-detail')
    ->name('cs.order.detail.preview');

 require __DIR__.'/presma-public-order-preview.php';

Route::view('/preview-work-order', 'cs.work-order')
    ->name('cs.work-order.preview');

 if (app()->environment('local')) {
    Route::view('/preview-invoice-pembayaran', 'cs.invoice-pembayaran')
        ->name('cs.invoice-pembayaran.preview');

    Route::view('/preview-invoice/create', 'cs.invoice-create')
        ->name('cs.invoice.create.preview');

    Route::view('/preview-pembayaran/create', 'cs.pembayaran-create')
        ->name('cs.pembayaran.create.preview');
}

if (app()->environment('local')) {
    Route::view('/preview-tracking', 'tracking.index')
        ->name('cs.tracking.preview');
}

// Route aplikasi setelah autentikasi dan otorisasi role diaktifkan.
// Project saat ini memiliki OWNER dan CS. Tambahkan nilai role produksi
// sesuai nilai persis yang disimpan pada kolom users.peran.
Route::get('/tracking', function () {
    $role = strtoupper(trim(Auth::user()->peran ?? ''));
    $allowedRoles = ['OWNER', 'CS']; // Tambahkan 'PRODUKSI' jika role tersebut sudah dibuat.

    abort_unless(in_array($role, $allowedRoles, true), 403);

    // CS memakai layout.cs; Owner perlu view/layout khusus Owner.
    // Untuk saat ini route ini dipakai CS. Buat route terpisah untuk Owner
    // jika layout dan sidebar Owner berbeda.
    abort_unless($role === 'CS', 403, 'Route tampilan ini disiapkan untuk CS.');

    return view('tracking.index');
})->middleware('auth')->name('tracking.index');

Route::prefix('cs')->name('cs.')->group(function () {
    Route::view('/notifikasi', 'cs.notification')
        ->name('notification');

    Route::view('/profil', 'cs.profile')
        ->name('profile');
});