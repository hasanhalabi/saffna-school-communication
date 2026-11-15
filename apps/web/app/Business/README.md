# Saffna Business Layer

This area owns project business rules, transactions, and Laravel-managed persistence. Project-authored PHP class filenames start with `Saffna`.

API controllers may call this layer. Business classes must not depend on controllers or browser code. Read the [application architecture](../../../../artifacts/architecture-decisions/saffna-application-architecture.md), [database governance](../../../../artifacts/database/README.md), and [business baseline](../../../../artifacts/business-rules-requirements/saffna-platform-baseline.md) before adding behavior.
