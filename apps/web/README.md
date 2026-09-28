# Saffna Web Application

This path is reserved for Saffna's only current deployable: a Laravel 12 web application. No Laravel source has been generated yet. The application will own its HTTP API, PHP business and persistence classes, native JavaScript Web Components, and SQLite database connection.

The planned internal separation is `app/Business/` for business and persistence classes, `app/Http/Controllers/Api/` for API transport, and `resources/js/components/` for Web Components. These are intended runtime paths, not directories created by the foundation. Project-authored PHP class and JavaScript component filenames will start with `Saffna`; Laravel-required filenames retain framework names. The API layer calls business classes, and Web Components call the API. Web Components never connect directly to SQLite.

Source strategy is greenfield. This path is one deployable boundary, not three independent services. Framework installation, exact dependencies, API contracts, authentication implementation, schema, and migrations require later approved stages.

Read the [project profile](../../artifacts/workspace-governance/project-profile.yaml), [architecture decision](../../artifacts/architecture-decisions/saffna-application-architecture.md), [business baseline](../../artifacts/business-rules-requirements/saffna-platform-baseline.md), [web interface baseline](../../artifacts/design-language/web-app/saffna-interface-baseline.md), and [security baseline](../../artifacts/security/saffna-access-baseline.md) before implementation. Cross-surface rules remain in those artifacts rather than this README.
