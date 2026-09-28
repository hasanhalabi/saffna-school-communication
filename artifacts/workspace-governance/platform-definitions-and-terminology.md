# Saffna Platform Definitions And Terminology

**Status:** Active canonical terminology library  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-09-28  
**Approval/task:** Direct request; Stage SAFFNA-FND-001; Stage SAFFNA-CLICKUP-001

## Platform Boundary

“Saffna platform” currently means the one planned Laravel web application and its owned UI, HTTP API, PHP business classes, and SQLite data. A browser is a client outside that server-side boundary. A possible future mobile app is not part of the current runtime. Inbound means a request or event enters the Saffna platform boundary; outbound means Saffna calls or emits to another system. Internal calls among its UI, API, and business classes do not create separate deployables.

## Canonical Terms

| Canonical term | Plain-English definition | Accepted alias or abbreviation | Deprecated expression | Technical mapping | Do not confuse with | Affected canonical artifacts | Source / approval provenance |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Saffna | The school communication product and current platform boundary | Saffna platform | None | One planned Laravel app at `apps/web/` | A future mobile app | Profile, structure, architecture | Owner request; SAFFNA-FND-001 |
| Admin user | A stated login actor type; permissions remain unresolved | Admin | None | Future Laravel identity/authorization model | System operator or ClickUp member | Business baseline, security | Owner clarification; SAFFNA-FND-001 |
| Teacher | A stated login actor type; permissions remain unresolved | None | None | Future identity/authorization model | Class ownership, which is unresolved | Business baseline, security | Owner clarification; SAFFNA-FND-001 |
| Parent | A stated login actor type; relationship to students remains unresolved | Parents | Patient, patients | Future identity/authorization model | Student | Business baseline, security | Owner correction; SAFFNA-FND-001 |
| Student | A stated login actor type and school participant; permissions remain unresolved | Students | None | Future identity/authorization model | Parent | Business baseline, security | Owner clarification; SAFFNA-FND-001 |
| User Management | Named Saffna module; detailed actions remain unresolved | None | None | Future Laravel feature area | Authentication implementation alone | Business baseline | Owner request; SAFFNA-FND-001 |
| Class Management | Named Saffna module; entity and workflow remain unresolved | None | None | Future Laravel feature area | Source-code class | Business baseline, database | Owner request; SAFFNA-FND-001 |
| Assignments | Named Saffna module; entity and workflow remain unresolved | None | None | Future Laravel feature area | ClickUp tasks | Business baseline, database | Owner request; SAFFNA-FND-001 |
| Messaging | Named Saffna module; delivery channel and workflow remain unresolved | None | None | Future Laravel feature area | ClickUp chat or an approved outbound provider | Business baseline, integrations | Owner request; SAFFNA-FND-001 |
| Laravel application | The single current deployable that will own UI, API, business classes, and data connection | Web app | Separate API service | `apps/web/`, Laravel 12 | Independent mobile app | Profile, structure, architecture | Owner clarification; SAFFNA-FND-001 |
| Business classes | Project-owned PHP classes intended to hold business behavior and direct database work | PHP business layer | Database classes as a blanket name | Future `apps/web/app/Business/` | HTTP API controllers | Architecture, database | Owner request; SAFFNA-FND-001 |
| API layer | HTTP transport between Saffna frontend/client and PHP business classes | API | Business layer | Future `apps/web/app/Http/Controllers/Api/` plus routing | Independently deployed API service | Architecture, inbound contracts | Owner request; SAFFNA-FND-001 |
| Web Component | Native JavaScript custom-element based frontend building block | Web Components | Additional frontend framework | Future `apps/web/resources/js/components/` | Bootstrap styling | Architecture, design language | Owner request; SAFFNA-FND-001 |
| SQLite | The selected database engine; schema and operational settings remain unresolved | None | Lite SQL | Future Laravel data connection | A separate database service | Profile, database, architecture | Owner wording interpreted in handshake; SAFFNA-FND-001 |
| Inbound integration | A request or event crossing into the Saffna platform boundary | Inbound API | None | Future HTTP API contract where applicable | Internal API-to-business call | Inbound contracts | Governance default; SAFFNA-FND-001 |
| Outbound integration | A call or event crossing from Saffna to another system | Outbound API | None | No provider approved | Browser response or internal call | Outbound contracts | Governance default; SAFFNA-FND-001 |
| Local DEV | Local authoring and later local runtime environment | Local development | None | This workspace | Server DEV/Staging | Profile, deployment | Governance default; SAFFNA-FND-001 |
| Server DEV/Staging | Separate remote test environment; target unresolved | Staging | None | No server configured | Local DEV or Live production | Profile, deployment | Governance default; SAFFNA-FND-001 |
| Live production | User-facing production environment; target unresolved | Production | None | No host configured | Server DEV/Staging | Profile, deployment | Governance default; SAFFNA-FND-001 |
| Saffna ClickUp list | Configured task source of truth for current workstreams | ClickUp list | Local backlog | Workspace `3668514`, list `901821841766` | Product requirement approval | Profile, task governance | Owner URL and 2026-09-28 read; SAFFNA-FND-001 |
| Local ClickUp MCP | Required tool route for authorized Saffna ClickUp operations in local Codex | `clickup_local_core` | Official ClickUp Plugin or hosted ClickUp MCP for this workspace | `mcp__clickup_local_core__` tools; existing user-level registration | Saffna ClickUp list as task source of truth or stage approval | Agent guide, task governance | Owner request; SAFFNA-CLICKUP-001 |

## Update Rule

Read this library before using governed product, actor, requirement, workflow, status, runtime, environment, integration, API, or deployment terms. When a term or concept is introduced, changed, renamed, or clarified, update this library and every affected canonical artifact in the same approved stage. Check user-facing labels and runtime catalogues once they exist. Record compatibility-sensitive identifiers that must retain an older spelling. Do not create competing synonyms. Raw owner input remains source evidence, not a second terminology authority.
