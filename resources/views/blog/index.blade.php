@extends('layouts.main')

@section('title', 'Blog & Artikel')

@section('content')
<main>
	<section class="bg-ink-950 py-20" data-nav-theme="dark">
		<div class="mx-auto max-w-3xl px-6 text-center">
			<p class="text-sm font-bold uppercase tracking-wider text-gold-400">Artikel</p>
			<h1 class="mt-3 font-display text-4xl text-white sm:text-5xl">Blog Extera Travel</h1>
			<p class="mt-4 text-ink-100/70">Kumpulan cerita perjalanan, tips umrah, dan inspirasi ibadah.</p>
		</div>
	</section>

	<section class="mx-auto max-w-7xl px-6 py-16 lg:py-24">
		@if($blogs->isEmpty())
			<div class="py-16 text-center">
				<x-lucide-newspaper class="mx-auto h-16 w-16 text-base-content/20" />
				<p class="mt-4 text-lg text-base-content/50">Belum ada artikel.</p>
			</div>
		@else
			<div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
				@foreach($blogs as $blog)
					<article class="group overflow-hidden rounded-3xl border border-primary-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
						<div class="p-6">
							<p class="text-xs text-ink-400">{{ $blog->created_at->format('d M Y') }}</p>
							<a href="{{ route('blog.show', $blog->slug) }}" class="mt-2 block">
								<h3 class="font-display text-xl text-ink-900 group-hover:text-primary-700 transition">{{ $blog->title }}</h3>
							</a>
							<p class="mt-3 text-sm text-ink-500 line-clamp-3">
								{{ Str::limit(strip_tags($blog->content), 120) }}
							</p>
							<a href="{{ route('blog.show', $blog->slug) }}" class="mt-5 inline-flex items-center gap-1 text-sm font-bold text-primary-600 transition group-hover:text-primary-800">
								Baca selengkapnya
								<x-lucide-arrow-right class="h-4 w-4" />
							</a>
						</div>
					</article>
				@endforeach
			</div>
			
			<div class="mt-12 flex justify-center">
				{{ $blogs->links() }}
			</div>
		@endif

		<div class="mt-16 text-center">
			<a href="{{ url('/') }}" class="inline-flex items-center gap-2 rounded-full border border-primary-200 bg-white px-6 py-3 text-sm font-bold text-ink-900 transition hover:bg-primary-50">
				<x-lucide-arrow-left class="h-4 w-4" />
				Kembali ke Beranda
			</a>
		</div>
	</section>
</main>
@endsection