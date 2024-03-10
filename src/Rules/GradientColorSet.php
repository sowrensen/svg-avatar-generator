<?php

namespace Sowren\SvgAvatarGenerator\Rules;

use Arr;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class GradientColorSet implements ValidationRule
{
    use ValidatesAttributes;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // If the value is not an array
        if (! is_array($value)) {
            $fail('The :attribute field must be an array.');
        }

        $hasMultipleSet = count(Arr::where($value, fn ($v) => is_array($v))) > 0;

        // Validate each item (array or string) in the array
        $hasMultipleSet
            ? $this->validateNestedColorSet($attribute, $value, $fail)
            : $this->validateColorSet($attribute, $value, $fail);
    }

    private function validateNestedColorSet(string $attribute, array $value, Closure $fail): void
    {
        foreach ($value as $index => $colorSet) {
            $keys = is_array($colorSet) ? array_keys($colorSet) : [$index];

            foreach ($keys as $nestedIndex) {
                $currentColor = is_array($colorSet) ? $colorSet[$nestedIndex] : $colorSet;

                if (is_array($currentColor)) {
                    $fail("The :attribute.{$index}.{$nestedIndex} field must be a valid hexadecimal color, array given.");
                    break;
                }

                if (! $this->validateHexColor($attribute, $currentColor)) {
                    $fail("The :attribute.{$index}.{$nestedIndex} field must be a valid hexadecimal color.");
                    break;
                }
            }
        }
    }

    private function validateColorSet(string $attribute, array $value, Closure $fail): void
    {
        foreach ($value as $index => $color) {
            if (! $this->validateHexColor($attribute, $color)) {
                $fail("The :attribute.{$index} field must be a valid hexadecimal color.");
                break;
            }
        }
    }
}
