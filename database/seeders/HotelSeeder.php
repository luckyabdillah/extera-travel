<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Pullman Zamzam Madinah',
                'address' => 'Amr Bin Al Gmoh Street, Madinah 41499, Arab Saudi',
                'city' => 'madinah',
                'star_rating' => 5,
                'phone' => '+966 14 821 0500',
                'email' => 'info@pullman-zamzam-madinah.com',
                'latitude' => '24.4672',
                'longitude' => '39.6109',
                'description' => 'Hotel bintang 5 yang terletak tepat di depan Masjid Nabawi. Akses langsung ke area wanita dan pria. Kamar luas dengan pemandangan kota Madinah.',
            ],
            [
                'name' => 'Anwar Al Madinah Movenpick',
                'address' => 'Central Zone, Madinah 41499, Arab Saudi',
                'city' => 'madinah',
                'star_rating' => 5,
                'phone' => '+966 14 818 1111',
                'email' => 'reservations@movenpick-madinah.com',
                'latitude' => '24.4675',
                'longitude' => '39.6112',
                'description' => 'Hotel mewah di area central Madinah, hanya 50 meter dari Masjid Nabawi. Menyediakan restoran internasional dan fasilitas lengkap.',
            ],
            [
                'name' => 'Dallah Taibah Hotel',
                'address' => 'Abu Ayyub Al Ansari Road, Madinah 41430, Arab Saudi',
                'city' => 'madinah',
                'star_rating' => 4,
                'phone' => '+966 14 829 0000',
                'email' => null,
                'latitude' => '24.4680',
                'longitude' => '39.6120',
                'description' => 'Hotel bintang 4 dengan lokasi strategis dekat Masjid Nabawi. Cocok untuk jamaah yang menginginkan kenyamanan dengan harga terjangkau.',
            ],
            [
                'name' => 'Swissotel Al Maqam Makkah',
                'address' => 'King Abdul Aziz Endowment, Abraj Al Bait Complex, Makkah 21955, Arab Saudi',
                'city' => 'makkah',
                'star_rating' => 5,
                'phone' => '+966 12 573 6000',
                'email' => 'reservations@swissotel-makkah.com',
                'latitude' => '21.4189',
                'longitude' => '39.8262',
                'description' => 'Hotel bintang 5 di kompleks Abraj Al Bait, menghadap langsung ke Masjidil Haram. Akses mudah ke area thawaf dan sa\'i.',
            ],
            [
                'name' => 'Pullman Zamzam Makkah',
                'address' => 'Abraj Al Bait Complex, King Abdul Aziz Endowment, Makkah 21955, Arab Saudi',
                'city' => 'makkah',
                'star_rating' => 5,
                'phone' => '+966 12 571 5555',
                'email' => 'info@pullman-zamzam-makkah.com',
                'latitude' => '21.4189',
                'longitude' => '39.8263',
                'description' => 'Hotel bintang 5 dengan pemandangan Ka\'bah langsung dari lobby dan beberapa kamar. Fasilitas premium untuk kenyamanan ibadah.',
            ],
            [
                'name' => 'Hilton Suites Makkah',
                'address' => 'Jabal Omar, Ibrahim Al Khalil Street, Makkah 21955, Arab Saudi',
                'city' => 'makkah',
                'star_rating' => 5,
                'phone' => '+966 12 573 9000',
                'email' => null,
                'latitude' => '21.4196',
                'longitude' => '39.8250',
                'description' => 'Hotel suites mewah di kawasan Jabal Omar, dengan desain modern. Menyediakan suite keluarga yang luas, ideal untuk rombongan.',
            ],
            [
                'name' => 'Elaf Kinda Hotel',
                'address' => 'Ajyad Street, Al Hajlah, Makkah 21955, Arab Saudi',
                'city' => 'makkah',
                'star_rating' => 4,
                'phone' => '+966 12 574 5555',
                'email' => 'info@elafkinda.com',
                'latitude' => '21.4175',
                'longitude' => '39.8280',
                'description' => 'Hotel bintang 4 dengan akses mudah ke Masjidil Haram melalui terowongan Ajyad. Harga kompetitif dengan pelayanan ramah.',
            ],
            [
                'name' => 'Movenpick Hajar Tower Makkah',
                'address' => 'Abraj Al Bait Complex, Makkah 21955, Arab Saudi',
                'city' => 'makkah',
                'star_rating' => 5,
                'phone' => '+966 12 571 7777',
                'email' => 'reservations@movenpick-hajar.com',
                'latitude' => '21.4191',
                'longitude' => '39.8260',
                'description' => 'Hotel ikonik di menara Hajar, bagian dari kompleks Abraj Al Bait. Restoran dengan panoramic view Masjidil Haram.',
            ],
            [
                'name' => 'Jeddah Hilton',
                'address' => 'North Corniche Road, Jeddah 21462, Arab Saudi',
                'city' => 'jeddah',
                'star_rating' => 5,
                'phone' => '+966 12 659 0000',
                'email' => 'reservations@jeddahhilton.com',
                'latitude' => '21.5433',
                'longitude' => '39.1728',
                'description' => 'Hotel transit premium di Jeddah, ideal untuk istirahat sebelum atau setelah penerbangan. Fasilitas lengkap termasuk kolam renang dan spa.',
            ],
            [
                'name' => 'Park Inn by Radisson Jeddah',
                'address' => 'Madinah Road, Jeddah 21463, Arab Saudi',
                'city' => 'jeddah',
                'star_rating' => 4,
                'phone' => '+966 12 610 0000',
                'email' => null,
                'latitude' => '21.4858',
                'longitude' => '39.1925',
                'description' => 'Hotel modern di pusat kota Jeddah, dekat dengan bandara dan pusat perbelanjaan. Cocok sebagai hotel transit dengan harga terjangkau.',
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }

        $this->command->info('Hotel berhasil di-seed: ' . count($hotels) . ' hotel.');
    }
}
