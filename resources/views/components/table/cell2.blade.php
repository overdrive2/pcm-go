@props([
    'label' => null,
    'unit' => null,
    'inline' => 'inline-flex',
])

<td {{ $attributes->merge(['class'=>'px-2']) }} >
    <div class="py-1">
        @if($label)
        <span class="lg:hidden mr-2">{{ $label }}</span>
        @endif
        <div class="px-1 py-1 {{ $inline }}">
            {{ $slot }}
            @if($unit)
            <span class="text-gray-600 dark:text-gray-100 lg:hidden inline-flex font-semibold px-2">{{ $unit }}</span>
            @endif
        </div>
    </div>
</td>
