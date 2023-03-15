@php
    /**
     * @var Sowren\SvgAvatarGenerator\SvgAvatarGenerator $generator
     * @var string $gradientId
     */
@endphp

<svg
    width="{{ $generator->getSize() }}"
    height="{{ $generator->getSize() }}"
    viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"
    xmlns:xlink="http://www.w3.org/1999/xlink"
>
    <defs>
        @include('svg::elements.linear-gradient')
    </defs>
    @include($generator->getShape()->render())
    <text
        x="50%" y="50%" style="line-height: 1;"
        font-family="-apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif"
        alignment-baseline="middle" text-anchor="middle"
        font-size="{{ $generator->getFontSize() }}"
        font-weight="{{ $generator->getFontWeight()->value }}"
        dy=".1em" dominant-baseline="middle"
        fill="{{ $generator->getForeground() }}"
    >
        {{ $generator->getInitials() }}
    </text>
</svg>
