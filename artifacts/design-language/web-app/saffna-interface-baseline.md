# Saffna Web Interface Baseline

**Status:** Login and session interface implemented for Google Chrome; User Management and visual design details pending
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001; Stage SAFFNA-ARCH-PLAN-001-R1; Stage SAFFNA-FOUNDATION-DEFS-001; Stage SAFFNA-IDENTITY-ACCESS-001-R2; ClickUp task `z8uq9mfg45`

## Confirmed Direction

- Build browser UI behavior with native JavaScript Web Components. Keep their project-authored filenames `Saffna`-prefixed in the future `apps/web/resources/js/components/` area.
- Use the latest compatible Bootstrap 5 release as the UI library and install its files locally. Use standard Bootstrap forms, tables, dialogs, feedback, and responsive utilities instead of recreating equivalent UI behavior.
- Use Font Awesome Free icons from locally hosted files. Do not depend on the Font Awesome CDN.
- Do not add React, Vue, Livewire, Tailwind, or another frontend library without a new approved decision.
- Arabic is the primary language and uses RTL layout. English uses LTR layout.
- Reuse Laravel's backend authentication facilities. Saffna-owned Web Components now implement login and current-session state; User Management components remain pending. Do not adopt a frontend starter-kit interface that introduces a conflicting framework.
- Show no school data or business actions before a session is authenticated. The login screen is the only currently planned guest application screen.

## Screen And Interaction Baseline

The initial authenticated-interface stage includes login, current account, user list, user details, create user, edit user, administrative password reset, disable/reactivate confirmation, and change-own-password behavior. It excludes public registration and public password recovery.

- Account forms use Laravel's `name`, unique `email`, and password fields. Phone is optional and non-unique. The Super Admin selects one fixed group when creating an account; status defaults to active, preferred language defaults to Arabic, and temporary credentials require a password change.
- Only the Super Admin sees create-account or assign/change-group behavior. Admin users may see allowed management actions for existing Teacher, Parent, and Student accounts. Teachers, Parents, and Students have no account-management UI beyond their own password and preferred language.
- Search the user list by name or email. Filter by group and account status. Use page-based pagination with 25 rows per page. Do not provide destructive bulk actions.
- Hide actions that the current user cannot perform. The server remains authoritative and returns `403` for attempted forbidden actions.
- Provide explicit loading, empty, validation, general error, session-expired, and permission-denied states.
- Support current stable Google Chrome only, with desktop and responsive mobile layouts from 360 CSS pixels. Use standard semantic HTML controls, visible labels, and normal keyboard behavior. Other browsers, screen-reader testing, and WCAG certification are not current acceptance requirements.
- Present Arabic in RTL and English in LTR. Show user-facing timestamps through minutes only, without seconds or milliseconds.

## Boundaries

Web Components communicate with the Laravel backend through the protected API layer after login. They do not access SQLite directly. `POST /login` and `POST /logout` sit outside `/api/*`; login establishes the Laravel session used by later API calls. The protected `GET /api/v1/me` operation supplies current-user state. API and business behavior belongs in the architecture and contract artifacts. The Laravel application owns the web assets and their deployment.

## Open Design Decisions

Confirm branding, typography and color tokens, detailed navigation, translation ownership, and future accessibility scope during later implementation stages. Expanding support beyond current stable Google Chrome requires later work. These visual details do not change the approved User Management screens or access boundaries.

## Cross-Surface Impact

Arabic/English behavior is implemented for login validation, API-visible messages, direction changes, account group labels, and session state. Chrome-only support affects QA and deployment expectations but does not weaken server-side security. A design, language, browser-support, or accessibility-scope change must review these areas and the terminology library in the same approved stage.
