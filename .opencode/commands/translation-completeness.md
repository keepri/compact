---
description: Checks that every model using Spatie\Translatable\HasTranslations has a value for each App\Enums\SupportedLocale case, for every field in its $translatable array — across seeders, factories, Filament form mutations, and direct create()/update() calls. This project enforces translation columns as non-nullable JSON with both en/ro keys mandatory (AGENTS.md), but no code-level guard exists for it. Use when the user says "check translations", "translation completeness", "missing locale", or asks to verify a translatable model/seeder/migration; also use proactively right after editing a HasTranslations model, its seeder, or a Filament form that binds `field.locale` inputs.
---

Invoke the "translation-completeness" skill. Load and follow its instructions now.