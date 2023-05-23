<div class="flex flex-col max-w-full px-4">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
        <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light dark:text-white">
                <thead class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
                    <tr class="border">
                        {{ $header }}
                    </tr>
                </thead>
                <tbody>
                    {{ $body }}
                </tbody>
                @isset($footer)
                <tfoot>
                    {{ $footer }}
                </tfoot>
                @endisset
            </table>
        </div>
      </div>
    </div>
</div>
