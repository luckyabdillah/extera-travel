@extends('admin.layouts.main')

@section('title', 'Edit FAQ')

@section('breadcrumb')
	<li><a href="{{ route('admin') }}">Dashboard</a></li>
	<li><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
	<li>Edit</li>
@endsection

@section('content')
	<div class="max-w-2xl">
		<div class="d-card bg-base-100 shadow-sm">
			<div class="d-card-body">
				<div class="mb-6 flex items-center justify-between">
					<div>
						<h2 class="d-card-title font-display text-xl">Edit FAQ</h2>
						<p class="text-xs text-base-content/50">Perbarui pertanyaan atau jawaban.</p>
					</div>
					<a href="{{ route('admin.faqs.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
						<x-lucide-arrow-left class="h-4 w-4" />
						Kembali
					</a>
				</div>

				<form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-4">
					@csrf
					@method('PUT')

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Pertanyaan <span class="text-error">*</span></span>
						</label>
						<input type="text" name="question" value="{{ old('question', $faq->question) }}" class="d-input d-input-bordered w-full" required />
						@error('question')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="d-form-control w-full">
						<label class="label">
							<span class="label-text font-semibold">Jawaban <span class="text-error">*</span></span>
						</label>
						<textarea name="answer" rows="5" class="d-textarea d-textarea-bordered w-full" required>{{ old('answer', $faq->answer) }}</textarea>
						@error('answer')
							<span class="text-xs text-error mt-1">{{ $message }}</span>
						@enderror
					</div>

					<div class="pt-4 flex gap-2">
						<button type="submit" class="d-btn d-btn-primary">
							<x-lucide-save class="h-4 w-4 mr-2" />
							Simpan Perubahan
						</button>
						<a href="{{ route('admin.faqs.index') }}" class="d-btn d-btn-ghost">Batal</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection