<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\FaqSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\HotelSeeder;
use Database\Seeders\PackageCategorySeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\PackageItinerarySeeder;
use Database\Seeders\PreferenceSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FaqSeeder::class,
            BlogSeeder::class,
            HotelSeeder::class,
            PackageCategorySeeder::class,
            PackageSeeder::class,
            PackageItinerarySeeder::class,
            PreferenceSeeder::class,
        ]);
    }
}
