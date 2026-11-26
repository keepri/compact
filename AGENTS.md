# Agent Guidelines for the Compact Site

This repository is the website of **Compact**, a Romanian rock band founded in 1976, built around its 50-year anniversary concert. It grew out of a Laravel 12 / Filament v4 boilerplate and still carries that tooling: **Laravel 12**, **Filament v4**, **Livewire 3**, **Tailwind CSS v4**. Follow these guidelines strictly to ensure code consistency, stability, and maintainability.

The public site is bilingual (`ro` default, `en`) and lives at `/`, `/concert`, `/formatia` and `/contact`. See section 9 for how it is put together.

## 0. Asking, Not Guessing

**Whenever a decision is the owner's to make, ask with the `AskUserQuestion`
tool - never as prose in the reply.** In particular:

- A review, audit or plan that ends in a list of options: present the list through the tool.
- Anything that deletes code, drops a dependency, or changes how the site or the panel looks.
- A judgement call between two defensible approaches that the code cannot settle.

## 1. Build, Lint, and Test Commands

### Finishing a piece of work - run these in this order

```bash
make refactor    # 1. Rector rewrites the code, then Pint formats it
make analyse     # 2. PHPStan
make test        # 3. only now run the tests
```

**`make refactor` must run BEFORE the tests, every time, and it is not optional once a feature is done.** Rector rewrites real code (return types, early returns, dead code, Laravel idioms). Running the tests first proves nothing about the code that will actually be committed, and a Rector rule that rewrites something incorrectly only shows up as a failing test - which is exactly the signal you want, but only if the tests run *after* the rewrite. Refactoring after a green test run hides that breakage until CI or, worse, production.

**AI agents: run `make finish` once a feature is implemented.** It runs exactly this sequence (`refactor`, `format`, `analyse`, `test`) in the correct order, so there is nothing to remember or skip.

### Refactoring (Rector)

Rector enforces the **shape** of the code; Pint enforces its **formatting**. The two never overlap: the `CODING_STYLE` prepared set stays off in `rector.php` because it is Pint's job, and enabling it makes the two tools fight over the same lines until `make refactor` oscillates. `make refactor` runs them in the only correct order - Rector first, Pint second, so the rewritten code is always formatted.

- **Apply:** `make refactor` (or `composer rector`)
- **Check without writing (CI):** `make refactor-check` (or `composer refactor:check`) - exits non-zero when changes are pending

What is enabled (see `rector.php`): PHP 8.4 sets, the version-matched Laravel upgrade sets, and the prepared `deadCode`, `codeQuality`, `typeDeclarations`, `instanceOf` and `earlyReturn` sets, plus the Laravel code-quality, collection, `Arr`/`Str`, Eloquent-query-builder, if-helper, type-declaration and testing sets.

When adding a rule or set:

