<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Tests;

use LBHurtado\XDeploy\XDeployServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [XDeployServiceProvider::class];
    }
}
