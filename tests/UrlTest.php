<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Sowren\SvgAvatarGenerator\Http\Controllers\SvgController;
use Sowren\SvgAvatarGenerator\Svg;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

it('will generate a url with the passed name', function () {
    $svg = new SvgAvatarGenerator('Jon Snow');

    expect($svg->toUrl())->toBe('http://localhost/svg-avatar?text=Jon Snow');
});

it('will respond back with a svg content', function () {
    $object = app()->make(SvgController::class);

    $request = new Request(['text' => 'Jon Snow']);

    $response = $object($request);
    $content = $response->getOriginalContent();

    expect($response)
        ->toBeInstanceOf(Response::class)
        ->toHaveProperties(['headers', 'content'])
        ->and($response->headers->get('content-type'))->toBe('image/svg+xml')
        ->and($content)->toBeInstanceOf(Svg::class)
        ->and($content->generator->getInitials())->toBe('JS');
});

it('will throw missing text exception if text is not set', function () {
    $object = app()->make(SvgController::class);

    $request = new Request;

    $object($request);
})->throws(ValidationException::class);
