@extends('layouts.app')

{{--
    ==========================================================================
    CHATOVBS — SOZLAMALAR SAHIFASI (v2: to'liq ekranli, 3-ustunli tuzilma)
    ==========================================================================
    Endi sahifa home.blade.php dagi kabi butun ekranni egallaydi (100vh,
    scroll sahifada emas, faqat ichki panellarda):

      [ CHAP: navigatsiya ]   [ O'RTA: tanlangan bo'lim kontenti ]   [ O'NG: jonli ko'rinish + hisob ]

    Chap panel — bo'limlar ro'yxati (bosilganda o'rtadagi bo'limga scroll qiladi
    va scrollspy orqali avtomatik faollashadi).
    O'rta panel — har bir bo'lim endi kengroq, 2 ustunli tayl-kartalar bilan.
    O'ng panel — jonli preview + "Hisobingiz" va "Faol qurilmalar" kabi
    qo'shimcha, foydali kartalar bilan to'ldirilgan (bo'sh joy qolmasligi uchun).

    BACKEND UCHUN ESLATMA — qabul qilinishi kerak bo'lgan yangi maydonlar:
      theme, accent_color, density, font_size,
      wallpaper_type, wallpaper_gradient, wallpaper_color,
      wallpaper_image (fayl), wallpaper_video (fayl), wallpaper_blur,
      notifications, sound, enter_to_send, notif_preview, group_notifications,
      profile_visibility, last_seen_visibility, read_receipts, two_factor,
      autodownload_wifi[], autodownload_mobile[],
      language, date_format, time_format_24h,
      quiet_hours_enabled, quiet_hours_start, quiet_hours_end, quiet_hours_message
    ==========================================================================
--}}

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ink: #0a0a0a; --ink-soft: #131310; --ink-softer: #1c1c17;
        --paper: #faf9f6; --line: #29291f; --line-soft: #34342a;
        --muted-on-dark: #8c8c81; --muted-on-light: #6b6b66;
    --accent: #faf9f6; --accent-ink: #0a0a0a; --accent-soft: rgba(250,249,246,0.10);
    --bubble: #0a0a0a; --bubble-ink: #faf9f6;   /* chiquvchi xabar pufakchasi */
        --teal: #2dd4bf; --teal-ink: #0a1f1c; --danger: #f16565;
        --radius-lg: 18px; --radius-md: 13px; --radius-sm: 9px;
    }
    #setPage.accent-amber  { --accent: #e0a83e; --accent-ink: #1c1206; --accent-soft: rgba(224,168,62,0.16); }
    #setPage.accent-teal   { --accent: #2dd4bf; --accent-ink: #06201c; --accent-soft: rgba(45,212,191,0.16); }
    #setPage.accent-blue   { --accent: #4b9bea; --accent-ink: #06172c; --accent-soft: rgba(75,155,234,0.16); }
    #setPage.accent-violet { --accent: #a78bfa; --accent-ink: #1a1330; --accent-soft: rgba(167,139,250,0.18); }
    #setPage.accent-rose   { --accent: #f472b6; --accent-ink: #2b0e1c; --accent-soft: rgba(244,114,182,0.16); }
    #setPage.accent-green  { --accent: #34d399; --accent-ink: #06231a; --accent-soft: rgba(52,211,153,0.16); }

        #setPage.accent-default.theme-light { --accent: #15150f; --accent-ink: #ffffff; --accent-soft: rgba(21,21,15,0.08); }
    #setPage.accent-amber, #setPage.accent-teal, #setPage.accent-blue,
    #setPage.accent-violet, #setPage.accent-rose, #setPage.accent-green {
        --bubble: var(--accent); --bubble-ink: var(--accent-ink);
    }

    #setPage.theme-light {
        --ink: #f2f1ec; --ink-soft: #ffffff; --ink-softer: #ececE3;
        --paper: #15150f; --line: #e3e1d5; --line-soft: #eae8dd;
        --muted-on-dark: #777268; --muted-on-light: #6b6b66;
    }

    * { box-sizing: border-box; }
    html, body { margin: 0 !important; padding: 0 !important; height: 100%; overflow: hidden; background: var(--ink); }
    #app nav.navbar, #app .site-header { display: none !important; }
    #app main.py-4 { padding: 0 !important; margin: 0 !important; height: 100vh; }
    #app { height: 100vh; }
    body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }

    .settings-app { display: flex; height: 100vh; width: 100%; overflow: hidden; background: var(--ink); color: var(--paper); }

    /* ============================================================ */
    /* CHAP: NAVIGATSIYA PANELI                                       */
    /* ============================================================ */
    .set-nav { width: 288px; flex-shrink: 0; background: var(--ink-soft); border-right: 1px solid var(--line); display: flex; flex-direction: column; overflow: hidden; }
    .set-nav__top { padding: 18px 16px 14px; border-bottom: 1px solid var(--line); flex-shrink: 0; }
    .set-nav__back { display: inline-flex; align-items: center; gap: 9px; background: none; border: none; color: var(--muted-on-dark); text-decoration: none; font-size: 12.5px; font-weight: 700; cursor: pointer; padding: 0; margin-bottom: 16px; transition: color .15s ease; }
    .set-nav__back:hover { color: var(--paper); }
    .set-nav__back svg { width: 15px; height: 15px; stroke: currentColor; }
    .set-nav__title { font-family: 'Sora', sans-serif; font-size: 21px; font-weight: 800; letter-spacing: -0.02em; margin: 0 0 14px; }

    .set-nav__user { display: flex; align-items: center; gap: 11px; padding: 10px; border-radius: var(--radius-md); background: var(--ink-softer); }
    .set-nav__avatar { width: 40px; height: 40px; border-radius: 50%; overflow: hidden; flex-shrink: 0; display: grid; place-items: center; background: var(--accent); color: var(--accent-ink); font-family: 'Sora', sans-serif; font-weight: 800; }
    .set-nav__avatar img { width: 100%; height: 100%; object-fit: cover; }
    .set-nav__user-info { min-width: 0; }
    .set-nav__user-info b { display: block; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .set-nav__user-info a { font-size: 11.5px; color: var(--accent); text-decoration: none; font-weight: 600; }
    .set-nav__user-info a:hover { text-decoration: underline; }


.set-nav__profile-btn { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 14px; padding: 10px 14px; border-radius: 999px; background: rgba(75,155,234,0.14); border: 1px solid rgba(75,155,234,0.4); color: #6db3f5; font: 700 12.5px 'Inter', sans-serif; text-decoration: none; cursor: pointer; transition: background .15s ease, color .15s ease, border-color .15s ease, transform .1s ease; }
.set-nav__profile-btn:hover { background: #4b9bea; border-color: #4b9bea; color: #06172c; }
.set-nav__profile-btn:active { transform: scale(.97); }
.set-nav__profile-btn svg { width: 14px; height: 14px; stroke: currentColor; flex-shrink: 0; }
#setPage.theme-light .set-nav__profile-btn { color: #2b7bd0; }
#setPage.theme-light .set-nav__profile-btn:hover { color: #fff; }


        .set-nav__list { flex: 1; overflow-y: auto; padding: 10px 10px 40px; }
    .set-nav__list::-webkit-scrollbar { width: 5px; }
    .set-nav__list::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }
    .set-nav__group-label { font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; color: var(--muted-on-dark); opacity: .7; padding: 14px 10px 6px; }
    .set-nav__group-label:first-child { padding-top: 4px; }

    .set-nav-item { width: 100%; display: flex; align-items: center; gap: 12px; padding: 10px 11px; border-radius: var(--radius-sm); border: none; background: transparent; color: var(--muted-on-dark); cursor: pointer; text-align: left; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; transition: background .15s ease, color .15s ease; margin-bottom: 2px; }
    .set-nav-item:hover { background: var(--ink-softer); color: var(--paper); }
    .set-nav-item.active { background: var(--accent-soft); color: var(--paper); }
    .set-nav-item__icon { width: 32px; height: 32px; border-radius: 9px; display: grid; place-items: center; background: var(--ink-softer); color: var(--muted-on-dark); flex-shrink: 0; transition: background .15s ease, color .15s ease; }
    .set-nav-item.active .set-nav-item__icon { background: var(--accent); color: var(--accent-ink); }
    .set-nav-item__icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; }
    .set-nav-item__text { flex: 1; min-width: 0; }
    .set-nav-item__text span { display: block; font-size: 10.5px; color: var(--muted-on-dark); font-weight: 500; margin-top: 1px; }
    .set-nav-item__chevron { width: 14px; height: 14px; stroke: var(--muted-on-dark); opacity: 0; transform: translateX(-3px); transition: opacity .15s ease, transform .15s ease; flex-shrink: 0; }
    .set-nav-item.active .set-nav-item__chevron { opacity: 1; transform: translateX(0); }

    .set-nav__footer { padding: 12px 20px 16px; border-top: 1px solid var(--line); flex-shrink: 0; }
    .set-nav__footer b { display: block; font-size: 11.5px; color: var(--muted-on-dark); font-weight: 700; }
    .set-nav__footer span { font-size: 10.5px; color: var(--muted-on-dark); opacity: .7; }

    /* ============================================================ */
    /* O'RTA: KONTENT                                                 */
    /* ============================================================ */
    .set-content { flex: 1; min-width: 0; display: flex; flex-direction: column; overflow: hidden; }
    .set-form { display: flex; flex-direction: column; flex: 1; min-height: 0; }

    .set-topbar { flex-shrink: 0; height: 62px; display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 0 30px; border-bottom: 1px solid var(--line); background: var(--ink); }
    .set-topbar h2 { margin: 0; font-family: 'Sora', sans-serif; font-size: 15.5px; font-weight: 700; }
    .set-topbar .status-pill { display: inline-flex; align-items: center; gap: 7px; font-size: 11.5px; color: #7ff0c9; background: rgba(45,212,191,0.12); border: 1px solid rgba(45,212,191,0.3); padding: 5px 11px; border-radius: 999px; font-weight: 700; }
    .set-topbar .status-pill svg { width: 13px; height: 13px; stroke: currentColor; }
    .theme-quick-btn {
        display: inline-flex; align-items: center; gap: 8px;
        border: 1px solid var(--line); background: var(--ink-softer); color: var(--paper);
        border-radius: 999px; padding: 9px 15px 9px 11px; cursor: pointer;
        font: 700 12px 'Inter', sans-serif; transition: background .18s ease, border-color .18s ease, transform .1s ease;
    }
    .theme-quick-btn:hover { border-color: var(--accent); background: var(--accent-soft); }
    .theme-quick-btn:active { transform: scale(.96); }
    .theme-quick-btn svg { width: 15px; height: 15px; stroke: currentColor; flex-shrink: 0; }
    #setPage.theme-light .theme-quick-btn { background: var(--ink-softer); }
    .btn-solid, .btn-ghost { display: inline-flex; align-items: center; gap: 8px; border-radius: 999px; padding: 10px 18px; font: 700 12.5px 'Inter', sans-serif; cursor: pointer; text-decoration: none; border: none; transition: filter .15s ease, transform .1s ease, background .15s ease, color .15s ease; }
    .btn-solid { background: var(--accent); color: var(--accent-ink); }
    .btn-solid:hover { filter: brightness(1.08); }
    .btn-ghost { background: transparent; border: 1px solid var(--line); color: var(--muted-on-dark); }
    .btn-ghost:hover { color: var(--paper); border-color: var(--muted-on-dark); }
    .btn-solid:active, .btn-ghost:active { transform: scale(.97); }
    .btn-solid svg, .btn-ghost svg { width: 14px; height: 14px; stroke: currentColor; }

    .set-scroll { flex: 1; overflow-y: auto; padding: 28px 34px 70px; scroll-behavior: smooth; }
    .set-scroll::-webkit-scrollbar { width: 7px; }
    .set-scroll::-webkit-scrollbar-thumb { background: var(--line); border-radius: 5px; }

    .set-section { max-width: 900px; margin: 0 auto 46px; scroll-margin-top: 10px; }
      
    .set-section__head { display: flex; align-items: flex-start; gap: 13px; margin-bottom: 18px; }
    .set-section__icon { width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0; display: grid; place-items: center; background: var(--accent-soft); color: var(--accent); }
    .set-section__icon svg { width: 21px; height: 21px; stroke: currentColor; fill: none; }
    .set-section__head h3 { margin: 0; font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; }
    .set-section__head p { margin: 4px 0 0; color: var(--muted-on-dark); font-size: 13px; line-height: 1.55; max-width: 560px; }

    .set-card { border: 1px solid var(--line); border-radius: var(--radius-lg); background: var(--ink-soft); padding: 20px; margin-bottom: 14px; }
    .set-card__title { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted-on-dark); margin: 0 0 14px; }

    .set-row { display: flex; align-items: center; justify-content: space-between; gap: 18px; padding: 13px 0; border-top: 1px solid var(--line); }
    .set-row:first-of-type { border-top: none; padding-top: 0; }
    .set-row__text strong { display: block; font-size: 13.5px; font-weight: 600; }
    .set-row__text span { display: block; margin-top: 3px; color: var(--muted-on-dark); font-size: 12px; line-height: 1.5; max-width: 360px; }
    .set-row__control { flex-shrink: 0; }

    .set-select { min-width: 165px; padding: 10px 32px 10px 13px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 600; cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%238c8c81' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; background-size: 15px; transition: border-color .15s ease; }
    .set-select:focus { border-color: var(--accent); }

    .set-switch { position: relative; width: 42px; height: 24px; flex-shrink: 0; }
    .set-switch input { position: absolute; opacity: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
    .set-switch__track { position: absolute; inset: 0; border-radius: 999px; background: var(--line); transition: background .2s ease; pointer-events: none; }
    .set-switch__track::before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; top: 3px; border-radius: 50%; background: var(--muted-on-dark); transition: transform .2s ease, background .2s ease; }
    .set-switch input:checked + .set-switch__track { background: var(--accent-soft); }
    .set-switch input:checked + .set-switch__track::before { transform: translateX(18px); background: var(--accent); }

    /* ---- 2-ustunli "toggle-card" grid (bildirishnomalar kabi bo'limlar uchun) ---- */
    .set-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .toggle-card { display: flex; align-items: flex-start; gap: 12px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink-soft); padding: 16px; }
    .toggle-card__icon { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--accent); }
    .toggle-card__icon svg { width: 17px; height: 17px; stroke: currentColor; }
    .toggle-card__body { flex: 1; min-width: 0; }
    .toggle-card__body strong { display: block; font-size: 13px; font-weight: 600; }
    .toggle-card__body span { display: block; margin-top: 3px; color: var(--muted-on-dark); font-size: 11.5px; line-height: 1.5; }
    .toggle-card__switch { margin-top: 2px; flex-shrink: 0; }

    /* ---- Tema tanlash ---- */
    .set-theme-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
    .set-theme-opt { position: relative; cursor: pointer; }
    .set-theme-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .set-theme-opt__swatch { height: 78px; border-radius: var(--radius-md); border: 2px solid var(--line); display: flex; flex-direction: column; justify-content: flex-end; gap: 5px; padding: 10px; transition: border-color .15s ease, transform .15s ease; overflow: hidden; }
    .set-theme-opt input:checked + .set-theme-opt__swatch { border-color: var(--accent); transform: translateY(-2px); }
    .set-theme-opt__swatch i { display: block; height: 6px; border-radius: 3px; }
    .set-theme-opt__dark { background: linear-gradient(160deg, #17170f, #08080a); }
    .set-theme-opt__dark i:nth-child(1) { width: 55%; background: rgba(255,255,255,0.35); }
    .set-theme-opt__dark i:nth-child(2) { width: 35%; background: rgba(255,255,255,0.18); }
    .set-theme-opt__light { background: linear-gradient(160deg, #ffffff, #e7e5db); }
    .set-theme-opt__light i:nth-child(1) { width: 55%; background: rgba(20,20,15,0.35); }
    .set-theme-opt__light i:nth-child(2) { width: 35%; background: rgba(20,20,15,0.18); }
    .set-theme-opt__system { background: linear-gradient(105deg, #17170f 50%, #ffffff 50%); }
    .set-theme-opt__system i:nth-child(1) { width: 55%; background: rgba(255,255,255,0.4); }
    .set-theme-opt__system i:nth-child(2) { width: 35%; background: rgba(20,20,15,0.3); }
    .set-theme-opt__label { display: block; text-align: center; margin-top: 9px; font-size: 12px; font-weight: 600; color: var(--muted-on-dark); }
    .set-theme-opt input:checked ~ .set-theme-opt__label { color: var(--paper); }

    /* ---- Aksent rang ---- */
    .set-accent-grid { display: flex; gap: 14px; flex-wrap: wrap; }
    .set-accent-opt { position: relative; cursor: pointer; }
    .set-accent-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .set-accent-opt__dot { position: relative; width: 42px; height: 42px; border-radius: 50%; display: grid; place-items: center; border: 2px solid transparent; transition: transform .15s ease, border-color .15s ease; }
    .set-accent-opt__dot::after { content: ''; width: 26px; height: 26px; border-radius: 50%; background: var(--dot-color); }
    .set-accent-opt input:checked + .set-accent-opt__dot { border-color: var(--dot-color); transform: scale(1.08); }
    .set-accent-opt input:checked + .set-accent-opt__dot svg { display: block; }
       .set-accent-opt__dot svg { position: absolute; width: 15px; height: 15px; stroke: #fff; display: none; filter: drop-shadow(0 1px 1px rgba(0,0,0,0.4)); }
    .set-accent-opt__dot--custom { position: relative; border: 2px dashed rgba(255,255,255,0.35); }
    .set-accent-opt__dot--custom .set-accent-opt__plus { display: block; }
    .set-accent-opt input:checked + .set-accent-opt__dot--custom .set-accent-opt__plus { display: none; }
        .set-accent-opt--default input:checked + .set-accent-opt__dot { border-color: var(--paper); }
    .set-accent-opt--default .set-accent-opt__dot::after { box-shadow: inset 0 0 0 1px rgba(255,255,255,.3); }


/* ---- Doim ochiq rang tanlagich (kartaning ichida) ---- */
.color-picker { margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--line); display: grid; grid-template-columns: minmax(0, 1fr) 240px; gap: 20px; align-items: start; }
.color-picker__sv { position: relative; height: 170px; border-radius: 12px; overflow: hidden; cursor: crosshair; touch-action: none; }
.color-picker__sv canvas { display: block; width: 100%; height: 100%; }
.color-picker__sv-thumb { position: absolute; width: 16px; height: 16px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 1px rgba(0,0,0,.4), 0 1px 3px rgba(0,0,0,.5); transform: translate(-50%, -50%); pointer-events: none; }
.color-picker__side { display: flex; flex-direction: column; gap: 14px; }
.color-picker__row { display: flex; align-items: center; gap: 10px; }
.color-picker__eyedrop { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--line); background: var(--ink-softer); color: var(--muted-on-dark); display: grid; place-items: center; cursor: pointer; flex-shrink: 0; transition: color .15s ease, border-color .15s ease; }
.color-picker__eyedrop:hover { color: var(--paper); border-color: var(--accent); }
.color-picker__eyedrop svg { width: 15px; height: 15px; stroke: currentColor; }
.color-picker__swatch { width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--line); flex-shrink: 0; }
.color-picker__hue { position: relative; flex: 1; height: 12px; border-radius: 999px; cursor: pointer; touch-action: none; background: linear-gradient(90deg,#f00,#ff0,#0f0,#0ff,#00f,#f0f,#f00); }
.color-picker__hue-thumb { position: absolute; top: 50%; width: 18px; height: 18px; border-radius: 50%; background: #fff; border: 2px solid #fff; box-shadow: 0 0 0 1px rgba(0,0,0,.35), 0 1px 3px rgba(0,0,0,.5); transform: translate(-50%, -50%); pointer-events: none; }
.color-picker__fields { display: flex; gap: 8px; }
.color-picker__fields label { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; min-width: 0; }
.color-picker__fields input, .color-picker__hex input { width: 100%; text-align: center; padding: 9px 4px; border: 1px solid var(--line); border-radius: 8px; background: var(--ink-softer); color: var(--paper); font-family: 'Inter', sans-serif; font-size: 12.5px; outline: none; transition: border-color .15s ease; }
.color-picker__fields input:focus, .color-picker__hex input:focus { border-color: var(--accent); }
.color-picker__fields span, .color-picker__hex span { font-size: 10px; color: var(--muted-on-dark); font-weight: 700; }
.color-picker__hex { display: flex; flex-direction: column; align-items: center; gap: 4px; }


    .set-accent-opt__name { display: block; text-align: center; margin-top: 7px; font-size: 10.5px; color: var(--muted-on-dark); font-weight: 600; }

/* ---- Segmented control (uslub, zichlik) ---- */
.set-segmented { display: inline-flex; align-items: stretch; padding: 4px; background: var(--ink-softer); border-radius: 999px; gap: 3px; }
.set-segmented label { position: relative; cursor: pointer; display: flex; margin: 0; line-height: 1.2; }
.set-segmented input { position: absolute; opacity: 0; width: 1px; height: 1px; }
.set-segmented span { display: inline-flex; align-items: center; justify-content: center; padding: 8px 16px; border-radius: 999px; font-size: 12px; font-weight: 700; color: var(--muted-on-dark); transition: background .15s ease, color .15s ease; }
.set-segmented input:checked + span { background: var(--accent); color: var(--accent-ink); }


    .set-range-row { display: flex; align-items: center; gap: 14px; }
    .set-range { flex: 1; accent-color: var(--accent); height: 4px; }
    .set-range-preview { font-size: 12px; color: var(--muted-on-dark); white-space: nowrap; }

    /* ---- Fon (wallpaper) ---- */
    .set-wall-tabs { display: inline-flex; gap: 5px; padding: 4px; background: var(--ink-softer); border-radius: 999px; }
    .set-wall-tab { border: none; background: transparent; color: var(--muted-on-dark); font-family: 'Inter', sans-serif; font-weight: 700; font-size: 12px; padding: 8px 16px; border-radius: 999px; cursor: pointer; transition: background .15s ease, color .15s ease; }
    .set-wall-tab.active { background: var(--accent); color: var(--accent-ink); }
    .set-wall-pane { display: none; margin-top: 18px; }
    .set-wall-pane.active { display: block; }
    .set-wall-hint { display: flex; align-items: center; gap: 8px; margin: 0 0 14px; font-size: 12.5px; color: var(--muted-on-dark); }
    .set-wall-hint svg { width: 16px; height: 16px; stroke: var(--accent); flex-shrink: 0; }
    .set-wall-hint b { color: var(--paper); font-weight: 700; }
    .set-wall-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px 11px; }
    .set-wall-opt { position: relative; cursor: pointer; display: block; }
    .set-wall-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .set-wall-opt__thumb { display: block; height: 84px; border-radius: var(--radius-md); border: 2px solid var(--line); transition: border-color .15s ease, transform .15s ease, box-shadow .15s ease; position: relative; overflow: hidden; }
    .set-wall-opt:hover .set-wall-opt__thumb { transform: translateY(-3px); border-color: var(--muted-on-dark); box-shadow: 0 8px 18px rgba(0,0,0,.35); }
    .set-wall-opt input:checked + .set-wall-opt__thumb { border-color: var(--accent); transform: translateY(-2px); box-shadow: 0 0 0 3px var(--accent-soft); }
    .set-wall-opt input:focus-visible + .set-wall-opt__thumb { outline: 2px solid var(--accent); outline-offset: 2px; }
    .set-wall-opt__name { display: block; margin-top: 7px; text-align: center; font-size: 11px; font-weight: 600; color: var(--muted-on-dark); transition: color .15s ease; }
    .set-wall-opt:hover .set-wall-opt__name, .set-wall-opt input:checked ~ .set-wall-opt__name { color: var(--paper); }
    .set-wall-opt__check { position: absolute; top: 8px; right: 8px; width: 20px; height: 20px; border-radius: 50%; background: var(--accent); color: var(--accent-ink); display: none; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,.4); }
    .set-wall-opt__check svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 3; }
    .set-wall-opt input:checked ~ .set-wall-opt__check { display: flex; }
    .wp-sunset { background: linear-gradient(155deg,#ff9966,#ff5e62 45%,#3a1c71); }
    .wp-mint { background: linear-gradient(155deg,#0f2027,#203a43,#2dd4bf); }
    .wp-dusk { background: linear-gradient(155deg,#232526,#414345); }
    .wp-berry { background: linear-gradient(155deg,#8e2de2,#4a00e0); }
    .wp-forest { background: linear-gradient(155deg,#134e5e,#71b280); }
    .wp-amber { background: linear-gradient(155deg,#f7971e,#e0a83e 60%,#8a5a12); }
    .wp-ocean { background: linear-gradient(155deg,#1c92d2,#f2fcfe); }
    .wp-mono { background: linear-gradient(155deg,#3a3a34,#141410); }
    .wp-candy { background: linear-gradient(155deg,#f6d365,#fda085); }
    .wp-night { background: linear-gradient(155deg,#0f0c29,#302b63,#24243e); }
    .wp-lime { background: linear-gradient(155deg,#a8e063,#56ab2f); }
    .wp-rose { background: linear-gradient(155deg,#f472b6,#7c3aed); }

    .set-color-row { display: flex; align-items: center; gap: 14px; }
    .set-color-input { -webkit-appearance: none; appearance: none; width: 46px; height: 46px; border: none; border-radius: 50%; background: none; cursor: pointer; }
    .set-color-input::-webkit-color-swatch-wrapper { padding: 0; border-radius: 50%; }
    .set-color-input::-webkit-color-swatch { border: 2px solid var(--line); border-radius: 50%; }
    .set-hex-label { font-family: monospace; font-size: 12.5px; color: var(--muted-on-dark); }



/* ---- Rang studiyasi: tepa / o'rta / past ---- */
.cs-layout { display: grid; grid-template-columns: 230px minmax(0, 1fr); gap: 20px; align-items: stretch; }
.cs-stage { position: relative; min-height: 330px; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--line); display: flex; flex-direction: column; }
.cs-stage__bg { position: absolute; inset: 0; transition: background .15s ease; }
.cs-zone { position: relative; flex: 1; display: flex; align-items: center; padding: 0 12px; border: 2px solid transparent; background: transparent; cursor: pointer; transition: border-color .15s ease, background .15s ease; font-family: inherit; }
.cs-zone:hover { background: rgba(255,255,255,.07); }
.cs-zone.is-active { border-color: #fff; background: rgba(255,255,255,.1); box-shadow: inset 0 0 0 1px rgba(0,0,0,.35); }
.cs-chip { display: inline-flex; align-items: center; gap: 8px; padding: 6px 11px 6px 7px; border-radius: 999px; background: rgba(0,0,0,.55); color: #fff; backdrop-filter: blur(6px); font-size: 11.5px; }
.cs-chip i { width: 16px; height: 16px; border-radius: 50%; border: 2px solid rgba(255,255,255,.85); display: block; }
.cs-chip b { font-weight: 700; }
.cs-chip em { font-style: normal; font-family: monospace; opacity: .75; font-size: 10.5px; }

.cs-editor { display: flex; flex-direction: column; gap: 14px; min-width: 0; }
.cs-editor__title { margin: 0; font-size: 12.5px; color: var(--muted-on-dark); }
.cs-editor__title b { color: var(--accent); }
.cs-sv { position: relative; height: 150px; border-radius: 12px; overflow: hidden; cursor: crosshair; touch-action: none; }
.cs-sv canvas { display: block; width: 100%; height: 100%; }
.cs-sv__thumb { position: absolute; width: 16px; height: 16px; border-radius: 50%; border: 2px solid #fff; box-shadow: 0 0 0 1px rgba(0,0,0,.4), 0 1px 3px rgba(0,0,0,.5); transform: translate(-50%, -50%); pointer-events: none; }
.cs-hue { position: relative; height: 12px; border-radius: 999px; cursor: pointer; touch-action: none; background: linear-gradient(90deg,#f00,#ff0,#0f0,#0ff,#00f,#f0f,#f00); }
.cs-hue__thumb { position: absolute; top: 50%; width: 18px; height: 18px; border-radius: 50%; background: #fff; box-shadow: 0 0 0 1px rgba(0,0,0,.35), 0 1px 3px rgba(0,0,0,.5); transform: translate(-50%, -50%); pointer-events: none; }
.cs-hexrow { display: flex; align-items: center; gap: 10px; }
.cs-hexrow input { width: 110px; padding: 9px 12px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font-family: monospace; font-size: 12.5px; text-transform: uppercase; }
.cs-hexrow input:focus { border-color: var(--accent); }
.cs-hexrow input.is-invalid { border-color: var(--danger); }

.cs-seg { display: inline-flex; padding: 4px; gap: 3px; background: var(--ink-softer); border-radius: 999px; align-self: flex-start; flex-wrap: wrap; }
.cs-seg button { border: none; background: transparent; color: var(--muted-on-dark); font: 700 11.5px 'Inter', sans-serif; padding: 7px 13px; border-radius: 999px; cursor: pointer; transition: background .15s ease, color .15s ease; }
.cs-seg button.active { background: var(--accent); color: var(--accent-ink); }
.cs-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.cs-actions .btn-ghost { padding: 8px 14px; font-size: 12px; }

.cs-palettes-title { margin: 22px 0 12px; padding-top: 18px; border-top: 1px solid var(--line); font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted-on-dark); }
.cs-palettes { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px 11px; }
.cs-pal { border: none; background: none; padding: 0; cursor: pointer; font-family: inherit; }
.cs-pal__thumb { display: block; height: 84px; border-radius: var(--radius-md); border: 2px solid var(--line); transition: transform .15s ease, border-color .15s ease, box-shadow .15s ease; }
.cs-pal:hover .cs-pal__thumb { transform: translateY(-3px); border-color: var(--accent); box-shadow: 0 8px 18px rgba(0,0,0,.35); }
.cs-pal span.cs-pal__name { display: block; margin-top: 7px; text-align: center; font-size: 11px; font-weight: 600; color: var(--muted-on-dark); }
@media (max-width: 860px) { .cs-layout { grid-template-columns: 1fr; } .cs-palettes { grid-template-columns: repeat(3, 1fr); } }

    .set-upload-zone { display: flex; align-items: center; gap: 14px; border: 1.5px dashed var(--line); border-radius: var(--radius-md); padding: 18px; cursor: pointer; transition: border-color .15s ease, background .15s ease; }
    .set-upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .set-upload-zone__icon { width: 44px; height: 44px; border-radius: 12px; background: var(--ink-softer); display: grid; place-items: center; color: var(--accent); flex-shrink: 0; }
    .set-upload-zone__icon svg { width: 21px; height: 21px; stroke: currentColor; }
    .set-upload-zone__text strong { display: block; font-size: 13px; }
    .set-upload-zone__text span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); }
    .set-upload-zone input[type=file] { display: none; }
    .set-blur-row { display: flex; align-items: center; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--line); }

    /* ---- Xotira progress bar ---- */
    .storage-bar-wrap { margin-top: 4px; }
    .storage-bar { height: 9px; border-radius: 999px; background: var(--ink-softer); overflow: hidden; display: flex; }
    .storage-bar i { display: block; height: 100%; }
    .storage-legend { display: flex; flex-wrap: wrap; gap: 14px; margin-top: 12px; }
    .storage-legend span { display: inline-flex; align-items: center; gap: 6px; font-size: 11.5px; color: var(--muted-on-dark); }
    .storage-legend em { width: 8px; height: 8px; border-radius: 3px; display: inline-block; font-style: normal; }


    /* ---- link-row (masalan "Faol seanslar", "Bloklangan foydalanuvchilar") ---- */
    .set-link-row { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-top: 1px solid var(--line); cursor: pointer; }
    .set-link-row:first-of-type { border-top: none; padding-top: 0; }
    .set-link-row__icon { width: 36px; height: 36px; border-radius: 10px; background: var(--ink-softer); display: grid; place-items: center; color: var(--accent); flex-shrink: 0; }
    .set-link-row__icon svg { width: 17px; height: 17px; stroke: currentColor; }
    .set-link-row__text { flex: 1; min-width: 0; }
    .set-link-row__text strong { display: block; font-size: 13.5px; font-weight: 600; }
    .set-link-row__text span { display: block; margin-top: 2px; color: var(--muted-on-dark); font-size: 12px; }
    .set-link-row__chev { width: 15px; height: 15px; stroke: var(--muted-on-dark); flex-shrink: 0; }

    /* ---- Tinch soatlar (Dam olish vaqti) ---- */
    .qh-status-pill { display: inline-flex; align-items: center; gap: 7px; font-size: 11px; font-weight: 800; padding: 5px 12px; border-radius: 999px; margin-left: 10px; vertical-align: middle; }
    .qh-status-pill.is-active { color: #7ff0c9; background: rgba(45,212,191,0.12); border: 1px solid rgba(45,212,191,0.3); }
    .qh-status-pill.is-quiet { color: #f0b56b; background: rgba(224,168,62,0.14); border: 1px solid rgba(224,168,62,0.35); }
    .qh-status-pill span.dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .qh-time-card { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
    .qh-time-field { display: flex; flex-direction: column; gap: 7px; }
    .qh-time-field label { font-size: 11px; font-weight: 700; color: var(--muted-on-dark); text-transform: uppercase; letter-spacing: .05em; }
    .set-input-time { padding: 10px 13px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 700; transition: border-color .15s ease; color-scheme: dark; }
    .set-input-time:focus { border-color: var(--accent); }
    #setPage.theme-light .set-input-time { color-scheme: light; }
    .qh-arrow { display: flex; align-items: center; padding-top: 20px; color: var(--muted-on-dark); }
    .qh-arrow svg { width: 16px; height: 16px; stroke: currentColor; }
    .qh-hint { flex-basis: 100%; margin-top: 6px; font-size: 11.5px; color: var(--muted-on-dark); }

    .qh-msg-textarea { width: 100%; resize: vertical; min-height: 62px; padding: 12px 14px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font-family: 'Inter', sans-serif; font-size: 12.5px; line-height: 1.5; transition: border-color .15s ease; }
    .qh-msg-textarea:focus { border-color: var(--accent); }

    .qh-banner-preview { display: flex; align-items: flex-start; gap: 12px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink-softer); padding: 15px; margin-top: 16px; }
    .qh-banner-preview__icon { width: 38px; height: 38px; border-radius: 11px; background: var(--accent-soft); color: var(--accent); display: grid; place-items: center; flex-shrink: 0; }
    .qh-banner-preview__icon svg { width: 19px; height: 19px; stroke: currentColor; }
    .qh-banner-preview__body strong { display: block; font-size: 12.5px; margin-bottom: 3px; }
    .qh-banner-preview__body span { display: block; font-size: 12px; color: var(--muted-on-dark); line-height: 1.5; }

    /* ============================================================ */
    /* O'NG: JONLI KO'RINISH + HISOB PANELI                          */
    /* ============================================================ */
    .set-preview-panel { width: 340px; flex-shrink: 0; background: var(--ink-soft); border-left: 1px solid var(--line); overflow-y: auto; padding: 20px 18px 30px; }
    .set-preview-panel::-webkit-scrollbar { width: 5px; }
    .set-preview-panel::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }

    .pv-card { border: 1px solid var(--line); border-radius: var(--radius-lg); background: var(--ink); overflow: hidden; margin-bottom: 16px; }
    .pv-card__label { display: flex; align-items: center; gap: 8px; padding: 13px 15px; border-bottom: 1px solid var(--line); font-family: 'Sora', sans-serif; font-weight: 700; font-size: 12px; color: var(--muted-on-dark); }
    .pv-card__label svg { width: 14px; height: 14px; stroke: var(--accent); }
    .pv-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--teal); margin-left: auto; animation: setPulse 1.6s ease-in-out infinite; }
    @keyframes setPulse { 0%,100% { opacity: .35; } 50% { opacity: 1; } }

    .pv-screen { position: relative; height: auto; aspect-ratio: 1.5; min-height: 280px; overflow: hidden; background: #141410; }
    .pv-bg { position: absolute; inset: 0; background-size: cover; background-position: center; transition: background .25s ease; }
    .pv-bg video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .pv-bg.blurred { filter: blur(3px) brightness(.85); }
    .pv-chat { position: absolute; inset: 0; padding: 14px; display: flex; flex-direction: column; justify-content: flex-end; gap: 7px; }
    .pv-bubble { max-width: 80%; padding: 9px 12px 8px; border-radius: 15px; font-size: 12px; line-height: 1.4; box-shadow: 0 2px 8px rgba(0,0,0,0.25); }
    .pv-bubble.in { align-self: flex-start; background: rgba(255,255,255,0.95); color: #171817; border-bottom-left-radius: 4px; }
   .pv-bubble.out { align-self: flex-end; background: var(--bubble); color: var(--bubble-ink); border-bottom-right-radius: 4px; }
    .pv-time { display: block; margin-top: 3px; font-size: 9.5px; opacity: .65; text-align: right; }
    .pv-footer-note { padding: 13px 15px; font-size: 11.5px; color: var(--muted-on-dark); line-height: 1.55; }
    .pv-footer-note b { color: var(--paper); }

    .acc-head { display: flex; align-items: center; gap: 12px; padding: 16px 15px; }
    .acc-avatar { width: 48px; height: 48px; border-radius: 50%; overflow: hidden; flex-shrink: 0; display: grid; place-items: center; background: var(--accent); color: var(--accent-ink); font-family: 'Sora', sans-serif; font-weight: 800; }
    .acc-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .acc-head b { display: block; font-size: 13.5px; }
    .acc-head span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); }
    .acc-stats { display: grid; grid-template-columns: repeat(3, 1fr); border-top: 1px solid var(--line); }
    .acc-stats div { text-align: center; padding: 12px 4px; border-right: 1px solid var(--line); }
    .acc-stats div:last-child { border-right: none; }
    .acc-stats b { display: block; font-family: 'Sora', sans-serif; font-size: 15px; }
    .acc-stats span { display: block; margin-top: 2px; font-size: 10px; color: var(--muted-on-dark); }

    .dev-row { display: flex; align-items: center; gap: 11px; padding: 12px 15px; border-top: 1px solid var(--line); }
    .dev-row:first-of-type { border-top: none; }
    .dev-row__icon { width: 34px; height: 34px; border-radius: 9px; background: var(--ink-softer); display: grid; place-items: center; color: var(--muted-on-dark); flex-shrink: 0; }
    .dev-row.is-current .dev-row__icon { color: var(--teal); background: rgba(45,212,191,0.14); }
    .dev-row__icon svg { width: 16px; height: 16px; stroke: currentColor; }
    .dev-row__text { flex: 1; min-width: 0; }
    .dev-row__text strong { display: block; font-size: 12.5px; font-weight: 600; }
    .dev-row__text span { display: block; margin-top: 1px; font-size: 11px; color: var(--muted-on-dark); }
    .dev-badge { font-size: 9.5px; font-weight: 800; color: var(--teal-ink); background: var(--teal); padding: 3px 7px; border-radius: 999px; flex-shrink: 0; }
    .pv-card__link-all { display: block; text-align: center; padding: 11px; font-size: 12px; font-weight: 700; color: var(--accent); text-decoration: none; border-top: 1px solid var(--line); }
    .pv-card__link-all:hover { text-decoration: underline; }



        /* ---- Interfeys zichligi: rasmli kartalar ---- */
    .density-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .density-opt { position: relative; cursor: pointer; display: block; }
    .density-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
    .density-opt__box { display: block; border: 2px solid var(--line); border-radius: var(--radius-md); padding: 12px; background: var(--ink); transition: border-color .15s ease, background .15s ease, transform .15s ease; }
    .density-opt:hover .density-opt__box { border-color: var(--muted-on-dark); }
    .density-opt input:checked + .density-opt__box { border-color: var(--accent); background: var(--accent-soft); transform: translateY(-2px); }
    .density-opt input:focus-visible + .density-opt__box { outline: 2px solid var(--accent); outline-offset: 2px; }
    .density-opt__mini { display: flex; flex-direction: column; justify-content: center; height: 74px; padding: 0 12px; border-radius: 9px; background: var(--ink-softer); margin-bottom: 12px; }
    .density-opt__mini i { display: block; height: 10px; border-radius: 6px; width: 62%; background: var(--line); }
    .density-opt__mini i:nth-child(even) { align-self: flex-end; width: 48%; background: var(--accent); opacity: .85; }
    .density-opt__mini--comfortable { gap: 10px; }
    .density-opt__mini--compact { gap: 4px; }
    .density-opt__name { display: block; font-size: 13.5px; font-weight: 700; }
    .density-opt__hint { display: block; margin-top: 3px; font-size: 11.5px; color: var(--muted-on-dark); line-height: 1.45; }
    .density-opt__check { position: absolute; top: 10px; right: 10px; width: 20px; height: 20px; border-radius: 50%; background: var(--accent); color: var(--accent-ink); display: none; align-items: center; justify-content: center; }
    .density-opt__check svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 3; }
    .density-opt input:checked ~ .density-opt__check { display: flex; }

    /* ---- Matn o'lchami: slayder ---- */
    .fs-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
    .fs-value { font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--accent); background: var(--accent-soft); padding: 5px 12px; border-radius: 999px; }
    .fs-slider-row { display: flex; align-items: center; gap: 14px; }
    .fs-step { width: 38px; height: 38px; flex-shrink: 0; border-radius: 50%; border: 1px solid var(--line); background: var(--ink-softer); color: var(--paper); font: 700 20px/1 'Sora', sans-serif; cursor: pointer; display: grid; place-items: center; transition: background .15s ease, border-color .15s ease, transform .1s ease, opacity .15s ease; }
    .fs-step:hover:not(:disabled) { border-color: var(--accent); background: var(--accent-soft); color: var(--accent); }
    .fs-step:active:not(:disabled) { transform: scale(.92); }
    .fs-step:disabled { opacity: .35; cursor: not-allowed; }
    .fs-range { -webkit-appearance: none; appearance: none; flex: 1; height: 10px; border-radius: 999px; outline: none; cursor: pointer; background: linear-gradient(90deg, var(--accent) 0%, var(--accent) var(--pct, 50%), var(--ink-softer) var(--pct, 50%), var(--ink-softer) 100%); }
    .fs-range::-webkit-slider-thumb { -webkit-appearance: none; appearance: none; width: 28px; height: 28px; border-radius: 50%; background: var(--accent); border: 5px solid var(--ink-soft); box-shadow: 0 0 0 1px var(--accent), 0 2px 8px rgba(0,0,0,.45); cursor: grab; transition: transform .12s ease; }
    .fs-range::-webkit-slider-thumb:hover { transform: scale(1.12); }
    .fs-range::-webkit-slider-thumb:active { cursor: grabbing; transform: scale(1.18); }
    .fs-range::-moz-range-thumb { width: 18px; height: 18px; border-radius: 50%; background: var(--accent); border: 5px solid var(--ink-soft); box-shadow: 0 0 0 1px var(--accent); cursor: grab; }
    .fs-range:focus-visible { outline: 2px solid var(--accent); outline-offset: 6px; }

    /* ---- Matn o'lchami: chatdagidek namuna ---- */
    .fs-chat { margin-top: 20px; padding: 16px; border-radius: var(--radius-md); background: var(--ink-softer); display: flex; flex-direction: column; gap: 8px; }
    .fs-bubble { max-width: 78%; padding: 10px 14px 8px; border-radius: 16px; line-height: 1.4; box-shadow: 0 2px 8px rgba(0,0,0,.2); word-break: break-word; }
    .fs-bubble.in { align-self: flex-start; background: rgba(255,255,255,0.95); color: #171817; border-bottom-left-radius: 4px; }
   .fs-bubble.out { align-self: flex-end; background: var(--bubble); color: var(--bubble-ink); border-bottom-right-radius: 4px; }
    .fs-bubble__time { display: block; margin-top: 3px; font-size: 10px; opacity: .65; text-align: right; }
    .fs-try { margin-top: 12px; display: flex; flex-direction: column; gap: 6px; }
    .fs-try label { font-size: 11px; font-weight: 700; color: var(--muted-on-dark); text-transform: uppercase; letter-spacing: .05em; }
    .fs-try input { width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--ink-softer); color: var(--paper); outline: none; font-family: 'Inter', sans-serif; font-size: 13px; transition: border-color .15s ease; }
    .fs-try input:focus { border-color: var(--accent); }

    /* jonli ko'rinishda zichlik */
    .pv-chat { transition: gap .2s ease; }
    .pv-chat.is-compact { gap: 3px; }
    .pv-chat.is-compact .pv-bubble { padding: 6px 10px 5px; }

    @media (max-width: 1300px) { .set-preview-panel { width: 300px; } }
    @media (max-width: 1080px) { .set-preview-panel { display: none; } }
    @media (max-width: 860px) {
        .color-picker { grid-template-columns: 1fr; }
        .set-nav { position: fixed; left: 0; top: 0; bottom: 0; z-index: 40; transform: translateX(0); transition: transform .2s ease; }
        .set-nav.hidden { transform: translateX(-100%); }
        .set-grid-2 { grid-template-columns: 1fr; }
        .set-wall-grid { grid-template-columns: repeat(4, 1fr); }
        .set-theme-grid { grid-template-columns: repeat(3, 1fr); }
        .qh-time-card { flex-direction: column; align-items: stretch; }
        .qh-arrow { display: none; }
    }











/* ---- Media muharriri (rasm / video) ---- */
.set-file-hidden { position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; clip: rect(0 0 0 0); pointer-events: none; }

.me-empty { display: flex; align-items: center; gap: 16px; padding: 16px 18px; border: 1.5px dashed var(--line); border-radius: var(--radius-md); background: var(--ink); cursor: pointer; outline: none; transition: border-color .15s ease, background .15s ease; }
.me-empty:hover, .me-empty:focus-visible, .me-empty.is-drag { border-color: var(--accent); background: var(--accent-soft); }
.me-empty__icon { width: 46px; height: 46px; border-radius: 13px; background: var(--accent-soft); color: var(--accent); display: grid; place-items: center; flex-shrink: 0; }
.me-empty__icon svg, .me-file__ic svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
.me-empty__txt { flex: 1; min-width: 0; }
.me-empty__txt b { display: block; font-size: 13.5px; }
.me-empty__txt span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); }
.me-empty .btn-solid { padding: 9px 16px; flex-shrink: 0; }

.me-editor { display: grid; grid-template-columns: minmax(0, 1fr) 210px; gap: 16px; align-items: start; }
.me-empty[hidden], .me-editor[hidden], .me-error[hidden] { display: none; }

.me-wrap { display: grid; place-items: center; padding: 14px; border-radius: var(--radius-md); border: 1px solid var(--line); background: var(--ink); min-width: 0; }
.me-stage { position: relative; overflow: hidden; border-radius: 10px; background: #000; cursor: grab; touch-action: none; user-select: none; box-shadow: 0 0 0 1px rgba(255,255,255,.12), 0 10px 26px rgba(0,0,0,.45); }
.me-stage.is-drag { cursor: grabbing; }
.me-stage img { position: absolute; max-width: none; pointer-events: none; -webkit-user-drag: none; }
.me-stage video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
.me-grid { position: absolute; inset: 0; pointer-events: none; opacity: 0; transition: opacity .15s ease; background-image: linear-gradient(rgba(255,255,255,.3) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.3) 1px, transparent 1px); background-size: 33.333% 33.333%; }
.me-stage.is-drag .me-grid { opacity: 1; }
.me-hint { position: absolute; left: 50%; bottom: 10px; transform: translateX(-50%); padding: 5px 12px; border-radius: 999px; background: rgba(0,0,0,.6); color: #fff; font-size: 11px; font-weight: 700; white-space: nowrap; backdrop-filter: blur(6px); pointer-events: none; transition: opacity .2s ease; }
.me-stage.is-touched .me-hint { opacity: 0; }

.me-side { display: flex; flex-direction: column; gap: 14px; min-width: 0; }
.me-file { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 11px; background: var(--ink-softer); }
.me-file__ic { width: 34px; height: 34px; border-radius: 9px; background: var(--accent-soft); color: var(--accent); display: grid; place-items: center; flex-shrink: 0; }
.me-file__ic svg { width: 17px; height: 17px; }
.me-file__t { min-width: 0; }
.me-file__t b { display: block; font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.me-file__t span { display: block; margin-top: 1px; font-size: 11px; color: var(--muted-on-dark); }
.me-ctl label { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 11px; font-weight: 700; color: var(--muted-on-dark); text-transform: uppercase; letter-spacing: .05em; }
.me-ctl label em { font-style: normal; color: var(--accent); }
.me-ctl input[type=range] { width: 100%; accent-color: var(--accent); }
.me-seg { display: flex; padding: 3px; gap: 3px; background: var(--ink-softer); border-radius: 999px; }
.me-seg button { flex: 1; border: none; background: transparent; color: var(--muted-on-dark); font: 700 11.5px 'Inter', sans-serif; padding: 7px 4px; border-radius: 999px; cursor: pointer; transition: background .15s ease, color .15s ease; }
.me-seg button.active { background: var(--accent); color: var(--accent-ink); }
.me-note { margin: 0; font-size: 12px; line-height: 1.5; color: var(--muted-on-dark); }
.me-actions { display: flex; flex-direction: column; gap: 8px; }
.me-actions .btn-ghost { justify-content: center; padding: 9px 14px; font-size: 12px; }
.me-actions .btn-ghost.is-danger:hover { color: var(--danger); border-color: var(--danger); }
.me-error { margin: 12px 0 0; padding: 10px 14px; border-radius: var(--radius-sm); font-size: 12.5px; font-weight: 600; color: var(--danger); background: rgba(241,101,101,.12); border: 1px solid rgba(241,101,101,.35); }
@media (max-width: 860px) { .me-editor { grid-template-columns: 1fr; } }







/* ================= BILDIRISHNOMALAR ================= */
.np-hero { display:flex; align-items:center; gap:16px; padding:20px; margin-bottom:14px; border:1px solid var(--line); border-radius:var(--radius-lg); background:linear-gradient(135deg,var(--accent-soft),var(--ink-soft) 70%); }
.np-hero__icon { width:52px; height:52px; border-radius:15px; background:var(--accent); color:var(--accent-ink); display:grid; place-items:center; flex-shrink:0; }
.np-hero__icon svg { width:24px; height:24px; stroke:currentColor; }
.np-hero__text { flex:1; min-width:0; }
.np-hero__text strong { display:block; font:800 15px 'Sora',sans-serif; }
.np-hero__text span { display:block; margin-top:4px; font-size:12.5px; color:var(--muted-on-dark); line-height:1.5; }
.np-hero__actions { display:flex; align-items:center; gap:12px; flex-shrink:0; }

.np-layout { display:grid; grid-template-columns:minmax(0,1.25fr) minmax(0,1fr); gap:24px; align-items:start; }
.np-screen { position:relative; aspect-ratio:16/10; border-radius:12px; border:6px solid var(--ink-softer); outline:1px solid var(--line); background:linear-gradient(160deg,var(--ink),var(--ink-softer)); overflow:hidden; }
.np-screen__bar { position:absolute; left:0; right:0; bottom:0; height:7%; background:var(--ink-softer); border-top:1px solid var(--line); }
.np-screen__win { position:absolute; left:14%; right:14%; top:22%; bottom:20%; border-radius:8px; border:1px solid var(--line); background:var(--ink-soft); opacity:.7; }
.np-zone { position:absolute; width:36%; height:24%; display:flex; cursor:pointer; border-radius:9px; border:1.5px dashed transparent; transition:border-color .15s ease, background .15s ease; }
.np-zone input { position:absolute; opacity:0; width:1px; height:1px; }
.np-zone:hover { border-color:var(--muted-on-dark); background:rgba(255,255,255,.04); }
.np-zone__toast { display:none; width:100%; height:100%; border-radius:8px; background:var(--accent-soft); border:1.5px solid var(--accent); padding:0 9px; align-items:center; gap:7px; }
.np-zone__toast i { width:14px; height:14px; border-radius:50%; background:var(--accent); flex-shrink:0; }
.np-zone__toast b { display:block; flex:1; height:5px; border-radius:3px; background:var(--accent); opacity:.55; box-shadow:0 8px 0 -0px var(--accent); }
.np-zone input:checked ~ .np-zone__toast { display:flex; }
.np-zone input:focus-visible ~ .np-zone__toast { outline:2px solid var(--accent); outline-offset:2px; }
.np-zone--tl { top:4%; left:3%; }   .np-zone--tc { top:4%; left:32%; }   .np-zone--tr { top:4%; right:3%; }
.np-zone--bl { bottom:10%; left:3%; } .np-zone--bc { bottom:10%; left:32%; } .np-zone--br { bottom:10%; right:3%; }
.np-screen-hint { margin:12px 0 0; text-align:center; font-size:11.5px; color:var(--muted-on-dark); }
.np-side { display:flex; flex-direction:column; gap:20px; min-width:0; }
.np-side h4 { margin:0 0 10px; font-size:11.5px; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:var(--muted-on-dark); }
.np-perm { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px; padding-top:14px; border-top:1px solid var(--line); font-size:12px; color:var(--muted-on-dark); }
.np-perm b { color:var(--paper); }
.np-note { margin:14px 0 0; padding:12px 14px; border-radius:var(--radius-sm); background:var(--ink-softer); font-size:11.5px; line-height:1.55; color:var(--muted-on-dark); }
@media (max-width:1180px) { .np-layout { grid-template-columns:1fr; } .np-hero { flex-wrap:wrap; } }

/* ---- Haqiqiy bildirishnoma (toast) ---- */
.ct-stack { position:fixed; z-index:9999; display:flex; flex-direction:column; gap:10px; width:350px; max-width:calc(100vw - 32px); pointer-events:none; }
.ct-stack.pos-top-left { top:18px; left:18px; --from:translateX(-40px); }
.ct-stack.pos-top-center { top:18px; left:50%; margin-left:-175px; --from:translateY(-30px); }
.ct-stack.pos-top-right { top:18px; right:18px; --from:translateX(40px); }
.ct-stack.pos-bottom-left { bottom:18px; left:18px; flex-direction:column-reverse; --from:translateX(-40px); }
.ct-stack.pos-bottom-center { bottom:18px; left:50%; margin-left:-175px; flex-direction:column-reverse; --from:translateY(30px); }
.ct-stack.pos-bottom-right { bottom:18px; right:18px; flex-direction:column-reverse; --from:translateX(40px); }
.ct { pointer-events:auto; position:relative; display:flex; align-items:flex-start; gap:12px; padding:13px 14px 15px; border-radius:16px; background:var(--ink-soft); border:1px solid var(--line-soft); color:var(--paper); box-shadow:0 16px 44px rgba(0,0,0,.5); overflow:hidden; cursor:pointer; animation:ctIn .3s cubic-bezier(.2,.9,.3,1.15); font-family:'Inter',sans-serif; }
.ct.is-out { animation:ctOut .22s ease forwards; }
@keyframes ctIn  { from { opacity:0; transform:var(--from); } to { opacity:1; transform:none; } }
@keyframes ctOut { to { opacity:0; transform:var(--from); } }
.ct__av { width:40px; height:40px; border-radius:50%; background:var(--accent); color:var(--accent-ink); display:grid; place-items:center; font:800 15px 'Sora',sans-serif; flex-shrink:0; }
.ct__body { flex:1; min-width:0; }
.ct__top { display:flex; align-items:baseline; justify-content:space-between; gap:10px; }
.ct__name { font-size:13.5px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ct__time { font-size:10.5px; color:var(--muted-on-dark); flex-shrink:0; }
.ct__text { margin-top:3px; font-size:12.5px; line-height:1.45; color:var(--muted-on-dark); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.ct__x { position:absolute; top:7px; right:8px; width:20px; height:20px; border:none; border-radius:50%; background:transparent; color:var(--muted-on-dark); font-size:15px; line-height:1; cursor:pointer; opacity:0; transition:opacity .15s ease, background .15s ease; }
.ct:hover .ct__x { opacity:1; }
.ct__x:hover { background:var(--ink-softer); color:var(--paper); }
.ct:hover .ct__time { opacity:0; }
.ct__bar { position:absolute; left:0; bottom:0; height:3px; width:100%; background:var(--accent); transform-origin:left; animation:ctBar var(--dur,6s) linear forwards; }
.ct:hover .ct__bar { animation-play-state:paused; }
@keyframes ctBar { to { transform:scaleX(0); } }
.ct--compact { padding:9px 12px 11px; gap:10px; border-radius:13px; }
.ct--compact .ct__av { width:30px; height:30px; font-size:12px; }
.ct--compact .ct__text { -webkit-line-clamp:1; margin-top:1px; font-size:12px; }
.ct--minimal { padding:10px 18px; border-radius:999px; gap:9px; align-items:center; }
.ct--minimal .ct__av { width:10px; height:10px; font-size:0; }
.ct--minimal .ct__top { display:contents; }
.ct--minimal .ct__time, .ct--minimal .ct__bar, .ct--minimal .ct__x { display:none; }
.ct--minimal .ct__body { display:flex; gap:6px; align-items:baseline; overflow:hidden; }
.ct--minimal .ct__name { flex-shrink:0; }
.ct--minimal .ct__name::after { content:':'; }
.ct--minimal .ct__text { margin:0; -webkit-line-clamp:1; }











/* ================= BILDIRISHNOMA (toast) ================= */
.ct-stack { position:fixed; z-index:9999; display:flex; flex-direction:column; gap:10px; width:350px; max-width:calc(100vw - 32px); pointer-events:none; }
.ct-stack.pos-top-left { top:18px; left:18px; --from:translateX(-40px); }
.ct-stack.pos-top-center { top:18px; left:50%; margin-left:-175px; --from:translateY(-30px); }
.ct-stack.pos-top-right { top:18px; right:18px; --from:translateX(40px); }
.ct-stack.pos-bottom-left { bottom:18px; left:18px; flex-direction:column-reverse; --from:translateX(-40px); }
.ct-stack.pos-bottom-center { bottom:18px; left:50%; margin-left:-175px; flex-direction:column-reverse; --from:translateY(30px); }
.ct-stack.pos-bottom-right { bottom:18px; right:18px; flex-direction:column-reverse; --from:translateX(40px); }
.ct { pointer-events:auto; position:relative; display:flex; align-items:flex-start; gap:12px; padding:13px 14px 15px; border-radius:16px; background:var(--ink-soft); border:1px solid var(--line); color:var(--paper); box-shadow:0 16px 44px rgba(0,0,0,.45); overflow:hidden; cursor:pointer; animation:ctIn .3s cubic-bezier(.2,.9,.3,1.15); font-family:'Inter',sans-serif; }
.ct.is-out { animation:ctOut .22s ease forwards; }
@keyframes ctIn  { from { opacity:0; transform:var(--from); } to { opacity:1; transform:none; } }
@keyframes ctOut { to { opacity:0; transform:var(--from); } }
.ct__av { width:40px; height:40px; border-radius:50%; background:var(--accent); color:var(--accent-ink); display:grid; place-items:center; font:800 15px 'Sora',sans-serif; flex-shrink:0; overflow:hidden; }
.ct__av img { width:100%; height:100%; object-fit:cover; display:block; }
.ct__body { flex:1; min-width:0; }
.ct__top { display:flex; align-items:baseline; justify-content:space-between; gap:10px; }
.ct__name { font-size:13.5px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.ct__time { font-size:10.5px; color:var(--muted-on-dark); flex-shrink:0; }
.ct__text { margin-top:3px; font-size:12.5px; line-height:1.45; color:var(--muted-on-dark); display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; word-break:break-word; }
.ct__x { position:absolute; top:7px; right:8px; width:20px; height:20px; border:none; border-radius:50%; background:transparent; color:var(--muted-on-dark); font-size:15px; line-height:1; cursor:pointer; opacity:0; transition:opacity .15s ease, background .15s ease; }
.ct:hover .ct__x { opacity:1; }
.ct:hover .ct__time { opacity:0; }
.ct__x:hover { background:var(--ink-softer); color:var(--paper); }
.ct__bar { position:absolute; left:0; bottom:0; height:3px; width:100%; background:var(--accent); transform-origin:left; animation:ctBar var(--dur,6s) linear forwards; }
.ct:hover .ct__bar { animation-play-state:paused; }
@keyframes ctBar { to { transform:scaleX(0); } }
.ct--compact { padding:9px 12px 11px; gap:10px; border-radius:13px; }
.ct--compact .ct__av { width:30px; height:30px; font-size:12px; }
.ct--compact .ct__text { -webkit-line-clamp:1; margin-top:1px; font-size:12px; }
.ct--minimal { padding:10px 18px; border-radius:999px; gap:9px; align-items:center; }
.ct--minimal .ct__av { width:10px; height:10px; font-size:0; }
.ct--minimal .ct__top { display:contents; }
.ct--minimal .ct__time, .ct--minimal .ct__bar, .ct--minimal .ct__x { display:none; }
.ct--minimal .ct__body { display:flex; gap:6px; align-items:baseline; overflow:hidden; }
.ct--minimal .ct__name { flex-shrink:0; }
.ct--minimal .ct__name::after { content:':'; }
.ct--minimal .ct__text { margin:0; -webkit-line-clamp:1; }


.pv-card--devices { transition: box-shadow .3s ease, border-color .3s ease; }
.pv-card--devices.is-lifted { box-shadow: 0 14px 36px rgba(0,0,0,.45); border-color: var(--accent); }





















/* ---------- Xotira: umumiy ko'rsatkich ---------- */
.st-summary { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 16px; }
.st-summary__big { font-family: 'Sora', sans-serif; font-size: 34px; font-weight: 800; letter-spacing: -0.02em; line-height: 1; }
.st-summary__big small { font-size: 14px; font-weight: 600; color: var(--muted-on-dark); margin-left: 6px; letter-spacing: 0; }
.st-summary__note { font-size: 12px; color: var(--muted-on-dark); }
 
.st-bar { display: flex; gap: 3px; height: 12px; }
.st-bar i { display: block; height: 100%; border-radius: 6px; min-width: 6px; transition: width .3s ease; }
 
.st-list { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 18px; }
.st-item { display: flex; align-items: center; gap: 11px; padding: 11px 13px; border-radius: var(--radius-sm); background: var(--ink-softer); }
.st-item__dot { width: 10px; height: 10px; border-radius: 4px; flex-shrink: 0; }
.st-item__name { flex: 1; min-width: 0; font-size: 13px; font-weight: 600; }
.st-item__size { font-size: 12.5px; font-weight: 700; }
.st-item__pct { width: 38px; text-align: right; font-size: 11.5px; color: var(--muted-on-dark); }
 
.st-clear { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-top: 18px; padding-top: 18px; border-top: 1px solid var(--line); }
.st-clear strong { display: block; font-size: 13.5px; }
.st-clear span.st-clear__hint { display: block; margin-top: 3px; font-size: 12px; color: var(--muted-on-dark); }
 
/* ---------- Avto-yuklash: jadval (grid) ---------- */
.dl-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 16px; }
.dl-top p { margin: 0; max-width: 420px; font-size: 12.5px; line-height: 1.55; color: var(--muted-on-dark); }
.dl-presets { display: inline-flex; padding: 4px; gap: 3px; background: var(--ink-softer); border-radius: 999px; }
.dl-presets button { border: none; background: transparent; color: var(--muted-on-dark); font: 700 11.5px 'Inter', sans-serif; padding: 7px 13px; border-radius: 999px; cursor: pointer; transition: background .15s ease, color .15s ease; }
.dl-presets button:hover { background: var(--accent-soft); color: var(--paper); }
 
.dl-table { border: 1px solid var(--line); border-radius: var(--radius-md); overflow: hidden; }
.dl-head, .dl-row { display: grid; grid-template-columns: minmax(0, 1fr) 110px 110px; align-items: center; }
.dl-head { background: var(--ink-softer); padding: 11px 16px; }
.dl-head__col { display: flex; flex-direction: column; align-items: center; gap: 5px; font-size: 11px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--muted-on-dark); }
.dl-head__col svg { width: 16px; height: 16px; stroke: var(--accent); fill: none; }
.dl-head__title { font-size: 11px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; color: var(--muted-on-dark); }
 
.dl-row { padding: 13px 16px; border-top: 1px solid var(--line); transition: background .15s ease; }
.dl-row:hover { background: var(--accent-soft); }
.dl-row__main { display: flex; align-items: center; gap: 13px; min-width: 0; }
.dl-row__icon { width: 38px; height: 38px; border-radius: 11px; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--accent); }
.dl-row__icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; }
.dl-row__text { min-width: 0; }
.dl-row__text strong { display: block; font-size: 13.5px; font-weight: 600; }
.dl-row__text span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); line-height: 1.4; }
.dl-cell { justify-self: center; }
 
.dl-foot { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-top: 14px; font-size: 12px; color: var(--muted-on-dark); }
.dl-foot b { color: var(--paper); font-weight: 700; }
.dl-warn { display: flex; align-items: flex-start; gap: 9px; margin-top: 14px; padding: 11px 14px; border-radius: var(--radius-sm); background: var(--ink-softer); font-size: 11.5px; line-height: 1.55; color: var(--muted-on-dark); }
.dl-warn svg { width: 15px; height: 15px; stroke: var(--accent); fill: none; flex-shrink: 0; margin-top: 1px; }
 
@media (max-width: 860px) {
    .st-list { grid-template-columns: 1fr; }
    .dl-head, .dl-row { grid-template-columns: minmax(0, 1fr) 72px 72px; padding-left: 12px; padding-right: 12px; }
    .dl-row__text span { display: none; }
}











/* ---------- Til kartalari (bayroq bilan) ---------- */
.lang-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
.lang-opt { position: relative; display: block; cursor: pointer; }
.lang-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
.lang-opt__box { display: flex; flex-direction: column; gap: 14px; height: 100%; padding: 14px; border: 2px solid var(--line); border-radius: var(--radius-md); background: var(--ink); transition: border-color .15s ease, background .15s ease, transform .15s ease; }
.lang-opt:hover .lang-opt__box { border-color: var(--muted-on-dark); }
.lang-opt input:checked + .lang-opt__box { border-color: var(--accent); background: var(--accent-soft); transform: translateY(-2px); }
.lang-opt input:focus-visible + .lang-opt__box { outline: 2px solid var(--accent); outline-offset: 2px; }
.lang-opt__flag { width: 100%; aspect-ratio: 3 / 2; border-radius: 10px; overflow: hidden; box-shadow: 0 0 0 1px rgba(255,255,255,.1), 0 8px 18px rgba(0,0,0,.3); }
.lang-opt__flag svg { display: block; width: 100%; height: 100%; }
.lang-opt__name { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; }
.lang-opt__sub { display: block; margin-top: -8px; font-size: 11.5px; color: var(--muted-on-dark); }
.lang-opt__check { position: absolute; top: 22px; left: 22px; width: 22px; height: 22px; border-radius: 50%; background: var(--accent); color: var(--accent-ink); display: none; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,.4); }
.lang-opt__check svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 3; fill: none; }
.lang-opt input:checked ~ .lang-opt__check { display: flex; }

.lang-opt__play { position: absolute; top: 22px; right: 22px; width: 32px; height: 32px; border: none; border-radius: 50%; background: rgba(0,0,0,.6); color: #fff; display: grid; place-items: center; cursor: pointer; backdrop-filter: blur(6px); transition: transform .12s ease, background .15s ease; }
.lang-opt__play:hover { background: var(--accent); color: var(--accent-ink); transform: scale(1.08); }
.lang-opt__play svg { width: 14px; height: 14px; fill: currentColor; }
.lang-opt__play .ic-stop { display: none; }
.lang-opt.is-playing .lang-opt__play { background: var(--accent); color: var(--accent-ink); }
.lang-opt.is-playing .ic-play { display: none; }
.lang-opt.is-playing .ic-stop { display: block; }

.eq { display: none; align-items: flex-end; gap: 2px; height: 12px; }
.eq i { display: block; width: 3px; border-radius: 2px; background: var(--accent); animation: eqBounce .9s ease-in-out infinite; }
.eq i:nth-child(2) { animation-delay: .2s; }
.eq i:nth-child(3) { animation-delay: .4s; }
@keyframes eqBounce { 0%, 100% { height: 3px; } 50% { height: 12px; } }
.lang-opt.is-playing .eq { display: inline-flex; }

/* ---------- Hozir chalinayotgan madhiya paneli ---------- */
.anthem-bar { display: flex; align-items: center; gap: 14px; margin-top: 16px; padding: 12px 14px; border-radius: var(--radius-md); background: var(--ink-softer); }
.anthem-bar[hidden] { display: none; }
.anthem-bar__flag { width: 42px; aspect-ratio: 3 / 2; border-radius: 6px; overflow: hidden; flex-shrink: 0; box-shadow: 0 0 0 1px rgba(255,255,255,.1); }
.anthem-bar__flag svg { display: block; width: 100%; height: 100%; }
.anthem-bar__info { flex: 1; min-width: 0; }
.anthem-bar__title { display: block; font-size: 12.5px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.anthem-bar__status { display: block; margin-top: 2px; font-size: 11px; color: var(--muted-on-dark); }
.anthem-bar__status.is-error { color: var(--danger); }
.anthem-bar__track { height: 4px; margin-top: 8px; border-radius: 999px; background: var(--line); overflow: hidden; }
.anthem-bar__track i { display: block; height: 100%; width: 0; background: var(--accent); transition: width .25s linear; }
.anthem-bar__vol { display: flex; align-items: center; gap: 8px; flex-shrink: 0; color: var(--muted-on-dark); }
.anthem-bar__vol svg { width: 16px; height: 16px; stroke: currentColor; fill: none; }
.anthem-bar__vol input { width: 80px; accent-color: var(--accent); }

.lang-toggle { display: flex; align-items: center; justify-content: space-between; gap: 18px; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--line); }
.lang-toggle strong { display: block; font-size: 13.5px; font-weight: 600; }
.lang-toggle span.lang-toggle__hint { display: block; margin-top: 3px; font-size: 12px; color: var(--muted-on-dark); line-height: 1.5; }

/* ---------- Sana va vaqt formati kartalari ---------- */
.fmt-grid { display: grid; gap: 12px; }
.fmt-grid--3 { grid-template-columns: repeat(3, 1fr); }
.fmt-grid--2 { grid-template-columns: repeat(2, 1fr); }
.fmt-opt { position: relative; display: block; cursor: pointer; }
.fmt-opt input { position: absolute; opacity: 0; width: 1px; height: 1px; }
.fmt-opt__box { display: block; height: 100%; padding: 16px; border: 2px solid var(--line); border-radius: var(--radius-md); background: var(--ink); transition: border-color .15s ease, background .15s ease, transform .15s ease; }
.fmt-opt:hover .fmt-opt__box { border-color: var(--muted-on-dark); }
.fmt-opt input:checked + .fmt-opt__box { border-color: var(--accent); background: var(--accent-soft); transform: translateY(-2px); }
.fmt-opt input:focus-visible + .fmt-opt__box { outline: 2px solid var(--accent); outline-offset: 2px; }
.fmt-opt__example { display: block; font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -0.01em; }
.fmt-opt__name { display: block; margin-top: 8px; font-size: 13px; font-weight: 700; }

.fmt-opt__chat { display: block; margin-top: 6px; font-size: 12.5px; color: var(--muted-on-dark); }
.fmt-opt__chat b { color: var(--accent); font-weight: 700; }

.fmt-opt__hint { display: block; margin-top: 3px; font-size: 11.5px; line-height: 1.5; color: var(--muted-on-dark); }
.fmt-opt__check { position: absolute; top: 12px; right: 12px; width: 20px; height: 20px; border-radius: 50%; background: var(--accent); color: var(--accent-ink); display: none; align-items: center; justify-content: center; }
.fmt-opt__check svg { width: 12px; height: 12px; stroke: currentColor; stroke-width: 3; fill: none; }
.fmt-opt input:checked ~ .fmt-opt__check { display: flex; }
.fmt-sub { margin: 0 0 12px; font-size: 12.5px; line-height: 1.55; color: var(--muted-on-dark); }

/* ---------- Jonli namuna ---------- */
.lp-chat { display: flex; flex-direction: column; gap: 8px; padding: 16px; border-radius: var(--radius-md); background: var(--ink-softer); }
.lp-date { align-self: center; padding: 4px 12px; border-radius: 999px; background: var(--ink); font-size: 11px; font-weight: 700; color: var(--muted-on-dark); }
.lp-bubble { max-width: 70%; padding: 10px 14px 8px; border-radius: 16px; font-size: 13px; line-height: 1.4; box-shadow: 0 2px 8px rgba(0,0,0,.2); }
.lp-bubble.in { align-self: flex-start; background: rgba(255,255,255,.95); color: #171817; border-bottom-left-radius: 4px; }
.lp-bubble.out { align-self: flex-end; background: var(--bubble); color: var(--bubble-ink); border-bottom-right-radius: 4px; }
.lp-bubble small { display: block; margin-top: 3px; text-align: right; font-size: 10px; opacity: .65; }

@media (max-width: 860px) {
    .lang-grid { grid-template-columns: repeat(2, 1fr); }
    .fmt-grid--3 { grid-template-columns: 1fr; }
    .fmt-grid--2 { grid-template-columns: 1fr; }
    .anthem-bar__vol { display: none; }
}






/* ---------- Maxfiylik: ixcham kartalar ---------- */
.pt-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pt-tile { display: flex; flex-direction: column; gap: 14px; padding: 14px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink); transition: border-color .15s ease; }
.pt-tile:hover { border-color: var(--muted-on-dark); }
.pt-tile:last-child:nth-child(odd) { grid-column: 1 / -1; }
.pt-tile__head { display: flex; align-items: center; gap: 12px; min-width: 0; }
.pt-tile__icon { width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--accent); }
.pt-tile__icon svg { width: 17px; height: 17px; stroke: currentColor; fill: none; }
.pt-tile__text { min-width: 0; }
.pt-tile__text strong { display: block; font-size: 13px; font-weight: 700; }
.pt-tile__text > span { display: block; margin-top: 2px; font-size: 11.5px; line-height: 1.4; color: var(--muted-on-dark); }
.pt-seg { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; padding: 3px; background: var(--ink-softer); border-radius: 999px; }
.pt-seg label { position: relative; cursor: pointer; display: block; margin: 0; line-height: 1.2; }
.pt-seg input { position: absolute; opacity: 0; width: 1px; height: 1px; }
.pt-seg span { display: flex; align-items: center; justify-content: center; height: 100%; padding: 8px 4px; border-radius: 999px; font-size: 11.5px; font-weight: 700; color: var(--muted-on-dark); transition: background .15s ease, color .15s ease; }
.pt-seg label:hover span { color: var(--paper); }
.pt-seg input:checked + span { background: var(--accent); color: var(--accent-ink); }
.pt-seg input:focus-visible + span { outline: 2px solid var(--accent); outline-offset: 2px; }

/* ---------- Tugmalar ---------- */
.btn-danger { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 999px; padding: 10px 18px; font: 700 12.5px 'Inter', sans-serif; cursor: pointer; text-decoration: none; background: rgba(241,101,101,.12); color: var(--danger); border: 1px solid rgba(241,101,101,.4); transition: background .15s ease, color .15s ease, transform .1s ease; }
.btn-danger:hover { background: var(--danger); color: #fff; }
.btn-danger:active { transform: scale(.97); }
.btn-danger svg, .pr-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; flex-shrink: 0; }
.pr-btn { white-space: nowrap; }

/* ---------- Amal qatorlari ---------- */
.pr-action { display: flex; align-items: center; gap: 14px; padding: 16px 0; border-top: 1px solid var(--line); }
.pr-action:first-of-type { border-top: none; padding-top: 2px; }
.pr-action__icon { width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--accent); }
.pr-action__icon svg { width: 19px; height: 19px; stroke: currentColor; fill: none; }
.pr-action__icon--danger { background: rgba(241,101,101,.12); color: var(--danger); }
.pr-action__text { flex: 1; min-width: 0; }
.pr-action__text strong { display: block; font-size: 13.5px; font-weight: 600; }
.pr-action__text > span { display: block; margin-top: 3px; font-size: 12px; line-height: 1.5; color: var(--muted-on-dark); }
.pr-badge { display: inline-block; margin-left: 8px; padding: 2px 9px; border-radius: 999px; font-size: 10px; font-weight: 800; vertical-align: middle; }
.pr-badge.is-on { color: var(--teal-ink); background: var(--teal); }
.pr-badge.is-off { color: var(--muted-on-dark); background: var(--ink-softer); }
.pr-count { min-width: 26px; height: 26px; padding: 0 8px; margin-left: 8px; border-radius: 999px; display: inline-grid; place-items: center; background: var(--accent-soft); color: var(--accent); font: 800 12px 'Sora', sans-serif; vertical-align: middle; }
.pr-select-sm { min-width: 150px; }
.set-card--danger { border-color: rgba(241,101,101,.3); }
.set-card--danger .set-card__title { color: var(--danger); }

@media (max-width: 860px) {
    .pt-grid { grid-template-columns: 1fr; }
    .pr-action { flex-wrap: wrap; }
}


/* ---- Ixcham variant (bildirishnoma vaqti uchun) ---- */
.fs-compact { gap: 10px; }
.fs-compact .fs-step { width: 28px; height: 28px; font-size: 16px; }
.fs-compact .fs-range { height: 6px; }
.fs-compact .fs-range::-webkit-slider-thumb { width: 18px; height: 18px; border-width: 3px; }
.fs-compact .fs-range::-moz-range-thumb { width: 12px; height: 12px; border-width: 3px; }











/* ---- Yuklash progressi (upload) ---- */
.up-overlay { position: fixed; inset: 0; z-index: 10000; display: none; place-items: center; background: rgba(0,0,0,.35); }
.up-overlay.is-open { display: grid; }
.up-card { width: min(300px, calc(100vw - 32px)); padding: 14px 16px; border-radius: var(--radius-md); background: var(--ink-soft); border: 1px solid var(--line); box-shadow: 0 12px 32px rgba(0,0,0,.4); color: var(--paper); font-family: 'Inter', sans-serif; }
.up-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 10px; }
.up-title { font: 700 12.5px 'Inter', sans-serif; }
.up-pct { font: 700 12.5px 'Inter', sans-serif; color: var(--accent); }
.up-bar { height: 6px; border-radius: 999px; background: var(--ink-softer); overflow: hidden; }
.up-bar i { display: block; height: 100%; width: 0; border-radius: 999px; background: var(--accent); transition: width .2s ease; }
.up-bar.is-busy i { animation: upPulse 1.1s ease-in-out infinite; }
@keyframes upPulse { 0%,100% { opacity: .55; } 50% { opacity: 1; } }
.up-info { display: flex; justify-content: space-between; gap: 10px; margin-top: 8px; font-size: 11.5px; color: var(--muted-on-dark); }
.up-info b { color: var(--paper); font-weight: 700; }
.up-msg { margin: 10px 0 0; font-size: 11.5px; line-height: 1.5; color: var(--muted-on-dark); }
.up-msg.is-error { color: var(--danger); }
.up-actions { display: flex; justify-content: flex-end; margin-top: 10px; }
.up-actions .btn-ghost { padding: 6px 12px; font-size: 11.5px; }
















/* ================= DAM OLISH VAQTI (v2) ================= */
.qh-hero { display:flex; align-items:center; gap:16px; padding:20px; margin-bottom:14px; border:1px solid var(--line); border-radius:var(--radius-lg); background:linear-gradient(135deg,var(--accent-soft),var(--ink-soft) 70%); transition:background .25s ease, border-color .25s ease; }
.qh-hero__icon { width:52px; height:52px; border-radius:15px; background:var(--accent); color:var(--accent-ink); display:grid; place-items:center; flex-shrink:0; transition:background .25s ease, color .25s ease; }
.qh-hero__icon svg { width:24px; height:24px; stroke:currentColor; fill:none; stroke-width:2; stroke-linecap:round; stroke-linejoin:round; }
.qh-hero__text { flex:1; min-width:0; }
.qh-hero__text strong { display:block; font:800 15px 'Sora',sans-serif; }
.qh-hero__text span { display:block; margin-top:4px; font-size:12.5px; color:var(--muted-on-dark); line-height:1.5; }
.qh-hero.is-quiet { background:linear-gradient(135deg,rgba(224,168,62,.16),var(--ink-soft) 70%); border-color:rgba(224,168,62,.35); }
.qh-hero.is-quiet .qh-hero__icon { background:#e0a83e; color:#1c1206; }
.qh-hero.is-off .qh-hero__icon { background:var(--ink-softer); color:var(--muted-on-dark); }
.qh-hero.is-off { background:var(--ink-soft); }

.qh-body { transition:opacity .2s ease; }
.qh-body.is-disabled { opacity:.45; pointer-events:none; }

.qh-presets { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:22px; }
.qh-preset { border:1px solid var(--line); background:var(--ink); color:var(--muted-on-dark); border-radius:999px; padding:8px 14px; font:700 12px 'Inter',sans-serif; cursor:pointer; transition:all .15s ease; }
.qh-preset small { margin-left:6px; font-weight:600; opacity:.75; }
.qh-preset:hover { color:var(--paper); border-color:var(--muted-on-dark); }
.qh-preset.active { background:var(--accent); color:var(--accent-ink); border-color:var(--accent); }

/* 24 soatlik chiziq */
.qh-tl { padding:30px 10px 0; }
.qh-tl__track { position:relative; height:46px; border-radius:12px; background:repeating-linear-gradient(135deg,var(--ink-softer) 0 8px,var(--ink) 8px 16px); border:1px solid var(--line); touch-action:none; }
.qh-tl__seg { position:absolute; top:0; bottom:0; background:var(--accent-soft); border-top:2px solid var(--accent); border-bottom:2px solid var(--accent); }
.qh-tl__seg[hidden] { display:none; }
.qh-tl__now { position:absolute; top:-7px; bottom:-7px; width:2px; background:var(--teal); border-radius:2px; transform:translateX(-50%); pointer-events:none; z-index:2; }
.qh-tl__now::before { content:''; position:absolute; top:-3px; left:50%; width:8px; height:8px; margin-left:-4px; border-radius:50%; background:var(--teal); }
.qh-tl__handle { position:absolute; top:-8px; width:18px; height:62px; transform:translateX(-50%); border:none; border-radius:9px; background:var(--accent); cursor:ew-resize; padding:0; z-index:3; box-shadow:0 3px 10px rgba(0,0,0,.4); touch-action:none; transition:transform .12s ease; }
.qh-tl__handle::after { content:''; position:absolute; left:50%; top:50%; width:2px; height:22px; margin:-11px 0 0 -1px; border-radius:2px; background:var(--accent-ink); opacity:.55; }
.qh-tl__handle:hover, .qh-tl__handle.is-drag { transform:translateX(-50%) scale(1.08); }
.qh-tl__handle:focus-visible { outline:2px solid var(--paper); outline-offset:2px; }
.qh-tl__tip { position:absolute; bottom:calc(100% + 6px); left:50%; transform:translateX(-50%); padding:3px 8px; border-radius:7px; background:var(--ink-softer); border:1px solid var(--line); color:var(--paper); font:700 11px 'Inter',sans-serif; white-space:nowrap; pointer-events:none; }
.qh-tl__ticks { display:flex; justify-content:space-between; margin-top:10px; font-size:10.5px; font-weight:700; color:var(--muted-on-dark); }
.qh-tl__legend { display:flex; flex-wrap:wrap; gap:16px; margin-top:14px; font-size:11.5px; color:var(--muted-on-dark); }
.qh-tl__legend span { display:inline-flex; align-items:center; gap:6px; }
.qh-tl__legend i { width:10px; height:10px; border-radius:3px; display:inline-block; }

.qh-fields { display:flex; align-items:flex-end; gap:16px; flex-wrap:wrap; margin-top:22px; padding-top:20px; border-top:1px solid var(--line); }
.qh-sum { display:flex; gap:10px; margin-left:auto; flex-wrap:wrap; }
.qh-sum div { padding:9px 14px; border-radius:var(--radius-sm); background:var(--ink-softer); text-align:center; min-width:96px; }
.qh-sum b { display:block; font:800 14px 'Sora',sans-serif; }
.qh-sum span { display:block; margin-top:2px; font-size:10.5px; color:var(--muted-on-dark); }

.qh-chips { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
.qh-chip { border:1px solid var(--line); background:transparent; color:var(--muted-on-dark); border-radius:999px; padding:6px 12px; font:600 11.5px 'Inter',sans-serif; cursor:pointer; transition:all .15s ease; }
.qh-chip:hover { color:var(--paper); border-color:var(--accent); background:var(--accent-soft); }
.qh-msg-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; }
.qh-msg-head .set-card__title { margin:0; }
.qh-count { font-size:11px; font-weight:700; color:var(--muted-on-dark); }
@media (max-width:860px) { .qh-sum { margin-left:0; } }


















/* ================= XOTIRA (v3) ================= */
.sg-hero { display: grid; grid-template-columns: 190px minmax(0, 1fr); gap: 26px; align-items: center; }
.sg-ring { position: relative; width: 190px; height: 190px; }
.sg-ring svg { width: 100%; height: 100%; transform: rotate(-90deg); }
.sg-ring circle { fill: none; stroke-width: 11; transition: stroke-dasharray .5s ease, stroke-dashoffset .5s ease; }
.sg-ring circle.bg { stroke: var(--ink-softer); }
.sg-ring__c { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
.sg-ring__c b { font: 800 24px 'Sora', sans-serif; letter-spacing: -.02em; }
.sg-ring__c span { margin-top: 3px; font-size: 11.5px; color: var(--muted-on-dark); }
.sg-cats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.sg-cat { --c: #888; position: relative; text-align: left; cursor: pointer; padding: 13px; border: 1.5px solid var(--line); border-radius: var(--radius-md); background: var(--ink); color: inherit; font-family: inherit; transition: border-color .15s ease, background .15s ease, transform .15s ease; }
.sg-cat:hover { transform: translateY(-2px); border-color: var(--c); }
.sg-cat.active { border-color: var(--c); background: color-mix(in srgb, var(--c) 13%, transparent); }
.sg-cat__ic { width: 30px; height: 30px; border-radius: 9px; display: grid; place-items: center; background: color-mix(in srgb, var(--c) 18%, transparent); color: var(--c); margin-bottom: 10px; }
.sg-cat__ic svg { width: 16px; height: 16px; stroke: currentColor; fill: none; }
.sg-cat b { display: block; font: 800 15px 'Sora', sans-serif; }
.sg-cat span { display: block; margin-top: 2px; font-size: 11.5px; color: var(--muted-on-dark); }
.sg-cat em { position: absolute; top: 12px; right: 12px; font-style: normal; font-size: 10.5px; font-weight: 800; color: var(--c); }
.sg-hint { margin: 18px 0 0; padding: 12px 14px; border-radius: var(--radius-sm); background: var(--ink-softer); font-size: 12px; line-height: 1.55; color: var(--muted-on-dark); }

.sg-toolbar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 16px; }
.sg-search { flex: 1 1 200px; display: flex; align-items: center; gap: 8px; padding: 0 13px; border: 1px solid var(--line); border-radius: 999px; background: var(--ink-softer); }
.sg-search:focus-within { border-color: var(--accent); }
.sg-search svg { width: 15px; height: 15px; color: var(--muted-on-dark); flex-shrink: 0; }
.sg-search input { flex: 1; min-width: 0; border: none; outline: none; background: transparent; color: var(--paper); font: 500 12.5px 'Inter', sans-serif; padding: 10px 0; }
.sg-toolbar .btn-ghost.is-busy svg { animation: sgSpin 1s linear infinite; }
@keyframes sgSpin { to { transform: rotate(360deg); } }

.sg-list { display: flex; flex-direction: column; gap: 8px; }
.sg-empty { padding: 34px 16px; text-align: center; font-size: 12.5px; color: var(--muted-on-dark); border: 1.5px dashed var(--line); border-radius: var(--radius-md); }
.sg-src { border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink); overflow: hidden; transition: border-color .15s ease; }
.sg-src.open { border-color: var(--accent); }
.sg-src__head { width: 100%; display: grid; grid-template-columns: 44px minmax(0, 1.2fr) minmax(90px, 1fr) auto 16px; gap: 14px; align-items: center; padding: 12px 14px; border: none; background: transparent; color: inherit; font-family: inherit; text-align: left; cursor: pointer; }
.sg-src__head:hover { background: var(--accent-soft); }
.sg-av { width: 44px; height: 44px; border-radius: 50%; overflow: hidden; display: grid; place-items: center; color: #fff; font: 700 15px 'Sora', sans-serif; flex-shrink: 0; }
.sg-av img { width: 100%; height: 100%; object-fit: cover; }
.sg-av svg { width: 20px; height: 20px; stroke: #fff; fill: none; }
.sg-src__name { display: flex; align-items: center; gap: 8px; min-width: 0; font-size: 13.5px; font-weight: 700; }
.sg-src__name span.n { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sg-badge { flex-shrink: 0; padding: 2px 8px; border-radius: 999px; font-size: 9.5px; font-weight: 800; text-transform: uppercase; letter-spacing: .04em; background: var(--ink-softer); color: var(--muted-on-dark); }
.sg-src__meta { margin-top: 3px; font-size: 11.5px; color: var(--muted-on-dark); }
.sg-stack { display: flex; gap: 2px; height: 8px; border-radius: 999px; overflow: hidden; background: var(--ink-softer); }
.sg-stack i { display: block; height: 100%; min-width: 3px; }
.sg-size { font: 800 13.5px 'Sora', sans-serif; white-space: nowrap; text-align: right; }
.sg-chev { width: 16px; height: 16px; stroke: var(--muted-on-dark); fill: none; transition: transform .2s ease; }
.sg-src.open .sg-chev { transform: rotate(90deg); }
.sg-src__body { padding: 4px 14px 16px; border-top: 1px solid var(--line); }
.sg-tabs { display: flex; flex-wrap: wrap; gap: 6px; margin: 12px 0; }
.sg-tab { border: 1px solid var(--line); background: transparent; color: var(--muted-on-dark); padding: 6px 12px; border-radius: 999px; font: 700 11.5px 'Inter', sans-serif; cursor: pointer; }
.sg-tab:hover { color: var(--paper); }
.sg-tab.active { background: var(--accent); border-color: var(--accent); color: var(--accent-ink); }
.sg-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; }
.sg-thumb { position: relative; aspect-ratio: 1; border-radius: 10px; overflow: hidden; background: var(--ink-softer); display: block; }
.sg-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .2s ease; }
.sg-thumb:hover img { transform: scale(1.06); }
.sg-thumb span { position: absolute; left: 5px; bottom: 5px; padding: 2px 6px; border-radius: 8px; background: rgba(0,0,0,.6); color: #fff; font-size: 10px; font-weight: 700; }
.sg-files { display: flex; flex-direction: column; }
.sg-file { display: flex; align-items: center; gap: 12px; padding: 9px 8px; border-radius: 10px; color: inherit; text-decoration: none; }
.sg-file:hover { background: var(--accent-soft); }
.sg-file__ic { width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: grid; place-items: center; color: #fff; font: 800 10.5px 'Inter', sans-serif; text-transform: uppercase; }
.sg-file__ic svg { width: 18px; height: 18px; stroke: #fff; fill: none; }
.sg-file__t { flex: 1; min-width: 0; }
.sg-file__t b { display: block; font-size: 12.5px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.sg-file__t span { display: block; margin-top: 2px; font-size: 11px; color: var(--muted-on-dark); }
.sg-file__ok { display: inline-flex; align-items: center; gap: 4px; color: var(--teal); font-size: 10.5px; font-weight: 700; flex-shrink: 0; }
.sg-file__ok svg { width: 12px; height: 12px; stroke: currentColor; fill: none; stroke-width: 3; }
.sg-more { display: block; margin: 10px auto 0; }
@media (max-width: 860px) {
    .sg-hero { grid-template-columns: 1fr; justify-items: center; }
    .sg-cats { grid-template-columns: repeat(2, 1fr); width: 100%; }
    .sg-src__head { grid-template-columns: 40px minmax(0, 1fr) auto 16px; }
    .sg-stack { display: none; }
    .sg-grid { grid-template-columns: repeat(3, 1fr); }
}







.set-nav__footer a { text-decoration:none; }
.set-nav__footer a:hover { color:var(--paper); text-decoration:underline; }


</style>

@php
    $theme        = $settings['theme'] ?? 'dark';
    $accentColor  = $settings['accent_color'] ?? 'default';
$accentCustomColor = $settings['accent_custom_color'] ?? '#e0a83e';
    $density      = $settings['density'] ?? 'comfortable';
    $fontSize     = $settings['font_size'] ?? 15;
    $wallType     = $settings['wallpaper_type'] ?? 'gradient';
    $wallGradient = $settings['wallpaper_gradient'] ?? 'sunset';
    $wallColor    = $settings['wallpaper_color'] ?? '#1d1d17';
    $wallColorMid    = $settings['wallpaper_color_mid'] ?? '#302b63';
$wallColorBottom = $settings['wallpaper_color_bottom'] ?? '#0f0c29';
$wallColorStyle  = $settings['wallpaper_color_style'] ?? 'v';
    $wallBlur     = !empty($settings['wallpaper_blur']);
    $wallCurrentUrl = $settings['wallpaper_current_url'] ?? null;

    $wallImageUrl = $settings['wallpaper_image_url'] ?? ($wallType === 'image' ? $wallCurrentUrl : null);
$wallVideoUrl = $settings['wallpaper_video_url'] ?? ($wallType === 'video' ? $wallCurrentUrl : null);
$wallVideoX   = $settings['wallpaper_video_x'] ?? 50;
$wallVideoY   = $settings['wallpaper_video_y'] ?? 50;

    // Tinch soatlar (Dam olish vaqti) — birinchi marta kirgan foydalanuvchi
    // uchun standart holatda YOQILGAN bo'lishi kerak, shu sababli faqat
    // massivda maydon mavjud bo'lsagina uning qiymatiga qaraymiz.
    $quietHoursEnabled = array_key_exists('quiet_hours_enabled', $settings ?? [])
        ? !empty($settings['quiet_hours_enabled'])
        : true;
    $quietStart   = $settings['quiet_hours_start'] ?? '06:00';
    $quietEnd     = $settings['quiet_hours_end'] ?? '22:00';
    $quietMessage = $settings['quiet_hours_message'] ?? "Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙";
    $notifPosition = $settings['notif_position'] ?? 'bottom-right';
$notifStyle    = $settings['notif_style'] ?? 'card';
$notifDuration = $settings['notif_duration'] ?? 6;
@endphp

<div class="settings-app" id="setPage">

    {{-- ============================================================ --}}
    {{-- CHAP: NAVIGATSIYA --}}
    {{-- ============================================================ --}}
    <aside class="set-nav">
        <div class="set-nav__top">
            <a class="set-nav__back" href="{{ route('home') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Chatlarga qaytish
            </a>
            <h1 class="set-nav__title">Sozlamalar</h1>
           <div class="set-nav__user">
    <span class="set-nav__avatar">
        @if (auth()->user()->avatar ?? false)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
        @else
            {{ strtoupper(substr(auth()->user()->name ?? 'F', 0, 1)) }}
        @endif
    </span>
    <span class="set-nav__user-info">
        <b>{{ auth()->user()->name ?? 'Foydalanuvchi' }}</b>
    </span>
</div>

<a href="{{ route('profile.edit') }}" class="set-nav__profile-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
    Profilni ko'rish
</a>
        </div>

        <nav class="set-nav__list" id="navList">
            <div class="set-nav__group-label">Shaxsiylashtirish</div>
            <button type="button" class="set-nav-item active" data-target="sec-appearance">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"></path></svg></span>
                <span class="set-nav-item__text">Ko'rinish<span>Tema, rang, shrift</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <button type="button" class="set-nav-item" data-target="sec-wallpaper">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg></span>
                <span class="set-nav-item__text">Chat foni<span>Rasm, video, gradient</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <div class="set-nav__group-label">Xabarlar</div>
            <button type="button" class="set-nav-item" data-target="sec-notifications">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
                <span class="set-nav-item__text">Bildirishnomalar<span>Ovoz, ko'rinish, chat</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <button type="button" class="set-nav-item" data-target="sec-quiet-hours">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg></span>
                <span class="set-nav-item__text">Dam olish vaqti<span>Tinch soatlar, eslatma</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <div class="set-nav__group-label">Xavfsizlik</div>
            <button type="button" class="set-nav-item" data-target="sec-privacy">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-4"></path></svg></span>
                <span class="set-nav-item__text">Maxfiylik<span>Profil, onlayn, 2FA</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            <button type="button" class="set-nav-item" data-target="sec-storage">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5v14a9 3 0 0 0 18 0V5"></path><path d="M3 12a9 3 0 0 0 18 0"></path></svg></span>
                <span class="set-nav-item__text">Xotira<span>Kesh, avto-yuklash</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <div class="set-nav__group-label">Umumiy</div>
            <button type="button" class="set-nav-item" data-target="sec-language">
                <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"></path></svg></span>
                <span class="set-nav-item__text">Til va mintaqa<span>Til, sana formati</span></span>
                <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>


            <button type="button" class="set-nav-item" data-target="sec-whatsnew">
    <span class="set-nav-item__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9Z"></path><path d="M19 3v4M17 5h4"></path></svg></span>
    <span class="set-nav-item__text">Yangiliklar<span>Versiya va rejalar</span></span>
    <svg class="set-nav-item__chevron" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
</button>
        </nav>

        <div class="set-nav__footer">
            <b>ChatO'VBS Desktop</b>
            <span><a href="#" onclick="document.querySelector('[data-target=sec-whatsnew]').click();return false;" style="color:inherit;">Versiya 1.0.0 · Yangiliklar</a></span>
        </div>
    </aside>

    {{-- ============================================================ --}}
    {{-- O'RTA: KONTENT --}}
    {{-- ============================================================ --}}
    <div class="set-content">
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="set-form" id="settingsForm">
            @csrf
            @method('PATCH')

            <div class="set-topbar">
                <h2 id="topbarTitle">Ko'rinish</h2>
                <div style="display:flex; align-items:center; gap:12px;">
                    @if (session('status'))
                        <span class="status-pill"><svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>{{ session('status') }}</span>
                    @endif
                    <button type="button" class="theme-quick-btn" id="quickThemeToggle" title="Qora/oq fonni almashtirish">
                        <svg id="quickThemeIconMoon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"></path></svg>
                        <svg id="quickThemeIconSun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><circle cx="12" cy="12" r="4"></circle><line x1="12" y1="1.5" x2="12" y2="4"></line><line x1="12" y1="20" x2="12" y2="22.5"></line><line x1="3.5" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="20.5" y2="12"></line><line x1="5.6" y1="5.6" x2="7.4" y2="7.4"></line><line x1="16.6" y1="16.6" x2="18.4" y2="18.4"></line><line x1="5.6" y1="18.4" x2="7.4" y2="16.6"></line><line x1="16.6" y1="7.4" x2="18.4" y2="5.6"></line></svg>
                        <span id="quickThemeLabel">Qorong'i</span>
                    </button>
                    <button type="reset" class="btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        Asliga qaytarish
                    </button>
                    <button type="submit" class="btn-solid">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Saqlash
                    </button>
                </div>
            </div>

            <div class="set-scroll" id="scrollArea">

                {{-- ===================== 1) KO'RINISH ===================== --}}
                <section class="set-section" id="sec-appearance">
                    <div class="set-section__head">
                        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"></path></svg></span>
                        <div><h3>Ko'rinish</h3><p>Ilovaning tema rangi, aksent rang, shrift o'lchami — tanlaganingiz o'ngdagi jonli ko'rinishda darhol aks etadi.</p></div>
                    </div>

                    <div class="set-card">
                        <p class="set-card__title">Tema</p>
                        <div class="set-theme-grid">
                            <label class="set-theme-opt">
                                <input type="radio" name="theme" value="dark" {{ $theme === 'dark' ? 'checked' : '' }}>
                                <span class="set-theme-opt__swatch set-theme-opt__dark"><i></i><i></i></span>
                                <span class="set-theme-opt__label">Qorong'i</span>
                            </label>
                            <label class="set-theme-opt">
                                <input type="radio" name="theme" value="light" {{ $theme === 'light' ? 'checked' : '' }}>
                                <span class="set-theme-opt__swatch set-theme-opt__light"><i></i><i></i></span>
                                <span class="set-theme-opt__label">Yorug'</span>
                            </label>
                            <label class="set-theme-opt">
                                <input type="radio" name="theme" value="system" {{ $theme === 'system' ? 'checked' : '' }}>
                                <span class="set-theme-opt__swatch set-theme-opt__system"><i></i><i></i></span>
                                <span class="set-theme-opt__label">Tizim bo'yicha</span>
                            </label>
                        </div>
                    </div>

                       <div class="set-card">
    <p class="set-card__title">Aksent rang</p>
    <div class="set-accent-grid">
               <label class="set-accent-opt set-accent-opt--default">
            <input type="radio" name="accent_color" value="default" {{ $accentColor === 'default' ? 'checked' : '' }}>
            <span class="set-accent-opt__dot" style="--dot-color: #0a0a0a"><svg class="set-accent-opt__check" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            <span class="set-accent-opt__name">Standart</span>
        </label>

        @foreach ([['amber','#e0a83e','Amber'],['teal','#2dd4bf','Teal'],['blue','#4b9bea',"Ko'k"],['violet','#a78bfa','Binafsha'],['rose','#f472b6','Pushti'],['green','#34d399','Yashil']] as $opt)
            <label class="set-accent-opt">
                <input type="radio" name="accent_color" value="{{ $opt[0] }}" {{ $accentColor === $opt[0] ? 'checked' : '' }}>
                <span class="set-accent-opt__dot" style="--dot-color: {{ $opt[1] }}"><svg class="set-accent-opt__check" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                <span class="set-accent-opt__name">{{ $opt[2] }}</span>
            </label>
        @endforeach

        <label class="set-accent-opt" id="accentCustomLabel">
            <input type="radio" name="accent_color" value="custom" id="accentCustomRadio" {{ $accentColor === 'custom' ? 'checked' : '' }}>
            <span class="set-accent-opt__dot set-accent-opt__dot--custom" id="accentCustomDot" style="--dot-color: {{ $accentCustomColor }}">
                <svg class="set-accent-opt__check" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <svg class="set-accent-opt__plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            </span>
            <span class="set-accent-opt__name">O'zim tanlayman</span>
        </label>
    </div>

    {{-- Doim ochiq rang tanlagich --}}
    <div class="color-picker" id="colorPicker">
        <div class="color-picker__sv" id="colorSV">
            <canvas id="colorSVCanvas" width="360" height="170"></canvas>
            <div class="color-picker__sv-thumb" id="colorSVThumb"></div>
        </div>
        <div class="color-picker__side">
            <div class="color-picker__row">
                <button type="button" class="color-picker__eyedrop" id="colorEyedrop" title="Ekrandan rang olish">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 22 1-1h3l9-9"></path><path d="M3 21v-3l9-9"></path><path d="m15 6 3.4-3.4a2.1 2.1 0 1 1 3 3L18 9l.4.4a2.1 2.1 0 1 1-3 3l-3.8-3.8a2.1 2.1 0 1 1 3-3Z"></path></svg>
                </button>
                <span class="color-picker__swatch" id="colorSwatch"></span>
                <div class="color-picker__hue" id="colorHue"><div class="color-picker__hue-thumb" id="colorHueThumb"></div></div>
            </div>
            <div class="color-picker__fields">
                <label><input type="text" inputmode="numeric" id="colorInputR" value="224"><span>R</span></label>
                <label><input type="text" inputmode="numeric" id="colorInputG" value="168"><span>G</span></label>
                <label><input type="text" inputmode="numeric" id="colorInputB" value="62"><span>B</span></label>
            </div>
            <div class="color-picker__hex">
                <input type="text" id="colorInputHex" maxlength="7" value="{{ $accentCustomColor }}" spellcheck="false">
                <span>HEX</span>
            </div>
        </div>
    </div>

    <input type="hidden" id="accentCustomColorInput" name="accent_custom_color" value="{{ $accentCustomColor }}">
</div>
                                     <div class="set-card">
                        <p class="set-card__title">Interfeys zichligi</p>
                        <div class="density-grid">
                            <label class="density-opt">
                                <input type="radio" name="density" value="comfortable" {{ $density === 'comfortable' ? 'checked' : '' }}>
                                <span class="density-opt__box">
                                    <span class="density-opt__mini density-opt__mini--comfortable"><i></i><i></i><i></i></span>
                                    <span class="density-opt__name">Keng</span>
                                    <span class="density-opt__hint">Xabarlar orasida ko'proq bo'shliq</span>
                                </span>
                                <span class="density-opt__check"><svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                            </label>
                            <label class="density-opt">
                                <input type="radio" name="density" value="compact" {{ $density === 'compact' ? 'checked' : '' }}>
                                <span class="density-opt__box">
                                    <span class="density-opt__mini density-opt__mini--compact"><i></i><i></i><i></i></span>
                                    <span class="density-opt__name">Ixcham</span>
                                    <span class="density-opt__hint">Ekranga ko'proq xabar sig'adi</span>
                                </span>
                                <span class="density-opt__check"><svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                            </label>
                        </div>
                    </div>

                                   <div class="set-card">
                        <div class="fs-head">
                            <p class="set-card__title" style="margin:0;">Matn o'lchami</p>
                            <span class="fs-value" id="fontSizePreview">{{ $fontSize }}px</span>
                        </div>
                        <div class="fs-slider-row">
                            <button type="button" class="fs-step" id="fsMinus" aria-label="Kichraytirish">−</button>
                            <input type="range" class="fs-range" name="font_size" min="13" max="19" step="1" value="{{ $fontSize }}" id="fontSizeRange">
                            <button type="button" class="fs-step" id="fsPlus" aria-label="Kattalashtirish">+</button>
                        </div>

                        <div class="fs-chat" id="fontSizeSample">
                            <div class="fs-bubble in">Salom! Yangi dizayn menga yoqdi 👋<span class="fs-bubble__time">10:24</span></div>
                            <div class="fs-bubble out"><span id="fsOutText">Rahmat! Fon va ranglarni sinab ko'ring 🎨</span><span class="fs-bubble__time">10:25 ✓✓</span></div>
                        </div>
                        <div class="fs-try">
                            <label for="fsTryInput">O'z matningizni yozib ko'ring</label>
                            <input type="text" id="fsTryInput" placeholder="Bu yerga yozing, tepada chatdagidek ko'rinadi..." maxlength="120" autocomplete="off">
                        </div>
                    </div>
                </section>

                {{-- ===================== 2) CHAT FONI ===================== --}}
                <section class="set-section" id="sec-wallpaper">
                    <div class="set-section__head">
                        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg></span>
                        <div><h3>Chat foni</h3><p>Suhbat oynasi orqa foniga tayyor gradient, bitta rang, o'z rasmingiz yoki hattoki video qo'ying.</p></div>
                    </div>

                    <div class="set-card">
                        <div class="set-wall-tabs" id="wallTabs">
                            <button type="button" class="set-wall-tab" data-tab="gradient">Gradientlar</button>
                            <button type="button" class="set-wall-tab" data-tab="color">Rang</button>
                            <button type="button" class="set-wall-tab" data-tab="image">Rasm</button>
                            <button type="button" class="set-wall-tab" data-tab="video">Video</button>
                        </div>
                        <input type="hidden" name="wallpaper_type" id="wallpaperTypeInput" value="{{ $wallType }}">

                                          <div class="set-wall-pane" data-pane="gradient">
                            <p class="set-wall-hint">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11V6a3 3 0 0 1 6 0v5"></path><path d="M6 11h12l-1 9H7z"></path></svg>
                                <span>Yoqqan rangni <b>bosib tanlang</b>, natijani o'ngdagi jonli ko'rinishda ko'rasiz.</span>
                            </p>
                            <div class="set-wall-grid">
                                @foreach ([['sunset','wp-sunset',"Quyosh botishi"],['mint','wp-mint','Yalpiz'],['dusk','wp-dusk',"G'ira-shira"],['berry','wp-berry','Malina'],['forest','wp-forest',"O'rmon"],['amber','wp-amber','Amber'],['ocean','wp-ocean','Okean'],['mono','wp-mono','Mono'],['candy','wp-candy','Konfet'],['night','wp-night','Tun'],['lime','wp-lime','Laym'],['rose','wp-rose','Atirgul']] as $g)
                                    <label class="set-wall-opt" title="{{ $g[2] }}">
                                        <input type="radio" name="wallpaper_gradient" value="{{ $g[0] }}" {{ $wallGradient === $g[0] ? 'checked' : '' }} data-wall-radio="gradient">
                                        <span class="set-wall-opt__thumb {{ $g[1] }}"></span>
                                        <span class="set-wall-opt__name">{{ $g[2] }}</span>
                                        <span class="set-wall-opt__check"><svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

            <div class="set-wall-pane" data-pane="color">
    <input type="hidden" name="wallpaper_color" id="wallColorInput" value="{{ $wallColor }}">
    <input type="hidden" name="wallpaper_color_mid" id="wallColorMidInput" value="{{ $wallColorMid }}">
    <input type="hidden" name="wallpaper_color_bottom" id="wallColorBottomInput" value="{{ $wallColorBottom }}">
    <input type="hidden" name="wallpaper_color_style" id="wallColorStyleInput" value="{{ $wallColorStyle }}">

    <div class="cs-layout">
        <div class="cs-stage">
            <div class="cs-stage__bg" id="csStageBg"></div>
            @foreach ([['top','Tepa'],['mid',"O'rta"],['bottom','Past']] as $z)
                <button type="button" class="cs-zone" data-zone="{{ $z[0] }}">
                    <span class="cs-chip"><i></i><b>{{ $z[1] }}</b><em></em></span>
                </button>
            @endforeach
        </div>

        <div class="cs-editor">
            <p class="cs-editor__title">Tahrirlanmoqda: <b id="csEditName">Tepa</b> — chapdagi zonalardan birini bosib almashtiring</p>
            <div class="cs-sv" id="csSV"><canvas id="csCanvas" width="400" height="150"></canvas><div class="cs-sv__thumb" id="csSVThumb"></div></div>
            <div class="cs-hue" id="csHue"><div class="cs-hue__thumb" id="csHueThumb"></div></div>
            <div class="cs-hexrow">
                <input type="text" id="csHexInput" maxlength="7" spellcheck="false">
                <span style="font-size:10px;color:var(--muted-on-dark);font-weight:700;">HEX</span>
            </div>
            <div class="cs-seg" id="csStyleSeg">
                <button type="button" data-style="v">Vertikal</button>
                <button type="button" data-style="d">Diagonal</button>
                <button type="button" data-style="h">Gorizontal</button>
                <button type="button" data-style="r">Radial</button>
            </div>
            <div class="cs-actions">
                <button type="button" class="btn-ghost" id="csRandom">Tasodifiy</button>
                <button type="button" class="btn-ghost" id="csSwap">Teskari</button>
            </div>
        </div>
    </div>

    <p class="cs-palettes-title">Tayyor palitralar</p>
    <div class="cs-palettes" id="csPalettes"></div>
</div>

     <div class="set-wall-pane" data-pane="image">
    <input type="file" name="wallpaper_image" id="wallImageInput" accept="image/png,image/jpeg,image/webp" class="set-file-hidden">
    <div id="wallImageRoot"></div>
</div>

<div class="set-wall-pane" data-pane="video">
    <input type="file" name="wallpaper_video" id="wallVideoInput" accept="video/mp4,video/webm" class="set-file-hidden">
    <div id="wallVideoRoot"></div>
</div>
                        <div class="set-blur-row">
                            <div class="set-row__text"><strong>Fonni xiralashtirish</strong><span>Band rasm/videolarda matn yaxshiroq o'qilishi uchun yumshoq xira effekt</span></div>
                            <label class="set-switch"><input type="checkbox" name="wallpaper_blur" value="1" id="wallBlurToggle" {{ $wallBlur ? 'checked' : '' }}><span class="set-switch__track"></span></label>
                        </div>
                    </div>
                </section>

                {{-- ===================== 3) BILDIRISHNOMALAR ===================== --}}
               <section class="set-section" id="sec-notifications">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
        <div><h3>Bildirishnomalar</h3><p>Yangi xabar kelganda ekranning qayerida, qanday ko'rinishda va qancha vaqt chiqishini o'zingiz belgilang.</p></div>
    </div>

    {{-- Asosiy yoqish/o'chirish + sinab ko'rish --}}
    <div class="np-hero">
        <span class="np-hero__icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
        <div class="np-hero__text"><strong>Xabar bildirishnomalari</strong><span>Yangi xabar, chaqiruv va eslatmalar haqida ekranda ogohlantirish chiqadi.</span></div>
        <div class="np-hero__actions">
            <button type="button" class="btn-ghost" id="npTestBtn">Sinab ko'rish</button>
            <label class="set-switch"><input type="checkbox" name="notifications" value="1" id="npMaster" {{ !empty($settings['notifications']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
    </div>

    {{-- Joylashuv va uslub --}}
    <div class="set-card">
        <p class="set-card__title">Ko'rinishi va joylashuvi</p>
        <div class="np-layout">
            <div>
                <div class="np-screen">
                    <div class="np-screen__win"></div>
                    <div class="np-screen__bar"></div>
                    @foreach ([['top-left','tl'],['top-center','tc'],['top-right','tr'],['bottom-left','bl'],['bottom-center','bc'],['bottom-right','br']] as $p)
                        <label class="np-zone np-zone--{{ $p[1] }}">
                            <input type="radio" name="notif_position" value="{{ $p[0] }}" {{ $notifPosition === $p[0] ? 'checked' : '' }}>
                            <span class="np-zone__toast"><i></i><b></b></span>
                        </label>
                    @endforeach
                </div>
                <p class="np-screen-hint">Ekranning kerakli joyini bosing — bildirishnoma shu yerda chiqadi</p>
            </div>

            <div class="np-side">
                <div>
                    <h4>Uslub</h4>
                    <div class="set-segmented">
                        <label><input type="radio" name="notif_style" value="card" {{ $notifStyle === 'card' ? 'checked' : '' }}><span>Karta</span></label>
                        <label><input type="radio" name="notif_style" value="compact" {{ $notifStyle === 'compact' ? 'checked' : '' }}><span>Ixcham</span></label>
                        <label><input type="radio" name="notif_style" value="minimal" {{ $notifStyle === 'minimal' ? 'checked' : '' }}><span>Minimal</span></label>
                    </div>
                </div>
              <div>
    <h4>Ekranda turish vaqti · <span id="npDurVal" style="color:var(--accent)">{{ $notifDuration }} soniya</span></h4>
  <div class="fs-slider-row fs-compact">
    <button type="button" class="fs-step" id="npDurMinus" aria-label="Kamaytirish">−</button>
    <input type="range" class="fs-range" name="notif_duration" id="npDuration" min="3" max="15" step="1" value="{{ $notifDuration }}">
    <button type="button" class="fs-step" id="npDurPlus" aria-label="Ko'paytirish">+</button>
</div>
</div>
            </div>
        </div>

        <div class="np-perm">
            <span>Tizim bildirishnomalari (sayt boshqa oynada bo'lsa ham): <b id="npPermText">—</b></span>
            <button type="button" class="btn-ghost" id="npPermBtn">Ruxsat berish</button>
        </div>
        <p class="np-note">Brauzer ochiq bo'lsa (fonda yoki boshqa ilova ustida bo'lsa ham) xabar kompyuterning o'z bildirishnomasi sifatida chiqadi. Brauzer butunlay yopiq bo'lganda ham kelishi uchun serverda Web Push (Service Worker + VAPID) sozlanishi kerak.</p>
    </div>

    {{-- Nima ko'rsatilsin --}}
    <div class="set-grid-2">
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>
            <span class="toggle-card__body"><strong>Tizim bildirishnomasi</strong><span>Boshqa oynada bo'lsangiz ham kompyuter orqali ko'rsatiladi</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="notif_system" value="1" id="npSystem" {{ !empty($settings['notif_system']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg></span>
            <span class="toggle-card__body"><strong>Bildirishnoma ovozi</strong><span>Yangi xabar kelganda qisqa signal</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="sound" id="npSound" value="1" {{ !empty($settings['sound']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></span>
            <span class="toggle-card__body"><strong>Xabar matnini ko'rsatish</strong><span>O'chirilsa faqat "Yangi xabar" deb chiqadi</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="notif_preview" id="npPreview" value="1" {{ !empty($settings['notif_preview']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
            <span class="toggle-card__body"><strong>Yuboruvchi ismi</strong><span>Kim yozganini bildirishnomada ko'rsatish</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="notif_show_sender" id="npSender" value="1" {{ ($settings['notif_show_sender'] ?? true) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg></span>
            <span class="toggle-card__body"><strong>Avatar ko'rsatish</strong><span>Yuboruvchining rasmi yoki bosh harfi</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="notif_show_avatar" id="npAvatar" value="1" {{ ($settings['notif_show_avatar'] ?? true) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span>
            <span class="toggle-card__body"><strong>Guruh bildirishnomalari</strong><span>Guruh va kanallardan xabar olish</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="group_notifications" value="1" {{ !empty($settings['group_notifications']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg></span>
            <span class="toggle-card__body"><strong>Enter bilan yuborish</strong><span>Enter bosilganda xabar yuboriladi</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="enter_to_send" value="1" {{ !empty($settings['enter_to_send']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
        <div class="toggle-card">
            <span class="toggle-card__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            <span class="toggle-card__body"><strong>O'qilganini ko'rsatish</strong><span>Xabaringiz o'qilganda ✓✓ belgisi</span></span>
            <label class="set-switch toggle-card__switch"><input type="checkbox" name="read_receipts" value="1" {{ !empty($settings['read_receipts']) ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
    </div>
</section>

                {{-- ===================== 3.5) DAM OLISH VAQTI / TINCH SOATLAR ===================== --}}
               <section class="set-section" id="sec-quiet-hours">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg></span>
        <div>
            <h3>Dam olish vaqti <span class="qh-status-pill" id="qhStatusPill"><span class="dot"></span><span id="qhStatusPillText">Yuklanmoqda…</span></span></h3>
            <p>Belgilangan soatlardan tashqarida yozishmalar yopiladi va dam olish haqida eslatma ko'rsatiladi.</p>
        </div>
    </div>

    {{-- Holat kartasi + yoqish/o'chirish --}}
    <div class="qh-hero" id="qhHero">
        <span class="qh-hero__icon"><svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"></path></svg></span>
        <div class="qh-hero__text">
            <strong id="qhHeroTitle">Yuklanmoqda…</strong>
            <span id="qhHeroSub"></span>
        </div>
        <label class="set-switch"><input type="checkbox" name="quiet_hours_enabled" value="1" id="qhEnabledToggle" {{ $quietHoursEnabled ? 'checked' : '' }}><span class="set-switch__track"></span></label>
    </div>

    <div class="qh-body" id="qhBody">
        {{-- Vaqt oralig'i --}}
        <div class="set-card" id="qhTimeCard">
            <p class="set-card__title">Yozishmalarga ruxsat berilgan vaqt</p>

            <div class="qh-presets" id="qhPresets">
                <button type="button" class="qh-preset" data-s="06:00" data-e="22:00">Standart<small>06–22</small></button>
                <button type="button" class="qh-preset" data-s="09:00" data-e="18:00">Ish vaqti<small>09–18</small></button>
                <button type="button" class="qh-preset" data-s="18:00" data-e="02:00">Kechki<small>18–02</small></button>
                <button type="button" class="qh-preset" data-s="00:00" data-e="00:00">24 soat<small>cheklovsiz</small></button>
            </div>

            <div class="qh-tl">
                <div class="qh-tl__track" id="qhTrack">
                    <div class="qh-tl__seg" id="qhSeg1"></div>
                    <div class="qh-tl__seg" id="qhSeg2" hidden></div>
                    <div class="qh-tl__now" id="qhNow" title="Hozirgi vaqt"></div>
                    <button type="button" class="qh-tl__handle" id="qhHandleS" aria-label="Boshlanish vaqti"><span class="qh-tl__tip" id="qhTipS"></span></button>
                    <button type="button" class="qh-tl__handle" id="qhHandleE" aria-label="Tugash vaqti"><span class="qh-tl__tip" id="qhTipE"></span></button>
                </div>
                <div class="qh-tl__ticks"><span>00:00</span><span>06:00</span><span>12:00</span><span>18:00</span><span>24:00</span></div>
                <div class="qh-tl__legend">
                    <span><i style="background:var(--accent)"></i>Yozishmalar ochiq</span>
                    <span><i style="background:var(--ink-softer);border:1px solid var(--line)"></i>Tinch soat</span>
                    <span><i style="background:var(--teal)"></i>Hozirgi vaqt</span>
                </div>
            </div>

            <div class="qh-fields">
                <div class="qh-time-field">
                    <label for="qhStartInput">Boshlanishi</label>
                    <input type="time" class="set-input-time" name="quiet_hours_start" id="qhStartInput" value="{{ $quietStart }}" step="900">
                </div>
                <div class="qh-arrow" style="padding-top:0;margin-bottom:12px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </div>
                <div class="qh-time-field">
                    <label for="qhEndInput">Tugashi</label>
                    <input type="time" class="set-input-time" name="quiet_hours_end" id="qhEndInput" value="{{ $quietEnd }}" step="900">
                </div>
                <div class="qh-sum">
                    <div><b id="qhSumAllow">–</b><span>Ochiq vaqt</span></div>
                    <div><b id="qhSumQuiet">–</b><span>Tinch vaqt</span></div>
                </div>
            </div>
            <p class="qh-hint" id="qhRangeHint" style="margin-top:14px;"></p>
        </div>

        {{-- Eslatma matni --}}
        <div class="set-card">
            <div class="qh-msg-head">
                <p class="set-card__title">Eslatma xabari matni</p>
                <span class="qh-count"><span id="qhCount">0</span>/180</span>
            </div>
            <textarea class="qh-msg-textarea" name="quiet_hours_message" id="qhMessageInput" maxlength="180">{{ $quietMessage }}</textarea>
            <div class="qh-chips" id="qhChips">
                <button type="button" class="qh-chip" data-t="Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙">🌙 Dam olish</button>
                <button type="button" class="qh-chip" data-t="Hozir tinch soat. Ertaga ertalab javob beraman 😊">😊 Ertaga javob</button>
                <button type="button" class="qh-chip" data-t="Ish vaqti tugadi. Shoshilinch bo'lsa qo'ng'iroq qiling 📞">📞 Shoshilinch</button>
            </div>
            <div class="qh-banner-preview">
                <span class="qh-banner-preview__icon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg></span>
                <div class="qh-banner-preview__body">
                    <strong>Dam olish vaqti</strong>
                    <span id="qhMessagePreviewText">{{ $quietMessage }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.privacy-section')

                {{-- ===================== 5) XOTIRA VA MA'LUMOTLAR ===================== --}}
    @php
    // Standart tanlovlar: Wi-Fi da hammasi, mobil internetda faqat yengil turlar
    $dlWifi   = $settings['autodownload_wifi']   ?? ['images', 'videos', 'files', 'voice', 'links'];
    $dlMobile = $settings['autodownload_mobile'] ?? ['images', 'voice', 'links'];

    $dlRows = [
        ['key' => 'images', 'label' => 'Rasmlar',        'hint' => 'Suratlar va skrinshotlar',
         'icon' => '<svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>'],
        ['key' => 'videos', 'label' => 'Videolar',       'hint' => 'Video va qisqa roliklar (trafikni ko\'p sarflaydi)',
         'icon' => '<svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>'],
        ['key' => 'files',  'label' => 'Fayllar',        'hint' => 'PDF, Word, Excel, arxivlar',
         'icon' => '<svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>'],
        ['key' => 'voice',  'label' => 'Ovozli xabarlar', 'hint' => 'Mikrofon orqali yozilgan xabarlar',
         'icon' => '<svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line></svg>'],
        ['key' => 'links',  'label' => 'Havolalar',      'hint' => 'Havola ichidagi rasm va sarlavha ko\'rinishi',
         'icon' => '<svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>'],
    ];
@endphp
 
<section class="set-section" id="sec-storage">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M3 5v14a9 3 0 0 0 18 0V5"></path><path d="M3 12a9 3 0 0 0 18 0"></path></svg></span>
        <div><h3>Xotira va ma'lumotlar</h3><p>Ilova qancha joy egallayotganini ko'ring va qaysi fayllar o'zi yuklanishini tanlang.</p></div>
    </div>
 
      {{-- ---- 1) Umumiy ko'rsatkich ---- --}}
    <div class="set-card">
        <p class="set-card__title">Xotiradan foydalanish</p>
        <div class="sg-hero">
            <div class="sg-ring">
                <svg viewBox="0 0 120 120" id="sgRing"></svg>
                <div class="sg-ring__c"><b id="sgTotal">0 MB</b><span id="sgCount">0 ta fayl</span></div>
            </div>
            <div class="sg-cats" id="sgCats"></div>
        </div>
        <p class="sg-hint">Rasm, video, fayl (Excel, PDF...), musiqa va ovozli xabarlar hajmi barcha lichka, kanal va guruhlardan yig'iladi. Xabar matnlari bu hisobga kirmaydi. Turni bosib, ro'yxatni shu tur bo'yicha filtrlashingiz mumkin.</p>
    </div>

    {{-- ---- 2) Manbalar bo'yicha ---- --}}
    <div class="set-card">
        <p class="set-card__title">Qayerdan qancha joy ketgan</p>
        <div class="sg-toolbar">
            <div class="sg-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                <input type="text" id="sgSearch" placeholder="Suhbat, kanal yoki guruh nomi" autocomplete="off">
            </div>
            <div class="set-segmented" id="sgKinds">
                <label><input type="radio" name="sg_kind" value="all" checked><span>Hammasi</span></label>
                <label><input type="radio" name="sg_kind" value="personal"><span>Lichka</span></label>
                <label><input type="radio" name="sg_kind" value="channel"><span>Kanal</span></label>
                <label><input type="radio" name="sg_kind" value="group"><span>Guruh</span></label>
                <label><input type="radio" name="sg_kind" value="saved"><span>Saqlangan</span></label>
            </div>
            <select class="set-select" id="sgSort" style="min-width:130px">
                <option value="size">Hajm bo'yicha</option>
                <option value="count">Fayl soni</option>
                <option value="name">Nomi</option>
            </select>
            <button type="button" class="btn-ghost" id="sgRescan">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                <span id="sgRescanText">Qayta hisoblash</span>
            </button>
        </div>
        <div class="sg-list" id="sgList"></div>
    </div>

    {{-- ---- 3) Kesh ---- --}}
    <div class="set-card">
        <div class="st-clear" style="margin:0;padding:0;border:none;">
            <div>
                <strong>Keshni tozalash</strong>
                <span class="st-clear__hint">Qidiruv tarixi va vaqtinchalik fayllar o'chadi, xabarlar va xotira hisobi saqlanib qoladi</span>
            </div>
            <button type="button" class="btn-ghost" id="stClearCache">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                <span id="stCacheLabel">Tozalash</span>
            </button>
        </div>
    </div>
 
    {{-- ---- 2) Media avtomatik yuklanishi ---- --}}
    <div class="set-card">
        <p class="set-card__title">Media avtomatik yuklanishi</p>
 
        <div class="dl-top">
            <p>Yoqilgan turlar chatda o'zi yuklanadi. O'chirilganlarini o'zingiz bosganda yuklab olasiz.</p>
            <div class="dl-presets" id="dlPresets">
                <button type="button" data-preset="all">Hammasi</button>
                <button type="button" data-preset="wifi">Faqat Wi-Fi</button>
                <button type="button" data-preset="none">Hech biri</button>
            </div>
        </div>
 
        <div class="dl-table">
            <div class="dl-head">
                <span class="dl-head__title">Turi</span>
                <span class="dl-head__col">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg>
                    Wi-Fi
                </span>
                <span class="dl-head__col">
                    <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                    Mobil internet
                </span>
            </div>
 
            @foreach ($dlRows as $r)
                <div class="dl-row">
                    <div class="dl-row__main">
                        <span class="dl-row__icon">{!! $r['icon'] !!}</span>
                        <span class="dl-row__text"><strong>{{ $r['label'] }}</strong><span>{{ $r['hint'] }}</span></span>
                    </div>
                    <label class="set-switch dl-cell" title="{{ $r['label'] }} — Wi-Fi">
                        <input type="checkbox" name="autodownload_wifi[]" value="{{ $r['key'] }}" data-dl="wifi" {{ in_array($r['key'], $dlWifi) ? 'checked' : '' }}>
                        <span class="set-switch__track"></span>
                    </label>
                    <label class="set-switch dl-cell" title="{{ $r['label'] }} — mobil internet">
                        <input type="checkbox" name="autodownload_mobile[]" value="{{ $r['key'] }}" data-dl="mobile" {{ in_array($r['key'], $dlMobile) ? 'checked' : '' }}>
                        <span class="set-switch__track"></span>
                    </label>
                </div>
            @endforeach
        </div>
 
        <div class="dl-foot">
            <span>Wi-Fi: <b id="dlCountWifi">–</b> &nbsp;·&nbsp; Mobil internet: <b id="dlCountMobile">–</b></span>
        </div>
 
        <div class="dl-warn">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <span>Mobil internetda video va katta fayllarni o'zi yuklashni yoqsangiz, internet paketingiz tez tugashi mumkin.</span>
        </div>
    </div>
</section>

                {{-- ===================== 6) TIL VA MINTAQA ===================== --}}
               @php
    $langValue     = $settings['language'] ?? 'uz';
    $dateFmtValue  = $settings['date_format'] ?? 'dmy';
    $time24Value   = !array_key_exists('time_format_24h', $settings ?? []) || !empty($settings['time_format_24h']);
    $anthemAutoplay = array_key_exists('anthem_autoplay', $settings ?? []) ? !empty($settings['anthem_autoplay']) : true;

    $flagUz = '<svg viewBox="0 0 30 20" preserveAspectRatio="none"><rect width="30" height="20" fill="#fff"/><rect width="30" height="6.4" fill="#0099B5"/><rect y="6.4" width="30" height="0.3" fill="#CE1126"/><rect y="13.3" width="30" height="0.3" fill="#CE1126"/><rect y="13.6" width="30" height="6.4" fill="#1EB53A"/><circle cx="4" cy="3.2" r="1.8" fill="#fff"/><circle cx="4.7" cy="3.2" r="1.5" fill="#0099B5"/><g fill="#fff"><circle cx="9.5" cy="1.6" r=".32"/><circle cx="11" cy="1.6" r=".32"/><circle cx="12.5" cy="1.6" r=".32"/><circle cx="8.75" cy="3" r=".32"/><circle cx="10.25" cy="3" r=".32"/><circle cx="11.75" cy="3" r=".32"/><circle cx="13.25" cy="3" r=".32"/><circle cx="8" cy="4.4" r=".32"/><circle cx="9.5" cy="4.4" r=".32"/><circle cx="11" cy="4.4" r=".32"/><circle cx="12.5" cy="4.4" r=".32"/><circle cx="14" cy="4.4" r=".32"/></g></svg>';

       $flagKo = '<svg viewBox="0 0 30 20" preserveAspectRatio="none"><rect width="30" height="20" fill="#fff"/><circle cx="15" cy="10" r="3.3" fill="#0047A0"/><path d="M11.7,10 A3.3,3.3 0 0 1 18.3,10 Z" fill="#CD2E3A"/><circle cx="13.35" cy="10" r="1.65" fill="#CD2E3A"/><circle cx="16.65" cy="10" r="1.65" fill="#0047A0"/><g fill="#000"><g transform="translate(15 10) rotate(-56.3)"><rect x="-1.6" y="-6.9" width="3.2" height="0.5"/><rect x="-1.6" y="-6.1" width="3.2" height="0.5"/><rect x="-1.6" y="-5.3" width="3.2" height="0.5"/></g><g transform="translate(15 10) rotate(56.3)"><rect x="-1.6" y="-6.9" width="1.35" height="0.5"/><rect x="0.25" y="-6.9" width="1.35" height="0.5"/><rect x="-1.6" y="-6.1" width="3.2" height="0.5"/><rect x="-1.6" y="-5.3" width="1.35" height="0.5"/><rect x="0.25" y="-5.3" width="1.35" height="0.5"/></g><g transform="translate(15 10) rotate(-123.7)"><rect x="-1.6" y="-6.9" width="3.2" height="0.5"/><rect x="-1.6" y="-6.1" width="1.35" height="0.5"/><rect x="0.25" y="-6.1" width="1.35" height="0.5"/><rect x="-1.6" y="-5.3" width="3.2" height="0.5"/></g><g transform="translate(15 10) rotate(123.7)"><rect x="-1.6" y="-6.9" width="1.35" height="0.5"/><rect x="0.25" y="-6.9" width="1.35" height="0.5"/><rect x="-1.6" y="-6.1" width="1.35" height="0.5"/><rect x="0.25" y="-6.1" width="1.35" height="0.5"/><rect x="-1.6" y="-5.3" width="1.35" height="0.5"/><rect x="0.25" y="-5.3" width="1.35" height="0.5"/></g></g></svg>';

    $flagRu = '<svg viewBox="0 0 30 20" preserveAspectRatio="none"><rect width="30" height="20" fill="#fff"/><rect y="6.67" width="30" height="6.67" fill="#0039A6"/><rect y="13.34" width="30" height="6.66" fill="#D52B1E"/></svg>';

    $flagEn = '<svg viewBox="0 0 30 20" preserveAspectRatio="none"><defs><clipPath id="ukClip"><rect width="30" height="20"/></clipPath></defs><g clip-path="url(#ukClip)"><rect width="30" height="20" fill="#012169"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#fff" stroke-width="4"/><path d="M0,0 L30,20 M30,0 L0,20" stroke="#C8102E" stroke-width="1.3"/><path d="M15,0 V20 M0,10 H30" stroke="#fff" stroke-width="6.5"/><path d="M15,0 V20 M0,10 H30" stroke="#C8102E" stroke-width="3.6"/></g></svg>';

    $langs = [
        ['code' => 'uz',  'name' => "O'zbekcha",      'sub' => "O'zbekiston",        'flag' => $flagUz],
                ['code' => 'ko',  'name' => '한국어',          'sub' => 'Janubiy Koreya',     'flag' => $flagKo],
        ['code' => 'ru',  'name' => 'Русский',        'sub' => 'Rossiya',            'flag' => $flagRu],
        ['code' => 'en',  'name' => 'English',        'sub' => 'Buyuk Britaniya',    'flag' => $flagEn],
    ];

    $today = now();
@endphp

<section class="set-section" id="sec-language">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"></path></svg></span>
        <div><h3 id="langSectionTitle">Til va mintaqa</h3><p id="langSectionSubtitle">Ilova qaysi tilda ko'rinishini va sana hamda vaqt qanday yozilishini tanlang.</p></div>
    </div>

    {{-- ---- 1) Ilova tili ---- --}}
    <div class="set-card">
        <p class="set-card__title" id="langCardTitle">Ilova tili</p>

        <div class="lang-grid" id="langGrid">
            @foreach ($langs as $l)
                <label class="lang-opt" data-lang="{{ $l['code'] }}">
                    <input type="radio" name="language" value="{{ $l['code'] }}" {{ $langValue === $l['code'] ? 'checked' : '' }}>
                    <span class="lang-opt__box">
                        <span class="lang-opt__flag">{!! $l['flag'] !!}</span>
                        <span>
                            <span class="lang-opt__name">{{ $l['name'] }} <span class="eq"><i></i><i></i><i></i></span></span>
                            <span class="lang-opt__sub">{{ $l['sub'] }}</span>
                        </span>
                    </span>
                    <span class="lang-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                    <button type="button" class="lang-opt__play" data-play="{{ $l['code'] }}" title="Madhiyani tinglash" aria-label="Madhiyani tinglash">
                        <svg class="ic-play" viewBox="0 0 24 24"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                        <svg class="ic-stop" viewBox="0 0 24 24"><rect x="5" y="5" width="14" height="14" rx="2"></rect></svg>
                    </button>
                </label>
            @endforeach
        </div>

        {{-- Hozir chalinayotgan madhiya --}}
        <div class="anthem-bar" id="anthemBar" hidden>
            <span class="anthem-bar__flag" id="anthemBarFlag"></span>
            <div class="anthem-bar__info">
                <span class="anthem-bar__title" id="anthemBarTitle"></span>
                <span class="anthem-bar__status" id="anthemBarStatus"></span>
                <div class="anthem-bar__track"><i id="anthemBarProgress"></i></div>
            </div>
            <label class="anthem-bar__vol" title="Ovoz balandligi">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
               <input type="range" id="anthemVolume" min="0" max="100" value="100">
            </label>
            <button type="button" class="btn-ghost" id="anthemStopBtn">To'xtatish</button>
        </div>

        <div class="lang-toggle">
            <div>
                <strong id="anthemToggleTitle">Til tanlanganda madhiya chalinsin</strong>
                <span class="lang-toggle__hint" id="anthemToggleHint">Til kartasini bosganingizda o'sha davlatning madhiyasi ovoz chiqarib chalinadi. Har bir kartadagi tugma orqali tilni almashtirmasdan ham tinglab ko'rishingiz mumkin.</span>
            </div>
            <label class="set-switch"><input type="checkbox" name="anthem_autoplay" value="1" id="anthemAutoplay" {{ $anthemAutoplay ? 'checked' : '' }}><span class="set-switch__track"></span></label>
        </div>
    </div>

    {{-- ---- 2) Sana formati ---- --}}
    <div class="set-card">
        <p class="set-card__title">Sana qanday yozilsin</p>
        <p class="fmt-sub">Xabarlar orasidagi sanalar va bugungi kun shu ko'rinishda chiqadi. Bugungi sana misol qilib ko'rsatilgan.</p>
        <div class="fmt-grid fmt-grid--3">
            <label class="fmt-opt">
                <input type="radio" name="date_format" value="dmy" {{ $dateFmtValue === 'dmy' ? 'checked' : '' }}>
                <span class="fmt-opt__box">
                    <span class="fmt-opt__example" data-date-example="dmy">{{ $today->format('d.m.Y') }}</span>
                    <span class="fmt-opt__chat">Chatda: <b data-chat-example="dmy"></b></span>
                    <span class="fmt-opt__name">Kun · Oy · Yil</span>
                    <span class="fmt-opt__hint">O'zbekiston va Rossiyada odatiy</span>
                </span>
                <span class="fmt-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            </label>
            <label class="fmt-opt">
                <input type="radio" name="date_format" value="mdy" {{ $dateFmtValue === 'mdy' ? 'checked' : '' }}>
                <span class="fmt-opt__box">
                    <span class="fmt-opt__example" data-date-example="mdy">{{ $today->format('m/d/Y') }}</span>
                    <span class="fmt-opt__chat">Chatda: <b data-chat-example="mdy"></b></span>
                    <span class="fmt-opt__name">Oy · Kun · Yil</span>
                    <span class="fmt-opt__hint">AQSh usuli</span>
                </span>
                <span class="fmt-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            </label>
            <label class="fmt-opt">
                <input type="radio" name="date_format" value="ymd" {{ $dateFmtValue === 'ymd' ? 'checked' : '' }}>
                <span class="fmt-opt__box">
                    <span class="fmt-opt__example" data-date-example="ymd">{{ $today->format('Y-m-d') }}</span>
                    <span class="fmt-opt__chat">Chatda: <b data-chat-example="ymd"></b></span>
                    <span class="fmt-opt__name">Yil · Oy · Kun</span>
                    <span class="fmt-opt__hint">Xalqaro standart, tartiblash oson</span>
                </span>
                <span class="fmt-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            </label>
        </div>
    </div>

    {{-- ---- 3) Vaqt formati ---- --}}
    <div class="set-card">
        <p class="set-card__title">Vaqt qanday yozilsin</p>
        <p class="fmt-sub">Soat qanday ko'rinishda yozilishini tanlang. Masalan, kunduzi soat uch yarim: bir usulda «15:30», ikkinchisida «3:30 PM».</p>
        <div class="fmt-grid fmt-grid--2">
            <label class="fmt-opt">
                <input type="radio" name="time_format_24h" value="1" {{ $time24Value ? 'checked' : '' }}>
                <span class="fmt-opt__box">
                    <span class="fmt-opt__example" data-time-example="24">{{ $today->format('H:i') }}</span>
                    <span class="fmt-opt__name">24 soatlik</span>
                    <span class="fmt-opt__hint">Kun 00:00 dan 23:59 gacha sanaladi. Bizda eng keng tarqalgan usul.</span>
                </span>
                <span class="fmt-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            </label>
            <label class="fmt-opt">
                <input type="radio" name="time_format_24h" value="0" {{ !$time24Value ? 'checked' : '' }}>
                <span class="fmt-opt__box">
                    <span class="fmt-opt__example" data-time-example="12">{{ $today->format('g:i A') }}</span>
                    <span class="fmt-opt__name">12 soatlik (AM / PM)</span>
                    <span class="fmt-opt__hint">Kun ikkiga bo'linadi: AM — tushdan oldin, PM — tushdan keyin.</span>
                </span>
                <span class="fmt-opt__check"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
            </label>
        </div>
    </div>

    {{-- ---- 4) Jonli namuna ---- --}}
    <div class="set-card">
        <p class="set-card__title">Chatda shunday ko'rinadi</p>
        <div class="lp-chat">
            <span class="lp-date" id="lpDate">{{ $today->format('d.m.Y') }}</span>
            <div class="lp-bubble in">Salom! Ertaga uchrashamizmi? 👋<small class="lp-time">{{ $today->format('H:i') }}</small></div>
            <div class="lp-bubble out">Ha, albatta! Kelishdik ✅<small class="lp-time">{{ $today->format('H:i') }} ✓✓</small></div>
        </div>
    </div>
</section>



@include('partials.whatsnew-section')

            </div>
        </form>
    </div>

    {{-- ============================================================ --}}
    {{-- O'NG: JONLI KO'RINISH + HISOB --}}
    {{-- ============================================================ --}}
    <aside class="set-preview-panel">
        <div class="pv-card">
            <div class="pv-card__label">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                Jonli ko'rinish
                <span class="pv-dot"></span>
            </div>
            <div class="pv-screen">
                <div class="pv-bg" id="previewBg"></div>
                <div class="pv-chat">
                    <div class="pv-bubble in">Salom! Yangi dizayn menga yoqdi 👋<span class="pv-time">10:24</span></div>
                    <div class="pv-bubble out">Rahmat! Fon va ranglarni sinab ko'ring 🎨<span class="pv-time">10:25 ✓✓</span></div>
                </div>
            </div>
            <div class="pv-footer-note"><b>Eslatma:</b> bu — saqlashdan oldingi taxminiy ko'rinish. "Saqlash" bosilgach, barcha suhbatlaringizga qo'llanadi.</div>
        </div>

        <div class="pv-card">
            <div class="acc-head">
                <span class="acc-avatar">
                    @if (auth()->user()->avatar ?? false)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'F', 0, 1)) }}
                    @endif
                </span>
                <div><b>{{ auth()->user()->name ?? 'Foydalanuvchi' }}</b><span>{{ '@' . (auth()->user()->username ?? 'username') }}</span></div>
            </div>
                 <div class="acc-stats">
                <div><b id="statPersonal">–</b><span>Lichka</span></div>
                <div><b id="statChannels">–</b><span>Kanal</span></div>
                <div><b id="statGroups">–</b><span>Guruh</span></div>
            </div>
        </div>

<div class="pv-card pv-card--devices" id="devicesCard">
    <div class="pv-card__label">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
        Faol qurilmalar
    </div>

    <div class="dev-row is-current">
        <span class="dev-row__icon" id="devIcon"><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>
        <span class="dev-row__text"><strong id="devName">Aniqlanmoqda…</strong><span id="devMeta">Joylashuv aniqlanmoqda…</span></span>
        <span class="dev-badge">HOZIR</span>
    </div>
</div>
    </aside>
</div>

<script>
(function () {
    var page = document.getElementById('setPage');

    /* ==========================================================================
       TEMA — jonli almashtirish + butun ilova bilan sinxronizatsiya
       ==========================================================================
       Bu yerdagi tanlov localStorage'dagi "chatovbs_night_mode" kalitiga
       yoziladi — bu aynan home.blade.php dagi asosiy chat oynasi ("Tungi rejim")
       ishlatadigan xuddi shu kalit. Shu sababli sozlamalarda tanlagan
       qora/oq rejim Chatlar ro'yxatiga qaytganingizda ham saqlanib qoladi,
       va aksincha — chatdan "Tungi rejim" o'zgartirilsa, bu sahifa ochilganda
       ham o'sha holat bilan ochiladi.
    ========================================================================== */
    var NIGHT_MODE_KEY = 'chatovbs_night_mode';
    var quickBtn = document.getElementById('quickThemeToggle');
    var quickIconMoon = document.getElementById('quickThemeIconMoon');
    var quickIconSun = document.getElementById('quickThemeIconSun');
    var quickLabel = document.getElementById('quickThemeLabel');
    var themeRadios = document.querySelectorAll('input[name="theme"]');

    function isSystemLight() {
        return window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
    }

    function currentThemeValue() {
        var checked = document.querySelector('input[name="theme"]:checked');
        return checked ? checked.value : 'dark';
    }

    function updateQuickBtnUI(isLight) {
        quickIconMoon.style.display = isLight ? 'none' : 'block';
        quickIconSun.style.display = isLight ? 'block' : 'none';
        quickLabel.textContent = isLight ? "Yorug'" : "Qorong'i";
    }

    function applyThemeClass(persist) {
        var val = currentThemeValue();
        var isLight = val === 'light' || (val === 'system' && isSystemLight());
        page.classList.toggle('theme-light', isLight);
        updateQuickBtnUI(isLight);
        // Faqat aniq tanlov (dark/light) qilinganda saqlaymiz — "Tizim bo'yicha"
        // tanlansa, ilova qurilma sozlamasiga qarab avtomatik ishlaydi.
        if (persist !== false && val !== 'system') {
            try { localStorage.setItem(NIGHT_MODE_KEY, val === 'dark' ? '1' : '0'); } catch (e) {}
        }
    }

    // Sahifa ochilganda: agar chatda avval "Tungi rejim" o'zgartirilgan bo'lsa,
    // shu holatni bu yerga ham tortib olamiz (backenddan kelgan qiymatdan ustun).
    (function syncFromStorageOnLoad() {
        var stored = null;
        try { stored = localStorage.getItem(NIGHT_MODE_KEY); } catch (e) {}
        if (stored === '1' || stored === '0') {
            var wantValue = stored === '1' ? 'dark' : 'light';
            themeRadios.forEach(function (r) { r.checked = (r.value === wantValue); });
        }
    })();

    themeRadios.forEach(function (i) { i.addEventListener('change', function () { applyThemeClass(); }); });
    applyThemeClass(false); // birinchi chizishda localStorage'ni qayta yozib yubormaslik uchun

    // Tezkor tugma: bitta bosishda qorong'i ↔ yorug' orasida almashtiradi.
    quickBtn.addEventListener('click', function () {
        var goingLight = !page.classList.contains('theme-light');
        var newValue = goingLight ? 'light' : 'dark';
        themeRadios.forEach(function (r) { r.checked = (r.value === newValue); });
        applyThemeClass();
    });

/* ---------- Aksent rang: "O'zim tanlayman" — doim ochiq rang tanlagich ---------- */
var accentCustomRadio = document.getElementById('accentCustomRadio');
var accentCustomColorInput = document.getElementById('accentCustomColorInput');
var accentCustomDot = document.getElementById('accentCustomDot');
var colorSV = document.getElementById('colorSV');
var colorSVCanvas = document.getElementById('colorSVCanvas');
var colorSVThumb = document.getElementById('colorSVThumb');
var colorHue = document.getElementById('colorHue');
var colorHueThumb = document.getElementById('colorHueThumb');
var colorSwatch = document.getElementById('colorSwatch');
var colorEyedrop = document.getElementById('colorEyedrop');
var colorInputR = document.getElementById('colorInputR');
var colorInputG = document.getElementById('colorInputG');
var colorInputB = document.getElementById('colorInputB');
var colorInputHex = document.getElementById('colorInputHex');
var svCtx = colorSVCanvas.getContext('2d');
var hsv = { h: 40, s: 0.72, v: 0.88 };

function hexToRgbFull(hex) {
    hex = (hex || '#e0a83e').replace('#', '');
    if (hex.length === 3) hex = hex.split('').map(function (c) { return c + c; }).join('');
    var num = parseInt(hex, 16) || 0;
    return { r: (num >> 16) & 255, g: (num >> 8) & 255, b: num & 255 };
}
function rgbToHex(r, g, b) {
    return '#' + [r, g, b].map(function (v) { return Math.max(0, Math.min(255, Math.round(v))).toString(16).padStart(2, '0'); }).join('');
}
function rgbToHsv(r, g, b) {
    r /= 255; g /= 255; b /= 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b), d = max - min, h = 0;
    if (d !== 0) {
        if (max === r) h = ((g - b) / d) % 6;
        else if (max === g) h = (b - r) / d + 2;
        else h = (r - g) / d + 4;
        h *= 60;
        if (h < 0) h += 360;
    }
    return { h: h, s: max === 0 ? 0 : d / max, v: max };
}
function hsvToRgb(h, s, v) {
    var c = v * s, x = c * (1 - Math.abs((h / 60) % 2 - 1)), m = v - c, r = 0, g = 0, b = 0;
    if (h < 60) { r = c; g = x; } else if (h < 120) { r = x; g = c; }
    else if (h < 180) { g = c; b = x; } else if (h < 240) { g = x; b = c; }
    else if (h < 300) { r = x; b = c; } else { r = c; b = x; }
    return { r: (r + m) * 255, g: (g + m) * 255, b: (b + m) * 255 };
}
function pickInkColor(rgb) {
    var lum = (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
    return lum > 0.55 ? '#171310' : '#ffffff';
}
function setVal(el, v) { if (document.activeElement !== el) el.value = v; }

function drawSVCanvas() {
    var w = colorSVCanvas.width, h = colorSVCanvas.height;
    var hueRgb = hsvToRgb(hsv.h, 1, 1);
    svCtx.fillStyle = 'rgb(' + Math.round(hueRgb.r) + ',' + Math.round(hueRgb.g) + ',' + Math.round(hueRgb.b) + ')';
    svCtx.fillRect(0, 0, w, h);
    var sat = svCtx.createLinearGradient(0, 0, w, 0);
    sat.addColorStop(0, 'rgba(255,255,255,1)'); sat.addColorStop(1, 'rgba(255,255,255,0)');
    svCtx.fillStyle = sat; svCtx.fillRect(0, 0, w, h);
    var val = svCtx.createLinearGradient(0, 0, 0, h);
    val.addColorStop(0, 'rgba(0,0,0,0)'); val.addColorStop(1, 'rgba(0,0,0,1)');
    svCtx.fillStyle = val; svCtx.fillRect(0, 0, w, h);
}

function updateThumbs() {
    colorSVThumb.style.left = (hsv.s * colorSV.clientWidth) + 'px';
    colorSVThumb.style.top = ((1 - hsv.v) * colorSV.clientHeight) + 'px';
    colorHueThumb.style.left = ((hsv.h / 360) * colorHue.clientWidth) + 'px';
}

function applyCurrentColor(persist) {
    var rgb = hsvToRgb(hsv.h, hsv.s, hsv.v);
    var hex = rgbToHex(rgb.r, rgb.g, rgb.b);
    colorSwatch.style.background = hex;
    setVal(colorInputR, Math.round(rgb.r));
    setVal(colorInputG, Math.round(rgb.g));
    setVal(colorInputB, Math.round(rgb.b));
    setVal(colorInputHex, hex);
    accentCustomDot.style.setProperty('--dot-color', hex);
    accentCustomColorInput.value = hex;
    if (persist !== false) {
        accentCustomRadio.checked = true;
        applyAccentClass();
    }
}

function setFromHex(hex) {
    var rgb = hexToRgbFull(hex);
    hsv = rgbToHsv(rgb.r, rgb.g, rgb.b);
    drawSVCanvas();
    updateThumbs();
    applyCurrentColor(false);
}

var svDragging = false;
function handleSVPointer(e) {
    var rect = colorSV.getBoundingClientRect();
    hsv.s = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
    hsv.v = 1 - Math.max(0, Math.min(1, (e.clientY - rect.top) / rect.height));
    updateThumbs();
    applyCurrentColor();
}
colorSV.addEventListener('pointerdown', function (e) { svDragging = true; colorSV.setPointerCapture(e.pointerId); handleSVPointer(e); });
colorSV.addEventListener('pointermove', function (e) { if (svDragging) handleSVPointer(e); });
colorSV.addEventListener('pointerup', function () { svDragging = false; });
colorSV.addEventListener('pointercancel', function () { svDragging = false; });

var hueDragging = false;
function handleHuePointer(e) {
    var rect = colorHue.getBoundingClientRect();
    hsv.h = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width)) * 360;
    drawSVCanvas();
    updateThumbs();
    applyCurrentColor();
}
colorHue.addEventListener('pointerdown', function (e) { hueDragging = true; colorHue.setPointerCapture(e.pointerId); handleHuePointer(e); });
colorHue.addEventListener('pointermove', function (e) { if (hueDragging) handleHuePointer(e); });
colorHue.addEventListener('pointerup', function () { hueDragging = false; });
colorHue.addEventListener('pointercancel', function () { hueDragging = false; });

[colorInputR, colorInputG, colorInputB].forEach(function (input) {
    input.addEventListener('input', function () {
        var r = Math.max(0, Math.min(255, parseInt(colorInputR.value, 10) || 0));
        var g = Math.max(0, Math.min(255, parseInt(colorInputG.value, 10) || 0));
        var b = Math.max(0, Math.min(255, parseInt(colorInputB.value, 10) || 0));
        hsv = rgbToHsv(r, g, b);
        drawSVCanvas(); updateThumbs(); applyCurrentColor();
    });
});

colorInputHex.addEventListener('input', function () {
    var v = this.value.trim();
    if (v.charAt(0) !== '#') v = '#' + v;
    if (/^#[0-9a-fA-F]{6}$/.test(v)) {
        setFromHex(v);
        accentCustomRadio.checked = true;
        applyAccentClass();
    }
});

if (window.EyeDropper) {
    colorEyedrop.addEventListener('click', function () {
        new EyeDropper().open().then(function (result) {
            setFromHex(result.sRGBHex);
            accentCustomRadio.checked = true;
            applyAccentClass();
        }).catch(function () {});
    });
} else {
    colorEyedrop.style.display = 'none';
}

window.addEventListener('resize', updateThumbs);

function applyAccentClass() {
    var checked = document.querySelector('input[name="accent_color"]:checked');
    var val = checked ? checked.value : 'default';
    page.className = page.className.replace(/\baccent-[\w-]+/g, '').replace(/\s+/g, ' ').trim();
    ['--accent', '--accent-ink', '--accent-soft', '--bubble', '--bubble-ink'].forEach(function (p) { page.style.removeProperty(p); });

    if (val === 'custom') {
        var hex = accentCustomColorInput.value || '#e0a83e';
        var rgb = hexToRgbFull(hex);
        var ink = pickInkColor(rgb);
        page.style.setProperty('--accent', hex);
        page.style.setProperty('--accent-ink', ink);
        page.style.setProperty('--accent-soft', 'rgba(' + rgb.r + ',' + rgb.g + ',' + rgb.b + ',0.16)');
        page.style.setProperty('--bubble', hex);
        page.style.setProperty('--bubble-ink', ink);
    } else {
        page.classList.add('accent-' + val);
    }
}

function persistAccent() {
    var checked = document.querySelector('input[name="accent_color"]:checked');
    try {
             localStorage.setItem('chatovbs_accent_color_{{ auth()->id() }}', checked ? checked.value : 'default');
        localStorage.setItem('chatovbs_accent_custom_{{ auth()->id() }}', accentCustomColorInput.value || '#e0a83e');
    } catch (e) {}
}

document.querySelectorAll('input[name="accent_color"]').forEach(function (i) { i.addEventListener('change', applyAccentClass); });
document.getElementById('settingsForm').addEventListener('submit', persistAccent);

setFromHex(accentCustomColorInput.value);
applyAccentClass();
persistAccent();

     /* ---------- Matn o'lchami + zichlik: jonli ko'rinish ---------- */
    var fontSizeRange = document.getElementById('fontSizeRange');
    var fontSizePreview = document.getElementById('fontSizePreview');
    var fontSizeSample = document.getElementById('fontSizeSample');
    var fsMinus = document.getElementById('fsMinus');
    var fsPlus = document.getElementById('fsPlus');
    var fsTryInput = document.getElementById('fsTryInput');
    var fsOutText = document.getElementById('fsOutText');
    var fsDefaultText = fsOutText.textContent;
    var densityRadios = document.querySelectorAll('input[name="density"]');
    var pvChat = document.querySelector('.pv-chat');

    function applyTypographyAndDensity() {
        var px = parseInt(fontSizeRange.value, 10);
        var min = parseInt(fontSizeRange.min, 10), max = parseInt(fontSizeRange.max, 10);
        fontSizeRange.style.setProperty('--pct', ((px - min) / (max - min) * 100) + '%');
        fontSizePreview.textContent = px + 'px';
        fontSizeSample.style.fontSize = px + 'px';
        fsMinus.disabled = px <= min;
        fsPlus.disabled = px >= max;
        document.querySelectorAll('.pv-bubble').forEach(function (b) { b.style.fontSize = (px * 0.8) + 'px'; });

        var d = document.querySelector('input[name="density"]:checked');
        pvChat.classList.toggle('is-compact', !!d && d.value === 'compact');
    }

    function stepFont(delta) {
        var min = parseInt(fontSizeRange.min, 10), max = parseInt(fontSizeRange.max, 10);
        var v = Math.max(min, Math.min(max, parseInt(fontSizeRange.value, 10) + delta));
        fontSizeRange.value = v;
        applyTypographyAndDensity();
    }

    fsMinus.addEventListener('click', function () { stepFont(-1); });
    fsPlus.addEventListener('click', function () { stepFont(1); });
    fontSizeRange.addEventListener('input', applyTypographyAndDensity);
    densityRadios.forEach(function (r) { r.addEventListener('change', applyTypographyAndDensity); });

    // O'z matningizni yozib ko'rish: yozganingiz chat pufakchasida chiqadi
    fsTryInput.addEventListener('input', function () {
        fsOutText.textContent = this.value.trim() ? this.value : fsDefaultText;
    });

    document.getElementById('settingsForm').addEventListener('reset', function () {
        setTimeout(function () { fsTryInput.value = ''; fsOutText.textContent = fsDefaultText; applyTypographyAndDensity(); }, 0);
    });
    applyTypographyAndDensity();

    /* ---------- Fon (wallpaper) tablari + jonli preview ---------- */
    var wallTabs = document.querySelectorAll('.set-wall-tab');
    var wallPanes = document.querySelectorAll('.set-wall-pane');
    var wallpaperTypeInput = document.getElementById('wallpaperTypeInput');
    var previewBg = document.getElementById('previewBg');

    var GRADIENTS = {
        sunset: 'linear-gradient(155deg,#ff9966,#ff5e62 45%,#3a1c71)',
        mint:   'linear-gradient(155deg,#0f2027,#203a43,#2dd4bf)',
        dusk:   'linear-gradient(155deg,#232526,#414345)',
        berry:  'linear-gradient(155deg,#8e2de2,#4a00e0)',
        forest: 'linear-gradient(155deg,#134e5e,#71b280)',
        amber:  'linear-gradient(155deg,#f7971e,#e0a83e 60%,#8a5a12)',
        ocean:  'linear-gradient(155deg,#1c92d2,#f2fcfe)',
        mono:   'linear-gradient(155deg,#3a3a34,#141410)',
        candy:  'linear-gradient(155deg,#f6d365,#fda085)',
        night:  'linear-gradient(155deg,#0f0c29,#302b63,#24243e)',
        lime:   'linear-gradient(155deg,#a8e063,#56ab2f)',
        rose:   'linear-gradient(155deg,#f472b6,#7c3aed)'
    };

    function setActiveTab(tabKey) {
        wallTabs.forEach(function (t) { t.classList.toggle('active', t.dataset.tab === tabKey); });
        wallPanes.forEach(function (p) { p.classList.toggle('active', p.dataset.pane === tabKey); });
        wallpaperTypeInput.value = tabKey;
        updatePreviewBg();
    }
    wallTabs.forEach(function (tab) { tab.addEventListener('click', function () { setActiveTab(tab.dataset.tab); }); });
    setActiveTab('{{ $wallType }}' || 'gradient');

  var APP_BASE = "{{ rtrim(asset(''), '/') }}";
var STORAGE_BASE = "{{ rtrim(asset('storage'), '/') }}";
function wallUrl(u) {
    if (!u) return null;
    if (/^(https?:)?\/\//i.test(u) || /^(blob|data):/i.test(u)) return u;
    u = String(u).replace(/^\/+/, '');
    if (u.indexOf('storage/') === 0) return APP_BASE + '/' + u;
    return STORAGE_BASE + '/' + u;
}
var savedImg = wallUrl(@json($wallImageUrl));
var savedVid = wallUrl(@json($wallVideoUrl));
var savedVidPos = { x: {{ (int) $wallVideoX }}, y: {{ (int) $wallVideoY }} };

function chatRatio() {
    var r = (window.innerWidth - 404) / window.innerHeight; // rail 70 + ro'yxat 334
    return Math.max(1.2, Math.min(2.2, r || 1.6));
}
window.__chatRatio = chatRatio;
document.querySelector('.pv-screen').style.aspectRatio = '1 / 1.1';

function updatePreviewBg() {
    previewBg.innerHTML = '';
    previewBg.classList.remove('blurred');
    var type = wallpaperTypeInput.value;
    var blur = document.getElementById('wallBlurToggle').checked;

    if (type === 'gradient') {
        var checked = document.querySelector('input[name="wallpaper_gradient"]:checked');
        previewBg.style.background = GRADIENTS[checked ? checked.value : 'sunset'] || GRADIENTS.sunset;
    } else if (type === 'color') {
        previewBg.style.background = window.__csBg ? window.__csBg() : '#1d1d17';
    } else if (type === 'image') {
        var file = document.getElementById('wallImageInput').files[0];
        var isrc = file ? URL.createObjectURL(file) : savedImg;
        previewBg.style.background = isrc ? 'url(' + isrc + ') center/cover no-repeat' : '#141410';
        if (isrc && blur) previewBg.classList.add('blurred');
    } else if (type === 'video') {
        previewBg.style.background = '#000';
        var vfile = document.getElementById('wallVideoInput').files[0];
        var vsrc = vfile ? URL.createObjectURL(vfile) : savedVid;
        if (vsrc) {
            var video = document.createElement('video');
            video.muted = true; video.defaultMuted = true; video.setAttribute('muted', '');
            video.loop = true; video.autoplay = true; video.playsInline = true;
            video.setAttribute('playsinline', '');
            video.preload = 'auto';
            var f = window.__vidFocus || savedVidPos;
            video.style.objectPosition = f.x + '% ' + f.y + '%';
            video.addEventListener('error', function () {
var badUrl = video.currentSrc || video.src;
previewBg.innerHTML = '<div style="position:absolute;inset:0;display:grid;place-items:center;padding:14px;text-align:center;color:#f16565;font-size:12px;word-break:break-all;">Video ochilmadi.<br><small style="opacity:.8">' + String(badUrl).replace(/</g,'&lt;') + '</small></div>';
console.warn('Video ochilmadi:', badUrl);
            });
            video.src = vsrc;
            previewBg.appendChild(video);
            var p = video.play(); if (p && p.catch) p.catch(function () {});
            if (blur) previewBg.classList.add('blurred');
        } else {
            previewBg.innerHTML = '<div style="position:absolute;inset:0;display:grid;place-items:center;color:#8c8c81;font-size:12px;">Video tanlanmagan</div>';
        }
    }
}
    document.querySelectorAll('input[name="wallpaper_gradient"]').forEach(function (r) { r.addEventListener('change', updatePreviewBg); });
    
/* ---------- Rang studiyasi: tepa / o'rta / past ---------- */
var csZones = { top: '{{ $wallColor }}', mid: '{{ $wallColorMid }}', bottom: '{{ $wallColorBottom }}' };
var csStyle = '{{ $wallColorStyle }}';
var csSel = 'top';
var csHsv = { h: 0, s: 0, v: 0 };
var CS_NAMES = { top: 'Tepa', mid: "O'rta", bottom: 'Past' };
var CS_ANGLES = { v: '180deg', d: '155deg', h: '90deg' };
var CS_PALETTES = [
    ['Shafaq', '#ff9966', '#ff5e62', '#3a1c71'], ['Okean', '#1c92d2', '#0f4c81', '#0b132b'],
    ['Tun', '#302b63', '#24243e', '#0f0c29'], ['Zumrad', '#71b280', '#134e5e', '#0a1f1c'],
    ['Malina', '#f472b6', '#8e2de2', '#1a1330'], ['Amber', '#f7971e', '#8a5a12', '#1c1206']
];

var csSV = document.getElementById('csSV'), csCanvas = document.getElementById('csCanvas');
var csSVThumb = document.getElementById('csSVThumb'), csHue = document.getElementById('csHue');
var csHueThumb = document.getElementById('csHueThumb'), csHexInput = document.getElementById('csHexInput');
var csCtx = csCanvas.getContext('2d');

function csCss() {
    var t = csZones.top, m = csZones.mid, b = csZones.bottom;
    if (csStyle === 'r') return 'radial-gradient(circle at 50% 25%, ' + t + ', ' + m + ' 55%, ' + b + ')';
    return 'linear-gradient(' + (CS_ANGLES[csStyle] || '180deg') + ', ' + t + ', ' + m + ', ' + b + ')';
}
window.__csBg = csCss; // updatePreviewBg shu funksiyadan foydalanadi

function csDrawCanvas() {
    var w = csCanvas.width, h = csCanvas.height, hr = hsvToRgb(csHsv.h, 1, 1);
    csCtx.fillStyle = 'rgb(' + Math.round(hr.r) + ',' + Math.round(hr.g) + ',' + Math.round(hr.b) + ')';
    csCtx.fillRect(0, 0, w, h);
    var s = csCtx.createLinearGradient(0, 0, w, 0);
    s.addColorStop(0, 'rgba(255,255,255,1)'); s.addColorStop(1, 'rgba(255,255,255,0)');
    csCtx.fillStyle = s; csCtx.fillRect(0, 0, w, h);
    var v = csCtx.createLinearGradient(0, 0, 0, h);
    v.addColorStop(0, 'rgba(0,0,0,0)'); v.addColorStop(1, 'rgba(0,0,0,1)');
    csCtx.fillStyle = v; csCtx.fillRect(0, 0, w, h);
}
function csThumbs() {
    csSVThumb.style.left = (csHsv.s * csSV.clientWidth) + 'px';
    csSVThumb.style.top = ((1 - csHsv.v) * csSV.clientHeight) + 'px';
    csHueThumb.style.left = ((csHsv.h / 360) * csHue.clientWidth) + 'px';
}

function csRender() {
    document.getElementById('csStageBg').style.background = csCss();
    document.querySelectorAll('.cs-zone').forEach(function (z) {
        var hex = csZones[z.dataset.zone];
        z.classList.toggle('is-active', z.dataset.zone === csSel);
        z.querySelector('i').style.background = hex;
        z.querySelector('em').textContent = hex.toUpperCase();
    });
    document.getElementById('csEditName').textContent = CS_NAMES[csSel];
    document.getElementById('wallColorInput').value = csZones.top;
    document.getElementById('wallColorMidInput').value = csZones.mid;
    document.getElementById('wallColorBottomInput').value = csZones.bottom;
    document.getElementById('wallColorStyleInput').value = csStyle;
    document.querySelectorAll('#csStyleSeg button').forEach(function (b) { b.classList.toggle('active', b.dataset.style === csStyle); });
    if (document.activeElement !== csHexInput) csHexInput.value = csZones[csSel].toUpperCase();
    updatePreviewBg();
}

function csSelect(key) {
    csSel = key;
    var c = hexToRgbFull(csZones[key]);
    csHsv = rgbToHsv(c.r, c.g, c.b);
    csDrawCanvas(); csThumbs(); csRender();
}
function csApplyHsv() {
    var c = hsvToRgb(csHsv.h, csHsv.s, csHsv.v);
    csZones[csSel] = rgbToHex(c.r, c.g, c.b);
    csRender();
}

var csDragSV = false, csDragHue = false;
function csSVMove(e) {
    var r = csSV.getBoundingClientRect();
    csHsv.s = Math.max(0, Math.min(1, (e.clientX - r.left) / r.width));
    csHsv.v = 1 - Math.max(0, Math.min(1, (e.clientY - r.top) / r.height));
    csThumbs(); csApplyHsv();
}
function csHueMove(e) {
    var r = csHue.getBoundingClientRect();
    csHsv.h = Math.max(0, Math.min(1, (e.clientX - r.left) / r.width)) * 360;
    csDrawCanvas(); csThumbs(); csApplyHsv();
}
csSV.addEventListener('pointerdown', function (e) { csDragSV = true; csSV.setPointerCapture(e.pointerId); csSVMove(e); });
csSV.addEventListener('pointermove', function (e) { if (csDragSV) csSVMove(e); });
csSV.addEventListener('pointerup', function () { csDragSV = false; });
csHue.addEventListener('pointerdown', function (e) { csDragHue = true; csHue.setPointerCapture(e.pointerId); csHueMove(e); });
csHue.addEventListener('pointermove', function (e) { if (csDragHue) csHueMove(e); });
csHue.addEventListener('pointerup', function () { csDragHue = false; });

csHexInput.addEventListener('input', function () {
    var v = this.value.trim();
    if (v.charAt(0) !== '#') v = '#' + v;
    if (/^#[0-9a-fA-F]{6}$/.test(v)) {
        this.classList.remove('is-invalid');
        csZones[csSel] = v.toLowerCase();
        var c = hexToRgbFull(v); csHsv = rgbToHsv(c.r, c.g, c.b);
        csDrawCanvas(); csThumbs(); csRender();
    } else { this.classList.toggle('is-invalid', v.length > 1); }
});
csHexInput.addEventListener('blur', function () { this.value = csZones[csSel].toUpperCase(); this.classList.remove('is-invalid'); });

document.querySelectorAll('.cs-zone').forEach(function (z) { z.addEventListener('click', function () { csSelect(z.dataset.zone); }); });
document.querySelectorAll('#csStyleSeg button').forEach(function (b) { b.addEventListener('click', function () { csStyle = b.dataset.style; csRender(); }); });

function csSetAll(t, m, b) { csZones.top = t; csZones.mid = m; csZones.bottom = b; csSelect(csSel); }
function csHsvHex(h, s, v) { var c = hsvToRgb(((h % 360) + 360) % 360, s, v); return rgbToHex(c.r, c.g, c.b); }

document.getElementById('csRandom').addEventListener('click', function () {
    var h = Math.random() * 360, step = 25 + Math.random() * 45;
    csSetAll(csHsvHex(h, 0.55, 0.55), csHsvHex(h + step, 0.6, 0.32), csHsvHex(h + step * 2, 0.65, 0.14));
});
document.getElementById('csSwap').addEventListener('click', function () { csSetAll(csZones.bottom, csZones.mid, csZones.top); });

var palWrap = document.getElementById('csPalettes');
CS_PALETTES.forEach(function (p) {
    var b = document.createElement('button');
    b.type = 'button'; b.className = 'cs-pal';
    b.innerHTML = '<span class="cs-pal__thumb" style="background:linear-gradient(180deg,' + p[1] + ',' + p[2] + ',' + p[3] + ')"></span><span class="cs-pal__name">' + p[0] + '</span>';
    b.addEventListener('click', function () { csSetAll(p[1], p[2], p[3]); });
    palWrap.appendChild(b);
});

window.addEventListener('resize', csThumbs);
csSelect('top');


    document.getElementById('wallBlurToggle').addEventListener('change', updatePreviewBg);


  function setupMedia(p, maxMB, isVideo, savedUrl, savedPos) {
    var input = document.getElementById(p + 'Input');
    var root = document.getElementById(p + 'Root');
    var form = document.getElementById('settingsForm');
    var okTypes = isVideo ? ['video/mp4', 'video/webm'] : ['image/jpeg', 'image/png', 'image/webp'];
   var RATIOS = { chat: window.__chatRatio(), wide: 1.6, square: 1, tall: 0.5625 };
    var ICON = isVideo
        ? '<svg viewBox="0 0 24 24"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>'
        : '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>';

    root.innerHTML =
        '<div class="me-empty" tabindex="0" role="button">' +
            '<span class="me-empty__icon">' + ICON + '</span>' +
            '<span class="me-empty__txt"><b>' + (isVideo ? 'Videoni shu yerga tashlang' : 'Rasmni shu yerga tashlang') + '</b><span>' + (isVideo ? 'MP4 yoki WEBM ·  450 MB gacha · ovozsiz aylanadi' : 'JPG, PNG yoki WEBP · 8 MB gacha') + '</span></span>' +
            '<button type="button" class="btn-solid me-pick">' + (isVideo ? 'Video tanlash' : 'Rasm tanlash') + '</button>' +
        '</div>' +
        '<div class="me-editor" hidden>' +
            '<div class="me-wrap"><div class="me-stage"><span class="me-grid"></span><span class="me-hint">Sudrab joylashtiring</span></div></div>' +
            '<div class="me-side">' +
                '<div class="me-file"><span class="me-file__ic">' + ICON + '</span><span class="me-file__t"><b class="me-name"></b><span class="me-size"></span></span></div>' +
                (isVideo
                    ? '<p class="me-note">Videoning kerakli qismini sichqoncha bilan sudrab tanlang.</p>'
                    : '<div class="me-ctl"><label>Kattalashtirish <em class="me-zv">100%</em></label><input type="range" class="me-zoom" min="100" max="300" value="100"></div>' +
                      '<div class="me-ctl"><label>Shakl</label><div class="me-seg"><button type="button" data-r="chat" class="active">Chat</button><button type="button" data-r="wide">Keng</button><button type="button" data-r="square">Kvadrat</button><button type="button" data-r="tall">Tik</button></div></div>') +
                '<div class="me-actions">' +
                    (isVideo ? '' : '<button type="button" class="btn-ghost me-reset">Joyini tiklash</button>') +
                    '<button type="button" class="btn-ghost me-change">Almashtirish</button>' +
                    '<button type="button" class="btn-ghost is-danger me-remove">Olib tashlash</button>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<p class="me-error" hidden></p>' +
        (isVideo ? '<input type="hidden" name="wallpaper_video_x" class="me-vx" value="50"><input type="hidden" name="wallpaper_video_y" class="me-vy" value="50">' : '');

    function $(s) { return root.querySelector(s); }
    var empty = $('.me-empty'), editor = $('.me-editor'), wrap = $('.me-wrap'), stage = $('.me-stage'), errEl = $('.me-error');
    var zi = $('.me-zoom'), zv = $('.me-zv'), vx = $('.me-vx'), vy = $('.me-vy');
    var el = null, url = null, current = null, nw = 0, nh = 0, SW = 0, SH = 0;
   var fx = 0.5, fy = 0.5, zoom = 1, ratio = RATIOS.chat, dirty = false, timer = null, baseName = 'wallpaper';

    function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }
    function fmt(b) { return b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB'; }
    function setInputFile(f) { var dt = new DataTransfer(); dt.items.add(f); input.files = dt.files; current = f; }

    function layout() {
        var W = Math.max(120, Math.min(wrap.clientWidth - 28, 280 * ratio));
        var H = W / ratio;
        stage.style.width = W + 'px'; stage.style.height = H + 'px';
        SW = W; SH = H;
        render();
    }

    function render() {
        if (!el || !nw || !SW) return;
        var base = Math.max(SW / nw, SH / nh);
        if (isVideo) {
            var ox = Math.max(0, nw * base - SW), oy = Math.max(0, nh * base - SH);
            fx = ox ? clamp(fx, 0, 1) : 0.5; fy = oy ? clamp(fy, 0, 1) : 0.5;
            var pos = Math.round(fx * 100) + '% ' + Math.round(fy * 100) + '%';
            el.style.objectPosition = pos;
            vx.value = Math.round(fx * 100); vy.value = Math.round(fy * 100);
            window.__vidFocus = { x: vx.value, y: vy.value };
            var pv = document.querySelector('#previewBg video');
            if (pv) pv.style.objectPosition = pos;
        } else {
            var s = base * zoom, dw = nw * s, dh = nh * s;
            fx = clamp(fx, SW / 2 / dw, 1 - SW / 2 / dw);
            fy = clamp(fy, SH / 2 / dh, 1 - SH / 2 / dh);
            el.style.width = dw + 'px'; el.style.height = dh + 'px';
            el.style.left = (SW / 2 - fx * dw) + 'px';
            el.style.top = (SH / 2 - fy * dh) + 'px';
        }
    }

    function exportImage(cb) {
        if (!el || isVideo || !nw) { if (cb) cb(); return; }
        var s = Math.max(SW / nw, SH / nh) * zoom;
        var sx = fx * nw - SW / 2 / s, sy = fy * nh - SH / 2 / s;
        var ow = ratio >= 1 ? 1600 : Math.round(1600 * ratio), oh = Math.round(ow / ratio);
        var c = document.createElement('canvas'); c.width = ow; c.height = oh;
        c.getContext('2d').drawImage(el, sx, sy, SW / s, SH / s, 0, 0, ow, oh);
        c.toBlob(function (blob) {
            if (!blob) { if (cb) cb(); return; }
            setInputFile(new File([blob], baseName + '.jpg', { type: 'image/jpeg' }));
            dirty = false;
            updatePreviewBg();
            if (cb) cb();
        }, 'image/jpeg', 0.9);
    }
    function schedule() { dirty = true; clearTimeout(timer); timer = setTimeout(function () { exportImage(); }, 250); }

    function ready() {
        nw = isVideo ? el.videoWidth : el.naturalWidth;
        nh = isVideo ? el.videoHeight : el.naturalHeight;
        empty.hidden = true; editor.hidden = false;
        layout();
        if (isVideo) updatePreviewBg(); else exportImage();
    }

    function load(file) {
        if (url) URL.revokeObjectURL(url);
        url = URL.createObjectURL(file);
        baseName = file.name.replace(/\.[^.]+$/, '') || 'wallpaper';
        if (el && el.parentNode) el.parentNode.removeChild(el);
        fx = 0.5; fy = 0.5; zoom = 1; ratio = RATIOS.chat;
        if (zi) { zi.value = 100; zv.textContent = '100%'; }
        root.querySelectorAll('.me-seg button').forEach(function (b) { b.classList.toggle('active', b.dataset.r === 'chat'); });
        stage.classList.remove('is-touched');
        if (isVideo) {
            el = document.createElement('video');
            el.muted = true; el.loop = true; el.autoplay = true; el.playsInline = true;
            el.onloadedmetadata = ready; el.src = url;
        } else {
            el = new Image(); el.alt = ''; el.draggable = false; el.onload = ready; el.src = url;
        }
        stage.insertBefore(el, stage.firstChild);
        $('.me-name').textContent = file.name;
        $('.me-size').textContent = fmt(file.size);
    }

    function clear() {
        input.value = ''; current = null; dirty = false;
        if (el && el.parentNode) el.parentNode.removeChild(el);
        el = null;
        if (url) { URL.revokeObjectURL(url); url = null; }
        editor.hidden = true; empty.hidden = false; errEl.hidden = true;
        updatePreviewBg();
    }

    function accept(file) {
        if (!file) return;
        var bad = null;
        if (okTypes.indexOf(file.type) === -1) bad = isVideo ? 'Faqat MP4 yoki WEBM video yuklash mumkin.' : 'Faqat JPG, PNG yoki WEBP rasm yuklash mumkin.';
        else if (file.size > maxMB * 1048576) bad = 'Fayl juda katta (' + fmt(file.size) + '). Maksimal hajm: ' + maxMB + ' MB.';
        if (bad) { clear(); errEl.textContent = bad; errEl.hidden = false; return; }
        setInputFile(file);
        errEl.hidden = true;
        load(file);
    }

    /* tugmalar */
    function openPicker() { input.click(); }
    empty.addEventListener('click', openPicker);
    empty.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openPicker(); } });
    $('.me-pick').addEventListener('click', function (e) { e.stopPropagation(); openPicker(); });
    $('.me-change').addEventListener('click', openPicker);
    $('.me-remove').addEventListener('click', clear);
    input.addEventListener('change', function () {
        if (input.files[0]) { accept(input.files[0]); }
        else if (current) { setInputFile(current); } // "Bekor qilish" bosilsa, mavjud fayl saqlanib qoladi
        else { clear(); }
    });

    /* sudrab tashlash */
    root.addEventListener('dragover', function (e) { e.preventDefault(); empty.classList.add('is-drag'); });
    root.addEventListener('dragleave', function () { empty.classList.remove('is-drag'); });
    root.addEventListener('drop', function (e) { e.preventDefault(); empty.classList.remove('is-drag'); accept(e.dataTransfer.files[0]); });

    /* kadr ichida sudrash */
    var drag = null;
    stage.addEventListener('pointerdown', function (e) {
        if (!el) return;
        drag = { x: e.clientX, y: e.clientY };
        stage.setPointerCapture(e.pointerId);
        stage.classList.add('is-drag', 'is-touched');
    });
    stage.addEventListener('pointermove', function (e) {
        if (!drag) return;
        var dx = e.clientX - drag.x, dy = e.clientY - drag.y;
        drag.x = e.clientX; drag.y = e.clientY;
        var base = Math.max(SW / nw, SH / nh);
        if (isVideo) {
            var ox = Math.max(0, nw * base - SW), oy = Math.max(0, nh * base - SH);
            if (ox) fx -= dx / ox;
            if (oy) fy -= dy / oy;
        } else {
            var s = base * zoom;
            fx -= dx / (nw * s); fy -= dy / (nh * s);
        }
        render();
    });
    function endDrag() { if (!drag) return; drag = null; stage.classList.remove('is-drag'); if (!isVideo) schedule(); }
    stage.addEventListener('pointerup', endDrag);
    stage.addEventListener('pointercancel', endDrag);

    /* faqat rasm: zoom, shakl, tiklash */
    if (!isVideo) {
        function setZoom(z) { zoom = clamp(z, 1, 3); zi.value = Math.round(zoom * 100); zv.textContent = Math.round(zoom * 100) + '%'; render(); schedule(); }
        zi.addEventListener('input', function () { setZoom(zi.value / 100); });
        stage.addEventListener('wheel', function (e) { if (!el) return; e.preventDefault(); setZoom(zoom - e.deltaY * 0.001); }, { passive: false });
        root.querySelectorAll('.me-seg button').forEach(function (b) {
            b.addEventListener('click', function () {
                root.querySelectorAll('.me-seg button').forEach(function (x) { x.classList.toggle('active', x === b); });
                ratio = RATIOS[b.dataset.r]; layout(); schedule();
            });
        });
        $('.me-reset').addEventListener('click', function () { fx = 0.5; fy = 0.5; setZoom(1); });
        // "Saqlash" bosilganda qirqilgan rasm tayyor bo'lishini kutamiz
        form.addEventListener('submit', function (e) {
            if (!dirty) return;
            e.preventDefault(); clearTimeout(timer);
            exportImage(function () { form.submit(); });
        });
    }


        /* saqlangan videoni tahrirlagichda ochiq holda ko'rsatish */
    function loadSaved(u, pos) {
        if (!isVideo || !u) return;
        fx = (pos && pos.x != null ? pos.x : 50) / 100;
        fy = (pos && pos.y != null ? pos.y : 50) / 100;
        el = document.createElement('video');
        el.muted = true; el.loop = true; el.autoplay = true; el.playsInline = true;
        el.onloadedmetadata = function () {
            nw = el.videoWidth; nh = el.videoHeight;
            empty.hidden = true; editor.hidden = false;
            layout();
        };
        el.src = u;
        stage.insertBefore(el, stage.firstChild);
        $('.me-name').textContent = decodeURIComponent(u.split('/').pop());
        $('.me-size').textContent = 'Saqlangan video';
    }
    loadSaved(savedUrl, savedPos);

    window.addEventListener('resize', function () { if (el && !editor.hidden) layout(); });
    form.addEventListener('reset', function () { setTimeout(clear, 0); });
}
setupMedia('wallImage', 8, false);
setupMedia('wallVideo', 450, true);
    updatePreviewBg();

  /* ---------- Dam olish vaqti (v2) ---------- */
(function () {
    var $ = function (id) { return document.getElementById(id); };
    var form = $('settingsForm'), tgl = $('qhEnabledToggle'), si = $('qhStartInput'), ei = $('qhEndInput');
    var msg = $('qhMessageInput'), msgPrev = $('qhMessagePreviewText'), cnt = $('qhCount');
    var track = $('qhTrack'), seg1 = $('qhSeg1'), seg2 = $('qhSeg2'), nowEl = $('qhNow');
    var hs = $('qhHandleS'), he = $('qhHandleE'), tipS = $('qhTipS'), tipE = $('qhTipE');
    var hero = $('qhHero'), hTitle = $('qhHeroTitle'), hSub = $('qhHeroSub'), body = $('qhBody');
    var pill = $('qhStatusPill'), pillTxt = $('qhStatusPillText'), hint = $('qhRangeHint');
    var sumA = $('qhSumAllow'), sumQ = $('qhSumQuiet');
    var STEP = 15, DEFAULT_MSG = "Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙";

    function pad(n) { return (n < 10 ? '0' : '') + n; }
    function toMin(v) { var p = (v || '00:00').split(':'); return (parseInt(p[0], 10) || 0) * 60 + (parseInt(p[1], 10) || 0); }
    function toHHMM(m) { m = ((m % 1440) + 1440) % 1440; return pad(Math.floor(m / 60)) + ':' + pad(m % 60); }
    function pct(m) { return (m / 1440 * 100) + '%'; }
    function dur(min) {
        var h = Math.floor(min / 60), m = min % 60;
        return (h ? h + ' soat' : '') + (h && m ? ' ' : '') + (m ? m + ' daqiqa' : (h ? '' : '0 daqiqa'));
    }
    function within(n, s, e) {
        if (s === e) return true;
        return s < e ? (n >= s && n < e) : (n >= s || n < e);
    }

    function refresh() {
        var s = toMin(si.value || '06:00'), e = toMin(ei.value || '22:00');
        var enabled = tgl.checked;
        var d = new Date(), n = d.getHours() * 60 + d.getMinutes();
        var allow = s === e ? 1440 : (s < e ? e - s : 1440 - s + e);

        /* chiziq */
        if (s === e) {
            seg1.style.left = '0'; seg1.style.width = '100%'; seg2.hidden = true;
        } else if (s < e) {
            seg1.style.left = pct(s); seg1.style.width = pct(e - s); seg2.hidden = true;
        } else {
            seg1.style.left = '0'; seg1.style.width = pct(e);
            seg2.hidden = false; seg2.style.left = pct(s); seg2.style.width = pct(1440 - s);
        }
        hs.style.left = pct(s); he.style.left = pct(e === 0 && s !== 0 ? 1440 : e);
        tipS.textContent = toHHMM(s); tipE.textContent = toHHMM(e);
        nowEl.style.left = pct(n);

        /* yig'indi */
        sumA.textContent = dur(allow);
        sumQ.textContent = dur(1440 - allow);
        hint.textContent = s === e
            ? "Boshlanish va tugash vaqti bir xil — cheklov yo'q, yozishmalar 24 soat ochiq."
            : (s > e ? "Tungi oraliq: " + toHHMM(s) + " dan ertasi kuni " + toHHMM(e) + " gacha yozishmalar ochiq."
                     : "Yozishmalar " + toHHMM(s) + " dan " + toHHMM(e) + " gacha ochiq, undan tashqarida eslatma ko'rsatiladi.");

        /* presetlar */
        document.querySelectorAll('.qh-preset').forEach(function (b) {
            b.classList.toggle('active', toMin(b.dataset.s) === s && toMin(b.dataset.e) === e);
        });

        /* holat */
        body.classList.toggle('is-disabled', !enabled);
        hero.classList.remove('is-quiet', 'is-off');
        var open = within(n, s, e);

        if (!enabled) {
            hero.classList.add('is-off');
            hTitle.textContent = "Dam olish vaqti o'chirilgan";
            hSub.textContent = 'Yozishmalar istalgan vaqtda ochiq. Yoqsangiz, belgilangan soatlardan tashqarida eslatma chiqadi.';
            pill.className = 'qh-status-pill is-active'; pillTxt.textContent = "O'chirilgan";
            return;
        }
        var left = null;
        if (s !== e) {
            var target = open ? e : s;
            left = (target - n + 1440) % 1440 || 1440;
        }
        if (open) {
            hTitle.textContent = 'Hozir yozishmalar ochiq';
            hSub.textContent = left ? 'Tinch soat boshlanishiga ' + dur(left) + ' qoldi (' + toHHMM(e) + ').' : '24 soat ochiq, cheklov yo\'q.';
            pill.className = 'qh-status-pill is-active'; pillTxt.textContent = 'Hozir: Faol';
        } else {
            hero.classList.add('is-quiet');
            hTitle.textContent = 'Hozir tinch soat';
            hSub.textContent = 'Yozishmalar ' + dur(left) + 'dan keyin, soat ' + toHHMM(s) + ' da ochiladi.';
            pill.className = 'qh-status-pill is-quiet'; pillTxt.textContent = 'Hozir: Tinch soat';
        }
    }

    /* tutqichlarni sudrash */
    function bindHandle(handle, input) {
        var dragging = false;
        handle.addEventListener('pointerdown', function (ev) {
            dragging = true; handle.setPointerCapture(ev.pointerId); handle.classList.add('is-drag'); ev.preventDefault();
        });
        handle.addEventListener('pointermove', function (ev) {
            if (!dragging) return;
            var r = track.getBoundingClientRect();
            var ratio = Math.max(0, Math.min(1, (ev.clientX - r.left) / r.width));
            var m = Math.round(ratio * 1440 / STEP) * STEP;
            input.value = toHHMM(m % 1440);
            refresh();
        });
        function end() { dragging = false; handle.classList.remove('is-drag'); }
        handle.addEventListener('pointerup', end);
        handle.addEventListener('pointercancel', end);
        handle.addEventListener('keydown', function (ev) {
            var delta = ev.key === 'ArrowRight' ? STEP : ev.key === 'ArrowLeft' ? -STEP : 0;
            if (!delta) return;
            ev.preventDefault();
            input.value = toHHMM(toMin(input.value) + delta);
            refresh();
        });
    }
    bindHandle(hs, si);
    bindHandle(he, ei);

    /* shablonlar */
    document.querySelectorAll('.qh-preset').forEach(function (b) {
        b.addEventListener('click', function () { si.value = b.dataset.s; ei.value = b.dataset.e; refresh(); });
    });

    /* xabar matni */
    function refreshMsg() {
        msgPrev.textContent = msg.value.trim() || DEFAULT_MSG;
        cnt.textContent = msg.value.length;
    }
    msg.addEventListener('input', refreshMsg);
    document.querySelectorAll('.qh-chip').forEach(function (c) {
        c.addEventListener('click', function () { msg.value = c.dataset.t; refreshMsg(); });
    });

    [tgl, si, ei].forEach(function (el) { el.addEventListener('change', refresh); el.addEventListener('input', refresh); });
    form.addEventListener('reset', function () { setTimeout(function () { refresh(); refreshMsg(); }, 0); });

    refresh(); refreshMsg();
    setInterval(refresh, 30000);
})(); // holatni har daqiqada yangilab turadi

       /* ---------- Chap navigatsiya: bosilganda scroll + scrollspy ---------- */
    var navItems = document.querySelectorAll('.set-nav-item');
    var navList = document.getElementById('navList');
    var scrollArea = document.getElementById('scrollArea');
    var topbarTitle = document.getElementById('topbarTitle');
    var sections = document.querySelectorAll('.set-section');
    var titleMap = {};
    var spyLock = false, spyLockTimer = null;

    function revealNavItem(item) {
        if (!item || !navList) return;
        var listRect = navList.getBoundingClientRect();
        var itemRect = item.getBoundingClientRect();
        var margin = 90;
        if (itemRect.bottom + margin > listRect.bottom) {
            navList.scrollTo({ top: navList.scrollTop + (itemRect.bottom + margin - listRect.bottom), behavior: 'smooth' });
        } else if (itemRect.top - margin < listRect.top) {
            navList.scrollTo({ top: navList.scrollTop - (listRect.top - (itemRect.top - margin)), behavior: 'smooth' });
        }
    }

    function setActiveNav(id) {
        navItems.forEach(function (item) {
            var isActive = item.dataset.target === id;
            item.classList.toggle('active', isActive);
            if (isActive) revealNavItem(item);
        });
        if (titleMap[id]) topbarTitle.textContent = titleMap[id];
        liftDevicesCard(id);          // ⬅ SHU QATOR YANGI
    }

    navItems.forEach(function (item) {
        titleMap[item.dataset.target] = item.querySelector('.set-nav-item__text').firstChild.textContent;
        item.addEventListener('click', function () {
            var target = document.getElementById(item.dataset.target);
            if (!target) return;
            spyLock = true;
            clearTimeout(spyLockTimer);
            setActiveNav(item.dataset.target);
           var areaRect = scrollArea.getBoundingClientRect();
var targetRect = target.getBoundingClientRect();
scrollArea.scrollTo({
    top: scrollArea.scrollTop + (targetRect.top - areaRect.top) - 10,
    behavior: 'smooth'
});
            spyLockTimer = setTimeout(function () { spyLock = false; }, 800);
        });
    });

    function updateSpy() {
        if (spyLock) return;
        var areaTop = scrollArea.getBoundingClientRect().top;
        var current = sections[0].id;
        sections.forEach(function (s) {
            if (s.getBoundingClientRect().top - areaTop <= 80) current = s.id;
        });
        if (scrollArea.scrollTop + scrollArea.clientHeight >= scrollArea.scrollHeight - 4) {
            current = sections[sections.length - 1].id;
        }
        setActiveNav(current);
    }


    /* "Faol qurilmalar" kartasi: Maxfiylik bo'limida tepaga ko'tariladi */
    var devicesCard = document.getElementById('devicesCard');
    var panelEl = document.querySelector('.set-preview-panel');

 function liftDevicesCard(sectionId) {
    if (!devicesCard || !panelEl) return;

    if (sectionId === 'sec-privacy') {
        // Panelni "Akkaunt" kartasi tepaga chiqquncha scroll qilamiz
        var accountCard = devicesCard.previousElementSibling;
        var target = accountCard ? accountCard.offsetTop - 20 : devicesCard.offsetTop - 20;
        panelEl.scrollTo({ top: target, behavior: 'smooth' });
        devicesCard.classList.add('is-lifted');
    } else {
        panelEl.scrollTo({ top: 0, behavior: 'smooth' });
        devicesCard.classList.remove('is-lifted');
    }
}


window.addEventListener('scroll', function () {
    if (window.scrollY || document.documentElement.scrollTop || document.body.scrollTop) {
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    }
}, true);


    scrollArea.addEventListener('scroll', updateSpy, { passive: true });
    updateSpy();











/* ---------- Bildirishnomalar: haqiqiy toast + namuna ---------- */
var NOTIF_SAMPLES = [
    { n: 'Malika', t: "Salom! Ertaga uchrashuvni soat nechchida qilamiz?" },
    { n: 'Jasur', t: "Rasmni yubordim, ko'rib chiqing 📷" },
    { n: 'Jamoa guruhi', t: 'Sardor: Hisobot tayyor, tekshirib bering ✅' }
];
var npSampleIdx = 0, npStacks = {};

function npVal(name) { var e = document.querySelector('input[name="' + name + '"]:checked'); return e ? e.value : null; }
function npBeep() {
    try {
        var C = window.AudioContext || window.webkitAudioContext, ctx = new C(), o = ctx.createOscillator(), g = ctx.createGain();
        o.type = 'sine'; o.frequency.setValueAtTime(880, ctx.currentTime); o.frequency.exponentialRampToValueAtTime(1320, ctx.currentTime + .12);
        g.gain.setValueAtTime(.0001, ctx.currentTime); g.gain.exponentialRampToValueAtTime(.18, ctx.currentTime + .02); g.gain.exponentialRampToValueAtTime(.0001, ctx.currentTime + .35);
        o.connect(g); g.connect(ctx.destination); o.start(); o.stop(ctx.currentTime + .36);
    } catch (e) {}
}
function npClearStacks() {
    Object.keys(npStacks).forEach(function (k) { npStacks[k].remove(); delete npStacks[k]; });
}
function npEsc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

/* Boshqa sahifalarda ham ishlatish uchun: window.ChatOVBSNotify.show({...}) */
function npShow(data, cfg) {
    var pos = cfg.pos || 'bottom-right', style = cfg.style || 'card', dur = cfg.dur || 6;
    var stack = npStacks[pos];
    if (!stack) {
        stack = document.createElement('div');
        stack.className = 'ct-stack pos-' + pos;
        page.appendChild(stack);
        npStacks[pos] = stack;
    }
    var name = cfg.sender ? data.n : "ChatO'VBS";
    var text = cfg.preview ? data.t : 'Yangi xabar';
    var t = document.createElement('div');
    t.className = 'ct' + (style === 'compact' ? ' ct--compact' : style === 'minimal' ? ' ct--minimal' : '');
    t.style.setProperty('--dur', dur + 's');
    var now = new Date();
    var time = ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2);
    t.innerHTML =
        (cfg.avatar || style === 'minimal' ? '<span class="ct__av">' + npEsc(name.charAt(0).toUpperCase()) + '</span>' : '') +
        '<div class="ct__body"><div class="ct__top"><span class="ct__name">' + npEsc(name) + '</span><span class="ct__time">' + time + '</span></div>' +
        '<div class="ct__text">' + npEsc(text) + '</div></div>' +
        '<button type="button" class="ct__x" aria-label="Yopish">×</button><span class="ct__bar"></span>';
    function close() {
        if (t.classList.contains('is-out')) return;
        t.classList.add('is-out');
        setTimeout(function () { t.remove(); }, 230);
    }
    t.addEventListener('click', close);
    t.querySelector('.ct__x').addEventListener('click', function (e) { e.stopPropagation(); close(); });
    var timer = setTimeout(close, dur * 1000);
    t.addEventListener('mouseenter', function () { clearTimeout(timer); });
    t.addEventListener('mouseleave', function () { timer = setTimeout(close, 1500); });
    stack.appendChild(t);
    while (stack.children.length > 4) stack.firstChild.remove();
    if (cfg.sound) npBeep();
}
window.ChatOVBSNotify = { show: npShow };

function npCfg() {
    return {
        pos: npVal('notif_position'), style: npVal('notif_style'),
        dur: parseInt(document.getElementById('npDuration').value, 10),
        preview: document.getElementById('npPreview').checked,
        sender: document.getElementById('npSender').checked,
        avatar: document.getElementById('npAvatar').checked,
        sound: document.getElementById('npSound').checked
    };
}
function npTest(fresh) {
    if (fresh) npClearStacks();
    var s = NOTIF_SAMPLES[npSampleIdx++ % NOTIF_SAMPLES.length];
    var cfg = npCfg();
    npShow(s, cfg);
    if (document.getElementById('npSystem').checked && 'Notification' in window && Notification.permission === 'granted') {
        try { new Notification(cfg.sender ? s.n : "ChatO'VBS", { body: cfg.preview ? s.t : 'Yangi xabar' }); } catch (e) {}
    }
}

var npDuration = document.getElementById('npDuration'), npDurVal = document.getElementById('npDurVal');
var npPermText = document.getElementById('npPermText'), npPermBtn = document.getElementById('npPermBtn');
function npRefreshPerm() {
    if (!('Notification' in window)) { npPermText.textContent = "Brauzer qo'llamaydi"; npPermBtn.style.display = 'none'; return; }
    var p = Notification.permission;
    npPermText.textContent = p === 'granted' ? 'Ruxsat berilgan ✓' : p === 'denied' ? "Bloklangan (brauzer sozlamasidan oching)" : "So'ralmagan";
    npPermBtn.style.display = p === 'default' ? '' : 'none';
}
npPermBtn.addEventListener('click', function () {
    Notification.requestPermission().then(function () { npRefreshPerm(); document.getElementById('npSystem').checked = Notification.permission === 'granted'; });
});
document.getElementById('npSystem').addEventListener('change', function () {
    if (this.checked && 'Notification' in window && Notification.permission === 'default') npPermBtn.click();
});
npRefreshPerm();

document.getElementById('npTestBtn').addEventListener('click', function () { npTest(true); });
var npDurMinus = document.getElementById('npDurMinus');
var npDurPlus = document.getElementById('npDurPlus');

function npDurRefresh() {
    var v = parseInt(npDuration.value, 10);
    var min = parseInt(npDuration.min, 10), max = parseInt(npDuration.max, 10);
    npDurVal.textContent = v + ' soniya';
    npDuration.style.setProperty('--pct', ((v - min) / (max - min) * 100) + '%');
    npDurMinus.disabled = v <= min;
    npDurPlus.disabled = v >= max;
}
function npDurStep(delta) {
    var min = parseInt(npDuration.min, 10), max = parseInt(npDuration.max, 10);
    npDuration.value = Math.max(min, Math.min(max, parseInt(npDuration.value, 10) + delta));
    npDurRefresh();
    npTest(true); // o'zgarishni darhol ko'rsatadi
}

npDurMinus.addEventListener('click', function () { npDurStep(-1); });
npDurPlus.addEventListener('click', function () { npDurStep(1); });
npDuration.addEventListener('input', npDurRefresh);
document.getElementById('settingsForm').addEventListener('reset', function () { setTimeout(npDurRefresh, 0); });
npDurRefresh();
document.querySelectorAll('input[name="notif_position"], input[name="notif_style"]').forEach(function (r) {
    r.addEventListener('change', function () { npTest(true); });
});
['npPreview', 'npSender', 'npAvatar'].forEach(function (id) {
    document.getElementById(id).addEventListener('change', function () { npTest(true); });
});
npDuration.addEventListener('change', function () { npTest(true); });
document.getElementById('npMaster').addEventListener('change', function () {
    var on = this.checked;
    document.querySelectorAll('#sec-notifications .np-layout, #sec-notifications .set-grid-2').forEach(function (el) {
        el.style.opacity = on ? '1' : '.45'; el.style.pointerEvents = on ? 'auto' : 'none';
    });
});
document.getElementById('npMaster').dispatchEvent(new Event('change'));










/* ---------- Sozlamalarni asosiy chat uchun saqlash ---------- */
var NOTIF_PREFS_KEY = 'chatovbs_notif_prefs';
function saveNotifPrefs() {
    function chk(n) { var e = document.querySelector('input[name="' + n + '"]'); return !!(e && e.checked); }
    var p = {
        notifications: chk('notifications'), sound: chk('sound'),
        notif_preview: chk('notif_preview'), notif_show_sender: chk('notif_show_sender'),
        notif_show_avatar: chk('notif_show_avatar'), notif_system: chk('notif_system'),
        group_notifications: chk('group_notifications'),
        notif_position: npVal('notif_position') || 'bottom-right',
        notif_style: npVal('notif_style') || 'card',
        notif_duration: parseInt(document.getElementById('npDuration').value, 10) || 6
    };
    try { localStorage.setItem(NOTIF_PREFS_KEY, JSON.stringify(p)); } catch (e) {}
}
document.getElementById('settingsForm').addEventListener('change', saveNotifPrefs);
document.getElementById('settingsForm').addEventListener('submit', saveNotifPrefs);
saveNotifPrefs();













/* ---------- Hisob statistikasi: lichka / kanal / guruh ---------- */
fetch("{{ url('/chat-list') }}", { headers: { 'Accept': 'application/json' } })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        var chats = data.chats || [];
        var entities = data.entities || [];

        var personal = chats.length;
        var channels = 0, groups = 0;

        entities.forEach(function (e) {
            if (e.type === 'channel') {
                channels++;
                if (e.chat_name) groups++;      // kanalga biriktirilgan muhokama chati
            } else {
                groups++;                        // alohida yaratilgan guruh/chat
            }
        });

        document.getElementById('statPersonal').textContent = personal;
        document.getElementById('statChannels').textContent = channels;
        document.getElementById('statGroups').textContent = groups;
    })
    .catch(function () {
        ['statPersonal', 'statChannels', 'statGroups'].forEach(function (id) {
            document.getElementById(id).textContent = '0';
        });
    });
    })();











    /* ---------- Faol qurilma: haqiqiy ma'lumot ---------- */
(function () {
    var ua = navigator.userAgent;

    var os = /Windows/i.test(ua) ? 'Windows'
           : /Android/i.test(ua) ? 'Android'
           : /iPhone|iPad|iPod/i.test(ua) ? 'iOS'
           : /Mac OS X/i.test(ua) ? 'macOS'
           : /Linux/i.test(ua) ? 'Linux' : "Noma'lum tizim";

    var browser = /Edg\//i.test(ua) ? 'Edge'
                : /OPR\//i.test(ua) ? 'Opera'
                : /Firefox\//i.test(ua) ? 'Firefox'
                : /Chrome\//i.test(ua) ? 'Chrome'
                : /Safari\//i.test(ua) ? 'Safari' : 'Brauzer';

    document.getElementById('devName').textContent = os + ' · ' + browser;

    if (/Android|iPhone|iPad|iPod/i.test(ua)) {
        document.getElementById('devIcon').innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>';
    }

    var REGIONS = {
        'Jizzakh': 'Jizzax viloyati', 'Tashkent': 'Toshkent', 'Samarkand': 'Samarqand viloyati',
        'Bukhara': 'Buxoro viloyati', 'Andijan': 'Andijon viloyati', 'Fergana': "Farg'ona viloyati",
        'Namangan': 'Namangan viloyati', 'Navoiy': 'Navoiy viloyati', 'Khorezm': 'Xorazm viloyati',
        'Kashkadarya': 'Qashqadaryo viloyati', 'Surkhandarya': 'Surxondaryo viloyati',
        'Syrdarya': 'Sirdaryo viloyati', 'Karakalpakstan': "Qoraqalpog'iston"
    };

    function setMeta(place) {
        document.getElementById('devMeta').textContent = (place ? place + ' · ' : '') + 'hozir faol';
    }

    var saved = null;
    try { saved = localStorage.getItem('chatovbs_user_place'); } catch (e) {}
    if (saved) setMeta(saved);

    fetch('https://ipwho.is/')
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (!d || !d.success) { if (!saved) setMeta(''); return; }
            var key = Object.keys(REGIONS).find(function (k) { return (d.region || '').indexOf(k) !== -1; });
            var place = key ? REGIONS[key] : (d.region || d.city || '');
            setMeta(place);
            try { localStorage.setItem('chatovbs_user_place', place); } catch (e) {}
        })
        .catch(function () { if (!saved) setMeta(''); });
})();
</script>




<script>
(function () {
    var wifi = Array.prototype.slice.call(document.querySelectorAll('input[data-dl="wifi"]'));
    var mobile = Array.prototype.slice.call(document.querySelectorAll('input[data-dl="mobile"]'));
    var wifiOut = document.getElementById('dlCountWifi');
    var mobileOut = document.getElementById('dlCountMobile');

    function count(list) {
        return list.filter(function (i) { return i.checked; }).length + ' / ' + list.length + ' yoqilgan';
    }
    function refresh() {
        wifiOut.textContent = count(wifi);
        mobileOut.textContent = count(mobile);
    }
    function setAll(list, value) {
        list.forEach(function (i) { i.checked = value; });
    }

    document.getElementById('dlPresets').addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-preset]');
        if (!btn) return;
        var p = btn.dataset.preset;
        setAll(wifi, p !== 'none');
        setAll(mobile, p === 'all');
        refresh();
    });

    wifi.concat(mobile).forEach(function (i) { i.addEventListener('change', refresh); });
    document.getElementById('settingsForm').addEventListener('reset', function () { setTimeout(refresh, 0); });
    refresh();
})();
</script>








<script>
(function () {
    /* Madhiya fayllari:  public/audio/anthems/uz.mp3, kaa.mp3, ru.mp3, en.mp3 */
    var ANTHEMS = {
        uz:  { src: "{{ asset('audio/anthems/uz.mp3') }}",  file: 'public/audio/anthems/uz.mp3',  title: "O'zbekiston Respublikasining Davlat madhiyasi" },
        ko:  { src: "{{ asset('audio/anthems/ko.mp3') }}",  file: 'public/audio/anthems/ko.mp3',  title: 'Aegukga (애국가) — Janubiy Koreya davlat madhiyasi' },
        ru:  { src: "{{ asset('audio/anthems/ru.mp3') }}",  file: 'public/audio/anthems/ru.mp3',  title: 'Государственный гимн Российской Федерации' },
        en:  { src: "{{ asset('audio/anthems/en.mp3') }}",  file: 'public/audio/anthems/en.mp3',  title: 'God Save the King — Buyuk Britaniya madhiyasi' }
    };
    var MAX_SECONDS = 410;
    var FADE_SECONDS = 2;

    var grid = document.getElementById('langGrid');
    var bar = document.getElementById('anthemBar');
    var barFlag = document.getElementById('anthemBarFlag');
    var barTitle = document.getElementById('anthemBarTitle');
    var barStatus = document.getElementById('anthemBarStatus');
    var barProgress = document.getElementById('anthemBarProgress');
    var stopBtn = document.getElementById('anthemStopBtn');
    var volInput = document.getElementById('anthemVolume');
    var autoplay = document.getElementById('anthemAutoplay');
    var form = document.getElementById('settingsForm');

    var audio = new Audio();
    audio.preload = 'auto';
    var current = null;


    var BOOST = 2.5; // 1 = o'zgarishsiz, 2 = ikki baravar, 3 = uch baravar

var audioCtx = null, gainNode = null;
function ensureBoost() {
    if (audioCtx) return;
    try {
        var AC = window.AudioContext || window.webkitAudioContext;
        audioCtx = new AC();
        var src = audioCtx.createMediaElementSource(audio);
        gainNode = audioCtx.createGain();
        var comp = audioCtx.createDynamicsCompressor(); // ovoz "yorilib" ketmasligi uchun
        src.connect(gainNode);
        gainNode.connect(comp);
        comp.connect(audioCtx.destination);
    } catch (e) {}
}

  function volume() { return (parseInt(volInput.value, 10) || 0) / 100; }
function applyVolume(v) {
    if (gainNode) { audio.volume = 1; gainNode.gain.value = v * BOOST; }
    else { audio.volume = v; }
}

    function setPlayingUI(code) {
        grid.querySelectorAll('.lang-opt').forEach(function (el) {
            el.classList.toggle('is-playing', el.dataset.lang === code);
        });
    }

    function stop() {
        audio.pause();
        audio.removeAttribute('src');
        audio.load();
        current = null;
        setPlayingUI(null);
        bar.hidden = true;
        barProgress.style.width = '0';
    }

    function showBar(code, statusText, isError) {
        var opt = grid.querySelector('.lang-opt[data-lang="' + code + '"]');
        barFlag.innerHTML = opt ? opt.querySelector('.lang-opt__flag').innerHTML : '';
        barTitle.textContent = ANTHEMS[code].title;
        barStatus.textContent = statusText;
        barStatus.classList.toggle('is-error', !!isError);
        bar.hidden = false;
    }

    function play(code) {
        var a = ANTHEMS[code];
        if (!a) return;
        stop();
        current = code;
        audio.src = a.src;
        audio.currentTime = 0;
       ensureBoost();
if (audioCtx && audioCtx.state === 'suspended') audioCtx.resume();
applyVolume(volume());
        setPlayingUI(code);
        showBar(code, 'Chalinmoqda…', false);
        var p = audio.play();
        if (p && p.catch) {
            p.catch(function () {
                setPlayingUI(null);
                showBar(code, 'Fayl topilmadi yoki ochilmadi: ' + a.file, true);
                current = null;
            });
        }
    }

    audio.addEventListener('error', function () {
        if (!current) return;
        var code = current;
        setPlayingUI(null);
        showBar(code, 'Fayl topilmadi: ' + ANTHEMS[code].file, true);
        current = null;
    });

    audio.addEventListener('timeupdate', function () {
        if (!current) return;
        var limit = Math.min(MAX_SECONDS, audio.duration || MAX_SECONDS);
        var left = limit - audio.currentTime;
        barProgress.style.width = Math.min(100, audio.currentTime / limit * 100) + '%';
        if (left <= FADE_SECONDS) applyVolume(Math.max(0, volume() * (left / FADE_SECONDS)));
        if (left <= 0) stop();
    });
    audio.addEventListener('ended', stop);

    volInput.addEventListener('input', function () { if (current) applyVolume(volume()); });
    stopBtn.addEventListener('click', stop);

    grid.querySelectorAll('.lang-opt__play').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var code = btn.dataset.play;
            if (current === code) stop(); else play(code);
        });
    });

    var languageText = {
        uz: {
            sectionTitle: 'Til va mintaqa',
            sectionSubtitle: 'Ilova qaysi tilda ko\'rinishini va sana hamda vaqt qanday yozilishini tanlang.',
            cardTitle: 'Ilova tili',
            anthemToggleTitle: 'Til tanlanganda madhiya chalinsin',
            anthemToggleHint: 'Til kartasini bosganingizda o\'sha davlatning madhiyasi ovoz chiqarib chalinadi. Har bir kartadagi tugma orqali tilni almashtirmasdan ham tinglab ko\'rishingiz mumkin.'
        },
        ru: {
            sectionTitle: 'Язык и регион',
            sectionSubtitle: 'Выберите язык интерфейса и формат даты/времени.',
            cardTitle: 'Язык приложения',
            anthemToggleTitle: 'Включить гимн при выборе языка',
            anthemToggleHint: 'При выборе языка будет проигрываться государственный гимн страны. Вы можете прослушать его без смены языка через кнопку на карточке.'
        },
        en: {
            sectionTitle: 'Language and region',
            sectionSubtitle: 'Choose the app language and how the date and time are displayed.',
            cardTitle: 'App language',
            anthemToggleTitle: 'Play anthem when language is selected',
            anthemToggleHint: 'When you tap a language card, that country\'s anthem will play. You can also listen without switching languages using the button on each card.'
        },
        ko: {
            sectionTitle: '언어 및 지역',
            sectionSubtitle: '앱 언어와 날짜/시간 표시 형식을 선택하세요.',
            cardTitle: '앱 언어',
            anthemToggleTitle: '언어 선택 시 애국가 재생',
            anthemToggleHint: '언어 카드를 선택하면 해당 국가의 애국가가 재생됩니다. 각 카드의 버튼으로 언어를 바꾸지 않고도 들을 수 있습니다.'
        }
    };

    function applyLanguageText(code) {
        var text = languageText[code] || languageText.uz;
        var sectionTitle = document.getElementById('langSectionTitle');
        var sectionSubtitle = document.getElementById('langSectionSubtitle');
        var cardTitle = document.getElementById('langCardTitle');
        var anthemToggleTitle = document.getElementById('anthemToggleTitle');
        var anthemToggleHint = document.getElementById('anthemToggleHint');

        if (sectionTitle) sectionTitle.textContent = text.sectionTitle;
        if (sectionSubtitle) sectionSubtitle.textContent = text.sectionSubtitle;
        if (cardTitle) cardTitle.textContent = text.cardTitle;
        if (anthemToggleTitle) anthemToggleTitle.textContent = text.anthemToggleTitle;
        if (anthemToggleHint) anthemToggleHint.textContent = text.anthemToggleHint;
        document.documentElement.lang = code;
    }

    grid.querySelectorAll('input[name="language"]').forEach(function (r) {
        r.addEventListener('change', function () {
            applyLanguageText(r.value);
            window.dispatchEvent(new CustomEvent('chatovbs:language', { detail: r.value }));
            if (r.checked && autoplay.checked) play(r.value); else if (current) stop();
        });
    });

    var initialLang = (document.querySelector('input[name="language"]:checked') || document.querySelector('input[name="language"]'));
    if (initialLang) applyLanguageText(initialLang.value);

    window.addEventListener('beforeunload', stop);
    form.addEventListener('reset', stop);

    /* ---------- Sana va vaqt namunalari ---------- */
    function pad(n) { return (n < 10 ? '0' : '') + n; }

    function formatDate(d, fmt) {
        var dd = pad(d.getDate()), mm = pad(d.getMonth() + 1), yy = d.getFullYear();
        if (fmt === 'mdy') return mm + '/' + dd + '/' + yy;
        if (fmt === 'ymd') return yy + '-' + mm + '-' + dd;
        return dd + '.' + mm + '.' + yy;
    }
    function formatTime(d, is24) {
        var h = d.getHours(), m = pad(d.getMinutes());
        if (is24) return pad(h) + ':' + m;
        return (h % 12 || 12) + ':' + m + ' ' + (h < 12 ? 'AM' : 'PM');
    }


    var CHAT_MONTHS = ['yanvar','fevral','mart','aprel','may','iyun','iyul','avgust','sentabr','oktabr','noyabr','dekabr'];
function chatDateLabel(d, fmt) {
    if (fmt === 'ymd') return formatDate(d, 'ymd');
    var day = d.getDate(), month = CHAT_MONTHS[d.getMonth()];
    if (fmt === 'mdy') return month.charAt(0).toUpperCase() + month.slice(1) + ' ' + day;
    return day + '-' + month;
}

    var lpDate = document.getElementById('lpDate');
    var lpTimes = document.querySelectorAll('.lp-time');

    function refreshFormats() {
        var now = new Date();
        document.querySelectorAll('[data-date-example]').forEach(function (el) {
            el.textContent = formatDate(now, el.dataset.dateExample);
        });

        document.querySelectorAll('[data-chat-example]').forEach(function (el) {
    el.textContent = chatDateLabel(now, el.dataset.chatExample);
});

        document.querySelectorAll('[data-time-example]').forEach(function (el) {
            el.textContent = formatTime(now, el.dataset.timeExample === '24');
        });

        var dateRadio = document.querySelector('input[name="date_format"]:checked');
        var timeRadio = document.querySelector('input[name="time_format_24h"]:checked');
        var is24 = !timeRadio || timeRadio.value === '1';

        lpDate.textContent = chatDateLabel(now, dateRadio ? dateRadio.value : 'dmy');
        lpTimes.forEach(function (el, i) {
            el.textContent = formatTime(now, is24) + (i === lpTimes.length - 1 ? ' ✓✓' : '');
        });
    }

    document.querySelectorAll('input[name="date_format"], input[name="time_format_24h"]').forEach(function (r) {
        r.addEventListener('change', refreshFormats);
    });
    form.addEventListener('reset', function () { setTimeout(refreshFormats, 0); });
    refreshFormats();
    setInterval(refreshFormats, 30000);
})();
</script>










<script>
(function () {
    var tfa = document.getElementById('prTfa');
    var badge = document.getElementById('prTfaBadge');

    function refreshTfa() {
        badge.textContent = tfa.checked ? 'YOQILGAN' : "O'CHIQ";
        badge.className = 'pr-badge ' + (tfa.checked ? 'is-on' : 'is-off');
    }
    tfa.addEventListener('change', refreshTfa);
    document.getElementById('settingsForm').addEventListener('reset', function () { setTimeout(refreshTfa, 0); });
    refreshTfa();

    document.getElementById('prShowDevices').addEventListener('click', function () {
        var card = document.getElementById('devicesCard');
        var panel = document.querySelector('.set-preview-panel');
        if (!card || !panel || getComputedStyle(panel).display === 'none') {
            alert("Qurilmalar kartasi keng ekranda o'ng panelda ko'rinadi.");
            return;
        }
        panel.scrollTo({ top: card.offsetTop - 20, behavior: 'smooth' });
        card.classList.add('is-lifted');
    });
    var CSRF = document.querySelector('meta[name="csrf-token"]').content;
    function postJson(url, method, body) {
        return fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(body || {})
        }).then(function (r) { return r.json().then(function (d) { if (!r.ok) throw new Error(d.message || 'Xatolik'); return d; }); });
    }

    document.getElementById('prLogoutOthers').addEventListener('click', function () {
        var pw = prompt("Boshqa qurilmalardan chiqish uchun parolingizni kiriting:");
        if (!pw) return;
        postJson("{{ route('settings.logout-others') }}", 'POST', { password: pw })
            .then(function () { alert('Boshqa qurilmalardan chiqildi.'); })
            .catch(function (e) { alert(e.message); });
    });

    document.getElementById('prExportBtn').addEventListener('click', function () {
        window.location.href = "{{ route('settings.export') }}";
    });

    document.getElementById('prDeleteBtn').addEventListener('click', function () {
        if (!confirm("Hisobingiz butunlay o'chiriladi. Buni qaytarib bo'lmaydi. Davom etasizmi?")) return;
        var pw = prompt("Tasdiqlash uchun parolingizni kiriting:");
        if (!pw) return;
        postJson("{{ route('settings.delete-account') }}", 'DELETE', { password: pw })
            .then(function () { window.location.href = "{{ url('/') }}"; })
            .catch(function (e) { alert(e.message); });
    });



    document.getElementById('prBlockedBtn').addEventListener('click', function () {
        alert("Bloklangan foydalanuvchilar ro'yxati tez orada qo'shiladi.");
    });
})();
</script>












<script>
(function () {
    var form = document.getElementById('settingsForm');
    var page = document.getElementById('setPage');
    var saveBtn = form.querySelector('button[type="submit"]');

    var ov = document.createElement('div');
    ov.className = 'up-overlay';
    ov.innerHTML =
        '<div class="up-card">' +
            '<div class="up-head"><span class="up-title">Yuklanmoqda…</span><span class="up-pct">0%</span></div>' +
            '<div class="up-bar"><i></i></div>' +
            '<div class="up-info"><span class="up-mb"><b>0.0</b> MB</span><span class="up-speed"></span></div>' +
            '<p class="up-msg" hidden></p>' +
            '<div class="up-actions"><button type="button" class="btn-ghost up-cancel">Bekor qilish</button></div>' +
        '</div>';
    page.appendChild(ov);

    var $ = function (s) { return ov.querySelector(s); };
    var title = $('.up-title'), pct = $('.up-pct'), bar = $('.up-bar'), fill = $('.up-bar i');
    var mbEl = $('.up-mb'), speedEl = $('.up-speed'), msg = $('.up-msg'), cancel = $('.up-cancel');
    var xhr = null;

    function mb(b) { return (b / 1048576).toFixed(1); }
    function showMsg(text, isError) { msg.hidden = false; msg.textContent = text; msg.classList.toggle('is-error', !!isError); }
    function close() { ov.classList.remove('is-open'); saveBtn.disabled = false; xhr = null; }

    cancel.addEventListener('click', function () {
        if (xhr && xhr.readyState !== 4) xhr.abort();
        close();
    });

    form.addEventListener('submit', function (e) {
        if (e.defaultPrevented) return;              // rasm qirqish o'zi hal qilyapti

        var total = 0;
        form.querySelectorAll('input[type="file"]').forEach(function (i) {
            for (var k = 0; k < i.files.length; k++) total += i.files[k].size;
        });
        if (total < 2 * 1048576) return;             // kichik fayl: oddiy saqlash

        e.preventDefault();
        saveBtn.disabled = true;

        title.textContent = 'Video yuklanmoqda…';
        pct.textContent = '0%';
        fill.style.width = '0';
        bar.classList.remove('is-busy');
        mbEl.innerHTML = '<b>0.0</b> / ' + mb(total) + ' MB';
        speedEl.textContent = '';
        msg.hidden = true;
        cancel.textContent = 'Bekor qilish';
        cancel.style.display = '';
        ov.classList.add('is-open');

        var started = Date.now();
        xhr = new XMLHttpRequest();
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');

        xhr.upload.onprogress = function (ev) {
            if (!ev.lengthComputable) return;
            var p = Math.min(100, ev.loaded / ev.total * 100);
            fill.style.width = p + '%';
            pct.textContent = Math.floor(p) + '%';
            mbEl.innerHTML = '<b>' + mb(ev.loaded) + '</b> / ' + mb(ev.total) + ' MB';
            var sec = (Date.now() - started) / 1000;
            if (sec > 0.5) speedEl.textContent = mb(ev.loaded / sec) + ' MB/s';
        };
        xhr.upload.onload = function () {
            title.textContent = "ChatO'VBS bo'limga qo'yilmoqda…";
            bar.classList.add('is-busy');
        };
        xhr.onload = function () {
            bar.classList.remove('is-busy');
            if (xhr.status >= 200 && xhr.status < 400) {
                fill.style.width = '100%'; pct.textContent = '100%';
                title.textContent = "Chat foniga qo'yildi ✓";
                cancel.style.display = 'none';
                setTimeout(function () { window.location.reload(); }, 900);
                return;
            }
            var text = 'Xatolik (' + xhr.status + ').';
            if (xhr.status === 419 || xhr.status === 413) {
                text = "Server faylni qabul qilmadi: fayl hajmi php.ini dagi upload_max_filesize / post_max_size dan katta.";
            } else {
                try {
                    var j = JSON.parse(xhr.responseText);
                    if (j.errors) text = j.errors[Object.keys(j.errors)[0]][0];
                    else if (j.message) text = j.message;
                } catch (err) {}
            }
            title.textContent = 'Saqlanmadi';
            showMsg(text, true);
            cancel.textContent = 'Yopish';
            saveBtn.disabled = false;
        };
        xhr.onerror = function () {
            bar.classList.remove('is-busy');
            title.textContent = 'Saqlanmadi';
            showMsg("Server bilan aloqa uzildi. Internetni tekshirib qayta urinib ko'ring.", true);
            cancel.textContent = 'Yopish';
            saveBtn.disabled = false;
        };
        xhr.onabort = function () { close(); };

        xhr.send(new FormData(form));
    });
})();
</script>
@include('partials.storage-ledger')
@include('partials.storage-ledger-ui')
@include('partials.language-runtime')
@endsection