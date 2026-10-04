@extends('layouts.app')

@section('content')
<style>
    /* Layout'ning o'z fon rangidan qat'iy nazar butun sahifani qora qilib qo'yamiz,
       va eski headerni (ChatO'VBS + akkaunt) yashiramiz — o'rniga o'zimiz top-bar chiqaramiz */
    html, body {
        background: #000000 !important;
    }
    body > *:not(#pfTopbar) {
        background: transparent;
    }
    .site-header {
        position: relative;
    }
    .site-header .site-user-dropdown {
        display: none !important;
    }

    :root {
        --bg: #000000;
        --panel: #0d0d0d;
        --panel-2: #141414;
        --panel-3: #1a1a1a;
        --line: rgba(255,255,255,0.08);
        --line-strong: rgba(255,255,255,0.18);
        --text: #ffffff;
        --muted: #8a8a8a;
        --accent: #ffffff;
        --accent-a: #7c5cff;
        --accent-b: #22c55e;
        --accent-c: #0ea5e9;
        --radius-lg: 24px;
        --radius-md: 16px;
        --radius-sm: 10px;
    }

    html.light-mode {
        --bg: #ffffff;
        --panel: #f6f6f7;
        --panel-2: #ececee;
        --panel-3: #e2e2e5;
        --line: rgba(0,0,0,0.08);
        --line-strong: rgba(0,0,0,0.16);
        --text: #0a0a0a;
        --muted: #68686e;
        --accent: #000000;
    }
    html.light-mode body { background: #ffffff !important; }

    /* ---- Custom top bar (marquee) ---- */
    #pfTopbar {
        position: relative;
        height: 36px;
        background: #000;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        overflow: hidden;
        display: flex;
        align-items: center;
        z-index: 50;
        margin: -1.5rem 0 0;
    }
    html.light-mode #pfTopbar {
        background: #fff;
        border-bottom: 1px solid rgba(0,0,0,0.08);
    }
    .pf-marquee {
        position: absolute;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.04em;
        color: #fff;
        animation: marquee 22s linear infinite;
    }
    html.light-mode .pf-marquee { color: #000; }
    @keyframes marquee {
        0% { transform: translateX(100vw); }
        100% { transform: translateX(-110%); }
    }
    .theme-toggle {
        position: absolute;
        right: 40px;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.2);
        background: transparent;
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background-color .6s ease, border-color .6s ease, color .6s ease, transform .2s ease;
        z-index: 25;
    }
    html.light-mode .theme-toggle {
        border-color: rgba(0,0,0,0.15);
        color: #000;
    }
    .theme-toggle:hover { transform: translateY(-50%) scale(1.08); }
    .theme-toggle svg { width: 15px; height: 15px; }
    .theme-toggle .icon-moon { display: block; }
    .theme-toggle .icon-sun { display: none; }
    html.light-mode .theme-toggle .icon-moon { display: none; }
    html.light-mode .theme-toggle .icon-sun { display: block; }

    /* ---- Header rang almashinishi ---- */
    .site-header {
        transition: background-color 1.2s ease;
    }
    .site-brand span,
    .site-brand .brand-apo,
    .site-nav-links .nav-link,
    #headerDino svg {
        transition: color 1.2s ease, fill 1.2s ease;
    }
    .site-header .container { position: relative; overflow: hidden; }

    .dino-ground {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 12px;
        height: 0;
        border-top: 1.5px dashed rgba(250,249,246,0.28);
        z-index: 5;
        width: 100%;
    }
    #headerDino {
        position: absolute;
        bottom: 12px;
        width: 24px;
        height: 24px;
        z-index: 21;
        transform: translateX(-50%);
    }
    #headerDino svg { width: 100%; height: 100%; display: block; }
    #headerDino .leg { animation: dino-leg .2s steps(1) infinite; transform-origin: center; }
    #headerDino.is-air .leg { animation-play-state: paused; }
    #headerDino.is-duck { transform-origin: bottom center; }
    #headerDino.is-duck svg { transform: scaleY(0.55) translateY(18%); }
    @keyframes dino-leg {
        0%, 49% { transform: scaleX(1); }
        50%, 100% { transform: scaleX(-1); }
    }
    .dino-cactus {
        position: absolute;
        bottom: 12px;
        width: 7px;
        height: 15px;
        background: #38ef7d;
        border-radius: 2px;
        z-index: 20;
    }
    .dino-cactus::before {
        content: "";
        position: absolute;
        left: -4px;
        top: 4px;
        width: 4px;
        height: 6px;
        background: #38ef7d;
        border-radius: 2px;
    }
    .dino-tree {
        position: absolute;
        bottom: 12px;
        width: 16px;
        height: 24px;
        z-index: 20;
    }
    .dino-tree svg { width: 100%; height: 100%; }
    .dino-bird {
        position: absolute;
        bottom: 40px;
        width: 18px;
        height: 12px;
        z-index: 20;
    }
    .dino-bird svg { width: 100%; height: 100%; }
    .dino-bird .wing { animation: bird-flap .25s steps(1) infinite; transform-origin: center; }
    @keyframes bird-flap {
        0%, 49% { transform: scaleY(1); }
        50%, 100% { transform: scaleY(0.4); }
    }

    * { box-sizing: border-box; }

    .pf {
        min-height: 100vh;
        background: var(--bg);
        color: var(--text);
        font-family: 'Inter', -apple-system, sans-serif;
        padding: 36px clamp(20px, 4vw, 56px) 90px;
        margin: -1px 0 0;
    }

    .pf__wrap { max-width: 1440px; margin: 0 auto; }

    /* ---- Top intro ---- */
    .pf__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 26px;
        animation: fadeDown .5s ease both;
    }
    .pf__back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--muted);
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: color .2s ease, transform .2s ease;
    }
    .pf__back:hover { color: var(--text); transform: translateX(-3px); }
    .pf__back svg { transition: transform .2s ease; }
    .pf__back:hover svg { transform: translateX(-2px); }

    .pf__intro {
        margin-bottom: 30px;
        animation: fadeUp .55s ease both;
        animation-delay: .05s;
    }
    .pf__intro h1 {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 6px;
        letter-spacing: -0.02em;
        background: linear-gradient(90deg, var(--text), var(--text) 60%, var(--muted));
        -webkit-background-clip: text;
        background-clip: text;
    }
    html.light-mode .pf__intro h1 { -webkit-text-fill-color: initial; background: none; }
    .pf__intro p {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.55;
        margin: 0;
        max-width: 600px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4ade80, #22c55e);
        color: #06210f;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 16px;
        border-radius: 12px;
        margin-bottom: 22px;
        animation: statusPop .4s cubic-bezier(.34,1.56,.64,1) both;
        box-shadow: 0 8px 24px rgba(34,197,94,0.25);
    }
    @keyframes statusPop {
        0% { opacity: 0; transform: translateY(-8px) scale(.9); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ---- Main split layout ---- */
    .pf__grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 28px;
        align-items: start;
    }

    /* generic stagger-in for the cards */
    .pf__left, .card {
        animation: fadeUp .55s cubic-bezier(.22,1,.36,1) both;
    }
    .pf__left { animation-delay: .08s; }
    #channelCard { animation-delay: .13s; }
    .pf__right .card:nth-of-type(1) { animation-delay: .14s; }
    #storiesCard { animation-delay: .26s; }

    /* Chap ustun: avatar + kanal ulash kartasi birga suriladi */
    .pf__left-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: sticky;
        top: 20px;
    }

    /* ---- Ikki karta orasidagi "elektr ilon" connector ---- */
    .pf__connector {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: -14px 0;
        height: 40px;
        position: relative;
        z-index: 3;
        pointer-events: none;
    }
    .pf__connector svg {
        width: 78%;
        height: 100%;
        overflow: visible;
    }
    .pf__connector-glow {
        fill: none;
        stroke: var(--accent-c);
        stroke-width: 7;
        stroke-linecap: round;
        opacity: .35;
        filter: blur(4px);
    }
    .pf__connector-line {
        fill: none;
        stroke: url(#pfConnectorGradient);
        stroke-width: 2.2;
        stroke-linecap: round;
        stroke-dasharray: 7 6;
        animation: pfConnectorFlow 1.1s linear infinite;
        filter: drop-shadow(0 0 4px rgba(14,165,233,0.65));
    }
    @keyframes pfConnectorFlow {
        to { stroke-dashoffset: -26; }
    }
    .pf__connector-dot {
        fill: #eafff6;
        filter: drop-shadow(0 0 6px rgba(34,197,94,0.9)) drop-shadow(0 0 10px rgba(14,165,233,0.7));
    }

    /* LEFT: big avatar */
    .pf__left {
        background: var(--card-color, var(--panel));
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 52px 30px 44px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: background-color .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .pf__left::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 50% -10%, rgba(255,255,255,0.09), transparent 55%);
        pointer-events: none;
    }
    .pf__left:hover {
        border-color: var(--line-strong);
        box-shadow: 0 18px 46px rgba(0,0,0,0.35);
    }

    .pf__left-topbar {
        position: absolute;
        top: 16px;
        right: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 6;
    }
    .pf__left-icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid var(--line);
        background: rgba(255,255,255,0.05);
        color: var(--text);
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background-color .2s ease, transform .2s ease, border-color .2s ease;
        padding: 0;
        position: relative;
        backdrop-filter: blur(6px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    html.light-mode .pf__left-icon-btn { background: rgba(0,0,0,0.04); }
    .pf__left-icon-btn:hover { background: rgba(255,255,255,0.12); border-color: var(--line-strong); transform: scale(1.1); }
    html.light-mode .pf__left-icon-btn:hover { background: rgba(0,0,0,0.08); }
    .pf__left-icon-btn svg { width: 13px; height: 13px; }
    .card-color-swatch {
        width: 13px;
        height: 13px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.35);
        display: block;
        background: var(--card-color, #ffffff);
        transition: transform .2s ease;
    }
    .card-color-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        border: none;
        padding: 0;
    }

    .avatar-menu {
        position: absolute;
        top: 50px;
        right: 16px;
        min-width: 200px;
        background: #161616;
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: 0 16px 34px rgba(0,0,0,0.5);
        padding: 6px;
        display: none;
        flex-direction: column;
        gap: 1px;
        z-index: 7;
        opacity: 0;
        transform: translateY(-6px) scale(.97);
        transition: opacity .16s ease, transform .16s ease;
    }
    html.light-mode .avatar-menu { background: #ffffff; box-shadow: 0 16px 34px rgba(0,0,0,0.18); }
    .avatar-menu.show { display: flex; opacity: 1; transform: translateY(0) scale(1); }
    .avatar-menu button {
        display: flex;
        align-items: center;
        gap: 10px;
        border: none;
        background: transparent;
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
        padding: 10px 11px;
        border-radius: 9px;
        cursor: pointer;
        text-align: left;
        width: 100%;
        font-family: inherit;
        transition: background-color .15s ease, padding-left .15s ease;
    }
    .avatar-menu button:hover { background: rgba(255,255,255,0.08); padding-left: 14px; }
    html.light-mode .avatar-menu button:hover { background: rgba(0,0,0,0.06); }
    .avatar-menu button svg { width: 16px; height: 16px; flex-shrink: 0; }
    .avatar-menu button.danger { color: #f87171; }

    .avatar-box {
        position: relative;
        width: 210px;
        height: 210px;
        cursor: pointer;
        margin-bottom: 22px;
    }
    .avatar-box__circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        background: var(--panel-2);
        border: 2px solid var(--line);
        display: grid;
        place-items: center;
        font: 800 68px 'Inter', sans-serif;
        color: #fff;
        transition: transform .3s cubic-bezier(.22,1,.36,1), border-color .3s ease, box-shadow .3s ease;
    }
    html.light-mode .avatar-box__circle { color: #000; }
    .avatar-box:hover .avatar-box__circle {
        transform: scale(1.035);
        border-color: #fff;
        box-shadow: 0 0 0 6px rgba(255,255,255,0.06);
    }
    html.light-mode .avatar-box:hover .avatar-box__circle { box-shadow: 0 0 0 6px rgba(0,0,0,0.05); }
    .avatar-box__circle img { width: 100%; height: 100%; object-fit: cover; }

    .avatar-box__btn {
        position: absolute;
        right: 8px;
        bottom: 8px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        color: #000;
        display: grid;
        place-items: center;
        border: 3px solid #000;
        transition: transform .25s cubic-bezier(.34,1.56,.64,1);
    }
    .avatar-box:hover .avatar-box__btn { transform: scale(1.14) rotate(-8deg); }
    .avatar-box__btn svg { width: 18px; height: 18px; }
    .avatar-box input[type=file] { display: none; }

    .pf__left h3 {
        font-size: 19px;
        font-weight: 700;
        margin: 0 0 4px;
        color: var(--card-text, var(--text));
        transition: color .3s ease;
    }
.pf__left .handle {
    color: var(--accent-c);
    font-size: 13px;
    font-weight: 600;
    margin: 0 0 14px;
    cursor: pointer;
    transition: opacity .2s ease, color .3s ease;
}
.pf__left .handle:hover {
    opacity: .8;
    text-decoration: underline;
}
    .pf__left p.desc {
        color: var(--card-text-muted, var(--muted));
        font-size: 12.5px;
        line-height: 1.5;
        margin: 0;
        max-width: 260px;
        transition: color .3s ease;
    }



.avatar-info-lines {
    display: flex;
    flex-direction: column;
    max-width: none;
    align-self: flex-start;
    text-align: left;
    width: 100%;
}
.info-line-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 12px 0;
    border-top: 1px solid var(--line);
}
.info-line-group:first-child {
    border-top: none;
    padding-top: 0;
}
.info-line-group:empty,
.info-line-group:has(> :only-child:empty) {
    display: none;
}
.info-line-label {
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--card-text-muted, var(--muted));
    opacity: .6;
    margin: 0 0 2px;
}
.avatar-channel-mini {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    padding: 8px 10px;
    border: 1px solid var(--line);
    border-radius: 13px;
    background: rgba(255,255,255,0.04);
    cursor: pointer;
    transition: background-color .2s ease, border-color .2s ease, transform .2s ease, box-shadow .2s ease;
}
html.light-mode .avatar-channel-mini { background: rgba(0,0,0,0.035); }
.avatar-channel-mini:hover,
.avatar-channel-mini:focus-visible {
    border-color: rgba(14,165,233,0.65);
    background: rgba(14,165,233,0.12);
    box-shadow: 0 8px 20px rgba(14,165,233,0.16);
    outline: none;
    transform: translateY(-1px);
}
.avatar-channel-mini:active { transform: scale(.985); }
.avatar-channel-mini__icon {
    width: 42px;
    height: 42px;
    flex: 0 0 42px;
    display: grid;
    place-items: center;
    overflow: hidden;
    border-radius: 50%;
    background: linear-gradient(135deg, #0ea5e9, #22c55e);
    color: #fff;
    font-size: 16px;
    font-weight: 800;
}
.avatar-channel-mini__icon img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.avatar-channel-mini__info {
    min-width: 0;
    overflow: hidden;
}
.avatar-channel-mini__name {
    overflow: hidden;
    color: var(--card-text, var(--text));
    font-size: 13px;
    font-weight: 700;
    line-height: 1.25;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.avatar-channel-mini__meta {
    overflow: hidden;
    margin-top: 3px;
    color: var(--card-text-muted, var(--muted));
    font-size: 11px;
    line-height: 1.25;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.pf__left p.desc.contact-line {
    display: none;
    align-items: center;
    justify-content: flex-start;
    gap: 6px;
    font-weight: 600;
}
.pf__left p.desc.contact-line.show { display: flex; }

    .avatar-gallery {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-top: 18px;
    }
    .avatar-gallery__item {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid var(--line);
        position: relative;
        flex-shrink: 0;
        animation: popIn .25s cubic-bezier(.34,1.56,.64,1) both;
        transition: transform .2s ease;
    }
    .avatar-gallery__item:hover { transform: scale(1.08); }
    @keyframes popIn {
        0% { opacity: 0; transform: scale(.6); }
        100% { opacity: 1; transform: scale(1); }
    }
    .avatar-gallery__item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .avatar-gallery__item button {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.55);
        border: none;
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
    }
    .avatar-gallery__item:hover button { display: flex; }
    .avatar-gallery__item button svg { width: 14px; height: 14px; }

    /* RIGHT: fields */
    .pf__right {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .card {
        background: var(--panel);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        padding: 28px 30px;
        transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease;
    }
    .card:hover {
        border-color: var(--line-strong);
        box-shadow: 0 14px 38px rgba(0,0,0,0.28);
    }
    #channelCard {
        width: 100%;
        padding: 22px 24px;
    }

    .card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 0 0 16px;
    }
    .card__head-left {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 0;
    }
    .card__icon {
        width: 30px;
        height: 30px;
        border-radius: 9px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        color: #fff;
    }
    .card__icon svg { width: 15px; height: 15px; }
    .card__icon.i-personal { background: linear-gradient(135deg, var(--accent-a), #ff6bcb); }
    .card__icon.i-link { background: linear-gradient(135deg, var(--accent-c), var(--accent-b)); }
    .card__icon.i-story { background: linear-gradient(135deg, #f59e0b, #ef4444); }

    .card__title {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--muted);
        margin: 0;
    }

    /* ---- "Shaxsiy ma'lumotlar" kartasi uchun rang tanlash tugmasi ---- */
    #personalInfoCard {
        background: var(--card-color, var(--panel));
        transition: background-color .3s ease, border-color .25s ease, box-shadow .25s ease;
    }
    #personalInfoCard .card__title,
    #personalInfoCard .field label,
    #personalInfoCard .field p.hint,
    #personalInfoCard .username-status.checking {
        color: var(--card-text-muted, var(--muted));
        transition: color .3s ease;
    }
    .card-color-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid var(--line);
        background: rgba(255,255,255,0.06);
        color: var(--text);
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background-color .2s ease, transform .2s ease, border-color .2s ease;
        padding: 0;
        position: relative;
        flex-shrink: 0;
    }
    .card-color-btn:hover { background: rgba(255,255,255,0.14); transform: scale(1.08); }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .field label {
        font-size: 12px;
        color: var(--muted);
        font-weight: 600;
    }
    .field input,
    .field textarea {
        background: var(--panel-2);
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        padding: 12px 14px;
        color: var(--text);
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        width: 100%;
    }
    .field input:focus,
    .field textarea:focus {
        border-color: #fff;
        background: var(--panel-3);
        box-shadow: 0 0 0 4px rgba(255,255,255,0.06);
    }
    html.light-mode .field input:focus,
    html.light-mode .field textarea:focus {
        border-color: #000;
        box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
    }
    .field input::placeholder,
    .field textarea::placeholder { color: #666; }

    .field p.hint {
        color: #6b6b6b;
        font-size: 11.5px;
        margin: 0;
    }

    .username-wrap {
        display: flex;
        align-items: center;
        background: var(--panel-2);
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        padding: 0 13px;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    }
    .username-wrap:focus-within {
        border-color: #fff;
        background: var(--panel-3);
        box-shadow: 0 0 0 4px rgba(255,255,255,0.06);
    }
    html.light-mode .username-wrap:focus-within {
        border-color: #000;
        box-shadow: 0 0 0 4px rgba(0,0,0,0.05);
    }
    .username-wrap span {
        color: var(--muted);
        font-weight: 700;
        font-size: 14px;
    }
    .username-wrap input {
        border: none;
        background: transparent;
        padding: 12px 8px;
        box-shadow: none !important;
    }
    .username-status {
        font-size: 11.5px;
        margin-top: 4px;
        font-weight: 600;
        min-height: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color .2s ease;
    }
    .username-status.ok { color: #4ade80; }
    .username-status.taken { color: #f87171; }
    .username-status.checking { color: var(--muted); }
    .username-status.checking::before {
        content: "";
        width: 9px; height: 9px;
        border-radius: 50%;
        border: 1.5px solid currentColor;
        border-top-color: transparent;
        animation: spin .6s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .field-error {
        color: #f87171;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
        animation: shake .3s ease;
    }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }

    /* ==================================================================
       STORIES CARD — Telegram-style story tiles + upload + viewer
       ================================================================== */
    #storiesCard { margin-top: 28px; }

    .stories-head-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-publish {
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        border-radius: 11px;
        padding: 9px 16px 9px 13px;
        font-size: 12.5px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        background-size: 160% 160%;
        box-shadow: 0 8px 20px rgba(239,68,68,0.28);
        transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-position .5s ease;
    }
    .btn-publish::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.5), transparent 70%);
        transform: translateX(-130%);
        transition: transform .55s ease;
    }
    .btn-publish:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(239,68,68,0.4);
        background-position: 100% 50%;
    }
    .btn-publish:hover::before { transform: translateX(130%); }
    .btn-publish:active { transform: translateY(0) scale(.95); }
    .btn-publish svg { width: 14px; height: 14px; flex-shrink: 0; }
    .btn-publish input[type=file] { display: none; }

    .stories-row {
        display: grid;
        grid-template-columns: repeat(7, 168px);   /* 6 emas, 7 */
        gap: 16px;
        padding: 4px 4px 12px;
    }
    @media (max-width: 900px) {
        .stories-row { grid-template-columns: repeat(4, 130px); }
    }
    @media (max-width: 640px) {
        .stories-row { grid-template-columns: repeat(3, 130px); }
    }
    .story-add {
        flex-shrink: 0;
        width: 168px;
        height: 240px;
        border-radius: var(--radius-md);
        border: 1.5px dashed rgba(255,255,255,0.25);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        color: var(--muted);
        transition: border-color .2s ease, color .2s ease, transform .2s ease, background .2s ease;
    }
    html.light-mode .story-add { border-color: rgba(0,0,0,0.2); }
    .story-add:hover {
        border-color: #fff;
        color: #fff;
        transform: translateY(-3px);
        background: rgba(255,255,255,0.03);
    }
    html.light-mode .story-add:hover { border-color: #000; color: #000; background: rgba(0,0,0,0.02); }
    .story-add span.plus {
        font-size: 26px;
        line-height: 1;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1.5px solid currentColor;
        display: grid;
        place-items: center;
        transition: transform .2s ease, background .2s ease;
    }
    .story-add:hover span.plus { transform: rotate(90deg); }
    .story-add span.txt { font-size: 12px; font-weight: 600; }
    .story-add input[type=file] { display: none; }

        .story-add--disabled {
        cursor: not-allowed;
        opacity: .5;
    }
    .story-add--disabled:hover {
        border-color: rgba(255,255,255,0.25);
        color: var(--muted);
        transform: none;
        background: transparent;
    }

    .story-card {
        flex-shrink: 0;
        width: 168px;
        height: 240px;
        border-radius: var(--radius-md);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--line);
        background: var(--panel-2);
        cursor: pointer;
        transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease, opacity .25s ease;
        animation: fadeUp .4s ease both;
    }
    .story-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 14px 30px rgba(0,0,0,0.4);
    }
    .story-card:hover .story-card__scrim,
    .story-card:hover .story-card__play,
    .story-card:hover .story-card__del {
        opacity: 1;
    }
    .story-card img, .story-card video {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
        pointer-events: none;
    }
    .story-card:hover img, .story-card:hover video { transform: scale(1.06); }

    /* pastdan qora soya — matn/tugmalar o'qiladigan bo'lishi uchun */
    .story-card__scrim {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, transparent 30%, transparent 55%, rgba(0,0,0,0.75) 100%);
        opacity: .55;
        transition: opacity .25s ease;
        pointer-events: none;
    }

    /* markazdagi play tugmasi (video bo'lsa) */
    .story-card__play {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%,-50%) scale(.85);
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(3px);
        border: 1.5px solid rgba(255,255,255,0.6);
        display: grid;
        place-items: center;
        opacity: 0;
        transition: opacity .25s ease, transform .25s cubic-bezier(.34,1.56,.64,1);
        pointer-events: none;
    }
    .story-card:hover .story-card__play { transform: translate(-50%,-50%) scale(1); }
    .story-card__play svg { width: 15px; height: 15px; fill: #fff; margin-left: 2px; }

    /* o'chirish (savat) tugmasi — o'ng yuqori burchak */
    .story-card__del {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: none;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(3px);
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        opacity: 0;
        z-index: 3;
        transition: opacity .2s ease, background-color .2s ease, transform .2s ease;
    }
    .story-card__del:hover { background: #ef4444; transform: scale(1.1); }
    .story-card__del svg { width: 12px; height: 12px; }

    .story-card__badge {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 7px;
        border-radius: 6px;
        z-index: 2;
    }
       .story-card.is-long { grid-column: span 2; width: auto; }
    .story-card__label {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.85), transparent);
        padding: 20px 10px 10px;
        font-size: 11px;
        color: #ddd;
        z-index: 2;
    }

    /* o'chirilayotgan payt: qorayib, kichrayib yo'qoladi */
    .story-card.is-deleting {
        opacity: 0;
        transform: scale(.82);
        filter: brightness(.3);
        pointer-events: none;
    }
    .story-card.is-deleting .story-card__scrim { opacity: .9; background: rgba(0,0,0,0.75); }

    /* yangi yuklangan (optimistik) karta — progress bilan */
    .story-card.is-uploading .story-card__scrim { opacity: .8; }
    .story-card__progress-wrap {
        position: absolute;
        left: 10px; right: 10px; bottom: 10px;
        z-index: 4;
    }
    .story-card__progress-track {
        height: 4px;
        border-radius: 4px;
        background: rgba(255,255,255,0.25);
        overflow: hidden;
    }
    .story-card__progress-bar {
        height: 100%;
        width: 0%;
        border-radius: 4px;
        background: linear-gradient(90deg, #0ea5e9, #22c55e);
        transition: width .25s ease;
    }
    .story-card__progress-txt {
        margin-top: 5px;
        font-size: 10px;
        font-weight: 700;
        color: #fff;
        text-align: center;
        letter-spacing: .02em;
    }
    .story-card__spinner {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%,-50%);
        width: 26px; height: 26px;
        border-radius: 50%;
        border: 2.5px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        animation: spin .7s linear infinite;
        z-index: 4;
    }
    .story-card.is-failed .story-card__scrim { opacity: .85; background: rgba(120,10,10,0.6); }
    .story-card__retry {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%,-50%);
        z-index: 4;
        background: #fff;
        color: #000;
        border: none;
        border-radius: 8px;
        padding: 7px 11px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stories-empty {
        color: #666;
        font-size: 13px;
        align-self: center;
        display: flex;
        align-items: center;
        gap: 6px;
        min-height: 184px;
    }

    /* ================= STORY VIEWER (to'liq ekranli lightbox) ================= */
    .story-viewer {
        position: fixed;
        inset: 0;
        z-index: 200;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0);
        backdrop-filter: blur(0px);
        transition: background-color .25s ease, backdrop-filter .25s ease;
    }
    .story-viewer.show {
        display: flex;
        background: rgba(0,0,0,0.88);
        backdrop-filter: blur(6px);
    }
    .story-viewer__stage {
        position: relative;
        width: min(92vw, 400px);
        height: min(97vh, 1010px);
        border-radius: 20px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        transform: scale(.9) translateY(14px);
        opacity: 0;
        transition: transform .32s cubic-bezier(.22,1,.36,1), opacity .28s ease;
    }
    .story-viewer.show .story-viewer__stage {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    .story-viewer__stage.is-leaving {
        transform: scale(.92) translateY(10px);
        opacity: 0;
    }
    .story-viewer__media {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
        display: block;
    }

    .story-viewer__bars {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        gap: 5px;
        z-index: 5;
    }
    .story-viewer__bar {
        flex: 1;
        height: 3px;
        border-radius: 3px;
        background: rgba(255,255,255,0.28);
        overflow: hidden;
    }
    .story-viewer__bar-fill {
        display: block;
        height: 100%;
        width: 0%;
        background: #fff;
        border-radius: 3px;
    }
    @keyframes storyBarFill {
    from { width: 0%; }
    to   { width: 100%; }
}
    .story-viewer.is-paused .story-viewer__bar-fill { animation-play-state: paused; }

    .story-viewer__top {
        position: absolute;
        top: 22px;
        left: 14px;
        right: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 5;
    }
    .story-viewer__who {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        font-size: 12.5px;
        font-weight: 700;
        text-shadow: 0 1px 4px rgba(0,0,0,0.5);
    }
    .story-viewer__avatar {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-a), #ff6bcb);
        display: grid;
        place-items: center;
        font-size: 12px;
        font-weight: 800;
        color: #fff;
        overflow: hidden;
        flex-shrink: 0;
    }
    .story-viewer__avatar img { width: 100%; height: 100%; object-fit: cover; }
    .story-viewer__time { font-weight: 500; color: rgba(255,255,255,0.75); }

    .story-viewer__actions { display: flex; align-items: center; gap: 6px; }
    .story-viewer__icon-btn {
        width: 32px; height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(0,0,0,0.35);
        backdrop-filter: blur(3px);
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background-color .2s ease, transform .2s ease;
    }
    .story-viewer__icon-btn:hover { background: rgba(255,255,255,0.22); transform: scale(1.08); }
    .story-viewer__icon-btn.danger:hover { background: #ef4444; }
    .story-viewer__icon-btn svg { width: 15px; height: 15px; }

    .story-viewer__nav-zone {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 34%;
        z-index: 4;
        cursor: pointer;
    }
    .story-viewer__nav-zone.prev { left: 0; }
    .story-viewer__nav-zone.next { right: 0; }

    .story-viewer__arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 42px; height: 42px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(4px);
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        z-index: 6;
        transition: background-color .2s ease, transform .2s ease;
    }
    .story-viewer__arrow:hover { background: rgba(255,255,255,0.2); transform: translateY(-50%) scale(1.08); }
    .story-viewer__arrow.left { left: -56px; }
    .story-viewer__arrow.right { right: -56px; }
    .story-viewer__arrow svg { width: 17px; height: 17px; }
    @media (max-width: 900px) {
        .story-viewer__arrow.left { left: 8px; background: rgba(0,0,0,0.35); }
        .story-viewer__arrow.right { right: 8px; background: rgba(0,0,0,0.35); }
    }

    .story-viewer__close {
        position: absolute;
        top: -46px;
        right: 0;
        width: 34px; height: 34px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.1);
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        z-index: 6;
        transition: background-color .2s ease, transform .2s ease;
    }
    .story-viewer__close:hover { background: rgba(255,255,255,0.22); transform: rotate(90deg); }
    .story-viewer__close svg { width: 15px; height: 15px; }


        .story-viewer__caption {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        padding: 40px 16px 20px;
        background: linear-gradient(0deg, rgba(0,0,0,0.8), transparent);
        color: #fff;
        font-size: 14px;
        line-height: 1.5;
        z-index: 5;
        word-break: break-word;
    }
    @media (max-width: 640px) {
        .story-viewer__close { top: 10px; right: 10px; z-index: 7; background: rgba(0,0,0,0.4); }
    }

    /* ---- Channel / chat link ---- */
    .link-row {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }
    .channel-input-wrap {
        position: relative;
        flex: 1;
        min-width: 0;
        display: flex;
        align-items: center;
        gap: 7px;
        background: var(--panel-2);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 0 11px;
        transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
    }
    .channel-input-wrap:focus-within,
    .channel-input-wrap:hover {
        border-color: var(--line-strong);
    }
    .channel-input-wrap:focus-within {
        border-color: #fff;
        background: var(--panel-3);
        box-shadow: 0 0 0 3px rgba(255,255,255,0.06);
    }
    html.light-mode .channel-input-wrap:focus-within {
        border-color: #000;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
    }
    .channel-input-wrap svg {
        width: 13px;
        height: 13px;
        color: var(--muted);
        flex-shrink: 0;
    }
    .channel-link-prefix {
        color: var(--muted);
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }
    .channel-input-wrap input {
        border: none;
        background: transparent;
        padding: 10px 0;
        flex: 1;
        min-width: 0;
        color: var(--text);
        font-size: 12.5px;
        outline: none;
    }
    .channel-input-wrap input::placeholder { color: #666; }

    /* Sichqoncha input ustiga borganda chiqadigan izoh (tooltip) */
    .channel-input-wrap[data-tooltip]::before,
    .channel-input-wrap[data-tooltip]::after {
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease, transform .2s ease;
        z-index: 15;
    }
    .channel-input-wrap[data-tooltip]::before {
        content: attr(data-tooltip);
        position: absolute;
        left: 0;
        bottom: calc(100% + 12px);
        width: 250px;
        max-width: 78vw;
        background: #161616;
        color: #f2f2f2;
        font-size: 11.5px;
        font-weight: 500;
        line-height: 1.55;
        padding: 11px 13px;
        border-radius: 12px;
        border: 1px solid var(--line-strong);
        box-shadow: 0 16px 34px rgba(0,0,0,0.45);
        transform: translateY(6px) scale(.97);
        transform-origin: bottom left;
    }
    .channel-input-wrap[data-tooltip]::after {
        content: "";
        position: absolute;
        left: 18px;
        bottom: calc(100% + 6px);
        width: 9px;
        height: 9px;
        background: #161616;
        border-right: 1px solid var(--line-strong);
        border-bottom: 1px solid var(--line-strong);
        transform: rotate(45deg);
    }
    html.light-mode .channel-input-wrap[data-tooltip]::before,
    html.light-mode .channel-input-wrap[data-tooltip]::after {
        background: #ffffff;
        color: #1a1a1a;
    }
    .channel-input-wrap[data-tooltip]:hover::before,
    .channel-input-wrap[data-tooltip]:focus-within::before {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    .channel-input-wrap[data-tooltip]:hover::after,
    .channel-input-wrap[data-tooltip]:focus-within::after {
        opacity: 1;
    }

    .btn-attach {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, var(--accent-c), var(--accent-b));
        background-size: 160% 160%;
        color: #041018;
        border: none;
        border-radius: 10px;
        padding: 0 15px;
        height: 40px;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .25s ease, background-position .5s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-shrink: 0;
        box-shadow: 0 8px 18px rgba(14,165,233,0.25);
    }
    .btn-attach::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent 30%, rgba(255,255,255,0.45), transparent 70%);
        transform: translateX(-130%);
        transition: transform .55s ease;
    }
    .btn-attach:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(14,165,233,0.35);
        background-position: 100% 50%;
    }
    .btn-attach:hover::before { transform: translateX(130%); }
    .btn-attach:active { transform: translateY(0) scale(.96); }
    .btn-attach svg {
        width: 12px;
        height: 12px;
        transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    }
    .btn-attach:hover svg { transform: translate(2px,-2px) rotate(8deg); }

    .linked-item {
        display: flex;
        align-items: center;
        gap: 13px;
        background: var(--panel-2);
        border: 1px solid var(--line);
        border-radius: var(--radius-md);
        padding: 13px 16px;
        margin-top: 12px;
        transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
        animation: fadeUp .35s ease both;
    }
    .linked-item:hover {
        border-color: var(--line-strong);
        transform: translateY(-2px);
        box-shadow: 0 10px 26px rgba(0,0,0,0.3);
    }
    .linked-item__icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg,#6366f1,#a855f7);
        color: #fff;
        display: grid;
        place-items: center;
        font-weight: 800;
        font-size: 15px;
        flex-shrink: 0;
    }
    .linked-item__icon img { width: 100%; height: 100%; object-fit: cover; border-radius: inherit; }
    .linked-item__icon.is-chat {
        background: linear-gradient(135deg,#22c55e,#0ea5e9);
    }
    .linked-item__info { flex: 1; min-width: 0; }
    .linked-item__name {
        font-size: 14px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .linked-item__type { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
    .linked-item__remove {
        background: transparent;
        border: 1px solid var(--line);
        color: var(--muted);
        border-radius: 9px;
        padding: 7px 12px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
        flex-shrink: 0;
    }
    .linked-item__remove:hover { color: #f87171; border-color: #f87171; background: rgba(248,113,113,0.08); }

    .profile-entity-results { display: grid; gap: 8px; margin-top: 10px; }
    .profile-entity-result { display: flex; align-items: center; gap: 11px; padding: 10px 12px; border: 1px solid var(--line); border-radius: 12px; background: var(--panel-2); cursor: pointer; }
    .profile-entity-result:hover, .profile-entity-result.selected { border-color: #18b7d5; background: rgba(24,183,213,.1); }
    .profile-entity-result__avatar { width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center; overflow: hidden; background: #1a9fc0; color: #fff; font-weight: 800; flex-shrink: 0; }
    .profile-entity-result__avatar img { width: 100%; height: 100%; object-fit: cover; }
    .profile-entity-result__body { min-width: 0; flex: 1; }
    .profile-entity-result__name { font-weight: 700; font-size: 13px; }
    .profile-entity-result__meta { display: flex; flex-wrap: wrap; align-items: center; gap: 3px 7px; color: var(--muted); font-size: 11px; margin-top: 3px; }
    .profile-entity-result__kind { color: var(--text); font-weight: 700; }
    .profile-entity-result__username { color: #18b7d5; }
    .profile-entity-result__chat { display: block; width: 100%; margin-top: 2px; padding-top: 3px; border-top: 1px solid var(--line); color: var(--muted); }
    .profile-entity-result__chat strong { color: var(--text); font-weight: 700; }
    .profile-entity-result__choose { display: block; color: #18b7d5; font-size: 10px; font-weight: 700; margin-top: 4px; }
    .linked-item--nested { margin-left: 28px; opacity: .92; }
    .linked-chat-inline { display: flex; align-items: center; gap: 9px; margin-top: 10px; padding: 6px 0 0; border: 0; border-top: 1px solid var(--line); border-radius: 0; background: transparent; }
    .linked-chat-inline .linked-item__icon { width: 30px; height: 30px; border-radius: 9px; font-size: 12px; }
    .linked-chat-inline > .linked-item__info { flex: 1 1 auto; width: auto; min-width: 0; }
    .linked-chat-inline .linked-item__name { font-size: 12px; }
    .linked-chat-inline .linked-item__type { font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .linked-chat-remove { flex: 0 0 auto; white-space: nowrap; padding: 5px 8px; font-size: 10px; }

    .link-empty {
        color: #666;
        font-size: 12.5px;
        margin-top: 4px;
    }

    /* ---- Save bar ---- */
     .save-bar {
        position: relative;
        width: 100%;
        margin-top: 22px;
        background: transparent;
        border: 0;
        padding: 0;
        justify-content: flex-end;
        align-items: center;
        border-radius: 0;
        box-shadow: none;
        z-index: 1;
        display: flex;
        gap: 10px;
    }
    .save-bar.is-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    .save-bar__label { margin-right: auto; }

    .save-bar .btn {
        flex: 0 0 auto;
        min-width: 140px;
    }
    .save-bar .btn-ghost {
        background: var(--panel);
    }

    @media (max-width: 520px) {
        .save-bar { flex-wrap: wrap; }
        .save-bar__label { width: 100%; margin-right: 0; }
        .save-bar .btn { flex: 1; min-width: 0; }
    }
    .btn {
        border: none;
        border-radius: var(--radius-sm);
        padding: 13px 18px;
        font-weight: 700;
        font-size: 13.5px;
        cursor: pointer;
        transition: all .2s cubic-bezier(.34,1.56,.64,1);
        flex: 1;
    }
    .btn:active { transform: scale(.96); }
    .btn-ghost { background: transparent; color: var(--muted); border: 1px solid var(--line); }
    .btn-ghost:hover { color: var(--text); border-color: var(--line-strong); }
    .btn-primary {
        background: #fff;
        color: #000;
        box-shadow: 0 10px 26px rgba(255,255,255,0.12);
    }
    html.light-mode .btn-primary { box-shadow: 0 10px 26px rgba(0,0,0,0.12); }
    .btn-primary:hover { transform: translateY(-2px); opacity: .92; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px);} to { opacity: 1; transform: translateY(0);} }
    @keyframes fadeDown { from { opacity: 0; transform: translateY(-14px);} to { opacity: 1; transform: translateY(0);} }

    @media (max-width: 980px) {
        .pf__grid { grid-template-columns: 1fr; }
        .pf__left-col { position: static; }
    }
    @media (max-width: 640px) {
        .field-row { grid-template-columns: 1fr; }
        .card { padding: 22px 20px; }
        .story-add, .story-card { width: 100%; height: 190px; }
    }















        /* ================= STORY COMPOSE (izoh yozish oynasi) ================= */
    .story-compose {
        position: fixed;
        inset: 0;
        z-index: 210;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0);
        backdrop-filter: blur(0px);
        transition: background-color .25s ease, backdrop-filter .25s ease;
    }
    .story-compose.show {
        display: flex;
        background: rgba(0,0,0,0.9);
        backdrop-filter: blur(6px);
    }
    .story-compose__stage {
        position: relative;
        width: min(92vw, 420px);
        display: flex;
        flex-direction: column;
        gap: 14px;
        transform: scale(.92) translateY(14px);
        opacity: 0;
        transition: transform .3s cubic-bezier(.22,1,.36,1), opacity .28s ease;
    }
    .story-compose.show .story-compose__stage {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    .story-compose__close {
        position: absolute;
        top: -44px;
        right: 0;
        width: 34px; height: 34px;
        border-radius: 50%;
        border: none;
        background: rgba(255,255,255,0.1);
        color: #fff;
        display: grid;
        place-items: center;
        cursor: pointer;
        z-index: 2;
        transition: background-color .2s ease, transform .2s ease;
    }
    .story-compose__close:hover { background: rgba(255,255,255,0.22); transform: rotate(90deg); }
    .story-compose__close svg { width: 15px; height: 15px; }

    .story-compose__preview {
        position: relative;
        width: 100%;
        max-height: min(70vh, 620px);
        border-radius: 20px;
        overflow: hidden;
        background: #000;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .story-compose__preview img,
    .story-compose__preview video {
        width: 100%;
        max-height: min(70vh, 620px);
        object-fit: contain;
        display: block;
    }
    .story-compose__caption-overlay {
        position: absolute;
        left: 0; right: 0; bottom: 0;
        padding: 16px;
        background: linear-gradient(0deg, rgba(0,0,0,0.75), transparent);
    }
    .story-compose__caption-overlay textarea {
        width: 100%;
        resize: none;
        border: 1px solid rgba(255,255,255,0.25);
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(6px);
        color: #fff;
        border-radius: 14px;
        padding: 11px 14px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: border-color .2s ease, background .2s ease;
    }
    .story-compose__caption-overlay textarea::placeholder { color: rgba(255,255,255,0.55); }
    .story-compose__caption-overlay textarea:focus {
        border-color: #fff;
        background: rgba(0,0,0,0.6);
    }

    .story-compose__submit {
        width: 100%;
        justify-content: center;
    }







    #storiesCard {
    background: var(--card-color, var(--panel));
    transition: background-color .3s ease, border-color .25s ease, box-shadow .25s ease;
}
#storiesCard .card__title {
    color: var(--card-text-muted, var(--muted));
    transition: color .3s ease;
}

.stories-hint {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 12px 14px;
    margin-bottom: 18px;
    color: var(--card-text-muted, var(--muted));
    font-size: 12.5px;
    line-height: 1.55;
    overflow: hidden;
    max-height: 200px;
    transition:
        background-color .3s ease,
        border-color .3s ease,
        color .3s ease,
        opacity .6s ease,
        transform .6s cubic-bezier(.34,1.56,.64,1),
        max-height .5s ease .12s,
        margin .5s ease .12s,
        padding .5s ease .12s,
        filter .5s ease;
}
html.light-mode .stories-hint { background: rgba(0,0,0,0.03); }
.stories-hint svg {
    width: 17px;
    height: 17px;
    flex-shrink: 0;
    margin-top: 1px;
    color: var(--accent-c);
    transition: transform .5s ease, opacity .5s ease;
}

/* Yo'qolish animatsiyasi */
.stories-hint.is-hiding {
    opacity: 0;
    transform: scale(.85) translateY(-10px) rotate(-2deg);
    filter: blur(4px);
    max-height: 0;
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
    border-color: transparent;
    pointer-events: none;
}
.stories-hint.is-hiding svg {
    transform: scale(0) rotate(180deg);
    opacity: 0;
}





    /* ---- Tugma hover — tepadan haqiqiy ko'zlar (kiprikli) chiqib, pirillab turadi ---- */
    .btn {
        position: relative;
        overflow: visible;
    }
    .btn::before,
    .btn::after {
        content: "";
        position: absolute;
        top: 0;
        width: 22px;
        height: 16px;
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center bottom;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26 20'%3E%3Cline x1='2' y1='4' x2='0' y2='0' stroke='%231a1a1a' stroke-width='1.6' stroke-linecap='round'/%3E%3Cline x1='7' y1='2' x2='6' y2='-2' stroke='%231a1a1a' stroke-width='1.6' stroke-linecap='round'/%3E%3Cline x1='13' y1='1.4' x2='13' y2='-2.6' stroke='%231a1a1a' stroke-width='1.6' stroke-linecap='round'/%3E%3Cline x1='19' y1='2' x2='20' y2='-2' stroke='%231a1a1a' stroke-width='1.6' stroke-linecap='round'/%3E%3Cline x1='24' y1='4' x2='26' y2='0' stroke='%231a1a1a' stroke-width='1.6' stroke-linecap='round'/%3E%3Cellipse cx='13' cy='10' rx='11.5' ry='8' fill='white' stroke='%231a1a1a' stroke-width='1.3'/%3E%3Ccircle cx='13' cy='10' r='5.2' fill='%234a2c17'/%3E%3Ccircle cx='13' cy='10' r='2.6' fill='%23000'/%3E%3Ccircle cx='11' cy='7.8' r='1.3' fill='white'/%3E%3C/svg%3E");
        opacity: 0;
        transform-origin: center bottom;
        transform: translateY(6px) scaleY(1);
        pointer-events: none;
        z-index: 6;
    }
    .btn::before { left: 32%; margin-left: -11px; }
    .btn::after  { left: 62%; margin-left: -11px; }

    .btn:hover::before,
    .btn:hover::after {
        animation: btnEyePeek 2.8s ease-in-out infinite;
    }
    .btn:hover::after { animation-delay: .1s; }

    @keyframes btnEyePeek {
        0%   { opacity: 0; transform: translateY(6px)   scaleY(1); }
        12%  { opacity: 1; transform: translateY(-15px) scaleY(1); }
        40%  { transform: translateY(-15px) scaleY(1); }
        46%  { transform: translateY(-15px) scaleY(0.08); }
        52%  { transform: translateY(-15px) scaleY(1); }
        75%  { transform: translateY(-15px) scaleY(1); }
        81%  { transform: translateY(-15px) scaleY(0.08); }
        87%  { transform: translateY(-15px) scaleY(1); }
        95%  { opacity: 1; transform: translateY(-15px) scaleY(1); }
        100% { opacity: 0; transform: translateY(6px)   scaleY(1); }
    }

    /* ---- Yon tarafdan chiqib, barmog'ini bigillatadigan qo'l — 40s bezovtalikdan keyin, sichqoncha yo'qligida ---- */
    .btn-hand {
        position: absolute;
        top: -8px;
        right: -10px;
        font-size: 18px;
        line-height: 1;
        opacity: 0;
        transform-origin: bottom right;
        transform: translate(6px, 6px) rotate(20deg) scale(.5);
        pointer-events: none;
        z-index: 7;
        filter: drop-shadow(0 2px 3px rgba(0,0,0,0.35));
    }

    .btn.is-waving .btn-hand {
        animation: btnHandWave 1.1s ease-in-out 3;
    }

    @keyframes btnHandWave {
        0%   { opacity: 0; transform: translate(6px, 6px) rotate(20deg) scale(.5); }
        14%  { opacity: 1; transform: translate(-4px, -6px) rotate(-8deg) scale(1); }
        24%  { transform: translate(-4px, -6px) rotate(14deg) scale(1); }
        34%  { transform: translate(-4px, -6px) rotate(-8deg) scale(1); }
        44%  { transform: translate(-4px, -6px) rotate(14deg) scale(1); }
        54%  { transform: translate(-4px, -6px) rotate(-4deg) scale(1); }
        66%  { opacity: 1; transform: translate(-4px, -6px) rotate(0deg) scale(1); }
        100% { opacity: 0; transform: translate(6px, 6px) rotate(20deg) scale(.5); }
    }

















        .field-locked-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .field-locked-wrap input {
        padding-right: 46px;
        cursor: default;
    }
    .field-locked-wrap input:focus {
        border-color: var(--line) !important;
        background: var(--panel-2) !important;
        box-shadow: none !important;
    }
    .field-toggle-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: var(--muted);
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background-color .2s ease, color .2s ease;
    }
    .field-toggle-btn:hover {
        background: rgba(255,255,255,0.08);
        color: var(--text);
    }
    html.light-mode .field-toggle-btn:hover { background: rgba(0,0,0,0.06); }
    .field-toggle-btn svg { width: 16px; height: 16px; }
    .field-toggle-btn .icon-eye-off { display: none; }
    .field-toggle-btn.is-hidden .icon-eye { display: none; }
    .field-toggle-btn.is-hidden .icon-eye-off { display: block; }



          .username-label-row {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .username-info-btn {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--muted);
        display: grid;
        place-items: center;
        cursor: pointer;
        padding: 0;
        transition: color .2s ease, transform .2s ease;
    }
    .username-info-btn svg { width: 15px; height: 15px; }
    .username-info-btn:hover { color: var(--accent-c); transform: scale(1.12); }
    .username-info-btn.is-active { color: var(--accent-c); }

.username-info-panel {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height .35s cubic-bezier(.22,1,.36,1), opacity .28s ease, margin-top .40s ease;
    margin-top: 0;
}
.username-info-panel.is-open {
    max-height: 300px;   /* matn balandligidan katta bo'lsin */
    opacity: 1;
    margin-top: 10px;
}
    .username-info-panel__inner {
        overflow: hidden;
        min-height: 0;
        background: linear-gradient(160deg, var(--panel-2), var(--panel-3));
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 0 14px;
        font-size: 12px;
        line-height: 1.6;
        color: var(--muted);
        transform: translateY(-6px);
        transition: transform .35s cubic-bezier(.22,1,.36,1), padding .35s ease;
    }
    .username-info-panel.is-open .username-info-panel__inner {
        padding: 13px 14px;
        transform: translateY(0);
    }
    .username-info-panel__inner p { margin: 0; }
    .username-info-panel__inner p + p { margin-top: 10px; }
    .username-info-panel__inner b { color: var(--text); font-weight: 700; }









    /* ================= FASLLAR EFFEKTI — storiesCard ichida ================= */
#storiesCard { position: relative; }

.season-fx-wrap {
    position: absolute;
    inset: 0;
    z-index: 1;
    overflow: hidden;
    border-radius: var(--radius-lg);
    pointer-events: none;
}
.season-fx-wrap .season-fx { position: absolute; inset: 0; }

#storiesCard > *:not(.season-fx-wrap) { position: relative; z-index: 2; }

.sfx-sun{position:absolute;top:-160px;left:50%;transform:translateX(-50%);width:560px;height:560px;border-radius:50%;background:radial-gradient(circle,rgba(255,214,102,.35),rgba(255,214,102,0) 70%);filter:blur(6px);animation:sfxSunPulse 6s ease-in-out infinite;}
@keyframes sfxSunPulse{0%,100%{opacity:.65;transform:translateX(-50%) scale(1);}50%{opacity:1;transform:translateX(-50%) scale(1.07);}}

.sfx-leaf{position:absolute;bottom:-24px;border-radius:0 100% 0 100%;opacity:0;animation-name:sfxLeafRise;animation-timing-function:linear;animation-iteration-count:infinite;}
@keyframes sfxLeafRise{
    0%{transform:translateY(0) translateX(0) rotate(0deg);opacity:0;}
    8%{opacity:.9;}
    50%{transform:translateY(-260px) translateX(24px) rotate(160deg);}
    92%{opacity:.85;}
    100%{transform:translateY(-530px) translateX(-14px) rotate(320deg);opacity:0;}
}

.sfx-snow{position:absolute;top:-14px;color:#fff;opacity:.9;animation-name:sfxSnowFall;animation-timing-function:linear;animation-iteration-count:infinite;}
@keyframes sfxSnowFall{
    0%{transform:translate(0,0) rotate(0deg);}
    50%{transform:translate(16px,260px) rotate(180deg);}
    100%{transform:translate(-14px,530px) rotate(360deg);}
}

.sfx-snowman{position:absolute;bottom:14px;right:22px;font-size:38px;filter:drop-shadow(0 4px 10px rgba(0,0,0,.45));opacity:0;animation-name:sfxSnowmanWiggle,sfxFadeIn;animation-duration:4.5s,.8s;animation-delay:0s,1.2s;animation-fill-mode:forwards,forwards;animation-iteration-count:infinite,1;animation-timing-function:ease-in-out,ease;}
@keyframes sfxSnowmanWiggle{0%,100%{transform:rotate(-3deg);}50%{transform:rotate(3deg);}}
@keyframes sfxFadeIn{from{opacity:0;}to{opacity:1;}}

.sfx-petal{position:absolute;top:-18px;border-radius:50% 0 50% 50%;opacity:0;animation-name:sfxPetalFall;animation-timing-function:linear;animation-iteration-count:infinite;}
@keyframes sfxPetalFall{
    0%{transform:translate(0,0) rotate(0deg);opacity:0;}
    10%{opacity:.9;}
    50%{transform:translate(30px,260px) rotate(140deg);}
    90%{opacity:.8;}
    100%{transform:translate(-24px,530px) rotate(300deg);opacity:0;}
}

.sfx-rain{position:absolute;top:-24px;width:1.5px;height:16px;background:linear-gradient(180deg,rgba(190,210,255,.55),rgba(190,210,255,0));animation-name:sfxRainFall;animation-timing-function:linear;animation-iteration-count:infinite;}
@keyframes sfxRainFall{0%{transform:translate(0,0);}100%{transform:translate(-46px,560px);}}
.sfx-rain.autumn{background:linear-gradient(180deg,rgba(255,220,180,.5),rgba(255,220,180,0));}

.sfx-aleaf{position:absolute;top:-20px;border-radius:0 100% 0 100%;opacity:0;animation-name:sfxALeafFall;animation-timing-function:linear;animation-iteration-count:infinite;}
@keyframes sfxALeafFall{
    0%{transform:translate(0,0) rotate(0deg);opacity:0;}
    10%{opacity:.9;}
    50%{transform:translate(-40px,260px) rotate(180deg);}
    90%{opacity:.8;}
    100%{transform:translate(-90px,530px) rotate(400deg);opacity:0;}
}





















.story-viewer__views-summary {
    position: absolute;
    left: 14px;
    right: 14px;
    bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 5;
    cursor: pointer;
}
.story-viewer__views-avatars { display: flex; }
.story-viewer__views-avatars span {
    width: 24px; height: 24px;
    border-radius: 50%;
    border: 2px solid #000;
    margin-left: -8px;
    overflow: hidden;
    background: #444;
    display: grid;
    place-items: center;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
}
.story-viewer__views-avatars span:first-child { margin-left: 0; }
.story-viewer__views-avatars span img { width: 100%; height: 100%; object-fit: cover; }
.story-viewer__views-count { color: #fff; font-size: 12.5px; font-weight: 600; }

.story-viewer__views-panel {
    position: absolute;
    left: 10px;
    right: 10px;
    bottom: 46px;
    max-height: 60%;
    background: rgba(30,32,38,0.96);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 16px 40px rgba(0,0,0,0.5);
    z-index: 8;
    overflow: hidden;
    display: none;
    flex-direction: column;
    opacity: 0;
    transform: translateY(10px) scale(.97);
    transition: opacity .2s ease, transform .2s ease;
}
.story-viewer__views-panel.show {
    display: flex;
    opacity: 1;
    transform: translateY(0) scale(1);
}
.story-viewer__views-panel-list {
    overflow-y: auto;
    padding: 6px;
}
.svp-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 8px;
    border-radius: 12px;
    transition: background-color .15s ease;
}
.svp-row:hover { background: rgba(255,255,255,0.06); }
.svp-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(135deg,#6366f1,#a855f7);
    display: grid;
    place-items: center;
    color: #fff;
    font-weight: 800;
    font-size: 15px;
    flex-shrink: 0;
}
.svp-avatar img { width: 100%; height: 100%; object-fit: cover; }
.svp-info { flex: 1; min-width: 0; }
.svp-name {
    color: #4db8ff;
    font-size: 14px;
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.svp-time {
    display: flex;
    align-items: center;
    gap: 4px;
    color: rgba(255,255,255,0.5);
    font-size: 12px;
    margin-top: 2px;
}
.svp-time svg { width: 13px; height: 13px; flex-shrink: 0; }
.svp-reaction { font-size: 19px; flex-shrink: 0; }

.svp-empty {
    padding: 30px 14px;
    text-align: center;
    color: rgba(255,255,255,0.45);
    font-size: 13px;
}


    .tme-copy {
        color: var(--accent-c);
        font-weight: 600;
        cursor: pointer;
        transition: opacity .15s ease;
        white-space: nowrap;
    }
    .tme-copy:hover { opacity: .8; text-decoration: underline; }
    .tme-copy.is-copied { color: #4ade80; }








        /* ---- Istoriyalar qatorlarini ajratuvchi sarlavha ---- */
    .stories-row-divider {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 2px 0;
        color: var(--card-text-muted, var(--muted));
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        user-select: none;
        animation: fadeUp .35s ease both;
    }
.srd-icon {
    position: relative;
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: #fff;
    background: linear-gradient(135deg, var(--accent-c), var(--accent-b));
    box-shadow: 0 4px 14px rgba(14,165,233,0.4);
    animation: srdFloat 2.4s ease-in-out infinite;
}
.srd-icon::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 2px solid var(--accent-c);
    animation: srdPulse 2s ease-out infinite;
    pointer-events: none;
}
.srd-icon svg {
    width: 14px;
    height: 14px;
    animation: srdTilt 3s ease-in-out infinite;
}
@keyframes srdFloat {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-3px); }
}
@keyframes srdPulse {
    0%   { transform: scale(1);   opacity: .7; }
    100% { transform: scale(1.9); opacity: 0; }
}
@keyframes srdTilt {
    0%, 100% { transform: rotate(-8deg) scale(1); }
    50%      { transform: rotate(8deg)  scale(1.12); }
}
    .stories-row-divider__count {
        font-weight: 600;
        opacity: .7;
        text-transform: none;
        letter-spacing: 0;
    }
    .stories-row-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--line-strong);
    }





    .story-card__type {
    position: absolute;
    left: 8px;
    bottom: 8px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(3px);
    color: #fff;
    display: grid;
    place-items: center;
    z-index: 3;
    pointer-events: none;
}
.story-card__type svg { width: 13px; height: 13px; }
</style>

<div id="pfTopbar">
    <span class="pf-marquee">Assalomu alekum! Profil bo'limiga hush kelibsiz. Bu yerda avatar rasmingizni, ismingizni, familiyangizni va username'ingizni istagancha tahrirlashingiz mumkin. Yangi istoriyalar qo'shib do'stlaringizga o'zingizni ko'rsating, kanal yoki chatingizni esa profilingizga ulab qo'ying.</span>
</div>

<div class="pf">
    <div class="pf__wrap">

        <div class="pf__top">
            <a class="pf__back" href="{{ route('home') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span data-i18n="profileBack">Orqaga</span>
            </a>
        </div>

        <div class="pf__intro">
            <h1 data-i18n="profileTitle">Sizning profilingiz</h1>
            <p data-i18n="profileSubtitle">Bu yerda avatar, ism va username kabi profil ma'lumotlaringizni tahrirlaysiz. Boshqa foydalanuvchilar tashrif buyurganda profilingizni aynan shu ko'rinishda ko'radi.</p>
        </div>

        @if (session('status'))
            <div class="status-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                {{ session('status') }}
            </div>
        @endif

        <form id="profileEditForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <input type="hidden" name="avatar_remove" id="avatarRemoveInput" value="0">

            <div class="pf__grid">

                {{-- CHAP USTUN: avatar kartasi + kanal/chat ulash kartasi --}}
                <div class="pf__left-col">

                {{-- LEFT: AVATAR --}}
                <div class="pf__left" id="pfLeftCard">

                    <div class="pf__left-topbar">
                        <button type="button" class="pf__left-icon-btn" id="cardColorBtn" title="Karta rangini o'zgartirish">
                            <span class="card-color-swatch" id="cardColorSwatch"></span>
                            <input type="color" class="card-color-input" id="cardColorInput" value="#0d0d0d">
                        </button>
                        <button type="button" class="pf__left-icon-btn" id="avatarMenuBtn" title="Rasm sozlamalari">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5" cy="12" r="1.6"></circle><circle cx="12" cy="12" r="1.6"></circle><circle cx="19" cy="12" r="1.6"></circle></svg>
                        </button>

                        <div class="avatar-menu" id="avatarMenu">
                            <button type="button" id="menuUploadPhoto">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span>Rasm yuklash</span>
                            </button>
                            <button type="button" id="menuAddPhoto">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                <span>Rasm qo'shish</span>
                            </button>
                            @if (auth()->user()->avatar ?? false)
                            <button type="button" id="menuRemovePhoto" class="danger">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                                <span>Rasmni o'chirish</span>
                            </button>
                            @endif
                        </div>
                    </div>

                    <label class="avatar-box" for="avatarInput" title="Rasmni o'zgartirish">
                        <span class="avatar-box__circle" id="avatarCircle">
                            @if (auth()->user()->avatar ?? false)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}?v={{ optional(auth()->user()->updated_at)->timestamp }}" alt="Avatar" id="avatarPreview">
                            @else
                                <span id="avatarLetter">{{ strtoupper(substr(auth()->user()->name ?? 'F', 0, 1)) }}</span>
                            @endif
                        </span>
                        <span class="avatar-box__btn" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        </span>
                        <input id="avatarInput" name="avatar" type="file" accept="image/*,.avif,.webp,.gif,.bmp">
                    </label>
                  <h3>{{ auth()->user()->name ?? 'Foydalanuvchi' }}</h3>
                   <p class="handle">{{ '@' }}{{ auth()->user()->username ?? 'username' }}</p>

<div class="avatar-info-lines" id="avatarInfoLines">
         @if(isset($linkedChannels) && $linkedChannels->count())
     @php
          $firstCh = $linkedChannels->first();
     @endphp
    <div class="info-line-group" id="channelGroup">
        <p class="info-line-label">{{ $firstCh->type === 'group' ? 'Guruh' : 'Kanal' }}</p>
        <div class="avatar-channel-mini" role="link" tabindex="0" data-home-url="{{ route('home', ['entity' => ($firstCh->type ?? 'channel') . '-' . $firstCh->id]) }}" aria-label="{{ $firstCh->name }} kanalini ochish">
            <span class="avatar-channel-mini__icon">@if($firstCh->avatar)<img src="{{ $firstCh->avatar }}" alt="">@else{{ strtoupper(substr($firstCh->name ?? $firstCh->username, 0, 1)) }}@endif</span>
            <div class="avatar-channel-mini__info">
                <div class="avatar-channel-mini__name">{{ $firstCh->name }}</div>
                <div class="avatar-channel-mini__meta">
                    {{ $firstCh->type === 'channel' ? 'Kanal' : 'Guruh' }}
                    @if($firstCh->username)
                        · <span class="tme-copy" data-value="t.me/{{ $firstCh->username }}">t.me/{{ $firstCh->username }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="info-line-group" id="contactGroup">
        <p class="desc contact-line" id="avatarPhoneLine"></p>
        <p class="desc contact-line" id="avatarEmailLine"></p>
    </div>
    <div class="info-line-group" id="bioGroup">
        <p class="info-line-label" data-i18n="profileBioLabel">Bio</p>
        <p class="desc" id="avatarBioDesc"></p>
    </div>
</div>
                    @error('avatar') <p class="field-error">{{ $message }}</p> @enderror

                    <input type="file" id="avatarAddInput" accept="image/*,.avif,.webp,.gif,.bmp" style="display:none;">
                    <div class="avatar-gallery" id="avatarGallery"></div>
                </div>

                {{-- Ikki karta orasidagi "elektr ilon" connector --}}
                <div class="pf__connector" aria-hidden="true">
                    <svg viewBox="0 0 300 34" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="pfConnectorGradient" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#0ea5e9"></stop>
                                <stop offset="50%" stop-color="#22c55e"></stop>
                                <stop offset="100%" stop-color="#0ea5e9"></stop>
                            </linearGradient>
                        </defs>
                        <path class="pf__connector-glow" d="M4 4 C 60 4, 40 30, 100 30 S 170 4, 150 17 S 240 30, 296 4" />
                        <path class="pf__connector-line" d="M4 4 C 60 4, 40 30, 100 30 S 170 4, 150 17 S 240 30, 296 4" />
                        <circle class="pf__connector-dot" r="3.4">
                            <animateMotion dur="2.6s" repeatCount="indefinite"
                                path="M4 4 C 60 4, 40 30, 100 30 S 170 4, 150 17 S 240 30, 296 4" />
                        </circle>
                    </svg>
                </div>

                {{-- Kanal / Chat ulash — avatar kartasi ostida, chap ustunda --}}
                <div class="card" id="channelCard">
                    <div class="card__head">
                        <span class="card__icon i-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 6.5 9 11H4V4h9a3.5 3.5 0 1 1 0 7"></path></svg>
                        </span>
                        <p class="card__title" data-i18n="profileLinkCardTitle">Kanal yoki chat ulash</p>
                    </div>
                    <div class="link-row">
                        <div class="channel-input-wrap" data-tooltip="O'zingizga tegishli kanal yoki guruh username'ini kiriting — u profilingizda ko'rinib turadi va boshqalar bosib o'tishi mumkin.">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 11 18-8-8 18-2-8-8-2z"></path></svg>
                            <span class="channel-link-prefix">t.me/</span>
                            <input type="text" id="channelLinkInput" placeholder="mening_kanalim yoki nomi" autocomplete="off" data-i18n-placeholder="profileLinkPlaceholder">
                        </div>
                        <button type="button" class="btn-attach" id="channelAttachBtn" title="Kanal yoki chatni ulash">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13.5 6.5 9 11H4V4h9a3.5 3.5 0 1 1 0 7"></path></svg>
                            <span data-i18n="profileLinkAttach">Ulash</span>
                        </button>
                    </div>
                    <div id="profileEntityResults" class="profile-entity-results" hidden></div>
                    <div id="linkedChannelsList">
                      @forelse($linkedChannels ?? [] as $ch)
                                                            <div class="linked-item">
                                <span class="linked-item__icon {{ ($ch->type ?? '') === 'group' ? 'is-chat' : '' }}">@if($ch->avatar)<img src="{{ $ch->avatar }}" alt="">@else{{ strtoupper(substr($ch->name ?? $ch->username, 0, 1)) }}@endif</span>
                                <div class="linked-item__info">
                                    <div class="linked-item__name">{{ $ch->name }}</div>
                                     <div class="linked-item__type">
                                       {{ $ch->type === 'channel' ? 'Kanal' : 'Guruh' }} · @if($ch->username)<span class="tme-copy" data-value="t.me/{{ $ch->username }}">t.me/{{ $ch->username }}</span>@else{{ 'username yo‘q' }}@endif · <span style="white-space:nowrap;">{{ $ch->members_count ?? 1 }}&nbsp;{{ $ch->type === 'channel' ? 'obunachi' : 'a’zo' }}</span>
                                    </div>
                                </div>
                                <button type="button" class="linked-item__remove" data-id="{{ $ch->id }}">O'chirish</button>
                            </div>
                        @empty
                            <p class="link-empty">Hozircha hech qanday kanal yoki chat ulanmagan.</p>
                        @endforelse
                    </div>
                </div>

                </div>{{-- /.pf__left-col --}}

                {{-- RIGHT: FIELDS --}}
                <div class="pf__right">

                    {{-- Shaxsiy ma'lumotlar --}}
                    <div class="card" id="personalInfoCard">
                        <div class="card__head">
                            <div class="card__head-left">
                                <span class="card__icon i-personal">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </span>
                                <p class="card__title">Shaxsiy ma'lumotlar</p>
                            </div>
                            <button type="button" class="card-color-btn" id="personalColorBtn" title="Karta rangini o'zgartirish">
                                <span class="card-color-swatch" id="personalColorSwatch"></span>
                                <input type="color" class="card-color-input" id="personalColorInput" value="#0d0d0d">
                            </button>
                        </div>

                        <div class="field-row" style="margin-bottom:14px;">
                            <div class="field">
                                <label for="nameInput">Ism</label>
                                <input type="text" name="name" id="nameInput" placeholder="Ismingiz"
                                       value="{{ old('name', auth()->user()->name ?? '') }}">
                                @error('name') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                           <div class="field">
    <label for="surnameInput">Familiya</label>
    <div class="field-locked-wrap">
        <input type="text" name="surname" id="surnameInput" placeholder="Familiyangiz"
               value="{{ old('surname', auth()->user()->surname ?? '') }}" readonly>
        <button type="button" class="field-toggle-btn" data-target="surnameInput" title="Yashirish/Ko'rsatish">
            <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
        </button>
    </div>
    @error('surname') <p class="field-error">{{ $message }}</p> @enderror
</div>
                        </div>

                            <div class="field-row" style="margin-bottom:14px;">
                                                          <div class="field">
                                <div class="username-label-row">
                                    <label for="usernameInput">Username</label>
                                    <button type="button" class="username-info-btn" id="usernameInfoBtn" title="Batafsil">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    </button>
                                </div>
                                <div class="username-wrap">
                                    <span>@</span>
                                    <input type="text" name="username" id="usernameInput" placeholder="username"
                                           autocomplete="off"
                                           value="{{ old('username', auth()->user()->username ?? '') }}">
                                </div>
                                <p class="username-status" id="usernameStatus"></p>
                                @error('username') <p class="field-error">{{ $message }}</p> @enderror

                                <div class="username-info-panel" id="usernameInfo">
                                    <div class="username-info-panel__inner">
                                        <p>Siz ChatO'VBS'da username tanlashingiz mumkin. Agar tansangiz, boshqa foydalanuvchilar sizni shu username orqali topib, telefon raqamingizni bilmasdan ham siz bilan bog'lanishlari mumkin.</p>
                                        <p>Siz <b>a-z</b>, <b>0-9</b> va pastki chiziq (<b>_</b>) dan foydalanishingiz mumkin. Minimal uzunlik — <b>5 ta belgi</b>.</p>
                                    </div>
                                </div>
                            </div>
                            
                                                     <div class="field">
                                <label for="phoneInput">Telefon raqam</label>
                                <div class="field-locked-wrap">
                                    <input type="text" name="phone" id="phoneInput" placeholder="+998 90 123 45 67"
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}" readonly>
                                    <button type="button" class="field-toggle-btn" data-target="phoneInput" title="Yashirish/Ko'rsatish">
                                        <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                    </button>
                                </div>
                                <input type="hidden" name="show_phone" id="showPhoneInput" value="{{ auth()->user()->show_phone ?? true ? '1' : '0' }}">
                                @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                        </div>

                                              <div class="field" style="margin-bottom:14px;">
                            <label for="emailInput">Email</label>
                            <div class="field-locked-wrap">
                                <input type="text" name="email" id="emailInput" placeholder="email@example.com"
                                       value="{{ old('email', auth()->user()->email ?? '') }}" readonly>
                                <button type="button" class="field-toggle-btn" data-target="emailInput" title="Yashirish/Ko'rsatish">
                                    <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    <svg class="icon-eye-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.5 18.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                </button>
                            </div>
                            <input type="hidden" name="show_email" id="showEmailInput" value="{{ auth()->user()->show_email ?? true ? '1' : '0' }}">
                            <p class="hint">Email asosiy ro'yxatdan o'tish ma'lumoti hisoblanadi.</p>
                            @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        </div>

                            <div class="field">
                            <label for="bioInput">Bio</label>
                            <textarea name="bio" id="bioInput" rows="3" maxlength="75"
                                      placeholder="O'zingiz haqingizda qisqacha yozing...">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                            <p class="hint"><span id="bioCount">0</span>/75 belgi</p>
                            @error('bio') <p class="field-error">{{ $message }}</p> @enderror
                        </div>

                                               <div class="save-bar" id="saveBar">
                            <button type="button" class="btn btn-ghost" id="resetBtn">Bekor qilish<span class="btn-hand">🖐️</span></button>
                            <button type="submit" class="btn btn-primary">Saqlash<span class="btn-hand">🖐️</span></button>
                        </div>
                    </div>

                </div>
            </div>

                     {{-- Istoriyalar — endi to'liq kenglikda, pastda alohida katta karta --}}
            <div class="card" id="storiesCard">
                <div class="season-fx-wrap"><div class="season-fx" id="cardSeasonFx"></div></div>
                @php
                    $storyCount = isset($stories) ? count($stories) : 0;
                    $lastStory = isset($stories) && count($stories) ? $stories->sortByDesc('created_at')->first() : null;
                    $hoursSinceLast = $lastStory ? $lastStory->created_at->diffInHours(now()) : null;
                    $onCooldown = $lastStory && $hoursSinceLast < 24;
                    $limitReached = $storyCount >= 32;
                    $canUpload = !$limitReached && !$onCooldown;
                    $cooldownLeft = $onCooldown ? (24 - $hoursSinceLast) : 0;
                @endphp

                <div class="card__head">
                    <div class="card__head-left">
                        <span class="card__icon i-story">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="4"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="m21 15-5-5L5 21"></path></svg>
                        </span>
                        <p class="card__title">Istoriyalar</p>
                    </div>

                    

                    <div class="stories-head-actions">
                      <button type="button" class="card-color-btn" id="storiesColorBtn" title="Karta rangini o'zgartirish">
                            <span class="card-color-swatch" id="storiesColorSwatch"></span>
                            <input type="color" class="card-color-input" id="storiesColorInput" value="#0d0d0d">
                        </button>
                        @if($canUpload)
                            <button type="button" class="btn-publish" id="storyPublishBtn" title="Yangi istoriya joylash">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Joylash
                                <input type="file" id="storyInput" accept="image/*,video/*">
                            </button>
                        @else
                            <button type="button" class="btn-publish" style="opacity:.5; cursor:not-allowed;" disabled title="{{ $limitReached ? '32 tadan ortiq istoriya joylay olmaysiz' : 'Kuniga faqat 1 marta joylash mumkin' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Joylash
                            </button>
                        @endif
                    </div>
                </div>
                                <div class="stories-hint" id="storiesHint">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>Rasm yoki video (1 daqiqagacha) qo'shing. 1 daqiqadan uzun videolar kattaroq blok sifatida ko'rsatiladi. Ko'rish uchun istoriyani bosing.</span>
                </div>

                <div class="stories-row" id="storiesRow" data-can-upload="{{ $canUpload ? '1' : '0' }}">
                    @if($canUpload)
                        <label class="story-add" for="storyAddTileInput">
                            <span class="plus">+</span>
                            <span class="txt">Qo'shish</span>
                        </label>
                        <input type="file" id="storyAddTileInput" accept="image/*,video/*" style="display:none;">
                    @else
                        <div class="story-add story-add--disabled" title="{{ $limitReached ? '32 tadan ortiq istoriya joylay olmaysiz' : 'Kuniga faqat 1 marta joylash mumkin, yana ' . $cooldownLeft . ' soatdan keyin' }}">
                            <span class="plus">{{ $limitReached ? '32' : '⏳' }}</span>
                            <span class="txt">{{ $limitReached ? 'Limit to\'ldi' : $cooldownLeft . ' soat qoldi' }}</span>
                        </div>
                    @endif

                                   @forelse($stories ?? [] as $story)
                      @php
                          $viewersData = $story->viewers
                              ->sortByDesc(function ($u) { return $u->pivot->created_at; })
                              ->values()
                              ->map(function ($u) {
                                  return [
                                      'name' => $u->name,
                                      'avatar' => $u->avatar ? asset('storage/'.$u->avatar) : null,
                                      'viewed_at' => $u->pivot->created_at->timestamp,
                                      'reaction' => $u->pivot->reaction,
                                  ];
                              });
                      @endphp
                      <div class="story-card {{ ($story->duration ?? 0) > 60 ? 'is-long' : '' }}"
     data-id="{{ $story->id }}"
     data-type="{{ $story->type ?? 'image' }}"
     data-src="{{ asset('storage/'.$story->media_path) }}"
     data-caption="{{ $story->caption }}"
     data-created-at="{{ $story->created_at->timestamp }}"
     data-views-count="{{ $story->viewers->count() }}"
     data-viewers='@json($viewersData)'>
                            @if(($story->type ?? 'image') === 'video')
                                <video src="{{ asset('storage/'.$story->media_path) }}" muted playsinline preload="metadata"></video>
                                @if(($story->duration ?? 0) > 60)
                                    <span class="story-card__badge">Uzun video</span>
                                    <span class="story-card__label">{{ gmdate('i:s', $story->duration) }}</span>
                                @endif
                                                   @else
                                <img src="{{ asset('storage/'.$story->media_path) }}" alt="Story">
                            @endif
                            <span class="story-card__scrim"></span>

                            <span class="story-card__type">
                                @if(($story->type ?? 'image') === 'video')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="4"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="m21 15-5-5L5 21"></path></svg>
                                @endif
                            </span>

                            @if(($story->type ?? 'image') === 'video')
                                <span class="story-card__play">
                                    <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                </span>
                            @endif
                            <button type="button" class="story-card__del" data-id="{{ $story->id }}" title="O'chirish">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                            </button>
                        </div>
                    @empty
                        <span class="stories-empty" id="storiesEmptyMsg">Hozircha istoriya yo'q</span>
                    @endforelse
                </div>
            </div>
           
        </form>
    </div>
</div>

{{-- ================= STORY VIEWER MODAL (to'liq ekranli) ================= --}}
<div class="story-viewer" id="storyViewer">
    <div class="story-viewer__stage" id="storyViewerStage">
        <div class="story-viewer__bars" id="storyViewerBars"></div>

        <div class="story-viewer__top">
            <div class="story-viewer__who">
                <span class="story-viewer__avatar" id="storyViewerAvatar">
                    @if (auth()->user()->avatar ?? false)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr(auth()->user()->name ?? 'F', 0, 1)) }}
                    @endif
                </span>
                <span>{{ auth()->user()->name ?? 'Siz' }}</span>
                <span class="story-viewer__time" id="storyViewerTime"></span>
            </div>
            <div class="story-viewer__actions">
                <button type="button" class="story-viewer__icon-btn" id="storyViewerMuteBtn" title="Ovoz">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                </button>
                
                <button type="button" class="story-viewer__icon-btn danger" id="storyViewerDeleteBtn" title="O'chirish">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
                </button>
                    <button type="button" class="story-viewer__icon-btn" id="storyViewerCloseBtn" title="Yopish">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
            </div>
        </div>
        <img class="story-viewer__media" id="storyViewerImg" style="display:none;" alt="Istoriya">
        <video class="story-viewer__media" id="storyViewerVideo" style="display:none;" playsinline></video>
        <div class="story-viewer__caption" id="storyViewerCaption" style="display:none;"></div>

          <div class="story-viewer__views-summary" id="storyViewerViewsSummary" style="display:none;">
            <div class="story-viewer__views-avatars" id="storyViewerViewsAvatars"></div>
            <span class="story-viewer__views-count" id="storyViewerViewsCount"></span>
        </div>

        <div class="story-viewer__views-panel" id="storyViewerViewsPanel">
            <div class="story-viewer__views-panel-list" id="storyViewerViewsList"></div>
        </div>

        <div class="story-viewer__nav-zone prev" id="storyViewerPrevZone" title="Oldingi"></div>
        <div class="story-viewer__nav-zone next" id="storyViewerNextZone" title="Keyingi"></div>

        
    </div>


    

    <button type="button" class="story-viewer__arrow left" id="storyViewerArrowLeft" title="Oldingi">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button type="button" class="story-viewer__arrow right" id="storyViewerArrowRight" title="Keyingi">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
</div>







{{-- ================= STORY COMPOSE MODAL (izoh yozish oynasi) ================= --}}
<div class="story-compose" id="storyCompose">
    <div class="story-compose__stage">
        <button type="button" class="story-compose__close" id="storyComposeClose" title="Bekor qilish">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <div class="story-compose__preview">
            <img id="storyComposePreviewImg" style="display:none;" alt="Ko'rinish">
            <video id="storyComposePreviewVideo" style="display:none;" muted playsinline autoplay loop></video>
            <div class="story-compose__caption-overlay">
                <textarea id="storyComposeCaption" placeholder="Izoh qo'shing..." maxlength="200" rows="2"></textarea>
            </div>
        </div>
        <button type="button" class="btn-publish story-compose__submit" id="storyComposeSubmit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Joylash
        </button>
    </div>
</div>





<script>
(function () {
    // Asosiy header'da: akkaunt o'rniga dino-o'yin — "ChatO'VBS" logotipi ortidan chiqadi,
    // yer chizig'i bo'ylab yuguradi va kaktus to'siqlarni sakrab o'tadi.
    var headerContainer = document.querySelector('.site-header .container');
    var brand = document.querySelector('.site-brand');

    if (headerContainer && brand) {
        var ground = document.createElement('span');
        ground.className = 'dino-ground';
        headerContainer.appendChild(ground);

        var dino = document.createElement('span');
        dino.id = 'headerDino';
        dino.innerHTML = '<svg viewBox="0 0 24 24" fill="#faf9f6"><path d="M4 16h2v-2h2v-2H6V9a3 3 0 0 1 3-3h1V4h2v2h2a3 3 0 0 1 3 3v1h2v2h-2v3h-2v-3H9v3H7v-3H4z"/><rect class="leg" x="8" y="17" width="2" height="4"/><rect class="leg" x="13" y="17" width="2" height="4"/></svg>';
        headerContainer.appendChild(dino);

        var brandRect = brand.getBoundingClientRect();
        var containerRect = headerContainer.getBoundingClientRect();
        var startX = (brandRect.right - containerRect.left) + 14;

        var themeBtnHTML = '<button type="button" class="theme-toggle" id="themeToggleBtn" title="Rejimni almashtirish">'
            + '<svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>'
            + '<svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>'
            + '</button>';
        var themeWrap = document.createElement('div');
        themeWrap.innerHTML = themeBtnHTML;
        (document.querySelector('.site-header') || headerContainer).appendChild(themeWrap.firstChild);

        var endX = containerRect.width - 64;
        var pos = startX;
        var speed = 2.4;
        var jumping = false;
        var jumpStart = 0;
        var ducking = false;
        var duckStart = 0;
        var obstacles = [];

        dino.style.left = pos + 'px';

        var birdSvg = '<svg viewBox="0 0 24 16" fill="none" stroke="#faf9f6" stroke-width="2.2" stroke-linecap="round"><path class="wing" d="M2 8 Q7 1 12 8 Q17 1 22 8"/></svg>';
        var treeSvg = '<svg viewBox="0 0 16 24" fill="#38ef7d"><path d="M8 0 2 10h3l-4 8h5v6h4v-6h5l-4-8h3z"/></svg>';

        function spawnObstacles() {
            var count = 5;
            var trackLen = endX - startX - 100;
            var step = trackLen / count;
            for (var i = 0; i < count; i++) {
                var roll = Math.random();
                var type = roll > 0.62 ? 'bird' : (roll > 0.31 ? 'tree' : 'cactus');
                var el = document.createElement('span');
                var x = startX + 90 + step * i + Math.random() * (step * 0.5);

                if (type === 'bird') {
                    el.className = 'dino-bird';
                    el.innerHTML = birdSvg;
                } else if (type === 'tree') {
                    el.className = 'dino-tree';
                    el.innerHTML = treeSvg;
                } else {
                    el.className = 'dino-cactus';
                }
                el.style.left = x + 'px';
                headerContainer.appendChild(el);
                obstacles.push({ el: el, x: x, jumped: false, type: type });
            }
        }

        function resetRun() {
            pos = startX;
            obstacles.forEach(function (o) { o.el.remove(); });
            obstacles = [];
            spawnObstacles();
        }
        resetRun();

        function tick() {
            pos += speed;

            obstacles.forEach(function (o) {
                if (!o.jumped && pos > o.x - 34 && pos < o.x - 30) {
                    o.jumped = true;
                    if (o.type === 'bird') {
                        ducking = true;
                        duckStart = performance.now();
                    } else {
                        jumping = true;
                        jumpStart = performance.now();
                    }
                }
            });

            var yOffset = 0;
            if (jumping) {
                var t = (performance.now() - jumpStart) / 420;
                if (t >= 1) {
                    jumping = false;
                } else {
                    yOffset = -Math.sin(t * Math.PI) * 22;
                }
            }

            if (ducking) {
                var td = (performance.now() - duckStart) / 500;
                if (td >= 1) {
                    ducking = false;
                }
            }

            dino.style.left = pos + 'px';
            dino.style.transform = 'translateX(-50%) translateY(' + yOffset + 'px)';
            dino.classList.toggle('is-air', jumping);
            dino.classList.toggle('is-duck', ducking);

            if (pos > endX) {
                resetRun();
            }

            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    // ---- Header rangi har 10 soniyada avtomatik almashadi ----
    (function () {
        var siteHeader = document.querySelector('.site-header');
        if (!siteHeader) return;

        var brandLetters = document.querySelectorAll('.site-brand span');
        var navLinks = document.querySelectorAll('.site-nav-links .nav-link');
        var dinoSvg = document.querySelector('#headerDino svg');
        var toggleBtn = document.getElementById('themeToggleBtn');

        var palette = [
            { bg: '#0a0a0a', text: '#faf9f6' },
            { bg: '#0b3d2e', text: '#a8f0d1' },
            { bg: '#0c2d55', text: '#a9d3ff' },
            { bg: '#4a1042', text: '#f3b8e6' },
            { bg: '#5c2a04', text: '#ffcf9e' },
            { bg: '#5c0b0b', text: '#ffb3b3' },
            { bg: '#1f1f1f', text: '#ffffff' },
            { bg: '#123d3d', text: '#a0f5f0' },
            { bg: '#3d3d0b', text: '#f3f0a8' },
            { bg: '#2a0b4a', text: '#d3b8ff' }
        ];

        var idx = 0;

        function applyColor(c) {
            siteHeader.style.backgroundColor = c.bg;
            brandLetters.forEach(function (el) { el.style.color = c.text; });
            navLinks.forEach(function (el) { el.style.color = c.text; });
            if (dinoSvg) dinoSvg.style.fill = c.text;
            if (toggleBtn) {
                toggleBtn.style.backgroundColor = c.text;
                toggleBtn.style.borderColor = c.text;
                toggleBtn.style.color = c.bg;
            }
        }

        applyColor(palette[idx]);

        setInterval(function () {
            idx = (idx + 1) % palette.length;
            applyColor(palette[idx]);
        }, 10000);
    })();

    const themeBtn = document.getElementById('themeToggleBtn');
    if (themeBtn) {
        if (localStorage.getItem('pfTheme') === 'light') {
            document.documentElement.classList.add('light-mode');
        }
        themeBtn.addEventListener('click', function () {
            document.documentElement.classList.toggle('light-mode');
            localStorage.setItem('pfTheme', document.documentElement.classList.contains('light-mode') ? 'light' : 'dark');
        });
    }
})();

(function () {
    const form = document.getElementById('profileEditForm');
    const saveBar = document.getElementById('saveBar');
    const avatarInput = document.getElementById('avatarInput');
    const avatarCircle = document.getElementById('avatarCircle');
    const avatarRemoveInput = document.getElementById('avatarRemoveInput');
    const bioInput = document.getElementById('bioInput');
    const bioCount = document.getElementById('bioCount');
    const nameInput = document.getElementById('nameInput');
    const usernameInput = document.getElementById('usernameInput');
    const usernameStatus = document.getElementById('usernameStatus');
    const channelBtn = document.getElementById('channelAttachBtn');
    const channelInput = document.getElementById('channelLinkInput');
    const linkedList = document.getElementById('linkedChannelsList');

    const initialData = new FormData(form);
    const initialState = JSON.stringify(Array.from(initialData.entries()).filter(([k]) => k !== 'avatar'));

     function checkDirty() {
        // Tugmalar endi doim ko'rinadi — bu funksiya faqat kelajakda kerak bo'lsa qoldirildi
    }

    /* =====================================================================
       TUGMALAR: sichqoncha ustida bo'lmaganda 40s dan keyin qo'l bilan
       "salomlashish" animatsiyasi 3 marta ishlaydi, so'ng yana 40s kutadi.
    ===================================================================== */
    (function () {
        const waveButtons = document.querySelectorAll('.save-bar .btn');
        const idleTimers = new Map();

        function startIdleTimer(btn) {
            clearIdleTimer(btn);
            const t = setTimeout(function () {
                btn.classList.add('is-waving');
            }, 40 * 1000);
            idleTimers.set(btn, t);
        }

        function clearIdleTimer(btn) {
            const t = idleTimers.get(btn);
            if (t) clearTimeout(t);
            idleTimers.delete(btn);
        }

        waveButtons.forEach(function (btn) {
            startIdleTimer(btn);

            const hand = btn.querySelector('.btn-hand');
            if (hand) {
                hand.addEventListener('animationend', function () {
                    btn.classList.remove('is-waving');
                    startIdleTimer(btn);
                });
            }

            btn.addEventListener('mouseenter', function () {
                clearIdleTimer(btn);
                btn.classList.remove('is-waving');
            });

            btn.addEventListener('mouseleave', function () {
                startIdleTimer(btn);
            });
        });
    })();







    // ---- Email / Telefon / Familiya: ko'z tugmasi + holatni saqlash ----
    const avatarEmailLine = document.getElementById('avatarEmailLine');
    const avatarPhoneLine = document.getElementById('avatarPhoneLine');

    function maskValue(value) {
        if (!value) return '';
        return '•'.repeat(Math.min(value.length, 24));
    }

    function updateContactLine(lineEl, toggleBtn, inputRef, label) {
        if (!lineEl || !toggleBtn || !inputRef) return;
        const isHidden = toggleBtn.classList.contains('is-hidden');
        const val = (inputRef.dataset.realValue || '').trim();

        if (!isHidden && val) {
            lineEl.textContent = label + ': ' + val;
            lineEl.classList.add('show');
        } else {
            lineEl.textContent = '';
            lineEl.classList.remove('show');
        }
    }

    function updateAvatarContacts() {
        const emailBtn = document.querySelector('.field-toggle-btn[data-target="emailInput"]');
        const phoneBtn = document.querySelector('.field-toggle-btn[data-target="phoneInput"]');
        updateContactLine(avatarEmailLine, emailBtn, document.getElementById('emailInput'), 'Email');
        updateContactLine(avatarPhoneLine, phoneBtn, document.getElementById('phoneInput'), 'Tel');
    }

    function setToggleState(btn, input, hidden, shouldSave) {
        btn.classList.toggle('is-hidden', hidden);
        input.value = hidden ? maskValue(input.dataset.realValue) : input.dataset.realValue;
        if (shouldSave) {
            try {
                localStorage.setItem('chatovbs_hidden_' + input.id, hidden ? '1' : '0');
            } catch (e) {}
            var hiddenField = input.id === 'phoneInput' ? document.getElementById('showPhoneInput')
                : input.id === 'emailInput' ? document.getElementById('showEmailInput') : null;
            if (hiddenField) hiddenField.value = hidden ? '0' : '1';
        }
        updateAvatarContacts();
    }





        // ---- Bio matnini avatar kartasida jonli ko'rsatish ----
    const avatarBioDesc = document.getElementById('avatarBioDesc');

    function linkifyText(text) {
        const escapeDiv = document.createElement('div');
        escapeDiv.textContent = text;
        let escaped = escapeDiv.innerHTML;
        const urlRegex = /((https?:\/\/|www\.|t\.me\/)[^\s<]+)/gi;
        escaped = escaped.replace(urlRegex, function (match) {
            let href = match;
            if (href.toLowerCase().startsWith('t.me/')) {
                href = 'https://' + href;
            } else if (!href.toLowerCase().startsWith('http')) {
                href = 'https://' + href;
            }
            return '<a href="' + href + '" target="_blank" rel="noopener noreferrer">' + match + '</a>';
        });
        return escaped;
    }

    function updateAvatarBio() {
        if (!avatarBioDesc) return;
        const val = bioInput.value.trim();
        if (val) {
            avatarBioDesc.innerHTML = linkifyText(val);
            avatarBioDesc.style.display = 'block';
        } else {
            avatarBioDesc.textContent = '';
            avatarBioDesc.style.display = 'none';
        }
    }

    updateAvatarBio();
    bioInput.addEventListener('input', updateAvatarBio);

    document.querySelectorAll('.field-toggle-btn').forEach(function (btn) {
        const targetId = btn.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;

        input.dataset.realValue = input.value;

        let savedHidden = false;
        try {
            savedHidden = localStorage.getItem('chatovbs_hidden_' + targetId) === '1';
        } catch (e) {}

        setToggleState(btn, input, savedHidden, false);

        btn.addEventListener('click', function () {
            const newHidden = !btn.classList.contains('is-hidden');
            setToggleState(btn, input, newHidden, true);
        });
    });

    form.addEventListener('submit', function () {
        document.querySelectorAll('.field-toggle-btn.is-hidden').forEach(function (btn) {
            const targetId = btn.dataset.target;
            const input = document.getElementById(targetId);
            if (input && input.dataset.realValue !== undefined) {
                input.value = input.dataset.realValue;
            }
        });
    });

    updateAvatarContacts();


    // t.me/... matnlariga bosilganda nusxa olish
    document.querySelectorAll('.tme-copy').forEach(function (el) {
        el.addEventListener('click', function (event) {
            event.stopPropagation();
            const value = el.dataset.value;
            navigator.clipboard.writeText(value).then(function () {
                const original = el.textContent;
                el.textContent = 'Nusxalandi!';
                el.classList.add('is-copied');
                setTimeout(function () {
                    el.textContent = original;
                    el.classList.remove('is-copied');
                }, 1200);
            }).catch(function () {});
        });
    });

    document.querySelectorAll('.avatar-channel-mini[data-home-url]').forEach(function (channelCard) {
        function openChannel() {
            channelCard.classList.add('is-opening');
            window.location.href = channelCard.dataset.homeUrl;
        }

        channelCard.addEventListener('click', openChannel);
        channelCard.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openChannel();
            }
        });
    });
   

    function updateBioCount() { bioCount.textContent = bioInput.value.length; }
    updateBioCount();
    bioInput.addEventListener('input', updateBioCount);

    form.addEventListener('input', checkDirty);

    avatarInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            avatarRemoveInput.value = '0';
            const reader = new FileReader();
            reader.onload = e => {
                avatarCircle.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" id="avatarPreview">';
            };
            reader.readAsDataURL(this.files[0]);
        }
        checkDirty();
    });

    function removeCurrentAvatar() {
        avatarInput.value = '';
        avatarRemoveInput.value = '1';
        avatarCircle.innerHTML = '<span id="avatarLetter">' + (nameInput.value.trim().charAt(0) || 'F').toUpperCase() + '</span>';
        checkDirty();
    }

    document.getElementById('resetBtn').addEventListener('click', function () {
        form.reset();
        avatarRemoveInput.value = '0';
        updateBioCount();
        
    });

    /* =====================================================================
       AVATAR CARD: "..." dropdown
    ===================================================================== */
    const avatarMenuBtn = document.getElementById('avatarMenuBtn');
    const avatarMenu = document.getElementById('avatarMenu');
    const menuUploadPhoto = document.getElementById('menuUploadPhoto');
    const menuAddPhoto = document.getElementById('menuAddPhoto');
    const menuRemovePhoto = document.getElementById('menuRemovePhoto');
    const avatarAddInput = document.getElementById('avatarAddInput');
    const avatarGallery = document.getElementById('avatarGallery');

    function closeAvatarMenu() { avatarMenu.classList.remove('show'); }

    avatarMenuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        avatarMenu.classList.toggle('show');
    });
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#avatarMenu') && !e.target.closest('#avatarMenuBtn')) {
            closeAvatarMenu();
        }
    });

    menuUploadPhoto.addEventListener('click', function () {
        closeAvatarMenu();
        avatarInput.click();
    });

    menuAddPhoto.addEventListener('click', function () {
        closeAvatarMenu();
        avatarAddInput.click();
    });

    function renderGalleryItem(dataUrl) {
        const item = document.createElement('div');
        item.className = 'avatar-gallery__item';
        item.innerHTML = '<img src="' + dataUrl + '" alt="Rasm">' +
            '<button type="button" title="O\'chirish"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>';
        item.querySelector('button').addEventListener('click', function () {
            item.remove();
            saveGalleryToStorage();
        });
        avatarGallery.appendChild(item);
    }

    function saveGalleryToStorage() {
        const imgs = Array.from(avatarGallery.querySelectorAll('img')).map(function (img) { return img.src; });
        try { localStorage.setItem('chatovbs_profile_gallery', JSON.stringify(imgs)); } catch (e) {}
    }

    (function loadGalleryFromStorage() {
        try {
            const saved = JSON.parse(localStorage.getItem('chatovbs_profile_gallery') || '[]');
            saved.forEach(renderGalleryItem);
        } catch (e) {}
    })();

    avatarAddInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            renderGalleryItem(e.target.result);
            saveGalleryToStorage();
        };
        reader.readAsDataURL(file);
        this.value = '';
    });

    if (menuRemovePhoto) {
        menuRemovePhoto.addEventListener('click', function () {
            closeAvatarMenu();
            removeCurrentAvatar();
        });
    }

    /* =====================================================================
       CARD BACKGROUND COLOR PICKER — istalgan kartaga ulanadi, fon rangi
       o'zgarganda matnlar (sarlavha, label, hint) avtomatik oq/qora bo'lib,
       har doim o'qiladigan bo'lib qoladi (qo'shimcha tugma shart emas).
    ===================================================================== */
    function hexLuminance(hex) {
        const c = hex.replace('#', '');
        const r = parseInt(c.substring(0, 2), 16) / 255;
        const g = parseInt(c.substring(2, 4), 16) / 255;
        const b = parseInt(c.substring(4, 6), 16) / 255;
        const lin = v => (v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4));
        return 0.2126 * lin(r) + 0.7152 * lin(g) + 0.0722 * lin(b);
    }

    function setupCardColorPicker(cardId, btnId, swatchId, inputId, storageKey) {
        const card = document.getElementById(cardId);
        const swatch = document.getElementById(swatchId);
        const input = document.getElementById(inputId);
        if (!card || !swatch || !input) return;

        function apply(hex) {
            const isLight = hexLuminance(hex) > 0.5;
            card.style.setProperty('--card-color', hex);
            card.style.setProperty('--card-text', isLight ? '#0a0a0a' : '#ffffff');
            card.style.setProperty('--card-text-muted', isLight ? 'rgba(10,10,10,0.62)' : 'rgba(255,255,255,0.65)');
            swatch.style.backgroundColor = hex;
        }

        let saved = null;
        try { saved = localStorage.getItem(storageKey); } catch (e) {}
        if (saved) {
            input.value = saved;
            apply(saved);
        } else {
            apply(input.value);
        }

        input.addEventListener('input', function () {
            apply(this.value);
            try { localStorage.setItem(storageKey, this.value); } catch (e) {}
        });
    }
    setupCardColorPicker('pfLeftCard', 'cardColorBtn', 'cardColorSwatch', 'cardColorInput', 'chatovbs_profile_card_color');
    setupCardColorPicker('personalInfoCard', 'personalColorBtn', 'personalColorSwatch', 'personalColorInput', 'chatovbs_profile_personal_color');
    setupCardColorPicker('storiesCard', 'storiesColorBtn', 'storiesColorSwatch', 'storiesColorInput', 'chatovbs_profile_stories_color');


        // Username haqida ma'lumot paneli — bosilganda animatsiya bilan ochiladi/yopiladi
    const usernameInfoBtn = document.getElementById('usernameInfoBtn');
    const usernameInfo = document.getElementById('usernameInfo');
    if (usernameInfoBtn && usernameInfo) {
        usernameInfoBtn.addEventListener('click', function () {
            const isOpen = usernameInfo.classList.toggle('is-open');
            usernameInfoBtn.classList.toggle('is-active', isOpen);
        });
    }
   
     // Username: Telegram uslubida — faqat harf/raqam/"_" , yozayotganda avtomatik filtrlanadi
    let usernameTimer = null;

    usernameInput.addEventListener('input', function () {
        // Ruxsat etilmagan belgilarni real vaqtda olib tashlaymiz
        const cursorPos = this.selectionStart;
        const cleaned = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        if (cleaned !== this.value) {
            const diff = this.value.length - cleaned.length;
            this.value = cleaned;
            this.setSelectionRange(cursorPos - diff, cursorPos - diff);
        }

        const val = this.value.trim();
        clearTimeout(usernameTimer);
        usernameStatus.className = 'username-status';

        if (val.length === 0) {
            usernameStatus.textContent = '';
            return;
        }
        if (/^[0-9_]/.test(val)) {
            usernameStatus.textContent = 'Username harf bilan boshlanishi kerak';
            usernameStatus.className = 'username-status taken';
            return;
        }
        if (val.length < 5) {
            usernameStatus.textContent = 'Kamida 5 ta belgi bo\'lishi kerak';
            usernameStatus.className = 'username-status taken';
            return;
        }
        if (val.length > 32) {
            usernameStatus.textContent = 'Ko\'pi bilan 32 ta belgi bo\'lishi mumkin';
            usernameStatus.className = 'username-status taken';
            return;
        }

        usernameStatus.textContent = 'Tekshirilmoqda...';
        usernameStatus.classList.add('checking');

        usernameTimer = setTimeout(() => {
            fetch(`{{ url('/profile/check-username') }}?username=${encodeURIComponent(val)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.available) {
                        usernameStatus.textContent = 'Bu username bo\'sh, olishingiz mumkin';
                        usernameStatus.className = 'username-status ok';
                    } else {
                        usernameStatus.textContent = 'Bu username band, boshqasini tanlang';
                        usernameStatus.className = 'username-status taken';
                    }
                })
                .catch(() => { usernameStatus.textContent = ''; });
        }, 450);
    });

    // Kanal/chat ulash: faqat joriy foydalanuvchining entitylari qidiriladi.
    if (channelBtn) {
        let selectedEntityId = null;
        const entityResults = document.getElementById('profileEntityResults');
        let entitySearchTimer = null;

        function entityAvatar(entity) {
            const image = entity.avatar || entity.chat_avatar || '';
            return image ? '<img src="' + image.replace(/"/g, '&quot;') + '" alt="">' : (entity.name || '?').charAt(0).toUpperCase();
        }

        function renderEntityResults(entities) {
            entityResults.innerHTML = '';
            if (!entities.length) {
                entityResults.innerHTML = '<p class="link-empty">Sizga tegishli kanal yoki chat topilmadi.</p>';
                entityResults.hidden = false;
                return;
            }
            entities.forEach(function (entity) {
                const row = document.createElement('div');
                row.className = 'profile-entity-result';
                row.dataset.id = entity.id;
                var entityKind = entity.type === 'channel' ? 'Kanal' : 'Guruh';
                var entityUsername = entity.username ? 't.me/' + entity.username : 'havola yo‘q';
                var linkedChat = entity.chat_name
                    ? '<span class="profile-entity-result__chat">Biriktirilgan chat: <strong>' + entity.chat_name + '</strong>' + (entity.chat_username ? ' <span class="profile-entity-result__username">t.me/' + entity.chat_username + '</span>' : '') + '</span>'
                    : '';
                row.innerHTML = '<span class="profile-entity-result__avatar">' + entityAvatar(entity) + '</span>' +
                    '<span class="profile-entity-result__body"><span class="profile-entity-result__name">' + (entity.name || '') + '</span>' +
                    '<span class="profile-entity-result__meta"><span class="profile-entity-result__kind">' + entityKind + '</span><span class="profile-entity-result__username">' + entityUsername + '</span>' + linkedChat + '</span><span class="profile-entity-result__choose">Shuni tanlash</span></span>';
                row.addEventListener('click', function () {
                    entityResults.querySelectorAll('.profile-entity-result').forEach(function (item) { item.classList.remove('selected'); });
                    row.classList.add('selected');
                    selectedEntityId = entity.id;
                    channelInput.value = entity.username || entity.name;
                });
                entityResults.appendChild(row);
            });
            entityResults.hidden = false;
        }

        function searchProfileEntities(query) {
            selectedEntityId = null;
            clearTimeout(entitySearchTimer);
            query = query.trim().replace(/^https?:\/\//i, '').replace(/^t\.me\//i, '').replace(/^@/, '');
            entitySearchTimer = setTimeout(function () {
                fetch('{{ route('profile.link-channel.search') }}?q=' + encodeURIComponent(query), {headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}})
                    .then(function (response) { return response.json(); })
                    .then(function (data) { renderEntityResults(data.entities || []); })
                    .catch(function () { entityResults.hidden = true; });
            }, 180);
        }

        channelInput.addEventListener('input', function () {
            const query = channelInput.value.trim();
            if (!query) {
                selectedEntityId = null;
                clearTimeout(entitySearchTimer);
                entityResults.hidden = true;
                entityResults.innerHTML = '';
                return;
            }
            searchProfileEntities(query);
        });

        channelBtn.addEventListener('click', function () {
            if (!selectedEntityId) { channelInput.focus(); return; }
            fetch("{{ route('profile.link-channel') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ entity_id: selectedEntityId })
            })
            .then(function (response) { if (!response.ok) throw new Error('Ulashda xatolik'); return response.json(); })
            .then(function () { location.reload(); })
            .catch(function (error) { console.error('Ulashda xato:', error); });
        });
    }

    // Ulangan kanal/chatni o'chirish
    if (linkedList) {
        linkedList.addEventListener('click', function (e) {
            if (!e.target.classList.contains('linked-item__remove')) return;
            const id = e.target.dataset.id;
            if (e.target.classList.contains('linked-chat-remove')) {
                fetch(`{{ url('/chat-entities/channel') }}/${id}/chat/delete`, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function (response) { if (!response.ok) throw new Error('Chatni o‘chirishda xatolik'); return response.json(); })
                .then(function () { location.reload(); })
                .catch(function (error) { console.error('Chatni o‘chirishda xato:', error); });
                return;
            }
            fetch(`{{ url('/profile/link-channel') }}/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(() => location.reload())
            .catch(err => console.error('O\'chirishda xato:', err));
        });
    }

    /* =====================================================================
       STORIES: yuklash (progress bilan), o'chirish (animatsiyali),
       to'liq ekranli ko'rish (Telegram-uslub) — hammasi shu blokda.
    ===================================================================== */
     (function () {
        const storiesRow = document.getElementById('storiesRow');

         const storiesHint = document.getElementById('storiesHint');
        if (storiesHint) {
            setTimeout(function () {
                storiesHint.classList.add('is-hiding');
            }, 40 * 1000); // 40 soniyadan keyin yo'qoladi
        }

        const storyInputTop = document.getElementById('storyInput');       // "Joylash" tugmasi ichidagi input
        const storyAddTileInput = document.getElementById('storyAddTileInput'); // "+" plitkasi ichidagi input
        const storyPublishBtn = document.getElementById('storyPublishBtn');
        const storeUrl = "{{ Route::has('stories.store') ? route('stories.store') : '' }}";
        const destroyBaseUrl = "{{ Route::has('stories.destroy') ? url('/stories') : '' }}";
        const csrfToken = "{{ csrf_token() }}";

        let uidCounter = 0;
        function nextUid() { uidCounter += 1; return 'pending-' + Date.now() + '-' + uidCounter; }

        function removeEmptyMessage() {
            const empty = document.getElementById('storiesEmptyMsg');
            if (empty) empty.remove();
        }

        function showEmptyMessageIfNeeded() {
            const hasCards = storiesRow.querySelector('.story-card');
            if (!hasCards && !document.getElementById('storiesEmptyMsg')) {
                const span = document.createElement('span');
                span.className = 'stories-empty';
                span.id = 'storiesEmptyMsg';
                span.textContent = "Hozircha istoriya yo'q";
                storiesRow.appendChild(span);
            }
        }

        function isVideoFile(file) {
            return file.type.indexOf('video') === 0;
        }

        // ---- Optimistik karta yaratish (yuklash boshlanishi bilanoq ko'rinadi) ----
        function buildPendingCard(file) {
            const uid = nextUid();
            const objectUrl = URL.createObjectURL(file);
            const isVideo = isVideoFile(file);

            const card = document.createElement('div');
            card.className = 'story-card is-uploading';
            card.dataset.uid = uid;
            card.dataset.type = isVideo ? 'video' : 'image';
            card.dataset.src = objectUrl;

            let mediaHTML = isVideo
                ? '<video src="' + objectUrl + '" muted playsinline preload="metadata"></video>'
                : '<img src="' + objectUrl + '" alt="Yuklanmoqda">';

            card.innerHTML = mediaHTML
                + '<span class="story-card__scrim"></span>'
                + '<span class="story-card__spinner"></span>'
                + '<div class="story-card__progress-wrap">'
                + '  <div class="story-card__progress-track"><div class="story-card__progress-bar"></div></div>'
                + '  <div class="story-card__progress-txt">Yuklanmoqda... 0%</div>'
                + '</div>'
                + '<button type="button" class="story-card__del" title="Bekor qilish">'
                + '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
                + '</button>';

            removeEmptyMessage();
            // "+" plitkasidan keyin, ro'yxat boshiga qo'shamiz
            const addTile = storiesRow.querySelector('.story-add');
            if (addTile && addTile.nextSibling) {
                storiesRow.insertBefore(card, addTile.nextSibling);
            } else {
                storiesRow.appendChild(card);
            }

            return { card, uid, objectUrl };
        }

        function setProgress(card, percent) {
            const bar = card.querySelector('.story-card__progress-bar');
            const txt = card.querySelector('.story-card__progress-txt');
            if (bar) bar.style.width = percent + '%';
            if (txt) txt.textContent = (percent >= 100 ? "Qayta ishlanmoqda..." : ('Yuklanmoqda... ' + percent + '%'));
        }

        function markFailed(card) {
            card.classList.remove('is-uploading');
            card.classList.add('is-failed');
            const wraps = card.querySelectorAll('.story-card__progress-wrap, .story-card__spinner');
            wraps.forEach(function (el) { el.remove(); });
            const retryBtn = document.createElement('button');
            retryBtn.type = 'button';
            retryBtn.className = 'story-card__retry';
            retryBtn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg> Qayta yuklash';
            card.appendChild(retryBtn);
            retryBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                card.remove();
                showEmptyMessageIfNeeded();
            });
        }

        function markUploaded(card) {
            card.classList.remove('is-uploading');
            const wraps = card.querySelectorAll('.story-card__progress-wrap, .story-card__spinner');
            wraps.forEach(function (el) { el.remove(); });
        }

        // ---- Faylni progress bilan yuklash (XHR — upload progress uchun) ----
             function uploadStoryFile(file, caption) {
            if (!storeUrl) {
                alert("Istoriya yuklash marshruti (stories.store) topilmadi. Backendda `stories.store` route'ini qo'shing.");
                return;
            }
            const pending = buildPendingCard(file);
            if (caption) {
                pending.card.dataset.caption = caption;
            }

            const fd = new FormData();
            fd.append('story', file);
            fd.append('caption', caption || '');
            fd.append('_token', csrfToken);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', storeUrl, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    const percent = Math.min(99, Math.round((e.loaded / e.total) * 100));
                    setProgress(pending.card, percent);
                }
            });

            xhr.addEventListener('load', function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    setProgress(pending.card, 100);
                    markUploaded(pending.card);
                    // Serverdagi haqiqiy holat bilan sinxronlash uchun sahifa yangilanadi,
                    // ammo endi foydalanuvchi bu vaqtgacha yuklanish jarayonini ko'rib turadi.
                    setTimeout(function () { location.reload(); }, 350);
                } else {
                    markFailed(pending.card);
                }
            });

            xhr.addEventListener('error', function () {
                markFailed(pending.card);
            });

            xhr.send(fd);
        }

             function handleFileChosen(inputEl) {
            const file = inputEl.files && inputEl.files[0];
            if (!file) return;

            const maxBytes = 150 * 1024 * 1024; // 150MB — server limitiga mos
            if (file.size > maxBytes) {
                alert("Fayl hajmi juda katta (150MB dan oshmasligi kerak).");
                inputEl.value = '';
                return;
            }

            openStoryCompose(file);
            inputEl.value = '';
        }

        /* ---- Compose modal: yuklashdan oldin izoh yozish ---- */
        const composeModal = document.getElementById('storyCompose');
        const composePreviewImg = document.getElementById('storyComposePreviewImg');
        const composePreviewVideo = document.getElementById('storyComposePreviewVideo');
        const composeCaption = document.getElementById('storyComposeCaption');
        const composeSubmit = document.getElementById('storyComposeSubmit');
        const composeClose = document.getElementById('storyComposeClose');

        let composeFile = null;
        let composeObjectUrl = null;

        function openStoryCompose(file) {
            composeFile = file;
            composeObjectUrl = URL.createObjectURL(file);
            composeCaption.value = '';

            if (isVideoFile(file)) {
                composePreviewImg.style.display = 'none';
                composePreviewVideo.style.display = 'block';
                composePreviewVideo.src = composeObjectUrl;
            } else {
                composePreviewVideo.style.display = 'none';
                composePreviewVideo.removeAttribute('src');
                composePreviewImg.style.display = 'block';
                composePreviewImg.src = composeObjectUrl;
            }

            composeModal.classList.add('show');
        }

        function closeStoryCompose() {
            composeModal.classList.remove('show');
            composePreviewVideo.pause();
            composePreviewVideo.removeAttribute('src');
            if (composeObjectUrl) {
                URL.revokeObjectURL(composeObjectUrl);
                composeObjectUrl = null;
            }
            composeFile = null;
        }

        composeClose.addEventListener('click', closeStoryCompose);
        composeModal.addEventListener('click', function (e) {
            if (e.target === composeModal) closeStoryCompose();
        });

        composeSubmit.addEventListener('click', function () {
            if (!composeFile) return;
            const caption = composeCaption.value.trim();
            uploadStoryFile(composeFile, caption);
            closeStoryCompose();
        });

        if (storyInputTop) {
            storyInputTop.addEventListener('click', function (e) { e.stopPropagation(); });
            storyInputTop.addEventListener('change', function () { handleFileChosen(storyInputTop); });
        }
        if (storyAddTileInput) {
            storyAddTileInput.addEventListener('change', function () { handleFileChosen(storyAddTileInput); });
        }


        if (storyPublishBtn && storyInputTop) {
    storyPublishBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        storyInputTop.click();
    });
}

        // ---- O'chirish (kartadagi savat tugmasi) ----
        function deleteStoryCard(card) {
            const id = card.dataset.id;
            card.classList.add('is-deleting');

            function finishRemoval() {
                card.remove();
                showEmptyMessageIfNeeded();
            }

            if (!id || !destroyBaseUrl) {
                // Optimistik/lokal karta — serverga so'rov yubormasdan olib tashlaymiz
                setTimeout(finishRemoval, 260);
                return;
            }

            fetch(destroyBaseUrl + '/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function () { setTimeout(finishRemoval, 260); })
            .catch(function () {
                card.classList.remove('is-deleting');
                alert("Istoriyani o'chirishda xatolik yuz berdi.");
            });
        }

        storiesRow.addEventListener('click', function (e) {
            const delBtn = e.target.closest('.story-card__del');
            if (delBtn) {
                e.preventDefault();
                e.stopPropagation();
                const card = delBtn.closest('.story-card');
                if (card) deleteStoryCard(card);
                return;
            }

            const card = e.target.closest('.story-card');
            if (card && !card.classList.contains('is-uploading') && !card.classList.contains('is-failed')) {
                openStoryViewer(card);
            }
        });

        /* =================================================================
           STORY VIEWER — to'liq ekranli, Telegram-uslubidagi ko'rish oynasi
        ================================================================= */
        const viewer = document.getElementById('storyViewer');
        const stage = document.getElementById('storyViewerStage');
        const barsWrap = document.getElementById('storyViewerBars');
        const imgEl = document.getElementById('storyViewerImg');
        const videoEl = document.getElementById('storyViewerVideo');
        const closeBtn = document.getElementById('storyViewerCloseBtn');
        const deleteBtn = document.getElementById('storyViewerDeleteBtn');
        const muteBtn = document.getElementById('storyViewerMuteBtn');
        const prevZone = document.getElementById('storyViewerPrevZone');
        const nextZone = document.getElementById('storyViewerNextZone');
        const arrowLeft = document.getElementById('storyViewerArrowLeft');
        const arrowRight = document.getElementById('storyViewerArrowRight');

        const IMAGE_DURATION_MS = 5000;
        let storyList = [];
        let currentIndex = 0;
       let isMuted = false;
        let imageTimer = null;

        function collectStories() {
            return Array.from(storiesRow.querySelectorAll('.story-card')).filter(function (c) {
                return !c.classList.contains('is-uploading') && !c.classList.contains('is-failed');
            });
        }

        function buildBars() {
            barsWrap.innerHTML = '';
            storyList.forEach(function () {
                const bar = document.createElement('div');
                bar.className = 'story-viewer__bar';
                bar.innerHTML = '<span class="story-viewer__bar-fill"></span>';
                barsWrap.appendChild(bar);
            });
        }

        function setBarsState() {
            const fills = barsWrap.querySelectorAll('.story-viewer__bar-fill');
            fills.forEach(function (fill, i) {
                fill.style.animation = 'none';
                fill.style.width = i < currentIndex ? '100%' : '0%';
            });
        }

        function startBarAnimation(durationMs) {
            const fills = barsWrap.querySelectorAll('.story-viewer__bar-fill');
            const fill = fills[currentIndex];
            if (!fill) return;
            fill.style.width = '0%';
            // reflow — animatsiyani qaytadan ishga tushirish uchun
            void fill.offsetWidth;
            fill.style.animation = 'storyBarFill ' + durationMs + 'ms linear forwards';
        }

        function clearImageTimer() {
            if (imageTimer) { clearTimeout(imageTimer); imageTimer = null; }
        }

        function stopMedia() {
            videoEl.pause();
            videoEl.removeAttribute('src');
            videoEl.load();
            clearImageTimer();
        }

        function renderStory(index) {
            const card = storyList[index];
            if (!card) return;
            currentIndex = index;

            const type = card.dataset.type;
            const src = card.dataset.src;

            stopMedia();
            setBarsState();

            if (type === 'video') {
                imgEl.style.display = 'none';
                videoEl.style.display = 'block';
                videoEl.src = src;
                videoEl.muted = isMuted;
                videoEl.currentTime = 0;
                muteBtn.style.display = 'grid';
                updateMuteIcon();

                videoEl.play().catch(function () {});
                videoEl.onloadedmetadata = function () {
                    const durMs = isFinite(videoEl.duration) ? videoEl.duration * 1000 : IMAGE_DURATION_MS;
                    startBarAnimation(durMs);
                };
                videoEl.onended = function () { goNext(); };
            } else {
                videoEl.style.display = 'none';
                imgEl.style.display = 'block';
                imgEl.src = src;
                muteBtn.style.display = 'none';
                startBarAnimation(IMAGE_DURATION_MS);
                imageTimer = setTimeout(function () { goNext(); }, IMAGE_DURATION_MS);
            }

               const captionEl = document.getElementById('storyViewerCaption');
            const captionText = card.dataset.caption || '';
            if (captionText) {
                captionEl.textContent = captionText;
                captionEl.style.display = 'block';
            } else {
                captionEl.style.display = 'none';
            }

            const timeEl = document.getElementById('storyViewerTime');
const createdAt = card.dataset.createdAt ? parseInt(card.dataset.createdAt, 10) * 1000 : null;
timeEl.textContent = (currentIndex + 1) + '/' + storyList.length + (createdAt ? ' • ' + relativeTime(createdAt) : '');
            
function formatViewTime(ts) {
    const d = new Date(ts);
    const now = new Date();
    const isToday = d.toDateString() === now.toDateString();
    const y = new Date(now); y.setDate(now.getDate() - 1);
    const isYesterday = d.toDateString() === y.toDateString();
    const hh = String(d.getHours()).padStart(2, '0');
    const mm = String(d.getMinutes()).padStart(2, '0');
    if (isToday) return 'bugun, ' + hh + ':' + mm;
    if (isYesterday) return 'kecha, ' + hh + ':' + mm;
    return d.toLocaleDateString('uz-UZ') + ', ' + hh + ':' + mm;
}

function renderViewsSummary(card) {
    const summary = document.getElementById('storyViewerViewsSummary');
    const avatarsWrap = document.getElementById('storyViewerViewsAvatars');
    const countEl = document.getElementById('storyViewerViewsCount');
    const panel = document.getElementById('storyViewerViewsPanel');
    const list = document.getElementById('storyViewerViewsList');

    panel.classList.remove('show');

    let viewers = [];
    try { viewers = JSON.parse(card.dataset.viewers || '[]'); } catch (e) {}
    const count = viewers.length;

    if (count > 0) {
        avatarsWrap.innerHTML = viewers.slice(0, 5).map(function (v) {
            return v.avatar
                ? '<span><img src="' + v.avatar + '" alt=""></span>'
                : '<span>' + (v.name ? v.name.charAt(0).toUpperCase() : '?') + '</span>';
        }).join('');
        countEl.textContent = count + ' views';
        summary.style.display = 'flex';
    } else {
        summary.style.display = 'none';
    }

    if (count > 0) {
        list.innerHTML = viewers.map(function (v) {
            const avatarHtml = v.avatar
                ? '<img src="' + v.avatar + '" alt="">'
                : (v.name ? v.name.charAt(0).toUpperCase() : '?');
            const reactionHtml = v.reaction ? '<span class="svp-reaction">' + v.reaction + '</span>' : '';
            return '<div class="svp-row">'
                + '<div class="svp-avatar">' + avatarHtml + '</div>'
                + '<div class="svp-info">'
                + '<div class="svp-name">' + v.name + '</div>'
                + '<div class="svp-time"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>' + formatViewTime(v.viewed_at * 1000) + '</div>'
                + '</div>'
                + reactionHtml
                + '</div>';
        }).join('');
    } else {
        list.innerHTML = '<div class="svp-empty">Hali hech kim tomosha qilmagan</div>';
    }
}

        renderViewsSummary(card);

            deleteBtn.dataset.targetId = card.dataset.id || '';
            arrowLeft.style.display = index > 0 ? 'grid' : 'none';
            arrowRight.style.display = index < storyList.length - 1 ? 'grid' : 'none';
        }

        function relativeTime(ts) {
    const diffMs = Date.now() - ts;
    const mins = Math.floor(diffMs / 60000);
    if (mins < 1) return 'hozir';
    if (mins < 60) return mins + ' daqiqa oldin';
    const hrs = Math.floor(mins / 60);
    if (hrs < 24) return hrs + ' soat oldin';
    return Math.floor(hrs / 24) + ' kun oldin';
}

        function updateMuteIcon() {
            muteBtn.innerHTML = isMuted
                ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>'
                : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>';
        }

        function goNext() {
            if (currentIndex < storyList.length - 1) {
                renderStory(currentIndex + 1);
            } else {
                closeViewer();
            }
        }
        function goPrev() {
            if (currentIndex > 0) renderStory(currentIndex - 1);
        }

        function openStoryViewer(clickedCard) {
            storyList = collectStories();
            const idx = storyList.indexOf(clickedCard);
            if (idx === -1) return;

            buildBars();
            viewer.classList.add('show');
            stage.classList.remove('is-leaving');
            document.body.style.overflow = 'hidden';
            renderStory(idx);
        }





        // ↓ YANGI QATORLAR — shu yerga qo'shing
        const viewsSummary = document.getElementById('storyViewerViewsSummary');
        const viewsPanel = document.getElementById('storyViewerViewsPanel');
        if (viewsSummary) {
            viewsSummary.addEventListener('click', function (e) {
                e.stopPropagation();
                viewsPanel.classList.toggle('show');
            });
        }
        if (viewsPanel) {
            viewsPanel.addEventListener('click', function (e) { e.stopPropagation(); });
        }

             function closeViewer() {
            document.getElementById('storyViewerViewsPanel').classList.remove('show');
            stage.classList.add('is-leaving');
            stopMedia();
            setTimeout(function () {
                viewer.classList.remove('show');
                stage.classList.remove('is-leaving');
                document.body.style.overflow = '';
            }, 220);
        }
        closeBtn.addEventListener('click', closeViewer);
        viewer.addEventListener('click', function (e) {
            if (e.target === viewer) closeViewer();
        });
        document.addEventListener('keydown', function (e) {
            if (!viewer.classList.contains('show')) return;
            if (e.key === 'Escape') closeViewer();
            if (e.key === 'ArrowRight') goNext();
            if (e.key === 'ArrowLeft') goPrev();
        });

        prevZone.addEventListener('click', function () { goPrev(); });
        nextZone.addEventListener('click', function () { goNext(); });
        arrowLeft.addEventListener('click', function (e) { e.stopPropagation(); goPrev(); });
        arrowRight.addEventListener('click', function (e) { e.stopPropagation(); goNext(); });

        // video ustida bosilganda pauza/davom ettirish
        videoEl.addEventListener('click', function () {
            if (videoEl.paused) { videoEl.play(); viewer.classList.remove('is-paused'); }
            else { videoEl.pause(); viewer.classList.add('is-paused'); }
        });

        muteBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            isMuted = !isMuted;
            videoEl.muted = isMuted;
            updateMuteIcon();
        });

        deleteBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            const card = storyList[currentIndex];
            if (!card) return;

            if (!confirm("Bu istoriyani o'chirmoqchimisiz?")) return;

            const wasLast = storyList.length === 1;
            deleteStoryCard(card);
            storyList.splice(currentIndex, 1);

            if (wasLast) {
                closeViewer();
                return;
            }
            buildBars();
            const nextIdx = Math.min(currentIndex, storyList.length - 1);
            renderStory(nextIdx);
        });
    })();
})();






