# x-deploy AI Agent hand-off

## Mission

Continue development of `3neti/x-deploy`, the package-first deployment control layer for x-change hosts.

Repository:

```text
https://github.com/3neti/x-deploy.git
```

Local path:

```text
/Users/rli/PhpstormProjects/packages/x-deploy
```

## Current state

The package has been scaffolded and pushed to `main`.

Recent commits:

- `ef511b7` — initial x-deploy package
- `35e8711` — fail-open registry telemetry wiring

The working tree should remain clean before starting new work.

## Package conventions

Use the conventions established by `x-provisioning`, `x-journal`, and `x-mcp`.

- Composer package: `3neti/x-deploy`
- Production namespace: `LBHurtado\\XDeploy`
- Test namespace: `LBHurtado\\XDeploy\\Tests`
- Service provider: `LBHurtado\\XDeploy\\XDeployServiceProvider`
- Config: `config/x-deploy.php`
- Commands: `src/Console/Commands`
- Contracts: `src/Contracts`
- Data objects: `src/Data`
- Services: `src/Services`
- Enums: `src/Enums`
- Unit tests: `tests/Unit`
- Feature tests: `tests/Feature`

Use explicit return types, constructor property promotion, typed immutable data objects, and Pest tests. Bind host-overridable services with `singletonIf`.

## Implemented surface

### Configuration

`config/x-deploy.php` currently provides:

- Instance ID, environment, and region
- Composer lock path
- Git commit and branch metadata
- Registry enablement, endpoint, and timeout
- Required class/method compatibility rules

### Commands

```sh
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
php artisan x-deploy:commission --json
php artisan x-deploy:heartbeat --json
php artisan x-deploy:report --json
```

### Services and contracts

- Manifest resolution from `composer.lock`
- Composer lock SHA-256 fingerprinting
- Package version and source reference extraction
- Required class/method compatibility checks
- Commissioning wrapper around compatibility checks
- Configured HTTPS registry transport
- Fail-open telemetry reporter
- Null telemetry reporter retained as an extension point

### Safety behavior

- Registry and telemetry failures return `false` and do not throw into application requests.
- x-deploy is not global request middleware.
- Deployment preflight and commissioning may fail deployment gates.
- Credentials, payer identity, provider payloads, and private evidence must never enter manifests or telemetry.

## Verification already completed

```sh
composer validate --strict --no-interaction
vendor/bin/pest --compact
vendor/bin/pint --dirty --format agent
```

Current result:

- Pest: 3 tests, 11 assertions
- Pint: passed
- Composer validation: passed

Run these commands after every behavioral change.

## Important limitations

This is the initial foundation, not the complete fleet control plane.

Not yet implemented:

- Durable asynchronous telemetry outbox
- Signed event envelopes and replay protection
- A central x-deploy registry application
- Provider and EMI capability profile storage
- x-journal event recording implementation
- Database, queue, Redis, storage, and worker commissioning probes
- Laravel Cloud deployment adapter
- Host integration in x-change-sandbox and x-PayOut
- MQTT transport

Do not pretend these are implemented. Extend the contracts and documentation as each capability is added.

## Recommended next work

### 1. Harden the manifest

- Add deterministic manifest serialization.
- Include PHP, Laravel, Node, frontend asset, migration, and queue topology metadata.
- Add explicit package compatibility rules for known cross-package contracts.
- Add tests for stale lockfiles and package source drift.

### 2. Add commissioning probes

Create probe contracts and services for:

- Database migration state
- Redis/cache reachability
- Queue and worker readiness
- Filesystem/storage readiness
- Published x-change asset verification
- Bank and EMI adapter capability checks

Keep probes read-only and safe to execute in production.

### 3. Add signed telemetry

Define a stable event envelope with:

- Schema
- Message ID
- Instance ID
- Event type
- Timestamp
- Monotonic sequence
- Payload hash
- Signature

Add idempotency and replay tests before introducing a registry server.

### 4. Integrate x-journal

Use an optional contract adapter. x-deploy must still function when x-journal is not installed. Keep x-journal as the durable audit source and the registry as summarized current state.

### 5. Integrate hosts

Keep hosts thin. They should supply:

- Secrets
- Environment values
- Provider endpoints
- Branding
- Cloud deployment configuration

They should not duplicate manifest or compatibility logic.

## Documentation requirements

Update documentation whenever a public contract changes:

- `README.md` for installation and quick start
- `docs/architecture.md` for boundaries
- `docs/manifest.md` for schema changes
- `docs/commissioning.md` for gates and probes
- `docs/telemetry.md` for event and transport changes
- `docs/registry.md` for fleet behavior
- `docs/troubleshooting.md` for operational failures
- `docs/agent-guide.md` for contributor workflow

Use stable headings, copyable commands, explicit examples, and clear failure behavior so both engineers and AI agents can follow the package safely.

## Guardrails

- Do not put deployment logic into x-change host applications.
- Do not add registry calls to request middleware.
- Do not fail user issuance or redemption because telemetry is unavailable.
- Do not emit secrets, payer identity, provider payloads, or private evidence.
- Do not change package dependencies without updating Composer lock and tests.
- Do not modify generated host frontend copies directly.
- Do not delete existing tests.
- Preserve package-first ownership and release changes through Git tags.

## Suggested first command sequence

```sh
cd /Users/rli/PhpstormProjects/packages/x-deploy
git status -sb
composer install --no-interaction --prefer-dist --no-progress
vendor/bin/pest --compact
vendor/bin/pint --dirty --format agent
```

Read this hand-off together with `AGENTS.md` and `docs/agent-guide.md` before changing code.
