@extends('layouts.app')

@section('title', 'Analitik Tren - Global SCM Risk Intel')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-0">Dasbor Analitik Tren Multi-Indikator</h2>
        <p class="text-secondary mb-0">Visualisasi historis GDP, inflasi tahunan, fluktuasi valuta asing, dan tren total skor risiko rantai pasok.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <div class="d-inline-block text-start" style="min-width: 250px;">
            <select id="analyticsCountrySelect" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                <option value="">-- Pilih Negara --</option>
                @foreach($countries as $c)
                    <option value="{{ $c->iso2 }}" {{ $loop->first ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->iso2 }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- GDP Trend Chart -->
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-primary me-2"></i> Tren GDP (World Bank)</h5>
            <div style="height: 250px; position: relative;">
                <canvas id="gdpChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Inflation Trend Chart -->
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-warning me-2"></i> Tren Inflasi Tahunan (%)</h5>
            <div style="height: 250px; position: relative;">
                <canvas id="inflationChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Currency Trend Chart -->
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-success me-2"></i> Tren Kurs Harian (vs USD)</h5>
            <div style="height: 250px; position: relative;">
                <canvas id="currencyChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Risk Score History Chart -->
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-danger me-2"></i> Riwayat Skor Risiko Rantai Pasok</h5>
            <div style="height: 250px; position: relative;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const analyticsCountrySelect = document.getElementById('analyticsCountrySelect');
    
    // Chart instances
    let gdpChart = null;
    let inflationChart = null;
    let currencyChart = null;
    let riskChart = null;

    window.addEventListener('DOMContentLoaded', () => {
        if (analyticsCountrySelect.value) {
            analyticsCountrySelect.dispatchEvent(new Event('change'));
        }
    });

    analyticsCountrySelect.addEventListener('change', async function() {
        const iso = this.value;
        if (!iso) return;

        try {
            // Load Country details first to trigger refresh if missing/stale
            const cProfile = await apiFetch(`/api/countries/${iso}`);
            const currencyCode = cProfile.data.currency?.code;

            // 1. Load Economic indicators (GDP & Inflation)
            const indRes = await apiFetch(`/api/countries/${iso}/indicators`);
            if (indRes.success) {
                const indicators = indRes.data;
                
                const gdpData = indicators.gdp || [];
                const inflationData = indicators.inflation || [];

                renderLineChart('gdpChart', gdpChart, gdpData.map(d => d.year), gdpData.map(d => d.value / 1e9), 'GDP (Miliar USD)', '#3b82f6', chart => gdpChart = chart);
                renderLineChart('inflationChart', inflationChart, inflationData.map(d => d.year), inflationData.map(d => d.value), 'Inflasi (%)', '#f59e0b', chart => inflationChart = chart);
            }

            // 2. Load Currency history
            if (currencyCode && currencyCode !== 'USD') {
                const currRes = await apiFetch(`/api/currency/${currencyCode}/history?days=30`);
                if (currRes.success) {
                    const cData = currRes.data;
                    renderLineChart('currencyChart', currencyChart, cData.map(d => d.rate_date), cData.map(d => d.rate_to_usd), `Kurs ${currencyCode} / USD`, '#10b981', chart => currencyChart = chart);
                }
            } else {
                // USD is flat 1.0
                renderLineChart('currencyChart', currencyChart, [new Date().toDateString()], [1.0], 'Kurs USD / USD', '#10b981', chart => currencyChart = chart);
            }

            // 3. Load Risk history
            const riskRes = await apiFetch(`/api/risk/${iso}/history?days=30`);
            if (riskRes.success) {
                const rData = riskRes.data;
                renderLineChart('riskChart', riskChart, rData.map(d => new Date(d.calculated_at).toLocaleDateString('id-ID')), rData.map(d => d.total_score), 'Skor Risiko', '#ef4444', chart => riskChart = chart);
            }

        } catch (err) {
            showToast(err.message || 'Gagal memuat data analitik tren.', 'error');
        }
    });

    function renderLineChart(canvasId, chartInstance, labels, data, label, color, setChartInstance) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        if (chartInstance) {
            chartInstance.destroy();
        }

        const newChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: color,
                    backgroundColor: 'rgba(255, 255, 255, 0.02)',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#94a3b8', font: { family: 'Inter', size: 11 } }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8', font: { family: 'Inter', size: 10 } }
                    },
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { color: '#94a3b8', font: { family: 'Inter', size: 10 } }
                    }
                }
            }
        });

        setChartInstance(newChart);
    }
</script>
@endsection
