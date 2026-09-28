@php
    $adminUser = Auth::user();
    $initial = strtoupper(mb_substr($adminUser->name ?? 'A', 0, 1));
    $navItems = [
        ['admin.dashboard', 'admin.dashboard', 'Dashboard', 'm2.25 12 8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
        ['admin.identity.edit', 'admin.identity.*', 'About Me', 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z'],
        ['admin.experience.index', 'admin.experience.*', 'Experience', 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0'],
        ['admin.education.index', 'admin.education.*', 'Education', 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5'],
        ['admin.skills.index', 'admin.skills.*', 'Skills', 'm3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z'],
        ['admin.projects.index', 'admin.projects.*', 'Projects', 'M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin | {{ config('app.name', 'Portfolio') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #admin-welcome { transition: opacity .8s ease; }
        .aw-up { opacity: 0; transform: translateY(14px); animation: awUp .8s ease forwards; }
        .aw-bar { animation: awBar 2.4s cubic-bezier(.4,0,.2,1) forwards; }
        @keyframes awUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes awBar { from { width: 0; } to { width: 100%; } }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">

    {{-- Welcome screen: shown once per browser session after logging in --}}
    <div id="admin-welcome" class="fixed inset-0 z-[100] flex items-center justify-center px-6 text-center text-white"
         style="background: radial-gradient(circle at 50% 30%, #2e1b6b 0%, #0b0b1c 60%, #05060a 100%);">
        <div class="max-w-md">
            <div class="aw-up mx-auto mb-6 w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-2xl font-bold shadow-lg shadow-purple-500/30" style="animation-delay:.1s">{{ $initial }}</div>
            <p id="aw-greet" class="aw-up text-sm tracking-[0.3em] uppercase text-purple-300" style="animation-delay:.3s">Welcome back</p>
            <h1 class="aw-up mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight" style="animation-delay:.6s">{{ $adminUser->name ?? 'Admin' }}</h1>
            <p class="aw-up mt-3 text-slate-400" style="animation-delay:1s">Getting your dashboard ready...</p>
            <div class="aw-up mt-8 mx-auto h-[3px] w-48 rounded-full bg-white/10 overflow-hidden" style="animation-delay:1.2s">
                <div class="aw-bar h-full rounded-full bg-gradient-to-r from-purple-400 to-indigo-400" style="animation-delay:1.2s; width:0"></div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            var el = document.getElementById('admin-welcome');
            var seen = false;
            try { seen = sessionStorage.getItem('adminWelcomed') === '1'; } catch (e) {}
            if (seen) { el.remove(); return; }
            var h = new Date().getHours();
            var greet = h < 12 ? 'Good morning' : (h < 18 ? 'Good afternoon' : 'Good evening');
            document.getElementById('aw-greet').textContent = greet + ', welcome back';
            setTimeout(function () {
                el.style.opacity = '0';
                el.style.pointerEvents = 'none';
                try { sessionStorage.setItem('adminWelcomed', '1'); } catch (e) {}
                setTimeout(function () { el.remove(); }, 850);
            }, 3200);
        })();
    </script>

    <div x-data="{ sidebar: false }" class="min-h-screen">

        {{-- Mobile backdrop --}}
        <div x-show="sidebar" x-transition.opacity @click="sidebar = false"
             class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" style="display:none"></div>

        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-slate-900 text-slate-300 transform transition-transform duration-300 lg:translate-x-0"
               :class="sidebar ? 'translate-x-0' : '-translate-x-full'">
            <div class="flex items-center gap-3 px-6 h-16 border-b border-white/10">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center text-white font-bold">{{ $initial }}</div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-white">Portfolio Admin</p>
                    <p class="text-xs text-slate-400">Content manager</p>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-1">
                @foreach ($navItems as [$route, $pattern, $label, $icon])
                    @php $active = request()->routeIs($pattern); @endphp
                    <a href="{{ route($route) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ $active ? 'bg-purple-500/15 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 {{ $active ? 'text-purple-400' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                        </svg>
                        {{ $label }}
                        @if ($active)<span class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-400"></span>@endif
                    </a>
                @endforeach
            </nav>

            <div class="px-3 py-4 border-t border-white/10 space-y-1">
                <a href="{{ route('portfolio.index') }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    View website
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                    Account
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="lg:pl-64 min-h-screen flex flex-col">
            <header class="sticky top-0 z-20 bg-white/85 backdrop-blur border-b border-slate-200">
                <div class="flex items-center gap-3 px-4 sm:px-6 lg:px-8 h-16">
                    <button type="button" @click="sidebar = true" class="lg:hidden -ml-1 p-2 rounded-lg text-slate-500 hover:bg-slate-100" aria-label="Open menu">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" /></svg>
                    </button>
                    <div class="flex-1 min-w-0">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2 class="font-semibold text-xl text-slate-800">Admin</h2>
                        @endisset
                    </div>
                    <div class="hidden sm:flex items-center gap-2 text-sm text-slate-500">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-indigo-500 text-white text-xs font-semibold flex items-center justify-center">{{ $initial }}</div>
                        <span class="font-medium text-slate-700">{{ $adminUser->name }}</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 sm:px-0 pb-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
