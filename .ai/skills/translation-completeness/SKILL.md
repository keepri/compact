---
name: translation-completeness
description: >
  Checks that every model using Spatie\Translatable\HasTranslations has a
  value for each App\Enums\SupportedLocale case, for every field in its
  $translatable array — across seeders, factories, Filament form mutations,
  and direct create()/update() calls. This project enforces translation
  columns as non-nullable JSON with both en/ro keys mandatory (AGENTS.md),
  but no code-level guard exists for it. Use when the user says "check
  translations", "translation completeness", "missing locale", or asks to
  verify a translatable model/seeder/migration; also use proactively right
  after editing a HasTranslations model, its seeder, or a Filament form that
  binds `field.locale` inputs.
---

Verify translatable content is complete for every supported locale.

## Scan

1. Read `App\Enums\SupportedLocale::values()` — the source of truth for
   required locale keys. Never hardcode `en`/`ro`; a third locale added later
   must be picked up automatically.
2. Find every model with `use Spatie\Translatable\HasTranslations` and read
   its `$translatable` (or `translatable`) array.
3. For each such model, check every place that writes to those fields:
   - Seeders (`database/seeders/*.php`) — literal arrays passed to
     `firstOrCreate`/`updateOrCreate`/`create`.
   - Factories (`database/factories/*.php`).
   - Filament forms — `field.locale` dot-notation inputs inside `Tabs`, and
     `mutateFormDataBeforeFill()`/`mutateFormDataBeforeSave()` overrides in
     the resource's `Pages/Edit*.php`.
   - Any other direct `->update()`/`->create()`/`->setTranslation()` call
     touching a translatable attribute.
4. Flag a gap wherever a literal translation array is missing a required
   locale key, or a Filament tab for a locale is absent/not `->required()`.

## Output

One line per gap, nothing if clean:

```
<file>:<line>: missing '<locale>' key for <Model>.<field>
```

## Boundaries

Read-only report. Does not edit files — hand the findings back and let the
user (or a follow-up edit) fix them. No Spatie-shipped validation rule exists
to point to (checked `vendor/spatie/laravel-translatable/src`); if the user
wants this enforced permanently, suggest a model `saving` event guard or a
custom Laravel validation rule, but only build one if asked.
