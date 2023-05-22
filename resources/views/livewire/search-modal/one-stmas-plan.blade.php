<div class="px-4">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="border-b-2 border-gray-600 dark:border-gray-200 bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" wire:model="checkAll" aria-describedby="checkbox-1" type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="p-4 dark:text-gray-400">Id</th>
                                <th scope="col"
                                    class="p-4 text-sm font-bold text-left text-gray-700 uppercase dark:text-gray-300">
                                    แผนก/หน่วยงาน
                                </th>
                                <th scope="col"
                                    class="p-4 text-sm font-bold text-left text-gray-700 uppercase dark:text-gray-300">
                                    จำนวน
                                </th>
                                <th scope="col"
                                    class="p-4 text-sm font-bold text-right text-gray-700 uppercase dark:text-gray-300">
                                    ราคารวม
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($rows as $key => $row)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <div class="flex items-center">
                                            <input wire:model="selectedIds" value="{{ $row->id }}" id="checkbox-{{ $key }}" aria-describedby="checkbox-1" type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-{{ $key }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="w-4 p-4 dark:text-gray-400">1</td>
                                    <td
                                        class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $row->from_dept_name }}
                                    </td>
                                    <td
                                      class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ $row->pqty }} {{ $row->unit }}
                                    </td>
                                    <td
                                      class="p-4 text-base text-right font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                      {{ number_format($row->pamt, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                          @if($summary)  
                          <tr>
                            <th>
                              <th colspan="2" class="text-center font-bold taxt-gray-700 dark:text-white">ยอดรวม</th>  
                              <td class="text-center font-bold taxt-gray-700 dark:text-white"> {{ number_format($summary->qty, 0) }} {{ $row->unit ?? '' }} </td>
                              <td class="text-center font-bold taxt-gray-700 dark:text-white"> {{ number_format($summary->amount, 2) }} บาท </td>
                            </th>
                          </tr>
                          @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
