@php
    /**
    * @var Sowren\SvgAvatarGenerator\SvgAvatarGenerator $generator;
    */
@endphp

<rect width='100%' height='100%' fill='url(#{{ $gradientId }})' rx="{{ $generator->getCornerRadius() }}"/>
