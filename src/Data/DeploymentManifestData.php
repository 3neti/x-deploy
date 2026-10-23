<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Data;

final readonly class DeploymentManifestData
{
    /** @param array<int, PackageReleaseData> $packages */
    public function __construct(
        public string $schema,
        public string $instanceId,
        public string $environment,
        public ?string $region,
        public ?string $gitCommit,
        public ?string $branch,
        public ?string $composerLockHash,
        public array $packages,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'schema' => $this->schema,
            'instance_id' => $this->instanceId,
            'environment' => $this->environment,
            'region' => $this->region,
            'git_commit' => $this->gitCommit,
            'branch' => $this->branch,
            'composer_lock_hash' => $this->composerLockHash,
            'packages' => array_map(static fn (PackageReleaseData $package): array => $package->toArray(), $this->packages),
        ];
    }
}
