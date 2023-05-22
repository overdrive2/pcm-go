<div wire:init="loadDetail">
    <ul class="w-full divide-y divide-gray-200 dark:divide-gray-700">
        <li class="pb-3 sm:pb-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0 px-4">
                    <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                        รับเข้า
                    </p>
                </div>
                <div class="px-4 inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    {{ number_format($details['qty_in'] ?? 0, 0) }} <span class="ml-2 text-gray-500">{{ $unit_name}}</span>
                </div>
            </div>
        </li>
        <li class="pb-3 sm:pb-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0 px-4">
                    <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                        จ่ายออก
                    </p>
                </div>
                <div class="px-4 inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    {{ number_format($details['qty_out'] ?? 0, 0) }} <span class="ml-2 text-gray-500">{{ $unit_name}}</span>
                </div>
            </div>
        </li>
        <li class="pb-3 sm:pb-4">
            <div class="flex items-center space-x-4">
                <div class="flex-1 min-w-0 px-4">
                    <p class="text-md font-medium text-gray-900 truncate dark:text-white">
                        คงเหลือ
                    </p>
                </div>
                <div class="px-4 inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                    {{ number_format(($details['qty_in'] ?? 0) - ($details['qty_out'] ?? 0), 0) }} <span class="ml-2 text-gray-500">{{ $unit_name}}</span>
                </div>
            </div>
        </li>
    </ul>
</div>