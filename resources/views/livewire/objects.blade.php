<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
                <li class="px-2"><a href="{{ route('stock.home') }}" class="no-underline text-gray-900">คงคลัง</a></li>
                <li>
                    <x-icon.chevron-right></x-icon.chevron-right>
                </li>
                <li class="px-2"><a href="{{ route('objects.menu') }}"><span
                            class="text-gray-700">วัสดุและครุภัณฑ์</span></a></li>
                <li>
                    <x-icon.chevron-right></x-icon.chevron-right>
                </li>
                <li class="px-2"><span class="text-gray-700">{{ $itemtype_name }}</span></li>
            </ol>
        </nav>
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                        <div class="lg:w-1/3 w-full">
                            <div class="relative">
                                <input type="text" wire:model.debounce.700ms='filters.search'
                                    class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full pr-8 pl-8 rounded z-0 focus:shadow"
                                    placeholder="ระบุคำค้นหา...">
                                <div class="absolute top-2 left-2">
                                    <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"
                                        wire:target='filters.search'></x-icon.search>
                                </div>
                                <div class="absolute top-2 right-6" wire:loading wire:target='filters.search'>
                                    <x-spinner class="text-indigo-400 h-5"></x-spinner>
                                </div>
                            </div>
                        </div>
                        <div class="w-2/3 lg:text-right mt-2 lg:mt-0">
                            <x-button wire:click="$set('showAdvSearchModal', true)">ขั้นสูง</x-button>
                            <x-button.primary wire:click="new" class="lg:ml-0 ml-2">เพิ่ม</x-button.primary>
                        </div>
                    </div>
                    <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                        รหัส
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell w-10">
                                        บาร์โค้ด
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                        ชื่อ/SN
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left  font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                        ประเภท
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center  font-medium text-gray-500 uppercase tracking-wider lg:table-cell">
                                        หน่วยงาน/แผนก
                                    </th>
                                    <th scope="col"
                                    class="px-6 py-3 text-center  font-medium text-gray-500 uppercase tracking-wider lg:table-cell">
                                        บรรจุภัณฑ์
                                    </th>
                                    <th scope="col" class="relative px-6 py-3 hidden lg:table-cell w-10">
                                        <span>คำสั่ง</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 flex-1 lg:flex-none">
                                @foreach ($objects as $item)
                                    <tr class="flex flex-col flex-no wrap lg:table-row mb-2 lg:mb-0 border">
                                        <td
                                            class="px-6 lg:py-4 whitespace-nowrap bg-gray-100 border-b lg:border-b-0 lg:bg-white sm:py-2">
                                            <div class="flex justify-between lg:flex-none py-1">
                                                <div>
                                                    <span class="lg:hidden mr-2">รหัส</span>
                                                    <div
                                                        class="px-1 py-1 inline-flex font-bold text-sm leading-5 rounded-lg bg-gray-100 text-gray-700">
                                                        {{ $item->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 lg:py-4 py-2 lg:w-32 lg:min-w-full">
                                            <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">บาร์โค้ด
                                                :</span>
                                            <span
                                                class="px-2 rounded-md text-gray-700">{{ $item->prefix . '-' . sprintf('%05d', $item->item_no) }}</span>
                                        </td>
                                        <td class="px-2 lg:py-4 py-2 lg:min-w-full">
                                            <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ชื่อ/SN
                                                :</span>
                                            <span
                                                class="rounded-md text-gray-700">{{ $item->label ?? $item->objname }}<span
                                                    class="rounded-md text-gray-500 text-sm font-mono ml-6 lg:ml-0">{!! $item->sn ? '<br>' . $item->sn : '' !!}</span></span>
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ประเภท
                                                :</span>
                                            <span
                                                class="px-2 rounded-md text-gray-700">{{ $item->itmtype_name ?? '-' }}</span>
                                            {!! $item->itmtype->ref_id > 0
                                                ? '<br><span class="px-2 rounded-md text-gray-500">' . $item->itmtype->ref_name . '</span>'
                                                : '' !!}
                                        </td>
                                        <td class="px-2 lg:py-4 py-2 lg:w-96 lg:min-w-full lg:text-center">
                                            <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">จ่ายให้
                                                :</span>
                                            @if ($item->trans_count > 0)
                                                @php
                                                    $tran = $item->object_tran;
                                                @endphp
                                                <button type="button" wire:click="detail({{ $item->id }})"
                                                    class="rounded-md border p-2 sm:inline-block hover:bg-indigo-100 cursor-pointer">
                                                    <p class="text-gray-500 font-bold">{{ $tran->dept_name }}</p>
                                                    <p class="text-sm font-light text-gray-500">จ่ายเมื่อ :
                                                        {{ $tran->tran_date_time_thai }}</p>
                                                </button>
                                            @else
                                                <x-button wire:click="detail({{ $item->id }})"
                                                    class="hover:bg-indigo-100">ตัดจ่าย</x-button>
                                            @endif
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">บรรจุภัณฑ์
                                                :</span>
                                            <span
                                                class="px-2 rounded-md text-gray-700">{{ $item->parent_number ?? '-' }}</span>
                                        </td>
                                        <td
                                            class="bg lg:border-0 px-2 py-4 whitespace-nowrap text-right text-sm font-medium border-t bg-gray-200 lg:bg-white">
                                            <div class="px-2 flex justify-center gap-x-2">
                                                <x-button wire:click="edit({{ $item->id }})"
                                                    class="text-gray-500 hover:text-yellow-700 bg-white border-gray-300 flex rounded-md border lg:border-0 px-2 py-1">
                                                    <x-icon.pencil-atl></x-icon.pencil-atl> <span
                                                        class="ml-1 lg:hidden">แก้ไข</span>
                                                </x-button>
                                                <x-button.link
                                                    class="text-gray-500 hover:text-red-700 flex bg-white rounded-md border-gray-300 border lg:border-0 px-2 py-1">
                                                    <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                                                </x-button.link>
                                                <x-button.link
                                                    class="text-gray-500 hover:text-blue-700 flex bg-white rounded-md border-gray-300 border lg:border-0 px-2 py-1"
                                                    type="button" wire:click="showPackage('{{ $item->id }}')">
                                                    <x-icon.collection
                                                        class="{{ $item->item_count ? 'text-green-600' : 'text-gray-600' }} h-5 w-5 ">
                                                    </x-icon.collection>
                                                    <span class="ml-1 lg:hidden">บรรจุภัณฑ์</span>
                                                </x-button.link>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" class="text-right py-2 text-gray-500">รวมทั้งหมด
                                        {{ number_format($objects->total(), 0) }} รายการ</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="px-2 py-2">{{ $objects->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-jet-dialog-modal wire:model="showEditModal" maxWidth="4xl">
            <x-slot name="title">
                รายละเอียดวัสดุ/ครุภัณฑ์
            </x-slot>
            <x-slot name="content">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="itmtype_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ประเภท</label>
                        <input wire:click="searchItemType" type="text" id="itmtype_id" readonly
                            value="{{ $editing->itmtype_name }}"
                            class="bg-gray-50 border cursor-pointer border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="เลือกประเภทสินค้า">
                    </div>
                    <div>
                        <label for="item_no"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลขอ้างอิง</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span>{{ $editing->prefix }}</span>
                            </div>
                            <input type="text" wire:model="item_no" id="item_no"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-14 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="00000">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="obj_name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อสินค้า</label>
                        <input type="text" id="obj_name" wire:model.defer="editing.objname"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="">
                    </div>
                    <div>
                        <label for="eqcode"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลขครุภัณฑ์</label>
                        <input type="text" id="eqcode" wire:model.defer="editing.eqcode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="0000-000-0000-0000" pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}-[0-9]{4}">
                    </div>
                    <div>
                        <label for="serail"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial Number</label>
                        <input type="text" id="serail" wire:model.defer="editing.sn"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-3 grid-cols-2">
                    <div>
                        <label for="buydate"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันที่ซื้อ</label>
                        <input type="date" id="buydate" wire:model="editing.buy_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="flowbite.com" required>
                    </div>
                    <div>
                        <label for="website"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ราคา</label>
                        <input type="number" wire:model.defer='editing.price' step=any
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="expdate"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันหมดอายุ</label>
                        <input type="date" id="expdate" wire:model.defer="editing.exp_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="">
                    </div>
                    <div>
                        <label for="wy"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รับประกัน(ปี)</label>
                        <input type="number" wire:model.defer="editing.wy"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="">
                    </div>
                    <div>
                        <label for="wm"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เดือน</label>
                        <input type="number" wire:model.defer="editing.wm"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="">
                    </div>
                    <div>
                        <label for="wd"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วัน</label>
                        <input type="number" wire:model.defer="editing.wd"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="">
                    </div>
                </div>
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="brand"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ยี่ห้อ</label>
                        <input wire:click="searchBrand" type="text" id="brand"
                            value="{{ $editing->brand_name }}" readonly
                            class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="model"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รุ่น</label>
                        <input type="text" wire:model.defer="editing.model"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="label"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ป้ายชื่อ(Sticker)</label>
                        <input type="text" wire:model.defer="editing.label" id="label"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                    <div>
                        <label for="ord"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ลำดับ</label>
                        <input type="text" id="ord" wire:model.defer="editing.ord"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    </div>
                </div>
            </x-slot>
            <x-slot name="footer">
                <div class="flex-none inline-block px-2"><span wire:target="search" wire:loading>Loading...</span>
                </div>
                <x-button.primary type="submit" wire:loading.attr="disabled">บันทึก</x-button.primary>
                <x-button.secondary type="button" wire:loading.attr="disabled"
                    wire:click="$toggle('showEditModal')">ยกเลิก</x-button.secondary>
            </x-slot>
        </x-jet-dialog-modal>
    </form>

    <x-jet-dialog-modal wire:model="showAdvSearchModal" maxWidth="4xl">
        <x-slot name="title">
            Advance Search
        </x-slot>
        <x-slot name="content">
            <div>
                <div class="flex items-center mb-4">
                    <input wire:model='filters.pay' id="payonly" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="payonly"
                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">แสดงเฉพาะที่จ่าย</label>
                </div>
                <div class="flex items-center">
                    <input wire:model='filters.package' checked id="packageonly" type="checkbox" value=""
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="packageonly"
                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">บรรจุภัณฑ์</label>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showAdvSearchModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showPackageModal" maxWidth="4xl">
        <x-slot name="title">
            บรรจุภัณฑ์
        </x-slot>
        <x-slot name="content">
            @livewire('object.detail', ['parent_id' => $parentId], key('package' . $parentId))
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showPackageModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showTransferModal" maxWidth="5xl">
        <x-slot name="title">
            <h3 class="text-xl font-medium text-gray-600 drak:text-white">ประวัติการเบิกจ่าย</h3>
        </x-slot>
        <x-slot name="content">
            @livewire('object-trans', ['objectId' => $objectId], key('objectId' . $objectId . $showTransferModal))
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showTransferModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showSrcItmTypeModal" maxWidth="xl">
        <x-slot name="title">
            ค้นหาชนิดวัสดุและครุภัณฑ์
        </x-slot>
        <x-slot name="content">
            @livewire('search-modal.itm-type', ['loadData' => $showSrcItmTypeModal, 'itmtypeId' => $editing->itmtype_id ?? null], key('itmtypeId' . $showSrcItmTypeModal . ($editing->itmtype_id ?? '')))
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSrcItmTypeModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showBrandModal" maxWidth="xl">
        <x-slot name="title">
            ค้นหายี่ห้อ
        </x-slot>
        <x-slot name="content">
            @livewire('search-modal.brands', ['loadData' => $showBrandModal, 'brandId' => $editing->brn_id ?? null], key('brandId' . $showBrandModal . ($editing->brn_id ?? '')))
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showBrandModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showSearchModal" maxWidth="4xl">
        <x-slot name="title">
            ค้นหารายการสินค้า
        </x-slot>
        <x-slot name="content">
            @if($showSearchModal)
                @livewire($searchObject, ['current_id' => $current_id, 'loadData' => $showSearchModal], key('SearchModal' . $showSearchModal.$current_id))
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
