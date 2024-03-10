<?php

use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('can make gradient set from single set of colors', function () {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors('#FF0000', '#00FF00', '#0000FF') // red, green, blue
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => '#FF0000', 'offset' => 0],
            ['color' => '#00FF00', 'offset' => .5],
            ['color' => '#0000FF', 'offset' => 1],
        ],
    ]);
});

it('can make gradient set from multiple sets of colors', function () {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['#FF0000', '#00FF00', '#FFFF00'], '#0000FF') // red, green, yellow, blue
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => '#FF0000', 'offset' => 0],
            ['color' => '#00FF00', 'offset' => .5],
            ['color' => '#FFFF00', 'offset' => 1],
        ],
        [
            ['color' => '#0000FF', 'offset' => 0],
            ['color' => '#0000FF', 'offset' => .5],
            ['color' => '#0000FF', 'offset' => 1],
        ],
    ]);
});

it('will omit additional colors set more than offsets', function () {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['#FF0000', '#00FF00', '#FFFF00']) // red, green, yellow
        ->setGradientStops(0, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => '#FF0000', 'offset' => 0],
            ['color' => '#00FF00', 'offset' => 1], // yellow after green is omitted
        ],
    ]);
});

it('will repeat last color if set fewer than offsets', function () {
    $generator = new SvgAvatarGenerator();
    $generator->setGradientColors(['#FF0000', '#00FF00'], '#0000FF') // red, green, blue
        ->setGradientStops(0, .5, 1);

    expect($generator->zip())->toBe([
        [
            ['color' => '#FF0000', 'offset' => 0],
            ['color' => '#00FF00', 'offset' => .5],
            ['color' => '#00FF00', 'offset' => 1], // repeating green
        ],
        [
            ['color' => '#0000FF', 'offset' => 0],
            ['color' => '#0000FF', 'offset' => .5], // repeating blue
            ['color' => '#0000FF', 'offset' => 1], // repeating blue
        ],
    ]);
});
