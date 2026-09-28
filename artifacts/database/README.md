# Saffna Database Governance

SQLite is the selected data store for the planned single Laravel application. The Laravel application owns its connection and future executable migrations. PHP business classes are the intended direct database access layer; HTTP API controllers and Web Components do not query SQLite directly.

This folder will hold canonical entity/data definitions, data dictionary, ownership, sensitive-data classification, reviewed migration specifications, retention, backup/restore, compatibility, and recovery decisions. No schema, migration, database file, connection, query, or seed data was created in Stage SAFFNA-FND-001.

Before a database stage, decide entity identifiers and relationships for users, classes, assignments, and messages; authorization of reads/writes; student and family data protection; SQLite version and deployment storage; migration and rollback method; backup/restore; and environment separation. Database inspection or execution needs separately disclosed approval with an exact target and environment.
