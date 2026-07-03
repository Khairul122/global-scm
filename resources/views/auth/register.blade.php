@extends('layouts.guest')

@section('title', 'Daftar - Global SCM Risk Intel')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 min-h-screen w-full">
    <!-- Left Illustrative Panel (5 Columns) -->
    <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-12 text-white bg-slate-950 relative overflow-hidden">
        <!-- Technical Grid Background -->
        <div class="absolute inset-0 bg-[linear-gradient(rgba(20,184,166,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(20,184,166,0.04)_1px,transparent_1px)] bg-[size:32px_32px] pointer-events-none z-0"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none z-0"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-accent/10 rounded-full blur-3xl pointer-events-none z-0"></div>

        <!-- Top branding -->
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 z-10">
            <div class="bg-primary/20 p-2 rounded-xl border border-primary/30">
                <i class="fa-solid fa-earth-americas text-xl text-teal-400"></i>
            </div>
            <span class="font-heading font-extrabold text-xl tracking-wide">GlobalSCM <span class="text-teal-400">Intel</span></span>
        </a>

        <!-- Middle Rich Illustrative Dashboard Mockup -->
        <div class="my-auto space-y-10 z-10 animate-slide-up">
            <div class="space-y-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-400/10 border border-teal-400/20 text-teal-400 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-circle-nodes text-warning"></i> Geopolitical Connections
                </span>
                <h2 class="text-3xl font-extrabold leading-tight text-white">{{ __('Buat Akun Anda & Mulai Memantau') }}</h2>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    {{ __('Daftar akun hari ini untuk mempersonalisasi daftar pantauan Anda. Amankan rute rantai pasok Anda dari risiko iklim ekstrem dan guncangan ekonomi dunia.') }}
                </p>
            </div>

            <!-- ILLUSTRATION: Supply Chain Risk Hub Control Room Mockup (Register Version) -->
            <div class="relative w-full max-w-sm bg-slate-900/80 backdrop-blur-md border border-slate-800 p-6 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] space-y-6">
                <!-- Visual Map Pathway Simulation -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wide">
                        <span><i class="fa-solid fa-chart-pie text-teal-400 mr-1.5"></i> {{ __('Analisis Risiko Rata-Rata') }}</span>
                        <span class="text-teal-400 font-mono">CALCULATING...</span>
                    </div>
                    <!-- Node Map Box -->
                    <div class="h-32 bg-slate-950/60 rounded-xl relative border border-slate-800/80 p-4 flex flex-col justify-center overflow-hidden">
                        <!-- Connecting dotted pathways -->
                        <div class="space-y-3 z-10">
                            <!-- Progress Bar 1 -->
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] font-mono text-slate-300">
                                    <span>{{ __('Risiko Cuaca') }} (Weather)</span>
                                    <span class="text-teal-400">30% (LOW)</span>
                                </div>
                                <div class="progress-track bg-slate-850 h-2">
                                    <div class="progress-fill bg-teal-400" style="width: 30%"></div>
                                </div>
                            </div>
                            <!-- Progress Bar 2 -->
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] font-mono text-slate-300">
                                    <span>{{ __('Risiko Geopolitik') }} (News)</span>
                                    <span class="text-amber-400">55% (MEDIUM)</span>
                                </div>
                                <div class="progress-track bg-slate-850 h-2">
                                    <div class="progress-fill bg-amber-400" style="width: 55%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary widgets: Risk gauge and weather -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Volatility Widget -->
                    <div class="bg-slate-950/40 border border-slate-800/80 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ __('Kecepatan Update') }}</span>
                            <i class="fa-solid fa-bolt text-teal-400 text-xs"></i>
                        </div>
                        <strong class="text-xs font-mono text-slate-100">{{ __('Instan / Real-Time') }}</strong>
                    </div>

                    <!-- Extreme Weather Widget -->
                    <div class="bg-slate-950/40 border border-slate-800/80 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ __('Proteksi Data') }}</span>
                            <i class="fa-solid fa-lock text-emerald-400 text-xs"></i>
                        </div>
                        <strong class="text-xs font-mono text-slate-100">Encrypted</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom copyright -->
        <div class="text-xs text-slate-500 z-10 font-mono">
            &copy; {{ date('Y') }} GlobalSCM Intel. Dashboard Decision-Support System v1.0.5
        </div>
    </div>

    <!-- Right Form Panel (7 Columns) -->
    <div class="lg:col-span-7 flex flex-col justify-center p-6 sm:p-10 lg:p-12 bg-[#f4f7fb]"
         x-data="{ nameFocused: false, emailFocused: false, passwordFocused: false, confirmFocused: false }">
        
        <!-- Centered Register Form Card -->
        <div class="w-full max-w-md mx-auto animate-slide-up my-auto">
            <!-- Card wrapper with dynamic border glow on focus -->
            <div class="skeuo-card p-8 sm:p-10 bg-white transition-all duration-300 relative overflow-hidden"
                 :class="{ 'ring-2 ring-primary/45 border-transparent shadow-[0_12px_28px_rgba(15,118,110,0.15)]': nameFocused || emailFocused || passwordFocused || confirmFocused }">
                
                <div class="text-center mb-8">
                    <div class="bg-primary/10 inline-flex p-4 rounded-full mb-3">
                        <i class="fa-solid fa-user-plus text-primary text-2xl animate-[bounce_3s_infinite]"></i>
                    </div>
                    <h3 class="font-bold text-2xl text-dark">{{ __('Daftar Akun Baru') }}</h3>
                    <p class="text-muted-foreground text-sm mt-1">{{ __('Daftarkan diri Anda untuk memantau data risiko secara personal') }}</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <!-- Name Field -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="nameFocused ? 'text-primary' : ''">{{ __('Nama Lengkap') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="nameFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" class="input-skeuo !pl-9 transition-all" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Nama Lengkap Anda') }}" required autofocus
                                   @focus="nameFocused = true" @blur="nameFocused = false">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="emailFocused ? 'text-primary' : ''">{{ __('Alamat Email') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="emailFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" class="input-skeuo !pl-9 transition-all" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required
                                   @focus="emailFocused = true" @blur="emailFocused = false">
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="passwordFocused ? 'text-primary' : ''">{{ __('Password') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="passwordFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9 transition-all" id="password" name="password" placeholder="Minimal 8 karakter" required
                                   @focus="passwordFocused = true" @blur="passwordFocused = false">
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="confirmFocused ? 'text-primary' : ''">{{ __('Konfirmasi Password') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="confirmFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-shield"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9 transition-all" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Ulangi password') }}" required
                                   @focus="confirmFocused = true" @blur="confirmFocused = false">
                        </div>
                    </div>

                    <button type="submit" class="btn-skeuo w-full !min-h-12 !text-base mt-4 relative overflow-hidden group">
                        <span class="absolute inset-0 w-full h-full bg-white/10 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            {{ __('Daftar Sekarang') }} <i class="fa-solid fa-arrow-right-to-bracket transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </button>

                    <!-- Divider & Navigation Buttons integrated inside the form card -->
                    <div class="text-center pt-4 border-t border-border mt-5 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            {{ __('Sudah punya akun?') }} 
                            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">
                                {{ __('Masuk di Sini') }}
                            </a>
                        </p>
                        
                        <div class="pt-2 flex gap-2">
                            <a href="{{ route('home') }}" class="btn-skeuo-outline flex-grow flex items-center justify-center gap-2 !min-h-11 hover:scale-[1.01] active:scale-95 transition-all">
                                <i class="fa-solid fa-house"></i> {{ __('Kembali ke Beranda') }}
                            </a>
                            <!-- Lang Switcher in Card -->
                            <div class="flex items-center border border-border rounded-xl px-2 bg-surface">
                                <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() === 'id' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground hover:text-foreground' }}">ID</a>
                                <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() === 'en' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground hover:text-foreground' }}">EN</a>
                            </div>
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
