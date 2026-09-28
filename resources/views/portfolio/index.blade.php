<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $identity->name ?? 'My Portfolio' }} | {{ $identity->headline ?? 'Portfolio' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <meta name="theme-color" content="#05060a">
    <script>try { if (localStorage.getItem('theme') === 'light') document.documentElement.classList.remove('dark'); } catch (e) {}</script>
    @vite('resources/css/app.css')

    <style>
        html { font-family: 'Inter', sans-serif; }
        .font-mono-alt { font-family: 'JetBrains Mono', monospace; }

        /* ---- Loading screen ---- */
        #loader {
            position: fixed; inset: 0; z-index: 100; display: flex; align-items: center; justify-content: center;
            padding: 1.5rem; text-align: center; color: #e2e8f0;
            background: radial-gradient(circle at 50% 25%, #221350 0%, #0a0a18 55%, #05060a 100%);
            transition: transform .9s cubic-bezier(.77,0,.18,1), opacity .3s ease .7s;
        }
        html:not(.dark) #loader { color: #1e293b; background: radial-gradient(circle at 50% 25%, #ede4ff 0%, #f8f5ff 55%, #fdf2f8 100%); }
        #loader.hide { transform: translateY(-100%); opacity: 0; pointer-events: none; }
        .ld-inner { max-width: 26rem; width: 100%; display: flex; flex-direction: column; align-items: center; }
        .ld-chart { width: 9.5rem; margin-bottom: 1.75rem; overflow: visible; }
        .ld-bar { transform-box: fill-box; transform-origin: bottom; transform: scaleY(0);
            animation: ldRise .9s cubic-bezier(.16,1,.3,1) forwards, ldPulse 2.4s ease-in-out 1.8s infinite; }
        .ld-path { stroke-dasharray: 160; stroke-dashoffset: 160; animation: ldDraw 1.4s ease .9s forwards; }
        .ld-dot { opacity: 0; animation: ldFade .4s ease 2.2s forwards; }
        .ld-up { opacity: 0; transform: translateY(10px); animation: ldUp .8s ease forwards; }
        .ld-eyebrow { font-family: 'JetBrains Mono', monospace; font-size: .7rem; letter-spacing: .35em; color: #a855f7; }
        .ld-title { font-size: clamp(1.7rem, 6vw, 2.4rem); font-weight: 800; line-height: 1.15; letter-spacing: -.02em; }
        .ld-grad { background: linear-gradient(90deg, #a855f7, #6366f1); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .ld-sub { margin-top: .9rem; font-size: .9rem; opacity: .7; line-height: 1.6; }
        .ld-track { margin-top: 1.75rem; width: 12rem; height: 3px; border-radius: 999px; background: rgba(148,163,184,.25); overflow: hidden; }
        #loader-fill { height: 100%; width: 0; border-radius: inherit; background: linear-gradient(90deg, #a855f7, #6366f1); transition: width .15s linear; }
        .ld-pct { margin-top: .6rem; font-family: 'JetBrains Mono', monospace; font-size: .7rem; opacity: .6; }
        @keyframes ldRise { to { transform: scaleY(1); } }
        @keyframes ldPulse { 0%, 100% { opacity: .85; } 50% { opacity: .5; } }
        @keyframes ldDraw { to { stroke-dashoffset: 0; } }
        @keyframes ldFade { to { opacity: 1; } }
        @keyframes ldUp { to { opacity: 1; transform: translateY(0); } }

        /* ---- Drifting purple orbs (slow, staggered, "random"-feeling paths) ---- */
        .orb {
            position: absolute; border-radius: 9999px; filter: blur(70px);
            pointer-events: none; opacity: .55;
        }
        .orb-1 {
            width: 26rem; height: 26rem; top: -6rem; left: -4rem;
            background: radial-gradient(circle at 30% 30%, #a855f7, transparent 70%);
            animation: drift1 26s ease-in-out infinite;
        }
        .orb-2 {
            width: 20rem; height: 20rem; top: 8rem; right: -3rem;
            background: radial-gradient(circle at 60% 40%, #6366f1, transparent 70%);
            animation: drift2 32s ease-in-out infinite;
        }
        .orb-3 {
            width: 18rem; height: 18rem; bottom: -4rem; left: 30%;
            background: radial-gradient(circle at 50% 50%, #d946ef, transparent 70%);
            animation: drift3 38s ease-in-out infinite;
        }
        @keyframes drift1 {
            0%   { transform: translate(0, 0) scale(1); }
            25%  { transform: translate(40px, 30px) scale(1.08); }
            50%  { transform: translate(10px, 70px) scale(0.95); }
            75%  { transform: translate(-30px, 20px) scale(1.05); }
            100% { transform: translate(0, 0) scale(1); }
        }
        @keyframes drift2 {
            0%   { transform: translate(0, 0) scale(1); }
            30%  { transform: translate(-50px, 40px) scale(1.1); }
            60%  { transform: translate(-20px, -30px) scale(0.9); }
            100% { transform: translate(0, 0) scale(1); }
        }
        @keyframes drift3 {
            0%   { transform: translate(0, 0) scale(1); }
            20%  { transform: translate(30px, -20px) scale(1.05); }
            55%  { transform: translate(-40px, -50px) scale(1.15); }
            80%  { transform: translate(20px, -10px) scale(0.92); }
            100% { transform: translate(0, 0) scale(1); }
        }

        /* ---- Floating hero cards ---- */
        .float-card { animation: floatCard 6s ease-in-out infinite; }
        .float-card.delay-1 { animation-delay: .8s; }
        .float-card.delay-2 { animation-delay: 1.6s; }
        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        /* ---- Scroll reveal ---- */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.in { opacity: 1; transform: translateY(0); }

        /* ---- Glow / hover ---- */
        .glow-card { transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease; }
        .glow-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0 0 1px rgba(168,85,247,.3), 0 20px 40px -20px rgba(168,85,247,.35);
        }

        /* ---- Skill bar fill animation ---- */
        .skill-fill { width: 0; transition: width 1.1s cubic-bezier(.16,1,.3,1); }
        .skill-fill.filled { width: var(--fill); }

        /* ---- Toggle switch ---- */
        .toggle-track { transition: background-color .3s ease; }
        .toggle-thumb { transition: transform .3s ease; }
        .dark .toggle-thumb { transform: translateX(20px); }

        /* ---- Project video: play on hover, static poster otherwise ---- */
        .project-video { transition: transform .5s ease; }
        .project-card:hover .project-video { transform: scale(1.04); }

        ::selection { background: #a855f7; color: #05060a; }

        /* ---- Interactive extras ---- */
        .glow-card { position: relative; }
        .glow-card::after {
            content: ''; position: absolute; inset: 0; border-radius: inherit; pointer-events: none;
            opacity: 0; transition: opacity .3s ease;
            background: radial-gradient(360px circle at var(--mx, 50%) var(--my, 50%), rgba(168,85,247,.16), transparent 60%);
        }
        .glow-card:hover::after { opacity: 1; }
        .orb, .float-card { transition: translate .5s ease-out; }
        .nav-link.is-active { color: #a855f7; }
        .nav-link.is-active > span { width: 100%; }
        .skill-chip.chip-active { background: #a855f7; border-color: #a855f7; color: #fff; }
        .typed-caret { animation: blink 1s steps(1) infinite; color: #a855f7; }
        @keyframes blink { 50% { opacity: 0; } }

        /* ---- Skills showcase ---- */
        .skills-grid-bg {
            position: absolute; inset: -60px; pointer-events: none;
            background-image:
                linear-gradient(rgba(148,163,184,.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,.12) 1px, transparent 1px);
            background-size: 44px 44px;
            -webkit-mask-image: radial-gradient(ellipse at center, #000 25%, transparent 75%);
            mask-image: radial-gradient(ellipse at center, #000 25%, transparent 75%);
            animation: gridSlide 20s linear infinite;
        }
        @keyframes gridSlide { to { background-position: 44px 44px; } }
        .skills-orb {
            position: absolute; border-radius: 9999px; filter: blur(80px); pointer-events: none; opacity: .45;
        }
        .skills-orb.a { width: 22rem; height: 22rem; top: -4rem; left: 8%;
            background: radial-gradient(circle, #a855f7, transparent 70%); animation: drift1 28s ease-in-out infinite; }
        .skills-orb.b { width: 20rem; height: 20rem; bottom: -5rem; right: 6%;
            background: radial-gradient(circle, #6366f1, transparent 70%); animation: drift2 34s ease-in-out infinite; }

        #skill-pill {
            position: absolute; top: 6px; bottom: 6px; left: 0; width: 0; border-radius: 9999px;
            transition: transform .45s cubic-bezier(.16,1,.3,1), width .45s cubic-bezier(.16,1,.3,1);
        }
        .skill-tab { transition: color .3s ease; }
        .skill-tab.is-on { color: #fff; }

        .skill-tile {
            transition: transform .3s ease, opacity .22s ease, border-color .3s ease, box-shadow .3s ease;
        }
        .skill-tile:hover {
            transform: translateY(-6px);
            border-color: rgba(168,85,247,.5);
            box-shadow: 0 18px 40px -18px rgba(168,85,247,.55);
        }
        .skill-tile img { transition: transform .35s ease; }
        .skill-tile:hover img { transform: scale(1.12); }
        .skill-tile.tile-pre { opacity: 0; }
        .skill-tile.tile-out { opacity: 0; transform: translateY(8px) scale(.94); }
        .skill-tile.tile-in { animation: tileIn .55s cubic-bezier(.16,1,.3,1) backwards; }
        @keyframes tileIn {
            from { opacity: 0; transform: translateY(18px) scale(.92); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (prefers-reduced-motion: reduce) {
            .skills-grid-bg, .skills-orb { animation: none; }
        }

        /* ---- Day / night toggle ---- */
        .dn { position: relative; width: 60px; height: 30px; flex: none; border-radius: 9999px; border: 0; padding: 0; cursor: pointer; overflow: hidden;
              background: linear-gradient(180deg, #60a5fa 0%, #bae6fd 100%);
              box-shadow: inset 0 2px 5px rgba(15,23,42,.25), 0 0 0 1px rgba(255,255,255,.4);
              transition: background .6s ease; }
        html.dark .dn { background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
              box-shadow: inset 0 2px 5px rgba(0,0,0,.5), 0 0 0 1px rgba(255,255,255,.08); }
        .dn-knob { position: absolute; top: 4px; left: 4px; width: 22px; height: 22px; border-radius: 9999px; background: #fde047;
              box-shadow: 0 0 0 4px rgba(253,224,71,.25), 0 0 14px rgba(253,224,71,.9);
              transition: transform .6s cubic-bezier(.68,-.35,.27,1.35), background .5s ease, box-shadow .5s ease; }
        html.dark .dn-knob { transform: translateX(30px) rotate(-30deg); background: #e5e7eb;
              box-shadow: 0 0 0 4px rgba(226,232,240,.08), 0 0 10px rgba(226,232,240,.5); }
        .dn-crater { position: absolute; border-radius: 50%; background: #cbd5e1; opacity: 0; transition: opacity .4s ease .1s; }
        .dn-crater.a { width: 6px; height: 6px; top: 5px; left: 11px; }
        .dn-crater.b { width: 4px; height: 4px; top: 13px; left: 5px; }
        html.dark .dn-crater { opacity: 1; }
        .dn-cloud { position: absolute; background: #fff; border-radius: 9999px; opacity: .95; transition: transform .6s ease, opacity .4s ease; }
        .dn-cloud.c1 { width: 16px; height: 7px; right: 6px; bottom: 5px; }
        .dn-cloud.c2 { width: 11px; height: 6px; right: 15px; bottom: 9px; }
        html.dark .dn-cloud { opacity: 0; transform: translateY(14px); }
        .dn-star { position: absolute; width: 2px; height: 2px; border-radius: 50%; background: #fff; opacity: 0; transform: translateY(-10px);
              transition: opacity .4s ease .15s, transform .6s ease .1s; }
        .dn-star.s1 { left: 9px; top: 7px; }
        .dn-star.s2 { left: 17px; top: 18px; width: 3px; height: 3px; }
        .dn-star.s3 { left: 24px; top: 9px; }
        html.dark .dn-star { opacity: 1; transform: none; animation: twinkle 2.6s ease-in-out infinite; }
        html.dark .dn-star.s2 { animation-delay: .8s; }
        html.dark .dn-star.s3 { animation-delay: 1.6s; }
        @keyframes twinkle { 50% { opacity: .35; } }

        /* ---- Light mode polish ---- */
        body { overflow-x: hidden; }
        html:not(.dark) body { background-color: #faf7ff; }
        html:not(.dark) body::before {
            content: ''; position: fixed; inset: 0; z-index: -1; pointer-events: none;
            background:
                radial-gradient(60rem 40rem at 10% -5%, rgba(196,181,253,.45), transparent 60%),
                radial-gradient(50rem 36rem at 95% 10%, rgba(251,207,232,.5), transparent 60%),
                radial-gradient(55rem 40rem at 50% 105%, rgba(186,230,253,.45), transparent 60%);
        }
        html:not(.dark) #top, html:not(.dark) footer#contact { background: transparent; }
        html:not(.dark) [class*="bg-slate-50/60"] { background-color: rgba(255,255,255,.55); }
        html:not(.dark) header.fixed { box-shadow: 0 1px 24px -8px rgba(124,58,237,.2); }
        html:not(.dark) .orb { opacity: .4; }
        html:not(.dark) #top h1 { background: linear-gradient(120deg, #1e1b4b, #6d28d9 60%, #db2777); -webkit-background-clip: text; background-clip: text; color: transparent; }
        html:not(.dark) .glow-card { border-color: rgba(167,139,250,.28); box-shadow: 0 12px 32px -18px rgba(124,58,237,.35); }
        html:not(.dark) .glow-card:hover { border-color: rgba(147,112,255,.55); box-shadow: 0 22px 42px -18px rgba(124,58,237,.5); }
        html:not(.dark) .skill-tile { border-color: rgba(167,139,250,.28); box-shadow: 0 10px 28px -18px rgba(124,58,237,.35); }
        html:not(.dark) .skill-tile:hover { border-color: rgba(147,112,255,.55); box-shadow: 0 22px 42px -18px rgba(124,58,237,.5); }
    </style>
</head>
<body class="bg-white text-slate-800 dark:bg-[#05060a] dark:text-slate-200 antialiased transition-colors duration-500">

    {{-- ============ LOADING SCREEN ============ --}}
    <div id="loader" role="status" aria-live="polite">
        <div class="ld-inner">
            <svg class="ld-chart" viewBox="0 0 160 100" fill="none" aria-hidden="true">
                <defs>
                    <linearGradient id="ldGrad" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0" stop-color="#a855f7"/><stop offset="1" stop-color="#6366f1"/>
                    </linearGradient>
                </defs>
                <line x1="8" y1="90" x2="152" y2="90" stroke="currentColor" stroke-opacity=".2" stroke-width="1.5"/>
                <rect class="ld-bar" style="animation-delay:.1s,1.8s" x="20"  y="50" width="16" height="40" rx="3" fill="url(#ldGrad)"/>
                <rect class="ld-bar" style="animation-delay:.25s,2s"  x="48"  y="32" width="16" height="58" rx="3" fill="url(#ldGrad)"/>
                <rect class="ld-bar" style="animation-delay:.4s,2.2s" x="76"  y="56" width="16" height="34" rx="3" fill="url(#ldGrad)"/>
                <rect class="ld-bar" style="animation-delay:.55s,2.4s" x="104" y="20" width="16" height="70" rx="3" fill="url(#ldGrad)"/>
                <rect class="ld-bar" style="animation-delay:.7s,2.6s" x="132" y="38" width="16" height="52" rx="3" fill="url(#ldGrad)"/>
                <path class="ld-path" d="M28 44 L56 26 L84 50 L112 14 L140 32" stroke="#f0abfc" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <circle class="ld-dot" cx="140" cy="32" r="4.5" fill="#f0abfc"/>
            </svg>
            <p class="ld-eyebrow ld-up" style="animation-delay:.2s">WELCOME</p>
            <h2 class="ld-title ld-up mt-2" style="animation-delay:.5s">Hello there,</h2>
            <p class="ld-title ld-grad ld-up" style="animation-delay:1s">welcome to my portfolio.</p>
            <p class="ld-sub ld-up" style="animation-delay:1.6s">It is a pleasure to have you here. Please, make yourself at home.</p>
            <div class="ld-track"><div id="loader-fill"></div></div>
            <span class="ld-pct"><span id="loader-pct">0</span>%</span>
        </div>
    </div>

    <div id="scroll-progress" class="fixed top-0 left-0 h-[3px] z-50 bg-gradient-to-r from-purple-400 to-indigo-500" style="width:0%"></div>
    <button id="back-to-top" type="button" aria-label="Back to top"
            class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-purple-500 text-white shadow-lg hover:bg-purple-400 transition opacity-0 pointer-events-none">↑</button>

    {{-- ============ NAVBAR ============ --}}
    <header class="fixed top-0 inset-x-0 z-40 backdrop-blur-md bg-white/70 dark:bg-[#05060a]/70 border-b border-slate-200/70 dark:border-white/10 transition-colors duration-500">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
            <a href="#top" class="font-mono-alt font-semibold tracking-tight text-slate-900 dark:text-white">
                {{ $identity->name ?? 'Portfolio' }}<span class="text-purple-500">.</span>
            </a>

            <div class="hidden sm:flex items-center gap-7 text-sm font-medium text-slate-500 dark:text-slate-400">
                <a href="#about" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">About
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#cv" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">CV
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#projects" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">Projects
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#experience" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">Experience
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#skills" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">Skills
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#contact" class="nav-link relative hover:text-slate-900 dark:hover:text-white transition-colors group">Contact
                    <span class="absolute -bottom-1 left-0 w-0 h-px bg-purple-400 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <a href="#contact"
                   class="hidden sm:inline-flex px-4 py-2 rounded-full bg-purple-500 text-white text-sm font-medium hover:bg-purple-400 transition-colors">
                    Let's Talk
                </a>
                <button id="menu-toggle" type="button" aria-label="Menu" class="sm:hidden p-1 text-slate-600 dark:text-slate-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <button id="theme-toggle" type="button" class="dn" aria-label="Switch between day and night mode">
                    <span class="dn-cloud c1"></span><span class="dn-cloud c2"></span>
                    <span class="dn-star s1"></span><span class="dn-star s2"></span><span class="dn-star s3"></span>
                    <span class="dn-knob"><i class="dn-crater a"></i><i class="dn-crater b"></i></span>
                </button>
            </div>
        </nav>
        <div id="mobile-menu" class="hidden sm:hidden border-t border-slate-200/70 dark:border-white/10 bg-white/95 dark:bg-[#05060a]/95 backdrop-blur-md">
            <div class="px-6 py-4 flex flex-col gap-4 text-base font-medium text-slate-600 dark:text-slate-300">
                <a href="#about">About</a><a href="#cv">CV</a><a href="#projects">Projects</a><a href="#experience">Experience</a>
                <a href="#skills">Skills</a><a href="#contact">Contact</a>
            </div>
        </div>
    </header>

    {{-- ============ HERO ============ --}}
    <section id="top" class="relative overflow-hidden pt-32 sm:pt-40 pb-16 sm:pb-28 bg-white dark:bg-[#05060a] transition-colors duration-500">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div id="about" class="reveal relative max-w-6xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            {{-- Left: headline --}}
            <div class="text-center lg:text-left">
                <div class="lg:hidden mb-6 flex justify-center">
                    <div class="relative">
                        <div class="absolute -inset-1 rounded-full bg-gradient-to-tr from-purple-400 to-indigo-500 opacity-70 blur-md"></div>
                        @if ($identity && $identity->photo_url)
                            <img src="{{ $identity->photo_url }}" alt="{{ $identity->name }}" class="relative w-32 h-32 rounded-full object-cover ring-4 ring-white dark:ring-[#05060a]">
                        @else
                            <div class="relative w-32 h-32 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-4xl font-bold text-slate-400 ring-4 ring-white dark:ring-[#05060a]">{{ $identity ? strtoupper(substr($identity->name, 0, 1)) : '?' }}</div>
                        @endif
                    </div>
                </div>
                <p class="font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-4">
                    📊 DATA ANALYST &amp; BI ANALYST · <span id="typed" class="text-slate-500 dark:text-slate-300">Insights</span><span class="typed-caret">|</span>
                </p>
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                    {{ $identity->headline ?? 'Turning Data into Decisions' }}
                </h1>
                <p class="mt-5 max-w-xl mx-auto lg:mx-0 text-slate-500 dark:text-slate-400 leading-relaxed">
                    {{ $identity->bio ?? "I'm ".($identity->name ?? 'a data and business intelligence analyst').", turning raw data into KPIs, dashboards, and reports that help teams see what is happening and decide what to do next." }}
                </p>

                <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="#projects"
                       class="px-6 py-3 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-semibold hover:opacity-90 transition">
                        View My Work
                    </a>
                    <a href="#contact"
                       class="px-6 py-3 rounded-full border border-slate-300 dark:border-white/20 text-slate-700 dark:text-slate-200 text-sm font-semibold hover:border-purple-400 hover:text-purple-500 transition">
                        Let's Talk
                    </a>
                </div>

                <div class="mt-8 flex flex-wrap justify-center lg:justify-start gap-3 text-sm font-medium">
                    @if ($identity?->linkedin_url)
                        <a href="{{ $identity->linkedin_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">LinkedIn</a>
                    @endif
                    @if ($identity?->github_url)
                        <a href="{{ $identity->github_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">GitHub</a>
                    @endif
                    @if ($identity?->twitter_url)
                        <a href="{{ $identity->twitter_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">Twitter / X</a>
                    @endif
                    @if ($identity?->website_url)
                        <a href="{{ $identity->website_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">Website</a>
                    @endif
                </div>
            </div>

            {{-- Right: floating photo + badge cards --}}
            <div class="relative h-[420px] hidden lg:block">
                {{-- main photo card --}}
                <div class="float-card absolute top-6 left-16 w-56 rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10 rotate-[-3deg]">
                    @if ($identity && $identity->photo_url)
                        <img src="{{ $identity->photo_url }}" class="w-full h-64 object-cover">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-purple-500/30 to-indigo-500/30 flex items-center justify-center text-5xl font-bold text-white/60">
                            {{ $identity ? strtoupper(substr($identity->name, 0, 1)) : '?' }}
                        </div>
                    @endif
                </div>

                {{-- stat badge 1 --}}
                <div class="float-card delay-1 absolute top-2 right-4 bg-white dark:bg-white/10 backdrop-blur rounded-xl px-4 py-3 shadow-xl ring-1 ring-black/5 dark:ring-white/10 rotate-[2deg]">
                    <p class="text-lg font-bold text-slate-900 dark:text-white">On time</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Every delivery</p>
                </div>

                {{-- stat badge 2 --}}
                <div class="float-card delay-2 absolute bottom-8 right-0 bg-white dark:bg-white/10 backdrop-blur rounded-xl px-4 py-3 shadow-xl ring-1 ring-black/5 dark:ring-white/10 rotate-[-2deg]">
                    <p class="text-lg font-bold text-slate-900 dark:text-white"><span data-count="{{ $projects->count() ?: 10 }}">{{ $projects->count() ?: 10 }}</span>+</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Dashboards shipped</p>
                </div>

                {{-- secondary small card --}}
                <div class="float-card absolute bottom-0 left-0 w-40 rounded-2xl overflow-hidden shadow-xl ring-1 ring-white/10 rotate-[4deg] bg-gradient-to-br from-indigo-500/20 to-purple-500/20 h-28 flex items-center justify-center">
                    <span class="font-mono-alt text-xs text-white/70">📈 SQL · Python · BI</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CV DOWNLOAD ============ --}}
    @php
        $cvOptions = [
            ['creative', '🎨', 'Creative CV', 'A visual, design-forward layout that shows more of my personality.', $identity?->cv_creative_path],
            ['formal', '📄', 'Formal CV', 'A clean, traditional format that works well for recruiters and ATS systems.', $identity?->cv_formal_path],
        ];
    @endphp
    <section id="cv" class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20">
        <h2 class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-2">DOWNLOAD</h2>
        <h3 class="reveal text-2xl font-bold text-slate-900 dark:text-white mb-10">My CV</h3>

        <div class="grid sm:grid-cols-2 gap-6">
            @foreach ($cvOptions as [$type, $icon, $title, $desc, $path])
                <div class="reveal glow-card rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6">
                    <div class="text-3xl mb-3">{{ $icon }}</div>
                    <h4 class="font-semibold text-lg text-slate-900 dark:text-white">{{ $title }}</h4>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $desc }}</p>
                    @if ($path)
                        <a href="{{ route('cv.download', $type) }}"
                           class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-purple-500 text-white text-sm font-semibold hover:bg-purple-400 transition-colors">
                            Download PDF <span aria-hidden="true">↓</span>
                        </a>
                    @else
                        <span class="mt-5 inline-flex items-center px-5 py-2.5 rounded-full border border-slate-200 dark:border-white/10 text-slate-400 text-sm cursor-not-allowed">
                            Coming soon
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ PROJECTS ============ --}}
    <section id="projects" class="border-y border-slate-100 dark:border-white/10 bg-slate-50/60 dark:bg-white/[0.02] transition-colors duration-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20">
            <h2 class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-2">FEATURED WORK</h2>
            <h3 class="reveal text-2xl font-bold text-slate-900 dark:text-white mb-10">Projects</h3>

            @if ($projects->isEmpty())
                <p class="reveal text-slate-400 italic">No projects added yet — add some from the admin panel.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projects as $project)
                        <div class="project-card reveal glow-card group flex flex-col rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03]"
                             data-title="{{ $project->title }}"
                             data-media-type="{{ $project->media_path ? $project->media_type : '' }}"
                             data-media-src="{{ $project->media_url }}"
                             data-url="{{ $project->external_url }}"
                             data-tags="{{ $project->tags }}">
                            <div class="relative h-44 overflow-hidden bg-slate-100 dark:bg-black/30 cursor-pointer" data-open-project>
                                @if ($project->media_path && $project->media_type === 'video')
                                    <video class="project-video w-full h-full object-cover" src="{{ $project->media_url }}"
                                           autoplay muted loop playsinline></video>
                                @elseif ($project->media_path)
                                    <img class="project-video w-full h-full object-cover" src="{{ $project->media_url }}" alt="{{ $project->title }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-600 text-sm">No preview</div>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h4 class="font-semibold text-slate-900 dark:text-white">{{ $project->title }}</h4>
                                @if ($project->description)
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 line-clamp-3">{{ $project->description }}</p>
                                    <div class="proj-desc hidden">{{ $project->description }}</div>
                                    <button type="button" data-open-project
                                            class="mt-2 self-start text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">
                                        Read more &rarr;
                                    </button>
                                @endif

                                @if (count($project->tag_list))
                                    <div class="mt-3 flex flex-wrap gap-1.5">
                                        @foreach ($project->tag_list as $tag)
                                            <span class="text-[11px] font-mono-alt px-2 py-0.5 rounded-full bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-300">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($project->external_url)
                                    <a href="{{ $project->external_url }}" target="_blank"
                                       class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">
                                        View project →
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============ EXPERIENCE ============ --}}
    <section id="experience" class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20">
        <h2 class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-2">CAREER TIMELINE</h2>
        <h3 class="reveal text-2xl font-bold text-slate-900 dark:text-white mb-10">Work Experience</h3>

        <div class="space-y-6">
            @forelse ($experiences as $experience)
                <div class="reveal glow-card rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6">
                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                        <h4 class="font-semibold text-lg text-slate-900 dark:text-white">
                            {{ $experience->job_title }} <span class="text-slate-400 dark:text-slate-500">·</span> {{ $experience->company }}
                        </h4>
                        <span class="font-mono-alt text-xs text-slate-400 dark:text-slate-500">
                            {{ $experience->start_date->format('M Y') }}
                            –
                            {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?? 'Present') }}
                        </span>
                    </div>
                    @if ($experience->location)
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">{{ $experience->location }}</p>
                    @endif
                    @if ($experience->responsibilities)
                        <p class="mt-3 text-slate-600 dark:text-slate-300 whitespace-pre-line">{{ $experience->responsibilities }}</p>
                    @endif
                    @if ($experience->achievements)
                        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300 whitespace-pre-line">
                            <span class="font-medium text-purple-600 dark:text-purple-400">Impact:</span> {{ $experience->achievements }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-slate-400 italic">No work experience added yet.</p>
            @endforelse
        </div>
    </section>

    {{-- ============ EDUCATION ============ --}}
    <section class="border-y border-slate-100 dark:border-white/10 bg-slate-50/60 dark:bg-white/[0.02] transition-colors duration-500">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-14 sm:py-20">
            <h2 class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-2">BACKGROUND</h2>
            <h3 class="reveal text-2xl font-bold text-slate-900 dark:text-white mb-10">Education</h3>

            <div class="space-y-6">
                @forelse ($educations as $education)
                    <div class="reveal glow-card rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6">
                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                            <h4 class="font-semibold text-lg text-slate-900 dark:text-white">{{ $education->degree }}</h4>
                            <span class="font-mono-alt text-xs text-slate-400 dark:text-slate-500">
                                {{ $education->start_date->format('M Y') }}
                                –
                                {{ $education->end_date?->format('M Y') ?? 'Present' }}
                            </span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400">{{ $education->institution }}</p>
                        @if ($education->description)
                            <p class="mt-3 text-slate-600 dark:text-slate-300 whitespace-pre-line">{{ $education->description }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-slate-400 italic">No education entries added yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============ SKILLS ============ --}}
    @php
        // Auto-match skill names to Devicon logos. Unmatched skills fall back to the Icon field (emoji) or the first letter.
        $deviconMap = [
            'html' => 'html5', 'html/css' => 'html5', 'html5' => 'html5', 'css' => 'css3', 'css3' => 'css3',
            'javascript' => 'javascript', 'js' => 'javascript', 'typescript' => 'typescript',
            'python' => 'python', 'r' => 'r', 'php' => 'php', 'laravel' => 'laravel',
            'vue' => 'vuejs', 'vue.js' => 'vuejs', 'react' => 'react', 'node.js' => 'nodejs',
            'tailwind' => 'tailwindcss', 'tailwind css' => 'tailwindcss', 'bootstrap' => 'bootstrap',
            'mysql' => 'mysql', 'postgresql' => 'postgresql', 'mongodb' => 'mongodb',
            'git' => 'git', 'github' => 'github', 'docker' => 'docker', 'linux' => 'linux', 'figma' => 'figma',
            'pandas' => 'pandas', 'numpy' => 'numpy', 'jupyter' => 'jupyter',
            'aws' => 'amazonwebservices', 'azure' => 'azure', 'google cloud' => 'googlecloud',
        ];
    @endphp
    <section id="skills" class="relative overflow-hidden border-y border-slate-100 dark:border-white/10 bg-slate-50/60 dark:bg-white/[0.02] transition-colors duration-500">
        <div class="skills-grid-bg"></div>
        <div class="skills-orb a"></div>
        <div class="skills-orb b"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
            <h2 class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-2">TOOLKIT</h2>
            <h3 class="reveal text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Skills &amp; Tech Stack</h3>
            <p class="reveal mt-3 text-slate-500 dark:text-slate-400">The tools I use to turn raw data into decisions.</p>

            @if ($skills->isEmpty())
                <p class="mt-10 text-slate-400 italic">No skills added yet.</p>
            @else
                <div class="reveal mt-10 overflow-x-auto pb-2">
                    <div class="relative inline-flex p-1.5 rounded-full border border-slate-200 dark:border-white/10 bg-white/70 dark:bg-white/[0.04] backdrop-blur">
                        <div id="skill-pill" class="bg-slate-900 dark:bg-white/15"></div>
                        <button type="button" data-filter="all" class="skill-tab is-on relative z-10 px-6 py-2 rounded-full text-sm font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">All</button>
                        @foreach ($skills->keys() as $cat)
                            <button type="button" data-filter="{{ $cat }}" class="skill-tab relative z-10 px-6 py-2 rounded-full text-sm font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">{{ $cat }}</button>
                        @endforeach
                    </div>
                </div>

                <div id="skill-grid" class="mt-12 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-5">
                    @foreach ($skills as $category => $items)
                        @foreach ($items as $skill)
                            @php
                                $key = strtolower(trim($skill->name));
                                $isUrl = $skill->icon && preg_match('/^https?:\/\//i', $skill->icon);
                                $slug = $deviconMap[$key] ?? null;
                                $img = $isUrl ? $skill->icon : ($slug ? "https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/{$slug}/{$slug}-original.svg" : null);
                                $fallback = ($skill->icon && ! $isUrl) ? $skill->icon : strtoupper(mb_substr($skill->name, 0, 1));
                            @endphp
                            <div class="skill-tile group relative aspect-square rounded-2xl border border-slate-200 dark:border-white/10 bg-white/80 dark:bg-white/[0.04] backdrop-blur flex flex-col items-center justify-center gap-3 overflow-hidden"
                                 data-cat="{{ $category }}">
                                <span class="absolute top-2 right-3 font-mono-alt text-[10px] text-purple-500 dark:text-purple-400 opacity-0 group-hover:opacity-100 transition-opacity">{{ $skill->proficiency }}%</span>
                                @if ($img)
                                    <img src="{{ $img }}" alt="" loading="lazy" class="w-11 h-11 object-contain"
                                         onerror="this.classList.add('hidden');this.nextElementSibling.classList.remove('hidden')">
                                    <span class="hidden text-3xl leading-none">{{ $fallback }}</span>
                                @else
                                    <span class="text-3xl leading-none">{{ $fallback }}</span>
                                @endif
                                <span class="text-xs font-medium text-slate-600 dark:text-slate-300 px-2 text-center">{{ $skill->name }}</span>
                                <span class="absolute bottom-0 left-0 h-[3px] bg-gradient-to-r from-purple-400 to-indigo-500 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"
                                      style="width: {{ $skill->proficiency }}%"></span>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============ FOOTER / CONTACT ============ --}}
    <footer id="contact" class="relative overflow-hidden border-t border-slate-100 dark:border-white/10 bg-white dark:bg-[#05060a] transition-colors duration-500">

        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-56 bg-gradient-to-t from-purple-500/15 to-transparent"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-24 text-center">
            <p class="reveal font-mono-alt text-xs tracking-[0.25em] text-purple-500 dark:text-purple-400 mb-3">GET IN TOUCH</p>
            <h3 class="reveal text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white mb-5">
                Let's turn your data into decisions.
            </h3>

            @if ($identity?->email)
                <a href="mailto:{{ $identity->email }}"
                   class="reveal inline-flex max-w-full break-all px-6 sm:px-7 py-3 rounded-full bg-purple-500 text-white text-sm font-semibold hover:bg-purple-400 transition-colors">
                    {{ $identity->email }}
                </a>
            @endif

            <div class="reveal mt-6 flex flex-wrap justify-center gap-5 text-sm text-slate-400 dark:text-slate-500">
                @if ($identity?->phone) <span>{{ $identity->phone }}</span> @endif
                @if ($identity?->address) <span>{{ $identity->address }}</span> @endif
            </div>

            <div class="reveal mt-8 flex flex-wrap justify-center gap-6 text-sm font-medium">
                @if ($identity?->linkedin_url)
                    <a href="{{ $identity->linkedin_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">LinkedIn</a>
                @endif
                @if ($identity?->github_url)
                    <a href="{{ $identity->github_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">GitHub</a>
                @endif
                @if ($identity?->twitter_url)
                    <a href="{{ $identity->twitter_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">Twitter / X</a>
                @endif
                @if ($identity?->website_url)
                    <a href="{{ $identity->website_url }}" target="_blank" class="text-slate-400 hover:text-purple-500 transition-colors">Website</a>
                @endif
            </div>

            <p class="reveal mt-16 text-xs text-slate-400 dark:text-slate-600 font-mono-alt">
                &copy; {{ date('Y') }} {{ $identity->name ?? '' }} — Built with Laravel.
                <a href="{{ route('login') }}" class="underline hover:text-purple-500">Admin</a>
            </p>
        </div>
    </footer>

    {{-- ============ PROJECT DETAILS MODAL ============ --}}
    <div id="project-modal" class="fixed inset-0 z-[90] hidden items-end sm:items-center justify-center p-0 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="pm-title">
        <div id="pm-backdrop" class="absolute inset-0 bg-black/70 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
        <div id="pm-panel" class="relative w-full sm:max-w-3xl max-h-[92vh] overflow-y-auto rounded-t-3xl sm:rounded-3xl bg-white dark:bg-[#0d0e16] border border-slate-200 dark:border-white/10 shadow-2xl opacity-0 translate-y-6 transition duration-300">
            <button id="pm-close" type="button" aria-label="Close"
                    class="absolute top-3 right-3 z-10 w-9 h-9 rounded-full bg-black/50 text-white text-lg leading-none hover:bg-black/70 transition">&times;</button>
            <div id="pm-media" class="bg-slate-100 dark:bg-black/40"></div>
            <div class="p-6 sm:p-8">
                <h3 id="pm-title" class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white"></h3>
                <div id="pm-tags" class="mt-3 flex flex-wrap gap-1.5"></div>
                <div id="pm-desc" class="mt-5 text-sm sm:text-base leading-relaxed whitespace-pre-line text-slate-600 dark:text-slate-300"></div>
                <a id="pm-link" href="#" target="_blank" rel="noopener"
                   class="hidden mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-purple-500 text-white text-sm font-semibold hover:bg-purple-400 transition-colors">
                    View project &rarr;
                </a>
            </div>
        </div>
    </div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Loading screen: shows for at least ~3s so the greeting can be read
            const loader = document.getElementById('loader');
            const pctEl = document.getElementById('loader-pct');
            const fillEl = document.getElementById('loader-fill');
            const t0 = performance.now(), MIN = 3000;
            let loaded = document.readyState === 'complete';
            window.addEventListener('load', () => { loaded = true; });
            setTimeout(() => { loaded = true; }, 6000);
            (function tick(now) {
                const t = Math.min((now - t0) / MIN, 1);
                const pct = Math.round((loaded ? t : Math.min(t, 0.9)) * 100);
                pctEl.textContent = pct;
                fillEl.style.width = pct + '%';
                if (t >= 1 && loaded) { loader.classList.add('hide'); return; }
                requestAnimationFrame(tick);
            })(t0);

            const toggle = document.getElementById('theme-toggle');
            toggle.addEventListener('click', function () {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            });

            const revealEls = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            revealEls.forEach(el => revealObserver.observe(el));

            const skillFills = document.querySelectorAll('.skill-fill');
            const skillObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('filled');
                        skillObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.3 });
            skillFills.forEach(el => skillObserver.observe(el));
        });

        document.addEventListener('DOMContentLoaded', function () {
            const bar = document.getElementById('scroll-progress');
            const topBtn = document.getElementById('back-to-top');
            const onScroll = () => {
                const h = document.documentElement;
                bar.style.width = (h.scrollTop / ((h.scrollHeight - h.clientHeight) || 1)) * 100 + '%';
                const hide = h.scrollTop < 600;
                topBtn.classList.toggle('opacity-0', hide);
                topBtn.classList.toggle('pointer-events-none', hide);
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
            topBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

            const menu = document.getElementById('mobile-menu');
            document.getElementById('menu-toggle').addEventListener('click', () => menu.classList.toggle('hidden'));
            menu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => menu.classList.add('hidden')));

            const links = document.querySelectorAll('.nav-link');
            const spy = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) links.forEach(l => l.classList.toggle('is-active', l.getAttribute('href') === '#' + e.target.id));
                });
            }, { rootMargin: '-45% 0px -50% 0px' });
            ['about', 'cv', 'projects', 'experience', 'skills', 'contact'].forEach(id => { const el = document.getElementById(id); if (el) spy.observe(el); });

            const words = ['Insights', 'Dashboards', 'KPIs', 'Reports', 'Decisions'];
            const typed = document.getElementById('typed');
            let wi = 0, ci = 0, del = false;
            (function tick() {
                const w = words[wi];
                typed.textContent = w.slice(0, ci);
                if (!del && ci === w.length) { del = true; return setTimeout(tick, 1400); }
                if (del && ci === 0) { del = false; wi = (wi + 1) % words.length; }
                ci += del ? -1 : 1;
                setTimeout(tick, del ? 45 : 90);
            })();

            const cObs = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (!e.isIntersecting) return;
                    const el = e.target, end = +el.dataset.count, t0 = performance.now();
                    const step = (t) => {
                        const p = Math.min((t - t0) / 1200, 1);
                        el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3)));
                        if (p < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                    cObs.unobserve(el);
                });
            }, { threshold: 0.6 });
            document.querySelectorAll('[data-count]').forEach(c => cObs.observe(c));

            document.querySelectorAll('.glow-card').forEach(card => {
                card.addEventListener('mousemove', e => {
                    const r = card.getBoundingClientRect();
                    card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    card.style.setProperty('--my', (e.clientY - r.top) + 'px');
                });
            });

            const hero = document.getElementById('top');
            const layers = [
                ...[...hero.querySelectorAll('.orb')].map((el, i) => [el, [-18, -26, -12][i] || -14]),
                ...[...hero.querySelectorAll('.float-card')].map((el, i) => [el, [16, 26, 12, 20][i] || 14]),
            ];
            hero.addEventListener('mousemove', e => {
                const x = e.clientX / window.innerWidth - .5, y = e.clientY / window.innerHeight - .5;
                layers.forEach(([el, d]) => { el.style.translate = (x * d * 2) + 'px ' + (y * d * 2) + 'px'; });
            });

            // Skills: sliding tab pill + staggered tile transitions
            const tabs = document.querySelectorAll('.skill-tab');
            const tiles = [...document.querySelectorAll('.skill-tile')];
            const pill = document.getElementById('skill-pill');
            const grid = document.getElementById('skill-grid');
            if (tabs.length && grid) {
                let current = 'all', busy = false;
                const movePill = (btn) => {
                    pill.style.width = btn.offsetWidth + 'px';
                    pill.style.transform = 'translateX(' + btn.offsetLeft + 'px)';
                };
                const play = (filter) => {
                    let n = 0;
                    tiles.forEach(t => {
                        const show = filter === 'all' || t.dataset.cat === filter;
                        t.classList.remove('tile-pre', 'tile-out', 'tile-in');
                        t.classList.toggle('hidden', !show);
                        if (show) {
                            void t.offsetWidth;
                            t.style.animationDelay = (n++ * 45) + 'ms';
                            t.classList.add('tile-in');
                        }
                    });
                };
                const activeTab = () => document.querySelector('.skill-tab.is-on');
                movePill(activeTab());
                window.addEventListener('load', () => movePill(activeTab()));
                window.addEventListener('resize', () => movePill(activeTab()));

                tiles.forEach(t => t.classList.add('tile-pre'));
                const gridObs = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) { play('all'); gridObs.disconnect(); }
                }, { threshold: 0.15 });
                gridObs.observe(grid);

                tabs.forEach(tab => tab.addEventListener('click', () => {
                    if (busy || tab.dataset.filter === current) return;
                    busy = true;
                    current = tab.dataset.filter;
                    tabs.forEach(t => t.classList.toggle('is-on', t === tab));
                    movePill(tab);
                    tiles.forEach(t => { t.classList.remove('tile-in', 'tile-pre'); t.classList.add('tile-out'); });
                    setTimeout(() => { play(current); busy = false; }, 240);
                }));
            }

            // Project details modal
            const modal = document.getElementById('project-modal');
            if (modal) {
                const panel = document.getElementById('pm-panel');
                const backdrop = document.getElementById('pm-backdrop');
                const mediaBox = document.getElementById('pm-media');
                let lastTrigger = null;

                const openModal = (card, trigger) => {
                    lastTrigger = trigger;
                    document.getElementById('pm-title').textContent = card.dataset.title || '';
                    const descEl = card.querySelector('.proj-desc');
                    document.getElementById('pm-desc').textContent = descEl ? descEl.textContent.trim() : '';

                    const tagsBox = document.getElementById('pm-tags');
                    tagsBox.innerHTML = '';
                    (card.dataset.tags || '').split(',').map(t => t.trim()).filter(Boolean).forEach(t => {
                        const span = document.createElement('span');
                        span.className = 'text-[11px] font-mono-alt px-2 py-0.5 rounded-full bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-300';
                        span.textContent = t;
                        tagsBox.appendChild(span);
                    });

                    mediaBox.innerHTML = '';
                    const src = card.dataset.mediaSrc, type = card.dataset.mediaType;
                    if (src && type === 'video') {
                        const v = document.createElement('video');
                        v.src = src; v.controls = true; v.autoplay = true; v.muted = true; v.loop = true; v.playsInline = true;
                        v.className = 'w-full max-h-[50vh] bg-black';
                        mediaBox.appendChild(v);
                    } else if (src && type === 'image') {
                        const img = document.createElement('img');
                        img.src = src; img.alt = card.dataset.title || '';
                        img.className = 'w-full max-h-[50vh] object-contain';
                        mediaBox.appendChild(img);
                    }

                    const link = document.getElementById('pm-link');
                    if (card.dataset.url) { link.href = card.dataset.url; link.classList.remove('hidden'); }
                    else { link.classList.add('hidden'); }

                    modal.classList.remove('hidden'); modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                    panel.scrollTop = 0;
                    requestAnimationFrame(() => {
                        backdrop.classList.replace('opacity-0', 'opacity-100');
                        panel.classList.remove('opacity-0', 'translate-y-6');
                        panel.classList.add('opacity-100', 'translate-y-0');
                    });
                    document.getElementById('pm-close').focus();
                };

                const closeModal = () => {
                    backdrop.classList.replace('opacity-100', 'opacity-0');
                    panel.classList.remove('opacity-100', 'translate-y-0');
                    panel.classList.add('opacity-0', 'translate-y-6');
                    setTimeout(() => {
                        modal.classList.add('hidden'); modal.classList.remove('flex');
                        mediaBox.innerHTML = '';
                        document.body.style.overflow = '';
                        if (lastTrigger) lastTrigger.focus();
                    }, 300);
                };

                document.querySelectorAll('[data-open-project]').forEach(el => {
                    el.addEventListener('click', () => openModal(el.closest('.project-card'), el));
                });
                backdrop.addEventListener('click', closeModal);
                document.getElementById('pm-close').addEventListener('click', closeModal);
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
                });
            }
        });
    </script>
</body>
</html>
