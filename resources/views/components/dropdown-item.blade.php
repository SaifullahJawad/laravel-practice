@props(['active' => false])

@php
    $classes = 'block text-left px-3 text-sm leading-6 hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white';

    if ($active)
        $classes .= ' bg-blue-500 text-white';
@endphp

<a {{ $attributes([ 'class' => $classes ]) }} {{-- $attributes() merges any attributes passed down to this component; like $attribures->merge()--}}
>{{ $slot }}</a>