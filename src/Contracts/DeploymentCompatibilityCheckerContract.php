<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Contracts;

use LBHurtado\XDeploy\Data\CompatibilityCheckResultData;
use LBHurtado\XDeploy\Data\DeploymentManifestData;

interface DeploymentCompatibilityCheckerContract
{
    public function check(DeploymentManifestData $manifest): CompatibilityCheckResultData;
}
