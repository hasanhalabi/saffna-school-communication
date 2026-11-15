# Saffna Project Structure

**Status:** Active runtime and identity/access structure
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001; Stage SAFFNA-RUNTIME-FOUNDATION-001-R1; Stage SAFFNA-IDENTITY-ACCESS-001-R2; ClickUp task `z8uq9mfg45`

## Structural Principle

Saffna has one current deployable application. Runtime source and canonical documentation are separate. The Laravel application has distinct business/persistence, API transport, and Web Component areas within that one deployable. A possible mobile application is not represented by a folder until adopted.

## Runtime Foundation Tree

```text
saffna-school-communication/
├── AGENTS.md
├── README.md
├── .gitignore
├── apps/
│   └── web/
│       ├── app/Business/{Audit,Authorization,Identity}/
│       ├── app/Console/Commands/
│       ├── app/Http/{Controllers,Middleware,Requests,Responses}/
│       ├── app/Models/ and app/Policies/
│       ├── config/
│       ├── database/migrations/
│       ├── lang/{ar,en}/
│       ├── resources/js/components/
│       ├── resources/views/
│       ├── routes/
│       ├── tests/
│       ├── composer.json
│       ├── composer.lock
│       ├── package.json
│       ├── package-lock.json
│       └── README.md
└── artifacts/
    ├── README.md
    ├── architecture-decisions/
    ├── archive/
    ├── business-rules-requirements/
    ├── database/
    ├── deployment-operations/
    ├── design-language/web-app/
    ├── integrations-inbound/
    ├── integrations-outbound/
    ├── product-owner-inputs/
    ├── security/
    ├── templates/
    └── workspace-governance/
```

Each artifact folder contains the files indexed by `artifacts/README.md`. The runtime tree shows the installed Laravel foundation and implemented identity/access layer. User Management and the other Saffna modules remain pending.

## Runtime Placement

| Path | Owner and purpose | Deployment boundary |
| --- | --- | --- |
| `apps/web/` | Saffna Laravel 12 web application, frontend build, SQLite connection, and identity/access runtime | One deployable; only current runtime path |
| `apps/web/app/Business/` | Project-owned PHP business and persistence classes | Audit recorder, fixed permission matrix, and temporary-password generator implemented; User Management services pending |
| `apps/web/app/Http/Controllers/Api/` | HTTP API transport/controllers | Protected current-user endpoint implemented; User Management endpoints pending |
| `apps/web/resources/js/components/` | Native JavaScript Web Components | Login and session components implemented; User Management components pending |

Project-authored PHP class and JavaScript component filenames use the `Saffna` prefix. Framework-required filenames keep Laravel's required names. Vite builds locally installed Bootstrap and Font Awesome assets. Identity routing is implemented; User Management and later feature routing remain pending.

## Runtime And Documentation Boundary

Runtime-local READMEs inventory the code. Product behavior, technology decisions, API contracts, data definitions, UI rules, security, and operations remain in `artifacts/`. New runtime entrypoints link to governing artifacts. The API layer calls business classes; it does not own duplicate business rules or direct persistence logic. Web Components use the API and do not query SQLite.

## Growth And Source Rules

Add a new `apps/` or `services/` path only after a real independent runtime and owner are approved. Shared packages require demonstrated reuse by at least two surfaces. Do not create parallel active code trees, speculative mobile folders, or local backlogs. The source is greenfield; no vendor or commercial source is approved for import. If adopted later, record exact provenance, version, license location without secrets, placement, and its own approved intake stage.

## Cross-Surface Review

Changes to layout or ownership require review of the profile, terminology, API contracts, data, security, UI/localization, deployment, task mapping, and future mobile impact. Update affected canonical artifacts in the same approved stage.
