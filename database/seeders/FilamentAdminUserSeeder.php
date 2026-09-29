<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class FilamentAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::query()->firstOrCreate(
            ['email' => Config::string('filament.default_admin_email')],
            [
                'name' => Config::string('filament.default_admin_name'),
                'password' => Hash::make(Config::string('filament.default_admin_password')),
                'email_verified_at' => now(),
            ],
        );
    }
}
