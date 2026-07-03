<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Global Supply Chain Risk Platform')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body class="bg-background text-foreground font-sans min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">

    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-border">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-earth-americas text-primary text-xl"></i>
                <span class="font-heading font-bold tracking-wide">GlobalSCM <span class="text-primary">Intel</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn-skeuo-outline">{{ __('Masuk') }}</a>
                <a href="{{ route('register') }}" class="btn-skeuo">{{ __('Daftar') }}</a>

                <!-- Lang Switcher -->
                <div class="flex items-center gap-1 bg-surface border border-border p-1 rounded-xl ml-2">
                    <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() === 'id' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground hover:text-foreground' }}">ID</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() === 'en' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground hover:text-foreground' }}">EN</a>
                </div>
            </nav>

            <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka menu"
                    class="md:hidden flex items-center justify-center w-11 h-11 rounded-xl hover:bg-muted">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden border-t border-border bg-white px-4 py-4 flex flex-col gap-3">
            <a href="{{ route('login') }}" class="btn-skeuo-outline w-full">{{ __('Masuk') }}</a>
            <a href="{{ route('register') }}" class="btn-skeuo w-full">{{ __('Daftar') }}</a>
            <div class="flex items-center justify-between border-t border-border pt-3 mt-1">
                <span class="text-xs text-muted-foreground font-semibold">Pilih Bahasa / Language</span>
                <div class="flex items-center gap-1 bg-surface border border-border p-1 rounded-xl">
                    <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ app()->getLocale() === 'id' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground' }}">ID</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ app()->getLocale() === 'en' ? 'bg-primary text-white shadow-sm' : 'text-muted-foreground' }}">EN</a>
                </div>
            </div>
        </div>
    </header>
    @endif

    <main class="flex-1 flex flex-col">
        @yield('content')
    </main>

    @if(!request()->routeIs('login') && !request()->routeIs('register'))
    <footer class="border-t border-border bg-white py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-muted-foreground">
            &copy; {{ date('Y') }} GlobalSCM Intel &mdash; Global Supply Chain Risk Intelligence Platform
        </div>
    </footer>
    @endif

    <div id="toastRoot" class="fixed bottom-4 right-4 z-[100] flex flex-col gap-2 items-end"></div>

    @yield('scripts')

    @if($errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: 'Kesalahan Validasi',
                    text: "{{ $errors->first() }}",
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-2xl border border-border shadow-2xl',
                        confirmButton: 'btn-skeuo !bg-none !bg-[var(--color-danger)] !shadow-none'
                    }
                });
            });
        </script>
    @endif

    @if(session('logout_success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    title: 'Keluar Berhasil',
                    text: "{{ session('logout_success') }}",
                    icon: 'success',
                    confirmButtonColor: '#0f766e',
                    background: '#ffffff',
                    customClass: {
                        popup: 'rounded-2xl border border-border shadow-2xl',
                        confirmButton: 'btn-skeuo !bg-none !bg-[var(--color-primary)] !shadow-none'
                    }
                });
            });
        </script>
    @endif
</body>
</html>
