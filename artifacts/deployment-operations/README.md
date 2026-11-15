# Saffna Deployment And Operations

Keep `Local DEV`, `Server DEV/Staging`, and `Live production` distinct. Local DEV now has the Laravel runtime and identity/access implementation under `apps/web/`; it is the only configured environment. Hosting, server ownership, domains, release endpoint, observability, backup, restore, and remote rollback remain unresolved. No remote environment was accessed or changed in Stage SAFFNA-FND-001, Stage SAFFNA-FOUNDATION-DEFS-001, Stage SAFFNA-RUNTIME-FOUNDATION-001-R1, or Stage SAFFNA-IDENTITY-ACCESS-001-R2.

The validated Local DEV workstation uses PHP `8.4.6`, Composer `2.9.2`, Node.js `22.13.0`, npm `11.1.0`, and SQLite `3.51.0`. The application uses `APP_TIMEZONE=Asia/Amman`, `APP_LOCALE=ar`, `APP_FALLBACK_LOCALE=en`, and `DB_CONNECTION=sqlite`. Environment values stay in ignored `.env` files; `.env.example` contains names and safe Local DEV defaults only.

Installation and validation commands are documented in `apps/web/README.md`. Composer and npm lockfiles are committed; `vendor/`, `node_modules/`, compiled assets, the Local DEV database, caches, and logs are ignored. Frontend assets are compiled locally through Vite.

Saffna must remain deployable to conventional low-cost shared PHP hosting when the selected host satisfies Laravel 12's runtime requirements, can point the public web root to Laravel's `public/` directory, permits writable Laravel storage, and supports the approved SQLite placement. Compile frontend assets locally before upload so Node.js is not required on the production server. This is a portability constraint, not approval of a host or deployment.

Current stable Google Chrome is the only supported browser. Local validation covers normal desktop and responsive mobile Chrome behavior from 360 CSS pixels. Other browsers, screen readers, and formal accessibility certification are not release requirements until a later approved stage adds them.

Use the configured application/server timezone rather than forcing UTC. Local DEV uses `Asia/Amman`; each future remote environment must explicitly match its intended server timezone before use. User-facing dates and times stop at minute precision.

This folder owns approved environment configuration names, deployment and release procedure, QA evidence, monitoring, incidents, support, and recovery. It must not contain secret values. SQLite file placement and backup policy need explicit decisions before staging or production deployment. Running builds, tests, migrations, servers, or deployments requires a later named-stage action list.
