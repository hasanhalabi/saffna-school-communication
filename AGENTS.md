# Saffna Workspace Instructions

> APPROVAL STOP RULE: A request to fix, change, or finish work is not stage approval. Before any file edit (including this file), write command, test, build, or other non-authoring action, send the complete five-item handshake in a final response and end that turn. A later user message must explicitly approve the named stage. Check that approval covers each action. Generic assent, tool access, and task status do not count.

## Scope And Runtime Layout

Saffna is a school communication platform. The only planned deployable is one Laravel 12 web application at `apps/web/`. Its future PHP business classes, HTTP API layer, and JavaScript Web Components have separate folders inside that application. SQLite is the planned application database. A mobile application is only a possible later surface; do not create it speculatively. Read `artifacts/README.md` and `artifacts/workspace-governance/project-profile.yaml` before planning work.

## Mandatory Stage Approval

- Require at least 95/100 evidence-based confidence for a named stage. Confidence is not approval.
- The initial request is not stage approval. Send a final response containing all five items: (1) stage summary with outcome, files, exclusions, sources, and validation; (2) assumptions and open questions; (3) the six-part confidence score and deductions; (4) every planned file change and every non-authoring action with target, environment, read/write effect, and side effects; and (5) `Please confirm: proceed with implementation for Stage <ID>.` End the turn after that response.
- Begin only after a later user message names and approves that stage. Quote the actual approval in commentary before the first implementation action. Before each implementation action, check that the approval covers its files, target, environment, and validation.
- If scope changes materially, issue a revised handshake and obtain a new named-stage approval. After a resume, handoff, context compaction, or model change, re-establish approval evidence before continuing.
- If work starts or exceeds scope without valid approval, stop, disclose known effects, preserve existing work, and request a corrective stage. Do not silently repair or revert.

The full rule and scoring rubric are in `artifacts/workspace-governance/stage-approval-and-confidence.md`.

## Workspace And External Actions

Workspace file authoring is limited to the approved stage. Read-only local inspection is allowed when it does not run application behavior. Disclose and obtain named-stage approval before database access, remote access, browser/UI automation, network/API calls, downloads, package changes, tests, builds, formatters, scripts, migrations, servers, deployments, write-capable Git actions, ClickUp mutations, or writes outside the workspace. A connected tool or credential is not authorization. Keep secrets out of files and tool output.

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

Follow `artifacts/workspace-governance/clickup-task-management.md`. Read-only ClickUp access and all task changes must be disclosed in the applicable stage. Create no local TODO, backlog, sprint, or task queue artifacts. A task-backed stage requires its approved closeout comment before completion.

- In local Codex, use only the existing **`clickup_local_core`** MCP server (`mcp__clickup_local_core__` tools) for all Saffna ClickUp reads, searches, comments, and authorized mutations. This routing rule takes precedence over generic ClickUp plugin or connector references.
- Do not use the Official ClickUp Plugin, hosted ClickUp MCP, or `mcp__codex_apps__clickup_*` tools. Do not fall back to Computer Use, browser or desktop automation, raw API calls, `curl`, or a separate ClickUp CLI. The local MCP itself communicates with ClickUp's normal REST API.
- Reuse the user-level registration in `~/.codex/config.toml`, the installation at `/Users/hasanhalabi/dev/clickup-mcp-server`, and the Keychain-backed launcher at `/Users/hasanhalabi/.local/share/clickup-mcp-core/launch.py`. Do not register a duplicate workspace server or copy credentials into repository files, `.env`, task text, logs, or chat.
- At the first approved ClickUp operation in a conversation, use `whoami` to confirm workspace **Eyadaty (`3668514`)** and the **core** profile; scope Saffna work to list `901821841766`. Follow the operation and failure rules in the task-management artifact. This routing rule grants no additional task permissions or stage approval.

## Terminology Library (Mandatory)

`artifacts/workspace-governance/platform-definitions-and-terminology.md` is the single canonical terminology library. Read it before creating, updating, reviewing, or referencing governed product, technical, environment, API, task, or delivery terms. Update it in the same approved stage as any new, changed, renamed, or clarified concept, along with affected canonical artifacts. Do not invent competing synonyms. Preserve compatibility-sensitive technical identifiers when documented.

## Codex Response Language (Mandatory)

Always reply in English, including when Hasan writes or dictates in Arabic or mixed Arabic and English. Use simple, direct English and explain technical terms when useful. An approved deliverable may retain its required Arabic or bilingual content.
