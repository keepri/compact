<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $slug
 * @property string $type
 * @property array<array-key, mixed> $heading
 * @property array<array-key, mixed> $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $translatable_columns_from
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereHeading($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ErrorPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ErrorPage extends Model
{
    use HasTranslations;

    /** @var list<string> */
    public array $translatable = ['heading', 'message'];

    #[Override]
    protected $fillable = [
        'slug',
        'type',
        'heading',
        'message',
    ];

    #[Override]
    protected $casts = [
        'heading' => 'array',
        'message' => 'array',
    ];
}
