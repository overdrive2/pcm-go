<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Plans') }}
        </h2>
    </x-slot>
    <div class="py-6">  
        <!-- Breadcrumb -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg py-2 px-2 mt-2">
                <ul class="grid gap-8 text-center text-xs leading-4 col-start-1 row-start-2" style="grid-template-columns:repeat(auto-fill, minmax(132px, 1fr))">                
                        <li class="relative flex flex-col-reverse">
                            <a role="button" href="{{ route('plan.request') }}">
                                <div class="mb-3 h-24 px-2 ">
                                    <div class="h-full flex flex-col hover:cursor-pointer hover:bg-gray-200 absolute inset-0 w-full items-center justify-center rounded-lg border border-gray-300 cursor-auto">
                                        <div class="text-xl"><i class="fa-solid fa-square-parking text-2xl text-indigo-700"></i></div>
                                        <div class="font-bold text-gray-600 text-md mt-2 px-2">ใบคำขอ</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="relative flex flex-col-reverse">
                            <a role="button" href="{{ route('plan.show') }}">
                                <div class="mb-3 h-24 px-2 ">
                                    <div class="h-full flex flex-col hover:cursor-pointer hover:bg-gray-200 absolute inset-0 w-full items-center justify-center rounded-lg border border-gray-300 cursor-auto">
                                        <div class="text-xl text-green-600"><i class="fa-solid fa-chart-bar"></i></div>
                                        <div class="font-bold text-gray-600 text-md mt-2 px-2">รายการเคลื่อนไหว</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                </ul>
            </div>
        </div>
    </div>
</div>