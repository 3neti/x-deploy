<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Console\Commands;

use Illuminate\Console\Command;
use LBHurtado\XDeploy\Contracts\DeploymentCommissionerContract;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;

final class DeploymentReportCommand extends Command
{
    protected $signature = 'x-deploy:report {--json : Emit JSON output}';

    protected $description = 'Report the deployment manifest and commissioning status.';

    public function handle(
        DeploymentManifestResolverContract $resolver,
        DeploymentCommissionerContract $commissioner,
    ): int {
        $payload = [
            'manifest' => $resolver->resolve()->toArray(),
            'commissioning' => $commissioner->commission()->toArray(),
        ];

        $this->line($this->option('json') ? json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) : json_encode($payload));

        return $payload['commissioning']['passed'] ? self::SUCCESS : self::FAILURE;
    }
}
