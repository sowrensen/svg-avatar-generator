<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidUrlException extends \Exception
{
    public static function create(string $url): InvalidUrlException
    {
        return new self("`{$url}` is not a valid URL.");
    }
}
