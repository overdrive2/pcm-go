@props([
    'component' => null,
    'value' => null,
    'label' => null,
    'id' => null,
])

<div id="{{ $id }}" class="flex items-center">
    <input type="text" value="{{ $label }}"
    {{ $attributes->merge(['class'=>'bg-gray-50 border border-gray-300 text-gray-900 focus:outline-none focus:shadow-md text-sm rounded-lg focus:ring-indigo-500 focus:ring-0 focus:border-indigo-500 block w-full pl-2 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500']) }}
    >
    <button type="button" wire:click="$emit('open:srcmodal', '{{ $component }}', '{{ $value }}')"
        class="p-2.5 ml-1 text-sm font-medium text-white bg-indigo-700 rounded-lg border border-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-1 focus:ring-indigo-200 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <span class="sr-only">Search</span>
    </button>
</div>