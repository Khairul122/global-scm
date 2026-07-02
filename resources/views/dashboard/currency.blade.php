@extends('layouts.app')

@section('title', 'Dampak Valuta - Global SCM Risk Intel')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-0">Dasbor Fluktuasi Nilai Tukar (Valuta)</h2>
        <p class="text-secondary mb-0">Tren nilai tukar mata uang asing terhadap USD untuk melacak volatilitas biaya impor.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <div class="d-inline-block text-start" style="min-width: 250px;">
            <select id="currencySelect" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                <option value="">-- Pilih Mata Uang --</option>
                @foreach($countries as $c)
                    @if($c->currency && $c->currency->code !== 'USD')
                        <option value="{{ $c->currency->code }}">
                            {{ $c->name }} - {{ $c->currency->code }} ({{ $c->currency->name }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Chart Column -->
    <div class="col-lg-8">
        <div class="glass-card p-4 h-100">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line text-primary me-2"></i> Grafik Riwayat Nilai Tukar (30 Hari)</h5>
            <div id="chartContainer" style="position: relative; height: 350px; width: 100%;">
                <canvas id="historyChart"></canvas>
                <div id="chartPlaceholder" class="position-absolute top-50 start-50 translate-middle text-center w-100 p-4">
                    <i class="fa-solid fa-money-bill-trend-up text-secondary display-4 mb-3"></i>
                    <p class="text-secondary mb-0">Silakan pilih mata uang di kanan atas untuk memuat grafik riwayat fluktuasi.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Currency Rates List Column -->
    <div class="col-lg-4">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-table-list text-primary me-2"></i> Nilai Tukar Terkini (vs USD)</h5>
            <div class="table-responsive" style="max-height: 380px;">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr class="text-secondary small border-secondary">
                            <th>Kode</th>
                            <th>Mata Uang</th>
                            <th class="text-end">Nilai / 1 USD</th>
                        </tr>
                    </thead>
                    <tbody id="ratesTableBody">
                        <tr>
                            <td colspan="3" class="text-center text-secondary py-4">
                                <div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat nilai tukar...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const currencySelect = document.getElementById('currencySelect');
    const chartPlaceholder = document.getElementById('chartPlaceholder');
    const ratesTableBody = document.getElementById('ratesTableBody');
    
    let historyChart = null;

    window.addEventListener('DOMContentLoaded', async () => {
        // Load latest rates table
        try {
            const res = await apiFetch('/api/currency');
            if (res.success) {
                ratesTableBody.innerHTML = '';
                res.data.forEach(c => {
                    if (c.code === 'USD') return;
                    const row = document.createElement('tr');
                    row.className = 'border-secondary';
                    row.innerHTML = `
                        <td class="fw-semibold text-primary">${c.code}</td>
                        <td class="small text-secondary">${c.name}</td>
                        <td class="text-end fw-bold">${c.rate_to_usd ? c.rate_to_usd.toFixed(4) : '--'} ${c.symbol || ''}</td>
                    `;
                    ratesTableBody.appendChild(row);
                });
            }
        } catch (err) {
            ratesTableBody.innerHTML = `<tr><td colspan="3" class="text-center text-danger py-4">${err.message || 'Gagal memuat kurs.'}</td></tr>`;
        }

        // Trigger selected param if any
        if (currencySelect.value) {
            currencySelect.dispatchEvent(new Event('change'));
        }
    });

    // Handle currency select change
    currencySelect.addEventListener('change', async function() {
        const code = this.value;
        if (!code) {
            chartPlaceholder.style.display = 'block';
            if (historyChart) {
                historyChart.destroy();
                historyChart = null;
            }
            return;
        }

        chartPlaceholder.style.display = 'none';

        try {
            const res = await apiFetch(`/api/currency/${code}/history?days=30`);
            if (res.success) {
                const historyData = res.data;
                
                const labels = historyData.map(h => h.rate_date);
                const values = historyData.map(h => h.rate_to_usd);

                // Render Chart
                const ctx = document.getElementById('historyChart').getContext('2d');
                
                if (historyChart) {
                    historyChart.destroy();
                }

                historyChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: `Nilai Tukar ${code} per USD`,
                            data: values,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: { family: 'Inter' }
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)'
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: { family: 'Inter' }
                                }
                            }
                        }
                    }
                });
            }
        } catch (err) {
            showToast(err.message || 'Gagal memuat grafik riwayat.', 'error');
        }
    });
</script>
@endsection
