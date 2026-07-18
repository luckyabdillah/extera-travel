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


        // Additional packages across months
        $extraPackages = [
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Reguler November',
                'slug' => Str::slug('Umrah Reguler November'),
                'package_category_id' => 1,
                'flight_by' => 'Garuda Indonesia',
                'date' => Carbon::now()->addMonths(4),
                'total_days' => 9,
                'quota' => 0,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 4 dekat Masjidil Haram
                                Hotel bintang 4 dekat Masjid Nabawi
                                Visa umrah
                                Konsumsi 3x sehari
                                Transportasi lokal",
                'exclusions' => "Biaya kelebihan bagasi
                                Biaya tour tambahan",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK
                                Pas foto 4x6",
                'prices' => [
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 27500000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Plus Turki Desember',
                'slug' => Str::slug('Umrah Plus Turki Desember'),
                'package_category_id' => 2,
                'flight_by' => 'Turkish Airlines',
                'date' => Carbon::now()->addMonths(5),
                'total_days' => 12,
                'quota' => 20,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 5 dekat Masjidil Haram
                                Hotel bintang 4 di Istanbul
                                Visa umrah + Turki
                                Konsumsi 3x sehari
                                Tour guide",
                'exclusions' => "Biaya tour tambahan
                                Laundry",
                'requirements' => "Paspor min 18 bulan
                                KTP
                                KK
                                Pas foto",
                'prices' => [
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 38500000],
                    ['price_type' => 'Single', 'currency' => 'IDR', 'price' => 45000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Eksklusif Oktober',
                'slug' => Str::slug('Umrah Eksklusif Oktober'),
                'package_category_id' => 3,
                'flight_by' => 'Qatar Airways',
                'date' => Carbon::now()->addMonths(3),
                'total_days' => 9,
                'quota' => 5,
                'inclusions' => "Tiket pesawat PP kelas bisnis
                                Hotel bintang 5 (pemandangan Ka'bah)
                                Visa umrah prioritas
                                Konsumsi 3x sehari
                                Transportasi privat
                                Dokumentasi",
                'exclusions' => "Biaya tour tambahan
                                Laundry",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK
                                Pas foto 4x6",
                'prices' => [
                    ['price_type' => 'Single', 'currency' => 'IDR', 'price' => 55000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Reguler Januari',
                'slug' => Str::slug('Umrah Reguler Januari'),
                'package_category_id' => 1,
                'flight_by' => 'Saudia Airlines',
                'date' => Carbon::now()->addMonths(6),
                'total_days' => 9,
                'quota' => 35,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 4
                                Visa umrah
                                Konsumsi
                                Transportasi lokal",
                'exclusions' => "Biaya kelebihan bagasi",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK",
                'prices' => [
                    ['price_type' => 'Triple', 'currency' => 'IDR', 'price' => 26000000],
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 28000000],
                ],
            ],

            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Reguler 7 Oktober',
                'slug' => Str::slug('Umrah Reguler 7 Oktober'),
                'package_category_id' => 1,
                'flight_by' => 'Lion Air',
                'date' => Carbon::now()->addMonths(3)->startOfMonth()->addDays(6),
                'total_days' => 9,
                'quota' => 20,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 3 dekat Masjidil Haram
                                Hotel bintang 3 dekat Masjid Nabawi
                                Visa umrah
                                Konsumsi 3x sehari
                                Transportasi lokal",
                'exclusions' => "Biaya kelebihan bagasi
                                Biaya tour tambahan
                                Laundry",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK
                                Pas foto 4x6",
                'prices' => [
                    ['price_type' => 'Triple', 'currency' => 'IDR', 'price' => 24000000],
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 26500000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Reguler 20 Oktober',
                'slug' => Str::slug('Umrah Reguler 20 Oktober'),
                'package_category_id' => 1,
                'flight_by' => 'Batik Air',
                'date' => Carbon::now()->addMonths(3)->startOfMonth()->addDays(19),
                'total_days' => 9,
                'quota' => 25,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 4 dekat Masjidil Haram
                                Visa umrah
                                Konsumsi 3x sehari
                                Transportasi lokal
                                Manasik",
                'exclusions' => "Biaya kelebihan bagasi
                                Biaya tour tambahan",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK
                                Pas foto 4x6
                                Buku nikah",
                'prices' => [
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 27000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Hemat 10 Hari Oktober',
                'slug' => Str::slug('Umrah Hemat 10 Hari Oktober'),
                'package_category_id' => 1,
                'flight_by' => 'Citilink',
                'date' => Carbon::now()->addMonths(3)->startOfMonth()->addDays(25),
                'total_days' => 10,
                'quota' => 30,
                'inclusions' => "Tiket pesawat PP
                                Hotel bintang 3
                                Visa umrah
                                Konsumsi 2x sehari
                                Transportasi lokal",
                'exclusions' => "Laundry
                                Biaya kelebihan bagasi
                                Telepon hotel",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK",
                'prices' => [
                    ['price_type' => 'Triple', 'currency' => 'IDR', 'price' => 22500000],
                    ['price_type' => 'Quad', 'currency' => 'IDR', 'price' => 21000000],
                ],
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'title' => 'Umrah Eksklusif 25 Oktober',
                'slug' => Str::slug('Umrah Eksklusif 25 Oktober'),
                'package_category_id' => 3,
                'flight_by' => 'Emirates',
                'date' => Carbon::now()->addMonths(3)->startOfMonth()->addDays(24),
                'total_days' => 9,
                'quota' => 8,
                'inclusions' => "Tiket pesawat PP kelas bisnis
                                Hotel bintang 5 (pemandangan Ka'bah)
                                Visa umrah prioritas
                                Konsumsi 3x sehari
                                Transportasi privat
                                Dokumentasi profesional",
                'exclusions' => "Biaya tour tambahan
                                Laundry
                                Telepon hotel",
                'requirements' => "Paspor min 12 bulan
                                KTP
                                KK
                                Pas foto 4x6",
                'prices' => [
                    ['price_type' => 'Single', 'currency' => 'IDR', 'price' => 58000000],
                    ['price_type' => 'Double', 'currency' => 'IDR', 'price' => 52000000],
                ],
            ],
        ];

        foreach ($extraPackages as $data) {
            $prices = $data['prices'];
            unset($data['prices']);
            $package = Package::create($data);
            foreach ($prices as $price) {
                $package->prices()->create($price);
            }
        }

        $this->command->info('Paket berhasil di-seed: ' . (count($packages) + count($extraPackages)) . ' paket.');
    }
}
