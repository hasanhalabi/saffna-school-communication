# Saffna Inbound Integration Contracts

An inbound interaction crosses from a browser or later external client into the Saffna platform boundary. The planned browser-to-Laravel HTTP API belongs here.

Every route under `/api/*` requires an authenticated Laravel browser session, including the fallback for unknown API paths. Approved application endpoints are versioned under `/api/v1/*`. The login page and `POST /login` sit outside `/api/*`; they are the only implemented unauthenticated application interaction. `POST /logout` also sits outside `/api/*` and requires the active session. `GET /api/v1/me` returns the authenticated user's current session identity and explicit access context. Public registration, public password recovery, public account bootstrap, token authentication, cross-origin access, and anonymous business/data API actions are excluded.

The browser and Laravel application use a same-origin session with Laravel CSRF protection. Multiple devices may hold sessions. Inactive sessions expire after 120 minutes, Laravel's remember-me behavior remains available, and account disable revokes an existing session on its next request. Later administrative password-reset behavior must revoke all existing sessions. Login is limited to five attempts per minute for each normalized email-and-IP combination.

## Implemented Identity Operations

| Method and path | Session | Request or result |
| --- | --- | --- |
| `GET /` and `GET /login` | Optional | Serves the same bilingual login/current-session shell and no school data |
| `POST /login` | Guest | Accepts `email`, `password`, and optional boolean `remember`; regenerates the session after valid active-account credentials |
| `POST /logout` | Required | Invalidates the session, regenerates the CSRF token, and returns `authenticated: false` |
| `GET /api/v1/me` | Required | Returns the current user's ID, name, email, fixed group code, status, preferred language, temporary-password flag, and explicit permission strings |

Invalid credentials and disabled accounts return the same localized `invalid_credentials` response. Login and API JSON respect Arabic or English from `Accept-Language`. Session expiry returns `401` and a refreshed CSRF token so the same page can safely return to login.

## Shared JSON Contract

Protected API responses use JSON. Error responses carry a stable machine-readable code, a localized human-readable message, field errors when relevant, and a request identifier. Use these HTTP meanings consistently:

| Status | Meaning |
| --- | --- |
| `401` | Missing, invalid, or expired authenticated session |
| `403` | Authenticated user lacks the required permission or data access |
| `404` | Requested record is not available to the permitted scope |
| `409` | Valid request conflicts with current record state or uniqueness |
| `419` | The same-origin CSRF token is missing, invalid, or expired |
| `422` | Request fields fail validation |
| `429` | Request or login throttling limit reached |
| `500` | Unexpected server failure without exposing internal or sensitive details |

Successful JSON responses contain `data` and `request_id`. Error JSON contains `code`, localized `message`, field-level `errors`, and `request_id`. Unknown API paths return `401` before authentication and the stable `404 not_found` response after authentication.

User Management collections use page-based pagination with page, page size, total rows, and total pages. The default page size is 25. API controllers validate transport shape, authenticate and authorize the request, call the owning business service, and format the HTTP response. They do not own business rules, transactions, or persistence.

Add feature endpoint contracts when their stages define consumers, payloads, validation, permissions, failures, compatibility, and acceptance tests. Keep business meaning in `artifacts/business-rules-requirements/` and data ownership in `artifacts/database/`. API controllers delegate to reusable PHP business classes and do not duplicate persistence, Arabic name normalization, identifier validation, or permission rules. A possible future mobile application would be another consumer with a separately approved authentication method, not an existing runtime.
