<?php

namespace Sowren\SvgAvatarGenerator\Exceptions;

class InvalidUrlException extends \Exception
{
    public static function create(string $url): InvalidUrlException
    {
        return new self("Invalid URL {$url} is provided.");
    }
}
