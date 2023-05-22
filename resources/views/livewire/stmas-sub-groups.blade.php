<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
              <li class="px-2"><a href="{{ route('basictables') }}" class="no-underline text-gray-900">ข้อมูลพื้นฐาน</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><a href="{{ route('stmasgroups.show') }}" class="no-underline text-gray-900">หมวดวัสดุและครุภัณฑ์</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><span class="text-gray-700">หมวดย่อยวัสดุและครุภัณฑ์</span></li>
            </ol>
        </nav>
    </x-slot>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                    <div class="lg:flex justify-between gap-x-2">
                        <div class="w-full">
                            <div class="relative">
                                <input type="text" wire:model.debounce.700ms='filters.search' class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full  lg:w-96 pr-8 pl-5 rounded z-0 focus:shadow" placeholder="ระบุคำค้นหา...">
                                <div class="absolute top-2 right-3">
                                    <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></x-icon.search>
                                </div>
                            </div>
                        </div>
                        <div class="w-full mt-0 lg:mt-0">
                            <x-input.select2 id="doctypes_id" search="search.doctype_kw" label="{{ $group_name ?? 'โปรดเลือกหมวด' }}">
                                @forelse($groups as $group)
                                    <div wire:click="$set('filters.group_id','{{$group->id}}')" x-on:click="open = false;" class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                                        <span class="ml-2 text-gray-700">{{ $group->flname }}</span>
                                    </div>
                                @empty
                                    <div class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                                        <span class="ml-2 text-gray-700"> -- ไม่พบข้อมูล --</span>
                                    </div>
                                @endforelse
                            </x-input.select2>
                        </div>
                    </div>
                </div>
                <div class="shadow overflow-hidden lg:border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-table.heading2 sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null" class="hidden lg:table-cell hover:w-auto">รหัส</x-table.heading2>
                                <x-table.heading2 sortable multi-column wire:click="sortBy('tname')" :direction="$sorts['tname'] ?? null" class="hidden lg:table-cell hover:w-auto">รายละเอียด</x-table.heading2>
                                <th>จำนวน(รหัส)</th>
                                <th scope="col" class="relative px-6 py-3 hidden lg:table-cell">
                                    <span>คำสั่ง</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 flex-1 lg:flex-none">
                            @foreach($subgroups as $key => $item)
                                <tr class="flex flex-col flex-no wrap lg:table-row mb-2 lg:mb-0 w-full border">
                                    <td class="px-6 lg:py-4 whitespace-nowrap bg-gray-100 border-b lg:border-b-0 lg:bg-white sm:py-2">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">ลำดับ :</span>
                                        <span class="px-2 rounded-md text-gray-700">{{ $item->id }}</span>
                                    </td>
                                    <td class="px-6 lg:py-4 py-2 whitespace-nowrap">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">รายละเอียด :</span>
                                        <div class="flex-none lg:flex">
                                            <div class="px-2 rounded-md text-gray-700">{!! str_ireplace($filters['search'], "<span class='text-red-500'>{$filters['search']}</span>",  $item->tname ?? '-') !!}</div>
                                            <div class="px-2 rounded-md text-gray-700">({{ $item->groups_id . "-" . $item->id }})</div>
                                        </div>
                                    </td>
                                    <td class="px-6 lg:py-4 py-2 lg:w-96 lg:min-w-full lg:text-center">
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2">จำนวนรหัส :</span>
                                        <a href="{{ route('stmas.show', [$item->groups_id, $item->id]) }}">
                                            <button class="rounded-md shadow-sm bg-gray-100 hover:bg-gray-200"><span class="px-2 rounded-md text-gray-700 text-right">{{ number_format($item->stmas_count, 0) }}</span></button>
                                        </a>
                                        <span class="lg:hidden inline-flex  leading-5 font-semibold mr-2 text-gray-500">รายการ</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium sm:border-t sm:bg-gray-100 lg:bg-white">
                                        <div class="px-2 flex gap-x-2">
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
                    <div class="px-2 py-2">{{ $subgroups->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
