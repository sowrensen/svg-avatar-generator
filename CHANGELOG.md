# Changelog

All notable changes to `svg-avatar-generator` will be documented in this file.

## 1.1.0

- Support for setting multiple sets of gradient colors.
- Random gradient generation from defined presets in config.
- `setGradientColors()` method on `SvgAvatarGenerator` class now accepts multiple integer/array arguments.
- Option to set gradient stops via `setGradientStops()` method.
- New `$gradientSet` attribute—with related getters and setters—which holds the randomly picked gradient set.
- Use blade templates to create SVG instead of PHP heredoc.
- New `render()` method on `Shape` enum class.
- Moved some helper methods to `Tool` trait.

## 1.0.0

- Initial release
