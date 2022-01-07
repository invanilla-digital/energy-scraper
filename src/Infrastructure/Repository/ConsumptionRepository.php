<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Infrastructure\Repository;

use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;
use Invanilla\EnergyScraper\Domain\Repository\ConsumptionRepository as DomainConsumptionRepository;

class ConsumptionRepository implements DomainConsumptionRepository
{
    public function addConsumptionCollectionAndSave(ConsumptionCollection $consumptionCollection): void
    {
        // TODO Implement
    }
}
