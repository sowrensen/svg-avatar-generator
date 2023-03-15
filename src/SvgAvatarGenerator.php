<?php

namespace Sowren\SvgAvatarGenerator;

use Arr;
use Sowren\SvgAvatarGenerator\Concerns\Tool;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;
use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidCornerRadius;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientStopException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\Extractors\Extractor;

class SvgAvatarGenerator
{
    use Tool;

    /**
     * Initials to be put in SVG.
     */
    protected string $initials = '';

    /**
     * Size of the SVG.
     */
    protected int $size;

    /**
     * Shape of the SVG, either Circle or Rectangle.
     */
    protected Shape $shape;

    protected int $cornerRadius;

    /**
     * Font size of the SVG.
     */
    protected int $fontSize;

    /**
     * Font weight of the SVG, Regular, Medium, Semibold, or Bold.
     */
    protected FontWeight $fontWeight;

    /**
     * Foreground color of the SVG.
     */
    protected string $foreground;

    /**
     * Angle of rotation of the color gradients.
     */
    protected int $gradientRotation;

    /**
     * Colors used to portray gradient.
     */
    protected array $gradientColors;

    /**
     * Positions of gradient color stops.
     */
    protected array $gradientStops;

    /**
     * Picked set of gradient color and offset.
     */
    protected array $gradientSet;

    /**
     * Array to hold default config.
     */
    private array $config;

    /**
     * Instance of predefined extractor.
     */
    public Extractor $extractor;

    /**
     * @throws InvalidCornerRadius
     * @throws InvalidSvgSizeException
     * @throws InvalidFontSizeException
     * @throws InvalidGradientStopException
     * @throws InvalidGradientRotationException
     */
    public function __construct(public ?string $text = null)
    {
        $this->config = config('svg-avatar');
        $this->extractor = app(Extractor::class);
        $this->build();
    }

