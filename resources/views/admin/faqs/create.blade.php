@extends('admin.layouts.main')

@section('title', 'Tambah FAQ')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
	<li>Tambah</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Tambah FAQ</h2>
						<p class="text-xs text-base-content/50">Buat pertanyaan dan jawaban baru.</p>
					</div>
					<a href="{{ route('admin.faqs.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-4">
					@csrf

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Pertanyaan <span class="text-error">*</span></span>
						</label>
						<input type="text" name="question" value="{{ old('question') }}" placeholder="Contoh: Bagaimana cara mendaftar umrah?" class="d-input d-input-bordered w-full" required />
						@error('question')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Jawaban <span class="text-error">*</span></span>
						</label>
						<textarea name="answer" rows="5" placeholder="Tulis jawaban lengkap di sini..." class="d-textarea d-textarea-bordered w-full" required>{{ old('answer') }}</textarea>
						@error('answer')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan FAQ
						</button>
						<a href="{{ route('admin.faqs.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection