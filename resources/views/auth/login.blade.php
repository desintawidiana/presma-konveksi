
@extends('layouts.auth')

@section('title', 'Login | Presma Operations')

@section('content')

<div class="login-page">

    <div class="login-container">

        <!-- Kartu Login -->
        <div class="login-card">

            <!-- Header Login -->
            <div class="login-header">

                <div class="login-logo">
                    <span class="material-symbols-outlined">
                        apparel
                    </span>
                </div>

                <span class="login-label">
                    INTERNAL ERP & SCM
                </span>

                <h1>Presma Operations</h1>

                <p>
                    Kelola operasional Presma Konveksi
                    dalam satu sistem.
                </p>

            </div>

            <!-- Form Login -->
            <form
                id="loginForm"
                method="POST"
                action="{{ url('/login') }}"
            >
                @csrf

                <!-- Email / Username -->
                <div class="form-group">

                    <div class="label-row">
                        <label for="identifier">
                            Email / Username
                        </label>

                        <span class="access-label">
                            Akses Resmi
                        </span>
                    </div>

                    <div class="input-wrapper">

                        <span class="material-symbols-outlined input-icon">
                            badge
                        </span>

                        <input
                            type="text"
                            id="identifier"
                            name="identifier"
                            placeholder="Email atau username"
                            value="{{ old('identifier') }}"
                            autocomplete="username"
                            required
                        >

                    </div>

                    @error('identifier')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <!-- Password -->
                <div class="form-group">

                    <label for="password">
                        Kata Sandi
                    </label>

                    <div class="input-wrapper">

                        <span class="material-symbols-outlined input-icon">
                            lock
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="toggle-password"
                            aria-label="Tampilkan kata sandi"
                        >
                            <span
                                class="material-symbols-outlined"
                                id="passwordIcon"
                            >
                                visibility
                            </span>
                        </button>

                    </div>

                    @error('password')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <!-- Remember & Forgot -->
                <div class="form-options">

                    <label class="remember-me">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>Ingat saya</span>

                    </label>

                    <span class="forgot-password">
                        Hubungi admin jika lupa kata sandi
                    </span>

                </div>

                <!-- Tombol Login -->
                <button
                    type="submit"
                    class="login-button"
                    id="loginButton"
                >
                    <span>Masuk</span>

                    <span class="material-symbols-outlined">
                        arrow_forward
                    </span>
                </button>

            </form>

            <!-- Informasi Keamanan -->
            <div class="login-security">

                <span class="material-symbols-outlined">
                    verified_user
                </span>

                <p>
                    Akses khusus staf dan manajemen
                    Presma Konveksi.
                </p>

            </div>

        </div>

        <!-- Footer -->
        <div class="login-footer">

            <span>
                Presma Operations
            </span>

            <span>
                Internal Management System
            </span>

        </div>

    </div>

</div>

@endsection
