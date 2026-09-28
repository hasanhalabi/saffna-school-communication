# Saffna Platform Baseline

**Status:** Proposed product baseline; detailed behavior unresolved  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-09-28  
**Approval/task:** Direct request; foundation documentation approved as Stage SAFFNA-FND-001

## Purpose And Scope

Saffna is intended to enable school communication among students, teachers, and parents. Admin users will also log in. The current primary deliverable is a browser-based platform. The product owner named four modules: User Management, Class Management, Assignments, and Messaging. Their detailed workflows, acceptance conditions, and relationships have not yet been supplied.

## Confirmed Product Statements

- `REQ-PLATFORM-001`: The planned Saffna platform has User Management, Class Management, Assignments, and Messaging modules.
- `REQ-PLATFORM-002`: The planned platform supports login for admin users, teachers, parents, and students.
- `REQ-PLATFORM-003`: Arabic is the primary language and uses RTL layout; English uses LTR layout.
- `REQ-PLATFORM-004`: The current primary delivery surface is the Laravel web application. Mobile is a possible later application, not a current deliverable.

These IDs record stated scope, not invented module workflows. A later approved stage must define observable success, rejection, edge, and recovery outcomes before runtime implementation.

## Actors And Terms

Use the definitions in the [canonical terminology library](../workspace-governance/platform-definitions-and-terminology.md). “Parents” is the confirmed term; the earlier “patients” wording was corrected by the product owner. Actor permissions and account relationships are unresolved.

## Source Strategy And Delivery

The source strategy is greenfield over Laravel 12. No reference codebase, template, or commercial source was supplied. Current delivery is browser-based; host, domains, release state, and remote environments are unresolved.

## Open Decisions And Later Gates

- Define each module's actors, records, actions, lifecycle, and acceptance criteria.
- Define role permissions, parent/student links, class ownership, assignment visibility, and messaging recipients.
- Define student and family data classification, consent where applicable, retention, deletion, audit, and recovery.
- Define API contracts, authentication/session behavior, error handling, localization copy, accessibility, and supported browsers.
- Define hosting and the distinction between Server DEV/Staging and Live production.

These decisions block relevant implementation stages, not this documentation foundation.

## Cross-Surface Impact

| Surface | Current impact | Governing location |
| --- | --- | --- |
| Web application | One Laravel deployable and four named modules | Architecture decision and future module rules |
| Data | SQLite selected; model unresolved | `artifacts/database/` |
| API | Browser-to-backend boundary required; contracts unresolved | `artifacts/integrations-inbound/` |
| Security/privacy | Four login actor types; permission/data rules unresolved | `artifacts/security/` |
| Design/localization | Arabic RTL primary, English LTR | `artifacts/design-language/` |
| Operations | Remote targets and release states unresolved | `artifacts/deployment-operations/` |
| Future mobile | Possible future API consumer | New approved stage if adopted |

## Evidence And Change History

- Product-owner statements: conversation on 2026-09-28, including clarification that the intended actor is “parent.”
- Dated external observation: ClickUp list metadata is recorded in task governance and does not define product behavior.
- Assumptions: none promoted to a product workflow.

| Date | Change | Approval/task |
| --- | --- | --- |
| 2026-09-28 | Recorded initial platform scope without inventing module behavior | SAFFNA-FND-001, direct request |
