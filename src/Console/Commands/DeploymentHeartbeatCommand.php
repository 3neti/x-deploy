<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;
use LBHurtado\XDeploy\Contracts\DeploymentTelemetryReporterContract;
use LBHurtado\XDeploy\Data\DeploymentEventData;

final class DeploymentHeartbeatCommand extends Command
{
    protected $signature = 'x-deploy:heartbeat {--json : Emit JSON output}';

    protected $description = 'Emit a sanitized deployment heartbeat.';

    public function handle(
        DeploymentManifestResolverContract $resolver,
        DeploymentTelemetryReporterContract $reporter,
    ): int {
        $manifest = $resolver->resolve();
        $event = new DeploymentEventData(
            schema: 'x-deploy.heartbeat.v1',
            messageId: (string) Str::ulid(),
            instanceId: $manifest->instanceId,
            type: 'heartbeat',
            sentAt: now()->toIso8601String(),
            payload: [
                'environment' => $manifest->environment,
                'git_commit' => $manifest->gitCommit,
                'composer_lock_hash' => $manifest->composerLockHash,
            ],
        );

        $reported = $reporter->report($event);
        $payload = ['reported' => $reported, 'event' => $event->toArray()];
        $this->line($this->option('json') ? json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) : json_encode($payload));

        return self::SUCCESS;
    }
}
