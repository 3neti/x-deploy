# Troubleshooting

## A required package method is missing

Run `x-deploy:manifest` and inspect the package version and source reference. Update the host lockfile to a compatible release, then rerun `x-deploy:preflight` before deployment.

## Telemetry is unavailable

Application requests should continue. Check the registry endpoint, timeout, queue, and retry logs. Do not add registry calls to request middleware.

## Published assets are stale

Run the package publish command and the host frontend build, then verify the generated manifest before activating the deployment.
