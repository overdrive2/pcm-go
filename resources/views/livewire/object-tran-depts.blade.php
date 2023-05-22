<div>
    <div>
        <x-slot name="header">
            <nav class="container">
                <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
                    <li class="px-2"><a href="{{ route('stock.home') }}"
                            class="no-underline text-gray-900">คงคลัง</a></li>
                    <li>
                        <x-icon.chevron-right></x-icon.chevron-right>
                    </li>
                    <li class="px-2"><a href="{{ route('objects.menu') }}"><span class="text-gray-700">วัสดุและครุภัณฑ์</span></a></li>
                    <li>
                        <x-icon.chevron-right></x-icon.chevron-right>
                    </li>
                    <li class="px-2"><span class="text-gray-700">{{ $itemtype->iname }}</span></li>
                </ol>
            </nav>
        </x-slot>
        <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="lg:flex gap-2 mb-2">
                <div class="lg:w-1/3 border shadow-md text-center bg-white py-4">ทั้งหมด <span class="font-bold text-indigo-600">{{ number_format($all, 0) }}</span> {{ $itemtype->unit_name ?? 'รายการ' }}</div>
                <div class="lg:w-1/3 border shadow-md text-center bg-white py-4">ใช้งาน <span class="font-bold text-green-600">{{ number_format($tran, 0) }}</span> {{ $itemtype->unit_name ?? 'รายการ' }}</div>
                <div class="lg:w-1/3 border shadow-md text-center bg-white py-4">จำหน่าย <span class="font-bold text-red-600">{{ number_format($disc, 0) }}</span> {{ $itemtype->unit_name ?? 'รายการ' }}</div>
            </div>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                            <div class="lg:w-1/3 w-full">
                                <div class="relative">
                                    <input type="text" wire:model.debounce.700ms='search'
                                        class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full pr-8 pl-8 rounded z-0 focus:shadow"
                                        placeholder="ระบุคำค้นหา...">
                                    <div class="absolute top-2 left-2">
                                        <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"
                                            wire:target='search'></x-icon.search>
                                    </div>
                                    <div class="absolute top-2 right-6" wire:loading>
                                        <x-spinner class="text-indigo-400 h-5"></x-spinner>
                                    </div>
                                </div>
                            </div>
                            <div class="w-2/3 lg:text-right mt-2 lg:mt-0">
                                <x-button wire:click="$set('showAdvSearchModal', true)">ขั้นสูง</x-button>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-2 border w-20">ลำดับ</th>
                                        <th class="py-2 border">รายละเอียด</th>
                                        <th class="py-2 border">จำนวน</th>
                                        <th class="py-2 border w-32">หน่วยนับ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $itmtotal = 0;
                                    @endphp
                                    @foreach ($itemtypes as $key => $row)
                                        @php
                                            $itmtotal = $itmtotal + $row->count;
                                        @endphp
                                        <tr class="bg-white hover:bg-gray-200 cursor-pointer {{ $row->id == $current_id ? 'bg-gray-200' : '' }}" wire:click="$set('current_id', '{{ $row->id }}')">
                                            <td class="border py-1 text-center">{{ $key + 1 }}</td>
                                            <td class="border py-1 ml-2"><span class="ml-4">{{ $row->iname }}</span></td>
                                            <td class="border py-1 text-right"><span class="mr-4">{{ number_format($row->count, 0) }}</span></td>
                                            <td class="border py-1 text-center"><span class="ml-4">{{ $row->unit_name }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="py-2 text-gray-500">รวมทั้งหมด</th>
                                        <th class="text-right"><span class="mr-4">{{ number_format($itmtotal, 0) }}</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg mt-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="py-2 border w-20">ลำดับ</th>
                                        <th class="py-2 border">แผนก/หน่วยงาน</th>
                                        <th class="py-2 border">จำนวน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $key => $row)
                                        <tr class="bg-white">
                                            <td class="border py-1 text-center">{{ $key + 1 }}</td>
                                            <td class="border py-1 ml-2"><span class="ml-4">{{ $row->dept_name }}</span></td>
                                            <td class="border py-1 text-right"><span class="mr-4">{{ number_format($row->count, 0) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="py-2 text-gray-500">รวมทั้งหมด</th>
                                        <th class="text-right"><span class="mr-4">{{ number_format($total, 0) }}</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="p-2">
                                {{ $rows->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
