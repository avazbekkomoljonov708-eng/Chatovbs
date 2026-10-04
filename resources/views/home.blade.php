@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --ink: #0a0a0a;
        --ink-soft: #14140f;
        --ink-softer: #1d1d17;
        --paper: #faf9f6;
        --line: #2a2a22;
        --line-soft: #e5e2d8;
        --muted-on-dark: #8a8a80;
        --muted-on-light: #6b6b66;
        --accent: #e0a83e;
        --accent-ink: #14140f;
        --teal: #2dd4bf;
        --teal-ink: #0a1f1c;
        --danger: #f16565;
         --check-blue: #1a56db;
        --radius-lg: 18px;
        --radius-md: 12px;
    }

    * { box-sizing: border-box; }

    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: 100%;
        overflow: hidden;
        background: var(--ink);
    }

    #app nav.navbar, #app .site-header { display: none !important; }
    #app main.py-4 { padding: 0 !important; margin: 0 !important; height: 100vh; }
    #app { height: 100vh; }

    body { font-family: 'Inter', sans-serif; }

    body.day-mode {
        --ink: #f7f7f4;
        --ink-soft: #ffffff;
        --ink-softer: #efefeb;
        --paper: #171817;
        --line: #dcdcd5;
        --line-soft: #e4e4de;
        --muted-on-dark: #777a73;
        --muted-on-light: #666a63;
    }
    body.day-mode .chat-main { background: #ffffff; }
    body.day-mode .cm-messages { background-color: #ffffff; }
    body.day-mode .main-menu-overlay.open { background: rgba(20,20,20,0.18); }
   body.day-mode .cl-search-box,
body.day-mode .sp-search { background: #f3f3f0; border-color: #d8d8d1; }
body.day-mode .composer-box { background: transparent; border: none; }
    body.day-mode .cl-search-box input,
    body.day-mode .composer-box input,
    body.day-mode .sp-search input { color: #171817; }
    body.day-mode .cl-search-box input::placeholder,
    body.day-mode .composer-box input::placeholder,
    body.day-mode .sp-search input::placeholder { color: #777a73; }
    body.day-mode .composer-box:focus-within { border-color: #171817; }
    body.day-mode .send-btn { background: #171817; color: #ffffff; }
    body.day-mode .icon-btn { color: #666a63; }
    body.day-mode .sp-tabs { background: #ffffff; }
    body.day-mode .sp-tab.active { color: #171817; }
    body.day-mode .cm-title h3,
    body.day-mode .cm-empty b,
    body.day-mode .msg-row.in .msg-bubble { color: #171817; }
       body.day-mode .msg-row.out .msg-bubble { background: var(--out-bg, #e8f5e5); color: var(--out-fg, #171817); }
    body.day-mode .icon-btn:hover { background: #e9e9e4; color: #171817; }

    body.night-mode .chat-list-panel,
    body.night-mode .chat-main,
    body.night-mode .side-panel { background: #10110f; color: #f5f4ef; }
    body.night-mode .chat-main { background: #10110f; }
    body.night-mode .cm-header,
    body.night-mode .cm-composer { background: #171916; border-color: #30332d; }
    body.night-mode .cm-title h3,
    body.night-mode .cm-empty b { color: #f5f4ef; }
    body.night-mode .cm-title span,
    body.night-mode .cl-empty,
    body.night-mode .cl-archived-text span { color: #9b9f96; }
    body.night-mode .cm-messages { background: #10110f; }
    body.night-mode .cm-messages.saved-view { background-color: #202822; background-image: radial-gradient(circle at 15% 20%, rgba(45,212,191,0.08), transparent 28%), radial-gradient(circle at 82% 75%, rgba(224,168,62,0.08), transparent 32%); }
    body.night-mode .cl-search-box,
body.night-mode .sp-search { background: #20231f; border-color: #343830; }
body.night-mode .composer-box { background: transparent; border: none; }
    body.night-mode .cl-search-box input,
    body.night-mode .composer-box input,
    body.night-mode .sp-search input { color: #f5f4ef; }
    body.night-mode .cl-archived:hover,
    body.night-mode .cl-item:hover { background: #20231f; }
    body.night-mode .sp-tabs { background: #171916; border-color: #30332d; }
    body.night-mode .sp-content { background: #20231f; }
    body.night-mode .emoji-grid button:hover { background: #343830; }
    body.night-mode .msg-row.in .msg-bubble { background: #252a25; border-color: #343830; color: #f5f4ef; }
    body.night-mode .internal-row { background: #20231f; border-color: #343830; }
    body.night-mode .internal-row__text span,
    body.night-mode .internal-list__empty { color: #9b9f96; }
       body.night-mode .saved-message-bubble { background: var(--out-bg, #285b4b); color: var(--out-fg, #f5f4ef); }
    body.night-mode .saved-message-time { color: #b7d9c8; }

    .app-shell {
        display: flex;
        height: 100vh;
        width: 100%;
        overflow: hidden;
    }

    /* ================= RAIL ================= */
    .rail {
        width: 70px;
        flex-shrink: 0;
        background: var(--ink);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 18px 0;
        gap: 6px;
    }

      .rail-brand {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--ink-softer);
        color: var(--paper);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease;
        position: relative;
        padding: 0;
        align-self: center;
    }
    .rail-brand:hover { background: var(--line); transform: scale(1.06); }
    .rail-brand svg { width: 20px; height: 20px; stroke: currentColor; fill: none; transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1); }
    .rail-brand-dot {
        position: absolute;
        top: 6px;
        right: 7px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--teal);
        border: 2px solid var(--ink);
    }
    .rail-brand.menu-open { background: var(--teal); color: var(--teal-ink); }
    .rail-brand.menu-open .rail-brand-dot { display: none; }
    .rail-brand.menu-open svg { transform: rotate(90deg); }

     .rail-item {
        width: 100%;
        padding: 10px 4px;
        border-radius: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        color: var(--muted-on-dark);
        position: relative;
        transition: background 0.2s ease, color 0.2s ease;
        background: transparent;
        border: none;
        font-family: 'Inter', sans-serif;
    }

    .rail-item:hover { background: var(--ink-soft); color: var(--paper); }

        .rail-item.active { background: var(--ink-softer); color: var(--check-blue); border-radius: 0; }
            .rail-item.active svg path,
    .rail-item.active svg circle { fill: rgba(26,86,219,0.28); }
    .rail-item.active.teal { background: var(--ink-softer); color: var(--teal); border-radius: 0; }

  .rail-item svg { width: 28px; height: 28px; stroke: currentColor; fill: none; }

      .rail-item i {
        font-size: 26px;
        line-height: 1;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .rail-item span { font-size: 10.5px; font-weight: 500; letter-spacing: 0.01em; }

      .rail-badge {
        position: absolute;
        top: 3px;
        right: 8px;
        background: var(--check-blue);
        color: #ffffff;
        font-size: 9.5px;
        font-weight: 700;
        min-width: 15px;
        height: 15px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 3px;
    }
    .rail-badge.teal { background: var(--teal); color: var(--teal-ink); }

    .rail-spacer {
        flex: 1;
    }

    /* ================= MAIN MENU (hamburger flyout) — Telegram-style animation ================= */
    .main-menu-overlay {
        position: fixed;
        inset: 0;
        z-index: 90;
        background: rgba(0,0,0,0);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.22s ease, background 0.22s ease;
    }
    .main-menu-overlay.open {
        opacity: 1;
        pointer-events: auto;
        background: rgba(0,0,0,0.28);
    }

.main-menu {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 6px;
    width: 300px;
    height: 100vh;
    max-height: none;
    background: var(--ink-soft);
    border: 1px solid var(--line);
    border-radius: 0;
    box-shadow: 0 20px 50px rgba(0,0,0,0.45);
    z-index: 91;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform-origin: 0 26px;
    transform: scale(0.98);
    pointer-events: none;
    transition: opacity 0.1s ease, transform 0.12s ease-out;
}
.main-menu::-webkit-scrollbar { width: 5px; }
.main-menu::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }
    .main-menu-overlay.open .main-menu {
        opacity: 1;
        transform: scale(1) translate(0, 0);
        pointer-events: auto;
    }

 .mm-header {
    padding: 18px 16px 16px;
    border-bottom: 1px solid var(--line);
}
    .mm-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--accent);
        color: var(--accent-ink);
        font-family: 'Sora', sans-serif;
        font-weight: 800;
        font-size: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: hidden;
    }
    .mm-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .mm-header-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
    .mm-name {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 14.5px;
        color: var(--paper);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
.mm-status {
    display: block;
    font-size: 12.5px;
    color: var(--teal);
    margin-top: 4px;
    cursor: pointer;
}
    .mm-header-toggle {
        background: none;
        border: none;
        color: var(--muted-on-dark);
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        transition: transform 0.2s ease;
    }
    .mm-header-toggle svg { width: 16px; height: 16px; stroke: currentColor; }
    .mm-header-toggle.open { transform: rotate(180deg); }

    .mm-accounts {
        border-bottom: 1px solid var(--line);
        overflow: hidden;
        max-height: 500px;
        transition: max-height 0.2s ease;
    }
    .mm-accounts.collapsed { max-height: 0; }

 .mm-account {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    min-height: 48px;
    cursor: pointer;
    transition: background 0.15s ease;
}
    .mm-account:hover { background: var(--ink-softer); }
    .mm-account-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: var(--paper);
        border: 2px solid transparent;
    }
    .mm-account.active .mm-account-avatar { border-color: var(--teal); }
    .mm-account-name {
        flex: 1;
        min-width: 0;
        font-size: 13.5px;
        color: var(--paper);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .mm-account-badge {
        background: var(--teal);
        color: var(--teal-ink);
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 999px;
        flex-shrink: 0;
    }

.mm-add-account {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    min-height: 48px;
    cursor: pointer;
    color: var(--teal);
    font-size: 13.5px;
    font-weight: 600;
    transition: background 0.15s ease;
}
    .mm-add-account:hover { background: var(--ink-softer); }
    .mm-add-account-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(45,212,191,0.14);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .mm-add-account-icon svg { width: 16px; height: 16px; stroke: var(--teal); }

    .mm-items { padding: 6px 0; }
    .mm-items + .mm-items { border-top: 1px solid var(--line); }

 .mm-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 10px 16px 10px 22px;
    min-height: 44px;
    cursor: pointer;
    color: var(--paper);
    font-size: 13.5px;
    line-height: 1.3;
    transition: background 0.15s ease;
}
    .mm-item:hover { background: var(--ink-softer); }
    .mm-item.selected { background: rgba(45,212,191,0.12); color: var(--teal); }
    .mm-item.selected svg { stroke: var(--teal); }
    .mm-item svg { width: 19px !important; height: 19px !important; stroke: #2481cc !important; fill: none !important; flex-shrink: 0; }
#mmNewChannel svg { fill: #2481cc !important; stroke: none !important; }

    .mm-item.mm-item-danger { color: var(--danger); }
    .mm-item.mm-item-danger svg { stroke: var(--danger) !important; }
    .mm-item.mm-item-danger:hover { background: rgba(241,101,101,0.12); }

    .mm-item-toggle {
        margin-left: auto;
        width: 34px;
        height: 20px;
        border-radius: 999px;
        background: var(--line);
        position: relative;
        flex-shrink: 0;
        transition: background 0.2s ease;
    }
    .mm-item-toggle::after {
        content: "";
        position: absolute;
        top: 2px;
        left: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: var(--paper);
        transition: left 0.2s ease;
    }
    .mm-item-toggle.on { background: var(--teal); }
    .mm-item-toggle.on::after { left: 16px; }

    .mm-footer {
        margin-top: auto;
        padding: 14px 16px 16px;
        text-align: center;
    }
    .mm-footer b { display: block; font-size: 12px; color: var(--muted-on-dark); font-weight: 600; }
    .mm-footer span { font-size: 11.5px; color: var(--muted-on-dark); opacity: 0.75; }

    /* ---- staggered entrance for menu rows (Telegram-like cascade) ---- */
    .mm-account,
    .mm-add-account,
    .mm-item {
        opacity: 0;
        transform: translateX(-10px);
        transition: opacity 0.1s ease, transform 0.1s ease-out;
    }
    .main-menu-overlay.open .mm-account,
    .main-menu-overlay.open .mm-add-account,
    .main-menu-overlay.open .mm-item {
        opacity: 1;
        transform: translateX(0);
    }

    /* ================= CHAT LIST ================= */
    .chat-list-panel {
        width: 334px;
        flex-shrink: 0;
        background: var(--ink-soft);
        border-right: 1px solid var(--line);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

   .cl-search {
    padding: 12px 10px 8px;
}

.cl-search-box {
    display: flex;
    align-items: center;
    gap: 9px;
    background: var(--ink-softer);
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 6px 14px;
    transition: border-color 0.2s ease;
}

    .cl-search-box:focus-within { border-color: var(--accent); }

    .cl-search-box svg { width: 15px; height: 15px; stroke: var(--muted-on-dark); fill: none; flex-shrink: 0; }

    .cl-search-box input {
        background: transparent;
        border: none;
        outline: none;
        color: var(--paper);
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        width: 100%;
    }
    .cl-search-box input::placeholder { color: var(--muted-on-dark); }

    .cl-archived {
        margin: 4px 8px 6px;
        padding: 10px 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: background 0.15s ease;
    }
    .cl-archived:hover { background: var(--ink-softer); }

       .cl-archived-icon {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: var(--ink-softer);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .cl-archived-icon svg { width: 24px; height: 24px; stroke: var(--muted-on-light); }
    body.night-mode .cl-archived-icon svg { stroke: #c9c9c2; }

    .cl-archived-text { flex: 1; min-width: 0; }
    .cl-archived-text b { display: block; font-size: 13.5px; color: var(--paper); font-weight: 600; }
    .cl-archived-text span { font-size: 12px; color: var(--muted-on-dark); }

    .cl-archived-count {
        background: var(--line);
        color: var(--muted-on-dark);
        font-size: 11px;
        font-weight: 700;
        min-width: 20px;
        height: 20px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6px;
    }

    .cl-items {
        flex: 1;
        overflow-y: auto;
        padding: 2px 8px 12px;
    }
    .cl-items::-webkit-scrollbar { width: 5px; }
    .cl-items::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }

    .cl-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 9px 10px;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: background 0.15s ease, border-radius 0.15s ease;
        position: relative;
    }
    .cl-item:hover { background: var(--ink-softer); }
    .cl-item.active {
        background: var(--check-blue);
        border-radius: 0;
        margin-left: -8px;
        margin-right: -8px;
        padding-left: 18px;
        padding-right: 18px;
    }
     .cl-item.active .cl-name,
    .cl-item.active .cl-msg,
    .cl-item.active .cl-time,
    .cl-item.active .cl-status { color: #ffffff !important; }
    .cl-item.active .cl-msg b { color: #ffffff !important; }

    .cl-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 15px;
        color: var(--paper);
        position: relative;
        overflow: visible;
        border: 2px solid var(--ink-soft);
        box-shadow: 0 0 0 1px rgba(255,255,255,0.16);
    }

    .cl-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%; overflow: hidden; }

    .cl-avatar.online::after {
        content: "";
        position: absolute;
        bottom: -1px;
        right: -1px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #38bdf8;
        border: 2px solid var(--ink);
        box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.35), 0 0 8px rgba(56, 189, 248, 0.7);
        z-index: 2;
        animation: online-dot-pulse 1.8s ease-in-out infinite;
    }
    @keyframes online-dot-pulse {
        0%, 100% { box-shadow: 0 0 0 1px rgba(56, 189, 248, 0.35), 0 0 5px rgba(56, 189, 248, 0.45); }
        50% { box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.18), 0 0 11px rgba(56, 189, 248, 0.9); }
    }
    .cm-status-online { color: #38bdf8 !important; }
         .msg-status { margin-left: 4px; font-size: 13px; font-weight: 700; color: var(--check-blue); }
    .msg-status.read { color: var(--check-blue); }

    .cl-body { flex: 1; min-width: 0; }
    .cl-row1 { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
    .cl-name { font-size: 14px; font-weight: 600; color: var(--paper); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cl-time { font-size: 11.5px; color: var(--muted-on-dark); flex-shrink: 0; display: inline-flex; align-items: center; gap: 3px; }
    .cl-row2 { display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-top: 2px; }
    .cl-msg { font-size: 12.5px; color: var(--muted-on-dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
           .cl-msg .entity-kind-icon { width: 15px; height: 15px; vertical-align: -3px; margin-right: 4px; stroke: currentColor; }
    .cl-msg .cl-forward-arrow { width: 18px; height: 18px; stroke: #2077bf; stroke-width: 2.5; vertical-align: -4px; }
    .cl-msg .cl-thumb {
        width: 20px;
        height: 20px;
        vertical-align: -5px;
        object-fit: cover;
        border-radius: 4px;
        background: rgba(255,255,255,0.08);
    }

        .cl-msg .cl-thumb-wrap {
        position: relative;
        display: inline-block;
        width: 20px;
        height: 20px;
        vertical-align: -5px;
        margin-right: 4px;
        border-radius: 4px;
        overflow: hidden;
        background: rgba(255,255,255,0.08);
    }
    .cl-msg .cl-thumb-wrap .cl-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        margin: 0;
    }
    .cl-msg .cl-thumb-play {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 10px;
        height: 10px;
        transform: translate(-50%, -50%);
        filter: drop-shadow(0 0 2px rgba(0,0,0,0.7));
    }

    .cl-name .entity-name-icon { width: 16px; height: 16px; margin-right: 6px; vertical-align: -3px; stroke: #1687ff; color: #1687ff; }
    .cl-item.active .cl-name .entity-name-icon { stroke: var(--accent-ink); color: var(--accent-ink); }
    .cl-msg b { color: var(--paper); font-weight: 600; }
            .cl-status { margin-right: 2px; color: var(--check-blue); font-weight: 700; font-size: 13px; }
    .cl-status.read { color: var(--check-blue); }
    .cl-unread {
        background: var(--accent);
        color: var(--accent-ink);
        font-size: 11px;
        font-weight: 700;
        min-width: 19px;
        height: 19px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 5px;
        flex-shrink: 0;
    }
       .cl-item.active .cl-unread { background: #ffffff; color: var(--check-blue); }


       .cl-unread.cl-unread-dot {
    min-width: 12px;
    width: 12px;
    height: 12px;
    padding: 0;
    font-size: 0;
}

    /* ---- empty chat list state ---- */
    .cl-empty {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: var(--muted-on-dark);
        gap: 10px;
        padding: 40px 30px;
    }
       .cl-empty svg { width: 40px; height: 40px; stroke: var(--muted-on-dark); opacity: 0.6; fill: none; }
    body.day-mode .cl-empty svg { stroke: var(--muted-on-light); opacity: 0.7; }
    .cl-empty b { color: var(--paper); font-family: 'Sora', sans-serif; font-size: 14.5px; font-weight: 700; }
    .cl-empty span { font-size: 12.5px; line-height: 1.5; }

    /* ================= CHAT MAIN ================= */
    .chat-main {
        flex: 1;
        min-width: 0;
        background: var(--paper);
        display: flex;
        flex-direction: column;
    }

    .cm-header {
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 0 22px;
        border-bottom: 1px solid var(--line-soft);
        background: #fff;
    }

    .cm-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--ink);
        color: var(--paper);
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cm-title { flex: 1; min-width: 0; }
.cm-title h3 { margin: 0; font-family: 'Sora', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--ink); }
    .cm-title span { font-size: 12.5px; color: var(--muted-on-light); }

    .cm-actions { display: flex; align-items: center; gap: 6px; position: relative; }

    .icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--muted-on-light);
        transition: background 0.15s ease, color 0.15s ease;
    }
    .icon-btn:hover { background: var(--line-soft); color: var(--ink); }
    .icon-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; }
    .icon-btn.active-toggle { background: var(--ink); color: var(--paper); }

     .cm-messages {
        flex: 1;
        overflow-y: auto;
        padding: 22px 20px 18px;
        display: flex;
        flex-direction: column;
        gap: 3px;
        background:
            radial-gradient(circle at 20% 10%, rgba(224,168,62,0.06), transparent 40%),
            radial-gradient(circle at 80% 80%, rgba(10,10,10,0.03), transparent 40%);
    }
    .cm-messages.saved-view {
        background-color: #d9d1bf;
        background-image:
            linear-gradient(rgba(246,241,229,0.76), rgba(246,241,229,0.76)),
            radial-gradient(circle at 15% 20%, rgba(48,104,78,0.16), transparent 28%),
            radial-gradient(circle at 82% 75%, rgba(137,91,55,0.14), transparent 32%);
    }
    .cm-messages::-webkit-scrollbar { width: 6px; }
    .cm-messages::-webkit-scrollbar-thumb { background: var(--line-soft); border-radius: 4px; }

    .cm-empty {
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        color: var(--muted-on-light);
        gap: 10px;
    }
   .cm-empty svg { width: 46px; height: 46px; stroke: var(--line-soft); fill: none; }
    .cm-empty b { color: var(--ink); font-family: 'Sora', sans-serif; font-size: 15px; }
    .cm-empty span { font-size: 13px; max-width: 260px; line-height: 1.5; }

    .internal-list {
        width: min(760px, 96%);
        margin: auto;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .internal-list__empty { padding: 30px; text-align: center; color: var(--muted-on-light); }
    .entity-detail { display: flex; flex-direction: column; align-items: center; gap: 8px; }
    .entity-detail > svg { width: 44px; height: 44px; color: var(--accent); margin-bottom: 8px; }
    .entity-detail h3 { margin: 0; color: var(--ink); font-size: 20px; }
    .entity-detail p { margin: 0; color: var(--muted-on-light); font-size: 13px; }
    .entity-detail strong { display: inline-block; margin-top: 8px; padding: 7px 12px; border-radius: 999px; background: var(--ink-softer); color: var(--ink); font-size: 13px; }
    .entity-detail span { color: var(--muted-on-light); font-size: 13px; }
    body.night-mode .entity-detail h3,
    body.night-mode .entity-detail strong { color: var(--paper); }
    .internal-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border: 1px solid var(--line-soft);
        border-radius: 12px;
        background: rgba(255,255,255,0.58);
    }
    .internal-row__avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        background: var(--accent);
        color: var(--accent-ink);
        font-weight: 700;
    }
    .internal-row__text { min-width: 0; }
    .internal-row__text b, .internal-row__text span { display: block; }
    .internal-row__text span { margin-top: 3px; color: var(--muted-on-light); font-size: 12px; }
    .saved-message-list { width: 100%; margin-top: auto; }
    .saved-message-row { display: flex; justify-content: flex-end; margin: 6px 0; }
.saved-message-row.from-other { justify-content: flex-start; }

.saved-msg-in {
    animation: savedMsgIn 0.28s cubic-bezier(0.22, 1, 0.36, 1) backwards;
}
@keyframes savedMsgIn {
    from { opacity: 0; transform: translateY(14px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
    .saved-message-row.from-other { justify-content: flex-start; }
    .saved-message-bubble {
        max-width: min(720px, 78%);
        padding: 9px 13px 7px;
        border-radius: 16px 16px 4px 16px;
        background: var(--out-bg, #d4f5d0);
        color: var(--out-fg, #18251b);
        box-shadow: 0 1px 1px rgba(0,0,0,0.12);
        font-size: 14px;
        line-height: 1.45;
    }
    .saved-message-row.from-other .saved-message-bubble {
        border-radius: 16px 16px 16px 4px;
        background: #ffffff;
        color: #18251b;
        border: 1px solid var(--line-soft);
    }
    .saved-message-sender {
        display: block;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 12.5px;
        color: var(--accent);
        margin-bottom: 2px;
    }
    .saved-message-time { display: block; margin-top: 3px; text-align: right; color: #66816b; font-size: 10.5px; }
    .saved-message-row.from-other .saved-message-time { color: var(--muted-on-light); }

    .day-divider {
        align-self: center;
        background: rgba(10,10,10,0.06);
        color: var(--muted-on-light);
        font-size: 11.5px;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 999px;
        margin: 10px 0 16px;
    }

    .date-divider {
    width: fit-content;
    margin: 10px auto 12px;
    padding: 4px 12px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.35);
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    position: sticky;
    top: 6px;
    z-index: 3;
}

    .msg-row {
        display: flex;
        gap: 9px;
        max-width: 78%;
        margin-bottom: 10px;
        position: relative;
    }
        .msg-row.in { align-self: flex-start; margin-right: auto; }
    .msg-row.out { align-self: flex-end; flex-direction: row-reverse; margin-left: auto; }
    .msg-row.selectable { cursor: pointer; }
    .msg-row.is-pending { opacity: .65; }

    .msg-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 11px;
        color: var(--paper);
        align-self: flex-end;
    }

    .msg-bubble {
        border-radius: 16px;
        padding: 9px 13px 8px;
        font-size: 14px;
        line-height: 1.45;
        position: relative;
    }
    .msg-bubble:has(.file-msg.file-doc),
    .saved-message-bubble:has(.file-msg.file-doc) {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        width: fit-content;
        max-width: 100%;
    }
    .msg-bubble:has(.file-msg.file-doc) .msg-time,
    .saved-message-bubble:has(.file-msg.file-doc) .saved-message-time {
        float: none;
        align-self: flex-end;
        margin-top: 4px;
    }
    .msg-row.in .msg-bubble {
        background: #fff;
        border: 1px solid var(--line-soft);
        color: var(--ink);
        border-bottom-left-radius: 4px;
    }

    .msg-row.out .msg-bubble {
        background: var(--out-bg, var(--ink));
        color: var(--out-fg, var(--paper));
        border-bottom-right-radius: 4px;
    }

    .msg-sender {
        display: block;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 12.5px;
        color: var(--accent);
        margin-bottom: 2px;
    }
    .msg-row.out .msg-sender { display: none; }

    .msg-time {
        display: inline-block;
        font-size: 10.5px;
        margin-top: 3px;
        opacity: 0.6;
        float: right;
        margin-left: 10px;
    }

          .file-msg,
    .file-msg:hover,
    .file-msg:visited,
    .file-msg:active {
        display: inline-flex; align-items: center; gap: 10px; color: inherit; text-decoration: none;
    }
    .file-msg .file-msg__name { text-decoration: none; }

            .file-msg.file-doc { min-width: 320px; max-width: 420px; width: fit-content; }
        .file-msg.file-media { max-width: 520px; }




    .file-msg__icon { width: 34px; height: 34px; flex: 0 0 34px; display: grid; place-items: center; border-radius: 10px; background: rgba(45,212,191,.18); color: var(--accent); font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .file-msg__info { min-width: 0; }
    .file-msg__name { display: block; overflow: hidden; font-size: 13px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; }
    .file-msg__meta { display: block; margin-top: 2px; font-size: 11px; opacity: .68; }
    .file-msg img { display: block; max-width: 420px; max-height: 440px; min-width: 300px; border-radius: 10px; object-fit: cover; }
/* GIF uchun — Telegramdagidek kichikroq o'lcham */
.file-msg.file-gif { max-width: 420px; }
.file-msg.file-gif img.gif-img {
    max-width: 360px;
    max-height: 360px;
    min-width: unset;
    width: auto;
    height: auto;
}

       .file-msg video { display: block; max-width: 320px; max-height: 450px; width: auto; border-radius: 10px; object-fit: cover; background: #000; }
        .file-msg audio { display: none; }
    .music-msg {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 230px;
        max-width: 320px;
    }
.music-msg-play {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: none;
    background: #4b9bea;
    cursor: pointer;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 0 0 6px rgba(75, 155, 234, 0.22);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.music-msg-play:hover {
    transform: scale(1.05);
    box-shadow: 0 0 0 8px rgba(75, 155, 234, 0.24);
}
.music-msg-play svg { width: 25px; height: 25px; margin-left: 2px; }
    .music-msg-info { flex: 1; min-width: 0; }
    .music-msg-name {
        display: block;
        font-size: 13px;
        font-weight: 700;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .music-msg-progress {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }
    .music-msg-bar {
        flex: 1;
        height: 3px;
        border-radius: 3px;
        background: rgba(128,128,128,0.35);
        position: relative;
        cursor: pointer;
    }
    .music-msg-bar-fill {
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 0%;
        border-radius: 3px;
        background: var(--accent);
    }
  



          .msg-bubble.media-bubble,
    .saved-message-bubble.media-bubble {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        box-shadow: none !important;
        position: relative;
        width: fit-content;
        max-width: 100%;
    }
    .msg-bubble.media-bubble .file-msg img,
    .saved-message-bubble.media-bubble .file-msg img { display: block; }
     .msg-bubble.media-bubble .msg-time,
    .saved-message-bubble.media-bubble .saved-message-time {
        position: absolute;
        right: 8px;
        bottom: 8px;
        background: rgba(0,0,0,0.45);
        color: #fff;
        padding: 2px 7px;
        border-radius: 10px;
        float: none;
        margin: 0;
        opacity: 1;
        z-index: 2;
    }
    .msg-bubble.media-bubble .file-msg video ~ .msg-time,
    .saved-message-bubble.media-bubble .file-msg video ~ .saved-message-time {
        bottom: 44px;
    }


        .msg-bubble.media-bubble .file-msg video ~ .msg-time,
    .saved-message-bubble.media-bubble .file-msg video ~ .saved-message-time {
        bottom: 44px;
    }

    .msg-bubble.media-bubble .msg-time .msg-status,
    .saved-message-bubble.media-bubble .saved-message-time .msg-status {
        color: var(--check-blue) !important;
        text-shadow: 0 0 3px rgba(0,0,0,0.6);
    }

    .msg-edited {
        font-size: 10px;
        opacity: 0.6;
        margin-left: 4px;
    }

    /* ---- channel post header (avatar + channel name) / footer (Leave a comment) ---- */
          .msg-row.channel-post {
        max-width: min(480px, 90%);
        align-items: flex-end;
        gap: 8px;
    }
     .channel-post-col {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
        overflow: hidden;
        
    }

.msg-row.channel-post .msg-bubble {
    border-radius: 16px 16px 0px 0px !important;
}
.channel-post-col:not(:has(.channel-post-footer)) .msg-bubble {
    border-radius: 16px 16px 16px 0px !important;
}
.msg-row.channel-post .msg-bubble.media-bubble .file-msg img,
.msg-row.channel-post .msg-bubble.media-bubble .file-msg video {
    border-radius: 0 !important;
}
     .channel-post-header {
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: space-between;
        margin: -9px -13px 8px;
        padding: 8px 13px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    /* Rasm/video (media-bubble) postlarida — header alohida panel, rasm ustiga chiqmaydi */
    .msg-bubble.media-bubble .channel-post-header,
    .saved-message-bubble.media-bubble .channel-post-header {
        position: static;
        margin: 0;
        padding: 9px 13px;
        background: #1f1f1d;
        border-bottom: none;
        border-radius: 16px 16px 0 0;
    }
    .msg-bubble.media-bubble .channel-post-header .channel-post-name,
    .saved-message-bubble.media-bubble .channel-post-header .channel-post-name {
        color: #5eb5f7;
    }
    .msg-bubble.media-bubble .channel-post-header .channel-post-badge,
    .saved-message-bubble.media-bubble .channel-post-header .channel-post-badge {
        background: rgba(255,255,255,0.18);
        color: #fff;
    }
    .msg-row.channel-post .msg-bubble.media-bubble {
        overflow: hidden;
    }

        .channel-post-header { justify-content: space-between; }
    .channel-post-header-left { display: flex; align-items: center; gap: 8px; min-width: 0; }
    .channel-post-badge {
        flex-shrink: 0;
        background: rgba(0,0,0,0.06);
        color: var(--muted-on-light);
        font-size: 10.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 3px 8px;
        border-radius: 999px;
    }
    body.night-mode .channel-post-badge { background: rgba(255,255,255,0.08); color: var(--muted-on-dark); }



    .channel-post-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 11px;
        color: #fff;
        overflow: hidden;
    }
    .channel-post-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .channel-post-name {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: #5eb5f7;
    }

    
.channel-post-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin: 0 !important;
    padding: 10px 13px;
     border-radius: 0 0 16px 4px;
    border-top: 1px solid rgba(0,0,0,0.07);
    background: rgba(10,10,10,0.035);
    cursor: pointer;
    color: var(--teal);
    font-size: 12.5px;
    font-weight: 600;
    width: 100%;
    box-sizing: border-box;
    transition: background 0.15s ease, color 0.15s ease;
}
.channel-post-footer:hover { color: var(--teal); background: rgba(9, 55, 124, 0.69); }
.channel-post-footer .cpf-left { display: flex; align-items: center; gap: 7px; }
.channel-post-footer svg { width: 15px; height: 15px; stroke: currentColor; flex-shrink: 0; }
body.night-mode .channel-post-footer { border-top-color: rgba(255,255,255,0.08); background: rgba(255,255,255,0.04); }
    body.night-mode .channel-post-name { color: #5eb5f7; }

    .msg-reply-quote {
        display: block;
        border-left: 2.5px solid var(--accent);
        padding: 3px 0 3px 8px;
        margin-bottom: 5px;
        font-size: 12px;
        opacity: 0.85;
        line-height: 1.3;
    }


    .msg-link {
    color: #3390ec;
    text-decoration: none;
    word-break: break-all;
}
.msg-link:hover { text-decoration: underline; }
.msg-row.out .msg-link,
.saved-message-row:not(.from-other) .msg-link {
    color: #168ce0;
}
body.night-mode .msg-link { color: #5eb5f7; }

    .msg-check {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--line-soft);
        flex-shrink: 0;
        align-self: center;
        display: none;
        align-items: center;
        justify-content: center;
        background: #fff;
    }
    body.selecting-mode .msg-check { display: flex; }
    body.selecting-mode .msg-row.out { flex-direction: row; }
       .msg-row.msg-selected .msg-check { background: var(--check-blue); border-color: var(--check-blue); }
    .msg-row.msg-selected .msg-check svg { width: 12px; height: 12px; stroke: #fff; }
    .msg-check svg { display: none; }
    .msg-row.msg-selected .msg-check svg { display: block; }

   .cm-composer {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 1.5px 13px;
    border-top: 1px solid var(--line-soft);
    background: #fff;
}

    .composer-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; }

    .reply-preview {
        display: none;
        align-items: center;
        gap: 10px;
        background: var(--paper);
        border: 1px solid var(--line-soft);
        border-radius: 12px;
        padding: 7px 10px;
        margin-bottom: 6px;
        position: relative;
    }
    .reply-preview.show { display: flex; }
    .reply-preview-bar { width: 3px; align-self: stretch; background: var(--accent); border-radius: 3px; flex-shrink: 0; }
    .reply-preview-text { min-width: 0; flex: 1; }
    .reply-preview-text b { display: block; font-size: 12.5px; color: var(--accent); font-family: 'Sora', sans-serif; }
    .reply-preview-text span { display: block; font-size: 12.5px; color: var(--muted-on-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .reply-preview-close { background: none; border: none; cursor: pointer; color: var(--muted-on-light); flex-shrink: 0; display: flex; padding: 4px; }
    .reply-preview-close svg { width: 15px; height: 15px; stroke: currentColor; }

   .composer-box {
    flex: 1;
    display: flex;
    align-items: center;
    background: transparent;
    border: none;
    border-radius: 0;
    padding: 0;
}
.composer-box:focus-within { border: none; }

.composer-box input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    color: var(--ink);
    padding: 10px 0;
}
    .composer-box input::placeholder { color: #b3b0a6; }

   .send-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: transparent;
    color: var(--muted-on-light);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background 0.15s ease, color 0.15s ease, transform 0.15s ease;
}



#composerEmojiBtn {
    color: var(--teal);
}
#composerEmojiBtn svg { width: 22px; height: 22px; }
#composerEmojiBtn:hover { background: rgba(45,212,191,0.14); color: var(--teal); }
#composerEmojiBtn.active-toggle { background: rgba(45,212,191,0.18); color: var(--teal); }


.send-btn:hover { background: var(--line-soft); color: var(--ink); transform: none; }
.send-btn svg { width: 20px; height: 20px; }
   .send-btn.recording { background: var(--teal); color: var(--teal-ink); animation: pulseRecTeal 1.1s infinite; }
.send-btn.recording.cancel-zone { background: var(--danger); color: #fff; animation: pulseRec 1.1s infinite; }

@keyframes pulseRecTeal {
    0% { box-shadow: 0 0 0 0 rgba(12, 59, 188, 0.76); }
    70% { box-shadow: 0 0 0 10px rgba(45,212,191,0); }
    100% { box-shadow: 0 0 0 0 rgba(45,212,191,0); }
}
@keyframes pulseRec {
    0% { box-shadow: 0 0 0 0 rgba(192, 6, 6, 0.82); }
    70% { box-shadow: 0 0 0 10px rgba(241,101,101,0); }
    100% { box-shadow: 0 0 0 0 rgba(241,101,101,0); }
}
.voice-msg {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 250px;
    max-width: 300px;
    
}



      .voice-msg-play {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        background: #4b9bea;
        cursor: pointer;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
             box-shadow: 0 0 0 6px rgba(75, 155, 234, 0.22);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .voice-msg-play:hover {
        transform: scale(1.05);
        box-shadow: 0 0 0 8px rgba(75, 155, 234, 0.24);
    }
    .voice-msg-play:active {
        transform: scale(0.96);
    }
    .voice-msg-play svg { width: 27px; height: 27px; margin-left: 2px; }
.voice-msg-wave {
    flex: 1;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.voice-msg-track {
    flex: 1;
    min-width: 0;
}


.voice-msg-wave span {
        width: 2px;
        background: currentColor;
        opacity: 0.45;
        border-radius: 2px;
        transition: opacity 0.12s ease;
    }
    .voice-msg-wave span.played { opacity: 1; color: var(--accent); }
    .voice-msg-duration { font-size: 11px; opacity: 0.75; flex-shrink: 0; }
    .voice-msg audio { display: none; }

   .rec-indicator {
    display: none;
    align-items: center;
    gap: 8px;
    padding: 8px 4px;
    color: var(--teal);
    font-size: 13px;
    font-weight: 600;
    transition: color 0.15s ease;
}
.rec-indicator.show { display: flex; }
.rec-indicator-dot { width: 9px; height: 9px; border-radius: 50%; background: var(--teal); animation: pulseRecTeal 1.1s infinite; transition: background 0.15s ease; }
.rec-indicator.cancel-zone { color: var(--danger); }
.rec-indicator.cancel-zone .rec-indicator-dot { background: var(--danger); animation: pulseRec 1.1s infinite; }
    .rec-indicator-cancel { margin-left: auto; background: none; border: none; color: var(--muted-on-light); font-size: 12.5px; cursor: pointer; font-family: 'Inter', sans-serif; }

    /* ---- pinned message banner ---- */
    .pinned-banner {
        display: none;
        align-items: center;
        gap: 10px;
        padding: 8px 22px;
        background: #fbf3e0;
        border-bottom: 1px solid var(--line-soft);
        font-size: 12.5px;
    }
    .pinned-banner.show { display: flex; }
    .pinned-banner svg { width: 15px; height: 15px; stroke: var(--accent); flex-shrink: 0; }
    .pinned-banner b { font-weight: 700; color: var(--ink); margin-right: 4px; }
    .pinned-banner span { color: var(--muted-on-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex: 1; }
    .pinned-banner button { background: none; border: none; cursor: pointer; color: var(--muted-on-light); display: flex; }
    .pinned-banner button svg { width: 14px; height: 14px; stroke: currentColor; }

    /* ---- selection mode toolbar ---- */
    .selection-toolbar {
        display: none;
        align-items: center;
        gap: 14px;
        padding: 0 22px;
        height: 58px;
        border-bottom: 1px solid var(--line-soft);
        background: #fff;
    }
    .selection-toolbar.show { display: flex; }
    .selection-toolbar button.sel-close { background: none; border: none; cursor: pointer; color: var(--ink); display: flex; }
    .selection-toolbar button.sel-close svg { width: 19px; height: 19px; stroke: currentColor; }
    .selection-toolbar .sel-count { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 14.5px; color: var(--ink); flex: 1; }
    .selection-toolbar .sel-action { background: none; border: none; cursor: pointer; color: var(--muted-on-light); display: flex; align-items: center; gap: 6px; font-size: 13px; font-family: 'Inter', sans-serif; }
    .selection-toolbar .sel-action:hover { color: var(--ink); }
    .selection-toolbar .sel-action svg { width: 18px; height: 18px; stroke: currentColor; }
    .selection-toolbar .sel-action.danger { color: var(--danger); }

    /* ================= DROPDOWN MENUS (chat options / message context) ================= */
    .dropdown-menu {
        position: fixed;
        min-width: 210px;
        background: var(--ink-soft);
        border: 1px solid var(--line);
        border-radius: 12px;
        box-shadow: 0 14px 34px rgba(0,0,0,0.35);
        padding: 6px;
        z-index: 120;
        display: none;
        flex-direction: column;
        gap: 1px;
    }
    .dropdown-menu.show { display: flex; }
    .dropdown-menu button {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 9px 11px;
        border-radius: 8px;
        border: none;
        background: transparent;
        cursor: pointer;
        color: var(--paper);
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        text-align: left;
        width: 100%;
    }
    .dropdown-menu button:hover { background: var(--ink-softer); }
    .dropdown-menu button svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    fill: none;              /* ⬅ SHU QATOR YETISHMAYAPTI */
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
}
    .dropdown-menu button.danger { color: var(--danger); }
   .dropdown-menu .dropdown-sep { height: 1px; background: var(--line); margin: 2px -6px; }

    .dropdown-submenu-wrap { position: relative; }
.dropdown-submenu-wrap > button { justify-content: space-between; }
.dropdown-chevron {
    margin-left: auto;
    width: 15px !important;
    height: 15px !important;
    opacity: 0.6;
    flex-shrink: 0;
}

.no-chevron { justify-content: flex-start !important; }
.dropdown-submenu { min-width: 200px; }

    #chatItems .cl-item.is-archived,
#archivedChatItems .cl-item.is-archived { display: none; }
#archivedChatItems .cl-item.is-archived { display: flex; }

    body.day-mode .dropdown-menu,
    body.night-mode .dropdown-menu { }
    body.day-mode .dropdown-menu { background: #ffffff; border-color: var(--line-soft); box-shadow: 0 14px 34px rgba(0,0,0,0.16); }
    body.day-mode .dropdown-menu button { color: #171817; }
    body.day-mode .dropdown-menu button:hover { background: #f1f1ec; }

    /* ================= SIDE PANEL (emoji/stickers/gifs) ================= */
    .side-panel {
        width: 320px;
        flex-shrink: 0;
        background: #fff;
        border-left: 1px solid var(--line-soft);
        display: flex;
        flex-direction: column;
        transition: margin-right 0.25s ease;
    }
        .side-panel.hidden { margin-right: -320px; visibility: hidden; }

  .sp-tabs {
    display: flex;
    border-bottom: 1px solid var(--line-soft);
    padding: 14px 18px 0;
    gap: 53px;
}
    .sp-tab {
        background: none;
        border: none;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: var(--muted-on-light);
        padding-bottom: 12px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: color 0.2s ease, border-color 0.2s ease;
    }
    .sp-tab.active { color: #2fdfdf; border-color: #2DD4A4; }

  .sp-search {
    margin: 10px 8px 6px;
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--paper);
    border: 1px solid var(--line-soft);
    border-radius: 999px;
    padding: 5px 13px;
}
@keyframes sp-search-pulse {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.85; }
    25% { transform: scale(1.1) rotate(-15deg); opacity: 1; }
    50% { transform: scale(1.15) rotate(0deg); opacity: 1; }
    75% { transform: scale(1.1) rotate(15deg); opacity: 1; }
}

.sp-search svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    transform-origin: 70% 70%;
    animation: sp-search-pulse 1.8s ease-in-out infinite;
}
    .sp-search input { border: none; background: transparent; outline: none; font-size: 13px; color: var(--ink); width: 100%; font-family: 'Inter', sans-serif; }

    .sp-content { flex: 1; overflow-y: auto; padding: 6px 14px 16px; }
    .sp-content::-webkit-scrollbar { width: 5px; }
    .sp-content::-webkit-scrollbar-thumb { background: var(--line-soft); border-radius: 4px; }

  .sp-section-title {
    font-size: 12px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: var(--muted-on-light);
    margin: 12px 4px 8px;
}

      .emoji-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0px;
    }
   .emoji-grid button {
    background: none;
    border: none;
    font-size: 21.5px;
    padding: 2px 2px;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.12s ease, transform 0.12s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}
    .emoji-grid button:hover { background: var(--line-soft); transform: scale(1.1); }


    .sp-placeholder {
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        color: var(--muted-on-light);
        font-size: 13px;
        gap: 8px;
        padding: 40px 20px;
    }
    .sp-placeholder svg { width: 38px; height: 38px; stroke: var(--line-soft); }

    /* ================= RESPONSIVE ================= */
  @media (max-width: 1200px) {
    .side-panel { position: fixed; right: 0; top: 0; bottom: 0; z-index: 40; box-shadow: -20px 0 40px rgba(0,0,0,0.15); }
    .side-panel.hidden { margin-right: -320px; visibility: hidden; }
} 

    @media (max-width: 860px) {
        .chat-list-panel { position: fixed; left: 84px; top: 0; bottom: 0; z-index: 30; box-shadow: 20px 0 40px rgba(0,0,0,0.25); transition: transform 0.25s ease; }
        .chat-list-panel.hidden { transform: translateX(-110%); }
    }

    @media (max-width: 560px) {
        .rail { width: 64px; }
        .rail-item { width: 48px; }
        .rail-item span { display: none; }
        .msg-row { max-width: 82%; }
    }





    /* Hech narsa tanlanmaganda header matni va composer yashirin bo'ladi */
.cm-header .cm-title,
.cm-header .cm-actions,
.cm-composer,
.pinned-banner,
.selection-toolbar {
    visibility: hidden;
    pointer-events: none;
}
body.chat-open .cm-header .cm-title,
body.chat-open .cm-header .cm-actions,
body.chat-open .cm-composer {
    visibility: visible;
    pointer-events: auto;
}
body.chat-open .pinned-banner.show,
body.chat-open .selection-toolbar.show {
    visibility: visible;
    pointer-events: auto;
}














/* ============= QIDIRUV PANELI ============= */
.cl-search { position: relative; }

.cl-search-box input { padding-right: 4px; }

.cl-search-clear {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: none;
    background: transparent;
    color: var(--muted-on-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    opacity: 0;
    transform: scale(0.5);
    pointer-events: none;
    transition: opacity 0.15s ease, transform 0.15s ease, background 0.15s ease, color 0.15s ease;
}
.cl-search-clear svg { width: 15px; height: 15px; stroke: currentColor; stroke-width: 2.4; }
.cl-search-clear:hover { background: var(--ink-softer); color: var(--paper); }
.cl-search-box.has-text .cl-search-clear,
.cl-search-box.search-focused .cl-search-clear {
    opacity: 1;
    transform: scale(1);
    pointer-events: auto;
}
body.day-mode .cl-search-clear { color: #777a73; }
body.day-mode .cl-search-clear:hover { background: #e9e9e4; color: #171817; }

.cl-search-panel {
    display: none;
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    background: var(--ink-soft);
    padding: 0px 8px 12px;
}
.cl-search-panel.open { display: flex; flex-direction: column; }
.cl-search-panel::-webkit-scrollbar { width: 5px; }
.cl-search-panel::-webkit-scrollbar-thumb { background: var(--line); border-radius: 4px; }

body.day-mode .cl-search-panel { background: #ffffff; }

#mainChatListView.searching .cl-archived,
#mainChatListView.searching .cl-items { display: none; }

.csp-hint, .csp-empty {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 34px 20px;
    text-align: center;
    color: var(--muted-on-dark);
    font-size: 12.5px;
}
.csp-hint.show, .csp-empty.show { display: flex; }
.csp-hint svg, .csp-empty svg { width: 30px; height: 30px; stroke: var(--line); fill: none; }

.csp-results { display: flex; flex-direction: column; gap: 1px; }

.csp-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 10px;
    border-radius: var(--radius-md);
    cursor: pointer;
    animation: cspRowIn 0.22s cubic-bezier(0.34,1.56,0.64,1) backwards;
}
.csp-row:hover { background: var(--ink-softer); }

@keyframes cspRowIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}

.csp-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Sora', sans-serif;
    font-weight: 700;
    font-size: 14px;
    color: var(--paper);
    overflow: hidden;
}
.csp-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }

.csp-body { flex: 1; min-width: 0; }
.csp-name { font-size: 13.5px; font-weight: 600; color: var(--paper); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.csp-name mark { background: transparent; color: var(--check-blue); font-weight: 700; }
.csp-sub { font-size: 12px; color: var(--muted-on-dark); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.csp-username { color: var(--muted-on-dark); }

/* ---- global qidiruv bo'limi (backend natijalari) ---- */
.csp-section-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted-on-dark);
    padding: 12px 10px 6px;
}


.csp-frequent-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: #f3f3f0;
    border-radius: 0;              /* burchaklar endi to'g'ri */
    margin: -8px -8px 8px;   /* top endi -4px */        
}
body.night-mode .csp-frequent-header { background: #20231f; }

.csp-frequent-title {
    font-size: 12px;   /* eski: 13px */
    font-weight: 600;
    color: var(--muted-on-dark);
}
.csp-frequent-toggle {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 12px;   /* eski: 13px */
    font-weight: 600;
    color: var(--muted-on-dark);
    padding: 0;
    font-family: 'Inter', sans-serif;
    text-decoration: underline;
    text-underline-offset: 3px;
}




.csp-frequent {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    row-gap: 14px;
    padding: 0 6px 14px;
    overflow: hidden;
    transition: max-height 0.25s ease;
}
.csp-frequent-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    width: 100%;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}
.csp-frequent-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Sora', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: var(--paper);
    overflow: visible;
    position: relative;
}
.csp-frequent-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    z-index: 5;
    background: #1f75df;
    color: #ffffff;
    font-size: 10px;
    font-weight: 700;
    width: 18px;
    height: 18px;
    min-width: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: 2px solid var(--ink-soft, #171916);
    box-sizing: content-box;
    line-height: 1;
}
.csp-frequent-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.csp-frequent-name {
    font-size: 11px;
    color: var(--paper);
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 52px;
}
body.day-mode .csp-frequent-name { color: #171817; }


.csp-history-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    background: #f3f3f0;
    border-radius: 0;
    margin: 10px -8px 8px;
}
body.night-mode .csp-history-header { background: #20231f; }

.csp-history-title {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted-on-dark);
}
.csp-history-clear {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 11.5px;
    font-weight: 600;
    color: var(--muted-on-dark);
    padding: 0;
    font-family: 'Inter', sans-serif;
    text-decoration: underline;
    text-underline-offset: 3px;
}
.csp-history-row {
    display: flex;
    gap: 14px;
    overflow-x: auto;
    padding: 0 4px 14px;
    scrollbar-width: none;
}
.csp-history-row::-webkit-scrollbar { display: none; }
.csp-history-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    width: 56px;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
}
.csp-history-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Sora', sans-serif;
    font-weight: 700;
    font-size: 15px;
    color: var(--paper);
    overflow: hidden;
}
.csp-history-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
.csp-history-name {
    font-size: 11px;
    color: var(--paper);
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 56px;
}
body.day-mode .csp-history-name { color: #171817; }

.csp-loading {
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    color: var(--muted-on-dark);
    font-size: 12.5px;
    gap: 8px;
}
.csp-loading.show { display: flex; }
.csp-spinner {
    width: 14px; height: 14px;
    border: 2px solid var(--line);
    border-top-color: var(--accent);
    border-radius: 50%;
    animation: cspSpin 0.7s linear infinite;
    flex-shrink: 0;
}
@keyframes cspSpin { to { transform: rotate(360deg); } }
body.day-mode .csp-spinner { border-color: var(--line-soft); border-top-color: var(--accent); }



.csp-tabs {
    display: flex;
    align-items: center;
    gap: 0;
    padding: 2px 2px 10px;
    overflow-x: auto;
    scrollbar-width: none;
    flex-shrink: 0;
}
.csp-tabs::-webkit-scrollbar { display: none; }
.csp-tab-btn {
    flex-shrink: 0;
    background: none;
    border: none;
    cursor: pointer;
    padding: 7px 4px;
    margin-right: 14px;
    font-family: 'Inter', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    font-style: italic;
    color: var(--muted-on-dark);
    border-bottom: 2px solid transparent;
    white-space: nowrap;
    transition: color 0.15s ease, border-color 0.15s ease;
}
.csp-tab-btn:hover { transform: translateY(-1px); }
.csp-tab-btn:hover { color: var(--paper); }
.csp-tab-btn.active { color: #5ab0f2; border-color: #5eb5f7; }
body.day-mode .csp-tab-btn { color: #666a63; }
body.day-mode .csp-tab-btn:hover { color: #171817; }
body.day-mode .csp-tab-btn.active { color: #3390ec; border-color: #3390ec; }

.csp-tab-empty {
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 40px 20px;
    text-align: center;
    color: var(--muted-on-dark);
    font-size: 12.5px;
}
.csp-tab-empty.show { display: flex; }
.csp-tab-empty svg { width: 30px; height: 30px; stroke: var(--line); }





.delete-confirm-overlay {
    position: fixed; inset: 0; z-index: 200;
    background: rgba(0,0,0,0.45);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.15s ease;
}
.delete-confirm-overlay.show { opacity: 1; pointer-events: auto; }
.delete-confirm-box {
    background: var(--ink-soft);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 18px 20px 14px;
    width: 300px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.45);
    transform: scale(0.96);
    transition: transform 0.15s ease;
}
.delete-confirm-overlay.show .delete-confirm-box { transform: scale(1); }
.delete-confirm-box p { margin: 0 0 14px; font-size: 14.5px; color: var(--paper); }
.delete-confirm-also {
    display: flex; align-items: center; gap: 10px;
    padding: 6px 0 14px; cursor: pointer; font-size: 13.5px; color: var(--paper);
    user-select: none;
}
/* ⬇⬇⬇ SHU YERGA YANGI .dc-check qo'yiladi ⬇⬇⬇ */
.dc-check {
    width: 18px; height: 18px; border-radius: 4px;
    background: transparent;
    border: 2px solid var(--muted-on-dark);
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.15s ease, border-color 0.15s ease;
}
.dc-check svg {
    width: 12px; height: 12px; color: #fff;
    opacity: 0;
    transform: scale(0.5);
    transition: opacity 0.12s ease, transform 0.12s ease;
}
.dc-check.checked {
    background: var(--check-blue);
    border-color: var(--check-blue);
}
.dc-check.checked svg {
    opacity: 1;
    transform: scale(1);
}
.delete-confirm-also:hover .dc-check {
    border-color: var(--check-blue);
}
/* ⬆⬆⬆ shu yergacha ⬆⬆⬆ */
.delete-confirm-actions { display: flex; justify-content: flex-end; gap: 8px; }
.delete-confirm-actions button {
    background: none; border: none; cursor: pointer;
    font-family: 'Inter', sans-serif; font-weight: 600; font-size: 13.5px;
    color: var(--teal); padding: 7px 12px;
    border-radius: 8px;
    transition: background 0.15s ease;
}
.delete-confirm-actions button:hover {
    background: rgba(45, 212, 191, 0.14);
}
body.day-mode .delete-confirm-actions button:hover {
    background: rgba(45, 212, 191, 0.12);
}
body.day-mode .delete-confirm-box { background: #ffffff; border-color: var(--line-soft); }
body.day-mode .delete-confirm-box p, body.day-mode .delete-confirm-also { color: #171817; }



.image-preview-overlay {
    position: fixed; inset: 0; z-index: 210;
    background: rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.15s ease;
}
.image-preview-overlay.show { opacity: 1; pointer-events: auto; }
.image-preview-box {
    background: var(--ink-soft); border: 1px solid var(--line);
    border-radius: 14px; padding: 16px; width: 360px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.45);
}
.image-preview-header { color: var(--paper); font-weight: 700; margin-bottom: 10px; }
.image-preview-img-wrap { max-height: 320px; overflow: hidden; border-radius: 10px; margin-bottom: 10px; }
.image-preview-img-wrap img { width: 100%; display: block; }
.image-preview-box input {
    width: 100%; background: var(--ink-softer); border: 1px solid var(--line);
    border-radius: 8px; padding: 8px 10px; color: var(--paper); outline: none;
    margin-bottom: 12px; font-family: 'Inter', sans-serif;
}
.image-preview-actions { display: flex; justify-content: flex-end; gap: 10px; }
.image-preview-actions button {
    background: none; border: none; color: var(--teal); font-weight: 600;
    cursor: pointer; padding: 6px 10px; border-radius: 6px;
}
.image-preview-actions button:hover { background: rgba(45,212,191,0.14); }
body.day-mode .image-preview-box { background: #ffffff; border-color: var(--line-soft); }
body.day-mode .image-preview-header { color: #171817; }
body.day-mode .image-preview-box input { background: #f3f3f0; border-color: #d8d8d1; color: #171817; }



.doc-open-overlay {
    position: fixed; inset: 0; z-index: 220;
    background: rgba(0,0,0,0.5);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.15s ease;
}
.doc-open-overlay.show { opacity: 1; pointer-events: auto; }
.doc-open-box {
    background: var(--ink-soft); border: 1px solid var(--line);
    border-radius: 16px; padding: 20px; width: 340px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.5);
    text-align: left;
}
.doc-open-header {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 14px;
}
.doc-open-icon {
    width: 46px; height: 46px; flex-shrink: 0;
    border-radius: 12px; background: rgba(45,212,191,.16);
    color: var(--accent); display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 11.5px; letter-spacing: 0.02em; text-transform: uppercase;
}
.doc-open-header-text { min-width: 0; }
.doc-open-name {
    color: var(--paper); font-weight: 700; font-size: 14px;
    line-height: 1.35; word-break: break-word;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.doc-open-meta { color: var(--muted-on-dark); font-size: 12px; margin-top: 3px; }
.doc-open-hint {
    color: var(--muted-on-dark); font-size: 12.5px; line-height: 1.55;
    margin-bottom: 18px; padding-bottom: 16px;
    border-bottom: 1px solid var(--line);
}
.doc-open-actions { display: flex; flex-direction: column; gap: 8px; }
.doc-open-actions button, .doc-open-actions a {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px; border-radius: 10px;
    border: none; cursor: pointer; font-family: 'Inter', sans-serif;
    font-size: 13.5px; font-weight: 600; text-decoration: none; box-sizing: border-box;
    transition: background 0.15s ease, transform 0.1s ease;
}
.doc-open-actions button:active, .doc-open-actions a:active { transform: scale(0.98); }
.doc-open-actions svg { width: 16px; height: 16px; stroke: currentColor; flex-shrink: 0; }
.doc-open-primary { background: var(--teal); color: var(--teal-ink); }
.doc-open-primary:hover { background: #26bfab; }
.doc-open-secondary { background: var(--ink-softer); color: var(--paper); }
.doc-open-secondary:hover { background: var(--line); }
body.day-mode .doc-open-box { background: #ffffff; border-color: var(--line-soft); }
body.day-mode .doc-open-name { color: #171817; }
body.day-mode .doc-open-hint { border-color: var(--line-soft); }
body.day-mode .doc-open-secondary { background: #f1f1ec; color: #171817; }
body.day-mode .doc-open-secondary:hover { background: #e6e6e0; }





.lightbox-img { cursor: pointer; }

.lightbox-overlay {
    position: fixed; inset: 0; z-index: 300;
    background: rgba(0,0,0,0.9);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.18s ease;
}
.lightbox-overlay.show { opacity: 1; pointer-events: auto; }
.lightbox-image {
    max-width: 90vw; max-height: 82vh;
    object-fit: contain;
    border-radius: 6px;
    user-select: none;
}
.lightbox-close, .lightbox-download {
    position: fixed; top: 18px;
    width: 42px; height: 42px; border-radius: 50%;
    border: none; background: rgba(255,255,255,0.1);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s ease;
}
.lightbox-close { right: 18px; }
.lightbox-download { right: 70px; }
.lightbox-close:hover, .lightbox-download:hover { background: rgba(255,255,255,0.22); }
.lightbox-close svg, .lightbox-download svg { width: 20px; height: 20px; stroke: currentColor; }
.lightbox-nav {
    position: fixed; top: 50%; transform: translateY(-50%);
    width: 48px; height: 48px; border-radius: 50%;
    border: none; background: rgba(255,255,255,0.1);
    color: #fff; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background 0.15s ease;
}
.lightbox-nav:hover { background: rgba(255,255,255,0.22); }
.lightbox-nav:disabled { opacity: 0.25; cursor: default; pointer-events: none; }
.lightbox-nav svg { width: 22px; height: 22px; stroke: currentColor; }
.lightbox-prev { left: 18px; }
.lightbox-next { right: 18px; }
.lightbox-footer {
    position: fixed; left: 0; right: 0; bottom: 18px;
    display: flex; align-items: center; justify-content: center; gap: 14px;
    color: #fff; font-size: 13px;
}
.lightbox-footer-info { display: flex; flex-direction: column; align-items: flex-end; line-height: 1.3; }
.lightbox-footer-info b { font-family: 'Sora', sans-serif; font-size: 13px; }
.lightbox-footer-info span { font-size: 11.5px; opacity: 0.7; }
.lightbox-counter {
    background: rgba(255,255,255,0.12);
    padding: 4px 10px; border-radius: 999px; font-size: 12px;
}








.msg-views {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    margin-right: 6px;
    opacity: 0.85;
    font-size: 10.5px;
    vertical-align: middle;
    position: relative;
    top: -1px;
}
.msg-views svg { width: 14.5px; height: 14.5px; stroke: currentColor; flex-shrink: 0; }
.msg-views-count { line-height: 1; }








img.emoji {
    width: 1.25em;
    height: 1.25em;
    vertical-align: -0.2em;
    margin: 0 1px;
}
.emoji-grid button img.emoji {
    width: 22px;
    height: 22px;
    margin: 0;
}


.emoji-cat-scroll { max-height: 100%; overflow-y: auto; }
.emoji-cat-block { margin-bottom: 4px; }


.saved-info-panel {
    width: 320px;
    flex-shrink: 0;
    background: #fff;
    border-left: 1px solid var(--line-soft);
    display: flex;
    flex-direction: column;
    transition: margin-right 0.25s ease;
    overflow: hidden;
}
.saved-info-panel.hidden { margin-right: -320px; visibility: hidden; }
.saved-info-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    padding: 16px 18px 14px;
    border-bottom: 1px solid var(--line-soft);
}
.saved-info-head h3 { margin: 0; font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: #171817; }
.saved-info-head span { display: block; font-size: 12.5px; color: var(--muted-on-light); margin-top: 3px; }
.saved-info-close { background: none; border: none; cursor: pointer; color: var(--muted-on-light); display: flex; padding: 2px; }
.saved-info-close svg { width: 18px; height: 18px; stroke: currentColor; }
.saved-info-stats { padding: 6px 0 14px; border-bottom: 1px solid var(--line-soft); flex-shrink: 0; }
.saved-info-stat-row {
    display: flex; align-items: center; gap: 14px;
    padding: 9px 18px; cursor: default; color: #171817; font-size: 13px;
}
.saved-info-stat-row svg { width: 19px; height: 19px; stroke: #171817; flex-shrink: 0; }
.saved-info-stat-row b { color: #171817; font-weight: 600; margin-right: 4px; }
.saved-info-chats { flex: 1; overflow-y: auto; padding: 6px 0; }
.saved-info-chats::-webkit-scrollbar { width: 5px; }
.saved-info-chats::-webkit-scrollbar-thumb { background: var(--line-soft); border-radius: 4px; }
.saved-info-chat-row { display: flex; align-items: center; gap: 12px; padding: 9px 18px; cursor: pointer; }

.saved-info-chat-row:hover { background: var(--paper); }
.saved-info-chat-row.active { background: var(--check-blue); }
.saved-info-chat-row.active .saved-info-chat-name,
.saved-info-chat-row.active .saved-info-chat-time,
.saved-info-chat-row.active .saved-info-chat-msg { color: #ffffff !important; }

.saved-info-chat-avatar {
    width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-weight: 700; font-size: 15px; color: #fff;
}
.saved-info-chat-body { flex: 1; min-width: 0; }
.saved-info-chat-row1 { display: flex; justify-content: space-between; gap: 8px; }
.saved-info-chat-name { font-size: 14px; font-weight: 600; color: #171817; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.saved-info-chat-time { font-size: 11.5px; color: var(--muted-on-light); flex-shrink: 0; }
.saved-info-chat-msg { font-size: 12.5px; color: var(--muted-on-light); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
body.night-mode .saved-info-panel { background: #10110f; }
body.night-mode .saved-info-head { border-color: #30332d; }
body.night-mode .saved-info-stats { border-bottom-color: #30332d; }

body.night-mode .saved-info-head h3 { color: #f5f4ef; }
body.night-mode .saved-info-stat-row { color: #f5f4ef; }

body.night-mode .saved-info-stat-row svg { stroke: #f5f4ef; }
body.night-mode .saved-info-stat-row b { color: #f5f4ef; }

body.night-mode .saved-info-chat-row:hover { background: #20231f; }
body.night-mode .saved-info-chat-name { color: #f5f4ef; }
@media (max-width: 1200px) {
    .saved-info-panel { position: fixed; right: 0; top: 0; bottom: 0; z-index: 40; box-shadow: -20px 0 40px rgba(0,0,0,0.15); }
    .saved-info-panel.hidden { margin-right: -320px; visibility: hidden; }
}





    /* ================= ARCHIVED CHATS VIEW (Telegram-style) ================= */
    #mainChatListView, #archivedChatsView {
        display: flex;
        flex-direction: column;
        height: 100%;
        min-height: 0;
    }
    .cl-archived-view-header {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 12px 14px 12px 6px;
        flex-shrink: 0;
        border-bottom: 1px solid var(--line);
    }
      .cl-archived-back {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--paper);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.15s ease;
        padding: 0;
        margin-right: -2px;
    }
    .cl-archived-back:hover { background: var(--ink-softer); }
    .cl-archived-back svg { width: 19px; height: 19px; stroke: currentColor; }
      .cl-archived-view-title {
        min-width: 0;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 13.5px;
        color: var(--paper);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

        .cl-archived-back-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        min-width: 0;
        cursor: pointer;
        position: relative;
        padding-bottom: 2px;
    }
    .cl-archived-back-group::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: -12px;
        height: 2px;
        background: var(--check-blue);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.2s ease;
    }
    .cl-archived-back-group:hover::after {
        transform: scaleX(1);
    }
    .cl-archived-menu-btn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--paper);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        padding: 0;
        transition: background 0.15s ease;
    }
    .cl-archived-menu-btn:hover { background: var(--ink-softer); }
    .cl-archived-menu-btn svg { width: 18px; height: 18px; }
    body.day-mode .cl-archived-view-header { border-color: var(--line-soft); }
    body.day-mode .cl-archived-back { color: #171817; }
    body.day-mode .cl-archived-view-title { color: #171817; }
    body.day-mode .cl-archived-menu-btn { color: #171817; }
    #archivedChatItems { flex: 1; overflow-y: auto; padding: 2px 8px 12px; }





    .contact-info-panel {
    width: 320px;
    flex-shrink: 0;
    background: #fff;
    border-left: 1px solid var(--line-soft);
    display: flex;
    flex-direction: column;
    transition: margin-right 0.25s ease;
    overflow: hidden;
}
.contact-info-panel.hidden { margin-right: -320px; visibility: hidden; }
.cip-close-wrap { display:flex; justify-content:flex-end; padding: 10px 10px 0; }
.cip-scroll { flex:1; overflow-y:auto; padding: 0 0 16px; }
.cip-scroll::-webkit-scrollbar { width: 5px; }
.cip-scroll::-webkit-scrollbar-thumb { background: var(--line-soft); border-radius: 4px; }

.cip-avatar-wrap { display:flex; flex-direction:column; align-items:center; text-align:center; padding: 0 18px 16px; }
.cip-avatar {
    width: 75px; height: 75px; border-radius: 50%;
    display:flex; align-items:center; justify-content:center;
    font-family:'Sora',sans-serif; font-weight:800; font-size:26px; color:#fff;
    margin-bottom: 10px; overflow:hidden; flex-shrink:0;
}
.cip-avatar img { width:100%; height:100%; object-fit:cover; display:block; }
.cip-name { font-family:'Sora',sans-serif; font-weight:700; font-size:16px; color:#171817; }
.cip-status { font-size:12.5px; color:var(--muted-on-light); margin-top:4px; }
.cip-status.online { color:#38bdf8; }

.cip-actions-row { display:flex; justify-content:space-around; gap: 8px; padding:12px 12px; border-bottom:1px solid var(--line-soft); }
.cip-action-btn {
    display:flex; flex-direction:column; align-items:center; justify-content:center; gap:5px;
    background: var(--ink-softer);
    border:none; cursor:pointer;
    font-size:11px; font-weight:600; font-family:'Inter',sans-serif;
    color: var(--paper);
    flex: 1;
    padding: 8px 4px;
    border-radius: 10px;
    transition: background 0.15s ease;
}
.cip-action-btn:hover { background: var(--line); }
.cip-action-btn svg { width:18px; height:18px; stroke: var(--paper); }
body.day-mode .cip-action-btn { background: #f1f1ec; color: #171817; }
body.day-mode .cip-action-btn svg { stroke: #171817; }
body.day-mode .cip-action-btn:hover { background: #e6e6e0; }
.cip-channel-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-bottom: 1px solid var(--line-soft);
    cursor: pointer;
    transition: background 0.15s ease;
}
.cip-channel-row:hover { background: var(--paper); }
.cip-channel-avatar {
    width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
    display:flex; align-items:center; justify-content:center;
    font-family:'Sora',sans-serif; font-weight:700; font-size:14px; color:#fff;
    overflow:hidden;
}
.cip-channel-avatar img { width:100%; height:100%; object-fit:cover; }
.cip-channel-body { flex:1; min-width:0; }
.cip-channel-top { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.cip-channel-name { font-size:13.5px; font-weight:600; color:#171817; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.cip-channel-time { font-size:11px; color:var(--muted-on-light); flex-shrink:0; }
.cip-channel-preview { font-size:12.5px; color:var(--muted-on-light); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-top:2px; }
.cip-channel-sub { font-size:11.5px; color:var(--muted-on-light); margin-top:2px; }




.cip-section-block {
    padding: 12px 18px;
    border-bottom: 1px solid var(--line-soft);
}
.cip-section-block:last-child { border-bottom: none; }
.cip-section-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--muted-on-light);
    margin-bottom: 4px;
}
.cip-section-value {
    font-size: 13.5px;
    color: #171817;
    word-break: break-word;
}
.cip-section-value a { color: #3390ec; text-decoration: none; }
.cip-section-value a:hover { text-decoration: underline; }
body.night-mode .cip-section-block { border-color: #30332d; }
body.night-mode .cip-section-label { color: #9b9f96; }
body.night-mode .cip-section-value { color: #f5f4ef; }


.cip-section-value.cip-username-value {
    color: #3390ec;
    cursor: pointer;
    user-select: none;
    transition: opacity 0.15s ease;
}
.cip-section-value.cip-username-value:hover { opacity: 0.8; }


body.night-mode .cip-section-value.cip-username-value { color: #5eb5f7; }

.cip-mini-channel {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 16px 18px;
    border-top: 7px solid var(--line-soft);
    border-bottom: 7px solid var(--line-soft);
    cursor: pointer;
    transition: background 0.15s ease;
}
.cip-mini-channel__icon {
    width: 42px; height: 42px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-weight: 700; font-size: 12px; color: #fff;
    overflow: hidden; background: #4b9bea;
    align-self: flex-start;
    margin-top: 0px;
}
.cip-mini-channel:hover { background: #f1f1ec; }

.cip-mini-channel__icon img { width: 100%; height: 100%; object-fit: cover; }
.cip-mini-channel__body { min-width: 0; flex: 1; }
.cip-mini-channel__top { display: flex; align-items: baseline; justify-content: space-between; gap: 8px; }
.cip-mini-channel__name { font-size: 13.5px; font-weight: 700; color: #171817; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 4px; }
.cip-mini-channel__name svg { width: 14px; height: 14px; flex-shrink: 0; color: #3390ec; }
.cip-mini-channel__time { font-size: 11px; color: var(--muted-on-light); flex-shrink: 0; }
.cip-mini-channel__desc { font-size: 12.5px; color: var(--muted-on-light); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cip-mini-channel__meta { font-size: 11.5px; color: var(--muted-on-light); margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
body.night-mode .cip-mini-channel:hover { background: #20231f; }
body.night-mode .cip-mini-channel { border-color: #30332d; }
body.night-mode .cip-mini-channel__name { color: #f5f4ef; }
body.night-mode .cip-mini-channel__time,
body.night-mode .cip-mini-channel__desc,
body.night-mode .cip-mini-channel__meta { color: #9b9f96; }

body.night-mode .contact-info-panel { background:#10110f; }
body.night-mode .cip-avatar-wrap,
body.night-mode .cip-actions-row,
body.night-mode .cip-channel-row { border-color:#30332d; }
body.night-mode .cip-name,
body.night-mode .cip-channel-name { color:#f5f4ef; }
body.night-mode .cip-channel-row:hover { background:#20231f; }

@media (max-width: 1200px) {
    .contact-info-panel { position: fixed; right: 0; top: 0; bottom: 0; z-index: 40; box-shadow: -20px 0 40px rgba(0,0,0,0.15); }
    .contact-info-panel.hidden { margin-right: -320px; visibility: hidden; }
}









.channel-info-panel {
    width: 320px;
    flex-shrink: 0;
    background: #fff;
    border-left: 1px solid var(--line-soft);
    display: flex;
    flex-direction: column;
    transition: margin-right 0.25s ease;
    overflow: hidden;
}
.channel-info-panel.hidden { margin-right: -320px; visibility: hidden; }
body.night-mode .channel-info-panel { background: #10110f; }
@media (max-width: 1200px) {
    .channel-info-panel { position: fixed; right: 0; top: 0; bottom: 0; z-index: 40; box-shadow: -20px 0 40px rgba(0,0,0,0.15); }
    .channel-info-panel.hidden { margin-right: -320px; visibility: hidden; }
}




















/* ============= SAQLANGAN XABARLAR: MEDIA KO'RINISHI ============= */
.saved-info-stat-row.clickable { cursor: pointer; transition: background 0.15s ease; }
.saved-info-stat-row.clickable:hover { background: #f1f1ec; }
body.night-mode .saved-info-stat-row.clickable:hover { background: #20231f; }

.saved-media-view { display: none; flex-direction: column; flex: 1; min-height: 0; }
.saved-info-panel.media-open .saved-info-head,
.saved-info-panel.media-open .saved-info-stats,
.saved-info-panel.media-open .saved-info-chats { display: none; }
.saved-info-panel.media-open .saved-media-view { display: flex; }

.smv-head {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 14px; border-bottom: 1px solid var(--line-soft); flex-shrink: 0;
}
.smv-title { flex: 1; font-family: 'Sora', sans-serif; font-weight: 700; font-size: 13.5px; color: #171817; }
.smv-btn {
    background: none; border: none; cursor: pointer; color: var(--muted-on-light);
    display: flex; padding: 4px; border-radius: 50%;
}
.smv-btn:hover { background: var(--line-soft); }
.smv-btn svg { width: 20px; height: 20px; stroke: currentColor; }
.smv-body { flex: 1; overflow-y: auto; padding-bottom: 12px; }
.smv-body::-webkit-scrollbar { width: 5px; }
.smv-body::-webkit-scrollbar-thumb { background: var(--line-soft); border-radius: 4px; }
.smv-month { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 12.5px; color: #171817; padding: 10px 16px 6px; }
.smv-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
.smv-item { aspect-ratio: 3 / 4; overflow: hidden; cursor: pointer; background: linear-gradient(145deg, #ececec, #dcdcdc); }
.smv-item img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.15s ease; }
.smv-item:hover img { transform: scale(1.04); }
body.night-mode .smv-head { border-color: #30332d; }
body.night-mode .smv-title, body.night-mode .smv-month { color: #f5f4ef; }
body.night-mode .smv-btn:hover { background: #20231f; }

.smv-month { display: flex; align-items: center; gap: 7px; font-family: 'Sora', sans-serif; font-weight: 700; font-size: 12.5px; color: #171817; padding: 10px 16px 6px; }
.smv-month svg { width: 15px; height: 15px; stroke: #171817; flex-shrink: 0; }
body.night-mode .smv-month svg { stroke: #ffffff; }














/* ============= VIDEOLAR KO'RINISHI ============= */
.smv-item { position: relative; }
.smv-item video { width: 100%; height: 100%; object-fit: cover; display: block; pointer-events: none; background: linear-gradient(145deg, #e8edf3, #d6dee8); }
.smv-duration {
    position: absolute; left: 6px; bottom: 6px;
    display: flex; align-items: center; gap: 4px;
    background: rgba(0,0,0,0.5); color: #fff;
    font-size: 11.5px; font-weight: 600; line-height: 1;
    padding: 3px 7px 3px 5px; border-radius: 10px;
}
.smv-duration svg { width: 11px; height: 11px; flex-shrink: 0; }
.lightbox-video {
    display: none;
    max-width: 90vw; max-height: 76vh;
    border-radius: 6px; background: #000;
}









/* ============= FAYLLAR KO'RINISHI ============= */
.smv-files { display: flex; flex-direction: column; }
.smv-file-row {
    display: flex; align-items: center; gap: 14px;
    padding: 8px 16px; cursor: pointer; transition: background 0.15s ease;
}
.smv-file-row:hover { background: #f1f1ec; }
body.night-mode .smv-file-row:hover { background: #20231f; }
.smv-file-icon {
    width: 52px; height: 52px; flex-shrink: 0; border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-family: 'Inter', sans-serif; font-weight: 700;
    font-size: 15px; text-transform: lowercase;
}
.smv-file-info { flex: 1; min-width: 0; }
.smv-file-name {
    font-size: 13.5px; font-weight: 700; color: #171817;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.smv-file-meta { font-size: 12px; color: var(--muted-on-light); margin-top: 3px; }
body.night-mode .smv-file-name { color: #f5f4ef; }










/* ============= MUSIQA (AUDIO) KO'RINISHI ============= */
.smv-audio-list { display: flex; flex-direction: column; padding-top: 8px; }
.smv-audio-row {
    display: flex; align-items: center; gap: 14px;
    padding: 8px 16px; cursor: pointer; transition: background 0.15s ease;
}
.smv-audio-row:hover { background: #f1f1ec; }
body.night-mode .smv-audio-row:hover { background: #20231f; }
.smv-audio-play {
    width: 36px; height: 36px; flex-shrink: 0; border-radius: 50%;
    border: none; background: #6ab3f3; color: #fff;
    display: flex; align-items: center; justify-content: center;
    pointer-events: none;
}
.smv-audio-play svg { width: 25px; height: 25px; }








.smv-link-row {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 10px 16px; cursor: pointer; transition: background 0.15s ease;
}
.smv-link-row:hover { background: #f1f1ec; }
body.night-mode .smv-link-row:hover { background: #20231f; }
.smv-link-icon {
    width: 46px; height: 46px; flex-shrink: 0; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-family: 'Sora', sans-serif; font-weight: 700; font-size: 17px;
    overflow: hidden; background: #5b9bea;
}
.smv-link-icon img { width: 60%; height: 60%; object-fit: contain; }
.smv-link-info { flex: 1; min-width: 0; padding-top: 1px; }
.smv-link-title {
    font-size: 13.5px; font-weight: 700; color: #171817;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.smv-link-desc {
    font-size: 12.5px; color: var(--muted-on-light); margin-top: 2px;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.smv-link-url {
    font-size: 12.5px; color: #3390ec; margin-top: 2px;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
body.night-mode .smv-link-title { color: #f5f4ef; }










.smv-voice-row {
    display: flex; align-items: center; gap: 14px;
    padding: 8px 16px; cursor: pointer; transition: background 0.15s ease;
}
.smv-voice-row:hover { background: #f1f1ec; }
body.night-mode .smv-voice-row:hover { background: #20231f; }
.smv-voice-info { flex: 1; min-width: 0; }
.smv-voice-name {
    font-size: 13.5px; font-weight: 700; color: #171817;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.smv-voice-meta { font-size: 12px; color: var(--muted-on-light); margin-top: 3px; }
body.night-mode .smv-voice-name { color: #f5f4ef; }





.open-chat-bar {
    display: none;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    height: 45px;            /* ⬅ 54px edi */
    width: 100%;             /* ⬅ YANGI */
    align-self: stretch;     /* ⬅ YANGI */
    margin: 0;               /* ⬅ YANGI */
    box-sizing: border-box;  /* ⬅ YANGI */
    border-top: 1px solid var(--line-soft);
    background: #fff;
    color: #3390ec;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    user-select: none;
    transition: background 0.15s ease;
}
.open-chat-bar:hover { background: var(--paper); }
body.night-mode .open-chat-bar { background: #171916; border-color: #30332d; }



#savedSubBackBtn {
    margin-left: -10px;
    margin-right: -2px;
    width: 40px;
    height: 40px;
}
#savedSubBackBtn svg {
    width: 24px;
    height: 24px;
}
#savedSubBackBtn + .cm-title {
    margin-left: -6px;
}










.chat-main { position: relative; }

.scroll-down-btn {
    position: absolute;
    right: 24px;
    bottom: 84px;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--ink-soft);
    border: 1px solid var(--line-soft);
    box-shadow: 0 6px 18px rgba(0,0,0,0.28);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    opacity: 0;
    transform: translateY(10px) scale(0.9);
    pointer-events: none;
    transition: opacity 0.18s ease, transform 0.18s ease;
    z-index: 15;
}
.scroll-down-btn.show {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: auto;
}
.scroll-down-btn:hover { background: var(--line-soft); }
body.night-mode .scroll-down-btn:hover { background: #2a2d27; }
.scroll-down-btn svg { width: 20px; height: 20px; stroke: var(--ink); }
body.night-mode .scroll-down-btn svg { stroke: #f5f4ef; }
body.day-mode .scroll-down-btn svg { stroke: #171817; }
.scroll-down-btn .sdb-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--check-blue);
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    min-width: 17px;
    height: 17px;
    border-radius: 999px;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
}














/* Kanal avatari ichidagi ikonka (rasm bo'lmasa) */
.cip-avatar svg { width: 34px; height: 34px; stroke: #fff; fill: none; }






.cip-info-row {
    padding: 12px 18px;
    cursor: default;
}
.cip-info-row.copyable { cursor: pointer; transition: background 0.15s ease; }

.cip-info-value { font-size: 13.5px; color: #171817; word-break: break-word; line-height: 1.45; }
.cip-info-value.is-link { color: #3390ec; }
.cip-info-label { font-size: 12px; color: var(--muted-on-light); margin-top: 2px; }
.cip-info-group { border-bottom: 7px solid var(--line-soft); padding: 4px 0; }
.cip-info-group:empty { display: none; }

.cip-info-row-icon {
    display: flex;
    align-items: center;
    gap: 14px;
    cursor: pointer;
    transition: background 0.15s ease;
}
.cip-info-row-icon:hover { background: var(--paper); }
body.night-mode .cip-info-row-icon:hover { background: #20231f; }
.cip-info-row-icon svg { width: 20px; height: 20px; stroke: var(--muted-on-light); flex-shrink: 0; }
.cip-info-row-icon.danger { color: var(--danger); }
.cip-info-row-icon.danger .cip-info-value { color: var(--danger) !important; }
.cip-info-row-icon.danger svg { stroke: var(--danger) !important; }
body.night-mode .cip-info-row-icon svg { stroke: #9b9f96; }
body.night-mode .cip-info-row-icon.danger svg { stroke: var(--danger) !important; }


.cip-group-divider { border-bottom: 1px solid var(--line-soft) !important; }
.cip-group-none { border-bottom: none !important; }
body.night-mode .cip-group-divider { border-bottom-color: #30332d !important; }
body.day-mode .cip-group-divider { border-bottom-color: var(--line-soft) !important; }

#channelStatsBlock { border-bottom: 1px solid var(--line-soft) !important; }
body.night-mode #channelStatsBlock { border-bottom-color: #30332d !important; }


.cip-info-title { padding: 10px 18px 0; ... }


.cip-info-title { padding: 10px 18px 0; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: var(--muted-on-light); }
body.night-mode .cip-info-value { color: #f5f4ef; }
body.night-mode .cip-info-value.is-link { color: #5eb5f7; }
body.night-mode .cip-info-label,
body.night-mode .cip-info-title { color: #9b9f96; }
body.night-mode .cip-info-group { border-color: #30332d; }

#cmDiscussBtn svg { width: 20px; height: 20px; fill: currentColor; stroke: none; }



html.has-accent .msg-row.out .msg-bubble:not(.media-bubble) .msg-status,
html.has-accent .saved-message-row:not(.from-other) .saved-message-bubble:not(.media-bubble) .msg-status,
html.has-accent .saved-message-row:not(.from-other) .saved-message-time { color: var(--out-fg) !important; }
html.has-accent .msg-row.out .msg-link,
html.has-accent .saved-message-row:not(.from-other) .msg-link { color: var(--out-fg); text-decoration: underline; }








/* ===== Suhbat tanlanmaganda: Telegramdagidek qisqa pill + kichik header ===== */
.cm-header {
    transition: height 0.2s ease;
}
body.chat-open .cm-header {
    height: 56px;              /* suhbat tanlanganda odatiy balandlik */
}

.cm-empty.cm-empty--pill {
    margin: auto;
    padding: 4px 12px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.18);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    gap: 0;
}
.cm-empty--pill span {
    max-width: none;
    white-space: nowrap;
    font-size: 12px;
    font-weight: 500;
    line-height: 1.4;
    color: #fff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
}


















/* ===== Chiquvchi pufakchadagi fayl / ovozli / musiqa elementlari: aksent rangga moslashadi ===== */
html.has-accent .msg-row.out .msg-bubble:not(.media-bubble) .file-msg__icon,
html.has-accent .saved-message-row:not(.from-other) .saved-message-bubble:not(.media-bubble) .file-msg__icon {
    background: color-mix(in srgb, var(--out-fg) 22%, transparent);
    color: var(--out-fg);
}

/* Ovozli xabar: play tugmasi */
html.has-accent .msg-row.out .voice-msg-play,
html.has-accent .saved-message-row:not(.from-other) .voice-msg-play,
html.has-accent .msg-row.out .music-msg-play,
html.has-accent .saved-message-row:not(.from-other) .music-msg-play {
    background: var(--out-fg);
    color: var(--out-bg);
    box-shadow: 0 0 0 6px color-mix(in srgb, var(--out-fg) 22%, transparent);
}
html.has-accent .msg-row.out .voice-msg-play:hover,
html.has-accent .saved-message-row:not(.from-other) .voice-msg-play:hover,
html.has-accent .msg-row.out .music-msg-play:hover,
html.has-accent .saved-message-row:not(.from-other) .music-msg-play:hover {
    box-shadow: 0 0 0 8px color-mix(in srgb, var(--out-fg) 26%, transparent);
}

/* Ovozli xabar: chiziqlar (o'ynalmagan xira, o'ynalgan to'liq) */
html.has-accent .msg-row.out .voice-msg-wave span,
html.has-accent .saved-message-row:not(.from-other) .voice-msg-wave span {
    background: var(--out-fg);
    opacity: 0.4;
}
html.has-accent .msg-row.out .voice-msg-wave span.played,
html.has-accent .saved-message-row:not(.from-other) .voice-msg-wave span.played {
    background: var(--out-fg);
    opacity: 1;
}

/* Musiqa progress */
html.has-accent .msg-row.out .music-msg-bar,
html.has-accent .saved-message-row:not(.from-other) .music-msg-bar {
    background: color-mix(in srgb, var(--out-fg) 30%, transparent);
}
html.has-accent .msg-row.out .music-msg-bar-fill,
html.has-accent .saved-message-row:not(.from-other) .music-msg-bar-fill {
    background: var(--out-fg);
}











/* ===== Lichkada suhbatdoshning tanlagan rangi ===== */
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .msg-bubble:not(.media-bubble) {
    background: var(--peer-bg) !important;
    color: var(--peer-fg) !important;
    border-color: transparent !important;
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .msg-link {
    color: var(--peer-fg); text-decoration: underline;
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .file-msg__icon {
    background: color-mix(in srgb, var(--peer-fg) 22%, transparent);
    color: var(--peer-fg);
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .voice-msg-play,
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .music-msg-play {
    background: var(--peer-fg) !important;
    color: var(--peer-bg) !important;
    box-shadow: 0 0 0 6px color-mix(in srgb, var(--peer-fg) 22%, transparent);
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .voice-msg-wave span {
    background: var(--peer-fg) !important; opacity: .4;
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .voice-msg-wave span.played {
    opacity: 1;
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .music-msg-bar {
    background: color-mix(in srgb, var(--peer-fg) 30%, transparent);
}
#cmMessages.has-peer-color .msg-row.in:not(.channel-post) .music-msg-bar-fill {
    background: var(--peer-fg);
}







/* Menyular har doim videolar va boshqa hamma narsa ustida chiqsin */
.dropdown-menu {
    z-index: 9999 !important;
}
.dropdown-menu.dropdown-submenu {
    z-index: 10000 !important;
}

/* Xabarlar konteyneri o'z ichida alohida qatlam hosil qilsin,
   shunda video kontrollari tashqaridagi menyuni bosib o'tolmaydi */
.cm-messages {
    isolation: isolate;
    position: relative;
    z-index: 0;
}
.file-msg video {
    position: relative;
    z-index: 0;
}








/* ===== Musiqa xabari ===== */
.music-msg { display:flex; align-items:center; gap:12px; min-width:260px; max-width:340px; padding:2px 0; }
.music-msg-play {
    width:46px; height:46px; border-radius:50%; border:none; flex-shrink:0; cursor:pointer;
    background:linear-gradient(135deg,#5aa9f0,#3a7fd6); color:#fff;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 2px 8px rgba(58,127,214,.45);
    transition:transform .15s ease;
}
.music-msg-play:hover { transform:scale(1.06); }
.music-msg-play svg { width:26px; height:26px; margin-left:2px; }
.music-msg.is-playing .music-msg-play svg { margin-left:0; }
.music-msg-info { flex:1; min-width:0; }
.music-msg-name { display:block; font-size:13.5px; font-weight:700; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.music-msg-meta { display:flex; align-items:center; gap:6px; margin-top:3px; font-size:11.5px; opacity:.75; }
.music-msg-time { margin-left:auto; font-variant-numeric:tabular-nums; }
.music-msg-bar { height:4px; border-radius:4px; background:rgba(128,128,128,.35); position:relative; cursor:pointer; margin-top:7px; }
.music-msg-bar::before { content:""; position:absolute; left:0; right:0; top:-6px; bottom:-6px; }
.music-msg-bar-fill { position:absolute; left:0; top:0; bottom:0; width:0%; border-radius:4px; background:#4b9bea; }
.music-eq { display:inline-flex; align-items:flex-end; gap:2px; height:11px; }
.music-eq i { width:2.5px; height:4px; border-radius:2px; background:currentColor; display:block; }
.music-eq i:nth-child(2) { height:9px; }
.music-eq i:nth-child(3) { height:6px; }
.music-msg.is-playing .music-eq i { animation:eqBounce .8s ease-in-out infinite; }
.music-msg.is-playing .music-eq i:nth-child(2) { animation-delay:.2s; }
.music-msg.is-playing .music-eq i:nth-child(3) { animation-delay:.4s; }
@keyframes eqBounce { 0%,100% { height:3px; } 50% { height:11px; } }

/* ===== Tepadagi mini-pleyer ===== */
.music-bar {
    display:none; align-items:center; gap:4px; position:relative; flex-shrink:0;
    height:44px; padding:0 14px 2px; background:var(--ink-soft);
    border-bottom:1px solid var(--line);
}
.music-bar.show { display:flex; }
.music-bar button {
    background:none; border:none; cursor:pointer; color:#4b9bea;
    width:30px; height:30px; border-radius:50%;
    display:flex; align-items:center; justify-content:center; transition:background .15s ease;
}
.music-bar button:hover { background:rgba(75,155,234,.15); }
.music-bar button svg { width:18px; height:18px; }
.music-bar #mbPlay svg { width:20px; height:20px; }
.mb-info { flex:1; min-width:0; margin:0 8px; }
.mb-name { display:block; font-size:13px; font-weight:600; color:var(--paper); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.mb-time { font-size:12px; color:var(--muted-on-dark); font-variant-numeric:tabular-nums; margin-right:4px; }
.music-bar #mbSpeed { width:auto; padding:0 8px; border-radius:6px; font-size:12px; font-weight:700; font-family:'Inter',sans-serif; }
.music-bar #mbClose { color:var(--muted-on-dark); }
.mb-progress { position:absolute; left:0; right:0; bottom:-1px; height:3px; background:rgba(128,128,128,.25); cursor:pointer; }
.mb-progress-fill { height:100%; width:0%; background:#4b9bea; }







/* Faqat musiqa uchun tugmalar (ovozli xabarda yashirin) */
.music-bar .mb-music-only { display:none; }
.music-bar.is-music .mb-music-only { display:flex; }
.music-bar .mb-music-only { opacity:.55; position:relative; }
.music-bar .mb-music-only.on { opacity:1; background:rgba(75,155,234,.18); }
#mbRepeat .mb-one {
    display:none; position:absolute; font-size:8px; font-weight:800;
    line-height:1; top:50%; left:50%; transform:translate(-50%,-50%);
}
#mbRepeat.one .mb-one { display:block; }












/* ---- Qadalgan chat belgisi ---- */
.cl-pin {
    flex-shrink: 0;
    margin-left: auto;
    display: flex;
    align-items: center;
    color: var(--muted-on-dark);
}
.cl-pin svg { width: 16px; height: 16px; fill: currentColor; stroke: none; }
.cl-item.active .cl-pin { color: #ffffff; }
/* o'qilmagan badge bo'lsa, qadash belgisi yashiriladi (Telegramdagidek) */
.cl-row2:has(.cl-unread) .cl-pin { display: none; }














/* ============= TELEGRAM USLUBIDAGI TASDIQLASH DIALOGI ============= */
.tg-dialog-overlay {
    position: fixed; inset: 0; z-index: 250;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.16s ease;
}
.tg-dialog-overlay.show { opacity: 1; pointer-events: auto; }
.tg-dialog {
    width: 380px; max-width: calc(100vw - 32px);
    background: var(--ink-soft);
    border: 1px solid var(--line);
    border-radius: 14px;
    padding: 20px 22px 14px;
    box-shadow: 0 24px 60px rgba(0,0,0,0.5);
    transform: translateY(8px) scale(0.96);
    transition: transform 0.18s cubic-bezier(0.2, 0.9, 0.3, 1.2);
}
.tg-dialog-overlay.show .tg-dialog { transform: none; }

.tg-dialog-head { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
.tg-dialog-avatar {
    width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Sora', sans-serif; font-weight: 700; font-size: 16px;
    color: #fff; overflow: hidden;
}
.tg-dialog-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
.tg-dialog-avatar svg { width: 24px; height: 24px; stroke: #fff; }
.tg-dialog-title {
    min-width: 0; font-family: 'Sora', sans-serif; font-weight: 700; font-size: 16px;
    color: var(--paper); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.tg-dialog-text { font-size: 14.5px; line-height: 1.5; color: var(--paper); margin-bottom: 14px; }
.tg-dialog-text b { font-weight: 700; }
.tg-dialog-text .tg-warn { display: block; margin-top: 12px; font-weight: 600; }

.tg-dialog-checks { display: flex; flex-direction: column; }
.tg-check-row {
    display: flex; align-items: center; gap: 12px;
    padding: 8px 0; cursor: pointer; user-select: none;
    font-size: 14px; color: var(--paper);
}
.tg-check-row:hover .dc-check { border-color: var(--check-blue); }

.tg-dialog-link {
    display: none;
    background: none; border: none; cursor: pointer;
    padding: 6px 0 4px; margin-bottom: 6px;
    font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 500;
    color: #5eb5f7;
}
.tg-dialog-link:hover { text-decoration: underline; text-underline-offset: 3px; }

.tg-dialog-actions { display: flex; justify-content: flex-end; gap: 6px; margin-top: 8px; }
.tg-dialog-actions button {
    background: none; border: none; cursor: pointer;
    padding: 8px 14px; border-radius: 8px;
    font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 600;
    transition: background 0.15s ease;
}
#tgDialogCancel { color: #6ab3f3; }
#tgDialogCancel:hover { background: rgba(106,179,243,0.14); }
#tgDialogOk { color: var(--danger); }
#tgDialogOk:hover { background: rgba(241,101,101,0.14); }

body.day-mode .tg-dialog { background: #ffffff; border-color: var(--line-soft); }
body.day-mode .tg-dialog-title,
body.day-mode .tg-dialog-text,
body.day-mode .tg-check-row { color: #171817; }
body.day-mode .tg-dialog-link { color: #3390ec; }
</style>

<div class="app-shell">
    <!-- ================= RAIL ================= -->
    <aside class="rail">
        <button class="rail-brand" id="mainMenuBtn" title="Menyu">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="14" y2="17"></line></svg>
            <span class="rail-brand-dot"></span>
        </button>

         <button class="rail-item active" id="tabAllChats">
    <span class="rail-badge" data-rail-count="all" style="display:none;"></span>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 3.5c-3.6 0-6.5 2.6-6.5 5.8 0 1.9 1 3.6 2.6 4.7l-.7 2.6 2.8-1.3c.6.15 1.2.2 1.8.2 3.6 0 6.5-2.6 6.5-5.8s-2.9-6.2-6.5-6.2z"></path>
        <path d="M15 8.2c3.1.3 5.5 2.7 5.5 5.6 0 1.7-.9 3.2-2.3 4.2l.6 2.3-2.5-1.1c-.5.13-1.05.18-1.6.18-2.9 0-5.4-2-5.9-4.7"></path>
    </svg>
    <span>Barcha</span>
</button>

<button class="rail-item" id="tabUnread">
    <span class="rail-badge" data-rail-count="unread" style="display:none;"></span>
  <i class='bx bx-chat'></i>
    <span>O'qilmagan</span>
</button>

<button class="rail-item" id="tabPersonal">
    <span class="rail-badge" data-rail-count="personal" style="display:none;"></span>
    <i class='bx bx-user-circle'></i>
    <span>Shaxsiy</span>
</button>

        <button class="rail-item" id="tabEdit">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"></line><circle cx="9" cy="7" r="2" fill="currentColor" stroke="none"></circle><line x1="4" y1="17" x2="20" y2="17"></line><circle cx="16" cy="17" r="2" fill="currentColor" stroke="none"></circle></svg>
            <span>Edit</span>
        </button>

        <div class="rail-spacer"></div>
    </aside>

      <!-- ================= CHAT LIST ================= -->
    <section class="chat-list-panel" id="chatListPanel">

       <!-- ===== ASOSIY RO'YXAT KO'RINISHI (search + archived row + chats) ===== -->
       <div id="mainChatListView">
              <div class="cl-search" id="clSearchWrap">
    <div class="cl-search-box" id="clSearchBox">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
        <input type="text" id="clSearchInput" placeholder="Qidirish" autocomplete="off">
        <button class="cl-search-clear" id="clSearchClear" type="button">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
</div>

<div class="cl-search-panel" id="clSearchPanel">
      <div class="csp-tabs" id="cspTabs">
        <button class="csp-tab-btn active" data-tab="chats" type="button">Suhbatlar</button>
        <button class="csp-tab-btn" data-tab="channels" type="button">Kanallar</button>
        <button class="csp-tab-btn" data-tab="messages" type="button">Postlar</button>
        <button class="csp-tab-btn" data-tab="photos" type="button">Rasmlar</button>
        <button class="csp-tab-btn" data-tab="videos" type="button">Videolar</button>
        <button class="csp-tab-btn" data-tab="files" type="button">Fayllar</button>
        <button class="csp-tab-btn" data-tab="links" type="button">Havolalar</button>
        <button class="csp-tab-btn" data-tab="music" type="button">Musiqa</button>
        <button class="csp-tab-btn" data-tab="voice" type="button">Ovozli xabarlar</button>
    </div>
    <div class="csp-hint" id="cspHint">
        <svg viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
        <span>Suhbat, kanal yoki foydalanuvchi nomini yozing</span>
    </div>

    <!-- Lokal (mavjud chatlar orasidan) natijalar -->
    <div class="csp-results" id="cspResults"></div>

    <!-- Global (server / butun foydalanuvchilar bazasi) natijalari -->
    <div class="csp-loading" id="cspLoading">
        <span class="csp-spinner"></span>
        <span>Qidirilmoqda...</span>
    </div>
    <div id="cspGlobalSection" style="display:none;">
        <div class="csp-section-title">Global qidiruv natijalari</div>
        <div class="csp-results" id="cspGlobalResults"></div>
    </div>

    <div class="csp-empty" id="cspEmpty">
        <svg viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
        <span>Hech narsa topilmadi</span>
    </div>
</div>
            <div class="cl-archived" id="clArchivedRow">
                        <div class="cl-archived-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="7" width="18" height="13" rx="3"></rect>
                    <path d="M3 7 L6 3.5 H18 L21 7"></path>
                    <path d="M12 10.5v6"></path>
                    <polyline points="9.5 14 12 16.5 14.5 14"></polyline>
                </svg>
            </div>
        <div class="cl-archived-text">
            <b>Arxivlangan suhbatlar</b>
            <span id="clArchivedSubtext">Hozircha yo'q</span>
        </div>
        <div class="cl-archived-count" id="clArchivedCount">0</div>
    </div>

    <div class="cl-items" id="chatItems">
        <div class="cl-empty">
            <svg viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <b>Hozircha suhbatlar yo'q</b>
            <span>Siz hali hech qanday guruh yoki kanalga qo'shilmagansiz.<br>Foydalanuvchi toping yoki guruhga qo'shiling.</span>
        </div>
    </div>
       </div>

       <!-- ===== ARXIVLANGAN SUHBATLAR KO'RINISHI (Telegram uslubida) ===== -->
       <div id="archivedChatsView" style="display:none; flex-direction:column; height:100%;">
                        <div class="cl-archived-view-header">
               <div class="cl-archived-back-group" id="archivedBackGroup">
                   <button class="cl-archived-back" id="archivedBackBtn" type="button">
                       <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="19" y1="12" x2="5" y2="12"></line>
                           <polyline points="12 19 5 12 12 5"></polyline>
                       </svg>
                   </button>
                   <span class="cl-archived-view-title">Arxivlangan suhbatlar</span>
               </div>
               <button class="cl-archived-menu-btn" id="archivedMenuBtn" type="button">
                   <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="19" r="2"></circle></svg>
               </button>
           </div>
                      <div class="cl-items" id="archivedChatItems">
                            <div class="cl-empty">
                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                       <rect x="3" y="7" width="18" height="13" rx="3"></rect>
                       <path d="M3 7 L6 3.5 H18 L21 7"></path>
                       <path d="M12 10.5v6"></path>
                       <polyline points="9.5 14 12 16.5 14.5 14"></polyline>
                   </svg>
                   <b>Arxiv bo'sh</b>
                   <span>Arxivlangan suhbatlar shu yerda ko'rinadi.</span>
               </div>
           </div>
       </div>

    </section>

    <!-- ================= CHAT MAIN ================= -->
    <main class="chat-main">
        <header class="cm-header">
            <div class="cm-avatar" id="cmAvatar" style="display:none;"></div>
            <button class="icon-btn" id="savedSubBackBtn" style="display:none;" title="Orqaga">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
</button>
            <div class="cm-title">
                <h3 id="cmName">Suhbat tanlanmagan</h3>
                <span id="cmStatus">Chapdan bir suhbat tanlang</span>
            </div>
            <div class="cm-actions">
                <button class="icon-btn"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></button>
                   <button class="icon-btn" id="cmCallBtn" style="display:none;" title="Qo'ng'iroq qilish"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>


                   <!-- YANGI TUGMA -->
<button class="icon-btn" id="cmDiscussBtn" style="display:none;" title="Efir">
    <svg viewBox="0 0 16 16">
        <path fill="currentColor" d="M15.5 8a.5.5 0 0 1 .5.5a4.5 4.5 0 0 1-4 4.47v1.53a.5.5 0 0 1-1 0v-1.53A4.5 4.5 0 0 1 7 8.5a.5.5 0 0 1 1 0a3.5 3.5 0 1 0 7 0a.5.5 0 0 1 .5-.5M6.502 1c1.358 0 2.6.493 3.56 1.309a3.5 3.5 0 0 0-.885.573a4.5 4.5 0 0 0-6.645 5.737c.058.11.075.237.045.358l-.482 1.926l1.924-.481a.5.5 0 0 1 .358.045A4.5 4.5 0 0 0 6.502 11l.099-.003q.262.511.62.954a5.5 5.5 0 0 1-3.138-.515l-2.149.54a.75.75 0 0 1-.91-.91l.537-2.153A5.5 5.5 0 0 1 6.502 1M11.5 3A2.5 2.5 0 0 1 14 5.5v3a2.5 2.5 0 0 1-5 0v-3A2.5 2.5 0 0 1 11.5 3m0 1A1.5 1.5 0 0 0 10 5.5v3a1.5 1.5 0 0 0 3 0v-3A1.5 1.5 0 0 0 11.5 4"></path>
    </svg>
</button>
<button class="icon-btn" id="togglePanelBtn"><svg viewBox="0 0 24 24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"><rect x="2" y="3" width="20" height="18" rx="3"></rect><line x1="12" y1="3" x2="12" y2="21"></line></svg></button>
        <button class="icon-btn" id="chatMenuBtn"><svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="19" r="2"></circle></svg></button>
            <!-- chat options dropdown (3 dots) -->
           <div class="dropdown-menu" id="chatOptionsMenu">
    <div class="dropdown-submenu-wrap" id="headerMuteSubmenuWrap">
        <button type="button" id="headerMuteBtn">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span id="headerMuteLabel">Ovozsiz qilish</span>
            <svg class="dropdown-chevron" id="headerMuteChevron" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><polyline points="9 6 15 12 9 18"></polyline></svg>
        </button>
        <div class="dropdown-menu dropdown-submenu" id="headerMuteSubmenu">
            <button type="button" data-mute-option="tone">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
                <span>Ovoz balandligini tanlash</span>
            </button>
            <button type="button" data-mute-option="disable">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path><line x1="3" y1="3" x2="21" y2="21"></line></svg>
                <span>Ovozni o'chirish</span>
            </button>
            <button type="button" data-mute-option="for">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15 14"></polyline></svg>
                <span>Vaqtinchalik ovozsiz...</span>
            </button>
            <button type="button" data-mute-option="forever" class="danger">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span>Butunlay ovozsiz</span>
            </button>
            </div>
    </div>

    <div class="dropdown-sep"></div>

      <button id="optViewInfo">
        <svg id="optViewInfoIcon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle><path d="M6.5 19a5.5 5.5 0 0 1 11 0"></path></svg>
        <span id="optViewInfoLabel">Profilni ko'rish</span>
    </button>

    <button id="optManage">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><circle cx="6.5" cy="7" r="2.6"></circle><line x1="9.6" y1="7" x2="21" y2="7"></line><line x1="3" y1="17" x2="14.4" y2="17"></line><circle cx="17.5" cy="17" r="2.6"></circle></svg>
        <span id="optManageLabel">Boshqarish</span>
    </button>

       <button id="optStoryArchive">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"></polygon></svg>
        <span>Hikoyalar arxivi</span>
    </button>

    <button id="optBoost">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><path d="M13 2 3 14h7l-1 8 11-14h-7z"></path></svg>
        <span id="optBoostLabel">Kanalni oshirish</span>
    </button>

    <button id="optCreatePoll"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg><span>Create poll</span></button>

    <button id="optViewDiscussion">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path></svg>
        <span>Muhokamani ko'rish</span>
    </button>

    <button id="optWallpaper"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><path d="M3 16l5-5 4 4 5-6 4 5"></path></svg><span>Set Wallpaper</span></button>

    <button id="optDisableSharing">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><polyline points="15 17 20 12 15 7"></polyline><path d="M4 18v-2a4 4 0 0 1 4-4h12"></path><line x1="3" y1="3" x2="21" y2="21"></line></svg>
        <span id="optDisableSharingLabel">Disable Sharing</span>
    </button>

    <div class="dropdown-sep"></div>
    <button id="optExport"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg><span>Export chat history</span></button>
    <button id="optClear"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg><span>Clear history</span></button>
    <button id="optDelete" class="danger"><svg id="optDeleteIcon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></svg><span id="optDeleteLabel">Delete chat</span></button>
</div>
        </header>



        <div class="music-bar" id="musicBar">
    <button id="mbPrev" type="button" title="Oldingi"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 6h2v12H6zM9.5 12 18 6v12z"></path></svg></button>
    <button id="mbPlay" type="button" title="Ijro / pauza"></button>
    <button id="mbNext" type="button" title="Keyingi"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M16 6h2v12h-2zM6 18V6l8.5 6z"></path></svg></button>
    <div class="mb-info"><span class="mb-name" id="mbName"></span></div>
    <span class="mb-time" id="mbTime">0:00</span>

<button id="mbOrder" class="mb-music-only" type="button" title="Oddiy tartib">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 4v16M7 4 3 8M7 4l4 4M17 20V4M17 20l-4-4M17 20l4-4"></path></svg>
</button>
<button id="mbRepeat" class="mb-music-only" type="button" title="Takrorlash o'chiq">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 1l4 4-4 4"></path><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><path d="M7 23l-4-4 4-4"></path><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
    <span class="mb-one">1</span>
</button>

<button id="mbSpeed" type="button" title="Tezlik">1x</button>
    <button id="mbClose" type="button" title="Yopish"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
    <div class="mb-progress" id="mbProgress"><div class="mb-progress-fill" id="mbFill"></div></div>
</div>

        <!-- pinned message banner -->
        <div class="pinned-banner" id="pinnedBanner">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14l-1.4-7L21 7l-3-3-3 3-7-1.4L6 12z"></path></svg>
            <b>Pinned message</b>
            <span id="pinnedBannerText"></span>
            <button id="pinnedBannerClose"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>

        <!-- selection mode toolbar -->
        <div class="selection-toolbar" id="selectionToolbar">
            <button class="sel-close" id="selClose"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            <span class="sel-count" id="selCount">0 tanlandi</span>
            <button class="sel-action" id="selForward"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 17 20 12 15 7"></polyline><path d="M4 18v-2a4 4 0 0 1 4-4h12"></path></svg>Forward</button>
            <button class="sel-action danger" id="selDelete"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>Delete</button>
        </div>

        <div class="cm-messages" id="cmMessages">
         <div class="cm-empty cm-empty--pill" id="cmEmptyState">
    <span>Xabar yozish uchun suhbatni tanlang</span>
</div>
        </div>

            <button class="scroll-down-btn" id="scrollDownBtn" type="button" title="Pastga tushish">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
            <span class="sdb-badge" id="scrollDownBadge"></span>
        </button>


        <!-- recording indicator -->
      <div class="rec-indicator" id="recIndicator">
    <span class="rec-indicator-dot"></span>
    <span id="recIndicatorTime">00:00,0</span>
    <span id="recIndicatorLabel">Ovozli xabar yozilmoqda...</span>
    <button class="rec-indicator-cancel" id="recCancelBtn">Bekor qilish</button>
</div>

        <div class="cm-composer">
            <button class="icon-btn" id="attachFileBtn" type="button" title="Fayl yuborish"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg></button>
            <input type="file" id="attachFileInput" hidden>

            <div class="composer-wrap">
                <div class="reply-preview" id="replyPreview">
                    <div class="reply-preview-bar"></div>
                    <div class="reply-preview-text">
                        <b id="replyPreviewName">Reply</b>
                        <span id="replyPreviewText"></span>
                    </div>
                    <button class="reply-preview-close" id="replyPreviewClose"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
                </div>
                <div class="composer-box">
                   <input type="text" id="msgInput" placeholder="Xabar yozing..." autocomplete="off" name="msg-text-field" spellcheck="false">
                </div>
            </div>

            <button class="icon-btn" id="composerEmojiBtn">
    <svg id="emojiBtnIconHappy" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
    <svg id="emojiBtnIconSad" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M16 16s-1.5-2-4-2-4 2-4 2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
</button>

            <button class="send-btn" id="sendBtn">
                <svg id="sendBtnIconSend" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                <svg id="sendBtnIconMic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
            </button>
        </div>

        <div class="open-chat-bar" id="openChatBar" style="display:none;">Suhbatni ochish</div>
    </main>

    <!-- ================= SIDE PANEL ================= -->
    <aside class="side-panel hidden" id="sidePanel">
        <div class="sp-tabs">
            <button class="sp-tab active" data-tab="emoji">Emoji</button>
            <button class="sp-tab" data-tab="stickers">Stikerlar</button>
            <button class="sp-tab" data-tab="gifs">GIF</button>
        </div>

        <div class="sp-search">
    <svg viewBox="0 0 24 24" fill="#26d1e1"><path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 1 0-.7.7l.27.28v.79l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"></path></svg>
    <input type="text" id="spSearchInput" placeholder="Qidirish">
</div>

        <div class="sp-content">
                 <div id="paneEmoji">
    <div class="emoji-cat-scroll" id="emojiCatScroll"></div>
</div>

            <div class="sp-placeholder" id="paneStickers">
                <svg viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3v4a2 2 0 0 0 2 2h4"></path><path d="M17 21H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z"></path></svg>
                Stikerlar to'plami hozircha yo'q
            </div>

                      <div id="paneGifs" style="display:none; flex-direction:column; height:100%;">
                <div class="gif-grid" id="gifGrid" style="display:grid; grid-template-columns:repeat(2,1fr); gap:6px;"></div>
                <div class="csp-loading" id="gifLoading" style="display:none; padding:20px;"><span class="csp-spinner"></span><span>Yuklanmoqda...</span></div>
                <div class="sp-placeholder" id="gifEmpty" style="display:none;">
                    <svg viewBox="0 0 24 24" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>
                    GIF topilmadi
                </div>
            </div>
        </div>
       </aside>
    <aside class="saved-info-panel hidden" id="savedInfoPanel">
        <div class="saved-info-head">
            <div>
                <h3>Saqlangan xabarlar</h3>
                <span id="savedInfoChatsCount">0 chat</span>
            </div>
            <button class="saved-info-close" id="savedInfoCloseBtn"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="saved-info-stats" id="savedInfoStats"></div>
        <div class="saved-info-chats" id="savedInfoChats"></div>


        <div class="saved-media-view" id="savedMediaView">
    <div class="smv-head">
        <button class="smv-btn" id="smvBack" type="button">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        </button>
        <span class="smv-title" id="smvTitle">Rasmlar</span>
        <button class="smv-btn" type="button">
            <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="19" r="2"></circle></svg>
        </button>
    </div>
    <div class="smv-body" id="smvBody"></div>
</div>
    </aside>

    <aside class="contact-info-panel hidden" id="contactInfoPanel">
        <div class="cip-close-wrap">
            <button class="saved-info-close" id="contactInfoCloseBtn"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="cip-scroll">
            <div class="cip-avatar-wrap">
                <div class="cip-avatar" id="cipAvatar"></div>
                <div class="cip-name" id="cipName"></div>
                <div class="cip-status" id="cipStatus"></div>
            </div>
<div class="cip-actions-row">
    <button class="cip-action-btn" id="cipMessageBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path></svg>
        <span>Xabar</span>
    </button>
    <button class="cip-action-btn" id="cipMuteBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        <span>Ovozsiz</span>
    </button>
    <button class="cip-action-btn" id="cipGiftBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="18" height="4"></rect><path d="M12 8v13"></path><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path><path d="M7.5 8a2.5 2.5 0 0 1 0-5C11 3 12 8 12 8"></path><path d="M16.5 8a2.5 2.5 0 0 0 0-5C13 3 12 8 12 8"></path></svg>
        <span>Sovg'alar</span>
    </button>
</div>

                   <div class="cip-info-block" id="cipInfoBlock"></div>

       <div class="saved-info-stats" id="cipStatsBlock"></div>
        </div>
    </aside>

    <aside class="channel-info-panel hidden" id="channelInfoPanel">
        <div class="cip-close-wrap">
            <button class="saved-info-close" id="channelInfoCloseBtn"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
     <div class="cip-scroll">
    <div id="channelInfoBody"></div>
    <div class="saved-info-stats" id="channelStatsBlock"></div>
    <div id="channelBottomBlock"></div>
</div>
    </aside>
</div>


<div class="doc-open-overlay" id="docOpenOverlay">
    <div class="doc-open-box">
        <div class="doc-open-header">
            <div class="doc-open-icon" id="docOpenIcon">FILE</div>
            <div class="doc-open-header-text">
                <div class="doc-open-name" id="docOpenName"></div>
                <div class="doc-open-meta" id="docOpenMeta"></div>
            </div>
        </div>
        <div class="doc-open-hint">Ushbu faylni ochish uchun mos dastur kerak bo'lishi mumkin. Agar qurilmangizda mos ilova bo'lmasa, uni Play Market yoki App Store orqali o'rnatib oling.</div>
        <div class="doc-open-actions">
            <button class="doc-open-primary" id="docOpenConfirm" type="button">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Baribir ochish / yuklab olish
            </button>
            <a class="doc-open-secondary" id="docOpenStoreLink" href="#" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                Ilova o'rnatish
            </a>
        </div>
    </div>
</div>


<div class="doc-open-overlay" id="comingSoonOverlay">
    <div class="doc-open-box" style="text-align:center;">
        <div class="doc-open-header" style="justify-content:center; margin-bottom:10px;">
            <div class="doc-open-icon" style="background:rgba(45,212,191,.16); color:var(--accent); width:56px; height:56px; border-radius:50%; font-size:22px;">💬</div>
        </div>
        <div class="doc-open-header-text" style="text-align:center; margin-bottom:16px;">
            <div class="doc-open-name" style="font-size:16px; -webkit-line-clamp:1;">ChatO'VBS Desktop</div>
            <div class="doc-open-meta">Versiya 1.0.0</div>
        </div>
        <div class="doc-open-hint" style="text-align:center;">
            Ushbu bo'lim hozircha faol emas — biz ustida ishlamoqdamiz. Tez orada, <b>1.0.1</b> versiyasida bu funksiya to'liq ishga tushiriladi. Yangilanishlarni kuzatib boring!
        </div>
        <div class="doc-open-actions">
            <button class="doc-open-primary" id="comingSoonOk" type="button">Tushunarli</button>
        </div>
    </div>
</div>



<div class="doc-open-overlay" id="storyViewerOverlay" style="z-index:310; background:rgba(0,0,0,0.92);">
    <div style="width:min(420px,94vw); height:98vh; max-height:98vh; position:relative; border-radius:10px; overflow:hidden; background:#111;">
        <div style="position:absolute; top:8px; left:8px; right:8px; z-index:5; display:flex; gap:2px;" id="storyProgressWrap"></div>        <div style="position:absolute; top:20px; left:12px; right:12px; z-index:5; display:flex; align-items:center; gap:8px;">
            <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;background:#4b9bea;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:13px;flex-shrink:0;" id="storyViewerAvatar"></div>
            <div style="flex:1;min-width:0;color:#fff;">
                <div style="font-size:13.5px;font-weight:700;display:flex;align-items:center;gap:6px;">
                    <span id="storyViewerName"></span>
                    <span id="storyViewerCounter" style="font-weight:500;opacity:0.7;font-size:12px;"></span>
                </div>
                <div style="font-size:11.5px;opacity:0.75;" id="storyViewerTime"></div>
            </div>
            <button id="storyViewerPauseBtn" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:6px;display:flex;">
                <svg id="storyPauseIcon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><rect x="6" y="5" width="4" height="14"></rect><rect x="14" y="5" width="4" height="14"></rect></svg>
                <svg id="storyPlayIcon" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" style="display:none;"><path d="M8 5.5v13l10-6.5z"></path></svg>
            </button>
                     <button id="storyViewerMuteBtn" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:6px;display:none;">
                <svg id="storyMuteOnIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                <svg id="storyMuteOffIcon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path><path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path></svg>
            </button>
            <button id="storyViewerClose" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:6px;display:flex;">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div id="storyViewerMediaWrap" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#000;">
            <img id="storyViewerImage" src="" style="max-width:100%;max-height:100%;display:none;object-fit:contain;">
            <video id="storyViewerVideo" style="max-width:100%;max-height:100%;display:none;object-fit:contain;" playsinline></video>
        </div>
        <div id="storyViewerCaption" style="position:absolute; left:12px; right:12px; bottom:74px; color:#fff; font-size:13.5px; text-shadow:0 1px 3px rgba(0,0,0,0.6); z-index:5;"></div>
        <button id="storyViewerPrevZone" style="position:absolute; top:0; bottom:64px; left:0; width:35%; background:none; border:none; cursor:pointer;"></button>
        <button id="storyViewerNextZone" style="position:absolute; top:0; bottom:64px; right:0; width:35%; background:none; border:none; cursor:pointer;"></button>

        <div style="position:absolute; left:0; right:0; bottom:0; z-index:6; display:flex; align-items:center; gap:8px; padding:12px 14px; background:linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.6));">
            <input type="text" id="storyReplyInput" placeholder="Reply privately..." autocomplete="off" style="flex:1; min-width:0; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.25); border-radius:20px; padding:9px 14px; color:#fff; font-family:'Inter',sans-serif; font-size:13px; outline:none;">
            <button id="storyReactBtn" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:4px;display:flex;flex-shrink:0;">
                <svg id="storyHeartIcon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"></path></svg>
            </button>
            <button id="storyEmojiBtn" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:4px;display:flex;flex-shrink:0;">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
            </button>
            <button id="storyMicBtn" type="button" style="background:none;border:none;color:#fff;cursor:pointer;padding:4px;display:flex;flex-shrink:0;">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line></svg>
            </button>
        </div>
    </div>
</div>

<div class="lightbox-overlay" id="lightboxOverlay">
    <button class="lightbox-close" id="lightboxClose" type="button">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <button class="lightbox-download" id="lightboxDownload" type="button">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
    </button>
    <button class="lightbox-nav lightbox-prev" id="lightboxPrev" type="button">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    <button class="lightbox-nav lightbox-next" id="lightboxNext" type="button">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
    <img class="lightbox-image" id="lightboxImage" src="" alt="">
    <video class="lightbox-video" id="lightboxVideo" controls playsinline></video>
    <div class="lightbox-footer">
        <div class="lightbox-footer-info">
            <b id="lightboxSender"></b>
            <span id="lightboxTime"></span>
        </div>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>
</div>


<div class="image-preview-overlay" id="imagePreviewOverlay">
    <div class="image-preview-box">
        <div class="image-preview-header">Rasm yuborish</div>
        <div class="image-preview-img-wrap">
            <img id="imagePreviewImg" src="" alt="">
        </div>
        <input type="text" id="imagePreviewCaption" placeholder="Izoh qo'shish...">
        <div class="image-preview-actions">
            <button id="imagePreviewCancel" type="button">Bekor qilish</button>
            <button id="imagePreviewSend" type="button">Yuborish</button>
        </div>
    </div>
</div>



<!-- message context menu (Reply / Edit / Pin / Copy Text / Forward / Delete / Select) -->
<div class="dropdown-menu" id="msgContextMenu">
    <button id="mcReply"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg><span>Reply</span></button>
    <button id="mcEdit"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"></path></svg><span>Edit</span></button>
    <button id="mcPin"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14l-1.4-7L21 7l-3-3-3 3-7-1.4L6 12z"></path></svg><span>Pin</span></button>
    <button id="mcCopy"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy Text</span></button>
    <button id="mcForward"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 17 20 12 15 7"></polyline><path d="M4 18v-2a4 4 0 0 1 4-4h12"></path></svg><span>Forward</span></button>
    <button id="mcDelete" class="danger"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg><span>Delete</span></button>
    <button id="mcSelect"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Select</span></button>
</div>




<!-- Efir/Voice chat menyusi -->
<div class="dropdown-menu" id="voiceChatMenu">
    <button id="vcStart">
        <svg width="21" height="21" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"></polygon></svg>
        <span>Efirni boshlash</span>
    </button>
    <button id="vcSchedule">
        <svg width="21" height="21" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15 14"></polyline></svg>
        <span>Efirni rejalashtirish</span>
    </button>
    <button id="vcStreamWith">
        <svg width="21" height="21" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.6" fill="currentColor" stroke="none"></circle><path d="M8.2 9.8a5.5 5.5 0 0 0 0 4.4"></path><path d="M15.8 9.8a5.5 5.5 0 0 1 0 4.4"></path><path d="M5 6.5a9.5 9.5 0 0 0 0 11"></path><path d="M19 6.5a9.5 9.5 0 0 1 0 11"></path></svg>
        <span>... bilan efir</span>
    </button>
</div>

<!-- Chat-list item uchun kontekst menyu (o'ng tugma) -->
<div class="dropdown-menu" id="itemContextMenu">
    <button data-action="openWindow">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
        <span>Yangi oynada ochish</span>
    </button>

    <div class="dropdown-sep"></div>

    <button data-action="archive" id="itemArchiveBtn">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="4" rx="1"></rect><path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"></path><line x1="10" y1="13" x2="14" y2="13"></line></svg>
        <span id="itemArchiveLabel">Arxivlash</span>
    </button>

    <button data-action="pin">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="17" x2="12" y2="22"></line><path d="M5 17h14l-1.4-7L21 7l-3-3-3 3-7-1.4L6 12z"></path></svg>
        <span id="itemPinLabel">Qadash</span>
    </button>

 <!-- ESKISI O'RNIGA -->
<div class="dropdown-submenu-wrap" id="muteSubmenuWrap">
    <button type="button" id="itemMuteBtn">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
        <span id="itemMuteLabel">Ovozsiz qilish</span>
        <svg class="dropdown-chevron" id="muteChevron" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><polyline points="9 6 15 12 9 18"></polyline></svg>
    </button>
    <div class="dropdown-menu dropdown-submenu" id="muteSubmenu">
        <button type="button" data-mute-option="tone">
            <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
            <span>Ovoz balandligini tanlash</span>
        </button>
        <button type="button" data-mute-option="disable">
            <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path><line x1="3" y1="3" x2="21" y2="21"></line></svg>
            <span>Ovozni o'chirish</span>
        </button>
        <button type="button" data-mute-option="for">
            <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15 14"></polyline></svg>
            <span>Vaqtinchalik ovozsiz...</span>
        </button>
        <button type="button" data-mute-option="forever" class="danger">
            <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span>Butunlay ovozsiz</span>
        </button>
    </div>
</div>

    <button data-action="toggleRead">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path><circle cx="12" cy="11.5" r="1.6" fill="currentColor" stroke="none"></circle></svg>
        <span id="itemReadLabel">O'qilmagan deb belgilash</span>
    </button>

      <div class="dropdown-submenu-wrap" id="folderSubmenuWrap">
        <button type="button" id="folderMenuBtn">
            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
            <span>Papkaga qo'shish</span>
            <svg class="dropdown-chevron" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"><polyline points="9 6 15 12 9 18"></polyline></svg>
        </button>
        <div class="dropdown-menu dropdown-submenu" id="folderSubmenu">
            <button type="button" data-folder="unread">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path></svg>
                <span>Unread</span>
            </button>
            <button type="button" data-folder="personal">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21v-1a8 8 0 0 1 16 0v1"></path></svg>
                <span>Personal</span>
            </button>
            <div class="dropdown-sep"></div>
            <button type="button" data-folder="__new">
                <svg viewBox="0 0 24 24" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
                <span>Create new folder</span>
            </button>
        </div>
    </div>

    <div class="dropdown-sep" id="itemBlockSep"></div>
    <button data-action="block" id="itemBlockBtn">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><line x1="5.5" y1="5.5" x2="18.5" y2="18.5"></line></svg>
        <span>Foydalanuvchini blocklash</span>
    </button>

    <div class="dropdown-sep"></div>
    <button data-action="clearHistory">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path></svg>
        <span>Tarixni tozalash</span>
    </button>

    <button data-action="danger" class="danger" id="itemDangerBtn">
        <svg id="itemDangerIcon" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></svg>
        <span id="itemDangerLabel">Suhbatni o'chirish</span>
    </button>
</div>


<div class="delete-confirm-overlay" id="deleteConfirmOverlay">
    <div class="delete-confirm-box">
        <p id="deleteConfirmText">Xabarni o'chirmoqchimisiz?</p>
        <label class="delete-confirm-also" id="deleteConfirmAlsoWrap" style="display:none;">
            <span class="dc-check" id="dcCheckIcon">
                <svg viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </span>
            <span><b id="deleteConfirmRecipient"></b> uchun ham o'chirilsin</span>
        </label>
        <div class="delete-confirm-actions">
            <button id="deleteConfirmCancel">Bekor qilish</button>
            <button id="deleteConfirmOk">O'chirish</button>
        </div>
    </div>
</div>

<!-- ⬇⬇⬇ SHU YERGA QO'SHING ⬇⬇⬇ -->
<div class="delete-confirm-overlay" id="clearHistoryConfirmOverlay">
    <div class="delete-confirm-box">
        <p>Qidiruv tarixini tozalamoqchimisiz?</p>
        <div class="delete-confirm-actions">
            <button id="clearHistoryCancel">Bekor qilish</button>
            <button id="clearHistoryOk">OK</button>
        </div>
    </div>
</div>
<!-- ⬆⬆⬆ SHU YERGACHA ⬆⬆⬆ -->





<!-- Telegram uslubidagi umumiy dialog (tarixni tozalash / tark etish) -->
<div class="tg-dialog-overlay" id="tgDialogOverlay">
    <div class="tg-dialog" id="tgDialog">
        <div class="tg-dialog-head" id="tgDialogHead" style="display:none;">
            <div class="tg-dialog-avatar" id="tgDialogAvatar"></div>
            <div class="tg-dialog-title" id="tgDialogTitle"></div>
        </div>
        <div class="tg-dialog-text" id="tgDialogText"></div>
        <div class="tg-dialog-checks" id="tgDialogChecks"></div>
        <button type="button" class="tg-dialog-link" id="tgDialogAutoDelete">Avto-o'chirishni yoqish</button>
        <div class="tg-dialog-actions">
            <button type="button" id="tgDialogCancel">Bekor qilish</button>
            <button type="button" id="tgDialogOk">OK</button>
        </div>
    </div>
</div>

<!-- ================= MAIN MENU FLYOUT ================= -->
<div class="main-menu-overlay" id="mainMenuOverlay">
    <div class="main-menu" id="mainMenu">
        <div class="mm-header">
            <div class="mm-avatar">
                @if (auth()->user()->avatar ?? false)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}?v={{ optional(auth()->user()->updated_at)->timestamp }}" alt="{{ auth()->user()->name ?? 'Avatar' }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name ?? 'F', 0, 1)) }}
                @endif
            </div>
            <div class="mm-header-row">
                <div style="min-width:0;">
                    <span class="mm-name">{{ auth()->user()->name ?? 'Foydalanuvchi' }}</span>
                    <span class="mm-status" id="mmSetStatus">Emoji status qo'yish</span>
                </div>
               
            </div>
        </div>

        <div class="mm-items">
            <div class="mm-item" id="mmProfile" data-href="{{ route('profile.edit') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"></circle><path d="M4 21v-1a8 8 0 0 1 16 0v1"></path></svg>
                <span data-i18n="mmProfile">Mening profilim</span>
            </div>
            <div class="mm-item" id="mmWallet" data-href="{{ route('wallet') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="14" rx="2"></rect><path d="M2 10h20"></path></svg>
                <span data-i18n="mmWallet">Hamyon</span>
            </div>
        </div>

        <div class="mm-items">
            <div class="mm-item" id="mmNewGroup" data-href="{{ route('groups.create') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span data-i18n="mmNewGroup">Yangi guruh</span>
            </div>
            <div class="mm-item" id="mmNewChannel" data-href="{{ route('channels.create') }}">
    <svg viewBox="0 0 16 16" fill="currentColor">
        <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 75 75 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0m-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233q.27.015.537.036c2.568.189 5.093.744 7.463 1.993zm-9 6.215v-4.13a95 95 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A61 61 0 0 1 4 10.065m-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68 68 0 0 0-1.722-.082z"></path>
    </svg>
    <span data-i18n="mmNewChannel">Yangi kanal</span>
</div>
            <div class="mm-item" id="mmContacts" data-href="{{ route('contacts') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span data-i18n="mmContacts">Kontaktlar</span>
            </div>
            <div class="mm-item" id="mmCalls" data-href="{{ route('calls') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <span data-i18n="mmCalls">Qo'ng'iroqlar</span>
            </div>
            <div class="mm-item" id="mmSaved">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                <span data-i18n="mmSaved">Saqlangan xabarlar</span>
            </div>
        </div>

        <div class="mm-items">
            <div class="mm-item" id="mmSettings" data-href="{{ route('settings') }}">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span data-i18n="mmSettings">Sozlamalar</span>
            </div>
            <div class="mm-item" id="mmNightMode">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                <span data-i18n="mmNightMode">Tungi rejim</span>
                <span class="mm-item-toggle" id="mmNightModeToggle"></span>
            </div>
        </div>

        <div class="mm-items">
            <div class="mm-item mm-item-danger" id="mmLogout">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Chiqish</span>
            </div>
        </div>

        <div class="mm-footer">
            <b>ChatO'VBS Desktop</b>
            <span>Versiya 1.0.0</span>
        </div>
    </div>
</div>

@if(Route::has('logout'))
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
@endif
@include('partials.apply-settings')
<script src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/16.0.1/twemoji.min.js" crossorigin="anonymous"></script>


<script>
(function () {
    var COLORS = { amber:'#e0a83e', teal:'#2dd4bf', blue:'#4b9bea', violet:'#a78bfa', rose:'#f472b6', green:'#34d399' };
    function inkFor(hex) {
        var n = parseInt(hex.replace('#', ''), 16) || 0;
        var lum = (0.299 * ((n >> 16) & 255) + 0.587 * ((n >> 8) & 255) + 0.114 * (n & 255)) / 255;
        return lum > 0.55 ? '#171310' : '#ffffff';
    }
    function applyAccent() {
        var root = document.documentElement, val = 'default', custom = '#e0a83e';
        try {
                       val = localStorage.getItem('chatovbs_accent_color_{{ auth()->id() }}') || 'default';
            custom = localStorage.getItem('chatovbs_accent_custom_{{ auth()->id() }}') || custom;
        } catch (e) {}
        var hex = val === 'custom' ? custom : COLORS[val];
        if (hex && !/^#[0-9a-f]{6}$/i.test(hex)) hex = null;

        ['--accent', '--accent-ink', '--out-bg', '--out-fg'].forEach(function (p) { root.style.removeProperty(p); });
        root.classList.toggle('has-accent', !!hex);
        if (!hex) return; // "Standart": homening o'z ko'rinishi qoladi

        var ink = inkFor(hex);
        root.style.setProperty('--accent', hex);
        root.style.setProperty('--accent-ink', ink);
        root.style.setProperty('--out-bg', hex);
        root.style.setProperty('--out-fg', ink);
    }
    applyAccent();
    window.addEventListener('storage', applyAccent);
})();
</script>


<script>


(function () {
     function applyTwemoji(container) {
        if (!window.twemoji || !container) return;
        twemoji.parse(container, {
            className: 'emoji',
            callback: function (icon, options) {
                var codepoints = icon.split('-').map(function (cp) { return parseInt(cp, 16); });
                var emojiChar = String.fromCodePoint.apply(null, codepoints);
                return 'https://emoji-cdn.mqrio.dev/' + encodeURIComponent(emojiChar) + '?style=telegram';
            }
        });
        container.querySelectorAll('img.emoji').forEach(function (img) {
            img.addEventListener('error', function onErr() {
                img.removeEventListener('error', onErr);
                var fallbackCode = twemoji.convert.toCodePoint(img.alt || '');
                img.src = 'https://cdn.jsdelivr.net/gh/twitter/twemoji@16.0.1/assets/svg/' + fallbackCode + '.svg';
            }, { once: true });
        });
    }

     // ---------- Rail tab switching ----------
    var railItems = document.querySelectorAll('.rail-item');
   var currentFilter = 'all'; // sahifa ochilganda default faol tab

    var railTabFilterMap = {
        tabAllChats: 'all',
        tabUnread: 'unread',
        tabPersonal: 'personal'
    };

 railItems.forEach(function (item) {
    item.addEventListener('click', function () {
        railItems.forEach(function (i) { i.classList.remove('active'); });
        item.classList.add('active');

        var mapped = railTabFilterMap[item.id];
        if (mapped) {
            currentFilter = mapped;
            filterChatItems(currentFilter);
        }
    });
});

       // ---------- Chat list switching (works once real chats are rendered) ----------
    var cmName = document.getElementById('cmName');
    var cmStatus = document.getElementById('cmStatus');
    var cmAvatar = document.getElementById('cmAvatar');
    var chatItemsWrap = document.getElementById('chatItems');

    // ---------- Qidiruv paneli (lokal chatlar + global/backend foydalanuvchi qidiruvi) ----------
    var clSearchInput = document.getElementById('clSearchInput');
    var clSearchBox = document.getElementById('clSearchBox');
    var clSearchClear = document.getElementById('clSearchClear');
    var clSearchPanel = document.getElementById('clSearchPanel');
    var cspHint = document.getElementById('cspHint');
    var cspEmpty = document.getElementById('cspEmpty');
    var cspResults = document.getElementById('cspResults');
    var cspLoading = document.getElementById('cspLoading');
    var cspGlobalSection = document.getElementById('cspGlobalSection');
    var cspGlobalResults = document.getElementById('cspGlobalResults');

     var cspTabEmpty = document.getElementById('cspTabEmpty');
    var cspTabEmptyText = document.getElementById('cspTabEmptyText');
    var currentSearchTab = 'chats';

    var tabEmptyMessages = {
        messages: "Postlar bo'yicha qidiruv hozircha mavjud emas",
        photos: "Rasmlar bo'yicha qidiruv hozircha mavjud emas",
        videos: "Videolar bo'yicha qidiruv hozircha mavjud emas",
        files: "Fayllar bo'yicha qidiruv hozircha mavjud emas",
        links: "Havolalar bo'yicha qidiruv hozircha mavjud emas",
        music: "Musiqa bo'yicha qidiruv hozircha mavjud emas",
        voice: "Ovozli xabarlar bo'yicha qidiruv hozircha mavjud emas"
    };

document.getElementById('cspTabs').addEventListener('click', function (e) {
    var btn = e.target.closest('.csp-tab-btn');
    if (!btn) return;
    document.querySelectorAll('.csp-tab-btn').forEach(function (b) { b.classList.remove('active'); });
    btn.classList.add('active');
    currentSearchTab = btn.dataset.tab;
    btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    runSearch(clSearchInput.value);
});

    var searchDebounce = null;
    var searchAbortController = null;
    var searchRequestUrl = "{{ Route::has('search.users') ? route('search.users') : '' }}";
    var presenceUrl = "{{ route('presence.heartbeat') }}";
        var csrfToken = "{{ csrf_token() }}";

    function sendPresenceHeartbeat() {
        fetch(presenceUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).catch(function () {});
    }
    sendPresenceHeartbeat();
    setInterval(sendPresenceHeartbeat, 60000);
    var messageBaseUrl = "{{ url('/messages') }}";
    var chatListUrl = "{{ url('/chat-list') }}";
    var notificationFeedUrl = "{{ route('notifications.feed') }}";
    var savedMessagesUrl = "{{ url('/saved-messages/data') }}";
    var entityMessagesBaseUrl = "{{ url('/entity-messages') }}";
    var publicChannelMessagesUrl = "{{ url('/public-channel-messages') }}";
        var userStoriesUrlBase = "{{ url('/users') }}"; // + '/' + userId + '/stories'
    var entityChatsBaseUrl = "{{ url('/entity-chats') }}";
    var savedMessagesDeleteBaseUrl = "{{ url('/saved-messages') }}";
    var currentUserId = {{ auth()->id() }};
        var currentUserName = "{{ addslashes(auth()->user()->name ?? 'Siz') }}";
       var activeRecipientId = null;
    var activeEntityId = null;
    var activeIsDiscussionChat = false;
    var activeRecipientUser = null;
    var activeRecipientProfile = null;
    var viewToken = 0;
    var renderedMessageIds = [];
    var activeEntityUnreadIds = [];


        var entityViewReady = false;

    function messageKey(m) { return (m.is_channel_post ? 'p:' : 'm:') + m.id; }
    function msgTs(m) { var t = new Date(m.created_at).getTime(); return isNaN(t) ? 0 : t; }
    function isOwnEntityMessage(m) { return m.sender_id === currentUserId && !m.is_channel_post; }
        function isSelfSent(m) { return m.sender_id === currentUserId; }
function isSelfSentIn(m, isChat) { return m.sender_id === currentUserId && !(isChat && m.is_channel_post); }


var pendingUploads = 0;
function showPending(fields, opts) {
    var tmp = Object.assign({
        id: 'tmp-' + Date.now() + Math.random().toString(36).slice(2, 6),
        sender_id: currentUserId, body: '', read_at: null,
        created_at: new Date().toISOString()
    }, fields);
    appendMessage(tmp, opts);
    var row = cmMessages.querySelector('.msg-row[data-message-key="' + messageKey(tmp) + '"]');
    if (row) row.classList.add('is-pending');
    cmMessages.scrollTop = cmMessages.scrollHeight;
    pendingUploads++;
    return tmp;
}
function finishPending(tmp) {
    pendingUploads = Math.max(0, pendingUploads - 1);
    var key = messageKey(tmp);
    var row = cmMessages.querySelector('.msg-row[data-message-key="' + key + '"]');
    if (row) row.remove();
    var i = renderedMessageIds.indexOf(key);
    if (i > -1) renderedMessageIds.splice(i, 1);
    if (tmp.file_url) URL.revokeObjectURL(tmp.file_url);
    if (tmp.audio_url) URL.revokeObjectURL(tmp.audio_url);
}


    function currentEntityScope() {
        return activeEntityId ? activeEntityId + ':' + (activeIsDiscussionChat ? 'chat' : 'channel') : '';
    }
    function sortEntityMessages(list) {
        return list.map(function (m, i) { return { m: m, i: i }; })
            .sort(function (a, b) { return (msgTs(a.m) - msgTs(b.m)) || (a.i - b.i); })
            .map(function (x) { return x.m; });
    }
    function entityMsgOpts(message) {
        if (!activeChannelOpts || !activeChannelOpts.forceIn) return activeChannelOpts;
        if (message.is_channel_post && activeChannelOpts.forwardOpts) return activeChannelOpts.forwardOpts;
        return isOwnEntityMessage(message) ? { forceOut: true } : { forceIn: true };
    }
    function captureView() {
        return { entityId: activeEntityId, isChat: activeIsDiscussionChat, userId: activeRecipientId, internal: activeInternalView };
    }
    function isSameView(s) {
        return s.entityId === activeEntityId && s.isChat === activeIsDiscussionChat &&
               s.userId === activeRecipientId && s.internal === activeInternalView;
    }

 var PIN_SVG = '<svg viewBox="0 0 24 24"><path d="M16 3a1 1 0 0 1 .7 1.7L15.4 6l1.8 5.4 1.5 1.5a1 1 0 0 1-.7 1.7H13v5.4a1 1 0 0 1-2 0v-5.4H6a1 1 0 0 1-.7-1.7l1.5-1.5L8.6 6 7.3 4.7A1 1 0 0 1 8 3z"></path></svg>';

function syncPinIcon(item, pinned) {
    var row = item.querySelector('.cl-row2');
    if (!row) return;
    var icon = row.querySelector('.cl-pin');
    if (pinned && !icon) {
        icon = document.createElement('span');
        icon.className = 'cl-pin';
        icon.innerHTML = PIN_SVG;
        row.appendChild(icon);
    } else if (!pinned && icon) {
        icon.remove();
    }
}

function sortChatItems() {
    var items = Array.prototype.slice.call(chatItemsWrap.querySelectorAll('.cl-item'));
    var meta = new Map();
    items.forEach(function (item) {
        var st = getItemState(item);
        meta.set(item, { pinned: !!st.pinned, pinnedAt: Number(st.pinnedAt) || 0 });
        syncPinIcon(item, !!st.pinned);
    });
    items.sort(function (a, b) {
        var ma = meta.get(a), mb = meta.get(b);
        if (ma.pinned !== mb.pinned) return ma.pinned ? -1 : 1;           // qadalganlar tepada
        if (ma.pinned && mb.pinned) return mb.pinnedAt - ma.pinnedAt;      // oxirgi qadalgan eng tepada
        return (Number(b.dataset.lastMessageAt) || 0) - (Number(a.dataset.lastMessageAt) || 0);
    }).forEach(function (item) { chatItemsWrap.appendChild(item); });
}




/* ================= BILDIRISHNOMALAR ================= */
var NOTIF_PREFS_KEY = 'chatovbs_notif_prefs';
var notifSeen = {};
var notifStacks = {};
var notificationFeedCursor = Date.now();
var notificationFeedSeen = {};
var notificationFeedInFlight = false;
var chatListReady = false;
function shouldPollForNotifications() {
    return document.visibilityState === 'visible' || !!getNotifPrefs().notifications;
}

function getNotifPrefs() {
    var d = { notifications: true, sound: true, notif_preview: true, notif_show_sender: true, notif_show_avatar: true,
              notif_system: false, group_notifications: true, notif_position: 'bottom-right', notif_style: 'card', notif_duration: 6 };
    try {
        var s = JSON.parse(localStorage.getItem(NOTIF_PREFS_KEY) || '{}');
        Object.keys(s).forEach(function (k) { d[k] = s[k]; });
    } catch (e) {}
    return d;
}

function notifBeep() {
    try {
        var C = window.AudioContext || window.webkitAudioContext, ctx = new C(), o = ctx.createOscillator(), g = ctx.createGain();
        o.type = 'sine'; o.frequency.setValueAtTime(880, ctx.currentTime); o.frequency.exponentialRampToValueAtTime(1320, ctx.currentTime + .12);
        g.gain.setValueAtTime(.0001, ctx.currentTime); g.gain.exponentialRampToValueAtTime(.18, ctx.currentTime + .02); g.gain.exponentialRampToValueAtTime(.0001, ctx.currentTime + .35);
        o.connect(g); g.connect(ctx.destination); o.start(); o.stop(ctx.currentTime + .36);
    } catch (e) {}
}

function notifMessageText(m) {
    if (!m) return '';
    if (m.audio_url) return 'Ovozli xabar';
    if (m.file_url) {
        var mime = m.file_mime || '';
        if (mime.indexOf('image/gif') === 0) return 'GIF';
        if (mime.indexOf('image/') === 0) return 'Rasm';
        if (mime.indexOf('video/') === 0) return 'Video';
        return m.file_name || 'Fayl';
    }
    return m.body || '';
}

function showChatToast(data) {
    var p = getNotifPrefs();
    var pos = p.notif_position, style = p.notif_style, dur = Number(p.notif_duration) || 6;
    var stack = notifStacks[pos];
    if (!stack) {
        stack = document.createElement('div');
        stack.className = 'ct-stack pos-' + pos;
        document.body.appendChild(stack);
        notifStacks[pos] = stack;
    }
    var name = p.notif_show_sender ? data.title : "ChatO'VBS";
    var text = p.notif_preview ? data.text : 'Yangi xabar';
    var t = document.createElement('div');
    t.className = 'ct' + (style === 'compact' ? ' ct--compact' : style === 'minimal' ? ' ct--minimal' : '');
    t.style.setProperty('--dur', dur + 's');

    var avatar = '';
    if (style === 'minimal') {
        avatar = '<span class="ct__av"></span>';
    } else if (p.notif_show_avatar) {
        avatar = '<span class="ct__av" style="background:' + (data.color || 'var(--accent)') + '">' +
            (data.avatarHtml || escapeHtml((name || '?').charAt(0).toUpperCase())) + '</span>';
    }
    t.innerHTML = avatar +
        '<div class="ct__body"><div class="ct__top"><span class="ct__name">' + escapeHtml(name || '') + '</span><span class="ct__time">' +
        escapeHtml(formatChatTime(new Date().toISOString())) + '</span></div><div class="ct__text">' + escapeHtml(text || '') + '</div></div>' +
        '<button type="button" class="ct__x" aria-label="Yopish">×</button><span class="ct__bar"></span>';

    function close() {
        if (t.classList.contains('is-out')) return;
        t.classList.add('is-out');
        setTimeout(function () { t.remove(); }, 230);
    }
    var timer = setTimeout(close, dur * 1000);
    t.addEventListener('mouseenter', function () { clearTimeout(timer); });
    t.addEventListener('mouseleave', function () { timer = setTimeout(close, 1500); });
    t.addEventListener('click', function () { close(); if (data.onClick) data.onClick(); });
    t.querySelector('.ct__x').addEventListener('click', function (e) { e.stopPropagation(); close(); });
    stack.appendChild(t);
    while (stack.children.length > 4) stack.firstChild.remove();
}

function notifySystem(title, body, onClick, iconUrl, tag) {
    if (!('Notification' in window) || Notification.permission !== 'granted') return;
    try {
        var options = { body: body, tag: tag || 'chatovbs' };
        if (iconUrl) options.icon = iconUrl;
        var n = new Notification(title, options);
        n.onclick = function () { window.focus(); n.close(); if (onClick) onClick(); };
    } catch (e) {}
}

function notifSeed(key, ts) {
    if (notifSeen[key] === undefined || ts > notifSeen[key]) notifSeen[key] = ts;
}

function notifTimestamp(message) {
    var time = new Date(message && message.created_at).getTime() || 0;
    var id = Number(message && message.id) || 0;
    return time + Math.min(id / 1000000000, 0.0009);
}

// key — suhbat kaliti, ts — xabar vaqti. Sahifa ochilgandagi eski xabarlar uchun bildirishnoma chiqmaydi.
function maybeNotify(key, ts, item, title, text, senderInfo) {
    var last = notifSeen[key];
    if (last === undefined) { notifSeen[key] = ts; return; }
    if (ts <= last) return;
    notifSeen[key] = ts;

    var p = getNotifPrefs();
    if (!p.notifications) return;
    if (item && getItemState(item).muted) return;
    var kind = item ? item.dataset.kind : 'personal';
    if (kind !== 'personal' && !p.group_notifications) return;
    var openIt = function () { window.focus(); if (item) item.click(); };
    var shownText = p.notif_preview ? text : 'Yangi xabar';
    var shownTitle = p.notif_show_sender ? title : "ChatO'VBS";

    if (!document.hidden) {
        var av = item ? item.querySelector('.cl-avatar') : null;
        var avatarHtml = senderInfo && senderInfo.avatarUrl
            ? '<img src="' + escapeHtml(senderInfo.avatarUrl) + '" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">'
            : (av ? av.innerHTML : '');
        showChatToast({ title: title, text: text, avatarHtml: avatarHtml, avatarUrl: senderInfo && senderInfo.avatarUrl, color: item ? item.dataset.color : '', onClick: openIt });
    }
    var avatarImage = item && item.querySelector('.cl-avatar img');
    var iconUrl = (senderInfo && senderInfo.avatarUrl) || (avatarImage ? avatarImage.src : null);
    if (p.notif_system && (document.hidden || !document.hasFocus())) notifySystem(shownTitle, shownText, openIt, iconUrl, 'chatovbs-' + key);
    if (p.sound) notifBeep();
}

function pollNotificationFeed() {
    if (!chatListReady || notificationFeedInFlight || !shouldPollForNotifications()) return;
    notificationFeedInFlight = true;
    var cursor = notificationFeedCursor;
    var requestStartedAt = Date.now();

    fetch(notificationFeedUrl + '?after=' + encodeURIComponent(cursor), { headers: { 'Accept': 'application/json' } })
        .then(function (response) {
            if (!response.ok) throw new Error('Notification feed request failed');
            return response.json();
        })
        .then(function (data) {
            (data.events || []).forEach(function (event) {
                var message = event.message || {};
                var type = event.type || 'personal';
                var senderId = Number(message.sender_id) || 0;
                var messageId = String(message.id || '');
                if (!messageId || senderId === currentUserId) return;

                var seenKey = type + ':' + (event.user ? event.user.id : (event.entity ? event.entity.id : '')) + ':' + messageId;
                if (notificationFeedSeen[seenKey]) return;
                notificationFeedSeen[seenKey] = true;

                if (type === 'personal' && event.user) {
                    var userId = Number(event.user.id);
                    var notifKey = 'u:' + userId;
                    var timestamp = notifTimestamp(message);
                    if (notifSeen[notifKey] === undefined) notifSeed(notifKey, timestamp - 0.001);
                    var item = chatItemsWrap.querySelector('.cl-item[data-user-id="' + userId + '"]') || addUserToChatList(event.user);
                    var existingBadge = item.querySelector('.cl-unread');
                    var unreadCount = Number(existingBadge && existingBadge.textContent) || 0;
                    if (!message.read_at) unreadCount++;
                    updateChatListPreview(userId, message, unreadCount);
                    return;
                }

                if (event.entity) {
                    var entity = event.entity;
                    var entityId = String(entity.id);
                    var kind = type;
                    var entityKey = 'e:' + entityId + ':' + kind;
                    var entityTimestamp = notifTimestamp(message);
                    if (notifSeen[entityKey] === undefined) notifSeed(entityKey, entityTimestamp - 0.001);
                    var entityItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="' + kind + '"]') || addEntityToChatList(entity);
                    maybeNotify(entityKey, entityTimestamp, entityItem, event.sender_name || entity.name, notifMessageText(message), { avatarUrl: event.sender_avatar || null });
                    updateEntityListPreview(entityId, kind === 'chat');
                }
            });
            notificationFeedCursor = requestStartedAt;
        })
        .catch(function () {})
        .finally(function () { notificationFeedInFlight = false; });
}




    function applyPeerBubbleColor(hex) {
        if (!hex || !/^#[0-9a-f]{6}$/i.test(hex)) {
            cmMessages.classList.remove('has-peer-color');
            cmMessages.style.removeProperty('--peer-bg');
            cmMessages.style.removeProperty('--peer-fg');
            return;
        }
        var n = parseInt(hex.slice(1), 16);
        var lum = (0.299 * ((n >> 16) & 255) + 0.587 * ((n >> 8) & 255) + 0.114 * (n & 255)) / 255;
        cmMessages.style.setProperty('--peer-bg', hex);
        cmMessages.style.setProperty('--peer-fg', lum > 0.55 ? '#171310' : '#ffffff');
        cmMessages.classList.add('has-peer-color');
    }




    

function escapeHtml(s) {
    return String(s == null ? '' : s)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

      function linkifyText(text) {
        var escaped = escapeHtml(text || '');
        var urlRegex = /(https?:\/\/[^\s<]+|t\.me\/[^\s<]+|www\.[^\s<]+\.[a-z]{2,}[^\s<]*)/gi;
        return escaped.replace(urlRegex, function (match) {
            var href = match;
            if (!/^https?:\/\//i.test(href)) href = 'https://' + href;
            return '<a href="' + href + '" target="_blank" rel="noopener noreferrer" class="msg-link">' + match + '</a>';
        });
    }

    function highlight(text, query) {
        var idx = text.toLowerCase().indexOf(query.toLowerCase());
        if (idx === -1) return escapeHtml(text);
        return escapeHtml(text.slice(0, idx)) + '<mark>' + escapeHtml(text.slice(idx, idx + query.length)) + '</mark>' + escapeHtml(text.slice(idx + query.length));
    }

    function updateEmptyState(localCount, globalCount) {
        if (localCount === 0 && globalCount === 0) {
            cspEmpty.classList.add('show');
        } else {
            cspEmpty.classList.remove('show');
        }
    }

           function renderLocalResults(query) {
       
        var allItems = chatItemsWrap.querySelectorAll('.cl-item');
        var matches = [];
        allItems.forEach(function (item) {
            var searchable = [item.dataset.name, item.dataset.username, item.dataset.email].join(' ').toLowerCase();
            if (searchable.indexOf(query.toLowerCase().replace(/^@/, '')) !== -1) matches.push(item);
        });

        matches.forEach(function (item, i) {
            var avatarEl = item.querySelector('.cl-avatar');
            var avatarBg = avatarEl ? avatarEl.style.background : 'var(--ink-softer)';
            var avatarInner = avatarEl ? avatarEl.innerHTML : '';
            var row = document.createElement('div');
            row.className = 'csp-row';
            row.style.animationDelay = (i * 25) + 'ms';
            row.innerHTML =
                '<div class="csp-avatar" style="background:' + avatarBg + '">' + avatarInner + '</div>' +
                '<div class="csp-body">' +
                    '<div class="csp-name">' + highlight(item.dataset.name || '', query) + '</div>' +
                    '<div class="csp-sub">' + escapeHtml(item.dataset.status || '') + '</div>' +
                '</div>';
                        row.addEventListener('click', function () {
                var avatarElForHistory = item.querySelector('.cl-avatar');
                addToSearchHistory({
                    id: 'local-' + (item.dataset.userId || item.dataset.entityId || item.dataset.name),
                    userId: item.dataset.userId || null,
                    entityId: item.dataset.entityId || null,
                    name: item.dataset.name || '',
                    username: item.dataset.username || '',
                    email: item.dataset.email || '',
                    avatarBg: avatarElForHistory ? avatarElForHistory.style.background : 'var(--ink-softer)',
                    avatarHtml: avatarElForHistory ? avatarElForHistory.innerHTML : '',
                    avatarRaw: null
                });
                item.click();
                closeSearchPanel();
                clSearchInput.value = '';
                clSearchBox.classList.remove('has-text');
            });
            cspResults.appendChild(row);
        });

        return matches.length;
    }

function renderRecentChats() {
    cspResults.innerHTML = '';
    var items = Array.prototype.slice.call(chatItemsWrap.querySelectorAll('.cl-item'));
    if (!items.length) return 0;

    var savedItems = items.filter(function (i) { return i.dataset.kind === 'saved'; });
    var others = items.filter(function (i) { return i.dataset.kind === 'personal'; });
    var ordered = savedItems.concat(others);

    // ---- "Frequent contacts" header (och fonli) + grid (fonsiz) ----
    var freqHeader = document.createElement('div');
    freqHeader.className = 'csp-frequent-header';
    freqHeader.innerHTML =
        '<span class="csp-frequent-title">Tez-tez suhbatlashadiganlar</span>' +
        '<button class="csp-frequent-toggle" type="button" id="cspFreqToggle">Ko\'proq</button>';
    cspResults.appendChild(freqHeader);

    var freqRow = document.createElement('div');
    freqRow.className = 'csp-frequent';
    ordered.forEach(function (item) {
        var avatarEl = item.querySelector('.cl-avatar');
        var avatarBg = avatarEl ? avatarEl.style.background : 'var(--ink-softer)';
        var avatarInner = avatarEl ? avatarEl.innerHTML : '';
        var unreadBadge = item.querySelector('.cl-unread');
        var unreadCount = unreadBadge ? Number(unreadBadge.textContent) || 0 : 0;
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'csp-frequent-item';
        var shortName = (item.dataset.name || '').split(' ')[0];
        btn.innerHTML =
            '<div class="csp-frequent-avatar" style="background:' + avatarBg + '">' + avatarInner +
                (unreadCount > 0 ? '<span class="csp-frequent-badge" style="' + (unreadCount > 9 ? 'width:auto;padding:0 4px;' : '') + '">' + (unreadCount > 99 ? '99+' : unreadCount) + '</span>' : '')+
            '</div>' +
            '<span class="csp-frequent-name">' + escapeHtml(shortName) + '</span>';
        btn.addEventListener('click', function () {
            item.click();
            closeSearchPanel();
            clSearchInput.value = '';
            clSearchBox.classList.remove('has-text');
        });
        freqRow.appendChild(btn);
    });
    cspResults.appendChild(freqRow);

    var freqToggleBtn = document.getElementById('cspFreqToggle');
    if (ordered.length <= 5) {
        freqToggleBtn.style.display = 'none';
        freqRow.style.maxHeight = 'none';
    } else {
        requestAnimationFrame(function () {
            var firstItemEl = freqRow.querySelector('.csp-frequent-item');
            var oneRowHeight = firstItemEl ? firstItemEl.getBoundingClientRect().height : 76;
            freqRow.style.maxHeight = oneRowHeight + 'px';

            var isExpandedNow = false;
            freqToggleBtn.onclick = function () {
                isExpandedNow = !isExpandedNow;
                freqRow.style.maxHeight = isExpandedNow ? freqRow.scrollHeight + 'px' : oneRowHeight + 'px';
                freqToggleBtn.textContent = isExpandedNow ? 'Yig\'ish' : 'Ko\'proq';
            };
        });
    }

    // ---- "Tarixingiz" — FAQAT haqiqatda qidirib bosilgan narsalar ----
    var history = getSearchHistory();
    if (history.length) {
        var historyHeader = document.createElement('div');
        historyHeader.className = 'csp-history-header';
        historyHeader.innerHTML =
            '<span class="csp-history-title">Tarixingiz</span>' +
            '<button class="csp-history-clear" type="button" id="cspRecentClear">Tozalash</button>';
        cspResults.appendChild(historyHeader);

        history.forEach(function (h, i) {
            var row = document.createElement('div');
            row.className = 'csp-row';
            row.style.animationDelay = (i * 25) + 'ms';
            row.innerHTML =
                '<div class="csp-avatar" style="background:' + h.avatarBg + '">' + h.avatarHtml + '</div>' +
                '<div class="csp-body">' +
                    '<div class="csp-name">' + escapeHtml(h.name || '') + '</div>' +
                    '<div class="csp-sub">' + escapeHtml(h.username ? '@' + h.username : (h.email || '')) + '</div>' +
                '</div>';
            row.addEventListener('click', function () {
                if (h.userId) {
                    openUserChat({ id: h.userId, name: h.name, username: h.username || '', email: h.email || '', avatar: h.avatarRaw || null });
                } else if (h.entityId) {
                    var entItem = chatItemsWrap.querySelector('.cl-item[data-entity-id="' + h.entityId + '"]');
                    if (entItem) entItem.click();
                }
                closeSearchPanel();
                clSearchInput.value = '';
                clSearchBox.classList.remove('has-text');
            });
            cspResults.appendChild(row);
        });

        var recentClearBtn = document.getElementById('cspRecentClear');
        recentClearBtn.addEventListener('click', function () {
            clearHistoryConfirmOverlay.classList.add('show');
        });
    }

    return ordered.length;
}





var searchHistoryKey = 'chatovbs_search_history_' + currentUserId;

function getSearchHistory() {
    try { return JSON.parse(localStorage.getItem(searchHistoryKey) || '[]'); }
    catch (e) { return []; }
}
function addToSearchHistory(entry) {
    var list = getSearchHistory();
    list = list.filter(function (h) { return h.id !== entry.id; });
    list.unshift(entry);
    localStorage.setItem(searchHistoryKey, JSON.stringify(list.slice(0, 20)));
}
function clearSearchHistoryData() {
    localStorage.removeItem(searchHistoryKey);
}

function renderSearchHistoryRow() {
    var history = getSearchHistory();
    if (!history.length) return;

    var header = document.createElement('div');
    header.className = 'csp-history-header';
    header.innerHTML =
        '<span class="csp-history-title">Tarixingiz</span>' +
        '<button class="csp-history-clear" type="button" id="cspHistoryClear">Tozalash</button>';
    cspResults.appendChild(header);

    var row = document.createElement('div');
    row.className = 'csp-history-row';
    history.forEach(function (h) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'csp-history-item';
        btn.innerHTML =
            '<div class="csp-history-avatar" style="background:' + h.avatarBg + '">' + h.avatarHtml + '</div>' +
            '<span class="csp-history-name">' + escapeHtml(h.name) + '</span>';
        btn.addEventListener('click', function () {
            if (h.userId) {
                openUserChat({ id: h.userId, name: h.name, username: h.username || '', email: h.email || '', avatar: h.avatarRaw || null });
            }
            closeSearchPanel();
            clSearchInput.value = '';
            clSearchBox.classList.remove('has-text');
        });
        row.appendChild(btn);
    });
    cspResults.appendChild(row);

    var clearBtn = document.getElementById('cspHistoryClear');
    clearBtn.addEventListener('click', function () {
        clearHistoryConfirmOverlay.classList.add('show');
    });
}
     

     var sentChatMsgKey = 'chatovbs_sent_chat_msgs';

    function getSentMsgMap() {
        try { return JSON.parse(localStorage.getItem(sentChatMsgKey) || '{}'); }
        catch (e) { return {}; }
    }
    function markSentMessage(entityId, messageId) {
        if (!entityId || messageId === undefined || messageId === null) return;
        var map = getSentMsgMap();
        var key = String(entityId);
        map[key] = map[key] || [];
        if (map[key].indexOf(messageId) === -1) {
            map[key].push(messageId);
            if (map[key].length > 500) map[key] = map[key].slice(-500);
        }
        localStorage.setItem(sentChatMsgKey, JSON.stringify(map));
    }
    function isSentMessage(entityId, messageId) {
        var map = getSentMsgMap();
        var key = String(entityId);
        return !!(map[key] && map[key].indexOf(messageId) !== -1);
    }

    var recentUsersKey = 'chatovbs_recent_users_{{ auth()->id() }}';

    function displayUserName(user) {
        return (user.name || user.username || user.email || '?').trim();
    }

    function formatChatTime(value) {
        if (!value) return '';
        var date = new Date(value);
        if (isNaN(date.getTime())) return '';
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: !(window.CHATOVBS_SETTINGS && window.CHATOVBS_SETTINGS.time24) });
    }





    var DIVIDER_MONTHS = ['yanvar','fevral','mart','aprel','may','iyun','iyul','avgust','sentabr','oktabr','noyabr','dekabr'];

function getDateFormatSetting() {
    var s = window.CHATOVBS_SETTINGS || {};
    var f = s.date_format || s.dateFormat || 'dmy';
    return (f === 'mdy' || f === 'ymd') ? f : 'dmy';
}

function dayKeyOf(value) {
    var d = new Date(value);
    if (!value || isNaN(d.getTime())) return '';
    return d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate();
}

function formatDayDividerLabel(value) {
    var d = new Date(value);
    if (isNaN(d.getTime())) return '';
    var fmt = getDateFormatSetting(), now = new Date();
    var dd = d.getDate(), mi = d.getMonth(), yy = d.getFullYear();
    var p = function (n) { return (n < 10 ? '0' : '') + n; };

    if (fmt === 'ymd') return yy + '-' + p(mi + 1) + '-' + p(dd);
    if (yy !== now.getFullYear()) {
        return fmt === 'mdy' ? p(mi + 1) + '/' + p(dd) + '/' + yy : p(dd) + '.' + p(mi + 1) + '.' + yy;
    }
    var month = DIVIDER_MONTHS[mi];
    return fmt === 'mdy' ? month.charAt(0).toUpperCase() + month.slice(1) + ' ' + dd : dd + '-' + month;
}

// Lichka / kanal / guruh uchun: kerak bo'lsa yangi sana chiziqchasini qo'shadi
function ensureDateDivider(createdValue) {
    var key = dayKeyOf(createdValue);
    if (!key) return;
    var el = cmMessages.lastElementChild;
    while (el) {
        if (el.classList.contains('date-divider')) {
            if (el.dataset.day === key) return;
        } else if (el.classList.contains('msg-row')) {
            if (el.dataset.dayKey === key) return;
            break;
        }
        el = el.previousElementSibling;
    }
    var div = document.createElement('div');
    div.className = 'day-divider date-divider';
    div.dataset.day = key;
    div.textContent = formatDayDividerLabel(createdValue);
    var last = cmMessages.lastElementChild;
    if (last && last.id === 'unreadDivider') cmMessages.insertBefore(div, last);
    else cmMessages.appendChild(div);
}

// Saqlangan xabarlar uchun (HTML qaytaradi)
function savedDayDividerHtml(prevMsg, msg) {
    var key = dayKeyOf(msg && msg.createdAt);
    if (!key) return '';
    if (prevMsg && dayKeyOf(prevMsg.createdAt) === key) return '';
    return '<div class="day-divider date-divider" data-day="' + key + '">' + escapeHtml(formatDayDividerLabel(msg.createdAt)) + '</div>';
}


    function formatLastSeen(lastSeenAt) {
    if (!lastSeenAt) return "oxirgi marta ko'rilgan vaqt noma'lum";
    var date = new Date(lastSeenAt);
    if (isNaN(date.getTime())) return '';
    var now = new Date();
    var diffMin = Math.floor((now - date) / 60000);

    if (diffMin < 1) return 'hozirgina onlayn edi';
    if (diffMin < 60) return diffMin + ' daqiqa oldin online edi';

    var hh = (date.getHours() < 10 ? '0' : '') + date.getHours();
    var mi = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
    var isToday = date.toDateString() === now.toDateString();
    var yesterday = new Date(now); yesterday.setDate(now.getDate() - 1);
    var isYesterday = date.toDateString() === yesterday.toDateString();

    if (isToday) return 'bugun soat ' + hh + ':' + mi + ' da online edi';
    if (isYesterday) return 'kecha soat ' + hh + ':' + mi + ' da online edi';

    var months = ['yanvar','fevral','mart','aprel','may','iyun','iyul','avgust','sentabr','oktabr','noyabr','dekabr'];
    return date.getDate() + '-' + months[date.getMonth()] + ' kuni online edi';
}

function formatSmartDateLabel(tsOrValue) {
    if (!tsOrValue) return '';
    var date = new Date(Number(tsOrValue) || tsOrValue);
    if (isNaN(date.getTime())) return '';
    var now = new Date();

    if (date.toDateString() === now.toDateString()) {
        var hh = (date.getHours() < 10 ? '0' : '') + date.getHours();
        var mi = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
        return hh + ':' + mi;
    }

    var yesterday = new Date(now);
    yesterday.setDate(now.getDate() - 1);
    if (date.toDateString() === yesterday.toDateString()) return 'kecha';

    var diffDays = Math.floor((now - date) / 86400000);
    if (diffDays < 7) {
        var weekdays = ['yakshanba', 'dushanba', 'seshanba', 'chorshanba', 'payshanba', 'juma', 'shanba'];
        return weekdays[date.getDay()];
    }

    var dd = (date.getDate() < 10 ? '0' : '') + date.getDate();
    var mm = (date.getMonth() + 1 < 10 ? '0' : '') + (date.getMonth() + 1);
    return dd + '.' + mm + '.' + date.getFullYear();
}

function computeStatusText(chatUser) {
    return chatUser.online ? 'onlayn' : formatLastSeen(chatUser.last_seen_at);
}



  function chatPreview(message) {
    if (!message) return '';
    if (message.audio_url) {
        return '<svg class="entity-kind-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line></svg>Ovozli xabar';
    }
    if (message.file_url) {
        var mime = message.file_mime || '';
        if (mime.indexOf('image/gif') === 0) {
            return '<img class="entity-kind-icon cl-thumb" src="' + escapeHtml(message.file_url) + '" alt="">GIF';
        }
        if (mime.indexOf('image/') === 0) {
            return '<img class="entity-kind-icon cl-thumb" src="' + escapeHtml(message.file_url) + '" alt="">Rasim';
        }
        if (mime.indexOf('video/') === 0) {
            return '<span class="cl-thumb-wrap"><video class="cl-thumb" src="' + escapeHtml(message.file_url) + '#t=0.1" preload="metadata" muted playsinline></video><svg class="cl-thumb-play" viewBox="0 0 24 24" fill="#fff"><path d="M8 5.5v13l10-6.5z"></path></svg></span>Video';
        }
        if (mime.indexOf('audio/') === 0) {
            return '<svg class="entity-kind-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>' + escapeHtml(message.file_name || 'Musiqa');
        }
        return '<svg class="entity-kind-icon" viewBox="0 0 24 24" fill="#ffffff" stroke="none"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6" fill="none" stroke="#171817" stroke-width="1.5"></path></svg>' + escapeHtml(message.file_name || 'Fayl');
    }
    return escapeHtml(message.body || '');
}

      function updateRailCounts() {
        if (typeof currentFilter !== 'undefined') filterChatItems(currentFilter);
        var items = Array.prototype.slice.call(chatItemsWrap.querySelectorAll('.cl-item'));
        var allCount = items.length;
        var personalCount = items.reduce(function (total, item) {
            if ((item.dataset.kind || 'personal') !== 'personal') return total;
            var badge = item.querySelector('.cl-unread');
            return total + (badge && Number(badge.textContent) > 0 ? 1 : 0);
        }, 0);
        var unreadCount = items.reduce(function (total, item) {
            var badge = item.querySelector('.cl-unread');
            return total + (badge ? Number(badge.textContent) || 0 : 0);
        }, 0);

        [['all', allCount], ['unread', unreadCount], ['personal', personalCount]].forEach(function (entry) {
            var badge = document.querySelector('[data-rail-count="' + entry[0] + '"]');
            if (!badge) return;
            badge.textContent = entry[1] > 99 ? '99+' : entry[1];
            badge.style.display = entry[1] > 0 ? 'flex' : 'none';
        });
    }

    function filterChatItems(filter) {
        chatItemsWrap.querySelectorAll('.cl-item').forEach(function (item) {
            var unread = item.querySelector('.cl-unread');
            var isUnread = unread && Number(unread.textContent) > 0;
            var isPersonal = (item.dataset.kind || 'personal') === 'personal';
            item.style.display = filter === 'unread' ? (isUnread ? '' : 'none')
                : filter === 'personal' ? (isPersonal ? '' : 'none') : '';
        });
    }

    function ensureUnreadDot(item) {
        var row = item.querySelector('.cl-row2');
        if (!row || item.querySelector('.cl-unread')) return;
        var dot = document.createElement('span');
        dot.className = 'cl-unread cl-unread-dot';
        dot.textContent = '1';
        row.appendChild(dot);
    }

    function markItemAsRead(item) {
        setItemState(item, { markedUnread: false });
        var badge = item.querySelector('.cl-unread');
        if (badge) badge.remove();
        updateRailCounts();

        var kind = item.dataset.kind;
        if (item.dataset.userId && item.dataset.userId !== 'saved') {
            var uid = item.dataset.userId;
            fetch(messageBaseUrl + '/' + uid, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function () { updateChatListUnread(uid, 0); })
                .catch(function () {});
        } else if (item.dataset.entityBackendId) {
            var eid = item.dataset.entityBackendId;
            var baseUrl = kind === 'chat' ? entityChatsBaseUrl : entityMessagesBaseUrl;
            fetch(baseUrl + '/' + eid, { headers: { 'Accept': 'application/json' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    var msgs = sortEntityMessages(data.messages || []);
                    if (msgs.length) setEntityLastSeen(eid, kind, msgTs(msgs[msgs.length - 1]));
                    updateEntityUnreadBadge(eid, kind, 0);
                })
                .catch(function () {});
        }
    }

    function markItemAsUnread(item) {
        setItemState(item, { markedUnread: true });
        ensureUnreadDot(item);
        updateRailCounts();
    }

    function updateChatListUnread(userId, unreadCount) {
        var item = chatItemsWrap.querySelector('.cl-item[data-user-id="' + userId + '"]');
        if (!item) return;
        var row = item.querySelector('.cl-row2');
        var badge = item.querySelector('.cl-unread');
        unreadCount = Number(unreadCount) || 0;

        if (unreadCount <= 0 && getItemState(item).markedUnread) {
            ensureUnreadDot(item);
            updateRailCounts();
            return;
        }

        if (unreadCount > 0 && (!item.classList.contains('active') || document.hidden || !document.hasFocus())) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'cl-unread';
                row.appendChild(badge);
            }
            badge.classList.remove('cl-unread-dot');
            badge.textContent = unreadCount;
            if (getItemState(item).markedUnread) setItemState(item, { markedUnread: false });
        } else if (badge) {
            badge.remove();
        }
        updateRailCounts();
    }

    function updateChatListPreview(userId, message, unreadCount) {
        var item = chatItemsWrap.querySelector('.cl-item[data-user-id="' + userId + '"]');
        if (!item) return;

  // ⬇⬇⬇ SHU YERGA QO'SHING ⬇⬇⬇
    if (message) {
        var nTs = notifTimestamp(message);
        if (message.sender_id === currentUserId || message.read_at) notifSeed('u:' + userId, nTs);
        else maybeNotify('u:' + userId, nTs, item, item.dataset.name, notifMessageText(message));
    }
    // ⬆⬆⬆



        var preview = item.querySelector('.cl-msg');
        var time = item.querySelector('.cl-time');
        if (preview && message) {
            var msgKey = String(message.id) + ':' + String(message.read_at || '');
            if (item.dataset.lastPreviewKey !== msgKey) {
                item.dataset.lastPreviewKey = msgKey;
                preview.innerHTML = chatPreview(message);
            }
        }
        if (time && message) {
            var tick = message.sender_id === currentUserId
                ? '<b class="cl-status' + (message.read_at ? ' read' : '') + '">' + (message.read_at ? '&#10003;&#10003;' : '&#10003;') + '</b> '
                : '';
            time.innerHTML = tick + escapeHtml(formatChatTime(message.created_at));
        }
        if (message) item.dataset.lastMessageAt = String(new Date(message.created_at).getTime() || 0);
        updateChatListUnread(userId, unreadCount);
        if (message) sortChatItems();
        updateRailCounts();
    }

    function ensureSavedChatItem() {
        var item = chatItemsWrap.querySelector('.cl-item[data-kind="saved"]');
        if (item) return item;

        var empty = chatItemsWrap.querySelector('.cl-empty');
        if (empty) empty.remove();

        item = document.createElement('div');
        item.className = 'cl-item';
        item.dataset.userId = 'saved';
        item.dataset.name = 'Saqlangan xabarlar';
        item.dataset.status = 'Faqat siz ko\'rasiz';
        item.dataset.kind = 'saved';
        item.dataset.color = '#4b9bea';
        item.dataset.lastMessageAt = '0';
        item.innerHTML = '<div class="cl-avatar" style="background:#4b9bea;color:#fff;"><svg viewBox="0 0 24 24" style="width:24px;height:24px;display:block;flex:none;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></div>' +
            '<div class="cl-body"><div class="cl-row1"><span class="cl-name">Saqlangan xabarlar</span><span class="cl-time"></span></div><div class="cl-row2"><span class="cl-msg"></span></div></div>';
        chatItemsWrap.prepend(item);
        bindChatItemEvents(item);
        return item;
    }

     function updateSavedChatPreview(message) {
        var item = ensureSavedChatItem();
        var preview = item.querySelector('.cl-msg');
        var time = item.querySelector('.cl-time');
        if (message) {
            var msgKey = String(message.id);
            if (item.dataset.lastPreviewKey !== msgKey) {
                item.dataset.lastPreviewKey = msgKey;
                preview.innerHTML = chatPreview(message);
            }
            time.textContent = formatChatTime(message.created_at);
            item.dataset.lastMessageAt = String(new Date(message.created_at).getTime() || 0);
            sortChatItems();
        }
    }

        // ⬇⬇⬇ YANGI QO'SHILADIGAN QISM SHU YERGA ⬇⬇⬇
    var entityLastSeenKey = 'chatovbs_entity_last_seen_ts_{{ auth()->id() }}';

    function getEntityLastSeenMap() {
        try { return JSON.parse(localStorage.getItem(entityLastSeenKey) || '{}'); }
        catch (e) { return {}; }
    }
    function setEntityLastSeen(entityId, kind, ts) {
        if (!ts) return;
        var map = getEntityLastSeenMap();
        var k = entityId + ':' + kind;
        if (map[k] === undefined || ts > Number(map[k])) {
            map[k] = ts;
            localStorage.setItem(entityLastSeenKey, JSON.stringify(map));
        }
    }
    function getEntityLastSeen(entityId, kind) {
        var v = getEntityLastSeenMap()[entityId + ':' + kind];
        return (v === undefined) ? null : Number(v);
    }

    function updateEntityUnreadBadge(entityId, kind, unreadCount) {
        var item = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="' + kind + '"]');
        if (!item) return;
        var row = item.querySelector('.cl-row2');
        var badge = item.querySelector('.cl-unread');
        unreadCount = Number(unreadCount) || 0;
        var isActive = item.classList.contains('active');

        if (unreadCount <= 0 && !isActive && getItemState(item).markedUnread) {
            ensureUnreadDot(item);
            updateRailCounts();
            return;
        }

        if (unreadCount > 0 && !isActive) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'cl-unread';
                row.appendChild(badge);
            }
            badge.classList.remove('cl-unread-dot');
            badge.textContent = unreadCount;
            if (getItemState(item).markedUnread) setItemState(item, { markedUnread: false });
        } else if (badge) {
            badge.remove();
        }
        updateRailCounts();
    }
    // ⬆⬆⬆ YANGI QISM SHU YERGACHA ⬆⬆⬆



       function updateEntityListPreview(entityId, isDiscussionChat) {
        var kind = isDiscussionChat ? 'chat' : 'channel';
        var selector = '.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="' + kind + '"]';
        var item = chatItemsWrap.querySelector(selector);
        if (!item) return;
        var baseUrl = isDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl;
        fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                 var messages = sortEntityMessages(data.messages || []);
                var lastMessage = messages[messages.length - 1];

                // ⬇⬇⬇ SHU YERGA QO'SHING ⬇⬇⬇
if (lastMessage) {
    var nKey = 'e:' + entityId + ':' + kind;
    var entityNotifTime = notifTimestamp(lastMessage);
    if (isSelfSent(lastMessage)) notifSeed(nKey, entityNotifTime);
    else maybeNotify(
        nKey,
        entityNotifTime,
        item,
        lastMessage.sender_name || item.dataset.name,
        notifMessageText(lastMessage),
        { avatarUrl: lastMessage.sender_avatar || null }
    );
}
// ⬆⬆⬆


                if (lastMessage) {
                    var preview = item.querySelector('.cl-msg');
                    var time = item.querySelector('.cl-time');
                    var msgKey = String(lastMessage.id);
                    if (preview && item.dataset.lastPreviewKey !== msgKey) {
                        item.dataset.lastPreviewKey = msgKey;
                        if (isDiscussionChat) {
                            var senderLabel;
                            var arrow = '';
                            if (lastMessage.sender_id === currentUserId && !lastMessage.is_channel_post) {
                                senderLabel = 'Siz';
                            } else {
                                var channelItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="channel"]');
                                senderLabel = channelItem ? channelItem.dataset.name : (item.dataset.name || 'Kanal');
                            arrow = '<svg class="entity-kind-icon cl-forward-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 17 20 12 15 7"></polyline><path d="M4 18v-2a4 4 0 0 1 4-4h12"></path></svg>';                            }
                            preview.innerHTML = '<b>' + escapeHtml(senderLabel) + ':</b> ' + arrow + chatPreview(lastMessage);
                        } else {
                            preview.innerHTML = chatPreview(lastMessage);
                        }
                    }
                    if (time) time.textContent = formatChatTime(lastMessage.created_at);
                    item.dataset.lastMessageAt = String(new Date(lastMessage.created_at).getTime() || 0);
                    sortChatItems();
                }

                             var isOpenNow = item.classList.contains('active');
                if (isOpenNow) {
                    if (lastMessage) setEntityLastSeen(entityId, kind, msgTs(lastMessage));
                    updateEntityUnreadBadge(entityId, kind, 0);
                } else {
                    var lastSeenTs = getEntityLastSeen(entityId, kind);
                                      var unreadCount = messages.filter(function (m) {
                       if (isSelfSentIn(m, isDiscussionChat)) return false;
                        return lastSeenTs === null || msgTs(m) > lastSeenTs;
                    }).length;
                    updateEntityUnreadBadge(entityId, kind, unreadCount);
                }
            })
            .catch(function () {});
    }

       function refreshEntityPreviews(entityId) {
        if (!entityId) return;
        updateEntityListPreview(entityId, false);
        setTimeout(function () { updateEntityListPreview(entityId, true); }, 400);
    }

    function openSavedMessages() {
    var myToken = ++viewToken;
    savedSubBackBtn.style.display = 'none';
    activeSavedSubChatIndex = null;
     activeRecipientId = null;
    activeRecipientUser = null;
    activeRecipientProfile = null;
    activeEntityId = null;
    document.getElementById('cmCallBtn').style.display = 'none';
    document.getElementById('cmDiscussBtn').style.display = 'none';
    document.getElementById('mmSaved').classList.add('selected');
    showInternalView('Saqlangan xabarlar', '', renderSavedMessages(), 'saved');
    syncRightPanelForContext();
   
    fetch(savedMessagesUrl, { headers: { 'Accept': 'application/json' } })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            if (myToken !== viewToken || activeInternalView !== 'saved') return;

            savedMessages = (data.messages || []).map(function (message) {
                    return {
                        id: message.id,
                          createdAt: message.created_at,     // ← SHU QATOR YANGI
                        text: message.body || '',
                        time: formatChatTime(message.created_at),
                        fromSelf: true,
                        audioUrl: message.audio_url || null,
                        duration: message.audio_duration || null,
                        fileUrl: message.file_url || null,
                        fileName: message.file_name || null,
                        fileMime: message.file_mime || null,
                        fileSize: message.file_size || null
                    };
                });

                                var _sm = data.messages || [];
                updateSavedChatPreview(_sm[_sm.length - 1]);
                       cmMessages.innerHTML = renderSavedMessages();
                cmMessages.classList.add('saved-view');
                cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
                           applyTwemoji(cmMessages);
                scrollToBottomWhenReady();
                if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
            })
            .catch(function () {});
    }

    function loadSavedChatPreview() {

        fetch(savedMessagesUrl, { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                var messages = data.messages || [];
                updateSavedChatPreview(messages[messages.length - 1]);
            })
            .catch(function () {});
    }

    function saveRecentUser(user) {
        var users = JSON.parse(localStorage.getItem(recentUsersKey) || '[]');
        users = users.filter(function (savedUser) { return Number(savedUser.id) !== Number(user.id); });
        users.unshift(user);
        localStorage.setItem(recentUsersKey, JSON.stringify(users.slice(0, 30)));
    }

    function renderGlobalResults(users, query) {
        cspGlobalResults.innerHTML = '';

        if (!users.length) {
            cspGlobalSection.style.display = 'none';
            return;
        }

        cspGlobalSection.style.display = 'block';
        users.forEach(function (user, i) {
            var initial = displayUserName(user).charAt(0).toUpperCase();
            var row = document.createElement('div');
            row.className = 'csp-row';
            row.style.animationDelay = (i * 25) + 'ms';
            var avatarHtml = user.avatar
                ? '<img src="/storage/' + user.avatar + '" alt="">'
                : initial;
            row.innerHTML =
                '<div class="csp-avatar" style="background:var(--accent);color:var(--accent-ink);">' + avatarHtml + '</div>' +
                '<div class="csp-body">' +
                    '<div class="csp-name">' + highlight(displayUserName(user), query) + '</div>' +
                    '<div class="csp-sub csp-username">' + (user.username ? '@' + escapeHtml(user.username) : escapeHtml(user.email || '')) + '</div>' +
                '</div>';
                       row.addEventListener('click', function () {
                saveRecentUser(user);
                addToSearchHistory({
                    id: 'user-' + user.id,
                    userId: user.id,
                    name: displayUserName(user),
                    username: user.username || '',
                    email: user.email || '',
                    avatarBg: 'var(--accent)',
                    avatarHtml: user.avatar ? '<img src="/storage/' + escapeHtml(user.avatar) + '" alt="">' : escapeHtml(displayUserName(user).charAt(0).toUpperCase()),
                    avatarRaw: user.avatar || null
                });
                openUserChat(user);
                closeSearchPanel();
                clSearchInput.value = '';
                clSearchBox.classList.remove('has-text');
            });
            cspGlobalResults.appendChild(row);
        });
    }

       function runSearch(query) {
        query = query.trim();

        clearTimeout(searchDebounce);
        if (searchAbortController) searchAbortController.abort();

        cspGlobalResults.innerHTML = '';
        cspGlobalSection.style.display = 'none';
        cspLoading.classList.remove('show');

               if (!query) {
            cspEmpty.classList.remove('show');
            if (currentSearchTab === 'chats') {
                cspHint.classList.remove('show');
                var recentCount = renderRecentChats();
                if (!recentCount) {
                    cspHint.classList.add('show');
                }
            } else {
                cspResults.innerHTML = '';
                cspHint.classList.add('show');
            }
            return;
        }
               cspHint.classList.remove('show');

        cspResults.innerHTML = '';
        renderSearchHistoryRow();
        var localCount = renderLocalResults(query);
        updateEmptyState(localCount, 0);

        if (query.length < 2 || !searchRequestUrl) {
            return;
        }

        searchDebounce = setTimeout(function () {
            cspLoading.classList.add('show');
            searchAbortController = new AbortController();

            fetch(searchRequestUrl + '?q=' + encodeURIComponent(query), {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                signal: searchAbortController.signal
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                cspLoading.classList.remove('show');
                var users = data.users || [];
                renderGlobalResults(users, query);
                updateEmptyState(localCount, users.length);
            })
            .catch(function (err) {
                if (err.name !== 'AbortError') {
                    cspLoading.classList.remove('show');
                    updateEmptyState(localCount, 0);
                }
            });
        }, 300);
    }

    function addUserToChatList(user) {
        var existing = chatItemsWrap.querySelector('.cl-item[data-user-id="' + user.id + '"]');
        if (existing) {
            existing.dataset.name = displayUserName(user);
            existing.dataset.username = user.username || '';
            existing.dataset.email = user.email || '';
            existing.dataset.status = user.username ? '@' + user.username : (user.email || '');
            var existingAvatar = existing.querySelector('.cl-avatar');
            if (existingAvatar) {
                existingAvatar.classList.toggle('online', !!user.online);
                existingAvatar.innerHTML = user.avatar
                    ? '<img src="/storage/' + escapeHtml(user.avatar) + '" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">'
                    : escapeHtml(displayUserName(user).charAt(0).toUpperCase());
            }
            return existing;
        }

        var empty = chatItemsWrap.querySelector('.cl-empty');
        if (empty) empty.remove();

        var item = document.createElement('div');
        item.className = 'cl-item';
        item.dataset.userId = user.id;
        item.dataset.name = displayUserName(user);
        item.dataset.username = user.username || '';
        item.dataset.email = user.email || '';
        item.dataset.status = user.username ? '@' + user.username : user.email;
        item.dataset.kind = 'personal';
        item.dataset.color = 'var(--accent)';
        item.dataset.lastMessageAt = '0';
        item.innerHTML = '<div class="cl-avatar' + (user.online ? ' online' : '') + '" style="background:var(--accent);color:var(--accent-ink);">' +
            (user.avatar ? '<img src="/storage/' + escapeHtml(user.avatar) + '" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">' : escapeHtml(displayUserName(user).charAt(0).toUpperCase())) +
            '</div><div class="cl-body"><div class="cl-row1"><span class="cl-name">' + escapeHtml(item.dataset.name) +
            '</span><span class="cl-time"></span></div><div class="cl-row2"><span class="cl-msg"></span></div></div>';
        chatItemsWrap.prepend(item);
        bindChatItemEvents(item);
        updateRailCounts();
        saveRecentUser(user);
        fetch(messageBaseUrl + '/' + user.id + '?preview=1', { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                var messages = data.messages || [];
                updateChatListPreview(user.id, messages[messages.length - 1], data.unread_count);
            })
            .catch(function () {});
        return item;
    }

    function addEntityToChatList(entity) {
        var itemId = 'entity-' + entity.type + '-' + entity.id;
        var existing = chatItemsWrap.querySelector('.cl-item[data-entity-id="' + itemId + '"]');
        var isChannel = entity.type === 'channel';
        var icon = isChannel
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 11 18-5-5 18-4-8-9-5Z"/><path d="m12 16 5-10"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"/><path d="M8 11h8M8 15h5"/></svg>';
        var memberLabel = isChannel ? (entity.members_count || 1) + ' obunachi' : (entity.members_count || 1) + ' a’zo';
        var label = isChannel ? 'Kanal' : (entity.type === 'chat' ? 'Suhbat' : 'Guruh');
        var createdLabel = isChannel ? 'Kanal yaratildi' : (entity.type === 'chat' ? 'Suhbat yaratildi' : 'Guruh yaratildi');
        var avatarSource = entity.avatar || '';
        var avatarUrl = avatarSource.indexOf('data:') === 0 ? avatarSource : '/storage/' + avatarSource;
        var avatar = avatarSource
            ? '<img src="' + escapeHtml(avatarUrl) + '" alt="" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">'
            : icon;
        if (existing) return existing;

        var empty = chatItemsWrap.querySelector('.cl-empty');
        if (empty) empty.remove();
        item = document.createElement('div');
        item.className = 'cl-item';
        item.dataset.entityId = itemId;
        item.dataset.entityBackendId = entity.id;
        item.dataset.name = entity.name;
        item.dataset.username = entity.username || '';
        item.dataset.description = entity.description || '';
        item.dataset.status = memberLabel;
        item.dataset.kind = entity.type;
        item.dataset.color = isChannel ? '#079f94' : '#d99d32';
        item.dataset.createdAt = entity.created_at || entity.updated_at;
        item.dataset.lastMessageAt = String(new Date(entity.updated_at || entity.created_at).getTime() || 0);
        var nameIcon = icon.replace('<svg ', '<svg class="entity-name-icon" ');
        item.innerHTML = '<div class="cl-avatar entity-avatar" style="background:' + item.dataset.color + ';color:#fff;">' + avatar + '</div>' +
            '<div class="cl-body"><div class="cl-row1"><span class="cl-name">' + nameIcon + escapeHtml(entity.name) + '</span><span class="cl-time">' + formatChatTime(entity.updated_at) + '</span></div>' +
            '<div class="cl-row2"><span class="cl-msg">' + createdLabel + '</span></div></div>';
              chatItemsWrap.prepend(item);
        bindChatItemEvents(item);
        updateRailCounts();
        if (entity.type === 'channel' || entity.type === 'chat' || entity.type === 'group') {
            updateEntityListPreview(entity.id, entity.type === 'chat');
        }
        return item;
    }

    function loadChatList() {
        fetch(chatListUrl, { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                (data.chats || []).forEach(function (chat) {
                    addUserToChatList(chat.user);
                    updateChatListPreview(chat.user.id, chat.message, chat.unread_count);
                });
                (data.entities || []).forEach(function (entity) {
                    addEntityToChatList(entity);
                    if (entity.chat_name) {
                        addEntityToChatList({
                            id: entity.id,
                            type: 'chat',
                            name: entity.chat_name,
                            username: entity.chat_username,
                            avatar: entity.chat_avatar,
                            description: entity.chat_description,
                            members_count: 1,
                            created_at: entity.chat_created_at || entity.created_at,
                            updated_at: entity.chat_created_at || entity.updated_at
                        });
                    }
                });
                sortChatItems();
                updateRailCounts();
                loadSavedChatPreview();
                chatListReady = true;
                                setTimeout(function () { if (window.ChatStorage) ChatStorage.scanAll(); }, 3000);
                pollNotificationFeed();

                var requestedEntity = new URLSearchParams(window.location.search).get('entity');
                if (requestedEntity) {
                    var requestedItem = chatItemsWrap.querySelector('.cl-item[data-entity-id="entity-' + requestedEntity + '"]');
                    if (requestedItem) requestedItem.click();
                }
            })
            .catch(function () {});
    }

    function restoreRecentUsers() {
        JSON.parse(localStorage.getItem(recentUsersKey) || '[]').reverse().forEach(function (user) {
            addUserToChatList(user);
        });
    }

   function voiceMsgHtml(audioUrl, durationSec) {
        var bars = '';
        var totalBars = 48;
        for (var i = 0; i < totalBars; i++) {
            var edgeDistance = Math.min(i, totalBars - 1 - i);
            var maxH = edgeDistance < 3 ? 6 + edgeDistance * 3 : 18;
            var h = 4 + Math.round(Math.random() * (maxH - 4));
            bars += '<span style="height:' + h + 'px"></span>';
        }
        var totalLabel = formatRecTime((durationSec || 0) * 1000);
        return '<div class="voice-msg">' +
            '<button class="voice-msg-play" type="button" aria-label="Ovozni ijro etish"><svg class="voice-play-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l10-6.5z"></path></svg></button>' +
            '<div class="voice-msg-track"><div class="voice-msg-wave">' + bars + '</div><div class="voice-msg-duration" data-total="' + (durationSec || 0) + '">0:00 / ' + totalLabel + '</div></div>' +
            '<audio preload="metadata" src="' + escapeHtml(audioUrl) + '"></audio></div>';
    }



        var viewedMessageIds = {};

    var viewObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var row = entry.target;
            var msgId = row.dataset.messageId;
            if (!msgId || String(msgId).indexOf('tmp-') === 0 || viewedMessageIds[msgId]) return;
            viewedMessageIds[msgId] = true;
            viewObserver.unobserve(row);

            fetch(entityMessagesBaseUrl + '/' + msgId + '/view', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var counter = row.querySelector('.msg-views-count');
                if (counter && data.views_count !== undefined) counter.textContent = data.views_count;
            })
            .catch(function () {});
        });
    }, { threshold: 0.6 });



        var entityReadObserver_OLD = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var row = entry.target;
            var msgId = row.dataset.messageId;
            if (!msgId) return;
            entityReadObserver.unobserve(row);
            markEntityMessageSeen(msgId);
        });
    }, { threshold: 0.6 });


        var entityReadObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) return;
            var row = entry.target;
            entityReadObserver.unobserve(row);
            if (row.dataset.scope !== currentEntityScope()) return;
            markEntityMessageSeen(row.dataset.messageKey, Number(row.dataset.createdTs) || 0);
        });
    }, { threshold: 0.6 });

    function markEntityMessageSeen(key, ts) {
        if (!activeEntityId) return;
        var idx = activeEntityUnreadIds.indexOf(key);
        if (idx === -1) return;
        activeEntityUnreadIds.splice(idx, 1);
        var kind = activeIsDiscussionChat ? 'chat' : 'channel';
        updateEntityUnreadBadge(activeEntityId, kind, activeEntityUnreadIds.length);
        setEntityLastSeen(activeEntityId, kind, ts);
        if (!activeEntityUnreadIds.length) {
            var divider = document.getElementById('unreadDivider');
            if (divider) divider.remove();
        }
    }

    function markEntityMessageSeen_OLD(msgId) {
        if (!activeEntityId) return;
        var idx = activeEntityUnreadIds.indexOf(String(msgId));
        if (idx === -1) return;
        activeEntityUnreadIds.splice(idx, 1);
        var kind = activeIsDiscussionChat ? 'chat' : 'channel';
        updateEntityUnreadBadge(activeEntityId, kind, activeEntityUnreadIds.length);
        var msgIdNum = Number(msgId);
        var currentSeen = getEntityLastSeen(activeEntityId, kind);
        if (currentSeen === null || msgIdNum > Number(currentSeen)) {
            setEntityLastSeen(activeEntityId, kind, msgIdNum);
        }
        if (!activeEntityUnreadIds.length) {
            var divider = document.getElementById('unreadDivider');
            if (divider) divider.remove();
        }
    }

        function ledgerDesc() {
        if (activeInternalView === 'saved') return { key: 's', name: 'Saqlangan xabarlar', kind: 'saved', color: '#4b9bea' };
        var item = getActiveListItem();
        if (!item) return null;
        var img = item.querySelector('.cl-avatar img');
        var d = { name: item.dataset.name, color: item.dataset.color, avatar: img ? img.getAttribute('src') : '' };
        if (activeRecipientId) { d.key = 'u:' + activeRecipientId; d.kind = 'personal'; return d; }
        if (activeEntityId) {
            d.key = 'e:' + activeEntityId + ':' + (activeIsDiscussionChat ? 'chat' : 'channel');
            d.kind = activeIsDiscussionChat ? 'group' : (item.dataset.kind === 'group' ? 'group' : 'channel');
            return d;
        }
        return null;
    }


   function appendMessage(message, opts) {
    opts = opts || {};
     var mKey = messageKey(message);
    if (message.id !== undefined && message.id !== null) {
        if (cmMessages.querySelector('.msg-row[data-message-key="' + mKey + '"]')) return;
    }
    if (cmEmptyState) { cmEmptyState.remove(); cmEmptyState = null; }
    var row = document.createElement('div');
               var isChannelPost = !!opts.channelName;
    var isOut = !isChannelPost && (opts.forceOut || (!opts.forceIn && message.sender_id === currentUserId));
    row.className = 'msg-row ' + (isChannelPost ? 'in channel-post' : (isOut ? 'out' : 'in'));
       row.dataset.messageId = message.id;
    row.dataset.messageKey = mKey;
    row.dataset.createdTs = String(new Date(message.created_at).getTime() || 0);
        var time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: !(window.CHATOVBS_SETTINGS && window.CHATOVBS_SETTINGS.time24) });
               var status = (!isChannelPost && message.sender_id === currentUserId)
            ? '<span class="msg-status' + (message.read_at ? ' read' : '') + '">' + (message.read_at ? '&#10003;&#10003;' : '&#10003;') + '</span>'
            : '';
        var viewsHtml = isChannelPost
            ? '<span class="msg-views"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"></path><circle cx="12" cy="12" r="3"></circle></svg><span class="msg-views-count" data-message-id="' + message.id + '">' + (message.views_count || 0) + '</span></span>'
            : '';
                                  var content = linkifyText(message.body || '');
        var isImageMsg = false;
               if (message.file_url) {
            var senderLabel = isChannelPost ? opts.channelName : (message.sender_id === currentUserId ? 'Siz' : (cmName.textContent || 'Foydalanuvchi'));
            content = fileMsgHtml(message.file_url, message.file_name, message.file_mime, message.file_size, { sender: senderLabel, time: time });
            var mimeType = message.file_mime || '';
            isImageMsg = mimeType.indexOf('image/') === 0 || mimeType.indexOf('video/') === 0;
        } else if (message.audio_url) {
            content = voiceMsgHtml(message.audio_url, message.audio_duration || 0);
        }
        var bubbleClass = 'msg-bubble' + (isImageMsg ? ' media-bubble' : '');
                  var headerHtml = isChannelPost
            ? '<div class="channel-post-header"><span class="channel-post-name">' + escapeHtml(opts.channelName) + '</span>' + (opts.badgeLabel ? '<span class="channel-post-badge">' + escapeHtml(opts.badgeLabel) + '</span>' : '') + '</div>'
            : '';
                var channelAvatarHtml = (isChannelPost && !opts.hideAvatar)
            ? '<span class="channel-post-avatar" style="background:' + (opts.channelColor || 'var(--accent)') + '">' + (opts.channelAvatarHtml || escapeHtml((opts.channelName || '?').charAt(0).toUpperCase())) + '</span>'
            : '';
        var bubbleHtml = '<div class="' + bubbleClass + '">' + headerHtml + content + '<span class="msg-time">' + viewsHtml + time + status + '</span></div>';
        row.innerHTML = isChannelPost
            ? channelAvatarHtml + '<div class="channel-post-col">' + bubbleHtml + '</div>'
            : bubbleHtml;
        if (isChannelPost && !opts.noFooter) {
            var footer = document.createElement('div');
            footer.className = 'channel-post-footer';
            footer.dataset.linkedEntityId = opts.linkedChatEntityId || '';
          footer.innerHTML =
    '<span class="cpf-left"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path></svg><span>Sharh qoldirish</span></span>' +
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 6 15 12 9 18"></polyline></svg>';
            row.querySelector('.channel-post-col').appendChild(footer);
        }
                          row.dataset.dayKey = dayKeyOf(message.created_at);
        ensureDateDivider(message.created_at);
        cmMessages.appendChild(row);


        applyTwemoji(row);
               if (renderedMessageIds.indexOf(mKey) === -1) renderedMessageIds.push(mKey);
            if (message.audio_url) bindVoicePlayer(row.querySelector('.voice-msg'));
        if (row.querySelector('.music-msg')) bindMusicPlayer(row.querySelector('.music-msg'));
        var videoEl = row.querySelector('.file-msg video');
        if (videoEl) fixVideoAspect(videoEl);
        if (isChannelPost) viewObserver.observe(row);

                if (window.ChatStorage && (message.file_url || message.audio_url)) {
            var _ld = ledgerDesc();
            if (_ld && !(activeIsDiscussionChat && message.is_channel_post)) ChatStorage.recordMessage(_ld, message);
        }
    }

     function bindVoicePlayer(player) {
        var audio = player.querySelector('audio');
        var button = player.querySelector('.voice-msg-play');
        var icon = player.querySelector('.voice-play-icon');
        var wave = player.querySelector('.voice-msg-wave');
        var bars = wave.querySelectorAll('span');
        var durationEl = player.querySelector('.voice-msg-duration');
        var fallbackTotal = Number(durationEl.dataset.total) || 0;
        var realDuration = null;
        var durationFixed = false;

        function totalSeconds() {
            if (realDuration && isFinite(realDuration) && realDuration > 0) return realDuration;
            return fallbackTotal;
        }

        function updateProgress() {
            var total = totalSeconds();
            var current = audio.currentTime || 0;
            var ratio = total ? current / total : 0;
            bars.forEach(function (bar, index) { bar.classList.toggle('played', index / bars.length < ratio); });
            durationEl.textContent = formatRecTime(current * 1000) + ' / ' + formatRecTime(total * 1000);
        }

        // .webm fayllarda duration ba'zan Infinity bo'lib chiqadi — buni to'g'irlaymiz
        function fixDuration() {
            if (durationFixed) return;
            if (isFinite(audio.duration) && audio.duration > 0) {
                realDuration = audio.duration;
                durationFixed = true;
                updateProgress();
                return;
            }
            durationFixed = true;
            audio.currentTime = 1e101;
            audio.addEventListener('timeupdate', function onFix() {
                audio.removeEventListener('timeupdate', onFix);
                realDuration = isFinite(audio.duration) ? audio.duration : fallbackTotal;
                audio.currentTime = 0;
                updateProgress();
            });
        }

        button.addEventListener('click', function () {
             MusicPlayer.pause();
            document.querySelectorAll('.voice-msg audio').forEach(function (other) {
                if (other !== audio) other.pause();
            });
            if (audio.paused) audio.play(); else audio.pause();
        });
        wave.addEventListener('click', function (event) {
            var total = totalSeconds();
            if (!total) return;
            var rect = wave.getBoundingClientRect();
            audio.currentTime = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width)) * total;
        });
          audio.addEventListener('play', function () {
            icon.innerHTML = '<path d="M7 5h4v14H7zM13 5h4v14h-4z"></path>';
            var row = player.closest('.msg-row, .saved-message-row');
            var mine = row && (row.classList.contains('out') ||
                (row.classList.contains('saved-message-row') && !row.classList.contains('from-other')));
           var who = mine ? currentUserName : (cmName.textContent || 'Foydalanuvchi');
            MusicPlayer.voiceStarted(audio, who, totalSeconds());
        });
        audio.addEventListener('pause', function () {
            icon.innerHTML = '<path d="M8 5.5v13l10-6.5z"></path>';
            MusicPlayer.syncVoice(audio);
        });
        audio.addEventListener('loadedmetadata', fixDuration);
        audio.addEventListener('durationchange', fixDuration);
        audio.addEventListener('timeupdate', function () {
            updateProgress();
            MusicPlayer.syncVoice(audio);
        });
        audio.addEventListener('ended', function () {
            audio.currentTime = 0;
            updateProgress();
            MusicPlayer.voiceEnded(audio);
        });
        audio.addEventListener('error', function () {
            durationEl.textContent = 'Ijro etib bo\'lmadi';
        });

        updateProgress();


        
    }


    
var MusicPlayer = (function () {
    var audio = new Audio();
    audio.preload = 'metadata';
    var bar = document.getElementById('musicBar');
    var mbPlay = document.getElementById('mbPlay');
    var mbName = document.getElementById('mbName');
    var mbTime = document.getElementById('mbTime');
    var mbFill = document.getElementById('mbFill');
    var mbSpeed = document.getElementById('mbSpeed');
    var PLAY = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l10-6.5z"></path></svg>';
    var PAUSE = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 5h4v14H7zM13 5h4v14h-4z"></path></svg>';
    var speeds = [1, 1.5, 2], speedIdx = 0;
    var queue = [], index = -1, cur = null;





    var reversed = false, repeatMode = 0; // repeatMode: 0 o'chiq, 1 hammasi, 2 bitta
var mbOrder = document.getElementById('mbOrder');
var mbRepeat = document.getElementById('mbRepeat');
var REPEAT_TITLES = ["Takrorlash o'chiq", 'Hammasini takrorlash', 'Bittasini takrorlash'];

function syncModes() {
    mbOrder.classList.toggle('on', reversed);
    mbOrder.title = reversed ? 'Teskari tartib' : 'Oddiy tartib';
    mbRepeat.classList.toggle('on', repeatMode > 0);
    mbRepeat.classList.toggle('one', repeatMode === 2);
    mbRepeat.title = REPEAT_TITLES[repeatMode];
}
function dirNext() { return reversed ? -1 : 1; }
function goTrack(dir, wrap) {
    var n = index + dir;
    if (n < 0 || n >= queue.length) {
        if (!wrap || !queue.length) return false;
        n = n < 0 ? queue.length - 1 : 0;
    }
    index = n;
    load(queue[index]);
    return true;
}
mbOrder.addEventListener('click', function () { reversed = !reversed; syncModes(); });
mbRepeat.addEventListener('click', function () { repeatMode = (repeatMode + 1) % 3; syncModes(); });
syncModes();

    var voiceEl = null, voiceName = '', voiceFallback = 0;

    function fmt(s) {
        s = Math.max(0, Math.floor(s || 0));
        return Math.floor(s / 60) + ':' + (s % 60 < 10 ? '0' : '') + (s % 60);
    }
    function engine() { return voiceEl || audio; }
    function totalOf(eng) {
        if (isFinite(eng.duration) && eng.duration > 0) return eng.duration;
        return voiceEl ? voiceFallback : 0;
    }

    function syncOne(el) {
        if (!el) return;
        var isCur = !!cur && cur.url === el.dataset.url;
        var playing = isCur && !audio.paused;
        el.classList.toggle('is-current', isCur);
        el.classList.toggle('is-playing', playing);
        var icon = el.querySelector('.music-play-icon');
        if (icon) icon.innerHTML = playing
            ? '<path d="M7 5h4v14H7zM13 5h4v14h-4z"></path>'
            : '<path d="M8 5.5v13l10-6.5z"></path>';
        var probe = el.querySelector('audio');
        var total = (isCur && isFinite(audio.duration)) ? audio.duration
                  : (probe && isFinite(probe.duration) ? probe.duration : 0);
        var fill = el.querySelector('.music-msg-bar-fill');
        if (fill) fill.style.width = (isCur && total ? audio.currentTime / total * 100 : 0) + '%';
        var t = el.querySelector('.music-msg-time');
        if (t) t.textContent = isCur ? fmt(audio.currentTime) + ' / ' + fmt(total) : (total ? fmt(total) : '');
        if (probe && !probe.dataset.bound) {
            probe.dataset.bound = '1';
            probe.addEventListener('loadedmetadata', function () { syncOne(el); });
        }
    }
    var listeners = [];
function syncAll() {
    document.querySelectorAll('.music-msg').forEach(syncOne);
    listeners.forEach(function (f) { f(); });
}

    function syncBar() {
        if (!voiceEl && !cur) { bar.classList.remove('show'); return; }
        var eng = engine();
        bar.classList.add('show');
       bar.classList.toggle('is-music', !voiceEl && !!cur && !cur.isVoice);
        mbName.textContent = voiceEl ? voiceName : cur.name;
        mbPlay.innerHTML = eng.paused ? PLAY : PAUSE;
        mbTime.textContent = fmt(eng.currentTime);
        var total = totalOf(eng);
        mbFill.style.width = (total ? Math.min(100, eng.currentTime / total * 100) : 0) + '%';
    }

    function load(track) {
        cur = track;
        audio.src = track.url;
        audio.playbackRate = speeds[speedIdx];
        audio.play().catch(function () {});
        syncBar(); syncAll();
    }

    function play(track, list) {
        document.querySelectorAll('.voice-msg audio').forEach(function (a) { a.pause(); });
        voiceEl = null;
        if (typeof stopSavedAudio === 'function') stopSavedAudio();
        if (cur && cur.url === track.url) {
            if (audio.paused) audio.play().catch(function () {}); else audio.pause();
            return;
        }
        queue = (list && list.length) ? list : [track];
        index = queue.findIndex(function (x) { return x.url === track.url; });
        if (index === -1) { queue.push(track); index = queue.length - 1; }
        load(track);
    }

    function voiceStarted(el, name, fallback) {
        if (voiceEl && voiceEl !== el) voiceEl.pause();
        if (cur) {
            audio.pause(); audio.removeAttribute('src'); audio.load();
            cur = null; queue = []; index = -1;
            syncAll();
        }
        voiceEl = el;
        voiceName = name;
        voiceFallback = fallback || 0;
        el.playbackRate = speeds[speedIdx];
        syncBar();
    }
    function syncVoice(el) { if (voiceEl === el) syncBar(); }
    function voiceSibling(dir) {
        var all = Array.prototype.slice.call(document.querySelectorAll('#cmMessages .voice-msg audio'));
        var i = all.indexOf(voiceEl);
        return i === -1 ? null : (all[i + dir] || null);
    }
    function voiceEnded(el) {
        if (voiceEl !== el) return;
        var nxt = voiceSibling(1);
        if (nxt) { nxt.play().catch(function () {}); }
        else { voiceEl = null; syncBar(); }
    }

    function next() {
        if (voiceEl) {
            var n = voiceSibling(1);
            if (n) n.play().catch(function () {});
            return;
        }
        goTrack(dirNext(), repeatMode === 1);
    }
    function prev() {
        if (voiceEl) {
            if (voiceEl.currentTime > 3) { voiceEl.currentTime = 0; return; }
            var p = voiceSibling(-1);
            if (p) p.play().catch(function () {}); else voiceEl.currentTime = 0;
            return;
        }
        if (audio.currentTime > 3) { audio.currentTime = 0; return; }
        if (!goTrack(-dirNext(), repeatMode === 1)) audio.currentTime = 0;
    }
    function close() {
        if (voiceEl) { var v = voiceEl; voiceEl = null; v.pause(); }
        audio.pause(); audio.removeAttribute('src'); audio.load();
        cur = null; queue = []; index = -1;
        syncBar(); syncAll();
    }
    function seekRatio(r) {
        if (!voiceEl && !cur) return;
        var eng = engine();
        var total = totalOf(eng);
        if (total) eng.currentTime = Math.max(0, Math.min(1, r)) * total;
    }

    ['play', 'pause', 'timeupdate', 'loadedmetadata', 'durationchange'].forEach(function (ev) {
        audio.addEventListener(ev, function () { syncBar(); syncAll(); });
    });
    audio.addEventListener('ended', function () {
        if (repeatMode === 2) { audio.currentTime = 0; audio.play().catch(function () {}); return; }
        if (!goTrack(dirNext(), repeatMode === 1)) {
            audio.currentTime = 0; audio.pause(); syncBar(); syncAll();
        }
    });

    mbPlay.addEventListener('click', function () {
        if (!voiceEl && !cur) return;
        var eng = engine();
        if (eng.paused) eng.play().catch(function () {}); else eng.pause();
    });
    document.getElementById('mbNext').addEventListener('click', next);
    document.getElementById('mbPrev').addEventListener('click', prev);
    document.getElementById('mbClose').addEventListener('click', close);
    mbSpeed.addEventListener('click', function () {
        speedIdx = (speedIdx + 1) % speeds.length;
        engine().playbackRate = speeds[speedIdx];
        mbSpeed.textContent = speeds[speedIdx] + 'x';
    });
    document.getElementById('mbProgress').addEventListener('click', function (e) {
        var r = this.getBoundingClientRect();
        seekRatio((e.clientX - r.left) / r.width);
    });

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.music-msg-play');
        var barEl = e.target.closest('.music-msg-bar');
        var el = (btn || barEl) ? (btn || barEl).closest('.music-msg') : null;
        if (!el) return;
        if (btn) {
            var scope = el.closest('#cmMessages') || document;
            var list = Array.prototype.map.call(scope.querySelectorAll('.music-msg'), function (n) {
                return { url: n.dataset.url, name: n.dataset.name };
            });
            play({ url: el.dataset.url, name: el.dataset.name }, list);
        } else if (cur && cur.url === el.dataset.url) {
            var r = barEl.getBoundingClientRect();
            seekRatio((e.clientX - r.left) / r.width);
        }
    });

    return {
        play: play,
        pause: function () { audio.pause(); },
        syncOne: syncOne,
        voiceStarted: voiceStarted,
        voiceEnded: voiceEnded,
        syncVoice: syncVoice,
        onChange: function (fn) { listeners.push(fn); },
        isPlaying: function (url) { return !!cur && cur.url === url && !audio.paused; }
    };
})();

function bindMusicPlayer(player) { MusicPlayer.syncOne(player); }


          function fixVideoAspect(video) {
        function apply() {
            if (!video.videoWidth || !video.videoHeight) return;
            var ratio = video.videoWidth / video.videoHeight;
            var maxW = 320, maxH = 450;
            var w = maxW, h = maxW / ratio;
            if (h > maxH) { h = maxH; w = maxH * ratio; }
            var roundedW = Math.round(w);
            var roundedH = Math.round(h);
            video.style.width = roundedW + 'px';
            video.style.height = roundedH + 'px';
            var wrap = video.closest('.file-msg');
            if (wrap) wrap.style.width = roundedW + 'px';
            var bubble = video.closest('.media-bubble');
            if (bubble) bubble.style.width = roundedW + 'px';
        }
        if (video.readyState >= 1) apply();
        else video.addEventListener('loadedmetadata', apply, { once: true });
    }



    function scrollToBottomWhenReady() {
    cmMessages.scrollTop = cmMessages.scrollHeight;
    var media = cmMessages.querySelectorAll('img, video');
    media.forEach(function (el) {
        var evt = el.tagName === 'IMG' ? 'load' : 'loadedmetadata';
        el.addEventListener(evt, function () {
            cmMessages.scrollTop = cmMessages.scrollHeight;
        }, { once: true });
    });
}



function loadMessages(userId, opts) {
    opts = opts || {};
       var isPoll = !!opts.poll;
    var myToken = isPoll ? viewToken : ++viewToken;

    fetch(messageBaseUrl + '/' + userId + (isPoll ? '?preview=1' : ''), { headers: { 'Accept': 'application/json' } })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            if (myToken !== viewToken || activeRecipientId !== userId) return;

            var messages = data.messages || [];
            var chatUser = data.user || {};
            var isOnline = !!chatUser.online;


            activeChatMessages = messages.map(function (m) {
                return {
                    id: m.id,
                    createdAt: m.created_at,
                    text: m.body || '',
                    time: formatChatTime(m.created_at),
                    fromSelf: m.sender_id === currentUserId,
                    senderName: m.sender_id === currentUserId ? 'Siz' : (chatUser.name || cmName.textContent || 'Foydalanuvchi'),
                    audioUrl: m.audio_url || null,
                    duration: m.audio_duration || null,
                    fileUrl: m.file_url || null,
                    fileName: m.file_name || null,
                    fileMime: m.file_mime || null,
                    fileSize: m.file_size || null
                };
            });
            if (rightPanelMode === 'contact') renderContactStats();



            if (!isPoll) {
                // Chat birinchi marta ochilganda yoki almashtirilganda — to'liq qayta chizamiz
                cmMessages.innerHTML = '';
                cmEmptyState = null;
                renderedMessageIds = [];
                messages.forEach(appendMessage);

                   // ⬇⬇⬇ SHU YERGA ⬇⬇⬇
    var lastAny = messages[messages.length - 1];
    if (lastAny) notifSeed('u:' + userId, notifTimestamp(lastAny));
    // ⬆⬆⬆
               
                           if (!messages.length) {
                    cmMessages.innerHTML = '<div class="cm-empty" id="cmEmptyState"><b>Hali hech qanday xabar yo\'q</b><span>Suhbatni boshlash uchun xabar yozing.</span></div>';
                    cmEmptyState = document.getElementById('cmEmptyState');
                }
                scrollToBottomWhenReady();
            } else {
                // Fon rejimida (5 soniyalik) yangilanish — faqat YANGI xabarlarni qo'shamiz,
                // ro'yxatni butunlay qayta chizmaymiz va foydalanuvchi tepada o'qiyotgan bo'lsa pastga surmaymiz.
                              var newOnes = messages.filter(function (m) {
                    return renderedMessageIds.indexOf(messageKey(m)) === -1;
                });
                if (newOnes.length) {
                    var wasNearBottom = (cmMessages.scrollTop + cmMessages.clientHeight) >= (cmMessages.scrollHeight - 80);
                    newOnes.forEach(appendMessage);
                   
  // ⬇⬇⬇ SHU YERGA ⬇⬇⬇
    var lastIn = newOnes.filter(function (m) { return m.sender_id !== currentUserId; }).pop();
    var pollItem = chatItemsWrap.querySelector('.cl-item[data-user-id="' + userId + '"]');
    if (lastIn && pollItem) maybeNotify('u:' + userId, notifTimestamp(lastIn), pollItem, pollItem.dataset.name, notifMessageText(lastIn));
    // ⬆⬆⬆


                    if (wasNearBottom) {
                        cmMessages.scrollTop = cmMessages.scrollHeight;
                    }
                }
            }

              activeRecipientProfile = chatUser;
              applyPeerBubbleColor(chatUser.bubble_color);
                            window.__peerQuiet = chatUser.quiet_now ? { message: chatUser.quiet_message, name: chatUser.name } : null;
              window.dispatchEvent(new Event('chatovbs:view-change'));
          cmStatus.textContent = chatUser.username ? '@' + chatUser.username + ' · ' + computeStatusText(chatUser) : computeStatusText(chatUser);
cmStatus.classList.toggle('cm-status-online', isOnline);
syncRightPanelForContext(); // profil panel ochiq bo'lsa, uni ham yangi holat bilan yangilaydi
            var chatItem = chatItemsWrap.querySelector('.cl-item[data-user-id="' + userId + '"]');
            if (chatItem) chatItem.querySelector('.cl-avatar').classList.toggle('online', isOnline);
        });
}


function loadEntityMessages(entityId, isDiscussionChat) {
    if (!entityId) return;
    entityId = String(entityId);
    var myToken = ++viewToken;
    var isChat = !!isDiscussionChat;
    activeIsDiscussionChat = isChat;

    entityViewReady = false;
    renderedMessageIds = [];
    activeEntityUnreadIds = [];
    entityReadObserver.disconnect();
    viewObserver.disconnect();

    if (isChat) {
        var forwardChannelItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="channel"]');
        var forwardOpts = null;
        if (forwardChannelItem) {
            var forwardAvatarEl = forwardChannelItem.querySelector('.cl-avatar');
            forwardOpts = {
                channelName: forwardChannelItem.dataset.name,
                channelAvatarHtml: forwardAvatarEl ? forwardAvatarEl.innerHTML : '',
                channelColor: forwardChannelItem.dataset.color || 'var(--accent)',
                noFooter: true,
                badgeLabel: 'kanal'
            };
        }
        activeChannelOpts = { forceIn: true, forwardOpts: forwardOpts };
    } else {
        var activeItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="channel"]');
        if (activeItem) {
            var avatarEl = activeItem.querySelector('.cl-avatar');
            activeChannelOpts = {
                channelName: activeItem.dataset.name,
                channelAvatarHtml: avatarEl ? avatarEl.innerHTML : '',
                channelColor: activeItem.dataset.color || 'var(--accent)',
                linkedChatEntityId: entityId,
                hideAvatar: true
            };
        } else {
            activeChannelOpts = null;
        }
    }

    var kind = isChat ? 'chat' : 'channel';
    var scope = entityId + ':' + kind;
    var baseUrl = isChat ? entityChatsBaseUrl : entityMessagesBaseUrl;

    fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
        .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
        .then(function (data) {
            // tez almashtirilgan bo'lsa, eski javob tashlab yuboriladi
            if (myToken !== viewToken || activeEntityId !== entityId || activeIsDiscussionChat !== isChat) return;

            var messages = sortEntityMessages(data.messages || []);
            cmMessages.innerHTML = '';
            cmEmptyState = null;
            renderedMessageIds = [];
            if (messages.length) notifSeed('e:' + entityId + ':' + kind, notifTimestamp(messages[messages.length - 1]));

            var lastSeenTs = getEntityLastSeen(entityId, kind);
                        var unreadKeys = messages.filter(function (m) {
                if (isSelfSentIn(m, isChat)) return false;
                return lastSeenTs === null || msgTs(m) > lastSeenTs;
            }).map(messageKey);
            activeEntityUnreadIds = unreadKeys.slice();
            var firstUnreadKey = unreadKeys.length ? unreadKeys[0] : null;

            messages.forEach(function (message) {
                var key = messageKey(message);
                if (firstUnreadKey !== null && key === firstUnreadKey) {
                    var divider = document.createElement('div');
                    divider.id = 'unreadDivider';
                    divider.className = 'day-divider';
                    divider.textContent = unreadKeys.length + " ta o'qilmagan xabar";
                    cmMessages.appendChild(divider);
                }
                appendMessage(message, entityMsgOpts(message));
                if (unreadKeys.indexOf(key) !== -1) {
                    var row = cmMessages.querySelector('.msg-row[data-message-key="' + key + '"]');
                    if (row) { row.dataset.scope = scope; entityReadObserver.observe(row); }
                }
            });

            updateEntityUnreadBadge(entityId, kind, activeEntityUnreadIds.length);

            if (!messages.length) {
                cmMessages.innerHTML = '<div class="cm-empty" id="cmEmptyState"><b>Hali hech qanday xabar yo\'q</b><span>' +
                    (isChat ? 'Birinchi xabarni yozing.' : 'Kanalga birinchi xabarni yuboring.') + '</span></div>';
                cmEmptyState = document.getElementById('cmEmptyState');
            }

            entityViewReady = true;

            if (firstUnreadKey !== null) {
                requestAnimationFrame(function () {
                    var d = document.getElementById('unreadDivider');
                    if (d) d.scrollIntoView({ block: 'center' });
                });
            } else {
                scrollToBottomWhenReady();
            }
        })
        .catch(function () {});
}

function loadEntityMessages_OLD(entityId, isDiscussionChat) {
    if (!entityId) return;
    var myToken = ++viewToken;
    activeIsDiscussionChat = !!isDiscussionChat;

       if (activeIsDiscussionChat) {
        var forwardChannelItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="channel"]');
        var forwardOpts = null;
        if (forwardChannelItem) {
            var forwardAvatarEl = forwardChannelItem.querySelector('.cl-avatar');
            forwardOpts = {
                channelName: forwardChannelItem.dataset.name,
                channelAvatarHtml: forwardAvatarEl ? forwardAvatarEl.innerHTML : '',
                channelColor: forwardChannelItem.dataset.color || 'var(--accent)',
                noFooter: true,
                badgeLabel: 'kanal'
            };
        }
        activeChannelOpts = { forceIn: true, forwardOpts: forwardOpts };
     } else {
        var activeItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="channel"]');
        if (activeItem) {
            var avatarEl = activeItem.querySelector('.cl-avatar');
            activeChannelOpts = {
                channelName: activeItem.dataset.name,
                channelAvatarHtml: avatarEl ? avatarEl.innerHTML : '',
                channelColor: activeItem.dataset.color || 'var(--accent)',
                linkedChatEntityId: entityId,
                hideAvatar: true
            };
        } else {
            activeChannelOpts = null;
        }
    }

    var baseUrl = activeIsDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl;
    var kind = activeIsDiscussionChat ? 'chat' : 'channel';
    fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
        .then(function (response) { return response.json(); })
        .then(function (data) {
            if (myToken !== viewToken || activeEntityId !== String(entityId)) return;
            var messages = data.messages || [];
            cmMessages.innerHTML = '';
            cmEmptyState = null;
            renderedMessageIds = [];

            var lastSeenId = getEntityLastSeen(entityId, kind);
            var unreadIds = messages.filter(function (m) {
                if (m.sender_id === currentUserId && !m.is_channel_post) return false;
                if (lastSeenId === null) return true;
                return Number(m.id) > Number(lastSeenId);
            }).map(function (m) { return String(m.id); });
            activeEntityUnreadIds = unreadIds.slice();

            var firstUnreadId = unreadIds.length ? unreadIds[0] : null;

            messages.forEach(function (message) {
                var perMsgOpts = activeChannelOpts;
                if (activeChannelOpts && activeChannelOpts.forceIn) {
                    if (isSentMessage(entityId, message.id)) {
                        perMsgOpts = { forceOut: true };
                    } else if (message.is_channel_post && activeChannelOpts.forwardOpts) {
                        perMsgOpts = activeChannelOpts.forwardOpts;
                    } else {
                        perMsgOpts = { forceIn: true };
                    }
                }

                if (firstUnreadId !== null && String(message.id) === firstUnreadId) {
                    var divider = document.createElement('div');
                    divider.id = 'unreadDivider';
                    divider.className = 'day-divider';
                    divider.style.alignSelf = 'center';
                    divider.textContent = unreadIds.length + " ta o'qilmagan xabar";
                    cmMessages.appendChild(divider);
                }

                appendMessage(message, perMsgOpts);

                if (unreadIds.indexOf(String(message.id)) !== -1) {
                    var row = cmMessages.querySelector('.msg-row[data-message-id="' + message.id + '"]');
                    if (row) entityReadObserver.observe(row);
                }
            });

            updateEntityUnreadBadge(entityId, kind, activeEntityUnreadIds.length);

            if (!messages.length) {
                cmMessages.innerHTML = '<div class="cm-empty" id="cmEmptyState"><b>Hali hech qanday xabar yo\'q</b><span>Kanalga birinchi xabarni yuboring.</span></div>';
                cmEmptyState = document.getElementById('cmEmptyState');
            }

            if (firstUnreadId !== null) {
                requestAnimationFrame(function () {
                    var divider = document.getElementById('unreadDivider');
                    if (divider) divider.scrollIntoView({ block: 'center' });
                });
            } else {
                scrollToBottomWhenReady();
            }
        })
        .catch(function () {});
}

   setInterval(function () {
   if (activeRecipientId && shouldPollForNotifications()) loadMessages(activeRecipientId, { poll: true });
}, 8000);
    setInterval(pollNotificationFeed, 8000);
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'visible') pollNotificationFeed();
    });

    setInterval(function () {
       if (!shouldPollForNotifications()) return;
        chatItemsWrap.querySelectorAll('.cl-item').forEach(function (item) {
            var userId = item.dataset.userId;
            if (!userId || userId === 'saved' || Number(userId) === activeRecipientId) return;
            fetch(messageBaseUrl + '/' + userId + '?preview=1', { headers: { 'Accept': 'application/json' } })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    var messages = data.messages || [];
                    updateChatListPreview(userId, messages[messages.length - 1], data.unread_count);
                })
                .catch(function () {});
        });
    }, 8000);



    // ⬇⬇⬇ YANGI QO'SHILADIGAN QISM SHU YERGA ⬇⬇⬇
    setInterval(function () {
        if (!shouldPollForNotifications()) return;
        var seen = {};
        chatItemsWrap.querySelectorAll('.cl-item[data-entity-backend-id]').forEach(function (item) {
            var id = item.dataset.entityBackendId;
            var kind = item.dataset.kind;
            var key = id + ':' + kind;
            if (seen[key]) return;
            seen[key] = true;
            updateEntityListPreview(id, kind === 'chat');
        });
    }, 8000);


        function pollEntityMessages() {
    if (!activeEntityId || !entityViewReady || !shouldPollForNotifications()) return;
        var entityId = activeEntityId;
        var isChat = activeIsDiscussionChat;
        var token = viewToken;
        var baseUrl = isChat ? entityChatsBaseUrl : entityMessagesBaseUrl;

        fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (token !== viewToken || !entityViewReady ||
                    activeEntityId !== entityId || activeIsDiscussionChat !== isChat) return;

                var newOnes = sortEntityMessages(data.messages || []).filter(function (m) {
                    return renderedMessageIds.indexOf(messageKey(m)) === -1;
                });
                if (!newOnes.length) return;

                var wasNearBottom = (cmMessages.scrollTop + cmMessages.clientHeight) >= (cmMessages.scrollHeight - 80);
                var notificationKey = 'e:' + entityId + ':' + (isChat ? 'chat' : 'channel');
                newOnes.forEach(function (message) {
                    appendMessage(message, entityMsgOpts(message));
                    activeChatMessages.push(mapEntityMessageForMedia(message, cmName.textContent || 'Kanal'));
                    var notificationTime = notifTimestamp(message);
                    if (isSelfSent(message)) {
                        notifSeed(notificationKey, notificationTime);
                    } else {
                        var chatItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + entityId + '"][data-kind="' + (isChat ? 'chat' : 'channel') + '"]');
                        var senderAvatar = message.sender_avatar || null;
                        maybeNotify(notificationKey, notificationTime, chatItem, message.sender_name || (chatItem && chatItem.dataset.name) || cmName.textContent, notifMessageText(message), { avatarUrl: senderAvatar });
                    }
                });
                if (!document.hidden && document.hasFocus()) {
                    setEntityLastSeen(entityId, isChat ? 'chat' : 'channel', msgTs(newOnes[newOnes.length - 1]));
                    activeEntityUnreadIds = [];
                } else {
                    newOnes.forEach(function (message) {
                        if (isSelfSentIn(message, isChat)) return;
                        var key = messageKey(message);
                        if (activeEntityUnreadIds.indexOf(key) === -1) activeEntityUnreadIds.push(key);
                    });
                }
                updateEntityUnreadBadge(entityId, isChat ? 'chat' : 'channel', activeEntityUnreadIds.length);
                if (rightPanelMode === 'channel') renderChannelStats();
                if (wasNearBottom) cmMessages.scrollTop = cmMessages.scrollHeight;
            })
            .catch(function () {});
    }

    function pollEntityMessages_OLD() {
        if (!activeEntityId || document.visibilityState !== 'visible') return;
        var entityId = activeEntityId;
        var isChat = activeIsDiscussionChat;
        var baseUrl = isChat ? entityChatsBaseUrl : entityMessagesBaseUrl;

              fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (activeEntityId !== entityId || activeIsDiscussionChat !== isChat) return;
                var newOnes = (data.messages || []).filter(function (m) {
                    return renderedMessageIds.indexOf(m.id) === -1;
                });
                if (!newOnes.length) return;

                var wasNearBottom = (cmMessages.scrollTop + cmMessages.clientHeight) >= (cmMessages.scrollHeight - 80);

                                                  newOnes.forEach(function (message) {
                    var perMsgOpts = activeChannelOpts;
                    if (activeChannelOpts && activeChannelOpts.forceIn) {
                        if (isSentMessage(entityId, message.id)) {
                            perMsgOpts = { forceOut: true };
                        } else if (message.is_channel_post && activeChannelOpts.forwardOpts) {
                            perMsgOpts = activeChannelOpts.forwardOpts;
                        } else {
                            perMsgOpts = { forceIn: true };
                        }
                    }
                    appendMessage(message, perMsgOpts);
                    activeChatMessages.push(mapEntityMessageForMedia(message, cmName.textContent || 'Kanal'));
                });

                setEntityLastSeen(entityId, isChat ? 'chat' : 'channel', newOnes[newOnes.length - 1].id);

                if (rightPanelMode === 'channel') renderChannelStats();

                if (wasNearBottom) cmMessages.scrollTop = cmMessages.scrollHeight;
            })
            .catch(function () {});
    }

    setInterval(pollEntityMessages, 8000);
    // ⬆⬆⬆ YANGI QISM SHU YERGACHA ⬆⬆⬆

    function openUserChat(user) {
        activeRecipientUser = user;
        var item = addUserToChatList(user);
        activeRecipientId = Number(user.id);
        item.click();
    }

     function openSearchPanel() {
        clSearchPanel.classList.add('open');
        mainChatListView.classList.add('searching');
        clSearchBox.classList.add('search-focused');
        runSearch(clSearchInput.value);
    }
    function closeSearchPanel() {
        clSearchPanel.classList.remove('open');
        mainChatListView.classList.remove('searching');
        clSearchBox.classList.remove('search-focused');
    }

    clSearchInput.addEventListener('focus', openSearchPanel);
    clSearchInput.addEventListener('input', function () {
        clSearchBox.classList.toggle('has-text', clSearchInput.value.length > 0);
        runSearch(clSearchInput.value);
    });
    clSearchClear.addEventListener('click', function () {
        clSearchInput.value = '';
        clSearchBox.classList.remove('has-text');
        clSearchInput.blur();
        closeSearchPanel();
    });
      document.addEventListener('click', function (e) {
        if (!e.target.closest('#clSearchWrap') && !e.target.closest('#clSearchPanel')) closeSearchPanel();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSearchPanel();
    });

    function bindChatItemEvents(singleItem) {
        var chatItems = singleItem ? [singleItem] : chatItemsWrap.querySelectorAll('.cl-item');
    chatItems.forEach(function (item) {
        item.addEventListener('click', function () {
            if (item.dataset.kind === 'saved') {
                openSavedMessages();
                chatItemsWrap.querySelectorAll('.cl-item').forEach(function (i) { i.classList.remove('active'); });
                item.classList.add('active');
                return;
            }
                                if (item.dataset.kind === 'channel' || item.dataset.kind === 'group' || item.dataset.kind === 'chat') {
                               activeRecipientId = null;
                activeRecipientUser = null;
                activeRecipientProfile = null;
                setItemState(item, { markedUnread: false });
                activeEntityId = item.dataset.entityBackendId || null;
                activeIsDiscussionChat = (item.dataset.kind === 'chat');
                activeChatMessages = [];
                chatItemsWrap.querySelectorAll('.cl-item').forEach(function (i) { i.classList.remove('active'); });
                item.classList.add('active');
                var entityIcon = item.dataset.kind === 'channel'
                    ? '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m3 11 18-5-5 18-4-8-9-5Z"/><path d="m12 16 5-10"/></svg>'
                    : '<svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"/><path d="M8 11h8M8 15h5"/></svg>';
                var created = new Date(item.dataset.createdAt || Date.now());
                var months = ['yanvar', 'fevral', 'mart', 'aprel', 'may', 'iyun', 'iyul', 'avgust', 'sentabr', 'oktabr', 'noyabr', 'dekabr'];
                var createdLabel = created.getDate() + '-' + months[created.getMonth()];
                var entityType = item.dataset.kind === 'channel' ? 'kanal' : (item.dataset.kind === 'chat' ? 'suhbat' : 'guruh');
                var createdText = item.dataset.kind === 'channel' ? 'Kanal yaratildi' : (item.dataset.kind === 'chat' ? 'Suhbat yaratildi' : 'Guruh yaratildi');
                                savedSubBackBtn.style.display = 'none';
                              showInternalView(item.dataset.name, item.dataset.status, '<div class="internal-list__empty entity-detail">' + entityIcon + '<h3>' + escapeHtml(item.dataset.name) + '</h3><p>' + createdLabel + '</p><strong>' + createdText + '</strong><span>Bu ' + entityType + ' Chatovbs menyusiga qo‘shildi.</span></div>', item.dataset.kind);
                syncRightPanelForContext();
                loadEntityMessages(activeEntityId, item.dataset.kind === 'chat');

document.getElementById('cmCallBtn').style.display = 'none';

var discussBtnEl = document.getElementById('cmDiscussBtn');
discussBtnEl.style.display = 'flex';
discussBtnEl.onclick = function (e) {
    e.stopPropagation();
    openVoiceChatMenu(discussBtnEl);
};


                return;
            }
                                  activeInternalView = '';
            window.__activeInternalView = '';
            window.dispatchEvent(new Event('chatovbs:view-change'));
            activeEntityId = null;
            activeChannelOpts = null;
            document.body.classList.add('chat-open');
            cmComposer.style.display = 'flex';
            openChatBar.style.display = 'none';
            msgInput.placeholder = 'Xabar yozing...';
                cmMessages.classList.remove('saved-view');
                document.getElementById('mmSaved').classList.remove('selected');
                if (typeof clearReply === 'function') clearReply();
                if (typeof exitSelectionMode === 'function') exitSelectionMode();
                if (typeof hidePinnedBanner === 'function') hidePinnedBanner();
                editingRow = null;
                chatItemsWrap.querySelectorAll('.cl-item').forEach(function (i) { i.classList.remove('active'); });
                item.classList.add('active');

            savedSubBackBtn.style.display = 'none';
             cmAvatar.style.display = 'flex';
            cmName.textContent = item.dataset.name;
                cmStatus.textContent = item.dataset.status;
                cmStatus.classList.remove('cm-status-online');   // ⬅ YANGI QATOR
                cmAvatar.style.background = item.dataset.color;
                cmAvatar.innerHTML = item.querySelector('.cl-avatar').innerHTML;
                                activeRecipientId = Number(item.dataset.userId) || null;
                                               
                applyPeerBubbleColor(null);
                                window.__peerQuiet = null;
                syncRightPanelForContext();
                document.getElementById('cmCallBtn').style.display = activeRecipientId ? 'flex' : 'none';
                document.getElementById('cmDiscussBtn').style.display = 'none';
                setItemState(item, { markedUnread: false });
                if (activeRecipientId) loadMessages(activeRecipientId);

                var badge = item.querySelector('.cl-unread');
                if (badge) badge.remove();
                updateRailCounts();

                if (window.innerWidth <= 860) {
                    document.getElementById('chatListPanel').classList.add('hidden');
                }
            });
        });
    }
    bindChatItemEvents();
    restoreRecentUsers();
    loadChatList();
    ensureSavedChatItem();
    loadSavedChatPreview();
    updateRailCounts();






    // ================= ITEM CONTEXT MENU (chap paneldagi chatga o'ng tugma) =================
var itemContextMenu = document.getElementById('itemContextMenu');
var itemContextTarget = null;

function itemStateId(item) {
    return item.dataset.kind + ':' + (item.dataset.userId || item.dataset.entityBackendId || 'saved');
}
function getItemState(item) {
    try { return JSON.parse(localStorage.getItem('chatovbs_item_state_' + itemStateId(item)) || '{}'); }
    catch (e) { return {}; }
}
function setItemState(item, patch) {
    var s = getItemState(item);
    Object.keys(patch).forEach(function (k) { s[k] = patch[k]; });
    localStorage.setItem('chatovbs_item_state_' + itemStateId(item), JSON.stringify(s));
    return s;
}
function applyArchivedVisibility() {
    var archContainer = document.getElementById('archivedChatItems');
    var archView = document.getElementById('archivedChatsView');
    var inArchiveView = archView && archView.style.display !== 'none';

    var all = Array.prototype.slice.call(chatItemsWrap.querySelectorAll('.cl-item'))
        .concat(Array.prototype.slice.call(archContainer.querySelectorAll('.cl-item')));

    var archivedCount = 0;
    all.forEach(function (item) {
        var archived = !!getItemState(item).archived;
        item.classList.toggle('is-archived', archived);
        if (archived) archivedCount++;

        // Arxivdan chiqarilgan chat asosiy ro'yxatga qaytadi
        if (!archived && item.parentNode === archContainer) {
            chatItemsWrap.appendChild(item);
        }
        // Arxiv oynasi ochiq paytda arxivlangan chat arxiv ro'yxatiga o'tadi
        if (archived && inArchiveView && item.parentNode === chatItemsWrap) {
            archContainer.appendChild(item);
        }
    });

    var emptyEl = archContainer.querySelector('.cl-empty');
    if (emptyEl) {
        emptyEl.style.display = archContainer.querySelector('.cl-item') ? 'none' : '';
    }

    var countEl = document.getElementById('clArchivedCount');
    var subEl = document.getElementById('clArchivedSubtext');
    if (countEl) countEl.textContent = archivedCount;
    if (subEl) subEl.textContent = archivedCount ? archivedCount + " ta suhbat" : "Hozircha yo'q";

    sortChatItems();
}
applyArchivedVisibility();

function openItemContextMenu(item, x, y) {
    itemContextTarget = item;
    var kind = item.dataset.kind;
    var state = getItemState(item);
    var isSaved = kind === 'saved';
    var isPersonal = kind === 'personal';
    var isGroupLike = (kind === 'channel' || kind === 'chat' || kind === 'group');

    var archiveBtn = document.getElementById('itemArchiveBtn');
    archiveBtn.style.display = isSaved ? 'none' : 'flex';
    document.getElementById('itemArchiveLabel').textContent = state.archived ? "Arxivdan chiqarish" : "Arxivlash";

document.getElementById('itemPinLabel').textContent = state.pinned ? "Qadashni olib tashlash" : "Qadash";

     var muteSubmenuWrapEl = document.getElementById('muteSubmenuWrap');
    var muteBtn = document.getElementById('itemMuteBtn');
    var muteChevronEl = document.getElementById('muteChevron');
    muteSubmenuWrapEl.style.display = isSaved ? 'none' : 'flex';
    document.getElementById('itemMuteLabel').textContent = state.muted ? "Ovozni yoqish" : "Ovozsiz qilish";
    muteChevronEl.style.display = state.muted ? 'none' : 'block';
    muteBtn.dataset.action = state.muted ? 'mute' : '';
    muteBtn.classList.toggle('no-chevron', !!state.muted);   // ⬅ YANGI QATOR // muted bo'lsa oddiy bosish orqali yoqiladi

    var hasUnread = !!item.querySelector('.cl-unread');
    document.getElementById('itemReadLabel').textContent = hasUnread ? "O'qilgan deb belgilash" : "O'qilmagan deb belgilash";

    document.getElementById('itemBlockBtn').style.display = isPersonal ? 'flex' : 'none';
    document.getElementById('itemBlockSep').style.display = isPersonal ? 'block' : 'none';

    var dangerLabel = isSaved ? "Suhbatni o'chirish"
        : kind === 'channel' ? "Kanaldan chiqish"
        : isGroupLike ? "Guruhdan chiqish"
        : "Suhbatni o'chirish";
    document.getElementById('itemDangerLabel').textContent = dangerLabel;
    document.getElementById('itemDangerIcon').innerHTML = isGroupLike
        ? '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>'
        : '<polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path>';



                  if (typeof folderSubmenu !== 'undefined' && folderSubmenu) folderSubmenu.classList.remove('show');
    if (typeof muteSubmenu !== 'undefined' && muteSubmenu) muteSubmenu.classList.remove('show');   // ⬅ YANGI QATOR
    closeAllDropdowns();
    msgContextMenu.classList.remove('show');
    itemContextMenu.style.left = Math.min(x, window.innerWidth - 240) + 'px';
    itemContextMenu.style.top = Math.min(y, window.innerHeight - 380) + 'px';
    itemContextMenu.classList.add('show');
}

function handleItemMenuAction(action, item) {
    var kind = item.dataset.kind;
    switch (action) {
        case 'openWindow':
            window.open(window.location.href, '_blank');
            break;
        case 'archive':
            setItemState(item, { archived: !getItemState(item).archived });
            applyArchivedVisibility();
            break;
    case 'pin': {
    var nowPinned = !getItemState(item).pinned;
    setItemState(item, { pinned: nowPinned, pinnedAt: nowPinned ? Date.now() : 0 });
    sortChatItems();
    chatItemsWrap.scrollTop = 0;
    break;
}
        case 'mute':
            setItemState(item, { muted: !getItemState(item).muted });
            break;
         case 'toggleRead': {
            if (item.querySelector('.cl-unread')) markItemAsRead(item);
            else markItemAsUnread(item);
            break;
        }
        case 'block':
            if (confirm("Foydalanuvchini blocklashni tasdiqlaysizmi?")) {
                setItemState(item, { blocked: true });
                alert("Foydalanuvchi bloklandi.");
            }
            break;
             case 'clearHistory':
            tgClearHistory(item);
            break;
          case 'danger': {
            var isGroupLike = (kind === 'channel' || kind === 'chat' || kind === 'group');
            if (isGroupLike) { tgLeaveEntity(item); break; }
            tgDeleteChat(item);
            break;
        }
    }
}

chatItemsWrap.addEventListener('contextmenu', function (e) {
    var item = e.target.closest('.cl-item');
    if (!item) return;
    e.preventDefault();
    openItemContextMenu(item, e.clientX, e.clientY);
});

var archivedChatItemsWrap = document.getElementById('archivedChatItems');
archivedChatItemsWrap.addEventListener('contextmenu', function (e) {
    var item = e.target.closest('.cl-item');
    if (!item) return;
    e.preventDefault();
    openItemContextMenu(item, e.clientX, e.clientY);
});

itemContextMenu.addEventListener('click', function (e) {
    var btn = e.target.closest('button[data-action]');
    if (!btn || !itemContextTarget) return;
    handleItemMenuAction(btn.dataset.action, itemContextTarget);
    itemContextMenu.classList.remove('show');
});





document.addEventListener('click', function (e) {
    if (!e.target.closest('#itemContextMenu')) itemContextMenu.classList.remove('show');
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') itemContextMenu.classList.remove('show');
});




// ---- Papkaga qo'shish submenu ----
var folderMenuBtn = document.getElementById('folderMenuBtn');
var folderSubmenu = document.getElementById('folderSubmenu');
var folderSubmenuWrap = document.getElementById('folderSubmenuWrap');
var folderSubmenuTimeout = null;

function openFolderSubmenu() {
    var r = folderMenuBtn.getBoundingClientRect();
    var subWidth = 210;
    var left = r.right + 4;
    if (left + subWidth > window.innerWidth) left = r.left - subWidth - 4;
    folderSubmenu.style.left = left + 'px';
    folderSubmenu.style.top = Math.min(r.top, window.innerHeight - 220) + 'px';
    folderSubmenu.classList.add('show');
}
function closeFolderSubmenu() {
    folderSubmenu.classList.remove('show');
}

folderMenuBtn.addEventListener('mouseenter', function () {
    clearTimeout(folderSubmenuTimeout);
    openFolderSubmenu();
});
folderMenuBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    if (folderSubmenu.classList.contains('show')) closeFolderSubmenu();
    else openFolderSubmenu();
});
folderSubmenuWrap.addEventListener('mouseleave', function () {
    folderSubmenuTimeout = setTimeout(closeFolderSubmenu, 200);
});
folderSubmenu.addEventListener('mouseenter', function () {
    clearTimeout(folderSubmenuTimeout);
});
folderSubmenu.addEventListener('mouseleave', function () {
    folderSubmenuTimeout = setTimeout(closeFolderSubmenu, 200);
});
folderSubmenu.addEventListener('click', function (e) {
    var btn = e.target.closest('button[data-folder]');
    if (!btn) return;
    e.stopPropagation();
    closeFolderSubmenu();
    itemContextMenu.classList.remove('show');
    showComingSoon();
});






// ⬇⬇⬇ YANGI BLOK SHU YERGA QO'YILADI ⬇⬇⬇
// ---- Ovozsiz qilish submenu (Mute notifications) ----
var muteMenuBtn = document.getElementById('itemMuteBtn');
var muteSubmenu = document.getElementById('muteSubmenu');
var muteSubmenuWrap = document.getElementById('muteSubmenuWrap');
var muteSubmenuTimeout = null;

function openMuteSubmenu() {
    var r = muteMenuBtn.getBoundingClientRect();
    var subWidth = 220;
    var left = r.right + 4;
    if (left + subWidth > window.innerWidth) left = r.left - subWidth - 4;
    muteSubmenu.style.left = left + 'px';
    muteSubmenu.style.top = Math.min(r.top, window.innerHeight - 200) + 'px';
    muteSubmenu.classList.add('show');
}
function closeMuteSubmenu() {
    muteSubmenu.classList.remove('show');
}

muteMenuBtn.addEventListener('mouseenter', function () {
    if (getItemState(itemContextTarget).muted) return;
    clearTimeout(muteSubmenuTimeout);
    openMuteSubmenu();
});
muteMenuBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    var state = getItemState(itemContextTarget);
    if (state.muted) {
        handleItemMenuAction('mute', itemContextTarget);
        itemContextMenu.classList.remove('show');
        closeMuteSubmenu();
        return;
    }
    if (muteSubmenu.classList.contains('show')) closeMuteSubmenu();
    else openMuteSubmenu();
});
muteSubmenuWrap.addEventListener('mouseleave', function () {
    muteSubmenuTimeout = setTimeout(closeMuteSubmenu, 200);
});
muteSubmenu.addEventListener('mouseenter', function () {
    clearTimeout(muteSubmenuTimeout);
});
muteSubmenu.addEventListener('mouseleave', function () {
    muteSubmenuTimeout = setTimeout(closeMuteSubmenu, 200);
});
muteSubmenu.addEventListener('click', function (e) {
    var btn = e.target.closest('button[data-mute-option]');
    if (!btn || !itemContextTarget) return;
    e.stopPropagation();
    var option = btn.dataset.muteOption;

    if (option === 'disable' || option === 'forever') {
        setItemState(itemContextTarget, { muted: true });
    } else {
        showComingSoon();
        closeMuteSubmenu();
        itemContextMenu.classList.remove('show');
        return;
    }

    closeMuteSubmenu();
    itemContextMenu.classList.remove('show');
});
// ⬆⬆⬆ YANGI BLOK SHU YERGACHA ⬆⬆⬆


    function openArchivedChatsView() {
        mainChatListView.style.display = 'none';
        archivedChatsView.style.display = 'flex';
        var archived = Array.prototype.slice.call(chatItemsWrap.querySelectorAll('.cl-item.is-archived'));
        var container = document.getElementById('archivedChatItems');
        var emptyEl = container.querySelector('.cl-empty');
        if (archived.length) {
            if (emptyEl) emptyEl.style.display = 'none';
            archived.forEach(function (item) { container.appendChild(item); });
        } else if (emptyEl) {
            emptyEl.style.display = '';
        }
    }
    function closeArchivedChatsView() {
        archivedChatsView.style.display = 'none';
        mainChatListView.style.display = 'flex';
        var container = document.getElementById('archivedChatItems');
        Array.prototype.slice.call(container.querySelectorAll('.cl-item')).forEach(function (item) {
            chatItemsWrap.appendChild(item);
        });
        sortChatItems();
        applyArchivedVisibility();
    }

    clArchivedRow.addEventListener('click', openArchivedChatsView);
    document.getElementById('archivedBackGroup').addEventListener('click', closeArchivedChatsView);

    
    // ---------- Main menu (hamburger) flyout — Telegram-style open/close ----------
    var mainMenuBtn = document.getElementById('mainMenuBtn');
    var mainMenuOverlay = document.getElementById('mainMenuOverlay');
    var mainMenu = document.getElementById('mainMenu');

    // Stagger each row's transition-delay so they cascade in, like Telegram's menu.
    function applyStagger() {
        var rows = mainMenu.querySelectorAll('.mm-account, .mm-add-account, .mm-item');
        rows.forEach(function (row, i) {
            row.style.transitionDelay = (i * 6) + 'ms';
        });
    }

    function clearStagger() {
        var rows = mainMenu.querySelectorAll('.mm-account, .mm-add-account, .mm-item');
        rows.forEach(function (row) { row.style.transitionDelay = ''; });
    }

   function openMainMenu() {
    mainMenu.scrollTop = 0;
    applyStagger();
    mainMenuOverlay.classList.add('open');
    mainMenuBtn.classList.add('menu-open');
}
    function closeMainMenu() {
        mainMenuOverlay.classList.remove('open');
        mainMenuBtn.classList.remove('menu-open');
        clearStagger();
    }
    mainMenuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (mainMenuOverlay.classList.contains('open')) {
            closeMainMenu();
        } else {
            openMainMenu();
        }
    });
    mainMenuOverlay.addEventListener('click', function (e) {
        if (e.target === mainMenuOverlay) closeMainMenu();
    });
    mainMenu.addEventListener('click', function (e) {
        e.stopPropagation();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMainMenu();
    });


    // Night mode toggle
    var mmNightModeToggle = document.getElementById('mmNightModeToggle');
    var nightModeEnabled = localStorage.getItem('chatovbs_night_mode') === '1';

    function applyTheme() {
        document.body.classList.toggle('night-mode', nightModeEnabled);
        document.body.classList.toggle('day-mode', !nightModeEnabled);
        mmNightModeToggle.classList.toggle('on', nightModeEnabled);
    }

    applyTheme();
    document.getElementById('mmNightMode').addEventListener('click', function () {
        nightModeEnabled = !nightModeEnabled;
        localStorage.setItem('chatovbs_night_mode', nightModeEnabled ? '1' : '0');
        applyTheme();
    });

    // Items that just navigate somewhere (if a real route was rendered) and close the menu
    ['mmProfile', 'mmSettings'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', function () {
            var href = el.dataset.href;
            closeMainMenu();
            if (href && href !== '#') {
                window.location.href = href;
            }
        });
    });

    // Menu items navigate to their authenticated backend pages.
    ['mmNewGroup', 'mmNewChannel'].forEach(function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', function () {
            var href = el.dataset.href;
            closeMainMenu();
            if (href && href !== '#') window.location.href = href;
        });
    });

    var activeInternalView = '';
    window.__activeInternalView = '';
        function isQuietBlocked() {
        return !!window.__quietLocked && activeInternalView !== 'saved';
    }
    var activeChannelOpts = null;
    // Saved Messages belongs to the authenticated account and is loaded from the server.
    var savedMessages = [];
    var activeChatMessages = [];

 function showInternalView(title, status, content, mode) {
    applyPeerBubbleColor(null);
        window.__peerQuiet = null;
    activeInternalView = mode;
    window.__activeInternalView = mode;
    window.dispatchEvent(new Event('chatovbs:view-change'));
    document.body.classList.add('chat-open');
    cmAvatar.style.display = 'none';
    cmComposer.style.display = 'flex';
    openChatBar.style.display = 'none';
        cmName.textContent = title;
        cmStatus.textContent = status;
        cmStatus.classList.remove('cm-status-online');   // ⬅ YANGI QATOR
        cmStatus.style.display = status ? 'block' : 'none';
               cmMessages.innerHTML = content;
        cmMessages.classList.toggle('saved-view', mode === 'saved');
        applyTwemoji(cmMessages);
        msgInput.placeholder = mode === 'saved' ? 'Saqlangan xabarga yozing...' : 'Xabar yozing...';

        
        closeMainMenu();
    }

function savedRowHtml(message) {
    var otherClass = message.fromSelf === false ? ' from-other' : '';
    var senderHtml = message.fromSelf === false && message.senderName
        ? '<span class="saved-message-sender">' + escapeHtml(message.senderName) + '</span>'
        : '';
    var msgMime = message.fileMime || '';
    var isImageMsg = message.fileUrl && (msgMime.indexOf('image/') === 0 || msgMime.indexOf('video/') === 0);
    var savedSenderLabel = message.fromSelf === false ? (message.senderName || 'Foydalanuvchi') : 'Siz';
    var content = message.fileUrl
        ? fileMsgHtml(message.fileUrl, message.fileName, message.fileMime, message.fileSize, { sender: savedSenderLabel, time: message.time })
        : (message.audioUrl ? voiceMsgHtml(message.audioUrl, message.duration || 0) : linkifyText(message.text || ''));
    var bubbleClass = 'saved-message-bubble' + (isImageMsg ? ' media-bubble' : '');
    return '<div class="saved-message-row' + otherClass + '" data-message-id="' + message.id + '"><div class="' + bubbleClass + '">' +
        senderHtml + content + '<span class="saved-message-time">' + escapeHtml(message.time || '') +
        ' <span class="msg-status read">✓✓</span></span></div></div>';
}

function renderSavedMessages() {
    if (!savedMessages.length) {
        return '<div class="internal-list__empty">Hozircha saqlangan xabarlar yo\'q.<br>Pastdagi maydonga yozib, saqlang.</div>';
    }
       return '<div class="saved-message-list">' + savedMessages.map(function (m, i) {
        return savedDayDividerHtml(savedMessages[i - 1], m) + savedRowHtml(m);
    }).join('') + '</div>';
}

function appendSavedRow(message, pending) {
    var list = cmMessages.querySelector('.saved-message-list');
    if (!list) {
        cmMessages.innerHTML = '<div class="saved-message-list"></div>';
        cmMessages.classList.add('saved-view');
        list = cmMessages.querySelector('.saved-message-list');
    }
    var tmp = document.createElement('div');
    tmp.innerHTML = savedRowHtml(message);
    var row = tmp.firstChild;
    if (pending) row.style.opacity = '.65';
       var prevSaved = savedMessages[savedMessages.length - 1];
    var dividerHtml = savedDayDividerHtml(prevSaved, message);
    if (dividerHtml) {
        var dtmp = document.createElement('div');
        dtmp.innerHTML = dividerHtml;
        list.appendChild(dtmp.firstChild);
    }
    list.appendChild(row);
    var voice = row.querySelector('.voice-msg');
    if (voice) bindVoicePlayer(voice);
    var music = row.querySelector('.music-msg');
    if (music) bindMusicPlayer(music);
    var vid = row.querySelector('.file-msg video');
    if (vid) fixVideoAspect(vid);
    applyTwemoji(row);
    cmMessages.scrollTop = cmMessages.scrollHeight;
    return row;
}

function saveToServer(pendingMsg, body, isJson, onFail) {
    var visible = activeInternalView === 'saved' && activeSavedSubChatIndex === null;
    var row = visible ? appendSavedRow(pendingMsg, true) : null;
    var headers = { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };
    if (isJson) headers['Content-Type'] = 'application/json';

    fetch(savedMessagesUrl, { method: 'POST', headers: headers, body: body })
        .then(function (r) {
            return r.json().catch(function () { return {}; }).then(function (data) {
                if (!r.ok) {
                    var v = data.errors ? Object.values(data.errors).flat()[0] : null;
                    throw new Error(v || data.message || 'Saqlashda xatolik');
                }
                return data;
            });
        })
        .then(function (data) {
            var m = data.message;
                        if (window.ChatStorage) ChatStorage.recordMessage({ key: 's', name: 'Saqlangan xabarlar', kind: 'saved', color: '#4b9bea' }, m);
            savedMessages.push({
                id: m.id,
                createdAt: m.created_at,
                text: m.body || '',
                time: formatChatTime(m.created_at),
                fromSelf: true,
                audioUrl: m.audio_url || null,
                duration: m.audio_duration || null,
                fileUrl: m.file_url || null,
                fileName: m.file_name || null,
                fileMime: m.file_mime || null,
                fileSize: m.file_size || null
            });
            updateSavedChatPreview(m);
            if (row) {
                row.dataset.messageId = m.id;
                row.style.opacity = '';
            }
            if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
        })
        .catch(function (err) {
            if (row) row.remove();
            if (onFail) onFail();
            alert(err.message || 'Saqlangan xabarni yuborishda xatolik yuz berdi.');
        });
}

    document.getElementById('mmSaved').addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();
        openSavedMessages();
    });

var comingSoonOverlay = document.getElementById('comingSoonOverlay');
function showComingSoon() {
    closeMainMenu();
    comingSoonOverlay.classList.add('show');
}
document.getElementById('comingSoonOk').addEventListener('click', function () {
    comingSoonOverlay.classList.remove('show');
});
comingSoonOverlay.addEventListener('click', function (e) {
    if (e.target === comingSoonOverlay) comingSoonOverlay.classList.remove('show');
});


function openVoiceChatMenu(anchorEl) {
    openDropdown(document.getElementById('voiceChatMenu'), anchorEl);
}

['vcStart', 'vcSchedule', 'vcStreamWith'].forEach(function (id) {
    document.getElementById(id).addEventListener('click', function () {
        closeAllDropdowns();
        showComingSoon();
    });
});

document.getElementById('mmContacts').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    showComingSoon();
});

document.getElementById('mmCalls').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    showComingSoon();
});

document.getElementById('mmWallet').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    showComingSoon();
});

document.getElementById('cmCallBtn').addEventListener('click', function (e) {
    e.preventDefault();
    e.stopPropagation();
    showComingSoon();
});

    // Logout — submits the CSRF-protected logout form
    var mmLogout = document.getElementById('mmLogout');
    var logoutForm = document.getElementById('logoutForm');
    if (mmLogout) {
        mmLogout.addEventListener('click', function () {
            if (logoutForm) {
                logoutForm.submit();
            } else {
                closeMainMenu();
            }
        });
    }

    // ---------- Side panel toggle ----------
    var sidePanel = document.getElementById('sidePanel');
    var toggleBtn = document.getElementById('togglePanelBtn');
    var emojiComposerBtn = document.getElementById('composerEmojiBtn');
    var rightPanelMode = 'none'; // 'none' | 'contact' | 'saved' — emoji BUTUNLAY mustaqil
     var channelInfoPanel = document.getElementById('channelInfoPanel');

    var emojiBtnIconHappy = document.getElementById('emojiBtnIconHappy');
    var emojiBtnIconSad = document.getElementById('emojiBtnIconSad');

    function refreshEmojiBtnFace() {
        var isOpen = !sidePanel.classList.contains('hidden');
        emojiBtnIconHappy.style.display = isOpen ? 'block' : 'none';
        emojiBtnIconSad.style.display = isOpen ? 'none' : 'block';
        emojiComposerBtn.classList.toggle('active-toggle', isOpen);
    }

       function setRightPanel(mode) {
        rightPanelMode = mode;
        if (mode !== 'saved') closeSavedMediaView();

        // Info paneli ochilsa, emoji paneli yopiladi
        if (mode !== 'none' && !sidePanel.classList.contains('hidden')) {
            sidePanel.classList.add('hidden');
            refreshEmojiBtnFace();
        }

        contactInfoPanel.classList.toggle('hidden', mode !== 'contact');
        savedInfoPanel.classList.toggle('hidden', mode !== 'saved');
        channelInfoPanel.classList.toggle('hidden', mode !== 'channel');
        toggleBtn.classList.toggle('active-toggle', mode !== 'none');
        if (mode === 'contact') renderContactInfoPanel();
        if (mode === 'saved') renderSavedInfoPanel();
        if (mode === 'channel') renderChannelInfoPanel();
    }

    function syncRightPanelForContext() {
        if (rightPanelMode === 'none') return;
        if (savedInfoPanel.classList.contains('media-open')) return; // media ro'yxati ochiq — qayta yozib yubormaymiz
        if (activeInternalView === 'saved') {
            setRightPanel('saved');
        } else if (activeRecipientId) {
            setRightPanel('contact');
        } else if (activeEntityId) {
            setRightPanel('channel');
        } else {
            setRightPanel('none');
        }
    }

     toggleBtn.addEventListener('click', function () {
        if (activeInternalView === 'saved') {
            setRightPanel(rightPanelMode === 'saved' ? 'none' : 'saved');
        } else if (activeRecipientId) {
            setRightPanel(rightPanelMode === 'contact' ? 'none' : 'contact');
        } else if (activeEntityId) {
            setRightPanel(rightPanelMode === 'channel' ? 'none' : 'channel');
        }
    });

      emojiComposerBtn.addEventListener('click', function () {
        var willOpen = sidePanel.classList.contains('hidden');

        // Emoji ochilsa, info paneli (Saqlangan xabarlar / kontakt) yopiladi
        if (willOpen && rightPanelMode !== 'none') {
            setRightPanel('none');
        }

        sidePanel.classList.toggle('hidden');
        refreshEmojiBtnFace();
    });
    refreshEmojiBtnFace();

       // ---------- Side panel tabs ----------
    var spTabs = document.querySelectorAll('.sp-tab');
    var panes = {
        emoji: document.getElementById('paneEmoji'),
        stickers: document.getElementById('paneStickers'),
        gifs: document.getElementById('paneGifs')
    };
    var currentSidePanelTab = 'emoji';
    spTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            spTabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            currentSidePanelTab = tab.dataset.tab;
            Object.keys(panes).forEach(function (key) {
                panes[key].style.display = (key === tab.dataset.tab) ? (key === 'emoji' ? 'block' : 'flex') : 'none';
            });
            if (spSearchInput) spSearchInput.placeholder = currentSidePanelTab === 'gifs' ? 'GIF qidirish' : 'Qidirish';
            if (currentSidePanelTab === 'gifs' && !gifGrid.dataset.loaded) {
                gifGrid.dataset.loaded = '1';
                loadGifs('');
            }
        });
    });
    panes.stickers.style.display = 'none';
    panes.gifs.style.display = 'none';
    panes.emoji.style.display = 'block';

    // ---------- GIF qidiruv va yuborish (GIPHY) ----------
    var gifSearchUrl = "{{ route('gifs.search') }}";
    var gifGrid = document.getElementById('gifGrid');
    var gifLoading = document.getElementById('gifLoading');
    var gifEmpty = document.getElementById('gifEmpty');
    var spSearchInput = document.getElementById('spSearchInput');
    var gifDebounce = null;

    function loadGifs(query) {
        gifLoading.style.display = 'flex';
        gifEmpty.style.display = 'none';
        gifGrid.innerHTML = '';
        fetch(gifSearchUrl + '?q=' + encodeURIComponent(query || ''), { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                gifLoading.style.display = 'none';
                var gifs = data.gifs || [];
                if (!gifs.length) {
                    gifEmpty.style.display = 'flex';
                    return;
                }
                gifs.forEach(function (gif) {
                    var img = document.createElement('img');
                    img.src = gif.preview;
                    img.loading = 'lazy';
                    img.style.width = '100%';
                    img.style.borderRadius = '8px';
                    img.style.cursor = 'pointer';
                    img.style.display = 'block';
                    img.addEventListener('click', function () { sendGif(gif.full_url); });
                    gifGrid.appendChild(img);
                });
            })
            .catch(function () {
                gifLoading.style.display = 'none';
                gifEmpty.style.display = 'flex';
            });
    }




        function sendGif(url) {
                    if (isQuietBlocked()) return;
        var formData = new FormData();
        formData.append('gif_url', url);

        if (activeInternalView === 'saved') {
            var nowIsoG = new Date().toISOString();
            saveToServer(
                { id: 'tmp-' + Date.now(), createdAt: nowIsoG, text: '', time: formatChatTime(nowIsoG), fromSelf: true,
                  fileUrl: url, fileName: 'giphy.gif', fileMime: 'image/gif', fileSize: 0 },
                formData, false
            );
            return;
        }


        var snap = captureView();

        var targetUrl = snap.internal === 'saved'
            ? savedMessagesUrl
            : (snap.entityId
                ? (snap.isChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + snap.entityId
                : (snap.userId ? messageBaseUrl + '/' + snap.userId : null));

        if (!targetUrl) return;

        fetch(targetUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        })
        .then(function (r) { if (!r.ok) throw new Error(); return r.json(); })
        .then(function (data) {
            var message = data.message;
            var same = isSameView(snap);

            if (snap.internal === 'saved') {
                savedMessages.push({
                    id: message.id,
                    createdAt: message.created_at,
                    text: '',
                    time: formatChatTime(message.created_at),
                    fromSelf: true,
                    fileUrl: message.file_url,
                    fileName: message.file_name,
                    fileMime: message.file_mime,
                    fileSize: message.file_size
                });
                updateSavedChatPreview(message);
                if (same) {
                    cmMessages.innerHTML = renderSavedMessages();
                    cmMessages.classList.add('saved-view');
                    applyTwemoji(cmMessages);
                    if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
                }
            } else if (snap.entityId) {
                if (same) {
                    var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                    appendMessage(message, sendOpts);
                    activeChatMessages.push(mapEntityMessageForMedia(message, 'Siz'));
                    if (rightPanelMode === 'channel') renderChannelStats();
                }
                refreshEntityPreviews(snap.entityId);
            } else if (snap.userId) {
                if (same) {
                    appendMessage(message);
                    activeChatMessages.push(mapEntityMessageForMedia(message, 'Siz'));
                    if (rightPanelMode === 'contact') renderContactStats();
                }
                updateChatListPreview(snap.userId, message);
            }
            if (same) cmMessages.scrollTop = cmMessages.scrollHeight;
        })
        .catch(function () { alert('GIF yuborilmadi.'); });
    }

    function sendGif_OLD(url) {
        var formData = new FormData();
        formData.append('gif_url', url);

        var targetUrl = activeInternalView === 'saved'
            ? savedMessagesUrl
            : (activeEntityId
                ? (activeIsDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + activeEntityId
                : messageBaseUrl + '/' + activeRecipientId);

        if (!targetUrl || (targetUrl === messageBaseUrl + '/null')) return;

        fetch(targetUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            var message = data.message;
            if (activeInternalView === 'saved') {
                savedMessages.push({
                    id: message.id,
                    createdAt: message.created_at,
                    text: '',
                    time: formatChatTime(message.created_at),
                    fromSelf: true,
                    fileUrl: message.file_url,
                    fileName: message.file_name,
                    fileMime: message.file_mime,
                    fileSize: message.file_size
                });
                cmMessages.innerHTML = renderSavedMessages();
                cmMessages.classList.add('saved-view');
                applyTwemoji(cmMessages);
                if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
                updateSavedChatPreview(message);
            } else if (activeEntityId) {
                var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                if (sendOpts.forceOut) markSentMessage(activeEntityId, message.id);
                appendMessage(message, sendOpts);
                refreshEntityPreviews(activeEntityId);
                activeChatMessages.push(mapEntityMessageForMedia(message, 'Siz'));
                if (rightPanelMode === 'channel') renderChannelStats();
            } else if (activeRecipientId) {
                appendMessage(message);
                updateChatListPreview(activeRecipientId, message);
                activeChatMessages.push(mapEntityMessageForMedia(message, 'Siz'));
                if (rightPanelMode === 'contact') renderContactStats();
            }
            cmMessages.scrollTop = cmMessages.scrollHeight;
        })
        .catch(function () { alert('GIF yuborilmadi.'); });
    }

    if (spSearchInput) {
        spSearchInput.addEventListener('input', function () {
            if (currentSidePanelTab !== 'gifs') return;
            clearTimeout(gifDebounce);
            gifDebounce = setTimeout(function () { loadGifs(spSearchInput.value.trim()); }, 400);
        });
    }

    // ---------- Telegram uslubidagi kategoriyalashgan emoji panel ----------
    var EMOJI_CATEGORIES = [
        { key: 'recent', icon: '🕐', title: "Ko'p ishlatilgan", emojis: [] },
        { key: 'smileys', icon: '😀', title: 'Emoji & People', emojis: ['😀','😃','😄','😁','😆','😅','🤣','😂','🙂','🙃','🫠','😉','😊','😇','🥰','😍','🤩','😘','😗','☺️','😚','😙','🥲','😋','😛','😜','🤪','😝','🤑','🤗','🤭','🫢','🫣','🤫','🤔','🫡','🤐','🤨','😐','😑','😶','🫥','😶‍🌫️','😏','😒','🙄','😬','😮‍💨','🤥','🫨','🙂‍↔️','🙂‍↕️','😌','😔','😪','🤤','😴','🫩','😷','🤒','🤕','🤢','🤮','🤧','🥵','🥶','🥴','😵','😵‍💫','🤯','🤠','🥳','🥸','😎','🤓','🧐','😕','🫤','😟','🙁','☹️','😮','😯','😲','😳','🫪','🥺','🥹','😦','😧','😨','😰','😥','😢','😭','😱','😖','😣','😞','😓','😩','😫','🥱','😤','😡','😠','🤬','😈','👿','💀','☠️','💩','🤡','👹','👺','👻','👽','👾','🤖','😺','😸','😹','😻','😼','😽','🙀','😿','😾','🙈','🙉','🙊','💌','💘','💝','💖','💗','💓','💞','💕','💟','❣️','💔','❤️‍🔥','❤️‍🩹','❤️','🩷','🧡','💛','💚','💙','🩵','💜','🤎','🖤','🩶','🤍','💋','💯','💢','🫯','💥','💫','💦','💨','🕳️','💬','👁️‍🗨️','🗨️','🗯️','💭','💤'] },
        { key: 'people', icon: '👋', title: 'Odamlar va imo-ishoralar', emojis: ['👋','🤚','🖐️','✋','🖖','🫱','🫲','🫳','🫴','🫷','🫸','👌','🤌','🤏','✌️','🤞','🫰','🤟','🤘','🤙','👈','👉','👆','🖕','👇','☝️','🫵','👍','👎','✊','👊','🤛','🤜','👏','🙌','🫶','👐','🤲','🤝','🙏','✍️','💅','🤳','💪','🦾','🦿','🦵','🦶','👂','🦻','👃','🧠','🫀','🫁','🦷','🦴','👀','👁️','👅','👄','🫦','👶','🧒','👦','👧','🧑','👱','👨','🧔','🧔‍♂️','🧔‍♀️','👨‍🦰','👨‍🦱','👨‍🦳','👨‍🦲','👩','👩‍🦰','🧑‍🦰','👩‍🦱','🧑‍🦱','👩‍🦳','🧑‍🦳','👩‍🦲','🧑‍🦲','👱‍♀️','👱‍♂️','🧓','👴','👵','🙍','🙍‍♂️','🙍‍♀️','🙎','🙎‍♂️','🙎‍♀️','🙅','🙅‍♂️','🙅‍♀️','🙆','🙆‍♂️','🙆‍♀️','💁','💁‍♂️','💁‍♀️','🙋','🙋‍♂️','🙋‍♀️','🧏','🧏‍♂️','🧏‍♀️','🙇','🙇‍♂️','🙇‍♀️','🤦','🤦‍♂️','🤦‍♀️','🤷','🤷‍♂️','🤷‍♀️','🧑‍⚕️','👨‍⚕️','👩‍⚕️','🧑‍🎓','👨‍🎓','👩‍🎓','🧑‍🏫','👨‍🏫','👩‍🏫','🧑‍⚖️','👨‍⚖️','👩‍⚖️','🧑‍🌾','👨‍🌾','👩‍🌾','🧑‍🍳','👨‍🍳','👩‍🍳','🧑‍🔧','👨‍🔧','👩‍🔧','🧑‍🏭','👨‍🏭','👩‍🏭','🧑‍💼','👨‍💼','👩‍💼','🧑‍🔬','👨‍🔬','👩‍🔬','🧑‍💻','👨‍💻','👩‍💻','🧑‍🎤','👨‍🎤','👩‍🎤','🧑‍🎨','👨‍🎨','👩‍🎨','🧑‍✈️','👨‍✈️','👩‍✈️','🧑‍🚀','👨‍🚀','👩‍🚀','🧑‍🚒','👨‍🚒','👩‍🚒','👮','👮‍♂️','👮‍♀️','🕵️','🕵️‍♂️','🕵️‍♀️','💂','💂‍♂️','💂‍♀️','🥷','👷','👷‍♂️','👷‍♀️','🫅','🤴','👸','👳','👳‍♂️','👳‍♀️','👲','🧕','🤵','🤵‍♂️','🤵‍♀️','👰','👰‍♂️','👰‍♀️','🤰','🫃','🫄','🤱','👩‍🍼','👨‍🍼','🧑‍🍼','👼','🎅','🤶','🧑‍🎄','🦸','🦸‍♂️','🦸‍♀️','🦹','🦹‍♂️','🦹‍♀️','🧙','🧙‍♂️','🧙‍♀️','🧚','🧚‍♂️','🧚‍♀️','🧛','🧛‍♂️','🧛‍♀️','🧜','🧜‍♂️','🧜‍♀️','🧝','🧝‍♂️','🧝‍♀️','🧞','🧞‍♂️','🧞‍♀️','🧟','🧟‍♂️','🧟‍♀️','🧌','🫈','💆','💆‍♂️','💆‍♀️','💇','💇‍♂️','💇‍♀️','🚶','🚶‍♂️','🚶‍♀️','🚶‍➡️','🚶‍♀️‍➡️','🚶‍♂️‍➡️','🧍','🧍‍♂️','🧍‍♀️','🧎','🧎‍♂️','🧎‍♀️','🧎‍➡️','🧎‍♀️‍➡️','🧎‍♂️‍➡️','🧑‍🦯','🧑‍🦯‍➡️','👨‍🦯','👨‍🦯‍➡️','👩‍🦯','👩‍🦯‍➡️','🧑‍🦼','🧑‍🦼‍➡️','👨‍🦼','👨‍🦼‍➡️','👩‍🦼','👩‍🦼‍➡️','🧑‍🦽','🧑‍🦽‍➡️','👨‍🦽','👨‍🦽‍➡️','👩‍🦽','👩‍🦽‍➡️','🏃','🏃‍♂️','🏃‍♀️','🏃‍➡️','🏃‍♀️‍➡️','🏃‍♂️‍➡️','🧑‍🩰','💃','🕺','🕴️','👯','👯‍♂️','👯‍♀️','🧖','🧖‍♂️','🧖‍♀️','🧗','🧗‍♂️','🧗‍♀️','🤺','🏇','⛷️','🏂','🏌️','🏌️‍♂️','🏌️‍♀️','🏄','🏄‍♂️','🏄‍♀️','🚣','🚣‍♂️','🚣‍♀️','🏊','🏊‍♂️','🏊‍♀️','⛹️','⛹️‍♂️','⛹️‍♀️','🏋️','🏋️‍♂️','🏋️‍♀️','🚴','🚴‍♂️','🚴‍♀️','🚵','🚵‍♂️','🚵‍♀️','🤸','🤸‍♂️','🤸‍♀️','🤼','🤼‍♂️','🤼‍♀️','🤽','🤽‍♂️','🤽‍♀️','🤾','🤾‍♂️','🤾‍♀️','🤹','🤹‍♂️','🤹‍♀️','🧘','🧘‍♂️','🧘‍♀️','🛀','🛌','🧑‍🤝‍🧑','👭','👫','👬','💏','👩‍❤️‍💋‍👨','👨‍❤️‍💋‍👨','👩‍❤️‍💋‍👩','💑','👩‍❤️‍👨','👨‍❤️‍👨','👩‍❤️‍👩','👨‍👩‍👦','👨‍👩‍👧','👨‍👩‍👧‍👦','👨‍👩‍👦‍👦','👨‍👩‍👧‍👧','👨‍👨‍👦','👨‍👨‍👧','👨‍👨‍👧‍👦','👨‍👨‍👦‍👦','👨‍👨‍👧‍👧','👩‍👩‍👦','👩‍👩‍👧','👩‍👩‍👧‍👦','👩‍👩‍👦‍👦','👩‍👩‍👧‍👧','👨‍👦','👨‍👦‍👦','👨‍👧','👨‍👧‍👦','👨‍👧‍👧','👩‍👦','👩‍👦‍👦','👩‍👧','👩‍👧‍👦','👩‍👧‍👧','🗣️','👤','👥','🫂','👪','🧑‍🧑‍🧒','🧑‍🧑‍🧒‍🧒','🧑‍🧒','🧑‍🧒‍🧒','👣','🫆'] },
        { key: 'animals', icon: '🐻', title: 'Hayvonot va tabiat', emojis: ['🐵','🐒','🦍','🦧','🐶','🐕','🦮','🐕‍🦺','🐩','🐺','🦊','🦝','🐱','🐈','🐈‍⬛','🦁','🐯','🐅','🐆','🐴','🫎','🫏','🐎','🦄','🦓','🦌','🦬','🐮','🐂','🐃','🐄','🐷','🐖','🐗','🐽','🐏','🐑','🐐','🐪','🐫','🦙','🦒','🐘','🦣','🦏','🦛','🐭','🐁','🐀','🐹','🐰','🐇','🐿️','🦫','🦔','🦇','🐻','🐻‍❄️','🐨','🐼','🦥','🦦','🦨','🦘','🦡','🐾','🦃','🐔','🐓','🐣','🐤','🐥','🐦','🐧','🕊️','🦅','🦆','🦢','🦉','🦤','🪶','🦩','🦚','🦜','🪽','🐦‍⬛','🪿','🐦‍🔥','🐸','🐊','🐢','🦎','🐍','🐲','🐉','🦕','🦖','🐳','🐋','🐬','🫍','🦭','🐟','🐠','🐡','🦈','🐙','🐚','🪸','🪼','🦀','🦞','🦐','🦑','🦪','🐌','🦋','🐛','🐜','🐝','🪲','🐞','🦗','🪳','🕷️','🕸️','🦂','🦟','🪰','🪱','🦠','💐','🌸','💮','🪷','🏵️','🌹','🥀','🌺','🌻','🌼','🌷','🪻','🌱','🪴','🌲','🌳','🌴','🌵','🌾','🌿','☘️','🍀','🍁','🍂','🍃','🪹','🪺','🍄','🪾'] },
        { key: 'food', icon: '🍔', title: 'Ovqat va ichimliklar', emojis: ['🍇','🍈','🍉','🍊','🍋','🍋‍🟩','🍌','🍍','🥭','🍎','🍏','🍐','🍑','🍒','🍓','🫐','🥝','🍅','🫒','🥥','🥑','🍆','🥔','🥕','🌽','🌶️','🫑','🥒','🥬','🥦','🧄','🧅','🥜','🫘','🌰','🫚','🫛','🍄‍🟫','🫜','🍞','🥐','🥖','🫓','🥨','🥯','🥞','🧇','🧀','🍖','🍗','🥩','🥓','🍔','🍟','🍕','🌭','🥪','🌮','🌯','🫔','🥙','🧆','🥚','🍳','🥘','🍲','🫕','🥣','🥗','🍿','🧈','🧂','🥫','🍱','🍘','🍙','🍚','🍛','🍜','🍝','🍠','🍢','🍣','🍤','🍥','🥮','🍡','🥟','🥠','🥡','🍦','🍧','🍨','🍩','🍪','🎂','🍰','🧁','🥧','🍫','🍬','🍭','🍮','🍯','🍼','🥛','☕','🫖','🍵','🍶','🍾','🍷','🍸','🍹','🍺','🍻','🥂','🥃','🫗','🥤','🧋','🧃','🧉','🧊','🥢','🍽️','🍴','🥄','🔪','🫙','🏺'] },
        { key: 'activities', icon: '⚽', title: 'Faoliyat', emojis: ['🎃','🎄','🎆','🎇','🧨','✨','🎈','🎉','🎊','🎋','🎍','🎎','🎏','🎐','🎑','🧧','🎀','🎁','🎗️','🎟️','🎫','🎖️','🏆','🏅','🥇','🥈','🥉','⚽','⚾','🥎','🏀','🏐','🏈','🏉','🎾','🥏','🎳','🏏','🏑','🏒','🥍','🏓','🏸','🥊','🥋','🥅','⛳','⛸️','🎣','🤿','🎽','🎿','🛷','🥌','🎯','🪀','🪁','🔫','🎱','🔮','🪄','🎮','🕹️','🎰','🎲','🧩','🧸','🪅','🪩','🪆','♠️','♥️','♦️','♣️','♟️','🃏','🀄','🎴','🎭','🖼️','🎨','🧵','🪡','🧶','🪢'] },
        { key: 'travel', icon: '✈️', title: 'Sayohat va joylar', emojis: ['🌍','🌎','🌏','🌐','🗺️','🗾','🧭','🏔️','⛰️','🛘','🌋','🗻','🏕️','🏖️','🏜️','🏝️','🏞️','🏟️','🏛️','🏗️','🧱','🪨','🪵','🛖','🏘️','🏚️','🏠','🏡','🏢','🏣','🏤','🏥','🏦','🏨','🏩','🏪','🏫','🏬','🏭','🏯','🏰','💒','🗼','🗽','⛪','🕌','🛕','🕍','⛩️','🕋','⛲','⛺','🌁','🌃','🏙️','🌄','🌅','🌆','🌇','🌉','♨️','🎠','🛝','🎡','🎢','💈','🎪','🚂','🚃','🚄','🚅','🚆','🚇','🚈','🚉','🚊','🚝','🚞','🚋','🚌','🚍','🚎','🚐','🚑','🚒','🚓','🚔','🚕','🚖','🚗','🚘','🚙','🛻','🚚','🚛','🚜','🏎️','🏍️','🛵','🦽','🦼','🛺','🚲','🛴','🛹','🛼','🚏','🛣️','🛤️','🛢️','⛽','🛞','🚨','🚥','🚦','🛑','🚧','⚓','🛟','⛵','🛶','🚤','🛳️','⛴️','🛥️','🚢','✈️','🛩️','🛫','🛬','🪂','💺','🚁','🚟','🚠','🚡','🛰️','🚀','🛸','🛎️','🧳','⌛','⏳','⌚','⏰','⏱️','⏲️','🕰️','🕛','🕧','🕐','🕜','🕑','🕝','🕒','🕞','🕓','🕟','🕔','🕠','🕕','🕡','🕖','🕢','🕗','🕣','🕘','🕤','🕙','🕥','🕚','🕦','🌑','🌒','🌓','🌔','🌕','🌖','🌗','🌘','🌙','🌚','🌛','🌜','🌡️','☀️','🌝','🌞','🪐','⭐','🌟','🌠','🌌','☁️','⛅','⛈️','🌤️','🌥️','🌦️','🌧️','🌨️','🌩️','🌪️','🌫️','🌬️','🌀','🌈','🌂','☂️','☔','⛱️','⚡','❄️','☃️','⛄','☄️','🔥','💧','🌊'] },
        { key: 'objects', icon: '💡', title: 'Buyumlar', emojis: ['👓','🕶️','🥽','🥼','🦺','👔','👕','👖','🧣','🧤','🧥','🧦','👗','👘','🥻','🩱','🩲','🩳','👙','👚','🪭','👛','👜','👝','🛍️','🎒','🩴','👞','👟','🥾','🥿','👠','👡','🩰','👢','🪮','👑','👒','🎩','🎓','🧢','🪖','⛑️','📿','💄','💍','💎','🔇','🔈','🔉','🔊','📢','📣','📯','🔔','🔕','🎼','🎵','🎶','🎙️','🎚️','🎛️','🎤','🎧','📻','🎷','🎺','🪊','🪗','🎸','🎹','🎻','🪕','🥁','🪘','🪇','🪈','🪉','📱','📲','☎️','📞','📟','📠','🔋','🪫','🔌','💻','🖥️','🖨️','⌨️','🖱️','🖲️','💽','💾','💿','📀','🧮','🎥','🎞️','📽️','🎬','📺','📷','📸','📹','📼','🔍','🔎','🕯️','💡','🔦','🏮','🪔','📔','📕','📖','📗','📘','📙','📚','📓','📒','📃','📜','📄','📰','🗞️','📑','🔖','🏷️','🪙','💰','🪎','💴','💵','💶','💷','💸','💳','🧾','💹','✉️','📧','📨','📩','📤','📥','📦','📫','📪','📬','📭','📮','🗳️','✏️','✒️','🖋️','🖊️','🖌️','🖍️','📝','💼','📁','📂','🗂️','📅','📆','🗒️','🗓️','📇','📈','📉','📊','📋','📌','📍','📎','🖇️','📏','📐','✂️','🗃️','🗄️','🗑️','🔒','🔓','🔏','🔐','🔑','🗝️','🔨','🪓','⛏️','⚒️','🛠️','🗡️','⚔️','💣','🪃','🏹','🛡️','🪚','🔧','🪛','🔩','⚙️','🗜️','⚖️','🦯','🔗','⛓️‍💥','⛓️','🪝','🧰','🧲','🪜','🪏','⚗️','🧪','🧫','🧬','🔬','🔭','📡','💉','🩸','💊','🩹','🩼','🩺','🩻','🚪','🛗','🪞','🪟','🛏️','🛋️','🪑','🚽','🪠','🚿','🛁','🪤','🪒','🧴','🧷','🧹','🧺','🧻','🪣','🧼','🫧','🪥','🧽','🧯','🛒','🚬','⚰️','🪦','⚱️','🧿','🪬','🗿','🪧','🪪'] },
        { key: 'symbols', icon: '❤️', title: 'Belgilar', emojis: ['🏧','🚮','🚰','♿','🚹','🚺','🚻','🚼','🚾','🛂','🛃','🛄','🛅','⚠️','🚸','⛔','🚫','🚳','🚭','🚯','🚱','🚷','📵','🔞','☢️','☣️','⬆️','↗️','➡️','↘️','⬇️','↙️','⬅️','↖️','↕️','↔️','↩️','↪️','⤴️','⤵️','🔃','🔄','🔙','🔚','🔛','🔜','🔝','🛐','⚛️','🕉️','✡️','☸️','☯️','✝️','☦️','☪️','☮️','🕎','🔯','🪯','♈','♉','♊','♋','♌','♍','♎','♏','♐','♑','♒','♓','⛎','🔀','🔁','🔂','▶️','⏩','⏭️','⏯️','◀️','⏪','⏮️','🔼','⏫','🔽','⏬','⏸️','⏹️','⏺️','⏏️','🎦','🔅','🔆','📶','🛜','📳','📴','♀️','♂️','⚧️','✖️','➕','➖','➗','🟰','♾️','‼️','⁉️','❓','❔','❕','❗','〰️','💱','💲','⚕️','♻️','⚜️','🔱','📛','🔰','⭕','✅','☑️','✔️','❌','❎','➰','➿','〽️','✳️','✴️','❇️','©️','®️','™️','🫟','#️⃣','*️⃣','0️⃣','1️⃣','2️⃣','3️⃣','4️⃣','5️⃣','6️⃣','7️⃣','8️⃣','9️⃣','🔟','🔠','🔡','🔢','🔣','🔤','🅰️','🆎','🅱️','🆑','🆒','🆓','ℹ️','🆔','Ⓜ️','🆕','🆖','🅾️','🆗','🅿️','🆘','🆙','🆚','🈁','🈂️','🈷️','🈶','🈯','🉐','🈹','🈚','🈲','🉑','🈸','🈴','🈳','㊗️','㊙️','🈺','🈵','🔴','🟠','🟡','🟢','🔵','🟣','🟤','⚫','⚪','🟥','🟧','🟨','🟩','🟦','🟪','🟫','⬛','⬜','◼️','◻️','◾','◽','▪️','▫️','🔶','🔷','🔸','🔹','🔺','🔻','💠','🔘','🔳','🔲'] },
        { key: 'flags', icon: '🏁', title: 'Bayroqlar', emojis: ['🏁','🚩','🎌','🏴','🏳️','🏳️‍🌈','🏳️‍⚧️','🏴‍☠️','🇦🇨','🇦🇩','🇦🇪','🇦🇫','🇦🇬','🇦🇮','🇦🇱','🇦🇲','🇦🇴','🇦🇶','🇦🇷','🇦🇸','🇦🇹','🇦🇺','🇦🇼','🇦🇽','🇦🇿','🇧🇦','🇧🇧','🇧🇩','🇧🇪','🇧🇫','🇧🇬','🇧🇭','🇧🇮','🇧🇯','🇧🇱','🇧🇲','🇧🇳','🇧🇴','🇧🇶','🇧🇷','🇧🇸','🇧🇹','🇧🇻','🇧🇼','🇧🇾','🇧🇿','🇨🇦','🇨🇨','🇨🇩','🇨🇫','🇨🇬','🇨🇭','🇨🇮','🇨🇰','🇨🇱','🇨🇲','🇨🇳','🇨🇴','🇨🇵','🇨🇶','🇨🇷','🇨🇺','🇨🇻','🇨🇼','🇨🇽','🇨🇾','🇨🇿','🇩🇪','🇩🇬','🇩🇯','🇩🇰','🇩🇲','🇩🇴','🇩🇿','🇪🇦','🇪🇨','🇪🇪','🇪🇬','🇪🇭','🇪🇷','🇪🇸','🇪🇹','🇪🇺','🇫🇮','🇫🇯','🇫🇰','🇫🇲','🇫🇴','🇫🇷','🇬🇦','🇬🇧','🇬🇩','🇬🇪','🇬🇫','🇬🇬','🇬🇭','🇬🇮','🇬🇱','🇬🇲','🇬🇳','🇬🇵','🇬🇶','🇬🇷','🇬🇸','🇬🇹','🇬🇺','🇬🇼','🇬🇾','🇭🇰','🇭🇲','🇭🇳','🇭🇷','🇭🇹','🇭🇺','🇮🇨','🇮🇩','🇮🇪','🇮🇱','🇮🇲','🇮🇳','🇮🇴','🇮🇶','🇮🇷','🇮🇸','🇮🇹','🇯🇪','🇯🇲','🇯🇴','🇯🇵','🇰🇪','🇰🇬','🇰🇭','🇰🇮','🇰🇲','🇰🇳','🇰🇵','🇰🇷','🇰🇼','🇰🇾','🇰🇿','🇱🇦','🇱🇧','🇱🇨','🇱🇮','🇱🇰','🇱🇷','🇱🇸','🇱🇹','🇱🇺','🇱🇻','🇱🇾','🇲🇦','🇲🇨','🇲🇩','🇲🇪','🇲🇫','🇲🇬','🇲🇭','🇲🇰','🇲🇱','🇲🇲','🇲🇳','🇲🇴','🇲🇵','🇲🇶','🇲🇷','🇲🇸','🇲🇹','🇲🇺','🇲🇻','🇲🇼','🇲🇽','🇲🇾','🇲🇿','🇳🇦','🇳🇨','🇳🇪','🇳🇫','🇳🇬','🇳🇮','🇳🇱','🇳🇴','🇳🇵','🇳🇷','🇳🇺','🇳🇿','🇴🇲','🇵🇦','🇵🇪','🇵🇫','🇵🇬','🇵🇭','🇵🇰','🇵🇱','🇵🇲','🇵🇳','🇵🇷','🇵🇸','🇵🇹','🇵🇼','🇵🇾','🇶🇦','🇷🇪','🇷🇴','🇷🇸','🇷🇺','🇷🇼','🇸🇦','🇸🇧','🇸🇨','🇸🇩','🇸🇪','🇸🇬','🇸🇭','🇸🇮','🇸🇯','🇸🇰','🇸🇱','🇸🇲','🇸🇳','🇸🇴','🇸🇷','🇸🇸','🇸🇹','🇸🇻','🇸🇽','🇸🇾','🇸🇿','🇹🇦','🇹🇨','🇹🇩','🇹🇫','🇹🇬','🇹🇭','🇹🇯','🇹🇰','🇹🇱','🇹🇲','🇹🇳','🇹🇴','🇹🇷','🇹🇹','🇹🇻','🇹🇼','🇹🇿','🇺🇦','🇺🇬','🇺🇲','🇺🇳','🇺🇸','🇺🇾','🇺🇿','🇻🇦','🇻🇨','🇻🇪','🇻🇬','🇻🇮','🇻🇳','🇻🇺','🇼🇫','🇼🇸','🇽🇰','🇾🇪','🇾🇹','🇿🇦','🇿🇲','🇿🇼','🏴󠁧󠁢󠁥󠁮󠁧󠁿','🏴󠁧󠁢󠁳󠁣󠁴󠁿','🏴󠁧󠁢󠁷󠁬󠁳󠁿'] },
    ];

var RECENT_EMOJI_KEY = 'chatovbs_recent_emojis_{{ auth()->id() }}';

function getRecentEmojis() {
    try { return JSON.parse(localStorage.getItem(RECENT_EMOJI_KEY) || '[]'); }
    catch (e) { return []; }
}
function addRecentEmoji(e) {
    var list = getRecentEmojis().filter(function (x) { return x !== e; });
    list.unshift(e);
    localStorage.setItem(RECENT_EMOJI_KEY, JSON.stringify(list.slice(0, 54)));
}

var emojiCatScroll = document.getElementById('emojiCatScroll');
function renderEmojiPanel() {
    // Butun panel FAQAT BIR MARTA quriladi. Keyingi chaqiruvlarda faqat "Recent" yangilanadi.
    if (emojiCatScroll.dataset.built === '1') {
        updateRecentEmojiBlock();
        return;
    }

    EMOJI_CATEGORIES[0].emojis = getRecentEmojis().slice(0, 54);
    emojiCatScroll.innerHTML = '';

    EMOJI_CATEGORIES.forEach(function (cat) {
        if (cat.key === 'recent' && !cat.emojis.length) return;

        var block = document.createElement('div');
        block.className = 'emoji-cat-block';
        block.id = 'emojiBlock_' + cat.key;
        var title = document.createElement('div');
        title.className = 'sp-section-title';
        if (cat.key === 'smileys') {
            title.innerHTML = '<span>' + cat.title + '</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="19" height="19"><line x1="4" y1="6" x2="14" y2="6"></line><circle cx="17" cy="6" r="2"></circle><line x1="10" y1="12" x2="20" y2="12"></line><circle cx="7" cy="12" r="2"></circle><line x1="4" y1="18" x2="14" y2="18"></line><circle cx="17" cy="18" r="2"></circle></svg>';
        } else {
            title.textContent = cat.title;
        }
        var grid = document.createElement('div');
        grid.className = 'emoji-grid';
        cat.emojis.forEach(function (e) {
            var b = document.createElement('button');
            b.type = 'button';
            b.textContent = e;
            grid.appendChild(b);
        });
        block.appendChild(title);
        block.appendChild(grid);
        emojiCatScroll.appendChild(block);
    });

    applyTwemoji(emojiCatScroll); // faqat bitta marta — 1800+ emoji uchun
    emojiCatScroll.dataset.built = '1';
}

function updateRecentEmojiBlock() {
    var recent = getRecentEmojis().slice(0, 54);
    var block = document.getElementById('emojiBlock_recent');

    if (!recent.length) {
        if (block) block.remove();
        return;
    }

    if (!block) {
        var catDef = EMOJI_CATEGORIES[0];
        block = document.createElement('div');
        block.className = 'emoji-cat-block';
        block.id = 'emojiBlock_recent';
        var title = document.createElement('div');
        title.className = 'sp-section-title';
        title.textContent = catDef.title;
        var grid = document.createElement('div');
        grid.className = 'emoji-grid';
        block.appendChild(title);
        block.appendChild(grid);
        emojiCatScroll.prepend(block); // "Recent" har doim eng tepada
    }

    var grid = block.querySelector('.emoji-grid');
    grid.innerHTML = '';
    recent.forEach(function (e) {
        var b = document.createElement('button');
        b.type = 'button';
        b.textContent = e;
        grid.appendChild(b);
    });
    applyTwemoji(grid); // faqat max 54 ta emoji uchun — tez
}

    renderEmojiPanel();

   // ---------- Saved Messages info panel ----------
    var savedInfoPanel = document.getElementById('savedInfoPanel');
    var savedInfoStats = document.getElementById('savedInfoStats');
    var savedInfoChats = document.getElementById('savedInfoChats');
    var savedInfoChatsCount = document.getElementById('savedInfoChatsCount');
    var savedInfoCloseBtn = document.getElementById('savedInfoCloseBtn');

    var STAT_ICONS = {
        stories: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"></polygon></svg>',
        photos: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>',
        videos: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>',
        files: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>',
        audio: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>',
        links: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>',
        voice: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line></svg>',
              gif: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="1.5" y="3" width="22" height="19" rx="4"></rect></svg><span style="position:absolute;font-size:9px;font-weight:800;letter-spacing:-0.3px;">GIF</span>'    
    };

    var savedInfoChatsData = [];
    var activeSavedSubChatIndex = null;


    function chatPreviewPlain(message) {
    if (!message) return '';
    if (message.audioUrl) return 'Ovozli xabar';
    if (message.fileUrl) {
        var mime = message.fileMime || '';
        if (mime.indexOf('image/gif') === 0) return 'GIF';
        if (mime.indexOf('image/') === 0) return 'Rasim';
        if (mime.indexOf('video/') === 0) return 'Video';
        if (mime.indexOf('audio/') === 0) return message.fileName || 'Musiqa';
        return message.fileName || 'Fayl';
    }
    return message.text || '';
}

    function computeSavedInfo() {
        var stats = { photos: 0, videos: 0, files: 0, audio: 0, links: 0, voice: 0, gif: 0 };
        var chatsMap = {};
        var myNotes = [];
        var urlRegex = /https?:\/\/[^\s]+/;

        (savedMessages || []).forEach(function (m) {
            var mime = m.fileMime || '';
            if (m.fileUrl) {
                if (mime.indexOf('image/gif') === 0) stats.gif++;
                else if (mime.indexOf('image/') === 0) stats.photos++;
                else if (mime.indexOf('video/') === 0) stats.videos++;
                else if (mime.indexOf('audio/') === 0) stats.audio++;
                else stats.files++;
            }
            if (m.audioUrl) stats.voice++;
            if (m.text && urlRegex.test(m.text)) stats.links++;

            if (m.fromSelf === false) {
                var name = m.senderName || 'Foydalanuvchi';
                if (!chatsMap[name]) chatsMap[name] = { name: name, lastText: '', lastTime: '', messages: [] };
               chatsMap[name].lastText = chatPreviewPlain(m);
                chatsMap[name].lastTime = m.time || chatsMap[name].lastTime;
                chatsMap[name].messages.push(m);
            } else {
                myNotes.push(m);
            }
        });

        var chatsList = Object.keys(chatsMap).map(function (k) { return chatsMap[k]; });
        if (myNotes.length) {
            var last = myNotes[myNotes.length - 1];
            chatsList.unshift({
                name: 'Mening yozuvlarim',
                lastText: chatPreviewPlain(last),
                lastTime: last.time || '',
                messages: myNotes,
                isMyNotes: true
            });
        }
        return { stats: stats, chats: chatsList };
    }

    function avatarColorFor(name) {
        var colors = ['#e17076', '#7bc862', '#65aadd', '#a695e7', '#ee7aae', '#6ec9cb', '#faa774'];
        var hash = 0;
        for (var i = 0; i < name.length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
        return colors[Math.abs(hash) % colors.length];
    }


        function computeContactMediaStats() {
        var stats = { photos: 0, videos: 0, files: 0, audio: 0, links: 0, voice: 0, gif: 0 };
        var urlRegex = /https?:\/\/[^\s]+/;
        (activeChatMessages || []).forEach(function (m) {
            var mime = m.fileMime || '';
            if (m.fileUrl) {
                if (mime.indexOf('image/gif') === 0) stats.gif++;
                else if (mime.indexOf('image/') === 0) stats.photos++;
                else if (mime.indexOf('video/') === 0) stats.videos++;
                else if (mime.indexOf('audio/') === 0) stats.audio++;
                else stats.files++;
            }
            if (m.audioUrl) stats.voice++;
            if (m.text && urlRegex.test(m.text)) stats.links++;
        });
        return stats;
    }

    function renderContactStats() {
        var cipStatsBlock = document.getElementById('cipStatsBlock');
        if (!cipStatsBlock) return;
        var stats = computeContactMediaStats();
        var rows = [];
        var storiesCount = (activeRecipientProfile && activeRecipientProfile.stories_count) || 0;
        if (storiesCount > 0) rows.push(['stories', storiesCount, 'stories']);
        rows.push(['photos', stats.photos, 'photo']);
        rows.push(['videos', stats.videos, 'video']);
        rows.push(['files', stats.files, 'fayl']);
        rows.push(['audio', stats.audio, 'audio fayl']);
        rows.push(['links', stats.links, 'ulashilgan havola']);
        rows.push(['voice', stats.voice, 'ovozli xabar']);
        rows.push(['gif', stats.gif, 'GIF']);

        cipStatsBlock.innerHTML = rows.filter(function (r) { return r[1] > 0; }).map(function (r) {
                        var clickable = ' clickable';
            return '<div class="saved-info-stat-row' + clickable + '" data-stat="' + r[0] + '">' +
                '<span style="display:flex;align-items:center;justify-content:center;position:relative;width:20px;height:20px;">' + STAT_ICONS[r[0]] + '</span>' +
                '<span><b>' + r[1] + '</b> ' + r[2] + '</span></div>';
        }).join('');
    }

    function renderSavedInfoPanel() {
        var info = computeSavedInfo();
        savedInfoChatsCount.textContent = info.chats.length + ' chat';

        var rows = [
            ['photos', info.stats.photos, 'photo'],
            ['videos', info.stats.videos, 'video'],
            ['files', info.stats.files, 'fayl'],
            ['audio', info.stats.audio, 'audio fayl'],
            ['links', info.stats.links, 'ulashilgan havola'],
            ['voice', info.stats.voice, 'ovozli xabar'],
            ['gif', info.stats.gif, 'GIF']
        ];
                   savedInfoStats.innerHTML = rows.map(function (r) {
         var clickable = (r[0] === 'photos' || r[0] === 'videos' || r[0] === 'files' || r[0] === 'audio' || r[0] === 'links' || r[0] === 'voice' || r[0] === 'gif') ? ' clickable' : '';
            return '<div class="saved-info-stat-row' + clickable + '" data-stat="' + r[0] + '"><span style="display:flex;align-items:center;justify-content:center;position:relative;width:20px;height:20px;">' + STAT_ICONS[r[0]] + '</span><span><b>' + r[1] + '</b> ' + r[2] + '</span></div>';
        }).join('');

       if (savedInfoPanel.classList.contains('media-open')) renderSavedMedia();

      savedInfoChatsData = info.chats;
if (!info.chats.length) {
    savedInfoChats.innerHTML = '<div class="internal-list__empty" style="padding:24px;">Hozircha xabarlar yo\'q.</div>';
} else {
    savedInfoChats.innerHTML = info.chats.map(function (c, idx) {
        var isActive = (activeSavedSubChatIndex === idx);
        var iconHtml = c.isMyNotes
            ? '<svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="12" y2="17"></line></svg>'
            : escapeHtml(c.name.charAt(0).toUpperCase());
        var color = c.isMyNotes ? '#4b9bea' : avatarColorFor(c.name);
        return '<div class="saved-info-chat-row' + (isActive ? ' active' : '') + '" data-chat-index="' + idx + '">' +
            '<div class="saved-info-chat-avatar" style="background:' + color + '">' + iconHtml + '</div>' +
            '<div class="saved-info-chat-body">' +
                '<div class="saved-info-chat-row1"><span class="saved-info-chat-name">' + escapeHtml(c.name) + '</span><span class="saved-info-chat-time">' + escapeHtml(c.lastTime) + '</span></div>' +
                '<div class="saved-info-chat-msg">' + escapeHtml(c.lastText) + '</div>' +
            '</div></div>';
    }).join('');
}
    }

    function refreshSavedInfoPanelIfVisible() {
        if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
    }

    function openSavedInfoPanel() { setRightPanel('saved'); }
    function closeSavedInfoPanel() { if (rightPanelMode === 'saved') setRightPanel('none'); }
    function toggleSavedInfoPanel() { setRightPanel(rightPanelMode === 'saved' ? 'none' : 'saved'); }
        savedInfoCloseBtn.addEventListener('click', closeSavedInfoPanel);



            var savedSubBackBtn = document.getElementById('savedSubBackBtn');



            var cmComposer = document.querySelector('.cm-composer');
var openChatBar = document.getElementById('openChatBar');
openChatBar.addEventListener('click', function () {
    openSavedMessages();
});

  savedInfoChats.addEventListener('click', function (e) {
    var row = e.target.closest('.saved-info-chat-row');
    if (!row) return;
    var idx = Number(row.dataset.chatIndex);
    var chat = savedInfoChatsData[idx];
    if (!chat) return;
    activeSavedSubChatIndex = idx;
    savedInfoChats.querySelectorAll('.saved-info-chat-row').forEach(function (r) { r.classList.remove('active'); });
    row.classList.add('active');
    openSavedSubChat(chat);
});

  function renderSavedMessagesList(list) {
    if (!list.length) return '<div class="internal-list__empty">Xabarlar yo\'q.</div>';
    var total = list.length;
    return '<div class="saved-message-list">' + list.map(function (message, i) {
        var otherClass = message.fromSelf === false ? ' from-other' : '';
        var senderHtml = message.fromSelf === false && message.senderName
            ? '<span class="saved-message-sender">' + escapeHtml(message.senderName) + '</span>'
            : '';
        var msgMime = message.fileMime || '';
        var isImageMsg = message.fileUrl && (msgMime.indexOf('image/') === 0 || msgMime.indexOf('video/') === 0);
        var savedSenderLabel = message.fromSelf === false ? (message.senderName || 'Foydalanuvchi') : 'Siz';
        var content = message.fileUrl
            ? fileMsgHtml(message.fileUrl, message.fileName, message.fileMime, message.fileSize, { sender: savedSenderLabel, time: message.time })
            : (message.audioUrl ? voiceMsgHtml(message.audioUrl, message.duration || 0) : linkifyText(message.text || ''));
        var bubbleClass = 'saved-message-bubble' + (isImageMsg ? ' media-bubble' : '');
        // Faqat oxirgi 12 ta xabarga stagger beramiz — ko'p xabar bo'lsa animatsiya cho'zilib ketmasin
        var delayIndex = Math.max(0, total - i - 1);
        var delay = Math.min(delayIndex, 11) * 22;
             return savedDayDividerHtml(list[i - 1], message) + '<div class="saved-message-row saved-msg-in' + otherClass + '" data-message-id="' + message.id + '" style="animation-delay:' + delay + 'ms">' +
            '<div class="' + bubbleClass + '">' + senderHtml + content + '<span class="saved-message-time">' + escapeHtml(message.time || '') + ' <span class="msg-status read">✓✓</span></span></div></div>';
    }).join('') + '</div>';
}
       function openSavedSubChat(chat) {
        document.body.classList.add('chat-open');
        savedSubBackBtn.style.display = 'flex';
        cmComposer.style.display = 'none';
        openChatBar.style.display = 'flex';
        cmAvatar.style.display = 'none';
        cmName.textContent = chat.name;
        cmStatus.style.display = 'block';
        cmStatus.textContent = chat.messages.length + ' ta saqlangan xabar';
        cmMessages.innerHTML = renderSavedMessagesList(chat.messages);
        cmMessages.classList.add('saved-view');
        cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
        cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
        cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
        applyTwemoji(cmMessages);
        scrollToBottomWhenReady();
        msgInput.placeholder = 'Xabar yozing...';
    }

   savedSubBackBtn.addEventListener('click', function () {
    savedSubBackBtn.style.display = 'none';
    activeSavedSubChatIndex = null;
    openSavedMessages();
});


       // ---------- Saqlangan xabarlar: Rasmlar, Videolar va Fayllar ko'rinishi (Telegram uslubida) ----------
    var smvBody = document.getElementById('smvBody');
    var smvTitle = document.getElementById('smvTitle');
        var mediaViewMessages = savedMessages;
    var mediaViewReturnMode = 'saved';
    var MONTHS_UZ = ['Yanvar','Fevral','Mart','Aprel','May','Iyun','Iyul','Avgust','Sentabr','Oktabr','Noyabr','Dekabr'];
    var currentMediaKind = 'photos';
    var FILE_COLORS = {
        pdf: '#e17076', ppt: '#e17076', pptx: '#e17076',
        xls: '#3cc9b6', xlsx: '#3cc9b6', csv: '#3cc9b6',
        doc: '#5b9bea', docx: '#5b9bea', txt: '#5b9bea',
        zip: '#e9a23b', rar: '#e9a23b', '7z': '#e9a23b'
    };

    function getSavedMedia(kind) {
        return (mediaViewMessages || []).filter(function (m) {
            if (!m.fileUrl) return false;
            var mime = m.fileMime || '';
            if (kind === 'gif') return mime.indexOf('image/gif') === 0;
            if (kind === 'videos') return mime.indexOf('video/') === 0;
            if (kind === 'audio') return mime.indexOf('audio/') === 0;
            if (kind === 'files') {
                return mime.indexOf('image/') !== 0 && mime.indexOf('video/') !== 0 && mime.indexOf('audio/') !== 0;
            }
            return mime.indexOf('image/') === 0 && mime.indexOf('image/gif') !== 0;
        }).slice().reverse();
    }


       var savedAudioPlayer = null;
    var savedAudioPlayBtn = null;
    var PLAY_ICON = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l10-6.5z"></path></svg>';
    var PAUSE_ICON = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 5h4v14H7zM13 5h4v14h-4z"></path></svg>';

        function syncAudioRows() {
        document.querySelectorAll('.smv-audio-row, .smv-voice-row').forEach(function (r) {
            var b = r.querySelector('.smv-audio-play');
            if (b) b.innerHTML = MusicPlayer.isPlaying(r.dataset.url) ? PAUSE_ICON : PLAY_ICON;
        });
    }
    MusicPlayer.onChange(syncAudioRows);

    function stopSavedAudio() {
        if (savedAudioPlayer) { savedAudioPlayer.pause(); savedAudioPlayer = null; }
        if (savedAudioPlayBtn) { savedAudioPlayBtn.innerHTML = PLAY_ICON; savedAudioPlayBtn = null; }
    }

    function renderSavedAudioList(items) {
        var nowYear = new Date().getFullYear();
        var groups = [];
        var groupMap = {};
        items.forEach(function (m) {
            var d = m.createdAt ? new Date(m.createdAt) : null;
            var valid = d && !isNaN(d.getTime());
            var key = valid ? d.getFullYear() + '-' + d.getMonth() : 'none';
            var label = valid
                ? MONTHS_UZ[d.getMonth()] + (d.getFullYear() !== nowYear ? ' ' + d.getFullYear() : '')
                : 'Boshqa';
            if (!groupMap[key]) {
                groupMap[key] = { label: label, items: [] };
                groups.push(groupMap[key]);
            }
            groupMap[key].items.push(m);
        });

        groups.forEach(function (g) {
            var title = document.createElement('div');
            title.className = 'smv-month';
            title.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span>' + g.label + '</span>';
            smvBody.appendChild(title);

            var list = document.createElement('div');
            list.className = 'smv-audio-list';

            g.items.forEach(function (m) {
                var name = m.fileName || 'Audio';
                var sizeText = formatFileSizeFull(m.fileSize);

                var row = document.createElement('div');
                row.className = 'smv-audio-row';
                    
                row.dataset.url = m.fileUrl;

                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'smv-audio-play';
                btn.innerHTML = PLAY_ICON;

                var info = document.createElement('div');
                info.className = 'smv-file-info';
                var nameEl = document.createElement('div');
                nameEl.className = 'smv-file-name';
                nameEl.textContent = name;
                nameEl.title = name;
                var metaEl = document.createElement('div');
                metaEl.className = 'smv-file-meta';
                metaEl.textContent = '00:00' + (sizeText ? ', ' + sizeText : '');
                info.appendChild(nameEl);
                info.appendChild(metaEl);

                row.appendChild(btn);
                row.appendChild(info);

                var probe = new Audio();
                probe.preload = 'metadata';
                probe.src = m.fileUrl;
                probe.addEventListener('loadedmetadata', function () {
                    if (isFinite(probe.duration)) {
                        metaEl.textContent = formatVideoDuration(probe.duration) + (sizeText ? ', ' + sizeText : '');
                    }
                });

                      row.addEventListener('click', function () {
                    MusicPlayer.play(
                        { url: m.fileUrl, name: name },
                        items.map(function (x) { return { url: x.fileUrl, name: x.fileName || 'Audio' }; })
                    );
                });

                list.appendChild(row);
            });

            smvBody.appendChild(list);
        });
                syncAudioRows();
    }








    function extractFirstLink(text) {
        var match = (text || '').match(/(https?:\/\/[^\s<]+|t\.me\/[^\s<]+|www\.[^\s<]+\.[a-z]{2,}[^\s<]*)/i);
        return match ? match[0] : null;
    }

    function getSavedLinks() {
        return (mediaViewMessages || []).filter(function (m) {
            return !!extractFirstLink(m.text);
        }).slice().reverse();
    }

    function formatDayHeader(date) {
        var nowYear = new Date().getFullYear();
        return date.getDate() + '-' + MONTHS_UZ[date.getMonth()].toLowerCase() + (date.getFullYear() !== nowYear ? ' ' + date.getFullYear() : '');
    }

    function renderSavedLinksList(items) {
        var groups = [];
        var groupMap = {};
        items.forEach(function (m) {
            var d = m.createdAt ? new Date(m.createdAt) : null;
            var valid = d && !isNaN(d.getTime());
            var key = valid ? d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() : 'none';
            var label = valid ? formatDayHeader(d) : 'Boshqa';
            if (!groupMap[key]) {
                groupMap[key] = { label: label, items: [] };
                groups.push(groupMap[key]);
            }
            groupMap[key].items.push(m);
        });

        groups.forEach(function (g) {
            var title = document.createElement('div');
            title.className = 'smv-month';
            title.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span>' + g.label + '</span>';
            smvBody.appendChild(title);

            g.items.forEach(function (m) {
                var link = extractFirstLink(m.text);
                if (!link) return;
                var normalized = /^https?:\/\//i.test(link) ? link : 'https://' + link;
                var domain = link;
                try { domain = new URL(normalized).hostname.replace(/^www\./, ''); } catch (e) {}

                var descText = (m.text || '').replace(link, '').trim();
                var titleText = descText.split('\n')[0].trim() || domain;
                if (titleText === descText) descText = '';

                var row = document.createElement('div');
                row.className = 'smv-link-row';

                var icon = document.createElement('div');
                icon.className = 'smv-link-icon';
                icon.style.background = avatarColorFor(domain);
                var img = document.createElement('img');
                img.src = 'https://www.google.com/s2/favicons?sz=64&domain=' + encodeURIComponent(domain);
                img.alt = '';
                img.addEventListener('error', function () {
                    icon.textContent = domain.charAt(0).toUpperCase();
                });
                icon.appendChild(img);

                var info = document.createElement('div');
                info.className = 'smv-link-info';
                var titleEl = document.createElement('div');
                titleEl.className = 'smv-link-title';
                titleEl.textContent = titleText;
                info.appendChild(titleEl);
                if (descText) {
                    var descEl = document.createElement('div');
                    descEl.className = 'smv-link-desc';
                    descEl.textContent = descText;
                    info.appendChild(descEl);
                }
                var urlEl = document.createElement('div');
                urlEl.className = 'smv-link-url';
                urlEl.textContent = link;
                info.appendChild(urlEl);

                row.appendChild(icon);
                row.appendChild(info);
                row.addEventListener('click', function () {
                    window.open(normalized, '_blank', 'noopener');
                });

                smvBody.appendChild(row);
            });
        });
    }











        function getSavedVoice() {
        return (mediaViewMessages || []).filter(function (m) { return !!m.audioUrl; }).slice().reverse();
    }

    function renderSavedVoiceList(items) {
        var nowYear = new Date().getFullYear();
        var groups = [];
        var groupMap = {};
        items.forEach(function (m) {
            var d = m.createdAt ? new Date(m.createdAt) : null;
            var valid = d && !isNaN(d.getTime());
            var key = valid ? d.getFullYear() + '-' + d.getMonth() : 'none';
            var label = valid
                ? MONTHS_UZ[d.getMonth()] + (d.getFullYear() !== nowYear ? ' ' + d.getFullYear() : '')
                : 'Boshqa';
            if (!groupMap[key]) {
                groupMap[key] = { label: label, items: [] };
                groups.push(groupMap[key]);
            }
            groupMap[key].items.push(m);
        });

        groups.forEach(function (g) {
            var title = document.createElement('div');
            title.className = 'smv-month';
            title.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span>' + g.label + '</span>';
            smvBody.appendChild(title);

            g.items.forEach(function (m) {
                var senderName = m.fromSelf === false ? (m.senderName || 'Foydalanuvchi') : currentUserName;

                var row = document.createElement('div');
                row.className = 'smv-voice-row';

                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'smv-audio-play';
                btn.innerHTML = PLAY_ICON;

                var info = document.createElement('div');
                info.className = 'smv-voice-info';
                var nameEl = document.createElement('div');
                nameEl.className = 'smv-voice-name';
                nameEl.textContent = senderName;
                var metaEl = document.createElement('div');
                metaEl.className = 'smv-voice-meta';
                var dateLabel = formatFileDate(m.createdAt);
                var durLabel = formatVideoDuration(m.duration || 0);
                metaEl.textContent = (dateLabel ? dateLabel + ', ' : '') + durLabel;
                info.appendChild(nameEl);
                info.appendChild(metaEl);

                row.appendChild(btn);
                row.appendChild(info);

                if (!m.duration) {
                    var probe = new Audio();
                    probe.preload = 'metadata';
                    probe.src = m.audioUrl;
                    probe.addEventListener('loadedmetadata', function () {
                        if (isFinite(probe.duration)) {
                            metaEl.textContent = (dateLabel ? dateLabel + ', ' : '') + formatVideoDuration(probe.duration);
                        }
                    });
                }

                   row.dataset.url = m.audioUrl;

                row.addEventListener('click', function () {
                    MusicPlayer.play(
                        { url: m.audioUrl, name: senderName, isVoice: true },
                        items.map(function (x) {
                            return {
                                url: x.audioUrl,
                                name: x.fromSelf === false ? (x.senderName || 'Foydalanuvchi') : currentUserName,
                                isVoice: true
                            };
                        })
                    );
                });

                smvBody.appendChild(row);
            });
        });
        syncAudioRows();
    }




    function formatVideoDuration(sec) {
        sec = Math.max(0, Math.floor(sec || 0));
        var h = Math.floor(sec / 3600);
        var m = Math.floor((sec % 3600) / 60);
        var s = sec % 60;
        var mm = (m < 10 ? '0' : '') + m;
        var ss = (s < 10 ? '0' : '') + s;
        return h > 0 ? h + ':' + mm + ':' + ss : mm + ':' + ss;
    }

    function formatFileSizeFull(bytes) {
        bytes = Number(bytes) || 0;
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        if (bytes < 1073741824) return (bytes / 1048576).toFixed(1) + ' MB';
        return (bytes / 1073741824).toFixed(1) + ' GB';
    }

    function formatFileDate(value) {
        var d = value ? new Date(value) : null;
        if (!d || isNaN(d.getTime())) return '';
        var hh = (d.getHours() < 10 ? '0' : '') + d.getHours();
        var mi = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
        return d.getDate() + '-' + MONTHS_UZ[d.getMonth()].toLowerCase() + ', ' + hh + ':' + mi;
    }

    function openFileFromList(m) {
        var name = m.fileName || 'Fayl';
        var ext = ((name.split('.').pop() || 'file').slice(0, 4)).toLowerCase();
        var appName = extAppHints[ext] || 'mos dastur';
        pendingDocTrigger = { dataset: { url: m.fileUrl, name: name } };
        docOpenIcon.textContent = ext;
        docOpenName.textContent = name;
        docOpenMeta.textContent = formatFileSizeFull(m.fileSize);
        docOpenStoreLink.href = 'https://play.google.com/store/search?q=' + encodeURIComponent(appName) + '&c=apps';
        docOpenOverlay.classList.add('show');
    }

     function renderSavedMedia() {
        var kind = currentMediaKind;
        stopSavedAudio();
        smvBody.innerHTML = '';
             var items = kind === 'links' ? getSavedLinks() : (kind === 'voice' ? getSavedVoice() : getSavedMedia(kind));
        if (!items.length) {
                        var emptyText = kind === 'videos' ? 'Hozircha videolar yo\'q.' : (kind === 'files' ? 'Hozircha fayllar yo\'q.' : (kind === 'audio' ? 'Hozircha audio fayllar yo\'q.' : (kind === 'links' ? 'Hozircha havolalar yo\'q.' : (kind === 'voice' ? 'Hozircha ovozli xabarlar yo\'q.' : (kind === 'gif' ? 'Hozircha GIF yo\'q.' : 'Hozircha rasmlar yo\'q.')))));
            smvBody.innerHTML = '<div class="internal-list__empty">' + emptyText + '</div>';
            return;
        }

        if (kind === 'audio') {
            renderSavedAudioList(items);
            return;
        }
        if (kind === 'links') {
            renderSavedLinksList(items);
            return;
        }
        if (kind === 'voice') {
            renderSavedVoiceList(items);
            return;
        }

        var nowYear = new Date().getFullYear();
        var groups = [];
        var groupMap = {};
        items.forEach(function (m) {
            var d = m.createdAt ? new Date(m.createdAt) : null;
            var valid = d && !isNaN(d.getTime());
            var key = valid ? d.getFullYear() + '-' + d.getMonth() : 'none';
            var label = valid
                ? MONTHS_UZ[d.getMonth()] + (d.getFullYear() !== nowYear ? ' ' + d.getFullYear() : '')
                : 'Boshqa';
            if (!groupMap[key]) {
                groupMap[key] = { label: label, items: [] };
                groups.push(groupMap[key]);
            }
            groupMap[key].items.push(m);
        });

        var allThumbs = [];
        groups.forEach(function (g) {
            var title = document.createElement('div');
            title.className = 'smv-month';
            title.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg><span>' + g.label + '</span>';
            smvBody.appendChild(title);

            /* ---------- FAYLLAR: ro'yxat ---------- */
            if (kind === 'files') {
                var list = document.createElement('div');
                list.className = 'smv-files';
                g.items.forEach(function (m) {
                    var name = m.fileName || 'Fayl';
                    var ext = ((name.split('.').pop() || 'file').slice(0, 4)).toLowerCase();
                    var row = document.createElement('div');
                    row.className = 'smv-file-row';

                    var icon = document.createElement('div');
                    icon.className = 'smv-file-icon';
                    icon.style.background = FILE_COLORS[ext] || '#7a8a9e';
                    icon.textContent = ext;

                    var info = document.createElement('div');
                    info.className = 'smv-file-info';
                    var nameEl = document.createElement('div');
                    nameEl.className = 'smv-file-name';
                    nameEl.textContent = name;
                    nameEl.title = name;
                    var sizeEl = document.createElement('div');
                    sizeEl.className = 'smv-file-meta';
                    sizeEl.textContent = formatFileSizeFull(m.fileSize);
                    var dateEl = document.createElement('div');
                    dateEl.className = 'smv-file-meta';
                    dateEl.textContent = formatFileDate(m.createdAt);

                    info.appendChild(nameEl);
                    info.appendChild(sizeEl);
                    info.appendChild(dateEl);
                    row.appendChild(icon);
                    row.appendChild(info);
                    row.addEventListener('click', function () { openFileFromList(m); });
                    list.appendChild(row);
                });
                smvBody.appendChild(list);
                return;
            }

            /* ---------- RASM / VIDEO: to'r ---------- */
            var grid = document.createElement('div');
            grid.className = 'smv-grid';

            g.items.forEach(function (m) {
                var cell = document.createElement('div');
                cell.className = 'smv-item';
                var thumb;

                if (kind === 'videos') {
                    thumb = document.createElement('video');
                    thumb.src = m.fileUrl + '#t=0.1';
                    thumb.preload = 'metadata';
                    thumb.muted = true;
                    thumb.playsInline = true;
                    cell.appendChild(thumb);

                    var badge = document.createElement('div');
                    badge.className = 'smv-duration';
                    badge.innerHTML = '<svg viewBox="0 0 24 24" fill="#fff"><path d="M8 5.5v13l10-6.5z"></path></svg><span>00:00</span>';
                    cell.appendChild(badge);
                    thumb.addEventListener('loadedmetadata', function () {
                        badge.querySelector('span').textContent = formatVideoDuration(thumb.duration);
                    });
                } else {
                    thumb = document.createElement('img');
                    thumb.src = m.fileUrl;
                    thumb.alt = m.fileName || '';
                    thumb.loading = 'lazy';
                    cell.appendChild(thumb);
                }

                thumb.dataset.full = m.fileUrl;
                thumb.dataset.sender = 'Siz';
                thumb.dataset.time = m.time || '';
                thumb.dataset.name = m.fileName || (kind === 'videos' ? 'video' : 'image');

                cell.addEventListener('click', function () {
                    openLightbox(thumb, allThumbs);
                });
                allThumbs.push(thumb);
                grid.appendChild(cell);
            });

            smvBody.appendChild(grid);
        });
    }

             function openSavedMediaView(kind, context) {
        if (kind !== 'photos' && kind !== 'videos' && kind !== 'files' && kind !== 'audio' && kind !== 'links' && kind !== 'voice' && kind !== 'gif') return;
        context = context || 'saved';
        mediaViewReturnMode = context;
        mediaViewMessages = (context === 'saved') ? savedMessages : activeChatMessages;
        currentMediaKind = kind;
        smvTitle.textContent = kind === 'videos' ? 'Videolar' : (kind === 'files' ? 'Fayllar' : (kind === 'audio' ? 'Audio fayllar' : (kind === 'links' ? 'Havolalar' : (kind === 'voice' ? 'Ovozli xabarlar' : (kind === 'gif' ? 'GIF' : 'Rasmlar')))));
        if (context === 'contact') {
            contactInfoPanel.classList.add('hidden');
            savedInfoPanel.classList.remove('hidden');
        } else if (context === 'channel') {
            channelInfoPanel.classList.add('hidden');
            savedInfoPanel.classList.remove('hidden');
        }
        renderSavedMedia();
        savedInfoPanel.classList.add('media-open');
    }
    function closeSavedMediaView() {
        stopSavedAudio();
        savedInfoPanel.classList.remove('media-open');
        if (mediaViewReturnMode === 'contact') {
            savedInfoPanel.classList.add('hidden');
            contactInfoPanel.classList.remove('hidden');
            mediaViewReturnMode = 'saved';
        } else if (mediaViewReturnMode === 'channel') {
            savedInfoPanel.classList.add('hidden');
            channelInfoPanel.classList.remove('hidden');
            mediaViewReturnMode = 'saved';
        }
    }

    savedInfoStats.addEventListener('click', function (e) {
        var row = e.target.closest('.saved-info-stat-row.clickable');
        if (!row) return;
        openSavedMediaView(row.dataset.stat);
    });
    document.getElementById('smvBack').addEventListener('click', closeSavedMediaView);


            // ---------- Lichka (shaxsiy chat) profil paneli ----------
    var contactInfoPanel = document.getElementById('contactInfoPanel');
    var cipAvatar = document.getElementById('cipAvatar');
    var cipName = document.getElementById('cipName');
    var cipStatus = document.getElementById('cipStatus');
    var cipChannelRow = document.getElementById('cipChannelRow');
    var cipChannelAvatar = document.getElementById('cipChannelAvatar');
    var cipChannelName = document.getElementById('cipChannelName');
    var cipChannelTime = document.getElementById('cipChannelTime');
    var cipChannelPreview = document.getElementById('cipChannelPreview');
    var cipChannelSub = document.getElementById('cipChannelSub');
                            var cipInfoBlock = document.getElementById('cipInfoBlock');
        var channelLastMsgCache = {}; // kanal oxirgi post matnini keshlaymiz — flicker bo'lmasligi uchun

      function renderContactInfoPanel() {
        if (!activeRecipientId) return;
        cipAvatar.style.background = cmAvatar.style.background || 'var(--accent)';
        cipAvatar.innerHTML = cmAvatar.innerHTML;
        cipName.textContent = cmName.textContent;
        var statusOnly = cmStatus.textContent.split('·').pop().trim();
        cipStatus.textContent = statusOnly;
        cipStatus.classList.toggle('online', cmStatus.classList.contains('cm-status-online'));

                                     var u = activeRecipientProfile || activeRecipientUser || {};
        var blocksHtml = '';

                // ---- Kanal (agar bu foydalanuvchiga tegishli kanal bo'lsa) ----
        var channel = u.channel;
        if (channel && channel.name) {
            var chIcon = channel.avatar
                ? '<img src="' + escapeHtml(channel.avatar) + '" alt="">'
                : escapeHtml(channel.name.charAt(0).toUpperCase());
            var chMembers = (channel.members_count !== undefined && channel.members_count !== null)
                ? channel.members_count + ' obunachi'
                : '';
                 var chFallbackText = channel.username ? 't.me/' + channel.username : '';
            var chCached = channelLastMsgCache[channel.id];
            var chInitialDesc = chCached ? chCached.desc : chFallbackText;
            var chInitialTime = chCached ? chCached.time : '';

            blocksHtml +=
                '<div class="cip-mini-channel" id="cipMiniChannel" data-entity-id="' + escapeHtml(String(channel.id || '')) + '">' +
                    '<span class="cip-mini-channel__icon" style="background:' + (channel.color || '#4b9bea') + '">' + chIcon + '</span>' +
                    '<div class="cip-mini-channel__body">' +
                        '<div class="cip-mini-channel__top">' +
                            '<span class="cip-mini-channel__name">' + escapeHtml(channel.name) +
                            '</span>' +
                            '<span class="cip-mini-channel__time" id="cipMiniChannelTime">' + escapeHtml(chInitialTime) + '</span>' +
                        '</div>' +
                        '<div class="cip-mini-channel__desc" id="cipMiniChannelDesc">' + escapeHtml(chInitialDesc) + '</div>' +
                        '<div class="cip-mini-channel__meta">Channel' + (chMembers ? ' · ' + escapeHtml(chMembers) : '') + '</div>' +
                    '</div>' +
                '</div>';

            if (channel.id) {
                fetch(publicChannelMessagesUrl + '/' + channel.id, { headers: { 'Accept': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        var msgs = data.messages || [];
                        var lastMsg = msgs[msgs.length - 1];
                        if (!lastMsg) return;
                        var descText = chatPreview(lastMsg).replace(/<[^>]*>/g, '').trim() || chFallbackText;
                        var timeText = formatSmartDateLabel(lastMsg.created_at);

                        var cached = channelLastMsgCache[channel.id];
                        if (cached && cached.desc === descText && cached.time === timeText) return;

                        channelLastMsgCache[channel.id] = { desc: descText, time: timeText };

                        var descEl = document.getElementById('cipMiniChannelDesc');
                        var timeEl = document.getElementById('cipMiniChannelTime');
                        if (descEl) descEl.textContent = descText;
                        if (timeEl) timeEl.textContent = timeText;
                    })
                    .catch(function () {});
            }
        }

        // ---- Telefon raqam (faqat foydalanuvchi ko'rsatishga ruxsat bergan bo'lsa) ----
        if (u.phone) {
            blocksHtml +=
                '<div class="cip-section-block">' +
                    '<div class="cip-section-label">Mobil raqam</div>' +
                    '<div class="cip-section-value">' + escapeHtml(u.phone) + '</div>' +
                '</div>';
        }

        // ---- Email ----
        if (u.email && u.show_email !== false) {
            blocksHtml +=
                '<div class="cip-section-block">' +
                    '<div class="cip-section-label">Email</div>' +
                    '<div class="cip-section-value">' + escapeHtml(u.email) + '</div>' +
                '</div>';
        }

        // ---- Bio ----
        if (u.bio) {
            blocksHtml +=
                '<div class="cip-section-block">' +
                    '<div class="cip-section-label">Bio</div>' +
                    '<div class="cip-section-value">' + linkifyText(u.bio) + '</div>' +
                '</div>';
        }

             // ---- Username ----
        if (u.username) {
            blocksHtml +=
                '<div class="cip-section-block">' +
                    '<div class="cip-section-label">Username</div>' +
                    '<div class="cip-section-value cip-username-value" id="cipUsernameValue" data-username="' + escapeHtml(u.username) + '">@' + escapeHtml(u.username) + '</div>' +
                '</div>';
        }

        cipInfoBlock.innerHTML = blocksHtml;
        applyTwemoji(cipInfoBlock);

        var usernameEl = document.getElementById('cipUsernameValue');
        if (usernameEl) {
            usernameEl.addEventListener('click', function () {
                var text = '@' + usernameEl.dataset.username;
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function () {
                        var original = usernameEl.textContent;
                        usernameEl.textContent = 'Nusxalandi!';
                        setTimeout(function () { usernameEl.textContent = original; }, 1200);
                    });
                }
            });
        }

        var miniChannel = document.getElementById('cipMiniChannel');
        if (miniChannel) {
            miniChannel.addEventListener('click', function () {
                var id = miniChannel.dataset.entityId;
                if (!id) return;
                var target = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + id + '"][data-kind="channel"]');
                if (target) target.click();
            });
        }
                renderContactStats();
    }



    var channelInfoBody = document.getElementById('channelInfoBody');



    function channelInfoGroupHtml(it, title) {
    if (!it) return '';
    var uname = (it.dataset.username || '').replace(/^@/, '').trim();
    var desc = (it.dataset.description || '').trim();
    if (!uname && !desc) return '';

    var html = '<div class="cip-info-group">';
    if (title) html += '<div class="cip-info-title">' + escapeHtml(title) + '</div>';
    if (uname) {
        html += '<div class="cip-info-row copyable" data-copy="https://t.me/' + escapeHtml(uname) + '">' +
            '<div class="cip-info-value is-link">t.me/' + escapeHtml(uname) + '</div>' +
            '<div class="cip-info-label">Havola</div></div>';
    }
    if (desc) {
        html += '<div class="cip-info-row">' +
            '<div class="cip-info-value">' + linkifyText(desc) + '</div>' +
            '<div class="cip-info-label">Tavsif</div></div>';
    }
    return html + '</div>';
}



    var channelStatsBlock = document.getElementById('channelStatsBlock');

    function mapEntityMessageForMedia(m, senderName) {
        return {
            id: m.id,
            createdAt: m.created_at,
            text: m.body || '',
            time: formatChatTime(m.created_at),
            fromSelf: false,
            senderName: senderName,
            audioUrl: m.audio_url || null,
            duration: m.audio_duration || null,
            fileUrl: m.file_url || null,
            fileName: m.file_name || null,
            fileMime: m.file_mime || null,
            fileSize: m.file_size || null
        };
    }

    function loadChannelMedia() {
        if (!activeEntityId) return;
        var entityId = activeEntityId;
        var isChat = activeIsDiscussionChat;
        var baseUrl = isChat ? entityChatsBaseUrl : entityMessagesBaseUrl;
        var name = cmName.textContent || 'Kanal';
        fetch(baseUrl + '/' + entityId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (activeEntityId !== entityId || activeIsDiscussionChat !== isChat) return;
                activeChatMessages = (data.messages || []).map(function (m) {
                    return mapEntityMessageForMedia(m, name);
                });
                renderChannelStats();
            })
            .catch(function () {});
    }

    function renderChannelStats() {
        var stats = computeContactMediaStats();
        var rows = [
            ['photos', stats.photos, 'photo'],
            ['videos', stats.videos, 'video'],
            ['files', stats.files, 'fayl'],
            ['audio', stats.audio, 'audio fayl'],
            ['links', stats.links, 'ulashilgan havola'],
            ['voice', stats.voice, 'ovozli xabar'],
            ['gif', stats.gif, 'GIF']
        ].filter(function (r) { return r[1] > 0; });

        channelStatsBlock.style.display = rows.length ? '' : 'none';
        channelStatsBlock.innerHTML = rows.map(function (r) {
            return '<div class="saved-info-stat-row clickable" data-stat="' + r[0] + '">' +
                '<span style="display:flex;align-items:center;justify-content:center;position:relative;width:20px;height:20px;">' + STAT_ICONS[r[0]] + '</span>' +
                '<span><b>' + r[1] + '</b> ' + r[2] + '</span></div>';
        }).join('');
    }

    channelStatsBlock.addEventListener('click', function (e) {
        var row = e.target.closest('.saved-info-stat-row.clickable');
        if (!row) return;
        openSavedMediaView(row.dataset.stat, 'channel');
    });



function renderChannelInfoPanel() {
    if (!activeEntityId) return;
    var item = chatItemsWrap.querySelector('.cl-item.active[data-entity-backend-id="' + activeEntityId + '"]');
    if (!item) return;

    var isChannel = item.dataset.kind === 'channel';
    var avatarEl = item.querySelector('.cl-avatar');
    var avatarInner = avatarEl ? avatarEl.innerHTML : '';
    var color = item.dataset.color || '#4b9bea';

    // Kanalga ulangan muhokama chati bormi?
    var linkedChat = isChannel
        ? chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + activeEntityId + '"][data-kind="chat"]')
        : null;

    var ICON_BELL = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>';
    var ICON_CHAT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.8 8.8 0 0 1-4-.9L3 21l1.5-4.5A8 8 0 0 1 3 11.5 8.5 8.5 0 0 1 12 3a8.5 8.5 0 0 1 9 8.5Z"></path></svg>';
   var ICON_MANAGE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6.5" cy="7" r="2.6"></circle><line x1="9.6" y1="7" x2="21" y2="7"></line><line x1="3" y1="17" x2="14.4" y2="17"></line><circle cx="17.5" cy="17" r="2.6"></circle></svg>';

    var actionsHtml =
        '<button class="cip-action-btn" id="chMuteBtn" type="button">' + ICON_BELL + '<span>Ovozsiz</span></button>' +
        (linkedChat
            ? '<button class="cip-action-btn" id="chDiscussBtn" type="button">' + ICON_CHAT + '<span>Muhokama</span></button>'
            : '') +
        '<button class="cip-action-btn" id="chManageBtn" type="button">' + ICON_MANAGE + '<span>Boshqarish</span></button>';

      var infoHtml = channelInfoGroupHtml(item, '');

    var subsMatch = (item.dataset.status || '').match(/\d+/);
    var subsCount = subsMatch ? subsMatch[0] : '1';
    var subsLabel = isChannel ? "obunachi" : "a'zo";

    var ICON_PEOPLE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
    var ICON_SHIELD = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"></path><path d="M9 12l2 2 4-4"></path></svg>';
    var ICON_LEAVE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>';

     var membersHtml =
        '<div class="cip-info-group cip-group-divider">' +
            '<div class="cip-info-row cip-info-row-icon copyable" id="cipSubscribersRow">' +
                ICON_PEOPLE +
                '<div><div class="cip-info-value">' + subsCount + ' ' + subsLabel + '</div></div>' +
            '</div>' +
            (isChannel
                ? '<div class="cip-info-row cip-info-row-icon copyable" id="cipAdminsRow">' +
                      ICON_SHIELD +
                      '<div><div class="cip-info-value">1 administrator</div></div>' +
                  '</div>'
                : '') +
        '</div>' +
        '<div class="cip-info-group cip-group-none">' +
            '<div class="cip-info-row cip-info-row-icon danger copyable" id="cipLeaveChannelRow">' +
                ICON_LEAVE +
                '<div class="cip-info-value">' + (isChannel ? "Kanalni tark etish" : "Guruhni tark etish") + '</div>' +
            '</div>' +
        '</div>';

       channelInfoBody.innerHTML =
        '<div class="cip-avatar-wrap">' +
            '<div class="cip-avatar" style="background:' + color + '">' + avatarInner + '</div>' +
            '<div class="cip-name">' + escapeHtml(item.dataset.name || '') + '</div>' +
            '<div class="cip-status">' + escapeHtml(item.dataset.status || '') + '</div>' +
        '</div>' +
        '<div class="cip-actions-row">' + actionsHtml + '</div>' +
        infoHtml;

    document.getElementById('channelBottomBlock').innerHTML = membersHtml;

    channelInfoBody.querySelectorAll('.cip-info-row.copyable').forEach(function (row) {
        row.addEventListener('click', function () {
            var valueEl = row.querySelector('.cip-info-value');
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(row.dataset.copy).then(function () {
                    var original = valueEl.textContent;
                    valueEl.textContent = 'Nusxalandi!';
                    setTimeout(function () { valueEl.textContent = original; }, 1200);
                });
            }
        });
    });

    applyTwemoji(channelInfoBody);
        channelStatsBlock.innerHTML = '';
    loadChannelMedia();

       document.getElementById('chMuteBtn').addEventListener('click', showComingSoon);
    document.getElementById('chManageBtn').addEventListener('click', showComingSoon);

    document.getElementById('cipSubscribersRow').addEventListener('click', showComingSoon);
    var adminsRowEl = document.getElementById('cipAdminsRow');
    if (adminsRowEl) adminsRowEl.addEventListener('click', showComingSoon);

    document.getElementById('cipLeaveChannelRow').addEventListener('click', function () {
        tgLeaveEntity(item);
    });
    var discussBtn = document.getElementById('chDiscussBtn');
    if (discussBtn) {
        discussBtn.addEventListener('click', function () {
            if (linkedChat) linkedChat.click();
        });
    }
}


      // ---------- Story viewer (Telegram uslubida: pauza, ovoz, reply, reaksiya) ----------
    var storyViewerOverlay = document.getElementById('storyViewerOverlay');
    var storyViewerImage = document.getElementById('storyViewerImage');
    var storyViewerVideo = document.getElementById('storyViewerVideo');
    var storyViewerName = document.getElementById('storyViewerName');
    var storyViewerCounter = document.getElementById('storyViewerCounter');
    var storyViewerAvatar = document.getElementById('storyViewerAvatar');
    var storyViewerTime = document.getElementById('storyViewerTime');
    var storyViewerCaption = document.getElementById('storyViewerCaption');
    var storyProgressWrap = document.getElementById('storyProgressWrap');
    var storyViewerPauseBtn = document.getElementById('storyViewerPauseBtn');
    var storyPauseIcon = document.getElementById('storyPauseIcon');
    var storyPlayIcon = document.getElementById('storyPlayIcon');
    var storyViewerMuteBtn = document.getElementById('storyViewerMuteBtn');
    var storyMuteOnIcon = document.getElementById('storyMuteOnIcon');
    var storyMuteOffIcon = document.getElementById('storyMuteOffIcon');
    var storyReplyInput = document.getElementById('storyReplyInput');
    var storyReactBtn = document.getElementById('storyReactBtn');
    var storyHeartIcon = document.getElementById('storyHeartIcon');
    var storiesUrlBase = "{{ url('/stories') }}";

       var storyList = [];
    var storyIndex = 0;
    var storyDuration = 5000; // rasm uchun standart; video uchun haqiqiy uzunlik ishlatiladi
    var storyRAF = null;
    var storySegmentStart = 0;
    var storyElapsed = 0;
       var storyPaused = false;
    var storyMuted = false;
    var storyOwnerId = null;

      function buildStoryProgressBars() {
        storyProgressWrap.innerHTML = '';
        storyList.forEach(function () {
            var bar = document.createElement('div');
            bar.style.cssText = 'flex:1;height:2.5px;border-radius:2px;background:rgba(255,255,255,0.35);overflow:hidden;';
            var fill = document.createElement('div');
            fill.className = 'story-progress-fill';
            fill.style.cssText = 'height:100%;width:0%;background:#fff;border-radius:2px;';
            bar.appendChild(fill);
            storyProgressWrap.appendChild(bar);
        });
    }

    function setBarWidth(idx, pct) {
        var bars = storyProgressWrap.querySelectorAll('.story-progress-fill');
        if (bars[idx]) bars[idx].style.width = pct + '%';
    }

    function markProgressDone(idx) {
        var bars = storyProgressWrap.querySelectorAll('.story-progress-fill');
        for (var i = 0; i < bars.length; i++) {
            bars[i].style.width = i < idx ? '100%' : '0%';
        }
    }

    function storyTick(ts) {
        if (storyPaused) return;
        if (!storySegmentStart) storySegmentStart = ts;
        var elapsed = storyElapsed + (ts - storySegmentStart);
        setBarWidth(storyIndex, Math.min(100, (elapsed / storyDuration) * 100));
        if (elapsed >= storyDuration) {
            goToNextStory();
            return;
        }
        storyRAF = requestAnimationFrame(storyTick);
    }

    function startStoryTimer() {
        cancelAnimationFrame(storyRAF);
        storyElapsed = 0;
        storySegmentStart = 0;
        storyPaused = false;
        storyPauseIcon.style.display = 'block';
        storyPlayIcon.style.display = 'none';
        storyRAF = requestAnimationFrame(storyTick);
    }

    function pauseStoryTimer() {
        if (storyPaused) return;
        storyPaused = true;
        cancelAnimationFrame(storyRAF);
        if (storySegmentStart) {
            storyElapsed += performance.now() - storySegmentStart;
            storySegmentStart = 0;
        }
        storyPauseIcon.style.display = 'none';
        storyPlayIcon.style.display = 'block';
        storyViewerVideo.pause();
    }

    function resumeStoryTimer() {
        if (!storyPaused) return;
        storyPaused = false;
        storySegmentStart = 0;
        storyPauseIcon.style.display = 'block';
        storyPlayIcon.style.display = 'none';
        storyRAF = requestAnimationFrame(storyTick);
        if (storyViewerVideo.style.display === 'block') storyViewerVideo.play().catch(function () {});
    }

    storyViewerPauseBtn.addEventListener('click', function () {
        if (storyPaused) resumeStoryTimer(); else pauseStoryTimer();
    });

    storyViewerMuteBtn.addEventListener('click', function () {
        storyMuted = !storyMuted;
        storyViewerVideo.muted = storyMuted;
        storyMuteOnIcon.style.display = storyMuted ? 'block' : 'none';
        storyMuteOffIcon.style.display = storyMuted ? 'none' : 'block';
    });

    storyReplyInput.addEventListener('focus', pauseStoryTimer);
    storyReplyInput.addEventListener('blur', function () {
        if (!storyReplyInput.value) resumeStoryTimer();
    });
    storyReplyInput.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter') return;
        var text = storyReplyInput.value.trim();
        if (!text || !storyOwnerId) { storyReplyInput.value = ''; return; }
                if (isQuietBlocked()) { storyReplyInput.value = ''; return; }
        fetch(messageBaseUrl + '/' + storyOwnerId, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: JSON.stringify({ body: text })
        }).catch(function () {});
        storyReplyInput.value = '';
        storyReplyInput.blur();
        resumeStoryTimer();
    });

    storyReactBtn.addEventListener('click', function () {
        var story = storyList[storyIndex];
        if (!story) return;
        storyHeartIcon.setAttribute('fill', '#f16565');
        storyHeartIcon.style.stroke = '#f16565';
        fetch(storiesUrlBase + '/' + story.id + '/react', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: JSON.stringify({ reaction: '❤️' })
        }).catch(function () {});
    });

    ['storyEmojiBtn', 'storyMicBtn'].forEach(function (id) {
        document.getElementById(id).addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            showComingSoon();
        });
    });

    function renderCurrentStory() {
        var story = storyList[storyIndex];
        if (!story) { closeStoryViewer(); return; }

        markProgressDone(storyIndex);
        storyViewerCounter.textContent = (storyIndex + 1) + '/' + storyList.length;
        storyViewerTime.textContent = formatSmartDateLabel(story.created_at);
        storyViewerCaption.textContent = story.caption || '';
        storyHeartIcon.setAttribute('fill', 'none');
        storyHeartIcon.style.stroke = '#fff';

          storyViewerVideo.pause();
        if (story.type === 'video') {
            storyViewerImage.style.display = 'none';
            storyViewerVideo.style.display = 'block';
            storyViewerVideo.src = story.media_url;
            storyViewerVideo.muted = storyMuted;
            storyViewerMuteBtn.style.display = 'flex';
            storyDuration = 5000; // haqiqiy uzunlik aniqlanguncha vaqtinchalik qiymat

            var metaHandled = false;
            function onVideoReady() {
                if (metaHandled) return;
                metaHandled = true;
                storyViewerVideo.removeEventListener('loadedmetadata', onVideoReady);
                storyViewerVideo.removeEventListener('error', onVideoReady);
                if (isFinite(storyViewerVideo.duration) && storyViewerVideo.duration > 0) {
                    storyDuration = storyViewerVideo.duration * 1000;
                }
                startStoryTimer();
            }
            storyViewerVideo.addEventListener('loadedmetadata', onVideoReady);
            storyViewerVideo.addEventListener('error', onVideoReady);

            storyViewerVideo.play().catch(function () {});
        } else {
            storyViewerVideo.style.display = 'none';
            storyViewerImage.style.display = 'block';
            storyViewerImage.src = story.media_url;
            storyViewerMuteBtn.style.display = 'none';
            storyDuration = 5000;
            startStoryTimer();
        }

        fetch(storiesUrlBase + '/' + story.id + '/view', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        }).catch(function () {});
    }

    function goToNextStory() {
        if (storyIndex < storyList.length - 1) {
            storyIndex++;
            renderCurrentStory();
        } else {
            closeStoryViewer();
        }
    }

    function goToPrevStory() {
        if (storyIndex > 0) {
            storyIndex--;
        }
        renderCurrentStory();
    }

    function closeStoryViewer() {
        cancelAnimationFrame(storyRAF);
        storyViewerVideo.pause();
        storyReplyInput.value = '';
        storyViewerOverlay.classList.remove('show');
    }

    function openStoryViewer(userId, userName, userAvatarHtml, startIndex) {
        fetch(userStoriesUrlBase + '/' + userId + '/stories', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                storyList = data.stories || [];
                if (!storyList.length) {
                    showComingSoon();
                    return;
                }
                storyOwnerId = userId;
                storyIndex = (typeof startIndex === 'number' && startIndex >= 0 && startIndex < storyList.length) ? startIndex : 0;
                storyViewerName.textContent = userName || '';
                storyViewerAvatar.innerHTML = userAvatarHtml || '';
                buildStoryProgressBars();
                storyViewerOverlay.classList.add('show');
                renderCurrentStory();
            })
            .catch(function () { showComingSoon(); });
    }


        var contactStoriesCache = [];

    function openContactStoriesView() {
        if (!activeRecipientId) return;
        mediaViewReturnMode = 'contact';
        currentMediaKind = 'stories';
        smvTitle.textContent = 'Yuborilgan hikoyalar';
        contactInfoPanel.classList.add('hidden');
        savedInfoPanel.classList.remove('hidden');
        smvBody.innerHTML = '<div class="csp-loading show"><span class="csp-spinner"></span><span>Yuklanmoqda...</span></div>';
        savedInfoPanel.classList.add('media-open');

        fetch(userStoriesUrlBase + '/' + activeRecipientId + '/stories', { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                contactStoriesCache = data.stories || [];
                renderContactStoriesGrid();
            })
            .catch(function () {
                smvBody.innerHTML = '<div class="internal-list__empty">Hikoyalarni yuklab bo\'lmadi.</div>';
            });
    }

    function renderContactStoriesGrid() {
        smvBody.innerHTML = '';
        if (!contactStoriesCache.length) {
            smvBody.innerHTML = '<div class="internal-list__empty">Hozircha hikoyalar yo\'q.</div>';
            return;
        }
        var grid = document.createElement('div');
        grid.className = 'smv-grid';

        var displayOrder = contactStoriesCache
            .map(function (story, idx) { return { story: story, idx: idx }; })
            .reverse();

        displayOrder.forEach(function (entry) {
            var story = entry.story;
            var idx = entry.idx;
            var cell = document.createElement('div');
            cell.className = 'smv-item';
            var thumb;

            if (story.type === 'video') {
                thumb = document.createElement('video');
                thumb.src = story.media_url + '#t=0.1';
                thumb.preload = 'metadata';
                thumb.muted = true;
                thumb.playsInline = true;
                cell.appendChild(thumb);

                var badge = document.createElement('div');
                badge.className = 'smv-duration';
                badge.innerHTML = '<svg viewBox="0 0 24 24" fill="#fff"><path d="M8 5.5v13l10-6.5z"></path></svg><span>00:00</span>';
                cell.appendChild(badge);
                thumb.addEventListener('loadedmetadata', function () {
                    badge.querySelector('span').textContent = formatVideoDuration(thumb.duration);
                });
            } else {
                thumb = document.createElement('img');
                thumb.src = story.media_url;
                thumb.loading = 'lazy';
                cell.appendChild(thumb);
            }

            cell.addEventListener('click', function () {
                openStoryViewer(activeRecipientId, cmName.textContent, cmAvatar.innerHTML, idx);
            });

            grid.appendChild(cell);
        });

        smvBody.appendChild(grid);
    }

    document.getElementById('storyViewerClose').addEventListener('click', closeStoryViewer);
    document.getElementById('storyViewerPrevZone').addEventListener('click', goToPrevStory);
    document.getElementById('storyViewerNextZone').addEventListener('click', goToNextStory);
    storyViewerOverlay.addEventListener('click', function (e) {
        if (e.target === storyViewerOverlay) closeStoryViewer();
    });

    

    function openContactInfoPanel() { setRightPanel('contact'); }
    function closeContactInfoPanel() { if (rightPanelMode === 'contact') setRightPanel('none'); }
    function toggleContactInfoPanel() { setRightPanel(rightPanelMode === 'contact' ? 'none' : 'contact'); }
    document.getElementById('contactInfoCloseBtn').addEventListener('click', closeContactInfoPanel);

         var cipStatsBlockEl = document.getElementById('cipStatsBlock');
    if (cipStatsBlockEl) {
        cipStatsBlockEl.addEventListener('click', function (e) {
            var row = e.target.closest('.saved-info-stat-row');
            if (!row) return;
                       if (row.dataset.stat === 'stories') {
                if (!activeRecipientId) return;
                openContactStoriesView();
                return;
            }
            if (!row.classList.contains('clickable')) return;
            openSavedMediaView(row.dataset.stat, 'contact');
        });
    }

        document.getElementById('channelInfoCloseBtn').addEventListener('click', function () {
        if (rightPanelMode === 'channel') setRightPanel('none');
    });


    document.getElementById('cipMessageBtn').addEventListener('click', function () {
        closeContactInfoPanel();
        msgInput.focus();
    });
    ['cipMuteBtn', 'cipGiftBtn'].forEach(function (id) {
        document.getElementById(id).addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            showComingSoon();
        });
    });

    document.querySelector('.cm-title').style.cursor = 'pointer';
  document.querySelector('.cm-title').addEventListener('click', function () {
    if (activeRecipientId) openContactInfoPanel();
    else if (activeEntityId) setRightPanel('channel');
});
    cmAvatar.style.cursor = 'pointer';
    cmAvatar.addEventListener('click', function () {
        if (activeRecipientId) openContactInfoPanel();
    });

    var clearHistoryConfirmOverlay = document.getElementById('clearHistoryConfirmOverlay');
    document.getElementById('clearHistoryCancel').addEventListener('click', function () {
        clearHistoryConfirmOverlay.classList.remove('show');
    });
    document.getElementById('clearHistoryOk').addEventListener('click', function () {
        clearSearchHistoryData();
        clearHistoryConfirmOverlay.classList.remove('show');
        runSearch(clSearchInput.value);
    });





    
    // ================= TELEGRAM USLUBIDAGI DIALOGLAR =================
    var entityLeaveBaseUrl = "{{ url('/entities') }}";
    var tgDialogOverlay = document.getElementById('tgDialogOverlay');
    var tgDialogHead = document.getElementById('tgDialogHead');
    var tgDialogAvatar = document.getElementById('tgDialogAvatar');
    var tgDialogTitle = document.getElementById('tgDialogTitle');
    var tgDialogText = document.getElementById('tgDialogText');
    var tgDialogChecks = document.getElementById('tgDialogChecks');
    var tgDialogAutoDelete = document.getElementById('tgDialogAutoDelete');
    var tgDialogOk = document.getElementById('tgDialogOk');
    var tgDialogState = null;
    var TG_CHECK_SVG = '<svg viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>';

    function closeTgDialog() {
        tgDialogOverlay.classList.remove('show');
        tgDialogState = null;
    }

    // cfg: { name, color, avatarHtml, textHtml, checks:[{key,label,checked}], autoDelete, confirmLabel, onConfirm(values) }
    function openTgDialog(cfg) {
        var values = {};
        if (cfg.name) {
            tgDialogHead.style.display = 'flex';
            tgDialogAvatar.style.background = cfg.color || 'var(--accent)';
            tgDialogAvatar.innerHTML = cfg.avatarHtml || escapeHtml(cfg.name.charAt(0).toUpperCase());
                        tgDialogTitle.textContent = cfg.title || cfg.name;
        } else {
            tgDialogHead.style.display = 'none';
        }
        tgDialogText.innerHTML = cfg.textHtml || '';
        tgDialogChecks.innerHTML = '';
        (cfg.checks || []).forEach(function (c) {
            values[c.key] = !!c.checked;
            var row = document.createElement('div');
            row.className = 'tg-check-row';
            row.innerHTML = '<span class="dc-check' + (c.checked ? ' checked' : '') + '">' + TG_CHECK_SVG + '</span><span>' + escapeHtml(c.label) + '</span>';
            row.addEventListener('click', function () {
                values[c.key] = !values[c.key];
                row.querySelector('.dc-check').classList.toggle('checked', values[c.key]);
            });
            tgDialogChecks.appendChild(row);
        });
        tgDialogAutoDelete.style.display = cfg.autoDelete ? 'block' : 'none';
        tgDialogOk.textContent = cfg.confirmLabel || 'OK';
        tgDialogState = { values: values, onConfirm: cfg.onConfirm };
        tgDialogOverlay.classList.add('show');
    }

    document.getElementById('tgDialogCancel').addEventListener('click', closeTgDialog);
    tgDialogOverlay.addEventListener('click', function (e) { if (e.target === tgDialogOverlay) closeTgDialog(); });
    tgDialogAutoDelete.addEventListener('click', function () { closeTgDialog(); showComingSoon(); });
    tgDialogOk.addEventListener('click', function () {
        var st = tgDialogState;
        closeTgDialog();
        if (st && st.onConfirm) st.onConfirm(st.values);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && tgDialogOverlay.classList.contains('show')) closeTgDialog();
    });

    function tgRequest(url, payload) {
        return fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: JSON.stringify(payload || {})
        }).then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.json().catch(function () { return {}; });
        });
    }

    function tgItemAvatar(item) {
        var av = item.querySelector('.cl-avatar');
        return av ? av.innerHTML : '';
    }

    // ---------- TARIXNI TOZALASH ----------
    function tgClearHistory(item) {
        if (!item) return;
        var kind = item.dataset.kind;
        var name = item.dataset.name || '';
        var checks = [];
        var textHtml;

        if (kind === 'personal') {
            textHtml = 'Rostdan ham <b>' + escapeHtml(name) + '</b> bilan yozishmadagi barcha xabarlarni o\'chirmoqchimisiz?';
            checks.push({ key: 'everyone', label: name + ' uchun ham o\'chirilsin', checked: false });
        } else if (kind === 'chat' || kind === 'group') {
            textHtml = 'Rostdan ham <b>"' + escapeHtml(name) + '"</b> dagi barcha xabarlarni o\'chirmoqchimisiz?';
            checks.push({ key: 'everyone', label: 'Hamma uchun o\'chirilsin', checked: false });
        } else {
            textHtml = 'Rostdan ham <b>"' + escapeHtml(name) + '"</b> dagi barcha xabarlarni o\'chirmoqchimisiz?';
        }
        textHtml += '<span class="tg-warn">Bu amalni qaytarib bo\'lmaydi.</span>';

        openTgDialog({
            textHtml: textHtml,
            checks: checks,
            autoDelete: kind !== 'saved',
            confirmLabel: "O'chirish",
            onConfirm: function (v) { tgRunClear(item, !!v.everyone); }
        });
    }

    function tgRunClear(item, everyone) {
        var kind = item.dataset.kind;
        var p;
        if (kind === 'saved') {
            var ids = savedMessages.map(function (m) { return m.id; })
                .filter(function (id) { return id && String(id).indexOf('tmp-') !== 0; });
            p = Promise.all(ids.map(function (id) {
                return fetch(savedMessagesDeleteBaseUrl + '/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                }).then(function (r) { if (!r.ok) throw new Error(); });
            })).then(function () { savedMessages = []; });
        } else if (kind === 'personal') {
            p = tgRequest(messageBaseUrl + '/' + item.dataset.userId + '/clear', { for_everyone: everyone });
        } else {
            var base = (kind === 'chat') ? entityChatsBaseUrl : entityMessagesBaseUrl;
            p = tgRequest(base + '/' + item.dataset.entityBackendId + '/clear', { for_everyone: everyone });
        }
        p.then(function () { tgAfterClear(item); })
         .catch(function () { alert("Tarixni tozalashda xatolik yuz berdi."); });
    }

    function tgAfterClear(item) {
        var kind = item.dataset.kind;
        var prev = item.querySelector('.cl-msg');
        if (prev) prev.innerHTML = '';
        var tm = item.querySelector('.cl-time');
        if (tm) tm.textContent = '';
        item.dataset.lastPreviewKey = '';
        var badge = item.querySelector('.cl-unread');
        if (badge) badge.remove();
        updateRailCounts();

        if (kind === 'saved') {
            if (activeInternalView === 'saved') {
                cmMessages.innerHTML = renderSavedMessages();
                cmMessages.classList.add('saved-view');
            }
            refreshSavedInfoPanelIfVisible();
            return;
        }
        if (!item.classList.contains('active')) return;

        renderedMessageIds = [];
        activeChatMessages = [];
        activeEntityUnreadIds = [];
        cmMessages.innerHTML = '<div class="cm-empty" id="cmEmptyState"><b>Hali hech qanday xabar yo\'q</b><span>Suhbatni boshlash uchun xabar yozing.</span></div>';
        cmEmptyState = document.getElementById('cmEmptyState');
        if (rightPanelMode === 'contact') renderContactStats();
        if (rightPanelMode === 'channel') renderChannelStats();
        hidePinnedBanner();
    }


        // ---------- SUHBATNI O'CHIRISH (lichka va Saqlangan xabarlar) ----------
    function tgDeleteChat(item) {
        if (!item) return;
        var kind = item.dataset.kind;
        var name = item.dataset.name || '';

        if (kind === 'saved') {
            openTgDialog({
                name: 'Saqlangan xabarlar',
                color: '#4b9bea',
                avatarHtml: tgItemAvatar(item),
                textHtml: 'Rostdan ham barcha saqlangan xabarlaringizni o\'chirmoqchimisiz?<span class="tg-warn">Bu amalni qaytarib bo\'lmaydi.</span>',
                confirmLabel: "O'chirish",
                onConfirm: function () { tgRunClear(item, false); }
            });
            return;
        }

        openTgDialog({
            name: name,
            title: "Suhbatni o'chirish",
            color: item.dataset.color,
            avatarHtml: tgItemAvatar(item),
            textHtml: '<b>' + escapeHtml(name) + '</b> bilan barcha xabarlar tarixini o\'chirmoqchimisiz?<span class="tg-warn">Bu amalni qaytarib bo\'lmaydi.</span>',
            checks: [{ key: 'everyone', label: name + ' uchun ham o\'chirilsin', checked: false }],
            confirmLabel: "O'chirish",
            onConfirm: function (v) {
                tgRequest(messageBaseUrl + '/' + item.dataset.userId + '/clear', { for_everyone: !!v.everyone })
                    .then(function () { tgAfterDeleteChat(item); })
                    .catch(function () { alert("Suhbatni o'chirishda xatolik yuz berdi."); });
            }
        });
    }

    function tgAfterDeleteChat(item) {
        var userId = item.dataset.userId;
        // Yaqinlar ro'yxatidan ham olamiz, aks holda sahifa yangilanganda qaytib chiqadi
        try {
            var users = JSON.parse(localStorage.getItem(recentUsersKey) || '[]').filter(function (u) {
                return String(u.id) !== String(userId);
            });
            localStorage.setItem(recentUsersKey, JSON.stringify(users));
        } catch (e) {}
        var wasActive = item.classList.contains('active');
        item.remove();
        updateRailCounts();
        applyArchivedVisibility();
        if (wasActive) tgResetChatView();
    }

    // ---------- GURUH / KANALDAN CHIQISH ----------
    function tgLeaveEntity(item) {
        if (!item) return;
        var kind = item.dataset.kind;
        var isChannel = (kind === 'channel');
        var checks = [];
        if (!isChannel) checks.push({ key: 'everyone', label: 'Hamma uchun o\'chirilsin', checked: false });
        checks.push({ key: 'folders', label: (isChannel ? 'Kanalni' : 'Guruhni') + ' barcha papkalardan olib tashlash', checked: false });

        openTgDialog({
            name: item.dataset.name || '',
            color: item.dataset.color,
            avatarHtml: tgItemAvatar(item),
            textHtml: 'Rostdan ham ushbu ' + (isChannel ? 'kanalni' : 'guruhni') + ' tark etmoqchimisiz?',
            checks: checks,
            confirmLabel: 'Tark etish',
            onConfirm: function (v) {
                tgRequest(entityLeaveBaseUrl + '/' + item.dataset.entityBackendId + '/leave', {
                    kind: kind,
                    delete_for_everyone: !!v.everyone,
                    remove_from_folders: !!v.folders
                }).then(function () { tgAfterLeave(item); })
                  .catch(function () { alert('Tark etishda xatolik yuz berdi.'); });
            }
        });
    }

    function tgAfterLeave(item) {
        var wasActive = item.classList.contains('active');
        item.remove();
        updateRailCounts();
        applyArchivedVisibility();
        if (wasActive) tgResetChatView();
    }

    function tgResetChatView() {
        activeEntityId = null;
        activeRecipientId = null;
        activeRecipientUser = null;
        activeRecipientProfile = null;
        activeChannelOpts = null;
        activeChatMessages = [];
        renderedMessageIds = [];
        document.body.classList.remove('chat-open');
        cmAvatar.style.display = 'none';
        cmName.textContent = 'Suhbat tanlanmagan';
        cmStatus.textContent = 'Chapdan bir suhbat tanlang';
        document.getElementById('cmDiscussBtn').style.display = 'none';
        document.getElementById('cmCallBtn').style.display = 'none';
        cmMessages.innerHTML = '<div class="cm-empty cm-empty--pill" id="cmEmptyState"><span>Xabar yozish uchun suhbatni tanlang</span></div>';
        cmEmptyState = document.getElementById('cmEmptyState');
        hidePinnedBanner();
        if (rightPanelMode !== 'none') setRightPanel('none');
    }

    // ---------- Send message ----------
    var msgInput = document.getElementById('msgInput');
    var sendBtn = document.getElementById('sendBtn');
    var attachFileBtn = document.getElementById('attachFileBtn');
    var attachFileInput = document.getElementById('attachFileInput');
    var cmMessages = document.getElementById('cmMessages');
    var cmEmptyState = document.getElementById('cmEmptyState');

    var scrollDownBtn = document.getElementById('scrollDownBtn');
var scrollDownBadge = document.getElementById('scrollDownBadge');
var scrollDownUnread = 0;

function updateScrollDownBtn() {
    if (!cmMessages) return;
    var distanceFromBottom = cmMessages.scrollHeight - cmMessages.scrollTop - cmMessages.clientHeight;
    var shouldShow = distanceFromBottom > 200;
    scrollDownBtn.classList.toggle('show', shouldShow);
    if (!shouldShow) {
        scrollDownUnread = 0;
        scrollDownBadge.style.display = 'none';
    }
}

cmMessages.addEventListener('scroll', updateScrollDownBtn);

scrollDownBtn.addEventListener('click', function () {
    cmMessages.scrollTo({ top: cmMessages.scrollHeight, behavior: 'smooth' });
});

// Yangi xabar qo'shilganda ham tugma holatini yangilab turadi
var scrollDownObserver = new MutationObserver(function () {
    updateScrollDownBtn();
    var distanceFromBottom = cmMessages.scrollHeight - cmMessages.scrollTop - cmMessages.clientHeight;
    if (distanceFromBottom > 200) {
        scrollDownUnread++;
        scrollDownBadge.textContent = scrollDownUnread > 9 ? '9+' : scrollDownUnread;
        scrollDownBadge.style.display = 'flex';
    }
});
scrollDownObserver.observe(cmMessages, { childList: true });

    function formatFileSize(bytes) {
        bytes = Number(bytes) || 0;
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

     function truncateFileName(name, maxLen) {
        maxLen = maxLen || 28;
        if (name.length <= maxLen) return name;
        var dotIndex = name.lastIndexOf('.');
        var ext = dotIndex > -1 ? name.slice(dotIndex) : '';
        var base = dotIndex > -1 ? name.slice(0, dotIndex) : name;
        var keepStart = Math.max(4, Math.ceil((maxLen - ext.length - 3) * 0.55));
        var keepEnd = Math.max(4, Math.floor((maxLen - ext.length - 3) * 0.45));
        return base.slice(0, keepStart) + '...' + base.slice(-keepEnd) + ext;
    }

    function fileMsgHtml(url, name, mime, size, meta) {
        name = name || 'Fayl';
        mime = mime || '';
        meta = meta || {};
        var safeUrl = escapeHtml(url || '');
        var safeFullName = escapeHtml(name);
        var safeSender = escapeHtml(meta.sender || '');
        var safeTime = escapeHtml(meta.time || '');

       if (mime.indexOf('image/') === 0) {
    var isGif = mime.indexOf('image/gif') === 0;
    return '<div class="file-msg file-media' + (isGif ? ' file-gif' : '') + '">' +
        '<img class="lightbox-img' + (isGif ? ' gif-img' : '') + '" src="' + safeUrl + '" alt="' + safeFullName + '" data-sender="' + safeSender + '" data-time="' + safeTime + '" data-name="' + safeFullName + '">' +
    '</div>';
}
        if (mime.indexOf('video/') === 0) {
            return '<div class="file-msg file-media"><video src="' + safeUrl + '" controls preload="metadata"></video></div>';
        }
        if (mime.indexOf('audio/') === 0) {
            return musicMsgHtml(safeUrl, safeFullName);
        }

            var extLabel = (name.split('.').pop() || 'file').slice(0, 4);
        var displayName = escapeHtml(truncateFileName(name, 28));
        var content = '<span class="file-msg__icon">' + escapeHtml(extLabel) + '</span><span class="file-msg__info"><span class="file-msg__name">' + displayName + '</span><span class="file-msg__meta">' + escapeHtml(formatFileSize(size)) + ' · Ochish</span></span>';
        return '<span class="file-msg file-doc doc-trigger" data-url="' + safeUrl + '" data-name="' + safeFullName + '" data-ext="' + escapeHtml(extLabel) + '" title="' + safeFullName + '">' + content + '</span>';
    }

function musicMsgHtml(safeUrl, safeName) {
    return '<div class="music-msg" data-url="' + safeUrl + '" data-name="' + safeName + '">' +
        '<button class="music-msg-play" type="button"><svg class="music-play-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l10-6.5z"></path></svg></button>' +
        '<div class="music-msg-info">' +
            '<span class="music-msg-name">' + safeName + '</span>' +
            '<div class="music-msg-meta"><span class="music-eq"><i></i><i></i><i></i></span><span>Musiqa</span><span class="music-msg-time"></span></div>' +
            '<div class="music-msg-bar"><div class="music-msg-bar-fill"></div></div>' +
        '</div>' +
        '<audio preload="metadata" src="' + safeUrl + '"></audio>' +
    '</div>';
}




    function sendSelectedFile(file, caption) {
            if (isQuietBlocked()) { attachFileInput.value = ''; return; }
    if (!file) return;
    var formData = new FormData();
    formData.append('file', file);
    if (caption) formData.append('body', caption);
    var headersF = {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'};
    var pf = { body: caption || '', file_url: URL.createObjectURL(file), file_name: file.name, file_mime: file.type, file_size: file.size };

    if (activeEntityId) {
        var snapFile = captureView();
        var sendOpts0 = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
        var tmpE = showPending(pf, sendOpts0);
        var fileTargetUrl = (snapFile.isChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + snapFile.entityId;
        fetch(fileTargetUrl, { method: 'POST', headers: headersF, body: formData })
            .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
            .then(function (data) {
                finishPending(tmpE);
                if (isSameView(snapFile)) {
                    appendMessage(data.message, sendOpts0);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'channel') renderChannelStats();
                    cmMessages.scrollTop = cmMessages.scrollHeight;
                }
                refreshEntityPreviews(snapFile.entityId);
                attachFileInput.value = '';
            })
            .catch(function () { finishPending(tmpE); alert('Kanalga fayl yuborilmadi.'); });
        return;
    }

    if (activeInternalView === 'saved') {
        var nowIsoF = new Date().toISOString();
        saveToServer(
            { id: 'tmp-' + Date.now(), createdAt: nowIsoF, text: '', time: formatChatTime(nowIsoF), fromSelf: true,
              fileUrl: URL.createObjectURL(file), fileName: file.name, fileMime: file.type, fileSize: file.size },
            formData, false
        );
        attachFileInput.value = '';
        return;
    }

    if (activeRecipientId) {
        var snapFileP = captureView();
        var tmpP = showPending(pf, null);
        fetch(messageBaseUrl + '/' + snapFileP.userId, { method: 'POST', headers: headersF, body: formData })
            .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
            .then(function (data) {
                finishPending(tmpP);
                if (isSameView(snapFileP)) {
                    appendMessage(data.message);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'contact') renderContactStats();
                    cmMessages.scrollTop = cmMessages.scrollHeight;
                }
                updateChatListPreview(snapFileP.userId, data.message);
                attachFileInput.value = '';
            })
            .catch(function () { finishPending(tmpP); alert('Faylni yuborishda xatolik yuz berdi.'); });
        return;
    }

    appendMessage({ id: 'local-' + Date.now(), sender_id: currentUserId, body: '', file_url: URL.createObjectURL(file), file_name: file.name, file_mime: file.type, file_size: file.size, created_at: new Date().toISOString() });
    attachFileInput.value = '';
    cmMessages.scrollTop = cmMessages.scrollHeight;
}



       function sendSelectedFile_OLD0(file, caption) {
        if (!file) return;
        var formData = new FormData();
        formData.append('file', file);
        if (caption) formData.append('body', caption);
        var headersF = {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'};

        if (activeEntityId) {
            var snapFile = captureView();
            var fileTargetUrl = (snapFile.isChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + snapFile.entityId;
            fetch(fileTargetUrl, { method: 'POST', headers: headersF, body: formData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    if (isSameView(snapFile)) {
                        var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                        appendMessage(data.message, sendOpts);
                        activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                        if (rightPanelMode === 'channel') renderChannelStats();
                        cmMessages.scrollTop = cmMessages.scrollHeight;
                    }
                    refreshEntityPreviews(snapFile.entityId);
                    attachFileInput.value = '';
                })
                .catch(function () { alert('Kanalga fayl yuborilmadi.'); });
            return;
        }

        if (activeInternalView === 'saved') {
            var snapSaved = captureView();
            fetch(savedMessagesUrl, { method: 'POST', headers: headersF, body: formData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    var message = data.message;
                    savedMessages.push({ id: message.id, createdAt: message.created_at, text: '', time: formatChatTime(message.created_at), fromSelf: true, fileUrl: message.file_url, fileName: message.file_name, fileMime: message.file_mime, fileSize: message.file_size });
                    updateSavedChatPreview(message);
                    if (isSameView(snapSaved)) {
                        cmMessages.innerHTML = renderSavedMessages();
                        cmMessages.classList.add('saved-view');
                        cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
                        cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
                        cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
                        applyTwemoji(cmMessages);
                        if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
                        cmMessages.scrollTop = cmMessages.scrollHeight;
                    }
                    attachFileInput.value = '';
                }).catch(function () { alert('Faylni saqlashda xatolik yuz berdi.'); });
            return;
        }

        if (activeRecipientId) {
            var snapFileP = captureView();
            fetch(messageBaseUrl + '/' + snapFileP.userId, { method: 'POST', headers: headersF, body: formData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    if (isSameView(snapFileP)) {
                        appendMessage(data.message);
                        activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                        if (rightPanelMode === 'contact') renderContactStats();
                        cmMessages.scrollTop = cmMessages.scrollHeight;
                    }
                    updateChatListPreview(snapFileP.userId, data.message);
                    attachFileInput.value = '';
                })
                .catch(function () { alert('Faylni yuborishda xatolik yuz berdi.'); });
            return;
        }

        appendMessage({ id: 'local-' + Date.now(), sender_id: currentUserId, body: '', file_url: URL.createObjectURL(file), file_name: file.name, file_mime: file.type, file_size: file.size, created_at: new Date().toISOString() });
        attachFileInput.value = '';
        cmMessages.scrollTop = cmMessages.scrollHeight;
    }

      function sendSelectedFile_OLD(file, caption) {
        if (!file) return;
        var formData = new FormData();
        formData.append('file', file);
        if (caption) formData.append('body', caption);

                if (activeEntityId) {
            var fileTargetUrl = (activeIsDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + activeEntityId;
            fetch(fileTargetUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}, body: formData })
                             .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                    if (sendOpts.forceOut) markSentMessage(activeEntityId, data.message.id);
                                                      appendMessage(data.message, sendOpts);
                    refreshEntityPreviews(activeEntityId);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'channel') renderChannelStats();
                    attachFileInput.value = ''; cmMessages.scrollTop = cmMessages.scrollHeight;
                })
                .catch(function () { alert('Kanalga fayl yuborilmadi.'); });
            return;
        }

        if (activeInternalView === 'saved') {
            fetch(savedMessagesUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}, body: formData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    var message = data.message;
                                      savedMessages.push({ id: message.id, createdAt: message.created_at, text: '', time: formatChatTime(message.created_at), fromSelf: true, fileUrl: message.file_url, fileName: message.file_name, fileMime: message.file_mime, fileSize: message.file_size });
                                     cmMessages.innerHTML = renderSavedMessages();
                    cmMessages.classList.add('saved-view');
                    cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
                    applyTwemoji(cmMessages);
                    if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
                    updateSavedChatPreview(message);
                    attachFileInput.value = '';
                    cmMessages.scrollTop = cmMessages.scrollHeight;
                }).catch(function () { alert('Faylni saqlashda xatolik yuz berdi.'); });
            return;
        }

           if (activeRecipientId) {
            fetch(messageBaseUrl + '/' + activeRecipientId, { method: 'POST', headers: {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}, body: formData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    appendMessage(data.message);
                    updateChatListPreview(activeRecipientId, data.message);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'contact') renderContactStats();
                    attachFileInput.value = ''; cmMessages.scrollTop = cmMessages.scrollHeight;
                })
                .catch(function () { alert('Faylni yuborishda xatolik yuz berdi.'); });
            return;
        }

        appendMessage({ id: 'local-' + Date.now(), sender_id: currentUserId, body: '', file_url: URL.createObjectURL(file), file_name: file.name, file_mime: file.type, file_size: file.size, created_at: new Date().toISOString() });
        attachFileInput.value = '';
        cmMessages.scrollTop = cmMessages.scrollHeight;
    }


        var docOpenOverlay = document.getElementById('docOpenOverlay');
    var docOpenIcon = document.getElementById('docOpenIcon');
    var docOpenName = document.getElementById('docOpenName');
    var docOpenConfirm = document.getElementById('docOpenConfirm');
    var docOpenStoreLink = document.getElementById('docOpenStoreLink');
    var pendingDocTrigger = null;

    var extAppHints = {
        xls: 'Excel', xlsx: 'Excel', doc: 'Word', docx: 'Word',
        ppt: 'PowerPoint', pptx: 'PowerPoint', pdf: 'PDF o\'quvchi'
    };

    var docOpenMeta = document.getElementById('docOpenMeta');

    cmMessages.addEventListener('click', function (e) {
        var trigger = e.target.closest('.doc-trigger');
        if (!trigger) return;
        pendingDocTrigger = trigger;
        var ext = (trigger.dataset.ext || 'file').toLowerCase();
        var appName = extAppHints[ext] || 'mos dastur';
        var metaText = trigger.querySelector('.file-msg__meta');
        docOpenIcon.textContent = ext;
        docOpenName.textContent = trigger.dataset.name || 'Fayl';
        docOpenMeta.textContent = metaText ? metaText.textContent.replace(' · Ochish', '') : '';
        docOpenStoreLink.href = 'https://play.google.com/store/search?q=' + encodeURIComponent(appName) + '&c=apps';
        docOpenOverlay.classList.add('show');
    });
    docOpenOverlay.addEventListener('click', function (e) {
        if (e.target === docOpenOverlay) docOpenOverlay.classList.remove('show');
    });

    docOpenConfirm.addEventListener('click', function () {
        if (pendingDocTrigger) {
            var a = document.createElement('a');
            a.href = pendingDocTrigger.dataset.url;
            a.download = pendingDocTrigger.dataset.name || 'file';
            document.body.appendChild(a);
            a.click();
            a.remove();
        }
        docOpenOverlay.classList.remove('show');
    });


        var lightboxOverlay = document.getElementById('lightboxOverlay');
    var lightboxImage = document.getElementById('lightboxImage');
     var lightboxVideo = document.getElementById('lightboxVideo');
    var lightboxClose = document.getElementById('lightboxClose');
    var lightboxDownload = document.getElementById('lightboxDownload');
    var lightboxPrev = document.getElementById('lightboxPrev');
    var lightboxNext = document.getElementById('lightboxNext');
    var lightboxSender = document.getElementById('lightboxSender');
    var lightboxTime = document.getElementById('lightboxTime');
    var lightboxCounter = document.getElementById('lightboxCounter');
    var lightboxList = [];
    var lightboxIndex = 0;

      function updateLightboxView() {
        var el = lightboxList[lightboxIndex];
        if (!el) return;
        var url = el.dataset.full || el.src;
        var isVideo = el.tagName === 'VIDEO';

        lightboxVideo.pause();
        if (isVideo) {
            lightboxImage.style.display = 'none';
            lightboxVideo.style.display = 'block';
            lightboxVideo.src = url;
            lightboxVideo.play().catch(function () {});
        } else {
            lightboxVideo.removeAttribute('src');
            lightboxVideo.load();
            lightboxVideo.style.display = 'none';
            lightboxImage.style.display = 'block';
            lightboxImage.src = url;
        }

        lightboxSender.textContent = el.dataset.sender || '';
        lightboxTime.textContent = el.dataset.time || '';
        lightboxCounter.textContent = (lightboxIndex + 1) + ' / ' + lightboxList.length;
        lightboxPrev.disabled = lightboxIndex <= 0;
        lightboxNext.disabled = lightboxIndex >= lightboxList.length - 1;
    }


    function openLightbox(clickedImg, customList) {
        lightboxList = customList && customList.length
            ? customList
            : Array.prototype.slice.call(cmMessages.querySelectorAll('.lightbox-img'));
        lightboxIndex = lightboxList.indexOf(clickedImg);
        if (lightboxIndex === -1) lightboxIndex = 0;
        updateLightboxView();
        lightboxOverlay.classList.add('show');
    }
     function closeLightbox() {
        lightboxVideo.pause();
        lightboxOverlay.classList.remove('show');
    }

    cmMessages.addEventListener('click', function (e) {
        var img = e.target.closest('.lightbox-img');
        if (!img) return;
        openLightbox(img);
    });

    cmMessages.addEventListener('click', function (e) {
        var footer = e.target.closest('.channel-post-footer');
        if (!footer) return;
        var linkedId = footer.dataset.linkedEntityId;
        if (!linkedId) return;
        var linkedItem = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + linkedId + '"][data-kind="chat"]');
        if (linkedItem) linkedItem.click();
    });

    lightboxClose.addEventListener('click', closeLightbox);
    lightboxOverlay.addEventListener('click', function (e) {
        if (e.target === lightboxOverlay) closeLightbox();
    });
    lightboxPrev.addEventListener('click', function () {
        if (lightboxIndex > 0) { lightboxIndex--; updateLightboxView(); }
    });
    lightboxNext.addEventListener('click', function () {
        if (lightboxIndex < lightboxList.length - 1) { lightboxIndex++; updateLightboxView(); }
    });
    lightboxDownload.addEventListener('click', function () {
        var img = lightboxList[lightboxIndex];
        if (!img) return;
        var a = document.createElement('a');
        a.href = img.dataset.full || img.src;
        a.download = img.dataset.name || 'image';
        document.body.appendChild(a);
        a.click();
        a.remove();
    });
    document.addEventListener('keydown', function (e) {
        if (!lightboxOverlay.classList.contains('show')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') { e.preventDefault(); lightboxPrev.click(); }
        if (e.key === 'ArrowRight') { e.preventDefault(); lightboxNext.click(); }
    });

      attachFileBtn.addEventListener('click', function () { attachFileInput.click(); });
      

    var imagePreviewOverlay = document.getElementById('imagePreviewOverlay');
    var imagePreviewImg = document.getElementById('imagePreviewImg');
    var imagePreviewCaption = document.getElementById('imagePreviewCaption');
    var imagePreviewCancel = document.getElementById('imagePreviewCancel');
    var imagePreviewSend = document.getElementById('imagePreviewSend');
    var pendingImageFile = null;

    attachFileInput.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;

        if (file.type.indexOf('image/') === 0) {
            pendingImageFile = file;
            imagePreviewImg.src = URL.createObjectURL(file);
            imagePreviewCaption.value = '';
            imagePreviewOverlay.classList.add('show');
            imagePreviewCaption.focus();
        } else {
            sendSelectedFile(file);
        }
    });

    imagePreviewCancel.addEventListener('click', function () {
        imagePreviewOverlay.classList.remove('show');
        pendingImageFile = null;
        attachFileInput.value = '';
    });

    imagePreviewSend.addEventListener('click', function () {
        if (!pendingImageFile) return;
        sendSelectedFile(pendingImageFile, imagePreviewCaption.value.trim());
        imagePreviewOverlay.classList.remove('show');
        pendingImageFile = null;
        attachFileInput.value = '';
    });

    imagePreviewCaption.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') imagePreviewSend.click();
    });


        function sendServerMessage(text) {
        var snap = captureView();
        msgInput.value = '';
        clearReply();
        refreshSendIcon();

        function failed(msg) {
            if (!msgInput.value) { msgInput.value = text; refreshSendIcon(); }
            alert(msg);
        }

                var tmpT = isSameView(snap)
            ? showPending({ body: text }, snap.entityId ? ((activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true }) : null)
            : null;

        if (snap.entityId) {
            var entityData = new FormData();
            entityData.append('body', text);
            var entityTargetUrl = (snap.isChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + snap.entityId;
            fetch(entityTargetUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }, body: entityData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                                    if (tmpT) finishPending(tmpT);
                    if (isSameView(snap)) {
                        var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                        appendMessage(data.message, sendOpts);
                        activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                        if (rightPanelMode === 'channel') renderChannelStats();
                        cmMessages.scrollTop = cmMessages.scrollHeight;
                    }
                    refreshEntityPreviews(snap.entityId);
                })
                               .catch(function () { if (tmpT) finishPending(tmpT); failed('Xabar yuborilmadi.'); });
            return;
        }

        if (activeRecipientUser) addUserToChatList(activeRecipientUser);
        fetch(messageBaseUrl + '/' + snap.userId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: text })
        })
                     .then(function (response) {
                return response.json().catch(function () { return {}; }).then(function (data) {
                    if (!response.ok) throw new Error(data.message || '');
                    return data;
                });
            })
            .then(function (data) {
                         if (tmpT) finishPending(tmpT);
                if (isSameView(snap)) {
                    appendMessage(data.message);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'contact') renderContactStats();
                    cmMessages.scrollTop = cmMessages.scrollHeight;
                }
                updateChatListPreview(snap.userId, data.message);
            })
                                         .catch(function (err) { if (tmpT) finishPending(tmpT); failed(err.message || 'Xabarni yuborishda xatolik yuz berdi.'); });
    }

   function sendServerMessage_OLD(text) {
        if (activeEntityId) {
            var entityData = new FormData();
            entityData.append('body', text);
            var entityTargetUrl = (activeIsDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + activeEntityId;
            fetch(entityTargetUrl, { method: 'POST', headers: {'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}, body: entityData })
                .then(function (response) { if (!response.ok) throw new Error(); return response.json(); })
                .then(function (data) {
                    var sendOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                    if (sendOpts.forceOut) markSentMessage(activeEntityId, data.message.id);
                                                      appendMessage(data.message, sendOpts);
                    refreshEntityPreviews(activeEntityId);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'channel') renderChannelStats();
                    msgInput.value = ''; clearReply(); refreshSendIcon(); cmMessages.scrollTop = cmMessages.scrollHeight;
                })
                .catch(function () { alert('Kanalga xabar yuborilmadi.'); });
            return;
        }
        if (activeRecipientUser) addUserToChatList(activeRecipientUser);
        fetch(messageBaseUrl + '/' + activeRecipientId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body: text })
        })
            .then(function (response) {
                if (!response.ok) throw new Error('Xabar yuborilmadi');
                return response.json();
            })
          .then(function (data) {
    appendMessage(data.message);
    renderedMessageIds.push(data.message.id);
    if (activeRecipientUser) addUserToChatList(activeRecipientUser);
    updateChatListPreview(activeRecipientId, data.message);
    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
    if (rightPanelMode === 'contact') renderContactStats();
    cmMessages.scrollTop = cmMessages.scrollHeight;
    msgInput.value = '';
    clearReply();
    refreshSendIcon();
})
            .catch(function () {
                alert('Xabarni yuborishda xatolik yuz berdi.');
            });
    }

        function sendMessage() {
                    if (isQuietBlocked()) return;
        var text = msgInput.value.trim();
        if (!text) return;

if (activeInternalView === 'saved') {
    var nowIso = new Date().toISOString();
    msgInput.value = '';
    refreshSendIcon();
    saveToServer(
        { id: 'tmp-' + Date.now(), createdAt: nowIso, text: text, time: formatChatTime(nowIso), fromSelf: true },
        JSON.stringify({ body: text }),
        true,
        function () { if (!msgInput.value) { msgInput.value = text; refreshSendIcon(); } }
    );
    return;
}

        // Editing an existing message: replace its text in place instead of sending new.
               if (editingRow) {
            var bubble = editingRow.querySelector('.msg-bubble');
            var timeSpan = bubble.querySelector('.msg-time');
            var timeHtml = timeSpan ? timeSpan.outerHTML : '';
            bubble.innerHTML = linkifyText(text) + '<span class="msg-edited">edited</span>' + timeHtml;
            editingRow = null;
            msgInput.value = '';
            refreshSendIcon();
            return;
        }

               if (activeRecipientId || activeEntityId) {
            sendServerMessage(text);
            return;
        }

        if (cmEmptyState) { cmEmptyState.remove(); cmEmptyState = null; }

        var row = document.createElement('div');
        row.className = 'msg-row out';

        var now = new Date();
        var h = now.getHours().toString().padStart(2, '0');
        var m = now.getMinutes().toString().padStart(2, '0');

        var quoteHtml = '';
        if (replyState) {
            quoteHtml = '<span class="msg-reply-quote"><b>' + replyState.name.replace(/</g, '&lt;') + '</b><br>' + replyState.text.replace(/</g, '&lt;') + '</span>';
        }

               row.innerHTML = '<div class="msg-bubble">' + quoteHtml + linkifyText(text) + '<span class="msg-time">' + h + ':' + m + '</span></div>';
        cmMessages.appendChild(row);
        cmMessages.scrollTop = cmMessages.scrollHeight;

        msgInput.value = '';
        clearReply();
        refreshSendIcon();
    }

    sendBtn.addEventListener('click', sendMessage);
    msgInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') sendMessage();
    });

document.getElementById('paneEmoji').addEventListener('click', function (e) {
    if (e.target.tagName !== 'BUTTON') return;
    var emoji = e.target.textContent;
    msgInput.value += emoji;
    msgInput.focus();
    addRecentEmoji(emoji);
    renderEmojiPanel();
    refreshSendIcon();
});

    /* =====================================================================
       CHAT OPTIONS DROPDOWN (the "..." button in the header)
       Create poll / Set Wallpaper / Export chat history / Clear history / Delete chat
    ===================================================================== */
    var chatMenuBtn = document.getElementById('chatMenuBtn');
    var chatOptionsMenu = document.getElementById('chatOptionsMenu');

    function openDropdown(menuEl, anchorEl) {
        closeAllDropdowns();
        if (menuEl.parentElement !== document.body) {
            document.body.appendChild(menuEl);
        }
        var r = anchorEl.getBoundingClientRect();
        menuEl.style.top = (r.bottom + 8) + 'px';
        menuEl.style.left = 'auto';
        menuEl.style.right = (window.innerWidth - r.right) + 'px';
        menuEl.classList.add('show');
    }
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu.show').forEach(function (m) { m.classList.remove('show'); });
    }

    chatMenuBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (chatOptionsMenu.classList.contains('show')) {
            closeAllDropdowns();
        } else {
            configureChatOptionsMenu();
            openDropdown(chatOptionsMenu, chatMenuBtn);
        }
    });


        // ================= HEADER "..." MENYUSI: kontekstga qarab elementlarni ko'rsatish =================
    function getActiveListItem() {
        if (activeRecipientId) {
            return chatItemsWrap.querySelector('.cl-item[data-user-id="' + activeRecipientId + '"]');
        }
        if (activeEntityId) {
            var kind = activeIsDiscussionChat ? 'chat' : 'channel';
            return chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + activeEntityId + '"][data-kind="' + kind + '"]');
        }
        return null;
    }

    function configureChatOptionsMenu() {
        var isPersonal = !!activeRecipientId;
        var isChannel = !!activeEntityId && !activeIsDiscussionChat;
        var isChat = !!activeEntityId && activeIsDiscussionChat;
        var isSaved = activeInternalView === 'saved'; // ⬅ YANGI QATOR
        var item = getActiveListItem();
        var state = item ? getItemState(item) : {};

        document.getElementById('headerMuteSubmenuWrap').style.display = isSaved ? 'none' : 'flex'; // ⬅ YANGI QATOR
        document.getElementById('headerMuteLabel').textContent = state.muted ? "Ovozni yoqish" : "Ovozsiz qilish";
        document.getElementById('headerMuteChevron').style.display = state.muted ? 'none' : 'block';
        document.getElementById('headerMuteBtn').classList.toggle('no-chevron', !!state.muted);

        document.getElementById('optViewInfo').style.display = isSaved ? 'none' : 'flex'; // ⬅ YANGI QATOR
              var viewInfoLabel = document.getElementById('optViewInfoLabel');
        viewInfoLabel.textContent = isPersonal ? "Profilni ko'rish" : (isChannel ? "Kanal ma'lumotlari" : "Guruh ma'lumotlari");
        document.getElementById('optViewInfoIcon').innerHTML = isPersonal
            ? '<circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle><path d="M6.5 19a5.5 5.5 0 0 1 11 0"></path>'
            : '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>';

        var manageLabel = document.getElementById('optManageLabel');
        document.getElementById('optManage').style.display = (isChannel || isChat) ? 'flex' : 'none';
        manageLabel.textContent = isChannel ? "Kanalni boshqarish" : "Guruhni boshqarish";

        document.getElementById('optStoryArchive').style.display = (isChannel || isChat) ? 'flex' : 'none';

        var boostLabel = document.getElementById('optBoostLabel');
        document.getElementById('optBoost').style.display = (isChannel || isChat) ? 'flex' : 'none';
        boostLabel.textContent = isChannel ? "Kanalni oshirish" : "Guruhni oshirish";

        document.getElementById('optCreatePoll').style.display = (isChannel || isChat || isSaved) ? 'flex' : 'none'; // ⬅ O'ZGARDI

        var linkedChat = isChannel ? chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + activeEntityId + '"][data-kind="chat"]') : null;
        document.getElementById('optViewDiscussion').style.display = linkedChat ? 'flex' : 'none';

        document.getElementById('optWallpaper').style.display = (isPersonal || isSaved) ? 'flex' : 'none'; // ⬅ O'ZGARDI

           document.getElementById('optDisableSharing').style.display = isPersonal ? 'flex' : 'none'; // ⬅ YANGI QATOR

              document.getElementById('optDisableSharingLabel').textContent = (item && getItemState(item).sharingDisabled) ? "Enable Sharing" : "Disable Sharing";

        var dangerLabel = document.getElementById('optDeleteLabel');
        var dangerIcon = document.getElementById('optDeleteIcon');
        dangerLabel.textContent = isChannel ? "Kanaldan chiqish" : (isChat ? "Guruhdan chiqish" : "Suhbatni o'chirish");
        dangerIcon.innerHTML = (isChannel || isChat)
            ? '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>'
            : '<polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path>';
    }

    document.getElementById('optViewInfo').addEventListener('click', function () {
        closeAllDropdowns();
        if (activeRecipientId) openContactInfoPanel();
        else if (activeEntityId) setRightPanel('channel');
    });
    document.getElementById('optManage').addEventListener('click', function () { closeAllDropdowns(); showComingSoon(); });
    document.getElementById('optStoryArchive').addEventListener('click', function () { closeAllDropdowns(); showComingSoon(); });
    document.getElementById('optBoost').addEventListener('click', function () { closeAllDropdowns(); showComingSoon(); });
    document.getElementById('optViewDiscussion').addEventListener('click', function () {
        closeAllDropdowns();
        var linkedChat = chatItemsWrap.querySelector('.cl-item[data-entity-backend-id="' + activeEntityId + '"][data-kind="chat"]');
        if (linkedChat) linkedChat.click();
    });

    // ---- Header mute submenu ----
    var headerMuteBtn = document.getElementById('headerMuteBtn');
    var headerMuteSubmenu = document.getElementById('headerMuteSubmenu');
    var headerMuteSubmenuWrap = document.getElementById('headerMuteSubmenuWrap');
    var headerMuteSubmenuTimeout = null;

    function openHeaderMuteSubmenu() {
        var r = headerMuteBtn.getBoundingClientRect();
        var subWidth = 220;
        var left = r.right + 4;
        if (left + subWidth > window.innerWidth) left = r.left - subWidth - 4;
        headerMuteSubmenu.style.left = left + 'px';
        headerMuteSubmenu.style.top = Math.min(r.top, window.innerHeight - 200) + 'px';
        headerMuteSubmenu.classList.add('show');
    }
    function closeHeaderMuteSubmenu() { headerMuteSubmenu.classList.remove('show'); }

    headerMuteBtn.addEventListener('mouseenter', function () {
        var item = getActiveListItem();
        if (item && getItemState(item).muted) return;
        clearTimeout(headerMuteSubmenuTimeout);
        openHeaderMuteSubmenu();
    });
    headerMuteBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        var item = getActiveListItem();
        var state = item ? getItemState(item) : {};
        if (state.muted) {
            if (item) setItemState(item, { muted: false });
            closeAllDropdowns();
            closeHeaderMuteSubmenu();
            return;
        }
        if (headerMuteSubmenu.classList.contains('show')) closeHeaderMuteSubmenu();
        else openHeaderMuteSubmenu();
    });
    headerMuteSubmenuWrap.addEventListener('mouseleave', function () {
        headerMuteSubmenuTimeout = setTimeout(closeHeaderMuteSubmenu, 200);
    });
    headerMuteSubmenu.addEventListener('mouseenter', function () { clearTimeout(headerMuteSubmenuTimeout); });
    headerMuteSubmenu.addEventListener('mouseleave', function () {
        headerMuteSubmenuTimeout = setTimeout(closeHeaderMuteSubmenu, 200);
    });
    headerMuteSubmenu.addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-mute-option]');
        if (!btn) return;
        e.stopPropagation();
        var item = getActiveListItem();
        var option = btn.dataset.muteOption;
        if (option === 'disable' || option === 'forever') {
            if (item) setItemState(item, { muted: true });
        } else {
            showComingSoon();
            closeHeaderMuteSubmenu();
            closeAllDropdowns();
            return;
        }
        closeHeaderMuteSubmenu();
        closeAllDropdowns();
    });

    document.getElementById('optCreatePoll').addEventListener('click', function () {
        closeAllDropdowns();
        alert("So'rovnoma yaratish tez orada qo'shiladi.");
    });

    document.getElementById('optWallpaper').addEventListener('click', function () {
        closeAllDropdowns();
        var color = prompt("Fon rangini kiriting (masalan #f4ecd8):", "#f4ecd8");
        if (color) {
            cmMessages.style.backgroundColor = color;
            cmMessages.style.backgroundImage = 'none';
        }
    });


        document.getElementById('optDisableSharing').addEventListener('click', function () {
        closeAllDropdowns();
        var item = getActiveListItem();
        if (!item) { showComingSoon(); return; }
        var state = getItemState(item);
        var newVal = !state.sharingDisabled;
        setItemState(item, { sharingDisabled: newVal });
        document.getElementById('optDisableSharingLabel').textContent = newVal ? "Enable Sharing" : "Disable Sharing";
    });

    document.getElementById('optExport').addEventListener('click', function () {
        closeAllDropdowns();
        var lines = [];
        cmMessages.querySelectorAll('.msg-row').forEach(function (row) {
            var who = row.classList.contains('out') ? 'Men' : (cmName.textContent || 'Suhbatdosh');
            var bubble = row.querySelector('.msg-bubble');
            var clone = bubble ? bubble.cloneNode(true) : null;
            if (clone) {
                var t = clone.querySelector('.msg-time');
                if (t) t.remove();
                lines.push(who + ': ' + clone.textContent.trim());
            }
        });
        var blob = new Blob([lines.join('\n') || 'Xabarlar yo\'q'], { type: 'text/plain' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = (cmName.textContent || 'chat') + '_tarix.txt';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
    });

    document.getElementById('optClear').addEventListener('click', function () {
        closeAllDropdowns();
        var it = (activeInternalView === 'saved') ? ensureSavedChatItem() : getActiveListItem();
        tgClearHistory(it);
    });


    document.getElementById('optDelete').addEventListener('click', function () {
        closeAllDropdowns();
        var it = (activeInternalView === 'saved') ? ensureSavedChatItem() : getActiveListItem();
        if (!it) return;
        if (it.dataset.kind === 'channel' || it.dataset.kind === 'chat' || it.dataset.kind === 'group') {
            tgLeaveEntity(it);
            return;
        }
        tgDeleteChat(it);
    });

    /* =====================================================================
       PINNED MESSAGE BANNER
    ===================================================================== */
    var pinnedBanner = document.getElementById('pinnedBanner');
    var pinnedBannerText = document.getElementById('pinnedBannerText');
    function showPinnedBanner(text) {
        pinnedBannerText.textContent = text;
        pinnedBanner.classList.add('show');
    }
    function hidePinnedBanner() {
        pinnedBanner.classList.remove('show');
    }
    document.getElementById('pinnedBannerClose').addEventListener('click', hidePinnedBanner);

    /* =====================================================================
       REPLY PREVIEW
    ===================================================================== */
    var replyPreview = document.getElementById('replyPreview');
    var replyPreviewName = document.getElementById('replyPreviewName');
    var replyPreviewText = document.getElementById('replyPreviewText');
    var replyState = null; // { name, text }

    function setReply(name, text) {
        replyState = { name: name, text: text };
        replyPreviewName.textContent = name;
        replyPreviewText.textContent = text;
        replyPreview.classList.add('show');
        msgInput.focus();
    }
    function clearReply() {
        replyState = null;
        replyPreview.classList.remove('show');
    }
    document.getElementById('replyPreviewClose').addEventListener('click', clearReply);

    /* =====================================================================
       EDIT STATE
    ===================================================================== */
    var editingRow = null; // the .msg-row currently being edited

    /* =====================================================================
       MESSAGE CONTEXT MENU (right-click on a message)
       Reply / Edit / Pin / Copy Text / Forward / Delete / Select
    ===================================================================== */
    var msgContextMenu = document.getElementById('msgContextMenu');
    var mcReply = document.getElementById('mcReply');
    var mcEdit = document.getElementById('mcEdit');
    var mcPin = document.getElementById('mcPin');
    var mcCopy = document.getElementById('mcCopy');
    var mcForward = document.getElementById('mcForward');
    var mcDelete = document.getElementById('mcDelete');
    var mcSelect = document.getElementById('mcSelect');
    var contextTargetRow = null;

    function bubbleText(row) {
        var bubble = row.querySelector('.msg-bubble, .saved-message-bubble');
        if (!bubble) return '';
        var clone = bubble.cloneNode(true);
        var t = clone.querySelector('.msg-time, .saved-message-time');
        if (t) t.remove();
        var s = clone.querySelector('.msg-sender, .saved-message-sender, .msg-reply-quote');
        if (s) s.remove();
        return clone.textContent.trim();
    }

    function openMessageMenu(row, x, y) {
        contextTargetRow = row;
        var isOut = row.classList.contains('out') || (row.classList.contains('saved-message-row') && !row.classList.contains('from-other'));
        mcEdit.style.display = isOut ? 'flex' : 'none';
        closeAllDropdowns();
        msgContextMenu.style.left = Math.min(x, window.innerWidth - 230) + 'px';
        msgContextMenu.style.top = Math.min(y, window.innerHeight - 320) + 'px';
        msgContextMenu.classList.add('show');
    }

    cmMessages.addEventListener('contextmenu', function (e) {
        var row = e.target.closest('.msg-row, .saved-message-row');
        if (!row) return;
        e.preventDefault();
        openMessageMenu(row, e.clientX, e.clientY);
    });

    // Also allow selecting a message while in selection mode via normal click
    cmMessages.addEventListener('click', function (e) {
        if (!document.body.classList.contains('selecting-mode')) return;
        var row = e.target.closest('.msg-row');
        if (!row) return;
        row.classList.toggle('msg-selected');
        updateSelectionCount();
    });

    mcReply.addEventListener('click', function () {
        if (!contextTargetRow) return;
        var name = contextTargetRow.classList.contains('out') ? 'Siz' : (cmName.textContent || 'Xabar');
        setReply(name, bubbleText(contextTargetRow));
        msgContextMenu.classList.remove('show');
    });

    mcEdit.addEventListener('click', function () {
        if (!contextTargetRow) return;
                if (isQuietBlocked()) { msgContextMenu.classList.remove('show'); return; }
        editingRow = contextTargetRow;
        msgInput.value = bubbleText(contextTargetRow);
        msgInput.focus();
        msgContextMenu.classList.remove('show');
    });

    mcPin.addEventListener('click', function () {
        if (!contextTargetRow) return;
        showPinnedBanner(bubbleText(contextTargetRow));
        msgContextMenu.classList.remove('show');
    });

    mcCopy.addEventListener('click', function () {
        if (!contextTargetRow) return;
        var text = bubbleText(contextTargetRow);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text);
        }
        msgContextMenu.classList.remove('show');
    });

    mcForward.addEventListener('click', function () {
        if (!contextTargetRow) return;
        savedMessages.push({
            text: bubbleText(contextTargetRow),
            time: new Date().toLocaleString('uz-UZ'),
            fromSelf: false,
            senderName: contextTargetRow.classList.contains('out') ? 'Siz' : (cmName.textContent || 'Foydalanuvchi')
        });
        localStorage.setItem('chatovbs_saved_messages', JSON.stringify(savedMessages));
        msgContextMenu.classList.remove('show');
        alert('Xabar Saqlangan xabarlarga forward qilindi.');
    });

     var deleteConfirmOverlay = document.getElementById('deleteConfirmOverlay');
    var deleteConfirmAlsoWrap = document.getElementById('deleteConfirmAlsoWrap');
    var deleteConfirmRecipient = document.getElementById('deleteConfirmRecipient');
    var dcCheckIcon = document.getElementById('dcCheckIcon');
    var deleteConfirmCancel = document.getElementById('deleteConfirmCancel');
    var deleteConfirmOk = document.getElementById('deleteConfirmOk');
 var alsoDeleteChecked = false;
var pendingDeleteCallback = null;

function openDeleteConfirm(showAlso, recipientName, onConfirm) {
    pendingDeleteCallback = onConfirm;
    if (showAlso) {
        deleteConfirmAlsoWrap.style.display = 'flex';
        deleteConfirmRecipient.textContent = recipientName || '';
        alsoDeleteChecked = true;
        dcCheckIcon.classList.add('checked');
    } else {
        deleteConfirmAlsoWrap.style.display = 'none';
    }
    deleteConfirmOverlay.classList.add('show');
}
    function closeDeleteConfirm() {
        deleteConfirmOverlay.classList.remove('show');
        pendingDeleteCallback = null;
    }
    deleteConfirmAlsoWrap.addEventListener('click', function () {
    alsoDeleteChecked = !alsoDeleteChecked;
    dcCheckIcon.classList.toggle('checked', alsoDeleteChecked);
});

    deleteConfirmCancel.addEventListener('click', closeDeleteConfirm);
    deleteConfirmOk.addEventListener('click', function () {
        if (pendingDeleteCallback) pendingDeleteCallback(alsoDeleteChecked);
        closeDeleteConfirm();
    });

   mcDelete.addEventListener('click', function () {
    if (!contextTargetRow) return;
    msgContextMenu.classList.remove('show');
    if (activeEntityId) { alert("Kanal/chat xabarini o'chirish hali qo'shilmagan."); return; }

    var isSaved = contextTargetRow.classList.contains('saved-message-row');
    var isOwnMessage = contextTargetRow.classList.contains('out');
    var showAlso = !isSaved && !!activeRecipientId && isOwnMessage;
    var recipientName = activeRecipientUser ? displayUserName(activeRecipientUser) : (cmName.textContent || '');

      openDeleteConfirm(showAlso, recipientName, function (alsoDelete) {
        if (isSaved) {
            var messageId = contextTargetRow.dataset.messageId;

            if (!messageId) {
                contextTargetRow.remove();
                refreshSavedInfoPanelIfVisible();
                return;
            }

            fetch(savedMessagesDeleteBaseUrl + '/' + messageId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    if (!response.ok) throw new Error();

                    var globalIdx = savedMessages.findIndex(function (m) { return String(m.id) === String(messageId); });
                    if (globalIdx > -1) savedMessages.splice(globalIdx, 1);
                                        if (window.ChatStorage) ChatStorage.removeMessage('s', 'm' + messageId);

                    if (activeSavedSubChatIndex !== null && savedInfoChatsData[activeSavedSubChatIndex]) {
                        var subChat = savedInfoChatsData[activeSavedSubChatIndex];
                        var subIdx = subChat.messages.findIndex(function (m) { return String(m.id) === String(messageId); });
                        if (subIdx > -1) subChat.messages.splice(subIdx, 1);
                        cmStatus.textContent = subChat.messages.length + ' ta saqlangan xabar';
                    }

                    contextTargetRow.remove();
                    refreshSavedInfoPanelIfVisible();
                })
                .catch(function () {
                    alert("Xabarni o'chirishda xatolik yuz berdi.");
                });
            return;
        }
        var messageId = contextTargetRow.dataset.messageId;
        if (!messageId) {
            contextTargetRow.remove();
            return;
        }

        fetch(messageBaseUrl + '/' + messageId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
                 body: JSON.stringify({ for_everyone: showAlso ? alsoDelete : false })
        })
            .then(function (response) {
                if (!response.ok) throw new Error();
                if (window.ChatStorage && activeRecipientId) ChatStorage.removeMessage('u:' + activeRecipientId, 'm' + messageId);
                contextTargetRow.remove();
            })
            .catch(function () {
                alert("Xabarni o'chirishda xatolik yuz berdi.");
            });
    });
});
    mcSelect.addEventListener('click', function () {
        enterSelectionMode();
        if (contextTargetRow) {
            contextTargetRow.classList.add('msg-selected');
            updateSelectionCount();
        }
        msgContextMenu.classList.remove('show');
    });

    /* =====================================================================
       SELECTION MODE
    ===================================================================== */
    var selectionToolbar = document.getElementById('selectionToolbar');
    var selCount = document.getElementById('selCount');

    function enterSelectionMode() {
        document.body.classList.add('selecting-mode');
        selectionToolbar.classList.add('show');
    }
    function exitSelectionMode() {
        document.body.classList.remove('selecting-mode');
        selectionToolbar.classList.remove('show');
        cmMessages.querySelectorAll('.msg-selected').forEach(function (r) { r.classList.remove('msg-selected'); });
    }
    function updateSelectionCount() {
        var n = cmMessages.querySelectorAll('.msg-row.msg-selected').length;
        selCount.textContent = n + ' ta tanlandi';
    }
    document.getElementById('selClose').addEventListener('click', exitSelectionMode);
    document.getElementById('selDelete').addEventListener('click', function () {
        cmMessages.querySelectorAll('.msg-row.msg-selected').forEach(function (r) { r.remove(); });
        exitSelectionMode();
    });
    document.getElementById('selForward').addEventListener('click', function () {
        var rows = cmMessages.querySelectorAll('.msg-row.msg-selected');
        rows.forEach(function (row) {
            savedMessages.push({
                text: bubbleText(row),
                time: new Date().toLocaleString('uz-UZ'),
                fromSelf: false,
                senderName: row.classList.contains('out') ? 'Siz' : (cmName.textContent || 'Foydalanuvchi')
            });
        });
        localStorage.setItem('chatovbs_saved_messages', JSON.stringify(savedMessages));
        alert(rows.length + " ta xabar Saqlangan xabarlarga forward qilindi.");
        exitSelectionMode();
    });

    // Close dropdowns / context menu on outside click
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown-menu') && !e.target.closest('#chatMenuBtn')) {
            closeAllDropdowns();
        }
        if (!e.target.closest('#msgContextMenu')) {
            msgContextMenu.classList.remove('show');
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            msgContextMenu.classList.remove('show');
        }
    });

    /* =====================================================================
       VOICE MESSAGES — mic when the input is empty, send icon when it has text
    ===================================================================== */
    var sendBtnIconSend = document.getElementById('sendBtnIconSend');
    var sendBtnIconMic = document.getElementById('sendBtnIconMic');
    var recIndicator = document.getElementById('recIndicator');
    var recIndicatorTime = document.getElementById('recIndicatorTime');
    var recCancelBtn = document.getElementById('recCancelBtn');



    var recIndicatorLabel = document.getElementById('recIndicatorLabel');
var isInCancelZone = false;

function isPointerOverSendBtn(x, y) {
    var rect = sendBtn.getBoundingClientRect();
    var pad = 12; // ozgina tolerantlik
    return x >= rect.left - pad && x <= rect.right + pad && y >= rect.top - pad && y <= rect.bottom + pad;
}

function setCancelZone(active) {
    if (isInCancelZone === active) return;
    isInCancelZone = active;
    recIndicator.classList.toggle('cancel-zone', active);
    sendBtn.classList.toggle('cancel-zone', active);
    recIndicatorLabel.textContent = active ? "Yozuvni bekor qilish uchun qo'yib yuboring" : 'Ovozli xabar yozilmoqda...';
}

function handleRecordPointerMove(event) {
    if (!mediaRecorder) return;
    setCancelZone(!isPointerOverSendBtn(event.clientX, event.clientY));
}

    function refreshSendIcon() {
        var hasText = msgInput.value.trim().length > 0;
        sendBtnIconSend.style.display = hasText ? 'block' : 'none';
        sendBtnIconMic.style.display = hasText ? 'none' : 'block';
    }
    msgInput.addEventListener('input', refreshSendIcon);
    refreshSendIcon();

    var mediaRecorder = null;
    var audioChunks = [];
    var recTimerInterval = null;
    var recStartTime = 0;
    var recCancelled = false;
    var mediaStreamRef = null;

    function formatRecTime(ms) {
        var totalSec = Math.floor(ms / 1000);
        var m = Math.floor(totalSec / 60);
        var s = totalSec % 60;
        return m + ':' + (s < 10 ? '0' : '') + s;
    }

    function formatRecTimeFine(ms) {
        ms = Math.max(0, ms);
        var m = Math.floor(ms / 60000);
        var s = Math.floor((ms % 60000) / 1000);
        var d = Math.floor((ms % 1000) / 100);
        return (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s + ',' + d;
    }

    function startRecording() {
                if (isQuietBlocked()) return;
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert("Bu brauzerda ovozli xabar yozib bo'lmaydi.");
            return;
        }
        navigator.mediaDevices.getUserMedia({ audio: true }).then(function (stream) {
            if (isQuietBlocked()) {
                stream.getTracks().forEach(function (track) { track.stop(); });
                return;
            }
            mediaStreamRef = stream;
            audioChunks = [];
            recCancelled = false;
            var mimeType = ['audio/webm;codecs=opus', 'audio/webm', 'audio/ogg;codecs=opus']
                .find(function (type) { return MediaRecorder.isTypeSupported(type); });
            mediaRecorder = new MediaRecorder(stream, mimeType ? { mimeType: mimeType } : undefined);
            mediaRecorder.addEventListener('dataavailable', function (e) {
                if (e.data && e.data.size > 0) audioChunks.push(e.data);
            });
                    mediaRecorder.addEventListener('stop', function () {
                        document.removeEventListener('pointermove', handleRecordPointerMove);
recIndicator.classList.remove('cancel-zone');
sendBtn.classList.remove('cancel-zone');
                stream.getTracks().forEach(function (t) { t.stop(); });
                recIndicator.classList.remove('show');
                sendBtn.classList.remove('recording');
                clearInterval(recTimerInterval);

                var chunks = audioChunks;
                var cancelled = recCancelled;
                var usedMimeType = mediaRecorder.mimeType;
                var duration = Math.max(1000, Date.now() - recStartTime);

                mediaRecorder = null;

                if (cancelled || !chunks.length) return;
                var blob = new Blob(chunks, { type: usedMimeType || 'audio/webm' });
                insertVoiceMessage(blob, duration);
            });
            mediaRecorder.start(250);
            setCancelZone(false);
            document.addEventListener('pointermove', handleRecordPointerMove);
            recStartTime = Date.now();
            recIndicator.classList.add('show');
            sendBtn.classList.add('recording');
                    recIndicatorTime.textContent = '00:00,0';
            recTimerInterval = setInterval(function () {
                recIndicatorTime.textContent = formatRecTimeFine(Date.now() - recStartTime);
            }, 50);
        }).catch(function () {
            alert("Mikrofonga ruxsat berilmadi.");
        });
    }

    function stopRecording(cancel) {
        recCancelled = !!cancel;
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
    }


        function insertVoiceMessage(blob, durationMs) {
                    if (isQuietBlocked()) return;
                if (activeInternalView === 'saved') {
            var fdS = new FormData();
            var extS = blob.type.indexOf('ogg') !== -1 ? 'ogg' : 'webm';
            fdS.append('audio', blob, 'voice-message.' + extS);
            fdS.append('duration', Math.round(durationMs / 1000));
            var nowIsoV = new Date().toISOString();
            saveToServer(
                { id: 'tmp-' + Date.now(), createdAt: nowIsoV, text: '', time: formatChatTime(nowIsoV), fromSelf: true,
                  audioUrl: URL.createObjectURL(blob), duration: Math.round(durationMs / 1000) },
                fdS, false
            );
            return;
        }

           if (!activeRecipientId && !activeEntityId) return;   // ← yangi
        var snap = captureView();  
        var formData = new FormData();
        var extension = blob.type.indexOf('ogg') !== -1 ? 'ogg' : 'webm';
        formData.append('audio', blob, 'voice-message.' + extension);
        formData.append('duration', Math.round(durationMs / 1000));

        var voiceUrl = snap.internal === 'saved'
            ? savedMessagesUrl
            : (snap.entityId
                ? (snap.isChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + snap.entityId
                : messageBaseUrl + '/' + snap.userId);

                        var tmpV = null;
        if (snap.internal !== 'saved' && isSameView(snap)) {
            tmpV = showPending(
                { audio_url: URL.createObjectURL(blob), audio_duration: Math.round(durationMs / 1000) },
                snap.entityId ? ((activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true }) : null
            );
        }

        fetch(voiceUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) {
                    var validationError = data.errors ? Object.values(data.errors).flat()[0] : null;
                    throw new Error(validationError || data.message || 'Ovozli xabar yuborilmadi');
                }
                return data;
            });
        }).then(function (data) {
                        if (tmpV) finishPending(tmpV);
            var same = isSameView(snap);

            if (snap.internal === 'saved') {
                var message = data.message;
                savedMessages.push({
                    id: message.id,
                    createdAt: message.created_at,
                    text: message.body || '',
                    time: formatChatTime(message.created_at),
                    fromSelf: true,
                    audioUrl: message.audio_url || null,
                    duration: message.audio_duration || null
                });
                updateSavedChatPreview(message);
                if (same) {
                    cmMessages.innerHTML = renderSavedMessages();
                    cmMessages.classList.add('saved-view');
                    cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
                    cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
                    cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
                    applyTwemoji(cmMessages);
                    if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
                }
            } else {
                if (same) {
                    var voiceOpts = null;
                    if (snap.entityId) {
                        voiceOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                    }
                    appendMessage(data.message, voiceOpts);
                    activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                    if (rightPanelMode === 'contact') renderContactStats();
                    if (rightPanelMode === 'channel') renderChannelStats();
                }
                if (snap.userId) updateChatListPreview(snap.userId, data.message);
                if (snap.entityId) refreshEntityPreviews(snap.entityId);
            }
            if (same) cmMessages.scrollTop = cmMessages.scrollHeight;
                      
        }).catch(function (error) {
                if (tmpV) finishPending(tmpV);
            alert(error.message || "Ovozli xabarni yuborishda xatolik yuz berdi.");
        });
    }

    function insertVoiceMessage_OLD(blob, durationMs) {
        if (activeInternalView !== 'saved' && !activeRecipientId && !activeEntityId) return;
        var formData = new FormData();
        var extension = blob.type.indexOf('ogg') !== -1 ? 'ogg' : 'webm';
        formData.append('audio', blob, 'voice-message.' + extension);
        formData.append('duration', Math.round(durationMs / 1000));
        fetch(activeInternalView === 'saved' ? savedMessagesUrl : (activeEntityId ? (activeIsDiscussionChat ? entityChatsBaseUrl : entityMessagesBaseUrl) + '/' + activeEntityId : messageBaseUrl + '/' + activeRecipientId), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            body: formData
        }).then(function (response) {
            return response.json().then(function (data) {
                if (!response.ok) {
                    var validationError = data.errors ? Object.values(data.errors).flat()[0] : null;
                    throw new Error(validationError || data.message || 'Ovozli xabar yuborilmadi');
                }
                return data;
            });
        }).then(function (data) {
                      if (activeInternalView === 'saved') {
                var message = data.message;
                savedMessages.push({
                    id: message.id,
                    createdAt: message.created_at,
                    text: message.body || '',
                    time: formatChatTime(message.created_at),
                    fromSelf: true,
                    audioUrl: message.audio_url || null,
                    duration: message.audio_duration || null
                });
                 updateSavedChatPreview(message);
                cmMessages.innerHTML = renderSavedMessages();
                cmMessages.classList.add('saved-view');
                cmMessages.querySelectorAll('.voice-msg').forEach(bindVoicePlayer);
cmMessages.querySelectorAll('.music-msg').forEach(bindMusicPlayer);
cmMessages.querySelectorAll('.file-msg video').forEach(fixVideoAspect);
                applyTwemoji(cmMessages);
                if (!savedInfoPanel.classList.contains('hidden')) renderSavedInfoPanel();
              } else {
                var voiceOpts = null;
                if (activeEntityId) {
                    voiceOpts = (activeChannelOpts && activeChannelOpts.channelName) ? activeChannelOpts : { forceOut: true };
                    if (voiceOpts.forceOut) markSentMessage(activeEntityId, data.message.id);
                }
                appendMessage(data.message, voiceOpts);
                            if (activeRecipientId) updateChatListPreview(activeRecipientId, data.message);
                if (activeEntityId) refreshEntityPreviews(activeEntityId);

                activeChatMessages.push(mapEntityMessageForMedia(data.message, 'Siz'));
                if (rightPanelMode === 'contact') renderContactStats();
                if (rightPanelMode === 'channel') renderChannelStats();
}
            cmMessages.scrollTop = cmMessages.scrollHeight;
        }).catch(function (error) {
            alert(error.message || "Ovozli xabarni yuborishda xatolik yuz berdi.");
        });
    }

    recCancelBtn.addEventListener('click', function () { stopRecording(true); });

    (function () {
        var dict = {
            uz: {
                mmProfile: 'Mening profilim', mmWallet: 'Hamyon', mmNewGroup: 'Yangi guruh', mmNewChannel: 'Yangi kanal', mmContacts: 'Kontaktlar', mmCalls: 'Qo\'ng\'iroqlar', mmSaved: 'Saqlangan xabarlar', mmSettings: 'Sozlamalar', mmNightMode: 'Tungi rejim'
            },
            ru: {
                mmProfile: 'Мой профиль', mmWallet: 'Кошелёк', mmNewGroup: 'Новая группа', mmNewChannel: 'Новый канал', mmContacts: 'Контакты', mmCalls: 'Звонки', mmSaved: 'Сохранённые сообщения', mmSettings: 'Настройки', mmNightMode: 'Ночной режим'
            },
            en: {
                mmProfile: 'My profile', mmWallet: 'Wallet', mmNewGroup: 'New group', mmNewChannel: 'New channel', mmContacts: 'Contacts', mmCalls: 'Calls', mmSaved: 'Saved messages', mmSettings: 'Settings', mmNightMode: 'Night mode'
            },
            ko: {
                mmProfile: '내 프로필', mmWallet: '지갑', mmNewGroup: '새 그룹', mmNewChannel: '새 채널', mmContacts: '연락처', mmCalls: '통화', mmSaved: '저장된 메시지', mmSettings: '설정', mmNightMode: '야간 모드'
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
        var initial = (window.CHATOVBS_SETTINGS && window.CHATOVBS_SETTINGS.language) || 'uz';
        apply(initial);
        window.addEventListener('chatovbs:language', function (event) { apply(event.detail || 'uz'); });
    })();

    var recordingPointerId = null;
    sendBtn.addEventListener('pointerdown', function (event) {
        if (msgInput.value.trim().length > 0 || mediaRecorder) return;
                if (msgInput.value.trim().length > 0 || mediaRecorder || isQuietBlocked()) return;
        event.preventDefault();
        recordingPointerId = event.pointerId;
        sendBtn.setPointerCapture(event.pointerId);
        startRecording();
    });
   sendBtn.addEventListener('pointerup', function (event) {
    if (event.pointerId !== recordingPointerId) return;
    recordingPointerId = null;
    stopRecording(isInCancelZone);
});
    sendBtn.addEventListener('pointercancel', function (event) {
        if (event.pointerId !== recordingPointerId) return;
        recordingPointerId = null;
        stopRecording(true);
    });
    sendBtn.addEventListener('click', function (event) {
        if (msgInput.value.trim().length === 0) event.preventDefault();
    });
})();












/* ---------- Tinch soatlar (v2): lichka, kanal, guruh yopiladi; Saqlangan xabarlar ochiq ---------- */
(function () {
    var DEFAULT_MSG = "Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙";
    var composer = document.querySelector('.cm-composer');
    var input = document.getElementById('msgInput');
    var messages = document.getElementById('cmMessages');
    var sidePanel = document.getElementById('sidePanel');
    var recIndicator = document.getElementById('recIndicator');
    var recCancel = document.getElementById('recCancelBtn');
    if (!composer || !input) return;

    // Stil: xiralashadi va bosilmaydi
    var st = document.createElement('style');
    st.textContent =
        '.cm-composer.is-quiet-locked{opacity:.4;filter:grayscale(.6);pointer-events:none;user-select:none;}' +
        '.cm-composer.is-quiet-locked *{cursor:not-allowed !important;}' +
        '.cm-messages{min-height:0;}' +
        '.quiet-banner{flex:0 0 auto;margin:0;position:relative;z-index:1;}' +
        '.quiet-banner + .cm-composer{margin-top:0 !important;}';
    document.head.appendChild(st);

    var banner = document.createElement('div');
    banner.className = 'quiet-banner';
    banner.style.cssText = 'display:none;align-items:center;gap:10px;padding:10px 22px;background:#fbf3e0;border-top:1px solid #e5e2d8;font-size:12.5px;color:#6b4e12;';
    banner.innerHTML = '<b>🌙 Dam olish vaqti:</b><span></span>';
    composer.parentNode.insertBefore(banner, composer);

    function mins(v) { var p = String(v || '00:00').split(':'); return (+p[0] || 0) * 60 + (+p[1] || 0); }

    function getPrefs() {
        var S = window.CHATOVBS_SETTINGS || {};
        var Q = S.quiet || {};
        return {
            enabled: Q.enabled !== undefined ? !!Q.enabled : (S.quiet_hours_enabled === undefined ? true : !!S.quiet_hours_enabled),
            start: Q.start || S.quiet_hours_start || '06:00',
            end: Q.end || S.quiet_hours_end || '22:00',
            message: Q.message || S.quiet_hours_message || DEFAULT_MSG
        };
    }

    var wasLocked = false;
    function check() {
        var p = getPrefs();
        var d = new Date(), n = d.getHours() * 60 + d.getMinutes(), s = mins(p.start), e = mins(p.end);
        var open = s === e || (s < e ? (n >= s && n < e) : (n >= s || n < e));
        var isSaved = window.__activeInternalView === 'saved' || messages.classList.contains('saved-view');
              var lockedSelf = !!p.enabled && !open && !isSaved;
        var peer = window.__peerQuiet;
        var lockedPeer = !!peer && !isSaved;
        var locked = lockedSelf || lockedPeer;
        window.__quietLocked = locked;

        banner.querySelector('span').textContent = lockedPeer
            ? (peer.name + ': ' + (peer.message || DEFAULT_MSG))
            : (p.message || DEFAULT_MSG);
        banner.style.display = locked ? 'flex' : 'none';
        composer.classList.toggle('is-quiet-locked', locked);
               input.disabled = locked;
        input.readOnly = locked;
        if (locked) {
            if (input.value) { input.value = ''; input.dispatchEvent(new Event('input')); }
            if (document.activeElement === input) input.blur();
        }

        if (locked && !wasLocked) {
            if (recIndicator && recIndicator.classList.contains('show') && recCancel) recCancel.click(); // yozilayotgan ovozni bekor qiladi
            if (sidePanel && !sidePanel.classList.contains('hidden')) {
                var eb = document.getElementById('composerEmojiBtn');
                if (eb) { composer.classList.remove('is-quiet-locked'); eb.click(); composer.classList.add('is-quiet-locked'); }
            }
        }
        wasLocked = locked;
    }

        // Qulf paytida hech qanday harf kiritilmasin (yopishtirish, emoji va h.k. ham)
    input.addEventListener('beforeinput', function (ev) {
        if (window.__quietLocked) ev.preventDefault();
    });

        input.addEventListener('input', function () {
        if (window.__quietLocked && input.value) {
            input.value = '';
            input.dispatchEvent(new CustomEvent('quiet-cleared'));
        }
    });

    // Ovozli yozishni boshlashga urinishni ham to'sib qo'yamiz (zaxira himoya)
    ['pointerdown', 'click', 'keydown'].forEach(function (evt) {
        composer.addEventListener(evt, function (ev) {
            if (composer.classList.contains('is-quiet-locked')) { ev.stopImmediatePropagation(); ev.preventDefault(); }
        }, true);
    });

    check();
    setInterval(check, 1000);                       // chat almashganda ham tez yangilanadi
    window.addEventListener('storage', check);
    window.addEventListener('chatovbs:view-change', check);
})();
</script>
@include('partials.storage-ledger')
<script>setInterval(function () { if (window.ChatStorage) ChatStorage.scanAll(); }, 300000);</script>
@include('partials.language-runtime')
@endsection
