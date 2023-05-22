<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
                <li class="px-2"><a href="{{ route('stock.home') }}"
                        class="no-underline text-gray-900">คลังสินค้า</a></li>
                <li>
                    <x-icon.chevron-right></x-icon.chevron-right>
                </li>
                <li class="px-2"><span class="text-gray-700">ประเภทวัสดุและครุภัณฑ์</span></li>
            </ol>
        </nav>
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="w-full lg:w-1/4"><x-input.text wire:model.debounce.600ms='filters.search' type='text' class="mb-2" placeholder='ค้นหา...'></x-input.text></div>
                <div></div>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg py-2 px-2">
                <ul class="grid gap-6 text-center text-xs leading-4 col-start-1 row-start-2" style="grid-template-columns:repeat(auto-fill, minmax(132px, 1fr))">
                    @foreach($itemtypes as $key => $item)
                    <li class="relative flex flex-col-reverse p-2">
                        <a href="{{ route('objects.trans.depts') }}?parent_id={{ $item->id }}" >
                            <x-button.icon label="{{ $item->iname }}">
                                <x-image-item icon="{{ $item->icon }}" class=""></x-image-item>
                            </x-button.icon>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
