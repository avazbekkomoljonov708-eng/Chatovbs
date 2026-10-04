{{-- ==========================================================================
     YANGILIKLAR BO'LIMI (v5) — resources/views/partials/whatsnew-section.blade.php
     settings.blade.php ichida:  @include('partials.whatsnew-section')
     Barcha klasslar "wy-" bilan boshlanadi — eski "wn-" klasslar bilan to'qnashmaydi.
     v5: 1.0.1 ga YANGI "Jonli efir" (Efir) bo'limi qo'shildi:
         Efirni boshlash, Efirni rejalashtirish, "... bilan efir".
         Katta chiroyli karta + animatsiyali efir ko'rinishi + savol-javob.
     ========================================================================== --}}

<style>
#sec-whatsnew { min-height: calc(100vh - 62px - 120px); }
:root { --wy-blue: #4b9bea; --wy-blue-soft: rgba(75,155,234,.14); --wy-amber: #f0b56b; --wy-amber-soft: rgba(224,168,62,.14); --wy-amber-line: rgba(224,168,62,.35); --wy-live: #ff4d5e; --wy-live-soft: rgba(255,77,94,.14); --wy-live-line: rgba(255,77,94,.38); }
#setPage.theme-light { --wy-amber: #a96a0c; --wy-amber-soft: rgba(224,168,62,.18); --wy-amber-line: rgba(169,106,12,.4); --wy-live: #d62839; --wy-live-soft: rgba(214,40,57,.1); --wy-live-line: rgba(214,40,57,.35); }

/* ---- Hozirgi versiya ---- */
.wy-now { display: flex; align-items: center; gap: 16px; padding: 20px; margin-bottom: 26px; border: 1px solid var(--line); border-radius: var(--radius-lg); background: var(--ink-soft); }
.wy-now__icon { width: 50px; height: 50px; border-radius: 14px; background: var(--accent); color: var(--accent-ink); display: grid; place-items: center; flex-shrink: 0; }
.wy-now__icon svg { width: 24px; height: 24px; stroke: currentColor; fill: none; }
.wy-now__text { flex: 1; min-width: 0; }
.wy-now__text strong { display: block; font: 800 16px 'Sora', sans-serif; }
.wy-now__text span { display: block; margin-top: 4px; font-size: 12.5px; line-height: 1.55; color: var(--muted-on-dark); }
.wy-ver { flex-shrink: 0; padding: 7px 14px; border-radius: 999px; font: 800 13px 'Sora', sans-serif; background: var(--accent-soft); color: var(--paper); border: 1px solid var(--line); }

/* ---- Katta sarlavha: keyingi versiya ---- */
.wy-next { margin-bottom: 8px; }
.wy-next__head { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.wy-next__head h4 { margin: 0; font: 800 22px 'Sora', sans-serif; letter-spacing: -.02em; }
.wy-soon { display: inline-flex; align-items: center; gap: 7px; padding: 5px 12px; border-radius: 999px; font-size: 11.5px; font-weight: 700; color: var(--teal); background: rgba(45,212,191,.12); border: 1px solid rgba(45,212,191,.3); }
.wy-soon i { width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: setPulse 1.6s ease-in-out infinite; }
.wy-next__lead { max-width: 660px; margin: 10px 0 0; font-size: 13.5px; line-height: 1.65; color: var(--muted-on-dark); }
.wy-next__lead b { color: var(--paper); font-weight: 700; }

.wy-group { margin: 28px 0 12px; display: flex; align-items: baseline; gap: 10px; }
.wy-group h5 { margin: 0; font: 800 14px 'Sora', sans-serif; }
.wy-group span { font-size: 12px; color: var(--muted-on-dark); }

/* ---- Kartalar ---- */
.wy-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.wy-card { display: flex; flex-direction: column; gap: 14px; padding: 16px; border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink-soft); transition: border-color .15s ease; }
.wy-card:hover { border-color: var(--muted-on-dark); }
.wy-card--blue:hover { border-color: var(--wy-blue); }
.wy-card h6 { margin: 0; font: 800 15px 'Sora', sans-serif; }
.wy-card p { margin: 6px 0 0; font-size: 12.5px; line-height: 1.6; color: var(--muted-on-dark); }
.wy-card__ex { margin-top: auto; padding: 10px 12px; border-radius: var(--radius-sm); background: var(--ink-softer); font-size: 11.5px; line-height: 1.5; color: var(--muted-on-dark); }
.wy-card__ex b { color: var(--paper); font-weight: 700; }
.wy-state { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; color: var(--muted-on-dark); }
.wy-state svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }

