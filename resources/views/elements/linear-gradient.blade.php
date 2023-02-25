@php
    /**
     * @var Sowren\SvgAvatarGenerator\SvgAvatarGenerator $generator
     * @var string $gradientId
     */
@endphp

<linearGradient id="{{ $gradientId }}" gradientTransform="rotate({{ $generator->getGradientRotation() }})">
    @foreach($generator->getGradientSet() as $set)
        <stop offset="{{ $set['offset'] }}" stop-color="{{ $set['color'] }}"/>
    @endforeach
</linearGradient>
