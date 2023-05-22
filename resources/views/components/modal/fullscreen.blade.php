@props(['title' => null])
<!--Modal-->
<div class="modal opacity-0 pointer-events-none fixed w-full min-h-screen top-0 left-0 flex" style="display: none">
    <div class="modal-overlay absolute w-full h-full bg-white opacity-95"></div>

    <div class="modal-container fixed w-full h-full z-50 overflow-y-auto ">

        <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-black text-sm z-50">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
            </svg>
            (Esc)
        </div>

        <!-- Add margin if you want to see grey behind the modal-->
        <div class="modal-content container mx-auto h-screen text-left p-4 flex flex-col">

            <!--Title-->
            <div class="flex justify-between items-center pb-2">
            <p class="text-2xl font-bold">{{ $title }}</p>
            </div>

            <!--Body-->
            {{ $body }}

            <!--Footer-->
            <div class="flex justify-end pt-2">
                {{ $footer }}
            </div>

        </div>
    </div>
</div>
