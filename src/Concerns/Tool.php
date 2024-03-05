<?php

namespace Sowren\SvgAvatarGenerator\Concerns;

use Arr;
use Sowren\SvgAvatarGenerator\Validators\ConfigValidator;

trait Tool
{
    /**
     * Extract initials using configured extractor.
     */
    protected function extractInitials(): void
    {
        ConfigValidator::validate('svg_text', $this->text);

        $initials = $this->extractor->extract($this->text);
        $this->setInitials($initials);
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

                $set[] = ['color' => $color, 'offset' => $offset];
            }
            $gradientSets[] = $set;
        }

        return $gradientSets;
    }
}
