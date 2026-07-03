@extends('layouts.guest')

@section('title', 'Global Supply Chain Risk Intelligence Platform')

@section('content')
<!-- Hero Section (Full Screen Viewport) -->
<div class="relative overflow-hidden bg-gradient-to-tr from-[#eef2f7] via-[#f4f7fb] to-[#e0e7ff] min-h-[calc(100vh-4rem)] flex flex-col justify-center">
    <!-- Abstract premium geometric shapes / glowing background points -->
    <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/10 w-80 h-80 bg-accent/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 w-full z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-12">
            <!-- Left Headline Column -->
            <div class="lg:col-span-7 animate-slide-up space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 border border-primary/25 text-primary text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-circle-nodes animate-pulse"></i> Intelligent Decision Support
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-dark">
                    Pantau Risiko Rantai Pasok <br>
                    <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Secara Real-Time & Presisi</span>
                </h1>
                <p class="text-lg text-muted-foreground max-w-xl">
                    Integrasikan intelijen cuaca global ekstrem, volatilitas valuta asing, tingkat inflasi, dan sentimen berita geopolitik ke dalam dasbor analitis interaktif untuk kelancaran logistik Anda.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('login') }}" class="btn-skeuo !px-8 !py-3.5 !text-base group">
                        <i class="fa-solid fa-right-to-bracket transition-transform group-hover:translate-x-1"></i> Masuk ke Dasbor
                    </a>
                    <a href="{{ route('register') }}" class="btn-skeuo-outline !px-8 !py-3.5 !text-base">
                        Daftar Akun Baru
                    </a>
                </div>
            </div>

            <!-- Right Interactive Graphic Column -->
            <div class="lg:col-span-5 flex justify-center relative min-h-[350px]">
                <!-- Outer floating abstract circle -->
                <div class="absolute w-72 h-72 rounded-full border border-primary/10 animate-[spin_20s_linear_infinite] pointer-events-none z-0"></div>
                
                <div class="relative w-full max-w-sm z-10 flex flex-col justify-center">
                    <!-- Weather Card -->
                    <div class="skeuo-card p-6 text-left transform -rotate-3 hover:rotate-0 transition-transform duration-300 shadow-2xl bg-white/80 backdrop-blur-md">
                        <div class="flex items-center gap-3.5 mb-3">
                            <div class="bg-primary/10 p-3 rounded-2xl">
                                <i class="fa-solid fa-cloud-bolt text-primary text-2xl"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-base">Pemantauan Cuaca Ekstrem</h6>
                                <small class="text-muted-foreground font-semibold">Open-Meteo Integration</small>
                            </div>
                        </div>
                        <p class="text-sm text-muted-foreground">Deteksi badai, curah hujan tinggi, dan anomali iklim laut secara instan pada rute pelayaran internasional.</p>
                        <div class="mt-4 flex items-center justify-between border-t border-border pt-3">
                            <span class="text-xs font-bold text-muted-foreground">Status Pelayaran</span>
                            <span class="risk-low text-[10px]">NORMAL</span>
                        </div>
                    </div>

                    <!-- Currency / Volatility Card -->
                    <div class="skeuo-card p-6 text-left mt-6 ml-8 lg:ml-12 transform rotate-2 hover:rotate-0 transition-transform duration-300 shadow-2xl bg-white/80 backdrop-blur-md">
                        <div class="flex items-center gap-3.5 mb-3">
                            <div class="bg-success/10 p-3 rounded-2xl">
                                <i class="fa-solid fa-wallet text-success text-2xl"></i>
                            </div>
                            <div>
                                <h6 class="font-bold text-base">Volatilitas Kurs Valas</h6>
                                <small class="text-muted-foreground font-semibold">ExchangeRate API</small>
                            </div>
                        </div>
                        <p class="text-sm text-muted-foreground">Mengukur koefisien variasi mata uang lokal terhadap USD dalam 30 hari untuk kalkulasi biaya lindung nilai.</p>
                        <div class="mt-4 flex items-center justify-between border-t border-border pt-3">
                            <span class="text-xs font-bold text-muted-foreground">Volatilitas EUR/USD</span>
                            <span class="font-mono text-xs font-bold text-success"><i class="fa-solid fa-chart-line"></i> 1.25%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular Countries Grid Section -->
<div class="bg-white border-t border-border py-16 lg:py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <h2 class="text-3xl font-bold text-dark">Ringkasan Risiko Negara Populer</h2>
            <p class="text-muted-foreground">Indeks risiko komposit terintegrasi yang diperbarui berdasarkan data cuaca, sentimen berita, inflasi, dan nilai tukar uang terbaru.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($popular as $country)
            <div class="skeuo-card p-6 flex flex-col justify-between hover:scale-[1.02] transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <img src="{{ $country->flag_url }}" alt="Bendera {{ $country->name }}" width="45" class="rounded-xl shadow-sm border border-border">
                            <div>
                                <h5 class="font-bold text-base">{{ $country->name }}</h5>
                                <span class="text-xs text-muted-foreground font-medium">{{ $country->capital }}</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-earth-asia text-muted-foreground/30 text-xl"></i>
                    </div>

                    <div class="skeuo-inset p-4 my-6 text-center">
                        <span class="text-muted-foreground text-xs font-bold uppercase tracking-wider block mb-1">Skor Risiko SCM</span>
                        @if($country->latestRiskScore)
                            <h2 class="text-4xl font-extrabold font-mono text-dark tabular-nums">{{ round($country->latestRiskScore->total_score) }}</h2>
                            <div class="mt-2">
                                <span class="{{ $country->latestRiskScore->level === 'high' ? 'risk-high' : ($country->latestRiskScore->level === 'medium' ? 'risk-medium' : 'risk-low') }} text-[10px]">
                                    {{ strtoupper($country->latestRiskScore->level) }} RISK
                                </span>
                            </div>
                        @else
                            <h2 class="text-4xl font-extrabold text-muted-foreground/50">--</h2>
                            <div class="mt-2">
                                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold bg-muted text-muted-foreground">BELUM DIHITUNG</span>
                            </div>
                        @endif
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn-skeuo-outline w-full mt-2">
                    Buka Analisis Detail
                </a>
            </div>
            @empty
            <div class="col-span-full text-center py-12 bg-surface rounded-2xl border border-border">
                <i class="fa-regular fa-folder-open text-muted-foreground text-4xl mb-3"></i>
                <p class="text-muted-foreground">Tidak ada data negara populer saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