- **Never enable `CODING_STYLE`, `naming`, or `privatization`.** The first is Pint's territory; the second renames variables and methods; the third makes members private that Livewire and Filament resolve dynamically at runtime.
- **Blade templates are skipped** (`*.blade.php`) and `resources/` is not in Rector's paths. Rector must never rewrite a template.
- **Review the dry run before committing a new rule**: `make refactor-check`. A rule that produces inline fully qualified names or fights a documented convention (for example the models' literal `@mixin \Eloquent`, which the IDE helper depends on) does not belong here.

### Testing (Pest)
This project uses **Pest** for testing. Run `make refactor` first - see the order above.
- **Run all tests:**
  ```bash
  php artisan test
  # OR
  vendor/bin/pest
  ```
- **Run a single test file:**
  ```bash
  vendor/bin/pest tests/Feature/ExampleTest.php
  ```
- **Run a specific test method:**
  ```bash
  vendor/bin/pest --filter 'method_name'
  ```
- **Parallel testing (faster):**
  ```bash
  vendor/bin/pest --parallel
  ```

**Assert with the named status assertion, never `assertStatus()`:** `assertOk()`, `assertNotFound()`, `assertBadRequest()`, `assertForbidden()`, `assertUnprocessable()` and friends. This also holds for `Livewire::test(...)`, whose `Testable` forwards unknown calls to `Illuminate\Testing\TestResponse`, so the whole assertion set is available there too. Reach for `assertStatus()` only for a code with no named helper (419, for instance). Rector cannot enforce this one - `AssertStatusToAssertMethodRector` can't resolve `$this` inside a Pest closure - so it is on you and on review.

### Linting & Formatting

Formatting is enforced project-wide and the whole repository is expected to be clean at all times.

- **Format everything (PHP + Blade + Tailwind classes):**
  ```bash
  composer format     # vendor/bin/pint && npm run format
  # OR
  make format
  ```
- **Verify formatting (use this in CI / before committing):**
  ```bash
  composer format:check   # or: make format-check
  ```
  Exits non-zero on any unformatted file.
- **Static Analysis (PHPStan + Larastan):**
  ```bash
  make analyse   # or: composer analyse
  ```

### Static analysis (PHPStan)

`phpstan.neon` runs **level 8** over `app/`, `bootstrap/`, `config/`, `database/` and `routes/`, and the repository is clean at it. Keep it that way:

- **Fix the code, not the report.** No baselines, no `@phpstan-ignore`, no casts or widened signatures added purely to silence an error. The single `ignoreErrors` entry that exists is for `@method` docblocks that `ide-helper:models` regenerates on every `composer install`, where a hand fix cannot survive.
- **The level only goes up.** Level 9 (explicit `mixed`) currently costs 23 errors, almost all `config()`/`env()` returning `mixed` into a typed parameter - a reasonable next step for a project with real domain code.
- **`tests/` is deliberately excluded.** Pest binds `$this` inside test closures at runtime, so every `$this->get(...)` reads as `method.notFound` and the expectation API is marked `@internal`: ~60 false positives, no real findings.

The individual tools, if you need to run one on its own:

| Scope | Tool | Config |
| --- | --- | --- |
| PHP | `vendor/bin/pint` | `pint.json` (PSR-12 + project rules) |
| Blade markup + Tailwind class order in Blade | `blade-formatter` over `resources/**/*.blade.php` | `.bladeformatterrc.json` (4-space indent, 80-column wrap, `sortTailwindcssClasses`) |

Two rules keep this stable — break either one and `format:check` starts failing:

- **Never nest a multi-line `@php ... @endphp` block inside a Blade directive** (`@foreach`, `@if`, ...). blade-formatter mis-indents it and mangles the PHP. Hoist the logic into the single `@php` block at the top of the template instead (see `resources/views/components/partials/head.blade.php`).
- **Blade is the only place classes are sorted.** There is no second sorter and no JS to sort - never add one that orders classes differently from blade-formatter.
- **blade-formatter does not know the theme.** Its class sorter (`@shufo/tailwindcss-class-sorter`) loads `tailwindcssConfigPath` as JavaScript through jiti, so it cannot read a v4 `@theme` stylesheet - pointing it at `resources/css/app.css` throws `SyntaxError: Invalid or unexpected token`. The option is therefore unset, and `brand-*` / `font-display` sort as unknown classes (hoisted to the front). The order is still deterministic, so `format:check` stays green. Re-add the option only if blade-formatter gains a v4 stylesheet entry point; never reintroduce a `tailwind.config.js` just to feed the sorter, which would put the theme's names in two places.

## 2. Code Style & Conventions

### PHP & General
- **Strict Typing:** Always use `declare(strict_types=1);` at the top of PHP files.
- **Imports:** Import classes with `use` statements. Use short class names in code, avoiding fully qualified names.
- **Helpers:** Prefer Laravel helper functions over facade class calls (e.g., `auth()->id()` vs `Auth::id()`, `redirect()->route()` vs `Redirect::route()`).
- **Enums:** Place Enums in `app/Enums`. Use Enum cases or `->value` instead of raw strings.
- **Switch/Match:** Prefer `match` expressions over `switch` statements.
- **Debug:** Do not commit `dd()` or `var_dump()`. Use strict typing and return types everywhere.

### Laravel Structure
- **Controllers:** Keep them slim. Use FormRequests for validation (`$request->validated()`).
- **Services:** If a service is used in multiple methods, inject via constructor. If used once, inject into the method.
- **Routing:** Use `Route::resource` or `Route::apiResource`. Avoid closures in route files.
- **Models:** Use `$fillable` or `$guarded`. Define relationships explicitly with return types. Register observers via PHP attributes (e.g., `#[ObservedBy([UserObserver::class])]`).

### Internationalization (i18n)
- **CRITICAL:** Always add translations for any new user-facing text using Laravel's translation system.
- **Translation Files:** Add keys to both `lang/en/` and `lang/ro/` files for consistency.
- **Usage:** Use `__('filename.key')` syntax in Blade templates and PHP files.
- **Structure:** Follow existing translation file structure and naming conventions.
- **Never commit hardcoded text** that should be translatable in user interfaces.
- **Supported locales:** `en` and `ro` (see `App\Enums\SupportedLocale`). Locale switching is handled by `SetLocale` middleware + the `/lang/{locale}` route.

### Database Translation Validation
- **CRITICAL:** Database translation columns must contain both 'en' and 'ro' keys for all supported languages.
- **JSON Format:** All translation columns use JSON format: `{"en":"English text","ro":"Text românesc"}`.
- **Non-nullable:** Translation columns are NOT nullable - translations for supported languages are mandatory.
- **Validation Required:** When working with translated content, always verify both language keys exist before saving.
- **Translatable models:** Use `Spatie\Translatable\HasTranslations` (see `ErrorPage` for reference).

## 3. Brand Tokens

One brand, declared once. `resources/css/app.css` holds a `:root` block with the
`--brand-*` colors and the two font families; the `@theme` block right below maps
them onto Tailwind utilities (`bg-brand-primary`, `text-brand-text-secondary`,
`font-display`, ...). Tailwind v4 is CSS-first: there is no `tailwind.config.js`,
and adding one would split the theme across two files.

Three places repeat a brand value, and they must stay in step:

- `resources/css/app.css` - the palette itself.
- `App\Providers\Filament\AdminPanelProvider` - Filament parses `primary/success/warning/danger` through `Color::hex()`, so the panel cannot read the stylesheet.
- `resources/views/components/partials/head.blade.php` - the Google Fonts link (Oswald + Barlow), the favicon and `theme-color`.

The name lives in `lang/{en,ro}/brand.php`, read with `__('brand.name')`.

### Which files Tailwind scans
`resources/css/app.css` imports Tailwind with `source(none)` and then names the one scanned path explicitly: `resources/views`. Automatic file detection stays off deliberately — one list, one place. The Filament panel loads its own compiled stylesheet, never `app.css`, so nothing under `app/Filament` is worth scanning.

When a new directory needs scanning, add an `@source` line in `app.css`. Two rules:

- **Never scan generated output.** `storage/framework/views` (Blade's compiled-template cache) and `public/build` are build artifacts; scanning them makes the CSS vary with runtime state and lets deleted classes linger.
- **Never re-enable automatic detection.** It walks the whole repository, which here means compiling stray utility classes out of the Markdown in `.ai/plugins/` into the production bundle.

Verify a change to these paths with a clean/warm comparison — both builds must emit the same asset hash:
```bash
php artisan view:clear && npm run build   # note the app-*.css hash
php artisan test && npm run build         # same hash expected
```

### Usage in Blade
```blade
<div class="bg-brand-primary text-brand-text">
    <p class="text-brand-text-secondary">...</p>
</div>

<x-brand.button variant="primary">Click</x-brand.button>
```

Never hardcode hex colors or one-off font families in views — use the brand
utilities. The palette itself is edited in `app.css`, which means `npm run build`
after every change.

## 4. Filament v4 Specifics

- **Single panel:** One admin panel at `/admin` (`App\Providers\Filament\AdminPanelProvider`), guard `admin`, model `App\Models\AdminUser`.
- **Resources shipped:** Error Pages - the only editable content on the site. There is no users or roles resource: the panel exists to edit the 404/500 copy, and admin accounts are created by `FilamentAdminUserSeeder` or by hand.
- **Base pages:** none. `EditErrorPage` declares its own `getRedirectUrl()`; add a shared base only once a second resource wants the same behaviour.
- **Validation:** `unique()` rules now default to `ignoreRecord: true`.
- **Imports:** Put Filament namespaces in `use` sections. Do not use full paths inline.
- **Utilities:** Form utilities like `Get` and `Set` are in `Filament\Schemas\Components\Utilities`.
- **Layouts:** Components like `Grid`, `Section` are in `Filament\Schemas\Components`.
- **Routes:** Use `Resource::getUrl('index')` instead of `route()`.
- **Enums:** Implement `HasLabel`, `HasColor`, `HasIcon` interfaces on Enums for Filament integration.
- **CRITICAL - Navigation i18n:** ALL Filament admin panel navigation items MUST be internationalized. When adding any new Resource, always implement `getNavigationLabel()` using translation keys from `admin.navigation`. Never use hardcoded navigation labels.
- **CRITICAL - Table Column Toggleability:** In every Filament table, columns must be user-toggleable via `->toggleable()`. Keep intentional hidden-by-default behavior with `->toggleable(isToggledHiddenByDefault: true)`.
- **Resource structure:** Schemas in `Schemas/`, tables in `Tables/`, pages in `Pages/` (see the `ErrorPages` resource for reference).
- **Do not generate View pages or Infolists** unless explicitly requested.
- **Vendor assets stay unpublished:** `public/css/filament`, `public/js`, `public/fonts` and `lang/vendor` are gitignored on purpose - they're Filament's own package assets/translations, regenerated automatically by `filament:upgrade` on every `composer install`/`update` (see `composer.json`'s `post-autoload-dump`). Never commit them or run `vendor:publish` for Filament's translations/assets; publishing that is a call each project should make for itself. The panel carries no stylesheet of its own - it wears Filament's defaults plus the four `->colors()` hex values.

## 5. Configuration Files

`config/` holds **only the keys this application overrides**. Laravel 12 merges
`vendor/laravel/framework/config/*.php` underneath (top level, plus a second
pass for `auth.guards`/`providers`, `cache.stores`, `database.connections`,
`filesystems.disks`, `logging.channels`, `mail.mailers` and `queue.connections`),
so a stock copy in `config/` buys nothing and silently goes stale - the copy this
repo used to carry still had Monolog's pre-rename `with` key and was missing the
Redis backoff options.

`config/logging.php`, `mail.php`, `queue.php` and `services.php` therefore do not
exist at all. When you need to change a framework default, add just that key.
Verify a config change by dumping `config()->all()` before and after and diffing
- nothing should be lost or altered but the key you meant to change.

## 6. Database

- **CRITICAL:** This project is **MariaDB-only** in all environments (production, local, CI, and tests). Production is DirectAdmin hosting, which offers MariaDB and nothing else.
- **Raw SQL:** avoid it; when it is unavoidable, write MariaDB SQL. `json` columns are `LONGTEXT` with a `JSON_VALID` check in MariaDB, so query them through Laravel's `->where('col->key', ...)` syntax rather than native JSON operators.
- **Time zone:** the `mariadb` connection runs its session in UTC (`'timezone' => '+00:00'` in `config/database.php`), matching `APP_TIMEZONE=UTC`. Never remove it: in the server's local zone MariaDB rejects timestamps inside the hour the clocks skip in March and misreads the hour they repeat in October (`tests/Feature/DatabaseTimezoneTest.php` guards this). Laravel merges a connection as a whole, so that override spreads the framework's own `mariadb` definition and changes only this one key.
- **Migrations:** Write and validate migrations for MariaDB behavior. Use `foreignId()->constrained()`.
- **Production Safety:** All migrations must be backward compatible. Never introduce breaking changes (renaming/dropping columns without a transition plan, adding NOT NULL without defaults on existing tables). Use `php artisan migrate --pretend` to preview changes.
- **New translatable columns:** use `->json('column')->nullable(false)` and ensure seeders populate all supported languages.

### Seeders
Every deploy runs `php artisan migrate --force --seed`. The seeders therefore run against live production data on every release, and the rules below are what make that safe.

**Rules:**
- **Create-only.** Use `firstOrCreate`, never `updateOrCreate`, `update()`, `delete()` or `truncate()`. Anything a seeder overwrites is wiped on the next deploy - including every edit made in the admin panel. A seeder creates what is missing and leaves existing rows alone.
- **Key on a stable natural identifier** (`slug`, `email`), never on an auto-increment `id`, so the "does it exist" lookup means the same thing in every database.
- **Fill every supported locale** in translatable columns (see Database Translation Validation).
- **Secrets come from config, never from the seeder.** Credentials are read through `config()` keys backed by env vars (as `FilamentAdminUserSeeder` reads `filament.default_admin_*`). The production `.env` must carry real values before the first deploy that runs a new seeder.
- **Changing existing production data is a migration's job, not a seeder's.** If seeded copy has to change on a live site, write a migration (or do it in the admin panel) - never switch a seeder to `updateOrCreate` for one release.

**Which environment runs what.** `DatabaseSeeder` keeps two explicit lists, branched on `app()->isProduction()`:

| Seeder | Production | Every other environment | Creates |
| --- | --- | --- | --- |
| `ErrorPageSeeder` | yes | yes | 404 (`not_found`) and 500 (`error`) page copy, en + ro |
| `FilamentAdminUserSeeder` | yes | yes | the admin account from `FILAMENT_DEFAULT_ADMIN_*` |

Non-production environments run **all** seeders: the production list plus any local/demo data. The two lists are written out separately even while they are identical, so adding a local-only seeder never touches the production branch.

**Adding a seeder:**
1. Make it create-only, keyed on a natural identifier.
2. Add it to the non-production list in `DatabaseSeeder`. Add it to the production list too only if production cannot work without the data - demo, sample and fixture data never goes there.
3. Add it to the table above.
4. Test it the way `tests/Feature/DatabaseSeederTest.php` and `ErrorPagesTest.php` do: seeding twice changes nothing that was edited in between, and - for a production seeder - `db:seed --force` under the `production` environment creates it.

## 7. Testing Guidelines
- **Framework:** Use **Pest**.
- **Database Isolation:** Tests run against a dedicated `compact_test` MariaDB database (user `compact`, password `compact`, host `localhost` - the same socket connection DirectAdmin gives its database users), which must exist before the first run. `RefreshDatabase` is applied globally in `tests/Pest.php`.
- **Structure:** Follow **Arrange-Act-Assert**.
- **Factories:** Use meaningful data in factories.
- **Filament:** Always create smoke tests for new Filament Resources:
  ```php
  Livewire::test(\App\Filament\Admin\Resources\Xxx\Pages\CreateXxx::class)->assertStatus(200);
  Livewire::test(\App\Filament\Admin\Resources\Xxx\Pages\EditXxx::class, ['record' => $record->id])->assertStatus(200);
  ```
- **Environment File:** none required. Every variable the suite needs is declared in `phpunit.xml`'s `<php>` block, so a fresh clone can run the tests immediately. A local `.env.testing` is optional (and gitignored) - add one only to override those values on your own machine.
- **Error page copy lives in the database.** `lang/*/errors.php` holds only the `<title>` and the button label; the heading and the message come from the `error_pages` rows, which is what the admin panel edits. Do not add a lang-file copy of them back as a "fallback" - that is two sources for one sentence.

## 8. Included Infrastructure

- **Admin accounts:** every row in `users` may sign in at `/admin` - there are no roles or permissions. Add one with `FilamentAdminUserSeeder` or `AdminUser::create()`; if the site ever needs a second class of editor, that is the point to reintroduce a role, not before.
- **S3 uploads:** `league/flysystem-aws-s3-v3` plus the `upload_url()` helper, which resolves a stored path against `config('filesystems.default')` (set it with `FILESYSTEM_DISK`). Nothing calls it today - the site's images are static files in `public/`.
- **Locale switch:** `bezhansalleh/filament-language-switch` inside the admin panel.
- **Error pages:** DB-editable 404/500 content (`error_pages` table + `ErrorPages` Filament resource), rendered via exception handler in `bootstrap/app.php`.
- **CSRF auto-refresh:** Livewire 419 recovery hook (`resources/js/livewire-csrf-refresh.js` + handler in `bootstrap/app.php`), loaded by the Filament panel only. The public pages hold no state and issue no Livewire XHR, so they do not need it.
- **Docker:** `Dockerfile` (PHP-FPM + nginx + Node; builds assets, caches config and runs `migrate --force` on start) and `docker-compose.yml` with an `app` and a `queue` service. There is no MariaDB container - `DB_*` must point at a database you provide.
- **Makefile:** shortcuts for the dev loop (`dev`, `test`, `format`, `migrate`, `analyse`) plus `db-backup` / `db-restore`, which shell out to `mariadb-dump` / `mariadb` using the `DB_*` environment variables.
- **AI-agent tooling:** `.ai/` is the source of truth for AI-agent tooling (plugins now, commands/skills/agents/rules if added later); `.claude/` only holds `settings.json` plus symlinks into `.ai/` (see `.ai/README.md`). Ships the [ponytail](https://github.com/DietrichGebert/ponytail), [mattpocock/skills](https://github.com/mattpocock/skills), and [caveman](https://github.com/JuliusBrussee/caveman) Claude Code plugins as git submodules under `.ai/plugins/` — run `git submodule update --init` after cloning, and ensure `node` is on `PATH` for ponytail's and caveman's hooks. They only activate once you accept Claude Code's workspace-trust prompt.

## 9. The Public Site

Four pages, no database: everything the visitor reads comes from `lang/` and `config/`.

| Piece | Where |
| --- | --- |
| Routes | `routes/web.php` - Romanian slugs, one URL set for both locales |
| Page classes | `app/Livewire/Pages/{Home,Concert,Band,Contact}.php`, all extending `SitePage` |
| Page views | `resources/views/livewire/pages/*.blade.php` |
| Layout chrome | `components/layouts/app.blade.php` + `components/partials/{head,header,footer}` |
| Shared UI | `resources/views/components/site/*` |
| Copy | `lang/{en,ro}/{site,home,concert,contact,band}.php` |
| Structural data | `config/site.php` (nav, addresses, map URLs), `config/band.php` (members, eras) |

Rules that keep this maintainable:

- **The route name is the meta key.** `x-partials.head` reads `<route name>.meta.{title,description,og_title,og_description}` straight from `request()->route()->getName()`, so **a page's route name must match its lang file name** - `concert` the route, `lang/{locale}/concert.php` the copy. A page class only renders its own view with a literal name (PHPStan level 8 requires a literal `view-string`); `SitePage` exists to declare the layout once. Add a page by copying `Contact.php`, and give it a route name matching its lang file. Views with no lang file of their own (the error pages) pass a `:title` to `x-layouts.app` and inherit `site.meta.*` for the rest.
- **Text goes in `lang/`, structure goes in `config/`.** Member names, era years and line-ups are locale-invariant and live in `config/band.php` exactly once; only roles, titles and prose are translated, keyed by the same slugs. Never duplicate a name across the two lang files.
- **A block that appears more than twice becomes a component.** `x-site.section`, `x-site.page-header`, `x-site.fact`, `x-site.fact-grid` and `x-site.nav-links` already cover the repeating idioms - reach for them before writing markup.
- **One nav list.** `config('site.nav')` drives the desktop nav, the mobile drawer and the footer through `x-site.nav-links`; the variants differ only in styling.
- **`eyebrow` and `hairline`** are `@utility` classes in `resources/css/app.css`, and the `h1-h4` rule in `@layer base` makes every heading uppercase display type. All three are load-bearing for the design.
- **Reading a translated array with nullable entries** (e.g. a member's optional `note`) must fetch the array whole - `__('band.members')` - because `__()` returns the key, not `null`, for a null value.

### Setting up a fresh clone
1. `git clone --recurse-submodules` (or `git submodule update --init`), then `composer install && npm install`.
2. Copy `.env.example` -> `.env`; run `php artisan key:generate`.
3. Create the MariaDB databases and user (see section 7); run `php artisan migrate --seed`.
4. `npm run build`, then `php artisan serve`.
5. Change `FILAMENT_DEFAULT_ADMIN_*` values before the first seed; log in at `/admin` to edit the 404/500 pages.

Brand colors and fonts are declared in `resources/css/app.css` (see section 3). The favicon and the hero image are static files in `public/` and resolve without `storage:link`.


===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.15
- filament/filament (FILAMENT) - v4
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v3
- larastan/larastan (LARASTAN) - v3
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- rector/rector (RECTOR) - v2
- tailwindcss (TAILWINDCSS) - v4

## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs
- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches when dealing with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The `search-docs` tool is perfect for all Laravel-related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless there is something very complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- That being said, keys in an Enum should follow existing application Enum conventions.

=== tests rules ===

## Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v12 rules ===

## Laravel 12

- Use the `search-docs` tool to get version-specific documentation.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

### Laravel 12 Structure
- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app\Console\Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

### Database
- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models
- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== livewire/core rules ===

## Livewire

- Use the `search-docs` tool to find exact version-specific documentation for how to write Livewire and Livewire tests.
- Use the `php artisan make:livewire [Posts\CreatePost]` Artisan command to create new components.
- State should live on the server, with the UI reflecting it.
- All Livewire requests hit the Laravel backend; they're like regular HTTP requests. Always validate form data and run authorization checks in Livewire actions.

## Livewire Best Practices
- Livewire components require a single root element.
- Use `wire:loading` and `wire:dirty` for delightful loading states.
- Add `wire:key` in loops:

    ```blade
    @foreach ($items as $item)
        <div wire:key="item-{{ $item->id }}">
            {{ $item->name }}
        </div>
    @endforeach
    ```

- Prefer lifecycle hooks like `mount()`, `updatedFoo()` for initialization and reactive side effects:

<code-snippet name="Lifecycle Hook Examples" lang="php">
    public function mount(User $user) { $this->user = $user; }
    public function updatedSearch() { $this->resetPage(); }
</code-snippet>

## Testing Livewire

<code-snippet name="Example Livewire Component Test" lang="php">
    Livewire::test(Counter::class)
        ->assertSet('count', 0)
        ->call('increment')
        ->assertSet('count', 1)
        ->assertSee(1)
        ->assertStatus(200);
</code-snippet>

<code-snippet name="Testing Livewire Component Exists on Page" lang="php">
    $this->get('/posts/create')
    ->assertSeeLivewire(CreatePost::class);
</code-snippet>

=== livewire/v3 rules ===

## Livewire 3

### Key Changes From Livewire 2
- These things changed in Livewire 3, but may not have been updated in this application. Verify this application's setup to ensure you conform with application conventions.
    - Use `wire:model.live` for real-time updates, `wire:model` is now deferred by default.
    - Components now use the `App\Livewire` namespace (not `App\Http\Livewire`).
    - Use `$this->dispatch()` to dispatch events (not `emit` or `dispatchBrowserEvent`).
    - Use the `components.layouts.app` view as the typical layout path (not `layouts.app`).

### New Directives
- `wire:show`, `wire:transition`, `wire:cloak`, `wire:offline`, `wire:target` are available for use. Use the documentation to find usage examples.

### Alpine
- Alpine is now included with Livewire; don't manually include Alpine.js.
- Plugins included with Alpine: persist, intersect, collapse, and focus.

### Lifecycle Hooks
- You can listen for `livewire:init` to hook into Livewire initialization, and `fail.status === 419` for the page expiring:

<code-snippet name="Livewire Init Hook Example" lang="js">
document.addEventListener('livewire:init', function () {
    Livewire.hook('request', ({ fail }) => {
        if (fail && fail.status === 419) {
            alert('Your session expired');
        }
    });

    Livewire.hook('message.failed', (message, component) => {
        console.error(message);
    });
});
</code-snippet>

=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest
### Testing
- If you need to verify a feature is working, write or update a Unit / Feature test.

### Pest Tests
- All tests must be written using Pest. Use `php artisan make:test --pest {name}`.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files - these are core to the application.
- Tests should test all of the happy paths, failure paths, and weird paths.
- Tests live in the `tests/Feature` and `tests/Unit` directories.
- Pest tests look and behave like this:
<code-snippet name="Basic Pest Test Example" lang="php">
it('is true', function () {
    expect(true)->toBeTrue();
});
</code-snippet>

### Running Tests
- Run the minimal number of tests using an appropriate filter before finalizing code edits.
- To run all tests: `php artisan test --compact`.
- To run all tests in a file: `php artisan test --compact tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --compact --filter=testName` (recommended after making a change to a related file).
- When the tests relating to your changes are passing, ask the user if they would like to run the entire test suite to ensure everything is still passing.

### Pest Assertions
- When asserting status codes on a response, use the specific method like `assertForbidden` and `assertNotFound` instead of using `assertStatus(403)` or similar, e.g.:
<code-snippet name="Pest Example Asserting postJson Response" lang="php">
it('returns all', function () {
    $response = $this->postJson('/api/docs', []);

    $response->assertSuccessful();
});
</code-snippet>

### Mocking
- Mocking can be very helpful when appropriate.
- When mocking, you can use the `Pest\Laravel\mock` Pest function, but always import it via `use function Pest\Laravel\mock;` before using it. Alternatively, you can use `$this->mock()` if existing tests do.
- You can also create partial mocks using the same import or self method.

### Datasets
- Use datasets in Pest to simplify tests that have a lot of duplicated data. This is often the case when testing validation rules, so consider this solution when writing tests for validation rules.

<code-snippet name="Pest Dataset Example" lang="php">
it('has emails', function (string $email) {
    expect($email)->not->toBeEmpty();
})->with([
    'james' => 'james@laravel.com',
    'taylor' => 'taylor@laravel.com',
]);
</code-snippet>

=== pest/v4 rules ===

## Pest 4

- Pest 4 is a huge upgrade to Pest and offers: browser testing, smoke testing, visual regression testing, test sharding, and faster type coverage.
- Browser testing is incredibly powerful and useful for this project.
- Browser tests should live in `tests/Browser/`.
- Use the `search-docs` tool for detailed guidance on utilizing these features.

### Browser Testing
- You can use Laravel features like `Event::fake()`, `assertAuthenticated()`, and model factories within Pest 4 browser tests, as well as `RefreshDatabase` (when needed) to ensure a clean state for each test.
- Interact with the page (click, type, scroll, select, submit, drag-and-drop, touch gestures, etc.) when appropriate to complete the test.
- If requested, test on multiple browsers (Chrome, Firefox, Safari).
- If requested, test on different devices and viewports (like iPhone 14 Pro, tablets, or custom breakpoints).
- Switch color schemes (light/dark mode) when appropriate.
- Take screenshots or pause tests for debugging when appropriate.

### Example Tests

<code-snippet name="Pest Browser Test Example" lang="php">
it('may reset the password', function () {
    Notification::fake();

    $this->actingAs(User::factory()->create());

    $page = visit('/sign-in'); // Visit on a real browser...

    $page->assertSee('Sign In')
        ->assertNoJavascriptErrors() // or ->assertNoConsoleLogs()
        ->click('Forgot Password?')
        ->fill('email', 'nuno@laravel.com')
        ->click('Send Reset Link')
        ->assertSee('We have emailed your password reset link!')

    Notification::assertSent(ResetPassword::class);
});
</code-snippet>

<code-snippet name="Pest Smoke Testing Example" lang="php">
$pages = visit(['/', '/about', '/contact']);

$pages->assertNoJavascriptErrors()->assertNoConsoleLogs();
</code-snippet>

=== tailwindcss/core rules ===

## Tailwind CSS

- Use Tailwind CSS classes to style HTML; check and use existing Tailwind conventions within the project before writing your own.
- Offer to extract repeated patterns into components that match the project's conventions (i.e. Blade, JSX, Vue, etc.).
- Think through class placement, order, priority, and defaults. Remove redundant classes, add classes to parent or child carefully to limit repetition, and group elements logically.
- You can use the `search-docs` tool to get exact examples from the official documentation when needed.

### Spacing
- When listing items, use gap utilities for spacing; don't use margins.

<code-snippet name="Valid Flex Gap Spacing Example" lang="html">
    <div class="flex gap-8">
        <div>Superior</div>
        <div>Michigan</div>
        <div>Erie</div>
    </div>
</code-snippet>

### Dark Mode
- If existing pages and components support dark mode, new pages and components must support dark mode in a similar way, typically using `dark:`.

=== tailwindcss/v4 rules ===

## Tailwind CSS 4

- Always use Tailwind CSS v4; do not use the deprecated utilities.
- `corePlugins` is not supported in Tailwind v4.
- In Tailwind v4, configuration is CSS-first using the `@theme` directive — no separate `tailwind.config.js` file is needed.

<code-snippet name="Extending Theme in CSS" lang="css">
@theme {
  --color-brand: oklch(0.72 0.11 178);
}
</code-snippet>

- In Tailwind v4, you import Tailwind using a regular CSS `@import` statement, not using the `@tailwind` directives used in v3:

<code-snippet name="Tailwind v4 Import Tailwind Diff" lang="diff">
   - @tailwind base;
   - @tailwind components;
   - @tailwind utilities;
   + @import "tailwindcss";
</code-snippet>

### Replaced Utilities
- Tailwind v4 removed deprecated utilities. Do not use the deprecated option; use the replacement.
- Opacity values are still numeric.

| Deprecated |	Replacement |
|------------+--------------|
| bg-opacity-* | bg-black/* |
| text-opacity-* | text-black/* |
| border-opacity-* | border-black/* |
| divide-opacity-* | divide-black/* |
| ring-opacity-* | ring-black/* |
| placeholder-opacity-* | placeholder-black/* |
| flex-shrink-* | shrink-* |
| flex-grow-* | grow-* |
| overflow-ellipsis | text-ellipsis |
| decoration-slice | box-decoration-slice |
| decoration-clone | box-decoration-clone |

=== filament/filament rules ===

## Filament

- Filament is a Laravel UI framework built on Livewire, Alpine.js, and Tailwind CSS. UIs are defined in PHP via fluent, chainable components. Follow existing conventions in this app.
- Use the `search-docs` tool for official documentation on Artisan commands, code examples, testing, relationships, and idiomatic practices. If `search-docs` is unavailable, refer to https://filamentphp.com/docs.

### Artisan

- Always use Filament-specific Artisan commands to create files. Find available commands with the `list-artisan-commands` tool, or run `php artisan --help`.
- Inspect required options before running, and always pass `--no-interaction`.

### Patterns

Always use static `make()` methods to initialize components. Most configuration methods accept a `Closure` for dynamic values.

Use `Get $get` to read other form field values for conditional logic:

<code-snippet name="Conditional form field visibility" lang="php">
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;

Select::make('type')
    ->options(CompanyType::class)
    ->required()
    ->live(),

TextInput::make('company_name')
    ->required()
    ->visible(fn (Get $get): bool => $get('type') === 'business'),

</code-snippet>

Use `Set $set` inside `->afterStateUpdated()` on a `->live()` field to mutate another field reactively. Prefer `->live(onBlur: true)` on text inputs to avoid per-keystroke updates:

<code-snippet name="Reactive field update" lang="php">
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

TextInput::make('title')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
        'slug',
        Str::slug($state ?? ''),
    )),

TextInput::make('slug')
    ->required(),

</code-snippet>

Compose layout by nesting `Section` and `Grid`. Children need explicit `->columnSpan()` or `->columnSpanFull()`:

<code-snippet name="Section and Grid layout" lang="php">
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

Section::make('Details')
    ->schema([
        Grid::make(2)->schema([
            TextInput::make('first_name')
                ->columnSpan(1),
            TextInput::make('last_name')
                ->columnSpan(1),
            TextInput::make('bio')
                ->columnSpanFull(),
        ]),
    ]),

</code-snippet>

Use `Repeater` for inline `HasMany` management. `->relationship()` with no args binds to the relationship matching the field name:

<code-snippet name="Repeater for HasMany" lang="php">
use Filament\Forms\Components\Repeater;

Repeater::make('qualifications')
    ->relationship()
    ->schema([
        TextInput::make('institution')
            ->required(),
        TextInput::make('qualification')
            ->required(),
    ])
    ->columns(2),

</code-snippet>

Use `state()` with a `Closure` to compute derived column values:

<code-snippet name="Computed table column value" lang="php">
use Filament\Tables\Columns\TextColumn;

TextColumn::make('full_name')
    ->state(fn (User $record): string => "{$record->first_name} {$record->last_name}"),

</code-snippet>

Use `SelectFilter` for enum or relationship filters, and `Filter` with a `->query()` closure for custom logic:

<code-snippet name="Table filters" lang="php">
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

SelectFilter::make('status')
    ->options(UserStatus::class),

SelectFilter::make('author')
    ->relationship('author', 'name'),

Filter::make('verified')
    ->query(fn (Builder $query) => $query->whereNotNull('email_verified_at')),

</code-snippet>

Actions are buttons that encapsulate optional modal forms and behavior:

<code-snippet name="Action with modal form" lang="php">
use Filament\Actions\Action;

Action::make('updateEmail')
    ->schema([
        TextInput::make('email')
            ->email()
            ->required(),
    ])
    ->action(fn (array $data, User $record) => $record->update($data)),

</code-snippet>

### Testing

Testing setup (requires `pestphp/pest-plugin-livewire` in `composer.json`):

- Always call `$this->actingAs(User::factory()->create())` before testing panel functionality.
- For edit pages, pass `['record' => $user->id]`, use `->call('save')` (not `->call('create')`), and do not assert `->assertRedirect()` (edit pages do not redirect after save).

<code-snippet name="Table test" lang="php">
use function Pest\Livewire\livewire;

livewire(ListUsers::class)
    ->assertCanSeeTableRecords($users)
    ->searchTable($users->first()->name)
    ->assertCanSeeTableRecords($users->take(1))
    ->assertCanNotSeeTableRecords($users->skip(1));

</code-snippet>

<code-snippet name="Create resource test" lang="php">
use function Pest\Laravel\assertDatabaseHas;

livewire(CreateUser::class)
    ->fillForm([
        'name' => 'Test',
        'email' => 'test@example.com',
    ])
    ->call('create')
    ->assertNotified()
    ->assertHasNoFormErrors()
    ->assertRedirect();

assertDatabaseHas(User::class, [
    'name' => 'Test',
    'email' => 'test@example.com',
]);

</code-snippet>

<code-snippet name="Edit resource test" lang="php">
livewire(EditUser::class, ['record' => $user->id])
    ->fillForm(['name' => 'Updated'])
    ->call('save')
    ->assertNotified()
    ->assertHasNoFormErrors();

assertDatabaseHas(User::class, [
    'id' => $user->id,
    'name' => 'Updated',
]);

</code-snippet>

<code-snippet name="Testing validation" lang="php">
livewire(CreateUser::class)
    ->fillForm([
        'name' => null,
        'email' => 'invalid-email',
    ])
    ->call('create')
    ->assertHasFormErrors([
        'name' => 'required',
        'email' => 'email',
    ])
    ->assertNotNotified();

</code-snippet>

Use `->callAction(DeleteAction::class)` for page actions, or `->callAction(TestAction::make('name')->table($record))` for table actions:

<code-snippet name="Calling actions" lang="php">
use Filament\Actions\Testing\TestAction;

livewire(ListUsers::class)
    ->callAction(TestAction::make('promote')->table($user), [
        'role' => 'admin',
    ])
    ->assertNotified();

</code-snippet>

### Correct Namespaces

- Form fields (`TextInput`, `Select`, `Repeater`, etc.): `Filament\Forms\Components\`
- Infolist entries (`TextEntry`, `IconEntry`, etc.): `Filament\Infolists\Components\`
- Layout components (`Grid`, `Section`, `Fieldset`, `Tabs`, `Wizard`, etc.): `Filament\Schemas\Components\`
- Schema utilities (`Get`, `Set`, etc.): `Filament\Schemas\Components\Utilities\`
- Table columns (`TextColumn`, `IconColumn`, etc.): `Filament\Tables\Columns\`
- Table filters (`SelectFilter`, `Filter`, etc.): `Filament\Tables\Filters\`
- Actions (`DeleteAction`, `CreateAction`, etc.): `Filament\Actions\`. Never use `Filament\Tables\Actions\`, `Filament\Forms\Actions\`, or any other sub-namespace for actions.
- Icons: `Filament\Support\Icons\Heroicon` enum (e.g., `Heroicon::PencilSquare`)

### Common Mistakes

- **Never assume public file visibility.** File visibility is `private` by default. Always use `->visibility('public')` when public access is needed.
- **Never assume full-width layout.** `Grid`, `Section`, `Fieldset`, and `Repeater` do not span all columns by default.
- **Use `Select::make('author_id')->relationship('author', 'name')` for BelongsTo fields.** `BelongsToSelect` does not exist in v4.
- **`Repeater` uses `->schema()`, not `->fields()`.**
- **Never add `->dehydrated(false)` to fields that need to be saved.** It strips the value from form state before `->action()` or the save handler runs. Only use it for helper/UI-only fields.
- **Use correct property types when overriding `Page`, `Resource`, and `Widget` properties.** These properties have union types or changed modifiers that must be preserved:
  - `$navigationIcon`: `protected static string | BackedEnum | null` (not `?string`)
  - `$navigationGroup`: `protected static string | UnitEnum | null` (not `?string`)
  - `$view`: `protected string` (not `protected static string`) on `Page` and `Widget` classes
</laravel-boost-guidelines>
