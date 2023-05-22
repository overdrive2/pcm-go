<td {{ $attributes->merge(['class' => 'px-6 py-2 whitespace-nowrap text-sm font-medium border-t bg-gray-100 lg:bg-white']) }}>
    <div class="px-2 flex gap-x-2 w-full justify-center">
        {{ $slot }}
    </div>
</td>
