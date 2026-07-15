<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\FaqSeeder;
use Database\Seeders\BlogSeeder;
use Database\Seeders\PackageCategorySeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\PackageItinerarySeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([FaqSeeder::class, BlogSeeder::class, PackageCategorySeeder::class, PackageSeeder::class, PackageItinerarySeeder::class]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
