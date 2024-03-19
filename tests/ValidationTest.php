<?php

use Illuminate\Validation\ValidationException;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('will throw exception if svg size less than minimum is provided', function () {
    config(['svg-avatar.size' => 8]);
    new SvgAvatarGenerator('Rob Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The svg size(?: field)? must be between 16 and 512/');

it('will throw exception if svg size greater than maximum is provided', function () {
    config(['svg-avatar.size' => 1024]);
    new SvgAvatarGenerator('Jon Snow');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The svg size(?: field)? must be between 16 and 512/');

it('will throw exception if font size less than minimum is provided', function () {
    config(['svg-avatar.font_size' => 9]);
    new SvgAvatarGenerator('Sansa Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The font size(?: field)? must be between 10 and 50/');

it('will throw exception if font size greater than maximum is provided', function () {
    config(['svg-avatar.font_size' => 51]);
    new SvgAvatarGenerator('Arya Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The font size(?: field)? must be between 10 and 50/');

it('will throw exception if gradient rotation less than minimum is provided', function () {
    config(['svg-avatar.gradient_rotation' => -1]);
    new SvgAvatarGenerator('Brandon Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient rotation(?: field)? must be between 0 and 360/');

it('will throw exception if gradient rotation greater than maximum is provided', function () {
    config(['svg-avatar.gradient_rotation' => 361]);
    new SvgAvatarGenerator('Rickon Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient rotation(?: field)? must be between 0 and 360/');

it('will throw missing text exception if text is not set', function () {
    $generator = new SvgAvatarGenerator();
    $generator->getInitials();
})->throws(ValidationException::class, 'The svg text field is required');

it('will throw exception if gradient stop less than minimum is provided', function () {
    config(['svg-avatar.gradient_stops' => [-1, 0.5]]);
    new SvgAvatarGenerator('Lyanna Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient_stops.0(?: field)? must be between 0 and 1/');

it('will throw exception if gradient stop greater than maximum is provided', function () {
    config(['svg-avatar.gradient_stops' => [0.2, 2]]);
    new SvgAvatarGenerator('Benjen Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient_stops.1(?: field)? must be between 0 and 1/');

it('will throw exception if invalid font url is provided', function () {
    config(['svg-avatar.custom_font_url' => 'invalid_url']);
    new SvgAvatarGenerator('Rickard Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The custom font url(?: field)? must be a valid URL/');

it('will throw exception if invalid foreground color is provided', function () {
    config(['svg-avatar.foreground' => 'red']); // named colors are not supported since 2.0.0
    new SvgAvatarGenerator('Eddard Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The foreground(?: field)? must be a valid hexadecimal color/');

it('will throw exception if invalid gradient colors are provided', function () {
    config(['svg-avatar.gradient_colors' => ['#00FF00', 'red']]); // named colors are not supported since 2.0.0
    new SvgAvatarGenerator('Catelyn Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient colors.1(?: field)? must be a valid hexadecimal color/');

it('will throw exception if gradient color structure is wrong', function () {
    config([
        'svg-avatar.gradient_colors' => [
            '#00FF00',
            [['#FF0000']],
        ],
    ]); // named colors are not supported since 2.0.0
    new SvgAvatarGenerator('Theon Stark');
})->throws(ValidationException::class)->expectExceptionMessageMatches('/The gradient colors.1.0(?: field)? must be a valid hexadecimal color/');
