<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('plan.home') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                Plan
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">List</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3" action="#" method="GET">
                    <label for="stmas-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-64 xl:w-96">
                        <input type="text" name="search" id="stmas-search" wire:model.debounce.600ms="search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="ระบุคำค้นหา...">
                    </div>
                    </form>
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <x-input.select id="doctype_id" wire:model="doctype_id">
                        <option value="">-- ทั้งหมด --</option>
                        @foreach($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->docname }}</option>
                        @endforeach
                    </x-input.select>
                    <x-input.select class="w-full" id="year" wire:model="year">
                        @foreach ($years as $y)
                        <option value="{{ $y->y }}">{{ $y->th }}</option>
                        @endforeach
                    </x-input.select>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4 text-md font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    ลำดับ
                                </th>
                                <th scope="col" class="p-4 text-md font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    รายละเอียด
                                </th>
                                <th scope="col" class="p-4 text-md font-medium text-right text-gray-500 uppercase dark:text-gray-400">
                                    จำนวน
                                </th>
                                <th scope="col" class="p-4 text-md font-medium text-center text-gray-500 uppercase dark:text-gray-400">
                                    หน่วยนับ
                                </th>
                                <th scope="col" class="p-4 text-md font-medium pr-8 text-right text-gray-500 uppercase dark:text-gray-400">
                                    มูลค่ารวม
                                </th>
                                <th scope="col" class="p-4 text-md font-medium pr-8 text-right text-gray-500 uppercase dark:text-gray-400">
                                    จัดซื้อ
                                </th>
                                <th scope="col" class="p-4 text-md font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    คำสั่ง
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($rows as $key => $row)
                            @php
                                $req = $row->getPlanRequest($dept_id, $year);
                            @endphp
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="text-center mr-2 w-20 text-sm font-bold text-gray-500 dark:text-gray-400">
                                    {{ $key + 1 }}
                                </td>
                                <td class="p-4 space-x-6 whitespace-nowrap">
                                    <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white text-left">
                                            {!! $search ? str_replace($search, '<span class="bg-yellow-200 dark:bg-yellow-500">'.$search.'</span>', $row->stmas_name) : $row->stmas_name !!}
                                        </div>
                                        <div class="text-md font-normal text-gray-500 dark:text-gray-400 text-left">{{ $row->stkcode }}</div>
                                    </div>
                                </td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-normal dark:text-white text-right w-32">{{ number_format($row->qty, 0) }}</td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">{{ $row->unit_name }}</td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">{{ number_format($row->amount, 2) }}</td>
                                <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white text-right">
                                    {{ number_format($req->amount, 2) }}
                                </td>
                                <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="flex items-center">
                                         <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>  Active
                                    </div>
                                </td>
                                <td class="p-4 space-x-2 whitespace-nowrap">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="py-2 mt-2 px-2">
            {{ $rows->links() }}
        </div>
    </div>
    <x-modal.dialog wire:model.defer="showEditModal" maxWidth="4xl" footerAlign="text-center">
        <x-slot name="title">รายละเอียดสินค้าและบริการ</x-slot>
        <x-slot name="content">
            <div class="px-4">
                <div class="lg:flex space-x-2">
                    <div class="w-full lg:w-1/2">
                        <x-input.group inline for="stkcod" label="รหัส" :error="$errors->first('editing.stkcod')">
                            <x-input.text type="text" wire:model.defer="editing.stkcod" id="stkcod"
                                name="stkcod" />
                        </x-input.group>
                    </div>
                    <div class="w-full lg:w-1/2">
                        <x-input.group inline for="stkdes" label="ชื่อกลาง" :error="$errors->first('editing.stkdes')">
                            <x-input.text type="text" wire:model.defer="editing.stkdes" id="stkdes"
                                name="stkdes" />
                        </x-input.group>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
        </x-slot>
    </x-modal.dialog>
</div>
