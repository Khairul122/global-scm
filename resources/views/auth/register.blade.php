@extends('layouts.app')

@section('title', 'Daftar - Global SCM Risk Intel')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="glass-card p-5 shadow-lg">
            <div class="text-center mb-4">
                <i class="fa-solid fa-user-plus text-primary fs-1 mb-3"></i>
                <h3 class="fw-bold">Buat Akun</h3>
                <p class="text-secondary">Daftar untuk memantau data risiko rantai pasok secara personal</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-secondary fw-semibold">Nama Lengkap</label>
                    <input type="text" class="form-control bg-dark border-secondary text-white py-2 px-3 rounded-3" id="name" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-secondary fw-semibold">Alamat Email</label>
                    <input type="email" class="form-control bg-dark border-secondary text-white py-2 px-3 rounded-3" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-secondary fw-semibold">Password</label>
                    <input type="password" class="form-control bg-dark border-secondary text-white py-2 px-3 rounded-3" id="password" name="password" placeholder="Minimal 8 karakter" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label text-secondary fw-semibold">Konfirmasi Password</label>
                    <input type="password" class="form-control bg-dark border-secondary text-white py-2 px-3 rounded-3" id="password_confirmation" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-semibold">Daftar Akun</button>
            </form>
            <div class="text-center mt-4">
                <p class="text-secondary mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary text-decoration-none">Masuk</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
