<div class="mt-2">
    <div>{{ $site }}:{{ $site_name }}</div>
    <x-input.text class="w-40 rounded-md" type="text" wire:model.debounce.600ms='search' />
    <div class="mt-2">
        @foreach($rows as $item)
        <div class="border-b shadow-sm px-2 py-1 cursor-pointer hover:bg-indigo-200">{{ $item->stkdes }}</div>
        @endforeach
    </div>
    <div class="mt-2">{{ $rows->links() }}</div>
</div>
