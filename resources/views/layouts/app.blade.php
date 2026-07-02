<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Global Supply Chain Risk Platform')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">
    
    <!-- Leaflet.js CSS (Maps) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Leaflet MarkerCluster CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <!-- App Styles -->
    @vite(['resources/css/app.css'])

    @yield('styles')
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fa-solid fa-earth-americas me-2 text-primary fs-4"></i>
                <span class="fw-bold tracking-wide">GlobalSCM <span class="text-primary">Intel</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('dashboard') ? 'active text-primary' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-chart-column me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('weather') ? 'active text-primary' : '' }}" href="/weather">
                            <i class="fa-solid fa-cloud-sun-rain me-1"></i> Cuaca
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('currency') ? 'active text-primary' : '' }}" href="/currency">
                            <i class="fa-solid fa-money-bill-transfer me-1"></i> Valuta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('ports') ? 'active text-primary' : '' }}" href="/ports">
                            <i class="fa-solid fa-ship me-1"></i> Pelabuhan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('news') ? 'active text-primary' : '' }}" href="/news">
                            <i class="fa-solid fa-newspaper me-1"></i> Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('analytics') ? 'active text-primary' : '' }}" href="/analytics">
                            <i class="fa-solid fa-chart-line me-1"></i> Analitik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('compare') ? 'active text-primary' : '' }}" href="/compare">
                            <i class="fa-solid fa-scale-balanced me-1"></i> Komparasi
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('watchlist') ? 'active text-primary' : '' }}" href="{{ route('watchlist') }}">
                            <i class="fa-solid fa-star me-1 text-warning"></i> Watchlist
                        </a>
                    </li>
                    @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin') ? 'active text-primary' : '' }}" href="{{ route('admin') }}">
                            <i class="fa-solid fa-user-shield me-1"></i> Admin
                        </a>
                    </li>
                    @endif
                    @endauth
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle px-3 py-1.5 glass-card" type="button" id="userMenu" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle me-1 text-primary"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end border-secondary p-1">
                            <li class="p-2 border-bottom border-secondary mb-1">
                                <small class="text-secondary d-block">Role</small>
                                <span class="badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">{{ strtoupper(Auth::user()->role) }}</span>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2 border-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content Container -->
    <div class="container" style="margin-top: 90px; margin-bottom: 50px;">
        @yield('content')
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="globalToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="toastMessage">Pesan</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Scripts (Bootstrap Bundle, ChartJS, Leaflet) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <!-- Global Javascript Utilities -->
    <script>
        // Setup CSRF headers for fetch/ajax calls
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast show helper
        const toastEl = document.getElementById('globalToast');
        const toast = new bootstrap.Toast(toastEl);
        
        function showToast(message, type = 'success') {
            document.getElementById('toastMessage').innerText = message;
            toastEl.className = 'toast align-items-center text-white border-0';
            if (type === 'success') {
                toastEl.classList.add('bg-success');
            } else if (type === 'danger' || type === 'error') {
                toastEl.classList.add('bg-danger');
            } else {
                toastEl.classList.add('bg-warning', 'text-dark');
            }
            toast.show();
        }

        // Global ajax fetcher with auto JSON parsing and error handling
        async function apiFetch(url, options = {}) {
            options.headers = options.headers || {};
            options.headers['X-CSRF-TOKEN'] = csrfToken;
            options.headers['Accept'] = 'application/json';
            
            if (options.body && !(options.body instanceof FormData) && typeof options.body === 'object') {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(options.body);
            }

            try {
                const response = await fetch(url, options);
                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.error?.message || result.message || 'Kesalahan Server Internal');
                }
                return result;
            } catch (err) {
                console.error("API error fetching " + url + ":", err);
                throw err;
            }
        }
    </script>

    @yield('scripts')
</body>
</html>
