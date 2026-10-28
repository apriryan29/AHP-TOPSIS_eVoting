<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Votura</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:   #0A1628;
            --navy2:  #0F1F3D;
            --blue:   #1E6FFF;
            --blue2:  #3B87FF;
            --gold:   #c5912a;
            --gold2:  #FFD17A;
            --light:  #F0F4FF;
            --muted:  #8A9BC0;
            --white:  #FFFFFF;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--light);
            color: var(--navy2);
            overflow-x: hidden;
        }

        /* ── CANVAS BACKGROUND ── */
        #canvas-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ── LAYOUT ── */
        .page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        /* ── HEADER ── */
        header {
            padding: 1.5rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            backdrop-filter: blur(12px);
            background: rgba(10,22,40,0.6);
        }

        .logo {
            display: flex;
            align-items: center;
            height: 6px;
            width: auto;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(30,111,255,0.4);
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            color: var(--white);
        }

        .logo-sub {
            font-size: 0.65rem;
            font-weight: 400;
            color: var(--muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .header-badge {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(244,185,66,0.12);
            border: 1px solid rgba(244,185,66,0.3);
            border-radius: 99px;
            padding: 0.35rem 0.9rem;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--gold2);
            letter-spacing: 0.04em;
        }

        .badge-dot {
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%,100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.5; transform: scale(0.7); }
        }

        /* ── HERO ── */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 2rem;
            gap: 2rem;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(30,111,255,0.12);
            border: 1px solid rgba(30,111,255,0.3);
            border-radius: 99px;
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--blue2);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            animation: fadeUp 0.6s ease both;
        }

        .hero-eyebrow svg { width: 14px; height: 14px; }

        .hero-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.4rem, 6vw, 4.2rem);
            font-weight: 700;
            line-height: 1.08;
            letter-spacing: -0.02em;
            max-width: 720px;
            animation: fadeUp 0.6s 0.1s ease both;
        }

        .hero-title .accent {
            background: linear-gradient(90deg, var(--gold), var(--gold2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            max-width: 800px;
            font-size: 1.05rem;
            line-height: 1.65;
            color: var(--muted);
            animation: fadeUp 0.6s 0.2s ease both;
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: flex;
            gap: 0;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            overflow: hidden;
            background: rgba(15,31,61,0.7);
            backdrop-filter: blur(12px);
            animation: fadeUp 0.6s 0.3s ease both;
        }

        .stat {
            padding: 1.1rem 2.2rem;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.08);
        }

        .stat:last-child { border-right: none; }

        .stat-num {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
        }

        .stat-num span { color: var(--gold); }

        .stat-label {
            font-size: 0.7rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-top: 0.3rem;
        }

        /* ── CTA ── */
        .cta-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.2rem;
            animation: fadeUp 0.6s 0.4s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            padding: 0.95rem 2.4rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 24px rgba(30,111,255,0.45), 0 0 0 0 rgba(30,111,255,0);
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(30,111,255,0.6);
        }

        .btn-primary:active { transform: translateY(0); }

        .btn-primary svg { width: 18px; height: 18px; }

        .cta-note {
            font-size: 0.78rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cta-note svg { width: 13px; height: 13px; color: var(--gold); }

        /* ── FEATURES ── */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            overflow: hidden;
            max-width: 860px;
            width: 100%;
            animation: fadeUp 0.6s 0.5s ease both;
        }

        .feature {
            background: rgba(10,22,40,0.9);
            padding: 1.6rem 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
            transition: background 0.2s;
        }

        .feature:hover { background: rgba(15,31,61,0.95); }

        .feat-icon {
            width: 38px; height: 38px;
            background: rgba(30,111,255,0.15);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: var(--blue2);
        }

        .feat-icon svg { width: 18px; height: 18px; }

        .feat-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--white);
        }

        .feat-desc {
            font-size: 0.78rem;
            color: var(--muted);
            line-height: 1.55;
        }

        /* ── FOOTER ── */
        footer {
            padding: 1.2rem 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255,255,255,0.07);
            font-size: 0.75rem;
            color: var(--muted);
        }

        footer a { color: var(--muted); text-decoration: none; }
        footer a:hover { color: var(--white); }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            header { padding: 1.2rem 1.5rem; }
            .header-badge { display: none; }
            .stats-row { flex-wrap: wrap; border-radius: 12px; }
            .stat { flex: 1 1 45%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.08); }
            .stat:last-child, .stat:nth-child(3) { border-bottom: none; }
            .features { grid-template-columns: 1fr; }
            footer { flex-direction: column; gap: 0.5rem; text-align: center; }
        }
    </style>
