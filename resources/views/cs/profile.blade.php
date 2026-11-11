@extends('layout.cs')

@section('title', 'My Profile | Presma Konveksi')

@section('content')
<br><br>
        <!-- Informasi Profil -->
        <div class="profile-main-card">

            <div class="profile-cover"></div>

            <div class="profile-identity">
                <div class="profile-large-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'RH', 0, 2)) }}
                </div>

                <div class="profile-identity-info">
                    <h2>{{ auth()->user()->name ?? 'Rina Handayani' }}</h2>
                    <p>Senior Customer Service</p>
                    <span class="profile-status">
                        <span></span> Akun Aktif
                    </span>
                </div>
            </div>

            <div class="profile-divider"></div>

            <!-- Data Pribadi -->
            <div class="profile-section">
                <div class="profile-section-heading">
                    <div>
                        <h3>Informasi Pribadi</h3>
                        <p>Informasi dasar akun Customer Service.</p>
                    </div>
                    <button type="button" id="edit-profile-btn">
                        <span class="material-symbols-outlined">edit</span>
                        Edit Profil
                    </button>
                </div>

                <form id="profile-form">

                    <div class="profile-form-grid">

                        <div class="profile-field">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name ?? 'Rina Handayani' }}"
                                readonly>
                        </div>

                        <div class="profile-field">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" readonly>
                        </div>

                        <div class="profile-field">
                            <label>Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '-' }}" readonly>
                        </div>

                        <div class="profile-field">
                            <label>Jabatan</label>
                            <input type="text" value="Senior Customer Service" readonly>
                        </div>

                    </div>

                    <div class="profile-form-actions" id="profile-actions">
                        <button type="button" id="cancel-profile-btn" class="btn-cancel-profile">Batal</button>

                        <button type="button" id="save-profile-btn" class="btn-save-profile">Simpan Perubahan</button>
                    </div>

                </form>
            </div>

        </div>

        <!-- Keamanan Akun -->
        <div class="profile-security-card">

            <div class="profile-section-heading">
                <div>
                    <h3>Keamanan Akun</h3>
                    <p>Kelola keamanan dan akses akun Anda.</p>
                </div>
            </div>

            <div class="security-item">
                <div class="security-item-icon">
                    <span class="material-symbols-outlined">lock</span>
                </div>

                <div class="security-item-info">
                    <strong>Password</strong>
                    <p>Perbarui password untuk menjaga keamanan akun.</p>
                </div>

                <button type="button" id="change-password-btn">
                    Ganti Password
                </button>
            </div>

            <div id="password-form" class="password-form hidden">
                <div class="profile-field">
                    <label>Password Saat Ini</label>
                    <input type="password" placeholder="Masukkan password saat ini">
                </div>

                <div class="profile-field">
                    <label>Password Baru</label>
                    <input type="password" placeholder="Masukkan password baru">
                </div>

                <div class="profile-field">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" placeholder="Ulangi password baru">
                </div>
            </div>

        </div>

    </div>
@endsection
