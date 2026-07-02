@extends('layouts.app')

@section('title', 'Komparasi Negara - Global SCM Risk Intel')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="fw-bold mb-0">Komparasi Risiko Negara</h2>
        <p class="text-secondary mb-0">Bandingkan profil ekonomi, cuaca, dan kerentanan rantai pasok secara berdampingan.</p>
    </div>
    <div class="col-md-6">
        <div class="d-flex justify-content-md-end gap-2 align-items-center mt-3 mt-md-0">
            <select id="countryA" class="form-select bg-dark border-secondary text-white py-2 rounded-3" style="max-width: 200px;">
                <option value="">-- Negara A --</option>
                @foreach($countries as $c)
                    <option value="{{ $c->iso2 }}">A - {{ $c->name }}</option>
                @endforeach
            </select>
            <span class="text-secondary fw-bold">VS</span>
            <select id="countryB" class="form-select bg-dark border-secondary text-white py-2 rounded-3" style="max-width: 200px;">
                <option value="">-- Negara B --</option>
                @foreach($countries as $c)
                    <option value="{{ $c->iso2 }}">B - {{ $c->name }}</option>
                @endforeach
            </select>
            <button id="compareBtn" class="btn btn-primary py-2 px-3 rounded-3 fw-semibold">Bandingkan</button>
        </div>
    </div>
</div>

<!-- Comparison Placeholder -->
<div id="comparePlaceholder" class="glass-card p-5 text-center my-5">
    <i class="fa-solid fa-scale-balanced text-primary display-3 mb-4"></i>
    <h4 class="fw-bold">Silakan Pilih Dua Negara</h4>
    <p class="text-secondary max-width-500 mx-auto">Pilih kedua negara yang ingin dibandingkan pada menu kanan atas lalu klik tombol "Bandingkan".</p>
</div>

