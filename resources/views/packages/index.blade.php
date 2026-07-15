@extends('layouts.main')

@section('title', 'Paket Umrah')

@section('content')
<main>
	{{-- Hero --}}
	<section class="bg-ink-950 py-30" data-nav-theme="dark">
		<div class="mx-auto max-w-3xl px-6 text-center">
			<p class="text-sm font-bold uppercase tracking-wider text-gold-400">Paket</p>
			<h1 class="mt-3 font-display text-4xl text-white sm:text-5xl">Pilihan Paket Umrah</h1>
			<p class="mt-4 text-ink-100/70">Temukan paket umrah sesuai kebutuhan kamu. Kelompokkan berdasarkan bulan keberangkatan.</p>
		</div>
	</section>

	{{-- Filters --}}
	<section class="sticky top-18 z-30 border-b border-primary-200 bg-white/95 backdrop-blur-lg">
		<div class="mx-auto max-w-7xl px-6 py-4 lg:px-8">
			<form method="GET" action="{{ url('/packages') }}" id="filterForm" class="flex flex-wrap items-end gap-4">
				{{-- Month filter --}}
				<div class="d-form-control w-48">
					<select name="month" onchange="this.form.submit()" class="d-select d-select-bordered d-select-sm w-full text-sm">
						<option value="">Semua Bulan</option>
						@foreach($months as $m)
							@php($monthName = \Carbon\Carbon::createFromFormat('Y-m', $m)->locale('id')->isoFormat('MMMM YYYY'))
							<option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $monthName }}</option>
						@endforeach
					</select>
				</div>

				{{-- Category dropdown --}}
				<div class="d-form-control w-44">
					<select name="category_id" onchange="this.form.submit()" class="d-select d-select-bordered d-select-sm w-full text-sm">
						<option value="">Semua Kategori</option>
						@foreach($categories as $cat)
							<option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
						@endforeach
					</select>
				</div>

				{{-- Available only checkbox --}}
				<label class="flex cursor-pointer items-center gap-2 pb-1">
					<input type="checkbox" name="available" value="1" onchange="this.form.submit()" class="d-checkbox d-checkbox-primary d-checkbox-sm" {{ request('available') ? 'checked' : '' }} />
					<span class="text-xs font-semibold text-ink-700">Tersedia</span>
				</label>
			</form>
		</div>
	</section>

	{{-- Packages list --}}
	<section class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
		@forelse($packages as $month => $monthPackages)
			<div class="mb-14">
				<h2 class="font-display text-2xl text-ink-900 mb-6 flex items-center gap-3">
					<x-lucide-calendar class="h-6 w-6 text-gold-600" />
					{{ $month }}
				</h2>

				<div class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-none" style="scrollbar-width: none; -ms-overflow-style: none;">
					@foreach($monthPackages as $package)
						<article class="group w-80 shrink-0 snap-start overflow-hidden rounded-3xl border border-primary-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
							{{-- Flyer --}}
							<div class="relative h-44 overflow-hidden">
								@if($package->flyer_path)
									<img src="{{ asset('storage/' . $package->flyer_path) }}" alt="{{ $package->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
								@else
									<div class="h-full w-full bg-linear-to-br from-primary-100/50 to-primary-200/50 flex items-center justify-center">
										<x-lucide-image class="h-14 w-14 text-primary-300/60" />
									</div>
								@endif
								<div class="absolute inset-0 bg-linear-to-t from-black/40 via-transparent to-transparent"></div>

								{{-- Badges --}}
								<div class="absolute left-3 top-3 flex flex-wrap gap-1.5">
									@if($package->category)
										<span class="rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold text-ink-800 backdrop-blur">{{ $package->category->name }}</span>
									@endif
									@if($package->quota > 0 && $package->quota <= 5)
										<span class="rounded-full bg-gold-400/90 px-3 py-1 text-[10px] font-bold text-ink-900 backdrop-blur">Sisa {{ $package->quota }}</span>
									@endif
								</div>

								{{-- Date on bottom-left of flyer --}}
								<div class="absolute bottom-3 left-3 flex items-center gap-2">
									<div class="rounded-lg bg-white/90 px-3 py-1.5 text-center backdrop-blur">
										<p class="text-[10px] font-bold leading-tight text-ink-900">{{ \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('DD') }}</p>
										<p class="text-[8px] font-semibold uppercase leading-tight text-primary-700">{{ \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('MMM') }}</p>
									</div>
								</div>
							</div>

							{{-- Content --}}
							<div class="p-5">
								<h3 class="font-display text-lg text-ink-900 group-hover:text-primary-700 transition">{{ $package->title }}</h3>

								<div class="mt-3 flex flex-wrap gap-x-4 gap-y-1.5 text-xs text-ink-500">
									@if($package->flight_by)
										<span class="flex items-center gap-1">
											<x-lucide-plane class="h-3.5 w-3.5 shrink-0" />
											{{ $package->flight_by }}
										</span>
									@endif
									<span class="flex items-center gap-1">
										<x-lucide-clock class="h-3.5 w-3.5 shrink-0" />
										{{ $package->total_days }} hari
									</span>
									<span class="flex items-center gap-1">
										<x-lucide-users class="h-3.5 w-3.5 shrink-0" />
										Kuota: {{ $package->quota }}
									</span>
								</div>

								{{-- Prices --}}
								<div class="mt-4 border-t border-primary-100 pt-4">
                                    @php($cheapest = $package->cheapestPrice())
                                    @if($cheapest)
                                        <p class="font-display text-xl text-gold-700">
                                            Mulai {{ $cheapest->currency === 'IDR' ? 'Rp' : ($cheapest->currency === 'USD' ? '$' : $cheapest->currency) }} {{ number_format($cheapest->price, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-ink-400">Hubungi Admin</p>
                                    @endif
								</div>

								<div class="mt-4 flex gap-2">
									<button class="product-detail-btn flex-1 rounded-full bg-primary-100 px-4 py-2.5 text-sm font-bold text-primary-800 transition group-hover:bg-primary-600 group-hover:text-white">Lihat Detail</button>
								</div>
							</div>
						</article>
					@endforeach
				</div>
			</div>
		@empty
			<div class="py-20 text-center">
				<x-lucide-package-search class="mx-auto h-20 w-20 text-base-content/15" />
				<p class="mt-6 text-xl font-semibold text-base-content/50">Tidak ada paket ditemukan</p>
				<p class="mt-2 text-sm text-base-content/40">Coba ubah filter atau bulan keberangkatan.</p>
				<a href="{{ url('/packages') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-primary-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-700">
					<x-lucide-rotate-ccw class="h-4 w-4" />
					Reset Filter
				</a>
			</div>
		@endforelse
	</section>
</main>
@endsection