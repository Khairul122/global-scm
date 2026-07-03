@extends('layouts.guest')

@section('title', 'Masuk - Global SCM Risk Intel')

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
                    <i class="fa-solid fa-shield-halved animate-pulse"></i> {{ __('Sistem Pengambilan Keputusan') }}
                </span>
                <h2 class="text-3xl font-extrabold leading-tight text-white">{{ __('Keputusan Logistik yang Cerdas Dimulai di Sini') }}</h2>
                <p class="text-slate-400 text-sm leading-relaxed max-w-sm">
                    {{ __('Masuk untuk mengakses dasbor risiko kustom, memantau watchlist Anda, menganalisis pelabuhan global, dan mengambil keputusan mitigasi rantai pasok berbasis data.') }}
                </p>
            </div>

            <!-- ILLUSTRATION: Supply Chain Risk Hub Control Room Mockup -->
            <div class="relative w-full max-w-sm bg-slate-900/80 backdrop-blur-md border border-slate-800 p-6 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] space-y-6">
                <!-- Visual Map Pathway Simulation -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-xs text-slate-400 font-bold uppercase tracking-wide">
                        <span><i class="fa-solid fa-route text-teal-400 mr-1.5"></i> {{ __('Rute Logistik Aktif') }}</span>
                        <span class="text-teal-400 font-mono">LIVE FEED</span>
                    </div>
                    <!-- Node Map Box -->
                    <div class="h-32 bg-slate-950/60 rounded-xl relative border border-slate-800/80 overflow-hidden">
                        <!-- Connecting dotted pathways -->
                        <svg class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                            <!-- Pathway 1 -->
                            <path d="M 30,80 Q 150,20 320,60" fill="none" stroke="rgba(20,184,166,0.2)" stroke-width="2" stroke-dasharray="4 4" />
                            <!-- Pathway 2 -->
                            <path d="M 30,80 Q 180,110 320,60" fill="none" stroke="rgba(20,184,166,0.3)" stroke-width="2" />
                            <!-- Animate dot moving along path -->
                            <circle r="4" fill="#2dd4bf">
                                <animateMotion dur="5s" repeatCount="indefinite" path="M 30,80 Q 180,110 320,60" />
                            </circle>
                        </svg>

                        <!-- Glowing Port Nodes -->
                        <div class="absolute left-8 top-16 flex flex-col items-center">
                            <span class="w-3 h-3 bg-teal-400 rounded-full animate-ping absolute"></span>
                            <span class="w-3 h-3 bg-teal-500 rounded-full border-2 border-slate-900 z-10"></span>
                            <span class="text-[9px] font-bold text-slate-400 mt-1 font-mono">JAKARTA</span>
                        </div>
                        <div class="absolute right-12 top-10 flex flex-col items-center">
                            <span class="w-3 h-3 bg-rose-400 rounded-full animate-ping absolute"></span>
                            <span class="w-3 h-3 bg-rose-500 rounded-full border-2 border-slate-900 z-10"></span>
                            <span class="text-[9px] font-bold text-slate-400 mt-1 font-mono">SHANGHAI</span>
                        </div>

                        <!-- Floating Boat Info Overlay -->
                        <div class="absolute left-1/3 top-6 bg-slate-900/90 border border-slate-800 px-2.5 py-1 rounded-lg flex items-center gap-1.5 shadow-md">
                            <i class="fa-solid fa-ship text-[10px] text-teal-400"></i>
                            <span class="text-[9px] font-bold text-slate-300 font-mono">CARGO_122</span>
                        </div>
                    </div>
                </div>

                <!-- Secondary widgets: Risk gauge and weather -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Volatility Widget -->
                    <div class="bg-slate-950/40 border border-slate-800/80 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ __('Kurs Volas') }}</span>
                            <i class="fa-solid fa-chart-line text-emerald-400 text-xs"></i>
                        </div>
                        <strong class="text-sm font-mono text-slate-100">USD/IDR</strong>
                        <div class="flex items-center gap-1 text-[10px] text-emerald-400 mt-1 font-bold">
                            <i class="fa-solid fa-caret-up"></i> +0.42%
                        </div>
                    </div>

                    <!-- Extreme Weather Widget -->
                    <div class="bg-slate-950/40 border border-slate-800/80 p-3 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ __('Indeks Cuaca') }}</span>
                            <i class="fa-solid fa-cloud-showers-water text-rose-400 text-xs"></i>
                        </div>
                        <strong class="text-sm font-mono text-slate-100">Storm Risk</strong>
                        <div class="flex items-center gap-1 text-[10px] text-rose-400 mt-1 font-bold">
                            <i class="fa-solid fa-triangle-exclamation animate-pulse"></i> {{ __('Tinggi') }}
                        </div>
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
         x-data="{ emailFocused: false, passwordFocused: false }">
        
        <!-- Centered Login Form Card -->
        <div class="w-full max-w-md mx-auto animate-slide-up my-auto">
            <!-- Card wrapper with dynamic border glow on focus -->
            <div class="skeuo-card p-8 sm:p-10 bg-white transition-all duration-300 relative overflow-hidden"
                 :class="{ 'ring-2 ring-primary/45 border-transparent shadow-[0_12px_28px_rgba(15,118,110,0.15)]': emailFocused || passwordFocused }">
                
                <div class="text-center mb-8">
                    <div class="bg-primary/10 inline-flex p-4 rounded-full mb-3">
                        <i class="fa-solid fa-lock text-primary text-2xl animate-[bounce_3s_infinite]"></i>
                    </div>
                    <h3 class="font-bold text-2xl text-dark">{{ __('Masuk Platform') }}</h3>
                    <p class="text-muted-foreground text-sm mt-1">{{ __('Gunakan akun Anda untuk mengakses fitur watchlist personal') }}</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="emailFocused ? 'text-primary' : ''">{{ __('Alamat Email') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="emailFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" class="input-skeuo !pl-9 transition-all" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gmail.com" required autofocus
                                   @focus="emailFocused = true" @blur="emailFocused = false">
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                                   :class="passwordFocused ? 'text-primary' : ''">{{ __('Password') }}</label>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="passwordFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9 transition-all" id="password" name="password" placeholder="••••••••" required
                                   @focus="passwordFocused = true" @blur="passwordFocused = false">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" class="w-4 h-4 accent-primary rounded cursor-pointer" id="remember" name="remember">
                            <label class="text-sm text-muted-foreground cursor-pointer select-none" for="remember">{{ __('Ingat Saya') }}</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-skeuo w-full !min-h-12 !text-base mt-2 relative overflow-hidden group">
                        <span class="absolute inset-0 w-full h-full bg-white/10 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            {{ __('Masuk') }} <i class="fa-solid fa-arrow-right-to-bracket transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </button>

                    <!-- Divider & Navigation Buttons integrated inside the form card -->
                    <div class="text-center pt-4 border-t border-border mt-5 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            {{ __('Belum punya akun?') }} 
                            <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">
                                {{ __('Daftar Sekarang') }}
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
