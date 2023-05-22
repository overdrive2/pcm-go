<div class="px-2 py-2">
    <div class="lg:flex gap-x-2">
        <div class="w-full lg:w-2/8">
            <x-input.group inline for="trdate_for_editing" label="วันที่ขอ" :error="$errors->first('editing.trdate')">
                <x-input.date wire:model="editing.trdate_for_editing" id="trdate_for_editing" name="trdate_for_editing" />
            </x-input.group>
        </div>
        <div class="w-full lg:w-1/8">
            <x-input.group inline for="trtime" label="เวลา" :error="$errors->first('editing.trtime')">
                <x-input.text type="text" wire:model.defer="editing.trtime" id="trtime"/>
            </x-input.group>
        </div>
        <div class="w-full lg:w-3/8">
            <x-input.group inline for="doctype_id" label="ประเภทเอกสาร" :error="$errors->first('editing.doctype_id')">
                <x-input.select2 id="doctype_id" search="search.doctype_kw" label="{{ $editing->doctype_name ?? '' }}">
                    @forelse($doctypes as $doctype)
                        <div wire:click="$set('editing.doctype_id','{{$doctype->id}}')" x-on:click="open = false;" class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700">{{ $doctype->docname }}</span>
                        </div>
                    @empty
                        <div class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700"> -- ไม่พบข้อมูล --</span>
                        </div>
                    @endforelse
                </x-input.select2>
            </x-input.group>
        </div>
        <div class="w-full lg:w-2/8">
            <x-input.group inline for="docnum" label="เลขที่เอกสาร" :error="$errors->first('editing.docnum')">
                <x-input.text type="text" wire:model.defer="editing.docnum" id="docnum"/>
            </x-input.group>
        </div>
    </div>
    <div class="lg:flex gap-x-2">
        <div class="w-full lg:w-1/2">
            <x-input.group inline for="site" label="จากคลัง" :error="$errors->first('editing.site')">
                <x-input.select id="site" placeholder="เลือกคลังตัดจ่าย" wire:model='editing.site'>
                    @foreach($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->sitename }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>
        </div>
        <div class="w-full lg:w-1/2">
            <x-input.group inline for="dept_id" label="แผนก/หน่วยงาน" :error="$errors->first('editing.dept_id')">
                <x-input.select2 id="dept_id" search="search.dept_kw" label="{{ $editing->department ?? '' }}">
                    @forelse($depts as $dept)
                        <div wire:click="$set('editing.dept_id','{{$dept->dept_id}}')" x-on:click="open = false;" class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700">{{ $dept->dept_name }}</span>
                        </div>
                    @empty
                        <div class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700"> -- ไม่พบข้อมูล --</span>
                        </div>
                    @endforelse
                </x-input.select2>
            </x-input.group>
        </div>
    </div>
    <div class="lg:flex gap-x-2">
        <div class="w-full">
            <x-input.group inline for="note" label="หมายเหตุ">
                <x-input.textarea id="note" class="rounded-md w-full"></x-input.textarea>
            </x-input.group>
        </div>
    </div>
    <div class="mt-2">
        @livewire('transfer-details',['transfer_id' => $editing->id, 'site' => $editing->site, 'src_stkcode' => $stkcode], key('detail'.$editing->id.$editing->site))
    </div>
</div>