<!-- Comparison Table Grid -->
<div id="compareResult" class="glass-card p-4 my-4" style="display: none;">
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle mb-0">
            <thead>
                <tr class="text-secondary border-secondary">
                    <th style="width: 34%;">Parameter Analisis</th>
                    <th id="nameHeaderA" class="text-center" style="width: 33%;">Negara A</th>
                    <th id="nameHeaderB" class="text-center" style="width: 33%;">Negara B</th>
                </tr>
            </thead>
            <tbody>
                <!-- Profile -->
                <tr class="table-group-divider border-secondary"><td colspan="3" class="small text-primary fw-bold">PROFIL UMUM</td></tr>
                <tr class="border-secondary">
                    <td>Ibu Kota</td>
                    <td id="capitalA" class="text-center">--</td>
                    <td id="capitalB" class="text-center">--</td>
                </tr>
                <tr class="border-secondary">
                    <td>Wilayah (Region)</td>
                    <td id="regionA" class="text-center">--</td>
                    <td id="regionB" class="text-center">--</td>
                </tr>
                <tr class="border-secondary">
                    <td>Mata Uang (Currency)</td>
                    <td id="currencyA" class="text-center">--</td>
                    <td id="currencyB" class="text-center">--</td>
                </tr>

                <!-- Economic indicators -->
                <tr class="border-secondary"><td colspan="3" class="small text-primary fw-bold">MAKROEKONOMI (WORLD BANK)</td></tr>
                <tr id="rowGdp" class="border-secondary">
                    <td>GDP Tahunan (USD)</td>
                    <td id="gdpA" class="text-center">--</td>
                    <td id="gdpB" class="text-center">--</td>
                </tr>
                <tr id="rowInflation" class="border-secondary">
                    <td>Tingkat Inflasi Tahunan (%)</td>
                    <td id="inflationA" class="text-center">--</td>
                    <td id="inflationB" class="text-center">--</td>
                </tr>
                <tr id="rowPopulation" class="border-secondary">
                    <td>Jumlah Populasi Penduduk</td>
                    <td id="populationA" class="text-center">--</td>
                    <td id="populationB" class="text-center">--</td>
                </tr>
                <tr id="rowExport" class="border-secondary">
                    <td>Volume Ekspor Tahunan (USD)</td>
                    <td id="exportA" class="text-center">--</td>
                    <td id="exportB" class="text-center">--</td>
                </tr>
                <tr id="rowImport" class="border-secondary">
                    <td>Volume Impor Tahunan (USD)</td>
                    <td id="importA" class="text-center">--</td>
                    <td id="importB" class="text-center">--</td>
                </tr>

                <!-- Weather metrics -->
                <tr class="border-secondary"><td colspan="3" class="small text-primary fw-bold">KONDISI CUACA & BADAI (OPEN-METEO)</td></tr>
                <tr class="border-secondary">
                    <td>Temperatur saat ini</td>
                    <td id="tempA" class="text-center">--</td>
                    <td id="tempB" class="text-center">--</td>
                </tr>
                <tr id="rowPrecipitation" class="border-secondary">
                    <td>Curah Hujan (Curah air)</td>
                    <td id="precipA" class="text-center">--</td>
                    <td id="precipB" class="text-center">--</td>
                </tr>
                <tr id="rowWind" class="border-secondary">
                    <td>Kecepatan Angin rata-rata</td>
                    <td id="windA" class="text-center">--</td>
                    <td id="windB" class="text-center">--</td>
                </tr>
                <tr id="rowStorm" class="border-secondary">
                    <td>Indeks Risiko Badai (0 - 100)</td>
                    <td id="stormA" class="text-center">--</td>
                    <td id="stormB" class="text-center">--</td>
                </tr>

                <!-- Final SCM Risk Score -->
                <tr class="border-secondary"><td colspan="3" class="small text-primary fw-bold">PENILAIAN RISIKO GABUNGAN</td></tr>
                <tr id="rowRisk" class="border-secondary py-3">
                    <td class="fw-bold">Total Skor Risiko SCM</td>
                    <td id="riskA" class="text-center fw-bold">--</td>
                    <td id="riskB" class="text-center fw-bold">--</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const countryASelect = document.getElementById('countryA');
    const countryBSelect = document.getElementById('countryB');
    const compareBtn = document.getElementById('compareBtn');
    const comparePlaceholder = document.getElementById('comparePlaceholder');
    const compareResult = document.getElementById('compareResult');

    compareBtn.addEventListener('click', async () => {
        const a = countryASelect.value;
        const b = countryBSelect.value;

        if (!a || !b) {
            showToast('Silakan pilih kedua negara terlebih dahulu.', 'error');
            return;
        }

        if (a === b) {
            showToast('Harap pilih dua negara yang berbeda.', 'warning');
            return;
        }

        comparePlaceholder.style.display = 'none';
        compareResult.style.display = 'none';

        try {
            const res = await apiFetch(`/api/compare?a=${a}&b=${b}`);
            if (res.success) {
                const data = res.data;
                const ca = data.country_a;
                const cb = data.country_b;

                // Headers flag + name
                document.getElementById('nameHeaderA').innerHTML = `<img src="https://flagcdn.com/w40/${ca.iso2.toLowerCase()}.png" class="me-2 rounded shadow-sm border border-secondary"> ${ca.name}`;
                document.getElementById('nameHeaderB').innerHTML = `<img src="https://flagcdn.com/w40/${cb.iso2.toLowerCase()}.png" class="me-2 rounded shadow-sm border border-secondary"> ${cb.name}`;

                // General Profile
                document.getElementById('capitalA').innerText = ca.capital || '--';
                document.getElementById('capitalB').innerText = cb.capital || '--';
                document.getElementById('regionA').innerText = ca.region || '--';
                document.getElementById('regionB').innerText = cb.region || '--';
                document.getElementById('currencyA').innerText = ca.currency ? `${ca.currency.name} (${ca.currency.code})` : '--';
                document.getElementById('currencyB').innerText = cb.currency ? `${cb.currency.name} (${cb.currency.code})` : '--';

                // Macroeconomic indicators
                document.getElementById('gdpA').innerText = ca.gdp ? `$${(ca.gdp / 1e9).toFixed(2)} Miliar` : '--';
                document.getElementById('gdpB').innerText = cb.gdp ? `$${(cb.gdp / 1e9).toFixed(2)} Miliar` : '--';
                document.getElementById('inflationA').innerText = ca.inflation !== null ? `${ca.inflation.toFixed(2)}%` : '--';
                document.getElementById('inflationB').innerText = cb.inflation !== null ? `${cb.inflation.toFixed(2)}%` : '--';
                document.getElementById('populationA').innerText = ca.population ? `${(ca.population / 1e6).toFixed(1)} Juta` : '--';
                document.getElementById('populationB').innerText = cb.population ? `${(cb.population / 1e6).toFixed(1)} Juta` : '--';
                document.getElementById('exportA').innerText = ca.export ? `$${(ca.export / 1e9).toFixed(2)} Miliar` : '--';
                document.getElementById('exportB').innerText = cb.export ? `$${(cb.export / 1e9).toFixed(2)} Miliar` : '--';
                document.getElementById('importA').innerText = ca.import ? `$${(ca.import / 1e9).toFixed(2)} Miliar` : '--';
                document.getElementById('importB').innerText = cb.import ? `$${(cb.import / 1e9).toFixed(2)} Miliar` : '--';

                // Weather
                document.getElementById('tempA').innerText = ca.weather ? `${ca.weather.temperature_c.toFixed(1)} °C` : '--';
                document.getElementById('tempB').innerText = cb.weather ? `${cb.weather.temperature_c.toFixed(1)} °C` : '--';
                document.getElementById('precipA').innerText = ca.weather ? `${ca.weather.precipitation_mm.toFixed(1)} mm` : '--';
                document.getElementById('precipB').innerText = cb.weather ? `${cb.weather.precipitation_mm.toFixed(1)} mm` : '--';
                document.getElementById('windA').innerText = ca.weather ? `${ca.weather.wind_speed_kmh.toFixed(1)} km/h` : '--';
                document.getElementById('windB').innerText = cb.weather ? `${cb.weather.wind_speed_kmh.toFixed(1)} km/h` : '--';
                document.getElementById('stormA').innerText = ca.weather ? ca.weather.storm_risk : '--';
                document.getElementById('stormB').innerText = cb.weather ? cb.weather.storm_risk : '--';

                // Risk
                document.getElementById('riskA').innerHTML = ca.risk ? `${Math.round(ca.risk.total_score)} <span class="badge rounded-pill risk-${ca.risk.level} ms-2 px-2.5 py-1 text-uppercase">${ca.risk.level}</span>` : '--';
                document.getElementById('riskB').innerHTML = cb.risk ? `${Math.round(cb.risk.total_score)} <span class="badge rounded-pill risk-${cb.risk.level} ms-2 px-2.5 py-1 text-uppercase">${cb.risk.level}</span>` : '--';

                // Clear highlights
                const tds = compareResult.querySelectorAll('td');
                tds.forEach(td => td.classList.remove('text-success', 'fw-bold'));

                // Apply dynamic highlights (higher GDP/exports, lower inflation/risk score/storm risk index)
                highlightBetterValue(ca.gdp, cb.gdp, 'gdpA', 'gdpB', true);
                highlightBetterValue(ca.inflation, cb.inflation, 'inflationA', 'inflationB', false);
                highlightBetterValue(ca.export, cb.export, 'exportA', 'exportB', true);
                highlightBetterValue(ca.import, cb.import, 'importA', 'importB', true);
                highlightBetterValue(ca.weather?.precipitation_mm, cb.weather?.precipitation_mm, 'precipA', 'precipB', false);
                highlightBetterValue(ca.weather?.wind_speed_kmh, cb.weather?.wind_speed_kmh, 'windA', 'windB', false);
                highlightBetterValue(ca.weather?.storm_risk, cb.weather?.storm_risk, 'stormA', 'stormB', false);
                highlightBetterValue(ca.risk?.total_score, cb.risk?.total_score, 'riskA', 'riskB', false);

                compareResult.style.display = 'block';
            }
        } catch (err) {
            showToast(err.message || 'Gagal memuat komparasi.', 'error');
        }
    });

    function highlightBetterValue(valA, valB, idA, idB, higherIsBetter) {
        if (valA === null || valB === null || valA === undefined || valB === undefined) return;
        const elA = document.getElementById(idA);
        const elB = document.getElementById(idB);
        
        if (valA === valB) return;

        if (higherIsBetter) {
            if (valA > valB) elA.classList.add('text-success', 'fw-bold');
            else elB.classList.add('text-success', 'fw-bold');
        } else {
            if (valA < valB) elA.classList.add('text-success', 'fw-bold');
            else elB.classList.add('text-success', 'fw-bold');
        }
    }
</script>
@endsection
