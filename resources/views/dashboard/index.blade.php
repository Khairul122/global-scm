@extends('layouts.app')

@section('title', 'Country Dashboard - Global SCM Risk Intel')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-0">Dasbor Risiko Negara</h2>
        <p class="text-secondary mb-0">Analisis profil umum, makroekonomi, cuaca, dan penilaian tingkat risiko global</p>
    </div>
    <div class="col-md-6 text-md-end">
        <div class="d-inline-block text-start" style="min-width: 250px;">
            <select id="countrySelect" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                <option value="">-- Pilih Negara --</option>
                @foreach($countries as $c)
                    <option value="{{ $c->iso2 }}" {{ request('country') === $c->iso2 ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->iso2 }})
                    </option>
                @endforeach
            </select>
        </div>
        @auth
        <button id="watchlistBtn" class="btn btn-outline-warning ms-2 py-2 px-3 rounded-3" style="display: none;">
            <i class="fa-regular fa-star me-1"></i> Tambah Watchlist
        </button>
        @endauth
    </div>
</div>

<!-- Initial instructions if no country is selected -->
<div id="welcomePlaceholder" class="glass-card p-5 text-center my-5">
    <i class="fa-solid fa-earth-americas text-primary display-3 mb-4"></i>
    <h4 class="fw-bold">Silakan Pilih Negara</h4>
    <p class="text-secondary max-width-500 mx-auto">Pilih salah satu negara dari dropdown di atas untuk memulai analisis risiko rantai pasok secara langsung.</p>
</div>

<!-- Main Dashboard Grid (Initially Hidden) -->
<div id="dashboardContent" class="row g-4" style="display: none;">
    <!-- Column 1: Country Profile & General Metrics -->
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100">
            <div class="d-flex align-items-center mb-4">
                <img id="countryFlag" src="" alt="Bendera" width="60" class="rounded shadow border border-secondary me-3">
                <div>
                    <h3 id="countryName" class="fw-bold mb-0">Nama Negara</h3>
                    <small id="countryOfficial" class="text-secondary">Official Name</small>
                </div>
            </div>
            
            <hr class="border-secondary opacity-25">

            <div class="mb-4">
                <small class="text-secondary d-block">Ibu Kota</small>
                <h5 id="countryCapital" class="fw-semibold mb-0">Ibukota</h5>
            </div>
            <div class="mb-4">
                <small class="text-secondary d-block">Wilayah</small>
                <h5 id="countryRegion" class="fw-semibold mb-0">Region</h5>
            </div>
            <div class="mb-4">
                <small class="text-secondary d-block">Mata Uang</small>
                <h5 id="countryCurrency" class="fw-semibold mb-0">Currency</h5>
            </div>
            <div class="mb-0">
                <small class="text-secondary d-block">Bahasa</small>
                <h5 id="countryLanguages" class="fw-semibold mb-0">Languages</h5>
            </div>
        </div>
    </div>

    <!-- Column 2: Economic Metrics & Weather Snapshot -->
    <div class="col-lg-4">
        <div class="row g-4 h-100">
            <!-- Economic Card -->
            <div class="col-12">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-primary me-2"></i> Indikator Ekonomi</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary">Produk Domestik Bruto (GDP)</span>
                        <span id="gdpVal" class="fw-bold">--</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary">Tingkat Inflasi Tahunan</span>
                        <span id="inflationVal" class="fw-bold">--</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Populasi Penduduk</span>
                        <span id="popVal" class="fw-bold">--</span>
                    </div>
                </div>
            </div>

            <!-- Weather Card -->
            <div class="col-12">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-cloud-sun text-primary me-2"></i> Kondisi Cuaca Ibu Kota</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary">Temperatur</span>
                        <span id="tempVal" class="fw-bold">--</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-secondary">Curah Hujan</span>
                        <span id="rainVal" class="fw-bold">--</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Kecepatan Angin</span>
                        <span id="windVal" class="fw-bold">--</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Column 3: Risk Scoring & Verdict -->
    <div class="col-lg-4">
        <div class="glass-card p-4 text-center d-flex flex-column justify-content-center h-100">
            <h5 class="fw-bold mb-3 text-start"><i class="fa-solid fa-triangle-exclamation text-primary me-2"></i> Skor Risiko Rantai Pasok</h5>
            
            <div class="my-4">
                <small class="text-secondary d-block mb-1">Skor Tertimbang</small>
                <h1 id="riskScoreVal" class="display-3 fw-bold mb-1 text-white">0</h1>
                <div class="d-inline-block">
                    <span id="riskBadge" class="badge px-4 py-2 rounded-pill fs-6 fw-bold">LOW</span>
                </div>
            </div>
            
            <p class="text-secondary small mt-3 px-3">Skor dihitung secara terbobot berdasarkan cuaca, sentimen berita, nilai inflasi, dan tingkat volatilitas kurs.</p>
        </div>
    </div>
