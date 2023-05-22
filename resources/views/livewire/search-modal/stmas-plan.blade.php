<div>
    <div class="w-full p-4sm:p-8 mb-2">
        <div class="flex items-center justify-between mb-4">
            <div class="w-full lg:w-1/2">
                <x-input.text type="text" wire:model.debounce.600ms="search"></x-input.text>
            </div>
       </div>
       <div class="flow-root">
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($rows as $key => $row)
            @php
                $plan = $row->getPlanQty($poh->dept_id, $poh->y);
                $reqqty = $row->getRequestQty($poh->dept_id, $poh->y, 'Y');
            @endphp
            <li class="py-2 sm:py-3">
                <div class="inline-flex items-center justify-between w-full p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 space-x-4">
                    <div class="flex-shrink-0">
                        <img class="w-10 h-10 border rounded-full" src="{{ asset('images/noimage.jpg') }}" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $row->stkdes }}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ $row->stkcod }}
                        </p>
                    </div>
                    <div class="flex-row px-2">
                        <p class="px-2 text-right text-sm text-gray-500 truncate dark:text-gray-400">จำนวนแผน {{ number_format($reqqty, 0) }}/{{ number_format($plan->pqty, 0) }} {{ $row->unit_name }}</p>
                        <p class="px-2 text-right text-sm text-gray-500 truncate dark:text-gray-400">มูลค่ารวม {{ number_format($plan->pamt, 2) }} บาท</p>
                    </div>
                    <div>
                        @if($plan->pqty > $reqqty)
                        <x-button.primary type="button" wire:click="$emit('set:stmassid', '{{$row->id}}')">เลือก</x-button.primary>
                        @else
                        <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Checked</span>
                        @endif
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
       </div>
    </div>
    <div>
    @if($rows)
        {{ $rows->links() }}
    @endif</div>
</div>
