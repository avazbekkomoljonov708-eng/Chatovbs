@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ink: #0a0a0a;
        --paper: #faf9f6;
        --line: #262626;
        --line-soft: #dedad2;
        --muted-on-dark: #8a8a85;
        --muted-on-light: #6b6b66;
        --error: #d64545;
        --radius-outer: 28px;
        --radius-field: 10px;
    }

    * { box-sizing: border-box; }

    body {
        background: #000;
    }

    .reg-page {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow: hidden;
    }

    .reg-shell {
        width: 100%;
        max-width: 1180px;
        height: 100%;
        max-height: 780px;
        position: relative;
        display: grid;
        grid-template-columns: 42% 58%;
        border-radius: var(--radius-outer);
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.55);
        opacity: 0;
        animation: shellIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    @keyframes shellIn {
        from { opacity: 0; transform: translateY(24px) scale(0.985); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ---------- THEME TOGGLE ---------- */
    .theme-toggle {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 52px;
        height: 30px;
        border-radius: 999px;
        border: none;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(6px);
        cursor: pointer;
        z-index: 10;
        padding: 3px;
        display: flex;
        align-items: center;
        box-shadow: inset 0 0 0 1px rgba(255,255,255,0.14), 0 4px 14px rgba(0,0,0,0.25);
        transition: background 0.4s ease, box-shadow 0.4s ease;
        opacity: 0;
        animation: togglePop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        animation-delay: 0.55s;
    }

    @keyframes togglePop {
        from { opacity: 0; transform: scale(0.6) rotate(-20deg); }
        to { opacity: 1; transform: scale(1) rotate(0deg); }
    }

    .theme-toggle:hover {
        background: rgba(255,255,255,0.14);
    }

    .theme-toggle-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: var(--paper);
        transform: translateX(0);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        transition: transform 0.4s cubic-bezier(0.65,0,0.35,1), background 0.4s ease;
    }

    .theme-toggle-dot svg {
        width: 13px;
        height: 13px;
        stroke: var(--ink);
        transition: stroke 0.4s ease, opacity 0.25s ease, transform 0.35s ease;
    }

    .theme-toggle-dot .icon-sun {
        position: absolute;
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }

    .theme-toggle-dot .icon-moon {
        position: absolute;
        opacity: 0;
        transform: scale(0.4) rotate(-60deg);
    }

    /* ---------- LEFT: identity panel ---------- */
    .reg-side {
        background: var(--ink);
        color: var(--paper);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 32px 40px;
        overflow: hidden;
        transition: background 0.4s ease, color 0.4s ease;
    }

    .reg-side canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .reg-mark {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 24px;
        letter-spacing: 0.01em;
        position: relative;
        z-index: 2;
        display: flex;
    }

    .reg-mark .ch-letter {
        display: inline-block;
        opacity: 0;
        transform: translateY(10px);
        animation: letterIn 0.5s ease forwards;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .reg-mark .ch-letter:hover {
        transform: translateY(-3px);
        color: #fff;
    }

    .reg-mark .ch-apo { color: var(--muted-on-dark); font-weight: 400; }

    @keyframes letterIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .reg-copy {
        position: relative;
        z-index: 2;
    }

    .region-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        max-width: 190px;
        margin: 22px 0;
    }

    .region-dot {
        width: 100%;
        aspect-ratio: 1;
        border: 1px solid var(--line);
        border-radius: 50%;
        background: transparent;
        animation: dotPulse 4.8s ease-in-out infinite;
        animation-delay: calc(var(--i) * 0.18s);
        transition: transform 0.25s ease, border-color 0.25s ease;
    }

    .region-dot:hover {
        transform: scale(1.25);
        border-color: #fff;
        background: #fff;
    }

    @keyframes dotPulse {
        0%, 84%, 100% { background: transparent; border-color: var(--line); }
        8% { background: var(--paper); border-color: var(--paper); }
    }

    .reg-copy h1 {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: clamp(26px, 2.8vw, 34px);
        line-height: 1.12;
        margin: 0 0 10px;
        letter-spacing: -0.01em;
    }

    .reg-copy p {
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        line-height: 1.5;
        color: var(--muted-on-dark);
        max-width: 300px;
        margin: 0;
    }

    .reg-foot {
        position: relative;
        z-index: 2;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        color: var(--muted-on-dark);
        letter-spacing: 0.04em;
        border-top: 1px solid var(--line);
        padding-top: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .reg-foot .credit {
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: none;
    }

    .reg-foot .credit-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--paper);
        animation: creditBlink 2.4s ease-in-out infinite;
    }

    @keyframes creditBlink {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }

    .reg-foot .credit b {
        color: var(--paper);
        font-weight: 700;
        letter-spacing: 0.03em;
    }

    /* ---------- RIGHT: form panel ---------- */
    .reg-form-panel {
        background: var(--paper);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 44px 28px;
        height: 100%;
        overflow-y: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
        transition: background 0.4s ease;
    }

    .reg-form-panel::-webkit-scrollbar {
        display: none;
    }

    .reg-form-inner {
        width: 100%;
        max-width: 440px;
        margin-top: auto;
        margin-bottom: auto;
    }

    .reg-form-header {
        margin-bottom: 24px;
        opacity: 0;
        animation: rise 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        animation-delay: 0.15s;
    }

    .reg-form-header h2 {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 25px;
        color: var(--ink);
        margin: 0 0 6px;
        letter-spacing: -0.01em;
        transition: color 0.4s ease;
    }

    .reg-form-header p {
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        color: var(--muted-on-light);
        margin: 0;
        transition: color 0.4s ease;
    }

    @keyframes rise {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .field {
        margin-bottom: 14px;
        opacity: 0;
        animation: rise 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .form-row .field { margin-bottom: 0; }


    .field label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--muted-on-light);
        margin-bottom: 6px;
        transition: color 0.4s ease;
    }

    .field input {
        width: 100%;
        background: #fff;
        border: 1.5px solid var(--line-soft);
        color: var(--ink);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        padding: 10px 14px;
        outline: none;
        border-radius: var(--radius-field);
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.15s ease, background 0.4s ease, color 0.4s ease;
    }

    .field input::placeholder { color: #c3c0b8; }

    .field input:hover {
        border-color: #b9b6ac;
    }

    .field input:focus {
        border-color: var(--ink);
        box-shadow: 0 0 0 4px rgba(10,10,10,0.06);
    }

    .field input.is-invalid {
        border-color: var(--error);
    }

    .field .invalid-feedback {
        display: block;
        font-family: 'Inter', sans-serif;
        color: var(--error);
        font-size: 12.5px;
        margin-top: 8px;
    }

    .submit-btn {
        width: 100%;
        border: 1.5px solid var(--ink);
        border-radius: var(--radius-field);
        background: var(--ink);
        color: var(--paper);
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 15.5px;
        letter-spacing: 0.02em;
        padding: 13px;
        margin-top: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        z-index: 0;
        transition: color 0.4s ease, transform 0.18s ease, box-shadow 0.25s ease, background 0.4s ease, border-color 0.4s ease;
        opacity: 0;
        animation: rise 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        animation-delay: 0.44s;
    }

    .submit-btn::before {
        content: "";
        position: absolute;
        inset: 0;
        background: var(--paper);
        transform: scaleX(0);
        transform-origin: left;
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.65, 0, 0.35, 1), background 0.4s ease;
    }

    .submit-btn:hover {
        color: var(--ink);
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(10,10,10,0.22);
    }

    .submit-btn:hover::before {
        transform: scaleX(1);
    }

    .submit-btn svg { transition: transform 0.25s ease; }

    .submit-btn:hover svg { transform: translateX(4px); }

    .submit-btn:active { transform: translateY(0) scale(0.99); }

    .reg-footer {
        margin-top: 14px;
        text-align: center;
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        color: var(--muted-on-light);
        opacity: 0;
        animation: rise 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        animation-delay: 0.48s;
        transition: color 0.4s ease;
    }

    .reg-footer a {
        color: var(--ink);
        font-weight: 600;
        text-decoration: none;
        border-bottom: 1px solid var(--ink);
        transition: opacity 0.2s ease, color 0.4s ease, border-color 0.4s ease;
    }

    .reg-footer a:hover { opacity: 0.6; }

    /* ---------- SWAPPED THEME STATE ---------- */
    .reg-shell.theme-swap .reg-side {
        background: var(--paper);
        color: var(--ink);
    }
    .reg-shell.theme-swap .reg-side .ch-letter { color: var(--ink); }
    .reg-shell.theme-swap .reg-side .ch-letter:hover { color: #000; }
    .reg-shell.theme-swap .reg-side .ch-apo,
    .reg-shell.theme-swap .reg-copy p,
    .reg-shell.theme-swap .reg-foot { color: var(--muted-on-light); }
    .reg-shell.theme-swap .reg-foot { border-top-color: var(--line-soft); }
    .reg-shell.theme-swap .reg-foot .credit-dot { background: var(--ink); }
    .reg-shell.theme-swap .reg-foot .credit b { color: var(--ink); }
    .reg-shell.theme-swap .region-dot { border-color: var(--line-soft); }
    .reg-shell.theme-swap .region-dot:hover { border-color: var(--ink); background: var(--ink); }

    .reg-shell.theme-swap .theme-toggle {
        background: rgba(10,10,10,0.06);
        box-shadow: inset 0 0 0 1px rgba(10,10,10,0.12), 0 4px 14px rgba(10,10,10,0.12);
    }
    .reg-shell.theme-swap .theme-toggle:hover {
        background: rgba(10,10,10,0.1);
    }
    .reg-shell.theme-swap .theme-toggle-dot {
        background: var(--ink);
        transform: translateX(22px);
    }
    .reg-shell.theme-swap .theme-toggle-dot svg {
        stroke: var(--paper);
    }
    .reg-shell.theme-swap .theme-toggle-dot .icon-sun {
        opacity: 0;
        transform: scale(0.4) rotate(60deg);
    }
    .reg-shell.theme-swap .theme-toggle-dot .icon-moon {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }

    .reg-shell.theme-swap .reg-form-panel { background: var(--ink); }
    .reg-shell.theme-swap .reg-form-header h2 { color: var(--paper); }
    .reg-shell.theme-swap .reg-form-header p,
    .reg-shell.theme-swap .field label,
    .reg-shell.theme-swap .reg-footer { color: var(--muted-on-dark); }

    .reg-shell.theme-swap .field input {
        background: #161616;
        border-color: #333;
        color: var(--paper);
    }
    .reg-shell.theme-swap .field input::placeholder { color: #55534d; }
    .reg-shell.theme-swap .field input:hover { border-color: #4a4a45; }
    .reg-shell.theme-swap .field input:focus {
        border-color: var(--paper);
        box-shadow: 0 0 0 4px rgba(250,249,246,0.08);
    }

    .reg-shell.theme-swap .submit-btn {
        border-color: var(--paper);
        background: var(--paper);
        color: var(--ink);
    }
    .reg-shell.theme-swap .submit-btn::before { background: var(--ink); }
    .reg-shell.theme-swap .submit-btn:hover { color: var(--paper); }

    .reg-shell.theme-swap .reg-footer a { color: var(--paper); border-color: var(--paper); }

    @media (max-width: 900px) {
        .reg-page { height: auto; min-height: 100vh; padding: 0; overflow: visible; }
        .reg-shell { grid-template-columns: 1fr; height: auto; max-height: none; border-radius: 0; box-shadow: none; }
        .reg-side { display: none; }
        .reg-form-panel { padding: 40px 24px; overflow: visible; }
        .form-row { grid-template-columns: 1fr; gap: 14px; }
        .form-row .field { margin-bottom: 14px; }
        .form-row .field:last-child { margin-bottom: 0; }
        .theme-toggle { display: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .field, .reg-form-header, .submit-btn, .reg-footer, .region-dot, .reg-shell, .ch-letter {
            animation: none !important;
            opacity: 1 !important;
        }
    }
</style>

<div class="reg-page">
    <div class="reg-shell">
        <button type="button" class="theme-toggle" id="themeToggle" aria-label="Mavzuni almashtirish">
            <span class="theme-toggle-dot">
                <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"></path>
                </svg>
                <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                </svg>
            </span>
        </button>

        <aside class="reg-side">
            <canvas id="particleCanvas"></canvas>

            <div class="reg-mark" aria-label="ChatO'VBS">
                @php $brand = ['C','h','a','t','O']; @endphp
                @foreach ($brand as $i => $letter)
                    <span class="ch-letter" style="animation-delay: {{ $i * 0.05 }}s">{{ $letter }}</span>
                @endforeach
                <span class="ch-letter ch-apo" style="animation-delay: 0.30s">'</span>
                @foreach (['V','B','S'] as $i => $letter)
                    <span class="ch-letter" style="animation-delay: {{ 0.35 + $i * 0.05 }}s">{{ $letter }}</span>
                @endforeach
            </div>

            <div class="reg-copy">
                <div class="region-grid" aria-hidden="true">
                    @for ($i = 0; $i < 12; $i++)
                        <span class="region-dot" style="--i: {{ $i }}"></span>
                    @endfor
                </div>
                <h1>12 viloyat,<br>bitta suhbat.</h1>
                <p>O'zbekistonning barcha hududlarini bir platformada birlashtiruvchi suhbat tizimiga xush kelibsiz.</p>
            </div>

            <div class="reg-foot">
                <span>ChatO'VBS &middot; Ro'yxatdan o'tish</span>
                <span class="credit"><span class="credit-dot"></span>Yaratuvchi: <b>PROGRESS IT</b></span>
            </div>
        </aside>

        <section class="reg-form-panel">
            <div class="reg-form-inner">
                <div class="reg-form-header">
                    <h2>Hisob yarating</h2>
                    <p>Bir necha soniyada ro'yxatdan o'ting va 12 viloyat suhbatiga qo'shiling.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="field" style="animation-delay: 0.20s">
                        <label for="name">Ism</label>
                        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field" style="animation-delay: 0.24s">
                        <label for="surname">Familya</label>
                        <input id="surname" type="text" class="@error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required>
                        @error('surname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field" style="animation-delay: 0.28s">
                        <label for="phone">Telefon raqam</label>
                        <input id="phone" type="tel" class="@error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+998 90 123 45 67" required>
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field" style="animation-delay: 0.32s">
                        <label for="email">Email manzil</label>
                        <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-row field" style="animation-delay: 0.36s">
                        <div class="field" style="animation: none; opacity: 1;">
                            <label for="password">Parol</label>
                            <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required>
                            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="field" style="animation: none; opacity: 1;">
                            <label for="password-confirm">Parolni tasdiqlang</label>
                            <input id="password-confirm" type="password" name="password_confirmation" required>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        Ro'yxatdan o'tish
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M13 6l6 6-6 6"></path>
                        </svg>
                    </button>

                    <div class="reg-footer">
                        Akkountingiz bormi? <a href="{{ route('login') }}">Kirish</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<script>
(function() {
    const canvas = document.getElementById('particleCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const side = canvas.parentElement;
    let particles = [];
    let mouse = { x: null, y: null };
    let w, h;

    function resize() {
        w = canvas.width = side.clientWidth;
        h = canvas.height = side.clientHeight;
    }

    function initParticles() {
        const count = Math.max(28, Math.floor((w * h) / 18000));
        particles = Array.from({ length: count }, () => ({
            x: Math.random() * w,
            y: Math.random() * h,
            vx: (Math.random() - 0.5) * 0.35,
            vy: (Math.random() - 0.5) * 0.35,
            r: Math.random() * 1.6 + 0.6
        }));
    }

    function step() {
        ctx.clearRect(0, 0, w, h);

        for (let p of particles) {
            p.x += p.vx;
            p.y += p.vy;

            if (mouse.x !== null) {
                const dx = p.x - mouse.x, dy = p.y - mouse.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 90) {
                    const force = (90 - dist) / 90;
                    p.x += (dx / dist) * force * 0.6;
                    p.y += (dy / dist) * force * 0.6;
                }
            }

            if (p.x < 0 || p.x > w) p.vx *= -1;
            if (p.y < 0 || p.y > h) p.vy *= -1;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(250,249,246,0.55)';
            ctx.fill();
        }

        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i], b = particles[j];
                const dx = a.x - b.x, dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.strokeStyle = 'rgba(250,249,246,' + (0.12 * (1 - dist / 120)) + ')';
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }

        requestAnimationFrame(step);
    }

    side.addEventListener('mousemove', function(e) {
        const rect = side.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    });
    side.addEventListener('mouseleave', function() {
        mouse.x = null;
        mouse.y = null;
    });

    window.addEventListener('resize', function() {
        resize();
        initParticles();
    });

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    resize();
    initParticles();
    if (!reduceMotion) {
        requestAnimationFrame(step);
    } else {
        step();
        ctx.clearRect(0, 0, w, h);
    }
})();

document.getElementById('themeToggle').addEventListener('click', function () {
    document.querySelector('.reg-shell').classList.toggle('theme-swap');
});
</script>
@endsection