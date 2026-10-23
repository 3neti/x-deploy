<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Contracts;

use LBHurtado\XDeploy\Data\DeploymentManifestData;

interface DeploymentManifestResolverContract
{
    public function resolve(): DeploymentManifestData;
}