</head>
<body>

<canvas id="canvas-bg"></canvas>

<div class="page">
    <!-- HERO -->
    <main class="hero">

        <div class="hero-eyebrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            <span id="nama-pemilihan">Memuat...</span>
        </div>

        <img src="{{ asset('images/logo1.png') }}" alt="Voting Icon" width="auto" height="96">
        <h1 class="hero-title">
            Suara Anda,<br>
            <span class="accent">Tercatat & Terlindungi</span>
        </h1>

        <p class="hero-desc" style="padding-bottom: 3rem;" id="deskripsi-pemilihan">
            Memuat...
        </p>

        <!-- CTA -->
        <div class="cta-group">
            {{-- Ganti href dengan route('admin.login') jika sudah ada route --}}
            <a href="{{ route('login') }}" class="btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk sebagai Administrator
            </a>
            <p class="cta-note">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                Akses terbatas — hanya untuk petugas berwenang
            </p>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <span>© 2026 Votura · Sistem Pengelolaan Pemilihan</span>
        <span>v1.1.0</span>
    </footer>

</div>

<!-- PARTICLE BACKGROUND SCRIPT -->
<script>
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
            r:     rand(1, 5),
            vx:    rand(-0.25, 0.25),
            vy:    rand(-0.4, -0.1),
            alpha: rand(0.05, 0.3),
            color: Math.random() > 0.5 ? '30,111,255' : '244,185,66',
        };
    }

    function init() {
        particles = Array.from({ length: 90 }, createParticle);
    }

    function draw() {
        ctx.clearRect(0, 0, W, H);

        /* subtle radial glow at center */
        const grd = ctx.createRadialGradient(W/2, H/2, 0, W/2, H/2, W * 0.55);
        grd.addColorStop(0,   'rgba(30,111,255,0.07)');
        grd.addColorStop(1,   'rgba(10,22,40,0)');
        ctx.fillStyle = grd;
        ctx.fillRect(0, 0, W, H);

        particles.forEach(p => {
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

        /* draw faint connecting lines between nearby particles */
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 90) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(30,111,255,${0.06 * (1 - dist/90)})`;
                    ctx.lineWidth   = 0.5;
                    ctx.stroke();
                }
            }
        }

        raf = requestAnimationFrame(draw);
    }

    window.addEventListener('resize', () => { resize(); });
    resize();
    init();
    draw();

    /* respect reduced motion */
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        cancelAnimationFrame(raf);
        ctx.clearRect(0, 0, W, H);
    }
})();
</script>

<script>
fetch('/api/pemilihan')
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data) {
            if (data.data.nama_pemilihan) {
                document.getElementById('nama-pemilihan').textContent = data.data.nama_pemilihan;
            }
            if (data.data.deskripsi) {
                document.getElementById('deskripsi-pemilihan').textContent = data.data.deskripsi;
            }
        }
    })
    .catch(() => {
        document.getElementById('nama-pemilihan').textContent = 'Sistem E-Voting';
        document.getElementById('deskripsi-pemilihan').textContent = 'Platform pengelolaan pemilihan elektronik yang aman, transparan, dan terverifikasi.';
    });
</script>

</body>
</html>