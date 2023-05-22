@props(['options' => []])

@php
    $options = array_merge([
                    'dateFormat' => 'Y-m-d',
                    'enableTime' => false,
                    'altFormat' =>  'j F Y',
                    'altInput' => true,
                    'locale' => 'th',
                    ], $options);
@endphp

<div wire:ignore>
    <input
        x-data="{value: @entangle($attributes->wire('model')), instance: undefined}"
        x-init="() => {
                instance = IMask(
                    $refs.input, 
                    {
                        mask: '$num',
                        blocks: {
                            num: {
                                mask: Number,
                                thousandsSeparator: ','
                            }
                        }
                    }
                );
            }"
        x-ref="input"
        x-bind:value="value"
        type="text"
        {{ $attributes->merge(['class' => 'form-input w-full rounded-md shadow-sm']) }}
    />
</div>