# Audit & Logging Module

This project now includes a structured audit trail that records critical user/admin/system/security events with timestamps, actor context, entity affected, before/after values, correlation IDs (for cross-module tracing), and export support.

## What’s included

- **Structured storage**: `audit_log` table (see `ccm.sql`) with JSON columns for before/after/metadata.
- **Immutable/tamper-evident entries**: each event stores an `integrity_hash` (HMAC-SHA256) derived from the event payload.
- **Central logger service**: `application/libraries/AuditLogger.php`.
- **Admin UI**: list + filters + drill-down + CSV/JSON export:
  - `/audit-log`
  - `/audit-log/details/{audit_log_id}`
  - `/audit-log/export/csv`
  - `/audit-log/export/json`

## Security / access control

The audit UI reuses the existing **System Logs** view permission (`system-log`) for access control. If a user does not have `view` rights for that module, the audit pages return **403 Forbidden**.

## Configuration

Set an HMAC key for integrity hashing:

- Preferred: environment variable `AUDIT_LOG_HMAC_KEY`
- Fallback: CodeIgniter `encryption_key` (from `application/config/config.php`)

## Instrumentation patterns

Use the logger anywhere in controllers/models/jobs:

- User actions: `$this->auditlogger->logUserAction($module, $action, $entityType, $entityId, $before, $after, $metadata, $status, $message)`
- Admin actions: `$this->auditlogger->logAdminAction(...)`
- System events (jobs/billing/notifications): `$this->auditlogger->logSystemEvent(...)`
- Security events (failed logins, blocked actions): `$this->auditlogger->logSecurityEvent(...)`

### Correlation IDs (incident reconstruction)

- Every request gets a `request_id` (auto-generated if not provided).
- By default `correlation_id` is set to `request_id`.
- For multi-step workflows across modules (membership → billing → payments), pass a shared `correlation_id` in `$metadata` when logging.

## What is already instrumented

- `auth/Login.php`: logs successful logins, failed logins (security event), and logouts.
- `admin/UserRoleController.php`: logs role/permission adds/updates/deletes with before/after snapshots.

## Database setup

Create the `audit_log` table by applying the schema from `ccm.sql`.

> Note: existing deployments must apply the new table manually (there is no CI migration in this repo).
