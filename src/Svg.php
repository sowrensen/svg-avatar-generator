<?php

namespace Sowren\SvgAvatarGenerator;

use Sowren\SvgAvatarGenerator\Enums\Shape;
use Str;

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
        return $this->svgElement();
    }

    /**
     * Build the output SVG.
     */
    protected function svgElement(): string
    {
        try {
            $svg = <<<SVG
                <svg 
                    width="{$this->generator->getSize()}" 
                    height="{$this->generator->getSize()}" 
                    viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" 
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                    <defs>
                        <linearGradient id="{$this->gradientId}" gradientTransform="rotate({$this->generator->getGradientRotation()})">
                            <stop offset="0%" stop-color="{$this->generator->getGradientColors()[0]}"/>
                            <stop offset="100%" stop-color="{$this->generator->getGradientColors()[1]}"/>
                        </linearGradient>
                    </defs>
                    {$this->getElement($this->generator->getShape())}
                    <text 
                        x="50%" y="50%" style="line-height: 1; 
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;"
                        alignment-baseline="middle" text-anchor="middle" 
                        font-size="{$this->generator->getFontSize()}" 
                        font-weight="{$this->generator->getFontWeight()->value}"
                        dy=".1em" dominant-baseline="middle" 
                        fill="{$this->generator->getForeground()}"
                    >
                        {$this->generator->getInitials()}
                    </text>
                </svg>
                SVG;
        } catch (\Exception $e) {
            logger($e->getMessage());
            $svg = '<svg></svg>';
        }

        return $svg;
    }

    /**
     * Find SVG element of the given shape.
     */
    protected function getElement(Shape $shape): string
    {
        return match ($shape) {
            Shape::RECTANGLE => $this->rectangleElement(),
            default => $this->circleElement(),
        };
    }

    /**
     * The circle element of SVG markup.
     */
    protected function circleElement(): string
    {
        return "<circle cx='50' cy='50' r='50' fill='url(#{$this->gradientId})'></circle>";
    }

    /**
     * The rectangle element of SVG markup.
     */
    protected function rectangleElement(): string
    {
        return "<rect width='100%' height='100%' fill='url(#{$this->gradientId})'/>";
    }
}
