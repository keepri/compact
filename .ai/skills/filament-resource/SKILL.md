---
name: filament-resource
description: >
  Scaffolds a new Filament v4 admin resource matching this project's
  exact structural convention (as established by the Roles resource):
  Resource/Schemas/Tables/Pages split, base Create/Edit pages, i18n
  navigation, toggleable columns, and a smoke test. Use when the user asks
  to add a new Filament resource, scaffold a resource, or add a "<Model>"
  section to the admin panel.
---

Scaffold a new Filament admin resource for `<Model>` under
`app/Filament/Admin/Resources/<Plural>/`, following the `Roles` resource as
the reference implementation.

## Files to generate

```
Resources/<Plural>/
  <Singular>Resource.php
  Schemas/<Singular>Form.php
  Tables/<Plural>Table.php
  Pages/List<Plural>.php
  Pages/Create<Singular>.php
  Pages/Edit<Singular>.php
```

- `<Singular>Resource.php`: `protected static ?string $model`; navigation
  icon typed `string|BackedEnum|null` via `Heroicon::`; `getNavigationGroup()`
  and `getNavigationLabel()` both return translated strings via `__()`;
  `form()`/`table()` delegate to the `Schemas`/`Tables` classes;
  `getPages()` maps `index`/`create`/`edit` only.
- `Schemas/<Singular>Form.php`: plain class with a static
  `configure(Schema $schema): Schema`. Translatable fields use
  `Tabs::make()` with one `Tabs\Tab` per `SupportedLocale` case and
  `field.locale` dot-notation inputs. Unique fields use
  `->unique(ignoreRecord: true)`.
- `Tables/<Plural>Table.php`: every column ends in `->toggleable()`
  (timestamps use `->toggleable(isToggledHiddenByDefault: true)`);
  `recordActions` wraps `EditAction`/`DeleteAction` in `ActionGroup::make()`;
  `toolbarActions` wraps `DeleteBulkAction` in `BulkActionGroup::make()`; add
  `persistFiltersInSession()`/`persistSearchInSession()`/
  `persistColumnSearchesInSession()`/`persistSortInSession()`.
- `Pages/List<Plural>.php`: `getHeaderActions()` returns `[CreateAction::make()]`.
- `Pages/Create<Singular>.php`: extends
  `App\Filament\Admin\Pages\BaseCreateRecord`, sets `$resource` only.
- `Pages/Edit<Singular>.php`: extends
  `App\Filament\Admin\Pages\BaseEditRecord`, sets `$resource`; if translatable
  fields exist, override `mutateFormDataBeforeFill()` to hydrate them via
  `$record->getTranslations('<field>')`.

## Rules to enforce (AGENTS.md §4)

1. `Schemas/`, `Tables/`, `Pages/` subfolders — no flat files.
2. Create/Edit pages extend `BaseCreateRecord`/`BaseEditRecord`, never raw
   Filament page classes.
3. `unique()` defaults to `ignoreRecord: true`.
4. Filament classes imported via `use`, never inline FQCNs.
5. `Get`/`Set` from `Filament\Schemas\Components\Utilities`; `Grid`/`Section`
   from `Filament\Schemas\Components`.
6. Use `Resource::getUrl('index')`, never `route()`.
7. Select-backed enums implement `HasLabel`/`HasColor`/`HasIcon`.
8. `getNavigationLabel()` is mandatory, backed by an `admin.navigation.*` key
   — never hardcoded text.
9. Every table column has `->toggleable()`.
10. No View page, no Infolist — unless the user explicitly asked for one.

## i18n keys

Add to both `lang/en/admin.php` and `lang/ro/admin.php`:
`navigation.<snake_plural>`, `navigation_groups.<group>` (reuse `content` or
`system` if it already fits), `models.<singular>`, `models.<plural>`, and any
new `fields.<field_name>` entries not already shared.

## Smoke test

Append to `tests/Feature/Filament/AdminPanelTest.php` (do not create a new
file — this repo keeps one shared test file), following the existing
per-resource block: authenticate via `$this->actingAs(adminUser(), 'admin')`,
then `Livewire::test(List<Plural>::class)->assertStatus(200)`,
`Livewire::test(Create<Singular>::class)->assertStatus(200)`, and
`Livewire::test(Edit<Singular>::class, ['record' => $record->id])->assertStatus(200)`
using a factory-created record. Add `/admin/<resource-slug>` and
`/admin/<resource-slug>/create` to the shared dataset test.

## Boundaries

Ask for the model/fields if not given — never invent domain fields. Skip any
step the user explicitly says they don't want (e.g. no test, no i18n keys
yet), but say so in one line rather than silently omitting it.
