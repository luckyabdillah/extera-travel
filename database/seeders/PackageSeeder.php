<?php

namespace Database\Seeders;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Reguler 9 Hari',
                'slug' => Str::slug('Umrah Reguler 9 Hari'),
                'package_category_id' => 1,
                'flight_by' => 'Saudia Airlines',
                'date' => Carbon::now()->addMonths(2),
                'total_days' => 9,
                'quota' => 30,
                'inclusions' => "Tiket pesawat PP\nHotel bintang 4 dekat Masjidil Haram\nHotel bintang 4 dekat Masjid Nabawi\nVisa umrah\nKonsumsi 3x sehari\nTransportasi lokal\nPerlengkapan umrah\nManasik sebelum berangkat",
                'exclusions' => "Biaya visa tambahan jika ada perubahan\nBiaya kelebihan bagasi\nBiaya tour tambahan di luar paket\nLaundry dan telepon hotel",
                'requirements' => "Paspor masa berlaku min 12 bulan\nKTP asli dan fotokopi\nKK fotokopi\nPas foto 4x6 latar putih\nBuku nikah (jika suami/istri)\nAkta kelahiran (jika mendaftarkan anak)",
                'prices' => [
                    ['price_type' => 'QUAD', 'currency' => 'IDR', 'price' => 28000000],
                    ['price_type' => 'TRIPLE', 'currency' => 'IDR', 'price' => 30000000],
                    ['price_type' => 'DOUBLE', 'currency' => 'IDR', 'price' => 32000000],
                    ['price_type' => 'SINGLE', 'currency' => 'IDR', 'price' => 36000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Plus Turki 12 Hari',
                'slug' => Str::slug('Umrah Plus Turki 12 Hari'),
                'package_category_id' => 2,
                'flight_by' => 'Turkish Airlines',
                'date' => Carbon::now()->addMonths(3),
                'total_days' => 12,
                'quota' => 25,
                'inclusions' => "Tiket pesawat PP\nHotel bintang 5 dekat Masjidil Haram\nHotel bintang 5 dekat Masjid Nabawi\nHotel bintang 4 di Istanbul\nVisa umrah + Turki\nKonsumsi 3x sehari selama di Saudi\nTransportasi lokal di Saudi & Turki\nTour guide di Turki\nPerlengkapan umrah\nManasik sebelum berangkat",
                'exclusions' => "Biaya tour tambahan di luar paket\nLaundry dan telepon hotel\nBiaya kelebihan bagasi",
                'requirements' => "Paspor masa berlaku min 18 bulan\nKTP asli dan fotokopi\nKK fotokopi\nPas foto 4x6 latar putih\nBuku nikah (jika suami/istri)",
                'prices' => [
                    ['price_type' => 'QUAD', 'currency' => 'IDR', 'price' => 45000000],
                    ['price_type' => 'TRIPLE', 'currency' => 'IDR', 'price' => 47000000],
                    ['price_type' => 'DOUBLE', 'currency' => 'IDR', 'price' => 49000000],
                    ['price_type' => 'SINGLE', 'currency' => 'IDR', 'price' => 53000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Eksklusif 9 Hari',
                'slug' => Str::slug('Umrah Eksklusif 9 Hari'),
                'package_category_id' => 3,
                'flight_by' => 'Garuda Indonesia',
                'date' => Carbon::now()->addMonths(1),
                'total_days' => 9,
                'quota' => 15,
                'inclusions' => "Tiket pesawat PP kelas bisnis\nHotel bintang 5 dekat Masjidil Haram (pemandangan Ka\'bah)\nHotel bintang 5 dekat Masjid Nabawi\nVisa umrah prioritas\nKonsumsi 3x sehari\nTransportasi lokal privat\nPerlengkapan umrah premium\nManasik private\nDokumentasi profesional",
                'exclusions' => "Biaya tour tambahan di luar paket\nLaundry dan telepon hotel",
                'requirements' => "Paspor masa berlaku min 12 bulan\nKTP asli dan fotokopi\nKK fotokopi\nPas foto 4x6 latar putih",
                'prices' => [
                    ['price_type' => 'DOUBLE', 'currency' => 'IDR', 'price' => 75000000],
                    ['price_type' => 'SINGLE', 'currency' => 'IDR', 'price' => 85000000],
                ],
            ],
        ];

        foreach ($packages as $data) {
            $prices = $data['prices'];
            unset($data['prices']);

            $package = Package::create($data);
            foreach ($prices as $price) {
                $package->prices()->create($price);
            }
        }

        $this->command->info('Paket berhasil di-seed: ' . count($packages) . ' paket.');
    }
}
