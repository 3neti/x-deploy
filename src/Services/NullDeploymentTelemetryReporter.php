<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use LBHurtado\XDeploy\Contracts\DeploymentTelemetryReporterContract;
use LBHurtado\XDeploy\Data\DeploymentEventData;

final class NullDeploymentTelemetryReporter implements DeploymentTelemetryReporterContract
{
    public function report(DeploymentEventData $event): bool
    {
        return false;
    }
}
