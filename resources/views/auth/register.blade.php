@extends('layouts.guest')

@section('title', 'Daftar - Global SCM Risk Intel')

@section('content')
<div class="flex items-center justify-center" style="min-height: 65vh;">
    <div class="w-full max-w-md animate-slide-up">
        <div class="skeuo-card p-8">
            <div class="text-center mb-6">
                <i class="fa-solid fa-user-plus text-primary text-3xl mb-3"></i>
                <h3 class="font-bold text-xl">Buat Akun</h3>
                <p class="text-muted-foreground">Daftar untuk memantau data risiko rantai pasok secara personal</p>
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-muted-foreground mb-1.5">Nama Lengkap</label>
                    <input type="text" class="input-skeuo" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-muted-foreground mb-1.5">Alamat Email</label>
                    <input type="email" class="input-skeuo" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-muted-foreground mb-1.5">Password</label>
                    <input type="password" class="input-skeuo" id="password" name="password" placeholder="Minimal 8 karakter" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-muted-foreground mb-1.5">Konfirmasi Password</label>
                    <input type="password" class="input-skeuo" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn-skeuo w-full">Daftar Akun</button>
            </form>
            <div class="text-center mt-6">
                <p class="text-muted-foreground">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Masuk</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
