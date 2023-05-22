<div>
    <div id="detail_header" class="py-2 flex justify-between">
        <div class="w-2/3">รายการ</div>
        <div class="w-1/3 text-right">
            @if($site == '')
            <x-button class="bg-indigo-600 text-white" disabled ><x-icon.plus></x-icon.plus> เพิ่ม</x-button>
            @else
            <x-button wire:click="showSearchModal" class="bg-indigo-600 text-white" ><x-icon.plus></x-icon.plus> เพิ่ม</x-button>
            @endif
        </div>
    </div>
    <x-table2>
        <x-slot name=header>
            <x-table.heading2>ลำดับ</x-table.heading2>
            <x-table.heading2>รายละเอียด</x-table.heading2>
            <x-table.heading2>จำนวน</x-table.heading2>
            <x-table.heading2>ราคา</x-table.heading2>
            <x-table.heading2>ราคารวม</x-table.heading2>
            <x-table.heading2 class="text-center">คำสั่ง</x-table.heading2>
        </x-slot>
        <x-slot name="body">
            @foreach ($details as $key=>$item)
                <x-table.row2>
                    <x-table.cell2 label="ลำดับ">{{ $key+1 }}</x-table.cell2>
                    <x-table.cell2 label="รายละเอียด" inline=''>
                        <div>{!! str_replace($src_stkcode, '<span class="text-yellow-500">'.$item->src_stkcode.'</span>', $item->stkcode) !!}</div>
                        <div>{{$item->stkdes}}</div>
                    </x-table.cell2>
                    <x-table.cell2 label="จำนวน" unit="{{$item->unit}}" class="lg:text-center">{{$item->qty}}</x-table.cell2>
                    <x-table.cell2 label="ราคา" unit="บาท">{{number_format($item->prc,2)}}</x-table.cell2>
                    <x-table.cell2 label="ราคารวม" unit="บาท" class="lg:text-right">{{number_format($item->ttamt,2)}}</x-table.cell2>
                    <x-table.action>
                        @if($item->trntype == 'I')
                            <x-button wire:click="generate({{$item->id}})">ลงทะเบียน</x-button>
                        @endif
                        <x-button>ลบ</x-button>
                    </x-table.action>
                </x-table.row2>
            @endforeach
        </x-slot>
    </x-table2>
    <x-jet-dialog-modal wire:model.defer="showGenerateModal" maxWidth="6xl">
      <x-slot name="title"></x-slot>
      <x-slot name="content">
          @livewire('objects', ['trh_id' => $transfer_id, 'trd_id' => $current_detail_id], key($transfer_id.$current_detail_id))
      </x-slot>
      <x-slot name="footer">
      </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="showModalStmass" maxWidth="6xl">
        <x-slot name="title">
            {{ __('ค้นหารายการวัสดุและครุภัณฑ์') }}
        </x-slot>
        <x-slot name="content">
            @livewire('stock-search', ['site' => $site])
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showModalStmass')" wire:loading.attr="disabled">
                {{ __('ยกเลิก') }}
            </x-jet-secondary-button>

            <x-button.primary class="ml-2" wire:click="$emit('save:order')" wire:loading.attr="disabled">
                {{ __('บันทึก') }}
            </x-button.primary>
        </x-slot>
    </x-jet-dialog-modal>
</div>
