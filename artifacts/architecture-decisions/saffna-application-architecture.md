# ADR-0001: Saffna Application Architecture

**Status:** Runtime foundation and identity/access implemented; User Management and other features pending
**Decision owner:** Hasan, requesting product owner  
**Date:** 2026-09-28; clarified and implemented through 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001 approved in the user message `proceed with implementation for Stage SAFFNA-FND-001`; Stage SAFFNA-ARCH-PLAN-001-R1; Stage SAFFNA-FOUNDATION-DEFS-001; Stage SAFFNA-RUNTIME-FOUNDATION-001-R1; Stage SAFFNA-IDENTITY-ACCESS-001-R2; Stage SAFFNA-IDENTITY-ACCESS-LOCAL-SUPER-ADMIN-001-R2; Stage SAFFNA-IDENTITY-PASSWORD-CHANGE-001-R1; ClickUp task `z8uq9mfg45`

## Context

Saffna starts as a greenfield, single-school communication web platform. The product owner requires one Laravel 12 application, PHP business classes that own direct database work, a separate HTTP API communication layer, and native JavaScript Web Components for the frontend. SQLite is the stated database. Bootstrap 5 and locally hosted Font Awesome Free are the allowed UI libraries/assets. A mobile application may exist later.

## Decision

- Use one deployable Laravel 12 application under `apps/web/`.
- The installed baseline uses Laravel application skeleton `12.12.2`, Laravel Framework `12.72.0`, Bootstrap `5.3.9`, and Font Awesome Free `7.3.1`, with exact dependency versions locked.
- Keep project-owned PHP business and persistence classes in a distinct `app/Business/` area, API controllers in `app/Http/Controllers/Api/`, and Web Components in `resources/js/components/` when runtime source is created.
- The browser frontend communicates with the backend through the HTTP API. API transport code delegates business and SQLite operations to the PHP business layer.
- Extend Laravel's application-owned `User` model and framework migration instead of creating a parallel user system. Use Laravel's default identity fields `name`, unique `email`, and hashed `password`; email is the login identifier and no username field is added.
- Protect every route under `/api/*` with Laravel session authentication and place approved application endpoints under `/api/v1/*`. The implemented authenticated fallback rejects unknown API requests before returning a scoped not-found response. `POST /login` and `POST /logout` remain outside `/api/*`; `GET /api/v1/me` returns the current identity and explicit permissions, and `PATCH /api/v1/account/password` delegates own-password changes to the business layer. A temporary-password account may use only current-session inspection, own-password change, and logout until the change succeeds. Public registration, public recovery, token authentication, cross-origin access, and anonymous business/data API routes remain absent.
- Allow multiple signed-in devices, use a 120-minute inactive-session lifetime, and retain Laravel's standard remember-me behavior. Disabling an account or administratively resetting its password revokes its existing sessions.
- Provision the first Local DEV Super Admin through the non-public `php artisan saffna:provision-super-admin` command after migrations. It runs only in Local DEV, requires an empty user table, uses `support@hasanhalabi.com` and `Saffna Super Admin`, hashes a generated temporary password, prints it once, and records an audit event without the password. Stage SAFFNA-IDENTITY-ACCESS-LOCAL-SUPER-ADMIN-001-R2 created that account in the ignored Local DEV database and delivered the one-time password outside source and task systems.
- Keep the user groups fixed as Super Admin, Admin user, Teacher, Parent, and Student. Each user belongs to one fixed group. The permission matrix is fixed in application code and enforced through Laravel Gates and Policies; it is not editable through the UI.
- Only the Super Admin creates accounts and assigns or changes user groups. An Admin user may manage existing Teacher, Parent, and Student accounts but may not create accounts, change groups, or manage Super Admin and Admin user accounts. Unlisted access is denied.
- Use Laravel migrations, Eloquent, query builder, and environment configuration for database-portable access. Avoid intentional SQLite-only SQL in application-owned behavior. MySQL conversion and compatibility testing are not current Saffna deliverables.
- Put reusable business behavior in clearly owned PHP services. Controllers validate transport shape and permissions; business services own business validation, transactions, and persistence. Search existing code before adding a function or class. Shared Arabic name normalization and approved national-number validation must not be duplicated across controllers, components, or domain services.
- Use a `Saffna` prefix for project-authored PHP class and JavaScript component filenames; preserve filenames Laravel requires for framework operation.
- Build custom Saffna browser behavior with native Web Components and the latest compatible Bootstrap 5 release installed locally. Reuse standard Laravel backend authentication facilities and standard Bootstrap components; do not introduce React, Vue, Livewire, Tailwind, or another frontend framework.
- Keep the current product single-school. Do not add organization or tenant boundaries speculatively.
- Support current stable Google Chrome only for the current browser delivery. Validate desktop and responsive mobile Chrome behavior from 360 CSS pixels with standard semantic controls and keyboard behavior. Other browsers, screen-reader testing, and WCAG certification may be added only by later work.
- Treat a future mobile client as an additional consumer only after its ownership, contracts, and deployment are approved. Do not create a mobile runtime now.

## Alternatives Considered

- Independently deployed API service: not selected because the product owner explicitly chose one Laravel application.
- A JavaScript application framework: not selected because the product owner specified native Web Components and no additional frontend UI libraries.
- Laravel React, Vue, Livewire, and Tailwind starter-kit interfaces: not selected because they add conflicting frontend architecture and dependencies. Saffna will reuse Laravel's backend authentication facilities without adopting those interface stacks.
- A separate Saffna user model and authentication system: not selected because the Laravel application model and authentication facilities are the required base.
- Anonymous access to routes under `/api/*`: not selected because the product owner requires every Saffna API action to have a logged-in user.
- Saffna-owned MySQL conversion: not selected. The application exposes a database-portable Laravel structure, while a future adopter owns conversion and verification.

## Consequences

The API, business logic, UI, and persistence share one deployment but have separate code ownership. API access depends on a Laravel browser session, so a possible future mobile client will require its own approved authentication design. The future mobile option makes stable API contracts important; it does not establish a mobile requirement. The Laravel foundation, identity schema, secure provisioning command, session endpoints, protected current-user and own-password APIs, fixed permission matrix, and Chrome login/session/password interface now exist. User Management operations and deployment remain later-stage gates. Database portability is an architectural constraint, not a guarantee that an untested database change needs no work.

## Validation And Reversal

Stage SAFFNA-RUNTIME-FOUNDATION-001-R1 verifies the installed runtime foundation. Stage SAFFNA-IDENTITY-ACCESS-001-R2 verifies identity migration rollback/reapply, provisioning safety and rollback, session security, API protection, the authorization matrix, frontend build, and normal-user behavior in current stable Google Chrome. Stage SAFFNA-IDENTITY-PASSWORD-CHANGE-001-R1 verifies required and voluntary own-password changes, API blocking during the required state, audit recording, localization, and the Chrome flow. A change to independent deployables, another framework, or the supported-browser boundary requires a superseding decision and cross-surface review.

## Related Artifacts

- [Project profile](../workspace-governance/project-profile.yaml)
- [Project structure](../workspace-governance/project-structure.md)
- [Business baseline](../business-rules-requirements/saffna-platform-baseline.md)
- [Web interface baseline](../design-language/web-app/saffna-interface-baseline.md)

## Supersession

- Supersedes: None
- Superseded by: None
