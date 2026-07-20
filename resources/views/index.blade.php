@extends('layouts.main')

@section('content')
	<main>
		<!-- Hero -->
		<section class="relative overflow-hidden bg-ink-950 pb-0 pt-32 lg:pt-40" id="hero" data-nav-theme="dark">
			<div class="pointer-events-none absolute inset-0 dot-grid opacity-40"></div>
			<div class="pointer-events-none absolute -left-24 top-24 h-72 w-72 rounded-full bg-primary-600/40 blur-3xl"></div>
			<div class="pointer-events-none absolute -right-16 bottom-10 h-72 w-72 rounded-full bg-gold-500/20 blur-3xl"></div>

			<div class="relative z-10 mx-auto grid max-w-7xl gap-12 px-6 pb-24 lg:grid-cols-2 lg:items-center lg:px-8 lg:pb-32">
				<div class="text-white">
					<span class="inline-flex items-center gap-2 rounded-full border border-gold-400/40 bg-white/5 px-4 py-1.5 text-xs font-semibold tracking-wide text-gold-200 backdrop-blur">
						Trusted Umrah Travel Partner
					</span>
					<h1 class="mt-5 font-display text-4xl leading-[1.1] text-white sm:text-5xl lg:text-6xl">
						Umrah Nyaman Bersama <span class="text-gold-300">Generasi Muda</span>
					</h1>
					<p class="mt-6 max-w-lg text-base text-ink-100/80 sm:text-lg">
						Untuk kamu yang ingin berangkat bersama teman-teman seusia, didampingi dari niat berangkat sampai pulang ke rumah, dengan pelayanan yang jelas dan nyaman.
					</p>
					<div class="mt-8 flex flex-wrap gap-3">
						<a href="/packages" class="rounded-full bg-gold-400 px-7 py-3.5 text-sm font-bold text-ink-900 shadow-gold transition hover:-translate-y-0.5 hover:bg-gold-300">Lihat Paket</a>
						<button onclick="openChatModal()" class="rounded-full border border-white/25 bg-white/5 px-7 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:bg-white/10">Chat Admin</button>
					</div>

					<div class="mt-10 flex flex-wrap gap-6 border-t border-white/10 pt-6">
						<div>
							<p class="font-display text-2xl text-gold-300">5000+</p>
							<p class="text-xs text-ink-100/70">Jamaah Terdaftar</p>
						</div>
						<div>
							<p class="font-display text-2xl text-gold-300">4.9/5</p>
							<p class="text-xs text-ink-100/70">Rating dari jamaah</p>
						</div>
						<div>
							<p class="font-display text-2xl text-gold-300">100%</p>
							<p class="text-xs text-ink-100/70">Pendampingan</p>
						</div>
					</div>
				</div>

				<div class="relative mx-auto w-full max-w-sm">
					<div class="absolute -inset-4 rounded-t-[999px] rounded-b-3xl border-2 border-dashed border-gold-400/30"></div>
					<div id="carousel" class="relative aspect-4/5 w-full overflow-hidden rounded-t-[999px] rounded-b-3xl shadow-soft ring-1 ring-white/10">
						@forelse($heroImages as $index => $hero)
							<div class="slide absolute inset-0 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-700">
								<img src="{{ asset('storage/' . $hero->path) }}" alt="{{ $hero->title ?? 'Hero Image' }}" class="h-full w-full object-cover" />
							</div>
						@empty
							<div class="slide absolute inset-0 opacity-100 transition-opacity duration-700">
								<img src="https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&w=900&q=80" alt="Perjalanan umrah" class="h-full w-full object-cover" />
							</div>
							<div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
								<img src="https://images.unsplash.com/photo-1528715471579-d1bcf0ba5e83?auto=format&fit=crop&w=900&q=80" alt="Suasana ibadah" class="h-full w-full object-cover" />
							</div>
							<div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
								<img src="https://images.unsplash.com/photo-1577587230708-187fdbef4d91?auto=format&fit=crop&w=900&q=80" alt="Momen jamaah" class="h-full w-full object-cover" />
							</div>
						@endforelse
						<div class="absolute inset-0 bg-linear-to-t from-ink-950/70 via-transparent to-transparent"></div>
					</div>

					<div class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 gap-2">
						@forelse($heroImages as $index => $hero)
							<button class="dot h-2 {{ $index === 0 ? 'w-7 bg-gold-300' : 'w-2 bg-white/40' }} rounded-full" aria-label="Slide {{ $index + 1 }}"></button>
						@empty
							<button class="dot h-2 w-7 rounded-full bg-gold-300"></button>
							<button class="dot h-2 w-2 rounded-full bg-white/40"></button>
							<button class="dot h-2 w-2 rounded-full bg-white/40"></button>
						@endforelse
					</div>

					<div class="absolute -bottom-6 -left-6 rounded-2xl bg-white p-4 shadow-soft">
						<p class="font-display text-lg text-primary-700">4.9 ⭐</p>
						<p class="text-[11px] font-semibold text-ink-400">4500+ jamaah muda</p>
					</div>
				</div>
			</div>

			<div style="--scallop-color:#fbfaf6" class="scallop"></div>
		</section>

		<!-- Product -->
		<section id="paket" class="mx-auto max-w-7xl px-6 py-20 lg:px-8" data-nav-theme="light">
			<div class="reveal mb-12 text-center">
				<p class="text-sm font-bold uppercase tracking-wider text-gold-700">Paket</p>
				<h2 class="mt-3 font-display text-3xl text-ink-900 sm:text-4xl">Paket Pilihan Buat Kamu</h2>
			</div>

			<div class="swiper packageSwiper overflow-hidden rounded-3xl">
				<div class="swiper-wrapper">
					@forelse($packageCategories as $category)
						<article class="swiper-slide reveal group overflow-hidden rounded-3xl border bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft @if($category->mark_as_favorite) border-2 border-gold-300 shadow-gold @else border-primary-200 @endif">
							@if($category->mark_as_favorite)
								<div class="relative">
									<span class="absolute right-4 top-4 z-10 rounded-full bg-gold-400 px-3 py-1 text-[11px] font-bold text-ink-900">Favorit</span>
									<div class="relative h-40 overflow-hidden rounded-t-[999px] mx-6 mt-6">
							@else
								<div class="relative h-40 overflow-hidden rounded-t-[999px] mx-6 mt-6">
							@endif
								@if($category->image_cover)
									<img src="{{ asset('storage/' . $category->image_cover) }}" alt="{{ $category->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
								@else
									<div class="h-full w-full bg-linear-to-br from-primary-100/50 to-primary-200/50 flex items-center justify-center">
										<x-lucide-image class="h-12 w-12 text-primary-300/60" />
									</div>
								@endif
							@if($category->mark_as_favorite)
									</div>
								</div>
							@else
								</div>
							@endif

							<div class="p-6 pt-4">
								<h3 class="font-display text-xl text-ink-900">{{ $category->name }}</h3>
								<p class="mt-5 font-display text-2xl text-gold-700">
									@php($cheapest = $category->cheapestPackagePrice())
									@if($cheapest)
										Mulai {{ $cheapest->currency === 'IDR' ? 'Rp ' : ($cheapest->currency === 'USD' ? '$ ' : $cheapest->currency . ' ') }}{{ number_format($cheapest->price, 0, ',', '.') }}
									@else
										Hubungi Admin
									@endif
								</p>
								<button class="product-detail-btn mt-6 w-full rounded-full px-4 py-2.5 text-sm font-bold transition @if($category->mark_as_favorite) bg-primary-600 text-white hover:bg-primary-700 @else bg-primary-100 text-primary-800 group-hover:bg-primary-600 group-hover:text-white @endif">Lihat Detail</button>
							</div>
						</article>
					@empty
						<article class="swiper-slide col-span-full py-12 text-center">
							<x-lucide-package class="mx-auto h-12 w-12 text-base-content/20" />
							<p class="mt-4 text-base-content/50">Belum ada kategori paket tersedia.</p>
						</article>
					@endforelse
				</div>
				<div class="mt-6 flex items-center justify-between">
					<div class="swiper-pagination static!"></div>
				</div>
			</div>

			<!-- CTA on customizeable package -->
			<div class="reveal mt-12 rounded-3xl border border-primary-200 bg-primary-50 p-6 text-center shadow-soft">
				<h3 class="font-display text-xl text-primary-800">Punya rencana berangkat tapi paketnya belum ada?</h3>
				<p class="mt-2 text-sm text-primary-700">Kamu bisa request paket sesuai kebutuhan, dan tim kami akan bantu buatkan.</p>
				<button type="button" onclick="openCustomModal()" class="mt-4 inline-block rounded-full bg-primary-600 px-6 py-2.5 text-sm font-bold text-white shadow-soft transition hover:bg-primary-700">Custom Paket</button>
			</div>
		</section>

		<!-- Why Choose Us -->
		<section id="kenapa-kita" class="bg-ink-950 py-20" data-nav-theme="dark">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="reveal mb-12 text-center">
					<p class="text-sm font-bold uppercase tracking-wider text-gold-400">Kenapa Kita</p>
					<h2 class="mt-3 font-display text-3xl text-white sm:text-4xl">4 Alasan Jamaah Pilih Extera</h2>
				</div>

				<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
					<div class="reveal rounded-3xl border border-white/10 bg-white/5 p-6">
						<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-t-[999px] rounded-b-md bg-gold-400/15">
							<svg class="h-6 w-6 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" />
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
							</svg>
						</div>
						<h3 class="font-display text-lg text-white">Berizin & Terpercaya</h3>
						<p class="mt-2 text-sm text-ink-100/70">Terdaftar resmi, jadi kamu dan orang tua bisa sama-sama tenang.</p>
					</div>

					<div class="reveal rounded-3xl border border-white/10 bg-white/5 p-6">
						<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-t-[999px] rounded-b-md bg-gold-400/15">
							<svg class="h-6 w-6 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2" />
								<circle cx="9" cy="7" r="4" stroke-width="2" />
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87" />
							</svg>
						</div>
						<h3 class="font-display text-lg text-white">Tim Muda, Ngerti Kamu</h3>
						<p class="mt-2 text-sm text-ink-100/70">Pendamping berpengalaman yang sepemikiran dengan kamu, dari manasik sampai pulang.</p>
					</div>

					<div class="reveal rounded-3xl border border-white/10 bg-white/5 p-6">
						<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-t-[999px] rounded-b-md bg-gold-400/15">
							<svg class="h-6 w-6 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 9h.01M15 9h.01M9 13h.01M15 13h.01" />
							</svg>
						</div>
						<h3 class="font-display text-lg text-white">Hotel Strategis</h3>
						<p class="mt-2 text-sm text-ink-100/70">Dekat lokasi ibadah, jalan kaki gampang, nggak buang waktu di jalan.</p>
					</div>

					<div class="reveal rounded-3xl border border-white/10 bg-white/5 p-6">
						<div class="mb-4 flex h-12 w-12 items-center justify-center rounded-t-[999px] rounded-b-md bg-gold-400/15">
							<svg class="h-6 w-6 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m-9 9V3h12v18l-3-2-3 2-3-2-3 2z" />
							</svg>
						</div>
						<h3 class="font-display text-lg text-white">Harga Transparan</h3>
						<p class="mt-2 text-sm text-ink-100/70">Rincian biaya jelas dari awal, nggak ada kejutan pas udah deposit.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- Gallery -->
		<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8" data-nav-theme="light">
			<div class="reveal mb-12 text-center">
				<p class="text-sm font-bold uppercase tracking-wider text-gold-700">Galeri</p>
				<h2 class="mt-3 font-display text-3xl text-ink-900 sm:text-4xl">Momen Jamaah Muda</h2>
			</div>

			<div class="swiper gallerySwiper overflow-hidden rounded-3xl">
				<div class="swiper-wrapper">
					@forelse($galleries as $gallery)
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="{{ asset('storage/' . $gallery->path) }}" alt="{{ $gallery->title ?? 'Gallery' }}">
						</div>
					@empty
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&w=800&q=80" alt="Gallery image 1">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1528715471579-d1bcf0ba5e83?auto=format&fit=crop&w=800&q=80" alt="Gallery image 2">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1577587230708-187fdbef4d91?auto=format&fit=crop&w=800&q=80" alt="Gallery image 3">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&w=800&q=80" alt="Gallery image 4">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1528715471579-d1bcf0ba5e83?auto=format&fit=crop&w=800&q=80" alt="Gallery image 5">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1577587230708-187fdbef4d91?auto=format&fit=crop&w=800&q=80" alt="Gallery image 6">
						</div>
						<div class="swiper-slide">
							<img class="h-56 w-full rounded-3xl object-cover" src="https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&w=800&q=80" alt="Gallery image 7">
						</div>
					@endforelse
					<div class="swiper-slide">
						<a href="/gallery" class="rounded-3xl">
							<div class="h-56 w-full bg-linear-to-br from-gold-300 to-gold-500 flex items-center justify-center p-4 rounded-3xl shadow-soft">
								<p class="text-ink-900 font-bold text-lg">Lihat Selengkapnya</p>
							</div>
						</a>
					</div>
				</div>
				<div class="mt-6 flex items-center justify-between">
					<div class="swiper-pagination static!"></div>
				</div>
			</div>
		</section>

		<!-- Testimoni -->
		<section id="testimoni" class="bg-white py-20" data-nav-theme="light">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="reveal mb-12 text-center">
					<p class="text-sm font-bold uppercase tracking-wider text-gold-700">Testimoni</p>
					<h2 class="mt-3 font-display text-3xl text-ink-900 sm:text-4xl">Kata Jamaah Kami</h2>
				</div>

				<div class="grid gap-6 md:grid-cols-3">
					<blockquote class="reveal rounded-3xl border border-primary-200 bg-primary-50 p-6">
						<p class="font-display text-4xl leading-none text-gold-400">"</p>
						<p class="mt-2 text-sm text-ink-700">Rombongannya seru, pembimbingnya sabar banget, umrah pertamaku jadi terasa nyaman.</p>
						<div class="mt-5 flex items-center gap-3">
							<img src="https://i.pravatar.cc/64?img=47" alt="Rani" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-300" />
							<div>
								<p class="text-sm font-bold text-ink-900">Rani, 24</p>
								<p class="text-xs text-ink-400">Jakarta</p>
							</div>
						</div>
					</blockquote>
					<blockquote class="reveal rounded-3xl border border-primary-200 bg-primary-50 p-6">
						<p class="font-display text-4xl leading-none text-gold-400">"</p>
						<p class="mt-2 text-sm text-ink-700">Hotelnya deket banget, itinerary jelas dari awal. Nggak buang-buang waktu di jalan.</p>
						<div class="mt-5 flex items-center gap-3">
							<img src="https://i.pravatar.cc/64?img=32" alt="Fajar" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-300" />
							<div>
								<p class="text-sm font-bold text-ink-900">Fajar, 27</p>
								<p class="text-xs text-ink-400">Bandung</p>
							</div>
						</div>
					</blockquote>
					<blockquote class="reveal rounded-3xl border border-primary-200 bg-primary-50 p-6">
						<p class="font-display text-4xl leading-none text-gold-400">"</p>
						<p class="mt-2 text-sm text-ink-700">Pertama kali jauh dari orang tua, tapi tetap di-handle rapi. Tim-nya responsif banget.</p>
						<div class="mt-5 flex items-center gap-3">
							<img src="https://i.pravatar.cc/64?img=15" alt="Nadia" class="h-10 w-10 rounded-full object-cover ring-2 ring-gold-300" />
							<div>
								<p class="text-sm font-bold text-ink-900">Nadia, 22</p>
								<p class="text-xs text-ink-400">Surabaya</p>
							</div>
						</div>
					</blockquote>
				</div>
			</div>
		</section>

		<!-- Follow Us -->
		<section class="mx-auto max-w-7xl px-6 py-20 lg:px-8" data-nav-theme="light">
			<div class="reveal mb-12 text-center">
				<p class="text-sm font-bold uppercase tracking-wider text-gold-700">Sosmed</p>
				<h2 class="mt-3 font-display text-3xl text-ink-900 sm:text-4xl">Ikuti Kami di Media Sosial</h2>
			</div>

			<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
				<article class="reveal group rounded-3xl border border-primary-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
					<h3 class="font-display text-xl text-ink-900">Instagram</h3>
					<p class="mt-2 text-sm text-ink-400">Temukan inspirasi perjalanan, momen seru, dan destinasi favorit kami di Instagram.</p>
					<a href="https://instagram.com" target="_blank" class="inline-block mt-4 rounded-full bg-linear-to-r from-[#f58529] via-[#dd2a7b] to-[#8134af] px-4 py-2 text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block mb-1 me-1" viewBox="0 0 16 16">
							<path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
						</svg>
						exteratravel
					</a>
				</article>

				<article class="reveal group rounded-3xl border border-primary-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
					<h3 class="font-display text-xl text-ink-900">TikTok</h3>
					<p class="mt-2 text-sm text-ink-400">Jangan lewatkan konten video menarik dan rekomendasi liburan terbaru di TikTok.</p>
					<a href="https://tiktok.com" target="_blank" class="inline-block mt-4 rounded-full bg-[#121212] px-4 py-2 text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg" style="box-shadow: -2px 0 0 #25F4EE, 2px 0 0 #FE2C55;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block mb-1 me-1" viewBox="0 0 16 16">
							<path d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z"/>
						</svg>
						exteratravel
					</a>
				</article>

				<article class="reveal group rounded-3xl border border-primary-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
					<h3 class="font-display text-xl text-ink-900">Facebook</h3>
					<p class="mt-2 text-sm text-ink-400">Ikuti Facebook kami untuk mendapatkan update layanan, promo, dan informasi perjalanan terkini.</p>
					<a href="https://facebook.com" target="_blank" class="inline-block mt-4 rounded-full bg-[#1877F2] px-4 py-2 text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-[#166FE5] hover:shadow-lg">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="inline-block mb-1 me-1" viewBox="0 0 16 16">
							<path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
						</svg>
						Extera Travel
					</a>
				</article>
			</div>
		</section>
	</main>

	<!-- Product Detail Modal -->
	<div id="productModal" class="fixed inset-0 z-60 hidden items-center justify-center p-4" aria-hidden="true">
		<div id="modalBackdrop" class="absolute inset-0 bg-ink-950/70 backdrop-blur-sm"></div>
		<div class="relative z-10 w-full max-w-xl rounded-3xl border border-gold-200 bg-white p-6 shadow-soft sm:p-8">
			<div class="mb-6 flex items-start justify-between gap-4">
				<div>
					<p class="text-xs font-bold uppercase tracking-wider text-gold-700">Detail Paket</p>
					<h3 class="mt-2 font-display text-2xl text-ink-900">Paket Umrah Extera Travel</h3>
				</div>
				<button id="closeModalBtn" class="rounded-full border border-primary-200 px-3 py-1.5 text-sm font-bold text-primary-700 transition hover:bg-primary-50">Tutup</button>
			</div>

			<div class="space-y-4 text-sm text-ink-700">
				<p>Paket sudah termasuk tiket pesawat PP, akomodasi hotel, konsumsi, transportasi lokal, dan perlengkapan umrah.</p>
				<ul class="list-inside list-disc space-y-1">
					<li>Durasi perjalanan: 9 - 12 hari</li>
					<li>Pendamping ibadah berpengalaman</li>
					<li>Manasik umrah sebelum keberangkatan</li>
					<li>Dokumentasi perjalanan jamaah</li>
				</ul>
				<p class="rounded-2xl bg-primary-50 p-3 text-primary-900">Catatan: ini modal statis untuk tahap testing, konten dapat dibuat dinamis pada tahap berikutnya.</p>
			</div>
		</div>
	</div>

	<!-- Custom Paket Modal -->
	<div id="customModal" class="fixed inset-0 z-60 hidden items-center justify-center p-4" aria-hidden="true">
		<div id="customModalBackdrop" class="absolute inset-0 bg-ink-950/70 backdrop-blur-sm"></div>
		<div class="relative z-10 w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-3xl border border-gold-200 bg-white p-6 shadow-soft sm:p-8">
			<div class="mb-6 flex items-start justify-between gap-4">
				<div>
					<p class="text-xs font-bold uppercase tracking-wider text-gold-700">Request Paket</p>
					<h3 class="mt-1 font-display text-2xl text-ink-900">Buat Paket Kustom</h3>
					<p class="mt-1 text-sm text-ink-400">Isi form di bawah, tim kami akan menghubungi kamu segera.</p>
				</div>
				<div class="flex items-center gap-2">
                    <button type="button" onclick="openHotelHintModal()" class="rounded-full border border-gold-300 bg-gold-50 px-3 py-1.5 text-sm font-bold text-gold-700 transition hover:bg-gold-100">Peta Hotel</button>
                    <button type="button" id="closeCustomModalBtn" class="rounded-full border border-primary-200 px-3 py-1.5 text-sm font-bold text-primary-700 transition hover:bg-primary-50">Tutup</button></div>
			</div>

			<form id="customForm" class="space-y-5">
				<div class="grid gap-5 sm:grid-cols-2">
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Nama Lengkap <span class="text-error">*</span></label>
						<input type="text" name="name" required
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200" />
					</div>
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Email <span class="text-error">*</span></label>
						<input type="email" name="email" required
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200" />
					</div>
				</div>

				<div class="grid gap-5 sm:grid-cols-2">
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">No. Telepon / WhatsApp <span class="text-error">*</span></label>
						<input type="tel" name="phone" required
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200" />
					</div>
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Jumlah Jamaah</label>
						<input type="number" name="total_pax" min="1" max="100" value="1"
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200" />
					</div>
				</div>

				<div class="grid gap-5 sm:grid-cols-2">
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Keberangkatan (Bulan & Tahun)</label>
						<input type="month" name="departure_month" min="2026-07"
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200" />
					</div>
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Destinasi / Kota Tujuan</label>
						<select name="destination"
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200">
							<option value="">Pilih destinasi...</option>
							<option value="mekkah-madinah">Mekkah & Madinah</option>
							<option value="mekkah-madinah-jeddah">Mekkah, Madinah & Jeddah</option>
							<option value="mekkah-madinah-turki">Mekkah, Madinah & Turki</option>
							<option value="mekkah-madinah-mesir">Mekkah, Madinah & Mesir</option>
							<option value="mekkah-madinah-yordania">Mekkah, Madinah & Yordania</option>
							<option value="umrah-plus">Umrah Plus (Lainnya)</option>
							<option value="haji">Haji Khusus</option>
							<option value="wisata-religi">Wisata Religi Nusantara</option>
							<option value="other">Lainnya</option>
						</select>
					</div>
				</div>

				<div class="grid gap-5 sm:grid-cols-2">
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Durasi</label>
						<select name="duration"
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200">
							<option value="">Pilih durasi...</option>
							<option value="7">7 Hari</option>
							<option value="9">9 Hari</option>
							<option value="10">10 Hari</option>
							<option value="12">12 Hari</option>
							<option value="14">14 Hari</option>
							<option value="21">21 Hari</option>
							<option value="flexible">Fleksibel</option>
						</select>
					</div>
					<div>
						<label class="mb-1 block text-sm font-semibold text-ink-700">Budget Per Orang</label>
						<select name="budget"
							class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200">
							<option value="">Pilih rentang budget...</option>
							<option value="<25">&lt; Rp 25 Juta</option>
							<option value="25-35">Rp 25 - 35 Juta</option>
							<option value="35-50">Rp 35 - 50 Juta</option>
							<option value="50-75">Rp 50 - 75 Juta</option>
							<option value="75-100">Rp 75 - 100 Juta</option>
							<option value=">100">&gt; Rp 100 Juta</option>
							<option value="flexible">Belum Tahu / Fleksibel</option>
						</select>
					</div>
				</div>

                <div class="grid gap-5 grid-cols-1 sm:grid-cols-{{ $gridCols }}">
                    @foreach($hotelsByCity as $city => $hotels)
                        <div @class(['sm:col-span-2' => $lastHotelFullWidth && $i === $hotelsByCityCount - 1])>
                            <label class="mb-1 block text-sm font-semibold text-ink-700">Hotel {{ ucwords(str_replace('-', ' ', $city)) }}</label>
                            <select name="hotels[{{ str_replace('-', '_', $city) }}]"
                                class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200">
                                <option value="">Pilih hotel...</option>
                                @foreach($hotels as $hotel)
                                    <option value="{{ $hotel->name }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

				<div role="alert" class="flex items-center gap-3 rounded-xl justify-between border border-orange-200 bg-orange-50 p-2 text-sm text-ink-700">
					<span class="ps-3">Bingung milih hotel? Intip lokasi hotel.</span>
					<button type="button" onclick="openHotelHintModal()" class="rounded-xl bg-gold-400 px-8 py-3 text-sm font-bold text-ink-900 shadow-gold transition hover:bg-gold-300">Peta Hotel</button>
				</div>

                <label class="mb-1 block text-sm font-semibold text-ink-700">Catatan Tambahan</label>
                <textarea name="notes" rows="4"
                    class="w-full rounded-xl border border-primary-200 bg-primary-50/50 px-4 py-2.5 text-sm text-ink-900 outline-none transition focus:border-gold-400 focus:ring-2 focus:ring-gold-200"
                    placeholder="Ceritakan kebutuhan spesifik kamu di sini...">
                </textarea>

				<div class="flex items-center gap-3 pt-2">
					<button type="submit" class="rounded-full bg-gold-400 px-8 py-3 text-sm font-bold text-ink-900 shadow-gold transition hover:bg-gold-300">Kirim Permintaan</button>
					<button type="button" id="closeCustomModalBtn2" class="rounded-full border border-primary-200 px-6 py-3 text-sm font-bold text-primary-700 transition hover:bg-primary-50">Batal</button>
				</div>

				<p class="text-xs text-ink-400">Dengan mengirim form ini, kamu menyetujui bahwa tim Extera Travel akan menghubungi kamu melalui WhatsApp atau email dalam 1x24 jam.</p>
			</form>
		</div>
	</div>

	<!-- Hotel Hint Modal -->
	<div id="hotelHintModal" class="fixed inset-0 z-60 hidden items-center justify-center p-4" aria-hidden="true">
		<div id="hotelHintBackdrop" class="absolute inset-0 bg-ink-950/70 backdrop-blur-sm"></div>
		<div class="relative z-10 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl border border-gold-200 bg-white p-6 shadow-soft sm:p-8">
			<div class="mb-6 flex items-start justify-between gap-4">
				<div>
					<p class="text-xs font-bold uppercase tracking-wider text-gold-700">Panduan Hotel</p>
					<h3 class="mt-1 font-display text-2xl text-ink-900">Petunjuk Lokasi Hotel</h3>
					<p class="mt-1 text-sm text-ink-400">Lihat posisi hotel di peta untuk membantu memilih paket.</p>
				</div>
				<div class="flex items-center gap-2">
					<button type="button" onclick="openCustomModalFromHint()" class="rounded-full border border-primary-200 px-3 py-1.5 text-sm font-bold text-primary-700 transition hover:bg-primary-50">Kembali</button>
				</div>
			</div>

			{{-- Tab City --}}
			<div id="hotelTabs" class="mb-4 flex flex-wrap gap-2 border-b border-primary-100 pb-3">
				@foreach($hotelsByCity as $city => $hotels)
					<button type="button"
						class="city-tab rounded-full px-4 py-1.5 text-xs font-bold transition {{ $loop->first ? 'bg-gold-400 text-ink-900' : 'bg-primary-50 text-ink-600 hover:bg-gold-100' }}"
						data-city="{{ $city }}">
						{{ ucwords(str_replace('-', ' ', $city)) }}
					</button>
				@endforeach
			</div>

			{{-- Map Container --}}
			<div id="hotelMap" class="h-[400px] w-full rounded-2xl border border-primary-200 z-0"></div>

			{{-- Hotel List Under Map --}}
			<div id="hotelList" class="mt-4 space-y-2">
				<p class="text-xs font-semibold text-ink-500">Daftar hotel di kota terpilih:</p>
				<div id="hotelListItems" class="grid gap-2 sm:grid-cols-2"></div>
			</div>

			{{-- Back to Custom Modal --}}
			<div class="mt-6 pt-4 border-t border-primary-100 flex items-center gap-3">
				<button type="button" onclick="openCustomModalFromHint()" class="rounded-full bg-gold-400 px-8 py-3 text-sm font-bold text-ink-900 shadow-gold transition hover:bg-gold-300">← Kembali ke Buat Paket Kustom</button>
			</div>
		</div>
	</div>

