<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-2 xl:gap-4">
    <div class="col-span-full xl:col-auto">
        <div class="mb-2">
            <x-input.group inline for="vendor" label="สินค้าและบริการ" :error="$errors->first('editing.stmas_id')">
                <x-input.text wire:click="$emit('search:stmasplan')" placeholder="ค้นหา..." class="cursor-pointer" readonly type="text" id="vendor" value="{{ $editing->stkdes }}" />
            </x-input.group>
        </div>
        <div class="grid grid-cols-4 space-x-2">
            <div class="col-auto">
                <x-input.group inline for="qty" label="จำนวน" :error="$errors->first('editing.qty')">
                    <x-input.text readonly  wire:model.defer="editing.qty" type="number" id="qty" endingAddOn="{{ $editing->unit_name }}"  />
                </x-input.group>
            </div>
            <div class="col-auto">
                <x-input.group inline for="price" label="ราคา">
                    <x-input.text wire:model.lazy="editing.price_for_editing" type="text" id="price" :error="$errors->first('editing.prc')" />
                </x-input.group>
            </div>
            <div class="col-span-2">
                <x-input.group inline for="ttamt" label="ราคารวม" :error="$errors->first('editing.ttamt')">
                    <x-input.text wire:model.lazy="editing.ttamt_for_editing" type="text" id="ttamt" />
                </x-input.group>
            </div>
        </div>
    </div>
    <div class="col-span-full xl:col-auto">
        <h4 class="dark:text-gray-50">รายการแผนในปี </h4>
        <div>
            @if($editing->uid)
                @livewire('order.detail-plan', ['poreq_d_uid' => $editing->uid], key('poreq'.$editing->uid))
            @endif
        </div>
    </div>
</div>
