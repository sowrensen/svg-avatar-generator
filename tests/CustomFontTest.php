<?php

use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('will have a custom font family defined', function() {
    $generator = new SvgAvatarGenerator('Saul Goodman');

    $svg = (string) $generator
        ->setCustomFontUrl('https://api.fontshare.com/v2/css?f[]=kola@400&display=swap')
        ->setFontFamily('Kola')
        ->render();

    expect($svg)
        ->toContain('Kola')
        ->toContain("@import url(https://api.fontshare.com");
});
