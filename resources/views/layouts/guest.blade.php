<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Global Supply Chain Risk Platform')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles')
</head>
<body class="bg-background text-foreground font-sans min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">

    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-border">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-earth-americas text-primary text-xl"></i>
                <span class="font-heading font-bold tracking-wide">GlobalSCM <span class="text-primary">Intel</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}" class="btn-skeuo-outline">Masuk</a>
                <a href="{{ route('register') }}" class="btn-skeuo">Daftar</a>
            </nav>

            <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka menu"
                    class="md:hidden flex items-center justify-center w-11 h-11 rounded-xl hover:bg-muted">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden border-t border-border bg-white px-4 py-4 flex flex-col gap-3">
            <a href="{{ route('login') }}" class="btn-skeuo-outline w-full">Masuk</a>
            <a href="{{ route('register') }}" class="btn-skeuo w-full">Daftar</a>
        </div>
    </header>

    <main class="flex-1">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </div>
    </main>

    <footer class="border-t border-border bg-white py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-muted-foreground">
            &copy; {{ date('Y') }} GlobalSCM Intel &mdash; Global Supply Chain Risk Intelligence Platform
        </div>
    </footer>

    <div id="toastRoot" class="fixed bottom-4 right-4 z-[100] flex flex-col gap-2 items-end"></div>

    @yield('scripts')
</body>
</html>
