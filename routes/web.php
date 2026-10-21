
<?php

use Illuminate\Support\Facades\Route;
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
    ->name('logout');

// DASHBOARD
Route::view('/dashboard', 'owner.dashboard')
    ->middleware('auth')
    ->name('dashboard');
