@extends('layouts.main')

@section('title', 'Checkout')

@section('content')
<main>
	<section class="bg-ink-950 py-30" data-nav-theme="dark">
		<div class="mx-auto max-w-3xl px-6 text-center">
			<p class="text-sm font-bold uppercase tracking-wider text-gold-400">Pemesanan</p>
			<h1 class="mt-3 font-display text-3xl text-white sm:text-4xl">Lengkapi Data Pemesan</h1>
			<p class="mt-4 text-ink-100/70">{{ $package->title }} &mdash; {{ \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
		</div>
	</section>

	<section class="mx-auto max-w-3xl px-6 py-12 lg:py-16">
		<form id="checkoutForm" method="POST" action="{{ route('checkout.customers', $package) }}" class="space-y-8">
			@csrf
			<input type="hidden" name="total_pax" id="totalPax" value="{{ old('total_pax', 1) }}" />

			<div class="d-card bg-base-100 border border-primary-200 shadow-sm">
				<div class="d-card-body">
					<h2 class="d-card-title font-display text-lg mb-2">Data Pemesan</h2>
					<div class="grid gap-4 sm:grid-cols-2">
						<div class="d-form-control sm:col-span-2">
							<label class="label"><span class="label-text font-semibold">Nama Lengkap <span class="text-error">*</span></span></label>
							<input type="text" name="booker_name" value="{{ old('booker_name') }}" class="d-input d-input-bordered w-full" required />
							@error('booker_name')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">Email <span class="text-error">*</span></span></label>
							<input type="email" name="booker_email" value="{{ old('booker_email') }}" class="d-input d-input-bordered w-full" required />
							@error('booker_email')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
						<div class="d-form-control">
							<label class="label"><span class="label-text font-semibold">No. HP</span></label>
							<input type="tel" name="booker_phone" value="{{ old('booker_phone') }}" class="d-input d-input-bordered w-full" />
							@error('booker_phone')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
						</div>
					</div>

					<div class="mt-4 d-form-control">
						<label class="label"><span class="label-text font-semibold">Jumlah Jamaah <span class="text-error">*</span></span></label>
						<select name="total_pax" id="totalPaxSelect" class="d-select d-select-bordered w-full" required>
							@for($i = 1; $i <= 10; $i++)
								<option value="{{ $i }}" {{ old('total_pax', 1) == $i ? 'selected' : '' }}>{{ $i }} Jamaah</option>
							@endfor
						</select>
						@error('total_pax')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
					</div>
				</div>
			</div>

			<div class="d-card bg-base-100 border border-primary-200 shadow-sm">
				<div class="d-card-body">
					<div class="flex items-center justify-between mb-4">
						<h2 class="d-card-title font-display text-lg">Detail Jamaah</h2>
						<label class="flex cursor-pointer items-center gap-2">
							<input type="checkbox" id="sameAsBooker" class="d-checkbox d-checkbox-primary d-checkbox-sm" />
							<span class="text-xs font-semibold text-ink-600">Isi detail penumpang sama dengan pemesan</span>
						</label>
					</div>
					<div id="passengerContainer" class="space-y-6"></div>
					@error('passengers')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
					@error('passengers.*')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
				</div>
			</div>

			<div class="flex gap-3 justify-end">
				<a href="{{ url('/packages') }}" class="d-btn d-btn-ghost">Batal</a>
				<button type="submit" class="d-btn d-btn-primary px-8">
					<x-lucide-arrow-right class="h-4 w-4 mr-2" />
					Lanjut ke Konfirmasi
				</button>
			</div>
		</form>
	</section>
</main>
@endsection

@push('scripts')
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			let prices = @json($package->prices);
			let mappedPrices = prices.map(p => ({
				id: p.id,
				price_type: p.price_type,
				currency: p.currency,
				price: p.price
			}));
			let container = document.getElementById("passengerContainer");
			let select = document.getElementById("totalPaxSelect");
			let hiddenTotal = document.getElementById("totalPax");
			let sameCheck = document.getElementById("sameAsBooker");
			let bookerName = document.querySelector("input[name=booker_name]");
			let bookerEmail = document.querySelector("input[name=booker_email]");
			let bookerPhone = document.querySelector("input[name=booker_phone]");

			function renderPassengers(count) {
				container.innerHTML = "";
				for (let i = 0; i < count; i++) {
					let num = i + 1;
					let div = document.createElement("div");
					div.className = 'rounded-xl border border-primary-100 bg-primary-50/50 p-4';
					let priceOptions = '';
					mappedPrices.forEach(function(p) {
						let formatted = p.currency === 'IDR'
							? 'Rp ' + Number(p.price).toLocaleString('id-ID')
							: '$ ' + Number(p.price).toLocaleString('en-US');
						priceOptions += '<option value="' + p.id + '">' + p.price_type + ' (' + formatted + ')</option>';
					});
					div.innerHTML = '<h4 class="font-display text-sm font-bold text-ink-900 mb-3">Jamaah #' + num + '</h4>'
						+ '<div class="grid gap-3 sm:grid-cols-2">'
						+ '<div class="d-form-control sm:col-span-2"><label class="label"><span class="label-text font-semibold text-xs">Nama Lengkap</span></label>'
						+ '<input type="text" name="passengers[' + i + '][name]" class="d-input d-input-bordered d-input-sm w-full" required /></div>'
						+ '<div class="d-form-control"><label class="label"><span class="label-text font-semibold text-xs">Email</span></label>'
						+ '<input type="email" name="passengers[' + i + '][email]" class="d-input d-input-bordered d-input-sm w-full" /></div>'
						+ '<div class="d-form-control"><label class="label"><span class="label-text font-semibold text-xs">No. HP</span></label>'
						+ '<input type="tel" name="passengers[' + i + '][phone]" class="d-input d-input-bordered d-input-sm w-full" /></div>'
						+ '<div class="d-form-control"><label class="label"><span class="label-text font-semibold text-xs">Jenis Kelamin</span></label>'
						+ '<select name="passengers[' + i + '][gender]" class="d-select d-select-bordered d-select-sm w-full" required>'
						+ '<option value="male">Laki-laki</option><option value="female">Perempuan</option></select></div>'
						+ '<div class="d-form-control"><label class="label"><span class="label-text font-semibold text-xs">Tipe Harga</span></label>'
						+ '<select name="passengers[' + i + '][price_type]" class="d-select d-select-bordered d-select-sm w-full" required>'
						+ priceOptions + '</select></div>'
						+ '</div>';
					container.appendChild(div);
				}
			}

			select.addEventListener("change", function() {
				hiddenTotal.value = this.value;
				renderPassengers(parseInt(this.value));
			});

			sameCheck.addEventListener("change", function() {
				let inputs = container.querySelectorAll("input");
				let genderSelects = container.querySelectorAll("select");
				if (this.checked) {
					inputs.forEach(function(inp) {
						let name = inp.name;
						if (name.includes("[name]")) inp.value = bookerName.value;
						else if (name.includes("[email]")) inp.value = bookerEmail.value;
						else if (name.includes("[phone]")) inp.value = bookerPhone.value;
					});
				} else {
					inputs.forEach(function(inp) { inp.value = ""; });
					genderSelects.forEach(function(sel) { sel.value = "male"; });
				}
			});

			renderPassengers(parseInt(select.value));
		});
	</script>
@endpush