# ADR-0001: Saffna Application Architecture

**Status:** Foundation direction approved; runtime details pending  
**Decision owner:** Hasan, requesting product owner  
**Date:** 2026-09-28  
**Approval/task:** Direct request; Stage SAFFNA-FND-001 approved in the user message `proceed with implementation for Stage SAFFNA-FND-001`

## Context

Saffna starts as a greenfield school communication web platform. The product owner requires one Laravel 12 application, PHP business classes that own direct database work, a separate HTTP API communication layer, and native JavaScript Web Components for the frontend. SQLite is the stated database. Bootstrap 5 and locally hosted Font Awesome Free are the allowed UI libraries/assets. A mobile application may exist later.

## Decision

- Use one deployable Laravel 12 application under `apps/web/`.
- Keep project-owned PHP business and persistence classes in a distinct `app/Business/` area, API controllers in `app/Http/Controllers/Api/`, and Web Components in `resources/js/components/` when runtime source is created.
- The browser frontend communicates with the backend through the HTTP API. API transport code delegates business and SQLite operations to the PHP business layer.
- Use a `Saffna` prefix for project-authored PHP class and JavaScript component filenames; preserve filenames Laravel requires for framework operation.
- Treat a future mobile client as an additional consumer only after its ownership, contracts, and deployment are approved. Do not create a mobile runtime now.

## Alternatives Considered

- Independently deployed API service: not selected because the product owner explicitly chose one Laravel application.
- A JavaScript application framework: not selected because the product owner specified native Web Components and no additional frontend UI libraries.

## Consequences

The API, business logic, UI, and persistence share one deployment but have separate code ownership. The future mobile option makes stable API contracts important; it does not establish a mobile requirement. Laravel version, exact directory integration, database schema, auth mechanism, build tooling, package versions, and deployment remain later-stage gates. Do not infer those details from this decision.

## Validation And Reversal

This foundation stage validates documentation consistency only. A later approved runtime stage must verify that Laravel 12 can be installed with the documented separation and filename convention. A change to independent deployables or another framework requires a superseding ADR and cross-surface review.

## Related Artifacts

- [Project profile](../workspace-governance/project-profile.yaml)
- [Project structure](../workspace-governance/project-structure.md)
- [Business baseline](../business-rules-requirements/saffna-platform-baseline.md)
- [Web interface baseline](../design-language/web-app/saffna-interface-baseline.md)

## Supersession

- Supersedes: None
- Superseded by: None
