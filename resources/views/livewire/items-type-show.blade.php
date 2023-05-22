<div>
    <x-slot name="header">
    </x-slot>
    <div class="flex justify-between mb-2">
        <div class="px-1 py-1 inline-flex">
            @if($filters['ref_id'])
                <a href="{{ route('itemtypes.show') }}"><x-icon.home class="text-gray-600 font-bold h-6 w-6" /></a>
            @endif
            @foreach($itemparents as $key => $parent)
                @php
                    if($key == 0) $ref_id = $parent->id;
                    else $ref_id .= ','.$parent->id
                @endphp
                <div class="inline-flex mr-2">
                    @if($key < count($itemparents)-1)
                        <a href="{{ route('itemtypes.show') }}?ref_id={{ $ref_id }}" class="flex">
                            <x-icon.chevron-right class="text-gray-600 font-bold h-6 w-6 {{ $key == 0 ? 'invisible':''}}" />
                            <span class="px-2">{{ $parent->iname }}</span>
                        </a>
                    @else
                        <x-icon.chevron-right class="text-gray-600 font-bold h-6 w-6 {{ $key == 0 ? 'invisible':''}}" />
                        <span class="px-2">{{ $parent->iname }}</span>
                    @endif
                </div>
            @endforeach
        </div>
        <div><x-button wire:click='new'>เพิ่ม</x-button></div>
    </div>
    <x-table2>
        <x-slot name="header">
            <x-table.heading2 class="w-9" sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">รหัส</x-table.heading2>
            <x-table.heading2 sortable multi-column>รายละเอียด</x-table.heading2>
            <x-table.heading2 class="text-center">Prefix</x-table.heading2>
            <x-table.heading2 class="text-center">รายการย่อย</x-table.heading2>
            <x-table.heading2 class="w-40 text-center">คำสั่ง</x-table.heading2>
        </x-slot>
        <x-slot name="body">
            @foreach($itemtypes as $key => $item)
            <x-table.row2>
                <x-table.cell2 class="text-center">{{ $key+(($itemtypes->currentPage()-1)*$perPage)+1 }}</x-table.cell2>
                <x-table.cell2>
                    <a href="{{ route('itemtypes.show') }}?ref_id={{ ( request()->input('ref_id') ? request()->input('ref_id').',' : '' ).$item->id }}" class="flex">
                        <x-image-item icon="{{ $item->icon }}"></x-image-item>
                        <span class="px-2">{{ $item->iname }}</span>
                    </a>
                </x-table.cell2>
                <x-table.cell2 class="text-center"><span class="px-2 text-gray-600 font-bold">{{ $item->prefix }}</span></x-table.cell2>
                <x-table.cell2 class="text-center">
                     <a href="{{ route('itemtypes.show') }}?ref_id={{ ( request()->input('ref_id') ? request()->input('ref_id').',' : '' ).$item->id }}">{{ $item->item_count }}</a>
                </x-table.cell2>
                <x-table.action>
                    <button type="button" wire:click="edit({{$item->id}})" class="lg:bg-white bg-gray-300 text-gray-700 hover:text-yellow-700 flex border rounded-md lg:border-0 px-2 py-1">
                        <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                    </button>
                    <x-button.link class="text-gray-700 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1 bg-gray-300 lg:bg-white">
                        <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                    </x-button.link>
                </x-table.action>
            </x-table.row2>
            @endforeach
        </x-slot>
    </x-table2>
    <div class="px-2 py-2">{{ $itemtypes->links() }}</div>
    <x-modal.dialog wire:model.defer="showEditModal" maxWidth="2xl">
      <x-slot name="title">เพิ่ม/แก้ไข</x-slot>
      <x-slot name="content">
            <x-input.group for="iname" label="ชื่อ" :error="$errors->first('editing.iname')">
                <x-input.text type='text' wire:model.defer="editing.iname" id="iname" placeholder="รายละเอียด" />
            </x-input.group>
            <x-input.group for="icon" label="icon" :error="$errors->first('editing.icon')">
                <div x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left z-10 w-full">
                    <div>
                        <span class="rounded-md shadow-sm">
                            <button @click="open = !open" type="button" class="inline-flex justify-start w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150" id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open" aria-expanded="true">
                                <x-image-item icon="{{ $editing->icon ?? '' }}" class="text-gray-600"></x-image-item>
                                <span>{{ $editing->icon ?? '' }}</span>
                                <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </span>
                    </div>
                    <div x-show="open" style="display: none;" x-description="Dropdown panel, show/hide based on dropdown state." x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="h-auto max-h-48 overflow-y-auto">
                        <div class="rounded-md bg-white shadow-xs">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                @foreach($icons as $icon)
                                <div @click="open = !open" wire:click="$set('editing.icon', '{{ str_replace('public/icons/', '', $icon) }}')" class="flex space-x-2 w-full hover:cursor-pointer hover:bg-gray-200">
                                    <x-image-item icon="{{ str_replace('public/icons/', '', $icon) }}" class="text-cool-gray-400 h-6 w-6"></x-image-item>
                                    <span>{{ str_replace('public/icons/', '', $icon) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </x-input.group>
            <x-input.group for="prefix" label="prefix" :error="$errors->first('editing.prefix')">
                <x-input.text type='text' wire:model.defer="editing.prefix" id="prefix" />
            </x-input.group>
            <x-input.group for="level" label="level" :error="$errors->first('editing.level')">
                <x-input.text type='number' wire:model.defer="editing.level" id="level" />
            </x-input.group>
            <x-input.group for="parent_id" label="Parent" :error="$errors->first('editing.parent_id')">
                <x-input.select wire:model.defer="editing.parent_id" class="rounded-md focus:ring-0">
                    <option>-- เลือกหมวด --</option>
                    @foreach(App\Models\ItmType::where('level', 0)->orderBy('ord', 'asc')->get() as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->iname }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>
            <x-input.group for="ord" label="ลำดับที่" :error="$errors->first('editing.ord')">
                <x-input.text type='number' wire:model.defer="editing.ord" id="ord" />
            </x-input.group>
      </x-slot>
      <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showEditModal')" wire:loading.attr="disabled">
                {{ __('ยกเลิก') }}
            </x-jet-secondary-button>

            <x-button.primary class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
      </x-slot>
    </x-modal.dialog>
</div>
