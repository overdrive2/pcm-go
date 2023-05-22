@props(['id' => null, 'maxWidth' => null, 'haveFooter' => 'true', 'footerAlign' => 'text-right'])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-2 bg-gray-100 dark:bg-gray-700 dark:text-gray-50">
        <div class="static">
            <div class="text-lg static">{{ $title }}</div>
            <div class="absolute right-1 top-1">
                <x-button.link x-on:click="show = false">
                    <x-icon.x-circle class="text-gray-500 dark:text-gray-100 h-6 w-6"></x-icon.x-circle>
                </x-button.link>
            </div>
        </div>
    </div>
    <div class="px-2 bg-white dark:bg-gray-600">
        <div class="py-2">
            {{ $content }}
        </div>
    </div>
    @if($haveFooter == 'true')
        <div class="px-6 py-2 bg-gray-100 dark:bg-gray-700 {{ $footerAlign }} rounded-b-lg">
            {{ $footer }}
        </div>
    @endif
</x-modal>
