<div>
    @if (!$mode)
        <div class="lg:flex justify-between gap-2 mb-4">
            <div class="lg:w-1/2 w-full">
                <x-button.primary type="button" wire:click="add">เพิ่ม</x-button.primary>
            </div>
            <div class="lg:w-1/2 w-full text-right"></div>
        </div>
    @else
        <div class="mb-4">
            <form wire:submit.prevent="save">
                <div class="lg:flex justify-between gap-2 mb-6">
                    <div class="w-full lg:w-1/3">
                        <label for="object_number"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลขอ้างอิง</label>
                        <div class="flex items-center">
                            <input type="text" id="object_number" wire:model.lazy="object_number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="CC-00000" required>
                            <button type="button" wire:click="$emit('open:srcmodal', 'search-modal.objects')"
                                class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </div>
                    <div class="w-full lg:w-2/3">
                        <label for="objname"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียด</label>
                        <input type="text" id="objname" value="{{ $child->label ?? '' }}" readonly
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="เลือกประเภทสินค้า">
                            <span class="sr-only">{{ $child->label ?? '' }}</span>    
                    </div>
                </div>
                <div class="lg:flex justify-between gap-2">
                    <div class="lg:w-1/3 w-full">
                        <label for="pack_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">วันที่ทำรายการ</label>
                        <x-input.date wire:model="pack_date" id="pack_date" name="pack_date" />
                    </div>
                    <div class="lg:w-2/3 w-full">
                        <label for="obstatus"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">สถานะ</label>
                        <select wire:model="editing.status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>-- เลือกสถานะ --</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->obstatus }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end py-2 bg-gray-100 dark:bg-gray-700 mt-2 rounded-md gap-2">
                    <x-button.primary type="submit">บันทึก</x-button.primary>
                    <x-button.secondary type="button" wire:click="cancel">ยกเลิก</x-button.secondary>
                </div>
            </form>
        </div>
    @endif
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        รายละเอียด
                    </th>
                    <th scope="col" class="px-6 py-3">
                        เลขอ้างอิง
                    </th>
                    <th scope="col" class="px-6 py-3">
                        วันที่
                    </th>
                    <th scope="col" class="px-6 py-3">
                        สถานะ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $row)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $row->child->label }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $row->child->object_number }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->pack_date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $row->status_name }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a role="button" wire:click="edit('{{$row->id}}')"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            <a role="button" wire:click="confirmDelete('{{$row->id}}')"
                                class="font-medium text-red-600 dark:text-blue-500 hover:underline">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="text-center  px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            colspan="5">
                            -- Empty --
                        </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
