<?php

declare(strict_types=1);

namespace App\Enums;

enum SupportedLocale: string
{
    case En = 'en';
    case Ro = 'ro';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn(self $locale): string => $locale->value,
            self::cases(),
        );
    }
}
