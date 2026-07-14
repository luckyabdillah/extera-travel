@extends('admin.layouts.main')

@section('title', 'FAQ')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li>FAQ</li>
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
					<h2 class="d-card-title font-display text-xl">FAQ</h2>
					<p class="text-xs text-base-content/50">Kelola pertanyaan yang sering diajukan jamaah.</p>
				</div>
				<a href="{{ route('admin.faqs.create') }}" class="d-btn d-btn-primary d-btn-sm gap-2">
					<x-lucide-plus class="h-4 w-4" />
					Tambah FAQ
				</a>
			</div>

			@if($faqs->isEmpty())
				<div class="py-12 text-center">
					<x-lucide-message-circle-question-mark class="mx-auto h-12 w-12 text-base-content/30" />
					<p class="mt-2 text-sm text-base-content/50">Belum ada FAQ.</p>
				</div>
			@else
				<div class="overflow-x-auto">
					<table class="d-table d-table-zebra">
						<thead>
							<tr>
								<th class="w-16">No</th>
								<th>Pertanyaan</th>
								<th class="hidden lg:table-cell">Jawaban</th>
								<th class="w-32 text-right">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($faqs as $index => $faq)
								<tr>
									<td class="text-base-content/50 text-sm">{{ $index + 1 }}</td>
									<td>
										<span class="font-medium text-base-content">{{ $faq->question }}</span>
									</td>
									<td class="hidden lg:table-cell">
										<span class="text-xs text-base-content/70">{{ Str::limit(strip_tags($faq->answer), 100) }}</span>
									</td>
									<td class="text-right">
										<div class="flex justify-end gap-2">
											<a href="{{ route('admin.faqs.edit', $faq) }}" class="d-btn d-btn-square d-btn-ghost d-btn-sm" title="Edit">
												<x-lucide-edit-3 class="h-4 w-4 text-info" />
											</a>
											<form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')" class="inline-block">
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