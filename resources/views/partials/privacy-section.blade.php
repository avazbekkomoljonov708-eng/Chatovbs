{{--
    resources/views/partials/privacy-section.blade.php
    Maxfiylik va xavfsizlik bo'limi (yangi dizayn).
    settings.blade.php ichida:  @include('partials.privacy-section')
--}}

<style>
/* ================= MAXFIYLIK VA XAVFSIZLIK (sx-) ================= */
.sx-overlay [hidden], .sx-grid [hidden] { display: none !important; }

.sx-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.sx-grid3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }

.sx-tile { display: flex; flex-direction: column; gap: 16px; padding: 16px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink); transition: border-color .15s ease; }
.sx-tile:hover { border-color: var(--muted-on-dark); }
.sx-tile__top { display: flex; align-items: flex-start; gap: 12px; }
.sx-tile__ctl { margin-top: auto; }

.sx-ic { width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0; display: grid; place-items: center; background: var(--accent-soft); color: var(--accent); }
.sx-ic svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.sx-ic--sm { width: 32px; height: 32px; border-radius: 10px; }
.sx-ic--sm svg { width: 16px; height: 16px; }
.sx-ic--danger { background: rgba(241,101,101,.12); color: var(--danger); }

.sx-tx { flex: 1; min-width: 0; }
.sx-tx strong { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; font-size: 13.5px; font-weight: 700; }
.sx-tx > span { display: block; margin-top: 4px; font-size: 12px; line-height: 1.5; color: var(--muted-on-dark); }

.sx-badge { padding: 2px 9px; border-radius: 999px; font-size: 10px; font-weight: 800; }
.sx-badge.is-on { color: var(--teal-ink); background: var(--teal); }
.sx-badge.is-off { color: var(--muted-on-dark); background: var(--ink-softer); }

.sx-btn { width: 100%; justify-content: center; white-space: nowrap; }
.sx-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; flex-shrink: 0; }
.sx-tile .set-select { width: 100%; }

/* qurilma statistikasi kartalari */
.sx-stat { display: flex; flex-direction: column; gap: 10px; padding: 16px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink); min-width: 0; }
.sx-stat__head { display: flex; align-items: center; gap: 10px; font-size: 12.5px; font-weight: 700; color: var(--muted-on-dark); }
.sx-stat__num { display: flex; align-items: baseline; gap: 6px; margin-top: 4px; font: 800 38px/1 'Sora', sans-serif; letter-spacing: -.02em; }
.sx-stat__num small { font: 600 13px 'Inter', sans-serif; letter-spacing: 0; color: var(--muted-on-dark); }
.sx-stat__sub { margin: 0 0 6px; min-height: 36px; font-size: 12px; line-height: 1.5; color: var(--muted-on-dark); }
.sx-stat .btn-ghost, .sx-stat .btn-danger { margin-top: auto; }

.sx-card--danger { border-color: rgba(241,101,101,.3); }
.sx-card--danger .set-card__title { color: var(--danger); }

/* o'ng paneldagi hisoblagich */
.sx-pill { margin-left: auto; padding: 2px 9px; border-radius: 999px; font: 800 10.5px 'Inter', sans-serif; color: var(--accent); background: var(--accent-soft); }

/* modal oynalar */
.sx-overlay { position: fixed; inset: 0; z-index: 10001; display: none; place-items: center; padding: 16px; background: rgba(0,0,0,.55); backdrop-filter: blur(3px); }
.sx-overlay.is-open { display: grid; }
.sx-modal { width: min(500px, 100%); max-height: calc(100vh - 32px); display: flex; flex-direction: column; border: 1px solid var(--line); border-radius: var(--radius-lg); background: var(--ink-soft); color: var(--paper); box-shadow: 0 24px 60px rgba(0,0,0,.55); font-family: 'Inter', sans-serif; animation: sxPop .2s ease; }
.sx-modal--sm { width: min(420px, 100%); }
@keyframes sxPop { from { opacity: 0; transform: translateY(10px) scale(.98); } to { opacity: 1; transform: none; } }
@media (prefers-reduced-motion: reduce) { .sx-modal { animation: none; } }

