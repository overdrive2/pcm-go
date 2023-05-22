<div>
    <div class="flex flex-col justify-center h-auto lg:px-2 px-0">
        <!-- Table -->
        <div class="w-full  bg-white shadow-lg rounded-md border border-gray-200">
            <header class="px-2 py-2 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">ผลการค้นหา</h2>
            </header>
            <div class="p-3">
                <div class="overflow-x-auto overflow-y-auto">
                    <table class="table-auto w-full">
                        <thead class="text-xs font-semibold uppercase text-gray-600 bg-gray-50">
                            <tr>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">ชื่อ-นามสกุล</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">ตำแหน่ง</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-left">หน่วยงาน</div>
                                </th>
                                <th class="p-2 whitespace-nowrap">
                                    <div class="font-semibold text-center">คำสั่ง</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @foreach($directors as $director)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="rounded-full h-10 w-10 bg-cover bg-center" style="background-image: url('{{ $director->photo_url }}')"></div>
                                        <div class="font-medium text-gray-800 ml-2">{{ $director->gname  }}</div>
                                        <span class="sr-only">{{ $director->id }}</span>
                                    </div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $director->position_name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left font-medium text-gray-500">{{ $director->agency_name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap text-center">
                                    <button class="hover:bg-gray-800 text-white rounded-md bg-gray-500 px-1 py-1" wire:click="$emit('set:director{{$comtype}}', '{{$director->id}}')">เลือก</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($directors)
                        <div>{{ $directors->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
