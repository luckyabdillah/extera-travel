@extends('admin.layouts.main')

@section('title', 'Tambah Hotel')

@section('breadcrumb')
 <li><a href="{{ route('admin') }}">Dashboard</a></li>
 <li><a href="{{ route('admin.hotels.index') }}">Hotel</a></li>
 <li>Tambah</li>
@endsection

@section('content')
 <div class="max-w-2xl">
  <div class="d-card bg-base-100 shadow-sm">
   <div class="d-card-body">
    <div class="mb-6 flex items-center justify-between">
     <div>
      <h2 class="d-card-title font-display text-xl">Tambah Hotel</h2>
      <p class="text-xs text-base-content/50">Tambahkan data hotel baru.</p>
     </div>
     <a href="{{ route('admin.hotels.index') }}" class="d-btn d-btn-ghost d-btn-sm gap-2">
      <x-lucide-arrow-left class="h-4 w-4" />
      Kembali
     </a>
    </div>

    <form action="{{ route('admin.hotels.store') }}" method="POST" class="space-y-4">
     @csrf

     <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Nama Hotel <span class="text-error">*</span></span>
       </label>
       <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Pullman Zamzam Madinah" class="d-input d-input-bordered w-full" required />
       @error('name')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Kota <span class="text-error">*</span></span>
       </label>
       <select name="city" class="d-select d-select-bordered w-full" required>
        <option value="">Pilih Kota</option>
        <option value="makkah" @selected(old('city') === 'makkah')>Makkah</option>
        <option value="madinah" @selected(old('city') === 'madinah')>Madinah</option>
        <option value="jeddah" @selected(old('city') === 'jeddah')>Jeddah</option>
       </select>
       @error('city')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Bintang <span class="text-error">*</span></span>
       </label>
       <select name="star_rating" class="d-select d-select-bordered w-full" required>
        @for($i = 1; $i <= 5; $i++)
         <option value="{{ $i }}" @selected(old('star_rating', 3) == $i)>{{ $i }} &#9733;</option>
        @endfor
       </select>
       @error('star_rating')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Telepon</span>
       </label>
       <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+966-..." class="d-input d-input-bordered w-full" />
       @error('phone')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="sm:col-span-2 d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Email</span>
       </label>
       <input type="email" name="email" value="{{ old('email') }}" placeholder="hotel@example.com" class="d-input d-input-bordered w-full" />
       @error('email')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="sm:col-span-2 d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Alamat</span>
       </label>
       <textarea name="address" rows="3" placeholder="Alamat lengkap hotel..." class="d-textarea d-textarea-bordered w-full">{{ old('address') }}</textarea>
       @error('address')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Latitude</span>
       </label>
       <input type="text" name="latitude" value="{{ old('latitude') }}" placeholder="Contoh: 21.4225" class="d-input d-input-bordered w-full" />
       @error('latitude')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Longitude</span>
       </label>
       <input type="text" name="longitude" value="{{ old('longitude') }}" placeholder="Contoh: 39.8262" class="d-input d-input-bordered w-full" />
       @error('longitude')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>

      <div class="sm:col-span-2 d-form-control w-full">
       <label class="label">
        <span class="label-text font-semibold">Deskripsi</span>
       </label>
       <textarea name="description" rows="4" placeholder="Deskripsi atau catatan tentang hotel..." class="d-textarea d-textarea-bordered w-full">{{ old('description') }}</textarea>
       @error('description')<span class="text-xs text-error mt-1">{{ $message }}</span>@enderror
      </div>
     </div>

     <div class="pt-4 flex gap-2">
      <button type="submit" class="d-btn d-btn-primary">
       <x-lucide-save class="h-4 w-4 mr-2" />
       Simpan Hotel
      </button>
      <a href="{{ route('admin.hotels.index') }}" class="d-btn d-btn-ghost">Batal</a>
     </div>
    </form>
   </div>
  </div>
 </div>
@endsection
