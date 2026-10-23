<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Data;

final readonly class PackageReleaseData
{
    public function __construct(
        public string $name,
        public string $version,
        public ?string $reference = null,
    ) {}

    /** @return array{name: string, version: string, reference: string|null} */
    public function toArray(): array
    {
        return ['name' => $this->name, 'version' => $this->version, 'reference' => $this->reference];
    }
}
