# Saffna | صفّنا

**The open-source school communication project for a free Arabic YouTube course.**

Saffna is the practical project behind **بناء نظام مدرسي حقيقي باستخدام Codex: من المتطلبات إلى تطبيق Laravel موثّق**. The course follows the work from an empty repository toward a locally runnable, tested, and documented bilingual application. Its main lesson is how to manage software delivery with AI while keeping a person responsible for the requirements, decisions, review, and result.

## Who is behind it

I’m **Hasan Halabi**, an AI Delivery & Product Systems Consultant, senior product engineer, and systems builder. I help software teams and freelancers improve AI-assisted delivery, and I help small businesses build reliable automation and custom software. I’m creating this free course to show that method through real, reviewable work rather than a collection of prompts or a polished final demo.

I use Codex as the collaborator shown in the recordings. The working method can also be applied with other capable AI tools, though their capabilities differ. The course is free, with no hidden paid continuation or withheld essential steps.

## The project and the learning goal

School communication is often split among messaging apps, paper notices, and disconnected records. Saffna is intended to give administrators, teachers, parents, and students a clearer place to manage school communication. The current product baseline names **User Management, Class Management, Assignments, and Messaging**. Their detailed workflows and permissions still need separate decisions before implementation.

The course is for experienced freelancers, developers, and small software teams who can read code and review its behavior. Prior Laravel experience is not required. Viewers will see how to:

- turn a problem into requirements, business rules, and explicit boundaries;
- keep decisions and project knowledge in the repository;
- use stage approvals and ClickUp tasks to control AI-assisted work;
- inspect and test each implementation step instead of trusting generated output;
- use Git and GitHub to preserve understandable checkpoints; and
- document a locally runnable application and its limits.

The planned application uses one Laravel 12 web application with an HTTP API, PHP business classes, SQLite, and a bilingual browser interface built with native Web Components and Bootstrap 5. Arabic is primary and uses right-to-left layout; English uses left-to-right layout. A mobile application is only a possible future client.

## Current checkpoint

This repository currently contains the **governed project foundation**, the installed Laravel 12 runtime under `apps/web/`, and the first identity-and-access implementation. Local DEV uses SQLite. The application now has secure Local DEV Super Admin provisioning, browser-session login and logout, a fully protected `/api/*` boundary, a fixed five-group permission matrix, and Arabic/English native Web Components for login and session state. Current stable Google Chrome is the only supported browser; other browsers and screen-reader certification are not part of the current work.

User Management operations, school modules, real data, remote environments, and a deployable release remain incomplete. Follow the course and repository history as later checkpoints are completed; do not treat planned features as finished software.

Start with:

1. [Repository working rules](AGENTS.md) — approvals, evidence, and change boundaries.
2. [Artifact index](artifacts/README.md) — where the project’s decisions and specifications live.
3. [Project profile](artifacts/workspace-governance/project-profile.yaml) — current scope and open decisions.
4. [Product baseline](artifacts/business-rules-requirements/saffna-platform-baseline.md) and [architecture decision](artifacts/architecture-decisions/saffna-application-architecture.md) — what is currently approved for the product and its technical direction.
5. [Web application](apps/web/README.md) — Local DEV setup, runtime boundaries, and current limits.

The educational endpoint is a locally runnable, tested, and documented application. This repository is not a production-ready school system, and it must not be used with real student or family data without separate security, privacy, operational, and deployment work.

## Project tracking

The private Saffna ClickUp list is the task source of truth. [GitHub Issues](https://github.com/hasanhalabi/saffna-school-communication/issues) provides a public, read-only view for course viewers who cannot access ClickUp. Each mirrored issue identifies its ClickUp task without exposing ClickUp credentials or requiring a ClickUp account.

Codex updates the matching GitHub Issue in the same working session after an authorized ClickUp task, subtask, status, description, or comment change. There is no background scheduler or repository token for ClickUp. GitHub comments may support course discussion, but they do not update ClickUp and do not change the approved project plan.

## Reuse and contributions

Hasan’s original material in this repository is released under the [Zero-Clause BSD License (0BSD)](LICENSE). You may use, copy, change, distribute, or sell that material without asking permission or crediting Hasan. It is provided without warranty. **Third-party components keep their own licenses and notices**; see [Third-Party Notices](THIRD_PARTY_NOTICES.md). The repository license does not set reuse terms for YouTube videos, music, or other course media.

You can fork and adapt the project. If you want to send a change back, read [Contributing](CONTRIBUTING.md) first. Please use fictional example data and never commit credentials or real school, parent, teacher, or student information.
