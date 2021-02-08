@props(['c-active'])

@php
    $classes = ($active ?? false)
                ? 'c-sidebar-nav-link c-active font-weight-bolder'
                : 'c-sidebar-nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
