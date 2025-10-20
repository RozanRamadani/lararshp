@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-teal-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition duration-200 ease-in-out'
            : 'text-gray-700 hover:bg-teal-600 hover:text-white hover:scale-105 px-3 py-2 rounded-lg text-sm font-medium transition duration-200 ease-in-out hover:shadow-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
