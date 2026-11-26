@extends('layout.owner')

@section('title', 'Manajemen Karyawan | Owner')

@section('content')

@php
    $employees = collect([
        (object) [
            'id' => 1,
            'nama' => 'Owner Presma',
            'username' => 'owner@presmakonveksi.com',
            'peran' => 'OWNER',
            'aktif' => 1,
            'dibuat_pada' => '2026-10-21',
        ],
        (object) [
            'id' => 2,
            'nama' => 'Customer Service Presma',
            'username' => 'cs.order@presmakonveksi.com',
            'peran' => 'CS',
            'aktif' => 1,
            'dibuat_pada' => '2026-10-21',
        ],
        (object) [
            'id' => 3,
            'nama' => 'Produksi Presma',
            'username' => 'produksi.spv@presmakonveksi.com',
            'peran' => 'PRODUKSI',
            'aktif' => 1,
            'dibuat_pada' => '2026-10-21',
        ],
    ]);

    $stats = [
        'total' => $employees->count(),
        'cs' => $employees->where('peran', 'CS')->count(),
        'produksi' => $employees->where('peran', 'PRODUKSI')->count(),
        'nonaktif' => $employees->where('aktif', 0)->count(),
    ];
@endphp

<style>
    .employee-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .employee-action-icon {
        width: 32px;
        height: 32px;
        min-width: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0dada;
        border-radius: 8px;
        background: #fff;
        color: #665858;
        cursor: pointer;
    }

    .employee-action-icon svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .employee-action-icon:hover {
        background: #f8f5f5;
        border-color: #870e12;
        color: #870e12;
    }

    .employee-action-icon.employee-delete {
        color: #a31515;
    }

    .employee-action-icon.employee-delete:hover {
        background: #fff0f0;
        border-color: #a31515;
    }

    .employee-action-icon:focus-visible {
        outline: 2px solid #870e12;
        outline-offset: 2px;
    }
</style>

<main class="owner-main">

    <div class="owner-page-heading">
        <div>
            <h1>Manajemen Karyawan</h1>
            <p>
                Pratinjau pengelolaan akun Owner, CS, dan Produksi.
                Data saat ini merupakan simulasi tampilan.
            </p>
        </div>

        <button
            class="owner-btn"
            type="button"
            onclick="document.getElementById('employee-create').scrollIntoView({behavior:'smooth'})">
            + Tambah Karyawan
        </button>
    </div>

    <section class="owner-grid owner-metrics">
        <article class="owner-card owner-metric">
            <div class="owner-metric-top">Total Akun</div>
            <strong>{{ $stats['total'] }}</strong>
        </article>

        <article class="owner-card owner-metric">
            <div class="owner-metric-top">Customer Service</div>
            <strong>{{ $stats['cs'] }}</strong>
        </article>

        <article class="owner-card owner-metric">
            <div class="owner-metric-top">Produksi</div>
            <strong>{{ $stats['produksi'] }}</strong>
        </article>

        <article class="owner-card owner-metric">
            <div class="owner-metric-top">Nonaktif</div>
            <strong>{{ $stats['nonaktif'] }}</strong>
        </article>
    </section>

    <section
        class="owner-card owner-panel"
        id="employee-create"
        style="margin-bottom:16px">

        <div class="owner-panel-heading">
            <div>
                <h2>Buat Akun Karyawan</h2>
                <p>
                    Form tampilan untuk rancangan pembuatan akun oleh Owner.
                    Belum menyimpan ke database.
                </p>
            </div>
        </div>

        <form class="owner-form-grid" data-employee-demo-form>
            <div class="owner-field">
                <label>Nama Lengkap</label>
                <input name="nama" required maxlength="100">
            </div>

            <div class="owner-field">
                <label>Username</label>
                <input name="username" required maxlength="50">
            </div>

            <div class="owner-field">
                <label>Peran</label>
                <select name="peran" required>
                    <option value="CS">Customer Service (CS)</option>
                    <option value="PRODUKSI">Produksi</option>
                </select>
            </div>

            <div class="owner-field">
                <label>Password Awal</label>
                <div class="owner-password-input">
                    <input
                        type="password"
                        id="new-employee-password"
                        name="password"
                        minlength="8"
                        required>

                    <button
                        type="button"
                        data-toggle-password="new-employee-password"
                        aria-label="Tampilkan password">
                        ◉
                    </button>
                </div>
                <small>Minimal 8 karakter.</small>
            </div>

            <div class="owner-field">
                <label>Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    minlength="8"
                    required>
            </div>

            <div class="owner-modal-actions full">
                <button class="owner-btn" type="submit">
                    Pratinjau Buat Akun
                </button>
            </div>
        </form>

        <p class="owner-muted" style="margin-top:10px">
            Akun baru akan tersimpan setelah backend diintegrasikan.
        </p>
    </section>

    <section class="owner-card owner-panel">
        <div class="owner-panel-heading">
            <div>
                <h2>Daftar Semua Akun</h2>
                <p>Termasuk Owner, CS, dan Produksi.</p>
            </div>
        </div>

        <div class="owner-table-wrap">
            <table class="owner-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Peran</th>
                        <th>Dibuat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td><strong>{{ $employee->nama }}</strong></td>
                            <td>{{ $employee->username }}</td>
                            <td>{{ $employee->peran }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($employee->dibuat_pada)->format('d/m/Y') }}
                            </td>
                            <td>
                                <span class="owner-badge green">Aktif</span>
                            </td>
                            <td>
                                <div class="employee-actions">
                                    @if ($employee->peran !== 'OWNER')

                                        <button
                                            type="button"
                                            class="owner-btn-light employee-action-icon"
                                            data-demo-employee-action="status"
                                            title="Nonaktifkan akun"
                                            aria-label="Nonaktifkan akun {{ $employee->nama }}">
                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                <circle cx="9" cy="7" r="4"/>
                                                <circle cx="18" cy="12" r="4"/>
                                                <path d="M16 12h4"/>
                                            </svg>
                                        </button>

                                        <button
                                            type="button"
                                            class="owner-btn-light employee-action-icon employee-delete"
                                            data-demo-employee-action="delete"
                                            title="Hapus akun"
                                            aria-label="Hapus akun {{ $employee->nama }}">
                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true">
                                                <path d="M3 6h18M9 6V4h6v2"/>
                                                <path d="M5 6l1 14h12l1-14"/>
                                                <path d="M10 10v6m4-6v6"/>
                                            </svg>
                                        </button>

                                    @else
                                        <span class="owner-muted">Akun utama</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="owner-table-footer">
            <span>Menampilkan {{ $employees->count() }} akun contoh</span>
            <span>Data demo — belum terhubung database</span>
        </div>
    </section>

</main>
@endsection