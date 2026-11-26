
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerPasswordController;

// HALAMAN UTAMA
Route::get('/', function () {
    return redirect()->route('login');
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
    $peran = trim((string) Auth::user()->peran);

    if ($peran === 'OWNER') {
        return redirect()->route('dashboard.owner');
    }

    if ($peran === 'CS') {
        return redirect()->route('dashboard.cs');
    }

    if ($peran === 'PRODUKSI') {
        return redirect()->route('dashboard.produksi');
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
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403, 'Kamu tidak memiliki akses ke dashboard CS.');
    }

    return view('cs.dashboard');
})->middleware('auth')->name('dashboard.cs');

// HALAMAN CUSTOMER CS
Route::get('/cs/customer', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403, 'Kamu tidak memiliki akses ke halaman Customer.');
    }

    return view('cs.customer');
})->middleware('auth')->name('cs.customer');

// HALAMAN ORDER CS
Route::get('/cs/order', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403, 'Kamu tidak memiliki akses ke halaman Order.');
    }

    return view('cs.order');
})->middleware('auth')->name('cs.order');

// HALAMAN DETAIL ORDER CS
Route::get('/cs/order/detail', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403, 'Kamu tidak memiliki akses ke halaman Detail Order.');
    }

    return view('cs.order-detail');
})->middleware('auth')->name('cs.order.detail');

// PREVIEW FRONTEND (LOCAL)
if (app()->environment('local')) {

    // Preview Owner
    Route::view('/owner', 'owner.dashboard')
        ->name('owner.preview');

    // Preview Customer Service
    Route::view('/preview-cs', 'cs.dashboard')
        ->name('cs.preview');

    // Alias preview CS
    Route::view('/cs', 'cs.dashboard');

    Route::view('/preview-customer', 'cs.customer')
        ->name('cs.customer.preview');

    Route::view('/preview-order', 'cs.order')
        ->name('cs.order.preview');
}

// PREVIEW DETAIL ORDER
Route::view('/preview-order/detail', 'cs.order-detail')
    ->name('cs.order.detail.preview');

// HALAMAN INVOICE & PEMBAYARAN CS
Route::get('/cs/invoice-pembayaran', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403);
    }

    return view('cs.invoice-pembayaran');
})->middleware('auth')->name('cs.invoice-pembayaran.preview');

// HALAMAN WORK ORDER CS
Route::get('/cs/work-order', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403);
    }

    return view('cs.work-order');
})->middleware('auth')->name('cs.work-order');

// HALAMAN TRACKING CS
Route::get('/cs/tracking', function () {
    if (!in_array(Auth::user()->peran, ['CS', 'OWNER', 'PRODUKSI'], true)) {
        abort(403);
    }

    return view('tracking.index');
})->middleware('auth')->name('cs.tracking');

// ROLE PRODUKSI
Route::middleware(['auth'])->group(function () {

    // DASHBOARD PRODUKSI
    Route::get('/dashboard/produksi', function () {
        abort_unless(
            in_array(trim((string) Auth::user()->peran), ['PRODUKSI', 'OWNER'], true),
            403
        );

        return view('produksi.dashboard');
    })->name('dashboard.produksi');

    // LIST ORDER PRODUKSI
    Route::get('/produksi/order', function () {
        abort_unless(
            in_array(trim((string) Auth::user()->peran), ['PRODUKSI', 'OWNER'], true),
            403
        );

        return view('produksi.order');
    })->name('produksi.order');

    Route::get('/produksi/proses', function () {
    return view('produksi.proses');
})->name('produksi.proses');

Route::get('/produksi/stok', function () {
    return view('produksi.stok');
})->name('produksi.stok');

Route::get('/produksi/pembelian', function () {
    return view('produksi.pembelian');
})->name('produksi.pembelian');
});
/*
|--------------------------------------------------------------------------
| ROLE PRODUKSI
|--------------------------------------------------------------------------
| Letakkan blok ini sebelum require presma-public-order-preview.php.
| Halaman tracking tetap memakai view tracking yang sudah ada.
*/
Route::middleware(['auth', 'peran:PRODUKSI,OWNER'])->group(function () {
    Route::get('/dashboard/produksi', function () {
        return view('produksi.dashboard');
    })->name('dashboard.produksi');

    Route::get('/produksi/order', function () {
        return view('produksi.order');
    })->name('produksi.order');

    Route::get('/produksi/proses', function () {
        return view('produksi.proses');
    })->name('produksi.proses');

    // Halaman stok dan pembelian berisi data dummy frontend pada tahap ini.
    Route::get('/produksi/stok', function () {
        return view('produksi.stok');
    })->name('produksi.stok');

    Route::get('/produksi/pembelian', function () {
        return view('produksi.pembelian');
    })->name('produksi.pembelian');

    Route::get('/produksi/notifikasi', function () {
        return view('produksi.notifikasi');
    })->name('produksi.notifikasi');
    
    Route::get('/produksi/profil', function () {
        return view('produksi.profil');
    })->name('produksi.profil');
});

// Tambahkan kondisi ini di route /dashboard yang sudah ada:
// if ($peran === 'PRODUKSI') return redirect()->route('dashboard.produksi');

// Tracking sudah tersedia. Ubah pengecekan role pada route cs.tracking
// agar menerima PRODUKSI dan OWNER juga.

// Tracking memakai halaman tracking yang sudah ada, tetapi diberi route khusus Produksi.
Route::get('/produksi/tracking', function () { return redirect()->route('cs.tracking'); })->middleware(['auth', 'peran:PRODUKSI,OWNER'])->name('produksi.tracking');

// Pastikan route cs.tracking yang sudah ada mengarah ke view Tracking yang sama dan middleware-nya mengizinkan CS, PRODUKSI, OWNER. Jika halaman Tracking memang publik untuk pelanggan, pertahankan route publik tersebut; jangan gandakan view/route.

Route::middleware(['auth', 'peran:OWNER'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::view('/order', 'owner.order')->name('order');
        Route::view('/produksi', 'owner.produksi')->name('produksi');

        // Tambahkan route tracking
        Route::get('/tracking', fn () => redirect()->route('cs.tracking'))->name('tracking');

        Route::view('/inventaris', 'owner.inventaris')->name('inventaris');
        Route::view('/keuangan', 'owner.keuangan')->name('keuangan');
        Route::view('/laporan', 'owner.laporan')->name('laporan');
        Route::view('/karyawan', 'owner.karyawan')->name('karyawan');
        Route::view('/notifikasi', 'owner.notifikasi')->name('notifikasi');
        Route::view('/profil', 'owner.profil')->name('profil');

    });

    use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

Route::patch('/owner/profil', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:30'],
    ]);

    $user = $request->user();
    $user->nama = $data['name'];
    $user->phone = $data['phone'] ?? null;
    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui.');
})->name('owner.profile.update');

Route::patch('/owner/profil/password', function (Request $request) {
    $data = $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed', Password::min(8)],
    ]);

    $user = $request->user();
    $user->password = Hash::make($data['password']);
    $user->save();

    return back()->with('success', 'Password berhasil diperbarui.');
})->name('owner.profile.password');
// PUBLIC ORDER PREVIEW
require __DIR__ . '/presma-public-order-preview.php';
