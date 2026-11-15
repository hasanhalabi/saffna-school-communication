# Saffna Identity And Access Baseline

**Status:** Authentication and fixed User Management authorization foundation implemented; later module permissions unresolved
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001; Stage SAFFNA-ARCH-PLAN-001-R1; Stage SAFFNA-FOUNDATION-DEFS-001; Stage SAFFNA-IDENTITY-ACCESS-001-R2; ClickUp task `z8uq9mfg45`

## Confirmed Boundary

The Laravel application is the identity-owning runtime. Saffna extends Laravel's application-owned `User` model instead of building a parallel identity system. The approved user groups are Super Admin, Admin user, Teacher, Parent, and Student; each user has one fixed group. Classes are not user groups. Email is required, unique, and used for login; no username is added.

Every route under `/api/*` requires an authenticated Laravel session, and approved application endpoints are versioned under `/api/v1/*`. The guest-only `POST /login` and session-protected `POST /logout` sit outside `/api/*`; `GET /api/v1/me` is protected. Saffna has no public registration, public password recovery, public account bootstrap, token authentication, cross-origin access, or anonymous business/data API. Static assets and the login page may be served without a session but do not expose school data or business actions.

The first Local DEV Super Admin can be created after migrations with the non-public `php artisan saffna:provision-super-admin` command. The command runs only in Local DEV, requires an empty user table, uses name `Saffna Super Admin` and email `support@hasanhalabi.com`, returns the generated temporary password once, and stores only its Laravel hash. The same controlled pattern applies to a future environment only after that environment is approved. Stage SAFFNA-IDENTITY-ACCESS-001-R2 tests this command in isolated databases and does not create the persistent Local DEV account.

## Authentication And Session Rules

- Passwords have at least 12 characters and contain uppercase letters, lowercase letters, and numbers. Symbols are optional.
- Temporary passwords require a change at the next login.
- Login is limited to five attempts per minute for each normalized email-and-IP combination. The response does not reveal whether the account exists or is disabled.
- Multiple devices may stay signed in. Inactive sessions expire after 120 minutes and Laravel's remember-me behavior remains available.
- Disabling an account or administratively resetting its password revokes existing sessions.
- Same-origin session cookies and Laravel CSRF protection are required. No API token or cross-origin browser authentication is approved.

## Initial User Management Permission Matrix

Unlisted access is denied. The matrix is fixed in application code and enforced through Laravel Gates and Policies. Administrators cannot edit the permission catalogue through the UI.

| Action | Super Admin | Admin user | Teacher, Parent, Student |
| --- | --- | --- | --- |
| View own account | Allowed | Allowed | Allowed |
| Change own password or preferred language | Allowed | Allowed | Allowed |
| List or view Super Admin and Admin user accounts | Allowed | Denied | Denied |
| List or view Teacher, Parent, and Student accounts | Allowed | Allowed | Denied |
| Create an account | Allowed for any fixed group | Denied | Denied |
| Assign or change a user's fixed group | Allowed | Denied | Denied |
| Edit an existing Teacher, Parent, or Student account | Allowed | Allowed | Denied |
| Reset credentials for Teacher, Parent, or Student | Allowed | Allowed | Denied |
| Disable or reactivate Teacher, Parent, or Student | Allowed | Allowed | Denied |
| Edit, reset, disable, or reactivate an Admin user | Allowed | Denied | Denied |
| Impersonate another user | Denied | Denied | Denied |
| Hard-delete an account | Denied | Denied | Denied |

The final active Super Admin cannot be disabled, demoted, or otherwise removed. Only the Super Admin creates users and assigns or changes group membership. An Admin user manages only existing Teacher, Parent, and Student accounts. Parent/student and teacher/class relationships are deliberately deferred to their later modules.

Administrative creation and reset show a temporary password once for authorized manual delivery. No email or SMS credential-delivery provider is approved. Reactivation requires a new temporary password and next-login change.

Append-only audit storage and recording are implemented for Super Admin provisioning and failed authorization. Later User Management services must use the same recorder for account creation and changes, group changes, disable/reactivate, and administrative password reset. Audit records never include plaintext or hashed passwords and remain indefinitely until a later retention rule is approved.

## Decisions Deferred To Later Modules Or Environments

- Define each actor's allowed actions and data visibility for Class Management, Assignments, and Messaging.
- Define how parent and student accounts relate and how teachers relate to classes when those modules begin.
- Classify student and family data; decide collection, consent where applicable, retention, deletion, audit, and access review.
- Decide later CSP hardening before remote deployment.
- Define the approved Super Admin provisioning target and operator for each future remote environment.
- Define test data, environment isolation, secret storage, and logging redaction.

The user-facing actor names come from the [terminology library](../workspace-governance/platform-definitions-and-terminology.md). Group membership grants only the actions listed in the approved code-defined matrix. Do not put real personal records in development fixtures or documentation.

## Cross-Surface Impact

Access decisions are enforced through the protected API boundary, PHP permission matrix, Laravel Gates and Policy, SQLite identity model, bilingual UI state, and append-only audit records. Current stable Google Chrome is the only browser supported in this stage; other browsers and screen-reader certification remain later work. A future mobile client still needs a separately approved authentication design.
