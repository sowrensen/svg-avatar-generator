@php
    /**
     * @var Sowren\SvgAvatarGenerator\SvgAvatarGenerator $generator
     */
@endphp

@if(($url = $generator->getCustomFontUrl()) && ($family = $generator->getFontFamily()))
    <style>
        /*<![CDATA[*/
        @import url({{ $url }});
        /*]]>*/
    </style>
    <style>
        svg {
            font-family: {{ $family }}, "sans-serif";
        }
    </style>
@else
    <style>
        svg {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
        }
    </style>
@endif
