<?php

declare(strict_types=1);

use Invanilla\EnergyScraper\Application\PipelineApplication;
use Invanilla\EnergyScraper\Domain\Event\DomainEventBus;
use Invanilla\EnergyScraper\Domain\Input\ScrapingSubjectCollection;
use Invanilla\EnergyScraper\Domain\Pipeline\ScrapingPipeline;
use Invanilla\EnergyScraper\Domain\Scraper\ScraperRegistry;
use Invanilla\EnergyScraper\Infrastructure\Repository\ConsumptionRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$scrapers = new ScraperRegistry(
    require __DIR__ . '/../config/scrapers.php'
);

$consumptionRepository = new ConsumptionRepository();
$eventBus = new DomainEventBus($consumptionRepository);

$application = new PipelineApplication(
    new ScrapingPipeline($scrapers, $eventBus),
    new ScrapingSubjectCollection(
        require __DIR__ . '/../config/subjects.php'
    )
);

$application->run();
