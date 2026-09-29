<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ErrorPage;
use Illuminate\Database\Seeder;

class ErrorPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 404 Not Found Page
        ErrorPage::query()->updateOrCreate(
            ['slug' => 'not_found'],
            [
                'type' => '404',
                'heading' => [
                    'en' => 'Page not found',
                    'ro' => 'Pagină negăsită',
                ],
                'message' => [
                    'en' => "The page you're looking for doesn't exist or has been moved.",
                    'ro' => 'Pagina pe care o cauți nu există sau a fost mutată.',
                ],
            ],
        );

        // 500 Server Error Page
        ErrorPage::query()->updateOrCreate(
            ['slug' => 'error'],
            [
                'type' => '500',
                'heading' => [
                    'en' => "This page didn't load",
                    'ro' => 'Această pagină nu s-a încărcat',
                ],
                'message' => [
                    'en' => 'Something went wrong on our end. You can try refreshing or head back home.',
                    'ro' => 'Ceva nu a mers bine la noi. Poți reîncărca pagina sau reveni acasă.',
                ],
            ],
        );
    }
}
