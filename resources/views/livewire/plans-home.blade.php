<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('แผนจัดซื้อ/จัดจ้าง') }}
        </h2>
    </x-slot>
    <div class="border-b px-2 flex">
        <button type="button" wire:click="$set('view_mode', 'master')" class="px-4 py-2 border rounded-md rounded-b-none {{$view_mode == 'master' ? 'bg-gray-300':''}}">
            <i class="fa-solid fa-calculator"></i> ใบคำขอ
        </button>
        <button wire:target="$set('view_mode', 'detail')" wire:loading.attr="disabled" type="button" wire:click="$set('view_mode', 'detail')" class="px-4 py-2 border rounded-md rounded-b-none {{$view_mode == 'detail' ? 'bg-gray-300':''}}">
            <div class="inline-block" wire:target="$set('view_mode', 'detail')" wire:loading.class="hidden"><i class="fa-solid fa-list"></i></div> 
            <x-spinner class="w-5" wire:loading wire:target="$set('view_mode', 'detail')" /> รายการเคลื่อนไหว</button>
        <div class="flex-1 text-right"><x-button.primary type='button' wire:click='new'>สร้าง</x-button.primary> </div>   
    </div>
    <div class="lg:flex flex-wrap gap-2 mb-2 py-1 px-2">
        <div class="lg:flex gap-2">
            <label for="search" class="inline-block mt-1 px-2">ค้นหา</label>
            <x-input.text type="text" wire:model.debounce.650ms="search" id="search" class="w-full" placeholder="ค้นหา..."/>
        </div>
        <div class="lg:flex gap-2">
            <label for="dept_search" class="inline-block mt-1 px-2">แผนก/หน่วยงาน</label>
            <x-input.text type="text" wire:click="searchModal('dept-search', 'set:srcdept', false)" value="{{ $dept_search_name }}" readonly class="w-full cursor-pointer" id="dept_search" placeholder="ทั้งหมด" />
        </div>
        <div class="lg:flex gap-2">
            <label for="current_year" class="inline-block mt-1 px-2">ปีงบประมาณ</label>
            <x-input.select class="w-full" id="current_year" wire:model="current_year">
                @foreach ($years as $y)
                    <option value="{{ $y->y }}">{{ $y->th }}</option>
                @endforeach
            </x-input.select>
        </div>
    </div>
    @if($view_mode == 'master')
    <x-table2>
        <x-slot name="header">
            <x-table.heading2 class="w-9" sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">เลขคำขอ</x-table.heading2>
            <x-table.heading2 sortable multi-column>วันที่ขอ</x-table.heading2>
            <x-table.heading2 sortable multi-column>แผนก/หน่วยงาน</x-table.heading2>
            <x-table.heading2 class="text-center">เรื่อง</x-table.heading2>
            <x-table.heading2 class="text-center">รายการ</x-table.heading2>
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
                    <x-table.cell2>
                        <span class="lg:hidden px-2">แผนก/หน่วยงาน</span>
                        <span class="lg:font-normal font-bold">{{ $row->from_dept_name }}</span>
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
                                <span class="lg:hidden px-2 text-gray-700 lg:font-normal font-bold">{{ $row->note }}</span>
                            </div>
                        </div>
                    </x-table.cell2>
                    <x-table.cell2 class="text-center">
                        <x-button.primary type="button" wire:click="showPlanDetail('{{ $row->id }}')">{{ $row->item_count ?? 0 }} รายการ</x-button.primary>
                    </x-table.cell2>
                    <x-table.action>
                        <button type="button" wire:click="edit('{{ $row->id }}')" class="lg:bg-white bg-gray-300 text-gray-700 hover:text-yellow-700 flex border rounded-md lg:border-0 px-2 py-1">
                            <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                        </button>
                        <button type="button" wire:click="ConfirmDeleteMasterPlan('{{ $row->id }}')" class="text-gray-700 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1 bg-gray-300 lg:bg-white">
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
    <div class="mt-2">
        {{ $rows->links() }}
    </div>
    @else
    <div class="flex flex-col h-screen max-h-screen">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="sticky-top bg-white z-50">
                    <tr class="border">
                        <th class="border-white bg-gray-200 border px-2 align-middle" rowspan="2">รหัส</th>
                        <th class="border-white bg-gray-200 border px-2 align-middle min-w-[200px]" rowspan="2">รายละเอียด</th>
                        <th class="border-white bg-gray-200 border px-2 align-middle min-w-[200px]" rowspan="2">หน่วยงาน/แผนก</th>
                        <th class="border-white bg-gray-200 border px-2 text-right" rowspan="2">ราคา</th>
                        <th class="border-white bg-yellow-200 border px-2 text-right" rowspan="2">จำนวน</th>
                        <th class="border-white bg-gray-200 border px-2 text-right" rowspan="2">หน่วยนับ</th>
                        <th class="border-white bg-gray-200 border px-2 text-center" rowspan="2">มูลค่า</th>
                        <th class="border w-48 bg-gray-300" colspan="2">รอดำเนินการ</th>
                        <th class="border w-48 bg-red-300" colspan="2">ขอซื้อ/จ้าง</th>
                        <th class="border w-48 bg-blue-300" colspan="2">กำลังดำเนินการ</th>
                        <th class="border w-48 bg-green-300" colspan="2">ดำเนินการเสร็จ</th>
                    </tr>
                    <tr class="border">
                        <th class="border bg-gray-300">จำนวน</th>
                        <th class="border text-center bg-gray-300">มูลค่า</th>
                        <th class="border bg-red-300">จำนวน</th>
                        <th class="border text-center bg-red-300">มูลค่า</th>
                        <th class="border bg-blue-300">จำนวน</th>
                        <th class="border text-center bg-blue-300">มูลค่า</th>
                        <th class="border bg-green-300">จำนวน</th>
                        <th class="border text-center bg-green-300">มูลค่า</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $key=>$row)
                    <tr class="border-b border-gray-200">
                        <td class="text-center align-top">{{ $row->id }}</td>
                        <td class="align-top">
                            <button type="button" class="text-left w-full hover:bg-gray-200 px-2" wire:click="detail('{{ $row->stkcode }}', '{{ $row->unit }}')">
                                <div class="text-gray-800">{{ $row->stkcode }}</div>
                                <div class="text-gray-600">{{ $row->stkdesc }}</div>
                            </button>
                        </td>
                        <td>{{ $row->from_dept_name }}</td>
                        <td class="text-right">{{ number_format($row->prc, 2) }}</td>
                        <td class="text-right border px-1">{{ number_format($row->pqty, 0) }}</td>
                        <td class="text-center">{{ $row->unit }}</td>
                        <td class="text-right">{{ number_format($row->pamt, 2) }}</td>
                        <td class="border text-center px-1">
                            <div>{{ number_format($row->pqty - $row->wait_qty, 0) }}</div>
                        </td>
                        <td class="border text-right px-1">
                            <div>{{ number_format($row->pamt - $row->wait_total, 2) }}</div>
                        </td>
                        <td class="text-center px-2">
                            <div class="px-2">
                                <a role="button" wire:click="showStmasOrder('{{ $row->stmas_id }}')" class="{{ $row->wait_qty > 0 ? 'cursor-pointer font-semibold bg-red-500 text-white rounded-md px-2' : '' }}">{{ number_format($row->wait_qty, 0) }}</a>
                            </div>
                        </td>
                        <td class="text-right px-2"><div class="px-2 {{ $row->wait_total > 0 ? 'bg-red-500 text-white' : '' }}">{{ number_format($row->wait_total, 2) }}</div></td>
                        <td class="text-center px-2">
                            <div class="px-2 {{ $row->inprg_qty > 0 ? 'bg-blue-500 text-white' : '' }}">{{ number_format($row->inprg_qty, 0) }}</div>
                        </td>
                        <td class="text-right px-2"><div class="px-2 {{ $row->inprg_total > 0 ? 'bg-blue-500 text-white' : '' }}">{{ number_format($row->inprg_total, 2) }}</div></td>
                        <td class="text-center"><div class="px-2 {{ $row->comp_qty > 0 ? 'bg-green-500 text-white' : '' }}">{{ number_format($row->comp_qty, 0) }}</div></td>
                        <td class="text-right"><div class="px-2 {{ $row->comp_total > 0 ? 'bg-green-500 text-white' : '' }}">{{ number_format($row->comp_total, 2) }}</div></td>
                    </tr>
                    @endforeach
                </tbody>
                @if($summary)
                <tfoot>
                    <tr class="py-2">
                        <th class="py-1 border px-2 text-center" colspan="4">รวมทั้งสิ้น</th>
                        <th class="py-1 border text-right px-2">{{ number_format($summary->pqty, 0) }}</th>
                        <th class="py-1 border text-right px-2"></th>
                        <th class="py-1 border text-right px-2">{{ number_format($summary->pamt, 2) }}</th>
                        <th class="py-1 border text-right px-2">{{ number_format($summary->curqty, 0) }}</th>
                        <th class="py-1 border text-right px-2">{{ number_format($summary->curamt, 2) }}</th>
                        <th class="py-1 border text-right px-2 text-red-700">{{ number_format($summary->wqty, 0) }}</th>
                        <th class="py-1 border text-right px-2 text-red-700">{{ number_format($summary->wamt, 2) }}</th>
                        <th class="py-1 border text-right px-2 text-blue-700">{{ number_format($summary->prgqty, 0) }}</th>
                        <th class="py-1 border text-right px-2 text-blue-700">{{ number_format($summary->prgamt, 2) }}</th>
                        <th class="py-1 border text-right px-2 text-green-700">{{ number_format($summary->compqty, 0) }}</th>
                        <th class="py-1 border text-right px-2 text-green-700">{{ number_format($summary->compamt, 2) }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        <div class="px-2 py-1">
            {{ $rows->links() }}
        </div>
    </div>
    @endif
    <x-modal.dialog wire:model.defer="showEditModal" maxWidth="2xl">
        <x-slot name="title">รายละเอียดคำขอแผน</x-slot>
        <x-slot name="content">
            <div class="px-4">
                <div class="lg:flex gap-x-2">
                    <div class="w-full lg:w-2/8">
                        {{ $editing->date_for_editing ?? '' }}
                        <x-input.group inline for="plan_date" label="วันที่ขอแผน" :error="$errors->first('editing.plan_date')">
                            <x-input.date wire:model.defer="editing.plan_date_for_editing" id="plan_date" name="plan_date" />
                        </x-input.group>
                    </div>
                    <div class="w-full lg:w-1/5">
                        <x-input.group inline for="y" label="ปีงบประมาณ" :error="$errors->first('editing.y')">
                            <x-input.select wire:model.defer="editing.y" class="rounded-md focus:ring-0">
                                @foreach ($years as $y)
                                <option value="{{ $y->y }}">{{ $y->th }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                </div>
                <div class="w-full">
                    <x-input.group inline for="doctype" label="ประเภทเอกสาร">
                        <x-input.text type="text" readonly value="{{ $editing->doctype_name }}" class="cursor-pointer hover:bg-indigo-50" wire:click="openSearchDoctype"></x-input.text>
                    </x-input.group>
                </div>
                <div class="w-full">
                    <x-input.group inline for="from_dept_id" label="แผนก/หน่วยงาน(ขอซื้อ/จ้าง)">
                        <x-input.text type="text" readonly value="{{ $editing->from_dept_name }}" class="cursor-pointer hover:bg-indigo-50" wire:click="searchModal('dept-search', 'set:fromdept', false)"></x-input.text>
                    </x-input.group>
                </div>
                <div class="w-full">
                    <x-input.group inline for="to_dept_id" label="แผนก/หน่วยงาน(ดำเนินการ)">
                        <x-input.text id="to_dept_id" value="{{ $editing->to_dept_name }}" type="text" class="cursor-pointer hover:bg-indigo-50" wire:click="searchModal('dept-search', 'set:todept', true)"></x-input.text>
                    </x-input.group>
                </div>
                <x-input.group inline for="title" label="เรื่อง" :error="$errors->first('editing.title')">
                    <textarea type="text" wire:model.defer="editing.title" id="title" rows=3 class="w-full rounded-md text-sm form-textarea focus:ring-0 focus:shadow-md px-2  focus:border-gray-400"></textarea>
                </x-input.group>
                <x-input.group inline for="note" label="หมายเหตุ" :error="$errors->first('editing.note')">
                    <textarea type="text" wire:model.defer="editing.note" id="note" rows=3 class="w-full rounded-md text-sm form-textarea focus:ring-0 focus:shadow-md px-2  focus:border-gray-400"></textarea>
                </x-input.group>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showEditModal')" wire:loading.attr="disabled">
                {{ __('ยกเลิก') }}
            </x-jet-secondary-button>

            <x-button.primary class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
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

    <!-- Product Info -->
    <x-modal.dialog wire:model.defer="showStmassModal" maxWidth="3xl">
        <x-slot name="title">รายละเอียดวัสดุ/ครุภัณฑ์</x-slot>
        <x-slot name="content">
            @livewire('stmass-detail', ['stkcode' => $stkcode, 'site' => $site, 'unit_name' => $unit, 'loadData' => $showStmassModal], key('stmass-detail'.$stkcode.$showStmassModal))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showStmassModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <!-- Plan Details stmass list -->
    <x-modal.dialog wire:model.defer="showPlanDetailModal" maxWidth="6xl">
        <x-slot name="title">รายการวัสดุ/ครุภัณฑ์</x-slot>
        <x-slot name="content">
             @livewire('stk-plans', ['master_id' => $master_id, 'loadData' => $showPlanDetailModal], key('plan-detail'.$master_id.$showPlanDetailModal))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showPlanDetailModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <!-- Plan Details stmass list -->
    <x-modal.dialog wire:model.defer="showEditPlanModal" maxWidth="6xl">
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

    <!-- Plan Details stmass list -->
    <x-modal.dialog wire:model.defer="showStmasOrderModal" maxWidth="6xl">
        <x-slot name="title">รายการสั่งซื้อ</x-slot>
        <x-slot name="content">
            @livewire('plan.stmas-order', ['stmas_id' => $stmas_id], key('plan-form'.$stmas_id.$showStmasOrderModal))
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary wire:click="$toggle('showStmasOrderModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-button.secondary>
            <x-button.primary wire:click="$emit('save:stkplan')" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-modal.dialog>

    <!-- Select from Plan none dept -->
    <x-modal.dialog wire:model.defer="showSearchFromPlanModal" maxWidth="6xl">
        <x-slot name="title">รายการวัสดุ/ครุภัณฑ์ ในแผนที่ไม่ได้ระบุแผนก</x-slot>
        <x-slot name="content">
             @livewire('search-from-plan', ['loadData' => $showSearchFromPlanModal], key('search-from-plan'.$showSearchFromPlanModal))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchFromPlanModal')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <!-- Search document type -->
    <x-modal.dialog wire:model.defer="showSearchDoctype" maxWidth="4xl">
        <x-slot name="title">ค้นหารายการประเภทเอกสาร</x-slot>
        <x-slot name="content">
            @livewire('search-modal.document-type', ['loadData' => $showSearchFromPlanModal], key('search-modal.document-type'.$showSearchDoctype))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchDoctype')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

    <x-modal.dialog wire:model.defer="showSearchStmass" maxWidth="4xl">
        <x-slot name="title">ค้นหารายการสินค้าและบริการ</x-slot>
        <x-slot name="content">
            @livewire('search-modal.stmas', ['loadData' => $showSearchStmass, 'dept_id' => $dept], key('search-modal.stmas'.$showSearchStmass))
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showSearchStmass')" wire:loading.attr="disabled">
                {{ __('ปิด') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-modal.dialog>

</div>
