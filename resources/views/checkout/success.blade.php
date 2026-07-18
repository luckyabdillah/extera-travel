@extends('layouts.main')

@section('title', 'Pemesanan Berhasil')

@section('content')
<main>
    <section class="mx-auto max-w-2xl px-6 py-30 text-center">
        <x-lucide-check-circle class="mx-auto h-20 w-20 text-gold-500" />

        <h1 class="mt-6 font-display text-3xl text-ink-900 sm:text-4xl">
            Pemesanan Berhasil!
        </h1>

        <p class="mt-4 text-lg text-ink-600">
            Terima kasih telah melakukan pemesanan, {{ $transaction->name }}.
        </p>

        <p class="mt-2 text-ink-500 leading-relaxed">
            Permintaan Anda telah kami terima dan akan segera diproses.
            Tim kami akan menghubungi Anda dalam waktu dekat untuk melakukan
            konfirmasi serta memberikan informasi mengenai langkah selanjutnya.
        </p>

        <div class="mt-10 flex justify-center">
            <a href="{{ url('/packages') }}" class="d-btn d-btn-primary">
                <x-lucide-arrow-left class="mr-2 h-4 w-4" />
                Kembali ke Paket
            </a>
        </div>
    </section>
</main>
@endsection