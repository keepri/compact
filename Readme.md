# Compact

The website of **Compact**, the Romanian rock band founded in 1976, built around its 50-year anniversary concert. Built on **Laravel 12**, **Filament v4**, **Livewire 3**, and **Tailwind CSS v4**.

## What's included

- **Filament v4 admin panel** at `/admin` (`AdminUser` model, `admin` guard) with Users, Roles, DB-editable Error Pages (404/500)
- **Centralized branding system** — `config/branding.php` is the single source of truth; `BrandingService` exposes it, `--brand-*` CSS variables feed Tailwind `brand-*` utilities and the Filament panel colors
- **Role assignment** — `RoleSlug` enum, `users.role_id`, `$user->hasRole(RoleSlug::Admin)`
- **S3 uploads** (`league/flysystem-aws-s3-v3`) with an `upload_url()` helper
- **en/ro i18n** — `SetLocale` middleware, `/lang/{locale}` switch route, Filament language switch, `spatie/laravel-translatable`
- **CSRF auto-refresh** — Livewire 419 recovery hook
- **Solid.js bridge** — lazy-mount JSX components from Blade via `solid-component` / `solid-props` attributes
- **Docker** — a `Dockerfile` (PHP-FPM + nginx + Node, builds assets and migrates on boot) and a `docker-compose.yml` with two services: `app` and `queue`. **No database container is included** — point `DB_*` at a MariaDB you run yourself
- **Makefile** — shortcuts for the dev loop (`make dev`, `make test`, `make format`, `make migrate`) and for `mariadb-dump` backup/restore against your `DB_*` settings
- **AI-agent tooling** — `.ai/` is the source of truth (see `.ai/README.md`); ships the [ponytail](https://github.com/DietrichGebert/ponytail), [mattpocock/skills](https://github.com/mattpocock/skills), and [caveman](https://github.com/JuliusBrussee/caveman) Claude Code plugins as submodules

## Getting started

```bash
git clone --recurse-submodules <repo-url> && cd <repo>   # or: git submodule update --init
composer install && npm install
cp .env.example .env
# set APP_NAME and APP_URL, then:
php artisan key:generate
# create the MariaDB database, then:
php artisan migrate --seed
php artisan storage:link          # branding assets are served from storage/app/public
npm run build
composer run dev   # or: make dev
```

Set `FILAMENT_DEFAULT_ADMIN_*` before the first seed, then log in at `/admin`. Place brand assets (logo, favicons) under `storage/app/public/branding/` — `upload_url()` resolves them through the `FILESYSTEM_DISK` disk.

## Branding

Declare the brand in `config/branding.php` (colors, typography, assets, component presets) and `lang/{en,ro}/brand.php`. Use `bg-brand-primary`, `text-brand-text-secondary` etc. in views, or the `x-brand.*` Blade components. Never hardcode hex colors or fonts.

See `AGENTS.md` for full coding conventions and workflows.

## Testing

```bash
php artisan test          # Pest, against the compact_test MariaDB database
vendor/bin/pint           # PHP formatting
vendor/bin/phpstan analyse --memory-limit=2G
```
