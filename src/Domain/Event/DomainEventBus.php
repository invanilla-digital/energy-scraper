<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Event;

use Invanilla\EnergyScraper\Domain\Repository\ConsumptionRepository;

class DomainEventBus
{
    public function __construct(
        private readonly ConsumptionRepository $consumptionRepository
    ) {
    }

    public function dispatch(object $event): void
    {
        if ($event instanceof ConsumptionDataScraped) {
            $this->consumptionRepository->addConsumptionCollectionAndSave($event->getConsumptionCollection());
        }
    }
}
