<?php

namespace Sowren\SvgAvatarGenerator\Validators;

use Arr;
use Str;
use Validator;
use Sowren\SvgAvatarGenerator\Rules\GradientColorSet;


class ConfigValidator
{
    protected static function rules(): array
    {
        return [
            'corner_radius' => ['int', 'between:0,25'],
            'font_size' => ['int', 'between:10,50'],
            'foreground' => ['hex_color'],
            'gradient_colors' => [new GradientColorSet()],
            'gradient_rotation' => ['int', 'between:0,360'],
            'gradient_stops' => ['array'],
            'gradient_stops.*' => ['numeric', 'between:0,1'],
            'svg_size' => ['int', 'between:16,512'],
            'custom_font_url' => ['nullable', 'url'],
            'svg_text' => ['required', 'string'],
        ];
    }

    public static function validate(string $key, mixed $value): array
    {
        $rules = Arr::where(static::rules(), function ($set, $property) use ($key) {
            return Str::startsWith($property, $key);
        });

        return Validator::validate([$key => $value], $rules);
    }
}
