# Architecture

`x-deploy` is a Laravel package that provides release control and deployment evidence. It does not replace Laravel Cloud, GitHub Actions, DNS, or `x-provisioning`.

## Boundaries

| Package | Responsibility |
| --- | --- |
| `x-deploy` | Release manifests, compatibility, commissioning, telemetry |
| `x-provisioning` | Infrastructure preparation and provisioning authority |
| `x-change` | Financial and application behavior |
| `x-journal` | Durable operational and deployment evidence |
| Host application | Secrets, branding, environment configuration, deployment wiring |

## Runtime safety

Telemetry is asynchronous and fail-open. A registry outage must not affect user requests. Preflight and commissioning are fail-closed only during controlled deployment gates.

## Fleet model

Each local, testing, staging, production, bank, or EMI host has an instance identity and emits a sanitized release and capability profile. A future registry service can aggregate these profiles without receiving credentials or private financial data.
