<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Application;

use Invanilla\EnergyScraper\Domain\Input\ScrapingSubjectCollection;
use Invanilla\EnergyScraper\Domain\Pipeline\ScrapingPipeline;

class PipelineApplication
{
    public function __construct(
        private readonly ScrapingPipeline $pipeline,
        private readonly ScrapingSubjectCollection $subjects
    ) {
    }

    public function run(): void
    {
        echo '🚀 Initiating pipeline' . PHP_EOL;

        $this->pipeline->initiate($this->subjects);

        echo 'ℹ️ Pipeline initiated with ' . count($this->pipeline->inspect()->toArray()) . ' subject(-s)' . PHP_EOL;
        echo '🏃 Running pipeline' . PHP_EOL;

        $this->pipeline->run();

        echo '🏁 Finished' . PHP_EOL;
    }
}
