@extends('layouts.main')

@section('title', 'FAQ')

@section('content')
<main>
	<section class="bg-ink-950 py-30" data-nav-theme="dark">
		<div class="mx-auto max-w-3xl px-6 text-center">
			<p class="text-sm font-bold uppercase tracking-wider text-gold-400">FAQ</p>
			<h1 class="mt-3 font-display text-4xl text-white sm:text-5xl">Pertanyaan yang Sering Diajukan</h1>
			<p class="mt-4 text-ink-100/70">Temukan jawaban untuk pertanyaan seputar pendaftaran, pembayaran, dan perjalanan umrah.</p>
		</div>
	</section>

	<section class="mx-auto max-w-3xl px-6 py-16 lg:py-24">
		@forelse($faqs as $faq)
			<details class="group border-b border-primary-200 py-5 open:pb-6">
				<summary class="flex cursor-pointer items-center justify-between gap-4 font-display text-lg text-ink-900 list-none marker:content-none">
					<span>{{ $faq->question }}</span>
					<x-lucide-chevron-down class="h-5 w-5 shrink-0 text-gold-600 transition duration-300 group-open:rotate-180" />
				</summary>
				<div class="mt-3 text-sm text-ink-600 leading-relaxed">
					{{ $faq->answer }}
				</div>
			</details>
		@empty
			<div class="py-16 text-center">
				<x-lucide-message-circle-question-mark class="mx-auto h-16 w-16 text-base-content/20" />
				<p class="mt-4 text-lg text-base-content/50">Belum ada FAQ.</p>
				<p class="text-sm text-base-content/40">Silakan hubungi admin untuk informasi lebih lanjut.</p>
			</div>
		@endforelse

		<div class="mt-12 text-center">
			<a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full bg-primary-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-primary-700">
				<x-lucide-arrow-left class="h-4 w-4" />
				Kembali ke Beranda
			</a>
		</div>
	</section>
</main>
@endsection
