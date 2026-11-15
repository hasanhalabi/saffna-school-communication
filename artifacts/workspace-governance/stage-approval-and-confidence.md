# Saffna Stage Approval And Confidence

**Status:** Active governance rule  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001; ClickUp task `z8uq9mfg33`; Stage SAFFNA-GOV-CHAT-TASK-001-R1

## Mandatory Gate

Before implementation, score the named stage at least 95/100 using evidence from owner statements, active canonical artifacts, the resolved ClickUp task, inspected code, or approved references. Confidence alone is not approval. A request to fix, change, or finish work is not stage approval. The initial request, generic assent, assistant plans, connected-tool access, sandbox approval, and ClickUp status are not approval, including for edits to `AGENTS.md`, tests, builds, and scripts.

For a work chat, complete the standing Startup Task Resolution workflow first. Then send one complete implementation handshake containing the exact task ID and HTTPS link, end that turn, and wait for a later user message that explicitly names and approves the stage. Quote that actual approval in commentary before the first implementation action. Before each implementation action—each file edit, write command, or non-authoring action outside the standing allowances—check that the approval covers the file, target, environment, validation, and side effects. A material change needs a revised handshake and new named-stage approval. After resume, handoff, context compaction, or model change, re-establish the task link and approval evidence without repeating verified discovery unless the connection or scope changed.

If work begins or exceeds scope without valid approval, stop further actions, disclose what changed and known effects, preserve the work, and request a corrective stage. Do not repair, revert, finish, commit, or test under retroactive approval.

## Standing Pre-Handshake Discovery

The product owner grants standing authorization for two bounded discovery activities before the implementation handshake:

1. Read-only local inspection of project files and Git state when it does not run application behavior or change local state.
2. Startup Task Resolution through the required local ClickUp MCP and Codex thread-title tool: confirm identity and list metadata; search and read only the configured Saffna list, including closed tasks, subtasks, candidate details, and comments; reuse one clear matching task or create exactly one task after complete search coverage finds none; rename the current chat to include the task ID; post one short linkage comment; and verify the result.

A newly created task must contain the objective, scope, acceptance criteria, relevant dependencies, and a proportionate automated-testing and validation strategy. Do not assign it, set dates, change status, edit unrelated fields, or perform any other mutation under this allowance. If candidate tasks are ambiguous, stop and ask one focused question instead of creating a duplicate.

These allowances remove the preliminary discovery-approval round trip. They are not implementation authority, do not lower the 95/100 confidence gate, and do not authorize application execution, tests, builds, browser automation, database access, other network access, Git writes, or other ClickUp mutations. A direct-answer chat that makes no project change or implementation deliverable does not need a task. If it becomes work, resolve its task before the implementation handshake.

## Confidence Rubric

| Dimension | Maximum | Evidence to assess |
| --- | ---: | --- |
| Outcome and scope | 25 | Result, boundaries, files and surfaces |
| Business rules and terminology | 20 | Canonical meaning and actor/rule clarity |
| Acceptance criteria | 20 | Observable success, failure, edge, and UX outcomes relevant to the stage |
| Dependencies and impact | 15 | Runtime, data, integration, and follow-up impacts |
| Environment, security, and data | 10 | Target, permissions, secrets, privacy, and migrations |
| Validation and rollback | 10 | Approved checks, limits, and recovery |

List deductions. A 95–99 score may keep only nonblocking assumptions that cannot materially change the stage outcome. Unresolved product workflows may be recorded in a documentation-only foundation but block their implementation stages.

## Five-Item Final-Response Handshake

Include all five items together in the final response, then end the turn:

1. **Stage summary:** Stage `<ID>`, exact ClickUp task ID and HTTPS link for project work, outcome, affected files or bounded areas, exclusions, sources of truth, and planned validation.
2. **Assumptions and open questions:** Facts inferred and unresolved choices.
3. **Confidence:** `<score>/100`, with Outcome and scope `<x>/25`, Business rules and terminology `<x>/20`, Acceptance criteria `<x>/20`, Dependencies and impact `<x>/15`, Environment, security, and data `<x>/10`, Validation and rollback `<x>/10`, and deductions.
4. **Planned actions:** List every file change and each non-authoring action. For each non-authoring action, name the exact action, target system and environment, purpose, read/write effect, and expected side effects. Normally include the complete task closeout bundle—comment, closed-status update, approved-file Git staging and commit, and non-force push target—so an explicit later close request needs no second approval. If none, say `No non-authoring actions planned.`
5. **Exact approval request:** `Please confirm: proceed with implementation for Stage <ID>.`

Do not start implementation in the handshake turn. The later user message must name the pending stage ID. A revised handshake needs a new ID or revision label.

## Action Boundary

After approval, workspace authoring is limited to the named files and bounded areas. Read-only local inspection and Startup Task Resolution are permitted before approval only within the standing boundaries above. Disclose and obtain approval for database access; other remote/server access; browser/UI automation; other network/API calls; downloads or package changes; tests, builds, formatters, scripts, migrations, servers, or application execution; deployment or publishing; write-capable Git/GitHub actions; other ClickUp mutations; destructive operations; or writes outside the workspace. Availability of credentials or tools is not authorization beyond an explicit standing allowance or approved stage.

## Closeout And Cross-Surface Review

Report changed files, canonical artifact updates, validation and limits, remote/data effects, follow-up decisions, Git state, and task-comment status. Every changed rule must review the web runtime, data/migrations, inbound/outbound contracts, security/privacy/permissions, environments/operations, UI/localization/accessibility, terminology, and possible future mobile effects. A task-backed stage needs its approved closeout comment before being declared complete.

When the handshake already approved the closeout bundle and Hasan explicitly asks to close the task, act without another approval after required validation: post the closeout comment, set the task to the configured closed status, stage and commit only approved files with the task ID in the commit message, and non-force push the approved branch. Stop and report the exact state if any step fails. Never include unrelated changes or treat the close request as authority for new scope.
