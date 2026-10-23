<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Console\Commands;

use Illuminate\Console\Command;
use LBHurtado\XDeploy\Contracts\DeploymentCompatibilityCheckerContract;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;

final class DeploymentPreflightCommand extends Command
{
    protected $signature = 'x-deploy:preflight {--json : Emit JSON output}';

    protected $description = 'Check the installed release manifest for compatibility issues.';

    public function handle(
        DeploymentManifestResolverContract $resolver,
        DeploymentCompatibilityCheckerContract $checker,
    ): int {
        $result = $checker->check($resolver->resolve());
        $payload = $result->toArray();

        $this->line($this->option('json') ? json_encode($payload, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) : json_encode($payload));

        return $result->passed ? self::SUCCESS : self::FAILURE;
    }
}
