# Saffna Web Interface Baseline

**Status:** Approved foundation direction; detailed design pending  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-09-28  
**Approval/task:** Direct request; Stage SAFFNA-FND-001

## Confirmed Direction

- Build browser UI behavior with native JavaScript Web Components. Keep their project-authored filenames `Saffna`-prefixed in the future `apps/web/resources/js/components/` area.
- Use Bootstrap 5 as the UI library. Determine the exact available release in a later approved package stage.
- Use Font Awesome Free icons from locally hosted files. Do not depend on the Font Awesome CDN.
- Do not add another frontend UI library without a new approved decision.
- Arabic is the primary language and uses RTL layout. English uses LTR layout.

## Boundaries

Web Components communicate with the Laravel backend through the API layer. They do not access SQLite directly. API and business behavior belongs in the architecture and contract artifacts. The Laravel application owns the web assets and their deployment.

## Open Design Decisions

Decide supported browsers/devices, responsive breakpoints, accessibility baseline, typography and color tokens, language switch behavior, bidirectional content handling, translation ownership, screen inventory, navigation, loading/error/empty states, and safe handling of icons and local asset versions. These decisions block corresponding UI implementation, not foundation documentation.

## Cross-Surface Impact

Arabic/English behavior affects form validation messages, API-visible copy boundaries, account roles, accessibility, and deployment asset packaging. A design or language rule change must review these areas and the terminology library in the same approved stage.
