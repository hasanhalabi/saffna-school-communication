# Saffna Business Rule Template

Copy into `artifacts/business-rules-requirements/` and replace this H1 with the capability name. This structure is noncanonical until completed and approved.

**Status:** Draft  
**Owner:** Name the Saffna product owner for this rule  
**Last reviewed:** Record the review date  
**Approval/task:** Record the named stage and direct request or ClickUp task ID/link

## Purpose And Scope

Describe the school communication outcome. State included and excluded actors, data, and workflows without inferring behavior from a module name.

## Actors And Terms

Link to `artifacts/workspace-governance/platform-definitions-and-terminology.md`. Define only new terms proposed for same-stage promotion.

## Business Rules And Requirements

Use stable `BR-SAFFNA-001` and `REQ-SAFFNA-001` style IDs, advancing numbers without reuse. Write testable statements with actor, condition, action, and expected effect.

## States And Transitions

Record allowed states, actor, preconditions, effects, and rejected transitions, or explain why state is not applicable.

## Validation, Failures, And Recovery

Define input constraints, validation order, denial behavior, user-facing outcome, retry/idempotency where relevant, and recovery.

## Acceptance Criteria

Use stable `AC-SAFFNA-001` style IDs. For each case, state given context, action, and observable outcome. Include success, rejection, edge, and Arabic/English UX cases when relevant.

## Cross-Surface Impact

| Surface | Impact | Governing artifact or follow-up |
| --- | --- | --- |
| Laravel web/API/business layer | Explain | Link |
| SQLite/data | Explain | Link |
| Security/privacy | Explain | Link |
| Design/localization/accessibility | Explain | Link |
| Operations and possible mobile | Explain | Link |

## Evidence And Source Classification

Record approved decisions, dated observations, vendor claims, assumptions, open decisions, and the exact stage/task provenance separately.

## Related Artifacts And Change History

Link the API, data, design, security, and architecture artifacts. Record each approved change date, summary, and approval source.
