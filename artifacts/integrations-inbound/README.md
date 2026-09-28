# Saffna Inbound Integration Contracts

An inbound interaction crosses from a browser or later external client into the Saffna platform boundary. The planned browser-to-Laravel HTTP API belongs here. No endpoint, schema, version, authentication method, error code, or external integration has been approved yet.

Create versioned contracts only when a feature stage defines consumers, payloads, validation, permissions, failures, compatibility, and acceptance tests. Keep business meaning in `artifacts/business-rules-requirements/` and data ownership in `artifacts/database/`. A possible future mobile application would be another consumer, not an existing runtime.
