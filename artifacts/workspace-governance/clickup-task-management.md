# Saffna ClickUp Task Management

**Status:** Active task-governance rule with dated list observation  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-09-28  
**Approval/task:** Direct request; Stage SAFFNA-FND-001 approved read-only list inspection; Stage SAFFNA-CLICKUP-001 approved local MCP routing

## Configured Source Of Truth

The [Saffna list](https://app.clickup.com/3668514/v/li/901821841766) in workspace `3668514` is the task source of truth for the current web application, its API and database work, documentation, and later release work unless the product owner maps a workstream elsewhere. Do not create local TODO, backlog, sprint, or follow-up artifacts. Stage SAFFNA-FND-001 is a direct request; no task ID was provided, so no task closeout comment is due for this stage.

## Dated Read-Only Observation

The connected ClickUp capability returned on 2026-09-28: list ID `901821841766`, name `Saffna`, parent space `Eyadaty` (space ID `5931145`), statuses below, and no list-level custom fields. The list-detail response did not identify a parent folder. This is an observation of current remote state, not approval of a product rule or a permanent schema. The supplied URL and returned URL differ in route form but point to the same workspace/list IDs.

| Observed status | ClickUp type | Execution meaning only |
| --- | --- | --- |
| `to do` | open | Not yet in execution |
| `scope defined` | custom | Scope is prepared; stage approval remains separate |
| `in progress` | custom | Work is underway; stage approval remains separate |
| `complete` | closed | Execution marked complete; closeout evidence remains separate |

Do not rename or change statuses to enforce this interpretation. Confirm the list's space placement with the product owner if a later task stage depends on organizational ownership.

## Local ClickUp MCP Routing

- In local Codex, use only the existing **`clickup_local_core`** MCP server (`mcp__clickup_local_core__` tools) for all ClickUp reads, searches, comments, and authorized mutations concerning Saffna. This rule takes precedence over older generic ClickUp plugin or connector references in workspace guidance.
- Do not use the Official ClickUp Plugin, hosted ClickUp MCP, or `mcp__codex_apps__clickup_*` tools. Do not fall back to Computer Use, browser or desktop automation, raw API calls, `curl`, or a separate ClickUp CLI. The local MCP itself communicates with ClickUp's normal REST API.
- Reuse the user-level registration in `~/.codex/config.toml`, the installation at `/Users/hasanhalabi/dev/clickup-mcp-server`, and the Keychain-backed launcher at `/Users/hasanhalabi/.local/share/clickup-mcp-core/launch.py`. Do not add a duplicate workspace server or copy credentials into repository files, `.env`, task text, logs, or chat.
- At the first approved ClickUp operation in a conversation, use `whoami` to confirm workspace **Eyadaty (`3668514`)** and the **core** profile. Scope work to the Saffna list `901821841766`; use `tree` if its identity needs resolving and `meta(scope: 901821841766)` for current statuses, assignees, and accepted values. The dated status observation above is not authoritative for later operations. Reuse verified identity unless the connection changes.
- Use `find` for scoped searches and duplicate checks, `task` for task details, and `comment` for authorized comments. Include closed tasks and relevant subtasks when checking duplicates; incomplete search coverage does not prove that no matching task exists. Use `create`, `update`, and other local tools only within approved task-mutation scope, then verify the resulting task.
- For an explicitly approved merge, use `merge` preview first, inspect its preservation notices, then execute with the returned `preview_token` and the same target and source IDs. Never retry an uncertain merge automatically or add a separate delete as cleanup.
- For an approved attachment, stage only the intended file under `/Users/hasanhalabi/.local/share/clickup-mcp-core/uploads` when the stage also approves that outside-workspace file action. Use `attach`, verify the upload, then remove the temporary copy within that same approved scope.
- Keep task and comment references as ordinary HTTPS Markdown links, such as `https://app.clickup.com/t/<task_id>`; preserve comment paths, query strings, and fragments. Do not convert them to `clickup://` links.
- If the local MCP or a required action is unavailable or fails, report the specific limitation and preserve completed work; do not switch connectors. For a failed comment, provide the exact intended comment and target task ID/link in a copy-ready block under the closeout rules below.
- This routing rule grants no additional task permissions and does not replace stage approval, action disclosure, list restrictions, or closeout requirements. The token can access other lists; these workspace limits are operating rules, not an API permission boundary.

## Authority And Task Rules

- Read/search the configured list or a referenced task only when the action is disclosed for the stage; use `clickup_local_core` under the routing rule above.
- Comments, task creation, and changes to status, description, dates, assignees, priority, tags, relationships, or fields require explicit named-stage scope. A task-backed stage must include the required closeout comment in its approved actions.
- Before approved task creation, search for a matching existing task. Use outcome-oriented titles, such as `[Web] Result`.
- Durable business rules live in canonical artifacts; ClickUp tasks link to them. Do not treat a task status, custom field, or assignee as stage approval or confidence evidence by itself.
- Do not infer that the four product modules each need a new task. Task creation needs a separate approved action.

## Task-Backed Stage Start And Closeout

For a task-backed stage, identify the exact task ID/link in the handshake. Read its current description, comments, status, and relevant fields through `clickup_local_core` after disclosed approval. Resolve conflicts with canonical artifacts before implementation. Obtain at least 95/100 confidence and explicit named-stage approval. Change fields only if that exact mutation is approved.

Before declaring a task-backed stage complete, add the approved task comment with: stage ID; implemented behavior/files/artifacts; validation and results; unvalidated limits; deployment/data effects; and follow-up decisions. If the comment fails, stop connector attempts, provide copy-ready text in chat, and state that task-backed closeout remains incomplete.
