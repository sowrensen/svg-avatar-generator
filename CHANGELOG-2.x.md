# Changelog

All notable changes to `svg-avatar-generator` **v2.x** will be documented in this file.

## 2.0.0

- Laravel 11 supports only.
- New validator for `foreground` and `gradient_colors` config.
- Dropped support for named colors, e.g. red, green in `foreground` and `gradient_colors`.
- Use `rules()` static method instead of `$rules` property to define validation rules.
- New `GradientColorSet` rule class to validate gradient colors structure.
