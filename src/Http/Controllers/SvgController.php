<?php

namespace Sowren\SvgAvatarGenerator\Http\Controllers;

use Illuminate\Http\Request;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

class SvgController
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'text' => ['required'],
        ]);

        $svg = new SvgAvatarGenerator($request->input('text'));

        return response($svg->render())->header('Content-Type', 'image/svg+xml');
    }
}
