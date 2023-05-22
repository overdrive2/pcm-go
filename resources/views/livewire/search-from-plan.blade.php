<div class="px-2">
    <div class="py-1 lg:w-1/2">
        <x-input.text autofocus type="text" placeholder="ค้นหา..." wire:model.debounce.500ms="search">
        </x-input.text>
    </div>
    <table class="w-full">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>รายละเอียด</th>
                <th>จำนวน</th>
                <th>ราคา</th>
                <th>ราคารวม</th>
                <th>คำสั่ง</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $key => $row)
            <tr class="border-b {{ $key % 2 == 0 ? 'bg-gray-100' : '' }}">
                <td>{{ $row->stkcode }}</td>
                <td>{{ $row->stkdesc.' '.$row->stkdesc2 }}</td>
                <td>{{ number_format($row->pqty, 0) }}</td>
                <td>{{ $row->prc }}</td>
                <td>{{ $row->pamt }}</td>
                <td class="text-center">
                    <x-button type="button" wire:click="setPlanId('{{ $row->id }}')">เลือก</x-button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
