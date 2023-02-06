<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class MissingTextException extends \Exception
{
    public static function create(): MissingTextException
    {
        return new self('SVG text is not set, call for($text) method to set the text/name.');
    }
}
