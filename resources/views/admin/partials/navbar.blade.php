<header class="d-navbar sticky top-0 z-30 gap-2 border-b border-base-300 bg-base-100/90 px-4 backdrop-blur lg:px-6">

	<div class="d-navbar-start gap-2">
		{{-- Toggle sidebar, hanya tampil di mobile/tablet --}}
		<label for="admin-drawer" class="d-btn d-btn-ghost d-btn-square lg:hidden" aria-label="Buka menu">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
			</svg>
		</label>

		<h1 class="font-display text-lg text-ink-900">@yield('page-title', 'Dashboard')</h1>
	</div>

	<div class="d-navbar-end gap-1">

		{{-- Toggle tema light/dark --}}
		<label class="d-swap d-swap-rotate d-btn d-btn-ghost d-btn-circle" aria-label="Ganti tema">
			<input type="checkbox" id="themeToggle" />
			<svg class="d-swap-off h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 8a4 4 0 100 8 4 4 0 000-8z" />
			</svg>
			<svg class="d-swap-on h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
			</svg>
		</label>

		{{-- Notifikasi --}}
		{{-- <div class="d-dropdown d-dropdown-end">
			<button tabindex="0" class="d-btn d-btn-ghost d-btn-circle" aria-label="Notifikasi">
				<div class="indicator">
					<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .53-.21 1.04-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
					</svg>
					<span class="d-badge d-badge-secondary d-badge-xs indicator-item">3</span>
				</div>
			</button>
			<ul tabindex="0" class="d-dropdown-content d-menu z-40 mt-3 w-72 rounded-box bg-base-100 p-2 shadow">
				<li class="px-2 py-1 text-xs font-semibold uppercase tracking-wide text-base-content/50">Notifikasi</li>
				<li><a href="#">Booking baru dari Rani Oktaviani</a></li>
				<li><a href="#">Pembayaran DP paket Umrah Reguler masuk</a></li>
				<li><a href="#">Reminder: Manasik jam 09.00</a></li>
			</ul>
		</div> --}}

        {{-- To home page --}}
        <a href="/" target="_blank" class="d-btn d-btn-ghost d-btn-circle" aria-label="Kunjungi website">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

		{{-- Akun --}}
		<div class="d-dropdown d-dropdown-end">
			<button tabindex="0" class="d-btn d-btn-ghost flex items-center gap-2 px-2">
				<div class="d-avatar">
					<div class="w-8 rounded-full ring ring-primary ring-offset-2 ring-offset-base-100">
						<img src="{{ auth()->user()->avatar_url ?? 'https://i.pravatar.cc/64?img=12' }}" alt="Admin" />
					</div>
				</div>
				<span class="hidden text-sm font-semibold sm:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
			</button>
			<ul tabindex="0" class="d-dropdown-content d-menu z-40 mt-3 w-56 rounded-box bg-base-100 p-2 shadow">
				<li><a href="#">Profil Saya</a></li>
				<li><a href="#">Pengaturan Akun</a></li>
				<li class="mt-1 border-t border-base-300 pt-1">
					<form method="POST" action="">
						@csrf
						<button type="submit" class="w-full text-left text-error">Keluar</button>
					</form>
				</li>
			</ul>
		</div>
	</div>
</header>

@push('scripts')
	<script>
		(function () {
			const toggle = document.getElementById('themeToggle');
			if (!toggle) return;

			const current = localStorage.getItem('admin-theme') || 'light';
			toggle.checked = current === 'dark';

			toggle.addEventListener('change', () => {
				const theme = toggle.checked ? 'dark' : 'light';
				document.documentElement.setAttribute('data-theme', theme);
				localStorage.setItem('admin-theme', theme);
			});
		})();
	</script>
@endpush