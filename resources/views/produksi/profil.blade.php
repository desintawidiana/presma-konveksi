@extends('layout.produksi')
@section('title', 'My Profile | Presma Konveksi')
@section('breadcrumb', 'Profil Saya')
@section('content')
@php
    $user = auth()->user();
    $nama = $user->nama ?? $user->name ?? 'Kepala Produksi';
    $username = $user->username ?? '';
    $role = $user->peran ?? 'PRODUKSI';
@endphp
<main class="produksi-main">
    <div class="produksi-page-heading"><div><h1>Profil Saya</h1><p>Kelola informasi akun Production Workspace.</p></div></div>
    <section class="profile-main-card">
        <div class="profile-cover"></div>
        <div class="profile-identity">
            <div class="profile-large-avatar" id="profile-avatar">{{ strtoupper(substr($nama,0,2)) }}</div>
            <div class="profile-identity-info">
                <h2 id="profile-display-name">{{ $nama }}</h2>
                <p>Kepala Produksi</p>
                <span class="profile-status"><span></span> Akun {{ ($user->aktif ?? true) ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
        </div>
        <div class="profile-divider"></div>
        <div class="profile-section">
            <div class="profile-section-heading">
                <div><h3>Informasi Pribadi</h3><p>Informasi dasar akun Kepala Produksi.</p></div>
                <button type="button" id="edit-profile-btn"><span class="material-symbols-outlined">edit</span>Edit Profil</button>
            </div>
            <form id="profile-form">
                <div class="profile-form-grid">
                    <div class="profile-field"><label>Nama Lengkap</label><input type="text" name="name" value="{{ $nama }}" readonly required></div>
                    <div class="profile-field"><label>Username</label><input type="text" name="username" value="{{ $username }}" readonly></div>
                    <div class="profile-field"><label>Nomor Telepon</label><input type="text" name="phone" value="{{ $user->no_telepon ?? $user->phone ?? '-' }}" readonly></div>
                    <div class="profile-field"><label>Jabatan</label><input type="text" value="Kepala Produksi" readonly></div>
                </div>
                <div class="profile-form-actions hidden" id="profile-actions">
                    <button type="button" id="cancel-profile-btn" class="btn-cancel-profile">Batal</button>
                    <button type="submit" id="save-profile-btn" class="btn-save-profile">Simpan Perubahan</button>
                </div>
                <p class="profile-save-feedback" id="profile-save-feedback" aria-live="polite"></p>
            </form>
        </div>
    </section>
    <section class="profile-security-card">
        <div class="profile-section-heading"><div><h3>Keamanan Akun</h3><p>Kelola keamanan dan akses akun Anda.</p></div></div>
        <div class="security-item">
            <div class="security-item-icon"><span class="material-symbols-outlined">lock</span></div>
            <div class="security-item-info"><strong>Password</strong><p>Perbarui password untuk menjaga keamanan akun.</p></div>
            <button type="button" id="change-password-btn">Ganti Password</button>
        </div>
        <div id="password-form" class="password-form hidden">
            <div class="profile-field"><label>Password Saat Ini</label><input type="password" placeholder="Masukkan password saat ini" autocomplete="current-password"></div>
            <div class="profile-field"><label>Password Baru</label><input type="password" placeholder="Masukkan password baru" autocomplete="new-password"></div>
            <div class="profile-field"><label>Konfirmasi Password Baru</label><input type="password" placeholder="Ulangi password baru" autocomplete="new-password"></div>
            <p class="profile-save-feedback">Penggantian password perlu endpoint backend agar dapat diverifikasi dan disimpan dengan aman.</p>
        </div>
    </section>
</main>
<script>
document.addEventListener('DOMContentLoaded',()=>{
 const form=document.getElementById('profile-form'),edit=document.getElementById('edit-profile-btn'),actions=document.getElementById('profile-actions'),feedback=document.getElementById('profile-save-feedback');
 const inputs=[...form.querySelectorAll('input[name]')],original=inputs.map(i=>i.value),key='presma_produksi_profile_demo_v1';
 const saved=JSON.parse(localStorage.getItem(key)||'null');if(saved){inputs.forEach(i=>{if(saved[i.name]!==undefined)i.value=saved[i.name]});}
 const sync=()=>{document.getElementById('profile-display-name').textContent=form.elements.name.value;document.getElementById('profile-avatar').textContent=form.elements.name.value.trim().split(/\s+/).map(x=>x[0]).join('').slice(0,2).toUpperCase()||'KP';};
 const setEditing=v=>{inputs.forEach(i=>i.readOnly=!v);actions.classList.toggle('hidden',!v);edit.classList.toggle('hidden',v);};
 edit.addEventListener('click',()=>{inputs.forEach(i=>i.dataset.before=i.value);setEditing(true);inputs[0].focus();});
 document.getElementById('cancel-profile-btn').addEventListener('click',()=>{inputs.forEach(i=>i.value=i.dataset.before??i.value);setEditing(false);sync();feedback.textContent='Perubahan dibatalkan.';});
 form.addEventListener('submit',e=>{e.preventDefault();const data=Object.fromEntries(new FormData(form));if(!data.name.trim()){feedback.textContent='Nama lengkap tidak boleh kosong.';return;}localStorage.setItem(key,JSON.stringify(data));setEditing(false);sync();feedback.textContent='Perubahan tersimpan pada browser untuk demo. Simpan permanen memerlukan endpoint update profil di Laravel.';});
 document.getElementById('change-password-btn').addEventListener('click',()=>document.getElementById('password-form').classList.toggle('hidden'));sync();
});
</script>
@endsection
