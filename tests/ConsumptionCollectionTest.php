<?php

use Invanilla\EnergyScraper\Domain\Output\Consumption;
use Invanilla\EnergyScraper\Domain\Output\ConsumptionCollection;

it('can be serialized into array', function () {
    $consumption = [
        new Consumption(
            'test', 'test', '2020-01', '2.34'
        )
    ];

    $collection = new ConsumptionCollection($consumption);

    expect($collection->toArray())->toBeArray()->toEqual($consumption);
});

it('allows new consumption to be added', function () {
    $consumption = [
        new Consumption(
            'test', 'test', '2020-01', '2.34'
        )
    ];

    $collection = new ConsumptionCollection($consumption);

    expect($collection->toArray())->toHaveCount(1);

    $collection->add(
        new Consumption(
            'test', 'test', '2020-02', '2.34'
        )
    );

    expect($collection->toArray())->toHaveCount(2);
});
