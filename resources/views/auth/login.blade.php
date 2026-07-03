@extends('layouts.guest')

@section('title', 'Masuk - Global SCM Risk Intel')

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
                <h2 class="text-3xl font-extrabold leading-tight">Keputusan Logistik yang Cerdas Dimulai di Sini</h2>
                <p class="text-teal-50/80 text-base leading-relaxed">
                    Masuk untuk mengakses dasbor risiko kustom, memantau watchlist Anda, menganalisis pelabuhan global, dan mengambil keputusan mitigasi rantai pasok berbasis data.
                </p>
            </div>

            <!-- Skeuomorphic indicator element inside decorative panel -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl shadow-xl space-y-4">
                <div class="flex items-center gap-3">
                    <div class="bg-white/15 p-2 rounded-xl">
                        <i class="fa-solid fa-shield-halved text-white text-lg"></i>
                    </div>
                    <div>
                        <h6 class="font-bold text-sm text-white">Risk Intelligence Mode</h6>
                        <small class="text-teal-200/70 font-medium">DSS Active & Monitor</small>
                    </div>
                </div>
                <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs text-teal-100/80">
                    <span>Negara Terpantau</span>
                    <span class="font-bold bg-white/20 px-2 py-0.5 rounded-full">20 Terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Bottom copyright -->
        <div class="text-xs text-teal-200/50 z-10">
            &copy; {{ date('Y') }} GlobalSCM Intel. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Right Form Panel (7 Columns) -->
    <div class="lg:col-span-7 flex flex-col justify-center p-6 sm:p-10 lg:p-12 bg-[#f4f7fb]">
        <!-- Centered Login Form Card -->
        <div class="w-full max-w-md mx-auto animate-slide-up my-auto">
            <div class="skeuo-card p-8 sm:p-10 bg-white">
                <div class="text-center mb-8">
                    <div class="bg-primary/10 inline-flex p-4 rounded-full mb-3">
                        <i class="fa-solid fa-lock text-primary text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-2xl text-dark">Masuk Platform</h3>
                    <p class="text-muted-foreground text-sm mt-1">Gunakan akun Anda untuk mengakses fitur watchlist personal</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-bold text-muted-foreground mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" class="input-skeuo !pl-9" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" required autofocus>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-bold text-muted-foreground">Password</label>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-muted-foreground/60 pointer-events-none">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9" id="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" id="remember" name="remember">
                            <label class="text-sm text-muted-foreground cursor-pointer select-none" for="remember">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-skeuo w-full !min-h-12 !text-base mt-2">
                        Masuk <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                    </button>

                    <!-- Divider & Navigation Buttons integrated inside the form card -->
                    <div class="text-center pt-4 border-t border-border mt-5 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">
                                Daftar Sekarang
                            </a>
                        </p>
                        
                        <div class="pt-2">
                            <a href="{{ route('home') }}" class="btn-skeuo-outline w-full flex items-center justify-center gap-2 !min-h-11">
                                <i class="fa-solid fa-house"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer for Mobile View (Hidden on large screens) -->
        <div class="text-center text-xs text-muted-foreground lg:hidden pt-4">
            &copy; {{ date('Y') }} GlobalSCM Intel
        </div>
    </div>
</div>
@endsection
