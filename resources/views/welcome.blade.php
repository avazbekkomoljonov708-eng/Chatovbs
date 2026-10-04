<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatO'VBS — matnli, ovozli va fayl xabarlar bitta joyda</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=5">
    <meta name="description" content="ChatO'VBS — umumiy suhbatlar, shaxsiy yozishmalar, kanallar, guruhlar, ovozli xabarlar va O'zbekistonning 14 ta viloyati bo'yicha alohida chat xonalari.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root{
            --bg:#000000;
            --bg-panel:#111111;
            --bg-panel-2:#161616;
            --bg-scrim: rgba(0,0,0,.86);
            --fg:#ffffff;
            --fg-soft:#f4f4f2;
            --muted:#8f8f8f;
            --muted-2:#5c5c5c;
            --line: rgba(255,255,255,.14);
            --line-strong: rgba(255,255,255,.28);
            --invert-bg:#f4f4f2;
            --invert-fg:#0a0a0a;
            --invert-muted:#5c5c5c;
            --invert-line: rgba(0,0,0,.14);
            --header-h:76px;
        }
        html[data-theme="light"]{
            --bg:#f7f6f2;
            --bg-panel:#ffffff;
            --bg-panel-2:#eeece5;
            --bg-scrim: rgba(247,246,242,.88);
            --fg:#0a0a0a;
            --fg-soft:#111111;
            --muted:#68675f;
            --muted-2:#9c9b93;
            --line: rgba(10,10,10,.12);
            --line-strong: rgba(10,10,10,.26);
            --invert-bg:#0a0a0a;
            --invert-fg:#f7f6f2;
            --invert-muted:#9c9b93;
            --invert-line: rgba(255,255,255,.14);
        }
        *{box-sizing:border-box;}
        html{scroll-behavior:smooth;}
        body{
            margin:0;
            background:var(--bg);
            color:var(--fg);
            font-family:'Inter',sans-serif;
            line-height:1.6;
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
            transition:background .35s ease, color .35s ease;
        }
        h1,h2,h3{font-family:'Space Grotesk',sans-serif; margin:0; letter-spacing:-.01em; font-weight:600;}
        p{margin:0;}
        a{color:inherit; text-decoration:none;}
        ::selection{background:var(--fg); color:var(--bg);}
        .mono{font-family:'JetBrains Mono',monospace;}

        .wrap{max-width:1140px; margin:0 auto; padding:0 28px;}
        a:focus-visible, button:focus-visible{outline:2px solid var(--fg); outline-offset:3px;}

        /* ---------- progress ---------- */
        .progress{position:fixed; top:0; left:0; height:2px; width:0%; background:var(--fg); z-index:110; transition:width .1s linear, background .3s ease;}

        /* ---------- header ---------- */
        .site-header{
            position:fixed; top:0; left:0; right:0; z-index:100;
            padding:18px 0; background:transparent; border-bottom:1px solid transparent;
            transition:transform .3s ease, background .3s ease, border-color .3s ease, padding .25s ease;
        }
        .site-header.scrolled{
            background:var(--bg-scrim); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
            border-color:var(--line); padding:13px 0;
        }
        .site-header.hide{transform:translateY(-110%);}
        .nav{display:flex; align-items:center; justify-content:space-between; gap:16px;}
        .brand{display:flex; align-items:center; gap:10px; font-family:'Space Grotesk',sans-serif; font-weight:600; font-size:17px;}
        .brand-mark{
            width:30px; height:30px; border:1.5px solid var(--fg); border-radius:50%;
            display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0;
            transition:border-radius .4s cubic-bezier(.34,1.56,.64,1), transform .4s ease;
        }
        .brand:hover .brand-mark{border-radius:30% 70% 70% 30% / 30% 30% 70% 70%; transform:rotate(8deg);}
        .nav-links{display:flex; align-items:center; gap:4px;}
        .nav-links a{position:relative; font-size:14px; color:var(--muted); font-weight:500; padding:8px 12px; transition:color .2s;}
        .nav-links a::after{
            content:''; position:absolute; left:12px; right:12px; bottom:4px; height:1px; background:var(--fg);
            transform:scaleX(0); transform-origin:left; transition:transform .25s ease;
        }
        .nav-links a:hover{color:var(--fg);}
        .nav-links a:hover::after{transform:scaleX(1);}
        .nav-right{display:flex; align-items:center; gap:10px; flex-shrink:0;}

        .theme-toggle{
            width:38px; height:38px; border-radius:50%; border:1px solid var(--line-strong); background:transparent;
            display:flex; align-items:center; justify-content:center; cursor:pointer; color:var(--fg); flex-shrink:0;
            transition:border-color .2s ease, transform .45s cubic-bezier(.34,1.56,.64,1), border-radius .3s ease;
        }
        .theme-toggle:hover{border-color:var(--fg); transform:rotate(50deg); border-radius:30%;}
        .theme-toggle svg{width:16px; height:16px;}
        .theme-toggle .icon-sun{display:none;}
        html[data-theme="light"] .theme-toggle .icon-moon{display:none;}
        html[data-theme="light"] .theme-toggle .icon-sun{display:block;}

        .burger{
            display:none; width:38px; height:38px; border:1px solid var(--line-strong); background:transparent;
            align-items:center; justify-content:center; cursor:pointer; flex-direction:column; gap:4px;
            transition:border-radius .3s ease;
        }
        .burger:hover{border-radius:10px;}
        .burger span{width:15px; height:1px; background:var(--fg); transition:transform .25s, opacity .25s;}
        .burger.open span:nth-child(1){transform:translateY(4.5px) rotate(45deg);}
        .burger.open span:nth-child(2){opacity:0;}
        .burger.open span:nth-child(3){transform:translateY(-4.5px) rotate(-45deg);}

        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:0 22px; height:44px; font-size:14px; font-weight:600;
            border:1px solid var(--fg); cursor:pointer; white-space:nowrap; position:relative; overflow:hidden;
            transition:background .18s ease, color .18s ease, transform .15s ease, border-radius .35s cubic-bezier(.34,1.56,.64,1);
        }
        .btn .arrow{transition:transform .18s ease; display:inline-block;}
        .btn:hover .arrow{transform:translateX(3px);}
        .btn-solid{background:var(--fg); color:var(--bg); border-radius:999px;}
        .btn-solid:hover{border-radius:10px 24px 10px 24px; transform:translateY(-2px);}
        .btn-ghost{background:transparent; color:var(--fg); border-radius:4px 16px 4px 16px;}
        .btn-ghost:hover{background:var(--fg); color:var(--bg); border-radius:999px; transform:translateY(-2px);}
        .btn:active{transform:scale(.96) !important;}

        .mobile-panel{
            display:none; position:fixed; top:var(--header-h); left:0; right:0; z-index:90;
            background:var(--bg-panel); border-bottom:1px solid var(--line);
            padding:20px 28px 28px; flex-direction:column; gap:2px;
            transform:translateY(-10px); opacity:0; transition:transform .22s ease, opacity .22s ease;
        }
        .mobile-panel.open{display:flex; transform:translateY(0); opacity:1;}
        .mobile-panel a{font-size:16px; font-weight:500; padding:13px 2px; border-bottom:1px solid var(--line); transition:padding-left .2s ease, color .2s ease;}
        .mobile-panel a:hover{padding-left:10px; color:var(--muted);}
        .mobile-panel a:last-child{border-bottom:none;}

        /* ---------- reveal ---------- */
        .reveal{opacity:0; transform:translateY(16px); animation:rise .7s ease forwards;}
        .r1{animation-delay:.04s;} .r2{animation-delay:.14s;} .r3{animation-delay:.24s;} .r4{animation-delay:.34s;}
        @keyframes rise{to{opacity:1; transform:translateY(0);}}
        .fade-up{opacity:0; transform:translateY(20px); transition:opacity .6s ease, transform .6s ease;}
        .fade-up.in-view{opacity:1; transform:translateY(0);}
        .stagger > *{opacity:0; transform:translateY(16px); transition:opacity .55s ease, transform .55s ease;}
        .stagger.in-view > *{opacity:1; transform:translateY(0);}
        .stagger.in-view > *:nth-child(1){transition-delay:.03s;}
        .stagger.in-view > *:nth-child(2){transition-delay:.09s;}
        .stagger.in-view > *:nth-child(3){transition-delay:.15s;}
        .stagger.in-view > *:nth-child(4){transition-delay:.21s;}
        .stagger.in-view > *:nth-child(5){transition-delay:.27s;}
        .stagger.in-view > *:nth-child(6){transition-delay:.33s;}
        .stagger.in-view > *:nth-child(n+7){transition-delay:.36s;}

        /* ---------- hero ---------- */
        .hero{position:relative; padding:calc(var(--header-h) + 64px) 0 0;}
        .hero-grid{display:grid; grid-template-columns:1.05fr .95fr; gap:56px; align-items:center;}
        .kicker{
            font-family:'JetBrains Mono',monospace; font-size:12px; color:var(--muted);
            display:flex; align-items:center; gap:9px; margin-bottom:24px;
        }
        .kicker::before{content:''; width:6px; height:6px; background:var(--fg); flex-shrink:0; animation:blink 1.6s steps(1) infinite;}
        @keyframes blink{0%,49%{opacity:1;} 50%,100%{opacity:.15;}}
        .hero h1{font-size:clamp(38px,4.6vw,58px); line-height:1.06;}
        .hero h1 u{text-decoration:none; border-bottom:3px solid var(--fg); padding-bottom:2px;}
        .hero-sub{max-width:480px; margin-top:22px; color:var(--muted); font-size:16px;}
        .hero-actions{display:flex; gap:12px; margin-top:32px; flex-wrap:wrap;}
        .hero-stats{display:flex; gap:0; margin-top:52px; border-top:1px solid var(--line);}
        .hero-stats div{padding:16px 26px 0 0; margin-right:26px; border-right:1px solid var(--line);}
        .hero-stats div:last-child{border-right:none; margin-right:0;}
        .hero-stats strong{display:block; font-family:'Space Grotesk',sans-serif; font-size:24px; font-weight:700;}
        .hero-stats span{font-size:12.5px; color:var(--muted);}

        /* ---------- chat mockup: the signature element ---------- */
        .device{
            position:relative; border:1px solid var(--line-strong); background:var(--bg-panel);
            border-radius:22px 22px 22px 4px; overflow:hidden; box-shadow:0 40px 90px -30px rgba(0,0,0,.45);
            transition:border-radius .5s cubic-bezier(.34,1.56,.64,1), transform .5s ease;
        }
        .device:hover{border-radius:4px 22px 22px 22px; transform:translateY(-4px);}
        .device-bar{
            display:flex; align-items:center; gap:7px; padding:11px 14px; border-bottom:1px solid var(--line);
        }
        .device-bar span{width:8px; height:8px; border-radius:50%; border:1px solid var(--line-strong);}
        .device-title{margin-left:8px; font-family:'JetBrains Mono',monospace; font-size:11.5px; color:var(--muted);}

        .d-head{display:flex; align-items:center; gap:11px; padding:14px 16px; border-bottom:1px solid var(--line);}
        .d-avatar{
            width:38px; height:38px; border-radius:50%; border:1.5px solid var(--fg);
            display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; flex-shrink:0;
            font-family:'Space Grotesk',sans-serif;
        }
        .d-meta strong{display:block; font-size:14px; font-weight:600;}
        .d-meta .status{display:flex; align-items:center; gap:6px; font-size:11.5px; color:var(--muted); margin-top:2px;}
        .d-meta .status::before{content:''; width:6px; height:6px; border-radius:50%; background:var(--fg); animation:blink 1.8s steps(1) infinite;}

        .d-body{padding:18px 16px 14px; display:flex; flex-direction:column; gap:11px; min-height:360px; max-height:420px; overflow:hidden; position:relative;}
        .d-date{align-self:center; font-family:'JetBrains Mono',monospace; font-size:10.5px; color:var(--muted-2); margin-bottom:4px;}

        .d-row{display:flex; gap:8px; max-width:82%;}
        .d-row.out{align-self:flex-end; flex-direction:row-reverse;}
        .d-row.in{align-self:flex-start;}
        .d-bubble{padding:9px 13px; border-radius:15px; font-size:13.5px; line-height:1.45; transition:border-radius .3s ease;}
        .d-row.in .d-bubble{background:var(--bg-panel-2); border:1px solid var(--line); border-bottom-left-radius:3px;}
        .d-row.out .d-bubble{background:var(--fg); color:var(--bg); border-bottom-right-radius:3px;}
        .d-row .d-bubble:hover{border-radius:20px;}
        .d-row.in .d-bubble:hover{border-bottom-left-radius:3px;}
        .d-row.out .d-bubble:hover{border-bottom-right-radius:3px;}
        .d-foot{display:flex; align-items:center; gap:5px; margin-top:4px; font-family:'JetBrains Mono',monospace; font-size:10px;}
        .d-row.out .d-foot{justify-content:flex-end; color:var(--muted);}
        .d-row.in .d-foot{color:var(--muted-2);}
        .d-ticks{letter-spacing:-1px;}
        .d-ticks.read{color:var(--fg);}

        .d-voice{
            display:flex; align-items:center; gap:10px; min-width:190px; padding:9px 12px; border-radius:15px 15px 3px 15px; cursor:pointer; user-select:none;
        }
        .d-row.in .d-voice{background:var(--bg-panel-2); border:1px solid var(--line); border-radius:15px 15px 15px 3px;}
        .d-voice-play{
            width:30px; height:30px; border-radius:50%; border:1px solid var(--line-strong); flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:11px;
            transition:transform .2s ease, border-radius .2s ease, background .2s ease, color .2s ease;
        }
        .d-voice:hover .d-voice-play{transform:scale(1.1); border-radius:30%;}
        .d-row.out .d-voice-play{border-color:var(--bg);}
        .d-voice.playing .d-voice-play{background:var(--fg); color:var(--bg);}
        .d-row.out .d-voice.playing .d-voice-play{background:var(--bg); color:var(--fg);}
        .d-wave{display:flex; align-items:center; gap:2px; height:18px; flex:1;}
        .d-wave span{width:2px; background:var(--muted); border-radius:1px; animation:waveMove 1.6s ease-in-out infinite; transition:background .25s ease;}
        .d-wave span.p{background:var(--fg);}
        .d-row.out .d-wave span{background:rgba(0,0,0,.28);}
        .d-row.out .d-wave span.p{background:var(--bg);}
        .d-voice.playing .d-wave span{animation-play-state:running;}
        .d-voice:not(.playing) .d-wave span{animation-play-state:paused;}
        @keyframes waveMove{0%,100%{opacity:.55;} 50%{opacity:1;}}
        .d-voice-time{font-family:'JetBrains Mono',monospace; font-size:10px; color:var(--muted); flex-shrink:0; min-width:26px;}
        .d-row.out .d-voice-time{color:rgba(0,0,0,.55);}

        .d-typing{display:flex; gap:4px; padding:11px 14px;}
        .d-typing span{width:5px; height:5px; border-radius:50%; background:var(--muted); animation:bounce 1.2s infinite;}
        .d-typing span:nth-child(2){animation-delay:.15s;}
        .d-typing span:nth-child(3){animation-delay:.3s;}
        @keyframes bounce{0%,60%,100%{transform:translateY(0); opacity:.4;} 30%{transform:translateY(-4px); opacity:1;}}

        .d-image{width:180px; border-radius:15px 15px 15px 3px; overflow:hidden; border:1px solid var(--line); cursor:pointer;}
        .d-row.out .d-image{border-radius:15px 15px 3px 15px;}
        .d-image-ph{
            width:100%; height:112px; position:relative; overflow:hidden;
            background:linear-gradient(150deg, var(--bg-panel-2) 0%, var(--bg-panel) 60%);
            display:flex; align-items:flex-end; justify-content:flex-start;
        }
        .d-image-ph svg{width:100%; height:100%; position:absolute; inset:0;}
        .d-image-cap{padding:7px 11px 9px; font-size:12px;}
        .d-row.in .d-image-cap{background:var(--bg-panel-2);}
        .d-row.out .d-image-cap{background:var(--fg); color:var(--bg);}

        .d-file{
            display:flex; align-items:center; gap:10px; min-width:196px; padding:10px 12px; border-radius:15px 15px 3px 15px; cursor:pointer;
        }
        .d-row.in .d-file{background:var(--bg-panel-2); border:1px solid var(--line); border-radius:15px 15px 15px 3px;}
        .d-row.out .d-file{border-radius:15px 15px 3px 15px;}
        .d-file-icon{
            width:32px; height:32px; border-radius:8px; border:1px solid var(--line-strong); flex-shrink:0;
            display:flex; align-items:center; justify-content:center; font-size:10px; font-family:'JetBrains Mono',monospace; font-weight:600;
        }
        .d-row.out .d-file-icon{border-color:var(--bg);}
        .d-file-meta{display:flex; flex-direction:column; gap:2px; min-width:0;}
        .d-file-name{font-size:12.5px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;}
        .d-file-size{font-family:'JetBrains Mono',monospace; font-size:10px; opacity:.65;}

        .d-input{
            display:flex; align-items:center; gap:10px; margin:0 14px 14px; padding:10px 14px;
            border:1px solid var(--line); border-radius:999px; transition:border-color .2s ease;
        }
        .d-input:hover{border-color:var(--line-strong);}
        .d-input span{font-size:12.5px; color:var(--muted); flex:1;}
        .d-input .mic{width:26px; height:26px; border-radius:50%; border:1px solid var(--line-strong); display:flex; align-items:center; justify-content:center; font-size:11px; flex-shrink:0;}

        .device-row{animation:msgIn .5s ease forwards; opacity:0;}
        @keyframes msgIn{from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);}}
        .device-row.leaving{animation:msgOut .4s ease forwards;}
        @keyframes msgOut{from{opacity:1; transform:translateY(0); max-height:80px; margin-bottom:11px;} to{opacity:0; transform:translateY(-8px); max-height:0; margin-bottom:0;}}

        @media(max-width:900px){
            .hero-grid{grid-template-columns:1fr;}
            .hero-stats{flex-wrap:wrap;}
        }

        /* ---------- ticker ---------- */
        .ticker-wrap{
            border-top:1px solid var(--line); border-bottom:1px solid var(--line);
            overflow:hidden; margin-top:60px; padding:16px 0;
        }
        .ticker-track{display:flex; width:max-content; animation:tickerMove 32s linear infinite;}
        .ticker-wrap:hover .ticker-track{animation-play-state:paused;}
        .ticker-item{
            display:flex; align-items:center; gap:14px; padding:0 28px;
            font-family:'Space Grotesk',sans-serif; font-size:15px; font-weight:600; color:var(--muted); white-space:nowrap;
        }
        .ticker-item b{color:var(--fg); font-weight:600;}
        .ticker-item .sep{width:6px; height:6px; border-radius:50%; border:1px solid var(--line-strong); flex-shrink:0;}
        @keyframes tickerMove{from{transform:translateX(0);} to{transform:translateX(-50%);}}

        /* ---------- section shell ---------- */
        section{position:relative; padding:96px 0;}
        .section-head{max-width:600px; margin-bottom:52px;}
        .section-head .kicker{margin-bottom:16px;}
        .section-head h2{font-size:clamp(28px,3.6vw,38px);}
        .section-head p{color:var(--muted); margin-top:14px; font-size:15.5px; max-width:520px;}

        /* ---------- feature ledger (documents real features) ---------- */
        .ledger{border-top:1px solid var(--line);}
        .ledger-row{
            position:relative; display:grid; grid-template-columns:64px 1.1fr 1.6fr; gap:28px; padding:26px 22px 26px 0;
            border-bottom:1px solid var(--line); align-items:start; transition:padding-left .28s ease, background .28s ease;
        }
        .ledger-row::before{
            content:''; position:absolute; left:0; top:0; bottom:0; width:0; background:var(--fg);
            transition:width .28s ease;
        }
        .ledger-row:hover{padding-left:18px; background:var(--bg-panel);}
        .ledger-row:hover::before{width:3px;}
        .ledger-row .idx{font-family:'JetBrains Mono',monospace; font-size:12.5px; color:var(--muted-2); padding-top:4px;}
        .ledger-row h3{font-size:17px; font-weight:600;}
        .ledger-row p{color:var(--muted); font-size:14.5px; margin-top:8px;}
        .ledger-row .tag{
            display:inline-block; font-family:'JetBrains Mono',monospace; font-size:10.5px; color:var(--muted-2);
            border:1px solid var(--line); padding:3px 10px; border-radius:2px 10px 2px 10px; margin-top:10px;
            transition:border-radius .25s ease, border-color .25s ease, color .25s ease;
        }
        .ledger-row:hover .tag{border-radius:10px 2px 10px 2px; border-color:var(--line-strong); color:var(--fg);}
        @media(max-width:760px){
            .ledger-row{grid-template-columns:40px 1fr; }
            .ledger-row > div:nth-child(3){grid-column:2/3;}
        }

        /* ---------- composer anatomy (documents the input bar) ---------- */
        .anatomy{
            border:1px solid var(--line-strong); border-radius:26px 26px 26px 4px; padding:26px;
            display:grid; grid-template-columns:1fr; gap:0; background:var(--bg-panel);
            transition:border-radius .4s cubic-bezier(.34,1.56,.64,1);
        }
        .anatomy:hover{border-radius:4px 26px 26px 26px;}
        .anatomy-bar{
            display:flex; align-items:center; gap:12px; padding:12px 16px; border:1px solid var(--line);
            border-radius:999px; margin-bottom:28px;
        }
        .anatomy-bar .a-icon{width:22px; height:22px; border:1px solid var(--line-strong); border-radius:50%; flex-shrink:0; transition:border-radius .25s ease;}
        .anatomy-bar:hover .a-icon{border-radius:30%;}
        .anatomy-bar .a-field{flex:1; font-size:13px; color:var(--muted);}
        .anatomy-bar .a-icon.filled{background:var(--fg);}
        .anatomy-legend{display:grid; grid-template-columns:repeat(4,1fr); gap:20px;}
        .anatomy-legend div{border-top:1px solid var(--line); padding-top:12px; transition:border-color .25s ease;}
        .anatomy-legend div:hover{border-color:var(--line-strong);}
        .anatomy-legend b{display:block; font-size:13.5px; font-weight:600; margin-bottom:5px;}
        .anatomy-legend span{font-size:12.5px; color:var(--muted); line-height:1.5;}
        @media(max-width:760px){ .anatomy-legend{grid-template-columns:1fr 1fr;} }

        /* ---------- inverted region section ---------- */
        .invert{background:var(--invert-bg); color:var(--invert-fg); border-top:1px solid var(--line); border-bottom:1px solid var(--line); transition:background .35s ease, color .35s ease;}
        .invert .kicker{color:var(--invert-muted);}
        .invert .kicker::before{background:var(--invert-fg);}
        .invert .section-head p{color:var(--invert-muted);}
        .mosaic{display:grid; grid-template-columns:repeat(auto-fit, minmax(126px,1fr)); gap:1px; background:var(--invert-line); border:1px solid var(--invert-line);}
        .tile{
            position:relative; padding:20px 16px 18px; background:var(--invert-bg); color:var(--invert-fg);
            transition:background .25s ease, color .25s ease, border-radius .3s ease, transform .25s ease;
        }
        .tile:hover{background:var(--invert-fg); color:var(--invert-bg); border-radius:16px; transform:scale(1.035); z-index:2;}
        .tile .num{font-family:'JetBrains Mono',monospace; font-size:11px; opacity:.5;}
        .tile .name{
            display:block; margin-top:12px; font-weight:600; font-size:14.5px; font-family:'Space Grotesk',sans-serif;
            overflow-wrap:anywhere;
        }
        .tile .online{margin-top:10px; font-family:'JetBrains Mono',monospace; font-size:10.5px; opacity:.6; display:flex; align-items:center; gap:5px;}
        .tile .online::before{content:''; width:5px; height:5px; border-radius:50%; background:currentColor; animation:blink 2.2s steps(1) infinite;}

        /* ---------- steps ---------- */
        .steps{display:grid; grid-template-columns:repeat(3,1fr); gap:1px; background:var(--line); border:1px solid var(--line);}
        .step{background:var(--bg); padding:32px 28px; transition:border-radius .3s ease, background .3s ease;}
        .step:hover{border-radius:0 26px 0 26px; background:var(--bg-panel);}
        .step .step-num{font-family:'JetBrains Mono',monospace; font-size:13px; color:var(--muted-2); display:block; margin-bottom:18px;}
        .step h3{font-size:17px; font-weight:600; margin-bottom:9px;}
        .step p{color:var(--muted); font-size:14.5px;}
        @media(max-width:760px){ .steps{grid-template-columns:1fr;} }

        /* ---------- trust ---------- */
        .trust{display:grid; grid-template-columns:repeat(3,1fr); gap:1px; background:var(--line); border:1px solid var(--line);}
        .trust-item{background:var(--bg); padding:30px 26px; transition:border-radius .3s ease, background .3s ease;}
        .trust-item:hover{border-radius:26px 0 26px 0; background:var(--bg-panel);}
        .trust-item h3{font-size:16px; font-weight:600; margin-bottom:9px;}
        .trust-item p{color:var(--muted); font-size:14px;}
        @media(max-width:760px){ .trust{grid-template-columns:1fr;} }

        /* ---------- faq ---------- */
        .faq{max-width:720px; display:flex; flex-direction:column;}
        .faq details{border-top:1px solid var(--line); padding:20px 18px; transition:background .25s ease, border-radius .25s ease;}
        .faq details:last-child{border-bottom:1px solid var(--line);}
        .faq details[open]{background:var(--bg-panel); border-radius:4px 16px 4px 16px;}
        .faq summary{
            cursor:pointer; font-weight:600; font-size:15px; list-style:none;
            display:flex; align-items:center; justify-content:space-between; gap:12px;
        }
        .faq summary::-webkit-details-marker{display:none;}
        .faq summary::after{content:'+'; font-size:19px; color:var(--muted); transition:transform .3s cubic-bezier(.34,1.56,.64,1); font-family:'Space Grotesk',sans-serif;}
        .faq details[open] summary::after{transform:rotate(45deg);}
        .faq details p{margin-top:13px; color:var(--muted); font-size:14.5px; line-height:1.6; max-width:600px;}

        /* ---------- cta ---------- */
        .cta-band{
            border:1px solid var(--line-strong); padding:68px 32px; text-align:center; border-radius:36px 36px 36px 4px;
            transition:border-radius .45s cubic-bezier(.34,1.56,.64,1);
        }
        .cta-band:hover{border-radius:4px 36px 36px 36px;}
        .cta-band h2{font-size:clamp(26px,3.6vw,36px); margin-bottom:14px;}
        .cta-band p{color:var(--muted); max-width:440px; margin:0 auto 30px;}

        /* ---------- footer ---------- */
        footer{border-top:1px solid var(--line); padding:56px 0 28px;}
        .foot-grid{display:grid; grid-template-columns:1.4fr 1fr 1fr 1fr; gap:32px; padding-bottom:36px;}
        .foot-col h4{font-family:'JetBrains Mono',monospace; font-size:11.5px; letter-spacing:.04em; color:var(--muted-2); margin-bottom:16px; font-weight:500; text-transform:lowercase;}
        .foot-col a{display:inline-block; font-size:14px; color:var(--muted); margin-bottom:10px; transition:color .18s ease, transform .18s ease;}
        .foot-col a:hover{color:var(--fg); transform:translateX(3px);}
        .foot-about p{color:var(--muted); font-size:14px; max-width:280px; margin-top:14px;}
        .foot-bottom{border-top:1px solid var(--line); padding-top:22px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;}
        .foot-copy{font-size:12.5px; color:var(--muted-2); font-family:'JetBrains Mono',monospace;}

        /* ---------- back to top ---------- */
   .to-top{
    position:fixed; right:22px; bottom:22px; z-index:95; width:42px; height:42px; border-radius:50%;
    background:var(--bg); border:1px solid var(--line-strong); display:flex; align-items:center; justify-content:center;
    cursor:pointer; opacity:0; pointer-events:none; transform:translateY(8px) scale(.8);
    color:var(--fg);
    transition:opacity .22s, transform .22s, border-color .18s, border-radius .3s ease;
}
        .to-top.show{opacity:1; pointer-events:auto; transform:translateY(0) scale(1);}
        .to-top:hover{border-color:var(--fg); border-radius:30%; transform:translateY(-2px) scale(1.05);}
        .to-top svg{width:15px; height:15px;}

        @media(max-width:820px){
            .nav-links{display:none;}
            .burger{display:flex;}
            .foot-grid{grid-template-columns:1fr 1fr; row-gap:28px;}
        }
        @media(max-width:480px){ .foot-grid{grid-template-columns:1fr;} }

        @media (prefers-reduced-motion: reduce){
            *{animation-duration:.001ms !important; animation-iteration-count:1 !important; transition-duration:.001ms !important;}
            html{scroll-behavior:auto;}
        }
    </style>
