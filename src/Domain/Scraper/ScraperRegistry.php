<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Scraper;

use Invanilla\EnergyScraper\Domain\Input\ScrapingSubject;
use LogicException;

final class ScraperRegistry
{
    /**
     * @param ScraperInterface[] $scrapers
     */
    public function __construct(
        private array $scrapers = []
    ) {
    }

    public function register(ScraperInterface $scraper): self
    {
        $this->scrapers[] = $scraper;

        return $this;
    }

    public function getForSubject(ScrapingSubject $subject): ScraperInterface
    {
        foreach ($this->scrapers as $scraper) {
            if ($scraper->canScrape($subject)) {
                return $scraper;
            }
        }

        throw new LogicException(
            "No scraper defined for subject with URI `{$subject->getUri()}` and description `{$subject->getDescription()}`"
        );
    }
}
