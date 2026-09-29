<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Core reference data - runs in ALL environments including production
        $this->call([
            ErrorPageSeeder::class,
        ]);

        // Test/demo data seeders - only run in non-production environments
        if (! app()->environment('production')) {
            $this->call([
                FilamentAdminUserSeeder::class,
            ]);
        }
    }
}
