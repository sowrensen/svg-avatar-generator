<?php

namespace Sowren\SvgAvatarGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;

class SvgController
{
    /**
     * Generate an SVG and send it as an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     *
     * @throws MissingTextException
     * @throws InvalidSvgSizeException
     * @throws InvalidFontSizeException
     * @throws InvalidGradientRotationException
     */
    public function __invoke(Request $request): Response
    {
        $svg = new SvgAvatarGenerator($request->input('text'));

        return response($svg->render())->header('Content-Type', 'image/svg+xml');
    }
}
