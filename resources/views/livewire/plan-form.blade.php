<div class="p-2">
    {{ $plan_id }}
    <form>
        <div class="lg:flex gap-2">
            <div class="w-full lg:w-1/5">
                <x-input.group inline for="stkcode" label="รหัส">
                    <x-input.text id="stkcode" wire:model="editing.stkcode" type="text" class="cursor-pointer hover:bg-indigo-50" wire:click="$emit('show:stmass-search', '{{ $master->to_dept_id ?? '0' }}')"></x-input.text>
                </x-input.group>
            </div>
            <div class="w-full lg:w-2/5">
                <x-input.group inline for="stkdesc" label="ชื่อกลางสินค้า/บริการ">
                    <x-input.text id="stkdesc" readonly value="{{ $editing->stkdesc }}" type="text" class="cursor-pointer hover:bg-indigo-50 cursor-not-allowed"></x-input.text>
                </x-input.group>
            </div>
            <div class="w-full lg:w-2/5">
                <x-input.group inline for="stkdesc2" label="ชื่อกลางสินค้า/บริการ">
                    <x-input.text id="stkdesc2" wire:model.defer="editing.stkdesc2" type="text"></x-input.text>
                </x-input.group>
            </div>
        </div>
        <div class="lg:flex justify-between gap-2">
            <div class="lg:w-1/2 w-full">
                <div class="flex justify-between gap-2 w-full">
                    <div class="w-1/2">
                        <x-input.group inline for="pqty" label="จำนวน">
                            <x-input.text id="pqty" wire:model.lazy="editing.pqty" type="number" class="cursor-pointer hover:bg-indigo-50"></x-input.text>
                        </x-input.group>
                    </div>
                    <div class="w-1/2">
                        <x-input.group inline for="unit" label="หน่วยนับ">
                            <x-input.text id="unit" wire:model.lazy="editing.unit" type="text" class="cursor-pointer hover:bg-indigo-50" readonly></x-input.text>
                        </x-input.group>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 w-full">
                <div class="flex justify-between gap-2">
                    <div class="w-1/2">
                        <x-input.group inline for="prc" label="ราคา">
                            <x-input.text id="prc" wire:model.lazy="editing.prc" inputmode="numeric" type="number" class="cursor-pointer hover:bg-indigo-50"></x-input.text>
                        </x-input.group>
                    </div>
                    <div class="w-1/2">
                        <x-input.group inline for="pamt" label="มูลค่ารวม">
                            <x-input.text id="pamt" wire:model="editing.pamt" inputmode="numeric" type="number" class="cursor-pointer hover:bg-indigo-50"></x-input.text>
                        </x-input.group>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="w-1/4">
                <x-input.group inline for="q1" label="ไตรมาส 1">
                    <x-input.text id="q1" wire:model.defer="editing.q1" type="number"></x-input.text>
                </x-input.group>
            </div>
            <div class="w-1/4">
                <x-input.group inline for="q2" label="ไตรมาส 2">
                    <x-input.text id="q2" wire:model.defer="editing.q2" type="number"></x-input.text>
                </x-input.group>
            </div>
            <div class="w-1/4">
                <x-input.group inline for="q3" label="ไตรมาส 3">
                    <x-input.text id="q3" wire:model.defer="editing.q3" type="number"></x-input.text>
                </x-input.group>
            </div>
            <div class="w-1/4">
                <x-input.group inline for="q4" label="ไตรมาส 4">
                    <x-input.text id="q4" wire:model.defer="editing.q4" type="number"></x-input.text>
                </x-input.group>
            </div>
        </div>
        <div class="lg:flex gap-2">
            <div class="w-full flex-1">
                <x-input.group inline for="from_dept" label="แผนก/หน่วยงาน">
                    <x-input.text id="from_dept" value="{{ $editing->from_dept_name }}" type="text" class="cursor-pointer hover:bg-indigo-50"></x-input.text>
                </x-input.group>
            </div>
            <div class="lg:w-96 w-full">
                <div class="flex justify-between gap-2">
                    <div class="w-1/2">
                        <x-input.group inline for="plany" label="ปีงบประมาณ">
                            <x-input.text id="plany" readonly value="{{ $editing->y + 543 }}" type="number"></x-input.text>
                        </x-input.group>
                    </div>
                    <div class="w-1/2">
                        <x-input.group inline for="pln_no" label="แผนลำดับที่">
                            <x-input.text id="pln_no" value="{{ $editing->no }}" type="number"></x-input.text>
                        </x-input.group>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>