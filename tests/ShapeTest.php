<?php

use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('will make a circular shaped svg', function() {
    $generator = new SvgAvatarGenerator('Walter White');

    $generator->asCircle()->render();

    expect($generator->getShape())
        ->toBe(Shape::CIRCLE)
        ->and($generator->getShape()->render())
        ->toContain('circle');
});

it('will make a rectangular shaped svg', function() {
    $generator = new SvgAvatarGenerator('Walter White');

    $generator->asRectangle()->render();

    expect($generator->getShape())
        ->toBe(Shape::RECTANGLE)
        ->and($generator->getShape()->render())
        ->toContain('rectangle');
});
