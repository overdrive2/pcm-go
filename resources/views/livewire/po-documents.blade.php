<div>
    <div class="border-b flex justify-between border-gray-500 py-2">
        <div>เอกสารแนบ/ใบเสนอราคา/เอกสารอื่น ๆ ที่เกี่ยวข้อง</div>
        <div class="flex justify-end">
            <button type="button" class="border rounded-md px-2 py-1 text-white bg-gray-600" wire:click='uploadModal'>
                <x-icon.plus></x-icon.plus> เพิ่ม
            </button>
        </div>
    </div>
    <div>
        @foreach($docscans as $key => $doc)
        <div class="flex justify-between border-b border-gray-300 mt-1 mb-2 py-1">
            <div class="flex gap-x-2">
                <span class="font-bold text-sm px-1 mt-1 text-gray-800">{{ $key+1 }}.</span>
                <div class="text-gray-600 w-32">{{ $doc->doctypename }}</div>
                <div class="ml-2 w-5 h-5"><img src="{{ asset('images/svgs') }}/{{$doc->filetype}}.svg"> </div>
                <div class="text-gray-600"><a role="button" wire:click="showImage('{{$doc->id}}')">{{ $doc->docname }}</a></div>
            </div>
            <div class="px-2 flex gap-x-2 justify-center">
                <button wire:click="deleteConfirm('{{ Crypt::encrypt($doc->id) }}')"><svg class="inline-block w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <x-jet-dialog-modal wire:model="showModalUpload" maxWidth="6xl">
        <x-slot name="title">
            <div class="lg:px-2 px-0">
                หน้าอัพโหลดไฟล์ ขนาดไม่เกิน 2 MB
            </div>
        </x-slot>
        <x-slot name="content">
            <x-input.group for="docname" label="รายละเอียด" :error="$errors->first('editing.docname')">
                <x-input.text type="text" wire:model.defer="editing.docname" id="docname" placeholder="รายละเอียด" />
            </x-input.group>
            <x-input.group for="doctype_id" label="ประเภทเอกสาร" :error="$errors->first('editing.doctype_id')">
                <x-input.select wire:model="editing.doctype_id" id="doctype_id" placeholder="โปรดเลือกประเภทเอกสาร" class="rounded-md">
                    @foreach (App\Models\MnDocscantype::all() as $doctype)
                        <option value="{{ $doctype->id }}">{{ $doctype->doctypename }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>
            <x-input.group for="docfile" label="รายละเอียด" :error="$errors->first('editing.docfile')">
                <x-tw-file-pond
                    wire:model.defer="file"
                    id="docfile"
                    placeholder="รายละเอียด"
                >
                    <x-slot name="plugins">
                        FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);
                    </x-slot>
                    <x-slot name="optionsSlot">
                        allowFileTypeValidation: true,
                        acceptedFileTypes: ['image/png', 'image/jpeg', 'application/pdf'],
                        allowFileSizeValidation: true,
                        maxFileSize: '{{ env('MAX_FILE_SIZE') }}',
                        labelMaxFileSizeExceeded: ['{{ __('validation.file_large') }}'],
                        labelMaxFileSize: ['{{__('validation.max_file_size')}} {filesize}'],
                    </x-slot>
                </x-tw-file-pond>
            </x-input.group>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showModalUpload')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
            <x-button.primary type="button" wire:click="save" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-jet-dialog-modal>
</div>
