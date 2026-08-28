<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;

/**
 * Rector enforces the *shape* of the code (structure, types, idioms).
 * Pint enforces its *formatting* (whitespace, imports, ordering).
 *
 * The two must never overlap, so the CODING_STYLE prepared set stays off -
 * it is Pint's job, and enabling it makes `make refactor` oscillate.
 *
 * Run `make refactor` when a feature is finished, and always before the tests.
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/bootstrap',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withRootFiles()
    ->withCache(__DIR__ . '/storage/framework/cache/rector')
    ->withSkip([
        __DIR__ . '/bootstrap/cache',
        // Blade templates are not parseable PHP; Rector must never rewrite them.
        '*.blade.php',
    ])
    // Inferred return types arrive as fully qualified names; import them so the
    // code keeps the short-class-name convention. Docblocks are left alone -
    // the models rely on a literal `@mixin \Eloquent` for IDE helper support.
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    // Upgrade rules matched to the installed Laravel version.
    ->withComposerBased(laravel: true)
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        instanceOf: true,
        earlyReturn: true,
    )
    ->withSets([
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
        LaravelSetList::LARAVEL_TESTING,
    ]);
