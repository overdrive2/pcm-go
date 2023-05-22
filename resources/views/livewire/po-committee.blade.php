<div>
    <div class="rounded-t-md border-b flex justify-between border-gray-500 mb-1 bg-gray-100 px-2 py-2">
        <div class="font-bold text-gray-500">{{ $comtype_name[$comtype-1] }} </div>
        <div class="flex justify-end">
            <button class="border rounded-md px-2 py-1 text-white bg-gray-600" wire:click='srcDirector'>
                <x-icon.plus></x-icon.plus> เพิ่ม
            </button>
        </div>
    </div>
    <div class="px-2 py-2">
        @foreach($committs as $key => $item)
        <div class="flex justify-between border-b border-gray-300">
            <div class="flex gap-x-2">
                <div class="px-1 mt-1"><span class="text-gray-800 font-bold text-sm">{{ $key+1 }}.</span> <span class="text-gray-600">{{ $item->comname }}</span></div>
                <div class="text-gray-600">ตำแหน่ง : {{ $item->posname }}</div>
            </div>
            <div class="px-2 flex gap-x-2 justify-center">
                <button wire:click="deleteConfirm('{{$item->id_crypt}}')"><x-icon.trash class="text-gray-500"></x-icon.trash></button>
            </div>
        </div>
        @endforeach
    </div>
    <x-jet-dialog-modal wire:model="showModalDirector" maxWidth="6xl">
        <x-slot name="title">
            <div class="lg:px-2 px-0">
                <input type="text" wire:model.debounce.500ms='director_search' class="border-gray-300 rounded-lg w-full sm:text-sm focus:shadow-md focus:ring-0 focus:border-gray-300" placeholder="ค้นหากรรมการ...">
            </div>
        </x-slot>
        <x-slot name="content">
            @livewire('committee-search', ['search' => $director_search, 'comtype' => $comtype], key($director_search))
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showModalDirector')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
