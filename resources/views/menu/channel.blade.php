<!DOCTYPE html>
<html lang="uz" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kanal yaratish</title>
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

    button, input, textarea, select { font: inherit; }
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
    .channels-panel { grid-column: 2; grid-row: 2; }
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
    }
    .username-input { padding-left: 52px; }

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

    .channels-panel { height: 460px; max-height: 460px; display: flex; flex-direction: column; }
    .channels-panel-body { padding: 20px 20px 22px; flex: 1; min-height: 0; display: flex; flex-direction: column; overflow-y: auto; overflow-x: hidden; }
    .channels-panel-body::-webkit-scrollbar { width: 6px; }
    .channels-panel-body::-webkit-scrollbar-track { background: transparent; }
    .channels-panel-body::-webkit-scrollbar-thumb { background: var(--surface-hover); border-radius: 10px; }

    .channel-count {
        min-width: 24px; height: 21px;
        display: flex; align-items: center; justify-content: center; padding: 0 7px;
        border-radius: 20px; color: var(--text);
        background: var(--surface); border: 1px solid var(--border-soft);
        font-size: 10px; font-weight: 750; margin-left: auto;
    }

    .channel-list {
        display: flex; flex-direction: column; gap: 9px;
        max-height: none; overflow: visible; padding-right: 3px;
    }

    /* channels beyond the first 4 stay hidden until "show all" is pressed,
       so the layout never grows unbounded */
    .channel-block.hidden-channel { display: none; }

    .channels-toggle-btn {
        display: none;
        margin-top: 12px; width: 100%; height: 36px;
        border-radius: 11px; border: 1px solid var(--border);
        background: var(--surface); color: var(--text);
        font-size: 11px; font-weight: 700; cursor: pointer;
        transition: .2s ease;
    }
    .channels-toggle-btn:hover { background: var(--surface-hover); border-color: var(--muted-2); }

    .channel-item {
        position: relative; display: flex; align-items: center; gap: 11px; padding: 11px;
        border: 1px solid var(--border-soft); border-radius: 14px; background: var(--surface);
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
        animation: channelIn .5s cubic-bezier(.2,.8,.2,1);
    }
    .channel-item:hover { border-color: var(--muted-2); background: var(--surface-hover); }

    @keyframes channelIn {
        from { opacity: 0; transform: translateY(8px) scale(.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .channel-image {
        width: 40px; height: 40px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border-radius: 50%;
        color: var(--text); font-size: 13px; font-weight: 750;
        background: var(--surface-hover); border: 1px solid var(--border);
    }
    .channel-image img { width: 100%; height: 100%; object-fit: cover; }

    .channel-content { min-width: 0; flex: 1; }
    .channel-title-row { display: flex; align-items: center; gap: 6px; }
    .channel-title { max-width: 160px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-size: 11.5px; font-weight: 700; }
    .status { width: 5px; height: 5px; flex-shrink: 0; border-radius: 50%; background: var(--text); }
    .channel-handle { color: var(--muted); font-size: 9.5px; margin-top: 2px; }

    .channel-meta { display: flex; align-items: center; gap: 6px; margin-top: 5px; }
    .meta-pill {
        display: inline-flex; align-items: center; gap: 3px; padding: 3px 6px; border-radius: 6px;
        color: var(--muted); background: var(--surface-hover); font-size: 8px; font-weight: 700;
    }

    .channel-more {
        width: 26px; height: 26px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border-soft); border-radius: 9px;
        color: var(--muted); background: var(--surface); cursor: pointer; transition: .2s ease;
    }
    .channel-more:hover { color: var(--text); background: var(--surface-hover); }

    .channel-block { display: flex; flex-direction: column; }

    .channel-dropdown {
        position: fixed; z-index: 999;
        min-width: 208px; padding: 6px;
        background: var(--panel); border: 1px solid var(--border);
        border-radius: 13px; box-shadow: 0 18px 40px rgba(0,0,0,.45);
        display: none; flex-direction: column; gap: 2px;
    }
    .channel-dropdown.open { display: flex; }

    .channel-created {
        display: flex; align-items: center; gap: 4px;
        color: var(--muted-2); font-size: 8.5px; margin-top: 5px;
    }
    .channel-created svg { width: 10px; height: 10px; flex-shrink: 0; }
    .channel-edited { color: #f2a93b; }

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

    .chat-branch { display: flex; gap: 10px; padding-left: 20px; margin-top: 2px; }

    .chat-connector { width: 20px; flex-shrink: 0; position: relative; }
    .chat-connector::before {
        content: ""; position: absolute; left: 9px; top: -11px; bottom: 50%;
        width: 1px; background: var(--border);
    }
    .chat-connector::after {
        content: ""; position: absolute; left: 9px; top: 50%; width: 11px; height: 1px;
        background: var(--border);
    }

    .chat-card {
        flex: 1; min-width: 0; padding: 18px; margin-bottom: 9px;
        border: 1px dashed var(--border); border-radius: 14px; background: var(--surface);
        animation: channelIn .35s ease;
    }

    .chat-fields { position: relative; }

    .chat-form-row { display: flex; align-items: center; gap: 12px; margin-bottom: 10px; }

    .chat-avatar-upload { display: flex; flex-direction: column; align-items: center; gap: 5px; flex-shrink: 0; }

    .chat-mini-avatar {
        position: relative;
        width: 64px; height: 64px; flex-shrink: 0; cursor: pointer;
    }
    .chat-mini-avatar-inner {
        width: 100%; height: 100%; border-radius: 50%; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface-hover); border: 1px solid var(--border); color: var(--muted);
        font-size: 19px; font-weight: 750;
        transition: border-color .2s ease;
    }
    .chat-mini-avatar:hover .chat-mini-avatar-inner { border-color: var(--text); }
    .chat-mini-avatar-inner svg { width: 22px; height: 22px; }
    .chat-mini-avatar-inner img { width: 100%; height: 100%; object-fit: cover; }

    .chat-mini-plus {
        position: absolute; right: -2px; bottom: -2px; width: 21px; height: 21px;
        display: flex; align-items: center; justify-content: center;
        border: 3px solid var(--bg); border-radius: 50%;
        background: var(--invert-bg); color: var(--invert-text);
        font-size: 13px; font-weight: 900; line-height: 1; pointer-events: none;
    }

    .chat-mini-upload-btn {
        border: 0; padding: 0; margin: 0; background: transparent; cursor: pointer;
        color: var(--text); font-size: 9px; font-weight: 700;
        text-decoration: underline; text-underline-offset: 2px; white-space: nowrap;
    }
    .chat-mini-upload-btn:hover { color: var(--muted); }

    .chat-field { flex: 1; min-width: 0; }
    .chat-field-username { position: relative; }
    .chat-field-username .chat-username-prefix {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: var(--muted); font-size: 12px; font-weight: 700; pointer-events: none;
    }

    .chat-mini-input {
        width: 100%; height: 42px; padding: 0 12px; font-size: 12.5px; color: var(--text);
        border: 1px solid var(--border); border-radius: 10px; background: var(--bg); outline: none;
    }
    .chat-mini-input.chat-username-input { padding-left: 48px; }
    .chat-mini-input:focus { border-color: var(--text); }

    .chat-mini-bio {
        width: 100%; min-height: 64px; padding: 11px 12px; font-size: 12.5px; color: var(--text);
        border: 1px solid var(--border); border-radius: 10px; background: var(--bg); outline: none;
        resize: vertical; margin-bottom: 10px;
    }

    .chat-preview {
        display: flex; align-items: center; gap: 11px; padding: 11px 12px; margin-bottom: 10px;
        border: 1px solid var(--border-soft); border-radius: 12px; background: var(--surface-hover);
    }
    .chat-preview-avatar {
        width: 36px; height: 36px; flex-shrink: 0; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
        background: var(--surface); border: 1px solid var(--border);
        color: var(--text); font-size: 13px; font-weight: 750;
    }
    .chat-preview-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .chat-preview-info { min-width: 0; flex: 1; }
    .chat-preview-name-row { display: flex; align-items: baseline; gap: 6px; }
    .chat-preview-name { font-size: 12px; font-weight: 750; }
    .chat-preview-name.placeholder { color: var(--muted-2); }
    .chat-preview-handle { color: var(--muted); font-size: 9.5px; font-weight: 600; }
    .chat-preview-desc { color: var(--muted); font-size: 10px; margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .chat-preview-desc.placeholder { color: var(--muted-2); }
    .chat-preview-tag {
        margin-left: auto; flex-shrink: 0; padding: 4px 8px; border-radius: 7px;
        color: var(--muted); background: var(--surface); font-size: 8px; font-weight: 750;
    }
    .chat-preview-label {
        display: flex; align-items: center; gap: 5px; margin-bottom: 8px;
        color: var(--muted-2); font-size: 9px; font-weight: 750; text-transform: uppercase; letter-spacing: .04em;
    }
    .chat-preview-label svg { width: 11px; height: 11px; }

    .chat-mini-actions { display: flex; justify-content: flex-end; gap: 7px; }
    .chat-mini-btn {
        height: 32px; padding: 0 13px; border-radius: 9px; font-size: 10.5px; font-weight: 700;
        cursor: pointer; border: 1px solid transparent;
    }
    .chat-mini-btn.primary { background: var(--invert-bg); color: var(--invert-text); }
    .chat-mini-btn.secondary { background: var(--surface); border-color: var(--border); color: var(--muted); }

    .chat-item {
        display: flex; align-items: center; gap: 10px; padding: 9px; flex: 1; min-width: 0;
        border: 1px solid var(--border-soft); border-radius: 12px; background: var(--surface);
        margin-bottom: 9px; animation: channelIn .35s ease; cursor: pointer;
    }
    .chat-item:hover { border-color: var(--muted-2); background: var(--surface-hover); }
    .chat-item .channel-image { width: 32px; height: 32px; font-size: 11px; }
    .chat-item .channel-title { font-size: 10.5px; }
    .chat-item .channel-handle { font-size: 8.5px; }
    .chat-more { width: 26px; height: 26px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-soft); border-radius: 9px; color: var(--muted); background: var(--surface); cursor: pointer; }
    .chat-more:hover { color: var(--text); background: var(--surface-hover); }
    .chat-tag {
        margin-left: auto; padding: 3px 7px; border-radius: 6px; font-size: 8px; font-weight: 750;
        color: var(--muted); background: var(--surface-hover); flex-shrink: 0;
    }

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

    .preview-panel.chat-mode .preview-avatar { border-style: dashed; }

    .history-panel-body { padding: 6px 18px 18px; }

    /* ============ FILTER BAR (search + filter toggle) ============ */

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
        .filter-extra { grid-template-columns: 1fr; }
    }

    .history-table-wrap {
        max-height: 420px; overflow-y: auto; overflow-x: auto;
        border: 1px solid var(--border); border-radius: 14px;
    }
    .history-table-wrap::-webkit-scrollbar { width: 4px; height: 4px; }
    .history-table-wrap::-webkit-scrollbar-track { background: transparent; }
    .history-table-wrap::-webkit-scrollbar-thumb { background: var(--surface-hover); border-radius: 10px; }

    .history-table { width: 100%; border-collapse: collapse; min-width: 760px; }

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
        animation: channelIn .35s ease;
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
    .history-name-text { font-weight: 700; max-width: 200px; overflow: hidden; text-overflow: ellipsis; display: block; }
    .history-name-note { display: block; color: var(--muted-2); font-size: 9px; font-weight: 500; margin-top: 1px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .history-chat-empty { color: var(--muted-2); font-size: 10px; }

    .history-tag {
        display: inline-flex; padding: 4px 9px; border-radius: 7px;
        color: var(--muted); background: var(--surface-hover); font-size: 8.5px; font-weight: 750;
        white-space: nowrap;
    }
    .history-tag.icon-edit { color: #f2a93b; }
    .history-tag.icon-delete { color: #e5484d; }
    .history-tag.chat-tag-pill { color: var(--text); }

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
        animation: channelIn .3s ease;
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
        .table-filter-bar { grid-template-columns: 1fr; }
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
                    <path d="M4 11.5v1a1.2 1.2 0 0 0 1.2 1.2h1.1l3.9 3v-9.4l-3.9 3H5.2A1.2 1.2 0 0 0 4 11.5Z"/>
                    <path d="M14.3 9a3.6 3.6 0 0 1 0 6"/>
                    <path d="M16.6 6.3a7.2 7.2 0 0 1 0 11.4"/>
                </svg>
            </div>
            <div>
                <h1 data-i18n="channelCreateTitle">Kanal yaratish</h1>
                <p data-i18n="channelCreateSubtitle">Yangi kanal oching, unga nom, rasm va tavsif qo‘shing, obunachilaringiz uchun ochiq yoki maxsus havola bilan yopiq qilib sozlang va bir necha soniyada ulashishni boshlang.</p>
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
                            <label data-i18n="channelPhotoLabel">Kanal rasmi</label>
                        </div>
                        <span data-i18n="optionalLabel">Ixtiyoriy</span>
                    </div>
                    <div class="photo-box">
                        <label for="channelPhoto" class="upload-avatar">
                            <div class="avatar" id="mainAvatar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                    <circle cx="12" cy="13" r="3.4"/>
                                    <path d="M4 8.5A1.5 1.5 0 0 1 5.5 7h1.8l1-2h7.4l1 2h1.8A1.5 1.5 0 0 1 20 8.5V18a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18Z"/>
                                </svg>
                            </div>
                            <div class="upload-plus">+</div>
                        </label>
                        <div class="photo-info">
                            <strong data-i18n="channelPhotoTitle">Kanal rasmini tanlang</strong>
                            <p data-i18n="channelPhotoHint">JPG, PNG yoki WEBP formatida rasm yuklang.</p>
                            <button type="button" class="upload-button" data-i18n="uploadPhotoBtn" onclick="document.getElementById('channelPhoto').click()">Rasm yuklash</button>
                            <input type="file" id="channelPhoto" accept="image/*" hidden>
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
                            <label for="channelName" data-i18n="channelNameLabel">Kanal nomi</label>
                        </div>
                        <span data-i18n="requiredLabel">Majburiy</span>
                    </div>
                    <div class="field">
                        <input id="channelName" class="input" type="text" maxlength="64" autocomplete="off" placeholder="Masalan: IT Yangiliklari">
                    </div>
                </div>

              <div class="form-section">
    <div class="form-label">
        <div class="form-label-left">
            <span class="form-label-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M10 13a5 5 0 0 0 7.5.4l2-2a5 5 0 0 0-7-7l-1.2 1.1"/>
                    <path d="M14 11a5 5 0 0 0-7.5-.4l-2 2a5 5 0 0 0 7 7l1.1-1.1"/>
                </svg>
            </span>
            <label for="channelUsername" data-i18n="channelLinkLabel">Havola</label>
        </div>
        <span data-i18n="optionalLabel">Ixtiyoriy</span>
    </div>
    <div class="field username-wrapper">
        <span class="username-prefix">t.me/</span>
        <input id="channelUsername" class="input username-input" type="text" maxlength="32" autocomplete="off" placeholder="it_yangiliklari">
    </div>
</div>

<div class="channel-dropdown" id="chatDropdown">
    <button type="button" class="dropdown-item" data-chat-action="edit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Tahrirlash
    </button>
    <button type="button" class="dropdown-item danger" data-chat-action="delete">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        O'chirish
    </button>
</div>

                <div class="form-section">
                    <div class="form-label">
                        <div class="form-label-left">
                            <span class="form-label-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </span>
                            <label for="channelDescription" data-i18n="channelDescriptionLabel">Kanal haqida</label>
                        </div>
                        <span id="descriptionCount">0 / 255</span>
                    </div>
                    <div class="field">
                        <textarea id="channelDescription" class="textarea" maxlength="255" placeholder="Kanal nima haqida ekanini qisqacha yozing..."></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <div class="visibility-title">
                        <span class="form-label-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 2 4 5v6c0 5 3.4 8.6 8 11 4.6-2.4 8-6 8-11V5z"/>
                            </svg>
                        </span>
                        <span data-i18n="channelTypeTitle">Kanal turi</span>
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
                            <strong data-i18n="publicChannelTitle">Ommaviy kanal</strong>
                            <small data-i18n="publicChannelHint">Hamma kanalni topishi mumkin.</small>
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
                            <strong data-i18n="privateChannelTitle">Yopiq kanal</strong>
                            <small data-i18n="privateChannelHint">Faqat havola orqali qo‘shiladi.</small>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="button button-secondary" id="cancelButton" data-i18n="cancelBtn">Bekor qilish</button>
                    <button type="button" class="button button-primary" id="createButton">
                        <span class="btn-spinner"></span>
                        <svg class="btn-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                            <path d="M12 5v14"/><path d="M5 12h14"/>
                        </svg>
                        <span class="btn-label" data-i18n="createChannelBtn">Kanal yaratish</span>
                    </button>
                </div>

            </div>
        </section>

        <section class="panel channels-panel">
            <div class="panel-head">
                <div class="panel-head-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="18" height="18" rx="5"/>
                        <path d="M8 12h8"/><path d="M12 8v8"/>
                    </svg>
                </div>
                <div><h2 data-i18n="yourChannelsTitle">Kanallaringiz</h2><p data-i18n="yourChannelsSubtitle">Siz yaratgan barcha kanallar</p></div>
                <div class="channel-count" id="channelCount">0</div>
            </div>

            <div class="channels-panel-body">
                <div id="emptyState" class="empty-state">
                    <div class="empty-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="6"/>
                            <path d="M12 8v8"/><path d="M8 12h8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 data-i18n="noChannelsTitle">Hali kanal yo‘q</h3>
                        <p data-i18n="noChannelsText">Birinchi kanalingizni yarating — shu yerda paydo bo‘ladi.</p>
                    </div>
                </div>

                <div class="channel-list" id="channelList"></div>

                <button type="button" class="channels-toggle-btn" id="channelsToggleBtn">Barchasini ko'rish</button>
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
                <span id="previewExplainerText" data-i18n="previewChannelText">Jonli ko‘rinish — kanalingiz shunday chiqadi</span>
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
                                <circle cx="12" cy="13" r="3.4"/>
                                <path d="M4 8.5A1.5 1.5 0 0 1 5.5 7h1.8l1-2h7.4l1 2h1.8A1.5 1.5 0 0 1 20 8.5V18a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18Z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="preview-info">
                        <div class="preview-name-row">
                            <h3 class="preview-name placeholder" id="previewName" data-i18n="previewChannelName">Kanal nomi</h3>
                            <p class="preview-handle" id="previewHandle">@kanal_username</p>
                        </div>
                        <p class="preview-desc placeholder" id="previewDesc" data-i18n="previewChannelDesc">Kanal tavsifi shu yerda ko‘rinadi.</p>
                    </div>
                </div>

                <div class="preview-stats">
                    <div class="preview-pill" id="previewVisibility" data-i18n="previewVisibilityPublicChannel">Ommaviy kanal</div>
                    <div class="preview-pill" id="previewSubs">0 obunachi</div>
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
                <div><h2>Kanallar jadvali</h2><p>Barcha kanallar, ularning turi va biriktirilgan suhbatlar — O‘zbekiston vaqti bilan</p></div>
                <div class="channel-count" id="historyCount">0</div>
            </div>

            <div class="history-panel-body">

                <div class="table-filter-bar">
                    <div class="filter-field filter-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                        <input type="text" id="tableSearchInput" placeholder="Kanal nomi yoki username bo‘yicha qidirish...">
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
                            <option value="public">Ommaviy kanal</option>
                            <option value="private">Yopiq kanal</option>
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
                        <h3>Hali kanal yo‘q</h3>
                        <p>Kanal yaratsangiz, bu yerda jadval ko‘rinishida — nomi, turi, yaratilgan vaqti va unga biriktirilgan suhbat bilan — paydo bo‘ladi.</p>
                    </div>
                </div>

                <div class="history-table-wrap" id="historyTableWrap" style="display:none">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Kanal</th>
                                <th>Suhbat</th>
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

<div class="channel-dropdown" id="sharedDropdown">
    <button type="button" class="dropdown-item" data-action="edit">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Tahrirlash
    </button>
    <button type="button" class="dropdown-item" data-action="chat">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Suhbat
    </button>
    <button type="button" class="dropdown-item" data-action="move">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        Chatovbs menyusiga o'tkazish
    </button>
    <div class="dropdown-divider"></div>
    <button type="button" class="dropdown-item danger" data-action="delete">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
        Kanalni o'chirish
    </button>
</div>

<script>
    const persistedEntities = @json($entities);
    const entityApiUrl = '{{ url('/chat-entities/channel') }}';
    const channelName = document.getElementById('channelName');
    const channelUsername = document.getElementById('channelUsername');
    const channelDescription = document.getElementById('channelDescription');
    const channelPhoto = document.getElementById('channelPhoto');
    const mainAvatar = document.getElementById('mainAvatar');
    const descriptionCount = document.getElementById('descriptionCount');
    const createButton = document.getElementById('createButton');
    const cancelButton = document.getElementById('cancelButton');
    const channelList = document.getElementById('channelList');
    const emptyState = document.getElementById('emptyState');
    const channelCount = document.getElementById('channelCount');
    const toast = document.getElementById('toast');
    const toastText = document.getElementById('toastText');
    const channelsToggleBtn = document.getElementById('channelsToggleBtn');

    const historyTableWrap = document.getElementById('historyTableWrap');
    const historyTableBody = document.getElementById('historyTableBody');
    const historyCount = document.getElementById('historyCount');
    const tableSearchInput = document.getElementById('tableSearchInput');
    const tableDateInput = document.getElementById('tableDateInput');
    const tableTypeSelect = document.getElementById('tableTypeSelect');
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterExtra = document.getElementById('filterExtra');

    const previewPanel = document.getElementById('previewPanel');
    const previewExplainerText = document.getElementById('previewExplainerText');
    const previewAvatarWrap = document.getElementById('previewAvatarWrap');
    const previewAvatar = document.getElementById('previewAvatar');
    const previewName = document.getElementById('previewName');
    const previewHandle = document.getElementById('previewHandle');
    const previewDesc = document.getElementById('previewDesc');
    const previewVisibility = document.getElementById('previewVisibility');
    const previewSubs = document.getElementById('previewSubs');

    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    const sunPath = '<path d="M12 3v2M12 19v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M3 12h2M19 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/><circle cx="12" cy="12" r="4"/>';
    const moonPath = '<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>';

    const defaultAvatarSVG = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <circle cx="12" cy="13" r="3.4"/>
            <path d="M4 8.5A1.5 1.5 0 0 1 5.5 7h1.8l1-2h7.4l1 2h1.8A1.5 1.5 0 0 1 20 8.5V18a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18Z"/>
        </svg>`;

    let selectedImage = '';
    let editingChannelName = null;
    let editingChannelMeta = null;
    let editingChannelClientId = null;
    let editingChatId = null;

    let previewOwnerChatId = null;

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
        if (previewOwnerChatId) return;
        const name = channelName.value.trim();
        const username = channelUsername.value.trim();
        const description = channelDescription.value.trim();

        if (name) {
            previewName.textContent = name;
            previewName.classList.remove('placeholder');
        } else {
            previewName.textContent = 'Kanal nomi';
            previewName.classList.add('placeholder');
        }

        previewHandle.textContent = 't.me/' + (username || (name ? slugify(name) : 'kanal_username'));

        if (description) {
            previewDesc.textContent = description;
            previewDesc.classList.remove('placeholder');
        } else {
            previewDesc.textContent = 'Kanal tavsifi shu yerda ko‘rinadi.';
            previewDesc.classList.add('placeholder');
        }

        if (selectedImage) {
            previewAvatar.innerHTML = '<img src="' + selectedImage + '" alt="Kanal rasmi">';
        } else if (name) {
            previewAvatar.textContent = name.charAt(0).toUpperCase();
        } else {
            previewAvatar.innerHTML = defaultAvatarSVG;
        }
    }

    channelName.addEventListener('input', updatePreview);
    channelUsername.addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
        updatePreview();
    });
    channelDescription.addEventListener('input', function () {
        descriptionCount.textContent = this.value.length + ' / 255';
        updatePreview();
    });

    channelPhoto.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            showToast('Faqat rasm faylini tanlang.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            selectedImage = event.target.result;
            mainAvatar.innerHTML = '<img src="' + selectedImage + '" alt="Kanal rasmi">';
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
            if (!previewOwnerChatId) {
                previewVisibility.textContent = type === 'private' ? 'Yopiq kanal' : 'Ommaviy kanal';
            }
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
        return 'ch' + entity.id;
    }

    function persistChannel(data, method, id) {
        return fetch(id ? entityApiUrl + '/' + id : entityApiUrl, {
            method: method || 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: method === 'DELETE' ? null : JSON.stringify(data)
        }).then(function (response) {
            if (!response.ok) throw new Error('Saqlashda xatolik');
            return response.json();
        });
    }

    function persistChat(data, id) {
        return fetch(entityApiUrl + '/' + id + '/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            if (!response.ok) {
                return response.text().then(function (message) {
                    throw new Error(message || 'Suhbatni saqlashda xatolik');
                });
            }
            return response.json();
        });
    }

    function deletePersistedChannel(id) {
        return fetch(entityApiUrl + '/' + id + '/delete', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(function (response) {
            if (!response.ok) throw new Error('Kanalni o‘chirishda xatolik');
            return response.json();
        });
    }

    function deletePersistedChat(id) {
        return fetch(entityApiUrl + '/' + id + '/chat/delete', {
            method: 'POST',
            headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(function (response) {
            if (!response.ok) throw new Error('Chatni o‘chirishda xatolik');
            return response.json();
        });
    }

    function renderPersistedChannel(entity, prepend) {
        const id = entityClientId(entity);
        const avatarHTML = entity.avatar
            ? '<img src="' + escapeHTML(entity.avatar) + '" alt="Kanal">'
            : escapeHTML(entity.name.charAt(0).toUpperCase());
        const block = document.createElement('div');
        block.className = 'channel-block';
        block.dataset.id = id;
        block.dataset.backendId = entity.id;
        block.dataset.created = entity.created_at;
        block.innerHTML = `
            <div class="channel-item">
                <div class="channel-image">${avatarHTML}</div>
                <div class="channel-content">
                    <div class="channel-title-row"><h3 class="channel-title">${escapeHTML(entity.name)}</h3><div class="status"></div></div>
                    <p class="channel-handle">t.me/${escapeHTML(entity.username || slugify(entity.name))}</p>
                    <div class="channel-meta"><div class="meta-pill">${entity.visibility === 'private' ? 'Yopiq' : 'Ommaviy'}</div><div class="meta-pill">0 obunachi</div></div>
                    <p class="channel-created">${icoClock} Yaratilgan: ${formatTashkentTime(new Date(entity.created_at))} (UZ vaqti)</p>
                </div>
                <button type="button" class="channel-more" data-action="toggle-menu">⋮</button>
            </div><div class="chat-slot" id="chatSlot-${id}" data-form-open="0"></div>`;
        if (prepend) channelList.prepend(block);
        else channelList.appendChild(block);
        const persistedChat = entity.chat_name ? {
            name: entity.chat_name,
            username: entity.chat_username || slugify(entity.chat_name),
            image: entity.chat_avatar || '',
            bio: entity.chat_description || '',
            createdAt: entity.chat_created_at || entity.updated_at
        } : null;
        if (persistedChat) {
            chatStore[id] = persistedChat;
            chatOpen[id] = true;
            renderChatBranch(id);
        }
        addChannelTableRow(id, {name: entity.name, username: entity.username || slugify(entity.name), bio: entity.description || '', type: entity.visibility, createdAtISO: entity.created_at, avatar: avatarHTML, avatarImage: entity.avatar || null, backendId: entity.id, chat: persistedChat});
    }

    createButton.addEventListener('click', function () {
        const name = channelName.value.trim();
        const username = channelUsername.value.trim();
        const description = channelDescription.value.trim();
        const selectedVisibility = document.querySelector('input[name="visibility"]:checked');
        const type = selectedVisibility ? selectedVisibility.value : 'public';

        if (!name) {
            channelName.focus();
            showToast('Avval kanal nomini kiriting.');
            return;
        }

        const carriedChat = editingChannelMeta && editingChannelMeta.chat ? editingChannelMeta.chat : null;
        const isEditing = !!(editingChannelMeta && editingChannelMeta.backendId);
        const wasEditingClientId = editingChannelClientId;
        const wasEditingChannelName = editingChannelName;
        const payload = {
            name: name,
            username: username || slugify(name),
            description: description,
            visibility: type,
            avatar: selectedImage || null,
            chat_name: carriedChat ? carriedChat.name : null,
            chat_username: carriedChat ? carriedChat.username : null,
            chat_avatar: carriedChat ? carriedChat.image : null,
            chat_description: carriedChat ? carriedChat.bio : null,
            chat_created_at: carriedChat ? carriedChat.createdAt : null
        };

        createButton.disabled = true;
        createButton.classList.add('loading');
        previewAvatarWrap.classList.remove('creating');
        void previewAvatarWrap.offsetWidth;
        previewAvatarWrap.classList.add('creating');

        const minDelay = new Promise(function (resolve) { setTimeout(resolve, 400); });

        Promise.all([
            persistChannel(payload, isEditing ? 'PATCH' : 'POST', isEditing ? editingChannelMeta.backendId : null),
            minDelay
        ]).then(function (results) {
            const entity = results[0].entity;
            createButton.disabled = false;
            createButton.classList.remove('loading');

            if (isEditing) {
                const oldBlock = document.querySelector('.channel-block[data-id="' + wasEditingClientId + '"]');
                if (oldBlock) oldBlock.remove();
                removeChannelTableRow(wasEditingClientId);
            } else if (document.getElementById('emptyState')) {
                document.getElementById('emptyState').remove();
            }

            renderPersistedChannel(entity, true);
            channelCount.textContent = channelList.querySelectorAll('.channel-item').length;

            if (wasEditingChannelName) {
                editingChannelName = null;
                editingChannelClientId = null;
                editingChannelMeta = null;
                createButton.querySelector('.btn-label').textContent = 'Kanal yaratish';
                showToast('O\'zgarishlar saqlandi!');
            } else {
                showToast('Kanal muvaffaqiyatli yaratildi!');
            }

            resetForm();
            updateChannelVisibility();
        }).catch(function () {
            createButton.disabled = false;
            createButton.classList.remove('loading');
            showToast('Kanal bazaga saqlanmadi. Qayta urinib ko\'ring.');
        });
    });

    let channelSeq = 0;
    const chatStore = {};
    const chatOpen = {};
    const chatPhotoStore = {};

    const icoClock = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>';
    const icoEdit = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>';

    const channelsTableStore = {};
    let openDetailId = null;

    // ---------- keep only the 4 most recent channel cards visible ----------
    let channelsExpanded = false;

    function updateChannelVisibility() {
        const blocks = Array.from(channelList.querySelectorAll('.channel-block'));

        if (blocks.length <= 4) {
            blocks.forEach(function (b) { b.classList.remove('hidden-channel'); });
            channelsToggleBtn.style.display = 'none';
            channelsExpanded = false;
            return;
        }

        channelsToggleBtn.style.display = 'block';
        blocks.forEach(function (b, i) {
            if (channelsExpanded || i < 4) b.classList.remove('hidden-channel');
            else b.classList.add('hidden-channel');
        });
        channelsToggleBtn.textContent = channelsExpanded
            ? 'Kamroq ko\'rsatish'
            : 'Yana ' + (blocks.length - 4) + ' ta kanalni ko\'rish';
    }

    channelsToggleBtn.addEventListener('click', function () {
        channelsExpanded = !channelsExpanded;
        updateChannelVisibility();
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
                <h3>Kanal topilmadi</h3>
                <p>Qidiruv shartlariga mos kanal yo‘q, yoki hali kanal yaratilmagan.</p>
            </div>`;
        return div;
    }

    function addChannelTableRow(id, data) {
        channelsTableStore[id] = data;
        renderChannelsTable();
    }

    function removeChannelTableRow(id) {
        delete channelsTableStore[id];
        if (openDetailId === id) openDetailId = null;
        renderChannelsTable();
    }

    function updateChannelChat(id, chatData) {
        if (channelsTableStore[id]) {
            channelsTableStore[id].chat = chatData;
            renderChannelsTable();
        }
    }

    function buildDetailCard(r) {
        const parts = formatTashkentParts(new Date(r.createdAtISO));

        const chatBlock = r.chat
            ? '<div class="detail-row-line">' +
                  '<div class="detail-avatar">' + (r.chat.image ? '<img src="' + r.chat.image + '" alt="">' : escapeHTML(r.chat.name.charAt(0).toUpperCase())) + '</div>' +
                  '<div>' +
                      '<div class="detail-name">' + escapeHTML(r.chat.name) + '</div>' +
                      '<div class="detail-sub">t.me/' + escapeHTML(r.chat.username) + '</div>' +
                  '</div>' +
              '</div>' +
              (r.chat.bio ? '<p class="detail-sub">' + escapeHTML(r.chat.bio) + '</p>' : '<p class="detail-sub">Tavsif kiritilmagan.</p>')
            : '<p class="detail-empty">Bu kanalga hali suhbat biriktirilmagan.</p>';

        return '' +
        '<div class="detail-card">' +
            '<div class="detail-block">' +
                '<h4>Kanal ma\'lumotlari</h4>' +
                '<div class="detail-row-line">' +
                    '<div class="detail-avatar">' + r.avatar + '</div>' +
                    '<div>' +
                        '<div class="detail-name">' + escapeHTML(r.name) + '</div>' +
                        '<div class="detail-sub">t.me/' + escapeHTML(r.username) + '</div>' +
                    '</div>' +
                '</div>' +
                '<p class="detail-sub">' + (r.bio ? escapeHTML(r.bio) : 'Tavsif kiritilmagan.') + '</p>' +
                '<p class="detail-line-extra">Turi: ' + (r.type === 'private' ? 'Yopiq kanal' : 'Ommaviy kanal') + '</p>' +
                '<p class="detail-line-extra">Yaratilgan: ' + parts.date + ' ' + parts.time + ' (UZ vaqti)</p>' +
            '</div>' +
            '<div class="detail-block">' +
                '<h4>Biriktirilgan suhbat</h4>' +
                chatBlock +
            '</div>' +
        '</div>';
    }

    function renderChannelsTable() {
        const term = tableSearchInput.value.trim().toLowerCase();
        const dateVal = tableDateInput.value;
        const typeVal = tableTypeSelect.value;

        let rows = Object.keys(channelsTableStore).map(function (id) {
            return Object.assign({ id: id }, channelsTableStore[id]);
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

        historyCount.textContent = Object.keys(channelsTableStore).length;

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
            const typeLabel = r.type === 'private' ? 'Yopiq' : 'Ommaviy';
            const typeClass = r.type === 'private' ? 'icon-edit' : '';

            const chatCell = r.chat
                ? '<div class="history-name-cell">' +
                      '<div class="history-name-icon">' + (r.chat.image ? '<img src="' + r.chat.image + '" alt="">' : escapeHTML(r.chat.name.charAt(0).toUpperCase())) + '</div>' +
                      '<div>' +
                          '<span class="history-name-text">' + escapeHTML(r.chat.name) + '</span>' +
                          '<span class="history-name-note">@' + escapeHTML(r.chat.username) + '</span>' +
                      '</div>' +
                  '</div>'
                : '<span class="history-chat-empty">Biriktirilmagan</span>';

            const isOpen = openDetailId === r.id;

            return '' +
                '<tr class="data-row">' +
                    '<td class="history-id">' + (i + 1) + '</td>' +
                    '<td>' +
                        '<div class="history-name-cell">' +
                            '<div class="history-name-icon">' + r.avatar + '</div>' +
                            '<div>' +
                                '<span class="history-name-text">' + escapeHTML(r.name) + '</span>' +
                                '<span class="history-name-note">t.me/' + escapeHTML(r.username) + '</span>' +
                            '</div>' +
                        '</div>' +
                    '</td>' +
                    '<td>' + chatCell + '</td>' +
                    '<td><span class="history-tag ' + typeClass + '">' + typeLabel + '</span></td>' +
                    '<td class="history-date-cell">' +
                        '<span class="history-date">' + parts.date + '</span>' +
                        '<small>' + parts.time + ' (UZ)</small>' +
                    '</td>' +
                    '<td><button type="button" class="btn-detail' + (isOpen ? ' open' : '') + '" data-detail-toggle="' + r.id + '">' + (isOpen ? 'Yopish' : 'Batafsil ko\'rish') + '</button></td>' +
                '</tr>' +
                '<tr class="detail-row' + (isOpen ? '' : ' closed') + '" id="detailRow-' + r.id + '">' +
                    '<td colspan="6">' + buildDetailCard(r) + '</td>' +
                '</tr>';
        }).join('');
    }

    historyTableBody.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-detail-toggle]');
        if (!btn) return;
        const id = btn.dataset.detailToggle;
        openDetailId = (openDetailId === id) ? null : id;
        renderChannelsTable();
    });

    tableSearchInput.addEventListener('input', renderChannelsTable);
    tableDateInput.addEventListener('change', renderChannelsTable);
    tableTypeSelect.addEventListener('change', renderChannelsTable);

    function formatTashkentTime(date) {
        const parts = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Tashkent',
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', hour12: false
        }).formatToParts(date);
        const get = function (t) { return parts.find(function (p) { return p.type === t; }).value; };
        return get('day') + '.' + get('month') + '.' + get('year') + ' ' + get('hour') + ':' + get('minute');
    }

    const uzMonths = ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentabr', 'Oktabr', 'Noyabr', 'Dekabr'];

    function formatTashkentParts(date) {
        const parts = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Tashkent',
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
        }).formatToParts(date);
        const get = function (t) { return parts.find(function (p) { return p.type === t; }).value; };
        const day = get('day'), month = get('month'), year = get('year');
        return {
            date: day + '.' + month + '.' + year,
            dateLong: day + '-' + uzMonths[parseInt(month, 10) - 1] + ', ' + year,
            time: get('hour') + ':' + get('minute') + ':' + get('second')
        };
    }

    const sharedDropdown = document.getElementById('sharedDropdown');
    const chatDropdown = document.getElementById('chatDropdown');
    let activeDropdownId = null;
    let activeChatId = null;

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

    function positionChatDropdown(button) {
        const rect = button.getBoundingClientRect();
        const menuWidth = chatDropdown.offsetWidth || 170;
        let left = rect.right - menuWidth;
        let top = rect.bottom + 6;
        if (left < 8) left = 8;
        if (left + menuWidth > window.innerWidth - 8) left = window.innerWidth - menuWidth - 8;
        if (top + chatDropdown.offsetHeight > window.innerHeight - 8) top = rect.top - chatDropdown.offsetHeight - 6;
        chatDropdown.style.left = left + 'px';
        chatDropdown.style.top = top + 'px';
    }

    function closeDropdown() {
        sharedDropdown.classList.remove('open');
        activeDropdownId = null;
    }

    function closeChatDropdown() {
        chatDropdown.classList.remove('open');
        activeChatId = null;
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#sharedDropdown') && !e.target.closest('.channel-more')) {
            closeDropdown();
        }
        if (!e.target.closest('#chatDropdown') && !e.target.closest('.chat-more')) closeChatDropdown();
    });
    window.addEventListener('scroll', function () { closeDropdown(); closeChatDropdown(); }, true);
    window.addEventListener('resize', function () { closeDropdown(); closeChatDropdown(); });

    channelList.addEventListener('click', function (e) {
        const chatMore = e.target.closest('.chat-more');
        if (chatMore) {
            const chatBlock = e.target.closest('.channel-block');
            activeChatId = chatBlock.dataset.id;
            chatDropdown.classList.add('open');
            positionChatDropdown(chatMore);
            return;
        }
        const toggleBtn = e.target.closest('[data-action="toggle-menu"]');
        if (!toggleBtn) return;
        const block = e.target.closest('.channel-block');
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

        if (action === 'delete') deleteChannelBlock(id);
        else if (action === 'edit') editChannelBlock(id);
        else if (action === 'move') moveToChatovbs(id);
        else if (action === 'chat') toggleChatSlot(id);
    });

    chatDropdown.addEventListener('click', function (e) {
        const actionButton = e.target.closest('[data-chat-action]');
        if (!actionButton || !activeChatId) return;
        const id = activeChatId;
        const action = actionButton.dataset.chatAction;
        closeChatDropdown();
        if (action === 'edit') editChat(id);
        if (action === 'delete') deleteChat(id);
    });

    channelList.addEventListener('click', function (e) {
        const chatActionBtn = e.target.closest('[data-action="submit-chat"], [data-action="cancel-chat"]');
        if (!chatActionBtn) return;
        const block = e.target.closest('.channel-block');
        const id = block.dataset.id;
        const action = chatActionBtn.dataset.action;

        if (action === 'submit-chat') submitChat(id);
        else if (action === 'cancel-chat') closeChatSlot(id);
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
                <h3>Hali kanal yo‘q</h3>
                <p>Birinchi kanalingizni yarating — shu yerda paydo bo‘ladi.</p>
            </div>`;
        return div;
    }

    function deleteChannelBlock(id, logHistory) {
        if (logHistory === undefined) logHistory = true;
        if (previewOwnerChatId === id) exitChatPreviewMode();
        const block = document.querySelector('.channel-block[data-id="' + id + '"]');
        const stored = channelsTableStore[id];
        const backendId = block ? block.dataset.backendId : (stored && stored.backendId);

        const removeFromPage = function () {
            if (block) block.remove();
            delete chatStore[id];
            delete chatOpen[id];
            delete chatPhotoStore[id];
            removeChannelTableRow(id);

            const currentCount = channelList.querySelectorAll('.channel-item').length;
            channelCount.textContent = currentCount;
            if (currentCount === 0 && !document.getElementById('emptyState')) {
                channelList.parentElement.insertBefore(buildEmptyState(), channelList);
            }

            updateChannelVisibility();
            if (logHistory) showToast("Kanal o'chirildi.");
        };

        if (!backendId) {
            showToast('Kanal bazadagi ID topilmadi, o‘chirish amalga oshmadi.');
            return;
        }

        deletePersistedChannel(backendId)
            .then(removeFromPage)
            .catch(function () { showToast('Kanal bazadan o‘chirilmadi.'); });
    }

    function editChannelBlock(id) {
        const block = document.querySelector('.channel-block[data-id="' + id + '"]');
        if (!block) return;

        const title = block.querySelector('.channel-title').textContent;
        const handle = block.querySelector('.channel-handle').textContent.replace(/^t\.me\//, '').replace(/^@/, '');
        const isPrivate = block.querySelector('.meta-pill').textContent.trim() === 'Yopiq';
        const existingBio = (channelsTableStore[id] && channelsTableStore[id].bio) ? channelsTableStore[id].bio : '';

        channelName.value = title;
        channelUsername.value = handle;
        channelDescription.value = existingBio;
        selectedImage = (channelsTableStore[id] && channelsTableStore[id].avatarImage) || '';
        mainAvatar.innerHTML = selectedImage
            ? '<img src="' + escapeHTML(selectedImage) + '" alt="Kanal rasmi">'
            : defaultAvatarSVG;
        descriptionCount.textContent = existingBio.length + ' / 255';
        document.querySelector('.visibility-card[data-type="' + (isPrivate ? 'private' : 'public') + '"]').click();
        updatePreview();
        channelName.focus();

        editingChannelName = title;
        editingChannelClientId = id;
        editingChannelMeta = {
            createdAt: block.dataset.created || new Date().toISOString(),
            backendId: block.dataset.backendId || (channelsTableStore[id] && channelsTableStore[id].backendId),
            chat: chatStore[id] || null
        };
        block.remove();
        removeChannelTableRow(id);
        channelCount.textContent = channelList.querySelectorAll('.channel-item').length;
        createButton.querySelector('.btn-label').textContent = 'O\'zgarishlarni saqlash';
        showToast('Ma\'lumotlar shaklga yuklandi — yangilab, "Kanal yaratish" tugmasini bosing.');
    }

    function moveToChatovbs(id) {
        const block = document.querySelector('.channel-block[data-id="' + id + '"]');
        const backendId = block && block.dataset.backendId;
        if (!backendId) return showToast('Kanal bazadagi ID topilmadi.');
        fetch(entityApiUrl + '/' + backendId + '/move-home', {
            method: 'POST',
            headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(function (response) {
            if (!response.ok) throw new Error('move failed');
            showToast("Kanal Chatovbs menyusiga o'tkazildi.");
        }).catch(function () { showToast('Kanal menyuga o‘tkazilmadi.'); });
    }

    function toggleChatSlot(id) {
        const slot = document.getElementById('chatSlot-' + id);
        if (!slot) return;

        if (chatStore[id]) {
            chatOpen[id] = !chatOpen[id];
            renderChatBranch(id);
            return;
        }

        if (slot.dataset.formOpen === '1') {
            slot.innerHTML = '';
            slot.dataset.formOpen = '0';
            if (previewOwnerChatId === id) exitChatPreviewMode();
        } else {
            slot.dataset.formOpen = '1';
            slot.innerHTML = chatFormTemplate(id);
            enterChatPreviewMode(id);
            updateChatPreview(id);
        }
    }

    function editChat(id) {
        const data = chatStore[id];
        const slot = document.getElementById('chatSlot-' + id);
        if (!data || !slot) return;

        editingChatId = id;
        slot.dataset.formOpen = '1';
        slot.innerHTML = chatFormTemplate(id);
        document.getElementById('chatName-' + id).value = data.name;
        document.getElementById('chatUsername-' + id).value = data.username || '';
        document.getElementById('chatBio-' + id).value = data.bio || '';
        if (data.image) {
            chatPhotoStore[id] = data.image;
            document.getElementById('chatAvatarInner-' + id).innerHTML = '<img src="' + escapeHTML(data.image) + '" alt="Suhbat rasmi">';
        }
        enterChatPreviewMode(id);
        updateChatPreview(id);
    }

    function deleteChat(id) {
        const block = document.querySelector('.channel-block[data-id="' + id + '"]');
        const backendId = block && block.dataset.backendId;
        if (!backendId) return showToast('Kanal bazadagi ID topilmadi.');

        deletePersistedChat(backendId).then(function () {
            delete chatStore[id];
            delete chatOpen[id];
            delete chatPhotoStore[id];
            editingChatId = null;
            renderChatBranch(id);
            updateChannelChat(id, null);
            showToast('Biriktirilgan suhbat o‘chirildi.');
        }).catch(function () { showToast('Suhbat bazadan o‘chirilmadi.'); });
    }

    function closeChatSlot(id) {
        const slot = document.getElementById('chatSlot-' + id);
        if (slot) { slot.innerHTML = ''; slot.dataset.formOpen = '0'; }
        if (previewOwnerChatId === id) exitChatPreviewMode();
        if (editingChatId === id) editingChatId = null;
    }

    function enterChatPreviewMode(id) {
        previewOwnerChatId = id;
        previewPanel.classList.add('chat-mode');
        const parentBlock = document.querySelector('.channel-block[data-id="' + id + '"]');
        const parentTitle = parentBlock ? parentBlock.querySelector('.channel-title').textContent : '';
        previewExplainerText.textContent = parentTitle
            ? '"' + parentTitle + '" kanali uchun suhbat yaratilmoqda'
            : 'Suhbat yaratilmoqda — jonli ko‘rinish';
    }

    function exitChatPreviewMode() {
        previewOwnerChatId = null;
        previewPanel.classList.remove('chat-mode');
        previewExplainerText.textContent = 'Jonli ko‘rinish — kanalingiz shunday chiqadi';
        updatePreview();
        const checked = document.querySelector('input[name="visibility"]:checked');
        previewVisibility.textContent = (checked && checked.value === 'private') ? 'Yopiq kanal' : 'Ommaviy kanal';
        previewSubs.textContent = '0 obunachi';
    }

    function updateChatPreview(id) {
        const nameInput = document.getElementById('chatName-' + id);
        const usernameInput = document.getElementById('chatUsername-' + id);
        const bioInput = document.getElementById('chatBio-' + id);
        if (!nameInput) return;

        const name = nameInput.value.trim();
        const username = usernameInput.value.trim();
        const bio = bioInput.value.trim();
        const image = chatPhotoStore[id] || '';

        const pAvatar = document.getElementById('chatPreviewAvatar-' + id);
        const pName = document.getElementById('chatPreviewName-' + id);
        const pHandle = document.getElementById('chatPreviewHandle-' + id);
        const pDesc = document.getElementById('chatPreviewDesc-' + id);

        if (pAvatar) pAvatar.innerHTML = image ? '<img src="' + image + '" alt="Suhbat rasmi">' : (name ? escapeHTML(name.charAt(0).toUpperCase()) : '#');
        if (pName) {
            if (name) { pName.textContent = name; pName.classList.remove('placeholder'); }
            else { pName.textContent = 'Suhbat nomi'; pName.classList.add('placeholder'); }
        }
        if (pHandle) pHandle.textContent = 't.me/' + (username || (name ? slugify(name) : 'suhbat_username'));
        if (pDesc) {
            if (bio) { pDesc.textContent = bio; pDesc.classList.remove('placeholder'); }
            else { pDesc.textContent = 'Suhbat haqida qisqacha shu yerda ko‘rinadi.'; pDesc.classList.add('placeholder'); }
        }

        if (previewOwnerChatId === id) {
            if (image) previewAvatar.innerHTML = '<img src="' + image + '" alt="Suhbat rasmi">';
            else if (name) previewAvatar.textContent = name.charAt(0).toUpperCase();
            else previewAvatar.innerHTML = defaultAvatarSVG;

            if (name) { previewName.textContent = name; previewName.classList.remove('placeholder'); }
            else { previewName.textContent = 'Suhbat nomi'; previewName.classList.add('placeholder'); }

            previewHandle.textContent = 't.me/' + (username || (name ? slugify(name) : 'suhbat_username'));

            if (bio) { previewDesc.textContent = bio; previewDesc.classList.remove('placeholder'); }
            else { previewDesc.textContent = 'Suhbat tavsifi shu yerda ko‘rinadi.'; previewDesc.classList.add('placeholder'); }

            previewVisibility.textContent = 'Suhbat';
            previewSubs.textContent = '0 a\'zo';
        }
    }

    function chatFormTemplate(id) {
        return `
        <div class="chat-branch">
            <div class="chat-connector"></div>
            <div class="chat-card">
                <div class="chat-preview-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Yangi suhbat — qanday ko‘rinishini shu yerda kuzating
                </div>
                <div class="chat-preview">
                    <div class="chat-preview-avatar" id="chatPreviewAvatar-${id}">#</div>
                    <div class="chat-preview-info">
                        <div class="chat-preview-name-row">
                            <span class="chat-preview-name placeholder" id="chatPreviewName-${id}">Suhbat nomi</span>
                            <span class="chat-preview-handle" id="chatPreviewHandle-${id}">t.me/suhbat_username</span>
                        </div>
                        <p class="chat-preview-desc placeholder" id="chatPreviewDesc-${id}">Suhbat haqida qisqacha shu yerda ko‘rinadi.</p>
                    </div>
                    <div class="chat-preview-tag">Suhbat</div>
                </div>

                <div class="chat-fields">
                    <div class="chat-form-row">
                        <div class="chat-avatar-upload">
                            <label class="chat-mini-avatar" for="chatPhoto-${id}" title="Suhbat rasmini yuklash">
                                <span class="chat-mini-avatar-inner" id="chatAvatarInner-${id}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="13" r="3.4"/><path d="M4 8.5A1.5 1.5 0 0 1 5.5 7h1.8l1-2h7.4l1 2h1.8A1.5 1.5 0 0 1 20 8.5V18a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 4 18Z"/></svg>
                                </span>
                                <span class="chat-mini-plus">+</span>
                            </label>
                            <button type="button" class="chat-mini-upload-btn" onclick="document.getElementById('chatPhoto-${id}').click()">Rasm yuklash</button>
                        </div>
                        <input type="file" id="chatPhoto-${id}" accept="image/*" hidden onchange="handleChatPhoto('${id}', this)">
                        <div class="chat-field">
                            <input type="text" class="chat-mini-input" id="chatName-${id}" placeholder="Suhbat nomi" maxlength="64" oninput="updateChatPreview('${id}')">
                        </div>
                    </div>
                    <div class="chat-form-row">
                        <div class="chat-field chat-field-username" style="margin-left:76px">
                            <span class="chat-username-prefix">t.me/</span>
                            <input type="text" class="chat-mini-input chat-username-input" id="chatUsername-${id}" placeholder="suhbat_username" maxlength="32" oninput="this.value=this.value.replace(/[^a-zA-Z0-9_]/g,''); updateChatPreview('${id}')">
                        </div>
                    </div>
                    <textarea class="chat-mini-bio" id="chatBio-${id}" maxlength="255" placeholder="Suhbat haqida qisqacha..." oninput="updateChatPreview('${id}')"></textarea>
                </div>
                <div class="chat-mini-actions">
                    <button type="button" class="chat-mini-btn secondary" data-action="cancel-chat">Bekor qilish</button>
                    <button type="button" class="chat-mini-btn primary" data-action="submit-chat">Suhbat yaratish</button>
                </div>
            </div>
        </div>`;
    }

    function handleChatPhoto(id, input) {
        const file = input.files[0];
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            chatPhotoStore[id] = e.target.result;
            const inner = document.getElementById('chatAvatarInner-' + id);
            if (inner) inner.innerHTML = '<img src="' + e.target.result + '" alt="Suhbat rasmi">';
            updateChatPreview(id);
        };
        reader.readAsDataURL(file);
    }

    function submitChat(id) {
        const nameInput = document.getElementById('chatName-' + id);
        const usernameInput = document.getElementById('chatUsername-' + id);
        const bioInput = document.getElementById('chatBio-' + id);
        const name = nameInput.value.trim();

        if (!name) { nameInput.focus(); showToast('Avval suhbat nomini kiriting.'); return; }

        chatStore[id] = {
            name: name,
            username: usernameInput.value.trim() || slugify(name),
            bio: bioInput.value.trim(),
            image: chatPhotoStore[id] || '',
            createdAt: editingChatId === id && chatStore[id]
                ? chatStore[id].createdAt
                : new Date().toISOString()
        };
        chatOpen[id] = true;
        exitChatPreviewMode();
        renderChatBranch(id);

        updateChannelChat(id, {
            name: chatStore[id].name,
            username: chatStore[id].username,
            image: chatStore[id].image,
            bio: chatStore[id].bio
        });

        const block = document.querySelector('.channel-block[data-id="' + id + '"]');
        const backendId = block && block.dataset.backendId;
        const chatPayload = {
                chat_name: chatStore[id].name,
                chat_username: chatStore[id].username,
                chat_avatar: chatStore[id].image || null,
                chat_description: chatStore[id].bio || null,
                chat_created_at: chatStore[id].createdAt
        };
        if (!backendId) {
            showToast('Kanal hali bazaga saqlanmadi. Avval kanalni yarating.');
            return;
        }

        persistChat(chatPayload, backendId)
            .then(function () {
                editingChatId = null;
                showToast('Suhbat ma’lumotlari saqlandi.');
            })
            .catch(function () { showToast('Suhbat bazaga saqlanmadi. Qayta urinib ko‘ring.'); });

        if (editingChatId !== id) showToast('Suhbat yaratildi.');
    }

    function renderChatBranch(id) {
        const slot = document.getElementById('chatSlot-' + id);
        if (!slot) return;
        slot.dataset.formOpen = '0';

        const data = chatStore[id];
        if (!data || !chatOpen[id]) { slot.innerHTML = ''; return; }

        const avatarHTML = data.image ? '<img src="' + data.image + '" alt="Suhbat">' : data.name.charAt(0).toUpperCase();

        slot.innerHTML = `
        <div class="chat-branch">
            <div class="chat-connector"></div>
            <div class="chat-item">
                <div class="channel-image">${avatarHTML}</div>
                <div class="channel-content">
                    <div class="channel-title-row">
                        <h3 class="channel-title">${escapeHTML(data.name)}</h3>
                        <div class="status"></div>
                    </div>
                    <p class="channel-handle">t.me/${escapeHTML(data.username)}</p>
                    <p class="channel-created">${icoClock} Yaratilgan: ${formatTashkentTime(new Date(data.createdAt))} (UZ vaqti)</p>
                </div>
                <div class="chat-tag">Suhbat</div>
                <button type="button" class="chat-more" data-action="toggle-chat-menu" aria-label="Suhbat amallari">⋮</button>
            </div>
        </div>`;
    }

    function resetForm() {
        channelName.value = '';
        channelUsername.value = '';
        channelDescription.value = '';
        channelPhoto.value = '';
        selectedImage = '';
        descriptionCount.textContent = '0 / 255';
        mainAvatar.innerHTML = defaultAvatarSVG;
        updatePreview();
    }

    cancelButton.addEventListener('click', function () {
        editingChannelName = null;
        editingChannelClientId = null;
        editingChannelMeta = null;
        createButton.querySelector('.btn-label').textContent = 'Kanal yaratish';
        resetForm();
        showToast('Maydonlar tozalandi.');
    });

    persistedEntities.slice().reverse().forEach(renderPersistedChannel);
    if (persistedEntities.length) {
        const oldEmpty = document.getElementById('emptyState');
        if (oldEmpty) oldEmpty.remove();
        channelCount.textContent = persistedEntities.length;
    }
    updatePreview();
    updateChannelVisibility();
</script>

<script>
(function () {
    var dict = {
        uz: {
            channelCreateTitle: 'Kanal yaratish', channelCreateSubtitle: 'Yangi kanal oching, unga nom, rasm va tavsif qo‘shing, obunachilaringiz uchun ochiq yoki maxsus havola bilan yopiq qilib sozlang va bir necha soniyada ulashishni boshlang.', backToChatovbs: 'Chatovbsga qaytish', optionalLabel: 'Ixtiyoriy', requiredLabel: 'Majburiy', channelPhotoLabel: 'Kanal rasmi', channelPhotoTitle: 'Kanal rasmini tanlang', channelPhotoHint: 'JPG, PNG yoki WEBP formatida rasm yuklang.', uploadPhotoBtn: 'Rasm yuklash', channelNameLabel: 'Kanal nomi', channelDescriptionLabel: 'Kanal haqida', channelTypeTitle: 'Kanal turi', publicChannelTitle: 'Ommaviy kanal', publicChannelHint: 'Hamma kanalni topishi mumkin.', privateChannelTitle: 'Yopiq kanal', privateChannelHint: 'Faqat havola orqali qo‘shiladi.', channelLinkLabel: 'Havola', cancelBtn: 'Bekor qilish', createChannelBtn: 'Kanal yaratish', yourChannelsTitle: 'Kanallaringiz', yourChannelsSubtitle: 'Siz yaratgan barcha kanallar', noChannelsTitle: 'Hali kanal yo‘q', noChannelsText: 'Birinchi kanalingizni yarating — shu yerda paydo bo‘ladi.', previewChannelText: 'Jonli ko‘rinish — kanalingiz shunday chiqadi', previewChannelName: 'Kanal nomi', previewChannelDesc: 'Kanal tavsifi shu yerda ko‘rinadi.', previewVisibilityPublicChannel: 'Ommaviy kanal'
        },
        ru: {
            channelCreateTitle: 'Создать канал', channelCreateSubtitle: 'Создайте новый канал, добавьте название, фото и описание, настройте открытый или закрытый доступ по ссылке и начните публикации за несколько минут.', backToChatovbs: 'Вернуться в Chatovbs', optionalLabel: 'Необязательно', requiredLabel: 'Обязательно', channelPhotoLabel: 'Фото канала', channelPhotoTitle: 'Выберите фото канала', channelPhotoHint: 'Загрузите изображение в JPG, PNG или WEBP.', uploadPhotoBtn: 'Загрузить фото', channelNameLabel: 'Название канала', channelDescriptionLabel: 'О канале', channelTypeTitle: 'Тип канала', publicChannelTitle: 'Публичный канал', publicChannelHint: 'Все могут найти канал.', privateChannelTitle: 'Закрытый канал', privateChannelHint: 'Подписаться можно только по ссылке.', channelLinkLabel: 'Ссылка', cancelBtn: 'Отмена', createChannelBtn: 'Создать канал', yourChannelsTitle: 'Ваши каналы', yourChannelsSubtitle: 'Все каналы, которые вы создали', noChannelsTitle: 'Пока нет каналов', noChannelsText: 'Создайте свой первый канал — он появится здесь.', previewChannelText: 'Предпросмотр — так будет выглядеть ваш канал', previewChannelName: 'Название канала', previewChannelDesc: 'Описание канала будет отображаться здесь.', previewVisibilityPublicChannel: 'Публичный канал'
        },
        en: {
            channelCreateTitle: 'Create channel', channelCreateSubtitle: 'Create a new channel, add a name, photo, and description, choose whether it is open or restricted via link, and start publishing in minutes.', backToChatovbs: 'Back to Chatovbs', optionalLabel: 'Optional', requiredLabel: 'Required', channelPhotoLabel: 'Channel photo', channelPhotoTitle: 'Choose channel photo', channelPhotoHint: 'Upload JPG, PNG, or WEBP image.', uploadPhotoBtn: 'Upload photo', channelNameLabel: 'Channel name', channelDescriptionLabel: 'About the channel', channelTypeTitle: 'Channel type', publicChannelTitle: 'Public channel', publicChannelHint: 'Anyone can find it.', privateChannelTitle: 'Private channel', privateChannelHint: 'Only invited users can join via link.', channelLinkLabel: 'Link', cancelBtn: 'Cancel', createChannelBtn: 'Create channel', yourChannelsTitle: 'Your channels', yourChannelsSubtitle: 'All channels you created', noChannelsTitle: 'No channels yet', noChannelsText: 'Create your first channel — it will appear here.', previewChannelText: 'Live preview — this is how your channel will look', previewChannelName: 'Channel name', previewChannelDesc: 'Channel description appears here.', previewVisibilityPublicChannel: 'Public channel'
        },
        ko: {
            channelCreateTitle: '채널 만들기', channelCreateSubtitle: '새 채널을 만들고 이름, 사진, 소개를 추가하고 공개 여부와 링크를 설정한 뒤 몇 분 안에 게시를 시작하세요.', backToChatovbs: 'Chatovbs로 돌아가기', optionalLabel: '선택', requiredLabel: '필수', channelPhotoLabel: '채널 사진', channelPhotoTitle: '채널 사진 선택', channelPhotoHint: 'JPG, PNG 또는 WEBP 이미지를 업로드하세요.', uploadPhotoBtn: '사진 업로드', channelNameLabel: '채널 이름', channelDescriptionLabel: '채널 소개', channelTypeTitle: '채널 유형', publicChannelTitle: '공개 채널', publicChannelHint: '모든 사용자가 찾을 수 있습니다.', privateChannelTitle: '비공개 채널', privateChannelHint: '초대 링크를 통해서만 가입할 수 있습니다.', channelLinkLabel: '링크', cancelBtn: '취소', createChannelBtn: '채널 만들기', yourChannelsTitle: '내 채널', yourChannelsSubtitle: '내가 만든 모든 채널', noChannelsTitle: '아직 채널이 없습니다', noChannelsText: '첫 번째 채널을 만들면 여기에 표시됩니다.', previewChannelText: '실시간 미리보기 — 채널이 이렇게 보입니다', previewChannelName: '채널 이름', previewChannelDesc: '채널 설명이 여기에 표시됩니다.', previewVisibilityPublicChannel: '공개 채널'
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