<div>  
    <div>
        <label for="search-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ค้นหา</label>
        <input autocomplete="off" autofocus type="text" id="search-text" wire:model="search" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
    <div class="mt-2 w-full text-md font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">    
        @foreach ($rows as $row)
            <button type="button" wire:click="$emit('set:doctype', '{{ $row->id }}')" class="w-full px-4 py-2 font-medium text-left border-b border-gray-200 cursor-pointer hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                {{ $row->docname }} {{ $row->id }}
            </button>
        @endforeach
    </div>
</div>
