<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Console\Commands;

use Illuminate\Console\Command;
use LBHurtado\XDeploy\Contracts\DeploymentCommissionerContract;

final class DeploymentCommissionCommand extends Command
{
    protected $signature = 'x-deploy:commission {--json : Emit JSON output}';

    protected $description = 'Run deployment commissioning checks.';

    public function handle(DeploymentCommissionerContract $commissioner): int
    {
        $result = $commissioner->commission()->toArray();

        $this->line($this->option('json') ? json_encode($result, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) : json_encode($result));

        return $result['passed'] ? self::SUCCESS : self::FAILURE;
    }
}
