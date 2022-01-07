<?php

use Invanilla\EnergyScraper\Domain\Input\ScrapingSubject;
use Invanilla\EnergyScraper\Domain\Input\ScrapingSubjectCollection;

it('can be serialized into array', function () {
    $subjects = [new ScrapingSubject('http://test.test', 'test')];
    $collection = new ScrapingSubjectCollection($subjects);

    expect($collection->toArray())
        ->toBeArray()
        ->toEqual($subjects);
});

it('allows new subjects to be added', function () {
    $subjects = [new ScrapingSubject('http://test.test', 'test')];
    $collection = new ScrapingSubjectCollection($subjects);

    expect($collection->toArray())->toHaveCount(1);

    $collection->add(new ScrapingSubject('http://test2.test', 'test 2'));

    expect($collection->toArray())->toHaveCount(2);
});
