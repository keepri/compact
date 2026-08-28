<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SupportedLocale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
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

    protected $fillable = [
        'slug',
        'type',
        'heading',
        'message',
    ];

    protected $casts = [
        'heading' => 'array',
        'message' => 'array',
    ];

    /**
     * Get an error page by its slug.
     */
    public static function getBySlug(string $slug): ?self
    {
        return cache()->remember(
            self::cacheKey($slug, app()->getLocale()),
            Config::integer('cache.ttl'),
            fn() => self::query()->where('slug', $slug)->first(),
        );
    }

    /**
     * Get the 404 not found page content.
     */
    public static function get404Page(): ?self
    {
        return self::getBySlug('not_found');
    }

    /**
     * Get the 500 server error page content.
     */
    public static function get500Page(): ?self
    {
        return self::getBySlug('error');
    }

    protected static function booted(): void
    {
        $forget = static function (self $page): void {
            foreach (SupportedLocale::cases() as $locale) {
                cache()->forget(self::cacheKey($page->slug, $locale->value));
            }
        };

        static::saved($forget);
        static::deleted($forget);
    }

    private static function cacheKey(string $slug, string $locale): string
    {
        return "error:page_content:{$locale}:{$slug}";
    }
}