.sx-modal__head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; padding: 20px 20px 8px; }
.sx-modal__head h4 { margin: 0; font: 800 17px 'Sora', sans-serif; }
.sx-modal__head p { margin: 4px 0 0; font-size: 12.5px; color: var(--muted-on-dark); }
.sx-x { width: 30px; height: 30px; flex-shrink: 0; border: none; border-radius: 50%; background: var(--ink-softer); color: var(--muted-on-dark); font-size: 18px; line-height: 1; cursor: pointer; transition: color .15s ease, background .15s ease; }
.sx-x:hover { color: var(--paper); background: var(--accent-soft); }
.sx-modal__text { margin: 0; padding: 4px 20px 6px; font-size: 13px; line-height: 1.6; color: var(--muted-on-dark); }
.sx-modal__foot { display: flex; justify-content: flex-end; gap: 10px; padding: 16px 20px 20px; }

.sx-bigcount { display: flex; align-items: baseline; gap: 10px; padding: 6px 20px 14px; }
.sx-bigcount b { font: 800 44px/1 'Sora', sans-serif; letter-spacing: -.02em; color: var(--accent); }
.sx-bigcount span { font-size: 13px; color: var(--muted-on-dark); }

.sx-dlist { display: flex; flex-direction: column; gap: 8px; padding: 0 20px 4px; overflow-y: auto; }
.sx-d { display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink); }
.sx-d.is-current { border-color: rgba(45,212,191,.45); background: rgba(45,212,191,.06); }
.sx-d__ic { width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--muted-on-dark); }
.sx-d.is-current .sx-d__ic { color: var(--teal); background: rgba(45,212,191,.14); }
.sx-d__ic svg { width: 18px; height: 18px; }
.sx-d__t { flex: 1; min-width: 0; }
.sx-d__t b { display: block; font-size: 13px; }
.sx-d__t span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sx-d__badge { flex-shrink: 0; padding: 3px 8px; border-radius: 999px; font-size: 9.5px; font-weight: 800; color: var(--teal-ink); background: var(--teal); }
.sx-d__kick { flex-shrink: 0; padding: 7px 13px; font-size: 11.5px; }
.sx-d__kick:hover { color: var(--danger); border-color: var(--danger); }

.sx-note { margin: 12px 20px 0; padding: 10px 12px; border-radius: var(--radius-sm); background: var(--ink-softer); font-size: 11.5px; line-height: 1.55; color: var(--muted-on-dark); }

.sx-pw { display: flex; flex-direction: column; gap: 6px; padding: 12px 20px 0; }
.sx-pw label { font-size: 11px; font-weight: 700; color: var(--muted-on-dark); text-transform: uppercase; letter-spacing: .05em; }
.sx-pw input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font: 500 13px 'Inter', sans-serif; transition: border-color .15s ease; }
.sx-pw input:focus { border-color: var(--accent); }
.sx-err { margin: 10px 20px 0; padding: 9px 12px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 600; color: var(--danger); background: rgba(241,101,101,.12); border: 1px solid rgba(241,101,101,.35); }

@media (max-width: 860px) {
    .sx-grid, .sx-grid3 { grid-template-columns: 1fr; }
}
</style>

@php
    $settings = $settings ?? [];
    $autoLock = $settings['auto_lock'] ?? 'never';
    $twoFactorOn = !empty($settings['two_factor']);
    $loginAlertsOn = array_key_exists('login_alerts', $settings) ? !empty($settings['login_alerts']) : true;
@endphp

