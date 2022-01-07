<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Scraper;

use Invanilla\EnergyScraper\Domain\Input\ScrapingSubject;
use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;

interface ScraperInterface
{
    public function scrape(ScrapingSubject $subject): ConsumptionCollection;

    public function canScrape(ScrapingSubject $subject): bool;
}
