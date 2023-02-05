<?php

namespace Sowren\SvgAvatarGenerator;

use Sowren\SvgAvatarGenerator\Enums\Shape;

class Svg
{
    /**
     * Fill class name used in SVG elements.
     *
     * @var string
     */
    private string $fillClassName = 'svg-fill-gradient';

    public function __construct(
        public array $config
    ) {
    }

    public function __toString(): string
    {
        return $this->svgElement();
    }

    /**
     * Build the output SVG.
     *
     * @return string
     */
    protected function svgElement(): string
    {
        try {
            $svg = <<<SVG
                <svg width="{$this->config['size']}" height="{$this->config['size']}" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <linearGradient id="{$this->fillClassName}" gradientTransform="rotate({$this->config['gradient_rotation']})">
                            <stop offset="0%" stop-color="{$this->config['gradient_colors'][0]}"/>
                            <stop offset="100%" stop-color="{$this->config['gradient_colors'][1]}"/>
                        </linearGradient>
                    </defs>
                    {$this->findElement($this->config['shape'])}
                    <text x="50%" y="50%" 
                        style="line-height: 1; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;"
                        alignment-baseline="middle" text-anchor="middle" font-size="{$this->config['font_size']}" font-weight="{$this->config['font_weight']->value}"
                        dy=".1em" dominant-baseline="middle" fill="{$this->config['foreground']}">
                        {$this->config['initials']}
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
     *
     * @param  Shape  $shape
     * @return string
     */
    protected function findElement(Shape $shape): string
    {
        return match ($shape) {
            Shape::RECTANGLE => $this->rectangleElement(),
            default => $this->circleElement(),
        };
    }

    /**
     * The circle element of SVG markup.
     *
     * @return string
     */
    protected function circleElement(): string
    {
        return "<circle cx='50' cy='50' r='50' fill='url(#{$this->fillClassName})'></circle>";
    }

    /**
     * The rectangle element of SVG markup.
     *
     * @return string
     */
    protected function rectangleElement(): string
    {
        return "<rect width='100%' height='100%' fill='url(#{$this->fillClassName})'/>";
    }
}
