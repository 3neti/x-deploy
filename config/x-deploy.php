<?php

declare(strict_types=1);

return [
    'instance' => [
        'id' => env('XDEPLOY_INSTANCE_ID', env('APP_NAME', 'x-deploy-instance')),
        'environment' => env('XDEPLOY_ENVIRONMENT', env('APP_ENV', 'local')),
        'region' => env('XDEPLOY_REGION'),
    ],
    'manifest' => [
        'composer_lock_path' => base_path('composer.lock'),
        'git_commit' => env('XDEPLOY_GIT_COMMIT'),
        'branch' => env('XDEPLOY_GIT_BRANCH'),
    ],
    'compatibility' => [
        'required_methods' => [],
    ],
    'registry' => [
        'enabled' => (bool) env('XDEPLOY_REGISTRY_ENABLED', false),
        'endpoint' => env('XDEPLOY_REGISTRY_ENDPOINT'),
        'timeout' => (int) env('XDEPLOY_REGISTRY_TIMEOUT', 3),
    ],
];
