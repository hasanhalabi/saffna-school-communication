# Saffna Workspace Instructions

> APPROVAL STOP RULE: A request to fix, change, or finish work is not stage approval. Before any file edit (including this file), write command, test, build, application execution, or other non-authoring action outside the standing discovery allowances below, send the complete five-item handshake in a final response and end that turn. A later user message must explicitly approve the named stage. Check that approval covers each action. Generic assent, tool access, and task status do not count. Read-only local inspection that does not run application behavior and the bounded Startup Task Resolution workflow are standing discovery allowances; neither is stage approval.

## Scope And Runtime Layout

Saffna is a school communication platform. The only planned deployable is one Laravel 12 web application at `apps/web/`. Its future PHP business classes, HTTP API layer, and JavaScript Web Components have separate folders inside that application. SQLite is the planned application database. A mobile application is only a possible later surface; do not create it speculatively. Read `artifacts/README.md` and `artifacts/workspace-governance/project-profile.yaml` before planning work.

## Mandatory Stage Approval

- Require at least 95/100 evidence-based confidence for a named stage. Confidence is not approval.
- The initial request is not stage approval. For project work, first complete the standing Startup Task Resolution workflow so the exact ClickUp task is known. Then send one final response containing all five items: (1) stage summary with outcome, files, exclusions, sources, and validation; (2) assumptions and open questions; (3) the six-part confidence score and deductions; (4) every planned file change and every non-authoring action with target, environment, read/write effect, and side effects, including the normal closeout bundle; and (5) `Please confirm: proceed with implementation for Stage <ID>.` End the turn after that response.
- Begin only after a later user message names and approves that stage. Quote the actual approval in commentary before the first implementation action. Before each implementation action, check that the approval covers its files, target, environment, and validation.
- Do not require a preliminary approval merely to read local project files or resolve and link the chat's ClickUp task under the standing allowances. These actions gather the evidence needed for the single implementation handshake; they do not authorize implementation.
- If scope changes materially, issue a revised handshake and obtain a new named-stage approval. After a resume, handoff, context compaction, or model change, re-establish approval evidence before continuing.
- If work starts or exceeds scope without valid approval, stop, disclose known effects, preserve existing work, and request a corrective stage. Do not silently repair or revert.

The full rule and scoring rubric are in `artifacts/workspace-governance/stage-approval-and-confidence.md`.

## Workspace And External Actions

Workspace file authoring is limited to the approved stage. Read-only local inspection is allowed before the handshake when it does not run application behavior. The bounded Startup Task Resolution actions in the Task Tracking section have standing owner authorization and may use the required ClickUp and Codex tools before the handshake. Disclose and obtain named-stage approval before database access, other remote access, browser/UI automation, network/API calls, downloads, package changes, tests, builds, formatters, scripts, migrations, servers, deployments, write-capable Git actions, other ClickUp mutations, or writes outside the workspace. A connected tool or credential grants no authority beyond these explicit allowances. Keep secrets out of files and tool output.

## Scope Changes And Closeout

Review changed rules across the web application, data, API contracts, security, localization, deployment, and future mobile implications. Update canonical artifacts in the same approved stage as the governed behavior. Close with changed files, validation evidence and limits, remote/data effects, open decisions, Git state, and any approved task comment. Do not create a local backlog.

## Sources Of Truth

- Current product behavior: `artifacts/business-rules-requirements/`.
- Durable technical decisions: `artifacts/architecture-decisions/`.
- Data ownership and migration specifications: `artifacts/database/`.
- UI and language rules: `artifacts/design-language/`.
- API direction and contracts: `artifacts/integrations-inbound/` and `artifacts/integrations-outbound/`.
- Security, environments, and task rules: their corresponding artifact folders.
- ClickUp list `901821841766` is the configured task source of truth; task status never substitutes for approval.

Read `artifacts/README.md` before creating or moving artifacts. Raw product-owner inputs and archives are not active rules.

## Documentation And Runtime Linkage

Runtime code belongs only in its owning deployable. Runtime READMEs navigate; canonical cross-surface rules live in `artifacts/`. Reference governing artifacts from new feature entrypoints. Do not duplicate active business rules in API, UI, or data documents. Project-authored PHP class and JavaScript component filenames use a `Saffna` prefix; framework-required filenames keep their required names.

## Cross-Surface Impact Review

For each requirement change, check the web runtime; SQLite data and migrations; inbound/outbound integration contracts; security, privacy, and permissions; environments and operations; Arabic/English UI, accessibility, and copy; terminology; and the possible future mobile consumer. Report impacts outside the stage rather than implementing them silently.

## Environments And Secrets

Use distinct `Local DEV`, `Server DEV/Staging`, and `Live production` environments. Remote targets remain unresolved until approved. Never store passwords, tokens, purchase codes, signing material, private endpoints, or student data samples in the repository. Record configuration names and secret-store ownership only after they are decided.

## Selected Technology Rules

