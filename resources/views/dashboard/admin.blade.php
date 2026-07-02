@extends('layouts.app')

@section('title', 'Admin Dashboard - Global SCM Risk Intel')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Panel Kontrol Administrator</h2>
        <p class="text-secondary">Kelola pengguna, dataset pelabuhan (WPI), leksikon kata sentimen, artikel analisis internal, dan pembobotan skor risiko.</p>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs border-secondary mb-4" id="adminTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active text-white" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-panel" type="button"><i class="fa-solid fa-users me-1 text-primary"></i> Pengguna</button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-white" id="ports-tab" data-bs-toggle="tab" data-bs-target="#ports-panel" type="button"><i class="fa-solid fa-anchor me-1 text-primary"></i> Pelabuhan (CSV)</button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-white" id="weights-tab" data-bs-toggle="tab" data-bs-target="#weights-panel" type="button"><i class="fa-solid fa-scale-unbalanced me-1 text-primary"></i> Bobot Risiko</button>
            </li>
            <li class="nav-item">
                <button class="nav-link text-white" id="lexicon-tab" data-bs-toggle="tab" data-bs-target="#lexicon-panel" type="button"><i class="fa-solid fa-book-open me-1 text-primary"></i> Leksikon Sentimen</button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="adminTabContent">
            <!-- 1. Users Panel -->
            <div class="tab-pane fade show active" id="users-panel">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-3">Daftar Pengguna</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0 align-middle">
                            <thead>
                                <tr class="text-secondary border-secondary">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="adminUsersBody">
                                <tr><td colspan="5" class="text-center text-secondary py-4">Memuat data pengguna...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 2. Ports CSV Importer Panel -->
            <div class="tab-pane fade" id="ports-panel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-3"><i class="fa-solid fa-file-csv me-1 text-primary"></i> Impor Dataset World Port Index</h5>
                            <p class="small text-secondary mb-3">Unggah berkas CSV untuk memperbarui basis data pelabuhan global secara massal. Ukuran maksimal file adalah 5MB.</p>
                            
                            <form id="portsImportForm">
                                <div class="mb-3">
                                    <label for="csvFile" class="form-label text-secondary small fw-semibold">Pilih Berkas CSV</label>
                                    <input type="file" id="csvFile" class="form-control bg-dark border-secondary text-white" accept=".csv" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">Unggah & Proses Impor</button>
                            </form>

                            <div id="importLoading" class="text-center py-3" style="display: none;">
                                <div class="spinner-border text-primary spinner-border-sm me-2"></div>
                                <span class="small text-secondary">Memproses data... Harap tunggu</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-3">Laporan Hasil Impor</h5>
                            <div id="importReport" class="text-secondary small" style="max-height: 250px; overflow-y: auto;">
                                <p class="mb-0">Belum ada aktivitas impor di sesi ini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Weights Panel -->
            <div class="tab-pane fade" id="weights-panel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-3">Sesuaikan Bobot Skor Risiko</h5>
                            <p class="small text-secondary mb-4">Total penjumlahan seluruh bobot komponen harus bernilai tepat **1.00** agar kalkulasi skor valid.</p>
                            
                            <form id="weightsForm">
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-semibold">Bobot Cuaca (Weather Risk)</label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control bg-dark border-secondary text-white" id="wWeather" value="{{ $weights['weather'] ?? 0.30 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-semibold">Bobot Sentimen Berita (Political News Risk)</label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control bg-dark border-secondary text-white" id="wNews" value="{{ $weights['news'] ?? 0.40 }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-secondary small fw-semibold">Bobot Inflasi (Inflation Risk)</label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control bg-dark border-secondary text-white" id="wInflation" value="{{ $weights['inflation'] ?? 0.20 }}" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label text-secondary small fw-semibold">Bobot Nilai Kurs (Currency Risk)</label>
                                    <input type="number" step="0.01" min="0" max="1" class="form-control bg-dark border-secondary text-white" id="wCurrency" value="{{ $weights['currency'] ?? 0.10 }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">Simpan Bobot Baru</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Lexicon Panel -->
            <div class="tab-pane fade" id="lexicon-panel">
                <div class="row g-4">
                    <!-- Form Tambah Kata -->
                    <div class="col-lg-4">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-3">Tambah Kata Leksikon</h5>
                            <form id="lexiconForm">
                                <div class="mb-3">
                                    <label for="lexType" class="form-label text-secondary small fw-semibold">Jenis Kata</label>
                                    <select id="lexType" class="form-select bg-dark border-secondary text-white" required>
                                        <option value="positive">Positif</option>
                                        <option value="negative">Negatif</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="lexWord" class="form-label text-secondary small fw-semibold">Kata (Bahasa Inggris)</label>
                                    <input type="text" id="lexWord" class="form-control bg-dark border-secondary text-white" placeholder="Contoh: delay, boom" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-semibold">Tambah Kata</button>
                            </form>
                        </div>
                    </div>

                    <!-- List Leksikon -->
                    <div class="col-lg-8">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-3">Kamus Kata Saat Ini</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-success fw-bold border-bottom border-success pb-2">Positif</h6>
                                    <div id="posLexList" class="d-flex flex-wrap gap-2" style="max-height: 250px; overflow-y: auto;">
                                        <!-- loaded via ajax -->
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-danger fw-bold border-bottom border-danger pb-2">Negatif</h6>
                                    <div id="negLexList" class="d-flex flex-wrap gap-2" style="max-height: 250px; overflow-y: auto;">
                                        <!-- loaded via ajax -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        loadUsers();
        loadLexicon();
        
        // Form listeners
        document.getElementById('weightsForm').addEventListener('submit', handleWeightsUpdate);
        document.getElementById('lexiconForm').addEventListener('submit', handleLexiconStore);
        document.getElementById('portsImportForm').addEventListener('submit', handlePortsImport);
    });

    // 1. Load Users
    async function loadUsers() {
        const tbody = document.getElementById('adminUsersBody');
        try {
            const res = await apiFetch('/api/admin/users');
            if (res.success) {
                tbody.innerHTML = '';
                res.data.data.forEach(user => {
                    const row = document.createElement('tr');
                    row.className = 'border-secondary';
                    row.innerHTML = `
                        <td>${user.name}</td>
                        <td class="small text-secondary">${user.email}</td>
                        <td>
                            <select onchange="updateUserRole(${user.id}, this.value)" class="form-select form-select-sm bg-dark border-secondary text-white py-1">
                                <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                                <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                            </select>
                        </td>
                        <td>
                            <span class="badge ${user.is_active ? 'bg-success' : 'bg-danger'}">${user.is_active ? 'Aktif' : 'Nonaktif'}</span>
                        </td>
                        <td class="text-end">
                            <button onclick="toggleUserStatus(${user.id}, ${user.is_active})" class="btn ${user.is_active ? 'btn-outline-danger' : 'btn-outline-success'} btn-sm rounded-3">
                                ${user.is_active ? 'Nonaktifkan' : 'Aktifkan'}
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">${err.message || 'Gagal memuat pengguna.'}</td></tr>`;
        }
    }

    async function updateUserRole(userId, role) {
        try {
            const res = await apiFetch(`/api/admin/users/${userId}`, {
                method: 'PATCH',
                body: { role }
            });
            if (res.success) {
                showToast('Role pengguna berhasil diubah.');
                loadUsers();
            }
        } catch (err) {
            showToast(err.message || 'Gagal mengubah role.', 'error');
            loadUsers();
        }
    }

    async function toggleUserStatus(userId, currentStatus) {
        try {
            const res = await apiFetch(`/api/admin/users/${userId}`, {
                method: 'PATCH',
                body: { is_active: !currentStatus }
            });
            if (res.success) {
                showToast('Status pengguna berhasil diubah.');
                loadUsers();
            }
        } catch (err) {
            showToast(err.message || 'Gagal mengubah status.', 'error');
        }
    }

    // 2. Import Ports CSV
    async function handlePortsImport(e) {
        e.preventDefault();
        const fileInput = document.getElementById('csvFile');
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('file', file);

        document.getElementById('importLoading').style.display = 'block';
        const report = document.getElementById('importReport');
        report.innerHTML = '<p class="text-info">Sedang memproses file CSV...</p>';

        try {
            const res = await apiFetch('/api/admin/ports/import', {
                method: 'POST',
                body: formData
            });
            
            document.getElementById('importLoading').style.display = 'none';
            if (res.success) {
                showToast(res.meta?.message || 'Impor data selesai.');
                
                let detailsHtml = '';
                if (res.data.details.length > 0) {
                    detailsHtml = '<h6 class="text-warning mt-3 mb-1">Rincian Baris Gagal:</h6><ul class="text-danger ps-3">';
                    res.data.details.forEach(d => {
                        detailsHtml += `<li>${d}</li>`;
                    });
                    detailsHtml += '</ul>';
                }

                report.innerHTML = `
                    <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success p-3 mb-0">
                        <strong>Impor Sukses!</strong><br>
                        - Berhasil diimpor: ${res.data.imported} pelabuhan<br>
                        - Gagal / Dilewati: ${res.data.failed} baris
                    </div>
                    ${detailsHtml}
                `;
                fileInput.value = '';
            }
        } catch (err) {
            document.getElementById('importLoading').style.display = 'none';
            report.innerHTML = `<div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger p-3 mb-0"><strong>Gagal Impor:</strong><br>${err.message}</div>`;
            showToast(err.message || 'Gagal memproses file.', 'error');
        }
    }

    // 3. Update Risk Weights
    async function handleWeightsUpdate(e) {
        e.preventDefault();
        const wWeather = parseFloat(document.getElementById('wWeather').value);
        const wNews = parseFloat(document.getElementById('wNews').value);
        const wInflation = parseFloat(document.getElementById('wInflation').value);
        const wCurrency = parseFloat(document.getElementById('wCurrency').value);

        const sum = wWeather + wNews + wInflation + wCurrency;
        if (Math.abs(sum - 1.0) > 0.001) {
            showToast(`Total bobot adalah ${sum.toFixed(2)}. Penjumlahan seluruh bobot harus berjumlah 1.00!`, 'error');
            return;
        }

        try {
            const res = await apiFetch('/api/admin/risk-weights', {
                method: 'PUT',
                body: {
                    weather: wWeather,
                    news: wNews,
                    inflation: wInflation,
                    currency: wCurrency
                }
            });
            if (res.success) {
                showToast('Bobot kalkulasi risiko berhasil disimpan.');
            }
        } catch (err) {
            showToast(err.message || 'Gagal menyimpan bobot.', 'error');
        }
    }

    // 4. Lexicon KAMUS
    async function loadLexicon() {
        const posList = document.getElementById('posLexList');
        const negList = document.getElementById('negLexList');

        try {
            const res = await apiFetch('/api/admin/lexicon');
            if (res.success) {
                posList.innerHTML = '';
                negList.innerHTML = '';

                const pos = res.data.positive;
                const neg = res.data.negative;

                Object.keys(pos).forEach(id => {
                    posList.appendChild(createLexiconBadge(id, pos[id], 'positive'));
                });

                Object.keys(neg).forEach(id => {
                    negList.appendChild(createLexiconBadge(id, neg[id], 'negative'));
                });
            }
        } catch (err) {
            console.error(err);
        }
    }

    function createLexiconBadge(id, word, type) {
        const badge = document.createElement('span');
        badge.className = `badge ${type === 'positive' ? 'bg-success bg-opacity-10 text-success border border-success' : 'bg-danger bg-opacity-10 text-danger border border-danger'} p-2 d-flex align-items-center`;
        badge.innerHTML = `
            ${word}
            <i onclick="deleteLexicon(${id}, '${type}')" class="fa-solid fa-xmark ms-2 cursor-pointer text-secondary" style="font-size: 10px; cursor: pointer;"></i>
        `;
        return badge;
    }

    async function handleLexiconStore(e) {
        e.preventDefault();
        const type = document.getElementById('lexType').value;
        const wordInput = document.getElementById('lexWord');
        const word = wordInput.value;

        try {
            const res = await apiFetch('/api/admin/lexicon', {
                method: 'POST',
                body: { type, word }
            });
            if (res.success) {
                showToast(`Kata '${word}' ditambahkan ke leksikon.`);
                wordInput.value = '';
                loadLexicon();
            }
        } catch (err) {
            showToast(err.message || 'Gagal menambahkan kata.', 'error');
        }
    }

    async function deleteLexicon(id, type) {
        if (!confirm('Hapus kata ini dari leksikon?')) return;
        try {
            const res = await apiFetch(`/api/admin/lexicon/${id}?type=${type}`, {
                method: 'DELETE'
            });
            if (res.success) {
                showToast('Kata berhasil dihapus dari leksikon.');
                loadLexicon();
            }
        } catch (err) {
            showToast(err.message || 'Gagal menghapus kata.', 'error');
        }
    }
</script>
@endsection
