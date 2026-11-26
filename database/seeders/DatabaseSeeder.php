<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. Runs on every deploy, so every seeder
     * listed here must be idempotent and must never overwrite existing rows.
     */
    public function run(): void
    {
        if (app()->isProduction()) {
            $this->call([
                ErrorPageSeeder::class,
                FilamentAdminUserSeeder::class,
            ]);

            return;
        }

        $this->call([
            ErrorPageSeeder::class,
            FilamentAdminUserSeeder::class,
        ]);
    }
}
