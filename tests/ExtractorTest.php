<?php

test('it can extract initials from multiple words', function () {
    $generator = new \Sowren\SvgAvatarGenerator\SvgAvatarGenerator('George R. R. Martin');
    expect($generator->getInitials())->toBe('GM');
});

test('it can extract initials from single word', function () {
    $generator = new Sowren\SvgAvatarGenerator\SvgAvatarGenerator('Eddard');
    expect($generator->getInitials())->toBe('ED');
});

test('it can extract initials from studly cased word', function () {
    $generator = new Sowren\SvgAvatarGenerator\SvgAvatarGenerator('EddardStark');
    expect($generator->getInitials())->toBe('ES');
});
