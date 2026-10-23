<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use LBHurtado\XDeploy\Contracts\DeploymentCompatibilityCheckerContract;
use LBHurtado\XDeploy\Data\CompatibilityCheckResultData;
use LBHurtado\XDeploy\Data\DeploymentManifestData;

final class DeploymentCompatibilityChecker implements DeploymentCompatibilityCheckerContract
{
    public function check(DeploymentManifestData $manifest): CompatibilityCheckResultData
    {
        $issues = [];

        foreach ($manifest->packages as $package) {
            if ($package->name === '' || $package->version === '') {
                $issues[] = 'A package entry is missing its name or version.';
            }
        }

        foreach ((array) config('x-deploy.compatibility.required_methods', []) as $class => $methods) {
            if (! class_exists((string) $class)) {
                $issues[] = "Required class is unavailable: {$class}";

                continue;
            }

            foreach ((array) $methods as $method) {
                if (! method_exists((string) $class, (string) $method)) {
                    $issues[] = "Required method is unavailable: {$class}::{$method}";
                }
            }
        }

        return new CompatibilityCheckResultData($issues === [], $issues);
    }
}
