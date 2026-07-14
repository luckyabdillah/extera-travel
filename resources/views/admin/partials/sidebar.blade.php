<aside class="min-h-full w-72 bg-ink-950 text-ink-100">

	{{-- Brand --}}
	<div class="flex items-center gap-3 px-5 py-5">
        <img src="{{ asset('assets/img/logo/square-light.png') }}" alt="Logo" class="h-10 w-auto transition-all duration-300" />
		<div>
			<p class="font-display text-base leading-none text-gold-100">EXTERA TRAVEL</p>
			<p class="mt-1 text-[10px] uppercase tracking-[0.2em] text-ink-100/50">Admin Panel</p>
		</div>
	</div>
    
	<ul class="d-menu w-full gap-2 px-3 pb-6 [&_li>details>summary]:font-semibold">
		<li>
			<a href="{{ route('admin') }}" class="{{ request()->routeIs('admin') ? 'd-menu-active' : '' }}">
				<x-lucide-layout-dashboard class="h-4 w-4" />
				Dashboard
			</a>
		</li>

		<li class="menu-title mt-3 text-[11px] uppercase tracking-wider text-ink-100/40">Master Data</li>

		<li>
			<details {{ request()->routeIs('admin.galleries*') || request()->routeIs('admin.hero-images*') ? 'open' : '' }}>
				<summary>
					<x-lucide-image class="h-4 w-4" />
					Foto
				</summary>
				<ul>
					<li><a href="#" class="{{ request()->routeIs('admin.galleries') ? 'd-menu-active' : '' }}">Galeri</a></li>
					<li><a href="{{ route('admin.hero-images.index') }}" class="{{ request()->routeIs('admin.hero-images*') ? 'd-menu-active' : '' }}">Landing Page</a></li>
				</ul>
			</details>
		</li>

		<li>
			<details {{ request()->routeIs('admin.package*') ? 'open' : '' }}>
				<summary>
					<x-lucide-package class="h-4 w-4" />
					Paket
				</summary>
				<ul>
					<li><a href="#" class="{{ request()->routeIs('admin.packages') ? 'd-menu-active' : '' }}">Paket Perjalanan</a></li>
					<li><a href="#" class="{{ request()->routeIs('admin.package-categories') ? 'd-menu-active' : '' }}">Kategori Paket</a></li>
				</ul>
			</details>
		</li>

		<li>
			<a href="#" class="{{ request()->routeIs('admin.blogs') ? 'd-menu-active' : '' }}">
				<x-lucide-newspaper class="h-4 w-4" />
				Blog
			</a>
		</li>

		<li>
			<a href="#" class="{{ request()->routeIs('admin.faqs') ? 'd-menu-active' : '' }}">
				<x-lucide-message-circle-question-mark class="h-4 w-4" />
				FAQ
			</a>
		</li>
		
		<li class="menu-title mt-3 text-[11px] uppercase tracking-wider text-ink-100/40">Transaksi</li>

		<li class="{{ request()->routeIs('admin.transactions') ? 'd-menu-active' : '' }}">
			<a href="#">
				<x-lucide-scroll-text class="h-4 w-4" />
				Pemesanan
			</a>
		</li>

		<li class="{{ request()->routeIs('admin.customers') ? 'd-menu-active' : '' }}">
			<a href="#">
				<x-lucide-users class="h-4 w-4" />
				Jamaah
			</a>
		</li>

		<li class="menu-title mt-3 text-[11px] uppercase tracking-wider text-ink-100/40">Lainnya</li>

		<li>
			<details {{ request()->routeIs('admin.settings.*') ? 'open' : '' }}>
				<summary>
					<x-lucide-settings class="h-4 w-4" />
					Pengaturan
				</summary>
				<ul>
					<li><a href="#" class="{{ request()->routeIs('admin.settings.users') ? 'd-menu-active' : '' }}">Pengguna</a></li>
					<li><a href="#" class="{{ request()->routeIs('admin.settings.roles') ? 'd-menu-active' : '' }}">Role & Akses</a></li>
					<li><a href="#" class="{{ request()->routeIs('admin.settings.preferences') ? 'd-menu-active' : '' }}">Preferensi</a></li>
				</ul>
			</details>
		</li>
	</ul>
</aside>
