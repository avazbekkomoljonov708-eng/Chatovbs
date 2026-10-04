@php
    $us = \App\Support\UserSettings::for(auth()->user());

    $accents = [
        'default' => ['#e0a83e', '#1c1206'], 'amber' => ['#e0a83e', '#1c1206'],
        'teal' => ['#2dd4bf', '#06201c'], 'blue' => ['#4b9bea', '#06172c'],
        'violet' => ['#a78bfa', '#1a1330'], 'rose' => ['#f472b6', '#2b0e1c'],
        'green' => ['#34d399', '#06231a'],
    ];
    if ($us['accent_color'] === 'custom') {
        $hex = ltrim($us['accent_custom_color'], '#');
        $lum = (0.299 * hexdec(substr($hex, 0, 2)) + 0.587 * hexdec(substr($hex, 2, 2)) + 0.114 * hexdec(substr($hex, 4, 2))) / 255;
        $accent = $us['accent_custom_color'];
        $accentInk = $lum > 0.55 ? '#171310' : '#ffffff';
    } else {
        list($accent, $accentInk) = $accents[$us['accent_color']] ?? $accents['default'];
    }

    $gradients = [
        'sunset' => 'linear-gradient(155deg,#ff9966,#ff5e62 45%,#3a1c71)',
        'mint' => 'linear-gradient(155deg,#0f2027,#203a43,#2dd4bf)',
        'dusk' => 'linear-gradient(155deg,#232526,#414345)',
        'berry' => 'linear-gradient(155deg,#8e2de2,#4a00e0)',
        'forest' => 'linear-gradient(155deg,#134e5e,#71b280)',
        'amber' => 'linear-gradient(155deg,#f7971e,#e0a83e 60%,#8a5a12)',
        'ocean' => 'linear-gradient(155deg,#1c92d2,#f2fcfe)',
        'mono' => 'linear-gradient(155deg,#3a3a34,#141410)',
        'candy' => 'linear-gradient(155deg,#f6d365,#fda085)',
        'night' => 'linear-gradient(155deg,#0f0c29,#302b63,#24243e)',
        'lime' => 'linear-gradient(155deg,#a8e063,#56ab2f)',
        'rose' => 'linear-gradient(155deg,#f472b6,#7c3aed)',
    ];
    $angles = ['v' => '180deg', 'd' => '155deg', 'h' => '90deg'];

    $wpBg = 'none';
    $wpVideo = null;
    if ($us['wallpaper_type'] === 'gradient') {
        $wpBg = $gradients[$us['wallpaper_gradient']] ?? $gradients['sunset'];
    } elseif ($us['wallpaper_type'] === 'color') {
        $t = $us['wallpaper_color']; $m = $us['wallpaper_color_mid']; $b = $us['wallpaper_color_bottom'];
        $wpBg = $us['wallpaper_color_style'] === 'r'
            ? "radial-gradient(circle at 50% 25%, $t, $m 55%, $b)"
            : 'linear-gradient(' . ($angles[$us['wallpaper_color_style']] ?? '180deg') . ", $t, $m, $b)";
    } elseif ($us['wallpaper_type'] === 'image' && $us['wallpaper_image_path']) {
        $wpBg = "url('" . Storage::disk('public')->url($us['wallpaper_image_path']) . "') center/cover no-repeat";
    } elseif ($us['wallpaper_type'] === 'video' && $us['wallpaper_video_path']) {
        $wpVideo = Storage::disk('public')->url($us['wallpaper_video_path']);
    }

    $clientSettings = [
        'theme' => $us['theme'],
        'time24' => (bool) $us['time_format_24h'],
        'dateFormat' => $us['date_format'],
        'language' => $us['language'],
        'enterToSend' => (bool) $us['enter_to_send'],
        'quiet' => [
            'enabled' => (bool) $us['quiet_hours_enabled'],
            'start' => $us['quiet_hours_start'],
            'end' => $us['quiet_hours_end'],
            'message' => $us['quiet_hours_message'],
        ],
        'wallpaper' => [
            'video' => $wpVideo,
            'x' => (int) $us['wallpaper_video_x'],
            'y' => (int) $us['wallpaper_video_y'],
            'blur' => (bool) $us['wallpaper_blur'],
            'hasLayer' => $wpBg !== 'none' || $wpVideo !== null,
        ],
        'notif' => [
            'notifications' => (bool) $us['notifications'], 'sound' => (bool) $us['sound'],
            'notif_preview' => (bool) $us['notif_preview'], 'notif_show_sender' => (bool) $us['notif_show_sender'],
            'notif_show_avatar' => (bool) $us['notif_show_avatar'], 'notif_system' => (bool) $us['notif_system'],
            'group_notifications' => (bool) $us['group_notifications'],
            'notif_position' => $us['notif_position'], 'notif_style' => $us['notif_style'],
            'notif_duration' => (int) $us['notif_duration'],
        ],
    ];
