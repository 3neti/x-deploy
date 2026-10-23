# AI agent guide

## Repository purpose

`x-deploy` owns release manifests, compatibility checks, commissioning, and sanitized deployment telemetry. It does not own financial behavior or infrastructure provisioning.

## Conventions

- Use `LBHurtado\\XDeploy` for production code.
- Put contracts in `src/Contracts`, data objects in `src/Data`, services in `src/Services`, commands in `src/Console/Commands`, and tests in `tests/Unit` or `tests/Feature`.
- Bind overridable host integrations with `singletonIf`.
- Keep `env()` calls in `config/x-deploy.php` only.
- Use explicit return types and Pest tests.

## Safe workflow

1. Read the relevant architecture and contract documentation.
2. Inspect sibling package conventions before adding a class.
3. Add or update a Pest test before changing behavior.
4. Run the focused test, Pint, and the package test suite.
5. Keep telemetry fail-open and exclude secrets and private data.
6. Update documentation and examples with public interface changes.

## Verification

```sh
composer validate --strict
vendor/bin/pest --compact
vendor/bin/pint --dirty --format agent
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
```

Never bypass a failed compatibility check by disabling the guard in a host request path. Fix the package lock or the declared compatibility contract.
