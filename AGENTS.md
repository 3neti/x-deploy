# x-deploy agent instructions

`x-deploy` is package-first deployment control for x-change hosts. Follow `docs/agent-guide.md` before changing code.

Use the `LBHurtado\\XDeploy` namespace and existing package structure. Keep compatibility checks deterministic, telemetry asynchronous, and runtime application behavior independent of registry availability. Every behavior change requires a Pest test and documentation update when it changes a public contract.
