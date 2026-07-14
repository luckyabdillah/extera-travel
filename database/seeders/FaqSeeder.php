<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Bagaimana cara mendaftar umrah di Extera Travel?',
                'answer' => 'Kamu bisa mendaftar melalui website dengan mengisi formulir pendaftaran, atau menghubungi admin kami via WhatsApp di nomor yang tersedia. Setelah itu, tim kami akan menghubungi kamu untuk proses selanjutnya.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Berapa minimal DP untuk mendaftar paket umrah?',
                'answer' => 'Minimal DP (Down Payment) adalah 30% dari total harga paket. DP dapat dibayarkan melalui transfer bank ke rekening resmi Extera Travel. Setelah DP lunas, keberangkatan kamu sudah terkonfirmasi.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apaya pembayaran bisa dicicil?',
                'answer' => 'Bisa! Extera Travel menyediakan opsi cicilan ringan tanpa bunga. Kamu bisa mencicil biaya umrah hingga H-7 keberangkatan. Tim admin kami akan membantu mengatur jadwal cicilan yang sesuai dengan kemampuan kamu.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apa saja yang termasuk dalam paket umrah?',
                'answer' => 'Paket umrah sudah termasuk tiket pesawat PP kelas ekonomi, akomodasi hotel bintang 4-5 dekat Masjidil Haram dan Masjid Nabawi, konsumsi tiga kali sehari, transportasi lokal, perlengkapan umrah, manasik, dan pendamping ibadah berpengalaman.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apakah ada pendamping selama perjalanan?',
                'answer' => 'Ya, setiap rombongan akan didampingi oleh pembimbing ibadah yang berpengalaman dan sudah bersertifikat. Mereka akan mendampingi dari keberangkatan, selama di tanah suci, hingga kembali ke tanah air.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Bagaimana jika saya batal berangkat?',
                'answer' => 'Pembatalan dapat dilakukan dengan syarat dan ketentuan yang berlaku. Biaya pembatalan akan disesuaikan dengan kebijakan maskapai, hotel, dan pihak terkait lainnya. Disarankan untuk memiliki asuransi perjalanan untuk mengantisipasi hal ini.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apakah Extera Travel berizin resmi?',
                'answer' => 'Extera Travel adalah biro perjalanan umrah dan haji yang berizin resmi dari Kementerian Agama RI. Kami terdaftar dan diawasi secara ketat, sehingga kamu dan keluarga bisa tenang selama perjalanan.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apa saja dokumen yang diperlukan untuk daftar umrah?',
                'answer' => 'Dokumen yang diperlukan antara lain: KTP (asli dan fotokopi), KK (kartu keluarga), paspor dengan masa berlaku minimal 12 bulan, foto berwarna latar putih ukuran 4x6, buku nikah (jika suami/istri), dan akta kelahiran jika mendaftarkan anak.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Berapa lama waktu tunggu keberangkatan umrah?',
                'answer' => 'Waktu tunggu keberangkatan tergantung pada paket yang dipilih dan ketersediaan kuota. Biasanya berkisar antara 1-3 bulan setelah pendaftaran dan pelunasan. Tim kami akan menginformasikan jadwal keberangkatan yang pasti setelah kuota terkonfirmasi.',
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'question' => 'Apakah ada program khusus untuk anak muda?',
                'answer' => 'Ada! Extera Travel memiliki program "Umrah Muda" yang dikhususkan untuk jamaah usia 18-35 tahun. Program ini dirancang dengan suasana yang lebih santai, teman seperjalanan seusia, dan sesi inspiratif bersama pembimbing muda.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('FAQ berhasil di-seed: ' . count($faqs) . ' pertanyaan.');
    }
}
