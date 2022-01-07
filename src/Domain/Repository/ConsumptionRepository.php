<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Repository;

use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;

interface ConsumptionRepository
{
    public function addConsumptionCollectionAndSave(ConsumptionCollection $consumptionCollection): void;
}
