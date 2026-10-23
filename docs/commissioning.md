# Commissioning

Run the deployment gates in this order:

```sh
php artisan x-deploy:manifest --json
php artisan x-deploy:preflight --json
php artisan x-change:publish --scope=build --force --verify --no-interaction
php artisan x-deploy:commission --json
php artisan x-deploy:report --json
```

Preflight blocks activation when package contracts, published assets, or required infrastructure are incompatible. A failed telemetry submission does not block a running application.