</div>

<!-- Skeleton Loading Dashboard Overlay -->
<div id="skeletonLoader" class="row g-4 my-3" style="display: none;">
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100 d-flex flex-column justify-content-between">
            <div class="skeleton skeleton-title"></div>
            <div>
                <div class="skeleton skeleton-text" style="width: 40%"></div>
                <div class="skeleton skeleton-text" style="width: 80%"></div>
            </div>
            <div class="mt-4">
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
                <div class="skeleton skeleton-text"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="glass-card p-4">
                    <div class="skeleton skeleton-title" style="width: 30%"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="glass-card p-4">
                    <div class="skeleton skeleton-title" style="width: 40%"></div>
                    <div class="skeleton skeleton-text"></div>
                    <div class="skeleton skeleton-text"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="glass-card p-4 h-100 d-flex flex-column justify-content-center align-items-center">
            <div class="skeleton skeleton-title" style="width: 50%"></div>
            <div class="skeleton rounded-circle" style="width: 100px; height: 100px; margin: 20px 0;"></div>
            <div class="skeleton skeleton-text" style="width: 70%"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const countrySelect = document.getElementById('countrySelect');
    const welcomePlaceholder = document.getElementById('welcomePlaceholder');
    const dashboardContent = document.getElementById('dashboardContent');
    const skeletonLoader = document.getElementById('skeletonLoader');
    const watchlistBtn = document.getElementById('watchlistBtn');

    let currentCountryIso = '';

    // Handle country selection
    countrySelect.addEventListener('change', async function() {
        const iso = this.value;
        if (!iso) {
            welcomePlaceholder.style.display = 'block';
            dashboardContent.style.display = 'none';
            watchlistBtn.style.display = 'none';
            return;
        }

        currentCountryIso = iso;
        welcomePlaceholder.style.display = 'none';
        dashboardContent.style.display = 'none';
        skeletonLoader.style.display = 'flex';

        try {
            const res = await apiFetch(`/api/countries/${iso}`);
            if (res.success) {
                const data = res.data;
                
                // Set Country General Info
                document.getElementById('countryFlag').src = `https://flagcdn.com/w160/${data.iso2.toLowerCase()}.png`;
                document.getElementById('countryName').innerText = data.name;
                document.getElementById('countryOfficial').innerText = data.official_name || data.name;
                document.getElementById('countryCapital').innerText = data.capital || '--';
                document.getElementById('countryRegion').innerText = data.region || '--';
                document.getElementById('countryCurrency').innerText = data.currency ? `${data.currency.name} (${data.currency.code})` : '--';
                document.getElementById('countryLanguages').innerText = Object.values(data.languages || {}).join(', ') || '--';

                // Set Economic Indicators
                document.getElementById('gdpVal').innerText = data.gdp_usd ? `$${(data.gdp_usd / 1e12).toFixed(2)} Triliun` : '--';
                document.getElementById('inflationVal').innerText = data.inflation_pct !== null ? `${data.inflation_pct.toFixed(2)}%` : '--';
                document.getElementById('popVal').innerText = data.population ? `${(data.population / 1e6).toFixed(1)} Juta` : '--';

                // Set Weather Data
                if (data.weather) {
                    document.getElementById('tempVal').innerText = `${data.weather.temperature_c.toFixed(1)} °C`;
                    document.getElementById('rainVal').innerText = `${data.weather.precipitation_mm.toFixed(1)} mm`;
                    document.getElementById('windVal').innerText = `${data.weather.wind_speed_kmh.toFixed(1)} km/h`;
                } else {
                    document.getElementById('tempVal').innerText = '--';
                    document.getElementById('rainVal').innerText = '--';
                    document.getElementById('windVal').innerText = '--';
                }

                // Set Risk Info
                if (data.risk) {
                    const score = Math.round(data.risk.total_score);
                    document.getElementById('riskScoreVal').innerText = score;
                    
                    const badge = document.getElementById('riskBadge');
                    badge.innerText = data.risk.level.toUpperCase();
                    badge.className = 'badge px-4 py-2 rounded-pill fs-6 fw-bold';
                    
                    if (data.risk.level === 'high') {
                        badge.classList.add('risk-high');
                    } else if (data.risk.level === 'medium') {
                        badge.classList.add('risk-medium');
                    } else {
                        badge.classList.add('risk-low');
                    }
                }

                // Toggle watchlist button if user authenticated
                if (watchlistBtn) {
                    watchlistBtn.style.display = 'inline-block';
                    // Check if already in watchlist
                    try {
                        const wlRes = await apiFetch('/api/watchlist');
                        if (wlRes.success) {
                            const inWl = wlRes.data.some(w => w.iso2 === iso);
                            updateWatchlistBtnUI(inWl);
                        }
                    } catch (e) {
                        // ignore unauthenticated or minor error
                    }
                }

                skeletonLoader.style.display = 'none';
                dashboardContent.style.display = 'flex';
            }
        } catch (err) {
            showToast(err.message || 'Gagal memuat profil negara.', 'error');
            skeletonLoader.style.display = 'none';
            welcomePlaceholder.style.display = 'block';
        }
    });

    // Helper for watchlist button UI
    function updateWatchlistBtnUI(isInWatchlist) {
        if (isInWatchlist) {
            watchlistBtn.className = 'btn btn-warning ms-2 py-2 px-3 rounded-3';
            watchlistBtn.innerHTML = '<i class="fa-solid fa-star me-1 text-white"></i> Terpantau';
            watchlistBtn.dataset.active = 'true';
        } else {
            watchlistBtn.className = 'btn btn-outline-warning ms-2 py-2 px-3 rounded-3';
            watchlistBtn.innerHTML = '<i class="fa-regular fa-star me-1"></i> Tambah Watchlist';
            watchlistBtn.dataset.active = 'false';
        }
    }

    // Handle Watchlist actions
    if (watchlistBtn) {
        watchlistBtn.addEventListener('click', async function() {
            const isActive = this.dataset.active === 'true';
            try {
                if (isActive) {
                    // Remove from Watchlist
                    const res = await apiFetch(`/api/watchlist/${currentCountryIso}`, { method: 'DELETE' });
                    if (res.success) {
                        showToast('Berhasil dihapus dari daftar pantauan.');
                        updateWatchlistBtnUI(false);
                    }
                } else {
                    // Add to Watchlist
                    const res = await apiFetch('/api/watchlist', {
                        method: 'POST',
                        body: { country_iso: currentCountryIso }
                    });
                    if (res.success) {
                        showToast('Berhasil ditambahkan ke daftar pantauan.');
                        updateWatchlistBtnUI(true);
                    }
                }
            } catch (err) {
                showToast(err.message || 'Gagal melakukan aksi watchlist.', 'error');
            }
        });
    }

    // Auto-trigger if query param present
    window.addEventListener('DOMContentLoaded', () => {
        if (countrySelect.value) {
            countrySelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection
