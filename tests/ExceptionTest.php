<?php

use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientStopException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidUrlException;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('will throw exception if svg size less than minimum is provided', function () {
    config(['svg-avatar.size' => 8]);
    new SvgAvatarGenerator('Rob Stark');
})->throws(InvalidSvgSizeException::class);

it('will throw exception if svg size greater than maximum is provided', function () {
    config(['svg-avatar.size' => 1024]);
    new SvgAvatarGenerator('Jon Snow');
})->throws(InvalidSvgSizeException::class);

it('will throw exception if font size less than minimum is provided', function () {
    config(['svg-avatar.font_size' => 9]);
    new SvgAvatarGenerator('Sansa Stark');
})->throws(InvalidFontSizeException::class);

it('will throw exception if font size greater than maximum is provided', function () {
    config(['svg-avatar.font_size' => 51]);
    new SvgAvatarGenerator('Arya Stark');
})->throws(InvalidFontSizeException::class);

it('will throw exception if gradient rotation less than minimum is provided', function () {
    config(['svg-avatar.gradient_rotation' => -1]);
    new SvgAvatarGenerator('Brandon Stark');
})->throws(InvalidGradientRotationException::class);

it('will throw exception if gradient rotation greater than maximum is provided', function () {
    config(['svg-avatar.gradient_rotation' => 361]);
    new SvgAvatarGenerator('Rickon Stark');
})->throws(InvalidGradientRotationException::class);

it('will throw missing text exception if text is not set', function () {
    $generator = new SvgAvatarGenerator();
    $generator->getInitials();
})->throws(MissingTextException::class);

it('will throw exception if gradient stop less than minimum is provided', function () {
    config(['svg-avatar.gradient_stops' => [-1, 1]]);
    new SvgAvatarGenerator('Lyanna Stark');
})->throws(InvalidGradientStopException::class);

it('will throw exception if gradient stop greater than maximum is provided', function () {
    config(['svg-avatar.gradient_stops' => [0, 2]]);
    new SvgAvatarGenerator('Benjen Stark');
})->throws(InvalidGradientStopException::class);

it('will throw exception if invalid font url is provided', function () {
    config(['svg-avatar.custom_font_url' => 'invalid_url']);
    new SvgAvatarGenerator('Rickard Stark');
})->throws(InvalidUrlException::class);
