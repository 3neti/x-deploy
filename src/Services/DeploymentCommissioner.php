<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use LBHurtado\XDeploy\Contracts\DeploymentCommissionerContract;
use LBHurtado\XDeploy\Contracts\DeploymentCompatibilityCheckerContract;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;
use LBHurtado\XDeploy\Data\CompatibilityCheckResultData;

final class DeploymentCommissioner implements DeploymentCommissionerContract
{
    public function __construct(
        private DeploymentManifestResolverContract $resolver,
        private DeploymentCompatibilityCheckerContract $checker,
    ) {}

    public function commission(): CompatibilityCheckResultData
    {
        return $this->checker->check($this->resolver->resolve());
    }
}