@endphp

<style>
    :root { --accent: {{ $accent }}; --accent-ink: {{ $accentInk }}; }
    .msg-bubble, .saved-message-bubble { font-size: {{ (int) $us['font_size'] }}px; }
    @if ($us['density'] === 'compact')
        .msg-row { margin-bottom: 3px; }
        .msg-bubble { padding: 6px 11px 5px; }
        .cm-messages { gap: 1px; }
    @endif
    @if ($clientSettings['wallpaper']['hasLayer'])
        .cm-messages, .cm-messages.saved-view { background: transparent !important; }
        .cm-header, .cm-messages, .cm-composer,
        .pinned-banner, .selection-toolbar, .rec-indicator, .open-chat-bar { position: relative; z-index: 1; }
        .wp-layer { position: absolute; inset: 0; z-index: 0; background: {!! $wpBg !!}; pointer-events: none; overflow: hidden; }
        .wp-layer.blurred { filter: blur(3px) brightness(.85); transform: scale(1.05); }
        .wp-layer video { width: 100%; height: 100%; object-fit: cover; }
    @endif
    .quiet-banner { display: none; align-items: center; gap: 10px; padding: 10px 18px; background: #fbf3e0; color: #171817; font-size: 13px; border-top: 1px solid var(--line-soft); position: relative; z-index: 1; }
    .quiet-banner.show { display: flex; }
</style>

<script>
(function () {
    var S = @json($clientSettings);
    window.CHATOVBS_SETTINGS = S;

    // Keep server-side quiet-hours checks aligned with the user's local clock.
    if (!window.__chatovbsTimezoneFetchWrapped && window.fetch && window.Intl) {
        var nativeFetch = window.fetch;
        window.fetch = function (input, init) {
            try {
                var requestUrl = typeof input === 'string' ? input : input.url;
                if (new URL(requestUrl, window.location.href).origin === window.location.origin) {
                    var requestHeaders = new Headers(init && init.headers ? init.headers : (input instanceof Request ? input.headers : undefined));
                    requestHeaders.set('X-Client-Timezone', Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC');
                    init = Object.assign({}, init || {}, { headers: requestHeaders });
                }
            } catch (e) {}
            return nativeFetch.call(this, input, init);
        };
        window.__chatovbsTimezoneFetchWrapped = true;
    }

    // ---- tema: serverdagi qiymat bilan sinxronlash ----
    try {
        var sysLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
        if (S.theme === 'system') localStorage.setItem('chatovbs_night_mode', sysLight ? '0' : '1');
        else if (localStorage.getItem('chatovbs_night_mode') === null) localStorage.setItem('chatovbs_night_mode', S.theme === 'dark' ? '1' : '0');
        localStorage.setItem('chatovbs_notif_prefs', JSON.stringify(S.notif));
    } catch (e) {}

    // ---- chat foni ----
    var main = document.querySelector('.chat-main');
    if (main && S.wallpaper.hasLayer) {
        var layer = document.createElement('div');
        layer.className = 'wp-layer' + (S.wallpaper.blur ? ' blurred' : '');
        if (S.wallpaper.video) {
            var v = document.createElement('video');
            v.src = S.wallpaper.video; v.autoplay = true; v.loop = true; v.muted = true; v.playsInline = true;
            v.style.objectPosition = S.wallpaper.x + '% ' + S.wallpaper.y + '%';
            layer.appendChild(v);
        }
        main.insertBefore(layer, main.firstChild);
    }

    // ---- Enter bilan yuborish ----
    var input = document.getElementById('msgInput');
    if (input && !S.enterToSend) {
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') e.stopImmediatePropagation();
        }, true);
    }

})();
</script> 