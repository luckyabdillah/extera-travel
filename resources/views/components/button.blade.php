{{-- components/button.blade.php --}}

{{-- @props([
    'variant' => 'primary'
])

@php
$classes = [
    'btn btn-primary' => $variant === 'primary',
    'btn btn-secondary' => $variant === 'secondary',
    'btn btn-gold' => $variant === 'gold',
    'btn btn-ghost' => $variant === 'ghost',
];
@endphp

@if ($attributes->has('href'))
    <a {{ $attributes->class($classes) }}>
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $attributes->get('type', 'button') }}"
        {{ $attributes->except('type')->class($classes) }}
    >
        {{ $slot }}
    </button>
@endif --}}