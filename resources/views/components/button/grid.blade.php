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
    'url' => ''
])

<div class="text-center border border-gray-400 rounded-xl p-6 bg-gray-100 hover:bg-gray-200">
    <a href="{{ $url }}">
        <div>
            {{ $slot }}
        </div>
        <div>{{ $label }}</div>
    </a>
</div>
