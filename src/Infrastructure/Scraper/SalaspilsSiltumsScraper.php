<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Infrastructure\Scraper;

use Goutte\Client;
use Invanilla\EnergyScraper\Domain\Input\ScrapingSubject;
use Invanilla\EnergyScraper\Domain\Output\Consumption;
use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;
use Invanilla\EnergyScraper\Domain\Scraper\ScraperInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\DomCrawler\Crawler;

class SalaspilsSiltumsScraper implements ScraperInterface
{
    public function __construct(
        private readonly Client $browser = new Client()
    ) {
    }

    public function scrape(ScrapingSubject $subject): ConsumptionCollection
    {
        $crawler = $this->browser->request('GET', $subject->getUri());

        $availableYearsInformation = $crawler->filter('.term-filter a')->each(function (Crawler $node) {
            return ['uri' => $node->attr('href'), 'year' => $node->text()];
        });

        $rawData = [];

        foreach ($availableYearsInformation as $yearInformation) {
            $rawData[$yearInformation['year']] = $this->scrapePage($yearInformation['uri']);
        }

        return new ConsumptionCollection(
            $this->transformRawDataIntoConsumption($rawData)
        );
    }

    #[Pure]
    public function canScrape(ScrapingSubject $subject): bool
    {
        return str_starts_with(
            $subject->getUri(),
            'https://salaspilssiltums.lv/klientiem/maju-paterini/gads/'
        );
    }

    private function scrapePage(string $uri): array
    {
        return $this->browser->request('GET', $uri)
            ->filter('.dt tr')
            ->each(function (Crawler $crawler) {
                return $crawler->filter('td')
                    ->each(function (Crawler $crawler) {
                        return $crawler->text();
                    });
            });
    }

    /**
     * @param array $rawData
     * @return Consumption[]
     */
    private function transformRawDataIntoConsumption(array $rawData): array
    {
        $consumption = [];

        foreach ($rawData as $year => $rows) {
            foreach ($rows as $row) {
                $monthlyConsumption = array_slice($row, 1);
                foreach ($monthlyConsumption as $monthIndex => $monthConsumption) {
                    $consumption[] = new Consumption(
                        street:         $row[0],
                        representative: $row[1],
                        yearAndMonth:   $year . '-' . $monthIndex,
                        consumptionMWH: $monthConsumption
                    );
                }
            }
        }

        return $consumption;
    }
}
