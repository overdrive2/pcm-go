<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
              <li class="px-2"><a href="{{ route('basictables') }}" class="no-underline text-gray-900">ข้อมูลพื้นฐาน</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><a href="{{ route('stmasgroups.show') }}" class="no-underline text-gray-900">หมวดวัสดุและครุภัณฑ์</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><span class="text-gray-700">รายการวัสดุและครุภัณฑ์</span></li>
            </ol>
        </nav>
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                        <x-input.text type="text" class="w-96"/>
                    </div>
                    <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading2 sortable multi-column wire:click="sortBy('stkcod')" :direction="$sorts['stkcod'] ?? null" class="hidden lg:table-cell hover:w-auto">รหัส</x-table.heading2>
                                    <x-table.heading2 sortable multi-column wire:click="sortBy('stkdes')" :direction="$sorts['stkdes'] ?? null" class="hidden lg:table-cell hover:w-auto">รายละเอียด</x-table.heading2>
                                    <x-table.heading2 class="hidden lg:table-cell hover:w-auto text-right">ราคา</x-table.heading2>
                                    <x-table.heading2 class="hidden lg:table-cell hover:w-auto text-center">หน่วยนับ</x-table.heading2>
                                    <th scope="col" class="relative px-6 py-3 hidden lg:table-cell">
                                        <span class="text-md text-gray-600">คำสั่ง</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 flex-1 lg:flex-none">
                                @foreach($stmass as $key => $item)
                                <tr class="flex flex-col flex-no wrap lg:table-row mb-2 lg:mb-0 w-full border">
                                    <td class="px-6 lg:py-4 whitespace-nowrap bg-gray-100 border-b lg:border-b-0 lg:bg-white sm:py-2">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">รหัส :</span>
                                        <span class="px-2 rounded-md text-gray-700">{{ $item->stkcod }}</span>
                                    </td>
                                    <td class="px-6 lg:py-4 py-2 whitespace-nowrap">{{ $item->stkdes }}</td>
                                    <td class="px-6 lg:py-4 py-2 lg:w-96 lg:min-w-full lg:text-right text-left">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ราคา :</span>
                                        <span>{{ number_format($item->unitpr, 2) }}</span>
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold ml-2">บาท</span>
                                    </td>
                                    <td class="px-6 lg:py-4 py-2 lg:w-96 lg:min-w-full lg:text-center">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">หน่วยนับ :</span>
                                        <span>{{ $item->unit_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium sm:border-t sm:bg-gray-100 lg:bg-white border-none">
                                        <div class="px-2 flex gap-x-2 border-t py-2">
                                                <a href="{{ route('order', $item->id) }}" target="_order" class="text-gray-500 hover:text-yellow-700 flex rounded-md border lg:border-0 px-2 py-1">
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
                        <div class="px-2 py-2">{{ $stmass->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
