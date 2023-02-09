<?php

it('will generate a url with the passed name', function () {
    $svg = new Sowren\SvgAvatarGenerator\SvgAvatarGenerator('Jon Snow');

    expect($svg->toUrl())->toBe('http://localhost/svg-avatar?text=Jon Snow');
});
