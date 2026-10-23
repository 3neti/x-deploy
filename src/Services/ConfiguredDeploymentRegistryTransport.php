<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use Illuminate\Http\Client\Factory as HttpFactory;
use LBHurtado\XDeploy\Contracts\DeploymentRegistryTransportContract;
use LBHurtado\XDeploy\Data\DeploymentEventData;

final class ConfiguredDeploymentRegistryTransport implements DeploymentRegistryTransportContract
{
    public function __construct(private HttpFactory $http) {}

    public function publish(DeploymentEventData $event): bool
    {
        $endpoint = config('x-deploy.registry.endpoint');

        if (! config('x-deploy.registry.enabled') || ! is_string($endpoint) || $endpoint === '') {
            return false;
        }

        return $this->http
            ->timeout((int) config('x-deploy.registry.timeout', 3))
            ->connectTimeout((int) config('x-deploy.registry.timeout', 3))
            ->post($endpoint, $event->toArray())
            ->successful();
    }
}
