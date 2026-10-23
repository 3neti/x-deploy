<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Data;

final readonly class DeploymentEventData
{
    /** @param array<string, mixed> $payload */
    public function __construct(
        public string $schema,
        public string $messageId,
        public string $instanceId,
        public string $type,
        public string $sentAt,
        public array $payload,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'schema' => $this->schema,
            'message_id' => $this->messageId,
            'instance_id' => $this->instanceId,
            'type' => $this->type,
            'sent_at' => $this->sentAt,
            'payload' => $this->payload,
        ];
    }
}
