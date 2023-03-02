<?php

namespace Sowren\SvgAvatarGenerator\Extractors;

interface Extractor
{
    /**
     * Extract initials from given text.
     */
    public function extract(string $text): string;
}
