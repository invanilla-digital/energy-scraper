<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Pipeline;

use LogicException;

final class PipelineChains
{
    /**
     * @param callable[] $chains
     */
    public function __construct(
        private array $chains = []
    ) {
    }

    public function add(string $uniqueName, callable $chain): self
    {
        if (isset($this->chains[$uniqueName])) {
            throw new LogicException(
                "Pipeline chain name must be unique `{$uniqueName}`"
            );
        }

        $this->chains[$uniqueName] = $chain;

        return $this;
    }

    /**
     * @return callable[]
     */
    public function toArray(): array
    {
        return $this->chains;
    }

    public function reset(): void
    {
        $this->chains = [];
    }
}
