<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Infrastructure\Scraper;

use Invanilla\EnergyScraper\Domain\Input\ScrapingSubject;
use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;
use Invanilla\EnergyScraper\Domain\Scraper\ScraperInterface;

class VoidScraper implements ScraperInterface
{
    public function scrape(ScrapingSubject $subject): ConsumptionCollection
    {
        // Void scraper does not scrape
        return new ConsumptionCollection();
    }

    public function canScrape(ScrapingSubject $subject): bool
    {
        return true; // void scraper accepts anything
    }
}
