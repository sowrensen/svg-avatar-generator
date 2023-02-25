<?php

namespace Sowren\SvgAvatarGenerator;

use Str;
use Arr;
use Exception;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;

trait Tool
{
    /**
     * Extract initials from given text/name. If only one word is given,
     * it will look for second capital character in the word, else
     * the consecutive second character will be taken.
     *
     * @throws MissingTextException
     */
    protected function extractInitials(): void
    {
        $name = $this->text;

        if (Str::contains($name, ' ')) {
            // If name has more than one part then break each part upto each space
            $parts = Str::of($name)->explode(' ');
        } else {
            // If name has only one part then try to find out if there are
            // any uppercase letters in the string. Then break the string
            // upto each uppercase letters, this allows to pass names in
            // studly case, e.g. 'SowrenSen'. If no uppercase letter is
            // found, $parts will have only one item in the array.
            $parts = Str::of($name)->kebab()->replace('-', ' ')->explode(' ');
        }

        try {
            $firstInitial = $parts->first()[0];

            // If only one part is found, take the second letter as second
            // initial, else take the first letter of the last part.
            $secondInitial = ($parts->count() === 1) ? $parts->first()[1] : $parts->last()[0];
        } catch (Exception) {
            throw MissingTextException::create();
        }

        $this->setInitials(strtoupper($firstInitial . $secondInitial));
    }


    /**
     * Creates sets of colors and offsets to form the gradients.
     */
    public function zip(): array
    {
        $colors = $this->getGradientColors();
        $offsets = $this->getGradientStops();

        $hasMultipleSet = count(Arr::where($colors, fn ($color) => is_array($color))) > 0;

        return $hasMultipleSet
            ? $this->zipMultiple($colors, $offsets)
            : $this->zipOne($colors, $offsets);
    }

    /**
     * Zip one set of colors to offsets.
     */
    private function zipOne($colors, $offsets): array
    {
        $set = [];

        foreach ($offsets as $key => $offset) {
            $set[] = ['color' => $colors[$key] ?? $colors[count($colors) - 1], 'offset' => $offset];
        }

        return [$set];
    }

    /**
     * Zip multiple sets of colors to offsets.
     */
    private function zipMultiple($colors, $offsets): array
    {
        $gradientSets = [];
        foreach ($colors as $gradColors) {
            $set = [];
            foreach ($offsets as $key => $offset) {
                $color = is_array($gradColors)
                    ? $gradColors[$key] ?? $gradColors[count($gradColors) - 1]
                    : $gradColors;

                $set [] = ['color' => $color, 'offset' => $offset];
            }
            $gradientSets[] = $set;
        }

        return $gradientSets;
    }
}
