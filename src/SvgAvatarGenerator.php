<?php

namespace Sowren\SvgAvatarGenerator;

use Exception;
use Illuminate\Support\Str;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;
use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;

class SvgAvatarGenerator
{
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
     * Colors used for gradient, use same colors for a plain SVG.
     */
    protected array $gradientColors;

    /**
     * Array to hold default config.
     */
    private array $config;

    /**
     * @throws InvalidSvgSizeException
     * @throws InvalidFontSizeException
     * @throws InvalidGradientRotationException
     */
    public function __construct(public ?string $text = null)
    {
        $this->config = config('svg-avatar');
        $this->build();
    }

    /**
     * Set the text or name to be used in the SVG. If only one word
     * is given, it will look for second capital character in the
     * word, else the consecutive second character will be taken.
     *
     * Examples:
     *
     * 'John Doe' will produce 'JD'
     *
     * 'JohnDoe' will produce 'JD'
     *
     * 'Johndoe' will produce 'JO'
     *
     * 'JohndoE' will produce 'JE'
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
     * Set the two colors (hex) for gradient, use same color for
     * a plain or flat SVG output.
     */
    public function setGradientColors(string $firstColor, string $secondColor): static
    {
        $this->gradientColors[0] = $firstColor;
        $this->gradientColors[1] = $secondColor;

        return $this;
    }

    /**
     * Extract initials from given text/name. If only one word is given,
     * it will look for second capital character in the word, else
     * the consecutive second character will be taken.
     *
     * @throws MissingTextException
     */
    protected function extractInitials(): static
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

        return $this;
    }

    /**
     * Set default values from config.
     *
     * @throws InvalidFontSizeException
     * @throws InvalidGradientRotationException
     * @throws InvalidSvgSizeException
     */
    protected function build(): void
    {
        $this
            ->setSize($this->config['size'])
            ->setShape($this->config['shape'])
            ->setFontSize($this->config['font_size'])
            ->setFontWeight($this->config['font_weight'])
            ->setForeground($this->config['foreground'])
            ->setGradientRotation($this->config['gradient_rotation'])
            ->setGradientColors(
                $this->config['gradient_colors'][0],
                $this->config['gradient_colors'][1]
            );
    }

    /**
     * Render the SVG.
     *
     * @throws MissingTextException
     */
    public function render(): Svg
    {
        $this->extractInitials();

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
