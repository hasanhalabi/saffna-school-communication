# Saffna Database Governance

SQLite is the Local DEV data store for the installed single Laravel application. Local validation uses SQLite CLI `3.51.0` with PHP `pdo_sqlite` and `sqlite3`. The Laravel application owns its connection and executable migrations. PHP business classes are the intended direct database access layer; HTTP API controllers and Web Components do not query SQLite directly.

The default Local DEV database is the ignored file `apps/web/database/database.sqlite`. `DB_CONNECTION=sqlite` selects it, and leaving `DB_DATABASE` unset uses Laravel's `database_path('database.sqlite')`. A future environment may select another Laravel-supported driver through environment configuration without changing business classes; that does not certify compatibility.

The installed migrations contain Laravel session support, cache storage, queued jobs, and the Saffna identity foundation. Migration `2026_11_15_000003_create_saffna_identity_foundation.php` creates the five fixed `user_groups` rows, adds the approved account fields to `users`, and creates append-only `audit_records`. It refuses to extend a user table that already contains accounts. The unused Laravel email-verification field and public password-reset token table remain excluded. The migrations contain no real personal data. The reviewed Local DEV sequence is:

```sh
php artisan migrate
php artisan migrate:rollback
php artisan migrate
```

The final command leaves the empty Local DEV schema migrated. `.env`, the database file, journals, and write-ahead-log files remain uncommitted local state.

Saffna data access must use Laravel migrations, Eloquent, query builder, and environment configuration without intentional SQLite-only coupling. Application-owned code must not use database triggers, stored procedures, raw vendor-specific SQL, database-specific functions, or vendor-specific schema types unless a later approved decision records the reason and impact. This structure gives another developer a clear path to adapt the application to another Laravel-supported database. MySQL conversion, operation, and compatibility testing are not Saffna deliverables.

## Approved Identity And Authorization Model

The identity schema extends Laravel's application-owned `User` model and migration rather than creating parallel user storage.

- Use Laravel's normal auto-incrementing integer identifiers. Authorization never treats an identifier as a secret.
- Keep the default identity fields `name`, unique `email`, hashed `password`, and Laravel's remember token. Email is the login identifier; there is no username field.
- The implemented Saffna account fields are one required `user_group_id` relationship, indexed account status, preferred language, optional non-unique phone, and `must_change_password`. A successful own-password change stores the new Laravel hash and clears `must_change_password` in one business-layer transaction.
- Account status has `active` and `disabled` values. Accounts are not hard-deleted.
- Migration-owned `user_groups` contains Super Admin, Admin user, Teacher, Parent, and Student. Each user has exactly one group. The permission matrix is implemented in application code, not in administrator-editable permission records.
- Parent/student and teacher/class relationships are deferred to the later owning modules. They are not part of the identity foundation.
- Append-only audit storage is implemented. Super Admin provisioning, own-password change, and failed authorization use it; later User Management services must add account creation and changes, group changes, disable/reactivate, and administrative password reset. Plaintext and hashed passwords are prohibited from audit data.
- Keep audit records indefinitely until a later retention rule is approved.
- Use the configured application/server timezone for stored timestamps. Local DEV uses `Asia/Amman`. User-facing timestamps display through minutes without seconds or milliseconds.

The first Local DEV Super Admin can be created once with `php artisan saffna:provision-super-admin`. It uses name `Saffna Super Admin` and unique email `support@hasanhalabi.com`; its generated temporary password is stored only as a Laravel hash and returned once. Stage SAFFNA-IDENTITY-ACCESS-LOCAL-SUPER-ADMIN-001-R2 created this account in the ignored Local DEV database without recording the password in repository or task systems.

This folder holds canonical entity/data definitions, data dictionary, ownership, sensitive-data classification, reviewed migration specifications, retention, backup/restore, compatibility, and recovery decisions. The runtime creates the empty identity schema and fixed reference groups. It creates no Saffna account, student data, or persistent Super Admin record by migration.

Before feature data or deployment stages, define the owning entity model, migration specification, remote database placement, backup/restore, and retention rules. Student and family data protection and relationships for classes, assignments, and messages remain later module decisions. Review every migration and query for accidental SQLite-only coupling. Database inspection or execution needs separately disclosed approval with an exact target and environment.