@endsection

@push('styles')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    @vite(['resources/js/pages/home.js'])
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
	<script>
		function openCustomModal() {
			let modal = document.getElementById("customModal");
			modal.classList.remove("hidden");
			modal.classList.add("flex");
			document.body.style.overflow = "hidden";
		}

		function closeCustomModal() {
			let modal = document.getElementById("customModal");
			modal.classList.add("hidden");
			modal.classList.remove("flex");
			document.body.style.overflow = "";
		}

		document.addEventListener("DOMContentLoaded", function() {
			let modal = document.getElementById("customModal");
			let backdrop = document.getElementById("customModalBackdrop");
			let closeBtns = document.querySelectorAll("#closeCustomModalBtn, #closeCustomModalBtn2");

			for (let i = 0; i < closeBtns.length; i++) {
				closeBtns[i].addEventListener("click", closeCustomModal);
			}

			backdrop.addEventListener("click", closeCustomModal);

			document.addEventListener("keydown", function(e) {
				if (e.key === "Escape" && !modal.classList.contains("hidden")) {
					closeCustomModal();
				}
			});

			modal.querySelector(".relative.z-10").addEventListener("click", function(e) {
				e.stopPropagation();
			});
		});
	</script>
    <script>
        let hotelData = @json($hotelsByCity);

        let hotelMap = null;
        let hotelMarkers = [];

        function initHotelMap() {
            if (hotelMap) return;
            hotelMap = L.map('hotelMap').setView([21.3891, 39.8579], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(hotelMap);
        }

        function clearMarkers() {
            hotelMarkers.forEach(function(m) { hotelMap.removeLayer(m); });
            hotelMarkers = [];
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function showHotelsOnMap(city) {
            if (!hotelMap) initHotelMap();
            clearMarkers();
            let bounds = [];
            let listHtml = '';

            if (hotelData[city]) {
                hotelData[city].forEach(function(hotel, i) {
                    if (hotel.latitude && hotel.longitude) {
                        let lat = parseFloat(hotel.latitude);
                        let lng = parseFloat(hotel.longitude);
                        let marker = L.marker([lat, lng])
                            .addTo(hotelMap)
                            .bindPopup(hotel.name, {
								autoClose: false,
								closeOnClick: false,
								className: 'leaflet-custom-popup'
							});
						marker.openPopup();
                        hotelMarkers.push(marker);
                        bounds.push([lat, lng]);

                        let color = i % 2 === 0 ? 'bg-gold-100 text-gold-800' : 'bg-primary-100 text-primary-800';
                        listHtml += '<div class="flex items-start gap-2 rounded-lg border border-primary-100 p-2 ' + color + ' text-xs font-semibold">' +
                            '<span class="mt-0.5">📍</span><span>' + hotel.name + '</span></div>';
                    }
                });
            }

            document.getElementById('hotelListItems').innerHTML = listHtml || '<p class="text-xs text-ink-400 col-span-2">Tidak ada hotel dengan koordinat di kota ini.</p>';

            if (bounds.length > 0) {
                hotelMap.fitBounds(bounds, { padding: [40, 40] });
            }
        }

        // City tab click handlers
        document.addEventListener('DOMContentLoaded', function() {
            let tabs = document.querySelectorAll('#hotelTabs .city-tab');
            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    tabs.forEach(function(t) {
                        t.classList.remove('bg-gold-400', 'text-ink-900');
                        t.classList.add('bg-primary-50', 'text-ink-600');
                    });
                    this.classList.add('bg-gold-400', 'text-ink-900');
                    this.classList.remove('bg-primary-50', 'text-ink-600');
                    showHotelsOnMap(this.dataset.city);
                });
            });
        });
    </script>
    <script>
        function openHotelHintModal() {
            closeCustomModal();
            let modal = document.getElementById("hotelHintModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.style.overflow = "hidden";
            // Show first city
            setTimeout(function() {
                let firstTab = document.querySelector('#hotelTabs .city-tab');
                if (firstTab) firstTab.click();
                initHotelMap();
            }, 200);
        }

        function closeHotelHintModal() {
            let modal = document.getElementById("hotelHintModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            document.body.style.overflow = "";
        }

        function openCustomModalFromHint() {
            closeHotelHintModal();
            openCustomModal();
        }

        document.addEventListener("DOMContentLoaded", function() {
            let hintModal = document.getElementById("hotelHintModal");
            let hintBackdrop = document.getElementById("hotelHintBackdrop");

            hintBackdrop.addEventListener("click", closeHotelHintModal);

            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape" && !hintModal.classList.contains("hidden")) {
                    closeHotelHintModal();
                }
            });

            hintModal.querySelector(".relative.z-10").addEventListener("click", function(e) {
                e.stopPropagation();
            });
        });

    </script>

    <script>
        (function() {
            let form = document.getElementById("customForm");
            if (!form) return;

            let waNumber = "6281283890098";

            let destinationLabels = {
                "mekkah-madinah": "Mekkah & Madinah",
                "mekkah-madinah-jeddah": "Mekkah, Madinah & Jeddah",
                "mekkah-madinah-turki": "Mekkah, Madinah & Turki",
                "mekkah-madinah-mesir": "Mekkah, Madinah & Mesir",
                "mekkah-madinah-yordania": "Mekkah, Madinah & Yordania",
                "umrah-plus": "Umrah Plus (Lainnya)",
                "haji": "Haji Khusus",
                "wisata-religi": "Wisata Religi Nusantara",
                "other": "Lainnya"
            };

            let durationLabels = {
                "7": "7 Hari",
                "9": "9 Hari",
                "10": "10 Hari",
                "12": "12 Hari",
                "14": "14 Hari",
                "21": "21 Hari",
                "flexible": "Fleksibel"
            };

            let budgetLabels = {
                "<25": "< Rp 25 Juta",
                "25-35": "Rp 25 - 35 Juta",
                "35-50": "Rp 35 - 50 Juta",
                "50-75": "Rp 50 - 75 Juta",
                "75-100": "Rp 75 - 100 Juta",
                ">100": "> Rp 100 Juta",
                "flexible": "Belum Tahu / Fleksibel"
            };

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                let fd = new FormData(form);
                let lines = [];

                lines.push("Halo admin Extera, saya ingin membuat paket kustom dengan detail berikut:");
                lines.push("");

                // Nama
                let name = fd.get("name");
                if (name) lines.push("*Nama Lengkap:* " + name);

                // Email
                let email = fd.get("email");
                if (email) lines.push("*Email:* " + email);
                // Phone
                let phone = fd.get("phone");
                if (phone) lines.push("*No. Telepon / WhatsApp:* " + phone);

                // Total Pax
                let pax = fd.get("total_pax");
                if (pax) lines.push("*Jumlah Jamaah:* " + pax);
                // Departure
                let dep = fd.get("departure_month");
                if (dep) lines.push("*Keberangkatan:* " + dep);

                // Destination
                let dest = fd.get("destination");
                if (dest) lines.push("*Destinasi:* " + (destinationLabels[dest] || dest));
                // Duration
                let dur = fd.get("duration");
                if (dur) lines.push("*Durasi:* " + (durationLabels[dur] || dur));

                // Budget
                let bud = fd.get("budget");
                if (bud) lines.push("*Budget Per Orang:* " + (budgetLabels[bud] || bud));
                // Hotels - collect all fields that start with "hotels["
                let hotelLines = [];
                for (let pair of fd.entries()) {
                    if (pair[0].startsWith("hotels[") && pair[1]) {
                        let city = pair[0].replace("hotels[", "").replace("]", "");
                        hotelLines.push("- *Hotel " + capitalize(city) + ":* " + pair[1]);
                    }
                }
                if (hotelLines.length > 0) {
                    lines.push("*Hotel Dipilih:*");
                    lines = lines.concat(hotelLines);
                }

                // Notes
                let notes = fd.get("notes");
                if (notes && notes.trim()) lines.push("*Catatan Tambahan:* " + notes.trim());

                let message = lines.join("\n");
                let url = "https://wa.me/" + waNumber + "?text=" + encodeURIComponent(message);
                window.open(url, "_blank");
            });
        })();
    </script>
@endpush
