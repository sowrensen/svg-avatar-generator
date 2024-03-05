<?php

namespace Sowren\SvgAvatarGenerator\Validators;

use Arr;
use Str;
use Validator;

class ConfigValidator
{
    protected static array $rules = [
        'corner_radius' => ['int', 'between:0,25'],
        'font_size' => ['int', 'between:10,50'],
        'gradiant_rotation' => ['int', 'between:0,360'],
        'gradiant_stops' => ['array'],
        'gradiant_stops.*' => ['numeric', 'between:0,1'],
        'svg_size' => ['int', 'between:16,512'],
        'custom_font_url' => ['nullable', 'url'],
        'svg_text' => ['required', 'string']
    ];

    public static function validate(string $key, mixed $value): array
    {
        $rules = Arr::where(static::$rules, function ($set, $property) use ($key) {
            return Str::startsWith($property, $key);
        });

        return Validator::validate([$key => $value], $rules);
    }
}
