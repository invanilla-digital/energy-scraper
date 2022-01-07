<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Input;

final class ScrapingSubject
{
    public function __construct(
        private readonly string $uri,
        private readonly string $description
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
