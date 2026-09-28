# Saffna Deployment And Operations

Keep `Local DEV`, `Server DEV/Staging`, and `Live production` distinct. The local repository is the only defined environment in the foundation. Hosting, server ownership, domains, release endpoint, observability, backup, restore, and rollback remain unresolved. No remote environment was accessed or changed in Stage SAFFNA-FND-001.

This folder owns approved environment configuration names, deployment and release procedure, QA evidence, monitoring, incidents, support, and recovery. It must not contain secret values. SQLite file placement and backup policy need explicit decisions before staging or production deployment. Running builds, tests, migrations, servers, or deployments requires a later named-stage action list.
