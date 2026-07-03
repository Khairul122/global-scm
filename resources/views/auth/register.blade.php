@extends('layouts.guest')

@section('title', 'Daftar - Global SCM Risk Intel')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 min-h-screen w-full">
    <!-- Left Decorative Panel (5 Columns) with Interactive Network Canvas -->
    <div class="hidden lg:flex lg:col-span-5 flex-col justify-between p-12 text-white bg-gradient-to-br from-[#0e4f4f] via-[#0f766e] to-[#042f2e] relative overflow-hidden">
        <!-- Interactive Canvas Background -->
        <canvas id="networkCanvas" class="absolute inset-0 w-full h-full z-0 opacity-50"></canvas>

        <!-- Ambient overlay for visual depth -->
        <div class="absolute top-[-20%] left-[-20%] w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none z-0"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-80 h-80 bg-black/30 rounded-full blur-3xl pointer-events-none z-0"></div>
        
        <!-- Top branding -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 z-10">
            <i class="fa-solid fa-earth-americas text-2xl text-white"></i>
            <span class="font-heading font-bold text-xl tracking-wide">GlobalSCM <span class="opacity-85 text-white/90">Intel</span></span>
        </a>

        <!-- Middle Illustrative Graphics/Copy -->
        <div class="my-auto space-y-8 z-10 animate-slide-up">
            <div class="space-y-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-circle-nodes text-warning"></i> Geopolitical Connections
                </span>
                <h2 class="text-3xl font-extrabold leading-tight">Buat Akun Anda & Mulai Memantau</h2>
                <p class="text-teal-50/80 text-base leading-relaxed">
                    Daftar akun hari ini untuk mempersonalisasi daftar pantauan Anda. Amankan rute rantai pasok Anda dari risiko iklim ekstrem dan guncangan ekonomi dunia.
                </p>
            </div>

            <!-- Interactive indicators inside decorative panel -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl shadow-xl space-y-4">
                <div class="flex items-center justify-between text-xs text-teal-100/80">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-gauge-high text-teal-300"></i> Kecepatan Pemrosesan</span>
                    <span class="font-bold text-teal-300">Real-time / Instant</span>
                </div>
                <div class="flex items-center justify-between border-t border-white/10 pt-3 text-xs text-teal-100/80">
                    <span>Keamanan Database</span>
                    <span class="font-bold bg-white/20 px-2.5 py-0.5 rounded-full">Encrypted</span>
                </div>
            </div>
        </div>

        <!-- Bottom copyright -->
        <div class="text-xs text-teal-200/50 z-10">
            &copy; {{ date('Y') }} GlobalSCM Intel. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Right Form Panel (7 Columns) with Interactive States -->
    <div class="lg:col-span-7 flex flex-col justify-center p-6 sm:p-10 lg:p-12 bg-[#f4f7fb]"
         x-data="{ nameFocused: false, emailFocused: false, passwordFocused: false, confirmFocused: false }">
        
        <!-- Centered Register Form Card -->
        <div class="w-full max-w-md mx-auto animate-slide-up my-auto">
            <!-- Card wrapper with dynamic border glow on focus -->
            <div class="skeuo-card p-8 sm:p-10 bg-white transition-all duration-300 relative overflow-hidden"
                 :class="{ 'ring-2 ring-primary/45 border-transparent shadow-[0_12px_28px_rgba(15,118,110,0.15)]': nameFocused || emailFocused || passwordFocused || confirmFocused }">
                
                <div class="text-center mb-8">
                    <div class="bg-primary/10 inline-flex p-4 rounded-full mb-3">
                        <i class="fa-solid fa-user-plus text-primary text-2xl animate-[bounce_3s_infinite]"></i>
                    </div>
                    <h3 class="font-bold text-2xl text-dark">Daftar Akun Baru</h3>
                    <p class="text-muted-foreground text-sm mt-1">Daftarkan diri Anda untuk memantau data risiko secara personal</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <!-- Name Field -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="nameFocused ? 'text-primary' : ''">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="nameFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" class="input-skeuo !pl-9 transition-all" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap Anda" required autofocus
                                   @focus="nameFocused = true" @blur="nameFocused = false">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="emailFocused ? 'text-primary' : ''">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="emailFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" class="input-skeuo !pl-9 transition-all" id="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required
                                   @focus="emailFocused = true" @blur="emailFocused = false">
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="passwordFocused ? 'text-primary' : ''">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="passwordFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9 transition-all" id="password" name="password" placeholder="Minimal 8 karakter" required
                                   @focus="passwordFocused = true" @blur="passwordFocused = false">
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-sm font-bold text-muted-foreground transition-colors duration-200"
                               :class="confirmFocused ? 'text-primary' : ''">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center transition-colors duration-200"
                                  :class="confirmFocused ? 'text-primary' : 'text-muted-foreground/60'">
                                <i class="fa-solid fa-shield"></i>
                            </span>
                            <input type="password" class="input-skeuo !pl-9 transition-all" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required
                                   @focus="confirmFocused = true" @blur="confirmFocused = false">
                        </div>
                    </div>

                    <button type="submit" class="btn-skeuo w-full !min-h-12 !text-base mt-4 relative overflow-hidden group">
                        <span class="absolute inset-0 w-full h-full bg-white/10 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300"></span>
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Daftar Sekarang <i class="fa-solid fa-arrow-right-to-bracket transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </button>

                    <!-- Divider & Navigation Buttons integrated inside the form card -->
                    <div class="text-center pt-4 border-t border-border mt-5 space-y-4">
                        <p class="text-sm text-muted-foreground">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-primary font-bold hover:underline">
                                Masuk di Sini
                            </a>
                        </p>
                        
                        <div class="pt-2">
                            <a href="{{ route('home') }}" class="btn-skeuo-outline w-full flex items-center justify-center gap-2 !min-h-11 hover:scale-[1.01] active:scale-95 transition-all">
                                <i class="fa-solid fa-house"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer for Mobile View (Hidden on large screens) -->
        <div class="text-center text-xs text-muted-foreground lg:hidden pt-4">
            &copy; {{ date('Y') }} GlobalSCM Intel
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('networkCanvas');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let width = canvas.width = canvas.offsetWidth;
        let height = canvas.height = canvas.offsetHeight;

        window.addEventListener('resize', () => {
            width = canvas.width = canvas.offsetWidth;
            height = canvas.height = canvas.offsetHeight;
        });

        const particles = [];
        const numParticles = 45;

        for (let i = 0; i < numParticles; i++) {
            particles.push({
                x: Math.random() * width,
                y: Math.random() * height,
                vx: (Math.random() - 0.5) * 0.8,
                vy: (Math.random() - 0.5) * 0.8,
                r: Math.random() * 2 + 1.2
            });
        }

        let mouse = { x: null, y: null };
        const parent = canvas.parentElement;

        parent.addEventListener('mousemove', (e) => {
            const rect = parent.getBoundingClientRect();
            mouse.x = e.clientX - rect.left;
            mouse.y = e.clientY - rect.top;
        });

        parent.addEventListener('mouseleave', () => {
            mouse.x = null;
            mouse.y = null;
        });

        function animate() {
            ctx.clearRect(0, 0, width, height);

            // Connect particles
            for (let i = 0; i < particles.length; i++) {
                const p1 = particles[i];

                for (let j = i + 1; j < particles.length; j++) {
                    const p2 = particles[j];
                    const dist = Math.hypot(p1.x - p2.x, p1.y - p2.y);
                    if (dist < 90) {
                        ctx.strokeStyle = `rgba(20, 184, 166, ${0.15 - (dist / 90) * 0.15})`;
                        ctx.lineWidth = 0.5;
                        ctx.beginPath();
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(p2.x, p2.y);
                        ctx.stroke();
                    }
                }

                // Connect to mouse
                if (mouse.x !== null) {
                    const distMouse = Math.hypot(p1.x - mouse.x, p1.y - mouse.y);
                    if (distMouse < 140) {
                        ctx.strokeStyle = `rgba(20, 184, 166, ${0.4 - (distMouse / 140) * 0.4})`;
                        ctx.lineWidth = 0.8;
                        ctx.beginPath();
                        ctx.moveTo(p1.x, p1.y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.stroke();
                    }
                }

                // Move particle
                p1.x += p1.vx;
                p1.y += p1.vy;

                // Bounce boundaries
                if (p1.x < 0 || p1.x > width) p1.vx *= -1;
                if (p1.y < 0 || p1.y > height) p1.vy *= -1;

                // Draw node dot
                ctx.fillStyle = 'rgba(255, 255, 255, 0.4)';
                ctx.beginPath();
                ctx.arc(p1.x, p1.y, p1.r, 0, Math.PI * 2);
                ctx.fill();
            }

            requestAnimationFrame(animate);
        }

        animate();
    });
</script>
@endsection
