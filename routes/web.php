
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
