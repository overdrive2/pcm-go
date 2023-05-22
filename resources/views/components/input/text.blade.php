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
    'leadingAddOn' => false,
    'endingAddOn' => false,
])

<div class="flex">
    @if ($leadingAddOn)
        <span class="dark:bg-gray-700 dark:text-white inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            {{ $leadingAddOn }}
        </span>
    @endif

    <input autocomplete="off" {{ $attributes->merge(['class' => 'bg-gray-50 dark:bg-gray-700 dark:text-white text-sm focus:outline-none rounded-md flex-1 focus:ring-blue-500 focus:ring-0 focus:border-blue-500 border-gray-300 focus:shadow-md p-2.5 focus:ring-none focus:border-gray-400 block w-full transition duration-150 ease-in-out sm:text-md sm:leading-5' . ($leadingAddOn ? ' rounded-none rounded-r-md' : '') . ($endingAddOn ? ' rounded-none rounded-l-md' : '')]) }}/>
    @if ($endingAddOn)
        <span class="dark:bg-gray-700 dark:text-white inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            {{ $endingAddOn }}
        </span>
    @endif
</div>
