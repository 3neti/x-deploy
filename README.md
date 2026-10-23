# x-deploy

Release compatibility, commissioning, and deployment telemetry for x-change hosts.

## Purpose

`x-deploy` is the deployment control layer for package-first Laravel applications. It resolves the installed package graph, detects incompatible releases before activation, runs commissioning checks, and emits sanitized deployment evidence.

It is intentionally not a request-path dependency. Registry or telemetry outages must not turn issuance, redemption, or other application requests into HTTP 500 responses.

## Installation

```sh
composer require 3neti/x-deploy:^1.0
php artisan vendor:publish --tag=x-deploy-config
```

## Commands

```sh
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
```

## Local host demonstration

The local `x-change-sandbox` and `x-PayOut` checkouts consume tagged `3neti/x-deploy` releases from Packagist with the `^1.0` constraint. No path repository or sibling x-deploy checkout is required. For package development only, a Composer path repository at `../packages/x-deploy` with `3neti/x-deploy:dev-main` can be used instead.

The sandbox uses `composer.json` and `composer.lock`. x-PayOut's existing development setup uses `composer.local.json` and `composer.local.lock`; use `COMPOSER=composer.local.json` for its local Composer commands. Its release Composer files remain separate. Before installing, compare the selected lockfile with installed packages so Composer does not replace local development dependencies unintentionally.

Each host's published `config/x-deploy.php` accepts `XDEPLOY_COMPOSER_LOCK` (default `composer.lock`) and checks that the x-change provider exposes `register` and `boot`. The local environments use these settings:

| Setting | x-change-sandbox | x-PayOut |
| --- | --- | --- |
| `XDEPLOY_INSTANCE_ID` | `x-change-sandbox-local` | `x-payout-local` |
| `XDEPLOY_ENVIRONMENT` | `local` | `local` |
| `XDEPLOY_COMPOSER_LOCK` | `composer.lock` | `composer.local.lock` |
| `XDEPLOY_REGISTRY_ENABLED` | `false` | `false` |

From either host directory, run:

```sh
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
php artisan x-deploy:commission --json
php artisan x-deploy:heartbeat --json
php artisan x-deploy:report --json
vendor/bin/pest tests/Unit/XDeployIntegrationTest.php --compact
```

Successful gates return `{"passed": true, "issues": []}` and exit zero. With the registry disabled, heartbeat prints its event with `"reported": false` and exits zero. `report` prints the manifest and commissioning result locally; it does not submit telemetry.

These checks currently verify configured PHP class/method availability, not database, worker, asset, or financial readiness. Manifests describe the selected lockfile, not live source changes behind a development symlink. Registry transport is currently synchronous; the asynchronous outbox remains planned.

## Package conventions

The package uses the `LBHurtado\\XDeploy` namespace and follows the directory and service-provider conventions used by `x-provisioning`, `x-journal`, and `x-mcp`. Hosts provide configuration and secrets; deployment behavior remains package-owned.

## Documentation

- [Architecture](docs/architecture.md)
- [Manifest](docs/manifest.md)
- [Commissioning](docs/commissioning.md)
- [Telemetry](docs/telemetry.md)
- [Registry](docs/registry.md)
- [x-journal integration](docs/x-journal-integration.md)
- [Troubleshooting](docs/troubleshooting.md)
- [AI agent guide](docs/agent-guide.md)
