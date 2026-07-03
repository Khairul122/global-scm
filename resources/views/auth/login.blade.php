@extends('layouts.guest')

@section('title', 'Masuk - Global SCM Risk Intel')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1 flex items-center justify-center" style="min-height: 65vh;">
    <div class="w-full max-w-md animate-slide-up">
        <div class="skeuo-card p-8">
            <div class="text-center mb-6">
                <i class="fa-solid fa-lock-open text-primary text-3xl mb-3"></i>
                <h3 class="font-bold text-xl">Masuk Platform</h3>
                <p class="text-muted-foreground">Silakan masuk untuk mengakses fitur portofolio dan watchlist</p>
            </div>

            @if($errors->any())
                <div class="bg-danger/10 text-danger border border-danger/25 rounded-xl p-3 mb-4 text-sm">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-muted-foreground mb-1.5">Alamat Email</label>
                    <input type="email" class="input-skeuo" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-muted-foreground mb-1.5">Password</label>
                    <input type="password" class="input-skeuo" id="password" name="password" required>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" class="w-4 h-4 accent-primary rounded" id="remember" name="remember">
                    <label class="text-sm text-muted-foreground" for="remember">Ingat Saya</label>
                </div>
                <button type="submit" class="btn-skeuo w-full">Masuk</button>
            </form>
            <div class="text-center mt-6">
                <p class="text-muted-foreground">Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-semibold hover:underline">Daftar Sekarang</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