/* yangi bo'lim: menyudagidek qator */
.wy-menurow { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 12px; background: var(--ink); border: 1px solid var(--line); }
.wy-menurow svg { width: 22px; height: 22px; stroke: var(--wy-blue); fill: none; flex-shrink: 0; }
.wy-menurow b { font-size: 14px; font-weight: 600; }
.wy-menurow em { margin-left: auto; font-style: normal; font-size: 10px; font-weight: 800; color: var(--wy-blue); background: var(--wy-blue-soft); padding: 3px 8px; border-radius: 999px; }

/* yaxshilanish: ikonka plitkasi */
.wy-ico { width: 44px; height: 44px; border-radius: 12px; display: grid; place-items: center; background: var(--accent-soft); color: var(--accent); }
.wy-ico svg { width: 22px; height: 22px; stroke: currentColor; fill: none; }

/* =====================================================================
   JONLI EFIR (YANGI)
   ===================================================================== */
.wy-live { position: relative; overflow: hidden; padding: 22px; border: 1px solid var(--wy-live-line); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--wy-live-soft), var(--ink-soft) 62%); }
.wy-live::before { content: ''; position: absolute; top: -90px; right: -70px; width: 260px; height: 260px; border-radius: 50%; background: radial-gradient(circle, var(--wy-live-soft), transparent 68%); pointer-events: none; }
.wy-live__top { position: relative; display: flex; align-items: flex-start; gap: 16px; }
.wy-live__ico { width: 52px; height: 52px; border-radius: 15px; flex-shrink: 0; display: grid; place-items: center; background: var(--wy-live); color: #fff; box-shadow: 0 0 0 6px var(--wy-live-soft); }
.wy-live__ico svg { width: 25px; height: 25px; stroke: currentColor; fill: none; }
.wy-live__text { flex: 1; min-width: 0; }
.wy-live__text h6 { margin: 0; font: 800 17px 'Sora', sans-serif; line-height: 1.35; }
.wy-live__text p { margin: 7px 0 0; max-width: 620px; font-size: 12.5px; line-height: 1.65; color: var(--muted-on-dark); }
.wy-live__text p b { color: var(--paper); font-weight: 700; }
.wy-new { display: inline-flex; align-items: center; gap: 6px; margin-left: 8px; padding: 3px 10px; border-radius: 999px; font: 800 10.5px 'Inter', sans-serif; vertical-align: middle; font-style: normal; white-space: nowrap; color: var(--wy-live); background: var(--wy-live-soft); border: 1px solid var(--wy-live-line); }
.wy-new i { width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: setPulse 1.4s ease-in-out infinite; }

.wy-live__body { position: relative; display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(0, 1fr); gap: 20px; margin-top: 20px; align-items: stretch; }

/* efir ko'rinishi (namuna) */
.wy-stage { position: relative; display: flex; flex-direction: column; justify-content: space-between; gap: 16px; min-height: 250px; padding: 16px; border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--line); background: linear-gradient(160deg, #1a1220, #0b0b12 60%, #0a1a1c); color: #f5f4ef; }
.wy-stage::after { content: ''; position: absolute; left: 50%; bottom: -60px; width: 240px; height: 160px; margin-left: -120px; border-radius: 50%; background: radial-gradient(circle, rgba(255,77,94,.28), transparent 70%); pointer-events: none; }
.wy-stage__bar { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
.wy-badge-live { display: inline-flex; align-items: center; gap: 7px; padding: 5px 11px; border-radius: 999px; font: 800 11px 'Inter', sans-serif; letter-spacing: .06em; background: #ff4d5e; color: #fff; }
.wy-badge-live i { width: 7px; height: 7px; border-radius: 50%; background: #fff; animation: wyBlink 1.1s ease-in-out infinite; }
.wy-listeners { display: inline-flex; align-items: center; gap: 6px; padding: 5px 11px; border-radius: 999px; font-size: 11.5px; font-weight: 700; background: rgba(255,255,255,.1); backdrop-filter: blur(6px); }
.wy-listeners svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }
.wy-stage__mid { position: relative; z-index: 1; text-align: center; }
.wy-stage__title { margin: 0; font: 800 15px 'Sora', sans-serif; }
.wy-stage__sub { margin: 4px 0 0; font-size: 11.5px; opacity: .65; }
.wy-wave { display: flex; align-items: center; justify-content: center; gap: 4px; height: 44px; margin-top: 14px; }
.wy-wave i { display: block; width: 4px; border-radius: 3px; background: linear-gradient(180deg, #ff7a88, #ff4d5e); animation: wyEq 1.1s ease-in-out infinite; }
.wy-wave i:nth-child(1) { animation-delay: -.9s; } .wy-wave i:nth-child(2) { animation-delay: -.7s; } .wy-wave i:nth-child(3) { animation-delay: -.5s; }
.wy-wave i:nth-child(4) { animation-delay: -.3s; } .wy-wave i:nth-child(5) { animation-delay: -.1s; } .wy-wave i:nth-child(6) { animation-delay: -.6s; }
.wy-wave i:nth-child(7) { animation-delay: -.4s; } .wy-wave i:nth-child(8) { animation-delay: -.8s; } .wy-wave i:nth-child(9) { animation-delay: -.2s; }
.wy-wave i:nth-child(10) { animation-delay: -.65s; } .wy-wave i:nth-child(11) { animation-delay: -.35s; } .wy-wave i:nth-child(12) { animation-delay: -.15s; }
.wy-stage__foot { position: relative; z-index: 1; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
.wy-avs { display: flex; }
.wy-avs span { width: 28px; height: 28px; margin-left: -8px; border-radius: 50%; border: 2px solid #12121a; display: grid; place-items: center; font: 800 10.5px 'Sora', sans-serif; color: #fff; }
.wy-avs span:first-child { margin-left: 0; }
.wy-avs span:nth-child(1) { background: #4b9bea; } .wy-avs span:nth-child(2) { background: #a78bfa; } .wy-avs span:nth-child(3) { background: #34d399; } .wy-avs span:nth-child(4) { background: rgba(255,255,255,.18); }
.wy-stage__btns { display: flex; gap: 8px; }
.wy-stage__btns span { width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center; background: rgba(255,255,255,.12); }
.wy-stage__btns span.end { background: #ff4d5e; }
.wy-stage__btns svg { width: 15px; height: 15px; stroke: #fff; fill: none; }

/* menyu qatorlari */
.wy-opts { display: flex; flex-direction: column; gap: 10px; }
.wy-opt { display: flex; align-items: flex-start; gap: 13px; padding: 14px; border-radius: var(--radius-md); background: var(--ink); border: 1px solid var(--line); transition: border-color .15s ease, transform .15s ease; }
.wy-opt:hover { border-color: var(--wy-live-line); transform: translateX(3px); }
.wy-opt__ico { width: 40px; height: 40px; border-radius: 12px; flex-shrink: 0; display: grid; place-items: center; background: var(--wy-live-soft); color: var(--wy-live); }
.wy-opt__ico svg { width: 20px; height: 20px; stroke: currentColor; fill: none; }
.wy-opt__txt { min-width: 0; }
.wy-opt__txt b { display: block; font-size: 13.5px; font-weight: 700; }
.wy-opt__txt span { display: block; margin-top: 3px; font-size: 12px; line-height: 1.55; color: var(--muted-on-dark); }
.wy-opt__ex { display: inline-block; margin-top: 7px; padding: 4px 9px; border-radius: 8px; background: var(--ink-softer); font-size: 11px; color: var(--muted-on-dark); }
.wy-opt__ex b { display: inline; font-size: inherit; color: var(--paper); }

.wy-live__foot { position: relative; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin-top: 18px; padding-top: 16px; border-top: 1px solid var(--wy-live-line); }
.wy-live__tags { display: flex; flex-wrap: wrap; gap: 8px; }
.wy-live__tags span { display: inline-flex; align-items: center; gap: 6px; padding: 5px 11px; border-radius: 999px; font-size: 11.5px; font-weight: 700; color: var(--muted-on-dark); background: var(--ink-softer); }
.wy-live__tags svg { width: 12px; height: 12px; stroke: var(--teal); fill: none; stroke-width: 3; }

@keyframes wyEq { 0%, 100% { height: 8px; } 50% { height: 40px; } }
@keyframes wyBlink { 0%, 100% { opacity: 1; } 50% { opacity: .25; } }

/* ---- Ma'lum kamchilik kartasi (Bildirishnomalar) ---- */
.wy-fixcard { grid-column: 1 / -1; position: relative; overflow: hidden; padding: 20px; border: 1px solid var(--wy-amber-line); border-radius: var(--radius-lg); background: linear-gradient(135deg, var(--wy-amber-soft), var(--ink-soft) 65%); }
.wy-fixcard__top { display: flex; align-items: flex-start; gap: 16px; }
.wy-fixcard__ico { width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0; display: grid; place-items: center; background: #e0a83e; color: #1c1206; }
.wy-fixcard__ico svg { width: 24px; height: 24px; stroke: currentColor; fill: none; }
.wy-fixcard__text { flex: 1; min-width: 0; }
.wy-fixcard__text h6 { margin: 0; font: 800 16px 'Sora', sans-serif; line-height: 1.35; }
.wy-fixcard__text p { margin: 7px 0 0; max-width: 620px; font-size: 12.5px; line-height: 1.65; color: var(--muted-on-dark); }
.wy-fixcard__text p b { color: var(--paper); font-weight: 700; }
.wy-fix { display: inline-flex; align-items: center; gap: 6px; margin-left: 8px; padding: 3px 10px; border-radius: 999px; font: 800 10.5px 'Inter', sans-serif; vertical-align: middle; color: var(--wy-amber); background: var(--wy-amber-soft); border: 1px solid var(--wy-amber-line); font-style: normal; white-space: nowrap; }
.wy-fix i { width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: setPulse 1.6s ease-in-out infinite; }

.wy-steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-top: 18px; }
.wy-step { display: flex; align-items: center; gap: 11px; padding: 12px 13px; border-radius: var(--radius-sm); background: var(--ink); border: 1px solid var(--line); }
.wy-step__dot { width: 26px; height: 26px; border-radius: 50%; flex-shrink: 0; display: grid; place-items: center; background: var(--ink-softer); color: var(--muted-on-dark); }
.wy-step__dot svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 3; }
.wy-step__txt { min-width: 0; }
.wy-step__txt b { display: block; font-size: 12.5px; font-weight: 700; }
.wy-step__txt span { display: block; margin-top: 2px; font-size: 11px; color: var(--muted-on-dark); }
.wy-step.is-done .wy-step__dot { background: var(--teal); color: var(--teal-ink); }
.wy-step.is-done .wy-step__txt span { color: var(--teal); font-weight: 700; }
.wy-step.is-work { border-color: var(--wy-amber-line); background: var(--wy-amber-soft); }
.wy-step.is-work .wy-step__dot { background: #e0a83e; color: #1c1206; }
.wy-step.is-work .wy-step__dot svg { animation: wySpin 2.4s linear infinite; }
.wy-step.is-work .wy-step__txt span { color: var(--wy-amber); font-weight: 700; }
@keyframes wySpin { to { transform: rotate(360deg); } }

.wy-fixcard__foot { display: flex; align-items: flex-start; gap: 9px; margin-top: 14px; font-size: 11.5px; line-height: 1.55; color: var(--muted-on-dark); }
.wy-fixcard__foot svg { width: 15px; height: 15px; stroke: var(--teal); fill: none; flex-shrink: 0; margin-top: 1px; }

/* ---- Ekranlar yonma-yon ---- */
.wy-devices { display: flex; align-items: flex-end; gap: 14px; padding: 18px 18px 0; border-radius: var(--radius-md); background: var(--ink-softer); overflow: hidden; }
.wy-dev { position: relative; border: 2px solid var(--line-soft); border-bottom: none; border-radius: 10px 10px 0 0; background: var(--ink); }
.wy-dev i { position: absolute; height: 6px; border-radius: 3px; background: var(--line-soft); }
.wy-dev i.me { background: var(--accent); }
.wy-dev--phone { width: 48px; height: 78px; }
.wy-dev--phone i:nth-child(1) { top: 12px; left: 7px; width: 55%; }
.wy-dev--phone i:nth-child(2) { top: 26px; right: 7px; width: 38%; }
.wy-dev--phone i:nth-child(3) { top: 40px; left: 7px; width: 48%; }
.wy-dev--tablet { width: 104px; height: 70px; }
.wy-dev--tablet::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 32%; border-right: 1px solid var(--line-soft); }
.wy-dev--tablet i:nth-child(1) { top: 12px; left: 38%; width: 40%; }
.wy-dev--tablet i:nth-child(2) { top: 26px; right: 8px; width: 28%; }
.wy-dev--tablet i:nth-child(3) { top: 40px; left: 38%; width: 34%; }
.wy-dev--pc { width: 150px; height: 84px; }
.wy-dev--pc::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 22%; border-right: 1px solid var(--line-soft); }
.wy-dev--pc i:nth-child(1) { top: 14px; left: 28%; width: 38%; }
.wy-dev--pc i:nth-child(2) { top: 28px; right: 10px; width: 26%; }
.wy-dev--pc i:nth-child(3) { top: 42px; left: 28%; width: 32%; }
.wy-devices__cap { margin: 8px 0 0; font-size: 12px; color: var(--muted-on-dark); }

/* ---- Hozir nimalar bor ---- */
.wy-have { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.wy-have > div { display: flex; align-items: flex-start; gap: 11px; padding: 13px 14px; border-radius: var(--radius-sm); background: var(--ink-softer); border: 1px solid transparent; }
.wy-have > div.is-fixing { border-color: var(--wy-amber-line); background: var(--wy-amber-soft); }
.wy-have > div svg { width: 16px; height: 16px; stroke: var(--teal); fill: none; stroke-width: 3; flex-shrink: 0; margin-top: 2px; }
.wy-have > div.is-fixing svg { stroke: var(--wy-amber); }
.wy-have strong { display: block; font-size: 13px; font-weight: 700; }
.wy-have span { display: block; margin-top: 2px; font-size: 11.5px; line-height: 1.5; color: var(--muted-on-dark); }
.wy-have strong .wy-fix { margin-left: 8px; padding: 2px 8px; font-size: 9.5px; }

/* ---- Savol-javob ---- */
.wy-faq { display: flex; flex-direction: column; gap: 8px; }
.wy-faq details { border: 1px solid var(--line); border-radius: var(--radius-md); background: var(--ink-soft); }
.wy-faq details[open] { border-color: var(--accent); }
.wy-faq summary { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; cursor: pointer; list-style: none; font-size: 13.5px; font-weight: 700; }
.wy-faq summary::-webkit-details-marker { display: none; }
.wy-faq summary svg { width: 16px; height: 16px; stroke: var(--muted-on-dark); fill: none; transition: transform .2s ease; flex-shrink: 0; }
.wy-faq details[open] summary svg { transform: rotate(180deg); }
.wy-faq summary:focus-visible { outline: 2px solid var(--accent); outline-offset: -2px; border-radius: var(--radius-md); }
.wy-faq p { margin: 0; padding: 0 16px 16px; font-size: 12.5px; line-height: 1.65; color: var(--muted-on-dark); }
.wy-faq p b { color: var(--paper); font-weight: 700; }

.wy-note { display: flex; align-items: flex-start; gap: 9px; margin-top: 16px; padding: 12px 14px; border-radius: var(--radius-sm); background: var(--ink-softer); font-size: 11.5px; line-height: 1.55; color: var(--muted-on-dark); }
.wy-note svg { width: 15px; height: 15px; stroke: var(--accent); fill: none; flex-shrink: 0; margin-top: 1px; }

@media (max-width: 1100px) { .wy-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 960px) { .wy-live__body { grid-template-columns: 1fr; } }
@media (max-width: 860px) {
    .wy-grid, .wy-have, .wy-steps { grid-template-columns: 1fr; }
    .wy-now { flex-wrap: wrap; }
    .wy-fixcard__top, .wy-live__top { flex-direction: column; }
}
@media (prefers-reduced-motion: reduce) {
    .wy-step.is-work .wy-step__dot svg, .wy-fix i, .wy-soon i, .wy-new i, .wy-badge-live i { animation: none; }
    .wy-wave i { animation: none; height: 22px; }
}
</style>

<section class="set-section" id="sec-whatsnew">
    <div class="set-section__head">
        <span class="set-section__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3 1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9Z"></path><path d="M19 3v4M17 5h4"></path></svg></span>
        <div><h3>ChatO'VBS yangiliklari</h3><p>Hozir qaysi versiyadasiz, ilovada nimalar bor va yaqin orada nimalar qo'shilishini shu yerdan bilib olasiz.</p></div>
    </div>

    {{-- ============ 1) Hozirgi versiya ============ --}}
    <div class="wy-now">
        <span class="wy-now__icon"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path><path d="m9 12 2 2 4-4"></path></svg></span>
        <div class="wy-now__text">
            <strong>Sizda eng so'nggi versiya o'rnatilgan</strong>
            <span>Hozircha yangilash shart emas. Yangi versiya chiqqanda shu yerda e'lon qilamiz.</span>
        </div>
        <span class="wy-ver">v1.0.0</span>
    </div>

    {{-- ============ 2) Keyingi versiya ============ --}}
    <div class="wy-next">
        <div class="wy-next__head">
            <h4>Versiya 1.0.1</h4>
            <span class="wy-soon"><i></i>Tez orada</span>
        </div>
        <p class="wy-next__lead">Keyingi yangilanishda ilovaga <b>jonli efir</b> (onlayn efir) va <b>3 ta yangi bo'lim</b> (Kontaktlar, Qo'ng'iroqlar, Hamyon) qo'shiladi. Shuningdek, rasm va videolar bilan ishlash yaxshilanadi, <b>bildirishnomalar</b> asosiy chatda to'liq ishlaydi, ilova esa <b>telefon va planshetda</b> ham qulay bo'ladi.</p>
    </div>

    {{-- ============ JONLI EFIR ============ --}}
    <div class="wy-group"><h5>Jonli efir (onlayn efir)</h5><span>Kanal va guruhlarda, yuqoridagi efir tugmasi orqali</span></div>
    <div class="wy-live">
        <div class="wy-live__top">
            <span class="wy-live__ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.8" fill="currentColor" stroke="none"></circle><path d="M8.2 9.8a5.5 5.5 0 0 0 0 4.4"></path><path d="M15.8 9.8a5.5 5.5 0 0 1 0 4.4"></path><path d="M5 6.5a9.5 9.5 0 0 0 0 11"></path><path d="M19 6.5a9.5 9.5 0 0 1 0 11"></path></svg></span>
            <div class="wy-live__text">
                <h6>Jonli efirda obunachilar bilan bevosita gaplashing <em class="wy-new"><i></i>Yangi</em></h6>
                <p>Kanal yoki guruh sahifasining yuqorisida efir tugmasi bor. Uni bosib <b>jonli efir</b> boshlaysiz, obunachilar esa uni shu zahoti eshitadi va ko'radi. Xabar yozib kutib o'tirish shart emas, savollarga joyida javob berasiz.</p>
            </div>
        </div>

        <div class="wy-live__body">
            {{-- Efir ko'rinishi (namuna) --}}
            <div class="wy-stage" aria-hidden="true">
                <div class="wy-stage__bar">
                    <span class="wy-badge-live"><i></i>JONLI</span>
                    <span class="wy-listeners"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"></path><circle cx="12" cy="12" r="3"></circle></svg>128 tinglovchi</span>
                </div>
                <div class="wy-stage__mid">
                    <p class="wy-stage__title">Kechki suhbat</p>
                    <p class="wy-stage__sub">Savol-javob · 24 daqiqadan beri</p>
                    <div class="wy-wave"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
                </div>
                <div class="wy-stage__foot">
                    <div class="wy-avs"><span>A</span><span>S</span><span>M</span><span>+9</span></div>
                    <div class="wy-stage__btns">
                        <span><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path></svg></span>
                        <span class="end"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                    </div>
                </div>
            </div>

            {{-- 3 ta imkoniyat (menyudagidek) --}}
            <div class="wy-opts">
                <div class="wy-opt">
                    <span class="wy-opt__ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="currentColor" stroke="none"></polygon></svg></span>
                    <span class="wy-opt__txt">
                        <b>Efirni boshlash</b>
                        <span>Bir bosishda hozirning o'zida jonli efirga chiqasiz. Obunachilarga efir boshlangani haqida xabar boradi.</span>
                        <span class="wy-opt__ex"><b>Misol:</b> yangilik bor, darhol hammaga aytmoqchisiz.</span>
                    </span>
                </div>
                <div class="wy-opt">
                    <span class="wy-opt__ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15 14"></polyline></svg></span>
                    <span class="wy-opt__txt">
                        <b>Efirni rejalashtirish</b>
                        <span>Efir vaqtini oldindan belgilaysiz. Obunachilar sanani ko'radi va efir boshlanishidan oldin eslatma oladi.</span>
                        <span class="wy-opt__ex"><b>Misol:</b> ertaga soat 20:00 da darsni jonli o'tkazasiz.</span>
                    </span>
                </div>
                <div class="wy-opt">
                    <span class="wy-opt__ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1.6" fill="currentColor" stroke="none"></circle><path d="M8.2 9.8a5.5 5.5 0 0 0 0 4.4"></path><path d="M15.8 9.8a5.5 5.5 0 0 1 0 4.4"></path><path d="M5 6.5a9.5 9.5 0 0 0 0 11"></path><path d="M19 6.5a9.5 9.5 0 0 1 0 11"></path></svg></span>
                    <span class="wy-opt__txt">
                        <b>... bilan efir</b>
                        <span>Boshqa odamni mehmon sifatida efirga chaqirasiz va ikkalangiz birga gaplashasiz.</span>
                        <span class="wy-opt__ex"><b>Misol:</b> mutaxassisni taklif qilib, intervyu o'tkazasiz.</span>
                    </span>
                </div>
            </div>
        </div>

        <div class="wy-live__foot">
            <div class="wy-live__tags">
                <span><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>Kanallarda</span>
                <span><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>Guruhlarda</span>
                <span><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>Tinglovchilar soni</span>
                <span><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>Eslatma</span>
            </div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>
    </div>

    {{-- Yangi bo'limlar --}}
    <div class="wy-group"><h5>Menyuga yangi bo'limlar qo'shiladi</h5><span>Chap menyuda mana shunday ko'rinadi</span></div>
    <div class="wy-grid">
        <div class="wy-card wy-card--blue">
            <div class="wy-menurow">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <b>Kontaktlar</b><em>YANGI</em>
            </div>
            <div>
                <h6>Kontaktlar</h6>
                <p>Tanish-bilishlaringiz bitta ro'yxatda turadi. Kerakli odamni nomi bo'yicha topib, shu zahoti unga yozishingiz mumkin.</p>
            </div>
            <div class="wy-card__ex"><b>Misol:</b> do'stingizni qidirasiz, bosasiz va chat ochiladi.</div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>

        <div class="wy-card wy-card--blue">
            <div class="wy-menurow">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"></path></svg>
                <b>Qo'ng'iroqlar</b><em>YANGI</em>
            </div>
            <div>
                <h6>Qo'ng'iroqlar</h6>
                <p>Yozishdan tashqari, ilova ichidan to'g'ridan-to'g'ri qo'ng'iroq qilish va o'tgan qo'ng'iroqlaringiz tarixini ko'rish imkoni bo'ladi.</p>
            </div>
            <div class="wy-card__ex"><b>Misol:</b> yozishga vaqt yo'q bo'lsa, bir bosishda qo'ng'iroq qilasiz.</div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>

        <div class="wy-card wy-card--blue">
            <div class="wy-menurow">
                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                <b>Hamyon</b><em>YANGI</em>
            </div>
            <div>
                <h6>Hamyon</h6>
                <p>Hisobingiz va to'lovlaringiz ilova ichidagi alohida bo'limda turadi. Boshqa ilovaga o'tib yurish shart bo'lmaydi.</p>
            </div>
            <div class="wy-card__ex"><b>Eslatma:</b> aniq imkoniyatlar tayyor bo'lgach shu yerda yozib qo'yiladi.</div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>
    </div>

    {{-- Yaxshilanishlar --}}
    <div class="wy-group"><h5>Mavjud narsalar yaxshilanadi</h5><span>Allaqachon bor imkoniyatlar qulayroq bo'ladi</span></div>
    <div class="wy-grid">

        {{-- Ma'lum kamchilik: Bildirishnomalar --}}
        <div class="wy-fixcard">
            <div class="wy-fixcard__top">
                <span class="wy-fixcard__ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg></span>
                <div class="wy-fixcard__text">
                    <h6>Bildirishnomalar asosiy chatda to'liq ishlaydi <em class="wy-fix"><i></i>Tuzatilmoqda</em></h6>
                    <p>Sozlamalarda bildirishnomani o'zingizga moslab, <b>sinab ko'rishingiz</b> mumkin. Lekin tanlagan joylashuv, uslub, turish vaqti va ovoz hozircha <b>asosiy chat oynasida to'liq qo'llanmaydi</b>. Bu kamchilikni bilamiz va 1.0.1 da tuzatamiz: yangi xabar kelganda aynan siz tanlagandek chiqadi.</p>
                </div>
            </div>

            <div class="wy-steps">
                <div class="wy-step is-done">
                    <span class="wy-step__dot"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                    <span class="wy-step__txt"><b>Sozlamalar sahifasi</b><span>Tayyor</span></span>
                </div>
                <div class="wy-step is-done">
                    <span class="wy-step__dot"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg></span>
                    <span class="wy-step__txt"><b>Sinab ko'rish</b><span>Tayyor</span></span>
                </div>
                <div class="wy-step is-work">
                    <span class="wy-step__dot"><svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.22-8.56"></path></svg></span>
                    <span class="wy-step__txt"><b>Asosiy chatda ishlashi</b><span>Tuzatilmoqda</span></span>
                </div>
            </div>

            <p class="wy-fixcard__foot">
                <svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Tanlovlaringiz saqlanib turadi. Yangilanishdan keyin qayta sozlash shart emas.</span>
            </p>
        </div>

        <div class="wy-card">
            <span class="wy-ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="M21 15l-5-5L5 21"></path></svg></span>
            <div>
                <h6>Yangi media tizimi</h6>
                <p>Rasm, video va fayllarni yuborish, ko'rish hamda saqlash yangilanadi. Ular tezroq yuklanadi va chatda toza ko'rinadi.</p>
            </div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>

        <div class="wy-card">
            <span class="wy-ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></span>
            <div>
                <h6>Telefon uchun ko'rinish</h6>
                <p>Ilova telefon ekraniga moslashadi. Chatlar, sozlamalar va menyular kichik ekranda ham qulay ochiladi.</p>
            </div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>

        <div class="wy-card">
            <span class="wy-ico"><svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></span>
            <div>
                <h6>Planshet uchun ko'rinish</h6>
                <p>O'rta ekranlarda chatlar ro'yxati va suhbat yonma-yon turadi, shuning uchun chatlar orasida o'tish osonlashadi.</p>
            </div>
            <span class="wy-state"><svg viewBox="0 0 24 24" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 15.5 14"></polyline></svg>Ishlanmoqda</span>
        </div>
    </div>

    {{-- Qurilmalar rasmi --}}
    <div style="margin-top:12px;">
        <div class="wy-devices">
            <div class="wy-dev wy-dev--phone"><i></i><i class="me"></i><i></i></div>
            <div class="wy-dev wy-dev--tablet"><i></i><i class="me"></i><i></i></div>
            <div class="wy-dev wy-dev--pc"><i></i><i class="me"></i><i></i></div>
        </div>
        <p class="wy-devices__cap">Bir xil ilova: telefonda, planshetda va kompyuterda. Ekran qanchalik katta bo'lsa, shunchalik ko'p narsa bir vaqtda ko'rinadi.</p>
    </div>

    <div class="wy-note">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <span>Bu rejalar ustida hozir ish ketmoqda. Chiqish vaqti va tarkibi o'zgarishi mumkin. Hammasi tayyor bo'lishi bilan shu bo'limda e'lon qilinadi.</span>
    </div>

    {{-- ============ 3) Hozir nimalar bor ============ --}}
    <div class="wy-group" style="margin-top:34px;"><h5>Versiya 1.0.0 da hozir nimalar bor</h5><span>Ilovaning birinchi chiqarilishi</span></div>
    <div class="set-card" style="margin:0;">
        <div class="wy-have">
            @foreach ([
                ["Ko'rinishni sozlash", "Qorong'i yoki yorug' tema, o'zingizga yoqqan rang va matn o'lchami."],
                ["Chat foni", "Gradient, bitta rang, o'z rasmingiz yoki video."],
                ["Bildirishnomalar", "Xabar ekranning qayerida, qanday ko'rinishda va qancha turishini sozlaysiz. Asosiy chatda to'liq ishlashi tuzatilmoqda.", true],
                ["Dam olish vaqti", "Belgilangan soatdan keyin yozishmalar yopiladi va eslatma chiqadi."],
                ["Maxfiylik va himoya", "Profilingizni kim ko'rishini belgilash va ikki bosqichli himoya."],
                ["Xotira va yuklash", "Ilova qancha joy olganini ko'rish, rasm va videolar o'zi yuklanishini sozlash."],
                ["4 ta til", "O'zbekcha, 한국어, Русский va English."],
                ["Sana va vaqt", "Sana va soat o'zingizga qulay ko'rinishda yoziladi."],
            ] as $item)
                <div class="{{ !empty($item[2]) ? 'is-fixing' : '' }}">
                    <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span style="margin:0;"><strong>{{ $item[0] }}@if (!empty($item[2]))<em class="wy-fix"><i></i>Tuzatilmoqda</em>@endif</strong><span>{{ $item[1] }}</span></span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- ============ 4) Savol-javob ============ --}}
    <div class="wy-group" style="margin-top:34px;"><h5>Ko'p so'raladigan savollar</h5></div>
    <div class="wy-faq">
        <details>
            <summary>Yangi versiya qachon chiqadi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Aniq sana hozircha belgilanmagan, chunki ishlar hali davom etmoqda. Versiya 1.0.1 tayyor bo'lishi bilan shu sahifada "Hozirgi" deb ko'rsatiladi.</p>
        </details>
        <details>
            <summary>Yangilanish uchun biror narsa qilishim kerakmi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Yo'q. Yangi versiya chiqqanda sizning sozlamalaringiz, chatlaringiz va tanlagan ranglaringiz o'zgarishsiz saqlanib qoladi.</p>
        </details>
        <details>
            <summary>Jonli efir nima va qayerda ochiladi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Efir — kanal yoki guruhdagi <b>jonli ovozli efir</b>. Hozir kanal sahifasining tepasida efir tugmasi ko'rinadi va bosilganda <b>Efirni boshlash</b>, <b>Efirni rejalashtirish</b> hamda <b>"... bilan efir"</b> menyusi chiqadi. Bu uch imkoniyat to'liq ishlashi 1.0.1 bilan boshlanadi. Hozircha ularni bossangiz "tez orada" oynasi ochiladi.</p>
        </details>
        <details>
            <summary>Efirni kim boshlay oladi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Efirni asosan kanal yoki guruh egasi boshlaydi. Obunachilar esa efirni tinglaydi va tinglovchilar soni yuqorida ko'rinib turadi. Aniq qoidalar tayyor bo'lgach shu yerda yozib qo'yamiz.</p>
        </details>
        <details>
            <summary>Kontaktlar, Qo'ng'iroqlar va Hamyon qayerda paydo bo'ladi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Ular chap tomondagi asosiy menyuda, "Hamyon", "Kontaktlar" va "Qo'ng'iroqlar" nomi bilan alohida qatorlar bo'lib chiqadi. Hozir ham menyuda ko'rinishi mumkin, lekin to'liq ishlashi 1.0.1 bilan boshlanadi.</p>
        </details>
        <details>
            <summary>Telefonda ishlatsam bo'ladimi? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Telefon va planshet uchun maxsus ko'rinish ustida ish ketmoqda. Hozircha ilova asosan kompyuter ekrani uchun mo'ljallangan, shuning uchun kichik ekranda ba'zi joylar noqulay bo'lishi mumkin.</p>
        </details>
        <details>
            <summary>Bildirishnoma sozlamalarim nega chatda ishlamayapti? <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></summary>
            <p>Sozlamalar sahifasida bildirishnomani <b>"Sinab ko'rish"</b> tugmasi orqali to'liq tekshirishingiz mumkin, lekin asosiy chat oynasi hali bu tanlovlarni to'liq o'qimaydi. Bu kamchilikni bilamiz va 1.0.1 da tuzatamiz. Tanlovlaringiz saqlanib turadi, qayta sozlash shart emas.</p>
        </details>
    </div>
</section>