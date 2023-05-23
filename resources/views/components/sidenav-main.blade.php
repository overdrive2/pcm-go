<nav
    id="sidenav-main"
    class="fixed left-0 top-0 z-[1036] h-screen w-60 -translate-x-full overflow-hidden bg-white shadow-[0_4px_12px_0_rgba(0,0,0,0.07),_0_2px_4px_rgba(0,0,0,0.05)] dark:bg-neutral-800 xl:data-[te-sidenav-hidden='false']:translate-x-0 sidenav-primary ps--active-y group/ps [overflow-anchor:none] [overflow-style:none] touch-none"
    data-te-sidenav-init
    data-te-sidenav-mode-breakpoint-over="0"
    data-te-sidenav-mode-breakpoint-side="xl"
    data-te-sidenav-hidden="false"
    data-te-sidenav-mode="side"
    data-te-sidenav-content="#page-content"
    data-te-sidenav-accordion="true">
    <a href="/" class="mb-3 flex items-center justify-center rounded-md py-6 pr-3 text-lg font-medium outline-none dark:text-neutral-100" aria-current="page">
        <picture class="lg:flex gap-2">
            <img src="{{ asset('images/ac-logo.png') }}" class="mr-2 h-[36px]" alt="logo">
            <div class="mt-2">AC Online</div>
        </picture>
    </a>
    <hr>
    <ul class="relative m-0 list-none px-[0.2rem] pb-80" data-te-sidenav-menu-ref="">

        <li class="relative">
            <x-navbar.link>
                <x-slot name="icon">
                    <x-icon.stack />
                </x-slot>
                <span>แผนจัดซื้อจัดจ้าง</span>
            </x-navbar.link>
            <x-navbar.ul>
                <x-navbar.li :url="route('plan.home')">
                    {{ __('ใบคำขอ') }}
                </x-navbar.li>

                <x-navbar.li :url="__('#')">
                    {{ __('รายการในแผน') }}
                </x-navbar.li>
            </x-navbar.ul>
        </li>

        <li class="relative">
            <x-navbar.link>
                <x-slot name="icon">
                    <x-icon.list />
                </x-slot>
                <span>การซื้อและจ้าง</span>
            </x-navbar.link>

            <x-navbar.ul>
                <x-navbar.li :url="__('#')">
                    {{ __('คำสั่งซื้อสั่งจ้าง') }}
                </x-navbar.li>

                <x-navbar.li :url="__('#')">
                    {{ __('ตรวจรับ') }}
                </x-navbar.li>
            </x-navbar.ul>
        </li>

        <li class="relative">
            <x-navbar.link>
                <x-slot name="icon">
                    <x-icon.box />
                </x-slot>
                <span>คงคลัง</span>
            </x-navbar.link>
            <x-navbar.ul>
                <x-navbar.li :url="__('#')">
                    รับเข้าคลัง
                </x-navbar.li>

                <x-navbar.li :url="route('stock.out')">
                    ตัดจ่าย
                </x-navbar.li>
            </x-navbar.ul>
        </li>
    </ul>
</nav>
