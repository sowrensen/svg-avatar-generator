<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SVG Image Size
    |--------------------------------------------------------------------------
    |
    | Generated images are square, this is done intentionally so that the
    | rendering of circular shaped images are perfect. So instead of
    | height and width we will set size.
    |
    | Default: 128
    | Allowed values: 16 to 512
    |
    */
    'size' => 128,

    'shape' => \Sowren\SvgAvatarGenerator\Enums\Shape::CIRCLE, // or Shape::Rectangle

    'font_size' => 48, // from 10 to 50

    'font_weight' => \Sowren\SvgAvatarGenerator\Enums\FontWeight::BOLD,

    'foreground' => '#FFFFFF',

    'gradient_rotation' => 115, // from 0 to 360

    'gradient_colors' => ['#F6A905', '#E86F85'], // only two are allowed, provide same colors for plain

    'url' => 'svg-avatar',
];
