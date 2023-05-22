<div>
    <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
        <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="{{ asset('images/prpaper.png') }}"
            alt="Jese picture">
        <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">
            <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">ใบเสนอราคา</h3>
            <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                PDF, JPG, GIF or PNG. Max size of 5MB
            </div>
            @error('file')
                <div class="mb-4 text-xs text-red-500 dark:text-red-400">
                    {{ $message }}
                </div>
            @enderror
            <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700 mb-2" x-show="isUploading">
                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full transition: width 1s"
                    :style="`width: ${progress}%;`" x-text="`${progress}%`"></div>
            </div>
            <div class="flex items-center space-x-4">
                <label role="button" for="file-upload"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z">
                        </path>
                        <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                    </svg>
                    อัพโหลด
                    <input id="file-upload" type="file" wire:model="file" class="hidden" />
                </label>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-1 w-full mt-4">
        <!-- Item -->
        @foreach($rows as $row)
            <x-image.poscan :row="$row" />
        @endforeach
    </div>
</div>
