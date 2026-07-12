<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="mytheme">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Reem+Kufi:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="bg-[#fbfaf6] text-ink-900 selection:bg-gold-200 selection:text-ink-900">
        <!-- Navbar -->
        <header id="siteHeader" class="fixed top-0 z-50 w-full border-b border-transparent bg-transparent backdrop-blur-lg transition-colors duration-300">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-8">
                <a href="#" class="flex items-center gap-3">
                    {{-- <div class="flex h-11 w-11 items-center justify-center rounded-t-[999px] rounded-b-lg bg-linear-to-b from-primary-500 to-primary-800 shadow-gold ring-2 ring-gold-400">
                        <svg class="h-5 w-5 text-gold-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 3c-2.5 2-3.5 4.7-3.5 7.2 0 3.9 2.6 6.8 3.5 7.8.9-1 3.5-3.9 3.5-7.8C15.5 7.7 14.5 5 12 3z" stroke-linejoin="round"/>
                        </svg>
                    </div> --}}
                    <div>
                        <div class="flex justify-center items-center gap-2">
                            <img src="{{ asset('assets/img/logo/square-light.png') }}" alt="Logo" class="h-10 w-auto transition-all duration-300" />
                            <div class="flex flex-col justify-center gap-1">
                                <p id="brandTitle" class="font-display leading-none tracking-wide text-gold-100 transition-colors duration-300">EXTERA TRAVEL</p>
                                <p id="brandSubtitle" class="text-[8px] uppercase tracking-[0.2em] text-gold-100/80 transition-colors duration-300">Umrah • Haji • Wisata Religi </p>
                            </div>
                        </div>
                    </div>
                </a>

                <ul id="desktopNav" class="hidden items-center gap-8 text-sm font-semibold md:flex text-gold-100 transition-colors duration-300">
                    <li><a href="#hero" class="nav-link transition">Home</a></li>
                    <li><a href="#paket" class="nav-link transition">Paket</a></li>
                    <li><a href="#kenapa-kita" class="nav-link transition">Kenapa Kita</a></li>
                    <li><a href="#testimoni" class="nav-link transition">Testimoni</a></li>
                    <li><a href="#kontak" class="nav-link transition">Kontak</a></li>
                </ul>

                <div class="flex items-center gap-3">
                    <a href="#paket" class="hidden rounded-full bg-gold-400 px-5 py-2.5 text-sm font-bold text-ink-900 shadow-gold transition hover:bg-gold-300 md:inline-block">Gabung Sekarang</a>
                    <button id="menuBtn" class="rounded-xl border border-gold-200 bg-white/90 p-2 text-primary-700 md:hidden transition-colors duration-300" aria-label="Open menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </nav>

            <div id="mobileMenu" class="hidden bg-ink-950/95 backdrop-blur-lg px-6 py-4 md:hidden transition-colors duration-300">
                <ul class="space-y-2 text-sm font-semibold">
                    <li><a href="#hero" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Home</a></li>
                    <li><a href="#paket" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Paket</a></li>
                    <li><a href="#kenapa-kita" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Kenapa Kita</a></li>
                    <li><a href="#testimoni" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Testimoni</a></li>
                    <li><a href="#kontak" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Kontak</a></li>
                    <li><a href="#paket" class="mt-2 block rounded-full bg-gold-400 px-4 py-2 text-center font-bold text-ink-900">Gabung Sekarang</a></li>
                </ul>
            </div>
        </header>

        @yield('content')

        <!-- Footer -->
        <div style="--scallop-color:#050505" class="scallop"></div>
        <footer id="kontak" class="bg-ink-950 text-ink-100">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 lg:grid-cols-3 lg:px-8">
                <div>
                    <h3 class="font-display text-lg text-gold-100">Extera Travel</h3>
                    <p class="mt-3 text-sm text-ink-100/70">Teman perjalanan ibadah untuk anak muda — aman, nyaman, dan penuh makna.</p>
                </div>

                <div>
                    <h4 class="font-bold text-gold-100">Menu</h4>
                    <ul class="mt-3 space-y-2 text-sm text-ink-100/70">
                        <li><a href="#hero" class="hover:text-white">Home</a></li>
                        <li><a href="#paket" class="hover:text-white">Paket</a></li>
                        <li><a href="#kenapa-kita" class="hover:text-white">Kenapa Kita</a></li>
                        <li><a href="#testimoni" class="hover:text-white">Testimoni</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gold-100">Kontak</h4>
                    <ul class="mt-3 space-y-2 text-sm text-ink-100/70">
                        <li>Jl. Contoh Alamat No. 123</li>
                        <li>+62 812-3456-7890</li>
                        <li>hello@exteratravel.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 py-4 text-center text-xs text-ink-100/50">
                © 2026 Extera Travel. All rights reserved.
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
