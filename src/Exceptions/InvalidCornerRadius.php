<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidCornerRadius extends \Exception
{
    public static function create(int $radius): InvalidCornerRadius
    {
        return new self("Invalid corner radius {$radius} is provided. Corner radius should be between 0 to 25.");
    }
}
