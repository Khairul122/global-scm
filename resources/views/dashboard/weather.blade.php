@extends('layouts.app')

@section('title', 'Peta Cuaca Global - Global SCM Risk Intel')

@section('styles')
<style>
    #map {
        height: 600px;
        width: 100%;
        background-color: #0b0f19;
    }
    .legend {
        background: rgba(19, 28, 46, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        padding: 15px;
        color: #f8fafc;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Peta Pemantauan Cuaca Global</h2>
        <p class="text-secondary">Peta interaktif kondisi cuaca ibu kota negara dan estimasi risiko badai maritim.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-9 mb-4 mb-lg-0">
        <div class="glass-card p-3 shadow-lg">
            <div id="map"></div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="glass-card p-4 mb-4">
            <h5 class="fw-bold mb-3">Legenda Risiko</h5>
            <div class="d-flex align-items-center mb-3">
                <span class="d-inline-block rounded-circle me-3" style="width: 16px; height: 16px; background-color: var(--success);"></span>
                <div>
                    <h6 class="mb-0 fw-semibold">Normal (Rendah)</h6>
                    <small class="text-secondary">Risiko Badai 0 - 33</small>
                </div>
            </div>
            <div class="d-flex align-items-center mb-3">
                <span class="d-inline-block rounded-circle me-3" style="width: 16px; height: 16px; background-color: var(--warning);"></span>
                <div>
                    <h6 class="mb-0 fw-semibold">Waspada (Sedang)</h6>
                    <small class="text-secondary">Risiko Badai 34 - 66</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <span class="d-inline-block rounded-circle me-3" style="width: 16px; height: 16px; background-color: var(--danger);"></span>
                <div>
                    <h6 class="mb-0 fw-semibold">Awas (Tinggi)</h6>
                    <small class="text-secondary">Risiko Badai 67 - 100</small>
                </div>
            </div>
        </div>

        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3">Informasi Cuaca</h5>
            <p class="small text-secondary mb-0">Marker warna mengikuti tingkat keparahan risiko badai (temperatur, curah hujan, kecepatan angin). Data di-caching selama 30 menit agar sistem responsif.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let map;
    
    window.addEventListener('DOMContentLoaded', async () => {
        // Initialize Map centered on global coordinates
        map = L.map('map').setView([15.0, 10.0], 2);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        try {
            // Fetch all countries list
            const res = await apiFetch('/api/countries');
            if (res.success) {
                const countries = res.data;
                
                for (const c of countries) {
                    // Fetch full info to get latest weather
                    const fullRes = await apiFetch(`/api/countries/${c.iso2}`);
                    if (fullRes.success && fullRes.data.weather) {
                        const data = fullRes.data;
                        const w = data.weather;
                        const r = data.risk;
                        
                        // Select color based on storm risk
                        let markerColor = 'green';
                        if (r && r.total_score >= 67) {
                            markerColor = 'red';
                        } else if (r && r.total_score >= 34) {
                            markerColor = 'gold';
                        }

                        // Create custom circle marker
                        const marker = L.circleMarker([c.latitude, c.longitude], {
                            radius: 10,
                            fillColor: markerColor === 'red' ? '#ef4444' : (markerColor === 'gold' ? '#f59e0b' : '#10b981'),
                            color: '#ffffff',
                            weight: 1.5,
                            fillOpacity: 0.8
                        }).addTo(map);

                        // Popup content
                        const popupHtml = `
                            <div style="font-family: 'Inter', sans-serif; min-width: 150px; color: #1e293b;">
                                <h6 class="fw-bold mb-1" style="margin-top: 0;">${c.name}</h6>
                                <small class="text-muted d-block mb-2">Ibu Kota: ${c.capital}</small>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Temp:</span> <strong class="ms-2">${w.temperature_c.toFixed(1)} °C</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Hujan:</span> <strong class="ms-2">${w.precipitation_mm.toFixed(1)} mm</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Angin:</span> <strong class="ms-2">${w.wind_speed_kmh.toFixed(1)} km/h</strong>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-1 mt-2">
                                    <span>Risiko:</span> 
                                    <strong class="ms-2 badge ${r && r.level === 'high' ? 'bg-danger' : (r && r.level === 'medium' ? 'bg-warning text-dark' : 'bg-success')} text-white">
                                        ${r ? r.level.toUpperCase() : 'UNKNOWN'}
                                    </strong>
                                </div>
                            </div>
                        `;
                        marker.bindPopup(popupHtml);
                    }
                }
            }
        } catch (err) {
            showToast('Gagal memuat data cuaca peta.', 'error');
            console.error(err);
        }
    });
</script>
@endsection
