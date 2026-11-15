# Saffna ClickUp Task Management

**Status:** Active task-governance rule with dated list observation  
**Owner:** Hasan, requesting product owner  
**Last reviewed:** 2026-11-15
**Approval/task:** Direct request; Stage SAFFNA-FND-001 approved read-only list inspection; Stage SAFFNA-CLICKUP-001 approved local MCP routing; ClickUp task `z8uq9mfg33`; Stage SAFFNA-GOV-CHAT-TASK-001-R1; ClickUp task `z8uq9mfgpc`; Stage SAFFNA-CLICKUP-GITHUB-MIRROR-001-R1

## Configured Source Of Truth

The [Saffna list](https://app.clickup.com/3668514/v/li/901821841766) in workspace `3668514` is the task source of truth for the current web application, its API and database work, documentation, and later release work unless the product owner maps a workstream elsewhere. Do not create local TODO, backlog, sprint, or follow-up artifacts. Stage SAFFNA-FND-001 is a direct request; no task ID was provided, so no task closeout comment is due for this stage.

[GitHub Issues](https://github.com/hasanhalabi/saffna-school-communication/issues) are a public, one-way mirror for course viewers who cannot access ClickUp. They do not become a second backlog, an approval source, or a source of task truth. The complete mapping and failure rules are in `clickup-github-issues-mirror.md`.

Every Codex chat that performs Saffna project work must resolve and link one primary task in this list before the implementation handshake. Multiple chats may reuse the same task when they serve the same outcome. A direct-answer chat that only provides information and makes no project change or implementation deliverable is exempt; if its scope becomes work, resolve its task before implementation planning continues.

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
- At the first ClickUp operation in a conversation, use `whoami` to confirm workspace **Eyadaty (`3668514`)** and the **core** profile. Scope work to the Saffna list `901821841766`; use `tree` if its identity needs resolving and `meta(scope: 901821841766)` for current statuses and accepted values. Startup Task Resolution supplies standing owner authorization for these bounded operations. The dated status observation above is not authoritative for later operations. Reuse verified identity unless the connection changes.
- Use `find` for scoped searches and duplicate checks, `task` for task details, and `comment` for authorized comments. Include closed tasks and relevant subtasks when checking duplicates; incomplete search coverage does not prove that no matching task exists. Use `create`, `update`, and other local tools only within approved task-mutation scope, then verify the resulting task.
- For an explicitly approved merge, use `merge` preview first, inspect its preservation notices, then execute with the returned `preview_token` and the same target and source IDs. Never retry an uncertain merge automatically or add a separate delete as cleanup.
- For an approved attachment, stage only the intended file under `/Users/hasanhalabi/.local/share/clickup-mcp-core/uploads` when the stage also approves that outside-workspace file action. Use `attach`, verify the upload, then remove the temporary copy within that same approved scope.
- Keep task and comment references as ordinary HTTPS Markdown links, such as `https://app.clickup.com/t/<task_id>`; preserve comment paths, query strings, and fragments. Do not convert them to `clickup://` links.
- If the local MCP or a required action is unavailable or fails, report the specific limitation and preserve completed work; do not switch connectors. For a failed comment, provide the exact intended comment and target task ID/link in a copy-ready block under the closeout rules below.
- This routing rule grants no additional task permissions and does not replace stage approval, action disclosure, list restrictions, or closeout requirements. The token can access other lists; these workspace limits are operating rules, not an API permission boundary.

## Authority And Task Rules

- Startup Task Resolution has standing owner authorization under the bounded workflow below, including creation or repair of only the resolved primary task's GitHub Issue and mirroring of its linkage comment. It does not require a preliminary stage approval and is not itself implementation approval.
- Outside Startup Task Resolution, read/search the configured list or a referenced task only when the action is disclosed for the stage; always use `clickup_local_core` under the routing rule above.
- Outside Startup Task Resolution, comments, task creation, and changes to status, description, dates, assignees, priority, tags, relationships, or fields require explicit named-stage scope. Each authorized ClickUp mutation must disclose and complete its companion GitHub Issue mirror in the same session. A task-backed stage must include the required closeout comment, its mirror, and the full closeout bundle in its approved actions.
- Before any task creation, search for a matching existing task. Use outcome-oriented titles, such as `[Web] Result`.
- Durable business rules live in canonical artifacts; ClickUp tasks link to them. Do not treat a task status, custom field, or assignee as stage approval or confidence evidence by itself.
- Do not infer that the four product modules each need a new task. Outside the conditional single creation allowed by Startup Task Resolution, task creation needs a separate approved action.

## Startup Task Resolution

At the start of each work chat, perform this sequence without requesting a separate preliminary approval:

1. Run `whoami` and confirm the `core` profile and Eyadaty workspace `3668514`. Read current list metadata when needed.
2. Search only list `901821841766`. Include closed tasks and relevant subtasks, and obtain enough coverage to support a duplicate decision. Read likely task details and comments when titles alone are insufficient.
3. Reuse one clear matching task. Multiple Codex chats may link to it when they concern the same outcome.
4. When complete search coverage finds no match, create exactly one task in the configured list. Give it an outcome-oriented title and a description containing the objective, scope, acceptance criteria, dependencies, and a proportionate automated-testing and validation strategy. Leave assignees, dates, priority, tags, relationships, custom fields, and status at their defaults unless a named stage separately authorizes them.
5. Link the current Codex chat by adding the task ID to its title and posting one short task comment containing the chat title and the pending or approved stage ID when known. Do not create a public share URL merely to establish linkage.
6. Search all open and closed Issues in `hasanhalabi/saffna-school-communication` for the task's stable hidden marker. Create the issue when absent, repair it when present, and mirror the linkage comment by its comment marker. Never match by title alone.
7. Verify the ClickUp task, linkage comment, GitHub Issue, and mirrored comment, then include the exact task ID and ordinary HTTPS task link in the single implementation handshake.

If multiple candidates could reasonably match, do not create another task. Ask one focused question only when the correct match cannot be determined from current evidence. If the local MCP or GitHub connector fails, report the failure and do not change connectors. This standing workflow authorizes no implementation, task-status change, additional comment, or unrelated mutation.

## GitHub Issues Mirror

- Mirror only ClickUp list `901821841766` into repository `hasanhalabi/saffna-school-communication`.
- Perform no scheduled polling and expose no ClickUp API token or repository secret. Codex mirrors the exact change immediately after it makes an authorized ClickUp change.
- The GitHub Issue body is generated from ClickUp and carries the hidden task marker defined in `clickup-github-issues-mirror.md`. Mirrored comments carry stable comment markers. Preserve GitHub-only comments and never copy them back to ClickUp.
- A ClickUp subtask is its own GitHub Issue. Represent parent and child relationships with ordinary GitHub Issue links rather than relying on a separate GitHub planning hierarchy.
- Map `complete` to a closed Issue and every other configured ClickUp status to an open Issue. An approved ClickUp deletion closes the Issue as not planned; it does not delete public history.
- Replace private ClickUp task or comment URLs with the explicit text `[private ClickUp link omitted]` while retaining the public task ID for traceability.
- Skip a task or comment carrying the exact `github-mirror:exclude` marker. Stop before publishing any credential, private endpoint, real student data, or other content that violates repository rules.
- A successful ClickUp write followed by a failed GitHub write is a partial result. Preserve it, report both systems' exact state, and repair only after authority is clear. Never silently retry an uncertain GitHub creation or comment.

## Task Scope And Testing Strategy

When creating or materially refining a task, plan validation at the same time as scope. The task must state which checks Codex will perform and why they fit the work. Possible checks include unit, feature, integration, browser/end-to-end, responsive, accessibility, localization, security, regression, data, and documentation validation; do not require irrelevant test types merely to fill a list.

Browser automation is required when browser or UI behavior is in scope and the needed browser access is available. Documentation-only work uses proportionate document, syntax, and consistency checks instead. Tests and browser execution remain implementation actions and must appear in the named-stage handshake even though writing the strategy is part of task setup.

## Task-Backed Stage Start And Closeout

For a task-backed stage, use Startup Task Resolution first, then identify the exact task ID/link in the single implementation handshake. Read its current description, comments, status, and relevant fields during resolution or under disclosed stage scope. Resolve conflicts with canonical artifacts before implementation. Obtain at least 95/100 confidence and explicit named-stage approval. Change fields only when the standing workflow or exact named-stage scope authorizes that mutation.

Before declaring a task-backed stage complete, add the approved task comment with: stage ID; implemented behavior/files/artifacts; validation and results; unvalidated limits; deployment/data effects; and follow-up decisions. Mirror that comment to the task's GitHub Issue before continuing. If either comment fails, stop connector attempts, provide copy-ready text in chat, and state that task-backed closeout remains incomplete.

The implementation handshake should normally pre-authorize the closeout comment and GitHub mirror, status change to the list's current closed status and matching GitHub Issue closure, Git staging of only the approved files, a commit containing the task ID, and a non-force push to an exact branch and remote. When Hasan later explicitly requests task closure and no material scope change occurred, execute that approved bundle without another handshake in this order: post the ClickUp closeout comment; mirror it to GitHub; set the task to the closed status; close the GitHub Issue; stage and commit only approved files; and push the approved branch. If a step fails, report the exact completed and incomplete state and do not silently retry an uncertain remote operation.
