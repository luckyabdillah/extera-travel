<?php

namespace Database\Seeders;

use App\Models\PackageCategory;
use Illuminate\Database\Seeder;

class PackageCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Umrah Reguler', 'mark_as_favorite' => false],
            ['name' => 'Umrah Plus Turki', 'mark_as_favorite' => true],
            ['name' => 'Umrah Eksklusif', 'mark_as_favorite' => false],
            ['name' => 'Haji Furoda', 'mark_as_favorite' => false],
            ['name' => 'Wisata Halal', 'mark_as_favorite' => false],
        ];

        foreach ($categories as $category) {
            PackageCategory::create($category);
        }

        $this->command->info('Kategori paket berhasil di-seed: ' . count($categories) . ' kategori.');
    }
}
