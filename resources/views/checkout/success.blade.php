@extends('layouts.main')

@section('title', 'Pemesanan Berhasil')

@section('content')
<main>
	<section class="mx-auto max-w-2xl px-6 py-20 text-center">
		<x-lucide-check-circle class="mx-auto h-20 w-20 text-gold-500" />
		<h1 class="mt-6 font-display text-3xl text-ink-900 sm:text-4xl">Pemesanan Berhasil!</h1>
		<p class="mt-4 text-ink-500">Invoice <strong>{{ $transaction->invoice_no }}</strong> telah dikirim ke email <strong>{{ $transaction->email }}</strong>.</p>

		<div class="mt-8 rounded-2xl border border-primary-200 bg-primary-50 p-6 text-left text-sm">
			<div class="flex items-center justify-between mb-4">
				<span class="font-display text-lg font-bold text-ink-900">Invoice #{{ $transaction->invoice_no }}</span>
				<span class="d-badge d-badge-warning d-badge-sm">Menunggu Pembayaran</span>
			</div>
			<div class="space-y-1 text-ink-600">
				<p>Nama: <strong>{{ $transaction->name }}</strong></p>
				<p>Total: <strong class="text-gold-700">{{ number_format($transaction->total_bill, 0, ',', '.') }}</strong></p>
				<p>Batas Pembayaran: <strong>{{ $transaction->expiration_time }} jam</strong></p>
			</div>
		</div>

		<div class="mt-10 flex flex-wrap justify-center gap-3">
			<a href="{{ url('/packages') }}" class="d-btn d-btn-primary">
				<x-lucide-arrow-left class="h-4 w-4 mr-2" />
				Kembali ke Paket
			</a>
		</div>
	</section>
</main>
@endsection