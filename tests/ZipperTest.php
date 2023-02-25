<?php

use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('can make gradient set from single set of colors', function() {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors('red', 'green', 'blue')
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => 'red', 'offset' => 0],
            ['color' => 'green', 'offset' => .5],
            ['color' => 'blue', 'offset' => 1]
        ]
    ]);
});

it('can make gradient set from multiple sets of colors', function() {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['red', 'green', 'yellow'], 'blue')
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => 'red', 'offset' => 0],
            ['color' => 'green', 'offset' => .5],
            ['color' => 'yellow', 'offset' => 1]
        ],
        [
            ['color' => 'blue', 'offset' => 0],
            ['color' => 'blue', 'offset' => .5],
            ['color' => 'blue', 'offset' => 1]
        ]
    ]);
});

it('will omit additional colors set more than offsets', function() {
     $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['red', 'green', 'yellow'])
        ->setGradientStops(0, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => 'red', 'offset' => 0],
            ['color' => 'green', 'offset' => 1], // yellow after green is omitted
        ]
    ]);
});

it('will repeat last color if set fewer than offsets', function() {
     $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['red', 'green'], 'blue')
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => 'red', 'offset' => 0],
            ['color' => 'green', 'offset' => .5],
            ['color' => 'green', 'offset' => 1], // repeating green
        ],
        [
            ['color' => 'blue', 'offset' => 0],
            ['color' => 'blue', 'offset' => .5], // repeating blue
            ['color' => 'blue', 'offset' => 1], // repeating blue
        ]
    ]);
});
