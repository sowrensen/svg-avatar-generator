<?php

namespace Sowren\SvgAvatarGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

class SvgController extends Controller
{
    public function __construct()
    {
        $this->middleware(config('svg-avatar.middleware'));
    }

    /**
     * Generate an SVG and send it as an HTTP response.
     */
    public function __invoke(Request $request): Response
    {
        $svg = new SvgAvatarGenerator($request->input('text'));

        return response($svg->render())->header('Content-Type', 'image/svg+xml');
    }
}
