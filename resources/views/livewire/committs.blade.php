<div>
    <x-slot name="header">
        รายชื่อคณะกรรมการ
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">
        <div>
            <input type="text" class="rounded-lg" wire:model.debounce.750="gname_search">
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ - นามสกุล</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 flex-1 lg:flex-none">
            @foreach($committs as $key => $commit)
            <tr class="">
                <td class="text-center">{{ $key+1 }}</td>
                <td>{{ $commit->gname }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $committs->links() }}
        </div>
    </div>
</div>
