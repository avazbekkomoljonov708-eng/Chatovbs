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

    html, body {
        margin: 0 !important;
        padding: 0 !important;
        background: #000;
        height: 100%;
    }

    /* Laravel standart layout navbar'ini shu sahifada yashirish */
    #app nav.navbar, #app .site-header { display: none !important; }
    #app main.py-4 { padding: 0 !important; margin: 0 !important; }
    #app { min-height: 100vh; }

    .verify-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .verify-card {
        width: 100%;
        max-width: 440px;
        background: var(--paper);
        border-radius: var(--radius-outer);
        padding: 44px 40px 36px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.55);
        text-align: center;
        opacity: 0;
        animation: cardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    @keyframes cardIn {
        from { opacity: 0; transform: translateY(20px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .verify-mark {
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 22px;
        letter-spacing: 0.01em;
        color: var(--ink);
        margin-bottom: 18px;
    }

    .verify-mark .brand-apo { color: var(--muted-on-light); font-weight: 400; }

    .verify-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: var(--ink);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .verify-icon svg {
        width: 24px;
        height: 24px;
        stroke: var(--paper);
    }

    .verify-card h2 {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 22px;
        color: var(--ink);
        margin: 0 0 8px;
        letter-spacing: -0.01em;
    }

    .verify-card p {
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        line-height: 1.5;
        color: var(--muted-on-light);
        margin: 0 0 28px;
    }

    .verify-card p b {
        color: var(--ink);
        font-weight: 600;
    }

    .code-field {
        margin-bottom: 8px;
        text-align: left;
    }

    .code-field label {
        display: block;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--muted-on-light);
        margin-bottom: 8px;
    }

    .code-boxes {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .code-boxes input {
        width: 100%;
        aspect-ratio: 1;
        background: #fff;
        border: 1.5px solid var(--line-soft);
        color: var(--ink);
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 22px;
        text-align: center;
        border-radius: var(--radius-field);
        outline: none;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.15s ease;
    }

    .code-boxes input:hover { border-color: #b9b6ac; }

    .code-boxes input:focus {
        border-color: var(--ink);
        box-shadow: 0 0 0 4px rgba(10,10,10,0.06);
        transform: translateY(-1px);
    }

    .code-boxes input.is-invalid { border-color: var(--error); }

    #code {
        position: absolute;
        opacity: 0;
        pointer-events: none;
        height: 0;
        width: 0;
    }

    .invalid-feedback {
        display: block;
        font-family: 'Inter', sans-serif;
        color: var(--error);
        font-size: 12.5px;
        margin-top: 10px;
        text-align: left;
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
        margin-top: 22px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        z-index: 0;
        transition: color 0.4s ease, transform 0.18s ease, box-shadow 0.25s ease;
    }

    .submit-btn::before {
        content: "";
        position: absolute;
        inset: 0;
        background: var(--paper);
        transform: scaleX(0);
        transform-origin: left;
        z-index: -1;
        transition: transform 0.4s cubic-bezier(0.65, 0, 0.35, 1);
    }

    .submit-btn:hover {
        color: var(--ink);
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(10,10,10,0.22);
    }

    .submit-btn:hover::before { transform: scaleX(1); }
    .submit-btn:active { transform: translateY(0) scale(0.99); }

    .resend-row {
        margin-top: 22px;
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        color: var(--muted-on-light);
    }

    .resend-timer {
        color: var(--ink);
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }

    .resend-btn {
        background: none;
        border: none;
        padding: 0;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 13.5px;
        color: var(--ink);
        text-decoration: none;
        border-bottom: 1px solid var(--ink);
        cursor: pointer;
        transition: opacity 0.2s ease;
        display: none;
    }

    .resend-btn:hover { opacity: 0.6; }

    .resend-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .resend-success {
        display: none;
        margin-top: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 12.5px;
        color: #2f9e56;
    }
</style>

<div class="verify-page">
    <div class="verify-card">
        <div class="verify-mark">Chat<span class="brand-apo">O'</span>VBS</div>

        <div class="verify-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                <path d="M3 7l9 6 9-6"></path>
            </svg>
        </div>

        <h2>Emailni tasdiqlang</h2>
        <p>Emailingizga yuborilgan <b>6 xonali kodni</b> quyida kiriting</p>

        <form method="POST" action="{{ route('verify.code') }}" id="verifyForm">
            @csrf

            <div class="code-field">
                <label>Tasdiqlash kodi</label>
                <div class="code-boxes" id="codeBoxes">
                    <input type="text" inputmode="numeric" maxlength="1" autofocus>
                    <input type="text" inputmode="numeric" maxlength="1">
                    <input type="text" inputmode="numeric" maxlength="1">
                    <input type="text" inputmode="numeric" maxlength="1">
                    <input type="text" inputmode="numeric" maxlength="1">
                    <input type="text" inputmode="numeric" maxlength="1">
                </div>
                <input type="text" id="code" name="code" required>
                @error('code')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="submit-btn">
                Tasdiqlash
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M13 6l6 6-6 6"></path>
                </svg>
            </button>

            <div class="resend-row">
                Kod kelmadimi? <span class="resend-timer" id="resendTimer">01:50</span> dan keyin
                <button type="button" class="resend-btn" id="resendBtn">Qaytadan yuborish</button>
            </div>
            <div class="resend-success" id="resendSuccess">Yangi kod emailingizga yuborildi.</div>
        </form>

        @if (Route::has('verify.resend'))
            <form id="resendForm" method="POST" action="{{ route('verify.resend') }}" style="display:none;">
                @csrf
            </form>
        @endif
    </div>
</div>

<script>
(function () {
    // ---------- 6 ta katakchani bitta yashirin inputga bog'lash ----------
    var boxes = Array.prototype.slice.call(document.querySelectorAll('#codeBoxes input'));
    var hidden = document.getElementById('code');

    function syncHidden() {
        hidden.value = boxes.map(function (b) { return b.value; }).join('');
    }

    boxes.forEach(function (box, i) {
        box.addEventListener('input', function () {
            box.value = box.value.replace(/[^0-9]/g, '').slice(0, 1);
            if (box.value && i < boxes.length - 1) {
                boxes[i + 1].focus();
            }
            syncHidden();
        });

        box.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !box.value && i > 0) {
                boxes[i - 1].focus();
            }
        });

        box.addEventListener('paste', function (e) {
            e.preventDefault();
            var digits = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').split('');
            digits.forEach(function (d, idx) {
                if (boxes[idx]) boxes[idx].value = d;
            });
            var next = Math.min(digits.length, boxes.length - 1);
            boxes[next].focus();
            syncHidden();
        });
    });

    // ---------- 1:50 (110 soniya) sanoq va qayta yuborish ----------
    var DURATION = 110; // 1 daqiqa 50 soniya
    var remaining = DURATION;
    var timerEl = document.getElementById('resendTimer');
    var resendBtn = document.getElementById('resendBtn');
    var resendSuccess = document.getElementById('resendSuccess');
    var resendForm = document.getElementById('resendForm');
    var intervalId = null;

    function formatTime(sec) {
        var m = Math.floor(sec / 60);
        var s = sec % 60;
        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
    }

    function tick() {
        remaining--;
        if (remaining <= 0) {
            clearInterval(intervalId);
            timerEl.style.display = 'none';
            resendBtn.style.display = 'inline';
        } else {
            timerEl.textContent = formatTime(remaining);
        }
    }

    function startCountdown() {
        remaining = DURATION;
        timerEl.textContent = formatTime(remaining);
        timerEl.style.display = 'inline';
        resendBtn.style.display = 'none';
        resendSuccess.style.display = 'none';
        clearInterval(intervalId);
        intervalId = setInterval(tick, 1000);
    }

    resendBtn.addEventListener('click', function () {
        resendBtn.disabled = true;

        function afterSend() {
            resendSuccess.style.display = 'block';
            startCountdown();
            boxes.forEach(function (b) { b.value = ''; });
            syncHidden();
            boxes[0].focus();
            resendBtn.disabled = false;
        }

        if (resendForm) {
            fetch(resendForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            }).then(afterSend).catch(afterSend);
        } else {
            afterSend();
        }
    });

    startCountdown();
})();
</script>
@endsection