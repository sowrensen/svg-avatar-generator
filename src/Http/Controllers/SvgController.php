<?php

namespace Sowren\SvgAvatarGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

class SvgController
{
    /**
     * Generate an SVG and send it as an HTTP response.
     *
     * @param  Request  $request
     * @return Response
     *
     * @throws MissingTextException
     */
    public function __invoke(Request $request): Response
    {
        $request->validate([
            'text' => ['required'],
        ]);

        $svg = new SvgAvatarGenerator($request->input('text'));

        return response($svg->render())->header('Content-Type', 'image/svg+xml');
    }
}
