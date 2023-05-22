@props(['id', 'label', 'search', 'display' => 'absolute'])
<div id="{{ $id }}" class="static"
    x-data="{ open: false }">
    <div class="">
        <div class="relative" >
            <x-icon.search class="absolute left-2 top-2 text-gray-400"></x-icon.search>
            <div wire:loading wire:target="{{ $search }}" class="absolute right-2 top-2"><x-spinner class="text-gray-400"></x-spinner></div>
            <input
                x-show = "!open"
                type   = "text"
                @click = "open = true;if (open) $nextTick(()=>{$refs.{{ $id }}.focus();$refs.{{ $id }}.select();});"
                value  = "{{ $label }}"
                class  = "border-gray-300 rounded-lg  w-full focus:shadow-md px-10 focus:ring-0 focus:border-gray-300 form-input sm:text-sm"
            />
            <input
                x-show                    = "open"
                x-ref                     = "{{ $id }}"
                type                      = "text"
                style                     = "display: none;"
                placeholder               = "ระบุคำค้นหา"
                wire:model.debounce.500ms = "{{ $search }}" class="select-all border-gray-300 rounded-lg w-full sm:text-sm focus:shadow-md px-10 focus:ring-0 focus:border-gray-300"
            />

        </div>
        <div
            style="display: none;z-index: 999;"
            x-show="open"
            @click.away="open = false;"
            class="border border-gray-300 overflow-y-auto rounded-lg max-h-96 w-auto py-2 sm:px-0 bg-white mt-1 {{ $display }}"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="px-4 py-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
