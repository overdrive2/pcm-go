<td {{ $attributes->merge(['class' => 'lg:w-32 px-6 py-2 whitespace-nowrap text-sm font-medium border-t bg-neutral-100 dark:bg-neutral-700']) }}>
    <div class="px-2 flex gap-x-2 w-full justify-center">
        {{ $slot }}
    </div>
</td>
