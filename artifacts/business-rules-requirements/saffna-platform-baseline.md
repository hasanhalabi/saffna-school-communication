# Saffna Platform Baseline

**Status:** Approved platform foundation with identity/access implemented; User Management operations and later modules remain unresolved
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; foundation documentation approved as Stage SAFFNA-FND-001; Stage SAFFNA-ARCH-PLAN-001-R1; Stage SAFFNA-FOUNDATION-DEFS-001; Stage SAFFNA-IDENTITY-ACCESS-001-R2; Stage SAFFNA-IDENTITY-PASSWORD-CHANGE-001-R1; ClickUp task `z8uq9mfg45`

## Purpose And Scope

Saffna is intended to enable communication within one school among students, teachers, and parents. Admin users will also log in. The current primary deliverable is a browser-based platform. The product owner named four modules: User Management, Class Management, Assignments, and Messaging. Authentication and the initial User Management boundary are defined; the other three modules' detailed workflows, acceptance conditions, and relationships remain deferred.

## Confirmed Product Statements

- `REQ-PLATFORM-001`: The planned Saffna platform has User Management, Class Management, Assignments, and Messaging modules.
- `REQ-PLATFORM-002`: The planned platform supports login for Super Admin, Admin users, teachers, parents, and students.
- `REQ-PLATFORM-003`: Arabic is the primary language and uses RTL layout; English uses LTR layout.
- `REQ-PLATFORM-004`: The current primary delivery surface is the Laravel web application. Mobile is a possible later application, not a current deliverable.
- `REQ-PLATFORM-005`: Saffna will extend Laravel's application-owned `User` model instead of creating a separate user system. Login uses a unique email and password; no username field is planned.
- `REQ-PLATFORM-006`: The first Local DEV account is a non-publicly provisioned Super Admin named `Saffna Super Admin` with email `support@hasanhalabi.com`. The generated temporary password is returned once to the product owner after creation and is not stored in plaintext.
- `REQ-PLATFORM-007`: Every user belongs to one fixed user group: Super Admin, Admin user, Teacher, Parent, or Student. Classes are managed records, not user groups. The permission matrix is fixed in application code and is not editable in the UI; only group membership is assigned through the UI.
- `REQ-PLATFORM-008`: Every route under `/api/*` requires an authenticated Laravel session, and approved application endpoints are versioned under `/api/v1/*`. `POST /login` and `POST /logout` are outside `/api/*`; public registration, public password recovery, token authentication, cross-origin access, and anonymous business/data API actions are not planned.
- `REQ-PLATFORM-009`: Browser behavior follows Web Components to protected API transport to reusable PHP business classes to Laravel-managed data access. API controllers and Web Components do not duplicate business or persistence rules.
- `REQ-PLATFORM-010`: SQLite is the selected Saffna database. Data access must avoid intentional SQLite-only coupling so another developer can later adapt the application to another Laravel-supported database. That conversion and its compatibility testing are outside current Saffna scope.
- `REQ-PLATFORM-011`: Before adding a project-owned function or class, implementation checks for an existing owner and reusable behavior. Shared Arabic name normalization and approved identifier validation belong in reusable business services, not duplicated API or UI code.
- `REQ-PLATFORM-012`: Saffna serves one school. Multiple-school tenancy, organization switching, and cross-school data boundaries are not planned.
- `REQ-PLATFORM-013`: Passwords contain at least 12 characters, including uppercase letters, lowercase letters, and numbers; symbols are optional. Temporary passwords must change at the next login through a form that verifies the current password, accepts a different compliant new password, and requires matching confirmation. Until that succeeds, the account may inspect its session, change its own password, or log out but may not use other protected API actions. Repeated login attempts are throttled.
- `REQ-PLATFORM-014`: Multiple devices may remain signed in. Inactive sessions expire after 120 minutes, Laravel's remember-me behavior is available, and an administrative password reset or account disable revokes existing sessions.
- `REQ-PLATFORM-015`: Only the Super Admin creates users and assigns or changes their fixed group. Admin users may manage existing Teacher, Parent, and Student accounts. Accounts are disabled or reactivated rather than deleted, no user impersonation is allowed, and the final active Super Admin cannot be disabled or demoted.
- `REQ-PLATFORM-016`: Custom Saffna frontend behavior uses native Web Components, locally installed Bootstrap 5, and locally hosted Font Awesome Free. React, Vue, Livewire, Tailwind, and other frontend frameworks are excluded.
- `REQ-PLATFORM-017`: Current stable Google Chrome is the only supported browser for the current implementation. Normal desktop and responsive mobile Chrome behavior from 360 CSS pixels is validated. Other browsers, screen-reader testing, and WCAG certification are outside the current scope; standard semantic controls and keyboard behavior remain implementation basics.

