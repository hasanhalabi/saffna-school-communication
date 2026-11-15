# Saffna Database Governance

SQLite is the selected data store for the planned single Laravel application. The Laravel application owns its connection and future executable migrations. PHP business classes are the intended direct database access layer; HTTP API controllers and Web Components do not query SQLite directly.

Saffna data access must use Laravel migrations, Eloquent, query builder, and environment configuration without intentional SQLite-only coupling. Application-owned code must not use database triggers, stored procedures, raw vendor-specific SQL, database-specific functions, or vendor-specific schema types unless a later approved decision records the reason and impact. This structure gives another developer a clear path to adapt the application to another Laravel-supported database. MySQL conversion, operation, and compatibility testing are not Saffna deliverables.

## Approved Identity And Authorization Model

The identity schema extends Laravel's application-owned `User` model and migration rather than creating parallel user storage.

- Use Laravel's normal auto-incrementing integer identifiers. Authorization never treats an identifier as a secret.
- Keep the default identity fields `name`, unique `email`, hashed `password`, and Laravel's remember token. Email is the login identifier; there is no username field.
- Add only the approved Saffna account fields: one fixed user-group relationship, account status, preferred language, optional non-unique phone, and `must_change_password`.
- Account status has `active` and `disabled` values. Accounts are not hard-deleted.
- Use a fixed `user_groups` reference owned by migrations for Super Admin, Admin user, Teacher, Parent, and Student. Each user has exactly one group. The permission matrix is defined in application code, not in administrator-editable permission records.
- Parent/student and teacher/class relationships are deferred to the later owning modules. They are not part of the identity foundation.
- Add append-only audit records for account creation and changes, group changes, disable/reactivate, administrative password reset, failed authorization, and Super Admin provisioning. Never record plaintext or hashed passwords in audit data.
- Keep audit records indefinitely until a later retention rule is approved.
- Use the configured application/server timezone for stored timestamps. Local DEV uses `Asia/Amman`. User-facing timestamps display through minutes without seconds or milliseconds.

The first Local DEV Super Admin will later be created with name `Saffna Super Admin` and unique email `support@hasanhalabi.com`. Its generated temporary password is stored only as a Laravel hash and returned once to the product owner.

This folder will hold canonical entity/data definitions, data dictionary, ownership, sensitive-data classification, reviewed migration specifications, retention, backup/restore, compatibility, and recovery decisions. This definition stage creates no schema, migration, database file, connection, query, seed data, or Super Admin record.

Before a database implementation stage, confirm the installed Laravel migration baseline, SQLite version and file placement, executable migration and rollback sequence, backup/restore, and environment separation. Student and family data protection and relationships for classes, assignments, and messages remain later module decisions. Review every migration and query for accidental SQLite-only coupling. Database inspection or execution needs separately disclosed approval with an exact target and environment.
