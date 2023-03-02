<?php

namespace Sowren\SvgAvatarGenerator\Extractors;

use Str;

class DefaultExtractor implements Extractor
{
    /**
     * Extract initials from given text/name. If only one word is given,
     * it will look for second capital character in the word, else
     * the consecutive second character will be taken.
     */
    public function extract(string $text): string
    {
        if (Str::contains($text, ' ')) {
            // If name has more than one part then break each part upto each space
            $parts = Str::of($text)->explode(' ');
        } else {
            // If name has only one part then try to find out if there are
            // any uppercase letters in the string. Then break the string
            // upto each uppercase letters, this allows to pass names in
            // studly case, e.g. 'SowrenSen'. If no uppercase letter is
            // found, $parts will have only one item in the array.
            $parts = Str::of($text)->kebab()->replace('-', ' ')->explode(' ');
        }

        $firstInitial = $parts->first()[0];

        // If only one part is found, take the second letter as second
        // initial, else take the first letter of the last part.
        $secondInitial = ($parts->count() === 1) ? $parts->first()[1] : $parts->last()[0];

        return strtoupper($firstInitial . $secondInitial);
    }
}
