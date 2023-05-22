<div>
    <div class="lg:flex justify-between gap-2">
        <div class="lg:w-1/2 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="text-xl font-bold text-gray-700 dark:text-gray-400">{{ $object->object_number ?? '' }}</h5>
            <h5 class="text-2xl font-medium text-gray-600 dark:text-gray-400">{{ $object->label ?? '' }}</h5>
            {!! $object->model ?? '' ? '<h5 class="text-2xl font-medium text-gray-600 dark:text-gray-400"> Model '.$object->model.'</h5>' : '' !!}
            <h5 class="text-lg font-bold text-gray-700 dark:text-gray-400">วันเกิด {{ $object->buy_date_thai ?? '' }}</h5>
            <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-lg font-extrabold tracking-tight">อายุ {{ $object->age ?? '' }}</span>
            </div>
            <h5 class="text-xl font-normal text-gray-600 dark:text-gray-400">ราคา {{ number_format($object->price ?? 0, 2) }} บาท</h5>
            <!-- List -->

            <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                @foreach($childs as $obj)
                <li class="pb-3 sm:pb-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <x-image-item icon="{{ $obj->icon }}" class=""></x-image-item>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ $obj->label }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ $obj->object_number }}
                            </p>
                        </div>
                        <div class="inline-flex items-center gap-2">
                            <button type="button" class="text-gray-700 border border-gray-700 hover:bg-gray-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                                <x-icon.pencil-atl class="w-5 h-5"></x-icon.pencil-atl>
                                <span class="sr-only">Edit</span>
                            </button>
                            <button type="button" class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800">
                                <x-icon.trash class="w-5 h-5"></x-icon.trash>
                                <span class="sr-only">Delete</span>
                            </button>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full lg:w-1/2 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 mb-2 lg:mb-0">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">History</h5>
                <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                    View all
                </a>
            </div>
            <div class="flow-root">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @if($object)
                    @foreach($object->history() as $item)
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <span class="font-bold text-sm bg-green-700 text-white rounded-full h-8 w-8 p-2.5">STAY</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $item->dept_name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $item->tran_date_time_thai }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                {{ $item->age }}
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @else
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                -- Empty --
                            </p>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    </div>
</div>