</head>
<body>

    <div class="progress" id="progress"></div>

    <header class="site-header" id="siteHeader">
        <div class="wrap nav">
            <div class="brand">
                <span class="brand-mark">O'</span>
                ChatO'VBS
            </div>
            <nav class="nav-links">
                <a href="#imkoniyatlar">Imkoniyatlar</a>
                <a href="#xabar-turlari">Xabar turlari</a>
                <a href="#viloyatlar">Viloyatlar</a>
                <a href="#qanday">Qanday ishlaydi</a>
                <a href="#savollar">Savollar</a>
            </nav>
            <div class="nav-right">
                <button class="theme-toggle" id="themeToggle" aria-label="Rejimni almashtirish" type="button">
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                </button>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-solid">Kabinet</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Kirish</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-solid">Ro'yxatdan o'tish</a>
                        @endif
                    @endauth
                @endif
                <button class="burger" id="burger" aria-label="Menyu" type="button">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
        <div class="mobile-panel" id="mobilePanel">
            <a href="#imkoniyatlar">Imkoniyatlar</a>
            <a href="#xabar-turlari">Xabar turlari</a>
            <a href="#viloyatlar">Viloyatlar</a>
            <a href="#qanday">Qanday ishlaydi</a>
            <a href="#savollar">Savollar</a>
        </div>
    </header>

    <main class="wrap">

        <!-- HERO -->
        <section class="hero">
            <div class="hero-grid">
                <div>
                    <span class="kicker reveal r1">Matn · ovoz · fayl — bitta suhbatda</span>
                    <h1 class="reveal r2">Yozing, gapiring,<br>yubor<u>ing</u> — hammasi<br>bitta oynada</h1>
                    <p class="hero-sub reveal r3">
                        ChatO'VBS — matnli xabarlar, ovozli xabarlar, rasm va fayllar,
                        kanallar va guruhlar bir joyda. Umumiy suhbatdan tortib
                        O'zbekistonning har bir viloyati uchun alohida xonagacha.
                    </p>
                    <div class="hero-actions reveal r4">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-solid">Bepul boshlash <span class="arrow">→</span></a>
                        @endif
                        <a href="#xabar-turlari" class="btn btn-ghost">Xabar turlarini ko'rish</a>
                    </div>
                    <div class="hero-stats reveal r4">
                        <div><strong>14</strong><span>viloyat xonasi</span></div>
                        <div><strong>real-time</strong><span>xabar yetkazish</span></div>
                        <div><strong>24/7</strong><span>ochiq suhbat</span></div>
                    </div>
                </div>

                <div class="device" id="deviceStage">
                    <div class="device-bar">
                        <span></span><span></span><span></span>
                        <span class="device-title">samarqand-xonasi</span>
                    </div>
                    <div class="d-head">
                        <div class="d-avatar">Sa</div>
                        <div class="d-meta">
                            <strong>Samarqand xonasi</strong>
                            <span class="status">128 kishi onlayn</span>
                        </div>
                    </div>
                    <div class="d-body" id="chatFeed">
                        <span class="d-date">Bugun</span>
                    </div>
                    <div class="d-input">
                        <span class="a-icon" style="width:18px;height:18px;border:1px solid var(--line-strong);border-radius:4px;"></span>
                        <span>Xabar yozing...</span>
                        <span class="mic">●</span>
                    </div>
                </div>
            </div>

            <div class="ticker-wrap">
                <div class="ticker-track" id="tickerTrack"></div>
            </div>
        </section>

        <!-- FEATURE LEDGER -->
        <section id="imkoniyatlar">
            <div class="section-head fade-up">
                <span class="kicker">Nima uchun ChatO'VBS</span>
                <h2>Bitta ilova, uchta muloqot uslubi</h2>
                <p>Kimga va qanday yozishni o'zingiz tanlaysiz — keng auditoriyaga, o'z hududingizga yoki bitta insonga.</p>
            </div>
            <div class="ledger stagger fade-up">
                <div class="ledger-row">
                    <div class="idx">01</div>
                    <div><h3>Umumiy suhbat</h3></div>
                    <div>
                        <p>Butun O'zbekiston bo'yicha ochiq xonada barcha foydalanuvchilar bilan bir vaqtda muloqot qilasiz.</p>
                        <span class="tag">ommaviy</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">02</div>
                    <div><h3>Viloyat xonalari</h3></div>
                    <div>
                        <p>Har bir viloyat uchun alohida chat — o'z hududingiz odamlari va yangiliklariga yaqinroq bo'lasiz.</p>
                        <span class="tag">14 ta xona</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">03</div>
                    <div><h3>Shaxsiy xabarlar</h3></div>
                    <div>
                        <p>Istalgan foydalanuvchi bilan, faqat ikkovingiz ko'radigan tarzda yozishasiz — javob berish, tahrirlash va pin qilish bilan.</p>
                        <span class="tag">1 ga 1</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- MESSAGE TYPES — the real feature documentation -->
        <section id="xabar-turlari">
            <div class="section-head fade-up">
                <span class="kicker">Xabar turlari</span>
                <h2>Faqat matn emas — hamma narsani yuborasiz</h2>
                <p>Har bir suhbatda quyidagi barcha xabar turlaridan foydalanish mumkin.</p>
            </div>
            <div class="ledger stagger fade-up">
                <div class="ledger-row">
                    <div class="idx">🎙</div>
                    <div><h3>Ovozli xabarlar</h3></div>
                    <div>
                        <p>Mikrofon tugmasini bosib turing — ovozli xabar yozila boshlaydi, to'lqin shakli va vaqt ko'rsatkichi bilan. Barmog'ingizni tugmadan chetga surib, yozuvni bekor qilishingiz mumkin.</p>
                        <span class="tag">drag-to-cancel</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">🖼</div>
                    <div><h3>Rasm va video</h3></div>
                    <div>
                        <p>Rasm yuborishdan oldin oldindan ko'rish va izoh qo'shish oynasi ochiladi. Yuborilgan rasmlar to'liq ekranli galereya (lightbox) rejimida ko'riladi — oldingi/keyingisiga o'tish bilan.</p>
                        <span class="tag">oldindan ko'rish</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">📎</div>
                    <div><h3>Fayllar</h3></div>
                    <div>
                        <p>Har qanday formatdagi fayl yuboriladi — hajmi va turi bilan birga. Faylni ochish yoki yuklab olish uchun mos ilova tanlash oynasi chiqadi.</p>
                        <span class="tag">istalgan format</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">🎵</div>
                    <div><h3>Musiqa fayllari</h3></div>
                    <div>
                        <p>Audio fayllar alohida pleyer sifatida ko'rinadi — progress chizig'i va vaqt ko'rsatkichi bilan, to'g'ridan-to'g'ri suhbat ichida tinglanadi.</p>
                        <span class="tag">ichki pleyer</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">😀</div>
                    <div><h3>Emoji</h3></div>
                    <div>
                        <p>Kategoriyalarga bo'lingan to'liq emoji to'plami — so'nggi ishlatilganlar alohida bo'limda saqlanadi, qidirish oson.</p>
                        <span class="tag">so'nggi ishlatilganlar</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">📌</div>
                    <div><h3>Javob berish, pin, tahrirlash</h3></div>
                    <div>
                        <p>Har bir xabarni javob berish, mahkamlash (pin), matnini tahrirlash, nusxa olish yoki bir nechtasini birga tanlab o'chirish yoki forward qilish mumkin.</p>
                        <span class="tag">to'liq boshqaruv</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- COMPOSER ANATOMY -->
        <section>
            <div class="section-head fade-up">
                <span class="kicker">Yozish paneli</span>
                <h2>Bitta qatorda — hammasi qo'l ostida</h2>
                <p>Xabar yozish paneli ortida nima turganini ko'rsatib beramiz.</p>
            </div>
            <div class="anatomy fade-up">
                <div class="anatomy-bar">
                    <span class="a-icon"></span>
                    <span class="a-field">Xabar yozing...</span>
                    <span class="a-icon"></span>
                    <span class="a-icon filled"></span>
                </div>
                <div class="anatomy-legend">
                    <div>
                        <b>Fayl biriktirish</b>
                        <span>Rasm, video, hujjat yoki istalgan boshqa faylni tanlab yuborasiz.</span>
                    </div>
                    <div>
                        <b>Matn maydoni</b>
                        <span>Havolalar avtomatik bosiladigan qilib belgilanadi, Enter — yuborish.</span>
                    </div>
                    <div>
                        <b>Emoji tugmasi</b>
                        <span>Kategoriyalashgan emoji panelini ochadi yoki yopadi.</span>
                    </div>
                    <div>
                        <b>Yuborish / Mikrofon</b>
                        <span>Matn bo'lsa — yuborish strelkasi, bo'sh bo'lsa — ovozli xabar mikrofoni ko'rinadi.</span>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- REGION MOSAIC (inverted section — the one bold moment) -->
    <section class="invert" id="viloyatlar">
        <div class="wrap">
            <div class="section-head fade-up">
                <span class="kicker">Xaritadan tanlang</span>
                <h2>14 ta viloyat, 14 ta xona</h2>
                <p>Har bir kartani sichqoncha bilan ushlab ko'ring.</p>
            </div>
            <div class="mosaic stagger fade-up">
                @php
                    $viloyatlar = [
                        'Toshkent shahri' => 412, 'Toshkent viloyati' => 268, 'Andijon' => 194, 'Farg\'ona' => 221,
                        'Namangan' => 176, 'Samarqand' => 253, 'Buxoro' => 158, 'Xorazm' => 121,
                        'Navoiy' => 97, 'Qashqadaryo' => 189, 'Surxondaryo' => 142, 'Jizzax' => 88,
                        'Sirdaryo' => 64, 'Qoraqalpog\'iston' => 133,
                    ];
                @endphp
                @foreach ($viloyatlar as $vil => $onlayn)
                    <div class="tile">
                        <span class="num">{{ sprintf('%02d', $loop->iteration) }}</span>
                        <span class="name">{{ $vil }}</span>
                        <span class="online">{{ $onlayn }} onlayn</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <main class="wrap">

        <!-- MORE FEATURES: saved messages, channels, groups, search, theme -->
        <section>
            <div class="section-head fade-up">
                <span class="kicker">Yana nima bor</span>
                <h2>Kanallar, guruhlar va shaxsiy arxiv</h2>
                <p>Xabar almashishdan tashqari, tashkil qilish uchun ham vositalar bor.</p>
            </div>
            <div class="ledger stagger fade-up">
                <div class="ledger-row">
                    <div class="idx">📡</div>
                    <div><h3>Kanallar</h3></div>
                    <div>
                        <p>Har bir post ko'rishlar sonini ko'rsatadi, ostida esa bog'langan muhokama chatiga "sharh qoldirish" tugmasi bor.</p>
                        <span class="tag">ko'rishlar hisobi</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">👥</div>
                    <div><h3>Guruhlar</h3></div>
                    <div>
                        <p>Bir nechta odam bilan umumiy xona yaratasiz — a'zolar soni va yaratilgan sanasi ko'rsatiladi.</p>
                        <span class="tag">jamoaviy</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">🔖</div>
                    <div><h3>Saqlangan xabarlar</h3></div>
                    <div>
                        <p>O'zingizga eslatma sifatida yozib qo'yasiz yoki boshqa suhbatdan forward qilasiz. Rasm, video, fayl, havola va ovozli xabarlar soni bo'yicha statistika ham beriladi.</p>
                        <span class="tag">shaxsiy arxiv</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">🔍</div>
                    <div><h3>Qidiruv</h3></div>
                    <div>
                        <p>Tez-tez yozishadigan suhbatdoshlaringiz va qidiruv tarixi alohida ko'rsatiladi — kerakli suhbatni bir necha soniyada topasiz.</p>
                        <span class="tag">tez-tez yozishadiganlar</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">◐</div>
                    <div><h3>Kunduzgi / tungi rejim</h3></div>
                    <div>
                        <p>Ko'zingizga qulay rejimni tanlaysiz — sozlama saqlanib qoladi va har safar qayta ochilganda eslab qolinadi.</p>
                        <span class="tag">ikki rejim</span>
                    </div>
                </div>
                <div class="ledger-row">
                    <div class="idx">✓✓</div>
                    <div><h3>O'qildi belgisi va onlayn holat</h3></div>
                    <div>
                        <p>Xabaringiz yetkazilgan yoki o'qilganini ikki tikcha orqali bilasiz, suhbatdoshingiz hozir onlaynmi — avatar ustidagi nuqtadan ko'rinadi.</p>
                        <span class="tag">real vaqt</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section id="qanday">
            <div class="section-head fade-up">
                <span class="kicker">Boshlash uchun</span>
                <h2>Uch qadamda suhbatga qo'shiling</h2>
            </div>
            <div class="steps stagger fade-up">
                <div class="step">
                    <span class="step-num">01</span>
                    <h3>Ro'yxatdan o'ting</h3>
                    <p>Ism va email orqali bir necha soniyada hisob yarating.</p>
                </div>
                <div class="step">
                    <span class="step-num">02</span>
                    <h3>Viloyatingizni tanlang</h3>
                    <p>O'zingiz istagan yoki yashayotgan hudud xonasiga qo'shiling.</p>
                </div>
                <div class="step">
                    <span class="step-num">03</span>
                    <h3>Yozishni boshlang</h3>
                    <p>Matn, ovozli xabar yoki fayl — qulay bo'lgan usulda muloqot qiling.</p>
                </div>
            </div>
        </section>

        <!-- TRUST -->
        <section>
            <div class="section-head fade-up">
                <span class="kicker">Ishonch</span>
                <h2>Muloqot — nazorat sizning qo'lingizda</h2>
            </div>
            <div class="trust stagger fade-up">
                <div class="trust-item">
                    <h3>Shaxsiy nazorat</h3>
                    <p>Kimlar bilan yozishishni va qaysi xonalarga qo'shilishni faqat o'zingiz belgilaysiz.</p>
                </div>
                <div class="trust-item">
                    <h3>Bloklash imkoniyati</h3>
                    <p>Istalmagan foydalanuvchini istalgan vaqtda bloklab, undan xabar olishni to'xtatasiz.</p>
                </div>
                <div class="trust-item">
                    <h3>Tezkor yetkazish</h3>
                    <p>Xabarlar real vaqt rejimida yetib boradi — sahifani yangilash shart emas.</p>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="savollar">
            <div class="section-head fade-up">
                <span class="kicker">Savol-javob</span>
                <h2>Ko'p beriladigan savollar</h2>
            </div>
            <div class="faq fade-up">
                <details>
                    <summary>ChatO'VBS'dan foydalanish pullikmi?</summary>
                    <p>Yo'q, ro'yxatdan o'tish va asosiy suhbat imkoniyatlaridan foydalanish bepul.</p>
                </details>
                <details>
                    <summary>Ovozli xabar yozish uchun nima kerak?</summary>
                    <p>Faqat brauzeringizga mikrofonga ruxsat berishingiz kifoya — qo'shimcha ilova o'rnatish shart emas.</p>
                </details>
                <details>
                    <summary>Bir nechta viloyat xonasiga qo'shilsam bo'ladimi?</summary>
                    <p>Ha, xohlagan viloyat xonalaringizga qo'shilib, ular orasida erkin almashib turishingiz mumkin.</p>
                </details>
                <details>
                    <summary>Shaxsiy xabarlarni boshqalar ko'ra oladimi?</summary>
                    <p>Yo'q, shaxsiy yozishmalar faqat suhbatdagi ikki tomonga ko'rinadi.</p>
                </details>
                <details>
                    <summary>Hisobimni keyinchalik o'chira olamanmi?</summary>
                    <p>Ha, profil sozlamalaridan hisobingizni istalgan vaqt o'chirishingiz mumkin bo'ladi.</p>
                </details>
            </div>
        </section>

        <!-- CTA -->
        <section>
            <div class="cta-band fade-up">
                <h2>O'z hududingiz ovoziga qo'shiling</h2>
                <p>Ro'yxatdan o'tish bepul va bir daqiqadan kam vaqt oladi.</p>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-solid">Hoziroq ro'yxatdan o'tish <span class="arrow">→</span></a>
                @endif
            </div>
        </section>

    </main>

    <footer class="wrap">
        <div class="foot-grid">
            <div class="foot-col foot-about">
                <div class="brand" style="font-size:16px;">
                    <span class="brand-mark" style="width:26px;height:26px;font-size:12px;">O'</span>
                    ChatO'VBS
                </div>
                <p>O'zbekiston viloyatlari bo'ylab suhbat maydoni — matn, ovoz, fayl va hududiy xabar almashish bir joyda.</p>
            </div>
            <div class="foot-col">
                <h4>mahsulot</h4>
                <a href="#imkoniyatlar">Imkoniyatlar</a>
                <a href="#xabar-turlari">Xabar turlari</a>
                <a href="#viloyatlar">Viloyatlar</a>
                <a href="#qanday">Qanday ishlaydi</a>
            </div>
            <div class="foot-col">
                <h4>yordam</h4>
                <a href="#savollar">Savol-javob</a>
                <a href="#">Aloqa</a>
                <a href="#">Qoidalar</a>
            </div>
            <div class="foot-col">
                <h4>ijtimoiy tarmoqlar</h4>
                <a href="#">Telegram</a>
                <a href="#">Instagram</a>
            </div>
        </div>
        <div class="foot-bottom">
            <span class="foot-copy">© {{ date('Y') }} ChatO'VBS. Barcha huquqlar himoyalangan.</span>
            <span class="foot-copy">O'zbekistonda yaratildi</span>
        </div>
    </footer>

    <button class="to-top" id="toTop" aria-label="Yuqoriga" type="button">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    <script>
        // Theme toggle (dark/light), persisted
        (function(){
            var root = document.documentElement;
            var saved = localStorage.getItem('chatovbs-theme');
            if (saved) root.setAttribute('data-theme', saved);
            document.getElementById('themeToggle').addEventListener('click', function(){
                var current = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                root.setAttribute('data-theme', current);
                localStorage.setItem('chatovbs-theme', current);
            });
        })();

        // Mobile menu
        (function(){
            var burger = document.getElementById('burger');
            var panel = document.getElementById('mobilePanel');
            burger.addEventListener('click', function(){
                panel.classList.toggle('open');
                burger.classList.toggle('open');
            });
            panel.querySelectorAll('a').forEach(function(a){
                a.addEventListener('click', function(){
                    panel.classList.remove('open');
                    burger.classList.remove('open');
                });
            });
        })();

        // ---------------------------------------------------------------
        // Live chat demo: an endless, self-replenishing conversation.
        // Cycles through text / voice / image / file messages forever,
        // and lets the visitor click a voice bubble to "play" it.
        // ---------------------------------------------------------------
        (function(){
            var feed = document.getElementById('chatFeed');
            var stage = document.getElementById('deviceStage');
            if (!feed || !stage) return;

            var MAX_VISIBLE = 5; // how many bubbles stay on screen at once
            var started = false;

            function imagePlaceholderSVG(seed){
                // simple abstract "photo" glyph, no external assets
                var hues = ['160,160,160','180,150,120','150,170,190','190,160,150'];
                var c = hues[seed % hues.length];
                return '<svg viewBox="0 0 180 112" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">' +
                    '<rect width="180" height="112" fill="rgba(' + c + ',.14)"/>' +
                    '<circle cx="34" cy="30" r="12" fill="rgba(' + c + ',.55)"/>' +
                    '<path d="M0 92 L52 52 L92 80 L130 44 L180 84 L180 112 L0 112 Z" fill="rgba(' + c + ',.4)"/>' +
                    '</svg>';
            }

            function makeBubbleShell(dir){
                var row = document.createElement('div');
                row.className = 'd-row ' + dir + ' device-row';
                return row;
            }

            function footHTML(time, dir, read){
                if (dir === 'out') {
                    return '<div class="d-foot"><span>' + time + '</span><span class="d-ticks' + (read ? ' read' : '') + '">✓✓</span></div>';
                }
                return '<div class="d-foot"><span>' + time + '</span></div>';
            }

            function buildText(dir, text, time, read){
                var row = makeBubbleShell(dir);
                row.innerHTML = '<div><div class="d-bubble"></div>' + footHTML(time, dir, read) + '</div>';
                row.querySelector('.d-bubble').textContent = text;
                return row;
            }

            function buildVoice(dir, duration, time, read){
                var row = makeBubbleShell(dir);
                var wrap = document.createElement('div');
                var bars = 24;
                var barsHTML = '';
                for (var i = 0; i < bars; i++){
                    var h = 4 + Math.round(Math.random() * 12);
                    barsHTML += '<span style="height:' + h + 'px" class="' + (i < 6 ? 'p' : '') + '"></span>';
                }
                wrap.innerHTML =
                    '<div class="d-voice" data-duration="' + duration + '" data-playing="0">' +
                        '<span class="d-voice-play">▶</span>' +
                        '<span class="d-wave">' + barsHTML + '</span>' +
                        '<span class="d-voice-time">0:' + (duration < 10 ? '0' + duration : duration) + '</span>' +
                    '</div>' +
                    footHTML(time, dir, read);
                row.appendChild(wrap);
                return row;
            }

            function buildImage(dir, caption, time, read, seed){
                var row = makeBubbleShell(dir);
                var wrap = document.createElement('div');
                wrap.innerHTML =
                    '<div class="d-image">' +
                        '<div class="d-image-ph">' + imagePlaceholderSVG(seed) + '</div>' +
                        (caption ? '<div class="d-image-cap"></div>' : '') +
                    '</div>' +
                    footHTML(time, dir, read);
                if (caption) wrap.querySelector('.d-image-cap').textContent = caption;
                row.appendChild(wrap);
                return row;
            }

            function buildFile(dir, name, size, ext, time, read){
                var row = makeBubbleShell(dir);
                var wrap = document.createElement('div');
                wrap.innerHTML =
                    '<div class="d-file">' +
                        '<span class="d-file-icon"></span>' +
                        '<div class="d-file-meta"><span class="d-file-name"></span><span class="d-file-size"></span></div>' +
                    '</div>' +
                    footHTML(time, dir, read);
                wrap.querySelector('.d-file-icon').textContent = ext;
                wrap.querySelector('.d-file-name').textContent = name;
                wrap.querySelector('.d-file-size').textContent = size;
                row.appendChild(wrap);
                return row;
            }

            function buildTyping(dir){
                var row = makeBubbleShell(dir);
                row.innerHTML = '<div class="d-typing"><span></span><span></span><span></span></div>';
                return row;
            }

            // Endless script: cycles through, times keep incrementing so it
            // always looks like a live, ongoing conversation.
            var script = [
                { t: 'typing', dir: 'in' },
                { t: 'text', dir: 'in', text: "Registon oldida kim bor? 👋" },
                { t: 'typing', dir: 'out' },
                { t: 'voice', dir: 'out', dur: 14 },
                { t: 'text', dir: 'in', text: "Kechqurun uchrashamizmi?" },
                { t: 'typing', dir: 'out' },
                { t: 'text', dir: 'out', text: "Albatta! Soat 19:00 da bo'ladimi?" },
                { t: 'typing', dir: 'in' },
                { t: 'image', dir: 'in', caption: 'Bugungi bozor 📸', seed: 0 },
                { t: 'text', dir: 'out', text: "Zo'r skachka! Men ham boraman" },
                { t: 'typing', dir: 'in' },
                { t: 'voice', dir: 'in', dur: 9 },
                { t: 'typing', dir: 'out' },
                { t: 'file', dir: 'out', name: 'Marshrut.pdf', size: '2.4 MB', ext: 'PDF' },
                { t: 'text', dir: 'in', text: "Rahmat, hammasi tushunarli 🙌" },
                { t: 'typing', dir: 'out' },
                { t: 'image', dir: 'out', caption: "Yo'ldaman, 10 daqiqa", seed: 2 },
                { t: 'typing', dir: 'in' },
                { t: 'text', dir: 'in', text: "Registonda ko'rishguncha!" },
                { t: 'typing', dir: 'out' },
                { t: 'voice', dir: 'out', dur: 21 },
                { t: 'typing', dir: 'in' },
                { t: 'text', dir: 'in', text: "Video ham yubordim, qara 🎥" },
                { t: 'file', dir: 'in', name: 'Registon_video.mp4', size: '18.6 MB', ext: 'MP4' },
                { t: 'typing', dir: 'out' },
                { t: 'text', dir: 'out', text: "Ajoyib bo'libdi! 🔥" }
            ];

            var idx = 0;
            var hour = 14, minute = 2;
            var timer = null;
            var running = false;

            function nextTime(){
                minute += 1 + Math.floor(Math.random() * 2);
                if (minute >= 60){ minute -= 60; hour = (hour + 1) % 24; }
                var hh = hour < 10 ? '0' + hour : '' + hour;
                var mm = minute < 10 ? '0' + minute : '' + minute;
                return hh + ':' + mm;
            }

            function trim(){
                var rows = feed.querySelectorAll('.device-row');
                while (rows.length > MAX_VISIBLE){
                    var oldest = rows[0];
                    oldest.classList.add('leaving');
                    (function(node){
                        setTimeout(function(){ if (node.parentNode) node.parentNode.removeChild(node); }, 380);
                    })(oldest);
                    rows = Array.prototype.slice.call(rows, 1);
                }
            }

            function removeTyping(dir){
                var t = feed.querySelector('.d-row.' + dir + ' .d-typing');
                if (t) {
                    var row = t.closest('.device-row');
                    if (row) row.remove();
                }
            }

            function step(){
                if (!running) return;
                var item = script[idx % script.length];
                idx++;

                if (item.t === 'typing'){
                    feed.appendChild(buildTyping(item.dir));
                    trim();
                    timer = setTimeout(step, 900 + Math.random() * 500);
                    return;
                }

                removeTyping(item.dir);
                var row, time = nextTime(), read = item.dir === 'out';
                if (item.t === 'text') row = buildText(item.dir, item.text, time, read);
                else if (item.t === 'voice') row = buildVoice(item.dir, item.dur, time, read);
                else if (item.t === 'image') row = buildImage(item.dir, item.caption, time, read, item.seed || 0);
                else if (item.t === 'file') row = buildFile(item.dir, item.name, item.size, item.ext, time, read);

                if (row){
                    feed.appendChild(row);
                    trim();
                }

                var delay = 1400 + Math.random() * 1400;
                timer = setTimeout(step, delay);
            }

            function start(){
                if (started) return;
                started = true;
                running = true;
                step();
            }

            function stop(){
                running = false;
                if (timer) clearTimeout(timer);
            }

            // Voice bubble "playback" — click to hear it play, waveform fills,
            // countdown ticks down, then resets. Purely visual, works for
            // both the live demo bubbles and any future ones.
            feed.addEventListener('click', function(e){
                var voice = e.target.closest('.d-voice');
                if (!voice) return;
                var playing = voice.getAttribute('data-playing') === '1';
                var playBtn = voice.querySelector('.d-voice-play');
                var timeEl = voice.querySelector('.d-voice-time');
                var duration = parseInt(voice.getAttribute('data-duration'), 10) || 10;

                // stop any other bubble currently "playing"
                feed.querySelectorAll('.d-voice.playing').forEach(function(v){
                    if (v !== voice) resetVoice(v);
                });

                if (playing){
                    resetVoice(voice);
                    return;
                }

                voice.classList.add('playing');
                voice.setAttribute('data-playing', '1');
                playBtn.textContent = '❚❚';

                var elapsed = 0;
                var interval = setInterval(function(){
                    elapsed += 1;
                    var remaining = duration - elapsed;
                    if (remaining <= 0){
                        clearInterval(interval);
                        resetVoice(voice);
                        return;
                    }
                    timeEl.textContent = '0:' + (remaining < 10 ? '0' + remaining : remaining);
                }, 1000);
                voice._playInterval = interval;

                function resetVoice(v){
                    var iv = v._playInterval;
                    if (iv) clearInterval(iv);
                    v.classList.remove('playing');
                    v.setAttribute('data-playing', '0');
                    v.querySelector('.d-voice-play').textContent = '▶';
                    var dur = parseInt(v.getAttribute('data-duration'), 10) || 10;
                    v.querySelector('.d-voice-time').textContent = '0:' + (dur < 10 ? '0' + dur : dur);
                }
            });

            if (!('IntersectionObserver' in window)) { start(); return; }
            var io = new IntersectionObserver(function(entries){
                entries.forEach(function(entry){
                    if (entry.isIntersecting) start();
                });
            }, { threshold: 0.35 });
            io.observe(stage);
        })();

        // Feature ticker — duplicated content for a seamless loop
        (function(){
            var track = document.getElementById('tickerTrack');
            if (!track) return;
            var items = [
                'Matnli xabarlar', 'Ovozli xabarlar', 'Rasm va video', 'Fayl yuborish',
                'Musiqa pleyeri', 'Emoji', 'Kanallar', 'Guruhlar', 'Saqlangan xabarlar',
                'Qidiruv', 'Kunduz/tun rejimi', "O'qildi belgisi"
            ];
            function buildSet(){
                var frag = document.createDocumentFragment();
                items.forEach(function(text){
                    var el = document.createElement('span');
                    el.className = 'ticker-item';
                    el.innerHTML = '<b>' + text + '</b><span class="sep"></span>';
                    frag.appendChild(el);
                });
                return frag;
            }
            track.appendChild(buildSet());
            track.appendChild(buildSet());
        })();

        // Scroll reveal
        (function(){
            var els = document.querySelectorAll('.fade-up');
            if (!('IntersectionObserver' in window)) {
                els.forEach(function(el){ el.classList.add('in-view'); });
                return;
            }
            var io = new IntersectionObserver(function(entries){
                entries.forEach(function(entry){
                    if (entry.isIntersecting){
                        entry.target.classList.add('in-view');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            els.forEach(function(el){ io.observe(el); });
        })();

        // Sticky header behaviour
        (function(){
            var header = document.getElementById('siteHeader');
            var lastY = window.scrollY;
            var ticking = false;
            function update(){
                var y = window.scrollY;
                header.classList.toggle('scrolled', y > 20);
                if (y > lastY && y > 140) header.classList.add('hide');
                else header.classList.remove('hide');
                lastY = y;
                ticking = false;
            }
            window.addEventListener('scroll', function(){
                if (!ticking){ window.requestAnimationFrame(update); ticking = true; }
            });
        })();

        // Scroll progress + back to top
        (function(){
            var bar = document.getElementById('progress');
            var toTop = document.getElementById('toTop');
            window.addEventListener('scroll', function(){
                var h = document.documentElement;
                var pct = (h.scrollTop) / (h.scrollHeight - h.clientHeight) * 100;
                bar.style.width = pct + '%';
                toTop.classList.toggle('show', h.scrollTop > 500);
            });
            toTop.addEventListener('click', function(){
                window.scrollTo({top:0, behavior:'smooth'});
            });
        })();
    </script>

</body>
</html>
