@extends('admin.layouts.main')

@section('title', 'Blog')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>Blog</li>
@endsection

@section('content')
	@if(session('success'))
		<div class="d-alert d-alert-success mb-4 shadow-sm">
			<span>{{ session('success') }}</span>
		</div>
	@endif

	<div class="d-card bg-base-100 shadow-sm">
		<div class="d-card-body">
			<div class="mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
				<div>
					<h2 class="d-card-title font-display text-xl">Artikel Blog</h2>
					<p class="text-xs text-base-content/50">Kelola artikel untuk informasi dan edukasi jamaah.</p>
				</div>
				<a href="{{ route('admin.blogs.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tulis Artikel
				</a>
			</div>

			@if($blogs->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-newspaper class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada artikel blog.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th>Judul Artikel</th>
								<th class="hidden md:table-cell">Tanggal Publikasi</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($blogs as $blog)
								<tr>
									<td>
										<span class="font-medium text-base-content">{{ $blog->title }}</span>
                                        <p class="text-xs text-base-content/50 mt-1">/blog/{{ $blog->slug }}</p>
									</td>
									<td class="hidden md:table-cell">
										<span class="text-xs text-base-content/70">{{ $blog->created_at->format('d M Y, H:i') }}</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
                                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Lihat">
												<x-lucide-external-link class="h-4 w-4 text-base-content/70" />
											</a>
											<a href="{{ route('admin.blogs.edit', $blog) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="inline-block">
												@csrf
												@method('DELETE')
												<button type="submit" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Hapus">
													<x-lucide-trash-2 class="h-4 w-4 text-error" />
												</button>
											</form>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection