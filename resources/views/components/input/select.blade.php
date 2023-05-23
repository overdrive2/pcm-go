<div
    class="w-full"
    x-data="{
        model: @entangle($attributes->wire('model')),
    }"
    x-init="

    "
>
    <select
        data-te-select-init
        {{ $attributes->merge(['class' => 'focus:rign-0 focus:ring-green-500']) }}
    >
        {{ $slot }}
    </select>
    @isset($label)
    <label class="z-50" data-te-select-label-ref>{{ $label }}</label>
    @endisset
</div>
