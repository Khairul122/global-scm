@extends('layouts.app')

@section('title', 'Global Supply Chain Risk Intelligence Platform')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-6 mb-5 mb-lg-0">
        <h1 class="display-4 fw-bold text-white mb-3">
            Pantau Risiko Rantai Pasok <br>
            <span class="text-primary text-gradient">Secara Real-Time</span>
        </h1>
        <p class="lead text-secondary mb-4">
            Mengintegrasikan data cuaca global, fluktuasi valuta asing, inflasi ekonomi, dan analisis sentimen berita ke dalam satu dasbor cerdas berbasis Decision Support System.
        </p>
        <div class="d-flex">
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 me-3 rounded-3 fw-semibold">
                <i class="fa-solid fa-chart-column me-2"></i> Dasbor Utama
            </a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 rounded-3 border-secondary fw-semibold">
                Daftar Akun
            </a>
            @endguest
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <!-- Visual representation of the global risks using FontAwesome -->
        <div class="d-inline-block position-relative p-5">
            <div class="glass-card p-4 text-start shadow" style="max-width: 400px; transform: rotate(-3deg);">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-2.5 rounded-3 me-3">
                        <i class="fa-solid fa-cloud-bolt text-primary fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Pemantauan Cuaca</h6>
                        <small class="text-secondary">Open-Meteo Integration</small>
                    </div>
                </div>
                <p class="small text-secondary mb-0">Deteksi risiko badai, curah hujan ekstrem, dan kecepatan angin kencang pada rute pelayaran utama.</p>
            </div>
            <div class="glass-card p-4 text-start shadow mt-4" style="max-width: 400px; margin-left: 60px; transform: rotate(2deg);">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-2.5 rounded-3 me-3">
                        <i class="fa-solid fa-wallet text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Skor Volatilitas Valas</h6>
                        <small class="text-secondary">ExchangeRate API</small>
                    </div>
                </div>
                <p class="small text-secondary mb-0">Mengukur perubahan kurs 30 hari terakhir untuk memitigasi risiko pembengkakan biaya logistik.</p>
            </div>
        </div>
    </div>
</div>

<!-- Popular Countries Section -->
<div class="py-5 mt-5">
    <div class="text-center mb-5">
        <h3 class="fw-bold">Ringkasan Risiko Negara Populer</h3>
        <p class="text-secondary">Kondisi risiko terbaru berdasarkan integrasi data multi-API</p>
    </div>

    <div class="row g-4">
        @forelse($popular as $country)
        <div class="col-md-4">
            <div class="glass-card p-4 text-center">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <img src="{{ $country->flag_url }}" alt="Bendera {{ $country->name }}" width="45" class="rounded shadow-sm me-3 border border-secondary">
                    <h5 class="mb-0 fw-bold">{{ $country->name }}</h5>
                </div>
                
                <div class="my-4">
                    <small class="text-secondary d-block mb-1">Skor Risiko</small>
                    @if($country->latestRiskScore)
                        <h2 class="display-6 fw-bold mb-1">{{ round($country->latestRiskScore->total_score) }}</h2>
                        <span class="badge px-3 py-1.5 rounded-pill {{ $country->latestRiskScore->level === 'high' ? 'risk-high' : ($country->latestRiskScore->level === 'medium' ? 'risk-medium' : 'risk-low') }}">
                            {{ strtoupper($country->latestRiskScore->level) }} RISK
                        </span>
                    @else
                        <h2 class="display-6 fw-bold text-secondary mb-1">--</h2>
                        <span class="badge bg-secondary px-3 py-1.5 rounded-pill">BELUM DIHITUNG</span>
                    @endif
                </div>

                <a href="{{ route('dashboard') }}?country={{ $country->iso2 }}" class="btn btn-outline-primary btn-sm w-100 rounded-3">
                    Lihat Dasbor Lengkap
                </a>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <p class="text-secondary">Tidak ada data negara populer saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
