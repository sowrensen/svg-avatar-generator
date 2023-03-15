<?php

namespace Sowren\SvgAvatarGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidCornerRadius;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientStopException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

class SvgController extends Controller
{
    public function __construct()
    {
        $this->middleware(config('svg-avatar.middleware'));
    }

    /**
     * Generate an SVG and send it as an HTTP response.
     *
     * @throws InvalidCornerRadius
     * @throws MissingTextException
     * @throws InvalidSvgSizeException
     * @throws InvalidFontSizeException
     * @throws InvalidGradientStopException
     * @throws InvalidGradientRotationException
     */
    public function __invoke(Request $request): Response
    {
        $svg = new SvgAvatarGenerator($request->input('text'));

        return response($svg->render())->header('Content-Type', 'image/svg+xml');
    }
}
