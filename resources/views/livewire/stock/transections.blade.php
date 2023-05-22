<div>
    <div class="lg:flex p-4">
        <div class="w-full">
            <div class="relative">
                <input type="text" wire:model.debounce.700ms='filters.search' class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full  lg:w-96 pr-8 pl-5 rounded z-0 focus:shadow" placeholder="ระบุคำค้นหา...">
                <div class="absolute top-2 right-3">
                    <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></x-icon.search>
                </div>
            </div>
        </div>
        <div class="lg:flex gap-x-2">
            <div>
                <x-select2 id="dept_search" wire:model="filters.dept_id">
                    <option>-- เลือกหน่วยงาน --</option>
                    @foreach($depts as $dept)
                        <option value="{{ $dept->dept_id }}">{{ $dept->dept_name }}</option>
                    @endforeach
                </x-select2>
            </div>
            <div class="w-full mt-2 lg:mt-0">
                <div>
                    <x-input.select placeholder="เลือกคลังตัดจ่าย" wire:model='filters.site'>
                      @foreach($sites as $site)
                      <option value="{{ $site->id }}">{{ $site->sitename }}</option>
                      @endforeach
                    </x-input.select>
                </div>
            </div>
        </div>
        <div>
            <a role="button" href="{{ route('stock.header') }}">มุมมองใบคำขอ</a>
        </div>
    </div>
    <x-table-flowbite.table>
        <x-slot name="header">
            <tr>
                <x-table-flowbite.th class="w-28">
                    เลขอ้างอิง
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    รายละเอียด
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    สถานะ
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    จำนวน
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    ราคา
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    มูลค่า
                </x-table-flowbite.th>
                <x-table-flowbite.th>
                    คำสั่ง
                </x-table-flowbite.th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse ($collection as $item)
            <x-table-flowbite.row>
                <x-table-flowbite.cell>
                    {{ $item->trhs_id }}
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    <p class="font-medium">{{ $item->stkdes }}</p>
                    <p class="">{{ $item->stkcode }}</p>
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    @if($item->trntype === 'O')
                    <x-badges.yellow>จ่ายออก</x-badges.yellow>
                    @else
                    <x-badges.green>รับเข้า</x-badges.green>
                    @endif
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    <div class="text-center">{{ number_format($item->qty, 0) }}</div>
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    {{ $item->prc }}
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    {{ $item->ttamt }}
                </x-table-flowbite.cell>
                <x-table-flowbite.cell>
                    <div class="flex gap-2">
                        <button type="button" wire:click="edit('{{ $item->id }}')"
                            class="lg:bg-white bg-gray-300 text-gray-700 hover:text-yellow-700 flex border rounded-md lg:border-0 px-2 py-1">
                            <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                        </button>
                        <button type="button" wire:click=""
                            class="text-gray-700 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1 bg-gray-300 lg:bg-white">
                            <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                        </button>
                    </div>
                </x-table-flowbite.cell>
            </x-table-flowbite.cell>
            @empty

            @endforelse
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-table-flowbite.table>
    {{ $collection->links() }}
</div>
