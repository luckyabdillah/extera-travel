@extends('layouts.main')

@section('title', 'Kontak')

@section('content')
<main>
    <section class="bg-ink-950 py-30" data-nav-theme="dark">
        <div class="mx-auto max-w-3xl px-6 text-center">
            <p class="text-sm font-bold uppercase tracking-wider text-gold-400">Kontak</p>
            <h1 class="mt-3 font-display text-4xl text-white sm:text-5xl">Hubungi Kami</h1>
            <p class="mt-4 text-ink-100/70">Ada pertanyaan atau butuh bantuan? Tim kami siap merespon.</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-6 py-16 lg:py-24">
        <div class="grid gap-10 lg:grid-cols-2">
            {{-- Contact Info --}}
            <div class="space-y-8">
                <div>
                    <h2 class="font-display text-2xl text-ink-900">Info Kontak</h2>
                    <p class="mt-2 text-sm text-ink-400">Jangan ragu untuk menghubungi kami melalui kontak di bawah atau kirim pesan langsung melalui form.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-ink-900">Alamat</p>
                            <p class="mt-0.5 text-sm text-ink-400">Jl. Contoh Alamat No. 123, Jakarta, Indonesia</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-ink-900">Telepon</p>
                            <p class="mt-0.5 text-sm text-ink-400">+62 812-3456-7890</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-ink-900">Email</p>
                            <p class="mt-0.5 text-sm text-ink-400">hello@exteratravel.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gold-100 text-gold-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-ink-900">WhatsApp</p>
                            <p class="mt-0.5 text-sm text-ink-400">+62 812-8389-0098</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="rounded-3xl border border-ink-200 bg-white p-6 shadow-sm lg:p-8">
                <h2 class="font-display text-xl text-ink-900">Kirim Pesan</h2>
                <p class="mt-1 text-sm text-ink-400">Isi form di bawah, kami akan merespon via WhatsApp.</p>
                <form id="contactForm" class="mt-6 space-y-4">
                    <div>
                        <label class="text-xs font-semibold text-ink-600">Nama</label>
                        <input type="text" id="contactName" required class="mt-1 w-full rounded-xl border border-ink-200 bg-ink-50 px-4 py-2.5 text-sm outline-none focus:border-gold-400 focus:ring-2 focus:ring-gold-200" placeholder="Nama kamu" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-ink-600">Pesan</label>
                        <textarea id="contactMessage" rows="5" required class="mt-1 w-full rounded-xl border border-ink-200 bg-ink-50 px-4 py-2.5 text-sm outline-none focus:border-gold-400 focus:ring-2 focus:ring-gold-200 resize-none" placeholder="Tulis pesan..."></textarea>
                    </div>
                    <button type="submit" class="w-full rounded-full bg-gold-400 py-3 text-sm font-bold text-ink-900 transition hover:bg-gold-300">
                        Kirim ke WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var name = document.getElementById('contactName').value.trim();
        var message = document.getElementById('contactMessage').value.trim();
        var whatsappMessage = encodeURIComponent(message + '\n\n\u2013 ' + name);
        var whatsappLink = 'https://wa.me/6281283890098?text=' + whatsappMessage;
        window.open(whatsappLink, '_blank');
    });
</script>
@endpush
