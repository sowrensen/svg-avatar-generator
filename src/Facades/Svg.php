<?php

namespace Sowren\SvgAvatarGenerator\Facades;

use Illuminate\Support\Facades\Facade;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;
use Sowren\SvgAvatarGenerator\Enums\Shape;
use Sowren\SvgAvatarGenerator\SvgAvatarGenerator;

/**
 * @method static SvgAvatarGenerator for(string $text)
 * @method static string getInitials()
 * @method static int getSize()
 * @method static SvgAvatarGenerator setSize(int $size)
 * @method static Shape getShape()
 * @method static SvgAvatarGenerator asCircle()
 * @method static SvgAvatarGenerator asRectangle()
 * @method static int getCornerRadius()
 * @method static SvgAvatarGenerator setCornerRadius(int $radius)
 * @method static string|null getCustomFontUrl()
 * @method static SvgAvatarGenerator setCustomFontUrl(?string $url = null)
 * @method static string|null getFontFamily()
 * @method static SvgAvatarGenerator setFontFamily(?string $name = null)
 * @method static int getFontSize()
 * @method static SvgAvatarGenerator setFontSize(int $fontSize)
 * @method static FontWeight getFontWeight()
 * @method static SvgAvatarGenerator setFontWeight(FontWeight $fontWeight)
 * @method static string getForeground()
 * @method static SvgAvatarGenerator setForeground(string $color)
 * @method static int getGradientRotation()
 * @method static SvgAvatarGenerator setGradientRotation(int $angle)
 * @method static array getGradientColors()
 * @method static SvgAvatarGenerator setGradientColors(string|array ...$colors)
 * @method static array getGradientStops()
 * @method static SvgAvatarGenerator setGradientStops(int|float ...$offsets)
 * @method static array getGradientSet()
 * @method static \Sowren\SvgAvatarGenerator\Svg render()
 * @method static string toUrl()
 *
 * @see \Sowren\SvgAvatarGenerator\SvgAvatarGenerator
 */
class Svg extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Sowren\SvgAvatarGenerator\SvgAvatarGenerator::class;
    }
}
