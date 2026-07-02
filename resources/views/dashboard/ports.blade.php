@extends('layouts.app')

@section('title', 'Peta Pelabuhan Dunia - Global SCM Risk Intel')

@section('styles')
<style>
    #map {
        height: 600px;
        width: 100%;
        background-color: #0b0f19;
    }
</style>
@endsection

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-0">Peta Pelabuhan Dunia (World Port Index)</h2>
        <p class="text-secondary mb-0">Pemetaan geografis pelabuhan utama global, ukuran kapasitas dermaga, dan integrasi wilayah perdagangan.</p>
    </div>
    <div class="col-md-6">
        <div class="row g-2 justify-content-md-end">
            <!-- Search bar -->
            <div class="col-6 col-md-5">
                <input type="text" id="portSearch" class="form-control bg-dark border-secondary text-white py-2 rounded-3" placeholder="Cari pelabuhan / kode WPI...">
            </div>
            <!-- Country Filter -->
            <div class="col-6 col-md-4">
                <select id="portCountry" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                    <option value="">Semua Negara</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->iso2 }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="glass-card p-3 shadow-lg">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let map;
    let markerCluster;
    const portSearch = document.getElementById('portSearch');
    const portCountry = document.getElementById('portCountry');

    window.addEventListener('DOMContentLoaded', () => {
        // Initialize Map
        map = L.map('map').setView([10.0, 100.0], 3);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        markerCluster = L.markerClusterGroup().addTo(map);

        // Fetch initial ports based on view bounds
        map.on('moveend', fetchPortsInBounds);
        
        // Listeners
        portSearch.addEventListener('input', debounce(fetchPortsInBounds, 500));
        portCountry.addEventListener('change', fetchPortsInBounds);

        // Fetch once
        fetchPortsInBounds();
    });

    async function fetchPortsInBounds() {
        const bounds = map.getBounds();
        const west = bounds.getWest();
        const south = bounds.getSouth();
        const east = bounds.getEast();
        const north = bounds.getNorth();
        
        const q = portSearch.value;
        const country = portCountry.value;

        // Construct query parameters
        let params = [];
        if (q) params.push(`q=${encodeURIComponent(q)}`);
        if (country) params.push(`country=${encodeURIComponent(country)}`);
        
        // Only query bounding box if we are zoomed in enough (to prevent massive loads) and not searching a specific country
        if (map.getZoom() > 4 && !country && !q) {
            params.push(`bbox=${west},${south},${east},${north}`);
        }

        const url = `/api/ports?${params.join('&')}`;

        try {
            const res = await apiFetch(url);
            if (res.success) {
                // Clear old markers
                markerCluster.clearLayers();

                const ports = res.data;
                ports.forEach(p => {
                    const marker = L.marker([p.latitude, p.longitude]);
                    
                    const popupHtml = `
                        <div style="font-family: 'Inter', sans-serif; min-width: 160px; color: #1e293b;">
                            <h6 class="fw-bold mb-1" style="margin-top: 0;">${p.name}</h6>
                            <small class="text-muted d-block mb-2">Kode WPI: ${p.wpi_code || '--'}</small>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Negara:</span> <strong>${p.country.name} (${p.country.iso2})</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Ukuran:</span> <strong>${p.harbor_size || 'Sedang'}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Koordinat:</span> <strong class="small">${p.latitude.toFixed(4)}, ${p.longitude.toFixed(4)}</strong>
                            </div>
                        </div>
                    `;
                    marker.bindPopup(popupHtml);
                    markerCluster.addLayer(marker);
                });
            }
        } catch (err) {
            console.error(err);
        }
    }

    // Debounce helper for searching
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
</script>
@endsection
