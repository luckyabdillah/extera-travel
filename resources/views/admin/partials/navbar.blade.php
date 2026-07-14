<header class="d-navbar sticky top-0 z-30 gap-2 border-b border-base-300 bg-base-100/90 px-4 backdrop-blur lg:px-6">

	<div class="d-navbar-start gap-2">
		{{-- Toggle sidebar, hanya tampil di mobile/tablet --}}
		<label for="admin-drawer" class="d-btn d-btn-ghost d-btn-square lg:hidden" aria-label="Buka menu">
			<x-lucide-menu class="h-5 w-5" />
		</label>

		<h1 class="font-display text-lg text-ink-900">@yield('page-title', 'Dashboard')</h1>
	</div>

	<div class="d-navbar-end gap-1">

		{{-- Toggle tema light/dark --}}
		<label class="d-swap d-swap-rotate d-btn d-btn-ghost d-btn-circle" aria-label="Ganti tema">
			<input type="checkbox" id="themeToggle" />
			<x-lucide-sun class="d-swap-off h-5 w-5" />
			<x-lucide-moon class="d-swap-on h-5 w-5" />
		</label>

        {{-- To home page --}}
        <a href="/" target="_blank" class="d-btn d-btn-ghost d-btn-circle" aria-label="Kunjungi website">
			<x-lucide-house class="h-5 w-5" />
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
				<li><a href="#">Profil</a></li>
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