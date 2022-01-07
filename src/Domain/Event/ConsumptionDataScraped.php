<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Event;

use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;

class ConsumptionDataScraped
{
    public function __construct(
        private readonly ConsumptionCollection $collection
    ) {
    }

    public function getConsumptionCollection(): ConsumptionCollection
    {
        return $this->collection;
    }
}
