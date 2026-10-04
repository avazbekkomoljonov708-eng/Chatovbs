<script>
(function () {
    if (window.ChatStorage) return;
    var UID = {{ (int) auth()->id() }};
    var KEY = 'chatovbs_storage_v1_' + UID;
    var CACHE_RE = /^chatovbs_(search_history_|recent_users_|recent_emojis_|user_place|profile_gallery)/;
    var URLS = {
        chatList: "{{ url('/chat-list') }}",
        messages: "{{ url('/messages') }}",
        entity: "{{ url('/entity-messages') }}",
        discussion: "{{ url('/entity-chats') }}",
        saved: "{{ url('/saved-messages/data') }}"
    };
    var CATS = [
        { key: 'images', label: 'Rasmlar',  color: '#4b9bea' },
        { key: 'videos', label: 'Videolar', color: '#f59e0b' },
        { key: 'files',  label: 'Fayllar',  color: '#34d399' },
        { key: 'audio',  label: 'Musiqa',   color: '#a78bfa' },
        { key: 'voice',  label: 'Ovozli',   color: '#f472b6' }
    ];

    var data = load(), saveTimer = null, scanning = null;

    function load() {
        try { var d = JSON.parse(localStorage.getItem(KEY) || 'null'); if (d && d.chats) return d; } catch (e) {}
        return { v: 1, chats: {} };
    }
    function saveNow() {
        try { localStorage.setItem(KEY, JSON.stringify(data)); } catch (e) {}
        window.dispatchEvent(new CustomEvent('chatovbs:storage'));
    }
    function scheduleSave() { clearTimeout(saveTimer); saveTimer = setTimeout(saveNow, 400); }

    function catOf(it) {
        if (it.v) return 'voice';
        var m = it.m || '';
        if (m.indexOf('image/') === 0) return 'images';
        if (m.indexOf('video/') === 0) return 'videos';
        if (m.indexOf('audio/') === 0) return 'audio';
        return 'files';
    }
    function extOf(name) {
        var p = String(name || '').split('.');
        return p.length > 1 ? p.pop().toLowerCase().slice(0, 5) : '';
    }
    function fmt(b) {
        b = Number(b) || 0;
        if (b <= 0) return '0 MB';
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b / 1024).toFixed(b < 10240 ? 1 : 0) + ' KB';
        if (b < 1073741824) return (b / 1048576).toFixed(b < 10485760 ? 1 : 0) + ' MB';
        return (b / 1073741824).toFixed(2) + ' GB';
    }
    function sameOrigin(u) {
        try { return new URL(u, location.href).origin === location.origin; } catch (e) { return false; }
    }

    function norm(m) {
        if (!m || m.id === undefined || m.id === null) return null;
        var sid = String(m.id);
        if (sid.indexOf('tmp-') === 0 || sid.indexOf('local-') === 0) return null;
        var fileUrl = m.file_url || m.fileUrl, audioUrl = m.audio_url || m.audioUrl;
        var url = fileUrl || audioUrl;
        if (!url || String(url).indexOf('blob:') === 0) return null;
        var isVoice = !fileUrl && !!audioUrl;
        return {
            id: (m.is_channel_post ? 'p' : 'm') + sid,
            u: url,
            n: m.file_name || m.fileName || (isVoice ? 'Ovozli xabar' : 'Fayl'),
            m: m.file_mime || m.fileMime || (isVoice ? 'audio/webm' : ''),
            s: Number(m.file_size || m.fileSize) || 0,
            t: m.created_at || m.createdAt || new Date().toISOString(),
            v: isVoice,
            d: Number(m.audio_duration || m.duration) || 0
        };
    }

    function ensureChat(desc) {
        var c = data.chats[desc.key];
        if (!c) c = data.chats[desc.key] = { items: {} };
        if (desc.name) c.name = desc.name;
        c.kind = desc.kind || c.kind || 'personal';
        if (desc.color) c.color = desc.color;
        if (desc.avatar) c.avatar = desc.avatar;
        return c;
    }
    function recordMessage(desc, m) {
        var it = norm(m);
        if (!it || !desc || !desc.key) return;
        var c = ensureChat(desc);
        if (c.items[it.id]) return;
        c.items[it.id] = it;
        scheduleSave();
    }
    // Xabar o'chirilganda hisobdan ham olib tashlash
    function removeMessage(chatKey, itemId) {
        var c = data.chats[chatKey];
        if (c && c.items[itemId]) { delete c.items[itemId]; scheduleSave(); }
    }

    function getJson(url) {
        return fetch(url, { headers: { 'Accept': 'application/json' } }).then(function (r) {
            if (!r.ok) throw new Error(); return r.json();
        });
    }
    function pool(jobs, n) {
        var i = 0;
        function next() {
            if (i >= jobs.length) return Promise.resolve();
            var j = jobs[i++];
            return j().then(next, next);
        }
        var w = []; for (var k = 0; k < n; k++) w.push(next());
        return Promise.all(w);
    }
    function src(a) {
        if (!a) return '';
        return (a.indexOf('data:') === 0 || a.indexOf('http') === 0 || a.charAt(0) === '/') ? a : '/storage/' + a;
    }

    function scanAll() {
        if (scanning) return scanning;
        var planned = {};
        scanning = getJson(URLS.chatList).then(function (list) {
            var jobs = [];
            function job(desc, url, skipPosts) {
                planned[desc.key] = true;
                jobs.push(function () {
                    return getJson(url).then(function (res) {
                        var c = ensureChat(desc), fresh = {};
                        (res.messages || []).forEach(function (m) {
                            if (skipPosts && m.is_channel_post) return;
                            var it = norm(m);
                            if (!it) return;
                            var old = c.items[it.id];
                            if (!it.s && old && old.s) it.s = old.s;   // oldin aniqlangan hajmni saqlab qolamiz
                            fresh[it.id] = it;
                        });
                        c.items = fresh;   // serverdagi holat asosiy: o'chirilganlar yo'qoladi
                    });
                });
            }
            job({ key: 's', name: 'Saqlangan xabarlar', kind: 'saved', color: '#4b9bea' }, URLS.saved);
            (list.chats || []).forEach(function (c) {
                var u = c.user || {};
                job({ key: 'u:' + u.id, name: u.name || u.username || u.email || 'Foydalanuvchi', kind: 'personal',
                      color: '#6b6b5c', avatar: u.avatar ? '/storage/' + u.avatar : '' }, URLS.messages + '/' + u.id);
            });
            (list.entities || []).forEach(function (e) {
                if (e.type === 'chat') {
                    job({ key: 'e:' + e.id + ':chat', name: e.name, kind: 'group', color: '#d99d32', avatar: src(e.avatar) }, URLS.discussion + '/' + e.id, true);
                    return;
                }
                job({ key: 'e:' + e.id + ':channel', name: e.name, kind: e.type === 'group' ? 'group' : 'channel',
                      color: '#079f94', avatar: src(e.avatar) }, URLS.entity + '/' + e.id);
                if (e.chat_name) {
                    job({ key: 'e:' + e.id + ':chat', name: e.chat_name, kind: 'group', color: '#d99d32', avatar: src(e.chat_avatar) },
                         URLS.discussion + '/' + e.id, true);
                }
            });
            return pool(jobs, 3).then(function () {
                // Endi mavjud bo'lmagan chatlar (chiqib ketilgan / o'chirilgan) hisobdan ketadi
                Object.keys(data.chats).forEach(function (k) { if (!planned[k]) delete data.chats[k]; });
            });
        }).then(function () {
            saveNow();
            return resolveSizes();
        }).catch(function () {}).then(function () { scanning = null; });
        return scanning;
    }

    function resolveSizes() {
        var todo = [];
        Object.keys(data.chats).forEach(function (k) {
            var items = data.chats[k].items;
            Object.keys(items).forEach(function (id) {
                var it = items[id];
                if (it.s !== 0) return;
                if (!sameOrigin(it.u)) { it.s = -1; return; }   // tashqi (Giphy) — CORS sabab o'lchab bo'lmaydi
                if (todo.length < 60) todo.push(it);
            });
        });
        if (!todo.length) return Promise.resolve();
        return pool(todo.map(function (it) {
            return function () {
                return fetch(it.u, { method: 'HEAD' }).then(function (r) {
                    var len = Number(r.headers.get('content-length'));
                    it.s = len > 0 ? len : -1;
                }).catch(function () { it.s = -1; });
            };
        }), 3).then(saveNow);
    }

    function summary() {
        var out = { total: 0, count: 0, cats: {}, chats: [] };
        CATS.forEach(function (c) { out.cats[c.key] = { size: 0, count: 0 }; });
        Object.keys(data.chats).forEach(function (key) {
            var c = data.chats[key], row = { key: key, name: c.name || "Noma'lum", kind: c.kind, color: c.color, avatar: c.avatar,
                                             total: 0, count: 0, cats: {}, items: [] };
            CATS.forEach(function (k) { row.cats[k.key] = { size: 0, count: 0 }; });
            Object.keys(c.items).forEach(function (id) {
                var it = c.items[id], cat = catOf(it), size = it.s > 0 ? it.s : 0;
                it.cat = cat;
                row.items.push(it);
                row.cats[cat].size += size; row.cats[cat].count++;
                row.total += size; row.count++;
                out.cats[cat].size += size; out.cats[cat].count++;
                out.total += size; out.count++;
            });
            if (row.count) out.chats.push(row);
        });
        return out;
    }

    // Kesh: tugma matni va "Tozalash" bir xil kalitlar bilan ishlaydi
    function cacheKeys() {
        try { return Object.keys(localStorage).filter(function (k) { return CACHE_RE.test(k); }); } catch (e) { return []; }
    }
    function cacheBytes() {
        var n = 0;
        cacheKeys().forEach(function (k) { n += (k.length + (localStorage.getItem(k) || '').length) * 2; });
        return n;
    }
    function clearCache() {
        cacheKeys().forEach(function (k) { localStorage.removeItem(k); });
        if (window.caches) caches.keys().then(function (ks) { ks.forEach(function (k) { caches.delete(k); }); });
        window.dispatchEvent(new CustomEvent('chatovbs:storage'));
    }

    window.ChatStorage = {
        CATS: CATS, fmt: fmt, catOf: catOf, extOf: extOf,
        summary: summary, scanAll: scanAll, recordMessage: recordMessage, removeMessage: removeMessage,
        cacheBytes: cacheBytes, clearCache: clearCache,
        clear: function () { data = { v: 1, chats: {} }; saveNow(); },
        key: KEY
    };
})();
</script>