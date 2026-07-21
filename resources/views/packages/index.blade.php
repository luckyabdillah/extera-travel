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
									<button type="button"
										class="detail-btn flex-1 rounded-full bg-primary-100 px-4 py-2.5 text-sm font-bold text-primary-800 transition hover:bg-primary-600 hover:text-white"
										data-uuid="{{ $package->uuid }}">
										Lihat Detail
									</button>
									@if($package->quota > 0)
										<a href="{{ route('checkout', $package->uuid) }}"
											class="flex-1 rounded-full text-center border border-primary-200 bg-white px-4 py-2.5 text-sm font-bold text-ink-600 transition hover:bg-primary-50 hover:text-primary-700">
											Book
										</a>
									@else
										<span
											class="flex-1 rounded-full text-center border border-ink-200 bg-ink-50 px-4 py-2.5 text-sm font-bold text-ink-300 cursor-not-allowed">
											Kuota Habis
										</span>
									@endif
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

{{-- Detail Modal --}}
<div id="packageModal" class="fixed inset-0 z-60 hidden items-center justify-center p-4" aria-hidden="true">
	<div id="modalBackdrop" class="absolute inset-0 bg-ink-950/70 backdrop-blur-sm"></div>
	<div class="relative z-10 w-full max-w-3xl min-h-[300px] max-h-[85vh] overflow-y-auto rounded-3xl border border-gold-200 bg-white shadow-soft">
		{{-- Modal header --}}
		<div class="sticky top-0 z-10 flex items-start justify-between gap-4 border-b border-primary-100 bg-white p-6 pb-4">
			<div>
				<p class="text-xs font-bold uppercase tracking-wider text-gold-700">Detail Paket</p>
				<h3 id="modalTitle" class="mt-1 font-display text-2xl text-ink-900">Memuat...</h3>
			</div>
			<button id="closeModalBtn" class="rounded-full border border-primary-200 px-3 py-1.5 text-sm font-bold text-primary-700 transition hover:bg-primary-50">Tutup</button>
		</div>

		{{-- Loading spinner --}}
		<div id="modalLoading" class="flex flex-col items-center justify-center py-20">
			<div class="h-8 w-8 animate-spin rounded-full border-3 border-gold-400 border-t-transparent"></div>
			<p class="mt-4 text-sm text-ink-400">Memuat detail paket...</p>
		</div>

		{{-- Modal content --}}
		<div id="modalContent" class="hidden p-6 pt-4 space-y-6">
			<div id="modalInfo" class="grid grid-cols-2 sm:grid-cols-4 gap-4"></div>
			<div id="modalPrices" class="rounded-2xl bg-primary-50 p-4">
				<h4 class="font-display text-sm font-semibold text-primary-800 mb-2">Harga Paket</h4>
				<div class="space-y-1"></div>
			</div>
			<div id="modalLists">
				<div id="modalTabs" class="tabs tabs-bordered flex gap-0 border-b border-primary-200 mb-4" role="tablist">
					<button class="tab tab-active font-bold text-sm px-5 py-2.5 text-primary-700 border-b-2 border-primary-600" data-tab="inclusions" role="tab">Termasuk</button>
					<button class="tab font-bold text-sm px-5 py-2.5 text-ink-500 border-b-2 border-transparent hover:text-ink-700" data-tab="exclusions" role="tab">Tidak Termasuk</button>
					<button class="tab font-bold text-sm px-5 py-2.5 text-ink-500 border-b-2 border-transparent hover:text-ink-700" data-tab="requirements" role="tab">Persyaratan</button>
				</div>
				<div id="modalTabContent" class="min-h-[120px]"></div>
			</div>
			<div id="modalItinerary">
				<h4 class="font-display text-base font-semibold text-ink-900 mb-4 flex items-center gap-2">
					<x-lucide-map-pin class="h-5 w-5 text-gold-600" />
					Itinerary Perjalanan
				</h4>
				<div class="space-y-3"></div>
			</div>
		</div>

		{{-- Error state --}}
		<div id="modalError" class="hidden flex flex-col items-center justify-center py-16">
			<x-lucide-alert-circle class="h-12 w-12 text-error/60" />
			<p class="mt-4 text-sm font-semibold text-ink-600">Gagal memuat detail paket</p>
			<p class="mt-1 text-xs text-ink-400">Silakan coba lagi.</p>
		</div>
	</div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
	let modal = document.getElementById("packageModal");
	let backdrop = document.getElementById("modalBackdrop");
	let closeBtn = document.getElementById("closeModalBtn");
	let loading = document.getElementById("modalLoading");
	let content = document.getElementById("modalContent");
	let error = document.getElementById("modalError");
	let modalTitle = document.getElementById("modalTitle");
	let modalInfo = document.getElementById("modalInfo");
	let modalPrices = document.getElementById("modalPrices").querySelector(".space-y-1");
	let modalItinerary = document.getElementById("modalItinerary").querySelector(".space-y-3");

	function renderModal(data) {
		modalTitle.textContent = data.title;

		modalInfo.innerHTML = ""
			+ '<div class="rounded-xl bg-base-100 p-3 text-center"><p class="text-xs text-base-content/50">Kategori</p><p class="font-display text-sm font-bold text-ink-900 mt-0.5">' + (data.category || "-") + '</p></div>'
			+ '<div class="rounded-xl bg-base-100 p-3 text-center"><p class="text-xs text-base-content/50">Maskapai</p><p class="font-display text-sm font-bold text-ink-900 mt-0.5">' + (data.flight_by || "-") + '</p></div>'
			+ '<div class="rounded-xl bg-base-100 p-3 text-center"><p class="text-xs text-base-content/50">Keberangkatan</p><p class="font-display text-sm font-bold text-ink-900 mt-0.5">' + data.date + '</p></div>'
			+ '<div class="rounded-xl bg-base-100 p-3 text-center"><p class="text-xs text-base-content/50">Durasi</p><p class="font-display text-sm font-bold text-ink-900 mt-0.5">' + data.total_days + " hari / Kuota " + data.quota + '</p></div>';

		modalPrices.innerHTML = "";
		if (data.prices && data.prices.length) {
			data.prices.forEach(function(p) {
				modalPrices.innerHTML += '<div class="flex items-center justify-between text-sm py-1"><span class="text-ink-600">' + p.price_type + '</span><span class="font-display font-bold text-gold-700">' + (p.currency === "IDR" ? "Rp" : p.currency) + " " + p.price + '</span></div>';
			});
		} else {
			modalPrices.innerHTML = '<p class="text-sm text-ink-400">Hubungi Admin</p>';
		}



		modalItinerary.innerHTML = "";
		if (data.itineraries && data.itineraries.length) {
			data.itineraries.forEach(function(i, idx) {
				let acd = i.accommodation_days ? " (" + i.accommodation_days + " malam)" : "";
				let meta = i.accommodation_place || i.meals
					? '<div class="flex flex-wrap gap-x-4 gap-y-1 px-4 pb-3 text-xs text-ink-500 border-t border-primary-100 pt-3">'
						+ (i.accommodation_place ? "<span>" + i.accommodation_place + acd + "</span>" : "")
						+ (i.meals ? "<span>" + i.meals + "</span>" : "")
						+ "</div>"
					: "";
				modalItinerary.innerHTML += '<details class="group rounded-xl border border-primary-200 overflow-hidden ' + (idx === 0 ? "open" : "") + '">'
					+ '<summary class="flex cursor-pointer items-center justify-between gap-3 bg-primary-50 px-4 py-3 list-none marker:content-none">'
					+ '<div class="flex items-center gap-3"><span class="d-badge d-badge-primary d-badge-sm font-bold shrink-0">' + i.marker + '</span>'
					+ '<span class="font-display text-sm font-bold text-ink-900">' + i.title + '</span></div>'
					+ '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 shrink-0 text-primary-600 transition group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>'
					+ '</summary>'
					+ '<div class="px-4 py-3 text-sm text-ink-600 leading-relaxed whitespace-pre-line">' + i.itinerary + '</div>'
					+ meta + '</details>';
			});
		} else {
			modalItinerary.innerHTML = '<p class="text-sm text-ink-400">Itinerary belum tersedia untuk paket ini.</p>';
		}

		window._modalData = data;
		loading.classList.add("hidden");
		error.classList.add("hidden");
		content.classList.remove("hidden");
		switchTab("inclusions");
	}

	function showError(msg) {
		loading.classList.add("hidden");
		content.classList.add("hidden");
		error.classList.remove("hidden");
	}

	function openModalWithUuid(uuid) {
		modalTitle.textContent = "Memuat...";
		loading.classList.remove("hidden");
		content.classList.add("hidden");
		error.classList.add("hidden");

		modal.classList.remove("hidden");
		modal.classList.add("flex");
		modal.setAttribute("aria-hidden", "false");
		document.body.classList.add("overflow-hidden");

		fetch("/api/packages/" + uuid)
			.then(function(r) { if (!r.ok) throw new Error("Fetch failed"); return r.json(); })
			.then(renderModal)
			.catch(function() { showError(); });
	}

	let tabContent = document.getElementById("modalTabContent");

	function switchTab(key) {
		let data = window._modalData;
		if (!data) return;
		let val = data[key];
		let html = "";
		if (val) {
			html += "<ul class=\"list-disc pl-5 space-y-2 text-sm text-ink-700 leading-relaxed\">";
			val.split("\n").forEach(function(line) {
				if (line.trim()) html += "<li>" + line.trim() + "</li>";
			});
			html += "</ul>";
		} else {
			html += "<p class=\"text-sm text-ink-400 italic\">Tidak ada informasi.</p>";
		}
		tabContent.innerHTML = html;
	}

	document.querySelectorAll("#modalTabs button").forEach(function(btn) {
		btn.addEventListener("click", function() {
			document.querySelectorAll("#modalTabs button").forEach(function(b) {
				b.classList.remove("tab-active", "text-primary-700", "border-primary-600");
				b.classList.add("text-ink-500", "border-transparent");
			});
			btn.classList.add("tab-active", "text-primary-700", "border-primary-600");
			btn.classList.remove("text-ink-500", "border-transparent");
			switchTab(btn.dataset.tab);
		});
	});

	function closeModal() {
		modal.classList.add("hidden");
		modal.classList.remove("flex");
		modal.setAttribute("aria-hidden", "true");
		document.body.classList.remove("overflow-hidden");
	}

	document.querySelectorAll(".detail-btn").forEach(function(btn) {
		btn.addEventListener("click", function() {
			openModalWithUuid(this.dataset.uuid);
		});
	});

	if (backdrop) backdrop.addEventListener("click", closeModal);
	if (closeBtn) closeBtn.addEventListener("click", closeModal);
	document.addEventListener("keydown", function(e) {
		if (e.key === "Escape" && !modal.classList.contains("hidden")) closeModal();
	});
});
</script>
@endpush

