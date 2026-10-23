<?php

declare(strict_types=1);

namespace LBHurtado\XDeploy\Data;

final readonly class CompatibilityCheckResultData
{
    /** @param array<int, string> $issues */
    public function __construct(
        public bool $passed,
        public array $issues = [],
    ) {}

    /** @return array{passed: bool, issues: array<int, string>} */
    public function toArray(): array
    {
        return ['passed' => $this->passed, 'issues' => $this->issues];
    }
}