    /**
     * Set the text or name to be used in the SVG.
     */
    public function for(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get generated initials.
     *
     * @throws MissingTextException
     */
    public function getInitials(): string
    {
        if (! $this->initials) {
            $this->extractInitials();
        }

        return $this->initials;
    }

    /**
     * Set the initials.
     */
    protected function setInitials(string $initials): static
    {
        $this->initials = $initials;

        return $this;
    }

    /**
     * Get SVG size.
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Set the SVG size between 16 and 512. The generated
     * SVG is square always.
     *
     * @throws InvalidSvgSizeException
     */
    public function setSize(int $size): static
    {
        if ($size < 16 || $size > 512) {
            throw InvalidSvgSizeException::create($size);
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Get the shape of the SVG.
     */
    public function getShape(): Shape
    {
        return $this->shape;
    }

    /**
     * Set the shape of the SVG. It can either be Circle,
     * or can be Rectangle.
     */
    protected function setShape(Shape $shape): static
    {
        return $shape === Shape::CIRCLE ? $this->asCircle() : $this->asRectangle();
    }

    /**
     * Set circle as output SVG shape.
     */
    public function asCircle(): static
    {
        $this->shape = Shape::CIRCLE;

        return $this;
    }

    /**
     * Set rectangle as output SVG shape.
     */
    public function asRectangle(): static
    {
        $this->shape = Shape::RECTANGLE;

        return $this;
    }

    /**
     * Get corner radius of rectangular shape.
     */
    public function getCornerRadius(): int
    {
        return $this->cornerRadius;
    }

    /**
     * Set corner radius of rectangular shape.
     *
     * @throws InvalidCornerRadius
     */
    public function setCornerRadius(int $radius): static
    {
        if ($radius < 0 || $radius > 25) {
            throw InvalidCornerRadius::create($radius);
        }

        $this->cornerRadius = $radius;

        return $this;
    }

    /**
     * Get the font size.
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * Set font size of the SVG between 10 and 50.
     *
     * @throws InvalidFontSizeException
     */
    public function setFontSize(int $fontSize): static
    {
        if ($fontSize < 10 || $fontSize > 50) {
            throw InvalidFontSizeException::create($fontSize);
        }

        $this->fontSize = $fontSize;

        return $this;
    }

    /**
     * Get the font weight.
     */
    public function getFontWeight(): FontWeight
    {
        return $this->fontWeight;
    }

    /**
     * Set the font weight of the SVG. It can be Regular,
     * Medium, Semibold, or Bold.
     */
    public function setFontWeight(FontWeight $fontWeight): static
    {
        $this->fontWeight = $fontWeight;

        return $this;
    }

    /**
     * Get the foreground (font) color.
     */
    public function getForeground(): string
    {
        return $this->foreground;
    }

    /**
     * Set the foreground (font) color of the SVG.
     */
    public function setForeground(string $color): static
    {
        $this->foreground = $color;

        return $this;
    }

    /**
     * Get the angle of color gradient rotation.
     */
    public function getGradientRotation(): int
    {
        return $this->gradientRotation;
    }

    /**
     * Set the angle of the color gradient rotation between 0 and 360.
     *
     * @throws InvalidGradientRotationException
     */
    public function setGradientRotation(int $angle): static
    {
        if ($angle < 0 || $angle > 360) {
            throw InvalidGradientRotationException::create($angle);
        }

        $this->gradientRotation = $angle;

        return $this;
    }

    /**
     * Get the gradient colors.
     */
    public function getGradientColors(): array
    {
        return $this->gradientColors;
    }

    /**
     * Set the colors (hex) for gradient. Colors can either be passed
     * as single or in pairs for random gradient generation.
     *
     * Examples:
     *
     * Passing ('red', 'green', 'blue') will be considered as single
     * set of colors and will generate a gradient consisting these
     * three colors.
     *
     * Passing (['red', 'green'], 'blue') will be considered as two
     * different sets of colors and will generate random gradient
     * consisting either red/green or blue background.
     */
    public function setGradientColors(string|array ...$colors): static
    {
        $this->gradientColors = $colors;

        return $this;
    }

    /**
     * Get the gradient colors.
     */
    public function getGradientStops(): array
    {
        return $this->gradientStops;
    }

    /**
     * Set stop positions of gradients.
     *
     * @throws InvalidGradientStopException
     */
    public function setGradientStops(int|float ...$offsets): static
    {
        if ((min($offsets) < 0) || max($offsets) > 1) {
            throw InvalidGradientStopException::create($offsets);
        }

        $this->gradientStops = $offsets;

        return $this;
    }

    /**
     * Returns the picked combination of colors
     * for gradient.
     */
    public function getGradientSet(): array
    {
        return $this->gradientSet;
    }

    /**
     * Set combination of colors and offsets.
     */
    protected function setGradientSet(): static
    {
        // Choose one randomly from the list
        // of prepared gradient sets.
        $set = Arr::random($this->zip());

        $this->gradientSet = $set;

        return $this;
    }

    /**
     * Set default values from config.
     *
     * @throws InvalidCornerRadius
     * @throws InvalidFontSizeException
     * @throws InvalidGradientRotationException
     * @throws InvalidSvgSizeException
     * @throws InvalidGradientStopException
     */
    protected function build(): void
    {
        $this
            ->setSize($this->config['size'])
            ->setShape($this->config['shape'])
            ->setCornerRadius($this->config['corner_radius'])
            ->setFontSize($this->config['font_size'])
            ->setFontWeight($this->config['font_weight'])
            ->setForeground($this->config['foreground'])
            ->setGradientRotation($this->config['gradient_rotation'])
            ->setGradientColors(...$this->config['gradient_colors'])
            ->setGradientStops(...$this->config['gradient_stops']);
    }

    /**
     * Render the SVG.
     *
     * @throws MissingTextException
     */
    public function render(): Svg
    {
        $this->extractInitials();
        $this->setGradientSet();

        return new Svg($this);
    }

    /**
     * Output the SVG as an HTTP url.
     */
    public function toUrl(): string
    {
        return url("{$this->config['url']}?text={$this->text}");
    }
}
