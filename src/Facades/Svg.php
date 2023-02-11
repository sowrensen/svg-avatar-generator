<?php

namespace Sowren\SvgAvatarGenerator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sowren\SvgAvatarGenerator\SvgAvatarGenerator
 */
class Svg extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Sowren\SvgAvatarGenerator\SvgAvatarGenerator::class;
    }
}