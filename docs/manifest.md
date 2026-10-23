# Deployment manifest

The manifest schema is `x-deploy.manifest.v1`.

```json
{
  "schema": "x-deploy.manifest.v1",
  "instance_id": "payout-production",
  "environment": "production",
  "region": "us-west-1",
  "git_commit": "abc123",
  "branch": "main",
  "composer_lock_hash": "sha256...",
  "packages": [
    {"name": "3neti/x-change", "version": "v1.0.301", "reference": "..."}
  ]
}
```

Package references and lock hashes are the compatibility evidence. Secrets, provider payloads, payer identity, and private evidence never belong in a manifest.
