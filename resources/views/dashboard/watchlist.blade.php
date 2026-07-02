@extends('layouts.app')

@section('title', 'Daftar Pantauan - Global SCM Risk Intel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Daftar Pantauan Risiko Anda</h2>
        <p class="text-secondary">Negara yang Anda pilih untuk dipantau secara berkala (maksimal 20 negara).</p>
    </div>
</div>

<div id="watchlistGrid" class="row g-4">
    <!-- Watchlist cards will be loaded here via AJAX -->
    <div class="col-12 text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="text-secondary mt-3">Memuat daftar pantauan...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const watchlistGrid = document.getElementById('watchlistGrid');

    window.addEventListener('DOMContentLoaded', () => {
        loadWatchlist();
    });

    async function loadWatchlist() {
        try {
            const res = await apiFetch('/api/watchlist');
            if (res.success) {
                const list = res.data;
                watchlistGrid.innerHTML = '';

                if (list.length === 0) {
                    watchlistGrid.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <div class="glass-card p-5 max-width-500 mx-auto">
                                <i class="fa-regular fa-star text-secondary display-3 mb-4"></i>
                                <h4 class="fw-bold">Daftar Pantauan Kosong</h4>
                                <p class="text-secondary mb-3">Anda belum menambahkan negara apa pun ke daftar pantauan.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-3 px-4">Ke Dasbor Negara</a>
                            </div>
                        </div>
                    `;
                } else {
                    list.forEach(w => {
                        const col = document.createElement('div');
                        col.className = 'col-md-4';
                        
                        const score = w.risk ? Math.round(w.risk.total_score) : '--';
                        const level = w.risk ? w.risk.level.toUpperCase() : 'UNKNOWN';
                        const badgeClass = w.risk?.level === 'high' ? 'risk-high' : (w.risk?.level === 'medium' ? 'risk-medium' : 'risk-low');

                        col.innerHTML = `
                            <div class="glass-card p-4 h-100 position-relative">
                                <button onclick="removeFromWatchlist('${w.iso2}')" class="btn btn-link text-danger position-absolute top-0 end-0 p-3" title="Hapus dari daftar pantauan">
                                    <i class="fa-regular fa-trash-can fs-5"></i>
                                </button>
                                <div class="d-flex align-items-center mb-3">
                                    <img src="${w.flag_url}" alt="Bendera ${w.name}" width="40" class="rounded border border-secondary shadow-sm me-3">
                                    <div>
                                        <h5 class="fw-bold mb-0">${w.name}</h5>
                                        <small class="text-secondary">${w.capital}</small>
                                    </div>
                                </div>
                                <div class="border-top border-secondary pt-3 mt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary small">Skor Risiko SCM</span>
                                        <div class="text-end">
                                            <strong class="fs-4 d-block text-white">${score}</strong>
                                            <span class="badge ${badgeClass} rounded-pill fs-8 text-uppercase">${level}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('dashboard') }}?country=${w.iso2}" class="btn btn-outline-primary btn-sm w-100 rounded-3">Buka Analisis</a>
                                </div>
                            </div>
                        `;
                        watchlistGrid.appendChild(col);
                    });
                }
            }
        } catch (err) {
            showToast(err.message || 'Gagal memuat daftar pantauan.', 'error');
        }
    }

    async function removeFromWatchlist(iso) {
        if (!confirm('Apakah Anda yakin ingin menghapus negara ini dari daftar pantauan?')) return;

        try {
            const res = await apiFetch(`/api/watchlist/${iso}`, { method: 'DELETE' });
            if (res.success) {
                showToast('Negara berhasil dihapus dari daftar pantauan.');
                loadWatchlist();
            }
        } catch (err) {
            showToast(err.message || 'Gagal menghapus negara dari daftar pantauan.', 'error');
        }
    }
</script>
@endsection
