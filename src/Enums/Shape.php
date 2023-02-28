<?php

namespace Sowren\SvgAvatarGenerator\Enums;

enum Shape
{
    case CIRCLE;
    case RECTANGLE;

    /**
     * Render corresponding XML element.
     */
    public function render(): string
    {
        return match ($this) {
            self::CIRCLE => 'svg::elements.circle',
            self::RECTANGLE => 'svg::elements.rectangle',
        };
    }
}
