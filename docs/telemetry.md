# Telemetry

Version one uses asynchronous HTTPS/JSON. Events include a schema, message ID, instance ID, event type, timestamp, sequence, and sanitized payload.

Telemetry is bounded by timeouts, retries, idempotency keys, and a circuit breaker. It is fail-open for application traffic. Do not emit credentials, payer identity, provider payloads, or private evidence.

MQTT over TLS is a future transport option for intermittent or high-volume fleets.
