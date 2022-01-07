<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Output;

final class Consumption
{
    public function __construct(
        private readonly string $street,
        private readonly string $representative,
        private readonly string $yearAndMonth,
        private readonly string $consumptionMWH
    ) {
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getConsumptionMWH(): string
    {
        return $this->consumptionMWH;
    }
}