(function () {
    function rand(min, max) { return Math.random() * (max - min) + min; }
    var fx = document.getElementById('cardSeasonFx');
    if (!fx) return;

    function renderCardSeason(season) {
        fx.innerHTML = '';
        fx.className = 'season-fx';

        if (season === 'summer') {
            var sun = document.createElement('div');
            sun.className = 'sfx-sun';
            fx.appendChild(sun);
            for (var i = 0; i < 16; i++) {
                var leaf = document.createElement('span');
                leaf.className = 'sfx-leaf';
                var size = rand(9, 16);
                leaf.style.width = size + 'px';
                leaf.style.height = size + 'px';
                leaf.style.left = rand(0, 100) + '%';
                leaf.style.background = 'linear-gradient(135deg,' + (Math.random() > .5 ? '#4ade80,#22c55e' : '#86efac,#4ade80') + ')';
                leaf.style.boxShadow = '0 0 4px rgba(0,0,0,0.35)';
                leaf.style.animationDuration = rand(6, 11) + 's';
                leaf.style.animationDelay = '-' + rand(0, 11) + 's';
                fx.appendChild(leaf);
            }
        }

        if (season === 'winter') {
            var flakes = ['❄', '❅', '❆'];
            for (var i = 0; i < 30; i++) {
                var snow = document.createElement('span');
                snow.className = 'sfx-snow';
                snow.textContent = flakes[Math.floor(rand(0, 3))];
                snow.style.left = rand(0, 100) + '%';
                snow.style.fontSize = rand(10, 18) + 'px';
                snow.style.textShadow = '0 0 4px rgba(0,0,0,0.5), 0 0 2px rgba(0,0,0,0.6)';
                snow.style.animationDuration = rand(6, 12) + 's';
                snow.style.animationDelay = '-' + rand(0, 12) + 's';
                fx.appendChild(snow);
            }
            var snowman = document.createElement('div');
            snowman.className = 'sfx-snowman';
            snowman.textContent = '⛄';
            fx.appendChild(snowman);
        }

        if (season === 'spring') {
            for (var i = 0; i < 20; i++) {
                var petal = document.createElement('span');
                petal.className = 'sfx-petal';
                var psize = rand(8, 13);
                petal.style.width = psize + 'px';
                petal.style.height = psize + 'px';
                petal.style.left = rand(0, 100) + '%';
                petal.style.background = (Math.random() > .5 ? '#fbcfe8' : '#f9a8d4');
                petal.style.boxShadow = '0 0 4px rgba(0,0,0,0.3)';
                petal.style.animationDuration = rand(6, 11) + 's';
                petal.style.animationDelay = '-' + rand(0, 11) + 's';
                fx.appendChild(petal);
            }
            for (var i = 0; i < 16; i++) {
                var rd = document.createElement('span');
                rd.className = 'sfx-rain';
                rd.style.left = rand(0, 100) + '%';
                rd.style.opacity = .6;
                rd.style.filter = 'drop-shadow(0 0 2px rgba(0,0,0,0.4))';
                rd.style.animationDuration = rand(1.2, 2.2) + 's';
                rd.style.animationDelay = '-' + rand(0, 2.2) + 's';
                fx.appendChild(rd);
            }
        }

        if (season === 'autumn') {
            for (var i = 0; i < 18; i++) {
                var aleaf = document.createElement('span');
                aleaf.className = 'sfx-aleaf';
                var asize = rand(10, 16);
                aleaf.style.width = asize + 'px';
                aleaf.style.height = asize + 'px';
                aleaf.style.left = rand(0, 100) + '%';
                var colors = ['#f59e0b', '#ea580c', '#b45309'];
                aleaf.style.background = colors[Math.floor(rand(0, 3))];
                aleaf.style.boxShadow = '0 0 4px rgba(0,0,0,0.35)';
                aleaf.style.animationDuration = rand(5, 9) + 's';
                aleaf.style.animationDelay = '-' + rand(0, 9) + 's';
                fx.appendChild(aleaf);
            }
            for (var i = 0; i < 20; i++) {
                var rain = document.createElement('span');
                rain.className = 'sfx-rain autumn';
                rain.style.left = rand(0, 100) + '%';
                rain.style.filter = 'drop-shadow(0 0 2px rgba(0,0,0,0.4))';
                rain.style.animationDuration = rand(1.0, 1.8) + 's';
                rain.style.animationDelay = '-' + rand(0, 1.8) + 's';
                fx.appendChild(rain);
            }
        }
    }

    // ---- TEST REJIMI: har 10 soniyada fasllar aylanib almashadi ----
    var seasons = ['spring', 'summer', 'autumn', 'winter'];
    var idx = 0;
    renderCardSeason(seasons[idx]);

    setInterval(function () {
        idx = (idx + 1) % seasons.length;
        renderCardSeason(seasons[idx]);
    }, 10000);
})();
</script>














