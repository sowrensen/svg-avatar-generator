<?php

namespace Sowren\SvgAvatarGenerator;

use Str;
use View;

class Svg
{
    /**
     * Gradient element ID
     */
    private string $gradientId;

    public function __construct(
        public SvgAvatarGenerator $generator
    ) {
        $this->gradientId = Str::random(32);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Build the output SVG.
     */
    protected function render(): string
    {
        return View::make('svg::elements.svg', [
            'generator' => $this->generator,
            'gradientId' => $this->gradientId
        ])->render();
    }
}
