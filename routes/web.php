
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
Route::view('/dashboard/owner', 'owner.dashboard')
    ->middleware('auth')
    ->name('dashboard.owner');

// DASHBOARD CS
Route::get('/dashboard/cs', function () {
    if (Auth::user()->peran !== 'CS') {
        abort(403, 'Kamu tidak memiliki akses ke dashboard CS.');
    }

    return view('cs.dashboard');
})->middleware('auth')->name('dashboard.cs');

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
