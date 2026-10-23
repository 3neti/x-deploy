<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Console\Commands;

use Illuminate\Console\Command;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;

final class DeploymentManifestCommand extends Command
{
    protected $signature = 'x-deploy:manifest {--json : Emit JSON output}';

    protected $description = 'Resolve the installed deployment release manifest.';

    public function handle(DeploymentManifestResolverContract $resolver): int
    {
        $manifest = $resolver->resolve()->toArray();

        $this->line($this->option('json') ? json_encode($manifest, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) : json_encode($manifest));

        return self::SUCCESS;
    }
}
