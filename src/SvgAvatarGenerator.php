<?php

namespace Sowren\SvgAvatarGenerator;

use Illuminate\Support\Str;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;
use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;

class SvgAvatarGenerator
{
    protected int $size;

    protected Shape $shape;

    protected int $fontSize;

    protected FontWeight $fontWeight;

    protected string $foreground;

    protected int $gradientRotation;

    protected array $gradientColors;

    private string $fillClassName = 'svg-fill-gradient';

    private array $config = [];

    public function __construct(public string $text = '')
    {
        $this->config = config('svg-avatar');
        $this->build();
    }

    public function for(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function size(int $size): static
    {
        if ($size < 16 || $size > 512) {
            throw InvalidSvgSizeException::create($size);
        }

        $this->size = $size;

        return $this;
    }

    protected function shape(Shape $shape): static
    {
        return $shape === Shape::CIRCLE ? $this->circle() : $this->rectangle();
    }

    public function circle(): static
    {
        $this->shape = Shape::CIRCLE;

        return $this;
    }

    public function rectangle(): static
    {
        $this->shape = Shape::RECTANGLE;

        return $this;
    }

    public function fontSize(int $fontSize): static
    {
        if ($fontSize < 10 || $fontSize > 50) {
            throw InvalidFontSizeException::create($fontSize);
        }

        $this->fontSize = $fontSize;

        return $this;
    }

    public function fontWeight(FontWeight $fontWeight): static
    {
        $this->fontWeight = $fontWeight;

        return $this;
    }

    public function foreground(string $color): static
    {
        $this->foreground = $color;

        return $this;
    }

    public function gradientRotation(int $angle): static
    {
        if ($angle < 0 || $angle > 360) {
            throw InvalidGradientRotationException::create($angle);
        }

        $this->gradientRotation = $angle;

        return $this;
    }

    public function gradientColors(string $colorA, string $colorB): static
    {
        $this->gradientColors[0] = $colorA;
        $this->gradientColors[1] = $colorB;

        return $this;
    }

    protected function extractInitials(string $name): string
    {
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

        $firstInitial = $parts->first()[0];

        // If only one part is found, take the second letter as second
        // initial, else take the first letter of the last part.
        $secondInitial = ($parts->count() === 1) ? $parts->first()[1] : $parts->last()[0];

        return strtoupper($firstInitial.$secondInitial);
    }

    protected function circleElement(): string
    {
        return "<circle cx='50' cy='50' r='50' fill='url(#{$this->fillClassName})'></circle>";
    }

    protected function rectangleElement(): string
    {
        return "<rect width='100%' height='100%' fill='url(#{$this->fillClassName})'/>";
    }

    protected function svgElement(string $initials, string $shape): string
    {
        try {
            $svg = <<<SVG
                <svg width="{$this->size}" height="{$this->size}" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <linearGradient id="{$this->fillClassName}" gradientTransform="rotate({$this->gradientRotation})">
                            <stop offset="0%" stop-color="{$this->gradientColors[0]}"/>
                            <stop offset="100%" stop-color="{$this->gradientColors[1]}"/>
                        </linearGradient>
                    </defs>
                    {$shape}
                    <text x="50%" y="50%" 
                        style="line-height: 1; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;"
                        alignment-baseline="middle" text-anchor="middle" font-size="{$this->fontSize}" font-weight="{$this->fontWeight->value}"
                        dy=".1em" dominant-baseline="middle" fill="{$this->foreground}">
                        {$initials}
                    </text>
                </svg>
                SVG;
        } catch (\Exception $e) {
            logger($e->getMessage());
            $svg = '<svg></svg>';
        }

        return $svg;
    }

    protected function build(): void
    {
        $this
            ->size($this->config['size'])
            ->shape($this->config['shape'])
            ->fontSize($this->config['font_size'])
            ->fontWeight($this->config['font_weight'])
            ->foreground($this->config['foreground'])
            ->gradientRotation($this->config['gradient_rotation'])
            ->gradientColors(
                $this->config['gradient_colors'][0],
                $this->config['gradient_colors'][1]
            );
    }

    public function render(): string
    {
        if (! $this->text) {
            throw new \Exception("SVG text is not set, did you forget to call for('my name') method?");
        }

        $initials = $this->extractInitials($this->text);

        $shape = match ($this->shape) {
            Shape::RECTANGLE => $this->rectangleElement(),
            default => $this->circleElement(),
        };

        return $this->svgElement($initials, $shape);
    }

    public function toUrl(): string
    {
        return url("{$this->config['url']}?text={$this->text}");
    }
}
