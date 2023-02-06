<?php

namespace Sowren\SvgAvatarGenerator;

use Illuminate\Support\Str;
use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;
use Sowren\SvgAvatarGenerator\Exceptions\MissingTextException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidSvgSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidFontSizeException;
use Sowren\SvgAvatarGenerator\Exceptions\InvalidGradientRotationException;

class SvgAvatarGenerator
{
    /**
     * Size of the SVG.
     *
     * @var int
     */
    protected int $size;

    /**
     * Shape of the SVG, either Circle or Rectangle.
     *
     * @var Shape
     */
    protected Shape $shape;

    /**
     * Font size of the SVG.
     *
     * @var int
     */
    protected int $fontSize;

    /**
     * Font weight of the SVG, Regular, Medium, Semibold, or Bold.
     *
     * @var FontWeight
     */
    protected FontWeight $fontWeight;

    /**
     * Foreground color of the SVG.
     *
     * @var string
     */
    protected string $foreground;

    /**
     * Angle of rotation of the color gradients.
     *
     * @var int
     */
    protected int $gradientRotation;

    /**
     * Colors used for gradient, use same colors for a plain SVG.
     *
     * @var array
     */
    protected array $gradientColors;

    /**
     * Array to hold default config.
     *
     * @var array
     */
    private array $config = [];

    public function __construct(public string $text = '')
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
     *
     * @param  string  $text
     * @return $this
     */
    public function for(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Set the SVG size between 16 and 512. The generated
     * SVG is square always.
     *
     * @param  int  $size
     * @return $this
     * @throws InvalidSvgSizeException
     */
    public function size(int $size): static
    {
        if ($size < 16 || $size > 512) {
            throw InvalidSvgSizeException::create($size);
        }

        $this->size = $size;

        return $this;
    }

    /**
     * Set the shape of the SVG. It can either be Circle,
     * or can be Rectangle.
     *
     * @param  Shape  $shape
     * @return $this
     */
    protected function shape(Shape $shape): static
    {
        return $shape === Shape::CIRCLE ? $this->circle() : $this->rectangle();
    }

    /**
     * Set circle as output SVG shape.
     *
     * @return $this
     */
    public function circle(): static
    {
        $this->shape = Shape::CIRCLE;

        return $this;
    }

    /**
     * Set rectangle as output SVG shape.
     *
     * @return $this
     */
    public function rectangle(): static
    {
        $this->shape = Shape::RECTANGLE;

        return $this;
    }

    /**
     * Set font size of the SVG between 10 and 50.
     *
     * @param  int  $fontSize
     * @return $this
     * @throws InvalidFontSizeException
     */
    public function fontSize(int $fontSize): static
    {
        if ($fontSize < 10 || $fontSize > 50) {
            throw InvalidFontSizeException::create($fontSize);
        }

        $this->fontSize = $fontSize;

        return $this;
    }

    /**
     * Set the font weight of the SVG. It can be Regular,
     * Medium, Semibold, or Bold.
     *
     * @param  FontWeight  $fontWeight
     * @return $this
     */
    public function fontWeight(FontWeight $fontWeight): static
    {
        $this->fontWeight = $fontWeight;

        return $this;
    }

    /**
     * Set the foreground (font) color of the SVG.
     *
     * @param  string  $color
     * @return $this
     */
    public function foreground(string $color): static
    {
        $this->foreground = $color;

        return $this;
    }

    /**
     * Set the angle of the color gradient rotation between 0 and 360.
     *
     * @param  int  $angle
     * @return $this
     * @throws InvalidGradientRotationException
     */
    public function gradientRotation(int $angle): static
    {
        if ($angle < 0 || $angle > 360) {
            throw InvalidGradientRotationException::create($angle);
        }

        $this->gradientRotation = $angle;

        return $this;
    }

    /**
     * Set the two colors (hex) for gradient, use same color for
     * a plain or flat SVG output.
     *
     * @param  string  $firstColor
     * @param  string  $secondColor
     * @return $this
     */
    public function gradientColors(string $firstColor, string $secondColor): static
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
     * @param  string  $name
     * @return string
     */
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

        return strtoupper($firstInitial . $secondInitial);
    }

    /**
     * Set default values from config.
     *
     * @return void
     * @throws InvalidFontSizeException
     * @throws InvalidGradientRotationException
     * @throws InvalidSvgSizeException
     */
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

    /**
     * Render the SVG.
     *
     * @return Svg
     * @throws MissingTextException
     */
    public function render(): Svg
    {
        if (! $this->text) {
            throw MissingTextException::create();
        }

        $config = [
            'initials' => $this->extractInitials($this->text),
            'size' => $this->size,
            'shape' => $this->shape,
            'font_size' => $this->fontSize,
            'font_weight' => $this->fontWeight,
            'foreground' => $this->foreground,
            'gradient_rotation' => $this->gradientRotation,
            'gradient_colors' => $this->gradientColors,
        ];

        return new Svg($config);
    }

    /**
     * Output the SVG as an HTTP url.
     *
     * @return string
     */
    public function toUrl(): string
    {
        return url("{$this->config['url']}?text={$this->text}");
    }
}
