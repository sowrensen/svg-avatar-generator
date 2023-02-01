<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidFontSizeException extends \Exception
{
    public static function create(int $fontSize): InvalidFontSizeException
    {
        return new self("Invalid font size {$fontSize} is provided. Font size should be between 10 to 50.");
    }
}