<script>
(function () {
    var row = document.getElementById('storiesRow');
    if (!row) return;

   var ICON = '<span class="srd-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="4"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="m21 15-5-5L5 21"></path></svg></span>';
    var observer;

    function layoutRows() {
        if (observer) observer.disconnect();

        row.querySelectorAll('.stories-row-divider').forEach(function (d) { d.remove(); });

        var items = Array.prototype.slice.call(row.children).filter(function (el) {
            return el.classList.contains('story-add') || el.classList.contains('story-card');
        });

        var groups = [];
        var lastTop = null;
        items.forEach(function (el) {
            var top = Math.round(el.offsetTop);
            if (lastTop === null || Math.abs(top - lastTop) > 4) {
                groups.push([]);
                lastTop = top;
            }
            groups[groups.length - 1].push(el);
        });

        groups.forEach(function (group, i) {
            var storyCount = group.filter(function (el) {
                return el.classList.contains('story-card');
            }).length;

            var divider = document.createElement('div');
            divider.className = 'stories-row-divider';
            divider.innerHTML = ICON +
                '<span>' + (i + 1) + '-qator</span>' +
                '<span class="stories-row-divider__count">' + storyCount + ' ta istoriya</span>';
            row.insertBefore(divider, group[0]);
        });

        if (observer) observer.observe(row, { childList: true });
    }

    observer = new MutationObserver(layoutRows);

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(layoutRows, 120);
    });

    layoutRows();
    window.addEventListener('load', layoutRows);
})();
</script>