<section class="set-section" id="sec-privacy">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-4"></path></svg></span>
        <div><h3>Maxfiylik va xavfsizlik</h3><p>Hisobingiz qanday himoyalanishini, qaysi qurilmalardan ulanganingizni va ma'lumotlaringizni shu yerda boshqarasiz.</p></div>
    </div>

    {{-- ===== 1) Kirish himoyasi ===== --}}
    <div class="set-card">
        <p class="set-card__title">Kirish himoyasi</p>
        <div class="sx-grid">

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                    <span class="sx-tx">
                        <strong>Ikki bosqichli tekshiruv <span class="sx-badge {{ $twoFactorOn ? 'is-on' : 'is-off' }}" id="prTfaBadge">{{ $twoFactorOn ? 'YOQILGAN' : "O'CHIQ" }}</span></strong>
                        <span>Kirishda paroldan tashqari qo'shimcha kod so'raladi. Parol o'g'irlansa ham hisob himoyada qoladi.</span>
                    </span>
                    <label class="set-switch"><input type="checkbox" name="two_factor" value="1" id="prTfa" {{ $twoFactorOn ? 'checked' : '' }}><span class="set-switch__track"></span></label>
                </div>
            </div>

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic"><svg viewBox="0 0 24 24"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
                    <span class="sx-tx">
                        <strong>Yangi qurilmadan kirish</strong>
                        <span>Hisobingizga notanish qurilmadan kirilsa, darhol ogohlantirish olasiz.</span>
                    </span>
                    <label class="set-switch"><input type="checkbox" name="login_alerts" value="1" {{ $loginAlertsOn ? 'checked' : '' }}><span class="set-switch__track"></span></label>
                </div>
            </div>

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic"><svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"></rect><circle cx="12" cy="16" r="1"></circle><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg></span>
                    <span class="sx-tx">
                        <strong>Avtomatik qulflash</strong>
                        <span>Ilova ishlatilmay turganda belgilangan vaqtdan keyin o'zi qulflanadi.</span>
                    </span>
                </div>
                <div class="sx-tile__ctl">
                    <select class="set-select" name="auto_lock">
                        @foreach (['never' => 'Hech qachon', '5' => '5 daqiqadan keyin', '15' => '15 daqiqadan keyin', '60' => '1 soatdan keyin'] as $v => $l)
                            <option value="{{ $v }}" {{ (string) $autoLock === (string) $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic"><svg viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg></span>
                    <span class="sx-tx">
                        <strong>Parolni o'zgartirish</strong>
                        <span>Xavfsizlik uchun parolni vaqti-vaqti bilan yangilab turing.</span>
                    </span>
                </div>
                <div class="sx-tile__ctl">
                    <a href="{{ route('profile.edit') }}" class="btn-ghost sx-btn">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>
                        Parolni o'zgartirish
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== 2) Qurilmalar va bloklash ===== --}}
    <div class="set-card">
        <p class="set-card__title">Qurilmalar va bloklash</p>
        <div class="sx-grid3">

            <div class="sx-stat">
                <div class="sx-stat__head">
                    <span class="sx-ic sx-ic--sm"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>
                    Ulangan qurilmalar
                </div>
                <div class="sx-stat__num"><span id="sxDevCount">–</span><small>ta</small></div>
                <p class="sx-stat__sub" id="sxDevSub">Aniqlanmoqda…</p>
                <button type="button" class="btn-ghost sx-btn" id="sxShowDevices">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Ko'rish
                </button>
            </div>

            <div class="sx-stat">
                <div class="sx-stat__head">
                    <span class="sx-ic sx-ic--sm sx-ic--danger"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></span>
                    Boshqa qurilmalar
                </div>
                <div class="sx-stat__num"><span id="sxOtherCount">–</span><small>ta</small></div>
                <p class="sx-stat__sub" id="sxOtherSub">Aniqlanmoqda…</p>
                <button type="button" class="btn-danger sx-btn" id="sxLogoutOthers">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    Chiqarib yuborish
                </button>
            </div>

            <div class="sx-stat">
                <div class="sx-stat__head">
                    <span class="sx-ic sx-ic--sm"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><line x1="5.5" y1="5.5" x2="18.5" y2="18.5"></line></svg></span>
                    Bloklanganlar
                </div>
                <div class="sx-stat__num"><span id="sxBlockedCount">0</span><small>ta</small></div>
                <p class="sx-stat__sub">Sizga yoza olmaydigan va profilingizni ko'ra olmaydigan odamlar.</p>
                <button type="button" class="btn-ghost sx-btn" id="sxBlocked">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    Ro'yxat
                </button>
            </div>

        </div>
    </div>

    {{-- ===== 3) Ma'lumotlar va hisob ===== --}}
    <div class="set-card sx-card--danger">
        <p class="set-card__title">Ma'lumotlar va hisob</p>
        <div class="sx-grid">

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></span>
                    <span class="sx-tx">
                        <strong>Ma'lumotlarimni yuklab olish</strong>
                        <span>Profilingiz va sozlamalaringiz nusxasini fayl sifatida oling.</span>
                    </span>
                </div>
                <div class="sx-tile__ctl">
                    <button type="button" class="btn-ghost sx-btn" id="sxExport">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Yuklab olish
                    </button>
                </div>
            </div>

            <div class="sx-tile">
                <div class="sx-tile__top">
                    <span class="sx-ic sx-ic--danger"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg></span>
                    <span class="sx-tx">
                        <strong>Hisobni o'chirish</strong>
                        <span>Barcha chatlar va ma'lumotlaringiz butunlay o'chadi. Buni qaytarib bo'lmaydi.</span>
                    </span>
                </div>
                <div class="sx-tile__ctl">
                    <button type="button" class="btn-danger sx-btn" id="sxDelete">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                        Hisobni o'chirish
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
(function () {
    var page = document.getElementById('setPage');
    if (!page) return;

    var CSRF = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    /* Qurilmalar ro'yxati uchun server manzili (controller kodini javobda ko'rsatdim) */
    var SESS_URL   = "{{ url('/settings/sessions') }}";
    var URL_LOGOUT = "{{ route('settings.logout-others') }}";
    var URL_EXPORT = "{{ route('settings.export') }}";
    var URL_DELETE = "{{ route('settings.delete-account') }}";
    var URL_HOME   = "{{ url('/') }}";

    var devices = [];
    var serverOk = false;

    function $(id) { return document.getElementById(id); }
    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }

    var IC_PC = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>';
    var IC_PHONE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>';

    function parseUA(ua) {
        ua = ua || '';
        var os = /Windows/i.test(ua) ? 'Windows'
               : /Android/i.test(ua) ? 'Android'
               : /iPhone|iPad|iPod/i.test(ua) ? 'iOS'
               : /Mac OS X/i.test(ua) ? 'macOS'
               : /Linux/i.test(ua) ? 'Linux' : "Noma'lum tizim";
        var br = /Edg\//i.test(ua) ? 'Edge'
               : /OPR\//i.test(ua) ? 'Opera'
               : /Firefox\//i.test(ua) ? 'Firefox'
               : /Chrome\//i.test(ua) ? 'Chrome'
               : /Safari\//i.test(ua) ? 'Safari' : 'Brauzer';
        return { name: os + ' · ' + br, mobile: /Android|iPhone|iPad|iPod/i.test(ua) };
    }

    function ago(ts) {
        var s = Math.max(0, Math.floor(Date.now() / 1000 - ts));
        if (s < 90) return 'hozir faol';
        var m = Math.floor(s / 60);
        if (m < 60) return m + ' daqiqa oldin';
        var h = Math.floor(m / 60);
        if (h < 24) return h + ' soat oldin';
        return Math.floor(h / 24) + ' kun oldin';
    }

    function place() { try { return localStorage.getItem('chatovbs_user_place') || ''; } catch (e) { return ''; } }

    function meta(d) {
        if (d.current) return (place() ? place() + ' · ' : '') + 'hozir faol';
        return (d.ip ? d.ip + ' · ' : '') + ago(d.last);
    }

    function api(url, method, body) {
        return fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(body || {})
        }).then(function (r) {
            return r.json().catch(function () { return {}; }).then(function (d) {
                if (!r.ok) {
                    var msg = d.message;
                    if (d.errors) { var k = Object.keys(d.errors)[0]; msg = d.errors[k][0]; }
                    throw new Error(msg || 'Xatolik yuz berdi');
                }
                return d;
            });
        });
    }

    /* ---------- 2FA belgisi ---------- */
    var tfa = $('prTfa'), badge = $('prTfaBadge');
    function refreshTfa() {
        badge.textContent = tfa.checked ? 'YOQILGAN' : "O'CHIQ";
        badge.className = 'sx-badge ' + (tfa.checked ? 'is-on' : 'is-off');
    }
    tfa.addEventListener('change', refreshTfa);
    $('settingsForm').addEventListener('reset', function () { setTimeout(refreshTfa, 0); });
    refreshTfa();

    /* ---------- Modal oynalar ---------- */
    var dm = document.createElement('div');
    dm.className = 'sx-overlay';
    dm.innerHTML =
        '<div class="sx-modal" role="dialog" aria-modal="true" aria-labelledby="sxDmTitle">' +
            '<div class="sx-modal__head"><div><h4 id="sxDmTitle">Ulangan qurilmalar</h4><p>Hisobingizga kirilgan barcha qurilmalar</p></div><button type="button" class="sx-x" data-close aria-label="Yopish">×</button></div>' +
            '<div class="sx-bigcount"><b id="sxDmCount">0</b><span>ta qurilmadan ulangansiz</span></div>' +
            '<div class="sx-dlist" id="sxDmList"></div>' +
            '<p class="sx-note" id="sxDmNote" hidden></p>' +
            '<div class="sx-modal__foot"><button type="button" class="btn-ghost" data-close>Yopish</button><button type="button" class="btn-danger" id="sxDmLogout">Boshqalaridan chiqish</button></div>' +
        '</div>';
    page.appendChild(dm);

    var am = document.createElement('div');
    am.className = 'sx-overlay';
    am.innerHTML =
        '<div class="sx-modal sx-modal--sm" role="dialog" aria-modal="true" aria-labelledby="sxAmTitle">' +
            '<div class="sx-modal__head"><div><h4 id="sxAmTitle"></h4></div><button type="button" class="sx-x" data-close aria-label="Yopish">×</button></div>' +
            '<p class="sx-modal__text" id="sxAmText"></p>' +
            '<div class="sx-pw" id="sxAmPwWrap"><label for="sxAmPw">Parolingiz</label><input type="password" id="sxAmPw" autocomplete="current-password" placeholder="Parolni kiriting"></div>' +
            '<p class="sx-err" id="sxAmErr" hidden></p>' +
            '<div class="sx-modal__foot"><button type="button" class="btn-ghost" data-close id="sxAmCancel">Bekor qilish</button><button type="button" class="btn-danger" id="sxAmOk">Tasdiqlash</button></div>' +
        '</div>';
    page.appendChild(am);

    function openM(m) { m.classList.add('is-open'); }
    function closeM(m) { m.classList.remove('is-open'); }

    [dm, am].forEach(function (m) {
        m.addEventListener('click', function (e) {
            if (e.target === m || e.target.closest('[data-close]')) closeM(m);
        });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeM(dm); closeM(am); }
    });

    /* ---------- Tasdiqlash oynasi (parol bilan yoki oddiy xabar) ---------- */
    var askRun = null;
    function ask(o) {
        $('sxAmTitle').textContent = o.title;
        $('sxAmText').textContent = o.text;
        $('sxAmPwWrap').hidden = !o.password;
        $('sxAmPw').value = '';
        $('sxAmErr').hidden = true;
        $('sxAmOk').hidden = !!o.info;
        $('sxAmOk').disabled = false;
        $('sxAmOk').textContent = o.confirm || 'Tasdiqlash';
        $('sxAmCancel').textContent = o.info ? 'Yopish' : 'Bekor qilish';
        askRun = o.run || null;
        openM(am);
        if (o.password) setTimeout(function () { $('sxAmPw').focus(); }, 60);
    }

    $('sxAmOk').addEventListener('click', function () {
        var btn = this, err = $('sxAmErr'), pw = $('sxAmPw').value;
        if (!$('sxAmPwWrap').hidden && !pw) { err.textContent = 'Parolni kiriting.'; err.hidden = false; return; }
        btn.disabled = true; err.hidden = true;
        Promise.resolve(askRun ? askRun(pw) : null)
            .then(function () { btn.disabled = false; closeM(am); })
            .catch(function (e) { btn.disabled = false; err.textContent = e.message || 'Xatolik yuz berdi'; err.hidden = false; });
    });
    $('sxAmPw').addEventListener('keydown', function (e) { if (e.key === 'Enter') $('sxAmOk').click(); });

    /* ---------- Qurilmalar ---------- */
    function fallbackDevices() {
        var u = parseUA(navigator.userAgent);
        return [{ id: 'current', name: u.name, mobile: u.mobile, ip: '', last: Date.now() / 1000, current: true }];
    }

    function others() { return devices.filter(function (d) { return !d.current; }); }

    function loadDevices() {
        return fetch(SESS_URL, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { if (!r.ok) throw new Error('x'); return r.json(); })
            .then(function (d) {
                var list = (d.sessions || []).map(function (s) {
                    var u = parseUA(s.user_agent);
                    return { id: s.id, name: u.name, mobile: u.mobile, ip: s.ip || '', last: s.last_active, current: !!s.current };
                });
                if (!list.some(function (x) { return x.current; })) list = fallbackDevices().concat(list);
                list.sort(function (a, b) { return (b.current ? 1 : 0) - (a.current ? 1 : 0) || b.last - a.last; });
                devices = list; serverOk = true;
            })
            .catch(function () { devices = fallbackDevices(); serverOk = false; })
            .then(renderAll);
    }

    function renderCounts() {
        var n = others().length;
        $('sxDevCount').textContent = devices.length;
        $('sxDevSub').textContent = !serverOk ? 'Faqat shu qurilma aniqlandi'
            : (n ? 'Shu qurilma va yana ' + n + ' ta boshqa qurilma' : 'Faqat shu qurilmadan ulangansiz');
        $('sxOtherCount').textContent = serverOk ? n : '–';
        $('sxOtherSub').textContent = !serverOk ? 'Boshqa qurilmalar soni aniqlanmadi'
            : (n ? 'Ularni bir bosishda hisobdan chiqarib yuborishingiz mumkin' : 'Chiqarib yuboriladigan boshqa qurilma yo\'q');
    }

    function renderPanel() {
        var card = $('devicesCard');
        if (!card) return;
        var label = card.querySelector('.pv-card__label');
        if (label) {
            var pill = label.querySelector('.sx-pill');
            if (!pill) { pill = document.createElement('span'); pill.className = 'sx-pill'; label.appendChild(pill); }
            pill.textContent = devices.length + ' ta';
        }
        card.querySelectorAll('.sx-extra').forEach(function (n) { n.remove(); });
        others().forEach(function (d) {
            var row = document.createElement('div');
            row.className = 'dev-row sx-extra';
            row.innerHTML = '<span class="dev-row__icon">' + (d.mobile ? IC_PHONE : IC_PC) + '</span>' +
                '<span class="dev-row__text"><strong>' + esc(d.name) + '</strong><span>' + esc(meta(d)) + '</span></span>';
            card.appendChild(row);
        });
    }

    function renderModal() {
        $('sxDmCount').textContent = devices.length;
        $('sxDmList').innerHTML = devices.map(function (d) {
            return '<div class="sx-d' + (d.current ? ' is-current' : '') + '">' +
                '<span class="sx-d__ic">' + (d.mobile ? IC_PHONE : IC_PC) + '</span>' +
                '<span class="sx-d__t"><b>' + esc(d.name) + '</b><span>' + esc(meta(d)) + '</span></span>' +
                (d.current
                    ? '<span class="sx-d__badge">SHU QURILMA</span>'
                    : '<button type="button" class="btn-ghost sx-d__kick" data-kick="' + esc(d.id) + '">Chiqarish</button>') +
                '</div>';
        }).join('');
        $('sxDmLogout').hidden = serverOk && others().length === 0;
        var note = $('sxDmNote');
        if (!serverOk) {
            note.textContent = "Boshqa qurilmalar ro'yxatini olib bo'lmadi, shuning uchun faqat shu qurilma ko'rsatilmoqda. Serverda SESSION_DRIVER=database va sessions jadvali bo'lishi kerak.";
            note.hidden = false;
        } else {
            note.hidden = true;
        }
    }

    function renderAll() { renderCounts(); renderPanel(); renderModal(); }

    $('sxDmList').addEventListener('click', function (e) {
        var b = e.target.closest('[data-kick]');
        if (!b) return;
        b.disabled = true; b.textContent = '…';
        api(SESS_URL + '/' + encodeURIComponent(b.getAttribute('data-kick')), 'DELETE')
            .then(loadDevices)
            .catch(function (err) {
                b.disabled = false; b.textContent = 'Chiqarish';
                var note = $('sxDmNote'); note.textContent = err.message; note.hidden = false;
            });
    });

    /* ---------- Tugmalar ---------- */
    $('sxShowDevices').addEventListener('click', function () {
        renderModal();
        openM(dm);
        loadDevices();
    });

    function startLogoutOthers() {
        var n = others().length;
        closeM(dm);
        if (serverOk && n === 0) {
            ask({ title: "Boshqa qurilma yo'q", text: "Hisobingiz hozir faqat shu qurilmada ochiq. Chiqarib yuboriladigan boshqa qurilma topilmadi.", info: true });
            return;
        }
        var text = serverOk
            ? 'Hozir ' + n + ' ta boshqa qurilma ulangan. Ularning hammasi hisobdan chiqariladi, faqat shu qurilma qoladi. Davom etish uchun parolingizni kiriting.'
            : "Shu qurilmadan tashqari barcha qurilmalar hisobdan chiqariladi. Davom etish uchun parolingizni kiriting.";
        ask({
            title: 'Boshqa qurilmalardan chiqish', text: text, password: true, confirm: 'Chiqarib yuborish',
            run: function (pw) { return api(URL_LOGOUT, 'POST', { password: pw }).then(loadDevices); }
        });
    }
    $('sxLogoutOthers').addEventListener('click', startLogoutOthers);
    $('sxDmLogout').addEventListener('click', startLogoutOthers);

    $('sxBlocked').addEventListener('click', function () {
        ask({ title: "Bloklangan foydalanuvchilar", text: "Bloklangan foydalanuvchilar ro'yxati tez orada qo'shiladi.", info: true });
    });

    $('sxExport').addEventListener('click', function () { window.location.href = URL_EXPORT; });

    $('sxDelete').addEventListener('click', function () {
        ask({
            title: "Hisobni o'chirish", password: true, confirm: "Butunlay o'chirish",
            text: "Hisobingiz, barcha chatlar va ma'lumotlaringiz butunlay o'chadi. Buni qaytarib bo'lmaydi. Davom etish uchun parolingizni kiriting.",
            run: function (pw) { return api(URL_DELETE, 'DELETE', { password: pw }).then(function () { window.location.href = URL_HOME; }); }
        });
    });

    loadDevices();
})();
</script>