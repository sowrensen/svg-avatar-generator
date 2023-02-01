<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidSvgSizeException extends \Exception
{
    public static function create(int $size): InvalidSvgSizeException
    {
        return new self("Invalid SVG size {$size} is provided. Size should be between 16 to 512.");
    }
}
