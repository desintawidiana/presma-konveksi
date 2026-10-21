
@extends('layout.auth')

@section('title', 'Login | Presma Operations')
@section('content')
<div class="flex flex-col w-full items-center justify-center py-space-xl px-space-md">
 <div class="relative w-full max-w-[460px]">
  <div class="absolute -top-12 -left-12 w-48 h-48 rounded-full bg-primary-fixed opacity-40 blur-3xl pointer-events-none">
  </div>
  <div class="absolute -bottom-10 -right-10 w-44 h-44 rounded-full bg-tertiary-fixed opacity-30 blur-2xl pointer-events-none">
  </div>
  <div class="relative bg-surface-container-lowest rounded-xl shadow-sm p-space-xl flex flex-col space-y-space-lg">
   <div class="flex flex-col items-center text-center">
    <div class="flex items-center justify-center mb-space-md">
     <img alt="Presma Konveksi Logo" class="h-14 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2jpkBKyKwo2memhFqZzYuprVflzOSd_kAq30sXsPyLEKrFlHhT3kNHJ0dw5g6b52a6csR05mZTQv5xkhmNrpMOvYm9fA42TY-5qKS9LdSPp2Jj4Oxsh5cmz_W56hORjj6oYNTk1cVfVS19ssm4rCtzt9Rr3EkGPbDgzTczzwij9iIcqG2T2oYsQ4wC3hG0UgkGIClZrq6gPxH6Qx_YlZYbhT0Bh-lUJzPWk99ZKg_lmqNowPRPySXMTkmPm4MY4wu0e8"/>
    </div>
    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-1">
     Internal ERP &amp; SCM
    </span>
    <h1 class="font-headline-lg text-headline-lg text-on-surface">
     Presma Operations
    </h1>
    <p class="font-body-md text-body-md text-secondary mt-1 max-w-[340px]">
     Kelola operasional Presma Konveksi dalam satu sistem.
    </p>
   </div>
   <form action="{{ route('login.process') }}" method="POST" id="loginForm" class="flex flex-col space-y-space-md">
    @csrf
    @if ($errors->has('identifier'))
        <div class="rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
            {{ $errors->first('identifier') }}
        </div>
    @endif
    <div class="flex flex-col space-y-1.5">
     <label class="font-label-md text-label-md text-on-surface flex items-center justify-between" for="identifier">
      <span class="">
       Email / Username
      </span>
      <span class="font-label-sm text-label-sm text-secondary">
       Akses Resmi
      </span>
     </label>
     <div class="relative flex items-center">
      <span class="material-symbols-outlined absolute left-3 text-secondary text-[20px] pointer-events-none select-none">
       badge
      </span>
      <input autocomplete="username" class="w-full h-[40px] pl-10 pr-3 rounded-lg bg-surface-container-lowest text-on-surface placeholder:text-secondary/60 font-body-md text-body-md shadow-sm outline-none focus:bg-surface-container-lowest transition-colors" id="identifier" name="identifier" placeholder="nama@presmakonveksi.com atau username" required="" type="text" value="{{ old('identifier') }}"/>
     </div>
    </div>
    <div class="flex flex-col space-y-1.5">
     <label class="font-label-md text-label-md text-on-surface" for="password">
      Kata Sandi
     </label>
     <div class="relative flex items-center">
      <span class="material-symbols-outlined absolute left-3 text-secondary text-[20px] pointer-events-none select-none">
       lock
      </span>
      <input autocomplete="current-password" class="w-full h-[40px] pl-10 pr-10 rounded-lg bg-surface-container-lowest text-on-surface placeholder:text-secondary/60 font-body-md text-body-md shadow-sm outline-none focus:bg-surface-container-lowest transition-colors" id="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" required="" type="password"/>
      <button aria-label="Tampilkan atau sembunyikan kata sandi" class="absolute right-2 p-1.5 text-secondary hover:text-on-surface rounded-lg flex items-center justify-center transition-colors" id="togglePasswordBtn" type="button">
       <span class="material-symbols-outlined text-[20px]" id="pwdIcon">
        visibility
       </span>
      </button>
     </div>
    </div>
    <div class="flex items-center justify-between pt-1">
     <label class="flex items-center space-x-2 cursor-pointer select-none">
      <input class="w-4 h-4 rounded text-primary-container bg-surface-container cursor-pointer accent-[#830909]" id="rememberMe" name="remember" type="checkbox" value="1"/>
      <span class="font-body-sm text-body-sm text-on-surface">
       Ingat saya
      </span>
     </label>
     <a class="font-body-sm text-body-sm text-primary hover:text-primary-container font-medium underline underline-offset-4" href="#" id="forgotPassword">
      Lupa kata sandi?
     </a>
    </div>
    <button class="w-full h-[44px] rounded-lg bg-primary-container text-on-primary font-title-sm text-title-sm flex items-center justify-center space-x-2 shadow-sm hover:opacity-95 active:scale-[0.99] transition-all" id="submitBtn" type="submit">
     <span class="">
      Masuk
     </span>
     <span class="material-symbols-outlined text-[18px]">
      arrow_forward
     </span>
    </button>
   </form>
   <div class="bg-surface-container-low rounded-lg p-3 flex flex-col space-y-2">
    <div class="flex items-center justify-between">
     <div class="flex items-center space-x-1.5">
      <span class="material-symbols-outlined text-primary-container text-[16px]">
       touch_app
      </span>
      <span class="font-label-sm text-label-sm text-on-surface font-semibold">
       Contoh akun (pratinjau):
      </span>
     </div>
     <span class="font-label-sm text-label-sm text-secondary">
      Klik peran
     </span>
    </div>
    <div class="flex items-center gap-1.5 flex-wrap">
     <button class="px-2.5 py-1 rounded bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-sm text-label-sm shadow-sm transition-colors flex items-center space-x-1" data-demo-email="owner@presmakonveksi.com" type="button">
      <span class="w-1.5 h-1.5 rounded-full bg-primary-container">
      </span>
      <span class="">
       Owner
      </span>
     </button>
     <button class="px-2.5 py-1 rounded bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-sm text-label-sm shadow-sm transition-colors flex items-center space-x-1" data-demo-email="cs.order@presmakonveksi.com" type="button">
      <span class="w-1.5 h-1.5 rounded-full bg-tertiary-container">
      </span>
      <span class="">
       CS
      </span>
     </button>
     <button class="px-2.5 py-1 rounded bg-surface-container-lowest hover:bg-surface-container text-on-surface font-label-sm text-label-sm shadow-sm transition-colors flex items-center space-x-1" data-demo-email="produksi.spv@presmakonveksi.com" type="button">
      <span class="w-1.5 h-1.5 rounded-full bg-secondary">
      </span>
      <span class="">
       Tim Produksi
      </span>
     </button>
    </div>
   </div>
   <div class="flex items-start space-x-2 pt-1 text-center justify-center">
    <span class="material-symbols-outlined text-secondary text-[16px] shrink-0 mt-0.5">
     verified_user
    </span>
    <p class="font-body-sm text-body-sm text-secondary max-w-[340px]">
     Pratinjau antarmuka staf dan manajemen Presma Konveksi.
    </p>
   </div>
  </div>
  <div class="flex items-center justify-between px-space-sm mt-space-md text-secondary">
   <div class="flex items-center space-x-2">
    <span class="w-2 h-2 rounded-full bg-surface-tint">
    </span>
    <span class="font-label-sm text-label-sm">
     Mode Pengembangan
    </span>
   </div>
   <span class="font-label-sm text-label-sm font-data-tabular">
    Preview UI
   </span>
  </div>
 </div>
</div>

@endsection
