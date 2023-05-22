<div class="px-2">
    <div class="lg:flex justify-between">
        <div class="lg:w-1/2 w-full">
            <input autofocus type="text" wire:model.debouncer.600ms="search"
                class="w-full border focus:ring-none focus:border-gray-400 rounded-md shadow-sm" placeholder="ค้นหา..." />
        </div>
        <div class="text-right flex gap-2">
            <x-button.secondary wire:click="$emit('open:search-form-plan-modal')">เลือกจากแผน</x-button.secondary>
            <x-button.primary wire:click="$emit('new:stkplan')">เพิ่ม</x-button.primary>
        </div>
    </div>
    <div class="mt-2">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-gray-300">
                    <th class="py-2">ลำดับ</th>
                    <th class="py-2">รายละเอียด</th>
                    <th class="py-2">จำนวน/หน่วยนับ</th>
                    <th class="py-2">ราคา</th>
                    <th class="py-2">มูลค่ารวม</th>
                    <th class="py-2">คำสั่ง</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($rows as $key => $row)
                    @php
                        $total = $total + $row->pamt;
                    @endphp
                    <tr class="border-b {{ $key % 2 == 1 ? 'bg-gray-50' : '' }}">
                        <td class="align-top text-right px-2"><span class="mr-4">{{ $key + 1 }}</span></td>
                        <td class="align-top px-2">
                            <p>{{ $row->stkcode }}</p>
                            <p>{{ $row->stkdesc }}</p>
                        </td>
                        <td class="text-right">{{ number_format($row->pqty, 0) }}</td>
                        <td class="text-right">{{ number_format($row->prc, 2) }} <span
                                class="text-sm font-bold">{{ $row->unit }}</span></td>
                        <td class="text-right">{{ number_format($row->pamt, 2) }}</td>
                        <td class="text-center">
                            <button type="button" wire:click="$emit('edit:stkplan', '{{ $row->id }}')"
                                class="bg-blue-500 text-white px-2 rounded-md hover:bg-blue-400">แก้ไข</button>
                            <button type="button" wire:click="$emit('confirm:delete:stkplan', '{{ $row->id }}')"
                                class="bg-red-500 text-white px-2 rounded-md hover:bg-red-400">ลบ</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">
                        รวมทั้งสิ้น
                    </th>
                    <th class="text-right">
                        {{ number_format($total, 2) }}
                    </th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="p-2">
            @if($rows)
            {{ $rows->links() }}
            @endif
        </div>
    </div>
</div>
