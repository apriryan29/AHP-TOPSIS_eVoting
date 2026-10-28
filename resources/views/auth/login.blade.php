{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Votura</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center relative overflow-hidden px-8 py-8">

<canvas id="canvas-bg" class="fixed inset-0 z-0 pointer-events-none"></canvas>

  <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-orange-100 p-8 w-full max-w-md relative z-10">

    {{-- Logo --}}
    <div class="flex items-center gap-3 mb-6">
      <img src="{{ asset('images/VotingMU.png') }}" alt="Votura" class="h-9 w-auto">
    </div>

    <h2 class="text-xl font-semibold text-gray-800">Masuk ke akun</h2>
    <p class="text-sm text-gray-400 mt-1 mb-6">Gunakan email dan password yang terdaftar.</p>

    {{-- Error Global --}}
    @if ($errors->has('email') && !$errors->has('password'))
      <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg px-4 py-3 mb-4">
        {{ $errors->first('email') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf

      {{-- Email --}}
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600 mb-1" for="email">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="nama@email.com"
          autocomplete="email"
          class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                 {{ $errors->has('email') ? 'border-red-400' : '' }}"
        />
        @error('email')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600 mb-1" for="password">Password</label>
        <div class="relative">
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Masukkan password"
            autocomplete="current-password"
            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400
                   {{ $errors->has('password') ? 'border-red-400' : '' }}"
          />
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
        @error('password')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Remember + Forgot --}}
      <div class="flex items-center justify-between mb-5">
        <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
          <input type="checkbox" name="remember" class="accent-orange-500" />
          Ingat saya
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:underline">Lupa password?</a>
      </div>

      <button type="submit"
        class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-2.5 rounded-lg text-sm transition">
        Masuk
      </button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-5">
      <a href="{{ url('/') }}" class="text-orange-500 font-medium hover:underline">← Kembali ke Beranda</a>
    </p>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';

      const icon = document.getElementById('eye-icon');
      if (input.type === 'text') {
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
      } else {
        icon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
      }
    }

    (function () {
      const canvas = document.getElementById('canvas-bg');
      const ctx    = canvas.getContext('2d');
      let W, H, particles = [], raf;

      function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
      }

      function rand(min, max) { return Math.random() * (max - min) + min; }

      function createParticle() {
        return {
          x:     rand(0, W),
          y:     rand(0, H),
          r:     rand(1, 3),
          vx:    rand(-0.5, 0.5),
          vy:    rand(-0.8, -0.2),
          alpha: rand(0.1, 0.4),
          color: ['251,146,60', '249,115,22', '234,88,12', '253,186,116', '254,215,170'][Math.floor(Math.random() * 5)],
        };
      }

      function init() {
        particles = Array.from({ length: 150 }, createParticle);
      }

      function draw() {
        ctx.clearRect(0, 0, W, H);

        const grd = ctx.createRadialGradient(W/2, H/2, 0, W/2, H/2, W * 0.7);
        grd.addColorStop(0, 'rgba(251,146,60,0.12)');
        grd.addColorStop(0.5, 'rgba(249,115,22,0.05)');
        grd.addColorStop(1, 'rgba(243,244,246,0)');
        ctx.fillStyle = grd;
        ctx.fillRect(0, 0, W, H);

        particles.forEach(p => {
          // glow effect
          const glow = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 3);
          glow.addColorStop(0, `rgba(${p.color},${p.alpha})`);
          glow.addColorStop(1, `rgba(${p.color},0)`);
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.r * 3, 0, Math.PI * 2);
          ctx.fillStyle = glow;
          ctx.fill();

          // core dot
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
          ctx.fillStyle = `rgba(${p.color},${p.alpha})`;
          ctx.fill();

          p.x += p.vx;
          p.y += p.vy;

          if (p.y < -10) { p.y = H + 5; p.x = rand(0, W); }
          if (p.x < -10) p.x = W + 5;
          if (p.x > W + 10) p.x = -5;
        });

        for (let i = 0; i < particles.length; i++) {
          for (let j = i + 1; j < particles.length; j++) {
            const dx   = particles[i].x - particles[j].x;
            const dy   = particles[i].y - particles[j].y;
            const dist = Math.sqrt(dx*dx + dy*dy);
            if (dist < 110) {
              ctx.beginPath();
              ctx.moveTo(particles[i].x, particles[i].y);
              ctx.lineTo(particles[j].x, particles[j].y);
              ctx.strokeStyle = `rgba(249,115,22,${0.2 * (1 - dist/110)})`;
              ctx.lineWidth   = 0.8;
              ctx.stroke();
            }
          }
        }

        raf = requestAnimationFrame(draw);
      }

      window.addEventListener('resize', resize);
      resize();
      init();
      draw();

      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        cancelAnimationFrame(raf);
        ctx.clearRect(0, 0, W, H);
      }
    })();
  </script>
</body>
</html>