<script>
(function () {
    var dict = {
        uz: {
            profileBack: 'Orqaga', profileTitle: 'Sizning profilingiz', profileSubtitle: 'Bu yerda avatar, ism va username kabi profil ma\'lumotlaringizni tahrirlaysiz. Boshqa foydalanuvchilar tashrif buyurganda profilingizni aynan shu ko\'rinishda ko\'radi.', profileLinkCardTitle: 'Kanal yoki chat ulash', profileLinkAttach: 'Ulash', profileBioLabel: 'Bio', profileLinkPlaceholder: 'mening_kanalim yoki nomi'
        },
        ru: {
            profileBack: 'Назад', profileTitle: 'Ваш профиль', profileSubtitle: 'Здесь вы можете редактировать аватар, имя, имя пользователя и другие данные профиля.', profileLinkCardTitle: 'Подключить канал или чат', profileLinkAttach: 'Подключить', profileBioLabel: 'Био', profileLinkPlaceholder: 'моя_ссылка_или_имя'
        },
        en: {
            profileBack: 'Back', profileTitle: 'Your profile', profileSubtitle: 'Here you can edit your avatar, name, username and other profile information.', profileLinkCardTitle: 'Link a channel or chat', profileLinkAttach: 'Link', profileBioLabel: 'Bio', profileLinkPlaceholder: 'my_channel_or_name'
        },
        ko: {
            profileBack: '뒤로', profileTitle: '내 프로필', profileSubtitle: '여기에서 아바타, 이름, 사용자 이름 등 프로필 정보를 수정할 수 있습니다.', profileLinkCardTitle: '채널 또는 채팅 연결', profileLinkAttach: '연결', profileBioLabel: '소개', profileLinkPlaceholder: '내_채널_또는_이름'
        }
    };
    function apply(lang) {
        var map = dict[lang] || dict.uz;
        document.querySelectorAll('[data-i18n]').forEach(function (el) {
            if (map[el.dataset.i18n]) el.textContent = map[el.dataset.i18n];
        });
        document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
            var key = el.dataset.i18nPlaceholder;
            if (map[key]) el.placeholder = map[key];
        });
    }
    var current = (window.CHATOVBS_SETTINGS && window.CHATOVBS_SETTINGS.language) || 'uz';
    apply(current);
    window.addEventListener('chatovbs:language', function (event) { apply(event.detail || 'uz'); });
})();
</script>

@include('partials.language-runtime')
@endsection