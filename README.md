# Offline SVG Avatar Generator for Laravel

Generating SVG avatars on the fly is nothing new. There are a lot of free/paid services and packages to do that. So why
another package for same task?

Well, this package has some subtle advantages over available packages, here's a few of them:

- ✅ No external api call is required. 🤝🏼
- ✅ Unlike some other available options, doesn't require heavy-weight image processing libraries like **Intervention**.
  🧺
- ✅ Support for gradient background. 🦜
- ✅ Ability to customize initials. ✍🏼

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
    ->setForeground('#E6C6A3')
    ->setGradientColors('#3A1C71', '#FDBB2D')
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

## Testing

Run following command to execute test cases:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
