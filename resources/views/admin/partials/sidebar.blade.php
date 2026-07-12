<aside class="min-h-full w-72 bg-ink-950 text-ink-100">

	{{-- Brand --}}
	<div class="flex items-center gap-3 px-5 py-5">
		{{-- <div class="flex h-10 w-10 items-center justify-center rounded-t-[999px] rounded-b-md bg-linear-to-b from-primary-500 to-primary-800 ring-2 ring-gold-400">
			<svg class="h-5 w-5 text-gold-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
				<path d="M12 3c-2.5 2-3.5 4.7-3.5 7.2 0 3.9 2.6 6.8 3.5 7.8.9-1 3.5-3.9 3.5-7.8C15.5 7.7 14.5 5 12 3z" stroke-linejoin="round" />
			</svg>
		</div> --}}
        <img src="{{ asset('assets/img/logo/square-light.png') }}" alt="Logo" class="h-10 w-auto transition-all duration-300" />
		<div>
			<p class="font-display text-base leading-none text-gold-100">EXTERA TRAVEL</p>
			<p class="mt-1 text-[10px] uppercase tracking-[0.2em] text-ink-100/50">Admin Panel</p>
		</div>
	</div>
    
	<ul class="d-menu w-full gap-2 px-3 pb-6 [&_li>details>summary]:font-semibold">
		<li>
			<a href="#" class="{{ request()->routeIs('admin.dashboard') ? 'd-menu-active' : '' }}">
				<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
				</svg>
				Dashboard
			</a>
		</li>

		<li class="menu-title mt-3 text-[11px] uppercase tracking-wider text-ink-100/40">Transaksi</li>

		<li>
			<details {{ request()->routeIs('admin.bookings.*') ? 'open' : '' }}>
				<summary>
					<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
					</svg>
					Booking
				</summary>
				<ul>
					<li><a href="#">Semua Booking</a></li>
					<li><a href="#">Menunggu Konfirmasi</a></li>
					<li><a href="#">Riwayat</a></li>
				</ul>
			</details>
		</li>

		<li>
			<details {{ request()->routeIs('admin.packages.*') ? 'open' : '' }}>
				<summary>
					<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
					</svg>
					Paket Umrah
				</summary>
				<ul>
					<li><a href="#">Semua Paket</a></li>
					<li><a href="#">Kategori Paket</a></li>

					{{-- contoh nested 2 level, tinggal dicopy kalau butuh lebih dalam lagi --}}
					<li>
						<details>
							<summary>Fasilitas</summary>
							<ul>
								<li><a href="#">Hotel</a></li>
								<li><a href="#">Maskapai</a></li>
								<li><a href="#">Muthawif</a></li>
							</ul>
						</details>
					</li>
				</ul>
			</details>
		</li>

		<li>
			<a href="#">
				<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zm8 3.13a4 4 0 010 7.75M16 3.13a4 4 0 010 7.75" />
				</svg>
				Jamaah
			</a>
		</li>

		<li class="menu-title mt-3 text-[11px] uppercase tracking-wider text-ink-100/40">Lainnya</li>

		<li>
			<details {{ request()->routeIs('admin.settings.*') ? 'open' : '' }}>
				<summary>
					<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
						<circle cx="12" cy="12" r="3" stroke-width="2" />
					</svg>
					Pengaturan
				</summary>
				<ul>
					<li><a href="#">Profil Admin</a></li>
					<li><a href="#">Role & Akses</a></li>
					<li><a href="#">Integrasi</a></li>
				</ul>
			</details>
		</li>
	</ul>
</aside>