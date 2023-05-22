<div>
    <div>คลังสินค้า : {{ $site_name }}({{$site}})</div>
    <x-input.text type="text" wire:model.debounce.600ms='filters.search'></x-input.text>
    <table class="min-w-full divide-y divide-gray-200 mt-2">
        <thead class="bg-gray-50">
            <tr>
                <x-table.heading2 class="w-40">รหัส</x-table.heading2>
                <x-table.heading2>รายละเอียด</x-table.heading2>
            </tr>
        </thead>
        <tbody>
            @foreach($stmass as $key => $item)
            <tr class="hover:bg-indigo-100 cursor-pointer" @click="show = false" wire:click="$emit('set:stkcode', '{{ $item->stkcod }}')">
                <td class="py-2">{{ $item->stkcod }}</td>
                <td class="py-2">{{ $item->stkdes }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">@if($stmass){{$stmass->links()}}@endif</td>
            </tr>
        </tfoot>
    </table>
</div>
