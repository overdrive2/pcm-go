<div x-data="{
        filters: $wire.filters,
        sites: @js($sites),
        depts: @js($depts),
    }"
    x-init = "
        () => {

        }
    "
>
    <div class="lg:flex gap-2" wire:ignore>
        <div class="lg:w-[350px] w-full">
            <div>
                <x-input.select
                    data-te-select-filter="true"
                    id="dept_search"
                    wire:model="filters.dept_id"
                    label="หน่วยงาน/แผนก"
                >
                    <option value="0">-- ทั้งหมด --</option>
                    <template x-for="dept in depts" :key="dept.dept_id">
                        <option
                        :selected="dept.dept_id === model"
                        :value="dept.dept_id"
                        x-text="dept.dept_name">
                    </option>
                    </template>
                </x-input.select>
            </div>
        </div>
        <div class="lg:w-[350px] w-full">
            <div>
                <x-input.select wire:model="filters.site" label="คลัง">
                    <template x-for="site in sites" :key="site.id">
                    <option
                        :selected="site.id === model"
                        :value="site.id"
                        x-text="site.sitename">
                    </option>
                    </template>
                </x-input.select>
            </div>
        </div>
        <div class="w-full lg:w-[250px]">
            <x-input.tw-text wire:model.debounce.600ms="filters.search" :id="__('search_text')" label="ค้นหา" />
            <div class="relative">
                <x-input.text type="text" wire:model.debounce.700ms='filters.search' placeholder="ระบุคำค้นหา..." />
                <div class="absolute top-2 right-3">
                    <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></x-icon.search>
                </div>
            </div>
        </div>
        <div>
            <x-button.link href="{{ route('stock.out') }}">มุมมองใบคำขอ</x-button.link>
        </div>
    </div>
    <x-table>
        <x-slot name="header">
            <tr>
                <x-table.heading2 class="w-28">
                    เลขอ้างอิง
                </x-table.heading2>
                <x-table.heading2>
                    รายละเอียด
                </x-table.heading2>
                <x-table.heading2>
                    สถานะ
                </x-table.heading2>
                <x-table.heading2>
                    จำนวน
                </x-table.heading2>
                <x-table.heading2>
                    ราคา
                </x-table.heading2>
                <x-table.heading2>
                    มูลค่า
                </x-table.heading2>
                <x-table.heading2>
                    คำสั่ง
                </x-table.heading2>
            </tr>
        </x-slot>
        <x-slot name="body">
            @forelse ($collection as $item)
            <x-table.row2>
                <x-table.cell2>
                    {{ $item->trhs_id }}
                </x-table.cell2>
                <x-table.cell2>
                    <p class="font-medium">{{ $item->stkdes }}</p>
                    <p class="">{{ $item->stkcode }}</p>
                </x-table.cell2>
                <x-table.cell2>
                    @if($item->trntype === 'O')
                    <x-badges.yellow>จ่ายออก</x-badges.yellow>
                    @else
                    <x-badges.green>รับเข้า</x-badges.green>
                    @endif
                </x-table.cell2>
                <x-table.cell2>
                    <div class="text-center">{{ number_format($item->qty, 0) }}</div>
                </x-table.cell2>
                <x-table.cell2>
                    {{ $item->prc }}
                </x-table.cell2>
                <x-table.cell2>
                    {{ $item->ttamt }}
                </x-table.cell2>
                <x-table.cell2>
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
                </x-table.cell2>
            </x-table.cell2>
            @empty

            @endforelse
        </x-slot>
        <x-slot name="footer"></x-slot>
    </x-table>
    {{ $collection->links() }}
</div>
