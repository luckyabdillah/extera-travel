@extends('layouts.main')

@section('title', 'Konfirmasi Pemesanan')

@section('content')
<main>
	<section class="bg-ink-950 py-30" data-nav-theme="dark">
		<div class="mx-auto max-w-3xl px-6 text-center">
			<p class="text-sm font-bold uppercase tracking-wider text-gold-400">Konfirmasi</p>
			<h1 class="mt-3 font-display text-3xl text-white sm:text-4xl">Konfirmasi Pemesanan</h1>
			<p class="mt-4 text-ink-100/70">Pastikan semua data sudah benar sebelum melanjutkan, ya!</p>
		</div>
	</section>

	<section class="mx-auto max-w-6xl px-6 py-12 lg:py-16">
		<div class="grid gap-8 lg:grid-cols-3">
			{{-- LEFT --}}
			<div class="space-y-6 lg:col-span-2">
				{{-- Paket --}}
				<div class="d-card border border-primary-200 bg-base-100 shadow-sm">
					<div class="d-card-body">
						<span class="text-xs uppercase tracking-widest text-primary-600">
							Paket Perjalanan
						</span>
						<h2 class="mt-2 font-display text-2xl">
							{{ $package->title }}
						</h2>
						<p class="mt-1 text-sm text-ink-500">
							{{ $package->category?->name }}
							-
							{{ \Carbon\Carbon::parse($package->date)->locale('id')->isoFormat('DD MMMM YYYY') }}
						</p>
					</div>
				</div>

				{{-- Data Pemesan --}}
				<div class="d-card border border-primary-200 bg-base-100 shadow-sm">
					<div class="d-card-body">
						<h3 class="d-card-title mb-4">
							Data Pemesan
						</h3>
						<div class="grid gap-4 sm:grid-cols-2">
							<div>
								<p class="text-xs uppercase text-ink-400">
									Nama
								</p>
								<p class="font-semibold">
									{{ session('checkout.booker_name') }}
								</p>
							</div>
							<div>
								<p class="text-xs uppercase text-ink-400">
									Email
								</p>
								<p class="font-semibold">
									{{ session('checkout.booker_email') }}
								</p>
							</div>
							<div>
								<p class="text-xs uppercase text-ink-400">
									No. HP
								</p>
								<p class="font-semibold">
									{{ session('checkout.booker_phone') ?? '-' }}
								</p>
							</div>
						</div>
					</div>
				</div>

				{{-- Jamaah --}}
				<div class="d-card border border-primary-200 bg-base-100 shadow-sm">
					<div class="d-card-body">
						<div class="flex items-center justify-between mb-4">
							<h3 class="d-card-title">
								Detail Jamaah
							</h3>
							<span class="d-badge d-badge-primary">
								{{ count($customers) }} Jamaah
							</span>
						</div>
						<div class="space-y-3">
							@foreach($customers as $i => $c)
							<div class="rounded-xl border border-base-300 p-4">
								<div class="flex items-start justify-between">
									<div>
										<p class="font-semibold">
											{{ $c->name }}
										</p>
										<p class="mt-1 text-sm text-ink-500">
											{{ $c->sex == 'male' ? 'Laki-laki' : 'Perempuan' }}
											@if($c->email)
												- {{ $c->email }}
											@endif

										</p>
									</div>
									<span class="text-sm font-bold text-primary">
										#{{ $i+1 }}
									</span>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>

			{{-- RIGHT --}}
			<div>
				<div class="sticky top-24">
					<div class="d-card border border-primary-300 bg-base-100 shadow-lg">
						<div class="d-card-body">
							<h3 class="d-card-title">
								Ringkasan Pembayaran
							</h3>
							<div class="mt-5 space-y-3 text-sm">
								<div class="flex justify-between">
									<span>Harga / Jamaah</span>
									<span>
										{{ $cheapest->currency === 'IDR' ? 'Rp' : '$' }}
										{{ number_format($cheapest->price,0,',','.') }}
									</span>
								</div>
								<div class="flex justify-between">
									<span>Total Jamaah</span>
									<span>{{ session('checkout.total_pax') }}</span>
								</div>
								<div class="divider my-2"></div>
								<div class="flex justify-between text-lg font-bold">
									<span>Total</span>
									<span class="text-primary">
										{{ $cheapest->currency === 'IDR' ? 'Rp ' : '$ ' }}
										{{ number_format($cheapest->price * session('checkout.total_pax'),0,',','.') }}
									</span>
								</div>
							</div>
							<form action="{{ route('checkout.confirm', $package) }}" method="POST">
								@csrf
								<button class="d-btn d-btn-primary mt-6 w-full">
									<x-lucide-check-circle class="mr-2 h-4 w-4"/>
									Konfirmasi
								</button>
							</form>
							<a href="{{ url('/packages') }}" class="d-btn d-btn-ghost mt-2 w-full">
								Batal
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection