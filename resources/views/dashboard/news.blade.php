@extends('layouts.app')

@section('title', 'Intelijen Berita - Global SCM Risk Intel')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h2 class="fw-bold mb-0">Intelijen Berita & Analisis Sentimen</h2>
        <p class="text-secondary mb-0">Pemindaian otomatis berita perdagangan global menggunakan sentimen berbasis leksikon.</p>
    </div>
    <div class="col-md-6">
        <div class="row g-2 justify-content-md-end">
            <!-- Category Filter -->
            <div class="col-6 col-md-4">
                <select id="newsCategory" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                    <option value="logistics">Logistik & Distribusi</option>
                    <option value="shipping">Pelayaran & Maritim</option>
                    <option value="trade">Perdagangan & Ekspor</option>
                    <option value="economy">Ekonomi Makro</option>
                </select>
            </div>
            <!-- Country Filter -->
            <div class="col-6 col-md-4">
                <select id="newsCountry" class="form-select bg-dark border-secondary text-white py-2 rounded-3">
                    <option value="">Global</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->iso2 }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sentiment Aggregates Card -->
    <div class="col-lg-4">
        <div class="glass-card p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-pie text-primary me-2"></i> Agregat Sentimen</h5>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-success small fw-semibold"><i class="fa-regular fa-face-smile me-1"></i> Positif</span>
                    <strong id="posPct">0%</strong>
                </div>
                <div class="progress bg-dark" style="height: 10px;">
                    <div id="posBar" class="progress-bar bg-success" role="progressbar" style="width: 0%"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-secondary small fw-semibold"><i class="fa-regular fa-face-meh me-1"></i> Netral</span>
                    <strong id="neuPct">0%</strong>
                </div>
                <div class="progress bg-dark" style="height: 10px;">
                    <div id="neuBar" class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                </div>
            </div>

            <div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-danger small fw-semibold"><i class="fa-regular fa-face-frown me-1"></i> Negatif</span>
                    <strong id="negPct">0%</strong>
                </div>
                <div class="progress bg-dark" style="height: 10px;">
                    <div id="negBar" class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="glass-card p-4">
            <h6 class="fw-bold mb-2">Mengapa sentimen dihitung?</h6>
            <p class="small text-secondary mb-0">Rasio berita negatif pada topik geopolitik dan logistik (misal: "delay", "war", "shortage") dimasukkan ke dalam Risk Scoring Engine untuk memperkirakan kerawanan jalur rantai pasok secara keseluruhan.</p>
        </div>
    </div>

    <!-- News List Column -->
    <div class="col-lg-8">
        <div class="glass-card p-4">
            <h5 class="fw-bold mb-4"><i class="fa-solid fa-list-check text-primary me-2"></i> Daftar Artikel Terindeks</h5>
            
            <div id="newsContainer" class="d-flex flex-column gap-4">
                <!-- Skeletons initially -->
                <div class="skeleton p-3 rounded" style="height: 100px;"></div>
                <div class="skeleton p-3 rounded" style="height: 100px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const newsCategory = document.getElementById('newsCategory');
    const newsCountry = document.getElementById('newsCountry');
    const newsContainer = document.getElementById('newsContainer');

    window.addEventListener('DOMContentLoaded', () => {
        loadNewsAndSummary();
    });

    newsCategory.addEventListener('change', loadNewsAndSummary);
    newsCountry.addEventListener('change', loadNewsAndSummary);

    async function loadNewsAndSummary() {
        const cat = newsCategory.value;
        const country = newsCountry.value;

        // Render Skeletons
        newsContainer.innerHTML = `
            <div class="skeleton rounded-3 p-4 mb-2" style="height: 120px;"></div>
            <div class="skeleton rounded-3 p-4 mb-2" style="height: 120px;"></div>
        `;

        try {
            // 1. Fetch news articles
            let url = `/api/news?category=${cat}`;
            if (country) {
                url += `&country=${country}`;
            }

            const newsRes = await apiFetch(url);
            if (newsRes.success) {
                newsContainer.innerHTML = '';
                const articles = newsRes.data;

                if (articles.length === 0) {
                    newsContainer.innerHTML = `
                        <div class="text-center py-5 text-secondary">
                            <i class="fa-regular fa-folder-open display-4 mb-3"></i>
                            <p class="mb-0">Tidak ada berita yang ditemukan untuk kategori atau negara ini.</p>
                        </div>
                    `;
                } else {
                    articles.forEach(art => {
                        const card = document.createElement('div');
                        card.className = 'glass-card p-4 border-secondary';
                        
                        let badgeClass = 'bg-secondary';
                        if (art.sentiment?.label === 'positive') badgeClass = 'bg-success';
                        else if (art.sentiment?.label === 'negative') badgeClass = 'bg-danger';

                        const pubDate = new Date(art.published_at).toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        card.innerHTML = `
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge ${badgeClass} text-white uppercase px-2.5 py-1.5 rounded-pill fs-7">
                                    <i class="fa-solid fa-brain me-1"></i> ${art.sentiment?.label.toUpperCase() || 'NEUTRAL'}
                                </span>
                                <small class="text-secondary">${pubDate}</small>
                            </div>
                            <h5 class="fw-bold mb-2">
                                <a href="${art.url}" target="_blank" class="text-white text-decoration-none hover-link">${art.title}</a>
                            </h5>
                            <p class="text-secondary small mb-2">${art.description || 'Tidak ada deskripsi singkat.'}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-primary"><i class="fa-solid fa-tags me-1"></i> ${art.category}</span>
                                <small class="text-secondary"><i class="fa-solid fa-chart-bar me-1"></i> Positif: ${art.sentiment?.positive || 0} | Negatif: ${art.sentiment?.negative || 0}</small>
                            </div>
                        `;
                        newsContainer.appendChild(card);
                    });
                }
            }

            // 2. Fetch aggregates
            let summaryUrl = `/api/news/summary?`;
            if (cat) summaryUrl += `category=${cat}&`;
            if (country) summaryUrl += `country=${country}`;

            const summaryRes = await apiFetch(summaryUrl);
            if (summaryRes.success) {
                const s = summaryRes.data;
                document.getElementById('posPct').innerText = `${s.positive_pct}%`;
                document.getElementById('posBar').style.width = `${s.positive_pct}%`;
                
                document.getElementById('neuPct').innerText = `${s.neutral_pct}%`;
                document.getElementById('neuBar').style.width = `${s.neutral_pct}%`;
                
                document.getElementById('negPct').innerText = `${s.negative_pct}%`;
                document.getElementById('negBar').style.width = `${s.negative_pct}%`;
            }
        } catch (err) {
            showToast(err.message || 'Gagal memuat berita.', 'error');
        }
    }
</script>
@endsection
