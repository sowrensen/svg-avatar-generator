<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidGradientRotationException extends \Exception
{
    public static function create(int $angle): InvalidGradientRotationException
    {
        return new self("Invalid value {$angle} for gradient rotation is provided. Gradient rotation angle should be between 0 to 360.");
    }
}
