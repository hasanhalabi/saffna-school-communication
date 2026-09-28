# Saffna Identity And Access Baseline

**Status:** Proposed security baseline; control design unresolved  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-09-28  
**Approval/task:** Direct request; Stage SAFFNA-FND-001

## Confirmed Boundary

The product owner stated that admin users, teachers, parents, and students will log in. The Laravel application is the planned identity-owning runtime. No authentication package, session design, account-linking model, permission matrix, registration process, or password recovery flow has been chosen.

## Decisions Required Before Implementation

- Define each actor's allowed actions and data visibility for User Management, Class Management, Assignments, and Messaging.
- Define how parent and student accounts relate and how teachers relate to classes.
- Classify student and family data; decide collection, consent where applicable, retention, deletion, audit, and access review.
- Define login/session security, CSRF/CORS/CSP boundaries, rate limits, recovery, lockout, and incident handling.
- Define test data, environment isolation, secret storage, and logging redaction.

The user-facing actor names come from the [terminology library](../workspace-governance/platform-definitions-and-terminology.md). No role implies permissions until the product owner approves a detailed rule. Do not put real personal records in development fixtures or documentation.

## Cross-Surface Impact

Access decisions affect the API, PHP business classes, SQLite model, UI states, Arabic/English copy, audit logs, and any future mobile client. Update the relevant canonical artifacts together in the same approved stage.
