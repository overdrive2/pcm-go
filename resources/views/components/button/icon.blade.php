{{--
-- Important note:
--
-- This template is based on an example from Tailwind UI, and is used here with permission from Tailwind Labs
-- for educational purposes only. Please do not use this template in your own projects without purchasing a
-- Tailwind UI license, or they’ll have to tighten up the licensing and you’ll ruin the fun for everyone.
--
-- Purchase here: https://tailwindui.com/
--}}

@props([
    'label' => '',
])

<div class="relative mb-3 h-24 px-2">
    <button {{ $attributes->merge([
            'type' => 'button',
            'aria-label' => 'academic-cap',
            'aria-haspopup' => 'true',
            'aria-controls' => 'academic-cap-md',
            'class' => 'hover:cursor-pointer hover:bg-indigo-200 absolute inset-0 w-full items-center justify-center rounded-lg border border-gray-300 cursor-auto'
        ]) }}
    >
        {{ $slot }}
        <div class="font-bold text-gray-600 text-md mt-2 px-2"><p>{!! $label !!}</p></div>
    </button>
</div>
