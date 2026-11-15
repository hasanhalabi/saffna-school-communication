# Saffna Deployment And Operations

Keep `Local DEV`, `Server DEV/Staging`, and `Live production` distinct. The local repository is the only defined environment in the foundation. Hosting, server ownership, domains, release endpoint, observability, backup, restore, and rollback remain unresolved. No remote environment was accessed or changed in Stage SAFFNA-FND-001 or Stage SAFFNA-FOUNDATION-DEFS-001.

Saffna must remain deployable to conventional low-cost shared PHP hosting when the selected host satisfies Laravel 12's runtime requirements, can point the public web root to Laravel's `public/` directory, permits writable Laravel storage, and supports the approved SQLite placement. Compile frontend assets locally before upload so Node.js is not required on the production server. This is a portability constraint, not approval of a host or deployment.

Use the configured application/server timezone rather than forcing UTC. Local DEV uses `Asia/Amman`; each future remote environment must explicitly match its intended server timezone before use. User-facing dates and times stop at minute precision.

This folder owns approved environment configuration names, deployment and release procedure, QA evidence, monitoring, incidents, support, and recovery. It must not contain secret values. SQLite file placement and backup policy need explicit decisions before staging or production deployment. Running builds, tests, migrations, servers, or deployments requires a later named-stage action list.
