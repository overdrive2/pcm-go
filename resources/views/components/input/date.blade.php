
@props(['id'])

@php
$id = $id ?? md5($attributes->wire('model'));
@endphp
<div
    id="{{ $id }}"
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-init="instance = flatpickr($refs.input,
        {
            altInput: false,
            locale: 'th',
            disableMobile: true,
            dateFormat: 'd/m/Y'
        })
        $watch('value', (value) => {
            instance.setDate(value)
        });"
    x-on:change="value = $event.target.value"
    class="flex rounded-md"
>
    <span class="bg-gray-50 dark:bg-gray-700 inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 text-gray-500 dark:text-white sm:text-sm p-2.5">
        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C5.44772 2 5 2.44772 5 3V4H4C2.89543 4 2 4.89543 2 6V16C2 17.1046 2.89543 18 4 18H16C17.1046 18 18 17.1046 18 16V6C18 4.89543 17.1046 4 16 4H15V3C15 2.44772 14.5523 2 14 2C13.4477 2 13 2.44772 13 3V4H7V3C7 2.44772 6.55228 2 6 2ZM6 7C5.44772 7 5 7.44772 5 8C5 8.55228 5.44772 9 6 9H14C14.5523 9 15 8.55228 15 8C15 7.44772 14.5523 7 14 7H6Z"/>
        </svg>
    </span>

    <input type="text" class="dark:text-white bg-gray-50 dark:bg-gray-700 dark:placeholder-gray-400 rounded-r-md text-sm focus:shadow-md px-2 focus:ring-0 focus:border-gray-400 w-full p-2.5 border-gray-300"
        {{ $attributes->whereDoesntStartWith('wire:model') }}
        x-ref="input"
        x-bind:value="value"
    />
</div>
