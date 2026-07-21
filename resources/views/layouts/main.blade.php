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
        
        <!-- Icon -->
        <link rel="mask-icon" href="{{ asset('assets/img/logo/square-light.png') }}">
        <link rel="alternate icon" class="js-site-favicon" type="image/png" href="{{ asset('assets/img/logo/square-light.png') }}">
        <link rel="icon" class="js-site-favicon" type="image/png" href="{{ asset('assets/img/logo/square-light.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/square-light.png') }}">
        <link rel="shortcut icon" href="{{ asset('assets/img/logo/square-light.png') }}" type="image/x-icon">

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
                    <li><a href="/" class="nav-link transition">Home</a></li>
                    <li><a href="/packages" class="nav-link transition">Paket</a></li>
                    <li><a href="/blogs" class="nav-link transition">Artikel</a></li>
                    <li><a href="/faq" class="nav-link transition">FAQ</a></li>
                    <li><a href="/contact" class="nav-link transition">Kontak</a></li>
                </ul>

                <div class="flex items-center gap-3">
                    <a href="/packages" class="hidden rounded-full bg-gold-400 px-5 py-2.5 text-sm font-bold text-ink-900 shadow-gold transition hover:bg-gold-300 md:inline-block">Gabung Sekarang</a>
                    <button id="menuBtn" class="rounded-xl border border-gold-200 bg-white/90 p-2 text-primary-700 md:hidden transition-colors duration-300" aria-label="Open menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </nav>

            <div id="mobileMenu" class="hidden bg-ink-950/95 backdrop-blur-lg px-6 py-4 md:hidden transition-colors duration-300">
                <ul class="space-y-2 text-sm font-semibold">
                    <li><a href="/" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Home</a></li>
                    <li><a href="/packages" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Paket</a></li>
                    <li><a href="/blogs" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Artikel</a></li>
                    <li><a href="/packages" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Paket</a></li>
                    <li><a href="/faq" class="mobile-nav-link block rounded-lg px-3 py-2 transition">FAQ</a></li>
                    <li><a href="/contact" class="mobile-nav-link block rounded-lg px-3 py-2 transition">Kontak</a></li>
                    <li><a href="/packages" class="mt-2 block rounded-full bg-gold-400 px-4 py-2 text-center font-bold text-ink-900">Gabung Sekarang</a></li>
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
                        <li><a href="/" class="hover:text-white">Home</a></li>
                        <li><a href="/packages" class="hover:text-white">Paket</a></li>
                        <li><a href="/blogs" class="hover:text-white">Artikel</a></li>
                        <li><a href="/faq" class="hover:text-white">FAQ</a></li>
                        <li><a href="/contact" class="hover:text-white">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gold-100">Kontak</h4>
                    <ul class="mt-3 space-y-2 text-sm text-ink-100/70">
                        <li>{{ \App\Helpers\PreferenceHelper::get('address', 'Jl. Contoh Alamat No. 123') }}</li>
                        <li>{{ \App\Helpers\PreferenceHelper::get('whatsapp_number', '+62 812-3456-7890') }}</li>
                        <li>{{ \App\Helpers\PreferenceHelper::get('email', 'hello@exteratravel.com') }}</li>
                    </ul>
                    @php($facebook = \App\Helpers\PreferenceHelper::get('facebook_account'))
                    @php($instagram = \App\Helpers\PreferenceHelper::get('instagram_account'))
                    @php($tiktok = \App\Helpers\PreferenceHelper::get('tiktok_account'))
                    @if($facebook || $instagram || $tiktok)
                        <div class="mt-4">
                            <h4 class="font-bold text-gold-100">Sosial Media</h4>
                            <div class="mt-2 flex gap-3">
                                @if($instagram)
                                    <a href="{{ $instagram }}" target="_blank" class="text-ink-100/70 hover:text-white transition" title="Instagram">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                @endif
                                @if($tiktok)
                                    <a href="{{ $tiktok }}" target="_blank" class="text-ink-100/70 hover:text-white transition" title="TikTok">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                    </a>
                                @endif
                                @if($facebook)
                                    <a href="{{ $facebook }}" target="_blank" class="text-ink-100/70 hover:text-white transition" title="Facebook">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="border-t border-white/10 py-4 text-center text-xs text-ink-100/50">
                © {{ date('Y') }} Extera Travel. All rights reserved.
            </div>
        </footer>

        <!-- Floating WhatsApp CTA -->
        <button id="chatBtn" onclick="openChatModal()" target="_blank" class="fixed bottom-6 right-6 z-40 flex items-center gap-2 rounded-full bg-primary-500 px-5 py-3.5 text-sm font-bold text-white shadow-gold transition hover:-translate-y-0.5 hover:bg-primary-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.99.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.336-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
            </svg>
            Chat Admin
        </button>

        <!-- Chat Modal -->
        <div id="chatModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="relative mx-4 w-full max-w-md rounded-3xl bg-white p-6 shadow-soft">
                <button onclick="closeChatModal()" class="absolute right-4 top-4 text-ink-400 hover:text-ink-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h3 class="font-display text-xl text-ink-900">Chat Admin</h3>
                <p class="mt-1 text-sm text-ink-400">Ada yang bisa kami bantu?</p>
                <form id="chatForm" class="mt-5 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-ink-600">Nama</label>
                        <input type="text" id="chatName" required class="mt-1 w-full rounded-xl border border-ink-200 bg-ink-50 px-4 py-2.5 text-sm outline-none focus:border-gold-400 focus:ring-2 focus:ring-gold-200" placeholder="Nama kamu" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-ink-600">Pesan</label>
                        <textarea id="chatMessage" rows="3" required class="mt-1 w-full rounded-xl border border-ink-200 bg-ink-50 px-4 py-2.5 text-sm outline-none focus:border-gold-400 focus:ring-2 focus:ring-gold-200 resize-none" placeholder="Tulis pesan..."></textarea>
                    </div>
                    <button type="submit" class="w-full rounded-full bg-gold-400 py-2.5 text-sm font-bold text-ink-900 transition hover:bg-gold-300">
                        Kirim ke WhatsApp
                    </button>
                </form>
            </div>
        </div>

        <script>
            function openChatModal() {
                document.getElementById('chatModal').classList.remove('hidden');
                document.getElementById('chatModal').classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
            function closeChatModal() {
                document.getElementById('chatModal').classList.add('hidden');
                document.getElementById('chatModal').classList.remove('flex');
                document.body.style.overflow = '';
            }
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('chatModal');
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeChatModal();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeChatModal();
                });
                document.getElementById('chatForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    var name = document.getElementById('chatName').value.trim();
                    var message = document.getElementById('chatMessage').value.trim();
                    var whatsappMessage = encodeURIComponent(message + '\n\n\u2013 ' + name);
                    var waNumber = '{{ \App\Helpers\PreferenceHelper::get('whatsapp_number', '6281283890098') }}'.replace(/\D/g, '');
                    var whatsappLink = 'https://wa.me/' + waNumber + '?text=' + whatsappMessage;
                    window.open(whatsappLink, '_blank');
                    closeChatModal();
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
