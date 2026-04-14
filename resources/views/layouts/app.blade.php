    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Showroom Europa</title>
    
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>

    <body class="bg-[#020617] text-slate-100 antialiased">
    <div class="flex">

        {{-- SIDEBAR --}}
        <aside
            class="fixed inset-y-0 left-0 w-64
                bg-gradient-to-b from-[#020617] via-[#020617]/95 to-black
                border-r border-white/10
                px-6 py-8
                z-50
                flex flex-col">

            {{-- LOGO --}}
            <div class="mb-12">
                <h1 class="text-2xl font-extrabold tracking-wide text-white">
                    SHOWROOM
                </h1>
                <p class="text-xs text-slate-400 tracking-widest">
                    PLENGER
                </p>
            </div>

            {{-- NAV --}}
            <nav class="flex-1 space-y-1 text-sm">
                <a href="{{ route('home') }}"
                class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('stock') }}"
                class="sidebar-link {{ request()->routeIs('stock') ? 'active' : '' }}">
                    Stock
                </a>

                <a href="{{ route('service') }}"
                class="sidebar-link {{ request()->routeIs('service') ? 'active' : '' }}">
                    Bengkel
                </a>

                @auth
                    {{-- Menu Admin --}}
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.request') }}"
                        class="sidebar-link {{ request()->routeIs('admin.request') ? 'active' : '' }}">
                            Request
                        </a>
                    @endif


                @if(auth()->user()->role === 'user')
                <a href="{{ route('user.orders') }}"
                class="sidebar-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                    Riwayat
                </a>
            @endif

            @endauth






                <a href="{{ route('masukan.rating') }}"
                class="sidebar-link {{ request()->routeIs('masukan') ? 'active' : '' }}">
                    Masukan
                </a>

            {{-- AUTH BUTTON --}}
                <div class="pt-6 mt-6 border-t border-white/10">

                    @auth
                    <div class="text-sm text-slate-300">
                Hello, {{ Auth::user()->name }}
            </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="sidebar-link w-full text-left text-red-400 hover:text-red-300">
                                Logout
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                        class="sidebar-link text-emerald-400 hover:text-emerald-300">
                            Login
                        </a>
                    @endguest

                </div>
            </nav>
            {{-- FOOTER --}}
            <div class="pt-6 border-t border-white/10 text-xs text-slate-500">
                © {{ date('Y') }} Showroom Europa
            </div>
        </aside>

        {{-- CONTENT --}}
        <main class="ml-64 min-h-screen w-full overflow-x-hidden">
            {{ $slot }}
        </main>

    </div>

    @livewireScripts

    <style>
/* BASE LINK */
.sidebar-link {
    display: block;
    padding: .9rem 1.1rem;
    border-radius: .9rem;
    font-weight: 500;
    color: #cbd5f5;
    position: relative;
    transition: all .25s ease;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.04);
    letter-spacing: .02em;
}

/* soft glow layer */
.sidebar-link::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: .9rem;
    background: linear-gradient(
        90deg,
        rgba(16,185,129,.25),
        rgba(16,185,129,.08),
        transparent
    );
    opacity: 0;
    transition: opacity .25s ease;
}

/* hover */
.sidebar-link:hover {
    color: white;
    transform: translateX(6px);
    background: rgba(255,255,255,0.05);
    border-color: rgba(255,255,255,0.1);
    box-shadow: 0 8px 30px rgba(0,0,0,0.35);
}

.sidebar-link:hover::before {
    opacity: 1;
}

/* active */
.sidebar-link.active {
    background: linear-gradient(
        90deg,
        rgba(16,185,129,.35),
        rgba(255,255,255,.05)
    );
    color: white;
    font-weight: 600;
    border-color: rgba(255,255,255,0.15);
    box-shadow:
        0 0 0 1px rgba(16,185,129,0.2),
        0 10px 40px rgba(16,185,129,0.15);
}
</style>


    </body>
    </html>
