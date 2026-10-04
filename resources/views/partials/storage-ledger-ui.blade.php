<script>
(function () {
    var CS = window.ChatStorage;
    if (!CS) return;
    var $ = function (id) { return document.getElementById(id); };
    var state = { category: null, kind: 'all', search: '', sort: 'size', open: null, tab: 'all', limit: 60 };
    var summary;
    var icons = {
        images: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8" cy="8" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg>',
        videos: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2"></rect></svg>',
        files: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6v20h12V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>',
        audio: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>',
        voice: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path></svg>'
    };
    var colors = { xls:'#16a34a', xlsx:'#16a34a', csv:'#16a34a', pdf:'#e5484d', doc:'#3b82f6', docx:'#3b82f6', txt:'#3b82f6', ppt:'#f97316', pptx:'#f97316', zip:'#e9a23b', rar:'#e9a23b', '7z':'#e9a23b' };
    var kinds = { personal:'Lichka', channel:'Kanal', group:'Guruh', saved:'Saqlangan' };
    function esc(v) { return String(v == null ? '' : v).replace(/[&<>"']/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }
    function category(k) { return CS.CATS.filter(function (x) { return x.key === k; })[0]; }
    function renderRing() {
        var r = 48, circumference = Math.PI * 2 * r, offset = 0;
        var svg = '<circle class="bg" cx="60" cy="60" r="' + r + '"></circle>';
        if (summary.total) CS.CATS.forEach(function (c) {
            var size = summary.cats[c.key].size;
            if (!size) return;
            var len = Math.max(2, size / summary.total * circumference - 3);
            svg += '<circle cx="60" cy="60" r="' + r + '" stroke="' + c.color + '" stroke-dasharray="' + len + ' ' + (circumference-len) + '" stroke-dashoffset="' + (-offset) + '"></circle>';
            offset += size / summary.total * circumference;
        });
        $('sgRing').innerHTML = svg;
        $('sgTotal').textContent = CS.fmt(summary.total);
        $('sgCount').textContent = summary.count + ' ta fayl';
    }
    function renderCategories() {
        $('sgCats').innerHTML = CS.CATS.map(function (c) {
            var d = summary.cats[c.key], pct = summary.total ? Math.round(d.size / summary.total * 100) : 0;
            return '<button type="button" class="sg-cat' + (state.category === c.key ? ' active' : '') + '" data-category="' + c.key + '" style="--c:' + c.color + '"><span class="sg-cat__ic">' + icons[c.key] + '</span><b>' + CS.fmt(d.size) + '</b><span>' + c.label + ' · ' + d.count + ' ta</span><em>' + pct + '%</em></button>';
        }).join('');
    }
    function renderChat(chat) {
        var avatar = chat.kind === 'saved'
        ? '<span class="sg-av" style="background:#4b9bea;display:flex;align-items:center;justify-content:center"><svg viewBox="0 0 24 24" style="width:24px;height:24px;display:block;flex:none;fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg></span>'
            : chat.avatar ? '<span class="sg-av" style="background:' + esc(chat.color || '#555') + '"><img src="' + esc(chat.avatar) + '" alt=""></span>'
            : '<span class="sg-av" style="background:' + esc(chat.color || '#555') + '">' + esc((chat.name || '?').charAt(0).toUpperCase()) + '</span>';
        var stack = CS.CATS.map(function (c) { var size = chat.cats[c.key].size; return size && chat.total ? '<i title="' + c.label + ': ' + CS.fmt(size) + '" style="width:' + (size / chat.total * 100) + '%;background:' + c.color + '"></i>' : ''; }).join('');
        var items = chat.items.filter(function (it) { return state.tab === 'all' || it.cat === state.tab; }).sort(function (a,b) { return new Date(b.t)-new Date(a.t); });
        var shown = items.slice(0, state.limit), images = shown.filter(function (it) { return it.cat === 'images'; });
        var body = '<div class="sg-tabs"><button class="sg-tab' + (state.tab === 'all' ? ' active' : '') + '" data-tab="all">Hammasi · ' + chat.count + '</button>';
        CS.CATS.forEach(function (c) { if (chat.cats[c.key].count) body += '<button type="button" class="sg-tab' + (state.tab === c.key ? ' active' : '') + '" data-tab="' + c.key + '">' + c.label + ' · ' + chat.cats[c.key].count + '</button>'; });
        body += '</div>';
        if (images.length) body += '<div class="sg-grid">' + images.map(function (it) { return '<a class="sg-thumb" href="' + esc(it.u) + '" target="_blank" rel="noopener" title="' + esc(it.n) + '"><img loading="lazy" src="' + esc(it.u) + '" alt=""><span>' + (it.s > 0 ? CS.fmt(it.s) : '—') + '</span></a>'; }).join('') + '</div>';
        var others = shown.filter(function (it) { return it.cat !== 'images'; });
        if (others.length) body += '<div class="sg-files">' + others.map(function (it) {
            var ext = CS.extOf(it.n), meta = category(it.cat), ico = it.cat === 'files' && ext ? '<span class="sg-file__ic" style="background:' + (colors[ext] || '#7a8a9e') + '">' + esc(ext) + '</span>' : '<span class="sg-file__ic" style="background:' + meta.color + '">' + icons[it.cat] + '</span>';
            var date = new Date(it.t), dateText = isNaN(date) ? '' : (' · ' + date.toLocaleDateString());
            var duration = it.d ? ' · ' + Math.floor(it.d/60) + ':' + ('0'+(it.d%60)).slice(-2) : '';
            return '<a class="sg-file" href="' + esc(it.u) + '" target="_blank" rel="noopener" download="' + esc(it.n) + '">' + ico + '<span class="sg-file__t"><b>' + esc(it.n) + '</b><span>' + (it.s > 0 ? CS.fmt(it.s) : '—') + duration + dateText + '</span></span><span class="sg-file__ok">✓ Yuklab olingan</span></a>';
        }).join('') + '</div>';
        if (!shown.length) body += '<div class="sg-empty">Bu turda fayl yo\'q.</div>';
        if (items.length > shown.length) body += '<button type="button" class="btn-ghost sg-more" data-more>Yana ' + (items.length-shown.length) + ' ta ko\'rsatish</button>';
        return '<div class="sg-src' + (state.open === chat.key ? ' open' : '') + '" data-key="' + esc(chat.key) + '"><button class="sg-src__head" type="button">' + avatar + '<span><span class="sg-src__name"><span class="n">' + esc(chat.name) + '</span><span class="sg-badge">' + esc(kinds[chat.kind] || '') + '</span></span><span class="sg-src__meta" style="display:block">' + chat.count + ' ta fayl</span></span><span class="sg-stack">' + stack + '</span><span class="sg-size">' + CS.fmt(state.category ? chat.cats[state.category].size : chat.total) + '</span><svg class="sg-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>' + (state.open === chat.key ? '<div class="sg-src__body">' + body + '</div>' : '') + '</div>';
    }
    function render() {
        summary = CS.summary();
        renderRing(); renderCategories();
        var q = state.search.trim().toLowerCase();
        var rows = summary.chats.filter(function (chat) {
            return (state.kind === 'all' || chat.kind === state.kind) && (!q || (chat.name || '').toLowerCase().indexOf(q) !== -1) && (!state.category || chat.cats[state.category].count);
        }).sort(function (a,b) {
            if (state.sort === 'name') return (a.name || '').localeCompare(b.name || '');
            if (state.sort === 'count') return b.count - a.count;
            return (state.category ? b.cats[state.category].size-a.cats[state.category].size : b.total-a.total);
        });
        $('sgList').innerHTML = rows.length ? rows.map(renderChat).join('') : '<div class="sg-empty">' + (summary.count ? 'Hech narsa topilmadi.' : 'Hozircha media fayllar yo\'q. Chatlarda rasm, video yoki fayl paydo bo\'lgach, shu yerda hisoblanadi.') + '</div>';
       $('stCacheLabel').textContent = CS.fmt(CS.cacheBytes()) + ' Tozalash';
    }
    $('sgCats').addEventListener('click', function (e) { var b=e.target.closest('[data-category]'); if(!b)return; state.category=state.category===b.dataset.category?null:b.dataset.category; state.tab=state.category||'all'; render(); });
    $('sgSearch').addEventListener('input', function(){state.search=this.value;render();});
    $('sgSort').addEventListener('change', function(){state.sort=this.value;render();});
    $('sgKinds').addEventListener('change', function(e){state.kind=e.target.value;render();});
    $('sgList').addEventListener('click', function(e){
        var more=e.target.closest('[data-more]'); if(more){state.limit+=60;render();return;}
        var tab=e.target.closest('[data-tab]'); if(tab){state.tab=tab.dataset.tab;state.limit=60;render();return;}
        var head=e.target.closest('.sg-src__head'); if(head){var key=head.parentNode.dataset.key;state.open=state.open===key?null:key;state.tab=state.category||'all';state.limit=60;render();}
    });
   var scan=$('sgRescan');
scan.addEventListener('click',function(){scan.classList.add('is-busy');$('sgRescanText').textContent='Hisoblanmoqda…';CS.scanAll().then(function(){scan.classList.remove('is-busy');$('sgRescanText').textContent='Qayta hisoblash';render();});});
$('stClearCache').addEventListener('click', function () { CS.clearCache(); alert('Kesh tozalandi.'); });
window.addEventListener('chatovbs:storage',render);
render(); CS.scanAll().then(render);
})();
</script>
