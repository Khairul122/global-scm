@extends('layouts.guest')

@section('title', 'Global Supply Chain Risk Intelligence Platform')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-10 py-8">
    <div class="animate-slide-up">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
            Pantau Risiko Rantai Pasok <br>
            <span class="text-primary">Secara Real-Time</span>
        </h1>
        <p class="text-lg text-muted-foreground mb-6">
            Mengintegrasikan data cuaca global, fluktuasi valuta asing, inflasi ekonomi, dan analisis sentimen berita ke dalam satu dasbor cerdas berbasis Decision Support System.
        </p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('login') }}" class="btn-skeuo">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Dasbor
            </a>
            <a href="{{ route('register') }}" class="btn-skeuo-outline">
                Daftar Akun
            </a>
        </div>
    </div>
    <div class="text-center">
        <div class="inline-block relative p-6">
            <div class="skeuo-card p-5 text-left" style="max-width: 380px; transform: rotate(-3deg);">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-primary/10 p-2.5 rounded-xl">
                        <i class="fa-solid fa-cloud-bolt text-primary text-xl"></i>
                    </div>
                    <div>
                        <h6 class="font-bold">Pemantauan Cuaca</h6>
                        <small class="text-muted-foreground">Open-Meteo Integration</small>
                    </div>
                </div>
                <p class="text-sm text-muted-foreground">Deteksi risiko badai, curah hujan ekstrem, dan kecepatan angin kencang pada rute pelayaran utama.</p>
            </div>
            <div class="skeuo-card p-5 text-left mt-4" style="max-width: 380px; margin-left: 60px; transform: rotate(2deg);">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-success/10 p-2.5 rounded-xl">
                        <i class="fa-solid fa-wallet text-success text-xl"></i>
                    </div>
                    <div>
                        <h6 class="font-bold">Skor Volatilitas Valas</h6>
                        <small class="text-muted-foreground">ExchangeRate API</small>
                    </div>
                </div>
                <p class="text-sm text-muted-foreground">Mengukur perubahan kurs 30 hari terakhir untuk memitigasi risiko pembengkakan biaya logistik.</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Countries Section -->
<div class="py-10 mt-6">
    <div class="text-center mb-8">
        <h3 class="text-2xl font-bold">Ringkasan Risiko Negara Populer</h3>
        <p class="text-muted-foreground">Kondisi risiko terbaru berdasarkan integrasi data multi-API</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($popular as $country)
        <div class="skeuo-card p-5 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="{{ $country->flag_url }}" alt="Bendera {{ $country->name }}" width="40" class="rounded-lg shadow-sm border border-border">
                <h5 class="font-bold">{{ $country->name }}</h5>
            </div>

            <div class="my-4">
                <small class="text-muted-foreground block mb-1">Skor Risiko</small>
                @if($country->latestRiskScore)
                    <h2 class="text-3xl font-bold mb-2 font-mono tabular-nums">{{ round($country->latestRiskScore->total_score) }}</h2>
                    <span class="{{ $country->latestRiskScore->level === 'high' ? 'risk-high' : ($country->latestRiskScore->level === 'medium' ? 'risk-medium' : 'risk-low') }}">
                        {{ strtoupper($country->latestRiskScore->level) }} RISK
                    </span>
                @else
                    <h2 class="text-3xl font-bold mb-2 text-muted-foreground">--</h2>
                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-muted text-muted-foreground">BELUM DIHITUNG</span>
                @endif
            </div>

            <a href="{{ route('login') }}" class="btn-skeuo-outline w-full">
                Lihat Dasbor Lengkap
            </a>
        </div>
        @empty
        <div class="md:col-span-3 text-center">
            <p class="text-muted-foreground">Tidak ada data negara populer saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
