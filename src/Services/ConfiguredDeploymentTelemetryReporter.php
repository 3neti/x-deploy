<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use LBHurtado\XDeploy\Contracts\DeploymentRegistryTransportContract;
use LBHurtado\XDeploy\Contracts\DeploymentTelemetryReporterContract;
use LBHurtado\XDeploy\Data\DeploymentEventData;
use Throwable;

final class ConfiguredDeploymentTelemetryReporter implements DeploymentTelemetryReporterContract
{
    public function __construct(private DeploymentRegistryTransportContract $transport) {}

    public function report(DeploymentEventData $event): bool
    {
        try {
            return $this->transport->publish($event);
        } catch (Throwable) {
            return false;
        }
    }
}
