<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Pipeline;

use Invanilla\EnergyScraper\Domain\Event\ConsumptionDataScraped;
use Invanilla\EnergyScraper\Domain\Event\DomainEventBus;
use Invanilla\EnergyScraper\Domain\Input\ScrapingSubjectCollection;
use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;
use Invanilla\EnergyScraper\Domain\Scraper\ScraperRegistry;
use JetBrains\PhpStorm\Pure;
use RuntimeException;
use Throwable;

class ScrapingPipeline
{
    #[Pure]
    public function __construct(
        private readonly ScraperRegistry $scrapers,
        private readonly DomainEventBus $eventBus,
        private readonly PipelineChains $chains = new PipelineChains()
    ) {
    }

    public function initiate(ScrapingSubjectCollection $subjects): void
    {
        $this->chains->reset();

        foreach ($subjects->toArray() as $subject) {
            $scraper = $this->scrapers->getForSubject($subject);

            $this->chains->add(
                $subject->getDescription(),
                static function () use ($scraper, $subject): ConsumptionCollection {
                    return $scraper->scrape($subject);
                }
            );
        }
    }

    public function inspect(): PipelineChains
    {
        return $this->chains;
    }

    public function run(): void
    {
        $exceptions = [];

        foreach ($this->chains->toArray() as $chainName => $pipelineChain) {
            try {
                $this->eventBus->dispatch(
                    new ConsumptionDataScraped($pipelineChain())
                );

                echo '> ✅ ' . $chainName . PHP_EOL;
            } catch (Throwable $exception) {
                echo '> ❌ ' . $chainName . PHP_EOL;

                $exceptions[$chainName] = $exception;
            }
        }

        if (!$exceptions) {
            return;
        }

        $this->reportExceptions($exceptions);
    }

    /**
     * @param Throwable[] $exceptions
     * @return void
     */
    private function reportExceptions(array $exceptions): void
    {
        $exceptionMessage = 'Pipeline had errors' . PHP_EOL;

        foreach ($exceptions as $location => $exception) {
            $exceptionMessage .= '[' . $location . ']' . $exception->getMessage() . PHP_EOL;
        }

        throw new RuntimeException($exceptionMessage);
    }
}
