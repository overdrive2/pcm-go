<div>
    <x-slot name="header">
        <nav class="container">
            <ol class="list-reset py-4 pl-4 rounded flex bg-grey-light text-grey">
              <li class="px-2"><a href="{{ route('stock.home') }}" class="no-underline text-gray-900">คงคลัง</a></li>
              <li><x-icon.chevron-right></x-icon.chevron-right></li>
              <li class="px-2"><span class="text-gray-700">รายการใบรับวัสดุและครุภัณฑ์</span></li>
            </ol>
        </nav>
        <div class="text-xl pl-6 text-gray-600">{{ $site_name }}</div>
    </x-slot>
    <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col">
            <div class="grid lg:flex lg:justify-between shadow mb-2 rounded-lg py-2 px-2 bg-white">
                <div class="lg:flex justify-between gap-x-2">
                    <div class="w-full">
                        <div class="relative">
                            <input type="text" wire:model.debounce.700ms='filters.search' class="focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150 border-gray-300 h-10 w-full  lg:w-96 pr-8 pl-5 rounded z-0 focus:shadow" placeholder="ระบุคำค้นหา...">
                            <div class="absolute top-2 right-3">
                                <x-icon.search class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></x-icon.search>
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-2 lg:mt-0">
                        <div class="flex">
                            <x-input.select placeholder="เลือกคลังตัดจ่าย" wire:model='filters.site' class="mr-2">
                              @foreach($sites as $site)
                              <option value="{{ $site->id }}">{{ $site->sitename }}</option>
                              @endforeach
                            </x-input.select>
                            @livewire('site-remember', ['site' => $filters['site']], key($filters['site']))
                        </div>
                    </div>
                </div>
                <div>
                    <button wire:click="advSearch" class="mt-2 lg:mt-0 bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-md">
                        ค้นหาขั้นสูง
                    </button>
                    <button onClick="toggleModal('new')" class="mt-2 lg:mt-0 bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-md">
                        <x-icon.plus></x-icon.plus> สร้าง
                    </button>
                </div>
            </div>
            <!-- Transfer Table -->
            <x-table2>
                <x-slot name="header">
                    <x-table.heading2 sortable multi-column wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">รหัส</x-table.heading2>
                    <x-table.heading2 sortable multi-column wire:click="sortBy('id')" :direction="$sorts['trdate'] ?? null" class="w-36">วันที่</x-table.heading2>
                    <x-table.heading2 sortable multi-column class="w-24">เวลา</x-table.heading2>
                    <x-table.heading2 sortable multi-column class="w-96">ผู้ขาย/เลขอ้างอิง</x-table.heading2>
                    <x-table.heading2 sortable multi-column>จำนวน</x-table.heading2>
                    <x-table.heading2 sortable multi-column class="w-40">มูลค่ารวม</x-table.heading2>
                    <x-table.heading2>คำสั่ง</x-table.heading2>
                </x-slot>
                <x-slot name="body">
                    @foreach($transfers as $item)
                    <x-table.row2>
                        <x-table.cell2 class="border-b lg:bg-white bg-gray-100" label="รหัส"><span class="leading-5  text-gray-700">{{ $item->id }}</span></x-table.cell2>
                        <x-table.cell2 label="วันที่">{{ $item->trdate }}</x-table.cell2>
                        <x-table.cell2 label="เวลา">{{ $item->trtime }}</x-table.cell2>
                        <x-table.cell2 label="ผู้ขาย/เลขอ้างอิง" inline=''>
                            <div>{{ $item->department }}</div>
                            @if($item->docnum)
                                <span class="text-sm font-bold text-white rounded-md bg-gray-500 px-2 w-auto">{{ $item->docnum }}</span>
                            @endif
                        </x-table.cell2>
                        <x-table.cell2 label="จำนวน" unit="รายการ" class="lg:text-center">{{ $item->detail_count }}</x-table.cell2>
                        <x-table.cell2 label="มูลค่า" unit="บาท" class="lg:text-right">{{ number_format($item->amount, 2) }}</x-table.cell2>
                        <x-table.action>
                            <button type="button" onClick="toggleModal({{ $item->id }})" class="lg:bg-white bg-gray-300 text-gray-700 hover:text-yellow-700 flex border rounded-md lg:border-0 px-2 py-1">
                                <x-icon.pencil-atl></x-icon.pencil-atl> <span class="ml-1 lg:hidden">แก้ไข</span>
                            </button>
                            <x-button.link class="text-gray-700 hover:text-red-700 flex rounded-md border lg:border-0 px-2 py-1 bg-gray-300 lg:bg-white">
                                <x-icon.trash></x-icon.trash> <span class="ml-1 lg:hidden">ลบ</span>
                            </x-button.link>
                        </x-table.action>
                    </x-table.row2>
                    @endforeach
                </x-slot>
            </x-table2>
            <!-- End Table -->
            <div class="py-4 px-4">{{ $transfers->links() }}</div>
        </div>
    </div>
    <!--Modal-->
    <x-modal.fullscreen title="เพิ่ม/แก้ไขรายการตัดจ่าย">
    <x-slot name="body">
        <iframe src="" id="iframe1" frameborder="0" class="w-full h-full"></iframe>
    </x-slot>
    <x-slot name="footer">
        <button class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">ยกเลิก</button>
        <button class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">บันทึก</button>
    </x-slot>
    </x-modal.fullscreen>

    <x-modal.dialog wire:model.defer="showAdvSearch" maxWidth="2xl">
      <x-slot name="title">ค้นหาขั้นสูง</x-slot>
      <x-slot name="content">
        <div class="h-auto">
            <x-input.group for="filters_stkcode" label="รหัสวัสดุ/ครุภัณฑ์" inline=false>
                <div class="flex">
                    <input type='text' id="filters_stkcode" wire:model.defer='filters.stkcode' class="rounded-md flex-1 border-gray-300 focus:shadow-md px-2 py-2 focus:ring-none focus:border-gray-400 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-none rounded-l-md" />
                    <button type="button" wire:click="$set('showStmassModal', true)" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">ค้นหา</button>
                </div>
            </x-input.group>
            <x-input.group inline for="vendors_id" label="ผู้ขาย" >
                <x-input.select2 id="vendors_id" search="search.vendor_kw" label="{{ $vendor_name ?? '' }}" display=''>
                    @forelse($vendors as $vendor)
                        <div wire:click="$set('filters.vendors_id','{{$vendor->id}}')" x-on:click="open = false;" class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700">{{ $vendor->prenam }}{{ $vendor->supnam }}</span>
                        </div>
                    @empty
                        <div class="hover:bg-gray-200 hover:border-gray-400 px-2 py-2 border-gray-200 border-b rounded-sm cursor-pointer">
                            <span class="ml-2 text-gray-700"> -- ไม่พบข้อมูล --</span>
                        </div>
                    @endforelse
                </x-input.select2>
            </x-input.group>
        </div>
      </x-slot>
      <x-slot name="footer">
          <x-button.secondary type='button' wire:click="$set('showAdvSearch', false)">ปิด</x-button.secondary>
      </x-slot>
    </x-modal.dialog>

    <x-jet-dialog-modal wire:model.defer="showStmassModal" maxWidth="4xl">
      <x-slot name="title">ค้นหารายการวัสดุ/ครุภัณฑ์</x-slot>
      <x-slot name="content">
          <span class="sr-only">{{$filters['site']}}</span>
          @livewire('stmass-search', [
                            'site' => $filters['site'],
                            'site_name' => $site_name,
                            'trntype' => 'I',
                            'loadData' => $showStmassModal
                        ],
                        key('stmassrc'.$showStmassModal)
                    )
      </x-slot>
      <x-slot name="footer">
      </x-slot>
    </x-jet-dialog-modal>

    @push('scripts')
    <script>
        var openmodal = document.querySelectorAll('.modal-open')

        for (var i = 0; i < openmodal.length; i++) {
          openmodal[i].addEventListener('click', function(event){
            event.preventDefault()
            toggleModal()
          })
        }

        const overlay = document.querySelector('.modal-overlay')
        overlay.addEventListener('click', toggleModal)

        var closemodal = document.querySelectorAll('.modal-close')
        for (var i = 0; i < closemodal.length; i++) {
          closemodal[i].addEventListener('click', function(){
            toggleModal(null)
          })
        }

        document.onkeydown = function(evt) {
          evt = evt || window.event
          var isEscape = false
          if ("key" in evt) {
            isEscape = (evt.key === "Escape" || evt.key === "Esc")
          } else {
            isEscape = (evt.keyCode === 27)
          }
          if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal(null)
          }
        };

        function toggleModal (id) {
          //console.log(id)
          const body = document.querySelector('body')
          const modal = document.querySelector('.modal')
          const iframe = document.getElementById('iframe1')
          if(modal.style.display == 'none') modal.style.display = 'block'
          if(id != null) iframe.src = "transfer/"+id
          else iframe.src = '#'
          modal.classList.toggle('opacity-0')
          modal.classList.toggle('pointer-events-none')
          body.classList.toggle('modal-active')
        }
      </script>
    @endpush
</div>
