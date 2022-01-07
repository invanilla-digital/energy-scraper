<?php

declare(strict_types=1);

namespace Invanilla\EnergyScraper\Domain\Input;

final class ScrapingSubjectCollection
{
    /**
     * @param ScrapingSubject[] $subjects
     */
    public function __construct(
        private array $subjects = []
    ) {
    }

    public function add(ScrapingSubject $subject): self
    {
        $this->subjects[] = $subject;

        return $this;
    }

    /**
     * @return ScrapingSubject[]
     */
    public function toArray(): array
    {
        return $this->subjects;
    }
}
