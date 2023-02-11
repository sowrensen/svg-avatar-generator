<?php

use Sowren\SvgAvatarGenerator\Svg;
use Sowren\SvgAvatarGenerator\Http\Controllers\SvgController;

it('will generate a url with the passed name', function() {
    $svg = new Sowren\SvgAvatarGenerator\SvgAvatarGenerator('Jon Snow');

    expect($svg->toUrl())->toBe('http://localhost/svg-avatar?text=Jon Snow');
});


it('will respond back with a svg content', function() {
    $object = app()->make(SvgController::class);

    $req = new \Illuminate\Http\Request(['text' => 'Jon Snow']);

    $res = $object($req);
    $content = $res->getOriginalContent();

    expect($res)
        ->toBeInstanceOf(\Illuminate\Http\Response::class)
        ->toHaveProperties(['headers', 'content'])
        ->and($res->headers->get('content-type'))->toBe('image/svg+xml')
        ->and($content)->toBeInstanceOf(Svg::class)
        ->and($content->generator->getInitials())->toBe('JS');
});
