<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidGradientStopException extends \Exception
{
    public static function create(array $offsets): InvalidGradientStopException
    {
        $values = implode(',', $offsets);

        return new self("Invalid value [{$values}] for gradient stop is provided. Gradient stops must be between 0 and 1.");
    }
}
