<?php

namespace Database\Seeders;

use App\Models\Preference;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Preference::firstOrCreate(
            ['key' => 'mail_info'],
            [
                'key'   => 'mail_info',
                'value' => 'info@exteratravel.com',
                'type'  => 'string',
                'group' => 'system',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'whatsapp_number'],
            [
                'key'   => 'whatsapp_number',
                'value' => '+62812 3456 7890',
                'type'  => 'string',
                'group' => 'contact',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'email'],
            [
                'key'   => 'email',
                'value' => 'hello@exteratravel.com',
                'type'  => 'string',
                'group' => 'contact',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'address'],
            [
                'key'   => 'address',
                'value' => 'Jl. Sudirman No. 123, Jakarta, Indonesia',
                'type'  => 'string',
                'group' => 'contact',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'tiktok_account'],
            [
                'key'   => 'tiktok_account',
                'type'  => 'string',
                'group' => 'social_media',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'facebook_account'],
            [
                'key'   => 'facebook_account',
                'type'  => 'string',
                'group' => 'social_media',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'instagram_account'],
            [
                'key'   => 'instagram_account',
                'value' => 'marhaba.wefada',
                'type'  => 'string',
                'group' => 'social_media',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'package_inclusions_template'],
            [
                'key'   => 'package_inclusions_template',
                'value' => "
                    Tiket pesawat PP\n
                    Hotel bintang 4 dekat Masjidil Haram\n
                    Hotel bintang 4 dekat Masjid Nabawi\n
                    Visa umrah\n
                    Konsumsi 3x sehari\n
                    Transportasi lokal\n
                    Perlengkapan umrah\n
                    Manasik sebelum berangkat\n
                ",
                'type'  => 'string',
                'group' => 'templates',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'package_exclusions_template'],
            [
                'key'   => 'package_exclusions_template',
                'value' => "
                    Biaya visa tambahan jika ada perubahan\n
                    Biaya kelebihan bagasi\n
                    Biaya tour tambahan di luar paket\n
                    Laundry dan telepon hotel\n
                ",
                'type'  => 'string',
                'group' => 'templates',
            ]
        );

        Preference::firstOrCreate(
            ['key' => 'package_requirements_template'],
            [
                'key'   => 'package_requirements_template',
                'value' => "
                    Paspor masa berlaku min 12 bulan\n
                    KTP asli dan fotokopi\n
                    KK fotokopi\n
                    Pas foto 4x6 latar putih\n
                    Buku nikah (jika suami/istri)\n
                    Akta kelahiran (jika mendaftarkan anak)\n
                ",
                'type'  => 'string',
                'group' => 'templates',
            ]
        );
    }
}