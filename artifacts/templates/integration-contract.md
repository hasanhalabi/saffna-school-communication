# Saffna Integration Contract Template

Copy into `artifacts/integrations-inbound/` or `artifacts/integrations-outbound/`, then replace this H1 with the integration name. This structure is noncanonical until completed and approved.

**Status:** Draft  
**Direction:** Declare inbound or outbound from the Saffna platform boundary  
**Owner:** Name the accountable owner  
**Version:** Record an approved compatibility version  
**Last reviewed:** Record the review date  
**Approval/task:** Record the named stage and direct request or ClickUp task ID/link

## Purpose And Boundary

Identify Saffna, the consumer or provider, data owner, actors, outcome, and exact crossing direction. A browser-to-Laravel API request is inbound; an internal controller-to-business call is not an external integration.

## Environments And Endpoints

Describe Local DEV, Server DEV/Staging, and Live production separately. Record only approved endpoint names or public URLs. Never include credentials or private endpoint values.

## Authentication And Authorization

Specify mechanism, actor permissions, denial behavior, configuration key names, and approved secret-store ownership without secret values.

## Request Or Event

Specify trigger/method, schema, constraints, validation order, version, and redacted example.

## Response Or Result

Specify success shape, stable status/error codes, and redacted example.

## Reliability And Failure Behavior

Define timeouts, retries/backoff, idempotency/deduplication, ordering, limits, dependency failure, and recovery when applicable.

## Security, Privacy, And Observability

Define data classification, minimization, redaction, audit, logs/metrics, retention, and incident signals.

## Compatibility And Change Policy

Define backward compatibility, deprecation, rollout, rollback, and consumer notification.

## Acceptance Tests And Cross-Surface Impact

Cover success, validation failure, authorization failure, dependency failure, and duplicate/replay. Review business rules, data, security, Arabic/English UI, deployment, terminology, and possible mobile consumers.

## Related Artifacts And Provenance

Link the governing business rule, data model, security rule, ADR, owner statement, and task or stage approval. Separate dated observations and vendor claims from approved requirements.
