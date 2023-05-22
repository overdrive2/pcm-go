<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
              <li class="px-2"><a href="{{ route('basictables') }}" class="no-underline text-gray-900">ข้อมูลพื้นฐาน</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><span class="text-gray-700">หมวดวัสดุและครุภัณฑ์</span></li>
            </ol>
        </nav>
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="-my-2 sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                    <div class="flex justify-between gap-x-2">
                        <div class="w-full">
                            <div class="relative">
                                <input type="text" wire:model.debounce.700ms='filters.search' class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full  lg:w-96 pr-8 pl-5 rounded z-0 focus:shadow" placeholder="ระบุคำค้นหา...">
                                <div class="absolute top-2 right-3">
                                    <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></x-icon.search>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    รหัส
                                </th>
                                <th scope="col" class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    ชื่อย่อ
                                </th>
                                <th scope="col" class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    ชื่อเต็ม
                                </th>
                                <th scope="col" class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell w-30">
                                    ประเภทเอกสาร
                                </th>
                                <th scope="col" class="px-6 py-3 text-center  font-medium text-gray-500 uppercase tracking-wider lg:table-cell">
                                    หมวดย่อย
                                </th>
                                <th scope="col" class="relative px-6 py-3 hidden lg:table-cell">
                                    <span>คำสั่ง</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 flex-1 lg:flex-none">
                            @foreach($stkgropus as $item)
                            <tr class="flex flex-col flex-no wrap lg:table-row mb-2 lg:mb-0 w-full border">
                                <td class="px-6 lg:py-4 whitespace-nowrap bg-gray-100 border-b lg:border-b-0 lg:bg-white sm:py-2">
                                    <div class="flex justify-between lg:flex-none py-1">
                                        <div>
                                            <span class="lg:hidden mr-2">รหัส</span>
                                            <div class="px-1 py-1 inline-flex font-bold text-sm leading-5 rounded-lg bg-gray-100 text-gray-700">
                                                {{ $item->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 lg:py-4 py-2 lg:w-96 lg:min-w-full">
                                    <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ชื่อย่อ :</span>
                                    <span class="px-2 rounded-md text-gray-700">{{ $item->shname }}</span>
                                </td>
                                <td class="px-6 lg:py-4 py-2 whitespace-nowrap">
                                    <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ชื่อเต็ม :</span>
                                    <span class="px-2 rounded-md text-gray-700">{{ $item->flname }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ประเภทเอกสาร :</span>
                                    <span class="px-2 rounded-md text-gray-700">{{ $item->doctype_name ?? '-' }}</span>
                                </td>
                                <td class="px-6 lg:py-4 py-2 lg:w-96 lg:min-w-full text-center">
                                    <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">หมวดย่อย :</span>
                                    <a href="{{ route('stmassubgroups.show', $item->id) }}">
                                        <button class="rounded-md shadow-sm bg-gray-100 hover:bg-gray-200"><span class="px-2 rounded-md text-gray-700 text-right">{{ $item->subgroup_count }}</span></button>
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2 text-gray-500">รายการ</span>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium sm:border-t sm:bg-gray-100 lg:bg-white">
                                    <div class="px-2 flex gap-x-2">
                                        <a role="button" wire:click="edit('{{$item->id}}')" class="text-gray-500 hover:text-yellow-700 flex rounded-md border lg:border-0 px-2 py-1">
                                            <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                                        </a>
                                        <x-button.link class="text-gray-500 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1">
                                            <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                                        </x-button.link>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-2 py-2">{{ $stkgropus->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <form wire:submit.prevent="save">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="6xl">
            <x-slot name="title">
                {{ __('รายละเอียดหมวดวัสดุและครุภัณฑ์') }}
            </x-slot>
            <x-slot name="content">
                <div class="lg:flex justify-between gap-2">
                    <div class="w-full lg:w-1/3">
                        <x-input.group inline for="grpcode" label="รหัสมาตรฐาน" :error="$errors->first('editing.id')">
                            <x-input.text type="text" wire:model.defer="editing.id" id="grpcode" />
                        </x-input.group>
                    </div>
                    <div class="w-full lg:w-2/3">
                        <x-input.group inline for="shname" label="ชื่อย่อ" :error="$errors->first('editing.shname')">
                            <x-input.text type="text" wire:model.defer="editing.shname" id="shname" />
                        </x-input.group>
                    </div>
                </div>  
                <div class="w-full">
                    <x-input.group inline for="flname" label="ชื่อเต็ม" :error="$errors->first('editing.flname')">
                        <x-input.text type="text" wire:model.defer="editing.flname" id="flname" />
                    </x-input.group>
                </div>
                <div class="lg:flex justify-between gap-2">
                    <x-input.group inline for="doctypes_id" label="ประเภทเอกสาร" :error="$errors->first('editing.doctypes_id')">
                        <x-input.search 
                            id="doctypes_id" 
                            readonly 
                            component="search-modal.document-type" 
                            label="{{ $editing->doctype_name }}"
                            value="doctypes_id"
                        />
                    </x-input.group>
                    <x-input.group inline for="def_site" label="ใช้เฉพาะคลัง" :error="$errors->first('editing.def_site')">
                        <x-input.search 
                            id="def_site" 
                            readonly 
                            component="search-modal.site" 
                            label="{{ $editing->site_name }}"
                            value="def_site"
                        />
                    </x-input.group>
                </div>  
            </x-slot>
            <x-slot name="footer">
                <x-button.primary type="submit">บันทึก</x-button.primary>
                <x-button.secondary type="button" wire:click="$toggle('showEditModal')">ยกเลิก</x-button.secondary>
            </x-slot>
        </x-jet-dialog-modal>
    </form>
    <x-jet-dialog-modal wire:model="showSearchModal" maxWidth="4xl">
        <x-slot name="title">
            {{ $modal_title }}
        </x-slot>
        <x-slot name="content">
            @if($showSearchModal)
                @livewire($searchObject, ['current_id' => $editing->{$current_id_name}, 'loadData' => $showSearchModal], key('SearchModal' . $showSearchModal.$current_id_name))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
