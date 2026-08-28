<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => ['en' => 'Administrator', 'ro' => 'Administrator'],
                'slug' => RoleSlug::Admin->value,
            ],
            [
                'name' => ['en' => 'Editor', 'ro' => 'Editor'],
                'slug' => RoleSlug::Editor->value,
            ],
        ];

        foreach ($roles as $role) {
            Role::query()->firstOrCreate(['slug' => $role['slug']], ['name' => $role['name']]);
        }
    }
}
