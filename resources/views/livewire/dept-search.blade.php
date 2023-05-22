<div>
    <div>
        <x-input.text autofocus type="text" placeholder="ระบุคำค้นหา..." wire:model.debounce.500ms="search">
        </x-input.text>
    </div>
    <div class="rounded-md shadow-md border-gray-300 mt-2">
        @foreach ($rows as $row)
            <div wire:click="setDept('{{ $row->dept_id }}')" class="border-b border-gray-200 py-1 px-4 hover:bg-gray-200 cursor-pointer">
                {!! str_replace($search, '<span class="bg-yellow-200">'.$search.'</span>', $row->dept_name) !!}
            </div>
        @endforeach
    </div>
    <div>
        {{ $rows->links() }}
    </div>
</div>
