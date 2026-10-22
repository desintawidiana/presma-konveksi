<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $authenticated = Auth::attempt([
            'username' => $credentials['identifier'],
            'password' => $credentials['password'],
            'aktif' => 1,
        ]);

        if (!$authenticated) {
            return back()
                ->withErrors([
                    'identifier' => 'Email/username atau kata sandi salah.',
                ])
                ->onlyInput('identifier');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}