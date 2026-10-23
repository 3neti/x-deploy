<?php

declare(strict_types=1);

it('registers the deployment manifest and preflight commands', function () {
    $path = tempnam(sys_get_temp_dir(), 'x-deploy-command-lock-');
    file_put_contents($path, json_encode(['packages' => []], JSON_THROW_ON_ERROR));
    config()->set('x-deploy.manifest.composer_lock_path', $path);

    $this->artisan('x-deploy:manifest', ['--json' => true])->assertExitCode(0);
    $this->artisan('x-deploy:preflight', ['--json' => true])->assertExitCode(0);
    $this->artisan('x-deploy:commission', ['--json' => true])->assertExitCode(0);
    $this->artisan('x-deploy:heartbeat', ['--json' => true])->assertExitCode(0);
    $this->artisan('x-deploy:report', ['--json' => true])->assertExitCode(0);

    unlink($path);
});

it('fails compatibility when a required method is missing', function () {
    $path = tempnam(sys_get_temp_dir(), 'x-deploy-compatibility-lock-');
    file_put_contents($path, json_encode(['packages' => []], JSON_THROW_ON_ERROR));
    config()->set('x-deploy.manifest.composer_lock_path', $path);
    config()->set('x-deploy.compatibility.required_methods', [
        stdClass::class => ['missingMethod'],
    ]);

    $this->artisan('x-deploy:preflight', ['--json' => true])->assertExitCode(1);

    unlink($path);
});
