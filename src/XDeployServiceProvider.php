<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy;

use Illuminate\Support\ServiceProvider;
use LBHurtado\XDeploy\Console\Commands\DeploymentCommissionCommand;
use LBHurtado\XDeploy\Console\Commands\DeploymentHeartbeatCommand;
use LBHurtado\XDeploy\Console\Commands\DeploymentManifestCommand;
use LBHurtado\XDeploy\Console\Commands\DeploymentPreflightCommand;
use LBHurtado\XDeploy\Console\Commands\DeploymentReportCommand;
use LBHurtado\XDeploy\Contracts\DeploymentCommissionerContract;
use LBHurtado\XDeploy\Contracts\DeploymentCompatibilityCheckerContract;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;
use LBHurtado\XDeploy\Contracts\DeploymentRegistryTransportContract;
use LBHurtado\XDeploy\Contracts\DeploymentTelemetryReporterContract;
use LBHurtado\XDeploy\Services\ConfiguredDeploymentRegistryTransport;
use LBHurtado\XDeploy\Services\DeploymentCommissioner;
use LBHurtado\XDeploy\Services\DeploymentCompatibilityChecker;
use LBHurtado\XDeploy\Services\DeploymentManifestResolver;
use LBHurtado\XDeploy\Services\NullDeploymentTelemetryReporter;

final class XDeployServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/x-deploy.php', 'x-deploy');

        $this->app->singletonIf(DeploymentManifestResolverContract::class, DeploymentManifestResolver::class);
        $this->app->singletonIf(DeploymentCompatibilityCheckerContract::class, DeploymentCompatibilityChecker::class);
        $this->app->singletonIf(DeploymentCommissionerContract::class, DeploymentCommissioner::class);
        $this->app->singletonIf(DeploymentRegistryTransportContract::class, ConfiguredDeploymentRegistryTransport::class);
        $this->app->singletonIf(DeploymentTelemetryReporterContract::class, NullDeploymentTelemetryReporter::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DeploymentManifestCommand::class,
                DeploymentPreflightCommand::class,
                DeploymentCommissionCommand::class,
                DeploymentHeartbeatCommand::class,
                DeploymentReportCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/x-deploy.php' => config_path('x-deploy.php'),
        ], 'x-deploy-config');
    }
}
