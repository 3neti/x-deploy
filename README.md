# x-deploy

Release compatibility, commissioning, and deployment telemetry for x-change hosts.

## Purpose

`x-deploy` is the deployment control layer for package-first Laravel applications. It resolves the installed package graph, detects incompatible releases before activation, runs commissioning checks, and emits sanitized deployment evidence.

It is intentionally not a request-path dependency. Registry or telemetry outages must not turn issuance, redemption, or other application requests into HTTP 500 responses.

## Installation

```sh
composer require 3neti/x-deploy
php artisan vendor:publish --tag=x-deploy-config
```

## Commands

```sh
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
```

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
