<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Contracts;

use LBHurtado\XDeploy\Data\DeploymentEventData;

interface DeploymentTelemetryReporterContract
{
    public function report(DeploymentEventData $event): bool;
}
