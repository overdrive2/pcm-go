<div class="px-4">
    <div class="w-full">
        <div class="relative">
            <input type="text" wire:model.debounce.700ms='search' autofocus
                class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full pr-8 pl-8 rounded z-0 focus:shadow"
                placeholder="ระบุคำค้นหา...">
            <div class="absolute top-2 left-2">
                <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500" wire:target='search'>
                </x-icon.search>
            </div>
            <div class="absolute top-2 right-4" wire:loading wire:target='search'>
                <x-spinner class="text-indigo-400 h-5"></x-spinner>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        รายการผู้ขาย
                    </th>
                    <th scope="col" class="px-6 py-3">
                        เลขหลักผู้ขาย
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $item)
                    <tr role="button" wire:click="$emit('set:vendor', '{{ $item->id }}')" class="bg-white cursor-pointer border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-200">
                        <td scope="row" class="px-4 py-2 {{ $current_id == $item->id ? 'font-bold text-blue-700 dark:text-blue-200':'font-medium text-gray-900 dark:text-white' }}">
                            <p class="whitespace-nowrap font-semibold">
                                {!! str_replace($search, '<span class="bg-yellow-100 dark:bg-yellow-700">'.$search.'</span>', $item->prenam . $item->supnam)  !!}
                            </p>
                            <p class="whitespace-nowrap">
                                {{ $item->addr01 .' '.$item->addr02  }}
                            </p>
                        </td>
                        <td>
                            {{ $item->gov_id }}
                        </td>
                    </tr>
                @empty
                    <tr colspan="2" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="px-4 py-1 text-center">
                            ไม่พบข้อมูล
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($rows)
    <div class="px-2 mt-2">
        {{ $rows->links() }}
    </div>
    @endif
</div>
