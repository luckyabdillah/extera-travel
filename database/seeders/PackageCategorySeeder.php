<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['uuid' => Str::uuid()->toString(), 'name' => 'Umrah Reguler', 'mark_as_favorite' => false],
            ['uuid' => Str::uuid()->toString(), 'name' => 'Umrah Plus Turki', 'mark_as_favorite' => true],
            ['uuid' => Str::uuid()->toString(), 'name' => 'Umrah Eksklusif', 'mark_as_favorite' => false],
            ['uuid' => Str::uuid()->toString(), 'name' => 'Haji Furoda', 'mark_as_favorite' => false],
            ['uuid' => Str::uuid()->toString(), 'name' => 'Wisata Halal', 'mark_as_favorite' => false],
        ];

        foreach ($categories as $category) {
            PackageCategory::create($category);
        }

        $this->command->info('Kategori paket berhasil di-seed: ' . count($categories) . ' kategori.');
    }
}
