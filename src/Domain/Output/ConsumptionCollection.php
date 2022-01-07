<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Output;

final class ConsumptionCollection
{
    /**
     * @param Consumption[] $consumptionItems
     */
    public function __construct(
        private array $consumptionItems = [],
    ) {
    }

    public function add(Consumption $consumption): self
    {
        $this->consumptionItems[] = $consumption;

        return $this;
    }

    /**
     * @return Consumption[]
     */
    public function toArray(): array
    {
        return $this->consumptionItems;
    }
}