Use Laravel 12 for the single web application, SQLite for its planned data store, and native JavaScript Web Components for the frontend. Use Bootstrap 5 as the UI library and locally hosted Font Awesome Free icons. Do not introduce other frontend libraries or a CDN for the icons without a new approved decision. Separate business/persistence classes from API transport code. Arabic is primary and RTL; English is LTR. Framework installation and exact package versions require a later stage.

## Task Tracking

Follow `artifacts/workspace-governance/clickup-task-management.md`. Startup Task Resolution is the only standing ClickUp exception; all other ClickUp access and task changes must be disclosed in the applicable stage. Create no local TODO, backlog, sprint, or task queue artifacts. A task-backed stage requires its approved closeout comment before completion.

### Chat Startup And Task Resolution

- At the start of a chat, classify it as a direct-answer chat or a work chat. A direct-answer chat only answers an informational question and makes no project change or implementation deliverable; it does not need a ClickUp task. If its scope becomes project work, run Startup Task Resolution before planning implementation.
- Every work chat must be linked to one primary task in the Saffna ClickUp list. Multiple chats may reuse the same task when they concern the same outcome.
- Startup Task Resolution has standing owner authorization and needs no preliminary stage approval. It is limited to: confirming ClickUp identity and current list metadata; searching and reading the configured list, including closed tasks, subtasks, likely task details, and comments; selecting one clear match; or creating exactly one task when complete search coverage finds no match; renaming the current Codex chat to include the task ID; posting one short linkage comment; and verifying the result.
- A created task must have an outcome-oriented title and a description containing the objective, scope, acceptance criteria, relevant dependencies, and an appropriate automated-testing and validation strategy. Do not assign it, set dates, or change unrelated fields unless separately authorized.
- If multiple tasks could reasonably match, do not create a duplicate. Ask one short question only when the correct task cannot be determined from available evidence.
- After resolution, identify the exact task ID and HTTPS link in the single implementation handshake. Task resolution and task status never substitute for named-stage approval.

### Testing And Closeout Workflow

- Plan validation while writing or refining the task. Select only relevant test types, which may include unit, feature, integration, browser/end-to-end, responsive, accessibility, localization, security, and regression checks. Codex performs the approved checks. Browser automation is required when browser or UI behavior is in scope and the needed browser access is available; it is not required for documentation-only work.
- The implementation-stage handshake must normally disclose the complete closeout bundle: the ClickUp closeout comment, status change to the list's closed status, staging only approved files, the commit target and message convention, and the non-force push target. This avoids a second approval at closure.
- When Hasan explicitly asks to close the task, execute the already approved closeout bundle immediately after required validation: post the closeout comment, set the task to the closed status, commit only the approved task files with the task ID in the commit message, and push the approved branch. Do not request another approval when the active named stage already covers these exact actions and no material scope change occurred.
- Never include unrelated working-tree changes, force-push, invent a remote or branch, or close a task when required validation or the closeout comment is incomplete. If any closeout step fails, stop, report the exact completed and incomplete state, and do not silently retry an uncertain remote mutation.

- In local Codex, use only the existing **`clickup_local_core`** MCP server (`mcp__clickup_local_core__` tools) for all Saffna ClickUp reads, searches, comments, and authorized mutations. This routing rule takes precedence over generic ClickUp plugin or connector references.
- Do not use the Official ClickUp Plugin, hosted ClickUp MCP, or `mcp__codex_apps__clickup_*` tools. Do not fall back to Computer Use, browser or desktop automation, raw API calls, `curl`, or a separate ClickUp CLI. The local MCP itself communicates with ClickUp's normal REST API.
- Reuse the user-level registration in `~/.codex/config.toml`, the installation at `/Users/hasanhalabi/dev/clickup-mcp-server`, and the Keychain-backed launcher at `/Users/hasanhalabi/.local/share/clickup-mcp-core/launch.py`. Do not register a duplicate workspace server or copy credentials into repository files, `.env`, task text, logs, or chat.
- At the first ClickUp operation in a conversation, use `whoami` to confirm workspace **Eyadaty (`3668514`)** and the **core** profile; scope Saffna work to list `901821841766`. Startup Task Resolution supplies standing authorization only for its bounded actions. Follow the operation and failure rules in the task-management artifact; all other actions still require named-stage scope.

## Terminology Library (Mandatory)

`artifacts/workspace-governance/platform-definitions-and-terminology.md` is the single canonical terminology library. Read it before creating, updating, reviewing, or referencing governed product, technical, environment, API, task, or delivery terms. Update it in the same approved stage as any new, changed, renamed, or clarified concept, along with affected canonical artifacts. Do not invent competing synonyms. Preserve compatibility-sensitive technical identifiers when documented.

## Codex Response Language (Mandatory)

Always reply in English, including when Hasan writes or dictates in Arabic or mixed Arabic and English. Use simple, direct English and explain technical terms when useful. An approved deliverable may retain its required Arabic or bilingual content.
