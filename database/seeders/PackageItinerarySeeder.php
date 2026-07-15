<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageItinerarySeeder extends Seeder
{
    public function run(): void
    {
        $packages = Package::all()->keyBy(fn ($p) => $p->title);

        $itineraries = [
            "Umrah Reguler 9 Hari" => [
                ["marker" => "HARI-1", "title" => "Jakarta - Jeddah", "itinerary" => "Tiba di Bandara King Abdul Aziz Jeddah.\nSetelah imigrasi dan mengambil bagasi, naik bus menuju hotel di Makkah.\nCheck-in hotel dan istirahat.\nMalam: Sholat Isya di Masjidil Haram.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 4, "meals" => "Makan Malam", "included_activities" => "Transportasi airport-hotel, Check-in"],
                ["marker" => "HARI-2", "title" => "Ibadah Umrah", "itinerary" => "Pagi: Sholat Subuh di Masjidil Haram.\nSetelah sarapan, persiapan umrah.\nIhram dari Miqat.\nUmrah: Thawaf, Sai, Tahallul.\nKembali ke hotel.\nMalam: Sholat Isya di Masjidil Haram.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 4, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Bimbingan umrah, Manasik"],
                ["marker" => "HARI-3", "title" => "Makkah Hari Bebas", "itinerary" => "Pagi: Sholat Subuh di Masjidil Haram.\nHari bebas untuk ibadah sunnah dan ziarah.\nThawaf sunnah, minum air zamzam.\nZiarah ke Jabal Nur dan Museum Makkah.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 4, "meals" => "Sarapan, Makan Siang, Makan Malam", "optional_activities" => "Ziarah Jabal Nur, Museum Makkah"],
                ["marker" => "HARI-4", "title" => "Makkah - Madinah", "itinerary" => "Pagi: Sholat Subuh di Masjidil Haram.\nCheck-out hotel.\nPerjalanan darat menuju Madinah (4-5 jam).\nCheck-in hotel Madinah.\nSholat Maghrib dan Isya di Masjid Nabawi.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Transportasi Makkah-Madinah"],
                ["marker" => "HARI-5", "title" => "Ziarah Madinah", "itinerary" => "Pagi: Sholat Subuh di Masjid Nabawi.\nSetelah sarapan, ziarah ke Raudhah, Makam Rasulullah, Masjid Quba, Masjid Qiblatain, dan Bukit Uhud.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Ziarah Raudhah, Masjid Quba, Bukit Uhud"],
                ["marker" => "HARI-6", "title" => "Madinah Hari Bebas", "itinerary" => "Pagi: Sholat Subuh di Masjid Nabawi.\nHari bebas: sholat sunnah di Masjid Nabawi, memperbanyak shalawat, ziarah ke makam Rasulullah, dan belanja oleh-oleh.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "optional_activities" => "Belanja oleh-oleh, Sholat sunnah di Masjid Nabawi"],
                ["marker" => "HARI-7", "title" => "Madinah - Jeddah", "itinerary" => "Pagi: Sholat Subuh di Masjid Nabawi.\nCheck-out hotel.\nPerjalanan ke Jeddah.\nMampir ke Masjid Hudaibiyah.\nCheck-in bandara dan penerbangan kembali ke Jakarta.", "accommodation_place" => null, "accommodation_days" => null, "meals" => "Sarapan, Makan Siang", "included_activities" => "Transportasi Madinah-Jeddah, Masjid Hudaibiyah"],
            ],
            "Umrah Plus Turki 12 Hari" => [
                ["marker" => "HARI-1", "title" => "Jakarta - Istanbul", "itinerary" => "Penerbangan menuju Istanbul.\nTiba di Bandara Istanbul.\nNaik bus menuju hotel.\nCheck-in hotel dan istirahat.\nMalam: Sholat Isya di hotel.", "accommodation_place" => "Hotel Istanbul", "accommodation_days" => 3, "meals" => "Makan Malam", "included_activities" => "Transportasi airport-hotel"],
                ["marker" => "HARI-2", "title" => "Tour Istanbul European Side", "itinerary" => "Pagi: Sarapan di hotel.\nTur Istanbul: Hagia Sophia, Masjid Biru (Sultan Ahmet), Basilica Cistern, Istana Topkapi, Grand Bazaar.\nMakan malam di restoran Turki.", "accommodation_place" => "Hotel Istanbul", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Tour guide, Tiket masuk objek wisata"],
                ["marker" => "HARI-3", "title" => "Tour Istanbul Asian Side", "itinerary" => "Pagi: Sarapan.\nFerry menuju sisi Asia Istanbul.\nKunjungan: Masjid Camlica, Bukit Camlica, Bazar Rempah, Taman Gulhane.\nMalam: Sholat dan persiapan ke Jeddah.", "accommodation_place" => "Hotel Istanbul", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Ferry, Transportasi wisata"],
                ["marker" => "HARI-4", "title" => "Istanbul - Makkah", "itinerary" => "Pagi: Sholat Subuh.\nCheck-out hotel.\nPenerbangan menuju Jeddah.\nTiba di Makkah, check-in hotel.\nMalam: Sholat Isya di Masjidil Haram.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 5, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Penerbangan Istanbul-Jeddah, Transportasi airport-hotel"],
                ["marker" => "HARI-5", "title" => "Ibadah Umrah", "itinerary" => "Pagi: Sholat Subuh.\nPersiapan umrah.\nIhram dari Miqat.\nUmrah: Thawaf, Sai, Tahallul.\nKembali ke hotel.\nMalam: Sholat di Masjidil Haram.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 5, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Bimbingan umrah"],
                ["marker" => "HARI-6", "title" => "Makkah Ibadah", "itinerary" => "Hari penuh ibadah di Masjidil Haram.\nThawaf sunnah, sholat sunnah, dzikir, dan doa.\nZiarah ke Jabal Rahmah dan Bukit Arafah.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 5, "meals" => "Sarapan, Makan Siang, Makan Malam", "optional_activities" => "Ziarah Jabal Rahmah, Arafah"],
                ["marker" => "HARI-7", "title" => "Makkah Ziarah", "itinerary" => "Setelah Subuh: ziarah ke Museum Makkah, Jabal Tsur, Abraj Al-Bait (pemandangan Kabah).\nSore: Kembali ke hotel, istirahat.", "accommodation_place" => "Hotel Makkah", "accommodation_days" => 5, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Ziarah dengan transportasi"],
                ["marker" => "HARI-8", "title" => "Makkah - Madinah", "itinerary" => "Pagi: Sholat Subuh.\nCheck-out hotel.\nPerjalanan darat ke Madinah.\nCheck-in hotel Madinah.\nSholat Maghrib dan Isya di Masjid Nabawi.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Transportasi Makkah-Madinah"],
                ["marker" => "HARI-9", "title" => "Ziarah Madinah", "itinerary" => "Pagi: Sholat Subuh di Masjid Nabawi.\nZiarah ke Raudhah, Makam Rasulullah, Masjid Quba, Masjid Qiblatain, dan Bukit Uhud.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "included_activities" => "Ziarah dengan transportasi"],
                ["marker" => "HARI-10", "title" => "Madinah Hari Bebas", "itinerary" => "Hari bebas untuk beribadah dan belanja oleh-oleh.\nSholat 5 waktu di Masjid Nabawi.\nPerbanyak shalawat di Raudhah.", "accommodation_place" => "Hotel Madinah", "accommodation_days" => 3, "meals" => "Sarapan, Makan Siang, Makan Malam", "optional_activities" => "Belanja oleh-oleh, Sholat sunnah di Masjid Nabawi"],
                ["marker" => "HARI-11", "title" => "Madinah - Jeddah", "itinerary" => "Pagi: Sholat Subuh.\nCheck-out hotel.\nPerjalanan ke Jeddah.\nSinggah di Masjid Hudaibiyah.\nTiba di Bandara Jeddah. Persiapan penerbangan.", "accommodation_place" => null, "accommodation_days" => null, "meals" => "Sarapan, Makan Siang", "included_activities" => "Transportasi Madinah-Jeddah"],
                ["marker" => "HARI-12", "title" => "Tiba di Jakarta", "itinerary" => "Tiba di Jakarta dengan selamat.\nPerjalanan umrah plus Turki selesai.", "accommodation_place" => null, "accommodation_days" => null, "meals" => "Makanan pesawat", "included_activities" => null],
            ],
        ];

        foreach ($itineraries as $title => $days) {
            $package = $packages->get($title);
            if (!$package) {
                $this->command->warn("  Package \"{$title}\" not found, skipping.");
                continue;
            }

            foreach ($days as $day) {
                $package->itineraries()->create($day);
            }

            $this->command->line("  Itinerary \"{$title}\": " . count($days) . " hari");
        }

        $this->command->info("Itinerary berhasil di-seed.");
    }
}
