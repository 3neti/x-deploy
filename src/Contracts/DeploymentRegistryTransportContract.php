<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Contracts;

use LBHurtado\XDeploy\Data\DeploymentEventData;

interface DeploymentRegistryTransportContract
{
    public function publish(DeploymentEventData $event): bool;
}
