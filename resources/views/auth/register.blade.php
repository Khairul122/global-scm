@extends('layouts.guest')

@section('title', 'Daftar - Global SCM Risk Intel')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 min-h-screen w-full">
    <!-- Left Decorative Panel (5 Columns) -->
    <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-12 text-white bg-gradient-to-br from-[#0f766e] via-[#0d9488] to-[#042f2e] relative overflow-hidden">
        <!-- Background glowing nodes -->
        <div class="absolute top-[-20%] left-[-20%] w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-80 h-80 bg-black/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <!-- Top branding -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 z-10">
            <i class="fa-solid fa-earth-americas text-2xl text-white"></i>
            <span class="font-heading font-bold text-xl tracking-wide">GlobalSCM <span class="opacity-85 text-white/90">Intel</span></span>
        </a>

        <!-- Middle Illustrative Graphics/Copy -->
        <div class="my-auto space-y-8 z-10 animate-slide-up">
            <div class="space-y-4">
                <h2 class="text-3xl font-extrabold leading-tight">Buat Akun Anda & Mulai Memantau</h2>
                <p class="text-teal-50/80 text-base leading-relaxed">
                    Daftar akun hari ini untuk mempersonalisasi daftar pantauan Anda. Amankan rute rantai pasok Anda dari risiko iklim ekstrem dan guncangan ekonomi dunia.
                </p>
            </div>

            <!-- Skeuomorphic indicator element inside decorative panel -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl shadow-xl space-y-4">
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 p-2 rounded-xl">
                        <i class="fa-solid fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-sm text-white">Real-Time Risk Feeds</h6>
                        <small class="text-teal-200/70 font-medium">Multiple Sources Synced</small>
                    </div>
                </div>
                <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs text-teal-100/80">
                    <span>Kecepatan Update</span>
                    <span class="font-bold bg-white/20 px-2 py-0.5 rounded-full">Instan / Real-Time</span>
                </div>
            </div>
        </div>

        <!-- Bottom copyright -->
        <div class="text-xs text-teal-200/50 z-10">
            &copy; {{ date('Y') }} GlobalSCM Intel. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Right Form Panel (7 Columns) -->
    <div class="lg:col-span-7 flex flex-col justify-between p-6 sm:p-10 lg:p-12 bg-[#f4f7fb]">
        <!-- Top Navigation Bar -->
        <div class="flex items-center justify-between w-full max-w-lg mx-auto lg:mx-0 lg:max-w-none">
            <a href="{{ route('home') }}" class="btn-skeuo-outline !min-h-10 !py-1.5 !px-4 text-sm flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Beranda
            </a>
            <div class="flex items-center gap-3">
                <span class="text-sm text-muted-foreground hidden sm:inline">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="btn-skeuo !min-h-10 !py-1.5 !px-4 text-sm">
                    Masuk
                </a>
            </div>
        </div>

        <!-- Centered Register Form Card -->
        <div class="flex-1 flex items-center justify-center my-8">
            <div class="w-full max-w-md animate-slide-up">
                <div class="skeuo-card p-8 sm:p-10 bg-white">
                    <div class="text-center mb-8">
                        <div class="bg-primary/10 inline-flex p-4 rounded-full mb-3">
                            <i class="fa-solid fa-user-plus text-primary text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-2xl text-dark">Daftar Akun Baru</h3>
                        <p class="text-muted-foreground text-sm mt-1">Daftarkan diri Anda untuk memantau data risiko secara personal</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-bold text-muted-foreground mb-1.5">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" class="input-skeuo !pl-9" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Anda" required autofocus>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-muted-foreground mb-1.5">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" class="input-skeuo !pl-9" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-bold text-muted-foreground mb-1.5">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" class="input-skeuo !pl-9" id="password" name="password" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-muted-foreground mb-1.5">Konfirmasi Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                    <i class="fa-solid fa-shield"></i>
                                </span>
                                <input type="password" class="input-skeuo !pl-9" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-skeuo w-full !min-h-12 !text-base mt-4">
                            Daftar Sekarang <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer for Mobile View (Hidden on large screens) -->
        <div class="text-center text-xs text-muted-foreground lg:hidden pt-4">
            &copy; {{ date('Y') }} GlobalSCM Intel
        </div>
    </div>
</div>
@endsection
