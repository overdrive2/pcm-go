<div>
    <div>
        <h4>รายการ{{ $document ?? '' }}</h4>
        <div>
            <x-input.text placeholder="ระบุคำค้นหา..." autocomplete="off" id="search" wire:model.debounce.600ms="search" type="text" autofocus />
        </div>
    </div>
    <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @foreach($rows as $row)
        <button type="button" @click="show = false" wire:click="$emit('set:stkcode', '{{ $row->stkcod }}')" class="w-full px-4 py-2 font-medium text-left border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
            <p class="text-gray-700 font-bold">{{ $row->stkcod }}</p>  
            <p class="text-gray-600">{!! str_replace($search, '<span class="bg-yellow-200">'.$search.'</span>', $row->stkdes) !!}</p>
        </button>
        @endforeach
    </div>
    <div id="pagination" class="overflow-x-auto">
        {{ $rows->links() }}
    </div>
</div>
