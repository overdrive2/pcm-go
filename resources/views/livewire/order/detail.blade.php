<div class="flex flex-col mt-6">
    <div class="overflow-x-auto rounded-lg">
        <div class="inline-block min-w-full align-middle">
            <div class="flex justify-start py-2 px-4">
                <x-button.primary wire:click="add">เพิ่ม</x-button.primary>
            </div>
            <div class="overflow-hidden shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                ลำดับ
                            </th>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                รายละเอียด
                            </th>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                จำนวน
                            </th>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">
                                ราคา
                            </th>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-center text-gray-500 uppercase dark:text-white">
                                ราคารวม
                            </th>
                            <th scope="col"
                                class="p-4 text-sm font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                คำสั่ง
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                        @foreach($rows as $key => $row)
                        <tr class="{{ $key % 2 == 0 ? '' : 'bg-gray-50 dark:bg-gray-700' }}">
                            <td class="p-2 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $key + 1 }}
                            </td>
                            <td class="p-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                {{ $row->stkdes }}
                            </td>
                            <td class="p-2 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white text-center">
                                {{ number_format($row->qty, 0) }}
                            </td>
                            <td class="p-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400 text-right">
                                {{ number_format($row->prc, 2) }}
                            </td>
                            <td class="p-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400 text-right">
                                {{ number_format($row->ttamt, 2) }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex items-center ml-auto">
                                    <button type="button" wire:click="$emit('edit:detail', '{{ $row->uid }}')" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fa-solid fa-pen-to-square w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <button type="button" wire:click="deleteConfirm('{{ $row->uid }}')" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <i class="fa-solid fa-trash-can w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
