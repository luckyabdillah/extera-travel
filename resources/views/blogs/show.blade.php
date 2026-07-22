@extends('layouts.main')

@section('title', $blog->title . ' - Blog')

@section('content')
<main>
	<section class="bg-ink-950 py-30" data-nav-theme="dark">
		<div class="mx-auto max-w-4xl px-6 text-center">
			<a href="{{ url('/blogs') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gold-400 hover:text-gold-300 transition">
				<x-lucide-arrow-left class="h-4 w-4" />
				Kembali ke Blog
			</a>
			<h1 class="mt-6 font-display text-3xl text-white sm:text-4xl lg:text-5xl leading-tight">{{ $blog->title }}</h1>
			<p class="mt-6 text-sm text-ink-100/50">Dipublikasikan pada {{ $blog->created_at->format('d F Y') }}</p>
		</div>
	</section>

	<section class="mx-auto max-w-3xl px-6 py-16 lg:py-24">
		@if($blog->image_cover)
			<img src="{{ asset('storage/' . $blog->image_cover) }}" class="mb-8 w-full rounded-2xl object-cover max-h-96" alt="{{ $blog->title }}" />
		@endif
		<article class="prose prose-lg prose-headings:font-display prose-a:text-primary-600 max-w-none text-ink-700">
			{!! $blog->content !!}
		</article>

		<div class="mt-16 border-t border-primary-200 pt-8 flex justify-between items-center">
			<a href="{{ url('/blogs') }}" class="inline-flex items-center gap-2 text-sm font-bold text-primary-600 transition hover:text-primary-800">
				<x-lucide-arrow-left class="h-4 w-4" />
				Artikel Lainnya
			</a>
		</div>
	</section>
</main>
@endsection