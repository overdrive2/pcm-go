<div>
    <div class="grid grid-cols-1 gap-2">
        <div class="lg:flex justify-between gap-2">
            <div class="w-full lg:w-1/3">
                <x-input.group inline for="stmas_search" label="รหัสสินค้า/บริการ" :error="$errors->first('editing.stmas_id')">
                    @if($pod_id)
                        <x-input.text type="text" value="{{ $editing->stkcode }}" id="stkcode" name="stkcode" readonly />
                    @else
                    <div id="stmas_id" class="flex items-center">
                        <input type="text" value="{{ $editing->stkcode }}"
                        class='bg-gray-50 border border-gray-300 text-gray-900 focus:outline-none focus:shadow-md text-sm rounded-lg focus:ring-indigo-500 focus:ring-0 focus:border-indigo-500 block w-full pl-2 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500'
                        >
                        <button type="button" wire:click="$emit('open:stmasplan:modal')"
                            class="p-2.5 ml-1 text-sm font-medium text-white bg-indigo-700 rounded-lg border border-indigo-700 hover:bg-indigo-800 focus:outline-none focus:ring-1 focus:ring-indigo-200 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                    @endif
                </x-input.group>
            </div>
            <div class="w-full flex-1">
                <x-input.group inline for="stkdes" label="รายละเอียด" :error="$errors->first('editing.stkdes')">
                    <x-input.text type="text" value="{{ $editing->stkdes }}" id="stkdes" name="stkdes" readonly />
                </x-input.group>
            </div>
        </div>
        <div class="lg:flex gap-2">
            <div class="w-full lg:w-1/3">
                <x-input.group inline for="qty" label="จำนวน" :error="$errors->first('editing.qty')">
                    @if($plan)
                        <x-input.text readonly endingAddOn="{{ $editing->unit_name }}" type="number" value="{{ $editing->qty }}" id="qty" name="qty" />
                    @else
                        <x-input.text required endingAddOn="{{ $editing->unit_name }}" type="number" wire:model.defer="editing.qty" id="qty" name="qty" />
                    @endif    
                </x-input.group>
            </div>
            <div class="w-full lg:w-1/3">
                <x-input.group inline for="price" label="ราคา" :error="$errors->first('editing.prc')">
                    <x-input.text type="number" wire:model.lazy="editing.prc" value="{{ $editing->prc }}" id="price" name="price" endingAddOn='บาท' />
                </x-input.group>
            </div>
            <div class="w-full lg:w-1/3">
                <x-input.group inline for="ttamt" label="ราคารวม" :error="$errors->first('editing.ttamt')">
                    <x-input.text type="text" value="{{ number_format($editing->ttamt, 2) }}" id="ttamt" name="ttamt" readonly endingAddOn='บาท'/>
                </x-input.group>
            </div>
        </div>
    </div>
    @if($plan)
    <div class="w-full px-4">
        <h4 class="bg-indigo-50">รายการในแผน</h4>
            @if($summary['amount'] > 0)
            <div class="lg:flex justify-between gap-2">
                <div class="w-full lg:w-1/2 flex gap-2 py-2">
                    @if($master['inpln'])
                        <span class="inline-flex items-center px-3  bg-gray-50 text-gray-800 sm:text-sm text-base font-bold w-28">คงเหลือ</span>
                        <x-input.text type="text"  value="{{ $summary['qty'] }}" endingAddOn="{{ $editing->unit_name }}" />
                        <x-input.text type="text"  value="{{ $summary['amount'] }}" endingAddOn="บาท" />
                    @endif
                </div>
                <div class="w-full lg:w-1/2 text-right py-2">
                    <x-button.primary wire:click="add" class="ml-4">เพิ่ม</x-button.primary>
                </div>
            </div>
            @endif
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($plans as $key => $plan)
            <li class="py-3 sm:py-4 px-4">
                <div class="flex items-center space-x-4">
                    <x-card.plan :key="$key+1" :plan="$plan" selectedId="{{ $selectedPlanId }}" qty="{{ $qty }}" :unit="$editing->unit_name" />
                    <div class="px-2 flex">
                        <button type="button" wire:click = "delCacheConfirm({{$plan->id}})" class="text-gray-500 hover:text-gray-700 flex rounded-md border lg:border-0 px-2 py-1">
                            <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                        </button>
                    </div>    
                </div>
            </li>
            @endforeach
            </ul>
        </div>
    @endif
</div>
