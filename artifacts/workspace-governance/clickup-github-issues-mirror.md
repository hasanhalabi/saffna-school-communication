# Saffna ClickUp To GitHub Issues Mirror

**Status:** Active workspace-governance rule

**Owner:** Hasan, requesting product owner

**Last reviewed:** 2026-11-15

**Approval/task:** ClickUp task `z8uq9mfgpc`; Stage SAFFNA-CLICKUP-GITHUB-MIRROR-001-R1

## Purpose And Authority

The Saffna ClickUp list `901821841766` is the only task source of truth. GitHub Issues in `hasanhalabi/saffna-school-communication` are a public, derived view for course viewers who cannot access ClickUp. A GitHub Issue, comment, label, or state never approves a stage, changes a ClickUp task, creates a second backlog, or becomes a product requirement.

The mirror is one way: ClickUp to GitHub. Codex performs the mirror in the same working session immediately after it creates or changes an authorized ClickUp task, subtask, description, status, relationship, or comment. There is no scheduled polling, manual synchronization run, GitHub Actions workflow, ClickUp API token, repository secret, raw API integration, or Saffna runtime integration.

## Authorization Boundary

Startup Task Resolution has standing authorization to create or repair only the resolved primary task's GitHub Issue and to mirror its single linkage comment. This narrow companion action does not authorize implementation, a ClickUp status change, another comment, another task, or unrelated GitHub work.

Outside Startup Task Resolution, the named stage must authorize the ClickUp mutation and disclose the matching GitHub Issue write. Approval of the mirror never supplies missing approval for the ClickUp action. After a successful ClickUp write, the mirror must finish before Codex treats that operation as complete.

Use only the existing local `clickup_local_core` MCP for ClickUp and the connected GitHub Issue tools for GitHub. Do not copy the Keychain credential, create a repository secret, introduce another ClickUp connector, use browser automation, or fall back to raw API calls.

## Mapping

| ClickUp source | GitHub representation |
| --- | --- |
| Task | One Issue |
| Subtask | One Issue with parent and child Issue links |
| Task name | Issue title |
| Task description | Generated section of the Issue body |
| Status `complete` | Closed Issue with completed reason |
| Any other configured status | Open Issue |
| Task comment | Issue comment with original author and ClickUp timestamp |
| Approved ClickUp deletion | Closed Issue with not-planned reason; retain public history |
| ClickUp task ID | Hidden stable Issue-body marker |
| ClickUp comment ID | Hidden stable Issue-comment marker |

Use these exact marker forms:

```text
<!-- saffna-clickup-task-id: TASK_ID -->
<!-- saffna-clickup-comment-id: COMMENT_ID -->
```

The generated Issue body starts with a plain warning that ClickUp is the source of truth and GitHub is a read-only public mirror. Show the ClickUp task ID for traceability, but do not require viewers to have ClickUp access and do not expose ClickUp credentials or private endpoints.

## Idempotency And GitHub-Only Content

Before creating an Issue, search open and closed Issues for the exact task marker. Never match by title alone. Zero matches permits creation. One match permits update. More than one match is an ambiguity: stop without choosing or deleting anything and report every duplicate.

Before adding a mirrored comment, read the Issue comments and match the exact comment marker. Zero matches permits creation. One match permits an update when the ClickUp comment text changed. More than one match is an ambiguity and must stop.

Generated titles, bodies, states, mirrored comments, and parent/child links follow ClickUp and may be repaired during the next authorized ClickUp change. Preserve GitHub-only discussion comments. Never copy GitHub-authored content to ClickUp.

## Privacy And Exclusions

The repository and its Issues are public. Before the initial backfill and before each mirror write, exclude content that would violate repository rules. Never publish passwords, tokens, private endpoints, signing material, purchase codes, real student or family data, or other private school information.

Private ClickUp task or comment URLs are always replaced with the explicit text `[private ClickUp link omitted]`; retain the public task ID for traceability. This standardized notice is not silent redaction and does not need a separate decision.

The exact marker `github-mirror:exclude` in a task or comment suppresses that item. A suppressed task has no public Issue. A suppressed comment is not copied. If content appears sensitive without an exclusion marker, stop before the GitHub write and request a decision; do not silently redact evidence or publish it.

## Initial Backfill

The approved initial backfill reads all tasks and subtasks in list `901821841766`, including completed work, and reads their comments. It performs the privacy check, creates or repairs one marker-bearing Issue per eligible item, adds marker-bearing comments, links parents and children, maps states, and then verifies every source item against GitHub.

The backfill uses the same mapping and failure rules as later same-session mirrors. It does not change ClickUp data.

## Failure And Recovery

Treat a successful ClickUp write followed by a failed GitHub write as a partial result. Preserve both systems, report the exact ClickUp task/comment and GitHub Issue/comment state, and do not retry an uncertain creation or update. A later authorized repair first searches by stable marker and continues only when the result is unambiguous.

If the local ClickUp MCP or connected GitHub Issue tools are unavailable, stop. Do not switch connectors, introduce credentials, use Computer Use, call a raw API, or claim the mirror succeeded.

## Validation And Cross-Surface Impact

For the initial backfill, verify every eligible task or subtask has exactly one Issue; every mirrored comment has at most one marker match; completed and active states map correctly; and parent/child links resolve. Re-read representative completed, active, parent, child, and commented items from both systems.

For later mutations, re-read the affected ClickUp task and GitHub Issue after the mirror write. Task closeout must mirror the closeout comment and close the Issue after ClickUp reaches `complete`.

This workflow changes workspace governance and public project visibility only. It does not change the Laravel application, SQLite data, inbound or outbound Saffna runtime contracts, security or permissions inside the product, environments, operations, Arabic/English UI, accessibility, or a possible future mobile client.
