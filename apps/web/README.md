# Saffna Web Application

This directory contains Saffna's only current deployable: a Laravel 12 web application. It uses Laravel Framework `12.72.0`, SQLite for Local DEV, native JavaScript Web Components, Bootstrap `5.3.9`, and Font Awesome Free `7.3.1`.

Identity and access are implemented. The root URL serves the Arabic/English login and current-session shell. `POST /login` and `POST /logout` use the Laravel browser session, every route under `/api/*` requires that session, and `PATCH /api/v1/account/password` changes the authenticated user's own password. A temporary-password account must complete that form before using other protected API actions. User administration and the other product modules require later approved stages.

## Runtime boundaries

| Path | Ownership |
| --- | --- |
| `app/Business/` | Business rules, transactions, and Laravel-managed persistence |
| `app/Http/Controllers/Api/` | HTTP transport that delegates to the business layer |
| `resources/js/components/` | Native Web Components that call approved HTTP APIs |

Project-authored PHP class and JavaScript component filenames use the `Saffna` prefix. Framework-required filenames keep their required names.

## Local DEV requirements

The installed and validated workstation versions are PHP `8.4.6`, Composer `2.9.2`, Node.js `22.13.0`, npm `11.1.0`, and SQLite `3.51.0`. PHP must provide `pdo_sqlite` and `sqlite3`.

For a fresh checkout:

```sh
cd apps/web
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm ci
npm run build
php artisan test
```

After migrations, the first Local DEV account can be created once with:

```sh
php artisan saffna:provision-super-admin
```

The command runs only when `APP_ENV=local`, requires an empty user table, creates the fixed `support@hasanhalabi.com` Super Admin, and prints its generated temporary password once. Do not copy that password into source, logs, task text, or documentation.

After signing in with a temporary password, the bilingual session interface requires the current temporary password, a policy-compliant new password, and matching confirmation. A successful change clears the temporary-password flag, regenerates the session and CSRF token, and records an audit event without either password.

`.env`, `database/database.sqlite`, `vendor/`, `node_modules/`, compiled assets, caches, and logs are local state and are not committed. Local DEV uses `Asia/Amman`, Arabic as the primary application locale, English as the fallback locale, and the database file at `apps/web/database/database.sqlite` when `DB_DATABASE` is unset.

Run `php artisan migrate:rollback` followed by `php artisan migrate` to verify the current empty baseline can roll back and migrate again. Other Laravel-supported database drivers can be selected through environment configuration without changing business classes; compatibility with another database is not certified.

Current stable Google Chrome is the only supported browser. Validation covers normal desktop and responsive mobile Chrome behavior from 360 CSS pixels, Arabic RTL, English LTR, and standard keyboard-operable controls. Other browsers, screen readers, and WCAG certification are outside the current scope.

## Governing sources

- [Application architecture](../../artifacts/architecture-decisions/saffna-application-architecture.md)
- [Database governance](../../artifacts/database/README.md)
- [Inbound API contract](../../artifacts/integrations-inbound/README.md)
- [Security baseline](../../artifacts/security/saffna-access-baseline.md)
- [Web interface baseline](../../artifacts/design-language/web-app/saffna-interface-baseline.md)
- [Deployment and operations](../../artifacts/deployment-operations/README.md)
