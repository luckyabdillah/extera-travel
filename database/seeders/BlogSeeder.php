<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Persiapan Fisik Sebelum Berangkat Umrah',
                'content' => '<p>Ibadah umrah membutuhkan stamina fisik yang prima karena rangkaian ibadahnya seperti thawaf dan sa\'i melibatkan banyak berjalan kaki.</p><h3>1. Rutin Berolahraga Ringan</h3><p>Mulailah membiasakan jalan kaki minimal 30 menit setiap hari.</p><h3>2. Atur Pola Makan</h3><p>Perbanyak konsumsi sayur, buah, dan vitamin untuk menjaga daya tahan tubuh.</p><blockquote>"Kesehatan adalah modal utama kelancaran ibadah di Tanah Suci."</blockquote>',
            ],
            [
                'title' => 'Panduan Memilih Paket Umrah untuk Pemula',
                'content' => '<p>Bagi yang baru pertama kali berangkat umrah, memilih paket yang tepat sangat krusial.</p><ul><li><strong>Cek Legalitas Travel:</strong> Pastikan terdaftar resmi di Kemenag.</li><li><strong>Perhatikan Jarak Hotel:</strong> Jika membawa orang tua, pastikan jarak hotel tidak terlalu jauh dari masjid.</li><li><strong>Transparansi Harga:</strong> Tanyakan rincian apa saja yang sudah termasuk dan belum.</li></ul>',
            ],
            [
                'title' => 'Mengenal Tata Cara Pelaksanaan Umrah',
                'content' => '<p>Umrah terdiri dari serangkaian ibadah inti yang wajib diketahui:</p><ol><li><strong>Ihram:</strong> Niat dari Miqat dan memakai pakaian Ihram.</li><li><strong>Thawaf:</strong> Mengelilingi Ka\'bah sebanyak 7 kali.</li><li><strong>Sa\'i:</strong> Berjalan dari bukit Shafa ke Marwah 7 kali.</li><li><strong>Tahallul:</strong> Mencukur atau memotong sebagian rambut.</li></ol>',
            ],
        ];

        foreach ($blogs as $blog) {
            $blog['slug'] = Str::slug($blog['title']);
            Blog::create($blog);
        }

        $this->command->info('Blog berhasil di-seed: ' . count($blogs) . ' artikel.');
    }
}
