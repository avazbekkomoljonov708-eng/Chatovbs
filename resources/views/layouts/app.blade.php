<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ChatO'VBS</title>

     <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        :root {
            --ink: #0a0a0a;
            --paper: #faf9f6;
            --line-soft: #e6e3db;
            --muted: #6b6b66;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--paper);
        }

        /* ---------- HEADER ---------- */
        .site-header {
            background: var(--ink);
            border-bottom: 1px solid #1c1c1c;
            padding: 0;
        }

        .site-header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 66px;
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 32px;
        }

        .site-brand {
            font-family: 'Sora', sans-serif;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 0.01em;
            color: var(--paper);
            text-decoration: none;
            display: flex;
            align-items: baseline;
            gap: 1px;
            transition: opacity 0.2s ease;
        }

        .site-brand:hover {
            opacity: 0.8;
            color: var(--paper);
        }

        .site-brand .brand-apo {
            color: #8a8a85;
            font-weight: 400;
        }



                .brand-logo {
            position: relative;
            display: block;
            width: 42px;
            height: 42px;
        }
        .brand-logo img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: opacity 0.25s ease;
        }
        .brand-logo .logo-hover { opacity: 0; }
        .site-brand:hover .brand-logo .logo-default { opacity: 0; }
        .site-brand:hover .brand-logo .logo-hover { opacity: 1; }

        .site-nav-toggle {
            display: none;
            background: transparent;
            border: 1.5px solid #333;
            border-radius: 8px;
            padding: 7px 9px;
            cursor: pointer;
        }

        .site-nav-toggle span {
            display: block;
            width: 18px;
            height: 1.5px;
            background: var(--paper);
            margin: 3.5px 0;
            border-radius: 2px;
        }

        .site-nav-collapse {
            display: flex;
            align-items: center;
        }

        .site-nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .site-nav-links .nav-link {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            color: #b7b6b0;
            text-decoration: none;
            padding: 8px 0;
            position: relative;
            transition: color 0.2s ease;
        }

        .site-nav-links .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 2px;
            width: 0;
            height: 1.5px;
            background: var(--paper);
            transition: width 0.25s ease;
        }

        .site-nav-links .nav-link:hover {
            color: var(--paper);
        }

        .site-nav-links .nav-link:hover::after {
            width: 100%;
        }

        .site-nav-links .nav-cta {
            color: var(--ink);
            background: var(--paper);
            border-radius: 8px;
            padding: 9px 18px;
            font-weight: 600;
        }

        .site-nav-links .nav-cta::after { display: none; }

        .site-nav-links .nav-cta:hover {
            color: var(--ink);
            opacity: 0.88;
        }

        .site-user-dropdown {
            position: relative;
        }

        .site-user-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            border: 1.5px solid #333;
            border-radius: 999px;
            padding: 6px 14px 6px 8px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            color: var(--paper);
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .site-user-toggle:hover {
            border-color: #555;
            background: rgba(255,255,255,0.04);
        }

        .site-user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--paper);
            color: var(--ink);
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            flex-shrink: 0;
        }

        .site-user-toggle svg {
            width: 13px;
            height: 13px;
            stroke: #8a8a85;
            transition: transform 0.2s ease;
        }

        .site-user-dropdown.open .site-user-toggle svg {
            transform: rotate(180deg);
        }

        .site-user-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 180px;
            background: var(--paper);
            border-radius: 12px;
            box-shadow: 0 20px 44px rgba(0,0,0,0.28);
            padding: 6px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
            z-index: 50;
        }

        .site-user-dropdown.open .site-user-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .site-user-menu .dropdown-item {
            display: block;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            background: transparent;
            border: none;
            border-radius: 8px;
            padding: 10px 12px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .site-user-menu .dropdown-item:hover {
            background: var(--line-soft);
            color: var(--ink);
        }

        @media (max-width: 767px) {
            .site-header .container { height: 60px; padding: 0 20px; }
            .site-nav-toggle { display: block; }
            .site-nav-collapse {
                display: none;
                position: absolute;
                top: 60px;
                left: 0;
                right: 0;
                background: var(--ink);
                border-top: 1px solid #1c1c1c;
                padding: 16px 20px 20px;
            }
            .site-nav-collapse.show { display: block; }
            .site-nav-links {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                width: 100%;
            }
            .site-nav-links .nav-link { width: 100%; padding: 10px 0; }
            .site-nav-links .nav-cta { width: 100%; text-align: center; margin-top: 6px; }
            .site-user-dropdown { width: 100%; }
            .site-user-toggle { width: 100%; justify-content: space-between; }
            .site-user-menu { position: static; box-shadow: none; margin-top: 8px; opacity: 1; visibility: visible; transform: none; display: none; }
            .site-user-dropdown.open .site-user-menu { display: block; }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="site-header">
            <div class="container">
                <a class="site-brand" href="{{ url('/') }}">
                    @php $brand = ['C','h','a','t','O']; @endphp
                    @foreach ($brand as $letter)
                        <span>{{ $letter }}</span>
                    @endforeach
                    <span class="brand-apo">'</span>
                    @foreach (['V','B','S'] as $letter)
                        <span>{{ $letter }}</span>
                    @endforeach
                </a>

                <button class="site-nav-toggle" type="button" id="siteNavToggle" aria-label="{{ __('Toggle navigation') }}">
                    <span></span><span></span><span></span>
                </button>

                <div class="site-nav-collapse" id="siteNavCollapse">
                    <ul class="site-nav-links">
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @if (Route::has('register'))
                                <li><a class="nav-link nav-cta" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @endif
                        @else
                            <li>
                                <div class="site-user-dropdown" id="siteUserDropdown">
                                    <button class="site-user-toggle" type="button" id="siteUserToggle">
                                        <span class="site-user-avatar">{{ Str::substr(Auth::user()->name, 0, 1) }}</span>
                                        <span v-pre>{{ Auth::user()->name }}</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"></path></svg>
                                    </button>

                                    <div class="site-user-menu">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
        (function () {
            var navToggle = document.getElementById('siteNavToggle');
            var navCollapse = document.getElementById('siteNavCollapse');
            if (navToggle && navCollapse) {
                navToggle.addEventListener('click', function () {
                    navCollapse.classList.toggle('show');
                });
            }

            var userDropdown = document.getElementById('siteUserDropdown');
            var userToggle = document.getElementById('siteUserToggle');
            if (userDropdown && userToggle) {
                userToggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('open');
                });
                document.addEventListener('click', function (e) {
                    if (!userDropdown.contains(e.target)) {
                        userDropdown.classList.remove('open');
                    }
                });
            }
        })();
    </script>
</body>
</html>