# Offline SVG Avatar Generator for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sowrensen/svg-avatar-generator.svg)](https://packagist.org/packages/sowrensen/svg-avatar-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sowrensen/svg-avatar-generator/run-tests.yml?branch=main&label=Tests)](https://github.com/sowrensen/svg-avatar-generator/actions?query=workflow%3ATests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sowrensen/svg-avatar-generator.svg)](https://packagist.org/packages/sowrensen/svg-avatar-generator)

Generating SVG avatars on the fly is nothing new. There are a lot of free/paid services and packages to do that. So why
another package for same task?

Well, this package has some subtle advantages over available packages, here's a few of them:

- [x] No external api call is required. 🤝🏼
- [x] Unlike some other available options, doesn't require heavy-weight image processing libraries like **Intervention**.
  🧺
- [x] Doesn't have any binary dependency, so nothing needs to be installed on server. 🗃️
- [x] Supports gradient background. 🦜
- [x] Supports random gradients based on defined presets in config. 🦚
- [x] Ability to customize initials. ✍🏼

## Requirements

- PHP >= 8.1
- Laravel >= 9.0

## Installation

Install the package via composer:

```bash
composer require sowrensen/svg-avatar-generator
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="svg-avatar-generator-config"
```

## Usage

### As model accessor

The usage of this package is stupidly simple. Use the `svg-avatar.php` config file to set your preferred decoration.
Then use the Facade to generate an avatar on the fly. The recommended way to achieve that is defining an accessor in
your model:

```php
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Model
{
    //...
    
    public function profilePhoto(): Attribute
    {
        return Attribute::get(function ($value, $attributes) {
            // If profile photo is set, return the original
            if (! is_null($attributes['profile_photo'])) {
                return $attributes['profile_photo'];
            }
            
            // Else, generate one
            return \Svg::for($attributes['name'])->toUrl();
        });
    }
}
```

> **Note**: If your accessor is different from the original attribute, you might want to put it in `$appends` array so
> that it loads automatically with your model.

### Override default config

If you want you can generate an avatar totally different from your configured style. It has all helpful methods to make
that possible:

```php
use Sowren\SvgAvatarGenerator\Facades\Svg;
use Sowren\SvgAvatarGenerator\Enums\FontWeight;

Svg::for('John Doe')
    ->asCircle() // or, asRectangle()
    ->setSize(64)
    ->setFontSize(40)
    ->setFontWeight(FontWeight::SEMIBOLD)
    ->setForeground('#FFFFFF')
    ->setGradientColors( // set of 3 different gradients
      ['#4158D0', '#C850C0', '#FFCC70'], 
      ['#00DBDE', '#FC00FF'], 
      ['#FF9A8B', '#FF6A88', '#FF99AC']
    )
    ->setGradientStops(0, .5, 1)
    ->setGradientRotation(120)
    ->render();
```

### Customize initials

You can define the second initial using studly case. For example,

| Provided string | Produced initial |
|-----------------|:----------------:|
| John Doe        |        JD        |
| JohnDoe         |        JD        |
| Johndoe         |        JO        |
| JohndoE         |        JE        |

## Sample Output

<img src="https://user-images.githubusercontent.com/13097375/221879852-b8283a4a-f3ff-42a9-b37a-07cbc9bd0afe.png" height="128"/>


## Testing

Run following command to execute test cases:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
