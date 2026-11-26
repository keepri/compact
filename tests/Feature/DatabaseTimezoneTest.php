<?php

declare(strict_types=1);

use App\Models\ErrorPage;
use Illuminate\Support\Facades\DB;

test('the database session runs in UTC like the application', function (): void {
    expect(DB::scalar('select @@session.time_zone'))->toBe('+00:00');
});

test('a timestamp inside the hour Romania skips in March is stored as written', function (): void {
    $this->travelTo(new DateTimeImmutable('2027-03-28 03:30:00', new DateTimeZone('UTC')));

    $errorPage = ErrorPage::query()->create([
        'slug' => 'dst_gap',
        'heading' => ['en' => 'Gap', 'ro' => 'Gol'],
        'message' => ['en' => 'Gap', 'ro' => 'Gol'],
    ]);

    expect($errorPage->fresh()->created_at->toDateTimeString())->toBe('2027-03-28 03:30:00');
});
