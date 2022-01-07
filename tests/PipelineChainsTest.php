<?php

use Invanilla\EnergyScraper\Domain\Pipeline\PipelineChains;

it('can be serialized into array', function () {
    $expectedArray = [
        'one plus one' => fn() => 1 + 1
    ];
    $chains = new PipelineChains(
        $expectedArray
    );

    expect($chains->toArray())
        ->toBeArray()
        ->toEqual($expectedArray);
});

it('allows new chains to be added', function () {
    $chains = new PipelineChains(
        [
            'one plus one' => fn() => 1 + 1
        ]
    );

    expect($chains->toArray())->toHaveCount(1);

    $chains->add('hello', fn() => 2 + 2);

    expect($chains->toArray())->toHaveCount(2);
});

it('does not allow non unique chain names', function () {
    $chains = new PipelineChains(
        [
            'world' => fn() => 1 + 1
        ]
    );

    $chains->add('world', fn() => 1 + 1);
})->throws(
    LogicException::class,
    "Pipeline chain name must be unique `world`"
);

