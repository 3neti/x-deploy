<?php

declare(strict_types=1);

use LBHurtado\XDeploy\Services\DeploymentManifestResolver;

it('resolves package versions and a lock hash', function () {
    $path = tempnam(sys_get_temp_dir(), 'x-deploy-lock-');
    file_put_contents($path, json_encode([
        'packages' => [[
            'name' => '3neti/x-change',
            'version' => 'v1.0.301',
            'source' => ['reference' => 'abc123'],
        ]],
    ], JSON_THROW_ON_ERROR));

    config()->set('x-deploy.manifest.composer_lock_path', $path);
    config()->set('x-deploy.instance.id', 'test-instance');
    config()->set('x-deploy.instance.environment', 'testing');

    $manifest = app(DeploymentManifestResolver::class)->resolve();

    expect($manifest->instanceId)->toBe('test-instance')
        ->and($manifest->environment)->toBe('testing')
        ->and($manifest->composerLockHash)->toHaveLength(64)
        ->and($manifest->packages[0]->name)->toBe('3neti/x-change')
        ->and($manifest->packages[0]->reference)->toBe('abc123');

    unlink($path);
});
