<div x-data="{step: @entangle('step')}">
    <div id="drawer-create-product-default"></div>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                      <li class="inline-flex items-center">
                        <a href="{{ route('plan.home') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                          <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                          Plan
                        </a>
                      </li>
                      <li>
                        <div class="flex items-center">
                          <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                          <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Requests</span>
                        </div>
                      </li>
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">คำขอซื้อขอจ้างในแผน</h1>
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <div class="sm:pr-3">
                        <label for="request-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <input type="text" wire:model.debounce.500ms="search" id="request-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="ค้นหาคำขอ...">
                        </div>
                    </div>
                    <div class="flex items-center w-full sm:justify-end">
                        <div class="flex pl-2 space-x-1">
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="#" class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2 w-full grow lg:flex justify-end">
                    <div class="flex gap-2">
                        <div class="grow w-96">
                            <x-select2 id="dept_search" wire:model="deptIds" multiple :placeholder="__('-- เลือกหน่วยงาน --')">
                                <option disabled>-- เลือกหน่วยงาน --</option>
                                @foreach($depts as $dept)
                                    <option value="{{ $dept->dept_id }}">{{ $dept->dept_name }}</option> 
                                @endforeach
                            </x-select2>
                        </div>
                        <x-button.primary type="button" class="w-28" wire:click="new">
                            New
                        </x-button.primary>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <x-table2>
            <x-slot name="header">
                <x-table.heading2 class="w-9" sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">
                    เลขคำขอ</x-table.heading2>
                <x-table.heading2 sortable multi-column>วันที่ขอ</x-table.heading2>
                <x-table.heading2 class="text-center">เรื่อง</x-table.heading2>
                <x-table.heading2 sortable multi-column>แผนก/หน่วยงาน</x-table.heading2>
                <x-table.heading2 class="text-center">รายการ</x-table.heading2>
                <x-table.heading2 class="text-right">ยอดรวม</x-table.heading2>
                <x-table.heading2 class="w-40 text-center">คำสั่ง</x-table.heading2>
            </x-slot>
            <x-slot name="body">
                @forelse ($rows as $key => $row)
                    <x-table.row2>
                        <x-table.cell2 class="lg:text-center">
                            <span class="lg:hidden px-2">เลขคำขอ</span>
                            <span class="font-bold lg:font-normal">{{ $row->id }}</span>
                            <div class="inline-block lg:hidden">
                                <span class="lg:hidden px-2">วันที่ขอ</span>
                                <span class="font-bold">{{ $row->date_for_human }}</span>
                            </div>
                        </x-table.cell2>
                        <x-table.cell2 class="hidden lg:inline-flex align-middle">
                            <span class="lg:hidden px-2">วันที่ขอ</span>
                            <span class="lg:font-normal font-bold lg:mt-1">{{ $row->date_for_human }}</span>
                        </x-table.cell2>
                        <x-table.cell2 inline="false">
                            <div class="lg:inline-block lg:text-left hidden ">
                                <span class="px-2 text-gray-700 font-bold">{{ $row->title }}</span>
                            </div>
                            <div class="lg:hidden">
                                <div class="w-full">
                                    <span class="px-2">เรื่อง</span>
                                    <span class="px-2 text-gray-700 font-bold">{{ $row->title }}</span>
                                </div>
                                <div class="w-full mt-1">
                                    <span class="lg:hidden px-2">รายละเอียด</span>
                                    <span
                                        class="lg:hidden px-2 text-gray-700 lg:font-normal font-bold">{{ $row->note }}</span>
                                </div>
                            </div>
                        </x-table.cell2>
                        <x-table.cell2>
                            <span class="lg:hidden px-2">แผนก/หน่วยงาน</span>
                            <span class="lg:font-normal font-bold">{{ $row->from_dept_name }}</span>
                        </x-table.cell2>
                        <x-table.cell2 class="text-center">
                            {{ $row->item_count ?? 0 }} รายการ
                        </x-table.cell2>
                        <x-table.cell2 class="lg:text-right text-center">
                            <span class="lg:hidden px-2">มูลค่ารวม</span>
                            <span class="lg:font-normal font-bold">{{ number_format($row->amount, 2) }}</span>
                        </x-table.cell2>
                        <x-table.action>
                            <button type="button" wire:click="edit('{{ $row->id }}')"
                                class="lg:bg-white bg-gray-300 text-gray-700 hover:text-yellow-700 flex border rounded-md lg:border-0 px-2 py-1">
                                <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                            </button>
                            <button type="button" wire:click="ConfirmDeleteMasterPlan('{{ $row->id }}')"
                                class="text-gray-700 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1 bg-gray-300 lg:bg-white">
                                <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                            </button>
                        </x-table.action>
                    </x-table.row2>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Empty</td>
                    </tr>
                @endforelse
            </x-slot>
        </x-table2>
        <div class="mt-2 px-4">
            {{ $rows->links() }}
        </div>
    </div>
    <x-modal.dialog wire:model.defer="showEditModal" maxWidth="x4" footerAlign="text-center">
        <x-slot name="title">รายละเอียดคำขอแผน</x-slot>
        <x-slot name="content">
            <div class="px-4">
                <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 mb-4">
                    <li :class="step == 1 ? 'text-blue-600 dark:text-blue-500' : 'text-gray-500 dark:text-gray-400'" class="flex items-center space-x-2.5">
                        <span :class="step == 1 ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0">
                            1
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">คำขอ</h3>
                            <p class="text-sm">รายละเอียด</p>
                        </span>
                    </li>
                    <li :class="step == 2 ? 'text-blue-600 dark:text-blue-500' : 'text-gray-500 dark:text-gray-400'" class="flex items-center space-x-2.5">
                        <span :class="step == 2 ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0">
                            2
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">รายการ</h3>
                            <p class="text-sm">รายการสินค้า/บริการ</p>
                        </span>
                    </li>
                    <li :class="step == 3 ? 'text-blue-600 dark:text-blue-500' : 'text-gray-500 dark:text-gray-400'" class="flex items-center space-x-2.5">
                        <span :class="step == 3 ? 'border-blue-600 dark:border-blue-500' : 'border-gray-500 dark:border-gray-400'" class="flex items-center justify-center w-8 h-8 border rounded-full shrink-0">
                            3
                        </span>
                        <span>
                            <h3 class="font-medium leading-tight">ยืนยัน</h3>
                            <p class="text-sm">ยืนยันคำขอ</p>
                        </span>
                    </li>
                </ol>
                <div x-show="step == 1">
                    <div class="lg:flex gap-x-2">
                        <div class="lg:grid grid-cols-2 gap-x-2 flex lg:w-1/2 w-full">
                            <div class="w-full">
                                <x-input.group inline for="plan_date" label="วันที่ขอแผน" :error="$errors->first('editing.plan_date')">
                                    <x-input.date wire:model.defer="editing.plan_date_for_editing" id="plan_date"
                                        name="plan_date" />
                                </x-input.group>
                            </div>
                            <div class="w-full">
                                <x-input.group inline for="y" label="ปีงบประมาณ" :error="$errors->first('editing.y')">
                                    <x-input.select wire:model.defer="editing.y" class="rounded-md focus:ring-0">
                                        @foreach ($years as $y)
                                            <option value="{{ $y->y }}">{{ $y->th }}</option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                            </div>
                        </div>
                        <div class="w-full lg:w-1/2">
                            <x-input.group inline for="doctype" label="ประเภทเอกสาร" :error="$errors->first('editing.doctype_id')">
                                <x-input.text type="text" readonly value="{{ $editing->doctype_name }}"
                                    class="cursor-pointer hover:bg-indigo-50" wire:click="openSearchDoctype"></x-input.text>
                            </x-input.group>
                        </div>
                    </div>
                    <div class="w-full">
                        <x-input.group inline for="from_dept_id" label="แผนก/หน่วยงาน(ขอซื้อ/จ้าง)" :error="$errors->first('editing.from_dept_id')">
                            <x-input.text type="text" readonly value="{{ $editing->from_dept_name }}"
                                class="cursor-pointer hover:bg-indigo-50"
                                wire:click="searchModal('dept-search', 'set:fromdept', false)"></x-input.text>
                        </x-input.group>
                    </div>
                    <div class="w-full">
                        <x-input.group inline for="to_dept_id" label="แผนก/หน่วยงาน(ดำเนินการ)">
                            <x-input.text id="to_dept_id" value="{{ $editing->to_dept_name }}" type="text"
                                class="cursor-pointer hover:bg-indigo-50"
                                wire:click="searchModal('dept-search', 'set:todept', true)"></x-input.text>
                        </x-input.group>
                    </div>
                    <x-input.group inline for="title" label="เรื่อง" :error="$errors->first('editing.title')" :error="$errors->first('editing.title')">
                        <textarea type="text" wire:model.defer="editing.title" id="title" rows=3
                            class="w-full rounded-md text-sm form-textarea focus:ring-0 focus:shadow-md px-2  focus:border-gray-400"></textarea>
                    </x-input.group>
                    <x-input.group inline for="note" label="หมายเหตุ" :error="$errors->first('editing.note')">
                        <textarea type="text" wire:model.defer="editing.note" id="note" rows=3
                            class="w-full rounded-md text-sm form-textarea focus:ring-0 focus:shadow-md px-2  focus:border-gray-400"></textarea>
                    </x-input.group>
                </div>
                <div x-show="step == 2">
                    @livewire('stk-plans', ['master_id' => $editing->id, 'loadData' => ($step == 2)], key('plan-detail' . $editing->id . $step))
                </div>
                <div x-show="step == 3">
                    <div class="p-4 w-full h-full md:h-auto">
                        <!-- Modal content -->
                        <div class="p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                            <p>วันที่ขอ <span class="font-semibold">{{ $editing->plan_date_for_editing }}</span></p>
                            <p>เรื่อง <span class="font-semibold">{{ $editing->title }}</span> </p>
                            <p>หมายเหตุ {{ $editing->note }}</p>
                            <p>แผนก/หน่วยงาน(ขอซื้อ/จ้าง)<br><span class="font-semibold">{{ $editing->from_dept_name }}</span></p>
                            <p>แผนก/หน่วยงาน(ดำเนินการ)<br> <span class="font-semibold">{{ $editing->to_dept_name }}</span></p>
                            <p>จำนวน <span class="font-bold text-indigo-700">{{ $editing->qty }}</span> รายการ</p>
                            <p>มูลค่ารวม <span class="font-bold text-indigo-700">{{ number_format($editing->amount) }}</span> บาท</p>
                            <p class="mb-2 text-gray-500 dark:text-gray-300 mt-2">
                                <i class="inline-block fa-solid fa-circle-check text-green-400 dark:text-green-500 w-6 h-6 mx-auto"></i> ตรวจสอบความถูกต้องของข้อมูลแล้ว, ยืนยันบักทึกรายการคำขอนี้?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="py-2">
                <x-button.secondary type="button" x-show="step > 1" class="ml-2" wire:click="prev" wire:loading.attr="disabled">
                    <i class="fa-solid fa-arrow-left"></i> {{ __('ก่อนหน้า') }}
                </x-button.secondary>
                <x-button.primary type="button" x-show="step < 3" class="ml-2" wire:click="next" wire:loading.attr="disabled">
                    {{ __('ถัดไป') }} <i class="fa-solid fa-arrow-right"></i>
                </x-button.primary>
                <x-button.primary type="button" x-show="step == 3" class="ml-2" wire:click="save" wire:loading.attr="disabled">
                    <i class="fa-solid fa-check"></i> {{ __('บันทึก') }}
                </x-button.primary>
            </div>
        </x-slot>
    </x-modal.dialog>
    <!-- Plan Details stmass list -->
    <x-modal.dialog wire:model.defer="showPlanDetailModal" maxWidth="6xl">
        <x-slot name="title">รายการวัสดุ/ครุภัณฑ์</x-slot>
        <x-slot name="content">
            @livewire('stk-plans', ['master_id' => $master_id, 'loadData' => $showPlanDetailModal], key('plan-detail' . $master_id . $showPlanDetailModal))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showPlanDetailModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <!-- Plan Details stmass list -->
    <x-modal.dialog wire:model.defer="showEditPlanModal" maxWidth="x4">
        <x-slot name="title">รายละเอียด</x-slot>
        <x-slot name="content">
            @livewire('plan-form', ['plan_id' => $plan_id, 'master_id' => $master_id, 'loadData' => $showEditPlanModal], key('plan-form'.$plan_id.$showEditPlanModal))
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showEditPlanModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
            <x-button.primary wire:click="$emit('save:stkplan')" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-modal.dialog>

    <!-- Search document type -->
    <x-modal.dialog wire:model.defer="showSearchDoctype" maxWidth="4xl">
        <x-slot name="title">ค้นหารายการประเภทเอกสาร</x-slot>
        <x-slot name="content">
            @livewire('search-modal.document-type', ['loadData' => $showSearchDoctype], key('search-modal.document-type'.$showSearchDoctype))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchDoctype')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showSearchModal" maxWidth="2xl">
        <x-slot name="title">ค้นหาหน่วยงาน/กลุ่มงาน</x-slot>
        <x-slot name="content">
            @if($showSearchModal)
                @livewire($modalComponent, ['action' => $action, 'owner' => $owner], key('srcModal'.$showSearchModal.$action.$modalComponent))
            @endif
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showSearchStmass" maxWidth="4xl">
        <x-slot name="title">ค้นหารายการสินค้าและบริการ</x-slot>
        <x-slot name="content">
            @livewire('search-modal.stmas', ['loadData' => $showSearchStmass, 'doctype_id' => $editing->doctype_id], key('search-modal.stmas'.$showSearchStmass.$editing->doctype_id))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchStmass')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>
</div>
