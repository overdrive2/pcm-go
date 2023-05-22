<div>
    <div class="w-full">
        <div class="flex gap-2">
            <div class="w-auto relative flex-1">
                <x-select2 id="dept_search" wire:model="deptSelected" multiple>
                    <option>-- เลือกหน่วยงาน --</option>
                    @foreach($depts as $dept)
                        <option value="{{ $dept->dept_id }}">{{ $dept->dept_name }}</option> 
                    @endforeach
                </x-select2>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" wire:model="selectAll" type="checkbox" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 w-64">
                            ชื่อวัสดุ-ครุภัณฑ์
                        </th>
                        <th scope="col" class="px-6 py-3 w-60">
                            รหัส
                        </th>
                        <th scope="col" class="px-6 py-3 w-80">
                            แผนก/หน่วยงาน
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ราคา
                        </th>
                        <th scope="col" class="px-6 py-3">
                            จำนวน
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ราคารวม
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $key => $item)
                    <tr class="{{ $key % 2 == 0 ? 'bg-white border-b dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800' }} dark:border-gray-700">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-{{$key}}"  wire:model="selectedId" value="{{ $item->id }}"  type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-{{$key}}" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="px-6 py-4">
                            <span class="ml-2 font-medium text-gray-900 dark:text-white">{{ $item->stkdesc }}</span>
                        </th>
                        <td class="px-6 py-4">
                            {{ $item->stkcode }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->from_dept_name }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{ number_format($item->prc, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->pqty }} {{ $item->unit }} 
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{ number_format($item->pamt, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" colspan="5"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                            -- Empty --
                        </th>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" colspan="5"
                        class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white text-center text-lg font-medium">
                        จำนวน {{ $qty }}
                    </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @if ($rows)
        <div class="px-2 mt-2">
            {{ $rows->links() }}
        </div>
    @endif
</div>
