<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use LBHurtado\XDeploy\Contracts\DeploymentManifestResolverContract;
use LBHurtado\XDeploy\Data\DeploymentManifestData;
use LBHurtado\XDeploy\Data\PackageReleaseData;
use RuntimeException;

final class DeploymentManifestResolver implements DeploymentManifestResolverContract
{
    public function __construct(private Filesystem $files) {}

    public function resolve(): DeploymentManifestData
    {
        $path = (string) config('x-deploy.manifest.composer_lock_path', base_path('composer.lock'));

        if (! $this->files->exists($path)) {
            throw new RuntimeException("Composer lock file not found: {$path}");
        }

        try {
            $contents = $this->files->get($path);
        } catch (FileNotFoundException $exception) {
            throw new RuntimeException("Composer lock file not readable: {$path}", previous: $exception);
        }

        $lock = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        $packages = array_map(
            static fn (array $package): PackageReleaseData => new PackageReleaseData(
                name: (string) ($package['name'] ?? ''),
                version: (string) ($package['version'] ?? ''),
                reference: data_get($package, 'source.reference'),
            ),
            array_values(array_filter(
                [...($lock['packages'] ?? []), ...($lock['packages-dev'] ?? [])],
                static fn (array $package): bool => isset($package['name'], $package['version']),
            )),
        );

        return new DeploymentManifestData(
            schema: 'x-deploy.manifest.v1',
            instanceId: (string) config('x-deploy.instance.id'),
            environment: (string) config('x-deploy.instance.environment'),
            region: config('x-deploy.instance.region'),
            gitCommit: config('x-deploy.manifest.git_commit'),
            branch: config('x-deploy.manifest.branch'),
            composerLockHash: hash('sha256', $contents),
            packages: $packages,
        );
    }
}
