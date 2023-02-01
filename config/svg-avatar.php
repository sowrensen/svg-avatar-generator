<?php

return [
    'size' => 128, // From 16 to 512

    'shape' => \Sowren\SvgAvatarGenerator\Enums\Shape::CIRCLE, // or Shape::Rectangle

    'font_size' => 48, // from 10 to 50

    'font_weight' => \Sowren\SvgAvatarGenerator\Enums\FontWeight::BOLD,

    'foreground' => '#FFFFFF',

    'gradient_rotation' => 115, // from 0 to 360

    'gradient_colors' => ['#F6A905', '#E86F85'], // only two are allowed, provide same colors for plain

    'url' => 'svg-avatar',
];
