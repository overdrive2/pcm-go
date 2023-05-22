<div>
    <x-tw-file-upload name="file" wire:model="file" label="เลือก" :display-upload-progress="true" multiple>
    @foreach($files as $key => $file)
    <div class="flex justify-between border-b border-gray-300">
        <div class="flex gap-x-2">
            <span class="font-bold text-sm px-1 mt-1">{{ $key+1 }}.</span><div>{{ $file }}</div>
        </div>
        <div>
            <button wire:click="deleteFile('{{$key}}')"><x-icon.trash class="text-gray-500"></x-icon.trash></button>
        </div>
    </div>
    @endforeach
    </x-tw-file-upload>
</div>