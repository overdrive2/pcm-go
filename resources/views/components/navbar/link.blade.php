@props([
    'expand'
])
<a class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10 relative overflow-hidden align-bottom" data-te-sidenav-link-ref="" data-te-collapse-init="" role="button" data-te-collapse-collapsed="" aria-expanded="{{ $expand ?? false }}" tabindex="0">
    <span class="mr-4 [&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
    {!! $icon ?? '' !!}
    </span>
    {{ $slot }}
    <x-icon.updown />
</a>
