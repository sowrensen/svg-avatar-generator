<?php

namespace Sowren\SvgAvatarGenerator\Extractors;

use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;

interface Extractor
{
    /**
     * Extract initials from given text.
     */
    public function extract(string $text): string;
}
