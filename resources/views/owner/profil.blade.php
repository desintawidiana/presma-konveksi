@extends('layout.owner')

@section('title', 'My Profile | Presma Konveksi')
@section('breadcrumb', 'Profil Saya')

@section('content')
@php
    $user = auth()->user();
    $nama = $user->nama ?? $user->name ?? 'Owner Presma';
    $username = $user->username ?? '';
    $role = $user->peran ?? 'OWNER';

    $inisial = collect(preg_split('/\s+/', trim($nama)))
        ->filter()
        ->take(2)
        ->map(fn ($kata) => strtoupper(substr($kata, 0, 1)))
        ->implode('');
@endphp

<main class="owner-main owner-profile-page">

    <div class="owner-page-heading">
        <div>
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun Owner Workspace.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="owner-profile-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="owner-profile-error">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="profile-main-card">
        <div class="profile-cover"></div>

        <div class="profile-identity">
            <div class="profile-large-avatar" id="profile-avatar">
                {{ $inisial ?: 'OW' }}
            </div>

            <div class="profile-identity-info">
                <h2 id="profile-display-name">{{ $nama }}</h2>
                <p>Owner</p>

                <span class="profile-status">
                    <span></span>
                    Akun {{ ($user->aktif ?? true) ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>

        <div class="profile-divider"></div>

        <div class="profile-section">
            <div class="profile-section-heading">
                <div>
                    <h3>Informasi Pribadi</h3>
                    <p>Informasi dasar akun Owner.</p>
                </div>

                <button type="button" id="edit-profile-btn">
                    <span class="material-symbols-outlined">edit</span>
                    Edit Profil
                </button>
            </div>

            <form id="profile-form"
                  action="{{ route('owner.profile.update') }}"
                  method="POST">
                @csrf
                @method('PATCH')

                <div class="profile-form-grid">
                    <div class="profile-field">
                        <label for="profile-name">Nama Lengkap</label>
                        <input id="profile-name" type="text"
                               name="name" value="{{ $nama }}"
                               readonly required>
                    </div>

                    <div class="profile-field">
                        <label for="profile-username">Username</label>
                        <input id="profile-username" type="text"
                               value="{{ $username }}" readonly>
                    </div>

                    <div class="profile-field">
                        <label for="profile-phone">Nomor Telepon</label>
                        <input id="profile-phone" type="text"
                               name="phone"
                               value="{{ $user->no_telepon ?? $user->phone ?? '' }}"
                               placeholder="Belum diisi" readonly>
                    </div>

                    <div class="profile-field">
                        <label for="profile-role">Jabatan</label>
                        <input id="profile-role" type="text"
                               value="{{ $role }}" readonly>
                    </div>
                </div>

                <div class="profile-form-actions hidden" id="profile-actions">
                    <button type="button" id="cancel-profile-btn"
                            class="btn-cancel-profile">
                        Batal
                    </button>

                    <button type="submit" class="btn-save-profile">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </section>

    <section class="profile-security-card">
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

        <form id="password-form" class="password-form hidden"
              action="{{ route('owner.profile.password') }}"
              method="POST">
            @csrf
            @method('PATCH')

            <div class="profile-field">
                <label for="current-password">Password Saat Ini</label>
                <input id="current-password" type="password"
                       name="current_password" autocomplete="current-password"
                       required>
            </div>

            <div class="profile-field">
                <label for="new-password">Password Baru</label>
                <input id="new-password" type="password"
                       name="password" autocomplete="new-password"
                       minlength="8" required>
            </div>

            <div class="profile-field">
                <label for="confirm-password">Konfirmasi Password Baru</label>
                <input id="confirm-password" type="password"
                       name="password_confirmation" autocomplete="new-password"
                       minlength="8" required>
            </div>

            <div class="profile-form-actions">
                <button type="button" id="cancel-password-btn"
                        class="btn-cancel-profile">
                    Batal
                </button>
                <button type="submit" class="btn-save-profile">
                    Simpan Password
                </button>
            </div>
        </form>
    </section>
</main>

<style>
    .owner-profile-page .profile-main-card,
    .owner-profile-page .profile-security-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .owner-profile-page .profile-cover {
        height: 100px;
        background: linear-gradient(110deg, #830909, #a43838);
    }

    .owner-profile-page .profile-identity {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 0 20px 16px;
        margin-top: -30px;
    }

    .owner-profile-page .profile-large-avatar {
        width: 64px;
        height: 64px;
        flex-shrink: 0;
        display: grid;
        place-items: center;
        border: 3px solid white;
        border-radius: 50%;
        background: #830909;
        color: white;
        font-weight: 700;
    }

    .owner-profile-page .profile-identity-info {
        padding-top: 30px;
    }

    .owner-profile-page .profile-identity-info h2,
    .owner-profile-page .profile-section-heading h3,
    .owner-profile-page p {
        margin: 0;
    }

    .owner-profile-page .profile-status {
        color: #16834b;
        font-size: 11px;
        font-weight: 600;
    }

    .owner-profile-page .profile-divider {
        border-top: 1px solid #e5e7eb;
    }

    .owner-profile-page .profile-section,
    .owner-profile-page .profile-security-card {
        padding: 20px;
    }

    .owner-profile-page .profile-section-heading,
    .owner-profile-page .security-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .owner-profile-page .profile-section-heading {
        margin-bottom: 16px;
    }

    .owner-profile-page .profile-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .owner-profile-page .profile-field label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .owner-profile-page .profile-field input {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #dce0e3;
        border-radius: 7px;
        background: #f3f4f5;
        font: inherit;
        font-size: 12px;
    }

    .owner-profile-page .profile-field input:not([readonly]) {
        background: white;
        border-color: #830909;
    }

    .owner-profile-page .profile-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 16px;
    }

    .owner-profile-page .security-item {
        padding-top: 14px;
        border-top: 1px solid #e5e7eb;
    }

    .owner-profile-page .security-item-info {
        flex: 1;
    }

    .owner-profile-page .security-item-icon {
        color: #830909;
    }

    .owner-profile-page .password-form {
        display: grid;
        gap: 12px;
        margin-top: 16px;
    }

    .owner-profile-page .profile-section-heading button,
    .owner-profile-page .security-item button,
    .owner-profile-page .btn-cancel-profile,
    .owner-profile-page .btn-save-profile {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 7px;
        background: white;
        color: #830909;
        font-size: 12px;
        cursor: pointer;
    }

    .owner-profile-page .btn-save-profile {
        background: #830909;
        border-color: #830909;
        color: white;
    }

    .owner-profile-page .owner-profile-success,
    .owner-profile-page .owner-profile-error {
        padding: 10px;
        margin-bottom: 12px;
        border-radius: 7px;
        font-size: 12px;
    }

    .owner-profile-page .owner-profile-success {
        background: #e8f5ed;
        color: #166534;
    }

    .owner-profile-page .owner-profile-error {
        background: #fce8e8;
        color: #991b1b;
    }

    .owner-profile-page .hidden {
        display: none !important;
    }

    @media (max-width: 640px) {
        .owner-profile-page .profile-form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('profile-form');
    const edit = document.getElementById('edit-profile-btn');
    const actions = document.getElementById('profile-actions');
    const nameInput = document.getElementById('profile-name');
    const phoneInput = document.getElementById('profile-phone');

    const setEditing = (editing) => {
        nameInput.readOnly = !editing;
        phoneInput.readOnly = !editing;
        actions.classList.toggle('hidden', !editing);
        edit.classList.toggle('hidden', editing);
    };

    edit.addEventListener('click', () => {
        setEditing(true);
        nameInput.focus();
    });

    document.getElementById('cancel-profile-btn')
        .addEventListener('click', () => {
            form.reset();
            setEditing(false);
        });

    document.getElementById('change-password-btn')
        .addEventListener('click', () => {
            document.getElementById('password-form')
                .classList.toggle('hidden');
        });

    document.getElementById('cancel-password-btn')
        .addEventListener('click', () => {
            const passwordForm = document.getElementById('password-form');
            passwordForm.reset();
            passwordForm.classList.add('hidden');
        });

    @if ($errors->has('name') || $errors->has('phone'))
        setEditing(true);
    @endif

    @if ($errors->has('current_password') || $errors->has('password'))
        document.getElementById('password-form').classList.remove('hidden');
    @endif
});
</script>
@endsection