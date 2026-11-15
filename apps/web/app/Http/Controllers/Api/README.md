# Saffna API Controllers

This area owns HTTP transport for approved protected Saffna API operations. Controllers validate transport input, authenticate and authorize requests, call the business layer, and format responses. They do not own business rules, transactions, or persistence.

Read the [application architecture](../../../../../../artifacts/architecture-decisions/saffna-application-architecture.md), [inbound API contract](../../../../../../artifacts/integrations-inbound/README.md), and [security baseline](../../../../../../artifacts/security/saffna-access-baseline.md) before adding an endpoint.
