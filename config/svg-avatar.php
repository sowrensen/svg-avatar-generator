<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Output SVG Dimension
    |--------------------------------------------------------------------------
    |
    | All images are square in size. This is done intentionally so that
    | the rendering of circular SVGs are perfect. Instead of height
    | and width, let's provide a size in integer.
    |
    | Type: int
    | Default: 64
    | Allowed: 16 to 512
    |
    */
    'size' => 64,

    /*
    |--------------------------------------------------------------------------
    | Output SVG Shape
    |--------------------------------------------------------------------------
    |
    | Here we define the output shape of the rendered SVG. For now two
    | different shapes are supported, circular or rectangle. Provide
    | your desired shape using the Enum class.
    |
    | Type: enum
    | Default: Shape::CIRCLE
    | Allowed: Shape::CIRCLE or Shape::RECTANGLE
    |
    */
    'shape' => \Sowren\SvgAvatarGenerator\Enums\Shape::CIRCLE,

    /*
    |--------------------------------------------------------------------------
    | Corner Radius
    |--------------------------------------------------------------------------
    |
    | You can define the corner radius of the Rectangle shape to achieve a
    | nice rounder corner. This setting only has effect when Shape is
    | set to Rectangle.
    |
    | Type: int
    | Default: 0
    | Allowed: 0 to 25
    |
    */
    'corner_radius' => 0,

    /*
    |--------------------------------------------------------------------------
    | Custom Font URL
    |--------------------------------------------------------------------------
    |
    | Specify the URL of the font family you want to use. You can use
    | Google Fonts, Fontshare or other services.
    |
    | e.g. https://api.fontshare.com/v2/css?f[]=kola@400&display=swap
    |
    | Type: string
    | Default: null
    |
    */
    'custom_font_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Font Family
    |--------------------------------------------------------------------------
    |
    | If you are using a custom font, specify the name of the family here,
    | otherwise it won't work. For example, for the URL in the previous
    | `custom_font_url` section's example, you should define 'Kola'
    | as the family name in this key.
    |
    | Type: string
    | Default: null
    |
    */
    'font_family' => null,

    /*
    |--------------------------------------------------------------------------
    | Font Size
    |--------------------------------------------------------------------------
    |
    | This key defines the size of the font inside the circular or the
    | rectangular area. Give it a proper size so that it doesn't
    | look too small or too large.
    |
    | Type: int
    | Default: 40
    | Allowed: 10 to 50
    |
    */
    'font_size' => 40,

    /*
    |--------------------------------------------------------------------------
    | Font Weight
    |--------------------------------------------------------------------------
    |
    | Now it is time to define the font weight. Four different types of
    | weight are supported. Provide one of them using the enum cases.
    |
    | Type: enum
    | Default: FontWeight::SEMIBOLD
    | Allowed: FontWeight::REGULAR, FontWeight::MEDIUM,
    |          FontWeight::SEMIBOLD, or FontWeight::BOLD
    |
    */
    'font_weight' => \Sowren\SvgAvatarGenerator\Enums\FontWeight::SEMIBOLD,

    /*
    |--------------------------------------------------------------------------
    | Foreground Color
    |--------------------------------------------------------------------------
    |
    | Set a suitable foreground (font) color in hex for the output SVG.
    | Don't forget to put the # symbol.
    |
    | Type: string (hex)
    | Default: #E6C6A3
    |
    */
    'foreground' => '#E6C6A3',

    /*
    |--------------------------------------------------------------------------
    | Gradient Colors
    |--------------------------------------------------------------------------
    |
    | Who doesn't admire a nice gradient for background color? You can set
    | a single gradient color or multiple sets of gradients to achieve
    | more dynamic effect.
    |
    | A fixed single gradient can be set by configuring list of hex colors.
    | For example, setting ['#FF0000', '#00FF00', '#0000FF'] will make a
    | gradient consisting red/green/blue color always.
    |
    | To set multiple gradients, you have to configure sets of colors. For
    | example, setting [['#FF0000', '#00FF00'], '#0000FF'] will randomly
    | generate a gradient of either red/green or blue background.
    |
    | You can provide same color to achieve a flat background.
    |
    | NOTE: Number of colors in a set—regardless of single multiple set—must
    | be consistent with gradient offsets.
    |
    | Type: array<array|string>
    | Default: ['#3A1C71', '#FDBB2D']
    |
    */
    'gradient_colors' => ['#3A1C71', '#FDBB2D'],

    /*
    |--------------------------------------------------------------------------
    | Gradient Stops
    |--------------------------------------------------------------------------
    |
    | Specify the stopping positions of gradient colors. Number of colors
    | in a set—regardless of single multiple set—must be consistent
    | with number of gradient stops. If you set more colors than
    | stops, the extra colors will be omitted, and if you set
    | fewer colors then stops, the last color in the set
    | will be repeated.
    |
    | Type: array<int|float>
    | Default: [0, 1]
    | Allowed: 0 to 1
    |
    */
    'gradient_stops' => [0, 1],

    /*
    |--------------------------------------------------------------------------
    | Gradient Rotation
    |--------------------------------------------------------------------------
    |
    | You can set the direction of the gradient flow by defining the
    | angle here.
    |
    | Type: int
    | Default: 120
    | Allowed: 0 to 360
    |
    */
    'gradient_rotation' => 120,

    /*
    |--------------------------------------------------------------------------
    | Extractor
    |--------------------------------------------------------------------------
    |
    | Extractor is responsible for taking initials out of the passed
    | string. The default extractor is pretty smart, if only one
    | word is given, it will look for second capital character
    | in the word, else the consecutive second character
    | will be taken.
    |
    | Examples:
    | - 'John Doe' will produce 'JD'
    | - 'JohnDoe' will produce 'JD'
    | - 'Johndoe' will produce 'JO'
    | - 'JohndoE' will produce 'JE'
    |
    | However if you want to write your own extractor, you should create a class
    | that implements Sowren\SvgAvatarGenerator\Extractors\Extractor interface
    | and set it up here.
    |
    | Type: Sowren\SvgAvatarGenerator\Extractors\Extractor
    | Default: Sowren\SvgAvatarGenerator\Extractors\DefaultExtractor::class
    |
    */
    'extractor' => Sowren\SvgAvatarGenerator\Extractors\DefaultExtractor::class,

    /*
    |--------------------------------------------------------------------------
    | SVG URL
    |--------------------------------------------------------------------------
    |
    | When using the toUrl() method, it will generate a link to your app with
    | the given url, e.g. https://myapp.app/svg-avatar?text=JohnDoe. You
    | can customize the url of that route using this key.
    |
    | Type: string
    | Default: svg-avatar
    |
    */
    'url' => 'svg-avatar',

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | The route is public by default. To prevent unwanted and unauthenticated
    | usage, you can set a middleware (e.g., 'auth', or ['auth']) here.
    |
    | Type: array<string>|string
    | Default: null
    |
    */
    'middleware' => null,
];
