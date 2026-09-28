# Saffna Initial Product Owner Intake — 2026-09-28

**Status:** Dated raw input summary; noncanonical  
**Source:** Hasan's messages in the Saffna bootstrap conversation  
**Approval context:** Stage SAFFNA-FND-001 approved creation of this foundation

## Statements Supplied

- Project name: Saffna. ClickUp list: `https://app.clickup.com/3668514/v/li/901821841766`.
- Purpose: a school communication platform. Named modules: User Management, Class Management, Assignments, and Messaging.
- Users: students, teachers, and parents, plus admin users for login. Hasan clarified that “parents” was intended where an earlier message said “patients.”
- Source: from scratch over Laravel 12, with one Laravel application.
- Architecture: separate folders for PHP business classes that communicate with the database, API communication code, and JavaScript Web Components. Project-authored runtime PHP and JavaScript filenames use the `Saffna` prefix.
- UI: Bootstrap 5, Font Awesome Free downloaded and hosted locally, no additional frontend UI library, no Font Awesome CDN.
- Database: SQLite (stated as “Lite SQL” in the first message, interpreted and recorded as SQLite in the foundation proposal).
- Language: Arabic is primary and RTL; English is LTR.
- Login actor types: admin users, teachers, parents, and students.
- Mobile application: possible in the future, with no current runtime requirement.

## Evidence Boundary

This record preserves the request. The project profile, architecture decision, and active baseline artifacts state the current foundation direction. Detailed module workflows, hosting, permissions, and student-data handling were not supplied and remain open decisions.
