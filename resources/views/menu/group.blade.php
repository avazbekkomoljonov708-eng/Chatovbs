<!DOCTYPE html>
<html lang="uz" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guruh yaratish</title>
<style>
    * { margin:0; padding:0; box-sizing:border-box; }

    :root {
        --radius-xl: 24px;
        --radius-lg: 17px;
        --radius-md: 12px;
    }

    html[data-theme="dark"] {
        --bg: #050505;
        --panel: linear-gradient(165deg, #131313, #0a0a0a);
        --border: rgba(255,255,255,.1);
        --border-soft: rgba(255,255,255,.06);
        --text: #f5f5f5;
        --muted: #8a8a8a;
        --muted-2: #565656;
        --surface: rgba(255,255,255,.035);
        --surface-hover: rgba(255,255,255,.07);
        --invert-bg: #f5f5f5;
        --invert-text: #0a0a0a;
        --ring: rgba(255,255,255,.16);
    }

    html[data-theme="light"] {
        --bg: #f2f2f0;
        --panel: linear-gradient(165deg, #ffffff, #f7f7f5);
        --border: rgba(0,0,0,.1);
        --border-soft: rgba(0,0,0,.06);
        --text: #111111;
        --muted: #6b6b6b;
        --muted-2: #9a9a9a;
        --surface: rgba(0,0,0,.03);
        --surface-hover: rgba(0,0,0,.055);
        --invert-bg: #111111;
        --invert-text: #f5f5f5;
        --ring: rgba(0,0,0,.14);
    }

    html { scroll-behavior: smooth; }

    body {
        min-height: 100vh;
        font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        color: var(--text);
        background: var(--bg);
        transition: background .35s ease, color .35s ease;
    }

    button, input, textarea { font: inherit; }
    h1, h2, h3, h4 { font-weight: 750; letter-spacing: -.02em; }
    p { line-height: 1.55; }

    .page { min-height: 100vh; padding: 40px; }
    .container { max-width: 1320px; margin: 0 auto; }

    .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px; }
    .topbar-left { display: flex; align-items: center; gap: 13px; }
    .topbar-right { display: flex; align-items: center; gap: 10px; }

    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        height: 36px; padding: 0 14px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--text);
        font-size: 11.5px; font-weight: 650;
        text-decoration: none;
        transition: .2s ease;
    }
    .back-link svg { width: 14px; height: 14px; flex-shrink: 0; }
    .back-link:hover { background: var(--surface-hover); border-color: var(--muted-2); transform: translateX(-2px); }

    .topbar-icon {
        width: 38px; height: 38px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px;
        background: var(--invert-bg); color: var(--invert-text);
    }
    .topbar-icon svg { width: 18px; height: 18px; }

    .topbar-left h1 { font-size: 21px; }
    .topbar-left p { color: var(--muted); font-size: 12px; margin-top: 2px; }

    .theme-toggle {
        position: relative; width: 56px; height: 30px; border-radius: 20px;
        border: 1px solid var(--border); background: var(--surface);
        cursor: pointer; flex-shrink: 0; transition: .25s ease;
    }
    .theme-toggle:hover { border-color: var(--muted); }

    .theme-toggle-knob {
        position: absolute; top: 3px; left: 3px; width: 22px; height: 22px; border-radius: 50%;
        background: var(--invert-bg); color: var(--invert-text);
        display: flex; align-items: center; justify-content: center;
        transition: transform .3s cubic-bezier(.2,.8,.2,1);
    }
    .theme-toggle-knob svg { width: 12px; height: 12px; }
    html[data-theme="light"] .theme-toggle-knob { transform: translateX(26px); }

    .workspace {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        grid-template-rows: auto auto auto;
        align-items: start;
        gap: 16px;
    }

    .create-panel { grid-column: 1; grid-row: 1 / span 2; }
    .preview-panel { grid-column: 2; grid-row: 1; }
    .groups-panel { grid-column: 2; grid-row: 2; }
    .history-panel { grid-column: 1 / span 2; grid-row: 3; }

    .panel {
        position: relative; min-width: 0;
        background: var(--panel);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        box-shadow: 0 24px 60px rgba(0,0,0,.25);
        transition: background .35s ease, border-color .35s ease;
    }

    .panel-head {
        display: flex; align-items: center; gap: 10px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border-soft);
    }

    .panel-head-icon {
        width: 30px; height: 30px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 9px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border-soft);
    }
    .panel-head-icon svg { width: 14px; height: 14px; }

    .panel-head h2 { font-size: 13px; }
    .panel-head p { color: var(--muted-2); font-size: 10px; margin-top: 2px; }

    .create-panel-body { padding: 22px; }

    .form-section { margin-top: 18px; }
    .form-section:first-child { margin-top: 0; }

    .form-label { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
    .form-label-left { display: flex; align-items: center; gap: 7px; }

    .form-label-icon {
        width: 22px; height: 22px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 7px;
        color: var(--muted);
        background: var(--surface);
        border: 1px solid var(--border-soft);
        transition: transform .25s cubic-bezier(.3,.7,.4,1.4), color .2s ease, border-color .2s ease;
    }
    .form-label-icon svg { width: 12px; height: 12px; }

    .form-section:hover .form-label-icon {
        transform: scale(1.12) rotate(-4deg);
        color: var(--text);
        border-color: var(--muted-2);
    }

    .form-label label { color: var(--text); font-size: 12px; font-weight: 650; }
    .form-label span { color: var(--muted-2); font-size: 10px; font-weight: 600; }

    .field { position: relative; }

    .input, .textarea {
        width: 100%; color: var(--text); outline: none;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: var(--surface);
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .input { height: 45px; padding: 0 15px; font-size: 13px; }
    .textarea { min-height: 80px; resize: vertical; padding: 12px 15px; font-size: 13px; }

    .input:hover, .textarea:hover { border-color: var(--muted-2); }
    .input:focus, .textarea:focus { border-color: var(--text); box-shadow: 0 0 0 3px var(--ring); }
    .input::placeholder, .textarea::placeholder { color: var(--muted-2); }

    .photo-box {
        display: flex; align-items: center; gap: 16px; padding: 16px;
        border: 1px solid var(--border-soft); border-radius: 15px; background: var(--surface);
    }

    .upload-avatar { position: relative; width: 68px; height: 68px; flex-shrink: 0; cursor: pointer; margin-top: 4px; }

    .avatar {
        width: 68px; height: 68px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border-radius: 50%;
        background: var(--surface-hover); border: 1px solid var(--border);
        font-size: 22px; font-weight: 750; color: var(--text);
        transition: .25s ease;
    }
    .upload-avatar:hover .avatar { border-color: var(--text); }
    .avatar svg { width: 26px; height: 26px; opacity: .8; }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }

    .upload-plus {
        position: absolute; right: -2px; bottom: -2px; width: 21px; height: 21px;
        display: flex; align-items: center; justify-content: center;
        border: 3px solid var(--bg); border-radius: 50%;
        background: var(--invert-bg); color: var(--invert-text);
        font-size: 13px; font-weight: 900;
    }

    .photo-info strong { display: block; font-size: 12px; }
    .photo-info p { color: var(--muted); font-size: 10px; margin-top: 2px; }

    .upload-button {
        border: 0; padding: 0; margin-top: 5px;
        color: var(--text); background: transparent; cursor: pointer;
        font-size: 10.5px; font-weight: 700; text-decoration: underline; text-underline-offset: 2px;
    }
    .upload-button:hover { color: var(--muted); }

    .username-wrapper { position: relative; }
   .username-prefix {
    position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
    color: var(--muted); font-size: 13px; font-weight: 700; pointer-events: none;
    white-space: nowrap;
}
.username-input { padding-left: 58px; }

    .visibility-title { display: flex; align-items: center; gap: 7px; margin-bottom: 9px; color: var(--text); font-size: 12px; font-weight: 650; }
    .visibility { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }

    .visibility-card {
        position: relative; padding: 12px; cursor: pointer;
        border: 1px solid var(--border-soft); border-radius: 13px; background: var(--surface);
        transition: .2s ease;
    }
    .visibility-card:hover { border-color: var(--muted-2); }
    .visibility-card.active { border-color: var(--text); background: var(--surface-hover); }
    .visibility-card input { display: none; }

    .visibility-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }

    .visibility-icon {
        width: 24px; height: 24px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 7px; background: var(--surface-hover); color: var(--muted);
        transition: transform .25s cubic-bezier(.3,.7,.4,1.4);
    }
    .visibility-card.active .visibility-icon { color: var(--text); transform: scale(1.1); }

    .radio { width: 13px; height: 13px; border: 1px solid var(--muted-2); border-radius: 50%; transition: .2s ease; }
    .visibility-card.active .radio { border: 4px solid var(--text); }

    .visibility-card strong { display: block; font-size: 11px; }
    .visibility-card small { display: block; color: var(--muted); font-size: 9px; line-height: 1.45; margin-top: 2px; }

    .username-field-wrap { max-height: 500px; overflow: hidden; transition: max-height .3s ease, opacity .25s ease, margin-top .3s ease; opacity: 1; }
    .username-field-wrap.collapsed { max-height: 0; opacity: 0; margin-top: 0; }

    .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }

    .button {
        height: 43px; padding: 0 18px;
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 12px; cursor: pointer; font-size: 12px; font-weight: 700;
        transition: .2s ease; border: 1px solid transparent;
    }

    .button-secondary { color: var(--muted); border-color: var(--border); background: var(--surface); }
    .button-secondary:hover { color: var(--text); background: var(--surface-hover); }

    .button-primary { position: relative; overflow: hidden; color: var(--invert-text); background: var(--invert-bg); }
    .button-primary:hover { transform: translateY(-1px); }
    .button-primary:disabled { opacity: .65; cursor: default; transform: none; }

    .btn-spinner {
        width: 13px; height: 13px; border-radius: 50%;
        border: 2px solid rgba(128,128,128,.35); border-top-color: var(--invert-text);
        animation: spin .7s linear infinite; display: none;
    }
    .button-primary.loading .btn-spinner { display: inline-block; }
    .button-primary.loading .btn-icon, .button-primary.loading .btn-label { opacity: .55; }
    @keyframes spin { to { transform: rotate(360deg); } }

    .groups-panel { min-height: 460px; display: flex; flex-direction: column; }
    .groups-panel-body { padding: 20px 20px 22px; flex: 1; display: flex; flex-direction: column; }

    .group-count {
        min-width: 24px; height: 21px;
        display: flex; align-items: center; justify-content: center; padding: 0 7px;
        border-radius: 20px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border-soft);
        font-size: 10px; font-weight: 750; margin-left: auto;
    }

    .group-list {
        display: flex; flex-direction: column; gap: 9px;
        max-height: 330px; overflow-y: auto; padding-right: 3px;
    }
    .group-list::-webkit-scrollbar { width: 4px; }
    .group-list::-webkit-scrollbar-track { background: transparent; }
    .group-list::-webkit-scrollbar-thumb { background: var(--surface-hover); border-radius: 10px; }

    .group-item {
        position: relative; display: flex; align-items: center; gap: 11px; padding: 11px;
        border: 1px solid var(--border-soft); border-radius: 14px; background: var(--surface);
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
        animation: itemIn .5s cubic-bezier(.2,.8,.2,1);
    }
    .group-item:hover { border-color: var(--muted-2); background: var(--surface-hover); }

    @keyframes itemIn {
        from { opacity: 0; transform: translateY(8px) scale(.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .group-image {
        width: 40px; height: 40px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border-radius: 50%;
        color: var(--text); font-size: 13px; font-weight: 750;
        background: var(--surface-hover); border: 1px solid var(--border);
    }
    .group-image img { width: 100%; height: 100%; object-fit: cover; }

    .group-content { min-width: 0; flex: 1; }
    .group-title-row { display: flex; align-items: center; gap: 6px; }
    .group-title { max-width: 160px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-size: 11.5px; font-weight: 700; }
    .status { width: 5px; height: 5px; flex-shrink: 0; border-radius: 50%; background: var(--text); }
    .group-handle { color: var(--muted); font-size: 9.5px; margin-top: 2px; }

    .group-meta { display: flex; align-items: center; gap: 6px; margin-top: 5px; }
    .meta-pill {
        display: inline-flex; align-items: center; gap: 3px; padding: 3px 6px; border-radius: 6px;
        color: var(--muted); background: var(--surface-hover); font-size: 8px; font-weight: 700;
    }

    .group-more {
        width: 26px; height: 26px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border-soft); border-radius: 9px;
        color: var(--muted); background: var(--surface); cursor: pointer; transition: .2s ease;
    }
    .group-more:hover { color: var(--text); background: var(--surface-hover); }

    .group-block { display: flex; flex-direction: column; }

    .group-dropdown {
        position: fixed; z-index: 999;
        min-width: 208px; padding: 6px;
        background: var(--panel); border: 1px solid var(--border);
        border-radius: 13px; box-shadow: 0 18px 40px rgba(0,0,0,.45);
        display: none; flex-direction: column; gap: 2px;
    }
    .group-dropdown.open { display: flex; }

    .group-created {
        display: flex; align-items: center; gap: 4px;
        color: var(--muted-2); font-size: 8.5px; margin-top: 5px;
    }
    .group-created svg { width: 10px; height: 10px; flex-shrink: 0; }
    .group-edited { color: #f2a93b; }

    .dropdown-item {
        display: flex; align-items: center; gap: 9px; padding: 9px 10px; width: 100%;
        border: 0; background: transparent; border-radius: 9px; cursor: pointer;
        color: var(--text); font-size: 11.5px; font-weight: 600; text-align: left;
    }
    .dropdown-item svg { width: 14px; height: 14px; flex-shrink: 0; color: var(--muted); }
    .dropdown-item:hover { background: var(--surface-hover); }
    .dropdown-item.danger { color: #e5484d; }
    .dropdown-item.danger svg { color: #e5484d; }
    .dropdown-divider { height: 1px; margin: 4px 2px; background: var(--border-soft); }

    .empty-state { display: flex; align-items: center; gap: 14px; padding: 14px 2px; }

    .empty-icon {
        width: 40px; height: 40px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px; color: var(--muted);
        background: var(--surface); border: 1px solid var(--border-soft);
    }
    .empty-icon svg { width: 18px; height: 18px; }
    .empty-state h3 { font-size: 12.5px; }
    .empty-state p { color: var(--muted); font-size: 10.5px; margin-top: 2px; }

    /* ============ TOP RIGHT — LIVE PREVIEW CARD ============ */

    .preview-body {
        display: flex; flex-direction: column; gap: 14px;
        padding: 52px 22px 20px;
    }

    .preview-top { display: flex; align-items: center; gap: 14px; }

    .live-tag {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 10px; border-radius: 20px;
        background: var(--surface); border: 1px solid var(--border-soft);
        color: var(--muted); font-size: 9px; font-weight: 750; letter-spacing: .05em;
        flex-shrink: 0;
        position: absolute; top: 16px; right: 20px;
    }
    .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--text); animation: pulse 1.6s ease-in-out infinite; }
    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .3; } }

    .preview-panel { position: relative; }

    .preview-explainer {
        position: absolute; top: 16px; left: 20px; right: 110px;
        display: flex; align-items: center; gap: 7px;
        color: var(--muted); font-size: 10px; font-weight: 700;
    }
    .preview-explainer-icon {
        width: 20px; height: 20px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 6px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border-soft);
    }
    .preview-explainer-icon svg { width: 11px; height: 11px; }
    .preview-explainer span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .preview-avatar-wrap { position: relative; width: 62px; height: 62px; flex-shrink: 0; }

    .preview-ring {
        position: absolute; inset: -6px; border-radius: 50%;
        border: 1px solid var(--border-soft); opacity: 0; pointer-events: none;
    }
    .preview-avatar-wrap.creating .preview-ring { animation: ringExpand 1.1s ease-out; }
    .preview-avatar-wrap.creating .preview-ring.r2 { animation-delay: .15s; }
    .preview-avatar-wrap.creating .preview-ring.r3 { animation-delay: .3s; }
    @keyframes ringExpand {
        0% { transform: scale(.85); opacity: .7; border-color: var(--text); }
        100% { transform: scale(1.9); opacity: 0; border-color: var(--text); }
    }

    .preview-avatar {
        width: 62px; height: 62px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
        background: var(--surface-hover); border: 1px solid var(--border);
        font-size: 21px; font-weight: 750; color: var(--text);
    }
    .preview-avatar svg { width: 24px; height: 24px; opacity: .7; }
    .preview-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .preview-info { min-width: 0; flex: 1; }

    .preview-name-row { display: flex; align-items: baseline; gap: 8px; flex-wrap: wrap; }

    .preview-name {
        font-size: 19px; font-weight: 800; letter-spacing: -.01em;
        max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .preview-name.placeholder { color: var(--muted-2); }
    .preview-handle { color: var(--muted); font-size: 11px; font-weight: 600; }

    .preview-desc {
        color: var(--muted); font-size: 11.5px;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
    }
    .preview-desc.placeholder { color: var(--muted-2); }

    .preview-stats { display: flex; align-items: center; gap: 7px; flex-shrink: 0; flex-wrap: wrap; }

    .preview-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 11px; border-radius: 9px;
        background: var(--surface); border: 1px solid var(--border-soft);
        color: var(--text); font-size: 10px; font-weight: 650; white-space: nowrap;
    }

    .history-panel-body { padding: 6px 18px 18px; }

    .table-filter-bar {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 10px;
        margin-bottom: 10px;
    }
    .filter-field { position: relative; min-width: 0; }
    .filter-field input,
    .filter-field select {
        width: 100%; height: 38px; padding: 0 12px; font-size: 12px; color: var(--text);
        border: 1px solid var(--border); border-radius: 10px; background: var(--surface); outline: none;
        transition: border-color .2s ease;
        appearance: none; -webkit-appearance: none;
    }
    .filter-field select { cursor: pointer; background-image: none; }
    .filter-field input:hover, .filter-field select:hover { border-color: var(--muted-2); }
    .filter-field input:focus, .filter-field select:focus { border-color: var(--text); box-shadow: 0 0 0 3px var(--ring); }
    .filter-field input::placeholder { color: var(--muted-2); }
    .filter-search input { padding-left: 34px; }
    .filter-search svg {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        width: 14px; height: 14px; color: var(--muted); pointer-events: none;
    }
    .filter-field input[type="date"],
    .filter-field select { color-scheme: dark; }
    html[data-theme="light"] .filter-field input[type="date"],
    html[data-theme="light"] .filter-field select { color-scheme: light; }

    .filter-field select option {
        background: var(--bg);
        color: var(--text);
    }

    .filter-toggle-btn {
        display: inline-flex; align-items: center; gap: 8px;
        height: 38px; padding: 0 14px; flex-shrink: 0;
        border-radius: 10px; border: 1px solid var(--border);
        background: var(--surface); color: var(--text);
        font-size: 11.5px; font-weight: 700; cursor: pointer;
        transition: .2s ease;
    }
    .filter-toggle-btn svg { width: 14px; height: 14px; }
    .filter-toggle-btn:hover { background: var(--surface-hover); border-color: var(--muted-2); }
    .filter-toggle-btn.active { background: var(--invert-bg); color: var(--invert-text); border-color: transparent; }

    .filter-extra {
        display: none;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }
    .filter-extra.open { display: grid; }

    @media (max-width: 700px) {
        .table-filter-bar { grid-template-columns: 1fr; }
        .filter-extra { grid-template-columns: 1fr; }
    }

    .history-table-wrap {
        max-height: 420px; overflow-y: auto; overflow-x: auto;
        border: 1px solid var(--border); border-radius: 14px;
    }
    .history-table-wrap::-webkit-scrollbar { width: 4px; height: 4px; }
    .history-table-wrap::-webkit-scrollbar-track { background: transparent; }
    .history-table-wrap::-webkit-scrollbar-thumb { background: var(--surface-hover); border-radius: 10px; }

    .history-table { width: 100%; border-collapse: collapse; min-width: 720px; }

    .history-table thead th {
        position: sticky; top: 0; z-index: 1;
        text-align: left; padding: 11px 14px;
        background: var(--surface-hover);
        color: var(--muted); font-size: 9.5px; font-weight: 750;
        text-transform: uppercase; letter-spacing: .04em;
        border-bottom: 1px solid var(--border);
        border-right: 1px solid var(--border-soft);
        white-space: nowrap;
    }
    .history-table thead th:last-child { border-right: 0; }
    .history-table thead th:first-child { border-top-left-radius: 14px; }
    .history-table thead th:last-child { border-top-right-radius: 14px; }

    .history-table tbody tr {
        border-bottom: 1px solid var(--border-soft);
        transition: background .2s ease;
        animation: itemIn .35s ease;
    }
    .history-table tbody tr:last-child { border-bottom: 0; }
    .history-table tbody tr.data-row:hover { background: var(--surface-hover); }

    .history-table td {
        padding: 11px 14px; font-size: 11px; color: var(--text);
        vertical-align: middle; white-space: nowrap;
        border-right: 1px solid var(--border-soft);
    }
    .history-table td:last-child { border-right: 0; }

    .history-id { color: var(--muted-2); font-weight: 700; font-size: 10px; }

    .history-name-cell { display: flex; align-items: center; gap: 9px; white-space: nowrap; }
    .history-name-icon {
        width: 30px; height: 30px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; color: var(--text); overflow: hidden;
        background: var(--surface-hover); border: 1px solid var(--border-soft);
        font-size: 12px; font-weight: 750;
    }
    .history-name-icon svg { width: 13px; height: 13px; }
    .history-name-icon img { width: 100%; height: 100%; object-fit: cover; }
    .history-name-icon.icon-edit { color: #f2a93b; }
    .history-name-icon.icon-delete { color: #e5484d; }
    .history-name-text { font-weight: 700; max-width: 220px; overflow: hidden; text-overflow: ellipsis; display: block; }
    .history-name-note { display: block; color: var(--muted-2); font-size: 9px; font-weight: 500; margin-top: 1px; max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .history-tag {
        display: inline-flex; padding: 4px 9px; border-radius: 7px;
        color: var(--muted); background: var(--surface-hover); font-size: 8.5px; font-weight: 750;
        white-space: nowrap;
    }
    .history-tag.icon-edit { color: #f2a93b; }
    .history-tag.icon-delete { color: #e5484d; }

    .history-date { color: var(--text); font-weight: 650; }
    .history-time-only { color: var(--muted); }
    .history-date-cell small { display: block; color: var(--muted-2); font-size: 8.5px; font-weight: 600; margin-top: 1px; }

    .btn-detail {
        height: 28px; padding: 0 11px; border-radius: 8px;
        border: 1px solid var(--border); background: var(--surface); color: var(--text);
        font-size: 9.5px; font-weight: 700; cursor: pointer; white-space: nowrap;
        transition: .2s ease;
    }
    .btn-detail:hover { background: var(--surface-hover); border-color: var(--muted-2); }
    .btn-detail.open { background: var(--invert-bg); color: var(--invert-text); border-color: transparent; }

    .detail-row td { padding: 0; border-right: 0; white-space: normal; }
    .detail-row.closed { display: none; }

    .detail-card {
        margin: 0; padding: 18px 20px; background: var(--surface);
        display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
        border-top: 1px dashed var(--border);
        animation: itemIn .3s ease;
    }
    @media (max-width: 700px) {
        .detail-card { grid-template-columns: 1fr; }
    }

    .detail-block h4 {
        font-size: 9.5px; color: var(--muted-2); text-transform: uppercase;
        letter-spacing: .05em; margin-bottom: 10px;
    }
    .detail-row-line { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    .detail-avatar {
        width: 38px; height: 38px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface-hover); border: 1px solid var(--border);
        font-size: 13px; font-weight: 750; color: var(--text);
    }
    .detail-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .detail-name { font-size: 12px; font-weight: 700; }
    .detail-sub { color: var(--muted); font-size: 10.5px; margin-top: 1px; white-space: normal; }
    .detail-line-extra { margin-top: 8px; font-size: 10.5px; color: var(--muted); }
    .detail-empty { font-size: 10.5px; color: var(--muted-2); }

    .toast {
        position: fixed; left: 50%; bottom: 26px; z-index: 100;
        display: flex; align-items: center; gap: 9px; padding: 12px 16px;
        border: 1px solid var(--border); border-radius: 13px;
        background: var(--invert-bg); color: var(--invert-text);
        box-shadow: 0 20px 50px rgba(0,0,0,.35);
        font-size: 11px; font-weight: 650;
        opacity: 0; transform: translate(-50%, 16px); pointer-events: none;
        transition: .3s ease;
    }
    .toast.show { opacity: 1; transform: translate(-50%, 0); }

    .toast-icon {
        width: 17px; height: 17px; display: flex; align-items: center; justify-content: center;
        border-radius: 50%; background: var(--invert-text); color: var(--invert-bg); font-size: 10px;
    }

    @media (max-width: 860px) {
        .page { padding: 16px; }
        .workspace { grid-template-columns: 1fr; }
        .visibility { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column-reverse; }
        .button { width: 100%; }
        .topbar-left h1 { font-size: 18px; }
        .preview-body { flex-wrap: wrap; }
        .preview-stats { width: 100%; justify-content: flex-start; margin-left: 76px; }
        .preview-explainer { right: 90px; }
        .filter-toggle-btn { width: 100%; justify-content: center; }
    }
</style>
</head>
<body>

<div class="page">
<div class="container">

    <header class="topbar">
        <div class="topbar-left">
            <div class="topbar-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <h1 data-i18n="groupCreateTitle">Guruh yaratish</h1>
                <p data-i18n="groupCreateSubtitle">Yangi guruh oching, unga nom, rasm va tavsif qo‘shing, a'zolar uchun ochiq yoki maxsus havola bilan yopiq qilib sozlang va bir necha soniyada muloqotni boshlang.</p>
            </div>
        </div>

        <div class="topbar-right">
            <a class="back-link" href="/home" id="backLink">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M19 12H5M11 18l-6-6 6-6"/>
                </svg>
                <span data-i18n="backToChatovbs">Chatovbsga qaytish</span>
            </a>

            <button type="button" class="theme-toggle" id="themeToggle" aria-label="Rejimni almashtirish">
                <span class="theme-toggle-knob" id="themeKnob">
                    <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>
                    </svg>
                </span>
            </button>
        </div>
    </header>

    <div class="workspace">

        <section class="panel create-panel">
            <div class="create-panel-body">

                <div class="form-section">
                    <div class="form-label">
                        <div class="form-label-left">
                            <span class="form-label-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="5" width="18" height="14" rx="3"/>
                                    <circle cx="12" cy="12" r="3.2"/>
                                    <path d="M8 5l1.2-2h5.6L16 5"/>
                                </svg>
                            </span>
                            <label data-i18n="groupPhotoLabel">Guruh rasmi</label>
                        </div>
                        <span data-i18n="optionalLabel">Ixtiyoriy</span>
                    </div>
                    <div class="photo-box">
                        <label for="groupPhoto" class="upload-avatar">
                            <div class="avatar" id="mainAvatar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                    <path d="M16 19v-1.6a3.4 3.4 0 0 0-3.4-3.4H7.4A3.4 3.4 0 0 0 4 17.4V19"/>
                                    <circle cx="9.5" cy="8.5" r="3"/>
                                    <path d="M20 19v-1.4a3 3 0 0 0-2.2-2.9"/>
                                    <path d="M14.5 5.6a3 3 0 0 1 0 5.7"/>
                                </svg>
                            </div>
                            <div class="upload-plus">+</div>
                        </label>
                        <div class="photo-info">
                            <strong data-i18n="groupPhotoTitle">Guruh rasmini tanlang</strong>
                            <p data-i18n="groupPhotoHint">JPG, PNG yoki WEBP formatida rasm yuklang.</p>
                            <button type="button" class="upload-button" data-i18n="uploadPhotoBtn" onclick="document.getElementById('groupPhoto').click()">Rasm yuklash</button>
                            <input type="file" id="groupPhoto" accept="image/*" hidden>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-label">
                        <div class="form-label-left">
                            <span class="form-label-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M4 7h16M4 12h10M4 17h13"/>
                                </svg>
                            </span>
                            <label for="groupName" data-i18n="groupNameLabel">Guruh nomi</label>
                        </div>
                        <span data-i18n="requiredLabel">Majburiy</span>
                    </div>
                    <div class="field">
                        <input id="groupName" class="input" type="text" maxlength="64" autocomplete="off" placeholder="Masalan: Dasturchilar klubi">
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-label">
                        <div class="form-label-left">
                            <span class="form-label-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </span>
                            <label for="groupDescription" data-i18n="groupDescriptionLabel">Guruh haqida</label>
                        </div>
                        <span id="descriptionCount">0 / 255</span>
                    </div>
                    <div class="field">
                        <textarea id="groupDescription" class="textarea" maxlength="255" placeholder="Guruh nima haqida ekanini qisqacha yozing..."></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <div class="visibility-title">
                        <span class="form-label-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 2 4 5v6c0 5 3.4 8.6 8 11 4.6-2.4 8-6 8-11V5z"/>
                            </svg>
                        </span>
                        <span data-i18n="groupTypeTitle">Guruh turi</span>
                    </div>
                    <div class="visibility">
                        <label class="visibility-card active" data-type="public">
                            <input type="radio" name="visibility" value="public" checked>
                            <div class="visibility-header">
                                <div class="visibility-icon">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18"/>
                                    </svg>
                                </div>
                                <div class="radio"></div>
                            </div>
                            <strong data-i18n="publicGroupTitle">Ochiq guruh</strong>
                            <small data-i18n="publicGroupHint">Hamma guruhni topib, qo‘shilishi mumkin.</small>
                        </label>

                        <label class="visibility-card" data-type="private">
                            <input type="radio" name="visibility" value="private">
                            <div class="visibility-header">
                                <div class="visibility-icon">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="4" y="10" width="16" height="10" rx="2.5"/>
                                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                    </svg>
                                </div>
                                <div class="radio"></div>
                            </div>
                            <strong data-i18n="privateGroupTitle">Yopiq guruh</strong>
                            <small data-i18n="privateGroupHint">Faqat taklif havolasi orqali qo‘shiladi.</small>
                        </label>
                    </div>
                </div>

   <div class="form-section username-field-wrap" id="usernameFieldWrap">
    <div class="form-label">
        <div class="form-label-left">
            <span class="form-label-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M10 13a5 5 0 0 0 7.5.4l2-2a5 5 0 0 0-7-7l-1.2 1.1"/>
                    <path d="M14 11a5 5 0 0 0-7.5-.4l-2 2a5 5 0 0 0 7 7l1.1-1.1"/>
                </svg>
            </span>
            <label for="groupUsername" data-i18n="groupLinkLabel">Havola</label>
        </div>
        <span data-i18n="optionalLabel">Ixtiyoriy</span>
    </div>
    <div class="field username-wrapper">
        <span class="username-prefix">t.me/</span>
        <input id="groupUsername" class="input username-input" type="text" maxlength="32" autocomplete="off" placeholder="dasturchilar_klubi">
    </div>
</div>

                <div class="form-actions">
                    <button type="button" class="button button-secondary" id="cancelButton" data-i18n="cancelBtn">Bekor qilish</button>
                    <button type="button" class="button button-primary" id="createButton">
                        <span class="btn-spinner"></span>
                        <svg class="btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <path d="M12 5v14"/><path d="M5 12h14"/>
                        </svg>
                        <span class="btn-label" data-i18n="createGroupBtn">Guruh yaratish</span>
                    </button>
                </div>

            </div>
        </section>

        <section class="panel groups-panel">
            <div class="panel-head">
                <div class="panel-head-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="18" height="18" rx="5"/>
                        <path d="M8 12h8"/><path d="M12 8v8"/>
                    </svg>
                </div>
                <div><h2 data-i18n="yourGroupsTitle">Guruhlaringiz</h2><p data-i18n="yourGroupsSubtitle">Siz yaratgan barcha guruhlar</p></div>
                <div class="group-count" id="groupCount">0</div>
            </div>

            <div class="groups-panel-body">
                <div id="emptyState" class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="6"/>
                            <path d="M12 8v8"/><path d="M8 12h8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 data-i18n="noGroupsTitle">Hali guruh yo‘q</h3>
                        <p data-i18n="noGroupsText">Birinchi guruhingizni yarating — shu yerda paydo bo‘ladi.</p>
                    </div>
                </div>

                <div class="group-list" id="groupList"></div>
            </div>
        </section>

        <section class="panel preview-panel" id="previewPanel">
            <div class="preview-explainer" id="previewExplainer">
                <span class="preview-explainer-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
                <span id="previewExplainerText" data-i18n="previewGroupText">Jonli ko‘rinish — guruhingiz shunday chiqadi</span>
            </div>

            <div class="live-tag"><span class="live-dot"></span>JONLI</div>

            <div class="preview-body">
                <div class="preview-top">
                    <div class="preview-avatar-wrap" id="previewAvatarWrap">
                        <span class="preview-ring r1"></span>
                        <span class="preview-ring r2"></span>
                        <span class="preview-ring r3"></span>
                        <div class="preview-avatar" id="previewAvatar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M16 19v-1.6a3.4 3.4 0 0 0-3.4-3.4H7.4A3.4 3.4 0 0 0 4 17.4V19"/>
                                <circle cx="9.5" cy="8.5" r="3"/>
                                <path d="M20 19v-1.4a3 3 0 0 0-2.2-2.9"/>
                                <path d="M14.5 5.6a3 3 0 0 1 0 5.7"/>
                            </svg>
                        </div>
                    </div>

                    <div class="preview-info">
                        <div class="preview-name-row">
                            <h3 class="preview-name placeholder" id="previewName" data-i18n="previewGroupName">Guruh nomi</h3>
                            <p class="preview-handle" id="previewHandle">@guruh_username</p>
                        </div>
                        <p class="preview-desc placeholder" id="previewDesc" data-i18n="previewGroupDesc">Guruh tavsifi shu yerda ko‘rinadi.</p>
                    </div>
                </div>

                <div class="preview-stats">
                    <div class="preview-pill" id="previewVisibility" data-i18n="previewVisibilityPublic">Ochiq guruh</div>
                    <div class="preview-pill" id="previewMembers">1 a'zo</div>
                </div>
            </div>
        </section>

        <section class="panel history-panel">
            <div class="panel-head">
                <div class="panel-head-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5l3.5 2"/>
                    </svg>
                </div>
                <div><h2>Guruhlar jadvali</h2><p>Barcha guruhlar va ularning turi — O‘zbekiston vaqti bilan</p></div>
                <div class="group-count" id="historyCount">0</div>
            </div>

            <div class="history-panel-body">

                <div class="table-filter-bar">
                    <div class="filter-field filter-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input type="text" id="tableSearchInput" placeholder="Guruh nomi yoki username bo‘yicha qidirish...">
                    </div>
                    <button type="button" class="filter-toggle-btn" id="filterToggleBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 5h16M7 12h10M10 19h4"/>
                        </svg>
                        Filtr
                    </button>
                </div>

                <div class="filter-extra" id="filterExtra">
                    <div class="filter-field">
                        <input type="date" id="tableDateInput" title="Sana bo‘yicha qidirish">
                    </div>
                    <div class="filter-field">
                        <select id="tableTypeSelect" title="Turi bo‘yicha qidirish">
                            <option value="all">Barcha turlar</option>
                            <option value="public">Ochiq guruh</option>
                            <option value="private">Yopiq guruh</option>
                        </select>
                    </div>
                </div>

                <div id="historyEmptyState" class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3.5 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3>Hali guruh yo‘q</h3>
                        <p>Guruh yaratsangiz, bu yerda jadval ko‘rinishida — nomi, turi va yaratilgan vaqti bilan — paydo bo‘ladi.</p>
                    </div>
                </div>

                <div class="history-table-wrap" id="historyTableWrap" style="display:none">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Guruh</th>
                                <th>Turi</th>
                                <th>Yaratilgan</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody"></tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>

</div>
</div>

<div class="toast" id="toast">
    <div class="toast-icon">✓</div>
    <span id="toastText">Tayyor</span>
</div>

<div class="group-dropdown" id="sharedDropdown">
    <button type="button" class="dropdown-item" data-action="edit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Tahrirlash
    </button>
    <button type="button" class="dropdown-item" data-action="move">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        Chatovbs menyusiga o'tkazish
    </button>
    <div class="dropdown-divider"></div>
    <button type="button" class="dropdown-item danger" data-action="delete">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        Guruhni o'chirish
    </button>
</div>

<script>
    const persistedEntities = @json($entities);
    const entityApiUrl = '{{ url('/chat-entities/group') }}';
    const groupName = document.getElementById('groupName');
    const groupUsername = document.getElementById('groupUsername');
    const groupDescription = document.getElementById('groupDescription');
    const groupPhoto = document.getElementById('groupPhoto');
    const mainAvatar = document.getElementById('mainAvatar');
    const descriptionCount = document.getElementById('descriptionCount');
    const createButton = document.getElementById('createButton');
    const cancelButton = document.getElementById('cancelButton');
    const groupList = document.getElementById('groupList');
    const groupCount = document.getElementById('groupCount');
    const toast = document.getElementById('toast');
    const toastText = document.getElementById('toastText');
    const usernameFieldWrap = document.getElementById('usernameFieldWrap');

    const historyTableWrap = document.getElementById('historyTableWrap');
    const historyTableBody = document.getElementById('historyTableBody');
    const historyCount = document.getElementById('historyCount');
    const tableSearchInput = document.getElementById('tableSearchInput');
    const tableDateInput = document.getElementById('tableDateInput');
    const tableTypeSelect = document.getElementById('tableTypeSelect');
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterExtra = document.getElementById('filterExtra');

    const previewAvatarWrap = document.getElementById('previewAvatarWrap');
    const previewAvatar = document.getElementById('previewAvatar');
    const previewName = document.getElementById('previewName');
    const previewHandle = document.getElementById('previewHandle');
    const previewDesc = document.getElementById('previewDesc');
    const previewVisibility = document.getElementById('previewVisibility');
    const previewMembers = document.getElementById('previewMembers');

    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    const sunPath = '<path d="M12 3v2M12 19v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M3 12h2M19 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/><circle cx="12" cy="12" r="4"/>';
    const moonPath = '<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>';

    const defaultAvatarSVG = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <path d="M16 19v-1.6a3.4 3.4 0 0 0-3.4-3.4H7.4A3.4 3.4 0 0 0 4 17.4V19"/>
            <circle cx="9.5" cy="8.5" r="3"/>
            <path d="M20 19v-1.4a3 3 0 0 0-2.2-2.9"/>
            <path d="M14.5 5.6a3 3 0 0 1 0 5.7"/>
        </svg>`;

    let selectedImage = '';
    let editingGroupName = null;
    let editingGroupMeta = null;
    let editingGroupClientId = null;
    let groupSeq = 0;
    const groupsTableStore = {};
    let openDetailId = null;

    const icoClock = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>';
    const icoEdit = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>';

    themeToggle.addEventListener('click', function () {
        const html = document.documentElement;
        const isDark = html.getAttribute('data-theme') === 'dark';
        html.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeIcon.innerHTML = isDark ? sunPath : moonPath;
    });

    filterToggleBtn.addEventListener('click', function () {
        filterExtra.classList.toggle('open');
        filterToggleBtn.classList.toggle('active');
    });

    function slugify(value) {
        return value.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_|_$/g, '');
    }

    function updatePreview() {
        const name = groupName.value.trim();
        const username = groupUsername.value.trim();
        const description = groupDescription.value.trim();

        if (name) {
            previewName.textContent = name;
            previewName.classList.remove('placeholder');
        } else {
            previewName.textContent = 'Guruh nomi';
            previewName.classList.add('placeholder');
        }

        const isPrivate = document.querySelector('input[name="visibility"]:checked').value === 'private';
        previewHandle.textContent = isPrivate ? '' : ('t.me/' + (username || (name ? slugify(name) : 'guruh_username')));
        previewHandle.style.display = isPrivate ? 'none' : '';

        if (description) {
            previewDesc.textContent = description;
            previewDesc.classList.remove('placeholder');
        } else {
            previewDesc.textContent = 'Guruh tavsifi shu yerda ko‘rinadi.';
            previewDesc.classList.add('placeholder');
        }

        if (selectedImage) {
            previewAvatar.innerHTML = '<img src="' + selectedImage + '" alt="Guruh rasmi">';
        } else if (name) {
            previewAvatar.textContent = name.charAt(0).toUpperCase();
        } else {
            previewAvatar.innerHTML = defaultAvatarSVG;
        }
    }

    groupName.addEventListener('input', updatePreview);
    groupUsername.addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        updatePreview();
    });
    groupDescription.addEventListener('input', function () {
        descriptionCount.textContent = this.value.length + ' / 255';
        updatePreview();
    });

    groupPhoto.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showToast('Faqat rasm faylini tanlang.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            selectedImage = event.target.result;
            mainAvatar.innerHTML = '<img src="' + selectedImage + '" alt="Guruh rasmi">';
            updatePreview();
        };
        reader.readAsDataURL(file);
    });

    const visibilityCards = document.querySelectorAll('.visibility-card');
    visibilityCards.forEach(function (card) {
        card.addEventListener('click', function () {
            visibilityCards.forEach(function (item) { item.classList.remove('active'); });
            this.classList.add('active');

            const type = this.dataset.type;
            previewVisibility.textContent = type === 'private' ? 'Yopiq guruh' : 'Ochiq guruh';

            /* Ochiq guruhlarda username maydoni ko'rsatiladi, yopiqda yashiriladi (Telegramdagidek) */
            usernameFieldWrap.classList.toggle('collapsed', type === 'private');

            updatePreview();
        });
    });

    let toastTimer;
    function showToast(message) {
        toastText.textContent = message;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toast.classList.remove('show'); }, 2600);
    }

    function escapeHTML(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }

    function entityClientId(entity) {
        return 'gr' + entity.id;
    }

    function persistGroup(data, method, id) {
        return fetch(id ? entityApiUrl + '/' + id : entityApiUrl, {
            method: method || 'POST',
            headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: method === 'DELETE' ? null : JSON.stringify(data)
        }).then(function (response) {
            if (!response.ok) throw new Error('Saqlashda xatolik');
            return response.json();
        });
    }

    function renderPersistedGroup(entity, prepend) {
        const id = entityClientId(entity);
        const avatarHTML = entity.avatar ? '<img src="' + escapeHTML(entity.avatar) + '" alt="Guruh">' : escapeHTML(entity.name.charAt(0).toUpperCase());
        const block = document.createElement('div');
        block.className = 'group-block';
        block.dataset.id = id;
        block.dataset.backendId = entity.id;
        block.dataset.created = entity.created_at;
        block.innerHTML = `
            <div class="group-item"><div class="group-image">${avatarHTML}</div><div class="group-content">
                <div class="group-title-row"><h3 class="group-title">${escapeHTML(entity.name)}</h3><div class="status"></div></div>
                <p class="group-handle">${entity.visibility === 'private' ? 'Yopiq guruh' : 't.me/' + escapeHTML(entity.username || slugify(entity.name))}</p>
                <div class="group-meta"><div class="meta-pill">${entity.visibility === 'private' ? 'Yopiq' : 'Ochiq'}</div><div class="meta-pill">1 a'zo</div></div>
                <p class="group-created">${icoClock} Yaratilgan: ${formatTashkentTime(new Date(entity.created_at))} (UZ vaqti)</p>
            </div><button type="button" class="group-more" data-action="toggle-menu">⋮</button></div>`;
        if (prepend) groupList.prepend(block);
        else groupList.appendChild(block);
        addGroupTableRow(id, {name: entity.name, username: entity.username || slugify(entity.name), bio: entity.description || '', type: entity.visibility, createdAtISO: entity.created_at, avatar: avatarHTML, avatarImage: entity.avatar || null, backendId: entity.id});
    }

    persistedEntities.slice().reverse().forEach(function (entity) { renderPersistedGroup(entity, false); });
    if (persistedEntities.length) {
        const oldEmpty = document.getElementById('emptyState');
        if (oldEmpty) oldEmpty.remove();
        groupCount.textContent = persistedEntities.length;
    }

    createButton.addEventListener('click', function () {
        const name = groupName.value.trim();
        const username = groupUsername.value.trim();
        const description = groupDescription.value.trim();
        const selectedVisibility = document.querySelector('input[name="visibility"]:checked');
        const type = selectedVisibility ? selectedVisibility.value : 'public';

        if (!name) {
            groupName.focus();
            showToast('Avval guruh nomini kiriting.');
            return;
        }

        createButton.disabled = true;
        createButton.classList.add('loading');
        previewAvatarWrap.classList.remove('creating');
        void previewAvatarWrap.offsetWidth;
        previewAvatarWrap.classList.add('creating');

        const isEditing = !!(editingGroupMeta && editingGroupMeta.backendId);
        const oldClientId = editingGroupClientId;
        const oldGroupName = editingGroupName;
        const payload = {name: name, username: username || slugify(name), description: description, visibility: type, avatar: selectedImage || null};
        const minDelay = new Promise(function (resolve) { setTimeout(resolve, 400); });

        Promise.all([
            persistGroup(payload, isEditing ? 'PATCH' : 'POST', isEditing ? editingGroupMeta.backendId : null),
            minDelay
        ]).then(function (results) {
            const entity = results[0].entity;
            createButton.disabled = false;
            createButton.classList.remove('loading');

            if (isEditing) {
                const oldBlock = document.querySelector('.group-block[data-id="' + oldClientId + '"]');
                if (oldBlock) oldBlock.remove();
                removeGroupTableRow(oldClientId);
            } else if (document.getElementById('emptyState')) {
                document.getElementById('emptyState').remove();
            }

            renderPersistedGroup(entity, true);
            groupCount.textContent = groupList.querySelectorAll('.group-item').length;

            if (oldGroupName) {
                editingGroupName = null;
                editingGroupClientId = null;
                editingGroupMeta = null;
                createButton.querySelector('.btn-label').textContent = 'Guruh yaratish';
                showToast('O\'zgarishlar saqlandi!');
            } else {
                showToast('Guruh muvaffaqiyatli yaratildi!');
            }

            resetForm();
        }).catch(function () {
            createButton.disabled = false;
            createButton.classList.remove('loading');
            showToast('Guruh bazaga saqlanmadi. Qayta urinib ko\'ring.');
        });
    });

    function buildHistoryEmptyState() {
        const div = document.createElement('div');
        div.className = 'empty-state';
        div.id = 'historyEmptyState';
        div.innerHTML = `
            <div class="empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3.5 2"/>
                </svg>
            </div>
            <div>
                <h3>Guruh topilmadi</h3>
                <p>Qidiruv shartlariga mos guruh yo‘q, yoki hali guruh yaratilmagan.</p>
            </div>`;
        return div;
    }

    function addGroupTableRow(id, data) {
        groupsTableStore[id] = data;
        renderGroupsTable();
    }

    function removeGroupTableRow(id) {
        delete groupsTableStore[id];
        if (openDetailId === id) openDetailId = null;
        renderGroupsTable();
    }

    function buildDetailCard(r) {
        const parts = formatTashkentParts(new Date(r.createdAtISO));
        const handlePart = r.type === 'private' ? 'Taklif havolasi orqali' : 't.me/' + escapeHTML(r.username);

        return '' +
        '<div class="detail-card">' +
            '<div class="detail-block">' +
                '<h4>Guruh ma\'lumotlari</h4>' +
                '<div class="detail-row-line">' +
                    '<div class="detail-avatar">' + r.avatar + '</div>' +
                    '<div>' +
                        '<div class="detail-name">' + escapeHTML(r.name) + '</div>' +
                        '<div class="detail-sub">' + handlePart + '</div>' +
                    '</div>' +
                '</div>' +
                '<p class="detail-sub">' + (r.bio ? escapeHTML(r.bio) : 'Tavsif kiritilmagan.') + '</p>' +
                '<p class="detail-line-extra">Turi: ' + (r.type === 'private' ? 'Yopiq guruh' : 'Ochiq guruh') + '</p>' +
                '<p class="detail-line-extra">Yaratilgan: ' + parts.date + ' ' + parts.time + ' (UZ vaqti)</p>' +
            '</div>' +
            '<div class="detail-block">' +
                '<h4>Qo\'shimcha</h4>' +
                '<p class="detail-line-extra">A\'zolar soni: 1 a\'zo (siz)</p>' +
                '<p class="detail-line-extra">Guruh ID: ' + escapeHTML(r.id || '') + '</p>' +
            '</div>' +
        '</div>';
    }

    function renderGroupsTable() {
        const term = tableSearchInput.value.trim().toLowerCase();
        const dateVal = tableDateInput.value;
        const typeVal = tableTypeSelect.value;

        let rows = Object.keys(groupsTableStore).map(function (id) {
            return Object.assign({ id: id }, groupsTableStore[id]);
        });

        rows = rows.filter(function (r) {
            if (term) {
                const hay = (r.name + ' ' + r.username + ' ' + (r.bio || '')).toLowerCase();
                if (hay.indexOf(term) === -1) return false;
            }
            if (typeVal !== 'all' && r.type !== typeVal) return false;
            if (dateVal) {
                const d = new Date(r.createdAtISO);
                const tashkentDate = new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Tashkent' }).format(d);
                if (tashkentDate !== dateVal) return false;
            }
            return true;
        });

        rows.sort(function (a, b) { return new Date(b.createdAtISO) - new Date(a.createdAtISO); });

        historyCount.textContent = Object.keys(groupsTableStore).length;

        if (rows.length === 0) {
            historyTableWrap.style.display = 'none';
            if (!document.getElementById('historyEmptyState')) {
                document.querySelector('.history-panel-body').insertBefore(buildHistoryEmptyState(), historyTableWrap);
            }
            return;
        }

        const existingEmpty = document.getElementById('historyEmptyState');
        if (existingEmpty) existingEmpty.remove();
        historyTableWrap.style.display = 'block';

        historyTableBody.innerHTML = rows.map(function (r, i) {
            const parts = formatTashkentParts(new Date(r.createdAtISO));
            const typeLabel = r.type === 'private' ? 'Yopiq' : 'Ochiq';
            const typeClass = r.type === 'private' ? 'icon-edit' : '';
            const bioPart = r.bio ? ' · ' + escapeHTML(r.bio) : '';
            const handlePart = r.type === 'private' ? 'Taklif havolasi orqali' : 't.me/' + escapeHTML(r.username);
            const isOpen = openDetailId === r.id;

            return '' +
                '<tr class="data-row">' +
                    '<td class="history-id">' + (i + 1) + '</td>' +
                    '<td>' +
                        '<div class="history-name-cell">' +
                            '<div class="history-name-icon">' + r.avatar + '</div>' +
                            '<div>' +
                                '<span class="history-name-text">' + escapeHTML(r.name) + '</span>' +
                                '<span class="history-name-note">' + handlePart + bioPart + '</span>' +
                            '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td><span class="history-tag ' + typeClass + '">' + typeLabel + '</span></td>' +
                    '<td class="history-date-cell">' +
                        '<span class="history-date">' + parts.date + '</span>' +
                        '<small>' + parts.time + ' (UZ)</small>' +
                    '</td>' +
                    '<td><button type="button" class="btn-detail' + (isOpen ? ' open' : '') + '" data-detail-toggle="' + r.id + '">' + (isOpen ? 'Yopish' : 'Batafsil ko\'rish') + '</button></td>' +
                '</tr>' +
                '<tr class="detail-row' + (isOpen ? '' : ' closed') + '" id="detailRow-' + r.id + '">' +
                    '<td colspan="5">' + buildDetailCard(r) + '</td>' +
                '</tr>';
        }).join('');
    }

    historyTableBody.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-detail-toggle]');
        if (!btn) return;
        const id = btn.dataset.detailToggle;
        openDetailId = (openDetailId === id) ? null : id;
        renderGroupsTable();
    });

    tableSearchInput.addEventListener('input', renderGroupsTable);
    tableDateInput.addEventListener('change', renderGroupsTable);
    tableTypeSelect.addEventListener('change', renderGroupsTable);

    function formatTashkentTime(date) {
        const parts = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Tashkent',
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: false
        }).formatToParts(date);
        const get = function (t) { return parts.find(function (p) { return p.type === t; }).value; };
        return get('day') + '.' + get('month') + '.' + get('year') + ' ' + get('hour') + ':' + get('minute');
    }

    function formatTashkentParts(date) {
        const parts = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Tashkent',
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
        }).formatToParts(date);
        const get = function (t) { return parts.find(function (p) { return p.type === t; }).value; };
        return {
            date: get('day') + '.' + get('month') + '.' + get('year'),
            time: get('hour') + ':' + get('minute') + ':' + get('second')
        };
    }

    const sharedDropdown = document.getElementById('sharedDropdown');
    let activeDropdownId = null;

    function positionDropdown(button) {
        const rect = button.getBoundingClientRect();
        const menuWidth = sharedDropdown.offsetWidth || 208;
        let left = rect.right - menuWidth;
        let top = rect.bottom + 6;

        if (left < 8) left = 8;
        if (left + menuWidth > window.innerWidth - 8) left = window.innerWidth - menuWidth - 8;
        if (top + sharedDropdown.offsetHeight > window.innerHeight - 8) top = rect.top - sharedDropdown.offsetHeight - 6;

        sharedDropdown.style.left = left + 'px';
        sharedDropdown.style.top = top + 'px';
    }

    function closeDropdown() {
        sharedDropdown.classList.remove('open');
        activeDropdownId = null;
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#sharedDropdown') && !e.target.closest('.group-more')) {
            closeDropdown();
        }
    });
    window.addEventListener('scroll', closeDropdown, true);
    window.addEventListener('resize', closeDropdown);

    groupList.addEventListener('click', function (e) {
        const toggleBtn = e.target.closest('[data-action="toggle-menu"]');
        if (!toggleBtn) return;
        const block = e.target.closest('.group-block');
        const id = block.dataset.id;

        if (activeDropdownId === id && sharedDropdown.classList.contains('open')) {
            closeDropdown();
            return;
        }

        activeDropdownId = id;
        sharedDropdown.classList.add('open');
        positionDropdown(toggleBtn);
    });

    sharedDropdown.addEventListener('click', function (e) {
        const actionBtn = e.target.closest('[data-action]');
        if (!actionBtn || !activeDropdownId) return;
        const id = activeDropdownId;
        const action = actionBtn.dataset.action;
        closeDropdown();

        if (action === 'delete') deleteGroupBlock(id);
        else if (action === 'edit') editGroupBlock(id);
        else if (action === 'move') moveToChatovbs(id);
    });

    function buildEmptyState() {
        const div = document.createElement('div');
        div.className = 'empty-state';
        div.id = 'emptyState';
        div.innerHTML = `
            <div class="empty-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="6"/>
                    <path d="M12 8v8"/><path d="M8 12h8"/>
                </svg>
            </div>
            <div>
                <h3>Hali guruh yo‘q</h3>
                <p>Birinchi guruhingizni yarating — shu yerda paydo bo‘ladi.</p>
            </div>`;
        return div;
    }

    function deleteGroupBlock(id, logHistory) {
        if (logHistory === undefined) logHistory = true;
        const block = document.querySelector('.group-block[data-id="' + id + '"]');
        const stored = groupsTableStore[id];
        const backendId = block ? block.dataset.backendId : (stored && stored.backendId);

        if (!backendId) {
            showToast('Guruh bazadagi ID topilmadi.');
            return;
        }

        persistGroup({}, 'DELETE', backendId).then(function () {
            if (block) block.remove();
            removeGroupTableRow(id);
            const currentCount = groupList.querySelectorAll('.group-item').length;
            groupCount.textContent = currentCount;
            if (currentCount === 0 && !document.getElementById('emptyState')) groupList.parentElement.insertBefore(buildEmptyState(), groupList);
            if (logHistory) showToast("Guruh o'chirildi.");
        }).catch(function () { showToast('Guruh bazadan o‘chirilmadi.'); });
    }

    function editGroupBlock(id) {
        const block = document.querySelector('.group-block[data-id="' + id + '"]');
        if (!block) return;

        const title = block.querySelector('.group-title').textContent;
        const isPrivate = block.querySelector('.meta-pill').textContent.trim() === 'Yopiq';
        const stored = groupsTableStore[id] || {};
        const handle = stored.username || '';
        const existingBio = stored.bio || '';

        groupName.value = title;
        groupUsername.value = handle;
        groupDescription.value = existingBio;
        selectedImage = stored.avatarImage || '';
        mainAvatar.innerHTML = selectedImage
            ? '<img src="' + escapeHTML(selectedImage) + '" alt="Guruh rasmi">'
            : defaultAvatarSVG;
        descriptionCount.textContent = existingBio.length + ' / 255';
        document.querySelector('.visibility-card[data-type="' + (isPrivate ? 'private' : 'public') + '"]').click();
        updatePreview();
        groupName.focus();

        editingGroupName = title;
        editingGroupClientId = id;
        editingGroupMeta = {
            createdAt: block.dataset.created || new Date().toISOString(),
            backendId: block.dataset.backendId || (groupsTableStore[id] && groupsTableStore[id].backendId)
        };
        block.remove();
        removeGroupTableRow(id);
        groupCount.textContent = groupList.querySelectorAll('.group-item').length;
        createButton.querySelector('.btn-label').textContent = 'O\'zgarishlarni saqlash';
        showToast('Ma\'lumotlar shaklga yuklandi — yangilab, "Guruh yaratish" tugmasini bosing.');
    }

    function moveToChatovbs(id) {
        const block = document.querySelector('.group-block[data-id="' + id + '"]');
        const backendId = block && block.dataset.backendId;
        if (!backendId) return showToast('Guruh bazadagi ID topilmadi.');
        fetch(entityApiUrl + '/' + backendId + '/move-home', {
            method: 'POST',
            headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(function (response) {
            if (!response.ok) throw new Error('move failed');
            showToast("Guruh Chatovbs menyusiga o'tkazildi.");
        }).catch(function () { showToast('Guruh menyuga o‘tkazilmadi.'); });
    }

    function resetForm() {
        groupName.value = '';
        groupUsername.value = '';
        groupDescription.value = '';
        groupPhoto.value = '';
        selectedImage = '';
        descriptionCount.textContent = '0 / 255';
        mainAvatar.innerHTML = defaultAvatarSVG;
        document.querySelector('.visibility-card[data-type="public"]').click();
        updatePreview();
    }

    cancelButton.addEventListener('click', function () {
        editingGroupName = null;
        editingGroupClientId = null;
        editingGroupMeta = null;
        createButton.querySelector('.btn-label').textContent = 'Guruh yaratish';
        resetForm();
        showToast('Maydonlar tozalandi.');
    });

    updatePreview();
</script>

<script>
(function () {
    var dict = {
        uz: {
            groupCreateTitle: 'Guruh yaratish', groupCreateSubtitle: 'Yangi guruh oching, unga nom, rasm va tavsif qo‘shing, a\'zolar uchun ochiq yoki maxsus havola bilan yopiq qilib sozlang va bir necha soniyada muloqotni boshlang.', backToChatovbs: 'Chatovbsga qaytish', optionalLabel: 'Ixtiyoriy', requiredLabel: 'Majburiy', groupPhotoLabel: 'Guruh rasmi', groupPhotoTitle: 'Guruh rasmini tanlang', groupPhotoHint: 'JPG, PNG yoki WEBP formatida rasm yuklang.', uploadPhotoBtn: 'Rasm yuklash', groupNameLabel: 'Guruh nomi', groupDescriptionLabel: 'Guruh haqida', groupTypeTitle: 'Guruh turi', publicGroupTitle: 'Ochiq guruh', publicGroupHint: 'Hamma guruhni topib, qo‘shilishi mumkin.', privateGroupTitle: 'Yopiq guruh', privateGroupHint: 'Faqat taklif havolasi orqali qo‘shiladi.', groupLinkLabel: 'Havola', cancelBtn: 'Bekor qilish', createGroupBtn: 'Guruh yaratish', yourGroupsTitle: 'Guruhlaringiz', yourGroupsSubtitle: 'Siz yaratgan barcha guruhlar', noGroupsTitle: 'Hali guruh yo‘q', noGroupsText: 'Birinchi guruhingizni yarating — shu yerda paydo bo‘ladi.', previewGroupText: 'Jonli ko‘rinish — guruhingiz shunday chiqadi', previewGroupName: 'Guruh nomi', previewGroupDesc: 'Guruh tavsifi shu yerda ko‘rinadi.', previewVisibilityPublic: 'Ochiq guruh'
        },
        ru: {
            groupCreateTitle: 'Создать группу', groupCreateSubtitle: 'Создайте новую группу, добавьте название, фото и описание, настройте открытый или закрытый доступ по ссылке и начните общение за несколько минут.', backToChatovbs: 'Вернуться в Chatovbs', optionalLabel: 'Необязательно', requiredLabel: 'Обязательно', groupPhotoLabel: 'Фото группы', groupPhotoTitle: 'Выберите фото группы', groupPhotoHint: 'Загрузите изображение в JPG, PNG или WEBP.', uploadPhotoBtn: 'Загрузить фото', groupNameLabel: 'Название группы', groupDescriptionLabel: 'О группе', groupTypeTitle: 'Тип группы', publicGroupTitle: 'Открытая группа', publicGroupHint: 'Все могут найти и присоединиться.', privateGroupTitle: 'Закрытая группа', privateGroupHint: 'Присоединиться можно только по приглашению.', groupLinkLabel: 'Ссылка', cancelBtn: 'Отмена', createGroupBtn: 'Создать группу', yourGroupsTitle: 'Ваши группы', yourGroupsSubtitle: 'Все группы, которые вы создали', noGroupsTitle: 'Пока нет групп', noGroupsText: 'Создайте первую группу — она появится здесь.', previewGroupText: 'Предпросмотр — так будет выглядеть ваша группа', previewGroupName: 'Название группы', previewGroupDesc: 'Описание группы будет отображаться здесь.', previewVisibilityPublic: 'Открытая группа'
        },
        en: {
            groupCreateTitle: 'Create group', groupCreateSubtitle: 'Create a new group, add a name, photo, and description, choose whether it is open or invite-only, and start conversations in minutes.', backToChatovbs: 'Back to Chatovbs', optionalLabel: 'Optional', requiredLabel: 'Required', groupPhotoLabel: 'Group photo', groupPhotoTitle: 'Choose group photo', groupPhotoHint: 'Upload a JPG, PNG, or WEBP image.', uploadPhotoBtn: 'Upload photo', groupNameLabel: 'Group name', groupDescriptionLabel: 'About the group', groupTypeTitle: 'Group type', publicGroupTitle: 'Public group', publicGroupHint: 'Anyone can find and join.', privateGroupTitle: 'Private group', privateGroupHint: 'Only invited users can join via link.', groupLinkLabel: 'Link', cancelBtn: 'Cancel', createGroupBtn: 'Create group', yourGroupsTitle: 'Your groups', yourGroupsSubtitle: 'All groups you created', noGroupsTitle: 'No groups yet', noGroupsText: 'Create your first group — it will appear here.', previewGroupText: 'Live preview — this is how your group will look', previewGroupName: 'Group name', previewGroupDesc: 'Group description appears here.', previewVisibilityPublic: 'Public group'
        },
        ko: {
            groupCreateTitle: '그룹 만들기', groupCreateSubtitle: '새 그룹을 만들고 이름, 사진, 소개를 추가하고 공개 여부와 초대 링크를 설정한 뒤 몇 분 안에 대화를 시작하세요.', backToChatovbs: 'Chatovbs로 돌아가기', optionalLabel: '선택', requiredLabel: '필수', groupPhotoLabel: '그룹 사진', groupPhotoTitle: '그룹 사진 선택', groupPhotoHint: 'JPG, PNG 또는 WEBP 이미지를 업로드하세요.', uploadPhotoBtn: '사진 업로드', groupNameLabel: '그룹 이름', groupDescriptionLabel: '그룹 소개', groupTypeTitle: '그룹 유형', publicGroupTitle: '공개 그룹', publicGroupHint: '모든 사용자가 찾고 참여할 수 있습니다.', privateGroupTitle: '비공개 그룹', privateGroupHint: '초대 링크를 통해서만 가입할 수 있습니다.', groupLinkLabel: '링크', cancelBtn: '취소', createGroupBtn: '그룹 만들기', yourGroupsTitle: '내 그룹', yourGroupsSubtitle: '내가 만든 모든 그룹', noGroupsTitle: '아직 그룹이 없습니다', noGroupsText: '첫 번째 그룹을 만들면 여기에 표시됩니다.', previewGroupText: '실시간 미리보기 — 그룹이 이렇게 보입니다', previewGroupName: '그룹 이름', previewGroupDesc: '그룹 설명이 여기에 표시됩니다.', previewVisibilityPublic: '공개 그룹'
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
</body>
</html>