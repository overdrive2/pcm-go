<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="p-2 text-xs dark:text-gray-400">ลำดับ</th>
                            <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                หน่วยงาน/แผนก
                            </th>
                            <th scope="col" class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">จำนวน</th>
                            <th scope="col" class="p-2 text-center w-10">
                                <x-button.primary type="button" wire:click="$emit('search:one:stmasplan', '{{ $stmas_id }}')">เพิ่ม</x-button.primary>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach($rows as $key => $row)
                        @php
                            $plan = $row->stkplan()
                        @endphp
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="w-4 p-2 dark:text-gray-400">{{ $key + 1 }}</td>
                            <td class="p-2 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $plan->from_dept_name }}
                            </td>
                            <td class="p-2 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if($editId == $row->id)
                                <x-input.text type="number" wire:model.defer="qty" />
                                @else
                                {{ number_format($row->qty, 2) }}
                                @endif
                            </td>
                            <td class="text-center flex gap-1">
                                @if($editId == $row->id)
                                <button type="button" wire:click="save" class="mt-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-square-check w-5 h-5 text-blue-500 dark:text-blue-400"></i>
                                    <span class="sr-only">Save</span>
                                </button>
                                <button type="button" wire:click="cancel" class="mt-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-rectangle-xmark w-5 h-5 text-red-500 dark:text-red-400"></i>
                                    <span class="sr-only">Cancel</span>
                                </button>
                                @else
                                <button type="button" wire:click="edit('{{ $row->id }}')" class="mt-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-pen-to-square w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    <span class="sr-only">Edit</span>
                                </button>
                                <button type="button" wire:click="deleteConfirm('{{ $row->id }}')" class="mt-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <i class="fa-solid fa-rectangle-xmark w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
