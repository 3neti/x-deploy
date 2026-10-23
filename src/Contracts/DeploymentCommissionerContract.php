<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Contracts;

use LBHurtado\XDeploy\Data\CompatibilityCheckResultData;

interface DeploymentCommissionerContract
{
    public function commission(): CompatibilityCheckResultData;
}
