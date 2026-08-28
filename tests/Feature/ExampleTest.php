<?php

declare(strict_types=1);

test('home page renders successfully', function (): void {
    $response = $this->get('/');

    $response->assertOk();
});

test('health endpoint responds', function (): void {
    $response = $this->get('/up');

    $response->assertOk();
});
