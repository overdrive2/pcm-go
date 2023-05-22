<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="mb-4 col-span-full xl:mb-2">
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a href="#"
                        class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                        <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('order.show') }}"
                            class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Orders</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Form</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Order Form</h1>
    </div>
    <div class="col-span-full xl:col-auto">
        <x-card.form class="2xl:col-span-2">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">รายละเอียดใบคำขอ</h3>
            <div class="mb-4">
                <div class="flex justify-between gap-2">
                    <div class="w-1/2">
                        <x-input.group inline for="order_date" label="วันที่ขอ" :error="$errors->first('editing.order_date')">
                            <x-input.date wire:model.defer="editing.date_for_editing" id="order_date"
                                name="order_date" />
                        </x-input.group>
                    </div>
                    <div class="w-1/2">
                        <x-input.group inline for="y" label="ประเภทคำขอ" :error="$errors->first('editing.potype')">
                            <x-input.select wire:model.defer="editing.potype" class="rounded-md focus:ring-0">
                                <option value="1">ซื้อ</option>
                                <option value="2">จ้าง</option>
                            </x-input.select>
                        </x-input.group>
                    </div>
                </div>
            </div>
            <div class="mb-4 flex w-full">
                <div class="w-full">
                    <x-input.group inline for="doctype_id" label="ประเภทเอกสาร">
                        <x-input.select id="doctype_id" wire:model.defer="editing.doctype_id" name="doctype"
                            class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>-- โปรดเลือกประเภทเอกสาร --</option>
                            @foreach ($documents as $item)
                                <option value="{{ $item->id }}">{{ $item->docname }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>
                <div class="flex-none w-auto">
                    <label class="relative inline-flex items-center cursor-pointer ml-2 mt-10">
                        <input type="checkbox" wire:model="editing.plan_for_editing" class="sr-only peer" checked>
                        <div
                            class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                        <span
                            class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $editing->plan_name }}</span>
                    </label>
                </div>
            </div>
            <div class="mb-4 flex flex-col gap-4">
                <x-input.group inline for="title" label="เรื่อง">
                    <x-input.text type="text" id="title" wire:model.defer="editing.title" />
                </x-input.group>
                <x-input.group inline for="res" label="เหตุผลความจำเป็น" :error="$errors->first('editing.res') ? 'โปรดระบุเหตุผล' : ''">
                    <x-input.text type="text" id="res" wire:model.defer="editing.res" />
                </x-input.group>
                <x-input.group inline for="vendor" label="ผู้ขาย">
                    <x-input.text wire:click="$set('showSearchVendor', true)" class="cursor-pointer" type="text"
                        id="vendor" value="{{ $editing->vendor_name }}" />
                </x-input.group>
            </div>
            <div class="mb-4">
                <div class="flex justify-between gap-2">
                    <div class="w-1/2">
                        <x-input.group inline for="fixtm" label="ความเร่งด่วน(วัน)" :error="$errors->first('editing.fixtm')">
                            <x-input.text type="number" wire:model.defer="editing.fixtm" id="fixtm"
                                name="fixtm" />
                        </x-input.group>
                    </div>
                    <div class="w-1/2">
                        <x-input.group inline for="phone" label="เบอร์ติดต่อภายใน" :error="$errors->first('editing.phone')">
                            <x-input.text type="text" wire:model.defer="editing.phone"
                                class="rounded-md focus:ring-0" />
                        </x-input.group>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <x-input.group inline for="note" label="หมายเหตุ">
                    <x-input.textarea id="note" wire:model.defer="editing.note" />
                </x-input.group>
            </div>
        </x-card.form>
        <x-card.form class="2xl:col-span-2">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">อนุมัติโดย</h3>
            <div class="grid grid-cols-1 gap-1 w-full mt-4">
                <x-card.commitee :no="__('1')" :comId="$editing->com1_id" />
                {!! $errors->first('editing.com1_id') ? '<span class="text-red-600 dark:text-red-500">โปรดระบุผู้อนุมัติ</span>' : '' !!}
            </div>
            <div class="grid grid-cols-1 gap-1 w-full mt-4">
                <x-card.commitee :no="__('2')" :comId="$editing->com2_id" />
            </div>
        </x-card.form>
        <x-card.form class="2xl:col-span-2">
            @livewire('order.upload', ['order_id' => $editing->id], key('poscan'))
        </x-card.form>
    </div>
    <div class="col-span-2">
        <x-card.form class="2xl:col-span-2">
            <h3 class="mb-4 text-xl font-semibold dark:text-white">รายการสินค้าและบริการ</h3>
            @livewire('order.detail', ['order_id' => $editing->id], key('detail' . $editing->id . $showEditDetail))
        </x-card.form>
    </div>
    <div class="col-span-3">
        <x-card.form class="2xl:col-span-2">
            <div class="lg:flex justify-between gap-2">
                <div class="lg:w-1/2 w-full">
                    <x-button.secondary wire:click="cancel" type="button">
                        <i class="fa-solid fa-trash-can w-4 h-4 mr-2 -ml-1 text-gray-500 dark:text-gray-400"></i>
                         ยกเลิกคำขอ</x-button.secondary>
                </div>
                <div class="lg:w-1/2 w-ful text-right">
                    <p class="inline-block mr-2 text-center dark:text-white">ผู้บันทึก {{ $editing->create_by_name }}</p>
                    <x-button.primary wire:click="saveConfirm" type="button">
                        <i class="fa-regular fa-floppy-disk w-4 h-4 mr-2 -ml-1"></i> 
                        บันทึก</x-button.primary>
                </div>
            </div>
        </x-card.form>
    </div>

    <x-modal.dialog wire:model.defer="showEditDetail" maxWidth="6xl">
        <x-slot name="title">รายละเอียดสินค้าและบริการ</x-slot>
        <x-slot name="content">
            @livewire('order.form-detail', ['detail_id' => $detail_id, 'poreq_id' => $editing->id], key('form-detail' . $editing->id . $detail_id))
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showEditDetail')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
            <x-button.primary wire:click="$emit('save:poreqd')" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showSearchVendor" maxWidth="6xl">
        <x-slot name="title">ค้นหารายการสินค้าและบริการ</x-slot>
        <x-slot name="content">
            @livewire('search-modal.vendors', ['loadData' => $showSearchVendor], key('search-modal.vendor' . $showSearchVendor))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchVendor')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showStmasPlan" maxWidth="6xl">
        <x-slot name="title">ค้นหารายการสินค้าและบริการ</x-slot>
        <x-slot name="content">
            @livewire('search-modal.stmas-plan', ['po_id' => $editing->id, 'loadData' => $showStmasPlan], key('search-modal.stmas-plan' . $showStmasPlan))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showStmasPlan')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showOneStmasPlan" maxWidth="x4" footerAlign="text-center">
        <x-slot name="title">รายการแผนของ {{ $stmas_name ?? '' }}</x-slot>
        <x-slot name="content">
            @livewire('search-modal.one-stmas-plan', ['stmas_id' => $stmas_id, 'y' => $editing->y, 'loadData' => $showOneStmasPlan], key('search-modal.one-stmas-plan' . $showOneStmasPlan))
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showOneStmasPlan')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
            <x-button.primary wire:click="$emit('post:selected:plan')" wire:loading.attr="disabled">
                {{ __('ตกลง') }}
            </x-button.primary>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showCommittee" maxWidth="x3" footerAlign="text-center">
        <x-slot name="title">เลือกรายการผู้อนุมัติ</x-slot>
        <x-slot name="content">
            @livewire('search-modal.committee', ['loadData' => $showCommittee, 'comId' => $comId], key('search-modal.committee' . $showCommittee))
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showCommittee')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="saveConfirmModal" maxWidth="lg" footerAlign="text-center">
        <x-slot name="title">Confirmation ?</x-slot>
        <x-slot name="content">
            <div class="p-6 pt-0 text-center">
                <svg class="w-16 h-16 mx-auto text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-5 mb-4 text-lg text-gray-600 dark:text-gray-200">ต้องการบันทึกใบคำขอนี้ใช่หรือไม่?</h3>
                <h4 class="mt-5 mb-4 text-lg text-gray-500 dark:text-gray-200">จำนวน {{ number_format($editing->qty, 0) }} รายการ</h4>
                <h4 class="mt-5 mb-4 text-base text-gray-500 dark:text-gray-200">มูลค่ารวม {{ number_format($editing->ttamt, 2) }} บาท</h4>
            </div>
        </x-slot>
        <x-slot name="footer">
            <a role="button" wire:click="save" @click="show = false"
                class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base inline-flex items-center px-3 py-2.5 text-center mr-2 dark:focus:ring-blue-800">
                ใช่, บันทึก
            </a>
            <a role="button" wire:click="$toggle('saveConfirmModal')" wire:loading.attr="disabled"
                class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-3 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                ไม่, ยกเลิก
            </a>
        </x-slot>
    </x-modal.dialog>

</div>