These IDs record approved platform direction, not invented module workflows. A later approved stage must define observable success, rejection, edge, and recovery outcomes before runtime implementation.

## Actors And Terms

Use the definitions in the [canonical terminology library](../workspace-governance/platform-definitions-and-terminology.md). “Parents” is the confirmed term; the earlier “patients” wording was corrected by the product owner. Super Admin is distinct from Admin user. Each user has one fixed user group. User Management permissions are defined in the security baseline; permissions and account relationships for Class Management, Assignments, and Messaging remain unresolved.

## Source Strategy And Delivery

The source strategy is greenfield over Laravel 12. No reference codebase, template, or commercial source was supplied. Current delivery is browser-based; host, domains, release state, and remote environments are unresolved.

## Open Decisions And Later Gates

- Define Class Management, Assignments, and Messaging actors, records, actions, lifecycle, and acceptance criteria.
- Define parent/student links, class ownership, assignment visibility, and messaging recipients when their owning modules begin.
- Define student and family data classification, consent where applicable, retention, deletion, audit, and recovery.
- Define product branding, typography, and color tokens during later UI work.
- Define hosting and the distinction between Server DEV/Staging and Live production.

These decisions block relevant implementation stages, not this documentation foundation.

## Cross-Surface Impact

| Surface | Current impact | Governing location |
| --- | --- | --- |
| Web application | One Laravel deployable; identity/access implemented and four modules named | Architecture decision and future module rules |
| Data | SQLite identity schema, fixed groups, and audit records implemented | `artifacts/database/` |
| API | Session login/logout plus protected current-user and own-password APIs implemented | `artifacts/integrations-inbound/` |
| Security/privacy | Five fixed user groups and initial User Management matrix enforced; student/family privacy remains unresolved | `artifacts/security/` |
| Design/localization | Arabic RTL and English LTR login/session/password UI implemented for current stable Google Chrome | `artifacts/design-language/` |
| Operations | Remote targets and release states unresolved | `artifacts/deployment-operations/` |
| Future mobile | Possible future API consumer | New approved stage if adopted |

## Evidence And Change History

- Product-owner statements: conversation on 2026-09-28, including clarification that the intended actor is “parent.”
- Dated external observation: ClickUp list metadata is recorded in task governance and does not define product behavior.
- Assumptions: none promoted to a product workflow.

| Date | Change | Approval/task |
| --- | --- | --- |
| 2026-09-28 | Recorded initial platform scope without inventing module behavior | SAFFNA-FND-001, direct request |
| 2026-11-15 | Added Laravel User reuse, Super Admin bootstrap, fully protected API, one-group authorization, database portability, and reuse-first requirements | SAFFNA-ARCH-PLAN-001-R1, `z8uq9mfg45` |
| 2026-11-15 | Defined email login, session and password rules, fixed groups, User Management permissions, API conventions, identity data, and native Bootstrap/Web Component UI direction | SAFFNA-FOUNDATION-DEFS-001, `z8uq9mfg45` |
| 2026-11-15 | Implemented secure provisioning, session authentication, the protected current-user API, fixed permission enforcement, and the Chrome-only bilingual login/session UI | SAFFNA-IDENTITY-ACCESS-001-R2, `z8uq9mfg45` |
| 2026-11-15 | Implemented required and voluntary own-password changes, required-state API blocking, audit recording, and the bilingual Chrome form | SAFFNA-IDENTITY-PASSWORD-CHANGE-001-R1, `z8uq9mfg45` |
