<?php

use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('can extract initials from multiple words', function () {
    $generator = new SvgAvatarGenerator('George R. R. Martin');
    expect($generator->getInitials())->toBe('GM');
});

it('can extract initials from single word', function () {
    $generator = new SvgAvatarGenerator('Eddard');
    expect($generator->getInitials())->toBe('ED');
});

it('can extract initials from studly cased word', function () {
    $generator = new SvgAvatarGenerator('CatelynStark');
    expect($generator->getInitials())->toBe('CS');
});
